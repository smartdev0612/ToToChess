
<?php
	$gameType = $TPL_VAR["game_type"];
	$sportType = $TPL_VAR["sport_type"];

	$pb_n_oe = $TPL_VAR["mini_odds"]["pb_n_oe"];
	$pb_n_uo = $TPL_VAR["mini_odds"]["pb_n_uo"];
	$pb_p_oe = $TPL_VAR["mini_odds"]["pb_p_oe"];
	$pb_p_uo = $TPL_VAR["mini_odds"]["pb_p_uo"];
	$pb_n_bs_a = $TPL_VAR["mini_odds"]["pb_n_bs_a"];
	$pb_n_bs_d = $TPL_VAR["mini_odds"]["pb_n_bs_d"];
	$pb_n_bs_h = $TPL_VAR["mini_odds"]["pb_n_bs_h"];
	$pb_p_n = $TPL_VAR["mini_odds"]["pb_p_n"];
	$pb_p_02 = $TPL_VAR["mini_odds"]["pb_p_02"];
	$pb_p_34 = $TPL_VAR["mini_odds"]["pb_p_34"];
	$pb_p_56 = $TPL_VAR["mini_odds"]["pb_p_56"];
	$pb_p_79 = $TPL_VAR["mini_odds"]["pb_p_79"];
	$pb_p_o_un = $TPL_VAR["mini_odds"]["pb_p_o_un"];
	$pb_p_e_un = $TPL_VAR["mini_odds"]["pb_p_e_un"];
	$pb_p_o_ov = $TPL_VAR["mini_odds"]["pb_p_o_ov"];
	$pb_p_e_ov = $TPL_VAR["mini_odds"]["pb_p_e_ov"];
    $pb_n_o_un = $TPL_VAR["mini_odds"]["pb_n_o_un"];
	$pb_n_e_un = $TPL_VAR["mini_odds"]["pb_n_e_un"];
	$pb_n_o_ov = $TPL_VAR["mini_odds"]["pb_n_o_ov"];
	$pb_n_e_ov = $TPL_VAR["mini_odds"]["pb_n_e_ov"];
?>
    <div class="mask"></div>
	<div id="container">
	
<script language='javascript' src='/10bet/js/calendar2.js'></script>
<script type="text/javascript" src="/10bet/skin/board/betting/js/script.js"></script>
<!--[if lte ie 8]>-->
<script type="text/javascript" src="/10bet/js/math.ie8.shim.min.js"></script>
<script type="text/javascript" src="/10bet/js/math.ie8.sham.min.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="/10bet/js/math.min.js"></script>
<script>math.config({number: 'BigNumber'});</script>
<script type="text/javascript" src="/10bet/skin/board/betting/js/float_layer.js?1611081183"></script>
<!-- 게시판 목록 시작 -->
<script>
    var limit_time = <?php echo $TPL_VAR["mini_config"]["power_limit"]?>;
    var limit_start = "<?php echo $TPL_VAR["mini_config"]["power_limit_start"]?>";
    var limit_end = "<?php echo $TPL_VAR["mini_config"]["power_limit_end"]?>";
    var now = new Date();
    var pieces = limit_start.split(":");
    var startHour = parseInt(pieces[0]);
    var startMin = parseInt(pieces[1]);
    var strStartTime = getStrDatetime(now, startHour, startMin);
    
    pieces = limit_end.split(":");
    var endHour = parseInt(pieces[0]);
    var endMin = parseInt(pieces[1]);
    var strEndTime = getStrDatetime(now, endHour, endMin);
    
    <?php if($TPL_VAR["mini_config"]["power"] == 0) {?>
        warning_popup('파워볼 미니게임은 현재 점검중입니다.\n이용에 불편을 드려 죄송합니다.');
        document.location.href='/';
    <?php }  else { ?>
        if(new Date(strStartTime) < now && now < new Date(strEndTime)) {
            warning_popup('파워볼 미니게임은 현재 점검중입니다.\n이용에 불편을 드려 죄송합니다.');
            document.location.href='/';
        }
    <?php } ?>
</script>
<style>
    .ko_sports_game img {vertical-align:middle;}
    .display_none {display:none;}
    .title_area h4 {width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;}
</style>

