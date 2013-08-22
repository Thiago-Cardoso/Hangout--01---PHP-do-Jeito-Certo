// Copyright 2001-2005 Interakt Online. All rights reserved.

/**
	class CleanTypesPicker
*/
function HyperlinkPicker(owner, src, w, h) {
	KTStorage.add(this);
	this.owner = owner;
	this.src = src;
	this.data = {links:[], special:[], all:[]};
	this.width = w || 200;
	this.height = h || 380;
	this.container = utility.dom.createElement("DIV", {
		"className":"hyperlink_container",
		"style":"width: 0px; height: 0px; display: none;"
	});
	var ktml = KTStorage.get(this.owner).ktml;
	this.container = ktml.toolbar.base.appendChild(this.container);
	this.isVisible = false;
	this.isDrawn = false;
	this.link_filter = null;
	this.highlight_idx = null;
	this.state = 'initialized';
};
HyperlinkPicker.prototype.load = function(fct) {
	this.state = 'loading';
	var url = this.src;
	try {
		this.rpc = new utility.req.request();
	} catch (e) {
		this.rpc = false;
	}
	var hyp = this;
	var completeEvent = function(sock) {
		var obj = null;
		var str = '';
		var err = null;
		try {
			str = sock.responseText;
			obj = eval('(' + str + ')');
			hyp.state = 'loaded';
		} catch(err) { }

		if (err && is.ie && err.number == -1072896658) {
			err = null;
			//IE 6.0.2800 and higher raise an error accessing responseText when xmlhttprequest receives a "Content-Type: text/html; charset=None" response header
			//"System error: -1072896658."
			//unknown encoding raises the -1072896658 error
			try {
				window.execScript("Function BinaryToString(Binary)\r\nDim I,S\r\nFor I = 1 to LenB(Binary)\r\nS = S & Chr(AscB(MidB(Binary,I,1)))\r\nNext\r\nBinaryToString = S\r\nEnd Function", "VBScript"); 
				str = BinaryToString(sock.responseBody);
				//now, lets try again
				obj = eval('(' + str + ')');
				hyp.state = 'loaded';
			} catch(err) { }
		}
		if (err) {
			hyp.state = 'initialized';
			alert(translate("No results available !"));
			return;
		}
		fct(obj);
	}

	this.rpc.initialize(url, {
		'method': 'get', // post, head
		'async': true, 
		'get': {encoding:KTStorage.get(this.owner).ktml.charset},
		'post': {},
		'onComplete': completeEvent
	});
};
HyperlinkPicker.prototype.getElement = function(name, idx) {
	var id = this.id;
	switch(name) {
		case "filter":
			id += "_link_filter_value";
			break;
		case "list":
			id += "_link_list_ul";
			break;
		case "li":
			id += "_link_list_li" + idx;
			break;
	}
	return document.getElementById(id);
};

HyperlinkPicker.prototype.initializeUI = function() {
	this.drawPicker();
	this.isDrawn = true;
	var obj = this;
	this.load(function(response) {
		obj.data = response;
		obj.data.all = response.special.concat(response.links);
		filterHyperlinks(obj.id, 'special');
	});
};

// resize containing elements to fit actual width and height
HyperlinkPicker.prototype.resize = function() {
	this.container.style.width = (this.width) + "px";
	this.container.style.height = (this.height) + "px";

	var link_filter = this.getElement('filter');
	var link_list = this.getElement('list');

	link_filter.style.width = (this.width-9) + "px";
	link_list.style.width = (this.width-6) + "px";
	link_list.style.height = (this.height - link_list.offsetHeight - 25) + "px";
};

HyperlinkPicker.prototype.drawPicker = function() {
	var ktml = KTStorage.get(this.owner).ktml;
	if (typeof this.src == "undefined") {
		message = translate("No Service Provider specified!", ktml.config.UILanguage);
	} else {
		message = translate("Please wait while loading links...", ktml.config.UILanguage);
	}
	var text = '\
<input type="text" id="' + this.id + '_link_filter_value" autocomplete="off" onKeyUp="filterHyperlinks(\''+this.id+'\', \'all\')" onchange="filterHyperlinks(\''+this.id+'\', \'all\')" class="hyperlink_filter" />\
<ul class="hyperlink_list" id="' + this.id + '_link_list_ul">' + message + '</ul>\
';

	this.container.innerHTML = text;

	var obj = this;
	var link_filter = this.getElement('filter');
	utility.dom.attachEvent(link_filter, is.ie?"onkeydown":"onkeypress", hyperlink_filter_keydown);
	utility.dom.attachEvent(link_filter, "onkeyup", hyperlink_filter_keyup);
	
	var link_list = this.getElement('list');
	utility.dom.attachEvent(link_list, "onmouseover", hyperlink_mouseover);
	utility.dom.attachEvent(link_list, "onmouseout", hyperlink_mouseout);
	utility.dom.attachEvent(link_list, "onclick", hyperlink_click);

	this.resize();
};

