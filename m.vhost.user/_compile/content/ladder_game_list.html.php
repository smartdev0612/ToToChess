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

$sadari_oe = $TPL_VAR["mini_odds"]["sadari_oe"];
$sadari_lr = $TPL_VAR["mini_odds"]["sadari_lr"];
$sadari_line = $TPL_VAR["mini_odds"]["sadari_line"];
$sadari_oeline_lr = $TPL_VAR["mini_odds"]["sadari_oeline_lr"];
?>

<script>
    var limit_time = <?php echo $TPL_VAR["mini_config"]["sadari_limit"]?>;
    <?php if($TPL_VAR["mini_config"]["sadari"] == 0) {?>
        alert('사다리 미니게임은 현재 점검중입니다.\n이용에 불편을 드려 죄송합니다.');
        document.location.href='/';
    <?php } ?>
</script>

<style>
    .bet_disable_3game_mobile{position:absolute;top: 565px;bottom: 47px;left: 0;right:0;font-size:30px;text-align:center;color:white;    background: rgba(0,0,0,0.7);}
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
<div class="ladder_wrap">
	<div class="ladder_top">		
<?php
	if ( $TPL_VAR["named_security_flag"] == 1 ) {
		echo "<img src=\"/images/named_security.jpg\" width=\"100%\" style=\"padding-top:1%;\">";
	} else {
		echo "<div class=\"ladder_area\"><iframe id=\"game_frame\" src=\"http://named.com/game/ladder/v2_index.php\" frameborder=\"0\" border=\"0\" scrolling=\"no\"></iframe></div>";
	}
?>		
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
				<h4><span>1게임</span><strong>홀/짝</strong></h4>
				<div>
					<ul>
						<li><input type="button" value="<?php echo $sadari_oe?>" class="b_odd" onclick="gameSelect('odd','<?php echo $sadari_oe?>');" id="gameSt_odd"></li>
						<li><input type="button" value=<?php echo $sadari_oe?>" class="b_even" onclick="gameSelect('even','<?php echo $sadari_oe?>');" id="gameSt_even"></li>
					</ul>
				</div>
			</div>
			<div class="ladder_2nd">
				<h4><span>2게임</span><strong>출발줄 줄갯수</strong></h4>
				<div>
					<ul>
						<li><input type="button" value="<?php echo $sadari_lr?>" class="b_lft" onclick="gameSelect('left','<?php echo $sadari_lr?>');" id="gameSt_left"></li>
						<li><input type="button" value="<?php echo $sadari_lr?>" class="b_rgt" onclick="gameSelect('right','<?php echo $sadari_lr?>');" id="gameSt_right"></li>
						<li><input type="button" value="<?php echo $sadari_line?>" class="b_3_odd" onclick="gameSelect('3line','<?php echo $sadari_line?>');" id="gameSt_3line"></li>
						<li><input type="button" value="<?php echo $sadari_line?>" class="b_4_even" onclick="gameSelect('4line','<?php echo $sadari_line?>');" id="gameSt_4line"></li>
					</ul>
				</div>
			</div>
			<div class="ladder_3rd">
				<h4 class="brnone"><span>3게임</span><strong>좌우 출발 3/4줄</strong></h4>
				<div class="brnone">
					<ul>
						<li><input type="button" value="<?php echo $sadari_oeline_lr?>" class="b_lft_3_oven" onclick="gameSelect('even3line_left','<?php echo $sadari__oeline_lr?>');" id="gameSt_even3line_left"></li>
						<li><input type="button" value="<?php echo $sadari_oeline_lr?>" class="b_lft_4_odd" onclick="gameSelect('odd4line_left','<?php echo $sadari__oeline_lr?>');" id="gameSt_odd4line_left"></li>
						<li><input type="button" value="<?php echo $sadari_oeline_lr?>" class="b_rgt_3_odd" onclick="gameSelect('odd3line_right','<?php echo $sadari__oeline_lr?>');" id="gameSt_odd3line_right"></li>
						<li><input type="button" value="<?php echo $sadari_oeline_lr?>" class="b_rgt_4_even" onclick="gameSelect('even4line_right','<?php echo $sadari__oeline_lr?>');" id="gameSt_even4line_right"></li>

					</ul>
                    <div class="bet_disable_3game_mobile"></div>
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
							<strong>사다리</strong>
						</div>
					</li>
					<li id="selBet">
						<div>
							<span>게임선택</span>
							<strong>
								<span class="tx" id="stGameIcon"></span>
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
				<li>사다리게임 회차는 오전 0시 기준으로 회차가 초기화 됩니다.</li>
				<li>한번 베팅한 사다리게임은 베팅취소 및 베팅수정이 불가합니다.</li>
				<li>베팅은 본인의 보유 예치금 기준으로 베팅 가능하며, 추첨결과에 따라 명시된 배당률 기준으로 적립해드립니다.</li>
				<li>부적절한 방법(ID도용, 불법프로그램, 시스템 베팅 등)으로 베팅을 할 경우 무효쳐리되며, 전액몰수/강제탈퇴 등 불이익을 받을 수 있습니다.</li>
				<li>사다리 게임의 모든 배당률은 당사의 운영정책에 따라 언제든지 상/하향 조정될 수 있습니다.</li>
				<li>본 서비스는 네임드 사다리게임 결과를 기준으로 정산처리됩니다.</li>
				<li>본 서비스는 당사의 운영정책에 따라 조기 종료되거나 이용이 제한될 수 있습니다.</li>
			</ul>
		</div>
	</div>
</div>

<script type="text/javascript" src="/scripts/bet/sadari.js?v=<?=time();?>"></script>
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