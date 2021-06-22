<?php
    if($TPL_VAR["game_type"]=="multi") { $on_multi="_o";}
    if($TPL_VAR["game_type"]=="handi") { $on_handi="_o";}
    if($TPL_VAR["game_type"]=="special") { $on_special="_o";}
    if($TPL_VAR["game_type"]=="real") { $on_real="_o";}
    if($TPL_VAR["game_type"]=="sadari") { $on_sadari="_o";}
    if($TPL_VAR["game_type"]=="dari") { $on_dari="_o";}
    if($TPL_VAR["game_type"]=="race") { $on_race="_o";}
    if($TPL_VAR["game_type"]=="power") { $on_power="_o";}
    if($TPL_VAR["game_type"]=="aladin") { $on_aladin="_o";}
    if($TPL_VAR["game_type"]=="lowhi") { $on_lowhi="_o";}
    if($TPL_VAR["game_type"]=="mgmoddeven") { $on_mgmoddeven="_o";}
    if($TPL_VAR["game_type"]=="mgmbacara") { $on_mgmbacara="_o";}
    if($TPL_VAR["game_type"]=="vfootball") { $on_vfootball="_o";}

	$TPL_game_list_1 = empty($TPL_VAR["game_list"])||!is_array($TPL_VAR["game_list"])?0:count($TPL_VAR["game_list"]);
    $gameType = $TPL_VAR["game_type"];
    $sportType = $TPL_VAR["sport_type"];
    $sport_setting = $TPL_VAR["sport_setting"];
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
<div id="sub_menu" style="height:auto; margin-bottom:0px;">
    <ul>
        <li class="sub_menu_1<?php echo $on_multi?>"><a href="/game_list?game=multi" class="sub_menu_1<?php echo $on_multi?>_text">조합</a></li>
        <li class="sub_menu_1<?php echo $on_special?>"><a href="/game_list?game=special" class="sub_menu_1<?php echo $on_handi?>_text">스페셜</a></li>
        <li class="sub_menu_1<?php echo $on_real?>"><a href="/game_list?game=real" class="sub_menu_1<?php echo $on_real?>_text">실시간</a></li>
        <li class="sub_menu_1<?php echo $on_vfootball?>"><a href="/game_list?game=vfootball" class="sub_menu_1<?php echo $on_power?>_text">가상축구</a></li>
        <li class="sub_menu_1<?php echo $on_sadari?>"><a href="/game_list?game=sadari" class="sub_menu_1<?php echo $on_sadari?>_text">사다리</a></li>
        <li class="sub_menu_1<?php echo $on_dari?>"><a href="/game_list?game=dari" class="sub_menu_1<?php echo $on_dari?>_text">다리다리</a></li>
        <li class="sub_menu_1<?php echo $on_race?>"><a href="/game_list?game=race" class="sub_menu_1<?php echo $on_race?>_text">달팽이</a></li>
        <li class="sub_menu_1<?php echo $on_power?>"><a href="/game_list?game=power" class="sub_menu_1<?php echo $on_power?>_text">파워볼</a></li>
    </ul>
    <ul>
        <li class="sub_menu_1<?php echo $on_aladin?>"><a href="/game_list?game=aladin" class="sub_menu_1<?php echo $on_aladin?>_text">알라딘사다리</a></li>
        <li class="sub_menu_1<?php echo $on_lowhi?>"><a href="/game_list?game=lowhi" class="sub_menu_1<?php echo $on_lowhi?>_text">로하이</a></li>
        <li class="sub_menu_1<?php echo $on_mgmoddeven?>"><a href="/game_list?game=mgmoddeven" class="sub_menu_1<?php echo $on_mgmoddeven?>_text">알라딘사다리</a></li>
        <li class="sub_menu_1<?php echo $on_mgmbacara?>"><a href="/game_list?game=mgmbacara" class="sub_menu_1<?php echo $on_mgmbacara?>_text">로하이</a></li>
    </ul>
