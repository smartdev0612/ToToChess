<?php
	if($TPL_VAR["game_type"]=="multi") { $on_multi="_o";}
	if($TPL_VAR["game_type"]=="handi") { $on_handi="_o";}
	if($TPL_VAR["game_type"]=="special") { $on_special="_o";}
	if($TPL_VAR["game_type"]=="real") { $on_real="_o";}
	if($TPL_VAR["game_type"]=="sadari") { $on_sadari="_o";}
	if($TPL_VAR["game_type"]=="dari") { $on_dari="_o";}
	if($TPL_VAR["game_type"]=="race") { $on_race="_o";}
	if($TPL_VAR["game_type"]=="power") { $on_power="_o";}
    if($TPL_VAR["game_type"]=="vfootball") { $on_vfootball="_o";}

	$TPL_game_list_1 = empty($TPL_VAR["game_list"])||!is_array($TPL_VAR["game_list"])?0:count($TPL_VAR["game_list"]);
?>

<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="wed, 04 jul 1973 16:00:00 gmt">
<script>
	function onFilterChange() {
		document.frm.submit();
	}
	
	function doSubmit() {
		document.frm.submit();
	}
</script>

<?php if($TPL_VAR["special_type"]=="0"){?>
<style type="text/css">
	<!-- 
	#mmenu .mix a {background-position:0px -26px}
	-->
</style>
<?php }elseif($TPL_VAR["special_type"]=="1"){?>
<style type="text/css">
	<!-- 
	#mmenu .special a	{background-position:0px -26px}
	-->
</style>
<?php }elseif($TPL_VAR["special_type"]=="2"){?>
<style type="text/css">
	<!-- 
	#mmenu .live a {background-position:0px -26px}
	-->
</style>
<?php }elseif($TPL_VAR["special_type"]=="3"){?>
<style type="text/css">
	<!-- 
	#mmenu .ladder a {background-position:0px -26px}
	-->
</style>
<?php }?>
<!--
<div id="sub_menu">
	<ul>
		<li class="sub_menu_1<?php echo $on_multi?>"><a href="/game_list?game=multi" class="sub_menu_1<?php echo $on_multi?>_text">조합</a></li>
		<li class="sub_menu_1<?php echo $on_handi?>"><a href="/game_list?game=handi" class="sub_menu_1<?php echo $on_handi?>_text">핸디</a></li>
		<li class="sub_menu_1<?php echo $on_real?>"><a href="/game_list?game=real" class="sub_menu_1<?php echo $on_real?>_text">실시간</a></li>
        <li class="sub_menu_1<?php echo $on_vfootball?>"><a href="/game_list?game=vfootball" class="sub_menu_1<?php echo $on_power?>_text">가상축구</a></li>
		<li class="sub_menu_1<?php echo $on_sadari?>"><a href="/game_list?game=sadari" class="sub_menu_1<?php echo $on_sadari?>_text">사다리</a></li>
		<li class="sub_menu_1<?php echo $on_dari?>"><a href="/game_list?game=dari" class="sub_menu_1<?php echo $on_dari?>_text">다리다리</a></li>
		<li class="sub_menu_1<?php echo $on_race?>"><a href="/game_list?game=race" class="sub_menu_1<?php echo $on_race?>_text">달팽이</a></li>
		<li class="sub_menu_1<?php echo $on_power?>"><a href="/game_list?game=power" class="sub_menu_1<?php echo $on_power?>_text">파워볼</a></li>
	</ul>
</div>
-->
<div id="contents_video" style="height: 300px;">
    <div style="text-align: center;height: 270px;
    background-image: url(/images/ibet/mv_bg.png);
    background-repeat: no-repeat;
    background-position: 50% 0px;">
        <iframe width="414" height="290" src="bet365_soccer?src=bet365.com" name="ladder" id="ladder" frameborder="0" scrolling="no"></iframe>
    </div>
</div>