HyperlinkPicker.prototype.select = function(url, title) {
	var ktml = KTStorage.get(this.owner).ktml;
	this.setVisible(false);
	this.savedSelection.select();
	this.onSelect(url, title);
}

HyperlinkPicker.prototype.hide = function() {
	this.setVisible(false);
};

HyperlinkPicker.prototype.setVisible = function(par) {
	if (this.isVisible == par) {
		return;
	}
	this.isVisible = par;
	if (par) {
		var ktml = KTStorage.get(this.owner).ktml;
		this.savedSelection = ktml.edit.selection.createRange();
		this.container.style.display = 'block';
		var cp = this;
		this.container.style.zIndex = 900;
		ktml.preserveSelection(false);
		this.highlight_idx = null;
		this.getElement('filter').select();
		utility.popup.makeModal(function() {
			cp.setVisible(false);
			ktml.util_restoreSelection();
		}
		, this.container
		/* dont stop keyboard events while hyperlink picker is open */
		,false);
	} else {
		hyperlink_row_dehighilight(this.getElement("li", this.highlight_idx));
		this.container.style.display= 'none';
		utility.popup.force = true;
		utility.popup.removeModal();
		utility.popup.force = false;
		this.savedSelection.select();
	}
};

HyperlinkPicker.prototype.showAtElement = function(el) {
	if (!this.isDrawn) {
		this.initializeUI();
	}
	this.container.style.left = "-20000px";
	this.container.style.top = "-20000px";
	this.container.style.display = 'block';
	utility.dom.putElementAt(this.container, el, '03');
	this.setVisible(true);
};

HyperlinkPicker.prototype.dispose = function() {
	this.container = null;
};

function filterHyperlinks(id, set) {
	var obj = KTStorage.get(id);
	if (obj.state != 'loaded') {
		return;
	}

	var filter = obj.getElement('filter').value;
	filter = filter.replace(/\s+|\t+/gi, ' ');
	var oldFilter = obj.link_filter;
	if ( oldFilter == null && filter == "") {
		set = 'special';
	} else {
		set = 'all'
	}

	if (oldFilter === filter && oldFilter!=null) {
		return;
	}
	
	obj.link_filter = filter;
	filter = filter.split(" ");
	var link_list = obj.getElement('list');
	var html = '', olink = '';
	var j=0;
	for(var i=0; i<obj.data[set].length && j<10; i++) {
		olink = obj.getLinkHTML(j,obj.data[set][i], filter);
		if (olink) {
			j++;
			html += olink;
		}
	}


	link_list.innerHTML = html;
	obj.highlight_idx = null;
};

function hyperlink_filter_keyup(e) {
	var o = utility.dom.setEventVars(e);
	var id = (o.targ.id+"").replace(/_link_filter_value$/i, '');
	var obj = KTStorage.get(id);
	obj.keyIsDown = false;
};

function hyperlink_filter_keydown(e) {
	var o = utility.dom.setEventVars(e);
	var k = o.e.keyCode;
	var id = (o.targ.id+"").replace(/_link_filter_value$/i, '');
	var obj = KTStorage.get(id);
	obj.keyIsDown = true;

	if (k!=40 && k!=38 && k!=13 && k!=27) {
		return true;
	}
	utility.dom.stopEvent(o.e);

	//close and cancel load on esc
	if ( k == 27) {
		obj.setVisible(false);
		return false;
	}
	if (obj.state != 'loaded') {
		return false;
	}

	var selIdx = parseInt(obj.highlight_idx);
	hyperlink_row_dehighilight(obj.getElement("li", selIdx));

	var newIdx = -1;
	if (k == 13) {
		if (!isNaN(selIdx)) {
			var li = obj.getElement("li", selIdx);
			var title = utility.dom.getElementsByClassName(li, "hyperlink_title")[0];
			var url   = utility.dom.getElementsByClassName(li, "hyperlink_url")[0];
			obj.select(url.title, title.title);
		}
		return false;
	}
	var dir = k==38?-1:1;

	if (!isNaN(selIdx)) {
		newIdx = Math.max(0, Math.min(selIdx+dir, 9));
	} else {
		newIdx = 0;
	}

	var li = obj.getElement("li", newIdx);
	if (!li) {
		return false;
	}
	obj.highlight_idx = newIdx;
	hyperlink_row_highilight(li);
};

