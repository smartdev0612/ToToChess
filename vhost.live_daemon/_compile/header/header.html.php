<?php /* Template_ 2.2.3 2014/06/20 01:57:22 D:\www_one-23.com\vhost.live_daemon\_template\header\header.html */?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>라이브 데몬</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="keywords" content="">
		<meta http-equiv="imagetoolbar" content="no">
		<script src="/js/selectAll.js"></script>
		<script src="/js/js.js"></script>
		<script src="/js/is_show.js"></script>
		<script src="/js/lendar.js"></script>
		<script src="/js/common.js"></script>
		<script src="/js/jBeep.min.js" type="text/javascript"></script>
		<script src="/js/jquery-1.7.1.min.js"></script>
		
		<script language="javascript">
			function begin_live_listener()
			{ 
				live_event_listener();
				live_event_main_bets_listener();
				timer = window.setInterval("live_event_listener()",5000);
				main_bets_timer = window.setInterval("live_event_main_bets_listener()",15000);
			}
			
			function live_event_listener()
			{
				$.ajax({
					type: "POST",
					url:"/LiveGame/live_game_listener",
					dataType: "html",
					data : "",
					success : function(html) {
					}
				});
			}
			
			function live_event_main_bets_listener()
			{
				$.ajax({
					type: "POST",
					url:"/LiveGame/live_main_bets_listener",
					dataType: "html",
					data : "",
					success : function(html) {
						//alert(html);
					}
				});
			}
	</script>