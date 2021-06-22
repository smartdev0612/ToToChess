<div id="contents_top">
    <div class="board_title"><?php echo $TPL_VAR["title"];?></div>
</div>

<div id="contents_left" style="width:1000px; min-height:600px; margin-left:90px;">
    <div style="margin-left: 20px;margin-top: 40px">
        <div class="ladder_top" style="height:590px; margin:0px;">
            <div id="wrap_ladder" class="ladder_area" style="top:-130px; left:5px; margin-top:130px;">
                <iframe id="pbframe" src="https://rt.ozlive.com/bar/web_baccarat1-2.html" style="width: 930px; height: 590px;" scrolling="no"></iframe>
                <!--<iframe id="pbframe" src="http://proxy.earn-bay.com/redirect.php?param=web_baccarat1-2.html" style="width: 930px; height: 590px;" scrolling="no"></iframe>-->
            </div>
        </div>

        <div style="height:325px;overflow:hidden;margin:5px 0 0 0; background:url('/images/mgmbacara_betting_bar.png') 0 0 no-repeat;">
            <div id="list_tableb" class="cod_wrap1" style="position:relative;">
                <div class="new_betting0">
                    <span id="viewSysDate"></span> <span style="color:#ffce25; font-weight:bold;">[<span id="viewGameTh"></span>회차]</span><br /> <span id="viewSysTime"></span><br />
                    <span style="display:block; margin:5px 0 0; color:#fff0c7; font-size:24px; font-weight:bold;"><span id="viewGameTime"></span></span><br />
                    <input type="image" src="/images/cod/btn_refresh.gif" alt="새로고침" onClick="location.reload();" />
                </div>

                <ul class="mgm_betting1">
                    <li><input class="b_player" id="gameSt_player" onclick="gameSelect('player','1.95');" type="button" value="1.95"></li>
                </ul>
                <ul class="mgm_betting11">
                    <li><input class="b_banker" id="gameSt_banker" onclick="gameSelect('banker','1.95');" type="button" value="1.95"></li>
                </ul>

                <ul class="pair_betting1">
                    <li><input class="b_player_pair" id="gameSt_player_pair" onclick="gameSelect('player_pair','7.90');" type="button" value="7.90"></li>
                </ul>
                <ul class="pair_betting11">
                    <li><input class="b_banker_pair" id="gameSt_banker_pair" onclick="gameSelect('banker_pair','7.90');" type="button" value="7.90"></li>
                </ul>

                <ul class="mgm_betting2">
                    <li><input class="b_tai" id="gameSt_tai" onclick="gameSelect('tai','7.90');" type="button" value="7.90"></li>
                </ul>

                <div class="new_betting_input1">
                    <input type="text" id="btMoney" name="btMoney" value="0" readonly onFocus="blur();" />
                    <input type="text" id="hitMoney" name="hitMoney" value="0" style="margin-left:87px; color:#1e75e2;" readonly onFocus="blur();" />
                </div>
                <div class="new_betting_input2">
                    <input type="text" id="mulMoney" name="mulMoney" value="0" onkeyUp="moneyPlusManual(this.value);" />
                </div>
                <ul class="new_betting4">
                    <li><a href="javascript:moneyPlus('5000');"><img src="/images/cod/5000_d.png" onMouseOver="this.src='/images/cod/5000_u.png'" onMouseOut="this.src='/images/cod/5000_d.png'" alt="5,000" /></a></li>
                    <li><a href="javascript:moneyPlus('10000');"><img src="/images/cod/10000_d.png" onMouseOver="this.src='/images/cod/10000_u.png'" onMouseOut="this.src='/images/cod/10000_d.png'" alt="10,000" /></a></li>
                    <li><a href="javascript:moneyPlus('50000');"><img src="/images/cod/50000_d.png" onMouseOver="this.src='/images/cod/50000_u.png'" onMouseOut="this.src='/images/cod/50000_d.png'" alt="5,0000" /></a></li>
                    <li><a href="javascript:moneyPlus('100000');"><img src="/images/cod/100000_d.png" onMouseOver="this.src='/images/cod/100000_u.png'" onMouseOut="this.src='/images/cod/100000_d.png'" alt="100,000" /></a></li>
                    <li><a href="javascript:moneyPlus('500000');"><img src="/images/cod/500000_d.png" onMouseOver="this.src='/images/cod/500000_u.png'" onMouseOut="this.src='/images/cod/500000_d.png'" alt="500,000" /></a></li>
                    <li><a href="javascript:moneyPlus('1000000');"><img src="/images/cod/1000000_d.png" onMouseOver="this.src='/images/cod/1000000_u.png'" onMouseOut="this.src='/images/cod/1000000_d.png'" alt="1,000,000" /></a></li>
                    <li><a href="javascript:moneyPlus('ex');"><img src="/images/cod/change_d.png" onMouseOver="this.src='/images/cod/change_u.png'" onMouseOut="this.src='/images/cod/change_d.png'" alt="잔돈" /></a></li>
                    <li><a href="javascript:moneyPlus('all');"><img src="/images/cod/allin_d.png" onMouseOver="this.src='/images/cod/allin_u.png'" onMouseOut="this.src='/images/cod/allin_d.png'" alt="올인" /></a></li>
                    <li><a href="javascript:moneyPlus('reset');"><img src="/images/cod/del_d.png" onMouseOver="this.src='/images/cod/del_u.png'" onMouseOut="this.src='/images/cod/del_d.png'" alt="초기화" /></a></li>
                </ul>
                <ul class="new_betting5">
                    <li><a href="javascript:gameBetting();"><img src="/images/cod/betting_d.png" alt="베팅하기" /></a></li>
                </ul>
                <dl class="new_betting6">
                    <dt>게임분류</dt>
                    <dd>[바카라]</dd>
                    <dt>게임선택</dt>
                    <dd><span id="stGameIcon">선택하세요</span></dd>
                    <dt>배당률</dt>
                    <dd><span id="stGameRate">0.00</span></dd>
                </dl>
            </div>
        </div>

        <div id="bettingShadow" class="bet_disable" style="top:890px;left:130px;">지금은 베팅을 하실 수 없습니다.</div>

        <div style="width:892px;height:430px;overflow:hidden;background:url('/images/bg_betting_list.jpg') 0 0 no-repeat; padding:0px 23px 0 20px;">
            <!-- 배팅 내역 -->
            <div style="width:893px; height:322px; margin-top:48px; position:relative;">
                <!-- 배팅내역 그래프 -->
                <div class="cod_table2">
                    <div class="ladder_wrap">
                        <div class="ladder_cod_inner2">
                            <table id="graphTable" summary="배팅내역">
                                <thead>
                                <tr>
                                    <th width="99">번호</th>
                                    <th width="99">회차</th>
                                    <th width="99">배팅시간</th>
                                    <th width="100">게임분류</th>
                                    <th width="99">배팅내역</th>
                                    <th width="99">배당률</th>
                                    <th width="99">배팅금액</th>
                                    <th width="99">적중/손실</th>
                                    <th width="99">적중여부</th>
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

                                            if ( $gameCode == "mgmbacara_pb" ) {
                                                $gameName = "PLAYER<br>BANKER";
                                                if ( $TPL_V2["select_no"] == 1 ) {
                                                    $select_val = "<img src=\"/images/mybet_player.png\">";
                                                } else {
                                                    $select_val = "<img src=\"/images/mybet_banker.png\">";
                                                }
                                            } else if ( $gameCode == "mgmbacara_pp" ) {
                                                $gameName = "플레이어<br>페어";
                                                $select_val = "<img src=\"/images/mybet_player_pair.png\">";
                                            } else if ( $gameCode == "mgmbacara_bp" ) {
                                                $gameName = "뱅커<br>페어";
                                                $select_val = "<img src=\"/images/mybet_banker_pair.png\">";
                                            } else if ( $gameCode == "mgmbacara_tai" ) {
                                                $gameName = "타이";
                                                $select_val = "<img src=\"/images/mybet_tai.png\">";
                                            }

                                            echo "<tr>
								<td align='center'><input type=\"checkbox\" id=\"betBox\" value=\"{$bettingNo}\" />&nbsp;".substr($bettingNo,5,6)."</td>
								<td align='center' style=\"text-align:left; font-weight:bold;\">{$bettingDate} <br />[{$gameTh}회차]</td>
								<td align='center'>{$betDay}<br />{$betTime}</td>
								<td align='center' style=\"font-weight:bold;\">{$gameName}</td>
								<td align='center'>{$select_val}</td>
								<td align='center'>{$bettingRate}</td>
								<td align='center'>".number_format($bettingMoney)."</td>
								<td align='center'>{$resultMoney}</td>
								<td align='center'>{$bettingResult}</td>
							</tr>";
                                        }
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="new_betting7_btn">
                    <ul>
                        <li><input type="image" src="/images/cod/cod_mybet_choice.gif" alt="전체선택" onClick="checkAll();" /></li>
                        <li><input type="image" src="/images/cod/cod_mybet_del.gif" alt="선택삭제" onClick="delBetting();" /></li>
                    </ul>
                    <p><input type="image" src="/images/cod/cod_mybet_all.gif" alt="전체 베팅내역"  style="margin-top:-1px;" onClick="top.location.href='/race/betting_list?game=sadari';" /></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/include/js/minigame/mgmbacara.js?v=<?=time();?>"></script>
