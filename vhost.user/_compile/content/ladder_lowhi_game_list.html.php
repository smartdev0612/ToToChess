<div id="contents_top">
    <div class="board_title"><?php echo $TPL_VAR["title"];?></div>
</div>

<div id="contents_left" style="min-height:600px; margin-left:40px;width: 1000px">
    <div style="margin-top: 40px;margin-left: 20px;">
        <div style="height:892px;overflow:hidden;margin:0 auto; background:url('/images/game_lowhi_1.png') 0 0 no-repeat;">
            <div class="ladder_top" style="height:540px; margin-top:30px;margin-left:65px;">
                <div id="wrap_ladder" class="ladder_area" style="left:-40px; top:-145px; width:1050px;">
                    <iframe style="width:850px; height:670px;" src="http://www.hafline.com/Theme/LowHI/Game.aspx" name="ladder" id="ladder" frameborder="0" scrolling="no"></iframe>
                </div>
            </div>

            <!-- 배팅판 -->
            <div id="list_tableb" style="position:relative;">
                <div class="new_betting0">
                    <span id="viewSysDate"></span> <span style="color:#ffce25; font-weight:bold;">[<span id="viewGameTh"></span>회차]</span><br /> <span id="viewSysTime"></span><br />
                    <span style="display:block; margin:5px 0 0; color:#fff0c7; font-size:24px; font-weight:bold;"><span id="viewGameTime"></span></span><br />
                    <input type="image" src="/images/Refresh.png" alt="새로고침" onClick="location.reload();" />
                </div>

                <ul class="lowhi_betting1">
                    <li><input type="button" value="1.95" class="b_low" onclick="gameSelect('low','1.95');" id="gameSt_low"></li>
                    <li><input type="button" value="1.95" class="b_hi" onclick="gameSelect('hi','1.95');" id="gameSt_hi"></li>
                </ul>

                <ul class="lowhi_betting2">
                    <li><input type="button" value="1.95" class="b_odd" onclick="gameSelect('odd','1.95');" id="gameSt_odd"></li>
                    <li><input type="button" value="1.95" class="b_even" onclick="gameSelect('even','1.95');" id="gameSt_even"></li>
                </ul>

                <ul class="new_betting3">
                </ul>

                <div class="new_betting_input1">
                    <input type="text" id="btMoney" name="btMoney" value="0" readonly onFocus="blur();" />
                    <input type="text" id="hitMoney" name="hitMoney" value="0" style="margin-left:87px; color:#1e75e2;" readonly onFocus="blur();" />
                </div>
                <div class="new_betting_input2">
                    <input type="text" id="mulMoney" name="mulMoney" value="0" onkeyUp="moneyPlusManual(this.value);" />
                </div>
                <ul class="new_betting4">
                    <li><a href="javascript:moneyPlus('5000');"><img src="/images/5000_d.png" onMouseOver="this.src='/images/5000_u.png'" onMouseOut="this.src='/images/5000_d.png'" alt="5,000" /></a></li>
                    <li><a href="javascript:moneyPlus('10000');"><img src="/images/10000_d.png" onMouseOver="this.src='/images/10000_u.png'" onMouseOut="this.src='/images/10000_d.png'" alt="10,000" /></a></li>
                    <li><a href="javascript:moneyPlus('50000');"><img src="/images/50000_d.png" onMouseOver="this.src='/images/50000_u.png'" onMouseOut="this.src='/images/50000_d.png'" alt="5,0000" /></a></li>
                    <li><a href="javascript:moneyPlus('100000');"><img src="/images/100000_d.png" onMouseOver="this.src='/images/100000_u.png'" onMouseOut="this.src='/images/100000_d.png'" alt="100,000" /></a></li>
                    <li><a href="javascript:moneyPlus('500000');"><img src="/images/500000_d.png" onMouseOver="this.src='/images/500000_u.png'" onMouseOut="this.src='/images/500000_d.png'" alt="500,000" /></a></li>
                    <li><a href="javascript:moneyPlus('1000000');"><img src="/images/1000000_d.png" onMouseOver="this.src='/images/1000000_u.png'" onMouseOut="this.src='/images/1000000_d.png'" alt="1,000,000" /></a></li>
                    <li><a href="javascript:moneyPlus('ex');"><img src="/images/change_d.png" onMouseOver="this.src='/images/change_u.png'" onMouseOut="this.src='/images/change_d.png'" alt="잔돈" /></a></li>
                    <li><a href="javascript:moneyPlus('all');"><img src="/images/allin_d.png" onMouseOver="this.src='/images/allin_u.png'" onMouseOut="this.src='/images/allin_d.png'" alt="올인" /></a></li>
                    <li><a href="javascript:moneyPlus('reset');"><img src="/images/del_d.png" onMouseOver="this.src='/images/del_u.png'" onMouseOut="this.src='/images/del_d.png'" alt="초기화" /></a></li>
                </ul>
                <ul class="new_betting5">
                    <li><a href="javascript:gameBetting();"><img src="/images/betting_d.png" alt="베팅하기" /></a></li>
                </ul>
                <dl class="new_betting6">
                    <dt>게임분류</dt>
                    <dd>[로하이]</dd>
                    <dt>게임선택</dt>
                    <dd><span id="stGameIcon">선택하세요</span></dd>
                    <dt>배당률</dt>
                    <dd><span id="stGameRate">0.00</span></dd>
                </dl>
            </div>
        </div>

        <div id="bettingShadow" class="bet_disable" style="top:865px; margin-left:-11px;">지금은 베팅을 하실 수 없습니다.</div>

        <div style="width:893px;height:750px;overflow:hidden;background:url('/images/game_sadari_3.png') 0 0 no-repeat; padding:1px 23px 0 20px;">

            <!-- 배팅 내역 -->
            <div style="width:895px; height:322px; overflow:hidden; margin-top:109px; position:relative;">
                <table width="100%" cellspacing="0" cellpadding="0" class="new_betting7">
                    <colgroup>
                        <col width="40" />
                        <col width="80" />
                        <col width="110" />
                        <col width="90" />
                        <col width="160" />
                        <col width="70" />
                        <col width="70" />
                        <col width="80" />
                        <col width="91" />
                        <col width="100" />
                    </colgroup>
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

                                if ( $gameCode == "lh_lh" ) {
                                    $gameName = "로우/하이";
                                    if ( $TPL_V2["select_no"] == 1 ) {
                                        $select_val = "<img src=\"/images/mybet_low.png\">";
                                    } else {
                                        $select_val = "<img src=\"/images/mybet_hi.png\">";
                                    }
                                } else if ( $gameCode == "lh_oe" ) {
                                    $gameName = "홀/짝";
                                    if ( $TPL_V2["select_no"] == 1 ) {
                                        $select_val = "<img src=\"/images/mybet_odd.png\">";
                                    } else {
                                        $select_val = "<img src=\"/images/mybet_even.png\">";
                                    }
                                }

                                echo "<tr>
									<td><input type=\"checkbox\" id=\"betBox\" value=\"{$bettingNo}\" /></td>
									<td style=\"text-align:left;\">".substr($bettingNo,5,6)."</td>
									<td style=\"color:#504e4b; text-align:left; font-weight:bold;\">{$bettingDate} <br />[{$gameTh}회차]</td>
									<td>{$betDay}<br />{$betTime}</td>
									<td style=\"color:#504e4b; font-weight:bold;\">{$gameName}</td>
									<td>{$select_val}</td>
									<td>{$bettingRate}</td>
									<td>".number_format($bettingMoney)."</td>
									<td>{$resultMoney}</td>
									<td>{$bettingResult}</td>
								</tr>";
                            }
                        }
                    }
                    ?>
                </table>
                <div class="new_betting7_btn">
                    <ul>
                        <li><input type="image" src="/images/mybet_choice.png" alt="전체선택" onClick="checkAll();" /></li>
                        <li><input type="image" src="/images/mybet_del.png" alt="선택삭제" onClick="delBetting();" /></li>
                    </ul>
                    <p><input type="image" src="/images/mybet_all.png" alt="전체 베팅내역"  style="margin-top:-1px;" onClick="top.location.href='/race/betting_list?game=aladin';" /></p>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="/include/js/minigame/lowhi.js?v=<?=time();?>"></script>
<script>
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