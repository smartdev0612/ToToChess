function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
  

function FlashTag(movie, width, height) {

  var hmutliFlashObject = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ' + 
    'codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" ' +
    ' WIDTH="' + width + '" HEIGHT="' + height + '" id="load" ALIGN="">' +
    ' <PARAM NAME=movie VALUE="' + movie + '">' +
    ' <PARAM NAME=menu VALUE=false>' +
    ' <PARAM NAME=quality VALUE=high>' + 
    ' <PARAM NAME="wmode" VALUE="transparent">' +
    ' <EMBED invokeURLs=false src="' + movie + '" ' +
    'menu=false quality=high bgcolor=#FFFFFF  WIDTH="' + width + '" HEIGHT="' + height + '" NAME="load" wmode="transparent" ALIGN="" ' +
       ' TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED invokeURLs=false>' +
    '</OBJECT>';
    document.write(hmutliFlashObject);
 }
 

function na_open_window(name, url, left, top, width, height, toolbar, menubar, statusbar, scrollbar, resizable)
{
  toolbar_str = toolbar ? 'yes' : 'no';
  menubar_str = menubar ? 'yes' : 'no';
  statusbar_str = statusbar ? 'yes' : 'no';
  scrollbar_str = scrollbar ? 'yes' : 'no';
  resizable_str = resizable ? 'yes' : 'no';
  window.open(url, name, 'left='+left+',top='+top+',width='+width+',height='+height+',toolbar='+toolbar_str+',menubar='+menubar_str+',status='+statusbar_str+',scrollbars='+scrollbar_str+',resizable='+resizable_str);
}

function ReWrite(URL){
	location.replace(URL)
}

function bluring(){ 
	if(event.srcElement.tagName=="A") document.body.focus(); 
	} 
document.onfocusin=bluring; 
