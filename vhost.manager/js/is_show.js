document.write("<div id='pup' style='position:absolute; border: 4px solid #cccccc;z-index:1;color:#000000;background-color: #ffffff; width:auto;overflow: visible;visibility: hidden;font-size:12px;padding:6px;text-align: left;line-height:200%;'></div>")
function showpup(str)
{
  var x=event.x;
  var y=event.y;
  pup.innerHTML=str;
  pup.style.visibility="visible";
  pup.style.left=x+10;
  pup.style.pixelTop=y+document.documentElement.scrollTop+10;
}

function hidepup()
{
  pup.style.innerHTML=""
  pup.style.visibility="hidden";
}