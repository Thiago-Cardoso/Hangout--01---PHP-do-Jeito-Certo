
var words=new Array();var addedWords=new Array();function SpellChecker(index,defaultLanguage){this.owner=window.opener.ktmls[index];this.language=defaultLanguage;this.location=false;this.dialects=document.getElementById(name+"_spellcheck_dialect");this.wnd=null;this.rpc=null;this.selectionIndex=-1;this.currentWord=null;}
function removeOptions(el){for(i=0;i<=el.options.length;i++){el.options[i]=null;}
el.options.length=0;}
function SpellChecker_setReplacementWord(replacementWord){if(this.selectionIndex<0||this.currentWord==null){return;}
this.replaceWithObject.value=replacementWord;words[this.currentWord]["replacement"]=replacementWord;}
function SpellChecker_setSuggestions(){if(this.selectionIndex<0||this.currentWord==null){return;}
removeOptions(this.suggestionListObject);var arr=words[this.currentWord].suggestions;if(typeof arr=="undefined"){return;}
for(var i=0;i<arr.length;i++){if(arr[i]!=""){var opt=new Option(arr[i],arr[i]);this.suggestionListObject.options[this.suggestionListObject.options.length]=opt;}}
this.suggestionListObject.options.selectedIndex=0;this.setReplacementWord(this.suggestionListObject.value);return true;}
function SpellChecker_invalidate(){return true;}
function SpellChecker_setLanguage(language){this.language=language;}
function SpellChecker_get(what,getParams,postParams){if(!this.rpc){return new Array();}
return tmp.split("\r\n");}
function SpellChecker_boot_step_1_test(lang){if(typeof lang=='object'&&lang.error){alert(utility.string.getInnerText(lang.error.message));utility.window.close();}else{this.owner.setModuleProperty("spellchecker","languages",lang);this.boot_step_2();}}
function SpellChecker_boot_step_2(){this.spellcheckDialectObject=document.getElementById("spellcheck_dialect");this.notInDictionaryObject=document.getElementById("notInDictionary");this.replaceWithObject=document.getElementById("replaceWith");this.suggestionListObject=document.getElementById("suggestionList");removeOptions(this.spellcheckDialectObject);var languages=[];var tmp=this.owner.getModuleProperty("spellchecker","languages");for(var i=0;i<tmp.length;i++){languages.push(tmp[i]);}
if(languages.length==0){alert(opener.translate("No dictionaries available on server.",ktml.config.UILanguage));window.setTimeout("utility.window.close()",500);return;}
var selectedValue="";var found=false;for(i=0;i<languages.length;i++){if(languages[i]!=""){if(selectedValue==""){selectedValue=languages[i];}
var oneLanguage=languages[i].split("|");var opt=new Option(oneLanguage[2],languages[i]);if(this.language==oneLanguage[1]){selectedValue=languages[i];opt.selected=true;found=true;}
this.spellcheckDialectObject.options[this.spellcheckDialectObject.options.length]=opt;}}
this.spellcheckDialectObject.value=selectedValue;this.word_array=this.owner.getModuleProperty("spellchecker","word_array");this.orng=this.owner.getModuleProperty("spellchecker","selectionRange").duplicate();this.rng=this.orng.duplicate();this.spellCheck();}
function SpellChecker_boot_step_1(){var tmp=this.owner.getModuleProperty("spellchecker","languages");if(typeof(tmp)=='undefined'||typeof(tmp)!='undefined'&&tmp.length==0){this.owner.makeRequest('spellcheck','listlanguages',{},function(obj){if(typeof obj=='object'&&obj.error){if(obj.error.code=='KTML_SPELLCHECK_ERROR_DICTIONARY_NOT_INSTALLED'){if(!confirm(opener.translate("Dictionary not installed.",ktml.config.UILanguage))){utility.window.close();}}else{alert(utility.string.getInnerText(obj.error.message));utility.window.close();}
return;}
spellchecker.boot_step_1_test(obj);});}else{this.boot_step_2();}}
function SpellChecker_spellCheck(){var t1=new Date();words=new Array();var text=this.word_array.join("\n");var spelled=this.owner.makeRequest("spellcheck","spellcheck",{text:text,dialect:document.getElementById("spellcheck_dialect").value},function(obj){if(typeof obj=='object'&&obj.error){if(obj.error.code=='KTML_SPELLCHECK_ERROR_DICTIONARY_NOT_INSTALLED'){if(!confirm(opener.translate("Dictionary not installed.",ktml.config.UILanguage))){utility.window.close();}}else{alert(utility.string.getInnerText(obj.error.message));utility.window.close();}}else{var spelled=obj;var words_count=0;for(var word_index in spelled){var o={status:0,word:spelled[word_index][0]};var line=spelled[word_index][1];if(!line){words_count++;words[o.word]=o;continue;}
var spl=line.split("\t");if(spl.length>0){words_count++;o.suggestions=spl;}
words[o.word]=o;}
this.misspelled_words_count=words_count;spellchecker.start();}});}
function SpellChecker_start(){this.owner.edit.selection.empty();this.selectionIndex=-1;this.next();}
function SpellChecker_stop(){this.selectionIndex=-1;this.currentWord=null;this.notInDictionaryObject.value="";this.replaceWithObject.value="";removeOptions(this.suggestionListObject);ktml.getModuleProperty("spellchecker","selectionRange").select();var rng=ktml.edit.selection.createRange();if(is.mozilla){ktml.edit.selection.removeAllRanges();}
rng.collapse(false);rng.select();}
function SpellChecker_next(){if(this.selectionIndex<0){this.owner.edit.selection.empty();}else{if(is.mozilla){this.owner.edit.selection.collapseToEnd();}else{this.rng=this.owner.edit.selection.createRange();this.rng.collapse(false);this.rng.select();}}
this.selectionIndex++;var wall=this.word_array.length;for(var i=this.selectionIndex;i<wall;i++){var anWord=this.word_array[i];if(typeof words[anWord]=="undefined"){continue;}
if(typeof window.addedWords[anWord]!="undefined"||typeof words[anWord]["status"]!="undefined"&&(words[anWord]["status"]=="ignored"||words[anWord]["status"]=="changed")){continue;}
break;}
if(i==wall){this.stop();if(wall>0){alert(window.topOpener.translate("Spellchecker complete",ktml.config.UILanguage));}
window.setTimeout('window.close();',1);return;}
this.selectionIndex=i;this.currentWord=anWord;this.notInDictionaryObject.value=anWord;this.setReplacementWord("");this.setSuggestions();if(window.topOpener.is.ie){this.rng.findText(anWord,1000000000,4);this.rng.select();}else{var fnd=this.owner.cw.find(anWord,true,false,false,true,false,false);if(fnd){this.rng=this.owner.edit.selection.createRange();}else{this.rng.collapse(false);this.rng.select();}}}
function SpellChecker_change(){if(this.selectionIndex<0||this.currentWord==null){return;}
this.rng.text=words[this.currentWord]["replacement"];this.rng.select();this.next();}
function SpellChecker_ignore(){if(this.selectionIndex<0||this.currentWord==null){return;}
this.next();}
function changeAll_clicked(){spellchecker.changeAll();}
function SpellChecker_changeAll(){if(this.selectionIndex<0||this.currentWord==null){return;}
words[this.currentWord]["status"]="changed";var wall=this.word_array.length;for(var i=this.selectionIndex;i<wall;i++){var anWord=this.word_array[i];if(anWord==this.currentWord){this.word_array[i]=words[this.currentWord]["replacement"];}}
if(!this.rng){this.rng=this.owner.edit.selection.createRange();}
this.rng.text=words[this.currentWord]["replacement"];var dupe=this.rng.duplicate();if(window.topOpener.is.ie){while(txt=dupe.findText(this.currentWord,1000000000,4)){dupe.select();if(dupe.compareEndPoints("StartToEnd",this.orng)>=0){break;}
dupe.text=words[this.currentWord]["replacement"];}
this.rng.select();}else{while(txt=this.owner.cw.find(this.currentWord,true,false,false,true,false,false)){dupe=this.owner.edit.selection.createRange();if(dupe.compareEndPoints("StartToEnd",this.orng)>=0){break;}
if(String_trim(dupe.text)==String_trim(dupe.startContainer.textContent)){dupe.text=words[this.currentWord]["replacement"];}}}
this.next();}
function SpellChecker_ignoreAll(){if(this.selectionIndex<0||this.currentWord==null){return;}
words[this.currentWord]["status"]="ignored";this.next();}
function SpellChecker_addToDictionary(){if(this.selectionIndex<0||this.currentWord==null){return;}
if(confirm(window.topOpener.translate("Are you sure",ktml.config.UILanguage))){var result=this.owner.makeRequest("spellcheck","addword",{"word":this.currentWord},function(result){if(typeof result=='object'&&result.error){alert(utility.string.getInnerText(result.error.message));return;}else{window.addedWords[spellchecker.currentWord]=spellchecker.currentWord;words[spellchecker.currentWord]["status"]="added";spellchecker.setReplacementWord(spellchecker.currentWord);spellchecker.next();}});}}
SpellChecker.prototype.setSuggestions=SpellChecker_setSuggestions;SpellChecker.prototype.setReplacementWord=SpellChecker_setReplacementWord;SpellChecker.prototype.spellCheck=SpellChecker_spellCheck;SpellChecker.prototype.start=SpellChecker_start;SpellChecker.prototype.next=SpellChecker_next;SpellChecker.prototype.change=SpellChecker_change;SpellChecker.prototype.ignore=SpellChecker_ignore;SpellChecker.prototype.changeAll=SpellChecker_changeAll;SpellChecker.prototype.ignoreAll=SpellChecker_ignoreAll;SpellChecker.prototype.addToDictionary=SpellChecker_addToDictionary;SpellChecker.prototype.invalidate=SpellChecker_invalidate;SpellChecker.prototype.setLanguage=SpellChecker_setLanguage;SpellChecker.prototype.get=SpellChecker_get;SpellChecker.prototype.boot_step_1=SpellChecker_boot_step_1;SpellChecker.prototype.boot_step_1_test=SpellChecker_boot_step_1_test;SpellChecker.prototype.boot_step_2=SpellChecker_boot_step_2;SpellChecker.prototype.stop=SpellChecker_stop;function changeLanguage(el){ktml.getModuleProperty("spellchecker","selectionRange").select();ktml.detectWordsArray();var new_lang=el.options[el.selectedIndex].value;new_lang=new_lang.split("|");spellchecker.setLanguage(new_lang[1]);spellchecker=new SpellChecker(getvars.find('id'),new_lang[1]);spellchecker.boot_step_2();}