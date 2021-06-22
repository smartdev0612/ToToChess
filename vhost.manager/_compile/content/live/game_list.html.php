<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '라이브-게임관리';</script>

<script>
	function on_account(detail_sn)
	{
		if(confirm("정산을 진행하시겠습니까?"))
		{
			$.ajax({
				type: "get",
				url:"/LiveGame/ajax_account_process?act=account&detail_sn="+detail_sn,
				dataType: "json",
				success : function(json) {
					if(json==null || json.length<=0) {
						location.href="/LiveGame/game_list";
						return true;
					}
					else if(json.result==-1) {
						alert("이미 정산처리되었습니다.");
					}
					else if(json.result==-2) {
						alert("결과가 입력되지 않았습니다.");
					}
					else if(json.result==1) {
						var text="";
						if(json.paused=='Y')
							text = "<input type='button' value='정지해제'  class='btnStyle3' onClick='on_unpause("+detail_sn+")'>";
						else if(json.state=='PLAY')
							text = "<input type='button' value='베팅정지'  class='btnStyle3' onClick='on_pause("+detail_sn+")'>";
						else if(json.state=='ACC')
							text = "<input type='button' value='정산취소'  class='btnStyle3' onClick='on_account_cancel("+detail_sn+")'>";
						else if(json.state=='FIN')
							text = "<input type='button' value='정산'  class='btnStyle3' onClick='on_account("+detail_sn+")'>";
							
						$("tr[name=tr_"+detail_sn+"] td:last-child").html(text);
					}
				}
			});
			
			//document.location = "/LiveGame/account_process?act=account&detail_sn="+detail_sn;
		}
	}
	
	function on_account_cancel(detail_sn)
	{
		if(confirm("정산취소를 진행하시겠습니까?"))
		{
			$.ajax({
				type: "get",
				url:"/LiveGame/ajax_account_process?act=account_cancel&detail_sn="+detail_sn,
				dataType: "json",
				success : function(json) {
					if(json==null || json.length<=0) {
						location.href="/LiveGame/game_list";
						return true;
					}
					else if(json.result==-1) {
						alert("상태값 오류입니다. !ACC.");
					}
					else if(json.result==1) {
						var text="";
						if(json.paused=='Y')
							text = "<input type='button' value='정지해제'  class='btnStyle3' onClick='on_unpause("+detail_sn+")'>";
						else if(json.state=='PLAY')
							text = "<input type='button' value='베팅정지'  class='btnStyle3' onClick='on_pause("+detail_sn+")'>";
						else if(json.state=='ACC')
							text = "<input type='button' value='정산취소'  class='btnStyle3' onClick='on_account_cancel("+detail_sn+")'>";
						else if(json.state=='FIN')
							text = "<input type='button' value='정산'  class='btnStyle3' onClick='on_account("+detail_sn+")'>";
							
						$("tr[name=tr_"+detail_sn+"] td:last-child").html(text);
					}
				}
			});
			//document.location = "/LiveGame/account_process?act=account_cancel&detail_sn="+detail_sn;
		}
	}
	
	function on_pause(detail_sn)
	{
		if(confirm("베팅 정지를 진행하시겠습니까?"))
		{
			document.location = "/LiveGame/account_process?act=pause&detail_sn="+detail_sn;
		}
	}
	
	function on_unpause(detail_sn)
	{
		if(confirm("베팅정지 해제를 진행하시겠습니까?"))
		{
			document.location = "/LiveGame/account_process?act=unpause&detail_sn="+detail_sn;
		}
	}
	
	function toggle(id)
	{
		$( "tr[name="+id+"]").slideToggle(100);
	}
	
	function on_delete(live_sn)
	{
		if(confirm("게임을 삭제하시겠습니까?"))
		{
			document.location = "/LiveGame/account_process?act=delete_live_game&live_sn="+live_sn;
		}
	}
	
</script>
</head>

