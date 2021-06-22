<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title> 관리 </title>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta http-equiv="imagetoolbar" content="no">
		<link rel="shortcut icon" href="/img/favicon.ico">
		<link rel="stylesheet" href="/css/default.css" type="text/css">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		
		<script src="/js/selectAll.js"></script>
		<script src="/js/js.js"></script>
		<!--<script src="/js/Basic.js" defer="defer"></script>-->
		<script src="/js/is_show.js"></script>
		<script src="/js/lendar.js?v=2"></script>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script language="JavaScript">
			
		function refreshContent() 
		{ 
			var oBao = new ActiveXObject("Microsoft.XMLHTTP"); 
			
			oBao.open("POST","/etc/refresh",false); 
			oBao.send(); 
				
			var strResult = unescape(oBao.responseText); 
			var arrResult = strResult.split("###");
			for(var i=0;i<arrResult.length;i++) 
			{ 
				arrTmp = arrResult[i].split("@@@"); 
				num1 = arrTmp[0];
				num2 = arrTmp[1];
				num3 = arrTmp[2];					
			}		
			$("#top_user").html("환영합니다.<b> "+num1+" </b>님");				
			$("#top_va").html("("+num2+"/"+num3+")쪽지함");
		}
			
		function beginTimer() 
		{ 
			timer = window.setInterval("refreshContent()",1000*60); 	
		}
		</script>