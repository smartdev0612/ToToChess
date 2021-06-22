function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
	function openNotice(intChildIdx) {
		window.open ("/pop_GameNotice.asp?intChildIdx="+intChildIdx,"공지사항"," scrollbars=no,toolbar=no,location=no,directories=no,status=no, width=400, height=400");
	}
function bookmark() {
	window.external.AddFavorite('<%=CONF_SITE_DOMAIN%>','<%=CONF_SITE_NAME%>');
}
function hidestatus(){
window.status='정직/신용/색다른재미/';
return true;
}
if (document.layers)
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT);
document.onmouseover=hidestatus;
document.onmouseout=hidestatus;

function DeleteData(URL) {
	if (confirm('정말삭제하시겠습니까?')) {
		location.href = URL;
	}
}

function go_url(url){
	document.location = url;
}

function ConfirmData(URL,Str) {
	if (confirm(Str)) {
		location.href = URL;
	}
}
function FormLoginCheck(f) {
	if (f.id.value == '') {
		alert('아이디를 입력하십시오');
		f.id.focus();
		return false;
	}
	if (f.pass.value == '' || f.pass.value == ' ') {
		alert('패스워드를 입력하십시오');
		f.pass.focus();
		return false;
	}
}
function SearchCheck(f) {
	if (f.word.value == '') {
		alert('검색어를 입력하십시오');
		f.word.focus();
		return false;
	}
}
function IsNumber(obj) {
	if (isNaN(obj.value)) {
		alert('숫자만 입력하십시오');
		obj.value = '';
		obj.focus();
		obj.select();
	}
}
function IsNumberKeyPress(e) {
	if (e.keyCode<45 || e.keyCode>57) {
		e.returnValue = false;
	}
}
function LoadSWF(id,src,w,h,bg,isplay,wmode) {
	if (wmode == '')
	{
		StrWMode = 'window';
	}
	else {
		StrWMode = 'transparent';
	}
	document.write("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"" + w + "\" height=\"" + h + "\" id=\"" + id + "\">\n");
	document.write("<param name=\"WMode\" value=\"" + StrWMode + "\">\n");
	document.write("<param name=\"Play\" value=\"" + isplay + "\">\n");
	document.write("<param name=\"Quality\" value=\"High\">\n");
	document.write("<param name=\"Menu\" value=\"true\">\n");
	document.write("<param name=\"Scale\" value=\"ShowAll\">\n");
	document.write("<param name=\"Movie\" value=\"" + src + "\">\n");
	document.write("<param name=\"BGColor\" value=\"" + bg + "\">\n");
	document.write("<embed src=\"" + src + "\" id=\"" + id + "\" name=\"" + id + "\" width=\"" + w + "\" height=\"" + h + "\" wmode=\"" + StrWMode + "\" play=\"" + isplay + "\" quality=\"High\" menu=\"true\" scale=\"ShowAll\" bgcolor=\"" + bg + "\">\n");
	document.write("</object>");
}
function OpenWindow(StrPage, StrName, w, h, sc) {
	var win = null;
	var winl = (screen.width-w)/2;
	var wint = (screen.height-h)/3;
	settings = 'height='+h+',';
	settings += 'width='+w+',';
	settings += 'top='+wint+',';
	settings += 'left='+winl+',';
	settings += 'scrollbars='+sc+',';
	settings += 'resizable=no,';
	settings += 'status=no';
	win = window.open(StrPage, StrName, settings);
	win.window.focus();
}
function GoOpener(StrURL) {
	if (top.opener && !top.opener.closed) {
		top.opener.location.href = StrURL;
	} else {
		top.opener = window.open(StrURL);
	}
	top.opener.focus();
}

