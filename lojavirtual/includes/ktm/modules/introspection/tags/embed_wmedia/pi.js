
function Embed_WMediaPI(owner){this.owner=owner;this.props='props_simple,props_advanced,props_simple_btn,props_advanced_btn,id,width,height,filename,autostart,showcontrols,ShowDisplay,ShowStatusBar,hspace,vspace,align,alternate'.split(",");for(var i=0;i<this.props.length;i++){this["ctrl_"+this.props[i]]="Properties_embed_wmedia_"+this.props[i]+"_"+this.owner.name;}
this.reset="Properties_embed_wmedia_resetsize_"+this.owner.name;this.btn1="Properties_embed_wmedia_playstop1_"+this.owner.name;this.btn2="Properties_embed_wmedia_playstop2_"+this.owner.name;this.embed_wmedia_src_browse="Properties_embed_wmedia_src_browse_"+this.owner.name;var idx=this.owner.toolbar.indexOfName('insert_image');if(idx<0){document.getElementById(this.embed_wmedia_src_browse).style.visibility="hidden";}
if(is.mozilla){document.getElementById(this.reset).style.visibility="hidden";}};function Embed_WMedia_renameButton(el,newName){el.removeAttribute("name");el.removeAttribute("NAME");el.setAttribute("NAME",newName);el.setAttribute("name",newName);return el;};function wmediaGetProperty(el,propName){var rep_html=el.outerHTML;var m=rep_html.match(new RegExp("\\s"+propName+"=([^\\s]*)","i"));if(m){m=m[1];m=m.replace(/\/>$/,"");m=m.replace(/>$/,"");m=m.replace(/^["']/,"");m=m.replace(/["']$/,"");return m;}else{return null;}};function wmediaSetProperty(doc,el,propName,propValue){var iid=el.getAttribute("id");if(!iid){iid="uniqid"+parseInt(Math.random()*100000);el.id=iid;}
var old_val=el.getAttribute(propName);var rep_html=el.outerHTML;if(old_val&&rep_html.toLowerCase().indexOf(" "+propName.toLowerCase()+"=")>=0){rep_html=rep_html.replace(new RegExp("\\s"+propName+"=[^\\s]*","gi"),"");if(!/>$/.test(rep_html)){rep_html+="/>";}}
if(propValue!==''){rep_html=rep_html.replace(/\/?>/i,' '+propName+'="'+propValue+'"/>');}
el.outerHTML=rep_html;return(/img/i.test(el.tagName)&&el.getAttribute("orig"))?el:doc.getElementById(iid);};function Embed_WMediaPI_apply(propName,propValue){var inspected=this.owner.inspectedNode;if(/img/i.test(inspected.tagName)&&inspected.getAttribute("orig")){inspected=new WMedia_Translator(this.owner);}
propName=propName.toLowerCase();switch(propName){case"id":if(propValue!=""){inspected.setAttribute("id",propValue);}else{inspected.removeAttribute("id");}
break;case"filename":inspected.setAttribute(propName,propValue?encodeURI(propValue):"");break;case"autostart":inspected.setAttribute(propName,propValue?"true":"false");break;case"showcontrols":inspected.setAttribute(propName,propValue?"true":"false");break;case"showdisplay":inspected.setAttribute(propName,propValue?"true":"false");break;case"showstatusbar":inspected.setAttribute(propName,propValue?"true":"false");break;case"align":if(propValue!=""){inspected.translated.align=propValue;inspected.setAttribute(propName,propValue);}else{inspected.translated.removeAttribute("align");inspected.removeAttribute(propName);}
break;case"width":inspected.translated.style.width="";if(propValue!=""){inspected.translated.width=propValue;inspected.setAttribute(propName,propValue);}else{inspected.translated.removeAttribute("width");inspected.removeAttribute(propName);}
break;case"height":inspected.translated.style.height="";if(propValue!=""){inspected.translated.height=propValue;inspected.setAttribute(propName,propValue);}else{inspected.translated.removeAttribute("height");inspected.removeAttribute(propName);}
break;case"hspace":case"vspace":if(propValue!=''){inspected.translated.setAttribute(propName,propValue);inspected.setAttribute(propName,propValue);}else{inspected.translated.removeAttribute(propName);inspected.removeAttribute(propName);}
break;case"play":orig_autostart=inspected.getAttribute("autostart");inspected.setAttribute("autostart","true");document.getElementById(this.btn1).value=translate("Stop");document.getElementById(this.btn2).value=translate("Stop");if(is.ie){this.owner.edit.selection.empty();inspected.play(propValue);}else{var play_window=utility.window.openWindow("MoviePlayerWindow"+parseInt(Math.random()*1000000000),KtmlRoot+"modules/introspection/tags/movie_player.html",400,280);window.play_window_arguments={ktml_counter:this.owner.counter,movie_html:inspected.outerHTML};this.owner.MediaPlayer=inspected;}
return;case"stop":inspected.setAttribute("autostart",orig_autostart+"");inspected.stop(propValue);document.getElementById(this.btn1).value=translate("Play");document.getElementById(this.btn2).value=translate("Play");return;case"alternate":if(propValue!=''){inspected.translated.setAttribute('title',propValue);inspected.setAttribute(propName,encodeURI(propValue));}else{inspected.translated.removeAttribute('title');inspected.removeAttribute(propName);}
util_safeSetFieldValue(this.ctrl_alternate,decodeURI(util_removeSiteNameFromHREF(this.owner,propValue)));break;default:alert("Setter for "+propName+" not implemented yet!\r\n[in Embed_WMediaPI_apply]");}
if(/img/i.test(inspected.tagName)&&inspected.getAttribute("orig")){this.owner.logic_domSelect(inspected.translated,2);}else{this.owner.logic_domSelect(inspected.translated,2);}
try{fixFocusHack(0);}
catch(e){}};function Embed_WMediaPI_inspect(propName,propValue){var inspected=this.owner.inspectedNode;if(/img/i.test(inspected.tagName)&&inspected.getAttribute("orig")){inspected=new WMedia_Translator(this.owner);}
util_safeSetFieldValue(this.ctrl_id,inspected.getAttribute("id"));var propValue=inspected.translated.getAttribute("width");util_safeSetFieldValue(this.ctrl_width,propValue);inspected.setAttribute("width",propValue);var propValue=inspected.translated.getAttribute("height");util_safeSetFieldValue(this.ctrl_height,propValue);inspected.setAttribute("height",propValue);util_safeSetFieldValue(this.ctrl_filename,decodeURI(util_removeSiteNameFromHREF(this.owner,inspected.getAttribute("filename"))));util_safeSetFieldValue(this.ctrl_alternate,decodeURI(util_removeSiteNameFromHREF(this.owner,inspected.getAttribute("alternate"))));var propValue=inspected.getAttribute("AutoStart")+"";document.getElementById(this.ctrl_autostart).checked=(propValue=="true"?true:false);var propValue=inspected.getAttribute("ShowControls")+"";document.getElementById(this.ctrl_showcontrols).checked=(propValue=="true"?true:false);var propValue=inspected.getAttribute("ShowDisplay")+"";document.getElementById(this.ctrl_ShowDisplay).checked=(propValue=="true"?true:false);var propValue=inspected.getAttribute("ShowStatusBar")+"";document.getElementById(this.ctrl_ShowStatusBar).checked=(propValue=="true"?true:false);var propValue=inspected.getAttribute("align");utility.dom.selectOption(document.getElementById(this.ctrl_align),propValue?propValue.toLowerCase():'');}
top.resumer_translator=null;function Embed_WMediaPI_resetSize(w,h){if(typeof(w)=="undefined"){top.resumer_translator=this;this.apply("play",true);}else{this.apply("stop");this.apply("width",w);var inspected=this.owner.inspectedNode;if(/img/i.test(inspected.tagName)&&inspected.getAttribute("orig")){inspected=new WMedia_Translator(this.owner);}
var ShowControls=inspected.getAttribute("ShowControls");var ShowDisplay=inspected.getAttribute("ShowDisplay");var ShowStatusBar=inspected.getAttribute("ShowStatusBar");h+=ShowControls=="true"?44:0;h+=ShowDisplay=="true"?74:0;h+=ShowStatusBar=="true"?24:0;this.apply("height",h);try{document.getElementById(this.reset).focus();}catch(err){}}};Embed_WMediaPI.prototype.resetSize=Embed_WMediaPI_resetSize;Embed_WMediaPI.prototype.apply=Embed_WMediaPI_apply;Embed_WMediaPI.prototype.inspect=Embed_WMediaPI_inspect;window.KtmlPIObjects["embed_wmedia"]=Embed_WMediaPI;