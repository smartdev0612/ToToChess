<?php
$gameType = $TPL_VAR["game_type"];
$sportType = $TPL_VAR["sport_type"];
?>

<script>
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
	<div id="game_view2" style="position: absolute;top: 145px;/* left: 180px; */width: 935px;height: 525px;z-index: 90000000;display: none;">
		<div class="ladder_top" style="margin:40px 0 0 53px;">	
			<div id="wrap_ladder" class="ladder_area" style="margin-left:-334px; margin-top:-208px;">		
				<iframe src="http://named.com/games/newRacing/view.php" name="ladder" id="ladder" frameborder="2" scrolling="no" style="width:1229px;height:831px;"></iframe>
			</div>
		</div>
	</div>

	<!-- 중계 1 시작 -->
	<div id="new_wrap_ladder">
		<!-- 네임드 달팽이 게임화면 -->
		<div class="snail_top">
			<div class="snail_area">
<?php
	if ( $TPL_VAR["named_security_flag"] == 1 ) {
		echo "<img src=\"/images/named_security.jpg?v=".time()."\" style=\"margin:20px 0 0 10px;\">";
	} else {
		echo "<iframe id=\"game_frame\" src=\"http://named.com/games/racing/view.php\" frameborder=\"0\" border=\"0\" scrolling=\"no\"></iframe>";
	}
