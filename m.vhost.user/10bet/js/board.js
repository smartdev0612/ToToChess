function resizeBoardImage(imageWidth,borderColor){var target=document.getElementsByName('target_resize_image[]');var imageHeight=0;if(target){for(i=0;i<target.length;i++){target[i].tmp_width=target[i].width;target[i].tmp_height=target[i].height;if(target[i].width>imageWidth){imageHeight=parseFloat(target[i].width/target[i].height)
target[i].width=imageWidth;target[i].height=parseInt(imageWidth/imageHeight);target[i].style.cursor='pointer';target[i].style.width='';target[i].style.height='';}
if(borderColor){target[i].style.borderWidth='1px';target[i].style.borderStyle='solid';target[i].style.borderColor=borderColor;}}}}
function getFontSize(){var fontSize=parseInt(get_cookie("ck_fontsize"));if(isNaN(fontSize)){fontSize=12;}
return fontSize;}
function scaleFont(val){var fontSize=getFontSize();var fontSizeSave=fontSize;if(val>0){if(fontSize<=18){fontSize=fontSize+val;}}else{if(fontSize>12){fontSize=fontSize+val;}}
if(fontSize!=fontSizeSave){drawFont(fontSize);}
set_cookie("ck_fontsize",fontSize,30,g4_cookie_domain);}
function drawFont(fontSize){if(!fontSize){fontSize=getFontSize();}
var subject=document.getElementById("writeSubject");var content=document.getElementById("writeContents");var comment=document.getElementById("commentContents");var wr_subject=document.getElementById("wr_subject");var wr_content=document.getElementById("wr_content");if(comment){var commentDiv=comment.getElementsByTagName("div");var lineHeight=fontSize+Math.round(1.1*fontSize);}
fontSize=fontSize+"px";if(subject)
subject.style.fontSize=fontSize;if(content)
content.style.fontSize=fontSize;if(wr_subject)
wr_subject.style.fontSize=fontSize;if(wr_content)
wr_content.style.fontSize=fontSize;if(commentDiv){for(i=0;i<commentDiv.length;i++){commentDiv[i].style.fontSize=fontSize;}}}