function Qishi_Assignment(x)
{
var rgb=x;
if (rgb=="")
{
document.getElementById('article_color_box_bg').style.background='url(images/article_bg.gif)';
}else
{
document.getElementById('article_color_box_bg').style.background=rgb;
}
//alert(rgb);
document.FormData.tit_color.value= rgb;
document.getElementById('tit_color').style.background=rgb;
}
function Qishi_is_display()
{
target=document.getElementById('article_color_box');
 if (target.style.display=="block"){
target.style.display="none";
 } else {
target.style.display="block";
 }
//document.bgColor =rgb;
}