function MoneyFormat(str)
{
	var re="";
	str = str + "";
	str=str.replace(/-/gi,"");
	str=str.replace(/ /gi,"");
	
	str2=str.replace(/-/gi,"");
	str2=str2.replace(/,/gi,"");
	str2=str2.replace(/\./gi,"");	
	
	if(isNaN(str2) && str!="-") return "";
	try
	{
		for(var i=0;i<str2.length;i++)
		{
			var c = str2.substring(str2.length-1-i,str2.length-i);
			re = c + re;
			if(i%3==2 && i<str2.length-1) re = "," + re;
		}
		
	}catch(e)
	{
		re="";
	}
	
	if(str.indexOf("-")==0)
	{
		re = "-" + re;
	}
	
	return re;

}
function getObject(objectId) { 
	// checkW3C DOM, then MSIE 4, then NN 4. 
	
	if(document.getElementById && document.getElementById[objectId]) { 
		return document.getElementById[objectId]; 
	} 
	else if (document.all && document.all[objectId]) { 
		return document.all[objectId]; 
	} 
	else if (document.layers && document.layers[objectId]) { 
		return document.layers[objectId]; 
	}
	else if(document.getElementById && document.getElementById(objectId)) { 
		return document.getElementById(objectId); 
	}
	else 
	{ 
		return false; 
	} 
}
function Floor(s,n)
{
	s=s+"";
	if(s.indexOf(".")>=0)
	{
		s=s.substring(0,s.indexOf(".")+3);
	}
	s = parseFloat(s);
	return s;
}
function getSrcElement(e)
{
	var src = e.srcElement? e.srcElement : e.target; 
	return src;
}
function GoGame(StrPage,Selectname,SelectBox,GameType) {
	if (SelectBox.value == 'n')
	{
		location.href = StrPage;
	}
	else if (SelectBox.value != '')
	{
		StrURL = StrPage + '?' + Selectname + '=' + SelectBox.value;
		if (GameType != '0')
		{
			StrURL += '&gametype='+GameType;
		}
		location.href = StrURL;
	}
}
function GoGametype(StrPage,SelectBox) {
	StrURL = StrPage;
	if (SelectBox.value != '')
	{
		if (SelectBox.value != '0') {
			StrURL += '?gametype='+SelectBox.value;
		}
		location.href = StrURL;
	}
}
function trim(str){
	str = str.replace(/^\s*/,'').replace(/\s*$/, '');
	return str;

}
function ClipboardCopy(i) 
{
	var TempEval = i;
	FormRange = TempEval.createTextRange();
	FormRange.execCommand('Copy');
	alert('복사되었습니다');
}


// 배팅슬립

function initMoving() {
 
	var obj = document.getElementById("wrap_betslip");
	obj.initTop = 144;
	obj.topLimit = 215;
	obj.bottomLimit = document.documentElement.scrollHeight - 100;
	 
	obj.style.position = "absolute";
	obj.top = obj.initTop;
	obj.left = obj.initLeft;
	if (typeof(window.pageYOffset) == "number") {
	obj.getTop = function() {
	return window.pageYOffset;
	}
	} else if (typeof(document.documentElement.scrollTop) == "number") {
	obj.getTop = function() {
	return document.documentElement.scrollTop;
	}
	} else {
	obj.getTop = function() {
	return 0;
	}
	}
	 
	if (self.innerHeight) {
	obj.getHeight = function() {
	return self.innerHeight;
	}
	} else if(document.documentElement.clientHeight) {
	obj.getHeight = function() {
	return document.documentElement.clientHeight;
	}
	} else {
	obj.getHeight = function() {
	return 500;
	}
	}
 
	if (document.all.animate.checked){
 
		clearInterval(obj.move);
		return false;
	}else{
 
		obj.move = setInterval(quickdiv, 30); //이동속도
	}
}
 
function quickdiv() {
	var obj = document.getElementById("wrap_betslip");
	if (obj.initTop > 0) {
		pos = obj.getTop() + obj.initTop-140;
	} else {
	pos = obj.getTop() + obj.getHeight() + obj.initTop;
	//pos = obj.getTop() + obj.getHeight() / 2 - 15;
	}
	 
	if (pos > obj.bottomLimit)
	pos = obj.bottomLimit;
	if (pos < obj.topLimit)
	pos = obj.topLimit;
	 
	interval = obj.top - pos;
	obj.top = obj.top - interval / 3;
	obj.style.top = obj.top + "px";
}


function Pop_close()

    {
        $("#wrap_indexMemo").hide();    
	}

//플래시
function flashDP(s,d,w,h,t){
	document.write("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width="+w+" height="+h+" id="+d+"><param name=wmode value="+t+" /><param name=movie value="+s+" /><param name=quality value=high /><embed src="+s+" quality=high wmode="+t+" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash\" width="+w+" height="+h+"></embed></object>");
}



function hidden()
{

	if (document.getElementById("tb_list").style.display == 'block') document.getElementById("tb_list").style.display = 'none';
	else if (document.getElementById("tb_list").style.display == 'none') document.getElementById("tb_list").style.display = 'block';

}