<div id="contents">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
        <tr>
            <td valign="top">
                <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" align="left" style="position:relative;background-color:rgba(0,0,0,0.8);">
                    <tr>
                        <td valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" valign="top" >
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" valign="top" >
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                                        <tr>
                                                            <td valign="top" width="100%" height="500">
                                                                <!-- 헤더 -->
                                                                <div class="mini_game_bet">
                                                                    <h2>파워볼</h2>	
                                                                    <div class="game_box">
                                                                        <div class="view_section">
                                                                            <div id="game_view" class="game_view">
                                                                                <iframe class="frameScale" scrolling="no" src="http://ntry.com/scores/powerball/live.php" frameborder="0" width="870" height="641" style="margin-top:10px; margin-left:3px;"></iframe>
                                                                            </div>
                                                                        </div>
                                                                        <form name="betForm">
                                                                            <div id="gamelist" class="bet_section">
                                                                                <div class="time_box">
                                                                                    <h3 class="gameDh"></h3>
                                                                                    <div id="time-limit" class="time_area"></div>
                                                                                    <div class="btn_center"><button type="button" class="button_type01" onclick="location.reload()">새로고침</button></div>
                                                                                </div>
                                                                                <div class="bet_cart_box">
                                                                                    <div class="bet_list01">
                                                                                        <div class="list_box01">
                                                                                            <h4>일반볼</h4>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n-oe-o btn_blue" onclick="gameSelect('n-oe-o','<?php echo $pb_n_oe?>');">
                                                                                                        홀
                                                                                                        <span class="bedd"><?php echo $pb_n_oe?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n-oe-e btn_red" onclick="gameSelect('n-oe-e','<?php echo $pb_n_oe?>');">
                                                                                                        짝
                                                                                                        <span class="bedd"><?php echo $pb_n_oe?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n-uo-u btn_blue" onclick="gameSelect('n-uo-u','<?php echo $pb_n_uo?>');">
                                                                                                        언더
                                                                                                        <span class="bedd"><?php echo $pb_n_uo?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n-uo-o btn_red" onclick="gameSelect('n-uo-o','<?php echo $pb_n_uo?>');">
                                                                                                        오버
                                                                                                        <span class="bedd"><?php echo $pb_n_uo?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="list_box01">
                                                                                            <h4>일반볼 조합</h4>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n_o-un btn_blue" onclick="gameSelect('n_o-un','<?php echo $pb_n_o_un?>');">
                                                                                                        홀언더
                                                                                                        <span class="bedd"><?php echo $pb_n_o_un?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n_o-over btn_red" onclick="gameSelect('n_o-over','<?php echo $pb_n_o_ov?>');">
                                                                                                        홀오버
                                                                                                        <span class="bedd"><?php echo $pb_n_o_ov?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n_e-un btn_blue" onclick="gameSelect('n_e-un','<?php echo $pb_n_e_un?>');">
                                                                                                        짝언더
                                                                                                        <span class="bedd"><?php echo $pb_n_e_un?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n_e-over btn_red" onclick="gameSelect('n_e-over','<?php echo $pb_n_e_ov?>');">
                                                                                                        짝오버
                                                                                                        <span class="bedd"><?php echo $pb_n_e_ov?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="list_box01">
                                                                                            <h4>파워볼</h4>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_p-oe-o btn_blue" onclick="gameSelect('p-oe-o','<?php echo $pb_p_oe?>');">
                                                                                                        홀
                                                                                                        <span class="bedd"><?php echo $pb_p_oe?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_p-oe-e btn_red" onclick="gameSelect('p-oe-e','<?php echo $pb_p_oe?>');">
                                                                                                        짝
                                                                                                        <span class="bedd"><?php echo $pb_p_oe?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_p-uo-u btn_blue" onclick="gameSelect('p-uo-u','<?php echo $pb_p_uo?>');">
                                                                                                        언더
                                                                                                        <span class="bedd"><?php echo $pb_p_uo?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_p-uo-o btn_red" onclick="gameSelect('p-uo-o','<?php echo $pb_p_uo?>');">
                                                                                                        오버
                                                                                                        <span class="bedd"><?php echo $pb_p_uo?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="list_box01">
                                                                                            <h4>파워볼 조합</h4>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_p_o-un btn_blue" onclick="gameSelect('p_o-un','<?php echo $pb_p_o_un?>');">
                                                                                                        홀언더
                                                                                                        <span class="bedd"><?php echo $pb_p_o_un?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_p_o-over btn_red" onclick="gameSelect('p_o-over','<?php echo $pb_p_o_ov?>');">
                                                                                                        홀오버
                                                                                                        <span class="bedd"><?php echo $pb_p_o_ov?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_p_e-un btn_blue" onclick="gameSelect('p_e-un','<?php echo $pb_p_e_un?>');">
                                                                                                        짝언더
                                                                                                        <span class="bedd"><?php echo $pb_p_e_un?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_p_e-over btn_red" onclick="gameSelect('p_e-over','<?php echo $pb_p_e_ov?>');">
                                                                                                        짝오버
                                                                                                        <span class="bedd"><?php echo $pb_p_e_ov?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- <div class="list_box01">
                                                                                            <h4>일반볼 구간</h4>
                                                                                            <div class="bet_btn02">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n-bs-a btn_blue" onclick="gameSelect('n-bs-a','<?php echo $pb_n_bs_a?>');">
                                                                                                        소
                                                                                                        <span class="count">15-64</span>
                                                                                                        <span class="bedd"><?php echo $pb_n_bs_a?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n-bs-d btn_green" onclick="gameSelect('n-bs-d','<?php echo $pb_n_bs_d?>');">
                                                                                                        중
                                                                                                        <span class="count">65-80</span>
                                                                                                        <span class="bedd"><?php echo $pb_n_bs_d?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_n-bs-h btn_red" onclick="gameSelect('n-bs-h','<?php echo $pb_n_bs_h?>');">
                                                                                                        대
                                                                                                        <span class="count">81-130</span>
                                                                                                        <span class="bedd"><?php echo $pb_n_bs_h?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div> -->
                                                                                    </div>
                                                                                    <div id="gamelist" class="bet_section" style="width:100%;">
                                                                                        <div class="bet_cart_box">
                                                                                            <div id="betting_disable"></div>
                                                                                            <div class="bet_cart">
                                                                                                <div class="info_bet">
                                                                                                    <div class="info_box">
                                                                                                        <div class="game01">
                                                                                                            <h4 style="width:40%;">게임분류 <span>파워볼</span></h4>
                                                                                                            <h4>게임선택 <span id="stGameTitle" style="right:-30px;"></span></h4>
                                                                                                        </div>
                                                                                                        <div class="game01">
                                                                                                            <h4 style="width:100%;">보유금액 <span class="member_inmoney"><?php echo number_format($TPL_VAR["cash"],0)?></span></h4>
                                                                                                        </div>
                                                                                                        <div class="dividend">배당 <span id="sp_bet"></span></div>
                                                                                                        <div class="div_pay">적중금액<span id="sp_total">0</span></div>
                                                                                                    </div>
                                                                                                    <div class="btn_box">
                                                                                                        <div><button type="button" onclick="moneyPlus('5000');">5,000</button></div>
                                                                                                        <div><button type="button" onclick="moneyPlus('10000');">10,000</button></div>
                                                                                                        <div><button type="button" onclick="moneyPlus('100000');">100,000</button></div>
                                                                                                        <div><button type="button" onclick="moneyPlus('300000');">300,000</button></div>
                                                                                                        <div><button type="button" onclick="moneyPlus('500000');">500,000</button></div>
                                                                                                        <div><button type="button" onclick="moneyPlus('1000000');">1,000,000</button></div>
                                                                                                        <div><button type="button" onclick="moneyPlus('reset');">초기화</button></div>
                                                                                                        <div><button type="button" onclick="moneyPlus('all');">올인</button></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="bet_moeny">
                                                                                                    배팅금액
                                                                                                    <input type="text" id="betMoney" name="betMoney" class="input_betmoney" value="0" onkeyUp="javascript:this.value=onMoneyChange(this.value);" placeholder="0">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="btn_minigame">
                                                                                                <button type="button" onclick="gameBetting();">배팅하기</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="board_box">
                                                                        <h2>배팅내역</h2>
                                                                        <div class="board_list">
                                                                            <table cellpadding="0" cellspacing="0" border="0">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th class="th-mini">회차</th>
                                                                                        <th class="th-mini">배팅유형</th>
                                                                                        <th class="th-mini">사이드</th>
                                                                                        <th class="th-mini">배당율</th>
                                                                                        <th class="th-mini">배팅금</th>
                                                                                        <th class="th-mini">당첨금</th>
                                                                                        <th class="th-mini">적중여부</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="tbody">
                                                                                <?php
                                                                                    foreach ( $TPL_VAR["betting_list"] as $TPL_K1 => $TPL_V1 ) {
                                                                                        $forCnt++;
                                                                                        $TPL_item_2=empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);
                                                                                        if ( $TPL_item_2 ) { 

                                                                                            $bettingNo = $TPL_V1["betting_no"];
                                                                                            $bettingRate = $TPL_V1["result_rate"];
                                                                                            $bettingMoney = $TPL_V1["betting_money"];
                                                                                            $betDay = substr($TPL_V1["bet_date"],5,5);
                                                                                            $betTime = substr($TPL_V1["bet_date"],11,8);

                                                                                            foreach ( $TPL_V1["item"] as $TPL_V2 ) {				
                                                                                                $gameCode = $TPL_V2["game_code"];
                                                                                                $gameTh = $TPL_V2["game_th"];
                                                                                                $bettingDate = str_replace("-","월 ",substr($TPL_V2["gameDate"],5,5))."일";

                                                                                                if ( $TPL_V2["home_rate"] < 1.1 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
                                                                                                    $resultMoney = "-";
                                                                                                    $bettingResult = "<font color='#f65555'>적특</font>";
                                                                                                } else {
                                                                                                    $resultMoney = "-";
                                                                                                    if ( $TPL_V2["result"] == 1 ) {
                                                                                                        $bettingResult = "<span style='color: lightgreen;'>적중</span>";
                                                                                                        $resultMoney = "<span class=\"new_betting_ok\">".number_format($bettingMoney * $bettingRate)."</span>";
                                                                                                    } else if ( $TPL_V2["result"] == 2 ) {
                                                                                                        $bettingResult = "<span style='color: red;'>미적중</span>";
                                                                                                        $resultMoney = "<span class=\"new_betting_no\">-".number_format($bettingMoney)."</span>";
                                                                                                    } else if ( $TPL_V2["result"] == 4 ) {
                                                                                                        $bettingResult = "적특";	
                                                                                                    } else {
                                                                                                        $bettingResult = "진행중";
                                                                                                    }
                                                                                                }

                                                                                                if ( $gameCode == "p_n-bs" ) {
                                                                                                    $gameName = "일반볼구간";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "대(81~130)";
                                                                                                    else if ( $TPL_V2["select_no"] == 2 ) $select_val = "소(15~64)";
                                                                                                    else $select_val = "중(65~80)";
                                                                                                } else if ( $gameCode == "p_n-oe" ) {
                                                                                                    $gameName = "일반볼홀짝";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "홀";
                                                                                                    else $select_val = "짝";
                                                                                                } else if ( $gameCode == "p_n-uo" ) {
                                                                                                    $gameName = "일반볼언오";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "언";
                                                                                                    else $select_val = "오";
                                                                                                } else if ( $gameCode == "p_p-oe" ) {
                                                                                                    $gameName = "파워볼홀짝";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "홀";
                                                                                                    else $select_val = "짝";
                                                                                                } else if ( $gameCode == "p_p-uo" ) {
                                                                                                    $gameName = "파워볼언오";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "언";
                                                                                                    else $select_val = "오";
                                                                                                } else if ( $gameCode == "p_01" ) {
                                                                                                    $gameName = "파워볼숫자";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "0";
                                                                                                    else $select_val = "1";
                                                                                                } else if ( $gameCode == "p_23" ) {
                                                                                                    $gameName = "파워볼숫자";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "2";
                                                                                                    else $select_val = "3";
                                                                                                } else if ( $gameCode == "p_45" ) {
                                                                                                    $gameName = "파워볼숫자";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "4";
                                                                                                    else $select_val = "5";
                                                                                                } else if ( $gameCode == "p_67" ) {
                                                                                                    $gameName = "파워볼숫자";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "6";
                                                                                                    else $select_val = "7";
                                                                                                } else if ( $gameCode == "p_89" ) {
                                                                                                    $gameName = "파워볼숫자";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "8";
                                                                                                    else $select_val = "9";
                                                                                                } else if ( $gameCode == "p_0279" ) {
                                                                                                    $gameName = "파워볼구간";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "A(0~2)";
                                                                                                    else $select_val = "D(7~9)";
                                                                                                } else if ( $gameCode == "p_3456" ) {
                                                                                                    $gameName = "파워볼구간";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "B(3~4)";
                                                                                                    else $select_val = "C(5~6)";
                                                                                                } else if ( $gameCode == "p_oe-unover" ) {
                                                                                                    $gameName = "파워볼언오버";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "홀-언더";
                                                                                                    else $select_val = "짝-오버";
                                                                                                } else if ( $gameCode == "p_eo-unover" ) {
                                                                                                    $gameName = "파워볼언오버";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "짝-언더";
                                                                                                    else $select_val = "홀-오버";
                                                                                                } else if ( $gameCode == "p_noe-unover" ) {
                                                                                                    $gameName = "일반볼조합";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "홀-언더";
                                                                                                    else $select_val = "짝-오버";
                                                                                                } else if ( $gameCode == "p_neo-unover" ) {
                                                                                                    $gameName = "일반볼조합";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) $select_val = "짝-언더";
                                                                                                    else $select_val = "홀-오버";
                                                                                                }

                                                                                                $btNo = $forCnt;
                                                                                                echo "<tr>
                                                                                                        <td class='th-mini' style=\"font-weight:bold;\">{$gameTh}</td>
                                                                                                        <td class='th-mini' style=\"font-weight:bold;\">{$gameName}</td>
                                                                                                        <td class='th-mini'>{$select_val}</td>
                                                                                                        <td class='th-mini'>{$bettingRate}</td>
                                                                                                        <td class='th-mini'>".number_format($bettingMoney)."</td>
                                                                                                        <td class=\"new_betting_no th-mini\" id='resultMoney_{$bettingNo}'>{$resultMoney}</td>
                                                                                                        <td class='th-mini' id='result_{$bettingNo}'>{$bettingResult}</td>
                                                                                                    </tr>";
                                                                                            }
                                                                                        } else {
                                                                                            echo    "<tr>
                                                                                                        <td colspan='12'>배팅 내역이 없습니다.</td>
                                                                                                    </tr>";
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                    
                                                                                </tbody>
                                                                            </table>
                                                                            <!-- page skip -->
                                                                            <div class="page_skip"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <div style="text-align:center;"> </div>
                                                        </tr>
                                                    </table>
                                                    <!-- 게시판 목록 끝 -->
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<script>
    
</script>
<script>
    var game = '<?php echo $TPL_VAR["game_type"]?>';            //-> 미니게임타입
	var VarMoney = '<?php echo $TPL_VAR["cash"]?>';				//-> 보유머니
	var VarMinBet = '<?php echo $TPL_VAR["betMinMoney"]?>';		//-> 최소배팅머니
	var VarMaxBet = '<?php echo $TPL_VAR["betMaxMoney"]?>';		//-> 최고배팅머니
	var VarMaxAmount = '<?php echo $TPL_VAR["maxBonus"]?>';		//-> 최대당첨금	

	$j(document).ready(function() {

		//-> 타이머 시작
		getServerTime();
        // var gameResult = setInterval(getMiniGameResult, 1000);
	});
</script>
<script>
    $j(function(){
        // var game_view_width = 635;
        // var game_view_width2 = $j("#game_view").width();
        // var left=((game_view_width - game_view_width2)*-1)-160;
        // if(left > -200) left = -200;
        // $j(".frameScale").css("left",left);
            
        var ww = window.innerWidth;
        // if(ww > 1710) {
        //     $j(".frameScale").css("transform","scale(1,1)");
        // }
        // if(ww > 1610 && ww < 1710  ) {
        //     $j(".frameScale").css("transform","scale(0.9,0.9)");
        // }
        // if(ww > 1590 && ww < 1610  ) {
        //     $j(".frameScale").css("transform","scale(0.88,0.88)");
        // }
        // if(ww > 1560 && ww < 1590  ) {
        //     $j(".frameScale").css({"transform":"scale(0.87,0.87)","left":"-312"});
        // }
        if(ww > 360 && ww < 450  ) {
            $j(".frameScale").css({"transform":"scale(0.52,0.52)","left":"-265","top":"-160"});
        } else if ( ww <= 360 ) {
            $j(".frameScale").css({"transform":"scale(0.52,0.52)","left":"-310","top":"-160"});
        }
    });
    $j(window).resize(function() { 
        // var game_view_width = 635;
        // var game_view_width2 = $j("#game_view").width();
        // var left=((game_view_width - game_view_width2)*-1)-160;
        // if(left > -200) left = -200;
        // $j(".frameScale").css("left",left);

        var ww = window.innerWidth;
        // if(ww > 1710) {
        //     $j(".frameScale").css("transform","scale(1,1)");
        // }
        // if(ww > 1610 && ww < 1710  ) {
        //     $j(".frameScale").css("transform","scale(0.9,0.9)");
        // }
        // if(ww > 1590 && ww < 1610  ) {
        //     $j(".frameScale").css("transform","scale(0.88,0.88)");
        // }
        // if(ww > 1560 && ww < 1590  ) {
        //     $j(".frameScale").css({"transform":"scale(0.87,0.87)","left":"-312"});
        // }
        if(ww < 900  ) {
            $j(".frameScale").css({"transform":"scale(0.52,0.52)","left":"-312","top":"-160"});
        }
    });
</script>
<style type="text/css">
    .frameScale {
        transform: scale(1, 1);
        position:relative;
    }
</style>
<style>
    #betting_disable { position:absolute;top:0;bottom:0;left:0;right:0;font-size:30px;text-align:center;color:white;background:rgba(0,0,0,0.7); z-index:4;}
</style>
