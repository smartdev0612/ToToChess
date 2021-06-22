<?php
if($TPL_VAR["game_type"]=="multi") { $on_multi="_o";}
if($TPL_VAR["game_type"]=="handi") { $on_handi="_o";}
if($TPL_VAR["game_type"]=="special") { $on_special="_o";}
if($TPL_VAR["game_type"]=="real") { $on_real="_o";}
if($TPL_VAR["game_type"]=="sadari") { $on_sadari="_o";}
if($TPL_VAR["game_type"]=="dari") { $on_dari="_o";}
if($TPL_VAR["game_type"]=="race") { $on_race="_o";}
if($TPL_VAR["game_type"]=="power") { $on_power="_o";}
if($TPL_VAR["game_type"]=="aladin") { $on_aladin="_o";}
if($TPL_VAR["game_type"]=="lowhi") { $on_lowhi="_o";}
if($TPL_VAR["game_type"]=="mgmoddeven") { $on_mgmoddeven="_o";}
if($TPL_VAR["game_type"]=="mgmbacara") { $on_mgmbacara="_o";}
if($TPL_VAR["game_type"]=="vfootball") { $on_vfootball="_o";}

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
?>

<script>
    var limit_time = <?php echo $TPL_VAR["mini_config"]["power_limit"]?>;
    <?php if($TPL_VAR["mini_config"]["power"] == 0) {?>
        alert('파워볼 미니게임은 현재 점검중입니다.\n이용에 불편을 드려 죄송합니다.');
        document.location.href='/';
    <?php } ?>
</script>
<style type="text/css">
.btn-pick-left {
	width:100%; 
	text-align:left; 
	height:30px; 
	background-color: rgba(0,0,0,.50); 
	border: 1px solid rgba(255, 255, 255, 0.1);
}

.btn-pick-left:hover {
	background-color: #b27200;
}

.btn-pick-right {
	text-align:left; 
	width:100%; 
	height:30px; 
	background-color: rgba(0,0,0,.50); 
	border: 1px solid rgba(255, 255, 255, 0.1);
}

.btn-pick-right:hover {
	background-color: #b27200;
}

.pick-bg {
	background-color: #b27200;
}
</style>
<!--
<div id="sub_menu" style="height:auto; margin-bottom:0px;">
    <ul>
        <li class="sub_menu_1<?php echo $on_multi?>"><a href="/game_list?game=multi" class="sub_menu_1<?php echo $on_multi?>_text">조합</a></li>
        <li class="sub_menu_1<?php echo $on_special?>"><a href="/game_list?game=special" class="sub_menu_1<?php echo $on_special?>_text">스페셜</a></li>
        <li class="sub_menu_1<?php echo $on_real?>"><a href="/game_list?game=real" class="sub_menu_1<?php echo $on_real?>_text">실시간</a></li>
        <li class="sub_menu_1<?php echo $on_vfootball?>"><a href="/game_list?game=vfootball" class="sub_menu_1<?php echo $on_power?>_text">가상축구</a></li>
        <li class="sub_menu_1<?php echo $on_sadari?>"><a href="/game_list?game=sadari" class="sub_menu_1<?php echo $on_sadari?>_text">사다리</a></li>
        <li class="sub_menu_1<?php echo $on_dari?>"><a href="/game_list?game=dari" class="sub_menu_1<?php echo $on_dari?>_text">다리다리</a></li>
        <li class="sub_menu_1<?php echo $on_race?>"><a href="/game_list?game=race" class="sub_menu_1<?php echo $on_race?>_text">달팽이</a></li>
        <li class="sub_menu_1<?php echo $on_power?>"><a href="/game_list?game=power" class="sub_menu_1<?php echo $on_power?>_text">파워볼</a></li>
    </ul>
    <ul>
        <li class="sub_menu_1<?php echo $on_aladin?>"><a href="/game_list?game=aladin" class="sub_menu_1<?php echo $on_aladin?>_text">알라딘사다리</a></li>
        <li class="sub_menu_1<?php echo $on_lowhi?>"><a href="/game_list?game=lowhi" class="sub_menu_1<?php echo $on_lowhi?>_text">로하이</a></li>
        <li class="sub_menu_1<?php echo $on_mgmoddeven?>"><a href="/game_list?game=mgmoddeven" class="sub_menu_1<?php echo $on_mgmoddeven?>_text">MGM홀짝</a></li>
        <li class="sub_menu_1<?php echo $on_mgmbacara?>"><a href="/game_list?game=mgmbacara" class="sub_menu_1<?php echo $on_mgmbacara?>_text">MGM바카라</a></li>
    </ul>
