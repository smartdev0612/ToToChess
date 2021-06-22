<?php /* Template_ 2.2.3 2014/10/21 23:16:26 D:\www_one-23.com\m.vhost.user\_template\right\right.html */?>

<div id="subbody" style="display:none;">

	<div id="wrap_betslip">

		<div class="title">
			<h3><span>베팅슬립</span></h3>
			<p class="fixed">
				<span id="betting_slip_context" class="hidden_view">
					<a onclick="toggleSlip();">배팅슬립 접기</a>
				</span>
			</p>
		</div>
		<div id="hidden">
		<form name="betForm" action="/race/bettingProcess" method="post" onsubmit="return false">
			<input type="hidden" value="betting" name="mode"> 
			<input type="hidden" name=strgametype> 
			<input type="hidden" name="gametype" value=<?=$bettype?>>
			<input type="hidden" name="game_type" value="<?php echo $TPL_VAR["game_type"]?>">
			<input type="hidden" name="special_type" value="<?php echo $TPL_VAR["special_type"]?>">
			<input type="hidden" name="result_rate"> 
			<textarea style="display:none" name=betcontent></textarea>
			
			<!--<input type="text" name="message">-->

			<table id="tb_list" cellspacing="0" summary="배팅슬립 배팅목록" style="display:visible">
				<tbody>
				</tbody>
			</table>
			
			<div class="betinfo">
				<p><label>보유금액</label><span><?php echo number_format($TPL_VAR["cash"],0)?>원</span></p>
				<p><label>배당률</label><span id="sp_bet">0.00</span></p>
				<p class="money">
					<label>베팅금액</label>
					<span>
						<input type="text" name="betMoney" id="betMoney" class="betmoney" value="5,000" onkeyUp="javascript:this.value=onMoneyChange(this.value);" onmouseover="this.focus()">
						<a href="javascript:void();" onclick="onAllinClicked();"><img src="/img/betslip_btn_allbet.gif"></a>
					</span>
				</p>
				<p class="winmoney"><label>예상배당금</label><span id="sp_total">0</span></p>
			</div>
		</form>

		<dl class="betguide">
			<dt>베팅최소금액 :</dt><dd><?php echo number_format($TPL_VAR["betMinMoney"])?></dd>
			<dt>베팅최대금액 :</dt><dd><?php echo number_format($TPL_VAR["betMaxMoney"])?></dd>
			<dt>aa적중최대금액 :</dt><dd><?php echo number_format($TPL_VAR["maxBonus"])?></dd>
		</dl>

		<p class="btn">
			<a href="javascript:betting('betting')"><img src="/img/betslip_btn_betting.gif" title="베팅하기"></a>
			<a href="javascript:bet_clear()"><img src="/img/betslip_btn_cancel.gif" title="취소" class="end"></a>
		</p>
		
		</div>

	</div>

</div>