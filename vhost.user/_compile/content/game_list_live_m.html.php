<?php 
	$TPL_league_keyword_list_1=empty($TPL_VAR["league_keyword_list"]) || !is_array($TPL_VAR["league_keyword_list"]) ? 0 : count($TPL_VAR["league_keyword_list"]);
	$TPL_game_list_1=empty($TPL_VAR["game_list"]) || !is_array($TPL_VAR["game_list"]) ? 0 : count($TPL_VAR["game_list"]);

    $gameType = $TPL_VAR["game_type"];
    $sportType = $TPL_VAR["sport_type"];
    $s_type = $TPL_VAR["s_type"];
    $sport_setting = $TPL_VAR["sport_setting"];
    $bonus_list = $TPL_VAR["bonus_list"];
?>
<!-- <link rel="stylesheet" type="text/css" href="/BET38/pc/_css/bootstrap-ko.css?v=511"> -->
<link rel="stylesheet" type="text/css" href="/BET38/mo/_css/default.css?v=516">
<link rel="stylesheet" type="text/css" href="/BET38/mo/_css/m_layout.css?v=529">
<link rel="stylesheet" type="text/css" href="/BET38/mo/_css/btns.css?v=511">
<link rel="stylesheet" type="text/css" href="/BET38/css/etc.m.css?v=510">
<script src="/BET38/js/jquery-1.12.1.min.js"></script>

