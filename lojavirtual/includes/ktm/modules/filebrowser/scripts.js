
ktml.prototype.openSelectFile=function(params){var tmpFolder='';if(typeof params.gotoImageEdit=="undefined"){params.gotoImageEdit=false;}
this.setModuleProperty('filebrowser','browse_submode',params.submode);this.setModuleProperty('filebrowser','browse_filter',params.filter);this.setModuleProperty('filebrowser','callback',params.callback);if(params.submode=="templates"){this.setModuleProperty('filebrowser','fileBrowserType',"Templates");this.setModuleProperty('filebrowser','submodeDetail',params.submode_detail+"");if((params.submode_detail+"")=="saveas"){this.makeValidSelection();var template_content=this.getSelectionHTML();template_content=HandleOutgoingText(this,template_content);this.setModuleProperty('templates','template_content',template_content);}}
if(params.submode=="media"){var selectedNode=this.logic_getSelectedNode();var isTranslated=(selectedNode.getAttribute('orig')!=null);if(selectedNode.tagName=="IMG"&&!isTranslated){var img_src=selectedNode.src;img_src=img_src.replace(new RegExp("^"+ktml_location.server,"i"),'');img_src=img_src.replace(new RegExp("^"+this.getModuleProperty('media','UploadFolderUrl'),"i"),'');img_src=decodeURI(img_src.replace(/\?size=\d*$/,''));if(img_src.indexOf('http')==0||img_src.indexOf('/')==0){this.setModuleProperty(params.submode,'selectedSrc',undefined);}else{this.setModuleProperty(params.submode,'selectedSrc',img_src);}}else{this.setModuleProperty(params.submode,'selectedSrc',undefined);}}
if(params.submode=="file"){var selectedNode=this.logic_getSelectedNode();selectedNode=utility.dom.getParentByTagName(selectedNode,"A");if(selectedNode){var href='';if(is.ie){var m=selectedNode.outerHTML.match(/\shref='?"?([^\s'"]*)/i);if(m){a_href=m[1];}}else{a_href=selectedNode.getAttribute("href");}
a_href=a_href.replace(new RegExp("^"+ktml_location.server,"i"),'');a_href=a_href.replace(new RegExp("^"+this.getModuleProperty('file','UploadFolderUrl'),"i"),'');a_href=decodeURI(a_href.replace(/\?size=\d*$/,''));if(a_href.indexOf('http')==0||a_href.indexOf('/')==0){this.setModuleProperty(params.submode,'selectedSrc',undefined);}else{this.setModuleProperty(params.submode,'selectedSrc',a_href);}}else{this.setModuleProperty(params.submode,'selectedSrc',undefined);}}
if(params.gotoImageEdit){this.setModuleProperty('filebrowser','editImagePath',img_src);utility.window.openWindow("EditImageWindow"+parseInt(Math.random()*1000000000),KtmlRoot+"modules/filebrowser/editimage.html?id="+this.counter,665,482);}else{utility.window.openWindow("SelectFileWindow"+parseInt(Math.random()*1000000000),KtmlRoot+"modules/filebrowser/filebrowser.html?id="+this.counter,649,359);}};ktml.prototype.insertMovieObject=function(media_type,movie_type,imgPath){var uniqid=this.getUniqueID();var addParams={};switch(movie_type){case"swf":addParams={"src":encodeURI(imgPath),"filename":encodeURI(imgPath),"quality":"high","wmode":"transparent","play":"true","salign":"top","id":uniqid,"name":uniqid};break;case"mov":addParams={"controller":"true","autoplay":"true","target":"quicktime","filename":encodeURI(imgPath),"enablejavascript":true,"id":uniqid,"name":uniqid};break;case"asf":case"avi":case"wmv":addParams={"filename":encodeURI(imgPath),"id":uniqid,"name":uniqid};break;}
var insert_html=WMedia_Translator_translate(addParams,media_type);insert_html=WMedia_Translator_translateMarkup(insert_html,media_type);this.insertHTML(insert_html,"first-node");};ktml.prototype.insertImage=function(imgPath){if(typeof(this.insert_count)=="undefined"){this.insert_count=1;}
if(is.ie){var scr=this.insert_count==1?' onload="parent.ktmls['+this.counter+'].logic_domSelect(this, 2);this.onload=null;"':'';this.insert_count--;if(this.insert_count==1){delete this.insert_count;}
this.insertHTML('<img'+scr+' src="'+encodeURI(imgPath)+'" border="0"/>','after');}else{var cm=null;if(cm=this.edit.getElementById('image_to_be_checked')){cm.removeAttribute("id");}
var scr=this.insert_count==1?' id="image_to_be_checked"':'';this.insert_count--;this.insertHTML('<img'+scr+' src="'+encodeURI(imgPath)+'" border="0" />');if(this.insert_count==0){window.setTimeout('ktml_image_load_checker('+this.counter+')',80);delete this.insert_count;}}};function ktml_image_load_checker(idx){var ktml=ktmls[idx];var cm=ktml.edit.getElementById('image_to_be_checked');if(!cm){return;}
if(!cm.complete){window.setTimeout('ktml_image_load_checker('+idx+')',80);}else{cm.removeAttribute("id");ktml.logic_domSelect(cm,2);}};ktml.prototype.insertHref=function(text){var url=text.replace(/\??size=\d*/i,'');text=text.replace(/(?:[^\/]*\/)*/,"");this.logic_InsertLink(encodeURI(url),text);};ktml.prototype.insertHTMLElement=function(ignored,fullFileName,isImage,isMovie){if(isImage){this.insertImage(fullFileName);return;}
fullFileName=fullFileName.replace(/\?.*?$/,'');if(fullFileName.match(/\.swf$/i)){this.insertMovieObject('flashmovie','swf',fullFileName);return;}
if(fullFileName.match(/\.mov$/i)){this.insertMovieObject('quicktime','mov',fullFileName);return;}
if(isMovie){this.insertMovieObject('windowsmedia',fullFileName.replace(/^.*\./,''),fullFileName);return;}
this.insertHref(fullFileName);};ktml.prototype.insertTemplate=function(content){this.insertHTML(content);if(this.viewInvisibles){this.utils_setInvisibles(false);}};function filebrowser_runonce(){};function filebrowser_runeach(k){var insert_image_filter='images';var insert_image_filter='media';var cmd="this.ktml.openSelectFile({submode:'media', filter:'"+insert_image_filter+"', callback:[this.ktml, 'insertHTMLElement']})";var idx=k.toolbar.indexOfName('insert_image');if(idx>=0){k.toolbar.buttonobjects[idx].command=cmd;}else{k.toolbar.deferredcommands['insert_image']=cmd;}
cmd="this.ktml.openSelectFile({submode:'file', filter:'documents', callback:[this.ktml, 'insertHTMLElement']})";idx=k.toolbar.indexOfName('insert_file');if(idx>=0){k.toolbar.buttonobjects[idx].command=cmd;}else{k.toolbar.deferredcommands['insert_file']=cmd;}
cmd="this.ktml.openSelectFile({submode:'templates', filter:'templates', callback:[this.ktml, 'insertTemplate']})";idx=k.toolbar.indexOfName('insert_template');if(idx>=0){k.toolbar.buttonobjects[idx].command=cmd;}else{k.toolbar.deferredcommands['insert_template']=cmd;}};