// Copyright 2001-2005 Interakt Online. All rights reserved.

function Embed_QuicktimePI(owner){
	this.owner = owner;
	this.props = 'props_simple,props_advanced,props_simple_btn,props_advanced_btn,id,width,height,filename,loop,autoplay,hspace,vspace,controller,scale,align,bgcolor,alternate'.split(",");
	for ( var i=0; i < this.props.length ; i++ ) {
		this["ctrl_" + this.props[i]] = "Properties_embed_quicktime_" + this.props[i] + "_"+this.owner.name;
	}

	this.reset = "Properties_embed_quicktime_resetsize_" + this.owner.name;
	this.btn1 = "Properties_embed_quicktime_playstop1_" + this.owner.name;
	this.btn2 = "Properties_embed_quicktime_playstop2_" + this.owner.name;
	
	this.embed_quicktime_alternate_browse = "Properties_embed_quicktime_alternate_browse_"+this.owner.name;
	this.embed_quicktime_src_browse = "Properties_embed_quicktime_src_browse_"+this.owner.name;
	this.embed_quicktime_bgMonitor = "Properties_embed_quicktime_bgcolorMonitor_"+this.owner.name;
	var idx = this.owner.toolbar.indexOfName('insert_image');
	if (idx<0) {
		document.getElementById(this.embed_quicktime_src_browse).style.visibility = "hidden";
		document.getElementById(this.embed_quicktime_alternate_browse).style.visibility = "hidden";
	}
};

function Embed_QuicktimePI_fixQuickTime(id) {
	var btn = document.getElementById(id);
	try {btn.focus();}catch(err){}
	btn.value = translate('Play', this.owner.config.UILanguage);
	this.owner.introspector.apply('stop');
	try {btn.focus();}catch(err){}
};

function Embed_QuicktimePI_apply(propName, propValue){
	var inspected = this.owner.inspectedNode;

	if (/img/i.test(inspected.tagName) && inspected.getAttribute("orig")) {
		inspected = new WMedia_Translator(this.owner);
	}
	propName = propName.toLowerCase();
	switch (propName) {
		case "id":
			if (propValue != "") {
				inspected.setAttribute("id", propValue);
			} else {
				inspected.removeAttribute("id");
			}
			break;
		case "filename":
			inspected.setAttribute(propName, propValue?encodeURI(propValue):"");
			break;
		case "loop":case "autoplay":case "controller":
			inspected.setAttribute(propName, propValue=="true"?"true":"false");
			break;
		case "bgcolor":
			var _color = propValue? propValue : "";
			inspected.setAttribute(propName, _color);
			try{
				document.getElementById(this.embed_quicktime_bgMonitor).style.backgroundColor = _color;
			} catch(e){};
			break;
		case "scale":
			inspected.setAttribute(propName, propValue?propValue:"ToFit");
			break;
		case "align":
			if (propValue != "") {
				inspected.translated.align = propValue;
				inspected.setAttribute(propName, propValue);
			} else {
				inspected.translated.removeAttribute("align");
				inspected.removeAttribute(propName);
			}
			break;
		case "width":
			inspected.translated.style.width = "";
			if (propValue != "") {
				inspected.translated.width = propValue;
				inspected.setAttribute(propName, propValue);
			} else {
				inspected.translated.removeAttribute("width");
				inspected.removeAttribute(propName);
			}
			break;
		case "height":
			inspected.translated.style.height = "";
			if (propValue != "") {
				inspected.translated.height = propValue;
				inspected.setAttribute(propName, propValue);
			} else {
				inspected.translated.removeAttribute("height");
				inspected.removeAttribute(propName);
			}
			break;
		case "hspace":case "vspace":
			if (propValue != '') {
				inspected.translated.setAttribute(propName, propValue);
				inspected.setAttribute(propName, propValue);
			} else {
				inspected.translated.removeAttribute(propName);
				inspected.removeAttribute(propName);
			}
			break;
		case "start":
			orig_autostart = inspected.getAttribute("autoplay");
			inspected.setAttribute("autoplay", "true");
			document.getElementById(this.btn1).value = translate("Stop");
			document.getElementById(this.btn2).value = translate("Stop");
			if(is.ie){
				this.owner.edit.selection.empty();
				inspected.play(propValue);
			} else {
				var play_window = utility.window.openWindow(
								  "MoviePlayerWindow" + parseInt(Math.random()*1000000000),
								  KtmlRoot + "modules/introspection/tags/movie_player.html",
								  400, 280);
				window.play_window_arguments = {
						ktml_counter: this.owner.counter,
						movie_html: inspected.outerHTML
				};
				this.owner.MediaPlayer = inspected;
			}
			return;
		case "stop":
			inspected.setAttribute("autoplay", orig_autostart+"");
			inspected.stop(propValue);
			document.getElementById(this.btn1).value = translate("Play");
			document.getElementById(this.btn2).value = translate("Play");
			return;
		case "alternate":
			if (propValue != '') {
				inspected.translated.setAttribute('title', propValue);
				inspected.setAttribute(propName, encodeURI(propValue));
			} else {
				inspected.translated.removeAttribute('title');
				inspected.removeAttribute(propName);
			}
			util_safeSetFieldValue(this.ctrl_alternate, decodeURI(util_removeSiteNameFromHREF(this.owner, propValue)));
			break;
		default:
			alert("Setter for " + propName + " not implemented yet!\r\n[in Embed_QuicktimePI_apply]");
	}
	try { fixFocusHack(0); }
	catch(e) { }
};