<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 - 항목 보기</h5>
	</div>
	<h3>항목 보기</h3>
	
	<div id="search">
		<form name=frmSrh method=post action="/LiveGame/game_list">
			
			<div class="wrap_search">
				
				<!-- 기간 필터 -->
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				
				<!-- 팀검색, 리그검색 -->
				<select name="filter_type">
					<option value="filter_home_team" <?php if($TPL_VAR["filter_type"]=="home_team"){?> selected<?php }?>>홈팀</option>
					<option value="filter_away_team" <?php if($TPL_VAR["filter_type"]=="away_team"){?> selected<?php }?>>원정팀</option>
					<option value="filter_league" <?php if($TPL_VAR["filter_type"]=="league"){?> selected<?php }?>>리그명</option>
				</select>
				<input type=text" size=10 name="keyword" value="<?php echo $TPL_VAR["keyword"]?>" class="name">
				
				<!-- 검색버튼 -->
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
				
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 실행시간 : bets <font color='blue'><?php echo $TPL_VAR["daemon_state"]['main_bets_access_timer']?></font>, live <font color='blue'><?php echo $TPL_VAR["daemon_state"]['event_data_access_timer']?></font>
			</div>
		</form>
	</div>
	
	<form id="form1" name="form1" method="post" action="?">
  	<input type="hidden" name="act" value="delete">  	
		<table cellspacing="1" class="tableStyle_gameList">
			<legend class="blind">게임별 상세항목</legend>
			<thead>
				<tr>
					<th scope="col">번호</th>
					<th scope="col">게임수</th>
					<th scope="col">진행상태</th>
					<th scope="col">종목</th>
					<th scope="col">경기일시</th>
					<th scope="col">리그</th>
					<th scope="col">홈팀</th>
					<th scope="col">원정팀</th>
					<th scope="col">전반 스코어</th>
					<th scope="col">후반 스코어</th>
					<th scope="col">전후반 스코어</th>
					<th scope="col">배팅총액</th>
					<th scope="col">수익</th>
					<th scope="col">관리</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_detail_2=empty($TPL_V1["detail"])||!is_array($TPL_V1["detail"])?0:count($TPL_V1["detail"]);?>
 				<tr class=<?php if($TPL_V1["game_state"]=='FIN'){?>"gameEnd"<?php }else{?>"gameGoing"<?php }?> onclick="toggle('detail_<?php echo $TPL_V1["live_sn"]?>')">
					<td><font color='blue'><?php echo $TPL_V1["live_sn"]?></font></td>
					<td>+<?php echo count($TPL_V1["detail"])?></td>
					<td>
<?php if($TPL_V1["game_state"]=='READY'){?> 대기중
<?php }elseif($TPL_V1["game_state"]=='FH'){?> 전반전(경기중)
<?php }elseif($TPL_V1["game_state"]=='HT'){?> 하프타임(경기중)
<?php }elseif($TPL_V1["game_state"]=='SH'){?> 후반전(경기중)
<?php }elseif($TPL_V1["game_state"]=='FIN'){?> 경기종료
<?php }?>
					</td>
					<td><?php echo $TPL_V1["sport_name"]?></td>
					<td><?php echo $TPL_V1["start_time"]?></td>
					<td><?php echo $TPL_V1["league_name"]?></td>
					
					<td><?php echo mb_strimwidth($TPL_V1["home_team"],0,30,"..","utf-8")?></td>
					<td><?php echo mb_strimwidth($TPL_V1["away_team"],0,30,"..","utf-8")?></td>
					
					<td><?php if($TPL_V1["first_score"]== -1){?>-<?php }else{?> <?php echo $TPL_V1["first_score"]?><?php }?></td>
					<td><?php if($TPL_V1["second_score"]== -1){?>-<?php }else{?> <?php echo $TPL_V1["second_score"]?><?php }?></td>
					<td><?php if($TPL_V1["score"]== -1){?>-<?php }else{?> <?php echo $TPL_V1["score"]?><?php }?></td>
					<td><?php echo number_format($TPL_V1["total_betting_money"])?></td>
					<td>
<?php if($TPL_V1["total_betting_money"]-$TPL_V1["prize"]<0){?><font color='red'><?php echo number_format($TPL_V1["total_betting_money"]-$TPL_V1["prize"])?></font>
<?php }else{?><font color='blue'><?php echo number_format($TPL_V1["total_betting_money"]-$TPL_V1["prize"])?></font>
<?php }?>
					</td>
					<td>
