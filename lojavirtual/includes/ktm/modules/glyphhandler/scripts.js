
function GlyphHandler(obj){this.owner=obj.counter;this.glyphs={};this.glyphs["table"]=document.createElement("IMG");this.glyphs["table"].GLYPH_DELTAY=13;this.glyphs["table"].GLYPH_DELTAX=3;this.glyphs["tr"]=document.createElement("IMG");this.glyphs["tr"].GLYPH_DELTAY=20;this.glyphs["tr"].GLYPH_DELTAX=3;if(is.mozilla){this.glyphs["hr"]=document.createElement("IMG");this.glyphs["hr"].GLYPH_DELTAY=5;this.glyphs["hr"].GLYPH_DELTAX=3;this.glyphs["input"]=document.createElement("IMG");this.glyphs["input"].GLYPH_DELTAY=7;this.glyphs["input"].GLYPH_DELTAX=7;}
for(var tagName in this.glyphs){this.glyphs[tagName].id="glyphFor_"+tagName;this.glyphs[tagName].style.position="absolute";this.glyphs[tagName].style.top="0px";this.glyphs[tagName].style.left="0px";this.glyphs[tagName].style.display="none";this.glyphs[tagName].style.marginBottom="-20px";this.glyphs[tagName].style.zIndex=99;this.glyphs[tagName].style.cursor="move";this.glyphs[tagName]=document.body.insertBefore(this.glyphs[tagName],document.body.firstChild);this.glyphs[tagName].src=KtmlDirDepth+'modules/glyphhandler/img/glyph_'+tagName+'.gif';this.glyphs[tagName].ktmlCounter=window.ktmls[this.owner].counter;utility.dom.attachEvent(this.glyphs[tagName],"mousedown",function(e){obj.preserveSelection(true);obj.glyphhandler.action(e);});utility.dom.attachEvent(this.glyphs[tagName],"mouseout",function(){obj.preserveSelection(false);});}};GlyphHandler.prototype.hide=function(){var glyph=null;for(var glyphName in this.glyphs){if(glyph=document.getElementById("glyphFor_"+glyphName)){this.hideGlyphTimeout=window.setTimeout("GlyphHandler_latehide("+this.owner+", \"glyphFor_"+glyphName+"\")",800);}}};function GlyphHandler_latehide(ktmlCounter,glyphId){var glyph=null;if(typeof glyphId!="undefined"){if(glyph=document.getElementById(glyphId)){glyph.style.display="none";glyph.selectObject=null;}}else{for(var glyphName in ktmls[ktmlCounter].glyphhandler.glyphs){if(glyph=document.getElementById("glyphFor_"+glyphName)){glyph.style.display="none";glyph.selectObject=null;}}}};GlyphHandler.prototype.action=function(e){if(is.ie){var hoverElement=window.event.srcElement;}else{var hoverElement=e.target;}
utility.dom.stopEvent(is.ie?window.event:e);window.ktmls[this.owner].logic_domSelect(hoverElement.selectObject);GlyphHandler_latehide(this.owner,hoverElement.id);};GlyphHandler.prototype.update=function(e){var found=0;if(is.ie){var el=window.ktmls[this.owner].cw.event.srcElement;}else{var el=e.target;}
while(el){if((el.id+"").match(/^glyphFor_/)){window.clearTimeout(this.hideGlyphTimeout);return;}
for(gname in this.glyphs){var re=new RegExp('^'+gname.toString()+'$','i');if(el.tagName.match(re)){window.clearTimeout(this.hideGlyphTimeout);GlyphHandler_latehide(this.owner,'glyphFor_'+gname.toString());found=1;break;}}
if(found){break;}
if(el.tagName=="HTML"){this.hide();return;}
el=el.parentElement;}
if(typeof this["show"]=="undefined"){GlyphHandler.prototype.show=GlyphHandler_show;}
this.show(el);};GlyphHandler.prototype.dispose=function(){for(var tmp in this.glyphs){this.glyphs[tmp]=null;}
this.glyphs=null;};function glyphhandler_runeach(k){k.glyphhandler=new GlyphHandler(k);Array_push(k.hooks['onsetdisplaymode'],glyphhandler_callback_hide);Array_push(k.hooks['onmouseover'],glyphhandler_callback_update);utility.window.blockInterface();var scripts=[];if(is.ie){scripts=k.edit.all.tags('!');}else{var el=null;var str='';var els=k.edit.evaluate('//comment()',k.edit,null,XPathResult.UNORDERED_NODE_SNAPSHOT_TYPE,null);for(var i=0;i<els.snapshotLength;i++){el=els.snapshotItem(i);scripts.push(el);}}
var i=scripts.length;while(i--){var oneScript=scripts[i];var src=oneScript[is.ie?'data':'textContent'];if(!(/^SCRIPT_TRANSLATOR/.test(src)&&/SCRIPT_TRANSLATOR$/.test(src))){continue;}
src=src.replace(/^SCRIPT_TRANSLATOR/,'').replace(/SCRIPT_TRANSLATOR$/,'');src=unescape(src);src=WMedia_Translator_translateMarkup(src,'script');if(is.ie){oneScript.outerHTML=src;}else{var r=k.edit.createRange();r.setStartBefore(oneScript);var bogusBr=oneScript.previousSibling;var df=r.createContextualFragment(src);oneScript.parentNode.replaceChild(df.firstChild,oneScript);if(bogusBr&&bogusBr.attributes.length>0&&bogusBr.attributes[0].nodeName=='_moz_editor_bogus_node'){bogusBr.parentNode.removeChild(bogusBr);}}}
var anchors=utility.dom.getElementsByTagName(k.edit,"A");var i=anchors.length;while(i--){var oneAnchor=anchors[i];if(!oneAnchor.getAttribute("name")){continue;}
if(oneAnchor.getAttribute("href")){continue;}
var src=oneAnchor.outerHTML;oneAnchor.outerHTML=WMedia_Translator_translateMarkup(src,'anchor');}
var hiddens=utility.dom.getElementsByTagName(k.edit,"input");var i=hiddens.length;while(i--){var hidden=hiddens[i];if(hidden.type!="hidden"){continue;}
var src=hidden.outerHTML;hidden.outerHTML=WMedia_Translator_translateMarkup(src,'hidden');}
var objects=k.edit.body.getElementsByTagName("OBJECT");var i=objects.length;while(i--){var src=objects[i].outerHTML;src=src.replace(/<param\s[^>]*>/gi,'');src=src.replace(/<zparam\s/gi,'<param ');if(is.mozilla){src=src.replace(/<\/zparam>/gi,'');src=src.replace(/<noembed>(.*?)<\/noembed>/,function(a,b){return'<noembed>'+String_htmldecode(b)+'</noembed>';});}
objects[i].outerHTML=util_plain2translated(src,k.counter);}
utility.window.unblockInterface();}
function glyphhandler_callback_hide(){if(typeof this["glyphhandler"]!="undefined"){this.glyphhandler.hide();}}
function glyphhandler_callback_update(e){if(typeof this["glyphhandler"]!="undefined"){this.glyphhandler.update(e);}}
ORIGINAL_SOURCE_ATTR_NAME="orig";function WMedia_Translator(owner){this.owner=owner;this.tagName="img";this.translated=this.owner.inspectedNode;this.isPlaying=false;this.outerHTML=decodeURIComponent(this.translated.getAttribute("orig"));this.MediaType=this.translated.getAttribute("for").toLowerCase();this.params=WMedia_Translator_parseSource(this.outerHTML,this.MediaType);}
var TRANSLATOR_DESCRIPTORS={anchor:{marker_rx:(/\s*name=?(?:["']?)[^"'>]*(?:["']?)/i),tag_name:"a",exceptions:[/\s?href={1}/i],attribute_parsers:{name:[/<a[^>]*?\s*name=?(?:["']?)([^"'>\s]*)(?:["']?)(:?[\w\W\s\r\n]*?)<\/a>/i],id:[(/<a[^>]*?\s*id=?(?:["']?)([^"'>\s]*)(?:["']?)(:?[\w\W\s\r\n]*?)<\/a>/i)],content:[(/<a[^>]*?>([\w\W\s\r\n]*?)<\/a>/i)]},translator_image:"core/img/anchor.gif"},hidden:{marker_rx:(/\s*type=?(?:["']?)hidden(?:["']?)/i),tag_name:"input",attribute_parsers:{name:[(/<input[^>]*?\s+name=(?:["']?)([^\s"'\/]*)(?:["']?)\s*[^>]*>/i)],id:[(/<input[^>]*?\s+id=(?:["']?)([^\s"'\/]*)(?:["']?)\s*[^>]*>/i)],value:[(/\s+value=("[^"]*"|'[^']*'|[^\s"]*)(?:\s|\/|>)/i)]},translator_image:"core/img/insert_hiddenfield.gif"},script:{marker_rx:(/./),tag_name:"script",attribute_parsers:{content:[(/<script[^>]*?>([\w\W\s\r\n]*?)<\/script>/i)]},translator_image:"core/img/translator_script.gif"},windowsmedia:{classid:"clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95",marker_rx:(/\s*classid=(?:["']?)CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95(?:["']?)/i),tag_name:"object",attribute_parsers:{id:[(/<object[^>]*?\s+id=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],name:[(/<embed[^>]*?\s*name=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i),(/<object[^>]*?\s*name=(?:["']?)([^\s"'>]*)(?:["']?)\s*[^>]*>/i)],width:[(/<object[^>]*?\s*width=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],height:[(/<object[^>]*?\s*height=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],standby:[(/<object[^>]*?\s*standby=(?:["']?)([^"']*)(?:["']?)\s*[^>]*>/i)],align:[(/<object[^>]*?\s*align=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],filename:[(/<PARAM[^>]*\s*NAME=["']?filename["']?\s*[^>]*>/i),(/\s*value=["']?([^"'>]*)["']?\s*[^>]*>/i)],AutoStart:[(/<PARAM[^>]*\s*NAME=["']?autoStart["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],ShowControls:[(/<PARAM[^>]*\s*NAME=["']?showControls["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],ShowStatusBar:[(/<PARAM[^>]*\s*NAME=["']?ShowStatusBar["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],Autorewind:[(/<PARAM[^>]*\s*NAME=["']?Autorewind["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],ShowDisplay:[(/<PARAM[^>]*\s*NAME=["']?ShowDisplay["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],alternate:[(/<img[^>]*>/i),(/<img[^>]*\s+src=["']?([^"']*)["']?\s*[^>]*>/i)]},translator_image:"core/img/blank.gif",translator_logo:"core/img/insert_windowsmedia.gif",code_base:"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112",pluginspage:"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab",object_type:"application/x-oleobject",embed_type:"application/x-mplayer2",dataparam:"src"},flashmovie:{classid:"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",marker_rx:(/\s*classid=(?:["']?)clsid:D27CDB6E-AE6D-11cf-96B8-444553540000(?:["']?)/i),tag_name:"object",attribute_parsers:{id:[(/<object[^>]*?\s+id=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],name:[(/<embed[^>]*?\s*name=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i),(/<object[^>]*?\s*name=(?:["']?)([^\s"'>]*)(?:["']?)\s*[^>]*>/i)],width:[(/<object[^>]*?\s*width=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],height:[(/<object[^>]*?\s*height=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],hspace:[(/<object[^>]*?\s*hspace=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],vspace:[(/<object[^>]*?\s*vspace=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],align:[(/<object[^>]*?\s*align=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],filename:[(/<PARAM[^>]*\s*NAME=["']?Movie["']?\s*[^>]*>/i),(/\s*value=["']?([^"'>]*)["']?\s*[^>]*>/i)],Play:[(/<PARAM[^>]*\s*NAME=["']?play["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],Loop:[(/<PARAM[^>]*\s*NAME=["']?loop["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],Quality:[(/<PARAM[^>]*\s*NAME=["']?quality["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],wmode:[(/<PARAM[^>]*\s*NAME=["']?wmode["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],Scale:[(/<PARAM[^>]*\s*NAME=["']?scale["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],bgcolor:[(/<PARAM[^>]*\s*NAME=["']?bgcolor["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],alternate:[(/<img[^>]*>/i),(/<img[^>]*\s+src=["']?([^"']*)["']?\s*[^>]*>/i)]},translator_image:"core/img/blank.gif",translator_logo:"core/img/insert_flash.gif",code_base:"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab",pluginspage:"http://www.macromedia.com/go/getflashplayer",object_type:"application/x-oleobject",embed_type:"application/x-shockwave-flash"},quicktime:{classid:"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B",marker_rx:(/\s*classid=(?:["']?)clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B(?:["']?)/i),tag_name:"object",attribute_parsers:{id:[(/<object[^>]*?\s+id=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],name:[(/<embed[^>]*?\s*name=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i),(/<object[^>]*?\s*name=(?:["']?)([^\s"'>]*)(?:["']?)\s*[^>]*>/i)],width:[(/<object[^>]*?\s*width=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],height:[(/<object[^>]*?\s*height=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],hspace:[(/<object[^>]*?\s*hspace=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],vspace:[(/<object[^>]*?\s*vspace=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],align:[(/<object[^>]*?\s*align=(?:["']?)([^\s"']*)(?:["']?)\s*[^>]*>/i)],filename:[(/<PARAM[^>]*\s*NAME=["']?src["']?\s*[^>]*>/i),(/\s*value=["']?([^"'>]*)["']?\s*[^>]*>/i)],autoplay:[(/<PARAM[^>]*\s*NAME=["']?autoplay["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],loop:[(/<PARAM[^>]*\s*NAME=["']?loop["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],controller:[(/<PARAM[^>]*\s*NAME=["']?controller["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],scale:[(/<PARAM[^>]*\s*NAME=["']?scale["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],bgcolor:[(/<PARAM[^>]*\s*NAME=["']?bgcolor["']?\s*[^>]*>/i),(/\s*value=["']?([^\s"']*)["']?\s*[^>]*>/i)],alternate:[(/<img[^>]*>/i),(/<img[^>]*\s+src=["']?([^"']*)["']?\s*[^>]*>/i)]},translator_image:"core/img/blank.gif",translator_logo:"core/img/insert_quicktime.gif",code_base:"http://www.apple.com/qtactivex/qtplugin.cab",pluginspage:"http://www.apple.com/quicktime/download/",object_type:"application/x-oleobject",embed_type:"video/x-quicktime"}};WMedia_Translator.prototype.untranslate=function(){var tmp=this.owner.edit.createElement("SPAN");var newID=this.owner.getUniqueID();tmp.id=newID;tmp.innerHTML=this.outerHTML;this.translated.parentNode.replaceChild(tmp,this.translated);tmp=this.owner.edit.getElementById(newID);var sel=tmp.firstChild;tmp.firstChild.href="http://";tmp.parentNode.replaceChild(tmp.firstChild,tmp);return sel;};function WMedia_Translator_translateMarkup(str,MediaType){MediaType=(MediaType+"").toLowerCase();var ret='';var transl_desc=TRANSLATOR_DESCRIPTORS[MediaType];var b_rx=new RegExp('<'+transl_desc.tag_name+'\\s?',"i");var e_rx=false;if(!b_rx.test(str)){return str;}
if(Array_indexOf(['input'],transl_desc.tag_name)==-1){e_rx=new RegExp('<\\/'+transl_desc.tag_name+'>',"i");}
var splits=str.split(b_rx);if(splits.length==1&&str==splits[0]&&transl_desc.tag_name!='script'){return str;}
for(var i=0;i<splits.length;i++){if(e_rx){if(!(e_rx.test(splits[i]))){if(splits[i]!=''&&!/^\s/.test(splits[i])&&!/^</.test(splits[i])){ret+='<'+transl_desc.tag_name+splits[i];continue;}
ret+=splits[i];}else{var exclude=false;if(transl_desc.exceptions){for(var j=0;j<transl_desc.exceptions.length;j++){if(transl_desc.exceptions[j].test(splits[i])){exclude=true;break;}}}
if(!exclude&&transl_desc.marker_rx.test(splits[i])){var splits2=splits[i].split(e_rx);var objectTag='<'+transl_desc.tag_name+' '+splits2[0]+'</'+transl_desc.tag_name+'>';var params=WMedia_Translator_parseSource(objectTag,MediaType);var s_id=params["id"]?' id="'+params["id"]+'"':'';var s_width=params["width"]?' width="'+params["width"]+'"':'';var s_height=params["height"]?' height="'+params["height"]+'"':'';var s_align=params["align"]?' align="'+params["align"]+'"':'';var s_hspace=params["hspace"]?' hspace="'+params["hspace"]+'"':'';var s_vspace=params["vspace"]?' vspace="'+params["vspace"]+'"':'';var s_style=transl_desc.translator_logo?"background-color: #cecece; border: 1px inset #999999; background-image: url("+KtmlRoot+transl_desc.translator_logo+"); background-repeat: no-repeat; background-position: center;":"margin: 1px;";var s_orig=encodeURIComponent(objectTag);if(MediaType=="script"){s_orig=s_orig.replace(/'/g,'%27');}
ret+='<img style="'+s_style+'" '+s_id+' for="'+MediaType+'" orig="'+s_orig+'" src="'+KtmlRoot+transl_desc.translator_image+'" '+s_width+s_height+s_align+s_hspace+s_vspace+' />';if(splits2[1]){ret+=splits2[1];}}else{ret+='<'+transl_desc.tag_name+' '+splits[i];}}}else{var exclude=false;if(transl_desc.exceptions){for(var j=0;j<transl_desc.exceptions.length;j++){if(transl_desc.exceptions[j].test(splits[i])){exclude=true;break;}}}
if(!exclude&&transl_desc.marker_rx.test(splits[i])){var splitFrom=splits[i].match(/^([\w\W]*?)(?:\/?>)([\w\W]*)/i);var objectTag='<'+transl_desc.tag_name+' '+splitFrom[1]+'/>';var params=WMedia_Translator_parseSource(objectTag,MediaType);var s_id=params["id"]?' id="'+params["id"]+'"':'';var s_width=params["width"]?' width="'+params["width"]+'"':'';var s_height=params["height"]?' height="'+params["height"]+'"':'';var s_align=params["align"]?' align="'+params["align"]+'"':'';var s_hspace=params["hspace"]?' hspace="'+params["hspace"]+'"':'';var s_vspace=params["vspace"]?' vspace="'+params["vspace"]+'"':'';ret+='<img '+s_id+' for="'+MediaType+'" orig="'+encodeURIComponent(objectTag)+'" src="'+KtmlRoot+transl_desc.translator_image+'" '+s_width+s_height+s_align+s_hspace+s_vspace+' />'+splitFrom[2];}else{if(splits[i].indexOf(">")<splits[i].indexOf("<")||splits[i].indexOf(">")>=0&&splits[i].indexOf("<")==-1){ret+='<'+transl_desc.tag_name+' '+splits[i];}else{ret+=splits[i];}}}}
return ret;};function WMedia_Translator_parseSource(str,MediaType){MediaType=(MediaType+"").toLowerCase();var m=null;var params={};var paramValue=null;for(var paramName in TRANSLATOR_DESCRIPTORS[MediaType].attribute_parsers){regexes=TRANSLATOR_DESCRIPTORS[MediaType].attribute_parsers[paramName];paramValue="";for(var i=0;i<Math.max(1,regexes.length);i++){m=str.match(regexes[i]);paramValue="";if(m){if(m.length>1){paramValue=m[1];paramValue=paramValue.replace(/(^["']|["']$)/g,'');}else if(regexes.length>1){m=m[0].match(regexes[regexes.length-1]);if(m){paramValue=m[1];break;}}}}
params[paramName.toLowerCase()]=paramValue;}
return params;}
function WMedia_Translator_translate(params,MediaType){MediaType=(MediaType+"").toLowerCase();var uniqueID="uniqid"+parseInt(Math.random()*100000);var str='';switch(MediaType){case"hidden":str='<input type="hidden" name="'+util_defaultValue(params['name'],'')+'" id="'+util_defaultValue(params['id'],'')+'" value="'+util_defaultValue(params['value'],'')+'" />';break;case"script":str='<script>'+util_defaultValue(params['content'],'')+'</script>';break;case"anchor":str='<a name="'+util_defaultValue(params['name'],'')+'"';var pid=util_defaultValue(params['id'],'');str+=(pid=='')?'':(' id="'+pid+'"');str+='>'+util_defaultValue(params['content'],'')+'</a>';break;case"windowsmedia":str='<object id="'+util_defaultValue(params['id'],uniqueID)+'" name="'+util_defaultValue(params['name'],uniqueID)+'" width="'+util_defaultValue(params['width'],200)+'" height="'+util_defaultValue(params['height'],150)+'" \
 standby="'+util_defaultValue(params['standby'],'')+'"\
 align="'+util_defaultValue(params['align'],'')+'"\
 classid="'+TRANSLATOR_DESCRIPTORS[MediaType].classid+'"\
 type="'+TRANSLATOR_DESCRIPTORS[MediaType].object_type+'"\
 codebase="'+TRANSLATOR_DESCRIPTORS[MediaType].code_base+'">\r\n\
 <param name="filename" value="'+util_defaultValue(params['filename'],'')+'"/>\r\n\
 <param name="url" value="'+util_defaultValue(params['filename'],'')+'"/>\r\n\
 <param name="autostart" value="'+util_defaultValue(params['autostart'],true)+'"/>\r\n\
 <param name="autoplay" value="'+util_defaultValue(params['autostart'],true)+'"/>\r\n\
 <param name="showcontrols" value="'+util_defaultValue(params['showcontrols'],true)+'"/>\r\n\
 <param name="showstatusbar" value="'+util_defaultValue(params['showstatusbar'],true)+'"/>\r\n\
 <param name="autorewind" value="'+util_defaultValue(params['autorewind'],true)+'"/>\r\n\
 <param name="showdisplay" value="'+util_defaultValue(params['showdisplay'],false)+'"/>\r\n\
 <embed \
 src="'+util_defaultValue(params['filename'],'')+'" \
 width="'+util_defaultValue(params['width'],200)+'" \
 height="'+util_defaultValue(params['height'],150)+'" \
 type="'+TRANSLATOR_DESCRIPTORS[MediaType].embed_type+'" \
 name="'+util_defaultValue(params['name'],uniqueID)+'" \
 autostart="'+(util_defaultValue(params['autostart'],"true")=="true"?1:0)+'" \
 showcontrols="'+(util_defaultValue(params['showcontrols'],"true")=="true"?1:0)+'" \
 showstatusbar="'+(util_defaultValue(params['showstatusbar'],"true")=="true"?1:0)+'" \
 autorewind="'+(util_defaultValue(params['autorewind'],"true")=="true"?1:0)+'" \
 showdisplay="'+(util_defaultValue(params['showdisplay'],"false")=="true"?1:0)+'">';var alternate=util_defaultValue(params['alternate'],'')
if(alternate!=''){str+='<noembed><img src="'+alternate+'" width="'+util_defaultValue(params['width'],200)+'" height="'+util_defaultValue(params['height'],150)+'"/></noembed>';}
str+='</embed></object>';break;case"flashmovie":str='<object \
 id="'+util_defaultValue(params['id'],uniqueID)+'" \
 name="'+util_defaultValue(params['name'],uniqueID)+'" \
 width="'+util_defaultValue(params['width'],200)+'" \
 height="'+util_defaultValue(params['height'],150)+'" \
 hspace="'+util_defaultValue(params['hspace'],0)+'" \
 vspace="'+util_defaultValue(params['vspace'],0)+'" \
 align="'+util_defaultValue(params['align'],'')+'" \
 classid="'+TRANSLATOR_DESCRIPTORS[MediaType].classid+'" \
 type="'+TRANSLATOR_DESCRIPTORS[MediaType].object_type+'" \
 codebase="'+TRANSLATOR_DESCRIPTORS[MediaType].code_base+'">\r\n\
 <param name="movie" value="'+util_defaultValue(params['filename'],'')+'"/>\r\n\
 <param name="loop" value="'+util_defaultValue(params['loop'],false)+'"/>\r\n\
 <param name="play" value="'+util_defaultValue(params['play'],true)+'"/>\r\n\
 <param name="quality" value="'+util_defaultValue(params['quality'],"high")+'"/>\r\n\
 <param name="wmode" value="'+util_defaultValue(params['wmode'],"transparent")+'"/>\r\n\
 <param name="scale" value="'+util_defaultValue(params['scale'],"")+'"/>\r\n\
 <param name="bgcolor" value="'+util_defaultValue(params['bgcolor'],"")+'"/>\r\n\
 <embed \
 src="'+util_defaultValue(params['filename'],'')+'"\
 width="'+util_defaultValue(params['width'],200)+'"\
 height="'+util_defaultValue(params['height'],150)+'"\
 hspace="'+util_defaultValue(params['hspace'],0)+'"\
 vspace="'+util_defaultValue(params['vspace'],0)+'"\
 align="'+util_defaultValue(params['align'],'')+'"\
 type="'+TRANSLATOR_DESCRIPTORS[MediaType].embed_type+'"\
 name="'+util_defaultValue(params['name'],uniqueID)+'"\
 loop="'+util_defaultValue(params['loop'],"false")+'"\
 play="'+util_defaultValue(params['play'],"true")+'"\
 quality="'+util_defaultValue(params['quality'],"high")+'"\
 wmode="'+util_defaultValue(params['wmode'],"transparent")+'"\
 bgcolor="'+util_defaultValue(params['bgcolor'],"")+'"\
 scale="'+util_defaultValue(params['scale'],"")+'" >';var alternate=util_defaultValue(params['alternate'],'')
if(alternate!=''){str+='<noembed><img src="'+alternate+'" width="'+util_defaultValue(params['width'],200)+'" height="'+util_defaultValue(params['height'],150)+'"/></noembed>';}
str+='</embed></object>';break;case"quicktime":str='<object \
 id="'+util_defaultValue(params['id'],uniqueID)+'"\
 name="'+util_defaultValue(params['name'],uniqueID)+'"\
 width="'+util_defaultValue(params['width'],200)+'"\
 height="'+util_defaultValue(params['height'],150)+'"\
 hspace="'+util_defaultValue(params['hspace'],0)+'"\
 vspace="'+util_defaultValue(params['vspace'],0)+'"\
 align="'+util_defaultValue(params['align'],'')+'"\
 classid="'+TRANSLATOR_DESCRIPTORS[MediaType].classid+'"\
 type="'+TRANSLATOR_DESCRIPTORS[MediaType].object_type+'"\
 codebase="'+TRANSLATOR_DESCRIPTORS[MediaType].code_base+'">\r\n\
 <param name="src" value="'+util_defaultValue(params['filename'],'')+'"/>\r\n\
 <param name="loop" value="'+util_defaultValue(params['loop'],false)+'"/>\r\n\
 <param name="autoplay" value="'+util_defaultValue(params['autoplay'],true)+'"/>\r\n\
 <param name="controller" value="'+util_defaultValue(params['controller'],"true")+'"/>\r\n\
 <param name="scale" value="'+util_defaultValue(params['scale'],'ToFit')+'"/>\r\n\
 <param name="bgcolor" value="'+util_defaultValue(params['bgcolor'],"")+'"/>\r\n\
 <param name="enablejavascript" value="true"/>\r\n\
 <embed \
 src="'+util_defaultValue(params['filename'],'')+'"\
 width="'+util_defaultValue(params['width'],200)+'"\
 height="'+util_defaultValue(params['height'],150)+'"\
 hspace="'+util_defaultValue(params['hspace'],0)+'"\
 vspace="'+util_defaultValue(params['vspace'],0)+'"\
 align="'+util_defaultValue(params['align'],'')+'"\
 type="'+TRANSLATOR_DESCRIPTORS[MediaType].embed_type+'"\
 name="'+util_defaultValue(params['name'],uniqueID)+'"\
 loop="'+util_defaultValue(params['loop'],"false")+'"\
 autoplay="'+util_defaultValue(params['autoplay'],"true")+'"\
 controler="'+util_defaultValue(params['controler'],"true")+'"\
 bgcolor="'+util_defaultValue(params['bgcolor'],"")+'"\
 enablejavascript="true"\
 scale="'+util_defaultValue(params['scale'],'ToFit')+'">';var alternate=util_defaultValue(params['alternate'],'')
if(alternate!=''){str+='<noembed><img src="'+alternate+'" width="'+util_defaultValue(params['width'],200)+'" height="'+util_defaultValue(params['height'],150)+'"/></noembed>';}
str+='</embed></object>';break;}
return str;}
function WMedia_Translator_play(retrieveDimensions){if(!this.translated.parentElement){return;}
retrieveDimensions=util_defaultValue(retrieveDimensions,false);this.isPlaying=true;var doc=this.translated.ownerDocument;var ifr=doc.createElement("IFRAME");ifr.id="KTML_MoviePreviewIframe";ifr.width=(this.translated.offsetWidth+0)+"px";ifr.height=(this.translated.offsetHeight+0)+"px";ifr.align=this.translated.align;ifr.frameBorder="no";if(retrieveDimensions){ifr.style.display="none";}
ifr=doc.body.appendChild(ifr);this.translated.parentElement.replaceChild(ifr,this.translated);ifr.translator=this;var oNewDoc=ifr.contentWindow.document.open("text/html","replace");if(retrieveDimensions){switch(this.MediaType){case"windowsmedia":headScript='<header><scr'+'ipt>function checkDimensions() { var pl=document.body.firstChild; if (pl.OpenState==6){window.clearInterval(checker);top.resumer_translator.resetSize(pl.ImageSourceWidth, pl.ImageSourceHeight);}}</scr'+'ipt></header>';bodyOnLoad=' onload="checker = window.setInterval(\'checkDimensions()\', 100)"';break;case"flashmovie":headScript='<header><scr'+'ipt>function checkDimensions() { var pl=document.body.firstChild;if (pl.readyState!=4){window.setTimeout(\'checkDimensions()\',100); return;}; w = pl.TGetProperty("/", 8);h = pl.TGetProperty("/", 9);top.resumer_translator.resetSize(w, h);}</scr'+'ipt></header>';bodyOnLoad=' onload="window.setTimeout(\'checkDimensions()\',100)"';break;case"quicktime":headScript='<header><scr'+'ipt>function checkDimensions() { var pl=document.body.firstChild;}</scr'+'ipt></header>';bodyOnLoad=' onload="window.setTimeout(\'checkDimensions()\',1000)"';break;}}else{headScript='';bodyOnLoad='';}
oNewDoc.write('<html>'+headScript+'<body'+bodyOnLoad+' style="overflow:auto; border-width:0px; margin:0px; padding:0px; background-color: #FFFFFF;" scroll="no">'+this.outerHTML+'</body></html>');oNewDoc.close();if(this.owner.introspector.clicked_button){var _this=this;var oname=this.owner.introspector.clicked_button;var idx=this.owner.counter;setTimeout(function(){try{document.getElementById(oname).focus();ktmls[idx].MediaPlayer=_this;}catch(err){}},0);}else{this.owner.MediaPlayer=this;}}
function WMedia_Translator_stop(callback){var removable=this.translated.ownerDocument.getElementById("KTML_MoviePreviewIframe");if(removable){var trans=removable.translator.translated;try{removable.contentWindow.document.body.firstChild.Stop();}catch(e){}
removable.contentWindow.document.body.innerHTML="";var zid=trans.getAttribute("id");removable.outerHTML=trans.outerHTML;trans=this.translated.ownerDocument.getElementById(zid);try{this.owner.logic_domSelect(trans,2);}catch(err){}}
this.owner.MediaPlayer=false;this.isPlaying=false;if(callback){callback();}}
function WMedia_Translator_getAttribute(propName){if(typeof(this.params[propName.toLowerCase()])=="undefined"){return null;}else{return this.params[propName.toLowerCase()];}}
function WMedia_Translator_setAttribute(propName,propValue){this.params[propName.toLowerCase()]=propValue;this.outerHTML=WMedia_Translator_translate(this.params,this.MediaType);this.translated.setAttribute("orig",encodeURIComponent(this.outerHTML));}
function WMedia_Translator_removeAttribute(propName){var UNDEFINED;var newParams={};propName=propName.toLowerCase();for(var pn in this.params){if(pn.toLowerCase()!=propName){newParams[pn]=this.params[pn];}}
this.params=newParams;this.outerHTML=WMedia_Translator_translate(this.params,this.MediaType);this.translated.setAttribute("orig",encodeURIComponent(this.outerHTML));}
WMedia_Translator.prototype.translateMarkup=WMedia_Translator_translateMarkup;WMedia_Translator.prototype.parseSource=WMedia_Translator_parseSource;WMedia_Translator.prototype.translate=WMedia_Translator_translate;WMedia_Translator.prototype.play=WMedia_Translator_play;WMedia_Translator.prototype.stop=WMedia_Translator_stop;WMedia_Translator.prototype.getAttribute=WMedia_Translator_getAttribute;WMedia_Translator.prototype.setAttribute=WMedia_Translator_setAttribute;WMedia_Translator.prototype.removeAttribute=WMedia_Translator_removeAttribute;function WordHTML_Translator_translateMarkup(str,MediaType,k){var not_found='';var placeholder_image=ktmls[k].getModuleProperty('media','UploadFolderUrl')+'placeholder.jpg';var placeholder_title=translate("To replace this placeholder, please upload the original image (%s) on server and insert it in the document.",KtmlGlobalLanguage);if(is.ie){str=str.replace(/<v:shape ([^>]*)>[\w\W]*?<v:imagedata ([^>]*)>[\w\W]*?<\/v:imagedata>[\w\W]*?<\/v:shape>/ig,function(a,b,c){var word_image=b.indexOf('/msohtml')>=0;var file_system=c.match(/src="(file:\/\/\/[^"]*)"/i);if(file_system){var w=b.match(/\swidth=\s*\"?([0-9\.]+)([a-z]*)\"?/i);if(w){var mv=parseFloat(w[1]);var mu=w[2];if(mu=="pt"){mv=mv*screen.deviceXDPI/72;}
w='width:'+mv+'px;';}else{w='';}
var h=b.match(/\sheight=\s*\"?([0-9\.]+)([a-z]*)\"?/i);if(h){var mv=parseFloat(h[1]);var mu=h[2];if(mu=="pt"){mv=mv*screen.deviceYDPI/72;}
h='height:'+mv+'px;';}else{h='';}
var title=utility.string.sprintf(placeholder_title,unescape(file_system[1].replace(/file:\/\/\//i,'')));var html='<img src="'+placeholder_image+'" style_preserve="'+w+h+';background-image:url('+not_found+');background-repeat:no-repeat;background-position:center"';html+='alt="'+title+'" title="'+title+'">';return html;}
return a;});}
str=str.replace(/<\/?\w+:\w+[^>]*>/ig,'');if(is.mozilla){str=str.replace(/<!-{0,2}\[[^\]]*\]-{0,2}>/ig,'');str=str.replace(/<img([^>]*?)v:shapes([^>]*?)>/ig,function(a,b,c){var word_image=b.indexOf('/msohtml')>=0;var file_system=b.match(/src="(file:\/\/\/[^"]*)"/i);if(word_image&&file_system){var w=a.match(/width="([^"]*)"/i);var h=a.match(/height="([^"]*)"/i);if(w){w='width:'+w[1]+'px;';}else{w='';}
if(h){h='height:'+h[1]+'px;';}else{h='';}
var title=utility.string.sprintf(placeholder_title,unescape(file_system[1].replace(/file:\/\/\//i,'')));var html='<img src="'+placeholder_image+'" style_preserve="'+w+h+';background-image:url('+not_found+');background-repeat:no-repeat;background-position:center"';html+='alt="'+title+'" title="'+title+'">';return html;}
return a;});}
str=str.replace(/style_preserve=/gi,'style=');return str;}
if(typeof KTML_Translators=="undefined"){KTML_Translators={ANCHOR:"WMedia_Translator",HIDDEN:"WMedia_Translator",WindowsMedia:"WMedia_Translator",FlashMovie:"WMedia_Translator",QuickTime:"WMedia_Translator",WORDHTML:"WordHTML_Translator",SCRIPT:"WMedia_Translator"}}