</div>
-->
<div class="powerball_wrap">
	<div class="powerball_top">
		<div class="powerball_now">
			<div class="game_info">
				<strong class="order">[제 <span id="firstTh"></span> 회차]</strong>
				<a href="javascript:;" onclick="powerballResult(0);" class="btn_refresh">새로고침</a>
				<strong class="time"><span id="last_play_day">추첨시간: <span id="result_date"></span></span></strong>
			</div>
			<div class="ball_list">
				<ul>
					<li>
						<strong><span id="ballList_1"></span></strong>
					</li>
					<li>
						<strong><span id="ballList_2"></span></strong>
					</li>
					<li>
						<strong><span id="ballList_3"></span></strong>
					</li>
					<li>
						<strong><span id="ballList_4"></span></strong>
					</li>
					<li>
						<strong><span id="ballList_5"></span></strong>
					</li>
					<li class="pb">
						<strong><span id="ballList_p"></span></strong>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="powerball_count">
		<span class="order">[ 제 <span id="viewGameTh"></span> 회차 ]</span>
		<strong class="count">[ <span id="viewGameTime"></span> ]</strong>
	</div>

	<div class="powerball_cnt">
		<div class="powerball_choice">
			<h3 class="hidden">게임선택</h3>
			<div class="powerball_choice_inner">
				<div class="powerball_1st">
					<div>
						<h4>1게임 : 일반볼 홀/짝</h4>
						<div>
							<li>
								<button onclick="gameSelect('n-oe-o','<?php echo $pb_n_oe?>');" class="btn btn-pick-left" id="gameSt_n-oe-o" >
									<span style="color:white; padding-left:5px;">일반볼 - 홀</span>
									<span style="color:yellow; float:right; padding-right:5px;"><?php echo $pb_n_oe?></span>
								<button>
							</li>
							<li>
								<button value="even" onclick="gameSelect('n-oe-e','<?php echo $pb_n_oe?>');" class="btn btn-pick-right" id="gameSt_n-oe-e">
									<span style="color:yellow; padding-left:5px;"><?php echo $pb_n_oe?></span>
									<span style="color:white; float:right; padding-right:5px;">일반볼 - 짝</span>
								<button>
							</li>													
						</div>
					</div>
				</div>
				<div class="powerball_2nd">
					<div>
						<h4>2게임 : 파워볼 홀/짝</h4>
						<div>
							<li>
								<button onclick="gameSelect('p-oe-o','<?php echo $pb_p_oe?>');" class="btn btn-pick-left" id="gameSt_p-oe-o">
									<span style="color:white; padding-left:5px;">파워볼 - 홀</span>
									<span style="color:yellow; float:right; padding-right:5px;"><?php echo $pb_p_oe?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('p-oe-e','<?php echo $pb_p_oe?>');"  class="btn btn-pick-right" id="gameSt_p-oe-e">
									<span style="color:yellow; padding-left:5px;"><?php echo $pb_p_oe?></span>
									<span style="color:white; float:right; padding-right:5px;">파워볼 - 짝</span>
								</button>	
							</li>
						</div>
					</div>
				</div>
				<div class="powerball_3rd">
					<div>
						<h4>3게임 : 일반볼 구간</h4>
						<div>
							<li>
								<button onclick="gameSelect('n-bs-a','<?php echo $pb_n_bs_a?>');" class="btn btn-pick-left"  id="gameSt_n-bs-a" style="height: 40px; text-align: center;">
									<span style="color:white;">일반볼 - 소 [15 - 64]</span><br>
									<span style="color:yellow;"><?php echo $pb_n_bs_a?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('n-bs-d','<?php echo $pb_n_bs_d?>');" class="btn btn-pick-left"  id="gameSt_n-bs-d" style="height: 40px; text-align: center;">
									<span style="color:white;">일반볼 - 중 [65 - 80]</span><br>
									<span style="color:yellow;"><?php echo $pb_n_bs_d?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('n-bs-h','<?php echo $pb_n_bs_h?>');" class="btn btn-pick-left"  id="gameSt_n-bs-h" style="height: 40px; text-align: center;">
									<span style="color:white;">일반볼 - 대 [81 - 130]</span><br>
									<span style="color:yellow;"><?php echo $pb_n_bs_h?></span>
								</button>
							</li>
						</div>
					</div>
				</div>
				<div class="powerball_4th">
					<div>
						<h4>4게임 : 파워볼 숫자</h4>
						<div style="display: flex;">
							<li>
								<button onclick="gameSelect('p_0','<?php echo $pb_p_n?>');" class="btn btn-pick-left" id="gameSt_p_0">
									<span style="color:white; padding-left:5px;">파워볼 - 0</span>
									<span style="color:yellow; float:right; padding-right:5px;"><?php echo $pb_p_n?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('p_1','<?php echo $pb_p_n?>');" class="btn btn-pick-right" id="gameSt_p_1">
									<span style="color:yellow; padding-left:5px;"><?php echo $pb_p_n?></span>
									<span style="color:white; float:right; padding-right:5px;">파워볼 - 1</span>
								</button>
							</li>
						</div>
						<div style="display: flex;">
							<li>
								<button onclick="gameSelect('p_2','<?php echo $pb_p_n?>');" id="gameSt_p_2" class="btn btn-pick-left">
									<span style="color:white; padding-left:5px;">파워볼 - 2</span>
									<span style="color:yellow; float:right; padding-right:5px;"><?php echo $pb_p_n?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('p_3','<?php echo $pb_p_n?>');" id="gameSt_p_3" class="btn btn-pick-right">
									<span style="color:yellow; padding-left:5px;"><?php echo $pb_p_n?></span>
									<span style="color:white; float:right; padding-right:5px;">파워볼 - 3</span>
								</button>
							</li>
						</div>
						<div style="display: flex;">
							<li>
								<button onclick="gameSelect('p_4','<?php echo $pb_p_n?>');" id="gameSt_p_4" class="btn btn-pick-left">
									<span style="color:white; padding-left:5px;">파워볼 - 4</span>
									<span style="color:yellow; float:right; padding-right:5px;"><?php echo $pb_p_n?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('p_5','<?php echo $pb_p_n?>');" id="gameSt_p_5" class="btn btn-pick-right">
									<span style="color:yellow; padding-left:5px;"><?php echo $pb_p_n?></span>
									<span style="color:white; float:right; padding-right:5px;">파워볼 - 5</span>
								</button>
							</li>
						</div>
						<div style="display: flex;">
							<li>
								<button onclick="gameSelect('p_6','<?php echo $pb_p_n?>');" id="gameSt_p_6" class="btn btn-pick-left">
									<span style="color:white; padding-left:5px;">파워볼 - 6</span>
									<span style="color:yellow; float:right; padding-right:5px;"><?php echo $pb_p_n?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('p_7','<?php echo $pb_p_n?>');" id="gameSt_p_7" class="btn btn-pick-right">
									<span style="color:yellow; padding-left:5px;"><?php echo $pb_p_n?></span>
									<span style="color:white; float:right; padding-right:5px;">파워볼 - 7</span>
								</button>
							</li>
						</div>
						<div style="display: flex;">
							<li>
								<button onclick="gameSelect('p_8','<?php echo $pb_p_n?>');" id="gameSt_p_8" class="btn btn-pick-left">
									<span style="color:white; padding-left:5px;">파워볼 - 8</span>
									<span style="color:yellow; float:right; padding-right:5px;"><?php echo $pb_p_n?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('p_9','<?php echo $pb_p_n?>');" id="gameSt_p_9" class="btn btn-pick-right">
									<span style="color:yellow; padding-left:5px;"><?php echo $pb_p_n?></span>
									<span style="color:white; float:right; padding-right:5px;">파워볼 - 9</span>
								</button>
							</li>
						</div>
					</div>
				</div>
				<div class="powerball_5th">
					<div>
						<h4>5게임 : 파워볼 구간</h4>
						<div style="display: flex;">
							<li>
								<button onclick="gameSelect('p_02','<?php echo $pb_p_02?>');" id="gameSt_p_02" class="btn btn-pick-left">
									<span style="color:white; padding-left:5px;">파워볼 - A [0-2]</span>
									<span style="color:yellow; float:right; padding-right:5px;"><?php echo $pb_p_02?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('p_34','<?php echo $pb_p_34?>');" id="gameSt_p_34" class="btn btn-pick-right">
									<span style="color:yellow; padding-left:5px;"><?php echo $pb_p_34?></span>
									<span style="color:white; float:right; padding-right:5px;">파워볼 - B [3-4]</span>
								</button>
							</li>
						</div>
						<div style="display: flex;">
							<li>
								<button onclick="gameSelect('p_56','<?php echo $pb_p_56?>');" id="gameSt_p_56" class="btn btn-pick-left">
									<span style="color:white; padding-left:5px;">파워볼 - C [5-6]</span>
									<span style="color:yellow; float:right; padding-right:5px;"><?php echo $pb_p_56?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('p_79','<?php echo $pb_p_79?>');" id="gameSt_p_79" class="btn btn-pick-right">
									<span style="color:yellow; padding-left:5px;"><?php echo $pb_p_79?></span>
									<span style="color:white; float:right; padding-right:5px;">파워볼 - D [7-9]</span>
								</button>
							</li>
						</div>
					</div>
				</div>
				<div class="powerball_6th">
					<div>
						<h4>6게임 : 파워볼 언오버</h4>
						<div style="display: flex;">
							<li>
								<button onclick="gameSelect('p_o-un','<?php echo $pb_p_o_un?>');" id="gameSt_p_o-un" class="btn btn-pick-left">
									<span style="color:white; padding-left:5px;">파워볼 - 홀 - 4.5 언더</span>
									<span style="color:yellow; float:right; padding-right:5px;"><i class="fas fa-arrow-down" style="color:#45a9ff; font-weight: bold;"></i> <?php echo $pb_p_o_un?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('p_o-over','<?php echo $pb_p_o_ov?>');" id="gameSt_p_o-over" class="btn btn-pick-right">
									<span style="color:yellow; padding-left:5px;"><i class="fas fa-arrow-up" style="color:#ff4545; font-weight: bold;"></i> <?php echo $pb_p_o_ov?></span>
									<span style="color:white; float:right; padding-right:5px;">파워볼 - 홀 - 4.5 오버</span>
								</button>
							</li>
						</div>
						<div style="display: flex;">
							<li>
								<button onclick="gameSelect('p_e-un','<?php echo $pb_p_e_un?>');" id="gameSt_p_e-un" class="btn btn-pick-left">
									<span style="color:white; padding-left:5px;">파워볼 - 짝 - 4.5 언더</span>
									<span style="color:yellow; float:right; padding-right:5px;"><i class="fas fa-arrow-down" style="color:#45a9ff; font-weight: bold;"></i> <?php echo $pb_p_e_un?></span>
								</button>
							</li>
							<li>
								<button onclick="gameSelect('p_e-over','<?php echo $pb_p_e_ov?>');" id="gameSt_p_e-over" class="btn btn-pick-right">
									<span style="color:yellow; padding-left:5px;"><i class="fas fa-arrow-up" style="color:#ff4545; font-weight: bold;"></i> <?php echo $pb_p_e_ov?></span>
									<span style="color:white; float:right; padding-right:5px;">파워볼 - 짝 - 4.5 오버</span>
								</button>
							</li>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="powerball_cart">
			<div class="cart_info">
				<ul>
					<li>
						<div>
							<span>게임분류</span>
							<strong>파워볼</strong>
						</div>
					</li>
					<li id="selBet">
						<div style="height: 42px;">
							<span>게임선택</span>
							<strong id="stGameTitle" id="stGameIcon"></strong>
						</div>
					</li>
					<li>
						<div>
							<span>배당률</span>
							<strong id="stGameRate" style="color:#ffeaad;">0.00</strong>
						</div>
					</li>
				</ul>
			</div>

			<div class="cart_pay">
				<h4 class="hidden">베팅금액선택</h4>
				<div class="bet_money"><label for="betExp2">베팅 금액</label><input type="text" id="btMoney" name="btMoney" value="0" readonly onFocus="blur();" /></div>
				<div class="bet_money i_blue"><label for="betExp3">적중 금액</label><input type="text" id="hitMoney" name="hitMoney" value="0" readonly onFocus="blur();" /></div>
				<div class="bet_btn_inner">
					<ul>
						<li>
							<input type="button" value="5,000" onclick="moneyPlus('5000');">
						</li>
						<li>
							<input type="button" value="10,000" onclick="moneyPlus('10000');">
						</li>
						<li>
							<input type="button" value="50,000" onclick="moneyPlus('50000');">
						</li>
						<li>
							<input type="button" value="100,000" onclick="moneyPlus('100000');">
						</li>
						<li>
							<input type="button" value="500,000" onclick="moneyPlus('500000');">
						</li>
						<li>
							<input type="button" value="1,000,000" onclick="moneyPlus('1000000');">
						</li>
					</ul>
				</div>
				<div class="bet_money_free">
					<label for="betExp4">직접입력</label>
					<input type="text" id="mulMoney" name="mulMoney" value="0" onkeyUp="moneyPlusManual(this.value);" />
				</div>
				<div class="bet_btn_inner">
					<ul>
						<li>
							<input type="button" class="i_blue" value="잔돈" onclick="moneyPlus('ex');">
						</li>
						<li>
							<input type="button" class="i_brw" value="올인" onclick="moneyPlus('all');">
						</li>
						<li>
							<input type="button" class="i_gray" value="초기화" onclick="moneyPlus('reset');">
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="btn_area">
			<div id="bettingShadow" class="bet_disable">지금은 베팅을 하실 수 없습니다.</div>
			<ul>
				<li><input type="button" value="베팅하기" class="btn_bet02" onclick="gameBetting();"></li>
				<!--li><a href="#power_result" class="call-modal btn_stats">지난 회차결과</a></li-->
				<li style="width:99%;"><a href="/race/betting_list" class="btn_all_bet">전체 베팅내역</a></li>

			</ul>		
		</div>
	</div>

	<div class="modal_style01" id="power_result" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
		<div class="powerball_result_list_inner">
			<table>
				<thead>
					<tr>
						<th scope="col">회차</th>
						<th scope="col">당첨번호결과</th>
						<th scope="col">숫자 합</th>
						<th scope="col">숫자 홀/짝</th>
					</tr>
					<tr>
						<th scope="col">파워볼</th>
						<th scope="col">파워볼 홀/짝</th>
						<th scope="col">대/중/소</th>
						<th scope="col">파워볼 구간</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="num">579127</td>
						<td class="result">03, 21, 12, 09, 20</td>
						<td class="total">65</td>
						<td class="oddeven">홀</td>
					</tr>
					<tr>
						<td class="pb">6</td>
						<td class="pb_odev">짝</td>
						<td class="djs">중(65~80)</td>
						<td class="pb_section">C(5~6)</td>
					</tr>
					<tr>
						<td class="num">579126</td>
						<td class="result">20, 14, 12, 15, 05</td>
						<td class="total">66</td>
						<td class="oddeven">짝</td>
					</tr>
					<tr>
						<td class="pb">0</td>
						<td class="pb_odev">짝</td>
						<td class="djs">중(65~80)</td>
						<td class="pb_section">A(0~2)</td>
					</tr>
					<tr>
						<td class="num">579125</td>
						<td class="result">01, 22, 19, 17, 16</td>
						<td class="total">75</td>
						<td class="oddeven">홀</td>
					</tr>
					<tr>
						<td class="pb">6</td>
						<td class="pb_odev">짝</td>
						<td class="djs">중(65~80)</td>
						<td class="pb_section">C(5~6)</td>
					</tr>
					<tr>
						<td class="num">579124</td>
						<td class="result">01, 10, 02, 03, 13</td>
						<td class="total">29</td>
						<td class="oddeven">홀</td>
					</tr>
					<tr>
						<td class="pb">0</td>
						<td class="pb_odev">짝</td>
						<td class="djs">소(15~64)</td>
						<td class="pb_section">A(0~2)</td>
					</tr>
					<tr>
						<td class="num">579123</td>
						<td class="result">23, 20, 01, 09, 03</td>
						<td class="total">56</td>
						<td class="oddeven">짝</td>
					</tr>
					<tr>
						<td class="pb">7</td>
						<td class="pb_odev">홀</td>
						<td class="djs">소(15~64)</td>
						<td class="pb_section">D(7~9)</td>
					</tr>
				</tbody>
			</table>
		</div>
		<a href="#!" class="modal-close" data-dismiss="modal">close</a>
		<a href="#!" class="lcl img_cmn">close</a>
	</div>     

	<div class="powerball_notice">
		<h4>알아두세요!</h4>
		<ul>
			<li>본 서비스는 나눔로또의 파워볼 결과를 기준으로 정산처리 하며, 파워볼의 결과와 무관합니다.</li>
			<li>한번 베팅한 파워볼게임은 베팅취소 및 베팅수정이 불가합니다.</li>
			<li>베팅은 본인의 보유 예치금 기준을 베팅가능하며, 추첨결과에 다라 명시된 배당률 기준으로 적립해드립니다.</li>
			<li>부적절한 방법(ID도용, 불법프로그램, 시스템 베팅 등)으로 베팅을 할 경우 무효쳐리되며, 전액몰수/강제탈퇴 등 불이익을 받을 수 있습니다.</li>
			<li>파워볼게임의 모든 배당률은 당사의 운영정책에 따라 언제든지 상/하향 조정될 수 있습니다.</li>
			<li>본 서비스는 당사의 운영정책에 따라 조기 종료되거나 이용이 제한될 수 있습니다.</li>
		</ul>
	</div>
