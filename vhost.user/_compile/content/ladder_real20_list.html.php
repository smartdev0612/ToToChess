<div id="contents_left" style="min-height:600px; margin-left:50px; position:relative;">
    <div class="game20">
        <div class="game20_mini">
            <div class="game20_cards">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="120" height="35"><img src="/images/card_left.png?v=<?php echo time(); ?>"/></td>
                        <td></td>
                        <td width="120"><img src="/images/card_right.png?v=<?php echo time(); ?>"/></td>
                    </tr>
                    <tr>
                        <td class="card_bg"><img src="/images/00_back.png" width="86" data-status="0" class="__action_result_image"/></td>
                        <td>
                            <img src=" images/00_back.png" data-status="0" class="__action_result_image"/>
                            <img src="/images/00_back.png" data-status="0" class="__action_result_image"/>
                            <img src="/images/00_back.png" data-status="0" class="__action_result_image"/>
                        </td>
                        <td class="card_bg"><img src="/images/00_back.png" data-status="0" class="__action_result_image"/></td>
                    </tr>
                    <tr>
                        <td height="56" class="card_txt1">
                            <ul class="game_card_txt1 __screen_viewOne">
                                <!-- <li class="txt_hol">?</li> -->
                                <li class="txt_zack __action_result_text">?</li>
                                <li class="txt_left __action_result_text" style="display: none;"></li>
                            </ul>
                        </td>
                        <td class="card_txt2">
                            <img src="/images/over_result.png" class="__screen_viewTwo" style="display: none;" alt="오버"/>
                            <!-- <img src="/images/under_result.png" alt="언더" /> -->
                        </td>

                        <td class="card_txt1">
                            <ul class="game_card_txt1 __screen_viewThree">
                                <li class="txt_num __action_result_text">?</li>
                                <li class="txt_right __action_result_text" style="display: none;">패</li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>

            <ul class="game20_btn2">
                <li>
                    <!-- <a href="javascript:gameImgMode();"><img src="/images/btn_20game_01.png" id="modeChange"/></a> -->
                    <a id="__action_image_controller" href="javascript:void(0);" class="_noevt"><img src="/images/btn_20game_01.png"/></a>
                </li>
                <li>
                    <!-- <a href="javascript:movieSize('big');"><img src="/images/btn_20game_02.png" alt="LIVE전체영상"/></a> -->
                    <a id="__action_fullLive_controller" href="javascript:void(0);" class="_noevt"><img src="/images/btn_20game_02.png" alt="LIVE전체영상"/></a>
                </li>
                <li>
                    <!-- <a href="javascript:movieSize('small');"><img src="/images/btn_20game_03.png" alt="LIVE확대영상"/></a> -->
                    <a id="__action_zoomLive_controller" href="javascript:void(0);" class="_noevt"><img src="/images/btn_20game_03.png" alt="LIVE확대영상"/></a>
                </li>
                <li>
                    <!-- <a href="javascript:;"><img src="/images/btn_20game_04.png" alt="게임방법"/></a> -->
                    <a  onclick="$('#real20_help').show();" class=" _noevt" "><img src="/images/btn_20game_04.png" alt="게임방법"/></a>
                </li>
            </ul>

            <div class="game20_movie" id="__panel_video" style="display:none;">
                <div style="width:579px; overflow:hidden; margin-left:13px;">
                    <iframe id="real20_movie" frameborder="0" border="0" scrolling="no" width="609" height="342" marginwidth="0" marginheight="0" align="center" style=" margin-left:-15px;"></iframe>
                </div>
            </div>

            <div class="game20_result">
                <h3>지난회차</h3>
                <ul id="__panel_gamelist_result">
                    <!--
                    <li class="">
                        <div class="result_date">
                            09월12일-287
                        </div>
                        <div class="result_data">대기중</div>
                    </li>
                    <li class="odd_right_row ">
                        <div class="result_date">
                            09월12일-287
                        </div>
                        <div class="result_data">
                            <div class="circle circle--one">
                                <p>짝</p>
                                <div>승</div>
                            </div>
                            <div class="circle circle--two"><p>13</p>
                            </div>
                            <div class="circle circle--three">
                                <p>10</p>
                                <div>승</div>
                            </div>
                        </div>
                    </li>
                    <li class="odd_right_row ">
                        <div class="result_date">
                            09월12일-287
                        </div>
                        <div class="result_data">
							<div class="circle circle--one">
                                <p>짝</p>
                                <div>승</div>
                            </div>
                            <div class="circle circle--two"><p>13</p>
                            </div>
                            <div class="circle circle--three">
                                <p>10</p>
                                <div>승</div>
                            </div>
						</div>
                    </li>
                    <li class="">
                        <span class="num">09월12일-288</span>
                        <span class="tx">대기중</span>
                    </li>
                    <li class="odd_right_row ">
                        <span class="num">09월12일-287</span>
                        <span class="tx">
							<img src="/images/20_txt_hol.png"/>
							<img src="/images/20_txt_c.png"/>
							<img src="/images/20_txt_1.png"/>
						</span>
                    </li>
                    <li class="odd_right_row ">
                        <span class="num">09월12일-287</span>
                        <span class="tx">
							<img src="/images/20_txt_zack.png"/>
							<img src="/images/20_txt_c.png"/>
							<img src="/images/20_txt_10.png"/>
						</span>
                    </li>
                    <li class="odd_right_row ">
                        <span class="num">09월12일-287</span>
                        <span class="tx">
							<img src="/images/20_txt_hol.png"/>
							<img src="/images/20_txt_c.png"/>
							<img src="/images/20_txt_1.png"/>
						</span>
                    </li>
                    <li class="odd_right_row ">
                        <span class="num">09월12일-287</span>
                        <span class="tx">
							<img src="/images/20_txt_zack.png"/>
							<img src="/images/20_txt_c.png"/>
							<img src="/images/20_txt_7.png"/>
						</span>
                    </li>
                    <li class="odd_right_row ">
                        <span class="num">09월12일-287</span>
                        <span class="tx">
							<img src="/images/20_txt_hol.png"/>
							<img src="/images/20_txt_c.png"/>
							<img src="/images/20_txt_8.png"/>
						</span>
                    </li>
                    <li class="odd_right_row ">
                        <span class="num">09월12일-287</span>
                        <span class="tx">
							<img src="/images/20_txt_zack.png"/>
							<img src="/images/20_txt_c.png"/>
							<img src="/images/20_txt_4.png"/>
						</span>
                    </li>
                    <li class="odd_right_row ">
                        <span class="num">09월12일-287</span>
                        <span class="tx">
							<img src="/images/20_txt_hol.png"/>
							<img src="/images/20_txt_c.png"/>
							<img src="/images/20_txt_5.png"/>
						</span>
                    </li>
                    -->
                </ul>
            </div>
        </div>
        <div id="__panel_displayBoard" class="game20_order __screen_statusPanel">
            <!--
            <h3>
                07월 01일 [200회차] 미니게임 배팅 / 남은배팅시간 : <span id="__countdownTimer">03:00</span> <span>초</span>
            </h3>
            -->
            <!--<ul>
                <li>169회차시작</li>
                <li class="now">배팅진행
                    <p>170회차 미니게임 배팅가능 구간</p>
                </li>
                <li>결과오픈진행</li>
                <li>170회차시작</li>
            </ul>-->
        </div>
        <div class="game20_betting">
            <ul class="game20_betting1">
                <li><input type="button" value="1.95" class="b_odd __action_betting_one_controller" alt="홀"></li>
                <li><input type="button" value="1.95" class="b_even __action_betting_one_controller" alt="짝"></li>
            </ul>
            <ul class="game20_betting2">
                <li><input type="button" value="1.95" class="b_odd __action_betting_two_controller" alt="오버"></li>
                <li style="width:94px; padding-top:5px; margin-right:2px;"><img
                        src="/images/btn_game20_betting044.png?v=<?php echo time(); ?>" alt="기준점"></li>
                <li><input type="button" value="1.95" class="b_even __action_betting_two_controller" alt="언더"></li>
            </ul>
            <ul class="game20_betting3">
                <li><input type="button" value="1.95" class="b_odd __action_betting_three_controller" alt="승(좌)"></li>
                <li><input type="button" value="9.00" class="b_mu __action_betting_three_controller" alt="무"></li>
                <li><input type="button" value="1.95" class="b_even __action_betting_three_controller" alt="승(우)"></li>
            </ul>
            <ul class="game20_betting4">
                <li><input type="button" value="8.50" class="b_1 __action_betting_four_controller" alt="1"></li>
                <li><input type="button" value="8.50" class="b_2 __action_betting_four_controller" alt="2"></li>
                <li><input type="button" value="8.50" class="b_3 __action_betting_four_controller" alt="3"></li>
                <li><input type="button" value="8.50" class="b_4 __action_betting_four_controller" alt="4"></li>
                <li><input type="button" value="8.50" class="b_5 __action_betting_four_controller" alt="5"></li>
                <li><input type="button" value="8.50" class="b_6 __action_betting_four_controller" alt="6"></li>
                <li><input type="button" value="8.50" class="b_7 __action_betting_four_controller" alt="7"></li>
                <li><input type="button" value="8.50" class="b_8 __action_betting_four_controller" alt="8"></li>
                <li><input type="button" value="8.50" class="b_9 __action_betting_four_controller" alt="9"></li>
                <li><input type="button" value="8.50" class="b_10 __action_betting_four_controller" alt="10"></li>
            </ul>
        </div>
    </div>

    <div class="game20_betting_now" style="position: relative">
        <!-- 네임드 사다리 게임화면 -->

        <!-- 사다리 배팅판 -->
        <div style="position:relative;">
            <div class="new20_betting_input1">
                <input type="text" id="btMoney" name="btMoney" class="__action_result_bettingAmount" value="0" readonly="" onfocus="blur();">
                <input type="text" id="hitMoney" name="hitMoney" class="__action_result_bettingHitAmount" value="0" style="margin-left:87px; color:#1e75e2;" readonly="" onfocus="blur();">
            </div>
            <div class="new20_betting_input2">
                <!-- <input type="text" id="mulMoney" name="mulMoney" value="0" onkeyup="moneyPlusManual(this.value);"> -->
                <input type="text" id="mulMoney" name="mulMoney" class="__action_bettingDirectAmount_controller" value="0">
            </div>
            <ul class="new20_betting1">
                <li>
                    <a href="#" class="__action_bettingAmount_controller" data-item="5000">
                        <img src="/images/5000_d.png" onmouseover="this.src='/images/5000_u.png'" onmouseout="this.src='/images/5000_d.png'" alt="5,000">
                    </a>
                </li>
                <li>
                    <a href="#" class="__action_bettingAmount_controller" data-item="10000">
                        <img src="/images/10000_d.png" onmouseover="this.src='/images/10000_u.png'" onmouseout="this.src='/images/10000_d.png'" alt="10,000">
                    </a>
                </li>
                <li>
                    <a href="#" class="__action_bettingAmount_controller" data-item="50000">
                        <img src="/images/50000_d.png" onmouseover="this.src='/images/50000_u.png'" onmouseout="this.src='/images/50000_d.png'" alt="5,0000">
                    </a>
                </li>
                <li>
                    <a href="#" class="__action_bettingAmount_controller" data-item="100000">
                        <img src="/images/100000_d.png" onmouseover="this.src='/images/100000_u.png'" onmouseout="this.src='/images/100000_d.png'" alt="100,000">
                    </a>
                </li>
                <li>
                    <a href="#" class="__action_bettingAmount_controller" data-item="500000">
                        <img src="/images/500000_d.png" onmouseover="this.src='/images/500000_u.png'" onmouseout="this.src='/images/500000_d.png'" alt="500,000">
                    </a>
                </li>
                <li>
                    <a href="#" class="__action_bettingAmount_controller" data-item="1000000">
                        <img src="/images/1000000_d.png" onmouseover="this.src='/images/1000000_u.png'" onmouseout="this.src='/images/1000000_d.png'" alt="1,000,000">
                    </a>
                </li>
                <li>
                    <a href="#" class="__action_bettingAmount_controller" data-item="ex">
                        <img src="/images/change_d.png" onmouseover="this.src='/images/change_u.png'" onmouseout="this.src='/images/change_d.png'" alt="잔돈">
                    </a>
                </li>
                <li>
                    <a href="#" class="__action_bettingAmount_controller" data-item="all">
                        <img src="/images/allin_d.png" onmouseover="this.src='/images/allin_u.png'" onmouseout="this.src='/images/allin_d.png'" alt="올인">
                    </a>
                </li>
                <li>
                    <a href="#" class="__action_bettingAmount_controller" data-item="reset">
                        <img src="/images/del_d.png" onmouseover="this.src='/images/del_u.png'" onmouseout="this.src='/images/del_d.png'" alt="초기화">
                    </a>
                </li>
            </ul>
            <ul class="new20_betting2">
                <li>
                    <!-- <input type="" id="__game_battingturn"> -->
                    <a href="javascript:void(0);" class="__action_bettingSubmit_controller"><img src="/images/betting_d.png" alt="베팅하기"></a>
                </li>
            </ul>
            <dl class="new20_betting3">
                <dt style="width:90%; line-height:18px; font-size:11px; background:#8b4527;">- 1/2/3 게임조합가능</dt>
                <dt style="width:60%; line-height:18px; font-size:11px; background:#8b4527; margin-bottom:5px;">-
                    중복배팅불가
                </dt>
                <dt>게임분류</dt>
                <dd class="__action_betting_result_type">선택하세요</dd>
                <dt>게임선택</dt>
                <dd><span id="stGameIcon" class="__action_betting_result_select">선택하세요</span></dd>
                <dt>배당률</dt>
                <dd><span id="stGameRate" class="__action_betting_result_allocation" style="font-size:18px;">0.00</span></dd>
            </dl>
        </div>
    </div>
    <div id="bettingShadow2" class="bet_disable2" style="display: none;"></div>
    <div id="bettingShadow3" class="bet_disable3" style="display: none;">
        <span></span>
    </div>
    
    <div style="width:893px;height:1022px;overflow:hidden;background:url('/images/game_20.png?v=<?php echo time(); ?>') 0 0 no-repeat; padding:52px 23px 0 20px;">
        <!-- 홀짝 그래프 -->
        <div style="float:left; height:339px;">
            <!--
            <iframe id="iframe_sadari_graph" src="/game20_result_graph" frameborder="0" border="0" scrolling="yes"
                    style="width:440px; height:322px;"></iframe>
            -->
            <div class="ladder_wrap" style="width: 440px; height: 339px; overflow-x: auto; overflow-y: hidden;">
                <div class="ladder_chart_inner">
                    <table id="__action_betting_oddStatistics_result" summary="최근 회차별 홀/짝 통계">
                        <thead>
                        <tr>
                            <!--
                            <th class="col_even">짝</th>
                            <th class="col_odd">홀</th>
                            <th class="col_even">짝</th>
                            <th class="col_odd">홀</th>
                            -->
                        </tr>
                        </thead>
                        <tbody>
                        <tr style="height:288px;">
                            <!--
                            <td valign="top">
                                <div class="even circle_r"><span class="tx"><em class="num">150</em></span>
                                    <div class="b_s_txt_l">리</div>
                                </div>
                            </td>
                            <td valign="top">
                                <div class="odd circle_b"><span class="tx"><em class="num">151</em></span>
                                    <div class="b_s_txt_l">리</div>
                                </div>
                            </td>
                            <td valign="top">
                                <div class="even circle_r"><span class="tx"><em class="num">152</em></span>
                                    <div class="b_s_txt_l">리</div>
                                </div>
                                <div class="even circle_r"><span class="tx"><em class="num">153</em></span>
                                    <div class="b_s_txt_r">얼</div>
                                </div>
                            </td>
                            -->
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div style="float:right; height:339px;">
            <!--
            <iframe id="iframe_sadari_graph" src="/game20_result_graph" frameborder="0" border="0" scrolling="yes"
                    style="width:440px; height:322px;"></iframe>
             -->
            <div class="ladder_wrap" style="width: 440px; height: 339px; overflow-x: auto; overflow-y: hidden;">
                <div class="ladder_chart_inner">
                    <table id="__action_betting_unOverStatistics_result" summary="최근 회차별 홀/짝 통계">
                        <thead>
                        <tr>
                            <!--
                            <th class="col_even">언</th>
                            <th class="col_odd">오</th>
                            <th class="col_even">언</th>
                            <th class="col_odd">오</th>
                            -->
                        </tr>
                        </thead>
                        <tbody>
                        <tr style="height:288px;">
                            <!--
                            <td valign="top"><div class="even circle_r"><span class="tx"><em class="num">150</em></span><div class="g_s_txt_l">5</div></div></td>
                            <td valign="top"><div class="odd circle_b"><span class="tx"><em class="num">151</em></span><div class="g_s_txt_l">2</div></div></td>
                            <td valign="top">
                                <div class="even circle_r"><span class="tx"><em class="num">152</em></span><div class="g_s_txt_l">4</div></div>
                                <div class="even circle_r"><span class="tx"><em class="num">153</em></span><div class="g_s_txt_l">6</div></div>
                            </td>
                            <td valign="top"><div class="odd circle_b"><span class="tx"><em class="num">154</em></span><div class="g_s_txt_l">1</div></div></td>
                            -->
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        <!-- 배팅 내역 -->
        <div style="width:895px; height:326px; overflow:hidden; margin-top:444px; position:relative;">
            <table width="100%" cellspacing="0" cellpadding="0" class="new_betting7">
                <colgroup>
                    <col width="40"/>
                    <col width="65"/>
                    <col width="125"/>
                    <col width="120"/>
                    <col width="130"/>
                    <col width="115"/>
                    <col width="40"/>
                    <col width="110"/>
                    <col width="73"/>
                    <col width="113"/>
                </colgroup>
                <?php

                foreach ($TPL_VAR["betting_list"] as $TPL_K1 => $TPL_V1) {
                    $TPL_item_2 = empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);
                    if ($TPL_item_2) {

                        $bettingNo = $TPL_V1["betting_no"];
                        $bettingRate = $TPL_V1["result_rate"];
                        $bettingMoney = $TPL_V1["betting_money"];
                        $betDay = substr($TPL_V1["bet_date"], 5, 5);
                        $betTime = substr($TPL_V1["bet_date"], 11, 8);

                        $gameOneHtml = "";
                        $gameTwoHtml = "";
                        $gameThreeHtml = "";
                        $gameFourHtml = "";
                        $gameResultHtml = "";

												$resultMoney = "-";
												if ( $TPL_V1["result"] == 2 ) {
														$bettingResult = "미적중";
														$resultMoney = "<span class=\"new_betting_no\">-" . number_format($bettingMoney) . "</span>";
												} else if ( $TPL_V1["result"] > 2 ) {
														$bettingResult = "적특";
												} else if ( $TPL_V1["result"] == 0 ) {
														$bettingResult = "진행중";
												} else if ( $TPL_V1["result"] == 1 ) {
														$bettingResult = "적중";
														$resultMoney = "<span class=\"new_betting_ok\">" . number_format($bettingMoney * $bettingRate) . "</span>";
												}

												$betStat = array();
                        foreach ($TPL_V1["item"] as $TPL_V2) {
                            $gameCode = $TPL_V2["game_code"];
                            $gameTh = $TPL_V2["game_th"];
                            $bettingDate = str_replace("-", "월 ", substr($TPL_V2["gameDate"], 5, 5)) . "일";

                            switch ($gameCode) {
                                case 'g_oe': {
                                    $gameName = "홀짝";

                                    if ($TPL_V2["select_no"] == 1) {
                                        $gameOneHtml = '    <div class="circle circle--one blue">';
                                        $gameOneHtml = $gameOneHtml . '        <p>홀</p>';
                                        $gameOneHtml = $gameOneHtml . '    </div>';
                                    } else {
                                        $gameOneHtml = '    <div class="circle circle--one red">';
                                        $gameOneHtml = $gameOneHtml . '        <p>짝</p>';
                                        $gameOneHtml = $gameOneHtml . '    </div>';
                                    }
                                    break;
                                }
                                case 'g_unover': {
                                    $gameName = "오버언더";

                                    if ($TPL_V2["select_no"] == 1) {
                                        $gameTwoHtml = '    <div class="circle circle--two over2">';
                                        $gameTwoHtml = $gameTwoHtml . '        <p>&nbsp;</p>';
                                        $gameTwoHtml = $gameTwoHtml . '    </div>';
                                    } else {
                                        $gameTwoHtml = '    <div class="circle circle--two under2">';
                                        $gameTwoHtml = $gameTwoHtml . '        <p>&nbsp;</p>';
                                        $gameTwoHtml = $gameTwoHtml . '    </div>';
                                    }

                                    break;
                                }
                                case 'g_winner'; {
                                    $gameName = "승무패";

                                    if ($TPL_V2["select_no"] == 1) {
                                        $gameThreeHtml = '    <div class="circle circle--one dark">';
                                        $gameThreeHtml = $gameThreeHtml . '        <p>리</p>';
                                        $gameThreeHtml = $gameThreeHtml . '    </div>';

                                    } else if ($TPL_V2["select_no"] == 2) {
                                        $gameThreeHtml = '    <div class="circle circle--one dark">';
                                        $gameThreeHtml = $gameThreeHtml . '        <p>얼</p>';
                                        $gameThreeHtml = $gameThreeHtml . '    </div>';
                                    } else {
                                        $gameThreeHtml = '    <div class="circle circle--one dark">';
                                        $gameThreeHtml = $gameThreeHtml . '        <p>무</p>';
                                        $gameThreeHtml = $gameThreeHtml . '    </div>';
                                    }

                                    break;
                                }
                                case 'g_t12': {
                                    $gameName = "숫자맞추기";

                                    $gameFourHtml = '    <div class="circle circle--three">';
                                    if ($TPL_V2["select_no"] == 1) {
                                        $gameFourHtml = $gameFourHtml . '        <p>1</p>';
                                    } else {
                                        $gameFourHtml = $gameFourHtml . '        <p>2</p>';
                                    }
                                    $gameFourHtml = $gameFourHtml . '    </div>';

                                    break;
                                }
                                case 'g_t34': {
                                    $gameName = "숫자맞추기";

                                    $gameFourHtml = '    <div class="circle circle--three">';
                                    if ($TPL_V2["select_no"] == 1) {
                                        $gameFourHtml = $gameFourHtml . '        <p>3</p>';
                                    } else {
                                        $gameFourHtml = $gameFourHtml . '        <p>4</p>';
                                    }
                                    $gameFourHtml = $gameFourHtml . '    </div>';

                                    break;
                                }
                                case 'g_t56': {
                                    $gameName = "숫자맞추기";

                                    $gameFourHtml = '    <div class="circle circle--three">';
                                    if ($TPL_V2["select_no"] == 1) {
                                        $gameFourHtml = $gameFourHtml . '        <p>5</p>';
                                    } else {
                                        $gameFourHtml = $gameFourHtml . '        <p>6</p>';
                                    }
                                    $gameFourHtml = $gameFourHtml . '    </div>';

                                    break;
                                }
                                case 'g_t78': {
                                    $gameName = "숫자맞추기";

                                    $gameFourHtml = '    <div class="circle circle--three">';
                                    if ($TPL_V2["select_no"] == 1) {
                                        $gameFourHtml = $gameFourHtml . '        <p>7</p>';
                                    } else {
                                        $gameFourHtml = $gameFourHtml . '        <p>8</p>';
                                    }
                                    $gameFourHtml = $gameFourHtml . '    </div>';

                                    break;
                                }
                                case 'g_t910': {
                                    $gameName = "숫자맞추기";

                                    $gameFourHtml = $gameFourHtml . '    <div class="circle circle--three">';
                                    if ($TPL_V2["select_no"] == 1) {
                                        $gameFourHtml = $gameFourHtml . '        <p>9</p>';
                                    } else {
                                        $gameFourHtml = $gameFourHtml . '        <p>10</p>';
                                    }
                                    $gameFourHtml = $gameFourHtml . '    </div>';

                                    break;
                                }
                            }

                            $gameResultHtml = $gameOneHtml . $gameTwoHtml . $gameThreeHtml . $gameFourHtml;
                        }

                        if (count($TPL_V1["item"]) > 1) $gameName = "다폴더게임";

                        /* <td>{$select_val}</td> */
                        echo "<tr>
							<td><input type=\"checkbox\" id=\"betBox\" value=\"{$bettingNo}\" /></td>
							<td style=\"text-align:left;\">" . substr($bettingNo, 5, 6) . "</td>
							<td style=\"color:#504e4b; text-align:center; font-weight:bold;\">{$bettingDate} <br />[{$gameTh}회차]</td>
							<td>{$betDay}<br />{$betTime}</td>
							<td style=\"color:#504e4b; font-weight:bold;\">{$gameName}</td>
							<td style=\"text-align:center;\"><div class=\"result_data2\">{$gameResultHtml}</div></td>
							<td>{$bettingRate}</td>
							<td>" . number_format($bettingMoney) . "</td>
							<td>{$resultMoney}</td>
							<td>{$bettingResult}</td>
						</tr>";
                    }
                }
                ?>
            </table>
            <div class="new_betting7_btn">
                <ul>
                    <li><input type="image" src="/images/mybet_choice.png" alt="전체선택" onClick="checkAll();"/></li>
                    <li><input type="image" src="/images/mybet_del.png" alt="선택삭제" onClick="delBetting();"/></li>
                </ul>
                <p><input type="image" src="/images/mybet_all.png" alt="전체 베팅내역" style="margin-top:-1px;" onClick="top.location.href='/race/betting_list?game=sadari';"/></p>
            </div>
        </div>


    </div>
		<div style="display:none; position:absolute; top:0; left:0; width:935px; height:570px; background:#fff; overflow:auto; z-index:10000000;" id="real20_help">
			<img src="/images/real20/real20_help.jpg?v=<? echo time() ?>" />
			<div style="position:absolute; top:10px; right:10px; width:34px; height:34px;"><img src="/images/real20/btn_close.png" onclick="$('#real20_help').hide();" /></div>
		</div>
