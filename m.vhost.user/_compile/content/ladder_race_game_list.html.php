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
?>
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
<div class="snail_wrap">
	<div class="snail_top">
<?php
	if ( $TPL_VAR["named_security_flag"] == 1 ) {
		echo "<img src=\"/images/named_security.jpg\" width=\"100%\" style=\"padding-top:1%;\">";
	} else {
		echo "<div class=\"snail_area\"><iframe id=\"game_frame\" src=\"http://named.com/games/racing/view.php\" frameborder=\"0\" border=\"0\" scrolling=\"no\"></iframe></div>";
	}
?>
	</div>

	<div class="snail_cnt">
		<!-- 게임선택 -->
		<div class="snail_choice">
			<div class="game_info">
				<span id="viewSysDate"></span> <span style="color:#ffce25;"><b>[<span id="viewGameTh" style="color:#ffce25;"></span>회차]</b></span>
				<em><span id="date_hh"><span id="viewSysTime"></span></span></em>
				<b><span id="viewGameTime" style="color: #ffea00;"></span></b>
			</div>

			<div class="snail_choice_inner">
				<div class="snail_1st">
					<dl>
						<dt>
							<h4><em>1게임</em><strong>1등 달팽이</strong><span>1등 달팽이 맞추기</span></h4>
							<div class="per"><span>2.80</span></div>
						</dt>
						<dd>
							<ul>
								<li><input type="button" class="btn_ne" value="네" onclick="gameSelect('1w-n','2.80');" id="gameSt_1w-n"></li>
								<li><input type="button" class="btn_im" value="임" onclick="gameSelect('1w-e','2.80');" id="gameSt_1w-e"></li>
								<li><input type="button" class="btn_du" value="드" onclick="gameSelect('1w-d','2.80');" id="gameSt_1w-d"></li>
							</ul>
						</dd>
					</dl>
				</div>
				<div class="snail_2nd">
				<dl>
					<dt><h4><em>2게임</em><strong>삼치기</strong><span>1등:적중 2등:적특 3등:미적중</span></h4><div class="per"><span>1.90</span></div></dt>
					<dd>
						<ul>
							<li><input type="button" class="btn_ne" value="네" onclick="gameSelect('1w2d3l-n','1.90');" id="gameSt_1w2d3l-n"></li>
							<li><input type="button" class="btn_im" value="임" onclick="gameSelect('1w2d3l-e','1.90');" id="gameSt_1w2d3l-e"></li>
							<li><input type="button" class="btn_du" value="드" onclick="gameSelect('1w2d3l-d','1.90');" id="gameSt_1w2d3l-d"></li>
						</ul>
					</dd>
				</dl>
			</div>
			<div class="snail_3rd">
				<dl>
					<dt>
						<h4><em>3게임</em><strong>골등피하기</strong><span>3등만 아니면 적중</span></h4><div class="per"><span>1.27</span></div>
					</dt>
					<dd>
						<ul>
							<li><input type="button" class="btn_ne" value="네" onclick="gameSelect('1w2w3l-n','1.27');" id="gameSt_1w2w3l-n"></li>
							<li><input type="button" class="btn_im" value="임" onclick="gameSelect('1w2w3l-e','1.27');" id="gameSt_1w2w3l-e"></li>
							<li><input type="button" class="btn_du" value="드" onclick="gameSelect('1w2w3l-d','1.27');" id="gameSt_1w2w3l-d"></li>
						</ul>
					</dd>
				</dl>
			</div>
			<div class="snail_4th">
				<dl>
					<dt>
						<h4><em>4게임</em><strong>달팽이 순위</strong><span>달팽이 순위 1등, 2등, 3등을 맞추자</span></h4><div class="per"><span>5.55</span></div>
					</dt>
					<dd>
						<ul>
							<li><input type="button" class="btn_nid" value="네임드" onclick="gameSelect('ned','5.55');" id="gameSt_ned"></li>
							<li><input type="button" class="btn_ndi" value="네드임" onclick="gameSelect('nde','5.55');" id="gameSt_nde"></li>
							<li><input type="button" class="btn_ind" value="임네드" onclick="gameSelect('end','5.55');" id="gameSt_end"></li>
							<li><input type="button" class="btn_idn" value="임드네" onclick="gameSelect('edn','5.55');" id="gameSt_edn"></li>
							<li><input type="button" class="btn_dni" value="드네임" onclick="gameSelect('dne','5.55');" id="gameSt_dne"></li>
							<li><input type="button" class="btn_din" value="드임네" onclick="gameSelect('den','5.55');" id="gameSt_den"></li>
						</ul>
					</dd>
				</dl>
			</div>
		</div>
	</div>

	<!-- 베팅카트 -->
	<div class="snail_cart">
		<div class="cart_info">
			<ul>
				<li>
					<div>
						<span>게임분류</span>
						<strong>달팽이레이싱</strong>
					</div>
				</li>
				<li>
					<div>
						<span>게임선택</span>
						<strong id="stGameTitle" id="stGameIcon"></strong>
					</div>
				</li>
				<li>
					<div>
						<span>배당률</span>
						<em><span id="stGameRate" style="color:#ffeaad;">0.00</span></em>
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
				<li><a href="/race/betting_list" class="btn_all_bet">전체 베팅내역</a></li>
			</ul>
		</div>

		<div class="snail_notice">
			<h4>알아두세요</h4>
			<ul>
				<li>달팽이게임 회차는 오전 0시 기준으로 회차가 초기화됩니다.</li>
				<li>한번 베팅한 달팽이게임은 베팅취소 및 베팅수정이 불가합니다.</li>
				<li>베팅은 본인의 보유 예치금 기준을 베팅가능하며, 추첨결과에 다라 명시된 배당률 기준으로 적립해드립니다.</li>
				<li>부적절한 방법(ID도용, 불법프로그램, 시스템 베팅 등)으로 베팅을 할 경우 무효쳐리되며, 전액몰수/강제탈퇴 등 불이익을 받을 수 있습니다.</li>
				<li>달팽이게임의 모든 배당률은 당사의 운영정책에 따라 언제든지 상/하향 조정될 수 있습니다.</li>
				<li>본 서비스는 네임드 달팽이게임 결과를 기준으로 정산처리됩니다.</li>
				<li>본 서비스는 당사의 운영정책에 따라 조기 종료되거나 이용이 제한될 수 있습니다.</li>
			</ul>
		</div>
	</div>

<script type="text/javascript" src="/scripts/bet/race.js?v=<?=time();?>"></script>
<script>
	var VarMoney = '<?php echo $TPL_VAR["cash"]?>';						//-> 보유머니
	var VarMinBet = '<?php echo $TPL_VAR["betMinMoney"]?>';		//-> 최소배팅머니
	var VarMaxBet = '<?php echo $TPL_VAR["betMaxMoney"]?>';		//-> 최고배팅머니
	var VarMaxAmount = '<?php echo $TPL_VAR["maxBonus"]?>';		//-> 최대당첨금

	$(document).ready(function() {
		//-> 타이머 시작
		getServerTime();
	});
</script>