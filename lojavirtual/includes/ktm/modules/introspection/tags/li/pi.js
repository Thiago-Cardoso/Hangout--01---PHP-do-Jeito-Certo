
function ListItemPI(owner){this.owner=owner;this.li_type="Properties_li_type_"+this.owner.name;this.li_value="Properties_li_value_"+this.owner.name;};function ListItemPI_apply(propName,propValue){switch(propName){case"id":if(propValue){this.owner.inspectedNode.id=propValue;}else{this.owner.inspectedNode.removeAttribute('id');}
break;case"type":this.owner.inspectedNode.type=propValue;break;case"value":var oldPropValue=this.owner.inspectedNode.value;try{if(propValue!=""){this.owner.inspectedNode.value=propValue;}else{this.owner.inspectedNode.removeAttribute("value");}}catch(e){document.getElementById(this.li_value).value=oldPropValue;}
break;}
try{fixFocusHack(0);}
catch(e){}};function ListItemPI_inspect(propName,propValue){var n=this.owner.inspectedNode.parentNode;var ptn='';while(n){if(n.nodeType==1){ptn=n.tagName.toLowerCase();this.li_type="Properties_li_"+ptn+"_type_"+this.owner.name;if(ptn=="ol"){document.getElementById("Properties_li_ul_type_label_"+this.owner.name).style.display="none";document.getElementById("Properties_li_ol_type_label_"+this.owner.name).style.display="";document.getElementById("Properties_li_ul_type_"+this.owner.name).style.display="none";document.getElementById("Properties_li_ol_type_"+this.owner.name).style.display="";document.getElementById("Properties_li_val_field1_"+this.owner.name).style.visibility="visible";document.getElementById("Properties_li_val_field2_"+this.owner.name).style.visibility="visible";}else{document.getElementById("Properties_li_ol_type_label_"+this.owner.name).style.display="none";document.getElementById("Properties_li_ul_type_label_"+this.owner.name).style.display="block";document.getElementById("Properties_li_ol_type_"+this.owner.name).style.display="none";document.getElementById("Properties_li_ul_type_"+this.owner.name).style.display="";document.getElementById("Properties_li_val_field1_"+this.owner.name).style.visibility="hidden";document.getElementById("Properties_li_val_field2_"+this.owner.name).style.visibility="hidden";}
break;}}
var propValue=this.owner.inspectedNode.getAttribute("type");utility.dom.selectOption(document.getElementById(this.li_type),(propValue?propValue:''));util_safeSetFieldValue(this.li_value,this.owner.inspectedNode.getAttribute("value"));var propValue=this.owner.inspectedNode.id||'';util_safeSetFieldValue("Properties_li_id_"+this.owner.name,propValue);};ListItemPI.prototype.apply=ListItemPI_apply;ListItemPI.prototype.inspect=ListItemPI_inspect;window.KtmlPIObjects["li"]=ListItemPI;