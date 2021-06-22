<?php
	if($TPL_VAR["game_type"]=="multi") { $on_multi="_o";}
	if($TPL_VAR["game_type"]=="handi") { $on_handi="_o";}
	if($TPL_VAR["game_type"]=="special") { $on_special="_o";}
	if($TPL_VAR["game_type"]=="real") { $on_real="_o";}
	if($TPL_VAR["game_type"]=="sadari") { $on_sadari="_o";}
	if($TPL_VAR["game_type"]=="dari") { $on_dari="_o";}
	if($TPL_VAR["game_type"]=="race") { $on_race="_o";}
	if($TPL_VAR["game_type"]=="power") { $on_power="_o";}
	if($TPL_VAR["game_type"]=="real20") { $on_real20="_o";}
	if($TPL_VAR["game_type"]=="cod") { $on_cod="_o";}
?>
<link rel="stylesheet" type="text/css" href="/include/css/font-awesome.css"/>
<!--
<div id="sub_menu">
	<ul>
		<li class="sub_menu_1<?php echo $on_multi?>"><a href="/game_list?game=multi" class="sub_menu_1<?php echo $on_multi?>_text">멀티</a></li>
		<li class="sub_menu_1<?php echo $on_handi?>"><a href="/game_list?game=handi" class="sub_menu_1<?php echo $on_handi?>_text">핸디</a></li>
		<li class="sub_menu_1<?php echo $on_special?>"><a href="/game_list?game=special" class="sub_menu_1<?php echo $on_special?>_text">스페셜</a></li>
		<li class="sub_menu_1<?php echo $on_real?>"><a href="/game_list?game=real" class="sub_menu_1<?php echo $on_real?>_text">실시간</a></li>
		<li class="sub_menu_1<?php echo $on_sadari?>"><a href="/game_list?game=sadari" class="sub_menu_1<?php echo $on_sadari?>_text">사다리</a></li>
		<li class="sub_menu_1<?php echo $on_dari?>"><a href="/game_list?game=dari" class="sub_menu_1<?php echo $on_dari?>_text">다리다리</a></li>
		<li class="sub_menu_1<?php echo $on_race?>"><a href="/game_list?game=race" class="sub_menu_1<?php echo $on_race?>_text">달팽이</a></li>
		<li class="sub_menu_1<?php echo $on_power?>"><a href="/game_list?game=power" class="sub_menu_1<?php echo $on_power?>_text">파워볼</a></li>
		<li class="sub_menu_1<?php echo $on_power?>"><a href="javascript:alert('서비스 준비중입니다.');" class="sub_menu_1<?php echo $on_real20?>_text">리얼20</a></li>
		<li class="sub_menu_1<?php echo $on_power?>"><a href="javascript:alert('서비스 준비중입니다.');" class="sub_menu_1<?php echo $on_cod?>_text">COD</a></li>
	</ul>
