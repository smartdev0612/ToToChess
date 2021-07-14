<?php /* Template_ 2.2.3 2014/02/27 03:20:08 D:\www_one-23.com\vhost.partner\_template\header\header.html */?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title> 총판 관리 시스템</title>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta http-equiv="imagetoolbar" content="no">
		<link rel="shortcut icon" href="/img/favicon.ico">
		<link rel="stylesheet" href="/css/default.css" type="text/css">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		
		<script src="/js/selectAll.js"></script>
		<script src="/js/js.js"></script>
		<!--<script src="/js/Basic.js" defer="defer"></script>-->
		<script src="/js/is_show.js"></script>
		<script src="/js/lendar.js?v=<?=time();?>"></script>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="/js/jBeep/jBeep.min.js"></script>

		<script language="JavaScript">
			$(document).ready(function(){
				var refresh = setInterval(refreshAction, 5000);
			});

			function refreshAction() {
				$.ajax("/etc/refresh")
					.done(function(response) {
						var arrResult = response.split("@@@"); 
						num1 = arrResult[0];
						num2 = arrResult[1];
						num3 = arrResult[2];
						$("#memoCnt").text(num2);
						if(parseInt(num2) > 0)
							try { jBeep('/snd/msg_recv_alarm.mp3'); } catch(e) {};
					});
			}
		</script>