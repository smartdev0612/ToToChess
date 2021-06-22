<?php
$TPL_categoryList_1=empty($TPL_VAR["categoryList"])||!is_array($TPL_VAR["categoryList"])?0:count($TPL_VAR["categoryList"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<script>document.title = '게임관리 - 사다리배팅현황';</script>
<script>
	function team_betting(url) {
		window.open(url,'','resizable=no width=520 height=240');
	}
</script>
</head>

<div class="wrap">
	<div id="route">
		<h5>게임관리 - 사다리배팅현황</h5>
	</div>
	<h3>사다리배팅현황</h3>	
	
	<div id="search">
		<form name=frmSrh method=post action="/game/gamelist_sadari">
			<input type="hidden" name="search" value="search">				
			<input type="hidden" name="type" value="<?php echo $TPL_VAR["type"]?>">
			<input type="hidden" name="category_name" value="">
			
			<div class="betList_option">
				
				<span>출력</span>
				<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<span class="icon">설정</span>
				<input type="radio" name="state" value=0 <?php if($TPL_VAR["state"]==0){?>checked<?php }?> class="radio">전체
				<input type="radio" name="state" value=1 <?php if($TPL_VAR["state"]==1){?>checked<?php }?> class="radio">종료
				<input type="radio" name="state" value=20 <?php if($TPL_VAR["state"]==20){?>checked<?php }?> onClick="submit()" class="radio">발매(배팅가능)
				<input type="radio" name="state" value=21 <?php if($TPL_VAR["state"]==21){?>checked<?php }?> onClick="submit()" class="radio">발매(배팅마감)
				<input type="radio" name="state" value=3 <?php if($TPL_VAR["state"]==3){?>checked<?php }?> class="radio">대기
				
				<!-- 기간 필터 -->
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				
				<!-- 검색버튼 -->
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</div>
		</form>
	</div>
	
	<form id="form1" name="form1" method="post" action="?">
  	<input type="hidden" name="act" value="delete">  	
		<table cellspacing="1" class="tableStyle_gameList" style="width:99%;">
			<legend class="blind">게임별 상세항목</legend>
			<thead>
				<tr>
					<th scope="col">번호</th>
					<th scope="col">진행상태</th>
					<th scope="col">경기일시</th>
					<th scope="col" colspan="2">홈</th>
					<th scope="col">VS</th>
					<th scope="col" colspan="2">어웨이</th>
					<th scope="col">스코어</th>
					<th scope="col">이긴 팀</th>
					<th scope="col">배팅수</th>
					<th scope="col">배팅금액현황</th>
				</tr>
			</thead>
			<tbody>
<?php
	if ( $TPL_list_1 ) {
		$forCnt = 0;
		foreach($TPL_VAR["list"] as $TPL_V1){
			if ( $forCnt == 3 ) {
				$forCnt = 0;
				echo "<tr colspan=\"30\" style=\"height:10px;\">&nbsp;</tr>";
			}
?>
<?php if(is_null($TPL_V1["kubun"])){?>
					<tr>	
<?php }elseif($TPL_V1["kubun"]==0){?>
 					<tr class="gameGoing">
<?php }elseif($TPL_V1["kubun"]==1){?>		
 					<tr class="gameEnd">	
<?php }?>
						<td>
<?php if($TPL_VAR["type"]==3){?>
								<input type='checkbox' name='intChildIdx' value='<?php echo $TPL_V1["child_sn"]?>'><font color=blue><?php echo $TPL_V1["child_sn"]?></font>
<?php }else{?>
								<font color='blue'><?php echo $TPL_V1["child_sn"]?></font>
<?php }?>
							
<?php if(is_null($TPL_V1["kubun"])){?>
								<input type='button' class='btnStyle_s' value='발매' onclick=open_window('/game/modifyStausProcess?mode=edit&idx=<?php echo $TPL_V1["child_sn"]?>&play=0','300','200')>
<?php }?>
						</td>
						<td>
<?php if(is_null($TPL_V1["kubun"])){?> <img src="/img/icon_gameStand.gif">
<?php 
			}elseif($TPL_V1["kubun"]==0){
				$gameDateTime = mktime($TPL_V1["gameHour"],$TPL_V1["gameTime"],0,substr($TPL_V1["gameDate"],5,2),substr($TPL_V1["gameDate"],8,2),substr($TPL_V1["gameDate"],0,4));
				if ( $gameDateTime > time() ) {
					echo "발매";
				} else {
					echo "마감";
				}
?>
<!--<img src="/img/icon_gameGoing.gif">-->
<?php }elseif($TPL_V1["kubun"]==1){?><img src="/img/icon_gameEnd.gif">
<?php }?>
						<!-- 12.10.29 "대기중" 게임일 때 <img src="/img/icon_gameStand.gif"> / "진행중" 게임일 때 <img src="/img/icon_gameGoing.gif"> / "완료" 게임일 때 <img src="/img/icon_gameEnd.gif"> -->
					</td>
						<td><?php if($TPL_V1["update_game_date"]){?><span style="color:red;"><?php }?><?php if($TPL_V1["update_enable"]==0){?><span style="border-bottom:1px solid red;"><?php }?><?php echo sprintf("%s %s:%s",substr($TPL_V1["gameDate"],5),$TPL_V1["gameHour"],$TPL_V1["gameTime"])?></td>
						<!--<td><?php echo $TPL_V1["regDate"]?></td>-->
						<td class="homeName">
							<a href=javascript:team_betting("/game/popup_gamedetail?child_sn=<?php echo $TPL_V1["child_sn"]?>"); style='cursor:hand' onmousemove="showpup('<?php echo $TPL_V1["home_team"]?>&nbsp;&nbsp;VS&nbsp;&nbsp;<?php echo $TPL_V1["away_team"]?>')" onmouseout='hidepup()'>
								<?php echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")?>

							</a>
						</td>
						<td>
<?php
	//-> home 배당 출력
	echo $TPL_V1["home_rate"];
	if ( $TPL_V1["home_rate"] != $TPL_V1["new_home_rate"] and strlen($TPL_V1["new_home_rate"]) > 0 ) { 
		echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_home_rate"]."</span>";
	}
?>
						</td>
						<td>vs</td>
						<td>
<?php
	//-> away 배당 출력
	echo $TPL_V1["away_rate"];
	if ( $TPL_V1["away_rate"] != $TPL_V1["new_away_rate"] and strlen($TPL_V1["new_away_rate"]) > 0 ) {
		echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_away_rate"]."</span>";
	}
?>
						</td>
						<td class="awayName">
							<a href=javascript:team_betting("/game/popup_gamedetail?child_sn=<?php echo $TPL_V1["child_sn"]?>"); style='cursor:hand' onmousemove="showpup('<?php echo $TPL_V1["home_team"]?>&nbsp;&nbsp;VS&nbsp;&nbsp;<?php echo $TPL_V1["away_team"]?>')" onmouseout='hidepup()'>
								<?php echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")?>
							</a>
						</td>
						<td><?php echo $TPL_V1["home_score"]?>:<?php echo $TPL_V1["away_score"]?></td>
						<td>
<?php if($TPL_V1["win"]==1){?> 홈승
<?php }elseif($TPL_V1["win"]==2){?> 원정승
<?php }elseif($TPL_V1["win"]==3){?> 무승부
<?php }elseif($TPL_V1["win"]==4){?> 취소/적특
<?php }else{?> -
<?php }?>
						</td>
						<td><?php echo $TPL_V1["betting_count"]?></td>
						<td style="border:1px solid #fff; background-color:#D5D5D5;">
<table width="100%">
	<tr>
		<td style="border:0px;font-weight:bold;color:#fff;font-size:20px;width:40px;<?php if($TPL_V1["league_sn"] == 571){echo "color:#fff;background-color:#003399;";} else {echo "color:#000;background-color:#D5D5D5;";}?>">
<?php
if ( $TPL_V1["league_sn"] == 571 ) echo "홀";
else if ( $TPL_V1["league_sn"] == 603 ) echo "좌";
else if ( $TPL_V1["league_sn"] == 604 ) echo "3줄";
?>
		</td>
		<td style="width:80px;background-color:#fff;border:0px;font-size:18px;"><?php echo number_format($TPL_V1["home_total_betting"])?></td>
		<td style="border:0px;font-weight:bold;font-size:20px;width:40px;<?php if($TPL_V1["league_sn"] == 571){echo "color:#fff;background-color:#A81919;";} else {echo "color:#000;background-color:#D5D5D5;";}?>">
<?php
if ( $TPL_V1["league_sn"] == 571 ) echo "짝";
else if ( $TPL_V1["league_sn"] == 603 ) echo "우";
else if ( $TPL_V1["league_sn"] == 604 ) echo "4줄";
?>
		</td>
		<td style="width:80px;background-color:#fff;border:0px;font-size:18px;"><?php echo number_format($TPL_V1["away_total_betting"])?></td>
		<td style="width:30px;background-color:#D5D5D5;border:0px;color:#000;">▶</td>
<?php
if ( $TPL_V1["league_sn"] == 571 ) {
	if ( $TPL_V1["home_total_betting"] > $TPL_V1["away_total_betting"] ) {
		echo "<td style=\"width:40px;font-weight:bold;border:0px;font-size:20px;color:#fff;background-color:#003399;\">홀";
	} else if ( $TPL_V1["home_total_betting"] < $TPL_V1["away_total_betting"] ) {
		echo "<td style=\"width:40px;font-weight:bold;border:0px;font-size:20px;color:#fff;background-color:#A81919;\">짝";
	} else {
		echo "<td style=\"width:40px;font-weight:bold;background-color:#fff;border:0px;font-size:20px;\">-";
	}
} else if ( $TPL_V1["league_sn"] == 603 ) {
	echo "<td style=\"width:40px;font-weight:bold;background-color:#fff;border:0px;font-size:20px;\">";
	if ( $TPL_V1["home_total_betting"] > $TPL_V1["away_total_betting"] ) {
		echo "좌";
	} else if ( $TPL_V1["home_total_betting"] < $TPL_V1["away_total_betting"] ) {
		echo "우";
	} else {
		echo "-";
	}
} else if ( $TPL_V1["league_sn"] == 604 ) {
	echo "<td style=\"width:40px;font-weight:bold;background-color:#fff;border:0px;font-size:20px;\">";
	if ( $TPL_V1["home_total_betting"] > $TPL_V1["away_total_betting"] ) {
		echo "3줄";
	} else if ( $TPL_V1["home_total_betting"] < $TPL_V1["away_total_betting"] ) {
		echo "4줄";
	} else {
		echo "-";
	}
}
?>
		</td>
		<td style="width:80px;background-color:#fff;border:0px;font-size:18px;">
<?php
	if ( $TPL_V1["home_total_betting"] > $TPL_V1["away_total_betting"] ) {
		echo number_format($TPL_V1["home_total_betting"] - $TPL_V1["away_total_betting"]);
	} else if ( $TPL_V1["home_total_betting"] < $TPL_V1["away_total_betting"] ) {
		echo number_format($TPL_V1["away_total_betting"] - $TPL_V1["home_total_betting"]);
	} else {
		echo "0";
	}
?>
		</td>
	</tr>
</table>
						</td>
					</tr>
<?php
		$forCnt++;
	}
}
?>
	  </table>
	  
	  <div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	
	</form>
</div>