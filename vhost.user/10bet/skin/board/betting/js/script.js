function DeleteData(URL){if(confirm('정말삭제하시겠습니까?')){location.href=URL;}}
function ConfirmData(URL,Str){if(confirm(Str)){location.href=URL;}}
function FormLoginCheck(f){if(!Web.checkPID(f,'id')){alert('아이디는 4자 이상 12자 이하 영문, 숫자, - 그리고 _ 만 입력 가능합니다.');f.id.focus();return false;}
if(f.pass.value==''||f.pass.value==' '){alert('패스워드를 입력하십시오');f.pass.focus();return false;}}
function SearchCheck(f){if(f.word.value==''){alert('검색어를 입력하십시오');f.word.focus();return false;}}
function IsNumber(obj){if(isNaN(obj.value)){alert('숫자만 입력하십시오');obj.value='';obj.focus();obj.select();}}
function IsNumberKeyPress(e){if(e.keyCode<45||e.keyCode>57){e.returnValue=false;}}
function LoadSWF(id,src,w,h,bg,isplay,wmode){if(wmode=='')
{StrWMode='window';}
else{StrWMode='transparent';}
document.write("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\""+w+"\" height=\""+h+"\" id=\""+id+"\">\n");document.write("<param name=\"WMode\" value=\""+StrWMode+"\">\n");document.write("<param name=\"Play\" value=\""+isplay+"\">\n");document.write("<param name=\"Quality\" value=\"High\">\n");document.write("<param name=\"Menu\" value=\"true\">\n");document.write("<param name=\"Scale\" value=\"ShowAll\">\n");document.write("<param name=\"Movie\" value=\""+src+"\">\n");document.write("<param name=\"BGColor\" value=\""+bg+"\">\n");document.write("<embed src=\""+src+"\" id=\""+id+"\" name=\""+id+"\" width=\""+w+"\" height=\""+h+"\" wmode=\""+StrWMode+"\" play=\""+isplay+"\" quality=\"High\" menu=\"true\" scale=\"ShowAll\" bgcolor=\""+bg+"\">\n");document.write("</object>");}
function OpenWindow(StrPage,StrName,w,h,sc){var win=null;var winl=(screen.width-w)/2;var wint=(screen.height-h)/3;settings='height='+h+',';settings+='width='+w+',';settings+='top='+wint+',';settings+='left='+winl+',';settings+='scrollbars='+sc+',';settings+='resizable=no,';settings+='status=no';win=window.open(StrPage,StrName,settings);win.window.focus();}
function GoOpener(StrURL){if(top.opener&&!top.opener.closed){top.opener.location.href=StrURL;}else{top.opener=window.open(StrURL);}
top.opener.focus();}
function MoneyFormat(str)
{var re="";str=str+"";str=str.replace(/-/gi,"");str=str.replace(/ /gi,"");str2=str.replace(/-/gi,"");str2=str2.replace(/,/gi,"");str2=str2.replace(/\./gi,"");if(isNaN(str2)&&str!="-")return"";try
{for(var i=0;i<str2.length;i++)
{var c=str2.substring(str2.length-1-i,str2.length-i);re=c+re;if(i%3==2&&i<str2.length-1)re=","+re;}}catch(e)
{re="";}
if(str.indexOf("-")==0)
{re="-"+re;}
return re;}
function getObject(objectId){if(document.getElementById&&document.getElementById[objectId]){return document.getElementById[objectId];}
else if(document.all&&document.all[objectId]){return document.all[objectId];}
else if(document.layers&&document.layers[objectId]){return document.layers[objectId];}
else if(document.getElementById&&document.getElementById(objectId)){return document.getElementById(objectId);}
else
{return false;}}
function Floor(s,n)
{s=s+"";if(s.indexOf(".")>=0)
{s=s.substring(0,s.indexOf(".")+3);}
s=parseFloat(s);return s;}
function getSrcElement(e)
{var src=e.srcElement?e.srcElement:e.target;return src;}
function GoGame(StrPage,Selectname,SelectBox,GameType){if(SelectBox.value=='n')
{location.href=StrPage;}
else if(SelectBox.value!='')
{StrURL=StrPage+'?'+Selectname+'='+SelectBox.value;if(GameType!='0')
{StrURL+='&gametype='+GameType;}
location.href=StrURL;}}
function GoGametype(StrPage,SelectBox){StrURL=StrPage;if(SelectBox.value!='')
{if(SelectBox.value!='0'){StrURL+='?gametype='+SelectBox.value;}
location.href=StrURL;}}
function trim(str){str=str.replace(/^\s*/,'').replace(/\s*$/,'');return str;}
function ClipboardCopy(i){var TempEval=i;FormRange=TempEval.createTextRange();FormRange.execCommand('Copy');alert('복사되었습니다');}