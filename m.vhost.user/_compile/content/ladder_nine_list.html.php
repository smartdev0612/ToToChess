<div class="ladder_wrap" style="background: url(/img/m/bg_ladder.png) repeat">
	<div class="ladder_top" style="height:335px;left:50%;margin-left:-150px;">
		<div class="ladder_area" style="width:830px; top:-265px !important; left:-87px; ">
			<iframe id="game_frame" src="https://gamenlives.com/9spiel.html" frameborder="0" border="0" scrolling="no" style="width:100%; height:1199px;"></iframe>
		</div>
	</div>

	<div class="ladder_cnt">
		<input type="hidden" id="game_hour" name="game_hour" value="21">
		<!-- 게임선택 -->
				<div class="ladder_choice">
			<div class="game_info">
				<span id="viewSysDate"></span> <span style="color:#ffce25;"><b>[<span id="viewGameTh" style="color:#ffce25;"></span>회차]</b></span>
				<em><span id="date_hh"><span id="viewSysTime"></span></span></em>
				<b><span id="viewGameTime" style="color: #ffea00;"></span></b>
			</div>
			<div class="ladder_1st">
				<h4><span>1게임</span><strong>P/B</strong></h4>
				<div>
					<ul>
						<li><input type="button" value="1.95" class="b_player" onclick="gameSelect('player','1.95');" id="gameSt_player"></li>
						<li><input type="button" value="1.95" class="b_banker" onclick="gameSelect('banker','1.95');" id="gameSt_banker"></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- 게임선택 -->
		
		<!-- //게임선택 -->
		<!-- 베팅카트 -->
		<div class="ladder_cart">
			<div class="cart_info">
				<ul>
					<li>
						<div>
							<span>게임분류</span>
							<strong>나인</strong>
						</div>
					</li>
					<li id="selBet">
						<div>
							<span>게임선택</span>
							<strong>
								<span class="tx" id="stGameIcon" style="valign:center;"></span>
							</strong>
						</div>
					</li>
					<li id="betRate">
						<div>
							<span>배당률</span>
							<em><span id="stGameRate" style="color:#ffeaad;">0.00</span></em>
						</div>
					</li>
				</ul>
			</div>
			<!-- 금액선택 -->
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
			<!-- //금액선택 -->
			</form>
		</div>

		<div class="btn_area">			
			<div id="bettingShadow" class="bet_disable">지금은 베팅을 하실 수 없습니다.</div>
			<ul>
				<li><input type="button" value="베팅하기" class="btn_bet02" onclick="gameBetting();"></li>

				<!--li><a href="#ladder_stats" class="call-modal btn_stats" onclick="load_chart()">회차별 홀/짝통계</a></li-->
				<li style="width:99%;"><a href="/race/betting_list" class="btn_all_bet">전체 베팅내역</a></li>

			</ul>
		</div>
		
		<div class="ladder_notice">
			<h4>알아두세요!</h4>
			<ul>
				<li>회차는 오전 0시 기준으로 회차가 초기화 됩니다.</li>
				<li>한번 베팅한 게임은 베팅취소 및 베팅수정이 불가합니다.</li>
				<li>베팅은 본인의 보유 예치금 기준으로 베팅 가능하며, 추첨결과에 따라 명시된 배당률 기준으로 적립해드립니다.</li>
				<li>부적절한 방법(ID도용, 불법프로그램, 시스템 베팅 등)으로 베팅을 할 경우 무효쳐리되며, 전액몰수/강제탈퇴 등 불이익을 받을 수 있습니다.</li>
				<li>게임의 모든 배당률은 당사의 운영정책에 따라 언제든지 상/하향 조정될 수 있습니다.</li>
				<li>본 서비스는 게임 결과를 기준으로 정산처리됩니다.</li>
				<li>본 서비스는 당사의 운영정책에 따라 조기 종료되거나 이용이 제한될 수 있습니다.</li>
			</ul>
		</div>
	</div>
</div>

<script type="text/javascript" src="/scripts/bet/nine.js?v=<?=time();?>"></script>
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