</div>

<link rel="stylesheet" type="text/css" href="/include/css/font-awesome.css"/>
<script type="text/javascript"> var serverCurrentTime = '<? echo date('H:i'); ?>'</script>
<script type="text/javascript">
    var VarMoney = '<?php echo $TPL_VAR["cash"]?>';      //-> 보유머니
    var VarMinBet = '<?php echo $TPL_VAR["betMinMoney"]?>';  //-> 최소배팅머니
    var VarMaxBet = '<?php echo $TPL_VAR["betMaxMoney"]?>';  //-> 최고배팅머니
    var VarMaxAmount = '<?php echo $TPL_VAR["maxBonus"]?>';  //-> 최대당첨금

    function checkAll() {
        $("input[id=betBox]").prop('checked', true);
    }

    function delBetting() {
        var ckVal = new Array();
        if (confirm("정말 베팅내역을 삭제 하시겠습니까?")) {
            $("input[id=betBox]").each(function () {
                if ($(this).is(":checked")) {
                    ckVal += $(this).val() + "|";
                }
            });

            if (ckVal != "") {
                $.ajaxSetup({async: false});
                var param = {bettingList: ckVal};
                $.post("/race/hide_betting", param, function (result) {
                    if (result == "true") {
                        alert("베팅내역이 삭제 되었습니다.");
                        top.location.reload();
                    } else {
                        alert('처리중 오류가 발생되었습니다.');
                    }
                });
            }
        }
    }
</script>
<!--
<script type='text/javascript' src='/include/js/real20XMLHttpRequest.js?v=<? echo time() ?>'></script>
<script type='text/javascript' src='/include/js/real20Controller.js?v=<? echo time() ?>'></script>
<script type='text/javascript' src='/include/js/real20.js?v=<? echo time() ?>'></script>
-->
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveCore.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveImagePanel.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveImagePanelController.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveGameList.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveDisplayBoard.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/dara365/real20LiveBattingPanelController.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20LiveStatistics.min.js?v=<? echo time() ?>"></script>
<script type="text/javascript" src="//real-2020.com/resource/js/real20/dist/real20Live.js?v=<? echo time() ?>"></script>