
function getMozRange(range){var moz={};var srange=range.duplicate();srange.collapse(true);var erange=range.duplicate();erange.collapse(false);moz.startContainer=srange.parentElement();moz.endContainer=erange.parentElement();moz.startNode=null;var el_range=null;for(var i=0;i<moz.startContainer.childNodes.length;i++){if(moz.startContainer.childNodes[i].nodeType==3){el_range=getTextNodeRange(moz.startContainer.childNodes[i]);if(el_range.inRange(srange)){moz.startNode=moz.startContainer.childNodes[i];break;}}}
moz.endNode=null;for(var i=0;i<moz.endContainer.childNodes.length;i++){if(moz.endContainer.childNodes[i].nodeType==3){el_range=getTextNodeRange(moz.endContainer.childNodes[i]);if(el_range.inRange(erange)){moz.endNode=moz.endContainer.childNodes[i];break;}}}
var c=0;var clona=null;var safe=0;while(safe<10000){safe++;clona=srange.duplicate();c=clona.moveStart("character",-1);if(c==0){break;}
if(clona.htmlText.indexOf("<")>=0){break;}
srange=clona;}
moz.startOffset=srange.text.length;srange.collapse(true);moz.srange=srange;safe=0;while(safe<10000){safe++;clona=erange.duplicate();c=clona.moveEnd("character",1);if(c==0){break;}
if(clona.htmlText.indexOf("<")>=0){break;}
erange=clona;}
c=1;while(c&&/\s$/.test(erange.htmlText)){c=erange.moveEnd("character",-1);}
moz.endOffset=moz.startOffset+range.text.length;erange.collapse(false);moz.erange=erange;return moz;};function selectTextNode(el){var el_range=createTextNodeRange(el);if(el_range){el_range.select();}};function getElementNodeRange(el){el_range=el.ownerDocument.body.createTextRange();try{el_range.moveToElementText(el);}catch(err){dd("getElementNodeRange moveToElementText error:");dd(err);return false;}
return el_range;};function getTextNodeRange(el){var el_range=el.ownerDocument.body.createTextRange();var left_range=el_range.duplicate();var right_range=el_range.duplicate();var left_edge,right_edge=null;var tmp=el;var man=null;var txt='';while(tmp){man=tmp.previousSibling;if(!man){break;}
if(man.nodeType==1){left_edge=man;break;}
tmp=man;}
if(left_edge){left_range.moveToElementText(left_edge);left_range.collapse(false);}else{left_range.moveToElementText(el.parentNode);left_range.collapse(true);}
tmp=el;while(tmp){man=tmp.nextSibling;if(!man){break;}
if(man.nodeType==1){right_edge=man;break;}
tmp=man;}
if(right_edge){right_range.moveToElementText(right_edge);right_range.collapse(true);}else{right_range.moveToElementText(el.parentNode);right_range.collapse(false);}
el_range.setEndPoint("StartToStart",left_range);el_range.setEndPoint("EndToEnd",right_range);return el_range;};function elementIntersectsRange(el,range){var el_range=null;if(el.nodeType==3){el_range=getTextNodeRange(el);}
if(el.nodeType==1){el_range=getElementNodeRange(el);}
if(el_range){var se=range.compareEndPoints("StartToEnd",el_range);var es=range.compareEndPoints("EndToStart",el_range);return se<0&&es>0||se==0&&es==0;}
return false;};function join_textnodes(el){var txt='';for(var i=el.childNodes.length-1;i>0;i--){if(el.childNodes[i].nodeType==3&&el.childNodes[i-1].nodeType==3){txt=el.childNodes[i].nodeValue;el.removeChild(el.childNodes[i]);el.childNodes[i-1].nodeValue+=""+txt;}}};ktml.prototype.logic_InsertStyle=function(value){if(this.selectableNodeClick){this.util_safeSetClassAttribute(this.selectableNodeClick,value);return;}
var sel=this.edit.selection;var sel_type=sel.type;var range=sel.createRange();if(sel.type=="Control"){this.util_safeSetClassAttribute(range.item(0),value);return;}
var mozRange=getMozRange(range);var pel=range.parentElement();if(pel.nodeName!="BODY"&&pel==mozRange.endContainer){while(!pel.contains(mozRange.startContainer)){pel=pel.parentNode;}}
join_textnodes(pel);if(sel_type=="None"){if(pel.nodeName!="BODY"){this.util_safeSetClassAttribute(pel,value);this.util_saveSelection();}else{if(mozRange.startNode){var span=this.util_safeSetClassAttribute(mozRange.startNode,value);range.moveToElementText(span);range.collapse(true);range.move("character",mozRange.startOffset);range.select();}}
return;}
if(mozRange.startContainer==mozRange.endContainer){var range_html=range.htmlText;if(range_html.indexOf("<")==-1){if(range_html==mozRange.startContainer.innerHTML){this.util_safeSetClassAttribute(mozRange.startContainer,value);}else{range.pasteHTML('<span class="'+value+'">'+range_html+'</span>');range.collapse(true);range.moveStart("character",-range_html.length);range.select();}}else if(range_html==mozRange.startContainer.outerHTML){this.util_safeSetClassAttribute(mozRange.startContainer,value);}else if(pel==mozRange.startContainer&&pel.childNodes.length==1){var s1=mozRange.startContainer.innerText;var el=mozRange.startContainer;var realpel=mozRange.startContainer;while(true){el=el.parentNode;if(el.childNodes.length!=1||el.nodeName=="BODY"||el.innerText!=s1){break;}
realpel=el;}
this.util_safeSetClassAttribute(realpel,value);}else{var inside=false;var el=null;for(var i=0;i<mozRange.startContainer.childNodes.length;i++){el=mozRange.startContainer.childNodes[i];if(inside&&el!=mozRange.endNode){this.util_safeSetClassAttribute(el,value);}
if(el==mozRange.startNode){inside=true;var r=getTextNodeRange(el);r.setEndPoint("StartToStart",range);r.pasteHTML('<span class="'+value+'">'+r.text+'</span>');i++;}
if(inside&&el==mozRange.endNode){if(el==mozRange.startNode){break;}
var r=getTextNodeRange(el);r.setEndPoint("EndToEnd",range);r.pasteHTML('<span class="'+value+'">'+r.text+'</span>');break;}}}
return;}
if(pel&&pel==mozRange.endContainer){this.util_safeSetClassAttribute(pel,value);return;}
var done=0;for(var i=0;i<pel.childNodes.length;i++){if(elementIntersectsRange(pel.childNodes[i],range)){this.util_safeSetClassAttribute(pel.childNodes[i],value);done=1;}else if(done==1){break;}}
return;};