<!--배팅타입 공지 리스트-->
<?php
	if ( $TPL_game_list_1 ) {
		foreach ( $TPL_VAR["game_list"] as $TPL_V1 ) {
			$TPL_item_2 = empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);

			if ( $TPL_V1["notice_betting_count"] > 0 ) {
?>
<div class="league">
	<p class="league_text_3">★공지사항★</p>
</div>
<?php
				if ( $TPL_item_2 ) {
					foreach( $TPL_V1["item"] as $TPL_V2 ) {
						if ( $TPL_V2["bet_enable"] == 5 ) {
?>
<div class="game_data">
	<div class="day"><?php echo $TPL_V2["gameHour"]?>:<?php echo $TPL_V2["gameTime"]?></div>
	<div class="home_box">
		<span class="home g_notice_1"><?php echo $TPL_V2["home_team"]?></span>
	</div>
	<div class="odd_box">
		<span class="odd odd_n">VS</span>
	</div>
	<div class="away_box">
		<span class="away g_notice_1"><?php echo $TPL_V2["away_team"]?></span>
	</div>
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
<div class="league">
	<p class="league_text_4"><img src="<?php echo $TPL_V1["league_image"]?>" width="17" height="12" style="vertical-align:top;"> <?php echo $TPL_V1["league_name"]?></p>
</div>
<?php		
			}

			if ( $TPL_item_2 ) {
				foreach ( $TPL_V1["item"] as $TPL_V2 ) {
					if ( $TPL_V2["bet_enable"] == 1 ) {

						//-> 팀명 경기종류 적용
						if ( $TPL_V2["type"] == 4 ){
							$homeTeamNameAdd = "&nbsp;<span class=\"home_under_icon\">▲</span>";
							$awayTeamNameAdd = "<span class=\"away_over_icon\">▼</span>&nbsp;";
						} else if ( $TPL_V2["type"] == 2 ) {
							//$homeTeamNameAdd = "&nbsp;<font class=\"gameType\">[핸디캡]</font>";
							//$awayTeamNameAdd = "<font class=\"gameType\">[핸디캡]</font>&nbsp;";
							$homeTeamNameAdd = "";
							$awayTeamNameAdd = "";
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

						$homeName = $TPL_V2["home_team"];
                        if(strpos($homeName, '★ 3폴더 이상만') === false)
                        {
                            //appended in 20170516....
                            if(strpos($homeName, '★ 5폴더 이상만') === false)
                            {

                            }
                            else
                            {
                                $homeName = "★5폴더이상가능★";
                            }
                        }
                        else
                        {
                            $homeName = "★3폴더이상가능★";
                        }

						if ( $teamColor ) {


							$homeTeamName = $teamColor.$homeName.$homeTeamNameAdd."</span>";
							$awayTeamName = $teamColor.$awayTeamNameAdd.$TPL_V2["away_team"]."</span>";
						} else {
							$homeTeamName = $homeName.$homeTeamNameAdd;
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
<div class="game_data" name="<?php echo $TPL_V2["child_sn"]?>_div">
	<div class="day"><?php echo $TPL_V2["gameHour"]?>:<?php echo $TPL_V2["gameTime"]?></div>
	<div class="home_box">
		<span class="home" onclick="onTeamSelected('<?php echo $TPL_V2["child_sn"]?>','0',<?php echo $TPL_VAR["special_type"]?>);return false;">
			<span class="home_n" rel="teamH">&nbsp;
                <?php echo $homeTeamName; ?>
            </span><span class="home_odd_n" rel="rateH"><?php echo number_format($TPL_V2["home_rate"],2)?>&nbsp;</span><input type="checkbox" name="ch" value="3" style="display:none;">
		</span>
	</div>
<?php
	if ( ( $TPL_V2["type"] == 1 && $TPL_V2["draw_rate"] == "1.00" ) || ( $TPL_V2["type"] == 2 && $TPL_V2["draw_rate"] == "0" ) ) {
?>
	<div class="odd_box">
		<span class="odd odd_n" rel="rateO">VS</span><input type="checkbox" name="ch" value="3" style="display:none;">
	</div>
<?php
	} else {
?>
	<div class="odd_box">
		<span class="odd odd_n" rel="rateO" onclick="onTeamSelected('<?php echo $TPL_V2["child_sn"]?>','1',<?php echo $TPL_VAR["special_type"]?>);return false;"><?php echo $TPL_V2["draw_rate"]?></span>
				<input type="checkbox" name="ch" value="3" style="display:none;">
	</div>
<?php
	}
?>
	<div class="away_box">
		<span class="away" onclick="onTeamSelected('<?php echo $TPL_V2["child_sn"]?>','2',<?php echo $TPL_VAR["special_type"]?>);return false;">
			<span class="away_odd_n" rel="rateA">&nbsp;<?php echo number_format($TPL_V2["away_rate"],2)?></span><span class="away_n" rel="teamA"><?php echo $awayTeamName;?>&nbsp;</span>
			<input type="checkbox" name="ch" value="2" style="display:none;">
		</span>
	</div>
</div>
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
<div class="league">
	<p class="league_text_4"><img src="<?php echo $TPL_V1["league_image"]?>" width="17" height="12" style="vertical-align:top;"> <?php echo $TPL_V1["league_name"]?></p>
</div>
<?
			}
			
			if ( $TPL_item_2 ) {
				foreach ( $TPL_V1["item"] as $TPL_V2 ) {
					if ( $TPL_V2["bet_enable"] != 1 ) {
						//-> 팀명 경기종류 적용
						if ( $TPL_V2["type"] == 4 ){
							$homeTeamNameAdd = "&nbsp;▲";
							$awayTeamNameAdd = "▼&nbsp;";
						} else if ( $TPL_V2["type"] == 2 ) {
							$homeTeamNameAdd = "&nbsp;<font class=\"gameType\">[핸디캡]</font>";
							$awayTeamNameAdd = "<font class=\"gameType\">[핸디캡]</font>&nbsp;";
						} else {
							unset($homeTeamNameAdd);
							unset($awayTeamNameAdd);
						}

                        $homeName = $TPL_V2["home_team"];
                        if(strpos($homeName, '★ 3폴더 이상만') === false)
                        {
                            //appended in 20170516....
                            if(strpos($homeName, '★ 5폴더 이상만') === false)
                            {

                            }
                            else
                            {
                                $homeName = "★5폴더이상가능★";
                            }
                        }
                        else
                        {
                            $homeName = "★3폴더이상가능★";
                        }

						if ( $teamColor ) {
							$homeTeamName = $homeName.$homeTeamNameAdd;
							$awayTeamName = $awayTeamNameAdd.$TPL_V2["away_team"];
						} else {
							$homeTeamName = $homeName.$homeTeamNameAdd;
							$awayTeamName = $awayTeamNameAdd.$TPL_V2["away_team"];
						}
?>
<div class="game_data">
	<div class="day"><?php echo $TPL_V2["gameHour"]?>:<?php echo $TPL_V2["gameTime"]?></div>
	<div class="home_box">
		<span class="home">
			<span class="home_d"><?php echo $homeTeamName?></span><span class="home_odd_d"><?php echo number_format($TPL_V2["home_rate"],2)?>&nbsp;</span>
		</span>
	</div>
<?php
	if ( ( $TPL_V2["type"] == 1 && $TPL_V2["draw_rate"] == "1.00" ) || ( $TPL_V2["type"] == 2 && $TPL_V2["draw_rate"] == "0" ) ) {
?>
	<div class="odd_box">
		<span class="odd odd_d">VS</span>
	</div>
<?php
	} else {
?>
	<div class="odd_box">
		<span class="odd odd_d"><?php echo $TPL_V2["draw_rate"]?></span>
	</div>
<?php
	}
?>
	<div class="away_box">
		<span class="away">
			<span class=" away_odd_d">&nbsp;<?php echo number_format($TPL_V2["away_rate"],2)?></span><span class="away_d"><?php echo $awayTeamName?></span>
		</span>
	</div>
</div>
<?php
						} // if
					} // foreach
				} // if
			} // if
		} // foreach
	} // if
?>

<script type="text/javascript" src="/scripts/bet/sport.js?v=<?=time();?>"></script>
<script language=javascript>
	$(document).ready(function() {
		initialize(<?php echo $TPL_VAR["minBetCount"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus3"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus4"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus5"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus6"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus7"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus8"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus9"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus10"]?>,
			<?php echo $TPL_VAR["singleMaxBetMoney"]?>);
	});
				
	var VarMoney 		= '<?php echo $TPL_VAR["cash"]?>';
	var VarMinBet 		= '<?php echo $TPL_VAR["betMinMoney"]?>';
	var VarMaxBet 		= '<?php echo $TPL_VAR["betMaxMoney"]?>';
	var VarMaxAmount 	= '<?php echo $TPL_VAR["maxBonus"]?>';
	
  var bettingendtime =<?php echo $TPL_VAR["betEndTime"]?>;
  var bettingcanceltime =<?php echo $TPL_VAR["betCancelTime"]?>;
  var bettingcancelbeforetime =<?php echo $TPL_VAR["betCancelBeforeTime"]?>;
</script>