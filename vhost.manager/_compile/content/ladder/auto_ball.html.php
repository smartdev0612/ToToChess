<script language="JavaScript">
	window.onload = function ()
	{
		ladder_listener_ball();
		begin_ladder_listener_ball();
	}
	
	function begin_ladder_listener_ball()
	{
		window.setInterval('ladder_listener_ball()', 30000);
	}
			
	function ladder_listener_ball()
	{
		$.ajax({
			type: "POST",
			url:"/LadderBall/ladderBallListener",
			dataType:'json',
			success : function(result) {
				if ( result != "null" ) {
					on_ladder_listener_ball(result);
				}
			}
		});
	}
	
	function on_ladder_listener_ball(result)
	{
		var mis_games = $("#mis_games").html();
		for(i=0; i<result.length; i++)
		{
			mis_games += result[i].gameNo+"회차 완료.<br>";
		}
		$("#mis_games").html(mis_games);
	}
</script>
	
</head>
<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>파워볼 게임 정산현황</h1>
	</div>

	<table cellspacing="1" class="tableStyle_membersWrite" summary="파워볼">
	<legend class="blind">파워볼 게임 진행현황</legend>
		<tr>
		  <th>정산 회차</th>
		  <td id='mis_games'>
		  </td>
		</tr>
	</table>
</div>
</body>
</html>