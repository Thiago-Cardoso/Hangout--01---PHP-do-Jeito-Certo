
function Input_RadioPI(owner){this.owner=owner;this.input_id="Properties_input_radio_id_"+this.owner.name;this.input_value="Properties_input_radio_value_"+this.owner.name;this.button_state=[];this.button_state["checked"]="Properties_input_radio_state_"+this.owner.name+"_checked";this.button_state["unchecked"]="Properties_input_radio_state_"+this.owner.name+"_unchecked";};function Input_Radio_renameInput(el,newName){el.removeAttribute("name");el.removeAttribute("NAME");el.setAttribute("NAME",newName);el.setAttribute("name",newName);return el;};function Input_RadioPI_apply(propName,propValue){switch(propName){case"id":if(propValue!=""){this.owner.inspectedNode.setAttribute('id',propValue);}else{this.owner.inspectedNode.removeAttribute('id');}
break;case"value":var oldPropValue=this.owner.inspectedNode.value;if(propValue!=""){this.owner.inspectedNode.value=propValue;}else{this.owner.inspectedNode.removeAttribute("value");}
break;case"state":var oldPropValue=this.owner.inspectedNode.checked;if(propValue=="checked"){this.owner.inspectedNode.checked=true;var valueAttrNodeExists=this.owner.inspectedNode.getAttributeNode("checked ");if(!valueAttrNodeExists){var newValueAttr=document.createAttribute('checked');this.owner.inspectedNode.setAttributeNode(newValueAttr);}
this.owner.inspectedNode.setAttribute("checked","checked");}else{this.owner.inspectedNode.checked=false;this.owner.inspectedNode.removeAttribute("checked");}
break;}
this.owner.introspector.update();};function Input_RadioPI_inspect(propName,propValue){var propValue=this.owner.inspectedNode.getAttribute("id");util_safeSetFieldValue(this.input_id,propValue);var specified=/<input[^>]*value=['"]?[^"]+['"]?[^>]*>/i.test(this.owner.inspectedNode.outerHTML);propValue=this.owner.inspectedNode.value;util_safeSetFieldValue(this.input_value,propValue&&specified?propValue:'');propValue=this.owner.inspectedNode.checked;propValue=propValue?'checked':'unchecked';document.getElementById(this.button_state[propValue]).checked=true;};Input_RadioPI.prototype.apply=Input_RadioPI_apply;Input_RadioPI.prototype.inspect=Input_RadioPI_inspect;window.KtmlPIObjects["input_radio"]=Input_RadioPI;