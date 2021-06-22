<div id="contents_right">
	<div id="betting_cart">
		<form name="frm_betting_slip" action="/LiveGame/live_betting_process" method="post">
		<input type="hidden" name="event_id" value="<?php echo $TPL_VAR["event_id"]?>">
		<input type="hidden" name="template">
		<input type="hidden" name="odd">
		<input type="hidden" name="position">
<!--
		<div class="betting_cart_head">
			<img src="/images/cart_head.gif" alt=""/>
		</div>
-->
		<!--// betting_cart_head 종료-->
		<div class="betting_cart_menu">
			<ul>
				<li><img src="/images/cart_head_1.png" alt=""/></li>
				<li><img src="/images/cart_head_2.png" alt="카트정지" style="cursor:pointer;" onClick="betSlipStop(this);" /></li>
				<li><a href="javascript:location.reload();"><img src="/images/cart_head_3.png" alt="전체삭제" /></a></li>
			</ul>
		</div><!--// betting_cart_menu 종료-->

		<div class="betting_cart_center">
			<ul>
				<li class="betting_cart_text_1">보유금액 :</li>
				<li class="betting_cart_text_2"><span class="member_inmoney"><?php echo number_format($TPL_VAR["cash"],0)?></span></li>
				<li class="betting_cart_text_8">원</li>
				<li class="betting_cart_text_3">베팅상한금액 :</li>
				<li class="betting_cart_text_4"><?php echo number_format($TPL_VAR["betMaxMoney"])?></li>
				<li class="betting_cart_text_8">원</li>
				<li class="betting_cart_text_5">예상배당율 :</li>
				<li class="betting_cart_text_6"><span id="sp_bet">0.00</span></li>
				<li class="betting_cart_text_8">배</li>
				<li class="betting_cart_text_7">베팅금액 :</li>
				<li class="betting_cart_money"><input type="text" name="betting_money" id="betting_money" value="<?php echo number_format($TPL_VAR["min_betting_money"])?>" onkeyUp="javascript:this.value=onMoneyChangeLive(this.value);" onmouseover="this.focus()" style="text-align: right; color: #3a4c64; width: 90px;" ></li>
				<li class="betting_cart_text_9">원</li>
			</ul>
		</div> <!--// betting_cart_center 종료-->

		<div class="betting_cart_bet">
			<ul>
				<li><img src="/images/cart_money_5000.png" style="cursor:pointer;" onclick="liveBettingMoneyPick('5000');" alt="5,000" /></li>
				<li><img src="/images/cart_money_10000.png" style="cursor:pointer;" onclick="liveBettingMoneyPick('10000');" alt="10,000" /></li>
				<li><img src="/images/cart_money_30000.png" style="cursor:pointer;" onclick="liveBettingMoneyPick('30000');" alt="30,000" /></li>
				<li><img src="/images/cart_money_50000.png" style="cursor:pointer;" onclick="liveBettingMoneyPick('50000');" alt="50,000" /></li>
				<li><img src="/images/cart_money_100000.png" style="cursor:pointer;" onclick="liveBettingMoneyPick('100000');" alt="100,000" /></li>
				<li><img src="/images/cart_money_max.png" style="cursor:pointer;" onclick="liveMaxBetting();" alt="MAX" /></li>
			</ul>
		</div> <!--// betting_cart_money 종료-->

		<div class="betting_crat_bet_1">
			<ul>
				<li class="betting_cart_text_1">예상당첨금 :</li>
				<li class="betting_cart_text_2"><span id="sp_total">0</span></li>
				<li class="betting_cart_text_8">원</li>
			</ul>
		</div><!--// betting_crat_bet_1 종료-->

		<div class="betting_cart_button">
			<a href="javascript:on_betting();"><img src="/images/cart_betting.png" alt=""/></a>
		</div> <!--// betting_cart_button 종료-->

		<table id="tb_list" cellspacing="0" summary="배팅슬립 배팅목록" style="display:visible">
			<tbody></tbody>
		</table>

		<!-- <div class="banner_box_1">
			<ul>
				<li class="banner_9"><img src="/images/kakao.png" align="absmiddle"></li>
			</ul>
		</div> --> <!--//banner_box_1 종료-->
		</form>
	</div> <!--// betting_cart 종료-->
</div> <!--// contents_right 종료-->

<script type="text/javascript">initMoving();</script>

<!--
<dt>베팅최소금액 :</dt><dd><?php echo number_format($TPL_VAR["betMinMoney"])?></dd>
<dt>베팅최대금액 :</dt><dd><?php echo number_format($TPL_VAR["betMaxMoney"])?></dd>
<dt>적중최대금액 :</dt><dd><?php echo number_format($TPL_VAR["maxBonus"])?></dd>
-->