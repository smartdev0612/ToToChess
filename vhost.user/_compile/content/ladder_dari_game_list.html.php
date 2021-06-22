<?php
$gameType = $TPL_VAR["game_type"];
$sportType = $TPL_VAR["sport_type"];

$dari_oe = $TPL_VAR["mini_odds"]["dari_oe"];
$dari_lr = $TPL_VAR["mini_odds"]["dari_lr"];
$dari_line = $TPL_VAR["mini_odds"]["dari_line"];
$dari_oeline_lr = $TPL_VAR["mini_odds"]["dari_oeline_lr"];

?>

<script>
    var limit_time = <?php echo $TPL_VAR["mini_config"]["dari_limit"]?>;
    <?php if($TPL_VAR["mini_config"]["dari"] == 0) {?>
        alert('다리다리 미니게임은 현재 점검중입니다.\n이용에 불편을 드려 죄송합니다.');
    document.location.href='/';
    <?php } ?>

	function gameView(obj, target){
		if ( target == "game_view2" ) {
			jq$("#game_view2").show();
		} else {
			jq$("#game_view2").hide();
		}
		jq$(obj).parent("ul").find("li").removeClass();
		jq$(obj).addClass("on");
	}
</script>
<div id="contents_top">
    <div class="board_title"><?php echo $TPL_VAR["title"];?></div>
</div>

<div id="contents_left" style="min-height:600px; margin-left:80px;width: 940px;padding: 15px;">
<!-- tab menu -->
	<ul class="ntry">
		<li class="on" onClick="gameView(this, 'game_view1');">중계1</li>
		<li onClick="gameView(this, 'game_view2');">중계2</li>
	</ul>

	<!-- 중계2 시작-->
	<div id="game_view2" style="position: absolute;top: 240px;left: 105px;width: 935px;height: 523px;z-index: 90000000;display: none">
		<div class="ladder_top" style="margin:40px 0 0 53px;">	
			<div id="wrap_ladder" class="ladder_area" style="margin-left:-334px; margin-top:-208px;">		
				<iframe src="http://ntry.com/scores/named_dari/main.php" name="ladder" id="ladder" frameborder="2" scrolling="no" style="width:1229px;height:831px;"></iframe>
			</div>
		</div>
	</div>

	<!-- 중계 1 시작 -->
	<div style="width:936px;height:892px;overflow:hidden;margin:0 auto; background:url('/images/game_dari_1.png') 0 0 no-repeat;">
		<!-- 네임드 다리다리 게임화면 -->
		<div class="ladder_tit">
			<h2 style="background:none;">다리다리게임</h2>
		</div>

		<div class="ladder_top" style="margin-left:200px;">
<?php
	if ( $TPL_VAR["named_security_flag"] == 1 ) {
		echo "<div id=\"wrap_ladder\" class=\"ladder_area\" style=\"left:0px; top:-174px; left:25px;\">
						<img src=\"/images/named_security.jpg\" style=\"margin-top:172px; padding-left:10px;\">
					</div>";
	} else {
		echo "<div id=\"wrap_ladder\" class=\"ladder_area\" style=\"top:-174px; left:-243px;\">
						<iframe src=\"http://daridari.named.com\" name=\"ladder\" id=\"ladder\" frameborder=\"2\" scrolling=\"no\" style=\"width:800px;\"></iframe>
					</div>";
	}