</div>
-->
<div class="ladder_wrap">
    <div class="ladder_top2">
        <div class="game20_mini">
            <div class="game20_cards">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr>
                        <td><img src="/img/m/card_left.png" style="width:60%; padding-top:5px;"></td>
                        <td></td>
                        <td><img src="/img/m/card_right.png" style="width:60%; padding-top:5px;"></td>
                    </tr>
                    <tr>
                        <td class="card_bg">
	                        <img src="/img/m/00_back.png" data-status="0" class="__action_result_image">
	                    </td>
                        <td>
	                        <img src="/img/m/00_back.png" data-status="0" class="__action_result_image">
	                        <img src="/img/m/00_back.png" data-status="0" class="__action_result_image"> 
	                        <img src="/img/m/00_back.png" data-status="0" class="__action_result_image"></td>
                        <td class="card_bg">
	                        <img src="/img/m/00_back.png" data-status="0" class="__action_result_image">
	                    </td>
                    </tr>
                    <tr>
                        <td class="card_txt1">
                            <ul class="game_card_txt1 __screen_viewOne">
                                <!-- <li class="txt_hol">?</li> -->
                                <li class="colorchange __action_result_text">?</li>
                                <li class="txt_left __action_result_text" style="display: none;">승</li>
                            </ul>
                        </td>
                        <td class="card_txt2"><img src="/img/m/over_result.png" class="__screen_viewTwo" style="display: none;" alt="오버">
                            <!-- <img src="/img/m/under_result.png" alt="언더" /> --></td>
                        <td class="card_txt1">
                            <ul class="game_card_txt1 __screen_viewThree">
                                <li class="txt_num __action_result_text">?</li>
                                <li class="txt_right __action_result_text" style="display: none;">승</li>
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <ul class="game20_btn2">
                <li>
                    <!-- <a href="javascript:gameImgMode();"><img src="/img/m/btn_20game_01.png" id="modeChange"/></a> -->
                    <a id="__action_image_controller" href="javascript:void(0);" class="_noevt"><img src="/img/m/btn_20game_01.png"></a></li>
                <li>
                    <!-- <a href="javascript:movieSize('big');"><img src="/img/m/btn_20game_02.png" alt="LIVE전체영상"/></a> -->
                    <a id="__action_fullLive_controller" href="javascript:void(0);" class="_noevt"><img src="/img/m/btn_20game_02.png" alt="LIVE전체영상"></a></li>
                <li>
                    <!-- <a href="javascript:movieSize('small');"><img src="/img/m/btn_20game_03.png" alt="LIVE확대영상"/></a> -->
                    <a id="__action_zoomLive_controller" href="javascript:void(0);" class="_noevt"><img src="/img/m/btn_20game_03.png" alt="LIVE확대영상"></a></li>
                <li>
                    <!-- <a href="javascript:;"><img src="/img/m/btn_20game_04.png" alt="게임방법"/></a> -->
                    <!--<a id="__screen_game_readme" href="javascript:void(0); class=" _noevt"="" "=""><img src="/img/m/btn_20game_04.png" alt="게임방법"></a>-->
                     <a onclick="$('#__overlayreadme').show();" class=" _noevt" "><img src="/img/m//btn_20game_04.png" alt="게임방법"/></a>
                </li>
            </ul>
            
            <div id="__panel_video" class="game20_movie __videostream" style="z-index: 999"></div>

            <div class="game20_result">
                <h3>지난회차</h3>
                <ul id="__panel_gamelist_result"">
                </ul>
            </div>
        </div>


    </div>
    <div class="ladder_cnt">
        <input type="hidden" id="game_hour" name="game_hour" value="21">
        <!-- 게임선택 -->
        <div class="ladder_choice">
            <div id="__panel_displayBoard" style="min-height: 60px;" class="game_info __screen_statusPanel">
                <!--
                <span id="viewSysDate"></span> <span style="color:#ffce25;"><b>[<span id="viewGameTh" style="color:#ffce25;"></span>회차]</b></span>
                <em><span id="date_hh"><span id="viewSysTime"></span></span></em>
                <b><span id="viewGameTime" style="color: #ffea00;"></span></b>
                -->
            </div>
            <div class="ladder_1st">
                <h4><span>1게임</span><strong>홀/짝</strong></h4>
                <div>
                    <ul class="game20_betting1">
                        <!--
                        <li><input type="button" value="1.95" class="b_odd " onclick="gameSelect('odd','1.95');" id="gameSt_odd"></li>
                        <li><input type="button" value="1.95" class="b_even" onclick="gameSelect('even','1.95');" id="gameSt_even"></li>
                        -->
                        <li><input type="button" value="1.95" class="b_odd __action_betting_one_controller" alt="홀"></li>
                        <li><input type="button" value="1.95" class="b_even __action_betting_one_controller" alt="짝"></li>
                    </ul>
                </div>
            </div>
            <div class="ladder_4nd">
                <h4><span>2게임</span><strong>언더오버</strong></h4>
                <div>
                    <ul class="game20_betting2">
                        <!--
                        <li><input type="button" value="1.95" class="b_over" onclick="gameSelect('left','1.95');" id="gameSt_left"></li>
                        <li><input type="button" value="27.5" class="b_point"></li>
                        <li><input type="button" value="1.95" class="b_under" onclick="gameSelect('3line','1.95');" id="gameSt_3line"></li>
                        -->
                        <li><input type="button" value="1.95" class="b_over __action_betting_two_controller" alt="오버"></li>
                        <li><input type="button" value="27.5" class="b_point"></li>
                        <li><input type="button" value="1.95" class="b_under __action_betting_two_controller" alt="언더"></li>
                    </ul>
                </div>
            </div>
            <div class="ladder_4nd">
                <h4><span>3게임</span><strong>승무패</strong></h4>
                <div>
                    <ul class="game20_betting3">
                        <!--
                        <li><input type="button" value="1.95" class="b_li" onclick="alert('3게임 배팅이 잠시 중지 되었습니다.');" id="gameSt_even3line_left"></li>
                        <li><input type="button" value="9.00" class="b_mu" onclick="alert('3게임 배팅이 잠시 중지 되었습니다.');" id="gameSt_odd4line_left"></li>
                        <li><input type="button" value="1.95" class="b_aul" onclick="alert('3게임 배팅이 잠시 중지 되었습니다.');" id="gameSt_odd3line_right"></li>
                        -->
                        <li><input type="button" value="1.95" class="b_li __action_betting_three_controller" alt="승(좌)"></li>
                        <li><input type="button" value="9.00" class="b_mu __action_betting_three_controller" alt="무"></li>
                        <li><input type="button" value="1.95" class="b_aul __action_betting_three_controller" alt="승(우)"></li>
                    </ul>
                </div>
            </div>
            <div class="ladder_5nd">
                <h4><span>4게임</span><strong>숫자<br/>맞추기</strong></h4>
                <div>
                    <ul class="game20_betting4">
                        <!--
                        <li><input type="button" value="8.50" class="b_01" onclick="" id=""></li>
                        <li><input type="button" value="8.50" class="b_02" onclick="" id=""></li>
                        <li><input type="button" value="8.50" class="b_03" onclick="" id=""></li>
                        <li><input type="button" value="8.50" class="b_04" onclick="" id=""></li>
                        <li><input type="button" value="8.50" class="b_05" onclick="" id=""></li>
                        <li><input type="button" value="8.50" class="b_06" onclick="" id=""></li>
                        <li><input type="button" value="8.50" class="b_07" onclick="" id=""></li>
                        <li><input type="button" value="8.50" class="b_08" onclick="" id=""></li>
                        <li><input type="button" value="8.50" class="b_09" onclick="" id=""></li>
                        <li><input type="button" value="8.50" class="b_10" onclick="" id=""></li>
                        -->
                        <li><input type="button" value="8.50" class="b_01 __action_betting_four_controller" alt="1"></li>
                        <li><input type="button" value="8.50" class="b_02 __action_betting_four_controller" alt="2"></li>
                        <li><input type="button" value="8.50" class="b_03 __action_betting_four_controller" alt="3"></li>
                        <li><input type="button" value="8.50" class="b_04 __action_betting_four_controller" alt="4"></li>
                        <li><input type="button" value="8.50" class="b_05 __action_betting_four_controller" alt="5"></li>
                        <li><input type="button" value="8.50" class="b_06 __action_betting_four_controller" alt="6"></li>
                        <li><input type="button" value="8.50" class="b_07 __action_betting_four_controller" alt="7"></li>
                        <li><input type="button" value="8.50" class="b_08 __action_betting_four_controller" alt="8"></li>
                        <li><input type="button" value="8.50" class="b_09 __action_betting_four_controller" alt="9"></li>
                        <li><input type="button" value="8.50" class="b_10 __action_betting_four_controller" alt="10"></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 게임선택 -->

        <!-- //게임선택 -->
        <!-- 베팅카트 -->
        <div class="ladder_cart">
            <div class="cart_info">
                <ul class="new20_betting3">
                    <li class="">
                        <div>
                            <span>게임분류</span>
                            <strong class="__action_betting_result_type">선택</strong>
                        </div>
                    </li>
                    <li id="selBet">
                        <div>
                            <span>게임선택</span>
                            <strong>
                                <span class="tx __action_betting_result_select" id="stGameIcon">선택</span>
                            </strong>
                        </div>
                    </li>
                    <li id="betRate">
                        <div>
                            <span>배당률</span>
                            <em><span id="stGameRate" class="__action_betting_result_allocation" style="color:#ffeaad;">0.00</span></em>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- 금액선택 -->
            <div class="cart_pay">
                <h4 class="hidden">베팅금액선택</h4>
                <div class="bet_money"><label for="betExp2">베팅 금액</label><input type="text" id="btMoney" name="btMoney" value="0" class="__action_result_bettingAmount" readonly onFocus="blur();"/></div>
                <div class="bet_money i_blue"><label for="betExp3">적중 금액</label><input type="text" id="hitMoney" name="hitMoney" value="0" class="__action_result_bettingHitAmount" readonly onFocus="blur();"/></div>
                <div class="bet_btn_inner">
                    <ul>
                        <li>
                            <input type="button" value="5,000" data-item="5000" class="__action_bettingAmount_controller">
                        </li>
                        <li>
                            <input type="button" value="10,000" data-item="10000" class="__action_bettingAmount_controller">
                        </li>
                        <li>
                            <input type="button" value="50,000" data-item="50000" class="__action_bettingAmount_controller">
                        </li>
                        <li>
                            <input type="button" value="100,000" data-item="100000" class="__action_bettingAmount_controller">
                        </li>
                        <li>
                            <input type="button" value="500,000" data-item="500000" class="__action_bettingAmount_controller">
                        </li>
                        <li>
                            <input type="button" value="1,000,000" data-item="1000000" class="__action_bettingAmount_controller">
                        </li>
                    </ul>
                </div>
                <div class="bet_money_free">
                    <label for="betExp4">직접입력</label>
                    <input type="text" id="mulMoney" name="mulMoney" value="0" class="__game_moneydirect"/>
                </div>
                <div class="bet_btn_inner">
                    <ul>
                        <li>
                            <input type="button" class="i_blue __action_bettingAmount_controller" value="잔돈" data-item="ex">
                        </li>
                        <li>
                            <input type="button" class="i_brw __action_bettingAmount_controller" value="올인" data-item="all">
                        </li>
                        <li>
                            <input type="button" class="i_gray __action_bettingAmount_controller" value="초기화" data-item="reset">
                        </li>
                    </ul>
                </div>
            </div>
            <!-- //금액선택 -->
            </form>
        </div>

        <div class="btn_area">
            <div id="bettingShadow" class="bet_disable">지금은 베팅을 하실 수 없습니다.</div>
            <ul>
                <li style="position: relative">
                    <input type="button" value="베팅하기" class="btn_bet02 __action_bettingSubmit_controller">
                    <div id="bettingShadow2"
                         style="width:100%;height:100%; line-height: 4em; font-size: 16px; font-weight: bold; background:rgba(0,0,0,.8);position: absolute;top:0;left:0;z-index: 1; display:none;"></div>
                </li>

                <!--li><a href="#ladder_stats" class="call-modal btn_stats" onclick="load_chart()">회차별 홀/짝통계</a></li-->
                <li style="width:99%;"><a href="/race/betting_list" class="btn_all_bet">전체 베팅내역</a></li>
            </ul>
        </div>

        <!-- 최근 회차별 홀/짝 통계 -->
        <div class="modal_style01" id="ladder_stats" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
            <div class="ladder_chart">
                <h4>최근 회차별 홀/짝 통계</h4>
                <div class="ladder_chart_area">
                    <ul>
                        <li>
                            <span class="date">03월 06일 [150회차]</span>
                            <strong class="evenfirst">
                                <span class="tx"></span>
                            </strong>
                        </li>
                        <li>
                            <span class="date">03월 06일 [150회차]</span>
                            <strong class="evensecond">
                                <span class="tx"></span>
                            </strong>
                        </li>
                        <li>
                            <span class="date">03월 06일 [150회차]</span>
                            <strong class="oddsecond">
                                <span class="tx"></span>
                            </strong>
                        </li>
                        <li>
                            <span class="date">03월 06일 [150회차]</span>
                            <strong class="oddfirst">
                                <span class="tx"></span>
                            </strong>
                        </li>
                        <li>
                            <span class="date">03월 06일 [150회차]</span>
                            <strong class="oddfirst">
                                <span class="tx"></span>
                            </strong>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="#!" class="modal-close" data-dismiss="modal">close</a>
            <a href="#!" class="lcl img_cmn">close</a>
        </div>
        <!-- //최근 회차별 홀/짝 통계 -->

        <div class="ladder_notice">
            <h4>알아두세요!</h4>
            <ul>
                <li>20장 라이브 미니게임은 실제 서비스 중인 리얼20장게임과 같이 서비스 됩니다.</li>
                <li>20장 하이브 미니게임의 회차는 실제 서비스 중인 리얼20장게의 회차 초기화기 같이 초기화 됩니다.</li>
                <li>배팅후 배팅취소 및 배팅수정이 불가합니다.</li>
                <li>배팅은 본인이 보유한 보유금액기준으로 배팅 가능하며, 추첨결과에 따라 명시된 배당율 기준으로 보유머니가 증가하며, 낙첨일 경우 감소합니다.</li>
                <li>부적절한 방법(ID도움, 불법프로그램, 시스템 배팅 등)으로 배팅을 할 경우 무효처리되며 전액 몰수/강제 탈퇴 등 불이익을 받을 수 있습니다.</li>
                <li>리얼20장의 모든 배당율은 당사의 운영정책에 따라 언제든지 상/하향 조정될 수 있습니다.</li>
                <li>리얼20장의 실제 서비스에서 생기는 문제가 발생될 경우 서비스의 이용이 제한될 수 있으며, 게임의 취소(적특)이 될 수 있습니다.</li>
                <li>본 서비스는 당사의 운영정책에 따라 조기 종료되거나 이용이 제한될 수 있습니다.</li>
            </ul>
        </div>
    </div>