function Embed_QuicktimePI_inspect(propName, propValue){
	var inspected = this.owner.inspectedNode;
	if (/img/i.test(inspected.tagName) && inspected.getAttribute("orig")) {
		inspected = new WMedia_Translator(this.owner);
	}
	util_safeSetFieldValue(this.ctrl_id, inspected.getAttribute("id"));

	var propValue = inspected.translated.getAttribute("width");
	util_safeSetFieldValue(this.ctrl_width, propValue);
	inspected.setAttribute("width", propValue);

	var propValue = inspected.translated.getAttribute("height");
	util_safeSetFieldValue(this.ctrl_height, propValue);
	inspected.setAttribute("height", propValue);

	util_safeSetFieldValue(this.ctrl_filename, decodeURI(util_removeSiteNameFromHREF(this.owner, inspected.getAttribute("filename"))));
	util_safeSetFieldValue(this.ctrl_alternate, decodeURI(util_removeSiteNameFromHREF(this.owner, inspected.getAttribute("alternate"))));

	var propValue = inspected.getAttribute("loop");
	document.getElementById(this.ctrl_loop).checked = (propValue=="true" ? true : false);

	var propValue = inspected.getAttribute("autoplay")+"";
	document.getElementById(this.ctrl_autoplay).checked = (propValue=="true" ? true : false);

	var propValue = inspected.getAttribute("controller");
	document.getElementById(this.ctrl_controller).checked = (propValue=="true" ? true : false);

	util_safeSetFieldValue(this.ctrl_hspace, inspected.getAttribute("hspace"));
	util_safeSetFieldValue(this.ctrl_vspace, inspected.getAttribute("vSpace"));

	var propValue = inspected.getAttribute("scale");
	utility.dom.selectOption(document.getElementById(this.ctrl_scale), propValue ? propValue : 'ToFit');

	var propValue = inspected.getAttribute("align");
	utility.dom.selectOption(document.getElementById(this.ctrl_align), propValue ? propValue.toLowerCase() : '');

	var propValue = inspected.getAttribute("bgColor");
	util_safeSetFieldValue(this.ctrl_bgcolor, propValue);
	try{
		document.getElementById(this.embed_quicktime_bgMonitor).style.backgroundColor = propValue;
	} catch(e){}
};

function Embed_QuicktimePI_resetSize(w, h) {
	if (typeof(w) == "undefined") {
		top.resumer_translator = this;
		this.apply("start", true);
	} else {
		this.apply("width", w);
		this.apply("height", h);
		this.apply("stop");
		try {
			document.getElementById(this.reset).focus();
		} catch(err){}
	}
};

Embed_QuicktimePI.prototype.resetSize = Embed_QuicktimePI_resetSize;
Embed_QuicktimePI.prototype.apply = Embed_QuicktimePI_apply;
Embed_QuicktimePI.prototype.inspect = Embed_QuicktimePI_inspect;
Embed_QuicktimePI.prototype.fixQuickTime = Embed_QuicktimePI_fixQuickTime;

window.KtmlPIObjects["embed_quicktime"] = Embed_QuicktimePI;
