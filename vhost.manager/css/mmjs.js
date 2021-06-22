// JavaScript Document
function f_OpenMenu(theURL) {
   parent.RightFrame.location.href = theURL;
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function Expand() {
   divs=document.getElementsByTagName("DIV");
   for (i=0;i<divs.length;i++) {
     divs[i].style.display="";
     key=document.getElementById("x" + divs[i].id);
   }
}

function Collapse() {
   divs=document.getElementsByTagName("DIV");
   for (i=0;i<divs.length;i++) {
     divs[i].style.display="none";
     key=document.getElementById("x" + divs[i].id);
   }
}

function Toggle(item) {
   obj=document.getElementById(item);
   visible=(obj.style.display!="none")
   key=document.getElementById("x" + item);
   if (visible) {
     obj.style.display="none";
   } else {
     obj.style.display="";
   }
}

//Added By Anthony, copied from Gemini mmjs.js
function MenuClick(menuID)
{    
    ToggleMenu(menuID);    
}

//For Menu mini and full
function ToggleMenu(item) {
   obj=document.getElementById(item);
   if (! obj) return;
   obj.style.display="none"; 
   var mini = (item.search("Mini")!= -1)
   
   if (mini) {
     item = item.replace(/Mini/,"Full");
   } else {
     item = item.replace(/Full/,"Mini");
   }
   obj=document.getElementById(item);  
   if(navigator.userAgent.indexOf("MSIE 8")!=-1) {
   obj.style.display="inline-table";
   } else {
   obj.style.display="";
   }
}

function ca_openMenu(url) {
    parent.RightFrame.location.href = "sso-casino.aspx?url=" + url;
}

function f_OpenHelp(link) {
    var wHandler = window.open(link);
    if (wHandler) wHandler.focus();
}