function hyperlink_click(e) {
	var o = utility.dom.setEventVars(e);
	var li = utility.dom.getParentByTagName(o.targ, "LI");
	if (!li) {
		return;
	}
	var title = utility.dom.getElementsByClassName(li, "hyperlink_title")[0];
	var url   = utility.dom.getElementsByClassName(li, "hyperlink_url")[0];

	var ul = li.parentNode;
	var id = (ul.id+"").replace(/_link_list_ul$/i, '');
	var obj = KTStorage.get(id);
	obj.select(url.title, title.title);
};

function hyperlink_mouseover(e) {
	var o = utility.dom.setEventVars(e);
	var li = utility.dom.getParentByTagName(o.targ, "LI");
	if (!li) {
		return;
	}
	var ul = li.parentNode;

	var id = (ul.id+"").replace(/_link_list_ul$/i, '');
	var obj = KTStorage.get(id);
	if (obj.keyIsDown) {
		return;
	}
	var selIdx = obj.highlight_idx;
	var m = li.id.match(/([0-9]+)$/);
	if (m) {
		var newIdx = parseInt(m[1], 10);
		if (newIdx != selIdx) {
			hyperlink_row_dehighilight(obj.getElement("li", selIdx));
			obj.highlight_idx = newIdx;
			hyperlink_row_highilight(li);
		}
	}
};

function hyperlink_mouseout(e) {
	var o = utility.dom.setEventVars(e);
	var li = utility.dom.getParentByTagName(o.targ, "LI");
	if (!li) {
		return;
	}
	var ul = li.parentNode;

	var id = (ul.id+"").replace(/_link_list_ul$/i, '');
	var obj = KTStorage.get(id);
	if (obj.keyIsDown) {
		return;
	}
	var selIdx = obj.highlight_idx;
	var m = li.id.match(/([0-9]+)$/);
	if (m) {
		var newIdx = parseInt(m[1], 10);
		if (newIdx != selIdx) {
			hyperlink_row_dehighilight(li);
		}
	}
};

function hyperlink_row_highilight(li) {
	if (li) {
		utility.dom.classNameAdd(li, "li_highlight");
	}
};

function hyperlink_row_dehighilight(li) {
	if (li) {
		utility.dom.classNameRemove(li, "li_highlight");
	}
};

//def - object having title and url
//filter - an array of strings to be marked in title and url
HyperlinkPicker.prototype.getLinkHTML = function (idx, def, filter) {
	var ret = '<li id="' + this.id+ '_link_list_li' + idx + '"><div class="hyperlink_title" title="@@title2@@">@@title@@</div><div class="hyperlink_url" title="@@url2@@">@@url@@</div></li>';
	var title = def.title;
	var url = def.url;
	var rgx = null;
	if (linkMatch(def, filter)) {
		for (var i=0; i<filter.length; i++) {
			if (filter[i] == "") {
				continue;
			}
			rgx = new RegExp("(" + filter[i].replace(/([^\w])/gi, "\\$1") + ")", "gi");
			title = title.replace(rgx, matchOutsideTag);
			url   =   url.replace(rgx, matchOutsideTag);
		}
	} else {
		return '';
	}
	ret = ret.replace(/@@title@@/gi, title);
	ret = ret.replace(/@@url@@/gi, url);
	ret = ret.replace(/@@title2@@/gi, def.title);
	ret = ret.replace(/@@url2@@/gi, def.url);
	return ret;
};

// we must match only outside tags
function matchOutsideTag($0, $1, pos, str) {
	//begin of the last tag before match
	var btb = str.substring(0, pos).lastIndexOf("<");
	//end of the last tag before match
	var etb = str.substring(0, pos).lastIndexOf(">");
	//begin of the first tag after match
	var bta = str.substring(pos+$1.length).indexOf("<");
	//end of first tag after match
	var eta = str.substring(pos+$1.length).indexOf(">");
	if (btb > etb || eta < bta) {//we are inside a tag
		return $1;
	}
	return "<span class=\"filter_str_match\">"+$1+"</span>";
};

function linkMatch(def, filter) {
	//case insensitive
	var url = def.url.toLowerCase()
	var title = def.title.toLowerCase()

	var i=filter.length;
	var m1 = true, m2 = true;
	while((m1 || m2) && i--) {
		if (filter[i] == "") {
			continue;
		}
		m1 = m1 && url.indexOf(filter[i].toLowerCase())!=-1;
		m2 = m2 && title.indexOf(filter[i].toLowerCase())!=-1;
	}
	return m1 || m2;
};
