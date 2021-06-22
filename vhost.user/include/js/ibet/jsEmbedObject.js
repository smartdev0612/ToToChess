////////////////////////////////////////////////////////////////////////////
//
//   Flash External MouseWheel Event v1.0
//   Work on Mac (Safari, FireFox, Opera)
//   Work on Windows (InternetExplorer, FireFox, Safari, Opera)
//
////////////////////////////////////////////////////////////////////////////
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function selBoxLink(value) {
	if (value != "") {
		window.open (value, "", "");
	}
}

/*
document.onkeydown = function() {
	if (event.keyCode == 116) {
		event.keyCode = 505;	
	}
	if (event.keyCode == 505) { 
		return false;	
	}
}
*/
function hidestatus(){
window.status='...'
return true
}

function makeFlashObject(swfURL,w,h,id,flashVars){
	var swfHTML = ('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'+ w +'" height="'+h+'" id="'+id+'" align="middle">');
	swfHTML+=('<param name="allowScriptAccess" value="sameDomain" />');
	swfHTML+=('<param name="FlashVars" value="'+ flashVars +'"/>');
	swfHTML+=('<param name="menu" value="false"/>');
	swfHTML+=('<param name="wmode" value="transparent"/>');
	swfHTML+=('<param name="movie" value="'+swfURL+'" /><param name="quality" value="high" /><param name="salign" value="lt" />');
	swfHTML+=('<embed menu="false" src="'+ swfURL +'"  wmode="transparent" quality="high" FlashVars="'+flashVars+'" bgcolor="#ffffff" width="'+w+'" height="'+h+'" name="'+id+'" align="middle" salign="lt" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
	swfHTML+=('</object>');
	document.write(swfHTML);
}

// MAC
var isMac=false;

// PC
var isPC=false;

// FIREFOX or SAFARI
var isFF=false;

// INTERNET EXPLORER
var isIE=false;

// MAC or PC
if(navigator.appVersion.toLowerCase().indexOf("mac")!=-1){
	isMac=true;
}else{
	isPC=true;
}

// IE or FF
if(navigator.appName.indexOf("Microsoft") != -1){
	isIE=true;
}else{
	isFF=true;
}

// MouseOver
var isOverFlash="none";

// Flash Write
function flashWrite(url,id,bg,vars,win,w,h,base,isWheel){
	var flashStr=
	"<div id='"+id+"_layer' style='width:"+w+";height:"+h+";'>"+
	"<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,124,0' width='"+w+"' height='"+h+"' id='"+id+"' align='middle'>"+
	"<param name='allowScriptAccess' value='always' />"+
	"<param name='movie' value='"+url+"' />"+
	"<param name='base' value='"+base+"' />"+
	"<param name='FlashVars' value='"+vars+"' />"+
	"<param name='wmode' value='"+win+"' />"+
	"<param name='quality' value='high' />"+
	"<param name='bgcolor' value='"+bg+"' />"+
	"<embed src='"+url+"' base='"+base+"' FlashVars='"+vars+"' wmode='"+win+"' quality='high' bgcolor='"+bg+"' width='"+w+"' height='"+h+"' name='"+id+"' align='middle' allowScriptAccess='always' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />"+
	"</object></div>";
	document.write(flashStr);
		if(isWheel){
		document.all[id+"_layer"].onmouseover=function(){
			isOverFlash=id;
		}
		document.all[id+"_layer"].onmouseout=function(){
			isOverFlash="none";
		}
	}
}

// Find Flash Target
function flashThisMovie(movieName){
	if(navigator.appName.indexOf("Microsoft") != -1){
		return window[movieName];
	}else{
		return document[movieName];
	}
}

// Mouse Wheel Init
function externalWheelEventInit(){
	if(window.addEventListener){
		window.addEventListener('DOMMouseScroll',externalWheelEvent,false);
	}else{
		window.onmousewheel=externalWheelEvent;
	}
	document.onmousewheel=externalWheelEvent;
}

// Mouse Wheel Event
function externalWheelEvent(event){
	if(isOverFlash!="none"){
		var e;
		if(isMac){
			e=event;
		}else{
			if(isFF){
				e=event;
			}else{
				e=window.event;
			}
		}
		var delta=0;
		if(e.wheelDelta){
			delta=e.wheelDelta/120;
		}else if(e.detail){
			delta=-e.detail/3;
		}
		if(/AppleWebKit/.test(navigator.userAgent))delta/=3;
		if(delta){
			flashThisMovie(isOverFlash).externalMouseEvent(delta);
		}
		if(e.preventDefault)e.preventDefault();
		e.returnValue=false;
	}
}

// Start
externalWheelEventInit();
