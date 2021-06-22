<?php 
	$TPL_league_keyword_list_1=empty($TPL_VAR["league_keyword_list"])||!is_array($TPL_VAR["league_keyword_list"])?0:count($TPL_VAR["league_keyword_list"]);
	$TPL_game_list_1=empty($TPL_VAR["game_list"])||!is_array($TPL_VAR["game_list"])?0:count($TPL_VAR["game_list"]);

$gameType = $TPL_VAR["game_type"];
$sportType = $TPL_VAR["sport_type"];
?>
<div id="contents_top">
    <div class="board_title"><?php echo $TPL_VAR["title"];?></div>
</div>

<div id="contents_video" style="height: 400px;">
    <div style="text-align: center;padding-top: 16px;height: 370px;
    background-image: url(/images/ibet/mv_bg.png);
    background-repeat: no-repeat;
    background-position: 50% 0px;">
        <iframe width="514" height="290" src="bet365_soccer?src=bet365.com" name="ladder" id="ladder" frameborder="0" scrolling="no" style="margin-top: 40px"></iframe>
    </div>
</div>

<div id="contents_left" style="/*min-height:600px;*/margin-top: 15px;width: 1150px;padding-bottom: 20px;">

<span id="tests"></span>
<!--배팅타입 공지 리스트-->
<?php
	if ( $TPL_game_list_1 ) {
		foreach ( $TPL_VAR["game_list"] as $TPL_V1 ) {
			$TPL_item_2 = empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);

			if ( $TPL_V1["notice_betting_count"] > 0 ) {
?>
	<div class="game_header">
		<div class="game_plag"><img src="<?php echo $TPL_V1["league_image"]?>" width="20" height="16"></div>
		<div class="gmae_league_1"><span class="game_league_text_1">[공지사항]</span> <span class="game_league_text_2">[필독]</span></div>
	</div>
<?php
				if ( $TPL_item_2 ) {
					foreach( $TPL_V1["item"] as $TPL_V2 ) {
						if ( $TPL_V2["bet_enable"] == 5 ) {
							//-> 팀명 스타일 적용 (관리자에서 설정된 값)
							switch ( $TPL_V1["view_style"] ) {
								case "0" :
									$teamColor = "<span style=\"color:#c4ff9c;\">";
								break;
								case "1" :
									$teamColor = "<span style=\"color:#feffb1;\">";
								break;
								case "2" :
									$teamColor = "<span style=\"color:#9cdbff;\">";
								break;
								case "5" :
									$teamColor = "<span style=\"color:#38f2f4;\">";
								break;
								case "50" :
									$teamColor = "<span style=\"color:#ffabab;\">";
								break;
								case "51" :
									$teamColor = "<span style=\"color:#ffd998;\">";
								break;
								case "52" :
									$teamColor = "<span style=\"color:#c7ff03;\">";
								break;
								case "53" :
									$teamColor = "<span style=\"color:#00ffb4;\">";
								break;
								case "54" :
									$teamColor = "<span style=\"color:#00a2ff;\">";
								break;
								case "55" :
									$teamColor = "<span style=\"color:#ffb9ee;\">";
								break;
								case "56" :
									$teamColor = "<span style=\"color:#cda1ff;\">";
								break;
								case "57" :
									$teamColor = "<span style=\"color:#ffffff;\">";
								break;
								default :
								$teamColor = "<span>";
							}

							$homeTeamName = $teamColor.$TPL_V2["home_team"]."</span>";
							$awayTeamName = $teamColor.$TPL_V2["away_team"]."</span>";
?>
	<div class="game_bet_data" name="<?php echo $TPL_V2["child_sn"]?>_tr">
		<ul>
			<li class="game_bet_time"><span class="game_bet_day_text_month"><?php if($TPL_V2["is_live"]==1){?><p class="liveicon"></p><?php }?><?php echo substr($TPL_V2["gameDate"],5,5)?> <?php echo $TPL_V2["week"]?></span>
				<span class="game_bet_day_text_time"> <?php echo $TPL_V2["gameHour"]?>:<?php echo $TPL_V2["gameTime"]?></span>
			</li>
			<li class="game_home_name_bg">
				<span class="game_home_name_notice"><?php echo $homeTeamName?></span>
				<span class="game_home_odd_notice">-</span>
			</li>
			<li class="game_tie_bg">
				<span class="game_tie_notice">-</span>
			</li>
			<li class="game_away_name_bg">
				<span class="game_away_odd_notice">-</span>
				<span class="game_away_name_notice"><?php echo $awayTeamName?></span>
			</li>
			<li class="game_bet_info_notice"><span style="color:#99caf0;"><b>공지</b></span></li>
		</ul>
	</div>
<?php
						} // if
					} // foreach
				} // if
			} // if
		} // foreach
	} // if
