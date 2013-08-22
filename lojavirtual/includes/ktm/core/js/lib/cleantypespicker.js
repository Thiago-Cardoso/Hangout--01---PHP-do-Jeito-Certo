// Copyright 2001-2005 Interakt Online. All rights reserved.

/**
	class CleanTypesPicker
*/
function CleanTypesPicker(owner) {
	this.owner = owner;
	this.div = utility.dom.createElement("DIV", {
		"className":"div_openable",
		"style":"width: 166px; height: 80px; display: none;"
	});
	this.div = this.owner.toolbar.base.appendChild(this.div);
	if (is.mozilla && is.mac) {
		this.div.style.overflow = "auto";
	}
	this.isVisible = false;
	this.isDrawn = false;
}


CleanTypesPicker.prototype.initializeUI = function() {
	this.drawPicker();
	this.isDrawn = true;
};

CleanTypesPicker.prototype.drawPicker = function() {
	var text = '';
	text += '\
<div class="option" openable_option="true" option_value="word"><img align="absbottom" src="' + KtmlRelativeImagePath + 'cleanword.gif" width="16" height="16" style="margin-right:2px;">||Clean Word HTML||</div>\
<div class="option" openable_option="true" option_value="css"><img align="absbottom" src="' + KtmlRelativeImagePath + 'cleancss.gif" width="16" height="16" style="margin-right:2px;">||Clean CSS Styles||</div>\
<div class="option" openable_option="true" option_value="formatting"><img align="absbottom" src="' + KtmlRelativeImagePath + 'clean.gif" width="16" height="16" style="margin-right:2px;">||Clean All Formatting Tags||</div>\
<div class="option" openable_option="true" option_value="all"><img align="absbottom" src="' + KtmlRelativeImagePath + 'cleanalltags.gif" width="16" height="16" style="margin-right:2px;">||Clean All Tags||</div>\
';
	text = lang_translatepage(text, this.owner.config.UILanguage, window);
	var obj = this;
	utility.dom.attachEvent(this.div, 'onclick', function(e) {
		var o = utility.dom.setEventVars(e);
		var el = o.targ;
		while (el && el.getAttribute("openable_option")==null) {
			el = el.parentElement;
		}
		if (el) {
			utility.dom.classNameRemove(el, 'highlight');
			obj.select(el.getAttribute("option_value"));
		}
	});
	utility.dom.attachEvent(this.div, 'onmouseover', function(e) {
		var o = utility.dom.setEventVars(e);
		var el = o.targ;
		while (el && el.getAttribute("openable_option")==null) {
			el = el.parentElement;
		}
		if (el) {
			utility.dom.classNameAdd(el, 'highlight');
		}
	});
	utility.dom.attachEvent(this.div, 'onmouseout', function(e) {
		var o = utility.dom.setEventVars(e);
		var el = o.targ;
		while (el && el.getAttribute("openable_option")==null) {
			el = el.parentElement;
		}
		if (el) {
			utility.dom.classNameRemove(el, 'highlight');
		}
	});
	this.div.innerHTML = text;
};

CleanTypesPicker.prototype.select = function(selected_option) {
	this.setVisible(false);
	this.onSelect(selected_option);
};

CleanTypesPicker.prototype.hide = function() {
	this.setVisible(false);
};

CleanTypesPicker.prototype.setVisible = function(par) {
	if (this.isVisible == par) {
		return;
	}
	this.isVisible = par;
	if (par) {
		this.div.style.display = 'block';
		var cp = this;
		this.div.style.zIndex = 20;
		utility.popup.makeModal(function() {
			cp.setVisible(false);
		}, this.div);
	} else {
		this.div.style.display= 'none';
		utility.popup.force = true;
		utility.popup.removeModal();
		utility.popup.force = false;
	}
};

CleanTypesPicker.prototype.showAtElement = function(el) {
	if (!this.isDrawn) {
		this.initializeUI();
	}
	this.div.style.top = "-20000px";
	this.setVisible(true);
	utility.dom.putElementAt(this.div, el, '03');
};

CleanTypesPicker.prototype.dispose = function() {
	this.div = null;
};