?>
			<!-- 실시간베팅현황 -->
			<div class="ladder_now_bet" style="display:none;">
				<h3 style="color:#000;">실시간 베팅현황</h3>
				<!--<a href="" class="btn_refresh">새로고침</a>-->
				<ul>
					<li class="end_pos_o"><span class="tx">홀</span><span class="money" id="home_s_oe">0</span>&nbsp;원</li>
					<li class="end_pos_e"><span class="tx">짝</span><span class="money" id="away_s_oe">0</span>&nbsp;원</li>
					<li class="start_pos_l"><span class="tx">좌</span><span class="money" id="home_s_lr">0</span>&nbsp;원</li>
					<li class="start_pos_r"><span class="tx">우</span><span class="money" id="away_s_lr">0</span>&nbsp;원</li>
					<li class="line_num_3"><span class="tx">3줄</span><span class="money" id="home_s_34">0</span>&nbsp;원</li>
					<li class="line_num_4"><span class="tx">4줄</span><span class="money" id="away_s_34">0</span>&nbsp;원</li>
					<li class="mix_l3e"><span class="tx">좌3짝</span><span class="money" id="home_s_e3o4l">0</span>&nbsp;원</li>
					<li class="mix_l4o"><span class="tx">좌4홀</span><span class="money" id="away_s_e3o4l">0</span>&nbsp;원</li>
					<li class="mix_r3o"><span class="tx">우3홀</span><span class="money" id="home_s_o3e4r">0</span>&nbsp;원</li>
					<li class="mix_r4e"><span class="tx">우4짝</span><span class="money" id="away_s_o3e4r">0</span>&nbsp;원</li>
				</ul>
			</div>
			<!--// 실시간베팅현황 -->
		</div>

		<!-- 다리다리 배팅판 -->
		<div id="list_tableb" style="position:relative;">
			<div class="new_betting0">
				<span id="viewSysDate"></span> <span style="color:#ffce25; font-weight:bold;">[<span id="viewGameTh"></span>회차]</span><br /> <span id="viewSysTime"></span><br /> 
				<span style="display:block; margin:5px 0 0; color:#fff0c7; font-size:24px; font-weight:bold;"><span id="viewGameTime"></span></span><br />
				<input type="image" src="/images/Refresh.png" alt="새로고침" onClick="location.reload();" />
			</div>

			<ul class="new_betting1">
				<li><input type="button" value="<?php echo $dari_oe?>" class="b_odd" onclick="gameSelect('odd','<?php echo $dari_oe?>');" id="gameSt_odd"></li>
				<li><input type="button" value="<?php echo $dari_oe?>" class="b_even" onclick="gameSelect('even','<?php echo $dari_oe?>');" id="gameSt_even"></li>
			</ul>

			<ul class="new_betting2">
				<li><input type="button" value="<?php echo $dari_lr?>" class="b_lft" onclick="gameSelect('left','<?php echo $dari_lr?>');" id="gameSt_left"></li>
				<li><input type="button" value="<?php echo $dari_lr?>" class="b_rgt" onclick="gameSelect('right','<?php echo $dari_lr?>');" id="gameSt_right"></li>
				<li><input type="button" value="<?php echo $dari_line?>" class="b_3_odd" onclick="gameSelect('3line','<?php echo $dari_line?>');" id="gameSt_3line"></li>
				<li><input type="button" value="<?php echo $dari_line?>" class="b_4_even" onclick="gameSelect('4line','<?php echo $dari_line?>');" id="gameSt_4line"></li>
			</ul>

			<ul class="new_betting3">
				<li><input type="button" value="<?php echo $dari_oeline_lr?>" class="b_lft_3_oven" onclick="gameSelect('even3line_left','<?php echo $dari_oeline_lr?>');" id="gameSt_even3line_left"></li>
				<li><input type="button" value="<?php echo $dari_oeline_lr?>" class="b_lft_4_odd" onclick="gameSelect('odd4line_left','<?php echo $dari_oeline_lr?>');" id="gameSt_odd4line_left"></li>
				<li><input type="button" value="<?php echo $dari_oeline_lr?>" class="b_rgt_3_odd" onclick="gameSelect('odd3line_right','<?php echo $dari_oeline_lr?>');" id="gameSt_odd3line_right"></li>
				<li><input type="button" value="<?php echo $dari_oeline_lr?>" class="b_rgt_4_even" onclick="gameSelect('even4line_right','<?php echo $dari_oeline_lr?>');" id="gameSt_even4line_right"></li>
                <div class="bet_disable_3game"></div>
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
				<dd><span style="font-size:11px;">[다리다리]</span></dd>
				<dt>게임선택</dt>
				<dd><span id="stGameIcon">선택하세요</span></dd>
				<dt>배당률</dt>
				<dd><span id="stGameRate">0.00</span></dd>
			</dl>
		</div>			
	</div>

	<div id="bettingShadow" class="bet_disable">지금은 베팅을 하실 수 없습니다.</div>