?>

<!--배팅가능 리스트-->
<?php 
	if ( $TPL_game_list_1 ) {
		foreach ( $TPL_VAR["game_list"] as $TPL_V1 ) {
			$TPL_item_2 = empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);
			if ( $TPL_V1["enable_betting_count"] > 0 ) {

			//-> 매칭리그명으로 리그명 묶기.
			if ( trim($TPL_V1["alias_name"]) != $save_alias_name or !trim($TPL_V1["alias_name"]) ) {
				if ( trim($TPL_V1["alias_name"]) ) {
					$TPL_V1["league_name"] = trim($TPL_V1["alias_name"]);			
				}
				$save_alias_name = trim($TPL_V1["alias_name"]);
?>
	<div class="game_header">
		<div class="game_plag"><img src="<?php echo $TPL_V1["league_image"]?>" width="20" height="16"></div>
		<div class="gmae_league_1"><span class="game_league_text_1"><?php echo $TPL_V1["league_name"]?></span></div>
	</div>
<?php		
			}

			if ( $TPL_item_2 ) {
				foreach ( $TPL_V1["item"] as $TPL_V2 ) {
					if ( $TPL_V2["bet_enable"] == 1 ) {

						//-> 팀명 경기종류 적용
						if ( $TPL_V2["type"] == 4 ){
							$homeTeamNameAdd = "&nbsp;<font class=\"gameType\">[오버]</font><span class=\"icon_up\">&nbsp;&nbsp;</span>";
							$awayTeamNameAdd = "<span class=\"icon_down\">&nbsp;&nbsp;</span><font color=\"#727171\">[언더]</font>&nbsp;";
						} else if ( $TPL_V2["type"] == 2 ) {
							//$homeTeamNameAdd = "&nbsp;<font class=\"gameType\">[핸디캡]</font>";
							//$awayTeamNameAdd = "<font class=\"gameType\">[핸디캡]</font>&nbsp;";
							unset($homeTeamNameAdd);
							unset($awayTeamNameAdd);
						} else {
							unset($homeTeamNameAdd);
							unset($awayTeamNameAdd);
						}

						//-> 팀명 스타일 적용 (관리자에서 설정된 값)
						switch ( $TPL_V1["view_style"] ) {
							case "0" :
								$teamColor = "<span style=\"color:#c4ff9c;\">";
							break;
							case "1" :
								$teamColor = "<span style=\"color:#feffb1;\">";
							break;
							case "2" :
								$teamColor = "<span style=\"color:#9cdbff;\">";
							break;
							case "5" :
								$teamColor = "<span style=\"color:#38f2f4;\">";
							break;
							case "50" :
								$teamColor = "<span style=\"color:#ffabab;\">";
							break;
							case "51" :
								$teamColor = "<span style=\"color:#ffd998;\">";
							break;
							case "52" :
								$teamColor = "<span style=\"color:#c7ff03;\">";
							break;
							case "53" :
								$teamColor = "<span style=\"color:#00ffb4;\">";
							break;
							case "54" :
								$teamColor = "<span style=\"color:#00a2ff;\">";
							break;
							case "55" :
								$teamColor = "<span style=\"color:#ffb9ee;\">";
							break;
							case "56" :
								$teamColor = "<span style=\"color:#cda1ff;\">";
							break;
							case "57" :
								$teamColor = "<span style=\"color:#ffffff;\">";
							break;
							default :
							$teamColor = "<span>";
						}

						if ( $teamColor ) {
							$homeTeamName = $teamColor.$TPL_V2["home_team"].$homeTeamNameAdd."</span>";
							$awayTeamName = $teamColor.$awayTeamNameAdd.$TPL_V2["away_team"]."</span>";
						} else {
							$homeTeamName = $TPL_V2["home_team"].$homeTeamNameAdd;
							$awayTeamName = $awayTeamNameAdd.$TPL_V2["away_team"];
						}
?>
	<form name="form_<?php echo $TPL_V2["child_sn"]?>" id="form_<?php echo $TPL_V2["child_sn"]?>">
	<div style="display:none">
		<input type="hidden" id="<?php echo $TPL_V2["child_sn"]?>_sport_name" value="<?php echo $TPL_V2["sport_name"]?>">
		<input type="hidden" id="<?php echo $TPL_V2["child_sn"]?>_game_type" value="<?php echo $TPL_V2["betting_type"]?>">
		<input type="hidden" id="<?php echo $TPL_V2["child_sn"]?>_sub_sn" 		value="<?php echo $TPL_V2["sub_child_sn"]?>">
		<input type="hidden" id="<?php echo $TPL_V2["child_sn"]?>_home_team" value="<?php echo trim($TPL_V2["home_team"])?>">
		<input type="hidden" id="<?php echo $TPL_V2["child_sn"]?>_home_rate" value="<?php echo $TPL_V2["home_rate"]?>">
		<input type="hidden" id="<?php echo $TPL_V2["child_sn"]?>_draw_rate" value="<?php echo $TPL_V2["draw_rate"]?>">
		<input type="hidden" id="<?php echo $TPL_V2["child_sn"]?>_away_team" value="<?php echo trim($TPL_V2["away_team"])?>">
		<input type="hidden" id="<?php echo $TPL_V2["child_sn"]?>_away_rate" value="<?php echo $TPL_V2["away_rate"]?>">
		<input type="hidden" id="<?php echo $TPL_V2["child_sn"]?>_is_specified_special" value="<?php echo $TPL_V2["is_specified_special"]?>">
	</div>
	<div class="game_bet_data" name="<?php echo $TPL_V2["child_sn"]?>_div">
		<ul>
			<li class="game_bet_time">
				<span class="game_bet_day_text_month"><?php if($TPL_V2["is_live"]==1){?><p class="liveicon"></p><?php }?><?php echo substr($TPL_V2["gameDate"],5,5)?> <?php echo $TPL_V2["week"]?></span>
				<span class="game_bet_day_text_time"> <?php echo $TPL_V2["gameHour"]?>:<?php echo $TPL_V2["gameTime"]?></span>
			</li>
			<li class="game_home_name_bg" onclick="onTeamSelected('<?php echo $TPL_V2["child_sn"]?>','0', <?php echo $TPL_VAR["special_type"]?>);return false;">
				<span class="game_home_name"><?php echo $homeTeamName;?></span>
				<span class="game_home_odd"><?php echo number_format($TPL_V2["home_rate"],2)?></span>
				<input type="checkbox" name="ch" value="1" style="display:none;">
			</li>
<?php
	if ( ( $TPL_V2["type"] == 1 && $TPL_V2["draw_rate"] == "1.00" ) || ( $TPL_V2["type"] == 2 && $TPL_V2["draw_rate"] == "0" ) ) {
?>
			<li class="game_tie_bg_vs">
				<span class="game_tie">VS</span>
				<input type="checkbox" name="ch" value="3" style="display:none;">
			</li>
<?php
	} else {
?>
			<li <?php if($TPL_V2["type"]>1){?>class="game_tie_bg_vs"<?php }else{?>class="game_tie_bg" onclick="onTeamSelected('<?php echo $TPL_V2["child_sn"]?>','1', <?php echo $TPL_VAR["special_type"]?>);return false;"<?php }?>>
				<span class="game_tie">
<?php 
	if ( $TPL_V2["type"] == 1 ) echo sprintf("%2.2f",$TPL_V2["draw_rate"]);
	else echo $TPL_V2["draw_rate"]+0;
?>
				</span>
				<input type="checkbox" name="ch" value="3" style="display:none;">
			</li>
<?php
	}
?>
			<li class="game_away_name_bg" onclick="onTeamSelected('<?php echo $TPL_V2["child_sn"]?>','2', <?php echo $TPL_VAR["special_type"]?>);return false;">
				<span class="game_away_odd"><?php echo number_format($TPL_V2["away_rate"],2)?></span>
				<span class="game_away_name"><?php echo $awayTeamName;?></span>
				<input type="checkbox" name="ch" value="2" style="display:none;">
			</li>
			<li class="game_bet_info_betting" style="width:38px;">베팅</li>
		</ul>
	</div> <!--//game_bet_data 종료-->
	</form>
<?php
						} // if
					} // foreach
				} // if
			} // if
		} // foreach
	} // if