<script>
	var comma_separator_number_step = jq$.animateNumber.numberStepFactories.separator(',');
	var VarMoney = '<?php echo $TPL_VAR["cash"]?>';						//-> 보유머니
	var VarMinBet = '<?php echo $TPL_VAR["betMinMoney"]?>';		//-> 최소배팅머니
	var VarMaxBet = '<?php echo $TPL_VAR["betMaxMoney"]?>';		//-> 최고배팅머니
	var VarMaxAmount = '<?php echo $TPL_VAR["maxBonus"]?>';		//-> 최대당첨금

	jq$(document).ready(function() {
		//-> 배팅버튼 이미지 처리
		jq$("img[id^=gameSt_]").mouseover(function() {
			checkSelectGame = jq$(this).attr('id').replace("gameSt_","");
			if ( selectGameType != checkSelectGame ) {
				jq$(this).attr('src',jq$(this).attr("src").replace("_d","_u"));
			}
		});
		jq$("img[id^=gameSt_]").mouseout(function() {
			checkSelectGame = jq$(this).attr('id').replace("gameSt_","");
			if ( selectGameType != checkSelectGame ) {
				jq$(this).attr('src',jq$(this).attr("src").replace("_u","_d"));
			}
		});
		
		//-> 타이머 시작
		getServerTime();
	});

	function checkAll() {
		jq$("input[id=betBox]").prop('checked', true);
	}

	function delBetting() {
		var ckVal = new Array();
		if ( confirm("정말 베팅내역을 삭제 하시겠습니까?") ) {
			jq$("input[id=betBox]").each(function() {
				if ( jq$(this).is(":checked") ) {
					ckVal += jq$(this).val() + "|";
				}
			});

			if ( ckVal != "" ) {
				jq$.ajaxSetup({async:false});
				var param = {bettingList:ckVal};
				jq$.post("/race/hide_betting", param, function(result) {
					if ( result == "true" ) {
						alert("베팅내역이 삭제 되었습니다.");
						top.location.reload();
					} else {
						alert('처리중 오류가 발생되었습니다.\n(진행중인 내역은 삭제 할 수 없습니다.)');
					}
				});
			}
		}
	}
</script>