<!-- JS END -->
<style>
    .ko_sports_game img {vertical-align:middle;}
    .ko_sports_game .bonus_ul {width:49%;display:inline-block;margin:0;}
    .ko_sports_game .bonus_div {width:99%;}
    .display_none {display:none;}
    .title_area h4 {width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;}
    .icon_up {
        width: 9px;
        height: 10px;
        padding: 2px;
        margin: 0 2px 0 2px;
        background: url(/images/icon_up.gif) center 50% no-repeat !important;
    }
    .icon_down {
        width: 9px;
        height: 10px;
        padding: 2px;
        margin: 0 2px 0 2px;
        background: url(/images/icon_down.gif) center 50% no-repeat !important;
    }
    .search_main {
        float: left;
        padding-bottom: 15px;
        padding-left: 15px;
        position: relative;
        vertical-align: middle;
        width: 80%;
    }

    .row {
        margin-right: -15px;
        margin-left: -15px;
    }

    .search1 {
        width: 20%;
    }

    .fl {
        float: left;
    }
    .search_dd {
        background-color: #1e2024;
        border: solid 1px #111;
        border-radius: 2px;
        color: #e9e9e9;
        cursor: pointer;
        display: table;
        font-weight: bold;
        height: 42px;
        list-style: none;
        padding-left: 15px;
        position: relative;
        text-align: left;
        vertical-align: middle;
        width: 100%;
    }
    .search_dd_pointer {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #26262a), color-stop(100%, #111111));
        background: -webkit-linear-gradient(top, #26262a 0%, #111111 100%);
        background: -o-linear-gradient(top, #26262a 0%, #111111 100%);
        background: -ms-linear-gradient(top, #26262a 0%, #111111 100%);
        background: linear-gradient(to bottom, #26262a 0%, #111111 100%);
        border-left: 1px solid #111;
        color: #e9e9e9;
        display: table-cell;
        height: 100%;
        right: -1px;
        text-align: center;
        vertical-align: middle;
        width: 45px;
    }

    .btn-primary-outline {
        background-color: transparent;
        border-color: transparent;
    }
    .sb_item {
        display: table;
        height: 40px;
        width: 100%;
    }
    .sb_item div {
        color: #e9e9e9;
        display: table-cell;
        text-align: left;
        vertical-align: middle;
    }
    .scrollable-menu {
        height: auto;
        max-height: 340px;
        overflow-x: hidden;
    }
    .dropdown-menu {
        padding: 0px;
    }
    .search_box {
        background-color: #1e2024;
        border: 1px solid #111;
        border-radius: 2px;
        margin-left: -1px;
        margin-top: 2px;
        width: 100%;
    }
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        display: none;
        float: left;
        min-width: 160px;
        padding: 5px 0;
        margin: 2px 0 0;
        font-size: 14px;
        text-align: left;
        list-style: none;
        background-color: #fff;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        border: 1px solid #ccc;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 4px;
        -webkit-box-shadow: 0 6px 12px rgb(0 0 0 / 18%);
        box-shadow: 0 6px 12px rgb(0 0 0 / 18%);
    }

    .search4 {
        width: 25%;
    }
    .search2 {
        width: 25%;
    }
    .search3 {
        width: 30%;
    }
    .pl5 {
        padding-left: 5px;
    }
    .search_dd_input {
        background-color: #1e2024;
        border: solid 1px #111;
        border-radius: 2px;
        color: #e9e9e9;
        cursor: pointer;
        display: table;
        font-weight: bold;
        height: 42px;
        list-style: none;
        position: relative;
        text-align: left;
        vertical-align: middle;
        width: 100%;
    }
    .search_dd_icon {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #26262a), color-stop(100%, #111111));
        background: -webkit-linear-gradient(top, #26262a 0%, #111111 100%);
        background: -o-linear-gradient(top, #26262a 0%, #111111 100%);
        background: -ms-linear-gradient(top, #26262a 0%, #111111 100%);
        background: linear-gradient(to bottom, #26262a 0%, #111111 100%);
        border-right: 1px solid #111;
        color: #e9e9e9;
        display: table-cell;
        height: 100%;
        left: -1px;
        text-align: center;
        vertical-align: middle;
        width: 45px;
    }
    .search_dd_input {
        background-color: #1e2024;
        border: solid 1px #111;
        border-radius: 2px;
        color: #e9e9e9;
        cursor: pointer;
        display: table;
        font-weight: bold;
        height: 42px;
        list-style: none;
        position: relative;
        text-align: left;
        vertical-align: middle;
        width: 100%;
    }

    .margin-left-175 {
        margin-left: -175px;
    }

    .toggle-width {
        width: 4% !important;
    }

    .toggle-icon {
        font-size: 32px; 
        cursor: pointer
    }

    .bonus_item {
        width: 32.8%;
        padding: 10px 10px 6px 10px;
        color: #fff;
        margin: 0 1.5px 5px 0;
        font-size: 0.8rem;
        line-height: 13px;
        float: left;
        cursor: pointer;
        border-radius: 5px;
        background: url(/BET38/pc/_img/tc_tab_bg.png) no-repeat top center;
        background-size: 100% 100%;
    }

    .bonus_item:hover {
        color: #fff !important;
        cursor: pointer;
        border-radius: 5px;
        background: url(/BET38/pc/_img/tc_tab_bg_ov.png) no-repeat top center;
        background-size: 100% 100%;
    }

    .st_real_mini_lock {
        position: absolute;
        width: 100%;
        height: 60px;
        text-align: center;
        padding: 18px 0 0 0;
        background: rgba( 0, 0, 0, 0.8 );
        z-index: 1;
    }

    @media screen and (max-width: 900px) { 
        .search_main {
            display:none;
        } 

        .sports_head {
            height:55px !important;
        }

        .margin-left-175 {
            margin-left: 0px;
        }

        .area-width {
            width: 90% !important;
        }

        .toggle-width {
            width: 9% !important;
            padding-top: 20px;
        }

        .sports_head .menu_list2 ul button {
            height: 40px;
        }

        .sports_head .menu_list2 .list02 li {
            width: 40px;
        }

    }
    ::-webkit-scrollbar {
        width: 0px;
    }
</style>

<div id="contents">
    <!-- ????????? ????????? ?????? -->
    <div class="sports_head">
        <!-- <div class="menu_list">
            <ul>
                <li><button class="button_type01 <?=($gameType == "multi" && $s_type == '1') ? 'on' : ''?>" onClick="location.href='/game_list?game=multi&s_type=1'">
                        <span>???????????????</span>
                    </button>
                </li>
                <li><button class="button_type01 <?=($gameType == "multi" && $s_type == '2') ? 'on' : ''?>" onClick="location.href='/game_list?game=multi&s_type=2'">
                        <span>???????????????</span>
                    </button>
                </li>
                <li><button class="button_type01 " onClick="location.href='/bbs/board.php?bo_table=a25'">
                        <span>??????????????????</span>
                    </button>
                </li>
                <li><button class="button_type01 " onClick="location.href='/bbs/board.php?bo_table=a10&b_type=3'">
                        <span>??????????????????</span>
                    </button>
                </li>
            </ul>
        </div> -->
        <div class="menu_list2">
            <!-- <ul class="list01">
                <li><button class="button_type01 <?=($TPL_VAR['sport_type'] == '' ) ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>'" style="height:35px;">ALL</button></li>
            </ul> -->
            <ul class="list02 margin-left-175">
                <li><button type="button" class="button_type01 btn_all <?=($TPL_VAR['sport_type'] == '' ) ? 'on' : ''; ?>" onClick="getLiveGameList('0')">ALL</button></li>
                <li><button type="button" class="button_type01 btn_soccer <?= $TPL_VAR['sport_type'] == 'soccer' ? 'on' : ''; ?>" onClick="getLiveGameList('0','soccer')"><img src="/10bet/images/10bet/ico/football-ico.png" alt="??????" /></button></li>
                <li><button type="button" class="button_type01 btn_basketball <?= $TPL_VAR['sport_type'] == 'basketball' ? 'on' : ''; ?>" onClick="getLiveGameList('0','basketball')"><img src="/10bet/images/10bet/ico/basketball-ico.png" alt="??????" /></button></li>
                <li><button type="button" class="button_type01 btn_baseball <?= $TPL_VAR['sport_type'] == 'baseball' ? 'on' : ''; ?>" onClick="getLiveGameList('0','baseball')"><img src="/10bet/images/10bet/ico/baseball-ico.png" alt="??????" /></button></li>
                <li><button type="button" class="button_type01 btn_hockey <?= $TPL_VAR['sport_type'] == 'hockey' ? 'on' : ''; ?>" onClick="getLiveGameList('0','hockey')"><img src="/10bet/images/10bet/ico/hockey-ico.png" alt="???????????????" /></button></li>
                <li><button type="button" class="button_type01 btn_volleyball <?= $TPL_VAR['sport_type'] == 'volleyball' ? 'on' : ''; ?>" onClick="getLiveGameList('0','volleyball')"><img src="/10bet/images/10bet/ico/volleyball-ico.png" alt="??????" /></button></li>
                <li><button type="button" class="button_type01 btn_esports <?= $TPL_VAR['sport_type'] == 'esports' ? 'on' : ''; ?>" onClick="getLiveGameList('0','esports')"><img src="/10bet/images/10bet/ico/esport-ico.png" alt="E?????????" /></button></li>
                <!-- <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'tennis' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=tennis'"><img src="/10bet/images/10bet/ico/tennis-ico.png" alt="?????????" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'handball' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=handball'"><img src="/10bet/images/10bet/ico/handball-ico.png" alt="?????????" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'mortor' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=mortor'"><img src="/10bet/images/10bet/ico/motor-sport-ico.png" alt="?????? ?????????" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'rugby' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=rugby'"><img src="/10bet/images/10bet/ico/rugby-league-ico.png" alt="??????" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'speedway' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=speedway'"><img src="/10bet/images/10bet/ico/speedway-ico.png" alt="?????????" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'darts' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=darts'"><img src="/10bet/images/10bet/ico/darts-ico.png" alt="??????" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'futsal' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=futsal'"><img src="/10bet/images/10bet/ico/futsal-ico.png" alt="??????" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'tabletennis' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=tabletennis'"><img src="/10bet/images/10bet/ico/tabletennis-ico.png" alt="????????????" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'esports' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=esports'"><img src="/10bet/images/10bet/ico/esport-ico.png" alt="????????????" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'etc' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=etc'">??????</button></li> -->
            </ul>
        </div>
    </div>
    <div id="st_site">
        <!-- CONTAINER -->
        <div class="st_container" id="centerPage" style="overflow:auto; padding-bottom:350px;max-height:600px;">
            <div class="st_b_cont_bg">
                <!-- CONTAINER TOTAL LEFT+RIGHT-->
                <div class="width_100 bt_g_tabs2">
                    <div id="bonus_ul">
                    <?php
                    foreach($bonus_list as $bonus) {?>
                        <div class="bonus_item selectable" name="<?=$bonus["sn"]?>_div" onclick=onMultiTeamSelected('<?=$bonus["sn"]?>','0')>
                            <div style="display:none">';
                                <input type="hidden" id="<?=$bonus["sn"]?>_sport_name" value="<?=$bonus["sport_name"]?>">
                                <input type="hidden" id="<?=$bonus["sn"]?>_game_type" value="<?=$bonus["betting_type"]?>">
                                <input type="hidden" id="<?=$bonus["sn"]?>_sub_sn"    value="<?=$bonus["sn"]?>">
                                <input type="hidden" id="<?=$bonus["sn"]?>_home_team" value="<?=trim($bonus["home_team"])?>">
                                <input type="hidden" id="<?=$bonus["sn"]?>_home_rate" value="<?=$bonus["home_rate"]?>">
                                <input type="hidden" id="<?=$bonus["sn"]?>_draw_rate" value="<?=$bonus["draw_rate"]?>">
                                <input type="hidden" id="<?=$bonus["sn"]?>_away_team" value="<?=trim($bonus["away_team"])?>">
                                <input type="hidden" id="<?=$bonus["sn"]?>_away_rate" value="<?=$bonus["away_rate"]?>">
                                <input type="hidden" id="<?=$bonus["sn"]?>_game_date" value="<?=$bonus["gameDate"]?>">
                                <input type="hidden" id="<?=$bonus["sn"]?>_league_sn" value="<?=$bonus["league_sn"]?>">
                            </div>
                            <span class="txt_co7 txt_w600"><?=$bonus["home_team"]?></span>
                            <div class="bt_gr_area4 txt_w600"><?=$bonus["home_rate"]?></div>
                            <input type="checkbox" name="ch" value="1" style="display:none;">
                        </div>
                    <?php }
                    ?>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="st_con_total">
                    <!-- CONTAINER AREA LEFT-->
                    <div class="list_st1" style="position:relative;">
                       
                    </div>
                    <div class="pagination pagination-centered">
                        <input type="hidden" id="sport_type" name="sport_type">
                        <input type="hidden" id="league_sn" name="league_sn">
                        <input type="hidden" id="today" name="today">
                        <ul>
                            <!-- <li class="active page page_1"><a href="javascript:void(0)" onclick="getPage('0')">1</a></li>
                            <li class="page page_2"><a href="javascript:void(0)" onclick="getPage('1')">2</a></li>
                            <li class="page page_3"><a href="javascript:void(0)" onclick="getPage('2')">3</a></li> -->
                        </ul>
                    </div>
                    <!--// CONTAINER AREA LEFT-->
                </div>
                <!-- CONTAINER TOTAL LEFT+RIGHT-->
            </div>
        </div>
    </div>
</div>
<!--// CONTAINER AREA-->

<script language="javascript">
    $(document).ready(function() {
        // getBonusList();
        localStorage.clear();
        var sport_type = '<?php echo $TPL_VAR["sport_type"]?>';
        setTimeout(() => {
            getLiveGameList(0, "", 0, 0);
        }, 1000);
    });

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

    var bettingendtime = '<?php echo $TPL_VAR["betEndTime"]?>';
    var bettingcanceltime = '<?php echo $TPL_VAR["betCancelTime"]?>';
    var bettingcancelbeforetime = '<?php echo $TPL_VAR["betCancelBeforeTime"]?>';
    var crossLimitCnt = '<?php echo $TPL_VAR["crossLimitCnt"]?>';
    var game_kind = "<?php echo $gameType?>";
    
    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }

    /*
    * $game_index 	: game identify id (Sub Child Index)
    * $index		: checkbox index-start from 0
    */
    function onMultiTeamSelected($game_index, $index, $betid) {
        $sport_name = $j("#" + $game_index + "_sport_name").val();
        $game_type = $j("#" + $game_index + "_game_type").val();
        $home_team = $j("#" + $game_index + "_home_team").val();
        $home_rate = $j("#" + $game_index + "_home_rate").val();
        $draw_rate = $j("#" + $game_index + "_draw_rate").val();
        $away_team = $j("#" + $game_index + "_away_team").val();
        $away_rate = $j("#" + $game_index + "_away_rate").val();
        $sub_sn = $j("#" + $game_index + "_sub_sn").val();
        $game_date = $j("#" + $game_index + "_game_date").val();
        $market_name = $j("#" + $game_index + "_market_name").val();
        $home_betid = $j("#" + $game_index + "_home_betid").val();
        $away_betid = $j("#" + $game_index + "_away_betid").val();
        $draw_betid = $j("#" + $game_index + "_draw_betid").val();
        $home_line = $j("#" + $game_index + "_home_line").val();
        $away_line = $j("#" + $game_index + "_away_line").val();
        $home_name = $j("#" + $game_index + "_home_name").val();
        $league_sn = $j("#" + $game_index + "_league_sn").val();
        $is_specified_special = 0;

        if ($index < 0 || $index > 2)
            return;

        if ($index == 1 && ($draw_rate == '1' || $draw_rate == '1.0' || $draw_rate == '1.00' || $draw_rate == 'VS'))
            return;

        //-> ????????? ????????? (2?????? ???????????? ??????)
        if ($home_team.indexOf("??????") > -1) {
            if (folder_bonus($home_team) == "0") {
                return;
            }
        }

        if ($game_type == 0) {
            warning_popup("????????? ????????? ????????????.");
            return;
        }

        //????????? Checkbox??? ??????
        var selectedRate = '0';
        if (0 == $index) selectedRate = $home_rate;
        else if (1 == $index) selectedRate = $draw_rate;
        else if (2 == $index) selectedRate = $away_rate;

        //??????
        var toggle_action = toggle_multi($game_index + '_div', $index, selectedRate, crossLimitCnt);
        //insert game
        if (toggle_action == 'inserted') {
            var item = new Item($game_index, $home_team, $away_team, $index, selectedRate, $home_rate, $draw_rate, $away_rate, $game_type, $sub_sn, $is_specified_special, $game_date, $league_sn, $sport_name, 0, $betid, $market_name, $home_line, $away_line, $home_name, $home_betid, $away_betid, $draw_betid);
            m_betList.addItem(item);

            // if(localStorage.getItem(`selected_${$betid}`) === null)
            //     localStorage.setItem(`selected_${$betid}`, $betid);

            //betcon = betcon.add_element($game_index + "|" + $index + "&" + $home_team + "  VS " + $away_team);
            var isdisabled = true;
        }
        //delete game
        else {
            m_betList.removeItem($game_index);
            //betcon = betcon.del_element($game_index + "|" + $index + "&" + $home_team + "  VS " + $away_team);
            var isdisabled = false;

            // if(localStorage.getItem(`selected_${$betid}`) !== null)
            //     localStorage.removeItem(`selected_${$betid}`);
        }

        bonus_del();
        calc();
    }

    function getLiveGameList(page_index, sport_type = "", league_sn = 0, today = 0) {
        $j("#sport_type").val(sport_type);
        $j("#league_sn").val(league_sn);
        $j("#today").val(today);
        $j(".page").removeClass("active");
        $j(".page_" + (parseInt(page_index) + 1)).addClass("active");

        switch(sport_type) {
            case "":
                $(".btn_all").addClass("on");
                $(".btn_soccer").removeClass("on");
                $(".btn_basketball").removeClass("on");
                $(".btn_baseball").removeClass("on");
                $(".btn_hockey").removeClass("on");
                $(".btn_volleyball").removeClass("on");
                $(".btn_esports").removeClass("on");
                break;
            case "soccer":
                $(".btn_soccer").addClass("on");
                $(".btn_all").removeClass("on");
                $(".btn_basketball").removeClass("on");
                $(".btn_baseball").removeClass("on");
                $(".btn_hockey").removeClass("on");
                $(".btn_volleyball").removeClass("on");
                $(".btn_esports").removeClass("on");
                break;
            case "basketball":
                $(".btn_basketball").addClass("on");
                $(".btn_soccer").removeClass("on");
                $(".btn_all").removeClass("on");
                $(".btn_baseball").removeClass("on");
                $(".btn_hockey").removeClass("on");
                $(".btn_volleyball").removeClass("on");
                $(".btn_esports").removeClass("on");
                break;
            case "baseball":
                $(".btn_baseball").addClass("on");
                $(".btn_soccer").removeClass("on");
                $(".btn_basketball").removeClass("on");
                $(".btn_all").removeClass("on");
                $(".btn_hockey").removeClass("on");
                $(".btn_volleyball").removeClass("on");
                $(".btn_esports").removeClass("on");
                break;
            case "hockey":
                $(".btn_hockey").addClass("on");
                $(".btn_soccer").removeClass("on");
                $(".btn_basketball").removeClass("on");
                $(".btn_baseball").removeClass("on");
                $(".btn_all").removeClass("on");
                $(".btn_volleyball").removeClass("on");
                $(".btn_esports").removeClass("on");
                break;
            case "volleyball":
                $(".btn_volleyball").addClass("on");
                $(".btn_soccer").removeClass("on");
                $(".btn_basketball").removeClass("on");
                $(".btn_baseball").removeClass("on");
                $(".btn_hockey").removeClass("on");
                $(".btn_all").removeClass("on");
                $(".btn_esports").removeClass("on");
                break;
            case "esports":
                $(".btn_esports").addClass("on");
                $(".btn_volleyball").removeClass("on");
                $(".btn_soccer").removeClass("on");
                $(".btn_basketball").removeClass("on");
                $(".btn_baseball").removeClass("on");
                $(".btn_hockey").removeClass("on");
                $(".btn_all").removeClass("on");
                break;
        }

        packet = {
            "m_strSports"   :   sport_type,
            "m_nLeague"     :   league_sn,
            "m_nLive"       :   2,
            "m_nPageIndex"  :   page_index,
            "m_nPageSize"   :   50,
            "m_nSendType"   :   nSendType
        };

        onLoadingScreen();

        if(ws.readyState === WebSocket.OPEN)
            onSendReqListPacket(packet);
        else 
            setTimeout(function() {
                onSendReqListPacket(packet);
            }, 1000);

        return;
      
    }

    function onRevGameList(strPacket) {
        showJson = JSON.parse(strPacket);
        // console.log(showJson);
        if(showJson.length == 0) {
            $j(".list_st1").empty();
            warning_popup("?????? ???????????? ????????? ????????????.");
        } else {
            $j(".list_st1").empty();
            $j(".pagination ul").empty();
            var jsonCountInfo = showJson[0].m_lstSportsCnt;
            showSportsTotalCount(jsonCountInfo);
            showGameList();
            var page_count = parseInt(showJson[0].m_nTotalCnt) / 50;
            var page_item = "";
            for(var i = 0; i < page_count; i++) {
                page_item += `<li class="page page_${i + 1} ${packet.m_nPageIndex == i ? 'active' : ''}"><a href="javascript:void(0)" onclick="getPage('${i}')">${i + 1}</a></li>`;
            }
            $j(".pagination ul").append(page_item);
        }
        
        $j("#loading").fadeOut(1000);
        $j("#coverBG2").fadeOut(1000);
    }
    
    function realTime(strPacket) {

    }
    
    function onRecvAjaxList(strPacket) {
        var json = JSON.parse(strPacket);
        // console.log(json);
        if(json.length > 0) {
            var jsonCountInfo = json[0].m_lstSportsCnt;
            showSportsTotalCount(jsonCountInfo);
            showAjaxList(json);
        } 
    }

    function showAjaxList(newJson) {
        if(showJson == null) {
            return;
        }

        if(newJson.length > 0) {
            for(var i = 0; i < newJson.length; i++) {
                if(document.getElementById(`sel_game_${newJson[i].m_nGame}`) != null && document.getElementById(`sel_game_${newJson[i].m_nGame}`) != undefined) {
                    $('#betting_section_' + newJson[i].m_nFixtureID).empty();
                    var details = newJson[i].m_lstDetail;
                    if(details.length > 0) {
                        appendMarketDiv(newJson[i], details);
                    }
                }
            }

            for(var i = 0; i < showJson.length; i++) {
                var json = newJson.find(val => val.m_nGame == showJson[i].m_nGame);
                if(json == null || json == undefined) {
                    //?????? ?????? ????????? ????????? ?????????????????? ???????????? ???????????? ???????????? ????????? ??????.
                    removeGameDiv(showJson[i]);
                }
                else {
                    var isExist = checkExist1x2(json);
                    if(document.getElementById(`cnt_${json.m_nGame}`) != null && document.getElementById(`cnt_${json.m_nGame}`) != undefined) {
                        if(json.m_nStatus == 1 || json.m_nStatus == 8 || json.m_nStatus == 9)
                            document.getElementById(`cnt_${json.m_nGame}`).innerHTML = "+0";
                        else 
                            document.getElementById(`cnt_${json.m_nGame}`).innerHTML = "+" + getMarketsCnt(json.m_strSportName, json.m_lstDetail, isExist);
                    }
                    if(document.getElementById(`F${json.m_nGame}`) != null && document.getElementById(`F${json.m_nGame}`) != undefined) {
                        if(json.m_nStatus == 1 || json.m_nStatus == 8 || json.m_nStatus == 9)
                            $j(`#F${json.m_nGame}`).prop("disabled", true);
                        else 
                            $j(`#F${json.m_nGame}`).prop("disabled", false);
                    }
                    if(document.getElementById(`period_${json.m_nGame}`) != null && document.getElementById(`period_${json.m_nGame}`) != undefined)
                        document.getElementById(`period_${json.m_nGame}`).innerHTML = json.m_strPeriod;
                    if(document.getElementById(`homescore_${json.m_nGame}`) != null && document.getElementById(`homescore_${json.m_nGame}`) != undefined)
                        document.getElementById(`homescore_${json.m_nGame}`).innerHTML = json.m_nHomeScore;
                    if(document.getElementById(`awayscore_${json.m_nGame}`) != null && document.getElementById(`awayscore_${json.m_nGame}`) != undefined)
                        document.getElementById(`awayscore_${json.m_nGame}`).innerHTML = json.m_nAwayScore;

                    for(var j=0; j < showJson[i].m_lstDetail.length; j++) {
                        var djson = json.m_lstDetail.find(val => val.m_nHBetCode == showJson[i].m_lstDetail[j].m_nHBetCode && val.m_nDBetCode == showJson[i].m_lstDetail[j].m_nDBetCode && val.m_nABetCode == showJson[i].m_lstDetail[j].m_nABetCode);
                        if(djson != null && djson != undefined) {
                            //????????????????????????
                            var sub_idx = `${json.m_nGame}_${djson.m_nMarket}_${djson.m_nFamily}`;
                            if(djson.m_fHRate != showJson[i].m_lstDetail[j].m_fHRate) {
                                var obj = document.getElementById(`${djson.m_nHBetCode}`);
                                if(obj != null && obj != undefined) {
                                    document.getElementById(`${djson.m_nHBetCode}`).innerHTML = djson.m_fHRate.toFixed(2);
                                }
                                if(document.getElementById(`${sub_idx}_home_rate`) != null && document.getElementById(`${sub_idx}_home_rate`) != undefined)
                                    document.getElementById(`${sub_idx}_home_rate`).value = djson.m_fHRate.toFixed(2);
                            }
                            if(djson.m_fDRate != showJson[i].m_lstDetail[j].m_fDRate) {
                                var obj = document.getElementById(`${djson.m_nDBetCode}`);
                                if(obj != null && obj != undefined) {
                                    document.getElementById(`${djson.m_nDBetCode}`).innerHTML = djson.m_fDRate.toFixed(2);
                                }
                                if(document.getElementById(`${sub_idx}_draw_rate`) != null && document.getElementById(`${sub_idx}_draw_rate`) != undefined)
                                    document.getElementById(`${sub_idx}_draw_rate`).value = djson.m_fDRate.toFixed(2);
                            }
                            if(djson.m_fARate != showJson[i].m_lstDetail[j].m_fARate) {
                                var obj = document.getElementById(`${djson.m_nABetCode}`);
                                if(obj != null && obj != undefined) {
                                    document.getElementById(`${djson.m_nABetCode}`).innerHTML = djson.m_fARate.toFixed(2);
                                }
                                if(document.getElementById(`${sub_idx}_away_rate`) != null && document.getElementById(`${sub_idx}_away_rate`) != undefined)
                                    document.getElementById(`${sub_idx}_away_rate`).value = djson.m_fARate.toFixed(2);
                            } 

                            // ??????????????? ?????? ????????????
                            if(document.getElementById(`${djson.m_nHBetCode}_cart`) != null) {
                                document.getElementById(`${djson.m_nHBetCode}_cart`).innerHTML = djson.m_fHRate.toFixed(2);
                                updateCart(0, djson.m_nHBetCode, djson.m_fHRate);
                                if(localStorage.getItem(`selected_${djson.m_nHBetCode}`) !== null) {
                                    $j(`#${djson.m_nHBetCode}_chk`).parent().addClass("on");
                                    $j(`#${djson.m_nHBetCode}_chk`).prop("checked", true);
                                }
                            }

                            if(document.getElementById(`${djson.m_nDBetCode}_cart`) != null) {
                                document.getElementById(`${djson.m_nDBetCode}_cart`).innerHTML = djson.m_fDRate.toFixed(2);
                                updateCart(1, djson.m_nDBetCode, djson.m_fDRate);
                                if(localStorage.getItem(`selected_${djson.m_nDBetCode}`) !== null) {
                                    $j(`#${djson.m_nDBetCode}_chk`).parent().addClass("on");
                                    $j(`#${djson.m_nDBetCode}_chk`).prop("checked", true);
                                }
                            }

                            if(document.getElementById(`${djson.m_nABetCode}_cart`) != null) { 
                                document.getElementById(`${djson.m_nABetCode}_cart`).innerHTML = djson.m_fARate.toFixed(2);
                                updateCart(2, djson.m_nABetCode, djson.m_fARate);
                                if(localStorage.getItem(`selected_${djson.m_nABetCode}`) !== null) {
                                    $j(`#${djson.m_nABetCode}_chk`).parent().addClass("on");
                                    $j(`#${djson.m_nABetCode}_chk`).prop("checked", true);
                                }
                            }

                        }

                        djson = json.m_lstDetail.find(val => val.m_nMarket == showJson[i].m_lstDetail[j].m_nMarket);
                        if(djson == null || djson == undefined) {
                            removeMarketDiv(showJson[i], showJson[i].m_lstDetail[j]);
                        }
                    }

                    if(json.m_nStatus == 1 || json.m_nStatus == 8 || json.m_nStatus == 9) {
                        $j("#lock_" + json.m_nGame).css("display", "block");
                    } else if(json.m_lstDetail.length > 0) {
                        var market12;
                        switch(json.m_nSports) {
                            case 6046: // ??????
                                market12 = json.m_lstDetail.find(val => val.m_nMarket == 1 && val.m_nHBetCode != "" && val.m_nDBetCode != "" && val.m_nABetCode != "");
                                break;
                            case 48242: // ??????
                                market12 = json.m_lstDetail.find(val => val.m_nMarket == 226 && val.m_nHBetCode != "" && val.m_nABetCode != "");
                                break;
                            case 154914: // ??????
                                market12 = json.m_lstDetail.find(val => val.m_nMarket == 226 && val.m_nHBetCode != "" && val.m_nABetCode != "");
                                break;
                            case 154830: // ??????
                                market12 = json.m_lstDetail.find(val => val.m_nMarket == 52 && val.m_nHBetCode != "" && val.m_nABetCode != "");
                                break;
                            case 35232: // ????????? ??????
                                market12 = json.m_lstDetail.find(val => val.m_nMarket == 1 && val.m_nHBetCode != "" && val.m_nDBetCode != "" && val.m_nABetCode != "");
                                break; 
                            case 687890: // E?????????
                                market12 = json.m_lstDetail.find(val => val.m_nMarket == 52 && val.m_nHBetCode != "" && val.m_nABetCode != "");
                                break;    
                        }
                        
                        if(typeof market12 !== 'undefined' && market12.m_nStatus > 1) {
                            $j("#lock_" + json.m_nGame).css("display", "block");
                        } else {
                            $j("#lock_" + json.m_nGame).css("display", "none");
                        }
                    }
                }
            }

        
            for(var i = 0; i < newJson.length; i++) {
                var json = showJson.find(val => val.m_nGame == newJson[i].m_nGame);
                if(json == null || json == undefined) {
                    //???????????????
                    console.log("append Game");
                    appendGameDiv(newJson[i], 1);
                }
            }

            var filteredJson = []
            for(i = 0; i < newJson.length; i++) {
                if(checkExist1x2(newJson[i])) {
                    filteredJson.push(newJson[i]);
                }
            }
            showJson = filteredJson;
        } else {
            $j(".list_st1").empty();
            showJson = newJson;
        }
    }

    function onClickLeague(nLeague) {
        getLiveGameList(0, "", nLeague, 0);
    }
   
    function removeGameDiv(item) {
        var obj = document.getElementById(`div_${item.m_nGame}`);
        if(obj != null && obj != undefined) {
            console.log("remove Game");
            $j(`#div_${item.m_nGame}`).remove();
        }
    }

    function removeMarketDiv(game, market) {
        console.log("remove market");
        var div_id = `div_${game.m_nGame}_${market.m_nMarket}`;
        var obj = document.getElementById(`${div_id}`);
        if(obj != null && obj != undefined)
        {
            $j(`#${div_id}`).remove();
        }
    }
    
    function showGameList() {
        gameList = showJson;
        // $('#gameRight').html('');
        $.each(showJson, function(index, item) {
            appendGameDiv(item, index);
        });
        scrollToTopDiv(".st_container");
        $j(".mask_layer").click();
    }

    function appendGameDiv(item, index) {
        if(item.m_lstDetail.length > 0) {
            var details = item.m_lstDetail;
            var isExist12 = false;
            isExist12 = checkExist1x2(item);
            $.each(details, function(i, detail) {
                switch(item.m_strSportName) {
                    case "??????":
                        if(isExist12) {
                            if(detail.m_nMarket == 1 && detail.m_nHBetCode != "" && detail.m_nDBetCode != "" && detail.m_nABetCode != "") {
                                getSubChildInfo(index, item, detail, getMarketsCnt(item.m_strSportName, details, isExist12), isExist12);
                            }
                        }
                        break;
                    case "??????":
                        if(isExist12) {
                            if(detail.m_nMarket == 226 && detail.m_nHBetCode != "" && detail.m_nABetCode != "") {
                                getSubChildInfo(index, item, detail, getMarketsCnt(item.m_strSportName, details, isExist12), isExist12);
                            }
                        } 
                        break;
                    case "??????":
                        if(isExist12) {
                            if(detail.m_nMarket == 226 && detail.m_nHBetCode != "" && detail.m_nABetCode != "") {
                                getSubChildInfo(index, item, detail, getMarketsCnt(item.m_strSportName, details, isExist12), isExist12);
                            }
                        } 
                        break;
                    case "??????":
                        if(isExist12) {
                            if(detail.m_nMarket == 52 && detail.m_nHBetCode != "" && detail.m_nABetCode != "") {
                                getSubChildInfo(index, item, detail, getMarketsCnt(item.m_strSportName, details, isExist12), isExist12);
                            }
                        }
                        break;
                    case "????????? ??????":
                        if(isExist12) {
                            if(detail.m_nMarket == 1 && detail.m_nHBetCode != "" && detail.m_nDBetCode != "" && detail.m_nABetCode != "") {
                                getSubChildInfo(index, item, detail, getMarketsCnt(item.m_strSportName, details, isExist12), isExist12);
                            }
                        } 
                        break;
                    case "E?????????":
                        if(isExist12) {
                            if(detail.m_nMarket == 52 && detail.m_nHBetCode != "" && detail.m_nABetCode != "") {
                                getSubChildInfo(index, item, detail, getMarketsCnt(item.m_strSportName, details, isExist12), isExist12);
                            }
                        } 
                        break;
                }
            });
        }
    }
    
    function getSubChildInfo(index, item, detail, childCnt, isExist12) {
        var div = "";
        
        var homeAdd = "";
        var awayAdd = "";
        var sub_idx = `${item.m_nGame}_${detail.m_nMarket}_${detail.m_nFamily}`;
        //console.log(response.betting_type);
        
        div += '<ul id="div_' + item.m_nGame + '">';
        div += '<li class="tr">';
        div += '<span class="st_game_leg">';
        div += `<img src="/BET38/_icon/sport/S${item.m_nSports}.png" width="23" class="st_marr3 st_marb1 st_game_ico">`;
        div += '&nbsp';
        if(item.m_strLeagueImg != "") {
            div += '<img src="' + item.m_strLeagueImg + '?v=1" width="23" class="st_marr3 st_marb1 st_game_ico">';
        }
        div += '&nbsp';
        div += item.m_strLeagueName;
        div += '</span>';
        div += `<button onclick="getBtnsMobile('${item.m_nGame}')" id="F${item.m_nGame}" class="gBtn st_mart1 bt_game_more" ${(item.m_nStatus == 1 || item.m_nStatus == 8 || item.m_nStatus == 9) ? 'disabled' : ''}><span id="cnt_${item.m_nGame}">+${(item.m_nStatus == 1 || item.m_nStatus == 8 || item.m_nStatus == 9) ? 0 : childCnt}</span></button>`;
        div += `<span class="span_period" id="period_${item.m_nGame}">${item.m_strPeriod}</span>`;
        div += '<span class="st_game_time">' + item.m_strDate.substring(5,10) + ' ' + item.m_strHour + ':' + item.m_strMin + '</span>'; 
        div += '</li>';
        if( item.m_strSportName == "??????")
            div += '<div class="st_real_l-1">';
        else if( item.m_strSportName == "??????")
            div += '<div class="st_real_l-2">'; 
        else if( item.m_strSportName == "??????")
            div += '<div class="st_real_l-3">';
        else if( item.m_strSportName == "??????")
            div += '<div class="st_real_l-4">';
        else if( item.m_strSportName == "????????? ??????")
            div += '<div class="st_real_l-5">';
        else if( item.m_strSportName == "E?????????")
            div += '<div class="st_real_l-5">';
        div += `<span class="no_st1" id="homescore_${item.m_nGame}">${item.m_nHomeScore}</span>`;
        div += '<span class="no_st2">VS</span>';
        div += `<span class="no_st1" id="awayscore_${item.m_nGame}">${item.m_nAwayScore}</span>`;
        div += '</div>';
        div += '<li class="spo_align">';
        div += '<div style="display:none">';
        div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + item.m_strSportName + '">';
        div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + detail.m_nMarket + '">';
        div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
        div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + item.m_strHomeTeam + '">';
        div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + detail.m_fHRate + '">';
        div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + detail.m_fDRate + '">';
        div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + item.m_strAwayTeam + '">';
        div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + detail.m_fARate + '">';
        div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + item.m_strDate + '">';
        if(detail.m_nFamily == 1)
            div += '<input type="hidden" id="' + sub_idx + '_market_name" value="?????????">';
        else if(detail.m_nFamily == 2)
            div += '<input type="hidden" id="' + sub_idx + '_market_name" value="??????">';
        div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + detail.m_nHBetCode + '">';
        div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + detail.m_nABetCode + '">';
        div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + detail.m_nDBetCode + '">';
        div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + detail.m_strHLine + '">';
        div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + detail.m_strALine + '">';
        div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + detail.m_strHName + '">';
        div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + item.m_nLeague + '"></div>';
        if(!isExist12 || item.m_nStatus == 1 || item.m_nStatus == 8 || item.m_nStatus == 9 || detail.m_nStatus > 1) {
            div += `<div id="lock_${item.m_nGame}" class="st_real_mini_lock" style="display:block"></div>`;
        } else {
            div += `<div id="lock_${item.m_nGame}" class="st_real_mini_lock" style="display:none"></div>`;
        }
        div += `<div class="st_wd44_l3  st_marr_n1 selectable" name="${sub_idx}_div" onclick="onMultiTeamSelected('${sub_idx}','0','${detail.m_nHBetCode}')">`;
        div += '<span class="spo_align1 f_w6">';
        div += item.m_strHomeTeam;
        div += '</span>';
        div += '<span class="spo_align2 txt_ar st_padr5" id="' + detail.m_nHBetCode + '">' + detail.m_fHRate.toFixed(2) + '</span>';
        //div += '<span class="f_right" id="' + item.child_sn + '_home_rate"></span>';
        div += `<input type="checkbox" id="${detail.m_nHBetCode}_chk" name="ch" value="1" style="display:none;"></div>`;
        if(detail.m_nMarket == 1) {
            div += `<div class="st_wd10_l txt_ac spo_align4 selectable" name="${sub_idx}_div"  onclick="onMultiTeamSelected('${sub_idx}','1','${detail.m_nDBetCode}')">`;
            //div += '<span id="' + item.child_sn + '_draw_rate">VS</span>';
            div += '<span id="' + detail.m_nDBetCode + '">' + detail.m_fDRate.toFixed(2) + '</span>';
            div += `<input type="checkbox" id="${detail.m_nDBetCode}_chk" name="ch" value="3" style="display:none;"></div>`;
        } else {
            div += `<div class="st_wd10_l txt_ac spo_align4 selectable" name="${sub_idx}_div">`;
            //div += '<span id="' + item.child_sn + '_draw_rate">VS</span>';
            div += "VS";
            div += '<input type="checkbox" name="ch" value="3" style="display:none;"></div>';
        }
        div += `<div class="st_wd44_l3 st_marl_n1 selectable" name="${sub_idx}_div" onclick="onMultiTeamSelected('${sub_idx}','2','${detail.m_nABetCode}')">`;
        //div += '<span id="' + item.child_sn + '_away_rate"></span>';
        //div += item.away_rate;
        div += '<span class="spo_align1 txt_ar f_w6">'; 
        div += item.m_strAwayTeam + '</span>';
        div += '<span class="spo_align2 txt_al st_marl5" id="' + detail.m_nABetCode + '">' + detail.m_fARate.toFixed(2) + '</span>';
        div += `<input type="checkbox" id="${detail.m_nABetCode}_chk" name="ch" value="2" style="display:none;">`;
        div += '</div></li>';
        div += '<div class="_hidden game_bottom" id="game_bottom_' + item.m_nGame + '">';
        div += '<div class="sel_game" id="sel_game_' + item.m_nGame + '">';
        div += '</div></div></ul>';
        
        $(".list_st1").append(div);
            
    }

    function getBtnsMobile(gameCode) {
        if($('#F'+gameCode).hasClass("act")) {
            //$('#F'+fid).html("<b>+</b>");
            $('#F'+gameCode).removeClass("act");
            $('#game_bottom_' + gameCode).css("display", "none");
        } else {
            //$('#F'+fid).html("<b>-</b>");
            $('#F'+gameCode).addClass("act");
            var childArray = showJson.filter(value => value.m_nGame == gameCode);
            showMarkets(childArray[0]);
            $('#game_bottom_' + gameCode).css("display", "block");
        }
    }

    function showMarkets(res) {
        $('#sel_game_' + res.m_nGame).html("");
        var div = '<div class="st_b_tit4"><div class="st_wd45 f_left txt_cut line-team">';
        div += res.m_strHomeTeam;
        div += '</div><div class="st_wd10 txt_ac" style="margin-top:5px;"><img src="/BET38/pc/_img/ico_vs.png" style="max-width:100%;"></div>';
        div += '<div class="st_wd45 f_right  st_padr10 txt_cut line-team">';
        div += res.m_strAwayTeam;
        div += "</div></div>";
        var hostname = window.location.hostname;
        if(hostname == "line1111.com" || hostname == "cs-82.com") {
            div += `<div id="game_stat_box_${res.m_nFixtureID}">`;
            var height = 410;
            if(res.m_nSports == 154914 || res.m_nSports == 35232) {
                height = 380;
            }
            div += `<iframe id="game_stat" scrolling="no" frameborder="0" src="/gameInfoIframe?event_id=${res.m_nFixtureID}" width="100%" height="${height}"></iframe></div>`;
        }
        div += `<div id="betting_section_${res.m_nFixtureID}"></div>`;
        $('#sel_game_' + res.m_nGame).html( div );

        var details = res.m_lstDetail;
        if(details.length > 0) {
            appendMarketDiv(res, details);
        }
    }

    function appendMarketDiv(res, details) {
        console.log("Append Market Div");
        var header1 = "";
        var header2 = "";
        var header3 = "";
        var header4 = "";
        var header5 = "";
        var header6 = "";
        var header7 = "";
        var header8 = "";
        var header9 = "";
        var header10 = "";
        var header11 = "";
        var header12 = "";
        var header13 = "";
        var header14 = "";
        var header15 = "";
        var header16 = "";
        var header17 = "";
        var header18 = "";
        var header19 = "";
        var header20 = "";
        var header21 = "";
        var header22 = "";
        var header23 = "";
        var header24 = "";
        var header25 = "";
        var header26 = "";
        var header27 = "";
        var header28 = "";
        var header29 = "";
        var header30 = "";
        var header31 = "";
        var header32 = "";
        var header33 = "";
        var header34 = "";
        var header35 = "";
        var header36 = "";
        var header37 = "";
        var header38 = "";
        var header39 = "";
        var header40 = "";
        var header41 = "";
        var header42 = "";
        var header43 = "";
        var header44 = "";
        var header45 = "";
        var header46 = "";
        var header47 = "";
        var header48 = "";
        var header49 = "";
        var header50 = "";
        var header51 = "";
        var header52 = "";
        var header53 = "";
        var header54 = "";
        var header55 = "";
        var header56 = "";
        var header57 = "";
        var header58 = "";
        var header59 = "";
        var header60 = "";
        var header61 = "";
        var header62 = "";
        var header63 = "";
        var header64 = "";
        var header65 = "";
        var header66 = "";
        var header67 = "";
        var header68 = "";
        var header69 = "";
        var header70 = "";
        var header71 = "";
        var header72 = "";
        var header73 = "";
        var header74 = "";
        var header75 = "";

        var children1 = [];
        var children2 = [];
        var children3 = [];
        var children4 = [];
        var children5 = [];
        var children6 = [];
        var children7 = [];
        var children8 = [];
        var children9 = [];
        var children10 = [];
        var children11 = [];
        var children12 = [];
        var children13 = [];
        var children14 = [];
        var children15 = [];
        var children16 = [];
        var children17 = [];
        var children18 = [];
        var children19 = [];
        var children20 = [];
        var children21 = [];
        var children22 = [];
        var children23 = [];
        var children24 = [];
        var children25 = [];
        var children26 = [];
        var children27 = [];
        var children28 = [];
        var children29 = [];
        var children30 = [];
        var children31 = [];
        var children32 = [];
        var children33 = [];
        var children34 = [];
        var children35 = [];
        var children36 = [];
        var children37 = [];
        var children38 = [];
        var children39 = [];
        var children40 = [];
        var children41 = [];
        var children42 = [];
        var children43 = [];
        var children44 = [];
        var children45 = [];
        var children46 = [];
        var children47 = [];
        var children48 = [];
        var children49 = [];
        var children50 = [];
        var children51 = [];
        var children52 = [];
        var children53 = [];
        var children54 = [];
        var children55 = [];
        var children56 = [];
        var children57 = [];
        var children58 = [];
        var children59 = [];
        var children60 = [];
        var children61 = [];
        var children62 = [];
        var children63 = [];
        var children64 = [];
        var children65 = [];
        var children66 = [];
        var children67 = [];
        var children68 = [];
        var children69 = [];
        var children70 = [];
        var children71 = [];
        var children72 = [];
        var children73 = [];
        var children74 = [];
        var children75 = [];
        var correctScoreItems = [];
        var correctScoreItems1 = [];
        var correctScoreItems2 = [];

        var item = new Array();
        $.each(details, function(index, detail) {
            item = {
                "m_nGame": res.m_nGame, 
                "m_strSportName": res.m_strSportName, 
                "m_nLeague": res.m_nLeague, 
                "m_strHomeTeam": res.m_strHomeTeam, 
                "m_strAwayTeam": res.m_strAwayTeam, 
                "m_strDate": res.m_strDate, 
                "m_strHour": res.m_strHour, 
                "m_strMin": res.m_strMin, 
                "m_nMarket": detail.m_nMarket, 
                "m_nFamily": detail.m_nFamily, 
                "m_nHBetCode": detail.m_nHBetCode, 
                "m_nDBetCode": detail.m_nDBetCode, 
                "m_nABetCode": detail.m_nABetCode, 
                "m_fHRate": detail.m_fHRate,
                "m_fDRate": detail.m_fDRate, 
                "m_fARate": detail.m_fARate, 
                "m_fHBase": detail.m_fHBase, 
                "m_fDBase": detail.m_fDBase, 
                "m_fABase": detail.m_fABase,
                "m_strHLine": detail.m_strHLine, 
                "m_strDLine": detail.m_strDLine, 
                "m_strALine": detail.m_strALine,
                "m_strHName": detail.m_strHName,
                "m_strDName": detail.m_strDName,
                "m_strAName": detail.m_strAName
            };

            switch(res.m_strSportName) {
                case "??????":
                    switch (detail.m_nMarket) {
                        case 427:
                            header1 = "????????? + ????????????";
                            children1.push(item);
                            break;
                        case 1:
                            // header2 = "?????????";
                            // children2.push(item);
                            break;
                        case 52:
                            header3 = "??????";
                            children3.push(item);
                            break;
                        case 3:
                            header4 = "?????????";
                            children4.push(item);
                            break;
                        case 2:
                            header5 = "????????????";
                            children5.push(item);
                            break;
                        case 41:
                            header6 = "????????? (?????????)&nbsp;";
                            children6.push(item);
                            break;
                        case 42:
                            header7 = "????????? (?????????)&nbsp;";
                            children7.push(item);
                            break;
                        case 64:
                            header8 = "????????? (?????????)&nbsp;";
                            children8.push(item);
                            break;
                        case 65:
                            header9 = "????????? (?????????)&nbsp;";
                            children9.push(item);
                            break;
                        case 21:
                            header10 = "???????????? (?????????)";
                            children10.push(item);
                            break;
                        case 45:
                            header11 = "???????????? (?????????)";
                            children11.push(item);
                            break;
                        case 153:
                            header12 = "???????????? (?????????) - ??????";
                            children12.push(item);
                            break;
                        case 154:
                            header13 = "???????????? (?????????) - ??????";
                            children13.push(item);
                            break;
                        case 155:
                            header14 = "???????????? (?????????) - ?????????";
                            children14.push(item);
                            break;
                        case 156:
                            header15 = "???????????? (?????????) - ?????????";
                            children15.push(item);
                            break;
                        case 101:
                            header16 = "???????????? - ??????";
                            children16.push(item);
                            break;
                        case 102:
                            header17 = "???????????? - ?????????";
                            children17.push(item);
                            break;
                        case 7:
                            header18 = "????????????";
                            children18.push(item);
                            break;
                        case 456:
                            header19 = "???????????? (?????????)";
                            children19.push(item);
                            break;
                        case 457:
                        case 151:
                            header20 = "???????????? (?????????)";
                            children20.push(item);
                            break;
                        case 5:
                            header21 = "??????";
                            children21.push(item);
                            break;
                        case 72:
                            header22 = "?????? (?????????)";
                            children22.push(item);
                            break;
                        case 73:
                            header23 = "?????? (?????????)";
                            children23.push(item);
                            break;
                        case 9:
                            header24 = "????????? ????????? (?????????)";
                            children24.push(item);
                            break;
                        case 100:
                            header25 = "????????? ????????? (?????????)";
                            children25.push(item);
                            break;
                    }
                    break;
                case "??????":
                    switch (detail.m_nMarket) {
                        case 226:
                            // header1 = "??????";
                            // children1.push(item);
                            break;
                        case 342:
                            header2 = "????????? (????????????)";
                            children2.push(item);
                            break;
                        case 28:
                            header3 = "???????????? (????????????)";
                            children3.push(item);
                            break;
                        case 202:
                            header4 = "?????? (1??????)";
                            children4.push(item);
                            break;
                        case 203:
                            header5 = "?????? (2??????)";
                            children5.push(item);
                            break;
                        case 204:
                            header6 = "?????? (3??????)";
                            children6.push(item);
                            break;
                        case 205:
                            header7 = "?????? (4??????)";
                            children7.push(item);
                            break;
                        case 206:
                            header8 = "?????? (5??????)";
                            children8.push(item);
                            break;
                        case 464:
                            header9 = "?????? (????????? ??? ????????????)";
                            children9.push(item);
                            break;
                        case 41:
                            header10 = "????????? (1??????)";
                            children10.push(item);
                            break;
                        case 42:
                            header11 = "????????? (2??????)";
                            children11.push(item);
                            break;
                        case 43:
                            header12 = "????????? (3??????)";
                            children12.push(item);
                            break;
                        case 44:
                            header13 = "????????? (4??????)";
                            children13.push(item);
                            break;
                        case 282:
                            header14 = "????????? (?????????)&nbsp;";
                            children14.push(item);
                            break;
                        case 284:
                            header15 = "????????? (?????????)&nbsp;";
                            children15.push(item);
                            break;
                        case 64:
                            header16 = "????????? (1??????)";
                            children16.push(item);
                            break;
                        case 65:
                            header17 = "????????? (2??????)";
                            children17.push(item);
                            break;
                        case 66:
                            header18 = "????????? (3??????)";
                            children18.push(item);
                            break;
                        case 67:
                            header19 = "????????? (4??????)";
                            children19.push(item);
                            break;
                        case 467:
                            header20 = "????????? (4?????? ??? ????????????)";
                            children20.push(item);
                            break;
                        case 468:
                            header21 = "????????? (????????? ??? ????????????)";
                            children21.push(item);
                            break;
                        case 21:
                            header22 = "???????????? (1??????)";
                            children22.push(item);
                            break;
                        case 45:
                            header23 = "???????????? (2??????)";
                            children23.push(item);
                            break;
                        case 46:
                            header24 = "???????????? (3??????)";
                            children24.push(item);
                            break;
                        case 47:
                            header25 = "???????????? (4??????)";
                            children25.push(item);
                            break;
                        case 77:
                            header26 = "???????????? (?????????)";
                            children26.push(item);
                            break;
                        case 469:
                            header27 = "???????????? (????????? ??? ????????????)";
                            children27.push(item);
                            break;
                        case 153:
                            header28 = "???????????? (1??????) - ??????";
                            children28.push(item);
                            break;
                        case 154:
                            header29 = "???????????? (2??????) - ??????";
                            children29.push(item);
                            break;
                        case 155:
                            header30 = "???????????? (1??????) - ?????????";
                            children30.push(item);
                            break;
                        case 156:
                            header31 = "???????????? (2??????) - ?????????";
                            children31.push(item);
                            break;
                        case 223:
                            header32 = "???????????? (3??????) - ??????";
                            children32.push(item);
                            break;
                        case 222:
                            header33 = "???????????? (3??????) - ?????????";
                            children33.push(item);
                            break;
                        case 287:
                            header34 = "???????????? (4??????) - ??????";
                            children34.push(item);
                            break;
                        case 288:
                            header35 = "???????????? (4??????) - ?????????";
                            children35.push(item);
                            break;
                        case 354:
                            header36 = "???????????? (?????????) - ??????";
                            children36.push(item);
                            break;
                        case 355:
                            header37 = "???????????? (?????????) - ?????????";
                            children37.push(item);
                            break;
                        case 221:
                            header38 = "???????????? (????????????) - ??????";
                            children38.push(item);
                            break;
                        case 220:
                            header39 = "???????????? (????????????) - ?????????";
                            children39.push(item);
                            break;
                        case 51:
                            header40 = "??????";
                            children40.push(item);
                            break;
                        case 72:
                            header41 = "?????? (1??????)";
                            children41.push(item);
                            break;
                        case 73:
                            header42 = "?????? (2??????)";
                            children42.push(item);
                            break;
                        case 74:
                            header43 = "?????? (3??????)";
                            children43.push(item);
                            break;
                        case 75:
                            header44 = "?????? (4??????)";
                            children44.push(item);
                            break;
                        case 76:
                            header45 = "?????? (5??????)";
                            children45.push(item);
                            break;
                        case 242:
                            header46 = "?????? (1??????) - ??????";
                            children46.push(item);
                            break;
                        case 243:
                            header47 = "?????? (1??????) - ?????????&nbsp;";
                            children47.push(item);
                            break;
                        case 289:
                            header48 = "?????? (2??????) - ??????";
                            children48.push(item);
                            break;
                        case 292:
                            header49 = "?????? (2??????) - ?????????&nbsp;";
                            children49.push(item);
                            break;
                        case 290:
                            header50 = "?????? (3??????) - ??????";
                            children50.push(item);
                            break;
                        case 293:
                            header51 = "?????? (3??????) - ?????????&nbsp;";
                            children51.push(item);
                            break;
                        case 291:
                            header52 = "?????? (4??????) - ??????";
                            children52.push(item);
                            break;
                        case 294:
                            header53 = "?????? (4??????) - ?????????&nbsp;";
                            children53.push(item);
                            break;
                        case 285:
                            header54 = "?????? (?????????)";
                            children54.push(item);
                            break;
                        case 198:
                            header55 = "?????? - ??????";
                            children55.push(item);
                            break;
                        case 199:
                            header56 = "?????? - ?????????";
                            children56.push(item);
                            break;
                    }
                    break;
                case "??????":
                    switch (detail.m_nMarket) {
                        case 52:
                            // header1 = "??????";
                            // children1.push(item);
                            break;
                        case 1558:
                            header2 = "????????? [?????????]";
                            children2.push(item);
                            break;
                        case 2:
                            header3 = "????????????";
                            children3.push(item);
                            break;
                        case 202:
                            header4 = "?????? (1??????)";
                            children4.push(item);
                            break;
                        case 203:
                            header5 = "?????? (2??????)";
                            children5.push(item);
                            break;
                        case 204:
                            header6 = "?????? (3??????)";
                            children6.push(item);
                            break;
                        case 205:
                            header7 = "?????? (4??????)";
                            children7.push(item);
                            break;
                        case 206:
                            header8 = "?????? (5??????)";
                            children8.push(item);
                            break;
                        case 64:
                            header9 = "????????? (1??????)";
                            children9.push(item);
                            break;
                        case 65:
                            header10 = "????????? (2??????)";
                            children10.push(item);
                            break;
                        case 66:
                            header11 = "????????? (3??????)";
                            children11.push(item);
                            break;
                        case 67:
                            header12 = "????????? (4??????)";
                            children12.push(item);
                            break;
                        case 68:
                            header13 = "????????? (5??????)";
                            children13.push(item);
                            break;
                        case 21:
                            header14 = "???????????? (1??????)";
                            children14.push(item);
                            break;
                        case 45:
                            header15 = "???????????? (2??????)";
                            children15.push(item);
                            break;
                        case 46:
                            header16 = "???????????? (3??????)";
                            children16.push(item);
                            break;
                        case 47:
                            header17 = "???????????? (4??????)";
                            children17.push(item);
                            break;
                        case 101:
                            header18 = "???????????? - ??????";
                            children18.push(item);
                            break;
                        case 102:
                            header19 = "???????????? - ?????????";
                            children19.push(item);
                            break;
                        case 153:
                            header20 = "???????????? (1??????) - ??????";
                            children20.push(item);
                            break;
                        case 154:
                            header21 = "???????????? (2??????) - ??????";
                            children21.push(item);
                            break;
                        case 155:
                            header22 = "???????????? (1??????) - ?????????";
                            children22.push(item);
                            break;
                        case 156:
                            header23 = "???????????? (2??????) - ?????????";
                            children23.push(item);
                            break;
                        case 5:
                            header24 = "??????";
                            children24.push(item);
                            break;
                        case 72:
                            header25 = "?????? (1??????)";
                            children25.push(item);
                            break;
                        case 73:
                            header26 = "?????? (2??????)";
                            children26.push(item);
                            break;
                        case 74:
                            header27 = "?????? (3??????)";
                            children27.push(item);
                            break;
                        case 75:
                            header28 = "?????? (4??????)";
                            children28.push(item);
                            break;
                        case 76:
                            header29 = "?????? (5??????)";
                            children29.push(item);
                            break;
                        case 9:
                            header30 = "????????? ????????? (1??????)";
                            // children30.push(item);
                            break;
                    }
                    break;
                case "??????":
                    switch (detail.m_nMarket) {
                        case 226:
                            // header1 = "??????";
                            // children1.push(item);
                            break;
                        case 342:
                            header2 = "????????? (????????????)";
                            children2.push(item);
                            break;
                        case 28:
                            header3 = "???????????? (????????????)";
                            children3.push(item);
                            break;
                        case 221:
                            header4 = "???????????? (????????????) - ??????";
                            children4.push(item);
                            break;
                        case 220:
                            header5 = "???????????? (????????????) - ?????????";
                            children5.push(item);
                            break;
                        case 235:
                            header6 = "?????? (1~5??????)";
                            children6.push(item);
                            break;
                        case 41:
                            header7 = "????????? (1??????)";
                            children7.push(item);
                            break;
                        case 42:
                            header8 = "????????? (2??????)";
                            children8.push(item);
                            break;
                        case 43:
                            header9 = "????????? (3??????)";
                            children9.push(item);
                            break;
                        case 44:
                            header10 = "????????? (4??????)";
                            children10.push(item);
                            break;
                        case 348:
                            header11 = "????????? (6??????)";
                            children11.push(item);
                            break;
                        case 349:
                            header12 = "????????? (7??????)";
                            children12.push(item);
                            break;
                        case 524:
                            header13 = "????????? (1~7??????)";
                            children13.push(item);
                            break;
                        case 2057:
                            header14 = "????????? (1~3??????)";
                            children14.push(item);
                            break;
                        case 281:
                            header15 = "????????? (1~5??????)";
                            children15.push(item);
                            break;
                        case 447:
                            header16 = "????????? (6??????)";
                            children16.push(item);
                            break;
                        case 448:
                            header17 = "????????? (7??????)";
                            children17.push(item);
                            break;
                        case 526:
                            header18 = "????????? (1~7??????)";
                            children18.push(item);
                            break;
                        case 449:
                            header19 = "????????? (8??????)";
                            children19.push(item);
                            break;
                        case 450:
                            header20 = "????????? (9??????)";
                            children20.push(item);
                            break;
                        case 21:
                            header21 = "???????????? (1??????)";
                            children21.push(item);
                            break;
                        case 45:
                            header22 = "???????????? (2??????)";
                            children22.push(item);
                            break;
                        case 46:
                            header23 = "???????????? (3??????)";
                            children23.push(item);
                            break;
                        case 1562:
                            header24 = "???????????? (1~3??????)";
                            children24.push(item);
                            break;
                        case 47:
                            header25 = "???????????? (4??????)";
                            children25.push(item);
                            break;
                        case 48:
                            header26 = "???????????? (5??????)";
                            children26.push(item);
                            break;
                        case 236:
                            header27 = "???????????? (1~5??????)";
                            children27.push(item);
                            break;
                        case 352:
                            header28 = "???????????? (6??????)";
                            children28.push(item);
                            break;
                        case 353:
                            header29 = "???????????? (7??????)";
                            children29.push(item);
                            break;
                        case 525:
                            header30 = "???????????? (1~7??????)";
                            children30.push(item);
                            break;
                    }
                    break;
                case "????????? ??????":
                    switch (detail.m_nMarket) {
                        case 1:
                            header1 = "?????????";
                            // children1.push(item);
                            break;
                        case 226:
                            // header2 = "??????";
                            // children2.push(item);
                            break;
                        case 342:
                            header3 = "????????? (????????????)";
                            children3.push(item);
                            break;
                        case 28:
                            header4 = "???????????? (????????????)";
                            children4.push(item);
                            break;
                        case 7:
                            header5 = "????????????";
                            children5.push(item);
                            break;
                        case 202:
                            header6 = "?????? (1????????????)";
                            children6.push(item);
                            break;
                        case 41:
                            header7 = "????????? (1????????????)";
                            children7.push(item);
                            break;
                        case 42:
                            header8 = "????????? (2????????????)";
                            children8.push(item);
                            break;
                        case 43:
                            header9 = "????????? (3????????????)";
                            children9.push(item);
                            break;
                        case 44:
                            header10 = "????????? (4????????????)";
                            children10.push(item);
                            break;
                        case 64:
                            header11 = "????????? (1????????????)";
                            children11.push(item);
                            break;
                        case 65:
                            header12 = "????????? (2????????????)";
                            children12.push(item);
                            break;
                        case 66:
                            header13 = "????????? (3????????????)";
                            children13.push(item);
                            break;
                        case 221:
                            header14 = "???????????? (????????????) - ??????";
                            children14.push(item);
                            break;
                        case 220:
                            header15 = "???????????? (????????????) - ?????????";
                            children15.push(item);
                            break;
                        case 21:
                            header16 = "???????????? (1????????????)";
                            children16.push(item);
                            break;
                        case 45:
                            header17 = "???????????? (2????????????)";
                            children17.push(item);
                            break;
                        case 46:
                            header18 = "???????????? (3????????????)";
                            children18.push(item);
                            break;
                        case 51:
                            header19 = "??????";
                            children19.push(item);
                            break;
                    }
                    break;
                case "E?????????":
                    switch (detail.m_nMarket) {
                        case 52:
                            header2 = "??????";
                            // children2.push(item);
                            break;
                        case 3:
                            header3 = "?????????";
                            children3.push(item);
                            break;
                        case 2:
                            header4 = "????????????";
                            children4.push(item);
                            break;
                        case 202:
                            header5 = "?????? (1??????)";
                            children5.push(item);
                            break;
                        case 64:
                            header6 = "????????? (1??????)";
                            children6.push(item);
                            break;
                        case 1149:
                            header7 = "????????? - ??? (1??????)";
                            children7.push(item);
                            break;
                        case 989:
                            header8 = "???????????? - ??? (1??????)";
                            children8.push(item);
                            break;
                        case 1129:
                            header9 = "???????????? - ?????? ????????? (1??????)";
                            children9.push(item);
                            break;
                        case 1133:
                            header10 = "???????????? - ????????? ????????? (1??????)";
                            children10.push(item);
                            break;
                        case 1162:
                            header11 = "???????????? - ????????? ??? (1??????)";
                            children11.push(item);
                            break;
                        case 1165:
                            header12 = "??? ?????? (1??????)";
                            children12.push(item);
                            break;
                        case 669:
                            header13 = "??? ??? (1??????)";
                            children13.push(item);
                            break;
                        case 1170:
                            header14 = "??? ????????? (1??????)";
                            children14.push(item);
                            break;
                        case 1251:
                            header15 = "??? ????????? (1??????)";
                            children15.push(item);
                            break;
                        case 672:
                            header16 = "??? ??? (1??????)";
                            children16.push(item);
                            break;
                        case 666:
                            header17 = "??? ?????? (1??????)";
                            children17.push(item);
                            break;
                        case 679:
                            header18 = "??? ?????? (1??????)";
                            children18.push(item);
                            break;
                        case 203:
                            header19 = "?????? (2??????)";
                            children19.push(item);
                            break;
                        case 65:
                            header20 = "????????? (2??????)";
                            children20.push(item);
                            break;
                        case 1150:
                            header21 = "????????? - ??? (2??????)";
                            children21.push(item);
                            break;
                        case 990:
                            header22 = "???????????? - ??? (2??????)";
                            children22.push(item);
                            break;
                        case 1130:
                            header23 = "???????????? - ?????? ????????? (2??????)";
                            children23.push(item);
                            break;
                        case 1134:
                            header24 = "???????????? - ????????? ????????? (2??????)";
                            children24.push(item);
                            break;
                        case 1163:
                            header25 = "???????????? - ????????? ??? (2??????)";
                            children25.push(item);
                            break;
                        case 1166:
                            header26 = "??? ?????? (2??????)";
                            children26.push(item);
                            break;
                        case 670:
                            header27 = "??? ??? (2??????)";
                            children27.push(item);
                            break;
                        case 1171:
                            header28 = "??? ????????? (2??????)";
                            children28.push(item);
                            break;
                        case 1252:
                            header29 = "??? ????????? (2??????)";
                            children29.push(item);
                            break;
                        case 673:
                            header30 = "??? ??? (2??????)";
                            children30.push(item);
                            break;
                        case 667:
                            header31 = "??? ?????? (2??????)";
                            children31.push(item);
                            break;
                        case 680:
                            header32 = "??? ?????? (2??????)";
                            children32.push(item);
                            break;
                        case 204:
                            header33 = "?????? (3??????)";
                            children33.push(item);
                            break;
                        case 66:
                            header34 = "????????? (3??????)";
                            children34.push(item);
                            break;
                        case 1151:
                            header35 = "????????? - ??? (3??????)";
                            children35.push(item);
                            break;
                        case 991:
                            header36 = "???????????? - ??? (3??????)";
                            children36.push(item);
                            break;
                        case 1131:
                            header37 = "???????????? - ?????? ????????? (3??????)";
                            children37.push(item);
                            break;
                        case 1135:
                            header38 = "???????????? - ????????? ????????? (3??????)";
                            children38.push(item);
                            break;
                        case 1164:
                            header39 = "???????????? - ????????? ??? (3??????)";
                            children39.push(item);
                            break;
                        case 1167:
                            header40 = "??? ?????? (3??????)";
                            children40.push(item);
                            break;
                        case 671:
                            header41 = "??? ??? (3??????)";
                            children41.push(item);
                            break;
                        case 1172:
                            header42 = "??? ????????? (3??????)";
                            children42.push(item);
                            break;
                        case 1253:
                            header43 = "??? ????????? (3??????)";
                            children43.push(item);
                            break;
                        case 674:
                            header44 = "??? ??? (3??????)";
                            children44.push(item);
                            break;
                        case 668:
                            header45 = "??? ?????? (3??????)";
                            children45.push(item);
                            break;
                        case 681:
                            header46 = "??? ?????? (3??????)";
                            children46.push(item);
                            break;
                        case 205:
                            header47 = "?????? (4??????)";
                            children47.push(item);
                            break;
                        case 67:
                            header48 = "????????? (4??????)";
                            children48.push(item);
                            break;
                        case 1152:
                            header49 = "????????? - ??? (4??????)";
                            children49.push(item);
                            break;
                        case 1147:
                            header50 = "???????????? - ??? (4??????)";
                            children50.push(item);
                            break;
                        case 1523:
                            header51 = "???????????? - ?????? ????????? (4??????)";
                            children51.push(item);
                            break;
                        case 1525:
                            header52 = "???????????? - ????????? ????????? (4??????)";
                            children52.push(item);
                            break;
                        case 1714:
                            header53 = "???????????? - ????????? ??? (4??????)";
                            children53.push(item);
                            break;
                        case 1168:
                            header54 = "??? ?????? (4??????)";
                            children54.push(item);
                            break;
                        case 1123:
                            header55 = "??? ??? (4??????)";
                            children55.push(item);
                            break;
                        case 1173:
                            header56 = "??? ????????? (4??????)";
                            children56.push(item);
                            break;
                        case 1254:
                            header57 = "??? ????????? (4??????)";
                            children57.push(item);
                            break;
                        case 1550:
                            header58 = "??? ??? (4??????)";
                            children58.push(item);
                            break;
                        case 206:
                            header59 = "?????? (5??????)";
                            children59.push(item);
                            break;
                        case 68:
                            header60 = "????????? (5??????)";
                            children60.push(item);
                            break;
                        case 1153:
                            header61 = "????????? - ??? (5??????)";
                            children61.push(item);
                            break;
                        case 1148:
                            header62 = "???????????? - ??? (5??????)";
                            children62.push(item);
                            break;
                        case 1524:
                            header63 = "???????????? - ?????? ????????? (5??????)";
                            children63.push(item);
                            break;
                        case 1526:
                            header64 = "???????????? - ????????? ????????? (5??????)";
                            children64.push(item);
                            break;
                        case 1715:
                            header65 = "???????????? - ????????? ??? (5??????)";
                            children65.push(item);
                            break;
                        case 1169:
                            header66 = "??? ?????? (5??????)";
                            children66.push(item);
                            break;
                        case 1124:
                            header67 = "??? ??? (5??????)";
                            children67.push(item);
                            break;
                        case 1174:
                            header68 = "??? ????????? (5??????)";
                            children68.push(item);
                            break;
                        case 1255:
                            header69 = "??? ????????? (5??????)";
                            children69.push(item);
                            break;
                        case 1551:
                            header70 = "??? ??? (5??????)";
                            children70.push(item);
                            break;
                    }
                    break;
            }
            if(detail.m_nMarket == 6) {
                correctScoreItems.push(item);
            }
        });
        var children_div = "";
        if(res.m_strSportName == "??????") {
            // ????????? + ????????????
            if(children1.length > 0) {
                children_div += div_1x2_unover(children1, header1);
            }

            // ?????????
            if(children2.length > 0) {
                children_div += div_1x2(children2, header2);
            }

            // ??????
            if(children3.length > 0) {
                //children_div += div_12(children3, header3);
            }

            // ?????????
            if(children4.length > 0) {
                children_div += div_handi(children4, header4);
            }

            // ????????????
            if(children5.length > 0) {
                children_div += div_unover(children5, header5);
            }

            // ????????? (?????????)
            if(children6.length > 0) {
                children_div += div_1x2(children6, header6);
            }

            // ????????? (?????????)
            if(children7.length > 0) {
                children_div += div_1x2(children7, header7);
            }

            // ????????? (?????????)
            if(children8.length > 0) {
                children_div += div_handi(children8, header8);
            }

            // ????????? (?????????)
            if(children9.length > 0) {
                children_div += div_handi(children9, header9);
            }

            // ???????????? (?????????)
            if(children10.length > 0) {
                children_div += div_unover(children10, header10);
            }

            // ???????????? (?????????)
            if(children11.length > 0) {
                children_div += div_unover(children11, header11);
            }

            // ???????????? (?????????) - ??????
            if(children12.length > 0) {
                children_div += div_unover(children12, header12);
            }

            // ???????????? (?????????) - ??????
            if(children13.length > 0) {
                children_div += div_unover(children13, header13);
            }

            // ???????????? (?????????) - ?????????
            if(children14.length > 0) {
                children_div += div_unover(children14, header14);
            }

            // ???????????? (?????????) - ?????????
            if(children15.length > 0) {
                children_div += div_unover(children15, header15);
            }

            // ???????????? - ??????
            if(children16.length > 0) {
                children_div += div_unover(children16, header16);
            }

            // ???????????? - ?????????
            if(children17.length > 0) {
                children_div += div_unover(children17, header17);
            }

            // ????????????
            if(children18.length > 0) {
                children_div += div_double(children18, header18);
            }

            // ???????????? (?????????)
            if(children19.length > 0) {
                children_div += div_double(children19, header19);
            }

            // ???????????? (?????????)
            if(children20.length > 0) {
                children_div += div_double(children20, header20);
            }

            // ??????
            if(children21.length > 0) {
                children_div += div_oddeven(children21, header21);
            }

            // ?????? (?????????)
            if(children22.length > 0) {
                children_div += div_oddeven(children22, header22);
            }

            // ?????? (?????????)
            if(children23.length > 0) {
                children_div += div_oddeven(children23, header23);
            }

            // ????????? ????????? (?????????)
            if(children24.length > 0) {
                children_div += div_correctScore(children24, header24);
            }

            // ????????? ????????? (?????????)
            if(children25.length > 0) {
                children_div += div_correctScore(children25, header25);
            }
        } else if(res.m_strSportName == "??????") {
            // ??????
            if(children1.length > 0) {
                children_div += div_12(children1, header1);
            }

            // ?????????
            if(children2.length > 0) {
                children_div += div_handi(children2, header2);
            }

            // ????????????
            if(children3.length > 0) {
                children_div += div_unover(children3, header3);
            }

            // ?????? (1??????)
            if(children4.length > 0) {
                children_div += div_12(children4, header4);
            }

            // ?????? (2??????)
            if(children5.length > 0) {
                children_div += div_12(children5, header5);
            }

            // ?????? (3??????)
            if(children6.length > 0) {
                children_div += div_12(children6, header6);
            }

            // ?????? (4??????)
            if(children7.length > 0) {
                children_div += div_12(children7, header7);
            }

            // ?????? (5??????)
            if(children8.length > 0) {
                children_div += div_12(children8, header8);
            }

            // ?????? (????????? ??? ????????????)
            if(children9.length > 0) {
                children_div += div_12(children9, header9);
            }

            // ????????? (1??????)
            if(children10.length > 0) {
                children_div += div_1x2(children10, header10);
            }

            // ????????? (2??????)
            if(children11.length > 0) {
                children_div += div_1x2(children11, header11);
            }

            // ????????? (3??????)
            if(children12.length > 0) {
                children_div += div_1x2(children12, header12);
            }

            // ????????? (4??????)
            if(children13.length > 0) {
                children_div += div_1x2(children13, header13);
            }

            // ????????? (?????????)
            if(children14.length > 0) {
                children_div += div_1x2(children14, header14);
            }

            // ????????? (?????????)
            if(children15.length > 0) {
                children_div += div_1x2(children15, header15);
            }

            // ????????? (1??????)
            if(children16.length > 0) {
                children_div += div_handi(children16, header16);
            }

            // ????????? (2??????)
            if(children17.length > 0) {
                children_div += div_handi(children17, header17);
            }

            // ????????? (3??????)
            if(children18.length > 0) {
                children_div += div_handi(children18, header18);
            }

            // ????????? (4??????)
            if(children19.length > 0) {
                children_div += div_handi(children19, header19);
            }

            // ????????? (4?????? ??? ????????????)
            if(children20.length > 0) {
                children_div += div_handi(children20, header20);
            }

            // ????????? (????????? ??? ????????????)
            if(children21.length > 0) {
                children_div += div_handi(children21, header21);
            }

            // ???????????? (1??????)
            if(children22.length > 0) {
                children_div += div_unover(children22, header22);
            }

            // ???????????? (2??????)
            if(children23.length > 0) {
                children_div += div_unover(children23, header23);
            }

            // ???????????? (3??????)
            if(children24.length > 0) {
                children_div += div_unover(children24, header24);
            }

            // ???????????? (4??????)
            if(children25.length > 0) {
                children_div += div_unover(children25, header25);
            }

            // ???????????? (?????????)
            if(children26.length > 0) {
                children_div += div_unover(children26, header26);
            }

            // ???????????? (????????? ??? ????????????)
            if(children27.length > 0) {
                children_div += div_unover(children27, header27);
            }

            // ???????????? (1??????) - ??????
            if(children28.length > 0) {
                children_div += div_unover(children28, header28);
            }

            // ???????????? (2??????) - ??????
            if(children29.length > 0) {
                children_div += div_unover(children29, header29);
            }

            // ???????????? (1??????) - ?????????
            if(children30.length > 0) {
                children_div += div_unover(children30, header30);
            }

            // ???????????? (2??????) - ?????????
            if(children31.length > 0) {
                children_div += div_unover(children31, header31);
            }

            // ???????????? (3??????) - ??????
            if(children32.length > 0) {
                children_div += div_unover(children32, header32);
            }

            // ???????????? (3??????) - ?????????
            if(children33.length > 0) {
                children_div += div_unover(children33, header33);
            }

            // ???????????? (4??????) - ??????
            if(children34.length > 0) {
                children_div += div_unover(children34, header34);
            }

            // ???????????? (4??????) - ?????????
            if(children35.length > 0) {
                children_div += div_unover(children35, header35);
            }

            // ???????????? (?????????) - ??????
            if(children36.length > 0) {
                children_div += div_unover(children36, header36);
            }

            // ???????????? (?????????) - ?????????
            if(children37.length > 0) {
                children_div += div_unover(children37, header37);
            }

            // ???????????? (????????????) - ?????? 
            if(children38.length > 0) {
                children_div += div_unover(children38, header38);
            }

            // ???????????? (????????????) - ????????? 
            if(children39.length > 0) {
                children_div += div_unover(children39, header39);
            }

            // ??????
            if(children40.length > 0) {
                children_div += div_oddeven(children40, header40);
            }

            // ?????? (1??????)
            if(children41.length > 0) {
                children_div += div_oddeven(children41, header41);
            }

            // ?????? (2??????)
            if(children42.length > 0) {
                children_div += div_oddeven(children42, header42);
            }

            // ?????? (3??????)
            if(children43.length > 0) {
                children_div += div_oddeven(children43, header43);
            }

            // ?????? (4??????)
            if(children44.length > 0) {
                children_div += div_oddeven(children44, header44);
            }

            // ?????? (5??????)
            if(children45.length > 0) {
                children_div += div_oddeven(children45, header45);
            }

            // ?????? (1??????) - ??????
            if(children46.length > 0) {
                children_div += div_oddeven(children46, header46);
            }

            // ?????? (1??????) - ?????????
            if(children47.length > 0) {
                children_div += div_oddeven(children47, header47);
            }

            // ?????? (2??????) - ??????
            if(children48.length > 0) {
                children_div += div_oddeven(children48, header48);
            }

            // ?????? (2??????) - ?????????
            if(children49.length > 0) {
                children_div += div_oddeven(children49, header49);
            }

            // ?????? (3??????) - ??????
            if(children50.length > 0) {
                children_div += div_oddeven(children50, header50);
            }

            // ?????? (3??????) - ?????????
            if(children51.length > 0) {
                children_div += div_oddeven(children51, header51);
            }

            // ?????? (4??????) - ??????
            if(children52.length > 0) {
                children_div += div_oddeven(children52, header52);
            }

            // ?????? (4??????) - ?????????
            if(children53.length > 0) {
                children_div += div_oddeven(children53, header53);
            }

            // ?????? (?????????)
            if(children54.length > 0) {
                children_div += div_oddeven(children54, header54);
            }

            // ?????? - ??????
            if(children55.length > 0) {
                children_div += div_oddeven(children55, header55);
            }

            // ?????? - ?????????
            if(children56.length > 0) {
                children_div += div_oddeven(children56, header56);
            }
        } else if(res.m_strSportName == "??????") {
            // ??????
            if(children1.length > 0) {
                children_div += div_12(children1, header1);
            }

            // ?????????
            if(children2.length > 0) {
                children_div += div_handi(children2, header2);
            }

            // ????????????
            if(children3.length > 0) {
                children_div += div_unover(children3, header3);
            }

            // ???????????? (????????????) - ??????
            if(children4.length > 0) {
                children_div += div_unover(children4, header4);
            }

            // ???????????? (????????????) - ?????????
            if(children5.length > 0) {
                children_div += div_unover(children5, header5);
            }

            // ?????? (1~5??????)
            if(children6.length > 0) {
                children_div += div_12(children6, header6);
            }

            // ????????? (1??????)
            if(children7.length > 0) {
                children_div += div_1x2(children7, header7);
            }

            // ????????? (2??????)
            if(children8.length > 0) {
                children_div += div_1x2(children8, header8);
            }

            // ????????? (3??????)
            if(children9.length > 0) {
                children_div += div_1x2(children9, header9);
            }

            // ????????? (4??????)
            if(children10.length > 0) {
                children_div += div_1x2(children10, header10);
            }

            // ????????? (6??????)
            if(children11.length > 0) {
                children_div += div_1x2(children11, header11);
            }

            // ????????? (7??????)
            if(children12.length > 0) {
                children_div += div_1x2(children12, header12);
            }

            // ????????? (1~7??????)
            if(children13.length > 0) {
                children_div += div_1x2(children13, header13);
            }

            // ????????? (1~3??????)
            if(children14.length > 0) {
                children_div += div_handi(children14, header14);
            }

            // ????????? (1~5??????)
            if(children15.length > 0) {
                children_div += div_handi(children15, header15);
            }

            // ????????? (6??????)
            if(children16.length > 0) {
                children_div += div_handi(children16, header16);
            }

            // ????????? (7??????)
            if(children17.length > 0) {
                children_div += div_handi(children17, header17);
            }

            // ????????? (1~7??????)
            if(children18.length > 0) {
                children_div += div_handi(children18, header18);
            }

            // ????????? (8??????)
            if(children19.length > 0) {
                children_div += div_handi(children19, header19);
            }

            // ????????? (9??????)
            if(children20.length > 0) {
                children_div += div_handi(children20, header20);
            }

            // ???????????? (1??????)
            if(children21.length > 0) {
                children_div += div_unover(children21, header21);
            }

            // ???????????? (2??????)
            if(children22.length > 0) {
                children_div += div_unover(children22, header22);
            }

            // ???????????? (3??????)
            if(children23.length > 0) {
                children_div += div_unover(children23, header23);
            }

            // ???????????? (1~3??????)
            if(children24.length > 0) {
                children_div += div_unover(children24, header24);
            }

            // ???????????? (4??????)
            if(children25.length > 0) {
                children_div += div_unover(children25, header25);
            }

            // ???????????? (5??????)
            if(children26.length > 0) {
                children_div += div_unover(children26, header26);
            }

            // ???????????? (1~5??????)
            if(children27.length > 0) {
                children_div += div_unover(children27, header27);
            }

            // ???????????? (6??????)
            if(children28.length > 0) {
                children_div += div_unover(children28, header28);
            }

            // ???????????? (7??????)
            if(children29.length > 0) {
                children_div += div_unover(children29, header29);
            }

            // ???????????? (1~7??????)
            if(children30.length > 0) {
                children_div += div_unover(children30, header30);
            }
        } else if(res.m_strSportName == "??????") {
            // ??????
            if(children1.length > 0) {
                children_div += div_12(children1, header1);
            }

            // ????????? [?????????]
            if(children2.length > 0) {
                children_div += div_handi(children2, header2);
            }

            // ????????????
            if(children3.length > 0) {
                children_div += div_unover(children3, header3);
            }

            // ?????? (1??????)
            if(children4.length > 0) {
                children_div += div_12(children4, header4);
            }

            // ?????? (2??????)
            if(children5.length > 0) {
                children_div += div_12(children5, header5);
            }

            // ?????? (3??????)
            if(children6.length > 0) {
                children_div += div_12(children6, header6);
            }

            // ?????? (4??????)
            if(children7.length > 0) {
                children_div += div_12(children7, header7);
            }

            // ?????? (5??????)
            if(children8.length > 0) {
                children_div += div_12(children8, header8);
            }

            // ????????? (1??????)
            if(children9.length > 0) {
                children_div += div_handi(children9, header9);
            }

            // ????????? (2??????)
            if(children10.length > 0) {
                children_div += div_handi(children10, header10);
            }

            // ????????? (3??????)
            if(children11.length > 0) {
                children_div += div_handi(children11, header11);
            }

            // ????????? (4??????)
            if(children12.length > 0) {
                children_div += div_handi(children12, header12);
            }

            // ????????? (5??????)
            if(children13.length > 0) {
                children_div += div_handi(children13, header13);
            }

            // ???????????? (1??????)
            if(children14.length > 0) {
                children_div += div_unover(children14, header14);
            }

            // ???????????? (2??????)
            if(children15.length > 0) {
                children_div += div_unover(children15, header15);
            }

            // ???????????? (3??????)
            if(children16.length > 0) {
                children_div += div_unover(children16, header16);
            }

            // ???????????? (4??????)
            if(children17.length > 0) {
                children_div += div_unover(children17, header17);
            }

            // ???????????? - ??????
            if(children18.length > 0) {
                children_div += div_unover(children18, header18);
            }

            // ???????????? - ?????????
            if(children19.length > 0) {
                children_div += div_unover(children19, header19);
            }

            // ???????????? - ?????? (1??????)
            if(children20.length > 0) {
                children_div += div_unover(children20, header20);
            }

            // ???????????? - ?????? (2??????)
            if(children21.length > 0) {
                children_div += div_unover(children21, header21);
            }

            // ???????????? - ????????? (1??????)
            if(children22.length > 0) {
                children_div += div_unover(children22, header22);
            }

            // ???????????? - ????????? (2??????)
            if(children23.length > 0) {
                children_div += div_unover(children23, header23);
            }

            // ??????
            if(children24.length > 0) {
                children_div += div_oddeven(children24, header24);
            }

            // ?????? (1??????)
            if(children25.length > 0) {
                children_div += div_oddeven(children25, header25);
            }

            // ?????? (2??????)
            if(children26.length > 0) {
                children_div += div_oddeven(children26, header26);
            }

            // ?????? (3??????)
            if(children27.length > 0) {
                children_div += div_oddeven(children27, header27);
            }

            // ?????? (4??????)
            if(children28.length > 0) {
                children_div += div_oddeven(children28, header28);
            }

            // ?????? (5??????)
            if(children29.length > 0) {
                children_div += div_oddeven(children29, header29);
            }

            // ????????? ????????? (1??????)
            if(children30.length > 0) {
                children_div += div_correctScore(children30, header30);
            }
        } else if(res.m_strSportName == "????????? ??????") {
            // ?????????
            if(children1.length > 0) {
                children_div += div_1x2(children1, header1);
            }

            // ??????
            if(children2.length > 0) {
                children_div += div_12(children2, header2);
            }

            // ?????????
            if(children3.length > 0) {
                children_div += div_handi(children3, header3);
            }

            // ????????????
            if(children4.length > 0) {
                children_div += div_unover(children4, header4);
            }

            // ????????????
            if(children5.length > 0) {
                children_div += div_double(children5, header5);
            }

            // ?????? (1????????????)
            if(children6.length > 0) {
                children_div += div_12(children6, header6);
            }

            // ????????? (1????????????)
            if(children7.length > 0) {
                children_div += div_1x2(children7, header7);
            }

            // ????????? (2????????????)
            if(children8.length > 0) {
                children_div += div_1x2(children8, header8);
            }

            // ????????? (3????????????)
            if(children9.length > 0) {
                children_div += div_1x2(children9, header9);
            }

            // ????????? (4????????????)
            if(children10.length > 0) {
                children_div += div_1x2(children10, header10);
            }

            // ????????? (1????????????)
            if(children11.length > 0) {
                children_div += div_handi(children11, header11);
            }

            // ????????? (2????????????)
            if(children12.length > 0) {
                children_div += div_handi(children12, header12);
            }

            // ????????? (3????????????)
            if(children13.length > 0) {
                children_div += div_handi(children13, header13);
            }

            // ???????????? - ??????
            if(children14.length > 0) {
                children_div += div_unover(children14, header14);
            }

            // ???????????? - ?????????
            if(children15.length > 0) {
                children_div += div_unover(children15, header15);
            }


            // ???????????? (1????????????)
            if(children16.length > 0) {
                children_div += div_unover(children16, header16);
            }

            // ???????????? (2????????????)
            if(children17.length > 0) {
                children_div += div_unover(children17, header17);
            }

            // ???????????? (3????????????)
            if(children18.length > 0) {
                children_div += div_unover(children18, header18);
            }

            // ??????
            if(children19.length > 0) {
                children_div += div_oddeven(children19, header19);
            }
        } else if(res.m_strSportName == "E?????????") {
            // ??????
            if(children2.length > 0) {
                children_div += div_12(children2, header2);
            }

            // ?????????
            if(children3.length > 0) {
                children_div += div_handi(children3, header3);
            }

            // ????????????
            if(children4.length > 0) {
                children_div += div_unover(children4, header4);
            }

            // ?????? (1??????)
            if(children5.length > 0) {
                children_div += div_12(children5, header5);
            }

            // ????????? (1??????)
            if(children6.length > 0) {
                children_div += div_handi(children6, header6);
            }

            // ????????? - ??? (1??????)
            if(children7.length > 0) {
                children_div += div_handi(children7, header7);
            }
            
            // ???????????? - ??? (1??????)
            if(children8.length > 0) {
                children_div += div_unover(children8, header8);
            }

            // ???????????? - ?????? ????????? (1??????)
            if(children9.length > 0) {
                children_div += div_unover(children9, header9);
            }

            // ???????????? - ????????? ????????? (1??????)
            if(children10.length > 0) {
                children_div += div_unover(children10, header10);
            }

            // ???????????? - ????????? ??? (1??????)
            if(children11.length > 0) {
                children_div += div_unover(children11, header11);
            }
            
            // ??? ?????? (1??????)
            if(children12.length > 0) {
                children_div += div_12(children12, header12);
            }

            // ??? ??? (1??????)
            if(children13.length > 0) {
                children_div += div_12(children13, header13);
            }
            
            // ??? ????????? (1??????)
            if(children14.length > 0) {
                children_div += div_12(children14, header14);
            }
            
            // ??? ????????? (1??????)
            if(children15.length > 0) {
                children_div += div_12(children15, header15);
            }

            // ??? ??? (1??????)
            if(children16.length > 0) {
                children_div += div_12(children16, header16);
            }
            
            // ??? ?????? (1??????)
            if(children17.length > 0) {
                children_div += div_12(children17, header17);
            }
            
            // ??? ?????? (1??????)
            if(children18.length > 0) {
                children_div += div_12(children18, header18);
            }

            // ?????? (2??????)
            if(children19.length > 0) {
                children_div += div_12(children19, header19);
            }

            // ????????? (2??????)
            if(children20.length > 0) {
                children_div += div_handi(children20, header20);
            }

            // ????????? - ??? (2??????)
            if(children21.length > 0) {
                children_div += div_handi(children21, header21);
            }

            // ???????????? - ??? (2??????)
            if(children22.length > 0) {
                children_div += div_unover(children22, header22);
            }

            // ???????????? - ?????? ????????? (2??????)
            if(children23.length > 0) {
                children_div += div_unover(children23, header23);
            }

            // ???????????? - ????????? ????????? (2??????)
            if(children24.length > 0) {
                children_div += div_unover(children24, header24);
            }

            // ???????????? - ????????? ??? (2??????)
            if(children25.length > 0) {
                children_div += div_unover(children25, header25);
            }

            // ??? ?????? (2??????)
            if(children26.length > 0) {
                children_div += div_12(children26, header26);
            }

            // ??? ??? (2??????)
            if(children27.length > 0) {
                children_div += div_12(children27, header27);
            }

            // ??? ????????? (2??????)
            if(children28.length > 0) {
                children_div += div_12(children28, header28);
            }

            // ??? ????????? (2??????)
            if(children29.length > 0) {
                children_div += div_12(children29, header29);
            }

            // ??? ??? (2??????)
            if(children30.length > 0) {
                children_div += div_12(children30, header30);
            }

            // ??? ?????? (2??????)
            if(children31.length > 0) {
                children_div += div_12(children31, header31);
            }

            // ??? ?????? (2??????)
            if(children32.length > 0) {
                children_div += div_12(children32, header32);
            }

            // ?????? (3??????)
            if(children33.length > 0) {
                children_div += div_12(children33, header33);
            }

            // ????????? (3??????)
            if(children34.length > 0) {
                children_div += div_handi(children34, header34);
            }

            // ????????? - ??? (3??????)
            if(children35.length > 0) {
                children_div += div_handi(children35, header35);
            }

            // ???????????? - ??? (3??????)
            if(children36.length > 0) {
                children_div += div_unover(children36, header36);
            }

            // ???????????? - ?????? ????????? (3??????)
            if(children37.length > 0) {
                children_div += div_unover(children37, header37);
            }

            // ???????????? - ????????? ????????? (3??????)
            if(children38.length > 0) {
                children_div += div_unover(children38, header38);
            }

            // ???????????? - ????????? ??? (3??????)
            if(children39.length > 0) {
                children_div += div_unover(children39, header39);
            }

            // ??? ?????? (3??????)
            if(children40.length > 0) {
                children_div += div_12(children40, header40);
            }

            // ??? ??? (3??????)
            if(children41.length > 0) {
                children_div += div_12(children41, header41);
            }

            // ??? ????????? (3??????)
            if(children42.length > 0) {
                children_div += div_12(children42, header42);
            }

            // ??? ????????? (3??????)
            if(children43.length > 0) {
                children_div += div_12(children43, header43);
            }
            
            // ??? ??? (3??????)
            if(children44.length > 0) {
                children_div += div_12(children44, header44);
            }

            // ??? ?????? (3??????)
            if(children45.length > 0) {
                children_div += div_12(children45, header45);
            }

            // ??? ?????? (3??????)
            if(children46.length > 0) {
                children_div += div_12(children46, header46);
            }

            // ?????? (4??????)
            if(children47.length > 0) {
                children_div += div_12(children47, header47);
            }

            // ????????? (4??????)
            if(children48.length > 0) {
                children_div += div_handi(children48, header48);
            }

            // ????????? - ??? (4??????)
            if(children49.length > 0) {
                children_div += div_handi(children49, header49);
            }

            // ???????????? - ??? (4??????)
            if(children50.length > 0) {
                children_div += div_unover(children50, header50);
            }

            // ???????????? - ?????? ????????? (4??????)
            if(children51.length > 0) {
                children_div += div_unover(children51, header51);
            }

            // ???????????? - ????????? ????????? (4??????)
            if(children52.length > 0) {
                children_div += div_unover(children52, header52);
            }

            // ???????????? - ????????? ??? (4??????)
            if(children53.length > 0) {
                children_div += div_unover(children53, header53);
            }

            // ??? ?????? (4??????)
            if(children54.length > 0) {
                children_div += div_12(children54, header54);
            }

            // ??? ??? (4??????)
            if(children55.length > 0) {
                children_div += div_12(children55, header55);
            }

            // ??? ????????? (4??????)
            if(children56.length > 0) {
                children_div += div_12(children56, header56);
            }

            // ??? ????????? (4??????)
            if(children57.length > 0) {
                children_div += div_12(children57, header57);
            }

            // ??? ??? (4??????)
            if(children58.length > 0) {
                children_div += div_12(children58, header58);
            }

            // ?????? (5??????)
            if(children59.length > 0) {
                children_div += div_12(children59, header59);
            }

            // ????????? (5??????)
            if(children60.length > 0) {
                children_div += div_handi(children60, header60);
            }

            // ????????? - ??? (5??????)
            if(children61.length > 0) {
                children_div += div_handi(children61, header61);
            }

            // ???????????? - ??? (5??????)
            if(children62.length > 0) {
                children_div += div_unover(children62, header62);
            }

            // ???????????? - ?????? ????????? (5??????)
            if(children63.length > 0) {
                children_div += div_unover(children63, header63);
            }

            // ???????????? - ????????? ????????? (5??????)
            if(children64.length > 0) {
                children_div += div_unover(children64, header64);
            }

            // ???????????? - ????????? ??? (5??????)
            if(children65.length > 0) {
                children_div += div_unover(children65, header65);
            }

            // ??? ?????? (5??????)
            if(children66.length > 0) {
                children_div += div_12(children66, header66);
            }

            // ??? ??? (5??????)
            if(children67.length > 0) {
                children_div += div_12(children67, header67);
            }

            // ??? ????????? (5??????)
            if(children68.length > 0) {
                children_div += div_12(children68, header68);
            }

            // ??? ????????? (5??????)
            if(children69.length > 0) {
                children_div += div_12(children69, header69);
            }

            // ??? ??? (5??????)
            if(children70.length > 0) {
                children_div += div_12(children70, header70);
            }
        }
        if(correctScoreItems.length > 0) {
            children_div += div_correctScore(correctScoreItems, "????????? ?????????");
        }
        $('#betting_section_' + res.m_nFixtureID).html( children_div );
    }

    // ?????? Div
    function div_12(children_array, header) {
        var div_id = `div_${children_array[0].m_nGame}_${children_array[0].m_nMarket}`;
        var children_div = "";
        children_div += `<div class="list_st5" id="${div_id}">`;
        children_div += '<ul><li class="tr2">' + header + '</li>';
        $.each(children_array, function(index, item) {
            var sub_idx = `${item.m_nGame}_${item.m_nMarket}_${item.m_nFamily}`;
            children_div += '<li>';
            children_div += '<div style="display:none">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + item.m_strSportName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + item.m_nMarket + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + item.m_strHomeTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + item.m_fHRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + item.m_fDRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + item.m_strAwayTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + item.m_fARate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + item.m_strDate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_market_name" value="' + header + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + item.m_nHBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + item.m_nABetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + item.m_nDBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + item.m_strHLine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + item.m_strALine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + item.m_strHName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + item.m_nLeague + '"></div>';
            children_div += "<div class='st_wd50_l2 selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','0','" + item.m_nHBetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += item.m_strHomeTeam; 
            children_div += '<span class="txt_co5"></span></span>';
            children_div += '<span class="f_right txt_co14" id="' + item.m_nHBetCode + '">' + item.m_fHRate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nHBetCode}_chk" name="ch" value="1" style="display:none;"></div>`;
            children_div += '<div name="' + sub_idx + '_div" style="display:none">';
            children_div += '<input type="checkbox" name="ch" value="3"></div>';
            children_div += "<div class='st_wd50_l2 selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','2','" + item.m_nABetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += item.m_strAwayTeam;  
            children_div += '<span class="txt_co5"></span></span>';
            children_div += '<span class="f_right txt_co14" id="' + item.m_nABetCode + '">' + item.m_fARate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nABetCode}_chk" name="ch" value="2" style="display:none;">`;
            children_div += '</div></li>';
        });
        children_div += '</ul></div>';
        return children_div;
    }

    // ????????? 
    function div_1x2(children_array, header) {
        var div_id = `div_${children_array[0].m_nGame}_${children_array[0].m_nMarket}`;
        var children_div = "";
        children_div += `<div class="list_st5" id="${div_id}">`;
        children_div += '<ul><li class="tr2">' + header + '</li>';
        $.each(children_array, function(index, item) {
            var sub_idx = `${item.m_nGame}_${item.m_nMarket}_${item.m_nFamily}`;
            children_div += '<li>';
            children_div += '<div style="display:none">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + item.m_strSportName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + item.m_nMarket + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + item.m_strHomeTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + item.m_fHRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + item.m_fDRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + item.m_strAwayTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + item.m_fARate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + item.m_strDate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_market_name" value="' + header + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + item.m_nHBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + item.m_nABetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + item.m_nDBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + item.m_strHLine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + item.m_strALine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + item.m_strHName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + item.m_nLeague + '"></div>';
            children_div += "<div class='st_wd33_l2  selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','0','" + item.m_nHBetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += item.m_strHomeTeam; 
            children_div += '<span class="txt_co5"></span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nHBetCode + '">' + item.m_fHRate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nHBetCode}_chk" name="ch" value="1" style="display:none;"></div>`;
            children_div += "<div class='st_wd33_l2  selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','1','" + item.m_nDBetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += '?????????'; 
            children_div += '<span class="txt_co5"></span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nDBetCode + '">' +  item.m_fDRate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nDBetCode}_chk" name="ch" value="3" style="display:none;"></div>`;
            children_div += "<div class='st_wd33_l2  selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','2','" + item.m_nABetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += item.m_strAwayTeam;  
            children_div += '<span class="txt_co5"></span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nABetCode + '">' +  item.m_fARate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nABetCode}_chk" name="ch" value="2" style="display:none;"></div></li>`;
        });
        children_div += '</ul></div>';
        return children_div;
    }

    // ?????????
    function div_handi(children_array, header) {
        var div_id = `div_${children_array[0].m_nGame}_${children_array[0].m_nMarket}`;
        var children_div = "";
        children_div += `<div class="list_st5" id="${div_id}">`;
        children_div += '<ul><li class="tr2">' + header + '</li>';
        $.each(children_array, function(index, item) {
            var sub_idx = `${item.m_nGame}_${item.m_nMarket}_${item.m_nFamily}_${index}`;
            children_div += '<li>';
            children_div += '<div style="display:none">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + item.m_strSportName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + item.m_nMarket + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + item.m_strHomeTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + item.m_fHRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + item.m_fDRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + item.m_strAwayTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + item.m_fARate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + item.m_strDate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_market_name" value="' + header + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + item.m_nHBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + item.m_nABetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + item.m_nDBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + item.m_strHLine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + item.m_strALine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + item.m_strHName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + item.m_nLeague + '"></div>';
            children_div += "<div class='st_wd50_l2  selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','0','" + item.m_nHBetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += item.m_strHomeTeam;   
            var home_points = item.m_strHLine.split(" ");
            children_div += '<span class="txt_co5">&nbsp;' +  home_points[0] + ' </span></span>'; 
            children_div += '<span class="f_right txt_col4" id="' + item.m_nHBetCode + '"> ' + item.m_fHRate.toFixed(2) + ' </span>';
            children_div += `<input type="checkbox" id="${item.m_nHBetCode}_chk" name="ch" value="1" style="display:none;"></div>`;
            children_div += '<div name="' + sub_idx + '_div" style="display:none">';
            children_div += '<input type="checkbox" name="ch" value="3"></div>';
            children_div += "<div class='st_wd50_l2 selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','2','" + item.m_nABetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += item.m_strAwayTeam;
            var away_points = item.m_strALine.split(" ");
            children_div += '<span class="txt_co5">&nbsp;' +  away_points[0] + ' </span></span>'; 
            children_div += '<span class="f_right txt_col4" id="' + item.m_nABetCode + '">' +  item.m_fARate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nABetCode}_chk" name="ch" value="2" style="display:none;"></div></li>`;
        });
        children_div += '</ul></div>';
        return children_div;
    }

    // ????????????
    function div_unover(children_array, header) {
        var div_id = `div_${children_array[0].m_nGame}_${children_array[0].m_nMarket}`;
        var children_div = "";
        children_div += `<div class="list_st5" id="${div_id}">`;
        children_div += '<ul><li class="tr2">' + header + '</li>';
        $.each(children_array, function(index, item) {
            var sub_idx = `${item.m_nGame}_${item.m_nMarket}_${item.m_nFamily}_${index}`;
            children_div += '<li>';
            children_div += '<div style="display:none">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + item.m_strSportName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + item.m_nMarket + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + item.m_strHomeTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + item.m_fHRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + item.m_fDRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + item.m_strAwayTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + item.m_fARate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + item.m_strDate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_market_name" value="' + header + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + item.m_nHBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + item.m_nABetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + item.m_nDBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + item.m_strHLine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + item.m_strALine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + item.m_strHName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + item.m_nLeague + '"></div>';
            children_div += "<div class='st_wd50_l2  selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','0','" + item.m_nHBetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += '??????'; 
            children_div += '<span class="txt_co5">&nbsp;' +  item.m_strHLine + '</span></span>';
            children_div += '<span class="f_right txt_col4" id="' + item.m_nHBetCode + '"> ' + item.m_fHRate.toFixed(2) + '  </span>';
            children_div += `<input type="checkbox" id="${item.m_nHBetCode}_chk" name="ch" value="1" style="display:none;"></div>`;
            children_div += '<div name="' + sub_idx + '_div" style="display:none">';
            children_div += '<input type="checkbox" name="ch" value="3"></div>';
            children_div += "<div class='st_wd50_l2 selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','2','" + item.m_nABetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += '??????'; 
            children_div += '<span class="txt_co5">&nbsp;' +  item.m_strALine + '</span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nABetCode + '"> ' +  item.m_fARate.toFixed(2) + ' </span>';
            children_div += `<input type="checkbox" id="${item.m_nABetCode}_chk" name="ch" value="2" style="display:none;"></div></li>`;
        });
        children_div += '</ul></div>';
        return children_div;
    }

    // ??????
    function div_oddeven(children_array, header) {
        var div_id = `div_${children_array[0].m_nGame}_${children_array[0].m_nMarket}`;
        var children_div = "";
        children_div += `<div class="list_st5" id="${div_id}">`;
        children_div += '<ul><li class="tr2">' + header + '</li>';
        $.each(children_array, function(index, item) {
            var sub_idx = `${item.m_nGame}_${item.m_nMarket}_${item.m_nFamily}`;
            children_div += '<li>';
            children_div += '<div style="display:none">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + item.m_strSportName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + item.m_nMarket + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + item.m_strHomeTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + item.m_fHRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + item.m_fDRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + item.m_strAwayTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + item.m_fARate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + item.m_strDate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_market_name" value="' + header + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + item.m_nHBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + item.m_nABetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + item.m_nDBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + item.m_strHLine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + item.m_strALine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + item.m_strHName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + item.m_nLeague + '"></div>';
            children_div += "<div class='st_wd50_l2 selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','0','" + item.m_nHBetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += '??????'; 
            children_div += '<span class="txt_co5"></span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nHBetCode + '"> ' + item.m_fHRate.toFixed(2) + ' </span>';
            children_div += `<input type="checkbox" id="${item.m_nHBetCode}_chk" name="ch" value="1" style="display:none;"></div>`;
            children_div += '<div name="' + sub_idx + '_div" style="display:none">';
            children_div += '<input type="checkbox" name="ch" value="3"></div>';
            children_div += "<div class='st_wd50_l2 selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','2','" + item.m_nABetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += '??????'; 
            children_div += '<span class="txt_co5"></span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nABetCode + '"> ' + item.m_fARate.toFixed(2) + ' </span>';
            children_div += `<input type="checkbox" id="${item.m_nABetCode}_chk" name="ch" value="2" style="display:none;"></div></li>`;
        });
        children_div += '</ul></div>';
        return children_div;
    }

    // ????????? ?????????
    function div_correctScore(children_array, header) {
        var div_id = `div_${children_array[0].m_nGame}_${children_array[0].m_nMarket}`;
        var children_div = "";
        children_div += `<div class="list_st5" id="${div_id}">`;
        children_div += '<ul><li class="tr2">' + header + '</li>';
        $i = 0;
        $.each(children_array, function(index, item) {
            var sub_idx = `${item.m_nGame}_${item.m_nMarket}_${item.m_nFamily}_${index}`;
            $i++;
            if($i % 3 == 1) {
                children_div += '<li>';
            }
            children_div += "<div class='st_wd33_l2  selectable' name='" + sub_idx + "_div'  onclick=onMultiTeamSelected('" + sub_idx + "','0','" + item.m_nHBetCode + "')>";
            children_div += '<div style="display:none">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + item.m_strSportName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + item.m_nMarket + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + item.m_strHomeTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + item.m_fHRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + item.m_fDRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + item.m_strAwayTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + item.m_fARate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + item.m_strDate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_market_name" value="' + header + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + item.m_nHBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + item.m_nABetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + item.m_nDBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + item.m_strHLine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + item.m_strALine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + item.m_strHName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + item.m_nLeague + '"></div>';
            children_div += '<span class="listName list_wd_65">';
            children_div += item.m_strHName;
            children_div += '<span class="txt_co5"></span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nHBetCode + '">' + item.m_fHRate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nHBetCode}_chk" name="ch" value="1" style="display:none;"></div>`;
            children_div += '<div name="' + sub_idx + '_div" style="display:none">';
            children_div += '<input type="checkbox" name="ch" value="3"></div>';
            children_div += "<div name='" + sub_idx + "_div' style='display:none'>";
            children_div += '<input type="checkbox" name="ch" value="2"></div>';
            if($i % 3 == 0) {
                children_div += '</li>';
            } 

        });
        children_div += '</ul></div>';   
        return children_div;
    }

    // ????????? + ????????????
    function div_1x2_unover(children_array, header) {
        var div_id = `div_${children_array[0].m_nGame}_${children_array[0].m_nMarket}`;
        var children_div = "";
        children_div += `<div class="list_st5" id="${div_id}">`;
        children_div += '<ul><li class="tr2">' + header + '</li>';
        $i = 0;
        $.each(children_array, function(index, item) {
            var sub_idx = `${item.m_nGame}_${item.m_nMarket}_${item.m_nFamily}_${index}`;
            $i++;
            if($i % 2 == 1) {
                children_div += '<li>';
            }
            children_div += "<div class='st_wd50_l2  selectable' name='" + sub_idx + "_div'  onclick=onMultiTeamSelected('" + sub_idx + "','0','" + item.m_nHBetCode + "')>";
            children_div += '<div style="display:none">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + item.m_strSportName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + item.m_nMarket + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + item.m_strHomeTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + item.m_fHRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + item.m_fDRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + item.m_strAwayTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + item.m_fARate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + item.m_strDate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_market_name" value="' + header + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + item.m_nHBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + item.m_nABetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + item.m_nDBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + item.m_strHLine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + item.m_strALine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + item.m_strHName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + item.m_nLeague + '"></div>';
            children_div += '<span class="listName list_wd_65">';
            switch(item.m_strHName) {
                case "1 And Under":
                    children_div += "?????? & ??????";
                    break;
                case "1 And Over":
                    children_div += "?????? & ??????";
                    break;
                case "2 And Under":
                    children_div += "????????? & ??????";
                    break;
                case "2 And Over":
                    children_div += "????????? & ??????";
                    break;
                case "X And Under":
                    children_div += "??? & ??????";
                    break;
                case "X And Over":
                    children_div += "??? & ??????";
                    break;
            }
            children_div += '<span class="txt_co5">&nbsp;' +  item.m_strHLine + '</span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nHBetCode + '">' + item.m_fHRate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nHBetCode}_chk" name="ch" value="1" style="display:none;"></div>`;
            children_div += '<div name="' + sub_idx + '_div" style="display:none">';
            children_div += '<input type="checkbox" name="ch" value="3"></div>';
            children_div += "<div name='" + sub_idx + "_div' style='display:none'>";
            children_div += '<input type="checkbox" name="ch" value="2"></div>';
            if($i % 2 == 0) {
                children_div += '</li>';
            } 

        });
        children_div += '</ul></div>';  
        return children_div;
    }

    // ???????????? 
    function div_double(children_array, header) {
        var div_id = `div_${children_array[0].m_nGame}_${children_array[0].m_nMarket}`;
        var children_div = "";
        children_div += `<div class="list_st5" id="${div_id}">`;
        children_div += '<ul><li class="tr2">' + header + '</li>';
        $.each(children_array, function(index, item) {
            var sub_idx = `${item.m_nGame}_${item.m_nMarket}_${item.m_nFamily}`;
            children_div += '<li>';
            children_div += '<div style="display:none">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + item.m_strSportName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + item.m_nMarket + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + item.m_strHomeTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + item.m_fHRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + item.m_fDRate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + item.m_strAwayTeam + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + item.m_fARate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + item.m_strDate + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_market_name" value="' + header + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + item.m_nHBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + item.m_nABetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + item.m_nDBetCode + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + item.m_strHLine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + item.m_strALine + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + item.m_strHName + '">';
            children_div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + item.m_nLeague + '"></div>';
            children_div += "<div class='st_wd33_l2  selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','0','" + item.m_nHBetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += '??????'; 
            children_div += '<span class="txt_co5"></span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nHBetCode + '">' + item.m_fHRate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nHBetCode}_chk" name="ch" value="1" style="display:none;"></div>`;
            children_div += "<div class='st_wd33_l2  selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','1','" + item.m_nDBetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += '??????'; 
            children_div += '<span class="txt_co5"></span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nDBetCode + '">' +  item.m_fDRate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nDBetCode}_chk" name="ch" value="3" style="display:none;"></div>`;
            children_div += "<div class='st_wd33_l2  selectable' name='" + sub_idx + "_div' onclick=onMultiTeamSelected('" + sub_idx + "','2','" + item.m_nABetCode + "')>";
            children_div += '<span class="listName list_wd_65">';
            children_div += '??????';  
            children_div += '<span class="txt_co5"></span></span>'; 
            children_div += '<span class="f_right txt_co14" id="' + item.m_nABetCode + '">' +  item.m_fARate.toFixed(2) + '</span>';
            children_div += `<input type="checkbox" id="${item.m_nABetCode}_chk" name="ch" value="2" style="display:none;"></div></li>`;
        });
        children_div += '</ul></div>';
        return children_div;
    }

</script>