?>


<!--배팅불가능 리스트 -->
<?php 
	if ( $TPL_game_list_1 ) {
		foreach ( $TPL_VAR["game_list"] as $TPL_V1 ) {
			$TPL_item_2 = empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);
			if ( $TPL_V1["disable_betting_count"] > 0 ) {

				//-> 매칭리그명으로 리그명 묶기.
				if ( trim($TPL_V1["alias_name"]) != $save_alias_name or !trim($TPL_V1["alias_name"]) ) {
					if ( trim($TPL_V1["alias_name"]) ) {
						$TPL_V1["league_name"] = trim($TPL_V1["alias_name"]);
					}
					$save_alias_name = trim($TPL_V1["alias_name"]);
?>
	<div class="game_header">
		<div class="game_plag"><img src="<?php echo $TPL_V1["league_image"]?>" width="20" height="16"></div>
		<div class="gmae_league_1"><span class="game_league_text_1"><?php echo $TPL_V1["league_name"]?></span></div>
	</div>
<?
			}
			
			if ( $TPL_item_2 ) {
				foreach ( $TPL_V1["item"] as $TPL_V2 ) {
					if ( $TPL_V2["bet_enable"] != 1 ) {
?>
	<div class="game_bet_data">
		<ul>
			<li class="game_bet_time">
				<span class="game_bet_day_text_month" style="color:#7a7979;"><?php if($TPL_V2["is_live"]==1){?><p class="liveicon"></p><?php }?><?php echo substr($TPL_V2["gameDate"],5,5)?> <?php echo $TPL_V2["week"]?></span>
				<span class="game_bet_day_text_time" style="color:#7a7979; font-weight:bold;"> <?php echo $TPL_V2["gameHour"]?>:<?php echo $TPL_V2["gameTime"]?></span>
			</li>
			<li class="game_home_name_bg_end">
				<span class="game_home_name_end"><?php echo $TPL_V2["home_team"]?><?php if($TPL_V2["type"]==4){?>&nbsp;[오버]<span class="icon_up">&nbsp;&nbsp;</span><?php }?></span>
				<span class="game_home_odd_end"><?php echo number_format($TPL_V2["home_rate"],2)?></span>
			</li>
<?php
	if ( ( $TPL_V2["type"] == 1 && $TPL_V2["draw_rate"] == "1.00" ) || ( $TPL_V2["type"] == 2 && $TPL_V2["draw_rate"] == "0" ) ) {
?>
			<li class="game_tie_bg_end">
				<span class="game_tie_end">VS</span>
			</li>
<?php
	} else {
?>
			<li class="game_tie_bg_end">
				<span class="game_tie_end">
<?php 
	if ( $TPL_V2["type"] == 1 ) echo sprintf("%2.2f",$TPL_V2["draw_rate"]);
	else echo $TPL_V2["draw_rate"]+0;
?>
				</span>
			</li>
<?php
	}
?>
			<li class="game_away_name_bg_end">
				<span class="game_away_odd_end"><?php echo number_format($TPL_V2["away_rate"],2)?></span>
				<span class="game_away_name_end"><?php if($TPL_V2["type"]==4){?><span class="icon_down">&nbsp;&nbsp;</span>[언더]&nbsp;<?php }?><?php echo $TPL_V2["away_team"]?></span>
			</li>
			<li class="game_bet_info_betting_end">마감</li>
		</ul>
	</div> <!--//game_bet_data 종료-->
<?php
						} // if
					} // foreach
				} // if
			} // if
		} // foreach
	} // if