</div>

<script type="text/javascript" src="/scripts/bet/powerball.js?v=<?=time();?>"></script>
<script>
	var VarMoney = '<?php echo $TPL_VAR["cash"]?>';						//-> 보유머니
	var VarMinBet = '<?php echo $TPL_VAR["betMinMoney"]?>';		//-> 최소배팅머니
	var VarMaxBet = '<?php echo $TPL_VAR["betMaxMoney"]?>';		//-> 최고배팅머니
	var VarMaxAmount = '<?php echo $TPL_VAR["maxBonus"]?>';		//-> 최대당첨금	

	$(document).ready(function() {	
		//-> 타이머 시작
		getServerTime();

		//-> 파워볼 결과 표시
		powerballResult(1);
	});

	function powerballResult(autoFlag) {
		$.ajaxSetup({async:false});
		$.post("/powerball_result_graph", null, function(result) {
			var obj = JSON.parse(result);

			if ( obj.length > 0 ) $("#resultTable tr").remove();
			for( i = 0 ; i < obj.length ; i++ ) {

				nb_list = obj[i].nb_list.replace(/,/gi,", ");

				if ( obj[i].nb_odd_even == "odd" ) n_odd_even = "홀";
				else n_odd_even = "짝";

				if ( obj[i].pb_odd_even == "odd" ) p_odd_even = "홀";
				else p_odd_even = "짝";

				html = "<tr>" +
									"<td>"+obj[i].th+"</td>" +
									"<td>"+nb_list+"</td>" +
									"<td>"+obj[i].nb_list_sum+"</td>" +
									"<td>"+n_odd_even+"</td>" +
									"<td>"+obj[i].pb+"</td>" +
									"<td>"+p_odd_even+"</td>" +
									"<td>"+obj[i].nb_list_area+"</td>" +
									"<td>"+obj[i].pb_area+"</td>" +
							"</tr>";

				$("#resultTable").append(html);

				if ( i == 0 ) {
					$("#firstTh").html(obj[i].th);
					var ballList = obj[i].nb_list.split(',');
					$("#ballList_1").html(Number(ballList[0]) + 0);
					$("#ballList_2").html(Number(ballList[1]) + 0);
					$("#ballList_3").html(Number(ballList[2]) + 0);
					$("#ballList_4").html(Number(ballList[3]) + 0);
					$("#ballList_5").html(Number(ballList[4]) + 0);
					$("#ballList_p").html(obj[i].pb);
				}
			}			
		});

		var prv_result_time = Number(powerStartTime) + (gameTh * (300 * 1000));
		var prv_result_date = new Date(Number(prv_result_time));
		var prv_result = prv_result_date.getFullYear() + "-" + addZero(prv_result_date.getMonth() + 1) + "-" + addZero(prv_result_date.getDate()) + " " +
										addZero(prv_result_date.getHours()) + ":" + addZero(prv_result_date.getMinutes()) + ":" + addZero(prv_result_date.getSeconds());
		$("#result_date").html(prv_result);

		if ( autoFlag == 1 ) {
			// 업데이트 주기(10초)
			setTimeout(function(){
				powerballResult(1);
			},10000);
		} else {
			alert("새로고침 되었습니다.\n\n(최근 추첨 결과는 10초마다 자동 새로고침 됩니다.)");
		}
	}
</script>