</div>

<div id="__overlayreadme" style="text-align: center; background: rgba(0,0,0, 0.4); width: 100%; height: 100%; position: fixed; top: 50px; left: 0; z-index: 99999; display: none;">
    <div onclick="$('#__overlayreadme').hide()" class="__closebtn" style="font-size: 3.0em;line-height:0;width:36px; height:36px;background:#0099cc; position: absolute; top:0; right: 0;">
        <i class="fa fa-times" aria-hidden="true"></i>
    </div>
    <img src="//sora-999.com/images/real20/howto_mini.png" style="width: 100%;">
</div>

<script type="text/javascript">
    var VarMoney = '<?php echo $TPL_VAR["cash"]?>';      //-> 보유머니
    var VarMinBet = '<?php echo $TPL_VAR["betMinMoney"]?>';  //-> 최소배팅머니
    var VarMaxBet = '<?php echo $TPL_VAR["betMaxMoney"]?>';  //-> 최고배팅머니
    var VarMaxAmount = '<?php echo $TPL_VAR["maxBonus"]?>';  //-> 최대당첨금
</script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveCore.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveImagePanel.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveImagePanelController.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveGameList.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveDisplayBoard.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/dara365/real20LiveBattingPanelController.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveStatistics.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20Live-M.js?v=<? echo time() ?>"></script>