?>
</div> <!-- contents_left -->

<?php
	if ( count($TPL_VAR["popup_list"]) > 0 ) {
		foreach ( $TPL_VAR["popup_list"] as $TPL_V1 ) {
			$checkCookie = "popup_".$TPL_V1["IDX"];
			if ( !$_COOKIE[$checkCookie] ) {
?>
<div id="<?php echo $checkCookie?>" style="position:absolute; top:<?php echo $TPL_V1["P_WIN_TOP"]?>px; left:<?php echo $TPL_V1["P_WIN_LEFT"]?>px; width:<?php echo $TPL_V1["P_WIN_WIDTH"]?>px; height:<?php echo $TPL_V1["P_WIN_HEIGHT"]?>px; z-index:100000; background-color: #000000; background-image: url('<?php echo $TPL_V1["P_FILE"];?>'); background-repeat: no-repeat; background-position: center center; padding:10px 10px 20px 10px;">
	<div style="height:<?php echo $TPL_V1["P_WIN_HEIGHT"]-10?>px;">
		 <?php echo $TPL_V1["P_CONTENT"]?><br>
	</div>
	<div style="text-align:right; font-size:12px;">
		<input type="checkbox" name="popupCookie" onclick="setCookie('popup_'+<?php echo $TPL_V1["IDX"]?>,'done',1); jq$('#<?php echo $checkCookie?>').hide();">
			하루 동안 이 팝업을 보이지 않음. &nbsp;&nbsp;
		<a href="#" onClick="jq$('#<?php echo $checkCookie?>').hide();"><span>[닫기]</span></a>
	</div>
</div>
<?php
			}
		}
	}
