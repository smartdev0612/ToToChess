<?php
	$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);
	$TPL_league_list_1=empty($TPL_VAR["league_list"])||!is_array($TPL_VAR["league_list"])?0:count($TPL_VAR["league_list"]);
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<div id="contents_left" style="min-height:600px;">
	<div id="top_title">
		<div class="title_icon"><img src="/images/sub_menu_icon.png" alt=""/></div>
		<div class="title_text"><img src="/images/title_game_end.png" alt=""/></div>
	</div> <!--// title 종료-->

	<div class="game_end_sub_menu">
		<div class="game_end_sub_menu_1">
			<ul>
				<li style="margin:0 5px;"><a href="/race/game_result"><img src="/images/sub_menu_over_01.png" alt="승무패"/></a></li>
				<li style="margin:0 5px;"><a href="/race/game_result?view_type=1"><img src="/images/sub_menu_over_02.png" alt="핸디캡"/></a></li>
				<li style="margin:0 5px;"><a href="/race/game_result?view_type=2"><img src="/images/sub_menu_over_03.png" alt="스페셜"/></a></li>
				<li style="margin:0 5px;"><a href="/LiveGame/game_result"><img src="/images/sub_menu_04.png" alt="축구라이브"/></a></li>
				<!-- <li style="margin:0 5px;"><a href="#none"><img src="/images/sub_menu_over_05.png" alt="버추얼사커"/></a></li> -->
				<li style="margin:0 5px;"><a href="/race/game_result?view_type=4"><img src="/images/sub_menu_over_06.png" alt="사다리"/></a></li>
				<li style="margin:0 5px;"><a href="#none"><img src="/images/sub_menu_over_07.png" alt="달팽이"/></a></li>
				<!-- <li style="margin:0 5px;"><a href="#none"><img src="/images/sub_menu_over_08.png" alt="파워볼"/></a></li> -->
			</ul>
		</div>
	</div>

