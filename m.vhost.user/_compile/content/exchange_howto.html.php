<?php /* Template_ 2.2.3 2013/03/20 01:06:02 D:\www\vhost.user_f\_template\content\exchange_howto.html */?>
<div id="wrap_body">
		<h2 class="blind">내용</h2>
		<div id="subvisual" class="subvisual_money">
			<h3><img src="/img2/member/title_withdraw.jpg"></h3>
		</div>
		<div id="body">

			<div id="subtab">
				<ul>
					<li class="withdraw"><a href="/member/exchange"><span>머니환전요청</span></a></li>
					<li class="wiHistory"><a href="/member/exchangelist"><span>머니환전내역</span></a></li>
					<li class="withdrawinfo_on"><a href="/member/exchange_howto"><span>환전방법</span></a></li>
				</ul>
			</div>

			<div id="wrap_search">						
				<div id="nowMoney"><p><img src="/img2/member/money_title.gif" title="보유캐쉬"><span><?php echo number_format($TPL_VAR["cash"])?></span></p></div>
			</div>

			<div id="money_info">
				<h4><img src="/img2/member/icon_charge.jpg"></h4>
				<dl>
					<dt>01. 환전방법</dt>
					<dd>1) 24시간 자유롭게 입,출금이 가능하며 최장 3~5분 소요됩니다.(단, 23:00부터 24:30분까지는 타행이체불가합니다.)</dd>
					<dd>2) 10분이상 입금이 지연될 시 회원님 계좌정보를 잘못 기입한 경우가 많습니다. 그럴경우 상단 메뉴 고객센터로 계좌정보를 정확히 보내주세요.</dd>
					<dd>3) 다른 계좌로 환전하시려면 고객센터로 문의주세요. </dd>
				</dl>
			</div>
		</div>
<?php $this->print_("right_normal",$TPL_SCP,1);?>

	</div>