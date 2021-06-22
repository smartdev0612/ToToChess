<?php /* Template_ 2.2.3 2014/10/17 17:43:00 D:\www_one-23.com\vhost.manager\_template\content\game\bet_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '오버배팅현황';</script>
<script language="JavaScript">
	function on_change()
	{
		document.form3.submit();
	}
	function go_delete(url)
	{
		if(confirm("정말 삭제하시겠습니까?  "))
		{

			url = url + "&perpage=<?php echo $TPL_VAR["perpage"]?>&sel_result=<?php echo $TPL_VAR["sel_result"]?>&select_keyword=<?php echo $TPL_VAR["select_keyword"]?>&keyword=<?php echo $TPL_VAR["keyword"]?>&page=<?php echo $TPL_VAR["page"]?>&show_detail=<?php echo $TPL_VAR["show_detail"]?>";
			document.location = url;
		}
		else
		{
			return;
		}
	}
	
	function toggle(id)
	{
		$( "#"+id ).slideToggle(100);
	}	
	
	function betting_view(url)
	{
		var newwindow = window.open(url,'','width=900,height=300,left=50,scrollbars=yes');
	}
	
	function onKeywordChange(frm)
	{
		if(frm.select_keyword.value=='')
		{
			frm.keyword.value='';
			frm.submit();
		}
	}
	
	function onExceptionBetClick(sn)
	{
		if(confirm("[적특] 처리하시겠습니까?"))
		{
			document.location = "/game/exceptionBetProcess?sn="+sn;
		}
	}
</script>
</head>
<body>
<div class="wrap">
	<h3>오버배팅현황</h3>		
  <form id="form1" name="form1" method="post" action="?act=delete_user">
		<table border="0" cellspacing="1" class="tableStyle_gameList" summary="게임별 배팅현황">
		<thead>
			<tr>					
				<th>사이트</th>
				<th>배팅번호</th>
				<th>아이디</th>
				<th>닉네임</th>
				<th>게임</th>
				<th>배팅금액</th>
				<th>배당율</th>
				<th>예상배당</th>
				<th>게임결과</th>
				<th>당첨금액</th>					
				<th>배팅날짜</th>
				<th>총판</th>
				<th>배팅취소</th>
				<th>배팅IP</th>
			</tr>
		</thead>
		<tbody>
			<!-- 12.10.30 "종료" (list.blnGameEnd=="Y") 경우 tr class="gameEnd" / "진행중" 경우 tr class="gameGoing" -->
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
<?php if($TPL_V1["betting_cnt"]==1){?>
			<tr id="t_<?php echo $TPL_V1["betting_no"]?>" class="singleFolder" >
<?php }else{?>
<?php if($TPL_V1["result"]==0){?>
				<tr id="t_<?php echo $TPL_V1["betting_no"]?>" class="gameGoing" >
<?php }else{?>	
				<tr id="t_<?php echo $TPL_V1["betting_no"]?>" class="gameEnd" >
<?php }?>
<?php }?>
				<td><?php echo $TPL_V1["logo"];?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["betting_no"]?></td>			    
				<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,600)"><?php echo $TPL_V1["member"]["uid"]?></a></td>			
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["member"]["nick"]?></td>				    
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')">
					<!--<span>(<?php echo $TPL_V1["win_count"]?>/<?php echo $TPL_V1["betting_cnt"]?>)</span>-->
					<ul class="tablestyle_game">
<?php if(is_array($TPL_R2=$TPL_V1["item"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<li <?php if($TPL_V2["result"]==1||$TPL_V2["result"]==3||$TPL_V2["result"]==4){?>class="win"<?php }elseif($TPL_VAR["result"]==2){?>class="lose"<?php }?>><?php if($TPL_V2["game_type"]==1){?>1<?php }elseif($TPL_V2["game_type"]==2){?>2<?php }elseif($TPL_V2["game_type"]==4){?>3<?php }?></li>
<?php }}?>
					</ul>
				</td>
				<td <?php if( $TPL_V1["betting_money"] >= 300000 ) {?> style="background-color:#4374D9;color:#fff;" <?php } ?> onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format($TPL_V1["betting_money"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo sprintf("%3.2f",$TPL_V1["result_rate"]);?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format($TPL_V1["result_rate"]*$TPL_V1["betting_money"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')">
<?php if($TPL_V1["result"]==1){?><font color=red>적  중</font>
<?php }elseif($TPL_V1["result"]==2){?>실  패
<?php }elseif($TPL_V1["result"]==4){?>적  특
<?php }else{?>경기중
<?php }?>
				</td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format($TPL_V1["result_money"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["regDate"]?><?php echo $TPL_V1["regdate"]?></td> 
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["rec_id"]?><?php echo $TPL_V1["partner_id"]?></td>
				<td><input type="button" value="취소"  class="btnStyle3" onClick="go_delete('/game/betcancelProcess?betting_no=<?php echo $TPL_V1["betting_no"]?>&amp;result=<?php echo $TPL_V2["result"];?>&amp;oper=race&amp;check_date=<?php echo sprintf("%s %s:%s",$TPL_V1["item"][0]["gameDate"],$TPL_V1["item"][0]["gameHour"],$TPL_V1["item"][0]["gameTime"])?>')">
				<!--<td><input type="button" value="취소"  class="btnStyle3" onClick="go_delete('/game/betcancelProcess?betting_no=<?php echo $TPL_V1["betting_no"]?>&oper=race')"></td>-->
				<td><?php echo $TPL_V1["betting_ip"]?></td>
			</tr>
			
			<tr id="d_<?php echo $TPL_V1["betting_no"]?>" <?php if($TPL_VAR["show_detail"]==0){?>style="display:none;"<?php }?> class="gameDetail">
				<td colspan="14">
					<table cellspacing="1" id="d_<?php echo $TPL_V1["betting_no"]?>">
						<tr>				  
							<th>게임타입</th>
							<th>경기시간</th>
							<th>리그</th>
							<th colspan="2" >홈팀</th>
							<th>무</th>
							<th colspan="2">원정팀</th>
							<th>점수</th>
							<th>결과</th>
							<th>상태</th>
							<th>적특</th>
						</tr>
<?php if($TPL_item_2){foreach($TPL_V1["item"] as $TPL_V2){?>
							<tr bgcolor="#ede8e8" border=1>				
								<td width="60" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php if($TPL_V2["game_type"]==1){?>[승무패]
<?php }elseif($TPL_V2["game_type"]==2){?>[핸디캡]
<?php }elseif($TPL_V2["game_type"]==3){?>[홀짝]
<?php }elseif($TPL_V2["game_type"]==4){?>[오바언더]
<?php }?>
								</td>
								<td width="80" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["g_date"]?><?php echo sprintf("%s/ %s %s:%s",substr($TPL_V2["gameDate"],5,2),substr($TPL_V2["gameDate"],8,2),$TPL_V2["gameHour"],$TPL_V2["gameTime"])?></td>
								<td width="100" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["league_name"]?></td>
								<td width="100" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==1){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["home_team"]?></td>
								<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==1){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["home_rate"]?></td>
								<td width="60" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==3){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["draw_rate"]?></td>
								<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==2){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["away_rate"]?></td>
								<td width="100" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==2){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["away_team"]?></td>
								<td width="40" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["home_score"]?>:<?php echo $TPL_V2["away_score"]?></td>
								<td width="50" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php if($TPL_V2["win"]==1){?>[홈승]
<?php }elseif($TPL_V2["win"]==3){?>[무승부]
<?php }elseif($TPL_V2["win"]==2){?>[원정승]
<?php }elseif($TPL_V2["win"]==4){?>[취소]
<?php }else{?>[대기]
<?php }?>
								</td>
								<td width="65" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php if($TPL_V2["result"]==0){?><font color=#666666>경기중</font>
<?php }elseif($TPL_V2["result"]==1){?><font color=red>적중</font>
<?php }elseif($TPL_V2["result"]==2){?><font color=blue>낙첨</font>
<?php }elseif($TPL_V2["result"]==4){?><font color=green>취소</font>
<?php }?>
								</td>
								<td width="30">
<?php 
	if ( $TPL_V2["home_rate"] < 1.1 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1 ) {
?>
<span style="color:#D9418C;"><b>적특됨</b></span>
<?php
	} else {
?>
<input type="button" value="적특"  class="btnStyle3" onClick="onExceptionBetClick(<?php echo $TPL_V2["total_betting_sn"]?>);"></td>
<?php
	}
?>
							</tr>															
<?php }}?>
						</table>
				</td>
			</tr>
<?php }}?>	
		</tbody>
		</table>
		
			
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	</form>
</div>