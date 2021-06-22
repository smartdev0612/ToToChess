<?php
    $ks_oe = $TPL_VAR["mini_odds"]["ks_oe"];
    $ks_lr = $TPL_VAR["mini_odds"]["ks_lr"];
    $ks_line = $TPL_VAR["mini_odds"]["ks_line"];
    $ks_oeline_lr = $TPL_VAR["mini_odds"]["ks_oeline_lr"];
?>
    <div class="mask"></div>
	<div id="container">
	
<script language="javascript" src="/10bet/js/sideview.js"></script>
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
    var limit_time = <?php echo $TPL_VAR["mini_config"]["kenosadari_limit"]?>;
    <?php if($TPL_VAR["mini_config"]["kenosadari"] == 0) {?>
        alert('키노사다리 미니게임은 현재 점검중입니다.\n이용에 불편을 드려 죄송합니다.');
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
                                                                    <h2>키노사다리</h2>	
                                                                    <div class="game_box">
                                                                        <div class="view_section">
                                                                            <div id="game_view" class="game_view">
                                                                                <iframe class="frameScale" scrolling="no" src="http://ntry.com/scores/keno_ladder/live.php" frameborder="0" width="830" height="641" style="margin-top:10px; margin-left:3px;"></iframe>
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
                                                                                                    <button type="button" class="btnBet btn_odd btn_blue" onclick="gameSelect('odd','<?php echo $ks_oe?>');">
                                                                                                        홀
                                                                                                        <span class="bedd"><?php echo $ks_oe?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_even btn_red" onclick="gameSelect('even', '<?php echo $ks_oe?>');">
                                                                                                        짝
                                                                                                        <span class="bedd"><?php echo $ks_oe?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="list_box01">
                                                                                            <h4>2게임 좌/우</h4>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_left btn_blue" onclick="gameSelect('left','<?php echo $ks_lr?>');">
                                                                                                        좌
                                                                                                        <span class="bedd"><?php echo $ks_lr?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_right btn_red" onclick="gameSelect('right','<?php echo $ks_lr?>');">
                                                                                                        우
                                                                                                        <span class="bedd"><?php echo $ks_lr?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="list_box01">
                                                                                            <h4>3게임 출발 3/4줄</h4>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_3line btn_blue" onclick="gameSelect('3line','<?php echo $ks_line?>');">
                                                                                                        3줄
                                                                                                        <span class="bedd"><?php echo $ks_line?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_4line btn_red" onclick="gameSelect('4line','<?php echo $ks_line?>');">
                                                                                                        4줄
                                                                                                        <span class="bedd"><?php echo $ks_line?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="list_box01">
                                                                                            <h4>4게임 좌우 출발 3/4줄</h4>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_even3line_left btn_blue" onclick="gameSelect('even3line_left','<?php echo $ks_oeline_lr?>');">
                                                                                                        짝좌3줄
                                                                                                        <span class="bedd"><?php echo $ks_oeline_lr?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_odd4line_left btn_red" onclick="gameSelect('odd4line_left','<?php echo $ks_oeline_lr?>');">
                                                                                                        홀좌4줄
                                                                                                        <span class="bedd"><?php echo $ks_oeline_lr?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="bet_btn01">
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_odd3line_right btn_blue" onclick="gameSelect('odd3line_right','<?php echo $ks_oeline_lr?>');">
                                                                                                        홀우3줄
                                                                                                        <span class="bedd"><?php echo $ks_oeline_lr?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="btn01">
                                                                                                    <button type="button" class="btnBet btn_even4line_right btn_red" onclick="gameSelect('even4line_right','<?php echo $ks_oeline_lr?>');">
                                                                                                        짝우4줄
                                                                                                        <span class="bedd"><?php echo $ks_oeline_lr?></span>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div id="gamelist" class="bet_section" style="width:100%;">
                                                                                    <div class="bet_cart_box">
                                                                                        <div id="betting_disable"></div>
                                                                                        <div class="bet_cart">
                                                                                            <div class="info_bet">
                                                                                                <div class="info_box">
                                                                                                    <div class="game01">
                                                                                                        <h4>게임분류 <span>키노사다리</span></h4>
                                                                                                        <h4>게임선택 <span id="stGameIcon"></span></h4>
                                                                                                    </div>
                                                                                                    <div class="game01">
                                                                                                        <h4 style="width:100%;">보유금액 <span class="member_inmoney"><?php echo number_format($TPL_VAR["cash"],0)?></span></h4>
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

                                                                                                if ( $gameCode == "ks_oe" ) {
                                                                                                    $gameName = "홀/짝";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) {
                                                                                                        $select_val = "<img src=\"/images/mybet_odd.png\">";
                                                                                                    } else {
                                                                                                        $select_val = "<img src=\"/images/mybet_even.png\">";
                                                                                                    }
                                                                                                } else if ( $gameCode == "ks_lr" ) {
                                                                                                    $gameName = "좌/우";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) {
                                                                                                        $select_val = "<img src=\"/images/mybet_left.png\">";
                                                                                                    } else {
                                                                                                        $select_val = "<img src=\"/images/mybet_right.png\">";
                                                                                                    }
                                                                                                } else if ( $gameCode == "ks_34" ) {
                                                                                                    $gameName = "3줄/4줄";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) {
                                                                                                        $select_val = "<img src=\"/images/mybet_3line.png\">";
                                                                                                    } else {
                                                                                                        $select_val = "<img src=\"/images/mybet_4line.png\">";
                                                                                                    }
                                                                                                } else if ( $gameCode == "ks_e3o4l" ) {
                                                                                                    $gameName = "짝좌3줄/홀좌4줄";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) {
                                                                                                        $select_val = "<img src=\"/images/mybet_even3line_left.png\">";
                                                                                                    } else {
                                                                                                        $select_val = "<img src=\"/images/mybet_odd4line_left.png\">";
                                                                                                    }
                                                                                                } else if ( $gameCode == "ks_o3e4r" ) {
                                                                                                    $gameName = "홀우3줄/짝우4줄";
                                                                                                    if ( $TPL_V2["select_no"] == 1 ) {
                                                                                                        $select_val = "<img src=\"/images/mybet_odd3line_right.png\">";
                                                                                                    } else {
                                                                                                        $select_val = "<img src=\"/images/mybet_even4line_right.png\">";
                                                                                                    }
                                                                                                }
                                                                                                $btNo = $forCnt;
                                                                                                echo "<tr>
                                                                                                        <td>".$btNo."</td>
                                                                                                        <td style=\"font-weight:bold;\">{$bettingDate} <br />[{$gameTh}회차]</td>
                                                                                                        <td>{$betDay}<br />{$betTime}</td>
                                                                                                        <td style=\"font-weight:bold;\">{$gameName}</td>
                                                                                                        <td>{$select_val}</td>
                                                                                                        <td>{$bettingRate}</td>
                                                                                                        <td>".number_format($bettingMoney)."</td>
                                                                                                        <td class=\"new_betting_no\" id='resultMoney_{$bettingNo}'>{$resultMoney}</td>
                                                                                                        <td id='result_{$bettingNo}'>{$bettingResult}</td>
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
<script type="text/javascript" src="/include/js/minigame/kenosadari.js?v=<?php echo time();?>"></script>
<script>
    var game = '<?php echo $TPL_VAR["game_type"]?>';            //-> 미니게임타입
	var VarMoney = '<?php echo $TPL_VAR["cash"]?>';						//-> 보유머니
	var VarMinBet = '<?php echo $TPL_VAR["betMinMoney"]?>';		//-> 최소배팅머니
	var VarMaxBet = '<?php echo $TPL_VAR["betMaxMoney"]?>';		//-> 최고배팅머니
	var VarMaxAmount = '<?php echo $TPL_VAR["maxBonus"]?>';		//-> 최대당첨금

	$j(document).ready(function() {
		//-> 타이머 시작
		getServerTime();
	});

</script>
<script>
    $j(function(){
        var ww = window.innerWidth;
        if(ww < 900  ) {
            $j(".frameScale").css({"transform":"scale(0.52,0.52)","left":"-312","top":"-160"});
        }
    });
    $j(window).resize(function() { 
        var ww = window.innerWidth;
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
