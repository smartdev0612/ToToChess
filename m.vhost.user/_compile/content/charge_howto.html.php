<?php /* Template_ 2.2.3 2013/03/15 17:39:17 D:\www\vhost.user\_template\content\charge_howto.html */?>
<div id="wrap_body">
		<h2 class="blind">내용</h2>
		<div id="subvisual" class="subvisual_money">
			<h3><img src="/img2/member/title_charge.png"></h3>
		</div>
		<div id="body">

			<div id="subtab">
				<ul>
					<li class="deposit"><a href="/member/charge"><span>머니충전요청</span></a></li>
					<li class="deHistory"><a href="/member/chargelist"><span>머니충전내역</span></a></li>
					<li class="depositinfo_on"><a href="/member/charge_howto"><span>결제방법</span></a></li>
				</ul>
			</div>

			<div id="wrap_search">						
				<div id="nowMoney"><p><img src="/img2/member/money_title.gif" title="보유캐쉬"><span><?php echo number_format($TPL_VAR["cash"])?></span></p></div>
			</div>

			<div id="money_info">
				<h4><img src="/img2/member/icon_charge.jpg"></h4>
				<dl>
					<dt>01. 결제방법</dt>
					<dd>1) 입금하실 계좌에 PC 뱅킹, 폰뱅킹, 무통장 입금, ATM등의 방법으로 금액 중 하나를 선택하여 입금합니다.</dd>
					<dd>2) 입금하신 금액을 입력하세요.</dd>
					<dd>3) 입금자명에는 입금하신 분의 성함을 넣어주세요.</dd>
					<dd>4) 확인버튼을 클릭하시면 충전신청이 완료됩니다.</dd>
					<dd>5) 입금액은 10,000원 이상입니다.</dd>
				</dl>
				<dl>
					<dt>02. 입금하실 계좌</dt>
					<dd>충전금액과 입금자명(가입하신 이름과 동일한 이름)을 입력하시고 충전신청을 하시면 쪽지로 입금계좌가 발송 됩니다.</dd>
				</dl>
				<dl>
					<dt>03. 주의사항</dt>
					<dd>1) 입금을 완료하시고 1분이 지나도 처리가 않된다면 고객센터로 연락주세요.</dd>
					<dd>2) 입금자명/입금액/충전신청금액이 정확히 일치해야 바로 처리됩니다.</dd>
					<dd>3) 충전은 동시에 한번밖에 할 수 없습니다. </dd>
				</dl>
			</div>
		</div>
<?php $this->print_("right_normal",$TPL_SCP,1);?>

	</div>