?>
			</div>
    </div>

		<!-- 달팽이 배팅판 -->
		<div class="new_wrap_ladder0">
			<span id="viewSysDate"></span> <span style="color:#502c18; font-weight:bold;">[<span id="viewGameTh"></span>회차]</span> <span id="viewSysTime"></span>
				<span style="color:#ff0000; font-size:14px; font-weight:bold;">[<span id="viewGameTime"></span>]</span>
		</div>
		<p class="new_wrap_ladder1"><input type="image" src="/images/Refresh.png" alt="새로고침" onClick="location.reload();" /></p>
		<div class="new_wrap_ladder2">
			<div class="new_wrap_ladder2_1">
				<ul>
					<li><a href="javascript:gameSelect('1w-n','2.80');"><img src="/images/betting_ne_d.png" id="gameSt_1w-n" alt="네" /></a></li>
					<li><a href="javascript:gameSelect('1w-e','2.80');"><img src="/images/betting_im_d.png" id="gameSt_1w-e" alt="임" /></a></li>
					<li><a href="javascript:gameSelect('1w-d','2.80');"><img src="/images/betting_de_d.png" id="gameSt_1w-d" alt="드" /></a></li>
				</ul>
				<p>2.80</p>
			</div>
			<div class="new_wrap_ladder2_2">
				<ul>
					<li><a href="javascript:gameSelect('1w2d3l-n','1.90');"><img src="/images/betting_ne_d.png" id="gameSt_1w2d3l-n" alt="네" /></a></li>
					<li><a href="javascript:gameSelect('1w2d3l-e','1.90');"><img src="/images/betting_im_d.png" id="gameSt_1w2d3l-e" alt="임" /></a></li>
					<li><a href="javascript:gameSelect('1w2d3l-d','1.90');"><img src="/images/betting_de_d.png" id="gameSt_1w2d3l-d" alt="드" /></a></li>
				</ul>
				<p>1.90</p>
			</div>
			<div class="new_wrap_ladder2_3">
				<ul>
					<li><a href="javascript:gameSelect('1w2w3l-n','1.27');"><img src="/images/betting_ne_d.png" id="gameSt_1w2w3l-n" alt="네" /></a></li>
					<li><a href="javascript:gameSelect('1w2w3l-e','1.27');"><img src="/images/betting_im_d.png" id="gameSt_1w2w3l-e" alt="임" /></a></li>
					<li><a href="javascript:gameSelect('1w2w3l-d','1.27');"><img src="/images/betting_de_d.png" id="gameSt_1w2w3l-d" alt="드" /></a></li>
				</ul>
				<p>1.27</p>
			</div>
		</div>
		<div class="new_wrap_ladder3">
			<ul>
				<li><a href="javascript:gameSelect('ned','5.55');"><img src="/images/betting_1_d.png" id="gameSt_ned" alt="네임드" /></a></li>
				<li><a href="javascript:gameSelect('nde','5.55');"><img src="/images/betting_2_d.png" id="gameSt_nde" alt="네임드" /></a></li>
				<li><a href="javascript:gameSelect('end','5.55');"><img src="/images/betting_3_d.png" id="gameSt_end" alt="네임드" /></a></li>
				<li><a href="javascript:gameSelect('edn','5.55');"><img src="/images/betting_4_d.png" id="gameSt_edn" alt="네임드" /></a></li>
				<li><a href="javascript:gameSelect('dne','5.55');"><img src="/images/betting_5_d.png" id="gameSt_dne" alt="네임드" /></a></li>
				<li><a href="javascript:gameSelect('den','5.55');"><img src="/images/betting_6_d.png" id="gameSt_den" alt="네임드" /></a></li>
			</ul>
			<p>5.55</p>
		</div>

		<!-- 실시간 베팅현황 -->
		<div class="now_bet" style="display:none;">
			<h3 class="hidden">실시간 베팅현황</h3>
			<!--a href="" class="btn_refresh">새로고침</a-->
			<dl>
					<dt class="hidden">1게임</dt>
					<dd>
							<ul>
									<li><strong class="btn_ne">네</strong><span class="money"><span id="home_r_1w">0</span>원</span></li>
									<li><strong class="btn_im">임</strong><span class="money"><span id="draw_r_1w">0</span>원</span></li>
									<li><strong class="btn_du">드</strong><span class="money"><span id="away_r_1w">0</span>원</span></li>
							</ul>
					</dd>
			</dl>
			<dl>
					<dt class="hidden">2게임</dt>
					<dd>
							<ul>
									<li><strong class="btn_ne">네</strong><span class="money"><span id="home_r_1w2d3l">0</span>원</span></li>
									<li><strong class="btn_im">임</strong><span class="money"><span id="draw_r_1w2d3l">0</span>원</span></li>
									<li><strong class="btn_du">드</strong><span class="money"><span id="away_r_1w2d3l">0</span>원</span></li>
							</ul>
					</dd>
			</dl>
			<dl>
					<dt class="hidden">3게임</dt>
					<dd>
							<ul>
									<li><strong class="btn_ne">네</strong><span class="money"><span id="home_r_1w2w3l">0</span>원</span></li>
									<li><strong class="btn_im">임</strong><span class="money"><span id="draw_r_1w2w3l">0</span>원</span></li>
									<li><strong class="btn_du">드</strong><span class="money"><span id="away_r_1w2w3l">0</span>원</span></li>
							</ul>
					</dd>
			</dl>

		</div>
	</div>

	
	<div id="new_wrap_ladder2">
		<div class="new_wrap_ladder20">
			게임분류 <span style="color:#502c18; font-weight:bold;">[달펭이레이싱]</span>
			게임선택 <span style="color:#502c18; font-weight:bold;">[<span id="stGameTitle">선택하세요</span>]</span>&nbsp;
			<span style="font-size:14px;">배당률 [<span id="stGameRate">0.00</span>]</span>
		</div>
		<div class="new_betting_input3">
			<input type="text" id="btMoney" name="btMoney" value="0" readonly onFocus="blur();" /> 
			<input type="text" id="hitMoney" name="hitMoney" value="0" style="margin-left:115px; color:#106de1;" readonly onFocus="blur();" />
		</div>
		<div class="new_betting_input4">
			<input type="text" id="mulMoney" name="mulMoney" value="0" onkeyUp="moneyPlusManual(this.value);" />
		</div>
		<ul class="new_betting21">
			<li><a href="javascript:moneyPlus('5000');"><img src="/images/dal_5000_d.png" onMouseOver="this.src='/images/dal_5000_u.png'" onMouseOut="this.src='/images/dal_5000_d.png'" alt="5,000" /></a></li>
			<li><a href="javascript:moneyPlus('10000');"><img src="/images/dal_10000_d.png" onMouseOver="this.src='/images/dal_10000_u.png'" onMouseOut="this.src='/images/dal_10000_d.png'" alt="10,000" /></a></li>
			<li><a href="javascript:moneyPlus('50000');"><img src="/images/dal_50000_d.png" onMouseOver="this.src='/images/dal_50000_u.png'" onMouseOut="this.src='/images/dal_50000_d.png'" alt="5,0000" /></a></li>
			<li><a href="javascript:moneyPlus('100000');"><img src="/images/dal_100000_d.png" onMouseOver="this.src='/images/dal_100000_u.png'" onMouseOut="this.src='/images/dal_100000_d.png'" alt="100,000" /></a></li>
			<li><a href="javascript:moneyPlus('500000');"><img src="/images/dal_500000_d.png" onMouseOver="this.src='/images/dal_500000_u.png'" onMouseOut="this.src='/images/dal_500000_d.png'" alt="500,000" /></a></li>
			<li><a href="javascript:moneyPlus('1000000');"><img src="/images/dal_1000000_d.png" onMouseOver="this.src='/images/dal_1000000_u.png'" onMouseOut="this.src='/images/dal_1000000_d.png'" alt="1,000,000" /></a></li>
			<li><a href="javascript:moneyPlus('ex');"><img src="/images/dal_change_d.png" onMouseOver="this.src='/images/dal_change_u.png'" onMouseOut="this.src='/images/dal_change_d.png'" alt="잔돈" /></a></li>
			<li><a href="javascript:moneyPlus('all');"><img src="/images/dal_allin_d.png" onMouseOver="this.src='/images/dal_allin_u.png'" onMouseOut="this.src='/images/dal_allin_d.png'" alt="올인" /></a></li>
			<li><a href="javascript:moneyPlus('reset');"><img src="/images/dal_refresh_d.png" onMouseOver="this.src='/images/dal_refresh_u.png'" onMouseOut="this.src='/images/dal_refresh_d.png'" alt="초기화" /></a></li>
		</ul>
		<ul class="new_betting22">
			<li><a href="javascript:gameBetting();"><img src="/images/betting_d.png" alt="베팅하기" /></a></li>
		</ul>

		<div id="bettingShadow" class="bet_disable_race">지금은 베팅을 하실 수 없습니다.</div>

		<div style="width:855px; height:392px; margin-top:231px; margin-left:43px; position:relative;">
			<table width="100%" cellspacing="0" cellpadding="0" class="new_betting7">
				<colgroup>
					<col width="32" />
					<col width="48" />
					<col width="90" />
					<col width="100" />
					<col width="100" />
					<col width="100" />
					<col width="70" />
					<col width="100" />
					<col width="101" />
					<col width="110" />
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

				if ( $gameCode == "r_1w" ) {
					$gameName = "1등 달팽이";
					if ( $TPL_V2["select_no"] == 1 ) $select_val = "<img src=\"/images/mybet_ne.png\">";
					else if ( $TPL_V2["select_no"] == 2 ) $select_val = "<img src=\"/images/mybet_de.png\">";
					else $select_val = "<img src=\"/images/mybet_im.png\">";
				} else if ( $gameCode == "r_1w2d3l" ) {
					$gameName = "삼치기";
					if ( $TPL_V2["select_no"] == 1 ) $select_val = "<img src=\"/images/mybet_ne.png\">";
					else if ( $TPL_V2["select_no"] == 2 ) $select_val = "<img src=\"/images/mybet_de.png\">";
					else $select_val = "<img src=\"/images/mybet_im.png\">";
				} else if ( $gameCode == "r_1w2w3l" ) {
					$gameName = "꼴등피하기";
					if ( $TPL_V2["select_no"] == 1 ) $select_val = "<img src=\"/images/mybet_ne.png\">";
					else if ( $TPL_V2["select_no"] == 2 ) $select_val = "<img src=\"/images/mybet_de.png\">";
					else $select_val = "<img src=\"/images/mybet_im.png\">";
				} else if ( $gameCode == "r_ned-nde" ) {
					$gameName = "달팽이 순위";
					if ( $TPL_V2["select_no"] == 1 ) {
						$select_val = "<img src=\"/images/mybet_ne.png\"><img src=\"/images/mybet_im.png\"><img src=\"/images/mybet_de.png\">";
					} else {
						$select_val = "<img src=\"/images/mybet_ne.png\"><img src=\"/images/mybet_de.png\"><img src=\"/images/mybet_im.png\">";
					}
				} else if ( $gameCode == "r_end-edn" ) {
					$gameName = "달팽이 순위";
					if ( $TPL_V2["select_no"] == 1 ) {
						$select_val = "<img src=\"/images/mybet_im.png\"><img src=\"/images/mybet_ne.png\"><img src=\"/images/mybet_de.png\">";
					} else {
						$select_val = "<img src=\"/images/mybet_im.png\"><img src=\"/images/mybet_de.png\"><img src=\"/images/mybet_ne.png\">";
					}
				} else if ( $gameCode == "r_dne-den" ) {
					$gameName = "달팽이 순위";
					if ( $TPL_V2["select_no"] == 1 ) {
						$select_val = "<img src=\"/images/mybet_de.png\"><img src=\"/images/mybet_ne.png\"><img src=\"/images/mybet_im.png\">";
					} else {
						$select_val = "<img src=\"/images/mybet_de.png\"><img src=\"/images/mybet_im.png\"><img src=\"/images/mybet_ne.png\">";
					}
				}

				echo "<tr>
								<td><input type=\"checkbox\" id=\"betBox\" value=\"{$bettingNo}\" /></td>
								<td>".substr($bettingNo,5,6)."</td>
								<td style=\"color:#504e4b; font-weight:bold;\">{$bettingDate} <br />[{$gameTh}회차]</td>
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
			<div class="new_betting23_btn">
				<ul>
					<li><input type="image" src="/images/dal_allchoice.png" alt="전체선택" onClick="checkAll();" /></li>
					<li><input type="image" src="/images/dal_choice.png" alt="선택삭제" style="" onClick="delBetting();" /></li>
				</ul>
				<p><input type="image" src="/images/dal_mybetting.png" alt="전체 베팅내역" style="margin-top:-1px;" onClick="top.location.href='/race/betting_list?game=race';" /></p>
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
				jq$(this).attr('src',jq$(this).attr("src").replace("_d.","_u."));
			}
		});
		jq$("img[id^=gameSt_]").mouseout(function() {
			checkSelectGame = jq$(this).attr('id').replace("gameSt_","");
			if ( selectGameType != checkSelectGame ) {
				jq$(this).attr('src',jq$(this).attr("src").replace("_u.","_d."));
			}
		});
		
		//-> 타이머 시작
		getServerTime();

		//-> 실시간 배팅현황
		//raceBettingMoney();
	});

	function raceBettingMoney() {
		if ( yyyy == null || mm == null || dd == null ) return;

		var fullDate = yyyy+"-"+mm+"-"+dd;
		$.ajax({
			url : "/member/raceBettingMoney",
			data : {"gameDate":fullDate, "gameTh":gameTh},
			type : "post",
			cache : false,
			async : false,
			timeout : 5000,
			scriptCharset : "utf-8",
			dataType : "json",
			success: function(res) {
				if ( res != null ) {
					$.each(res, function(key, value) {
						jq$("#"+key).animateNumber({number:value, numberStep:comma_separator_number_step});
					});
				}
			},
			error: function(xhr,status,error) {}	
		});

		// 업데이트 주기(10초)
		setTimeout(function(){
			raceBettingMoney();
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
				$.ajaxSetup({async:false});
				var param = {bettingList:ckVal};
				$.post("/race/hide_betting", param, function(result) {
					if ( result == "true" ) {
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