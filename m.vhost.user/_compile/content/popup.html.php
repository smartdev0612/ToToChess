<?php /* Template_ 2.2.3 2013/03/15 18:22:18 D:\www\m.vhost.user\_template\content\popup.html */?>
<script>document.title = '<?php echo $TPL_VAR["title"]?>';</script>

<script>

function setCookie(name, value, expiredays )
{
	//<![CDATA[
	var today = new Date();
  today.setDate( today.getDate() + expiredays );
  document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + 
  today.toGMTString() + ";";
	//  return;
//]]>
}
//저장된 쿠키값 읽어오기
function getCookie(name)
{
//<![CDATA[
	var nameOfCookie = name + "=";
  var x = 0; 
  while(x<=document.cookie.length)
  {
  	var y = (x+nameOfCookie.length);
    if(document.cookie.substring(x,y) == nameOfCookie)
    {
    	if((endOfCookie=document.cookie.indexOf(";",y))==-1)
      	endOfCookie = document.cookie.length;
			return unescape(document.cookie.substring(y,endOfCookie));
		}
    x = document.cookie.indexOf("",x)+1;  //날짜지정
    if(x==0) break;
	}
	return "";
//]]>
}

</script>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
<title><?php echo $TPL_VAR["site_title"]?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE7">
<meta name="author" content="KG SOFT">
<meta name="copyright" content="OK SPORTS 2012"/>
<meta http-equiv="imagetoolbar" content="no">
<meta name="robots" content="noindex">

<link rel="stylesheet" type="text/css" href="/css/default.css?v04" >
</head>

<body id="wrap_popup">

<div id="whole_popup">

	<div class="text">
		 <?php echo $TPL_VAR["content"]?><br>
	</div>
	<p>
		<input type="checkbox" name="popupCookie" onclick="setCookie('popup_'+<?php echo $TPL_VAR["popup_sn"]?>,'done',1);self.close();"> 
			하루 동안 이 팝업을 보이지 않음. &nbsp;&nbsp;&nbsp;
		<a href="#" onClick="self.close();return false"><span>닫기</span></a>
	</p>

</div>

</body>
</html>
<!--
<div id="popup_layer" style="position:absolute;width:250px; left:10px;top:10px;z-index:101;background-image:url('/upload/popup/bg_popup.jpg');">
	<table>
		<tr height="100%">
			<td>
				<img src="upload/popup/event1.jpg" border=0>
			</td>
		</tr>
		<tr>	
			<td>
			<input type="checkbox" name="popupCookie" onclick="setCookie('popup_'+<?php echo $TPL_VAR["popup_sn"]?>,'done',1);self.close();"> 
			하루 동안 이 팝업을 보이지 않음. &nbsp;&nbsp;&nbsp;
				<a href="#" onClick="self.close();return false"><font color='green' size=2 face=arial  style="text-decoration:none">닫기</font></a>
			</td>
		</tr>
	</table>
</div>
-->