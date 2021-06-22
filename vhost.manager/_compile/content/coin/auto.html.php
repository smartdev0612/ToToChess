<script language="JavaScript">
	window.onload = function ()
	{
		coin_listener();
		begin_coin_listener();
	}
	
	function begin_coin_listener()
	{
		window.setInterval('coin_listener()', 50000);
	}
			
	function coin_listener()
	{
		$.ajax({
			type: "POST",
			url:"/Coin/CoinListener",
			dataType:'json',
			success : function(result) {
				if ( result != "null" ) {
					on_ladder_listener(result);
				}
			}
		});
	}
	
	function on_coin_listener(result)
	{
		var mis_games = '';
		for(i=0; i<result.length-1; i++)
		{
			game = result[i]['home_team'].split(" ");
			mis_games += game[0]+"<br>";
		}
		
		game = result[result.length-1]['home_team'].split(" ");
		mis_games += "<font color='#CC3D3D'><b>"+game[0]+" [진행중...]</b></font>";
		$("#mis_games").html(mis_games);
	}
</script>
	
</head>
<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>동전 게임 진행현황</h1>
	</div>

	<table cellspacing="1" class="tableStyle_membersWrite" summary="사다리">
	<legend class="blind">동전 게임 진행현황</legend>
		<tr>
		  <th>마감 누락게임</th>
		  <td id='mis_games'>
		  </td>
		</tr>
	</table>
</div>

</body>
</html>