<?php
	if ( $TPL_list_1 ) {
		foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
?>
	<table class="tablestyle_gamelist" cellspacing="1" cellpadding="0" id="gameresult_live">
		<thead>
			<tr>
				<td class="league" colspan="4" style="height: 20px; padding: 4px 0 4px 0;"><span style="height: 15px; padding:9px  10px 9px 13px;"><img src="<?php echo $TPL_V1["league_image"]?>" style="vertical-align:middle"></span><span style="width: 830px; padding: 8px 0 10px 0; font-weight: bold; color: #dfdfdf;"><?php echo $TPL_V1["league_name"]?></td>
			</tr>
			<tr>
				<td class="data" colspan="4" style="height: 15px; padding:3px  10px 3px 13px;"><span class="date"><?php echo $TPL_V1["start_time"]?></span><b><?php echo $TPL_V1["home_team"]?> VS <?php echo $TPL_V1["away_team"]?></b><span class="score"><?php echo $TPL_V1["score"]?></span></td>
			</tr>
			<tr id="live_result_table">
				<td class="result_live_1">타입</td>
				<td class="result_live_2">게임구분</td>
				<td class="result_live_3">베팅구좌</td>
				<td class="result_live_4">결과</td>
			</tr>
		</thead>
		<tbody>
<?php
	if ( $TPL_V1["odd_count"] == 2 ) {
?>
		<tbody>
			<tr>
				<td class="icon" style="width:70px;">라이브</td>
				<td class="type"><?php echo $TPL_V1["template_alias"]?></td>
				<td class="livetable">
					<table width="100%" cellspacing="0" cellpadding="0" class="oddtable">
						<tr>
							<td class="<?php if($TPL_V1["win_position"]=='Even' or $TPL_V1["win_position"]=='Over'){?>odd win<?php }else{?>odd<?php }?>">
								<span class="name">
<?php
	if ( $TPL_V1["token_odds"][0][0] == 'Even' ) {
		echo "짝";
	} else if ( $TPL_V1["token_odds"][0][0] == 'Odd' ) {
		echo "홀";
	} else {
		echo $TPL_V1["token_odds"][0][0];
	}
?>
								</span>
							</td>
							<td class="<?php if($TPL_V1["win_position"]=='Odd' or $TPL_V1["win_position"]=='Under'){?>odd win<?php }else{?>odd<?php }?>">
								<span class="name">
<?php
	if ( $TPL_V1["token_odds"][1][0] == 'Even' ) {
		echo "짝";
	} else if ( $TPL_V1["token_odds"][1][0]=='Odd' ) {
		echo "홀";
	} else {
		echo $TPL_V1["token_odds"][1][0];
	}
?>
								</span>
							</td>
						</tr>
					</table>
				</td>
				<td class="result" style="width:70px;">
<?php
	if ( $TPL_V1["win_position"] == 'Even' ) {
		echo "<span class=\"win\">(짝)승</span>";
	} else if ( $TPL_V1["win_position"] == 'Odd' ) {
		echo "<span class=\"lose\">(홀)승</span>";
	} else if ( $TPL_V1["win_position"] == 'Under' ) {
		echo "<span class=\"win\">언더</span>";
	} else if ( $TPL_V1["win_position"] == 'Over' ) {
		echo "<span class=\"win\">오버</span>";
	}
?>
				</td>
			</tr>
			<tr><td colspan="4"style="height:13px; padding:0; background:#000;"></td></tr>			
<?php
	} else if ( $TPL_V1["odd_count"] == 3 ) {
?>	
			<tr>
				<td class="icon">라이브</td>
				<td class="type"><?php echo $TPL_V1["template_alias"]?></td>
				<td class="livetable">
					<table width="100%" cellspacing="0" cellpadding="0" class="normaltable">
						<tr>
							<td class="<?php if($TPL_V1["win_position"]=='1'){?>homelive win<?php }else{?>homelive<?php }?>">
								<span class="name">
<?php
	if ( $TPL_V1["token_odds"][0][0] == '1' ) {
		echo $TPL_V1["home_team"];
	} else {
		echo $TPL_V1["token_odds"][0][0];
	}
?>
								</span>
							</td>
							<td class="<?php if($TPL_V1["win_position"]=='X'){?>drawlive win<?php }else{?>drawlive<?php }?>">
								<span class="rate">
<?php
	if ( $TPL_V1["token_odds"][1][0] == 'X' ) {
		echo "무승부";
	} else {
		echo $TPL_V1["token_odds"][1][0];
	}
?>
								</span>
							</td>
							<td class="<?php if($TPL_V1["win_position"]=='2'){?>awaylive win<?php }else{?>awaylive<?php }?>">
								<span class="name">
<?php
	if ( $TPL_V1["token_odds"][2][0] == '2' ) {
		echo $TPL_V1["away_team"];
	} else {
		echo $TPL_V1["token_odds"][2][0];
	}
?>
								</span>
							</td>
						</tr>
					</table>
				</td>
			<td class="result">
<?php
	if ( $TPL_V1["win_position"] == '1' ) {
		echo "<span class=\"win\">홈승</span>";
	} else if ( $TPL_V1["win_position"] == 'X' ) {
		echo "<span class=\"draw\">무승부</span>";
	} else if ( $TPL_V1["win_position"] == '2' ) {
		echo "<span class=\"lose\">원정승</span>";
	} else if ( $TPL_V1["win_position"] == 'CANCEL' ) {
		echo "<span class=\"cancel\">적특</span>";
	} else {
		echo "진행중";
	}
?>
			</td>
		</tr>
		<tr><td colspan="4"style="height:13px; padding:0; background:#000;"></td></tr>											
<?php
	} else if ( $TPL_V1["odd_count"] == 26) {
?>
		<tr>
			<td class="icon">라이브</td>
			<td class="type"><?php echo $TPL_V1["template_alias"]?></td>
			<td class="livetable">
				<table width="100%" cellspacing="0" cellpadding="0" class="scoretable">
					<tr>
						<td class="<?php if($TPL_V1["win_position"]=='0-0'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][0][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='1-0'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][1][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='1-1'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][2][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='0-1'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][3][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='2-0'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][4][0]?></span></td>
					</tr>
					<tr>
						<td class="<?php if($TPL_V1["win_position"]=='2-1'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][5][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='2-2'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][6][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='1-2'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][7][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='0-2'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][8][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='3-0'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][9][0]?></span></td>
					</tr>
					<tr>
						<td class="<?php if($TPL_V1["win_position"]=='3-1'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][10][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='3-2'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][11][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='3-3'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][12][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='2-3'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][13][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='1-3'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][14][0]?></span></td>
					</tr>
					<tr>
						<td class="<?php if($TPL_V1["win_position"]=='0-3'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][15][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='4-0'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][16][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='4-1'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][17][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='4-2'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][18][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='4-3'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][19][0]?></span></td>
					</tr>
					<tr>
						<td class="<?php if($TPL_V1["win_position"]=='4-4'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][20][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='3-4'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][21][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='2-4'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][22][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='1-4'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][23][0]?></span></td>
						<td class="<?php if($TPL_V1["win_position"]=='0-4'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][24][0]?></span></td>
					</tr>
				</table>
			</td>
			<td class="result">
<?php
	if ( $TPL_V1["win_position"] == 'CANCEL' ) {
		echo "<span class=\"cancel\">적특</span>";
	} else if ( $TPL_V1["win_position"] == '-1' ) {
		echo "진행중";
	} else {
		echo "<span class=\"win\">".$TPL_V1["win_position"]."</span>";
	}
?>
			</td>
		</tr>
		<tr><td colspan="4"style="height:13px; padding:0; background:#000;"></td></tr>			
<?php
		}
	}
}
?>
		</tbody>
	</table>
		
	<div class="bbs_move_icon" style="margin-top:40px;">
		<?php echo $TPL_VAR["pagelist"]?>
	</div>

</div> <!-- contents_left -->