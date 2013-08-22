
ktml.prototype.logic_InsertStyle=function(value){if(this.selectableNodeClick){this.util_safeSetClassAttribute(this.selectableNodeClick,value);return;};var range=null;var sel=this.cw.getSelection();if(sel.rangeCount>1){for(var i=0;i<sel.rangeCount;i++){range=sel.getRangeAt(i);this.util_safeSetClassAttribute(range.startContainer.childNodes[range.startOffset],value);}
return;}
var range=sel.getRangeAt(0);var startc=range.startContainer;var startOffset=range.startOffset;if(!sel.isCollapsed&&sel.type=="Control"){this.util_safeSetClassAttribute(startc.childNodes[startOffset],value);return;}
if(startc.nodeName=="BODY"){this.util_safeSetClassAttribute(startc,value);this.edit.execCommand("SelectAll",false,true);return;}
var endc=range.endContainer;var endOffset=range.endOffset;if(startc.nodeType==3&&startc==endc){if(startOffset!=endOffset&&(startOffset!=0||endOffset!=startc.textContent.length)){var txt=this.edit.createTextNode(startc.textContent.substring(startOffset,endOffset));range.deleteContents();range.insertNode(txt);txt=this.util_safeSetClassAttribute(txt,value);sel.removeAllRanges();range=this.edit.createRange();range.selectNode(txt.firstChild);sel.addRange(range);}else{this.util_safeSetClassAttribute(startc.parentNode,value);sel.collapse(startc,startOffset);if(endOffset!=startOffset){sel.extend(startc,endOffset);}}
return;}else if(startc.nodeType==1&&startOffset==endOffset){this.util_safeSetClassAttribute(startc,value);return;}else if(startc.nodeType==1&&startc==endc){this.util_safeSetClassAttribute(startc,value);return;}
var cc=range.commonAncestorContainer;var sc=startc;while(sc.parentNode!=cc){if(sc.parentNode.nodeName=="BODY"){break;}
sc=sc.parentNode;}
if(endc.nodeName=="BODY"){if(endOffset==range.endContainer.childNodes.length){endOffset--;}
endc=range.endContainer.childNodes[endOffset];}
var ec=endc;while(ec.parentNode!=cc){if(ec.parentNode.nodeName=="BODY"){break;}
ec=ec.parentNode;}
if(sc!=ec&&endOffset==0){ec=node_before(ec);endOffset=0;}
var ret1=this.util_safeSetClassAttribute(sc,value);var tmp=null;if(ret1){sc=ret1.firstChild;tmp=node_after(sc.parentNode);}else{tmp=node_after(sc);}
if(sc!=ec){var ret=false;while(tmp&&tmp!=ec){ret=this.util_safeSetClassAttribute(tmp,value);tmp=node_after(ret?ret:tmp);}
var ret2=this.util_safeSetClassAttribute(ec,value);if(ret1){sel.collapse(ret1.firstChild,startOffset);}else{sel.collapse(startc,startOffset);}
if(ret2){sel.extend(ret2.firstChild,endOffset);}else{sel.extend(endc,endOffset);}}else{sel.removeAllRanges();range=this.edit.createRange();range.selectNode(sc);sel.addRange(range);}}