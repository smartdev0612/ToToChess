<?php /* Template_ 2.2.3 2014/10/20 15:44:54 D:\www_one-23.com\m.vhost.user\_template\right\right_live.html */?>
<script>
	function moneyFormat(num)
	{
		num = new String(num)
		num = num.replace(/,/gi,"")
		return _moneyFormat(num)
	}
		
	function _moneyFormat(num)
	{
		fl=""
		if(isNaN(num)) { alert("문자는 사용할 수 없습니다.");return 0}
		if(num==0) return num
			
		if(num<0)
		{
			num=num*(-1)
			fl="-"
		}
		else
		{
			num=num*1 //처음 입력값이 0부터 시작할때 이것을 제거한다.
		}
		num = new String(num)
		temp=""
		co=3
		num_len=num.length
		while (num_len>0)
		{
			num_len=num_len-co
			if(num_len<0){co=num_len+co;num_len=0}
			temp=","+num.substr(num_len,co)+temp
		}
		return fl+temp.substr(1)
	}
		
	function onMoneyChange(amount)
	{
		var rs = moneyFormat(amount);
		calculate_money();
		return rs;
	}
	
</script>


<div id="subbody" class="livebg">

	<div class="wrap_betslip" id="wrap_betslip">

		<!-- 우측 움직이는 레이어 -->
		<div class="wrap">
			<div class="title">
				<h3><span>베팅슬립</span></h3>
				<p class="fixed"><input type="checkbox" id="animate" onclick="javascript:initMoving();"><img src="/img/betslip_bg_lock.gif"></p>
			</div>
			
			<form name="frm_betting_slip" action="/LiveGame/live_betting_process" method="post">
				<input type="hidden" name="event_id" value="<?php echo $TPL_VAR["event_id"]?>">
				<input type="hidden" name="template">
				<input type="hidden" name="odd">
				<input type="hidden" name="position">

				<table id="tb_list" cellspacing="1">
					<tbody>
					</tbody>
				</table>
				
				<div class="betinfo">
					<p><label>보유금액</label><span><?php echo number_format($TPL_VAR["cash"],0)?>원</span></p>
					<p><label>예상배당률</label><span id="sp_bet">0.00</span></p>
					<p class="money">
						<label>베팅금액</label>
						<span>
							<input type="text" name="betting_money" class="betmoney" value="5,000" onkeyUp="javascript:this.value=onMoneyChange(this.value);" onmouseover="this.focus()">
							<a href="javascript:void();" onclick="onAllinClicked();"><img src="/img/betslip_btn_allbet.gif"></a>
						</span>
					</p>
					<p class="winmoney"><label>예상배당금</label><span id="sp_total">0</span></p>
				</div>
			</form>

			<dl class="betguide">
				<dt>베팅최소금액 :</dt><dd><?php echo number_format($TPL_VAR["min_betting_money"])?></dd>
				<dt>베팅최대금액 :</dt><dd><?php echo number_format($TPL_VAR["max_betting_money"])?></dd>
				<dt>적중최대금액 :</dt><dd><?php echo number_format($TPL_VAR["max_prize_money"])?></dd>
			</dl>

			<p class="btn">
				<a href="javascript:on_betting()"><img src="/img/betslip_btn_betting.gif" title="베팅하기"></a>
				<img src="/img/betslip_btn_cancel.gif" title="취소" class="end" onclick="clear_betting_slip()">
			</p>
		</div>

		<ul id="wrap_banner">
			<li><img src="/img/cs.png"></li>
			<li><a href="javascript:menu0312();"><img src="/img/banner_casino.jpg"></a></li>
		</ul>
		
	</div>
	<script type="text/javascript">initMoving(document.getElementById("wrap_betslip"), 0, 0, 0);</script>
	<!-- 우측 움직이는 레이어 끝 -->

</div>