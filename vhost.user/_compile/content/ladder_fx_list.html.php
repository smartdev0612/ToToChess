<?php
    $fx_bs = $TPL_VAR["mini_odds"]["fx_bs"];
    $fx_uo = $TPL_VAR["mini_odds"]["fx_uo"];
    $fx_oe = $TPL_VAR["mini_odds"]["fx_oe"];
    $min = $TPL_VAR["min"];
    $is_use = $TPL_VAR["is_use"];
?>

    <div class="mask"></div>
	<div id="container">
	
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
    var limit_time = <?php echo $TPL_VAR["mini_config"]["fx_limit"]?>;
    var game_gap = <?php echo $min?>;

    <?php if($TPL_VAR["mini_config"]["fx"] == 0) {?>
        alert('FX 미니게임은 현재 점검중입니다.\n이용에 불편을 드려 죄송합니다.');
    document.location.href='/';
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
                                                                    <h2><?="FX게임".$min."분"?></h2>	
                                                                    <div class="game_box">
                                                                        <div class="view_section">
                                                                            <div id="game_view" class="game_view">
                                                                                <iframe class="frameScale" scrolling="no" src="http://fxgame.com/fxgame/<?php echo $min?>min/index.php" frameborder="0" width="830" height="641" style="margin-top:10px; margin-left:3px;"></iframe>
                                                                            </div>
                                                                            <div id="gamelist" class="bet_section" style="width:100%;">
                                                                                <div class="bet_cart_box">
                                                                                    <div id="betting_disable"></div>
                                                                                    <div class="bet_cart">
                                                                                        <div class="info_bet">
                                                                                            <div class="info_box">
                                                                                                <div class="game01">
                                                                                                    <h4>게임분류 <span><?="FX게임".$min."분"?></span></h4>
                                                                                                    <h4>게임선택 <span id="stGameIcon"></span></h4>
                                                                                                </div>
                                                                                                <div class="game01">
                                                                                                    <h4 style="width:100%;">보유금액 <span><?php echo number_format($TPL_VAR["cash"],0)?> 원</span></h4>
                                                                                                </div>
                                                                                                <div class="dividend">배당 <span id="stGameRate"></span></div>
                                                                                                <div class="div_pay">적중금액<span id="hitMoney">0</span></div>
                                                                                            </div>
                                                                                            <div class="btn_box">
                                                                                                <div><button type="button" onclick="moneyPlus('5000');">5,000</button></div>
                                                                                                <div><button type="button" onclick="moneyPlus('10000');">10,000</button></div>
                                                                                                <div><button type="button" onclick="moneyPlus('100000');">100,000</button></div>
                                                                                                <div><button type="button" onclick="moneyPlus('300000');">300,000</button></div>
                                                                                                <div><button type="button" onclick="moneyPlus('500000');">500,000</button></div>
                                                                                                <div><button type="button" onclick="moneyPlus('1000000');">1,000,000</button></div>
                                                                                                <div><button type="button" onclick="moneyPlus('ex');">잔돈</button></div>
                                                                                                <div><button type="button" onclick="moneyPlus('all');">올인</button></div>
                                                                                                <div><button type="button" onclick="moneyPlus('reset');">초기화</button></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="bet_moeny">
                                                                                            배팅금액
                                                                                            <input type="text" id="btMoney" name="btMoney" class="input_betmoney" value="0" onkeyUp="javascript:this.value=onMoneyChange(this.value);" placeholder="0">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="btn_minigame">
                                                                                        <button type="button" onclick="gameBetting();">배팅하기</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <form name="betForm">
                                                                            <div id="gamelist" class="bet_section">
                                                                                <div class="bet_cart_box">
                                                                                    <div class="bet_list01">
                                                                                        <div class="list_box01">
                                                                                            <h4>1게임 홀/짝</h4>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="mini_bet btn_blue" onclick="gameSelect('odd','<?php echo $fx_oe?>');">
                                                                                                        홀
                                                                                                        <span class="bedd"><?php echo $fx_oe?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btn_red" onclick="gameSelect('even','<?php echo $fx_oe?>');">
                                                                                                        짝
                                                                                                        <span class="bedd"><?php echo $fx_oe?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="list_box01">
                                                                                            <h4>2게임 언더/오버</h4>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btn_blue" onclick="gameSelect('under','<?php echo $fx_uo?>');">
                                                                                                        언더
                                                                                                        <span class="bedd"><?php echo $fx_uo?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btn_red" onclick="gameSelect('over','<?php echo $fx_uo?>');">
                                                                                                        오버
                                                                                                        <span class="bedd"><?php echo $fx_uo?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="list_box01">
                                                                                            <h4>3게임 매수/매도</h4>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btn_blue" onclick="gameSelect('buy','<?php echo $fx_bs?>');">
                                                                                                        매수
                                                                                                        <span class="bedd"><?php echo $fx_bs?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btn_red" onclick="gameSelect('sell','<?php echo $fx_bs?>');">
                                                                                                        매도
                                                                                                        <span class="bedd"><?php echo $fx_bs?></span>
                                                                                                    </button>
                                                                                                </div>
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
                                                                                <colgroup>
                                                                                    <col width="5%" />
                                                                                    <col width="15%" />
                                                                                    <col width="15%" />
                                                                                    <col width="15%" />
                                                                                    <col width="10%" />
                                                                                    <col width="10%" />
                                                                                    <col width="10%" />
                                                                                    <col width="10%" />
                                                                                    <col width="10%" />
                                                                                </colgroup>
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>번호</th>
                                                                                        <th>회차</th>
                                                                                        <th>배팅시간</th>
                                                                                        <th>게임분류</th>
                                                                                        <th>배팅내역</th>
                                                                                        <th>배당율</th>
                                                                                        <th>배팅금액</th>
                                                                                        <th>적중/손실</th>
                                                                                        <th>적중여부</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
                                                                                    foreach ( $TPL_VAR["betting_list"] as $TPL_K1 => $TPL_V1 ) {
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
                                                                                                    $bettingResult = "<font color='#f65555'>적특</font>";
                                                                                                } else {
                                                                                                    $resultMoney = "-";
                                                                                                    if ( $TPL_V2["result"] == 1 ) {
                                                                                                        $bettingResult = "적중";
                                                                                                        $resultMoney = "<span class=\"new_betting_ok\">".number_format($bettingMoney * $bettingRate)."</span>";
                                                                                                    } else if ( $TPL_V2["result"] == 2 ) {
                                                                                                        $bettingResult = "미적중";
                                                                                                        $resultMoney = "<span class=\"new_betting_no\">-".number_format($bettingMoney)."</span>";
                                                                                                    } else if ( $TPL_V2["result"] == 4 ) {
                                                                                                        $bettingResult = "적특";	
                                                                                                    } else {
                                                                                                        $bettingResult = "진행중";
                                                                                                    }
                                                                                                }
                                                                                
                                                                                                if ( $gameCode == "fx_oe" ) {
                                                                                                    $gameName = "홀/짝";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) {
                                                                                                        $select_val = "홀";
                                                                                                    } else {
                                                                                                        $select_val = "짝";
                                                                                                    }
                                                                                                } else if ( $gameCode == "fx_uo" ) {
                                                                                                    $gameName = "언더/오버";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) {
                                                                                                        $select_val = "언더";
                                                                                                    } else {
                                                                                                        $select_val = "오버";
                                                                                                    }
                                                                                                } else if ( $gameCode == "fx_bs" ) {
                                                                                                    $gameName = "매수/매도";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) {
                                                                                                        $select_val = "매수";
                                                                                                    } else {
                                                                                                        $select_val = "매도";
                                                                                                    }
                                                                                                }
                                                                               
                                                                                                $btNo = count($TPL_VAR["betting_list"]) - $forCnt;
                                                                                                echo "<tr>
                                                                                                        <td>".$btNo."</td>
                                                                                                        <td style=\"font-weight:bold;\">{$bettingDate} <br />[{$gameTh}회차]</td>
                                                                                                        <td>{$betDay}<br />{$betTime}</td>
                                                                                                        <td style=\"font-weight:bold;\">{$gameName}</td>
                                                                                                        <td>{$select_val}</td>
                                                                                                        <td>{$bettingRate}</td>
                                                                                                        <td>".number_format($bettingMoney)."</td>
                                                                                                        <td class=\"new_betting_no\">{$resultMoney}</td>
                                                                                                        <td>{$bettingResult}</td>
                                                                                                    </tr>";
                                                                                                $forCnt++;
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
<script type="text/javascript" src="/include/js/minigame/fx.js?v=<?php echo time();?>"></script>
<script>
	var VarMoney = '<?php echo $TPL_VAR["cash"]?>';						//-> 보유머니
	var VarMinBet = '<?php echo $TPL_VAR["betMinMoney"]?>';		//-> 최소배팅머니
	var VarMaxBet = '<?php echo $TPL_VAR["betMaxMoney"]?>';		//-> 최고배팅머니
	var VarMaxAmount = '<?php echo $TPL_VAR["maxBonus"]?>';		//-> 최대당첨금

	$j(document).ready(function() {
		
		//-> 타이머 시작
		getServerTime();

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
	<!-- 베팅카트 -->
	<!-- 모바일 푸터 메뉴 -->
	<div id="mobile_foot_menu">
		<ul class="foot_menu">
			<li><span class="ico_customer"><a href="https://t.me/tenbetkorea" target="_blank"><img src="/10bet/images/10bet/ico_telegram_01.png" alt="텔레그램" /></a></span></li>
			<li><span class="ico_customer"><a href="/bbs/board.php?bo_table=z10"><img src="/10bet/images/10bet/ico_customer_01.png" alt="고객문의" /></a></span></li>
			<!--<li><span class="ico_chetting"><img src="/10bet/images/10bet/ico_chetting_01.png" alt="라이브채팅" /></span></li>-->
    					<li><span class="ico_cart"><img src="/10bet/images/10bet/ico_cart_01.png" alt="배팅카트" /></span></li>
						<li><span class="ico_bottom_menu" id="ico_bottom_menu">
								MINI
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 33 35" fill="currentColor">
					<rect width="33" height="7" rx="3.5" ry="3.5"></rect>
					<rect y="14" width="33" height="7" rx="3.5" ry="3.5"></rect>
					<rect y="28" width="33" height="7" rx="3.5" ry="3.5"></rect>
				</svg>
				</span>
			</li>
		</ul>
	</div>

    	
<!-- 모바일 하단 메뉴 -->
<script language='javascript'> var g4_cf_filter = ''; </script>
<script language='javascript' src='/10bet/js/filter.js'></script>