?>

<script language="javascript">
	initialize(<?php echo $TPL_VAR["minBetCount"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus3"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus4"]?>,
							<?php echo $TPL_VAR["folderBonus"]["bonus5"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus6"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus7"]?>,
							<?php echo $TPL_VAR["folderBonus"]["bonus8"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus9"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus10"]?>,
							<?php echo $TPL_VAR["singleMaxBetMoney"]?>);
				
	var VarMoney = '<?php echo $TPL_VAR["cash"]?>';
	var VarMinBet = '<?php echo $TPL_VAR["betMinMoney"]?>';
	var VarMaxBet = '<?php echo $TPL_VAR["betMaxMoney"]?>';
	var VarMaxAmount = '<?php echo $TPL_VAR["maxBonus"]?>';

	var Bet_Rule = '<?php echo $TPL_VAR["rule"]?>';
	var Bet_Rule_vh = '<?php echo $TPL_VAR["vh"]?>';
	var Bet_Rule_vu = '<?php echo $TPL_VAR["vu"]?>';
	var Bet_Rule_hu = '<?php echo $TPL_VAR["hu"]?>';
	
  var bettingendtime =<?php echo $TPL_VAR["betEndTime"]?>;
  var bettingcanceltime =<?php echo $TPL_VAR["betCancelTime"]?>;
  var bettingcancelbeforetime =<?php echo $TPL_VAR["betCancelBeforeTime"]?>;
</script>