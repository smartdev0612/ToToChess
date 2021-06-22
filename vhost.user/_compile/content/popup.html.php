<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
	<title><?php echo $TPL_VAR["site_title"]?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="shortcut icon" href="/img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="/new_css/game.css"/>
	<link rel="stylesheet" type="text/css" href="/new_css/layout.css"/>
	<title><?php echo $TPL_VAR["SITE_TITLE"]?> 스포츠배팅 NO.1</title>
	<style>
		body { background-color: #000000;
           background-image: url('<?php echo $TPL_VAR["file_url"];?>');
					 background-size:100% 100%;
           background-repeat: no-repeat;
           background-attachment: fixed;
           background-position: center center;}
	</style>
</head>
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
<body>
<div style="width:100%;height:100%;">
	<div>
		 <?php echo $TPL_VAR["content"]?><br>
	</div>
	<div style="height:30px;text-align:right;margin:10px 20px 10px 0;">
		<input type="checkbox" name="popupCookie" onclick="setCookie('popup_'+<?php echo $TPL_VAR["popup_sn"]?>,'done',1);self.close();"> 
			하루 동안 이 팝업을 보이지 않음. &nbsp;&nbsp;&nbsp;
		<a href="#" onClick="self.close();return false"><span>[닫기]</span></a>
	</div>
</div>
</body>
</html>