</div>
-->
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
							$homeTeamNameAdd = "&nbsp;<font color='#adff2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#adff2f'>[H]</font>&nbsp;";
							//$homeTeamNameAdd = "";
							//$awayTeamNameAdd = "";
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
							//$awayTeamName = $teamColor.$awayTeamNameAdd.$TPL_V2["away_team"]."</span>";
                            $awayTeamName = $awayTeamNameAdd.$TPL_V2["away_team"];
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
if ( strlen(trim($homeTeamName)) != strlen(str_replace("보너스","",trim($homeTeamName))) ) {
    ?>
    <div class="odd_box">
        <span class="odd odd_d">VS</span>
    </div>
    <div class="away_box">
		<span class="away">
			<span class=" away_odd_d">&nbsp;<?php echo number_format($TPL_V2["away_rate"],2)?></span><span class="away_d"><?php echo $awayTeamName?></span>
		</span>
    </div>
<?php
} else {
    if (($TPL_V2["type"] == 1 && $TPL_V2["draw_rate"] == "1.00") || ($TPL_V2["type"] == 2 && $TPL_V2["draw_rate"] == "0")) {
        ?>
        <div class="odd_box">
            <span class="odd odd_n" rel="rateO">VS</span><input type="checkbox" name="ch" value="3"
                                                                style="display:none;">
        </div>
        <?php
    } else {
        ?>
        <div class="odd_box">
            <span class="odd odd_n" rel="rateO"
                  onclick="onTeamSelected('<?php echo $TPL_V2["child_sn"] ?>','1',<?php echo $TPL_VAR["special_type"] ?>);return false;"><?php echo $TPL_V2["draw_rate"] ?></span>
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
    <?php }?>
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
							$homeTeamNameAdd = "&nbsp;<font color='#adff2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#adff2f'>[H]</font>&nbsp;";
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
    var game_kind = "<?php echo $gameType?>";

    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }

    /*
     * $game_index 	: game identify id
     * $index		: checkbox index-start from 0
    */
    function onTeamSelected($game_index, $index, $special_type)
    {
        //-> 글로벌 페이지 타입 저장.
        page_special_type = $special_type;

        $sport_name = $("#"+$game_index+"_sport_name").val();
        $game_type 	= $("#"+$game_index+"_game_type").val();
        $home_team 	= $("#"+$game_index+"_home_team").val();
        $home_rate 	= $("#"+$game_index+"_home_rate").val();
        $draw_rate 	= $("#"+$game_index+"_draw_rate").val();
        $away_team 	= $("#"+$game_index+"_away_team").val();
        $away_rate 	= $("#"+$game_index+"_away_rate").val();
        $sub_sn 	= $("#"+$game_index+"_sub_sn").val();
        $game_date 	= $("#"+$game_index+"_game_date").val();
        $league_sn = $("#"+$game_index+"_league_sn").val();
        $is_specified_special = $("#"+$game_index+"_is_specified_special").val();

        if($index<0 || $index>2)
            return;

        if($index==1 && ($draw_rate=='1' || $draw_rate=='1.0' || $draw_rate=='1.00' || $draw_rate=='VS'))
            return;

        //-> 보너스 선택시 (2폴더 이상시만 가능)
        if ( $home_team.indexOf("보너스") > -1 ) {
            if(folder_bonus($home_team) =="0"){
                return;
            }
        }

        if($game_type!=1 && $game_type!=2 && $game_type!=4)
        {
            alert("올바른 배팅이 아닙니다.");
            return;
        }

        $sport_array = ["축구", "야구", "농구", "배구", "하키"];

        <?php
        $kind = '';
        if($gameType == 'multi')
        {
            $kind = 'cross';
        } else if($gameType == 'handi') {
            $kind = 'handi';
        } else if($gameType == 'special') {
            $kind = 'special';
        } else if($gameType == 'real') {
            $kind = 'real';
        }
        ?>

        if( (<?=$sport_setting[$kind.'_soccer_wl_over']?> == 1 && $sport_name == '축구') ||
            (<?=$sport_setting[$kind.'_baseball_wl_over']?> == 1 && $sport_name == '야구') ||
            (<?=$sport_setting[$kind.'_basketball_wl_over']?> == 1 && $sport_name == '농구') ||
            (<?=$sport_setting[$kind.'_volleyball_wl_over']?> == 1 && $sport_name == '배구') ||
            (<?=$sport_setting[$kind.'_hockey_wl_over']?> == 1 && $sport_name == '하키') ||
            (<?=$sport_setting[$kind.'_etc_wl_over']?> == 1 && inArray($sport_name, $sport_array) == false)
        )
        {
            if(!CheckRule_wl_over($game_index, $index, $game_type, $home_team, $away_team))
            {
                alert("동일경기("+$sport_name+") [승패]+[오버] 조합은 배팅 불가능합니다.");
                return;
            }
        }

        if( (<?=$sport_setting[$kind.'_soccer_wl_under']?> == 1 && $sport_name == '축구') ||
            (<?=$sport_setting[$kind.'_baseball_wl_under']?> == 1 && $sport_name == '야구') ||
            (<?=$sport_setting[$kind.'_basketball_wl_under']?> == 1 && $sport_name == '농구') ||
            (<?=$sport_setting[$kind.'_volleyball_wl_under']?> == 1 && $sport_name == '배구') ||
            (<?=$sport_setting[$kind.'_hockey_wl_under']?> == 1 && $sport_name == '하키') ||
            (<?=$sport_setting[$kind.'_etc_wl_under']?> == 1 && inArray($sport_name, $sport_array) == false)
        )
        {
            if (!CheckRule_wl_under($game_index, $index, $game_type, $home_team, $away_team)) {
                alert("동일경기("+$sport_name+") [승패]+[언더]  조합은 배팅 불가능합니다.");
                return;
            }
        }

        if( (<?=$sport_setting[$kind.'_soccer_d_over']?> == 1 && $sport_name == '축구') ||
            (<?=$sport_setting[$kind.'_baseball_d_over']?> == 1 && $sport_name == '야구') ||
            (<?=$sport_setting[$kind.'_basketball_d_over']?> == 1 && $sport_name == '농구') ||
            (<?=$sport_setting[$kind.'_volleyball_d_over']?> == 1 && $sport_name == '배구') ||
            (<?=$sport_setting[$kind.'_hockey_d_over']?> == 1 && $sport_name == '하키') ||
            (<?=$sport_setting[$kind.'_etc_d_over']?> == 1 && inArray($sport_name, $sport_array) == false)
        )
        {
            if (!CheckRule_d_over($game_index, $index, $game_type, $home_team, $away_team)) {
                alert("동일경기("+$sport_name+") [무]+[오버]  조합은 배팅 불가능합니다.");
                return;
            }
	    }

        if( (<?=$sport_setting[$kind.'_soccer_d_under']?> == 1 && $sport_name == '축구') ||
            (<?=$sport_setting[$kind.'_baseball_d_under']?> == 1 && $sport_name == '야구') ||
            (<?=$sport_setting[$kind.'_basketball_d_under']?> == 1 && $sport_name == '농구') ||
            (<?=$sport_setting[$kind.'_volleyball_d_under']?> == 1 && $sport_name == '배구') ||
            (<?=$sport_setting[$kind.'_hockey_d_under']?> == 1 && $sport_name == '하키') ||
            (<?=$sport_setting[$kind.'_etc_d_under']?> == 1 && inArray($sport_name, $sport_array) == false)
            )
        {
            if (!CheckRule_d_under($game_index, $index, $game_type, $home_team, $away_team)) {
                alert("동일경기("+$sport_name+") [무]+[언더]  조합은 배팅 불가능합니다.");
                return;
            }
        }

        if( (<?=$sport_setting[$kind.'_soccer_h_unov']?> == 1 && $sport_name == '축구') ||
            (<?=$sport_setting[$kind.'_baseball_h_unov']?> == 1 && $sport_name == '야구') ||
            (<?=$sport_setting[$kind.'_basketball_h_unov']?> == 1 && $sport_name == '농구') ||
            (<?=$sport_setting[$kind.'_volleyball_h_unov']?> == 1 && $sport_name == '배구') ||
            (<?=$sport_setting[$kind.'_hockey_h_unov']?> == 1 && $sport_name == '하키') ||
            (<?=$sport_setting[$kind.'_etc_h_unov']?> == 1 && inArray($sport_name, $sport_array) == false)
           )
        {
            if (!checkRule_handi_unov($game_index, $index, $game_type, $home_team, $away_team)) {
                alert("동일경기("+$sport_name+") [핸디]+[언더/오버]  조합은 배팅 불가능합니다.");
                return;
            }
        }

        //승무패 이외에 무승부는 처리하지 않는다.
        if($game_type!=1 && $index==1)
            return;

        //선택한 Checkbox의 배당
        var selectedRate = '0';
        if(0==$index) 		selectedRate=$home_rate;
        else if(1==$index)	selectedRate=$draw_rate;
        else if(2==$index)	selectedRate=$away_rate;

        //토글
        var toggle_action = toggle($game_index+'_div', $index, selectedRate);
        //insert game
        if (toggle_action=='inserted')
        {
            /*
                    //-> 선택 총 배당이 500배를 넘을 수 없음.
                    if ( (Number(selectedRate) * Number(m_betList._bet)) > 500 ) {
                        alert('MAX배당은 500배까지만 가능합니다.');
                        toggle_action = toggle($game_index+'_div', $index, selectedRate);
                        return;
                    }
            */
            var item = new Item($game_index, $home_team, $away_team, $index, selectedRate, $home_rate, $draw_rate, $away_rate, $game_type, $sub_sn, $is_specified_special, $game_date, $league_sn, $sport_name);
            m_betList.addItem(item);

            betcon=betcon.add_element($game_index+"|"+$index+"&"+$home_team+"  VS "+$away_team);
            var isdisabled = true;
        }
        //delete game
        else
        {
            m_betList.removeItem($game_index);
            betcon=betcon.del_element($game_index+"|"+$index+"&"+$home_team+"  VS "+$away_team);
            var isdisabled = false;
        }

        if($game_type=='1' || $game_type=='2')
        {
            $('#form_'+$game_index+' input:checkbox').each( function(index) {
                if(0==index) { this.disabled = ($home_rate=='0')?true:isdisabled; }
                if(1==index) { this.disabled = ($draw_rate=='0')?true:isdisabled; }
                if(2==index) { this.disabled = ($away_rate=='0')?true:isdisabled; }
            });
        }

        /*
            if ( $special_type == 0 || $special_type == 1 || $special_type == 2 ) {
                if(!check_single_only($game_date))
                {
                    alert("단폴더만 가능합니다.");
                    toggle_action = toggle($game_index+'_div', $index, selectedRate);
                    m_betList.removeItem($game_index);
                    betcon=betcon.del_element($game_index+"|"+$index+"&"+$home_team+"  VS "+$away_team);
                    var isdisabled = false;
                    return;
                }
            }
        */

        //-> 축구 -> 동일경기 [승무패-승]+[언더오버-오버] 조합은 배팅 체크
        /*	if( $sport_name == "축구" ) {
                if ( !checkRule_win_over() ) {
                    matchGameWinOver = 1;
                } else {
                    matchGameWinOver = 0;
                }
            }

            //-> 축구 -> 동일경기 [승무패-승]+[언더오버-언더] 조합은 배팅 체크
            if( $sport_name == "축구" ) {
                if ( !checkRule_win_under() ) {
                    matchGameWinUnder = 1;
                } else {
                    matchGameWinUnder = 0;
                }
            }

            //-> 축구 -> 동일경기 [승무패-패]+[언더오버-언더] 조합은 배팅 체크
            if( $sport_name == "축구" ) {
                if ( !checkRule_lose_under() ) {
                    matchGameLoseUnder = 1;
                } else {
                    matchGameLoseUnder = 0;
                }
            }

            //-> 축구 -> 동일경기 [승무패-패]+[언더오버-오버] 조합은 배팅 체크
            if( $sport_name == "축구" ) {
                if ( !checkRule_lose_over() ) {
                    matchGameLoseOver = 1;
                } else {
                    matchGameLoseOver = 0;
                }
            }
        */
        //-> 야구 -> 동일경기 "1이닝 득점" [승무패-승]+[언더오버-언더] 조합은 배팅 체크
        /*if( $sport_name == "야구" ) {
            if ( !checkRule_fb_win_under() ) {
                matchGameFbWinUnder = 1;
            } else {
                matchGameFbWinUnder = 0;
            }
        }*/

        //-> 야구 -> 동일경기 "1이닝 득점" [승무패-승]+[언더오버-오버] 조합은 배팅 체크
        /*if( $sport_name == "야구" ) {
            if ( !checkRule_fb_win_over() ) {
                matchGameFbWinOver = 1;
            } else {
                matchGameFbWinOver = 0;
            }
        }*/

        //-> 야구 -> 동일경기 "1이닝 무득점" [승무패-패]+[언더오버-언더] 조합은 배팅 체크
        /*if( $sport_name == "야구" ) {
            if ( !checkRule_fb_lose_under() ) {
                matchGameFbLoseUnder = 1;
            } else {
                matchGameFbLoseUnder = 0;
            }
        }*/

        //-> 야구 -> 동일경기 "1이닝 무득점" [승무패-패]+[언더오버-오버] 조합은 배팅 체크
        /*if( $sport_name == "야구" ) {
            if ( !checkRule_fb_lose_over() ) {
                matchGameFbLoseOver = 1;
            } else {
                matchGameFbLoseOver = 0;
            }
        }*/

        //-> 야구 -> 동일경기 [승패]+[언오버] 조합 체크
        /*if( $sport_name == "야구" ) {
            if ( !checkRule_winlose_unover() ) {
                matchGameFbWinloseUnover = 1;
            } else {
                matchGameFbWinloseUnover = 0;
            }
        }*/

        //-> 농구 첫3점슛+첫자유투 묶을수 없다.
        /*if( $sport_name == "농구" ) {
            if ( !checkRule_basketBall_a() ) {
                matchGameBbFtsFfs = 1;
            } else {
                matchGameBbFtsFfs = 0;
            }
        }*/

        bonus_del(); //시점 관련 버그
        calc();
    }
</script>