
function UnorderedListPI(owner){this.owner=owner;};function UnorderedListPI_apply(propName,propValue){var inspected=this.owner.inspectedNode;switch(propName){case"type":inspected.type=propValue;for(var i=0;i<inspected.childNodes.length;i++){if(inspected.childNodes[i].nodeType==1&&inspected.childNodes[i].tagName.toLowerCase()=="li"){inspected.childNodes[i].removeAttribute("type");}}
break;case"id":if(propValue){inspected.id=propValue;}else{inspected.removeAttribute('id');}
break;}
try{fixFocusHack(0);}
catch(e){}};function UnorderedListPI_inspect(propName,propValue){var propValue=this.owner.inspectedNode.getAttribute("type")||"disc";utility.dom.selectOption(document.getElementById("Properties_ul_type_"+this.owner.name),propValue);var propValue=this.owner.inspectedNode.id||'';util_safeSetFieldValue("Properties_ul_id_"+this.owner.name,propValue);};UnorderedListPI.prototype.apply=UnorderedListPI_apply;UnorderedListPI.prototype.inspect=UnorderedListPI_inspect;window.KtmlPIObjects["ul"]=UnorderedListPI;