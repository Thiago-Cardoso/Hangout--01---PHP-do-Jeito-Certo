
function GlyphHandler_show(forTag){window.clearTimeout(this.hideGlyphTimeout);try{var tagName=forTag.tagName.toLowerCase();}catch(e){return;}
var glyph=null;if(glyph=document.getElementById("glyphFor_"+tagName)){glyph.selectObject=forTag;glyph.style.display="block";}else{return;}
var _parent=(parent==self)?parent:self;var pbox=utility.dom.getBox(_parent.ktmls[this.owner].iframe);var box=utility.dom.getBox(forTag);var nx=pbox.x+(box.x-box.scrollLeft>0?box.x-box.scrollLeft:0)-glyph.offsetWidth+glyph.GLYPH_DELTAX;var ny=pbox.y+(box.y-box.scrollTop>0?box.y-box.scrollTop:0)-glyph.offsetHeight+glyph.GLYPH_DELTAY;glyph.style.left=(nx>document.documentElement.scrollLeft?nx:document.documentElement.scrollLeft)+"px";glyph.style.top=(ny>document.documentElement.scrollTop?ny:document.documentElement.scrollTop)+"px";glyph=null;}
GlyphHandler.prototype.show=GlyphHandler_show;