<?php if($TPL_V1["game_state"]=="READY"){?>
						<input type="button" value="삭제"  class="btnStyle3" onClick="on_delete(<?php echo $TPL_V1["live_sn"]?>)">						
<?php }elseif($TPL_V1["first_score"]=='-1'||$TPL_V1["second_score"]=='-1'||$TPL_V1["game_state"]!='FIN'){?><input type="button" value="수동"  class="btnStyle3" onClick="open_window('/LiveGame/popup_manual_fin?live_sn=<?php echo $TPL_V1["live_sn"]?>','650','300')">
<?php }elseif($TPL_V1["account_count"]>0){?>미정산 +<?php echo $TPL_V1["account_count"]?>

<?php }else{?>-
<?php }?>
					</td>
				</tr>
				
<?php if($TPL_detail_2){foreach($TPL_V1["detail"] as $TPL_V2){
$TPL_total_3=empty($TPL_V2["total"])||!is_array($TPL_V2["total"])?0:count($TPL_V2["total"]);?>
				<tr class="gameDetail" name="detail_<?php echo $TPL_V1["live_sn"]?>" style="display:none;">
					<td colspan="14">
						<table cellspacing="1">
							<tr>
								<th scope="col">종류</th>
<?php if($TPL_total_3){foreach($TPL_V2["total"] as $TPL_K3=>$TPL_V3){?>
									<th><?php echo $TPL_K3?></th>
<?php }}?>
								<th scope="col">관리</th>
							</tr>
							
							<tr bgcolor="#ede8e8" name="tr_<?php echo $TPL_V2["live_detail_sn"]?>">
								<td width="120"><?php echo $TPL_V2["alias"]?></td>
<?php if($TPL_total_3){foreach($TPL_V2["total"] as $TPL_K3=>$TPL_V3){?>
								<td width="100/<?php echo $TPL_total_3?>%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["win_position"]==$TPL_K3){?>;background :#fff111<?php }?>">
<?php if($TPL_V3>0){?><a href="#" onclick="open_window('/LiveGame/popup_betting_list?detail_sn=<?php echo $TPL_V2["live_detail_sn"]?>&betting_position=<?php echo $TPL_K3?>','1024','600')"><?php echo number_format($TPL_V3)?></a><?php }else{?><?php echo number_format($TPL_V3)?><?php }?>
								</td>
<?php }}?>
								<!-- 마지막 td에 존재해야 한다. ajax에 의해 변경됨 -->
								<td width="60" >
<?php if($TPL_V2["paused"]=='Y'){?>
									<input type="button" value="정지해제"  class="btnStyle3" onClick="on_unpause(<?php echo $TPL_V2["live_detail_sn"]?>)">
<?php }elseif($TPL_V2["detail_state"]=='PLAY'){?>
									<input type="button" value="베팅정지"  class="btnStyle3" onClick="on_pause(<?php echo $TPL_V2["live_detail_sn"]?>)">
<?php }elseif($TPL_V2["detail_state"]=='ACC'){?>
									<input type="button" value="정산취소"  class="btnStyle3" onClick="on_account_cancel(<?php echo $TPL_V2["live_detail_sn"]?>)">
<?php }elseif($TPL_V2["detail_state"]=='FIN'){?>
									<input type="button" value="정산"  class="btnStyle3" onClick="on_account(<?php echo $TPL_V2["live_detail_sn"]?>)">
<?php }?>
								</td>
							</tr>															
						</table>
					</td>
				</tr>
<?php }}?>
<?php }}?>
	    	<tr>
	    		<td colspan="11">총합</td>
	    		<td><?php echo number_format($TPL_VAR["static"]["total_betting_money"],0)?></td>
	    		<td>
<?php if($TPL_VAR["static"]["total_betting_money"]-$TPL_VAR["static"]["total_prize"]<0){?><font color='red'><?php echo number_format($TPL_VAR["static"]["total_betting_money"]-$TPL_VAR["static"]["total_prize"])?></font>
<?php }else{?><font color='blue'><?php echo number_format($TPL_VAR["static"]["total_betting_money"]-$TPL_VAR["static"]["total_prize"])?></font>
<?php }?>
	    		</td>
	    		<td>-</td>
	    	</tr>
	  </table>
	  
	  <div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	
	</form>
</div>