<div style="width:893px;height:1022px;overflow:hidden;background:url('/images/game_sadari_2.png') 0 0 no-repeat; padding:52px 23px 0 20px;">	
	<!-- 홀짝 그래프 -->
	<div style="height:339px;">
		<iframe id="iframe_sadari_graph" src="/dari_result_graph" frameborder="0" border="0" scrolling="yes" style="width:893px; height:339px;"></iframe>
	</div>

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

				if ( $gameCode == "d_oe" ) {
					$gameName = "홀/짝";
					if ( $TPL_V2["select_no"] == 1 ) {
						$select_val = "<img src=\"/images/mybet_odd.png\">";
					} else {
						$select_val = "<img src=\"/images/mybet_even.png\">";
					}
				} else if ( $gameCode == "d_lr" ) {
					$gameName = "좌/우";
					if ( $TPL_V2["select_no"] == 1 ) {
						$select_val = "<img src=\"/images/mybet_left.png\">";
					} else {
						$select_val = "<img src=\"/images/mybet_right.png\">";
					}
				} else if ( $gameCode == "d_34" ) {
					$gameName = "3줄/4줄";
					if ( $TPL_V2["select_no"] == 1 ) {
						$select_val = "<img src=\"/images/mybet_3line.png\">";
					} else {
						$select_val = "<img src=\"/images/mybet_4line.png\">";
					}
				} else if ( $gameCode == "d_e3o4l" ) {
					$gameName = "짝좌3줄/홀좌4줄";
					if ( $TPL_V2["select_no"] == 1 ) {
						$select_val = "<img src=\"/images/mybet_even3line_left.png\">";
					} else {
						$select_val = "<img src=\"/images/mybet_odd4line_left.png\">";
					}
				} else if ( $gameCode == "d_o3e4r" ) {
					$gameName = "홀우3줄/짝우4줄";
					if ( $TPL_V2["select_no"] == 1 ) {
						$select_val = "<img src=\"/images/mybet_odd3line_right.png\">";
					} else {
						$select_val = "<img src=\"/images/mybet_even4line_right.png\">";
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
			<p><input type="image" src="/images/mybet_all.png" alt="전체 베팅내역"  style="margin-top:-1px;" onClick="top.location.href='/race/betting_list?game=sadari';" /></p>
		</div>
	</div>
</div>

 
</div>



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

		//-> 실시간 배팅현황
		//sadariBettingMoney();

		//-> 사다리 그래프 스크롤바
		jq$("#iframe_sadari_graph").scrollLeft(300);
	});

	function sadariBettingMoney() {
		if ( yyyy == null || mm == null || dd == null ) return;

		var fullDate = yyyy+"-"+mm+"-"+dd;
		jq$.ajax({
			url : "/member/sadariBettingMoney",
			data : {"gameDate":fullDate, "gameTh":gameTh},
			type : "post",
			cache : false,
			async : false,
			timeout : 5000,
			scriptCharset : "utf-8",
			dataType : "json",
			success: function(res) {
				if ( res != null ) {
                    jq$.each(res, function(key, value) {
						jq$("#"+key).animateNumber({number:value, numberStep:comma_separator_number_step});
					});
				}
			},
			error: function(xhr,status,error) {}	
		});

		// 업데이트 주기(10초)
		setTimeout(function(){
			sadariBettingMoney();
		},10000);
	}

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
						swal("베팅내역이 삭제 되었습니다.");
						top.location.reload();
					} else {
						swal('처리중 오류가 발생되었습니다.\n(진행중인 내역은 삭제 할 수 없습니다.)');
					}
				});
			}
		}
	}
</script>