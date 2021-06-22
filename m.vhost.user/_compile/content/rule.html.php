<?php /* Template_ 2.2.3 2014/09/27 15:00:10 D:\www_one-23.com\m.vhost.user\_template\content\rule.html */?>
<script>
		function onTabClicked(tab_index)
		{
			document.location.href="/cs/rule?tab_index="+tab_index;		
		}
	</script>

<style>
	<!--
	#smenu .guide a
	{background-color:#126c50;border:1px solid #11644a;}
	#smenu .guide a span
	{color:#ffdf1b;text-decoration:underline}
	-->
</style>

	<div id="subvisual" class="subvisual_guide">
		<h3>
			<img src="/img/title_guide.gif">
		</h3>
	</div>

	<div id="subtab">
		<ul>
			<li <?php if($TPL_VAR["tab_index"]==0){?>class="on"<?php }?> ><a href="javascript:void();" onclick="onTabClicked(0)"><span>기본규정</span></a></li>
			<li <?php if($TPL_VAR["tab_index"]==1){?>class="on"<?php }?>><a href="javascript:void();" onclick="onTabClicked(1)"><span>베팅규정</span></a></li>
			<li <?php if($TPL_VAR["tab_index"]==2){?>class="on"<?php }?>><a href="javascript:void();" onclick="onTabClicked(2)"><span>적중특례</span></a></li>
			<li <?php if($TPL_VAR["tab_index"]==3){?>class="on"<?php }?>><a href="javascript:void();" onclick="onTabClicked(3)"><span>종목별규정</span></a></li>
			<li <?php if($TPL_VAR["tab_index"]==4){?>class="on"<?php }?>><a href="javascript:void();" onclick="onTabClicked(4)"><span>도움말</span></a></li>
		</ul>
	</div>

	<div id="gameguide">

		<div id="rule_basic" <?php if($TPL_VAR["tab_index"]!=0){?> style="display:none;"<?php }?>>

			<dl>
				<dt>게임 및 용어설명</dt>
				<dd>◇ 적중특례 : 경기취소, 연기, 배당오류 등의 다양한 이유로 게임이 정상적으로 처리되지 못하는 경우 해당경기에 대해 1배 처리하는 것을 말합니다.</dd>
				<dd>◇ 승무패경기 : 해당 경기의 승/무승부/패를 예상하여 배팅하는 방식이며 일부 경기의 경우 무승부를 적중특례 처리합니다.</dd>
				<dd>◇ 핸디캡경기 : 기량이 일정 이상 차이가 나는 경기에서 우월한 팀에게 일정한 기준의 불리한 점수를 미리 부여한 후 승/패를 예상하여 배팅하는 방식입니다.</dd>
				<dd>◇ 오버언더경기 : 해당 경기의 양팀 점수합이 기준점보다 높을지 낮을지를 예상하여 배팅하는 방식입니다.</dd>
			</dl>

			<dl>
				<dt>기본규정 및 숙지 사항</dt>
				<dd>(1)&nbsp;공지된 배당률은 사항에 따라 변동될 수 있습니다. 배당률은 경기결과에 영향을 미칠 수 있는 (주요 선수의 부상 및 결장)등 여러가지 예기치 못한 변수에 의해 변경되며, 배당률이 변경될 경우 변경시점 이전에 배팅은 변경이전 배당률로 그대로 적용 받게 됩니다.</dd>
				<dd>(2)&nbsp;특정조합에 배팅이 집중될 경우 배팅을 차단할 수 있습니다.</dd>
				<dd>(3)&nbsp;배팅한 경기 중 취소된 경기의 배당률은 모두 1.0배로 처리하며 선택한 경기 중 한 경기라도 결과가 확정되었을 경우 그 배팅은 유효하게 처리 됩니다.단, 선택한 경기가 모두 취소가 되었을 경우는 100% 환불 처리됩니다.</dd>
				<dd>(4)&nbsp;대상경기 시간은 정규 경기시간까지의 결과를 적용합니다. (야구, 농구, 배구 제외)</dd>
				<dd>(5)&nbsp;시작 및 마감시간은 한국시간을 기준으로 하며, 기타운영상의 사유에 따라 변경될 수 있습니다.</dd>
				<dd>(6)&nbsp;회원은 자신의 배팅 머니를 24시간 언제든지 환전을 요구할 수 있으며, 회사는 회원의 환전요구를 신속하게 처리합니다.</dd>
				<dd>(7)&nbsp;배팅금액은 최소 5천원에서 최대 100백만원이며 배팅상한선을 초과 배팅 할 경우 배팅이 제한되며, 최대적중금 상한가는 300만원이며, 이를 초과할 경우 300만원까지만 지급되며 차액은 몰수 처리됩니다.</dd>
				<dd>(8)&nbsp;단폴더 배팅은 최대 50만원 까지만 배팅 하실수 있습니다 스타실시간 야구 실시간을 제외한 무분별한 단폴더 배팅은 제제를 당하실수 있습니다</dd>
				<dd>(9)&nbsp;배팅한 후 10분이내에는 하루 3회까지 회원 본인이 배팅취소가 가능하며 10분이 지난 이후에는 프로그램상의 오류가 아닌 이상 절대 취소되거나 변경이 불가능합니다. 회원은 배팅을 결정하기 전 신중히 검토한 다음 배팅하시기 바랍니다.</dd>
				<dd>(10)&nbsp;회사는 운영에 지장을 초래 하는 회원에 한해 별도의 통보 없이 계정을 취소 또는 정지 시킬 수 있는 권리가 있으며, 보유 머니를 몰수 할 수 있습니다.</dd>
				<dd>(11)&nbsp;시스템 및 전산 장비의 오류 또는 천재지변으로 인한 장애가 발생하여 배팅 및 정산과 관련된 오류 발생시, 회원은 이를 회사에 즉시 알려야 할 책임이 있으며 회사가 인지 못한 오류로 발생되는 회원의 손실은 회사가 책임지지 않습니다.</dd>
				<dd>(12)&nbsp;경기 시작후 배팅시 적중특례 처리합니다.</dd>
				<dd>(13)&nbsp;핸디캡 및 오버언더 경기에서 한쪽으로 배팅이 집중될 경우 해당경기에 더 이상 배팅을 하지 못하도록 막은 후 기준점을 변경하여 새로운 게임을 등록할 수 있으며 이 경우 변경 전 게임에 배팅하신 회원은 당시의 기준점을 적용받습니다.</dd>
				<dd>(14)&nbsp;동일한 IP로 다계정 접속기록이 있는 회원 중 급격히 보유금액이 늘어나거나 동향에 변화가 있을 경우 자동 차단 프로그램에 의해 배팅이 불가능한 상태가 될 수 있습니다.</dd>
			</dl>
		</div>

		<div id="rule_betting" <?php if($TPL_VAR["tab_index"]!=1){?> style="display:none;"<?php }else{?>class="on"<?php }?>>
			<dl>
				<dt>금지배팅 규정</dt>
				<dd>다음과 같은 배팅의 경우 당첨금 전액 혹은 일부 몰수처리 될 수 있으며 3회이상 발견시 의도적이라고 판단하여 별도의 통보없이 강제탈퇴 처리될 수 있습니다. 수많은 배팅을 일일이 사전 확인하기가 사실상 불가능하므로 당첨된 배팅내역만을 기준으로 검토합니다.</dd>
				<dd>(1) 중복배팅
					<ul>
						<li>- 중복베팅은 베팅할 당시의 아이디(ID)와 아이피(IP)를 두가지 모두를 기준으로 차단합니다. 
							(현재 유동성 아이피를 사용하여 중복배팅 하시는 분들의 경우 호스트 아이피는 같으므로 아이피는 틀리더라도 호스트 아이피가 같으면 중복배팅으로 처리하여 전액 몰수 처리됩니다.)</li>
						<li>- 한경기에 당첨금 상한가 300만원 조합을 완성하고 동일 조합으로 동일한 배팅을 했을 경우 당첨금 상한가 300만원을 초과하는 금액은 전액 몰수 처리합니다.</li>
						<li>- 동일한 IP에서 배팅한 금액의 합계가 50만원 이상 이거나 당첨금액의 합계가 300만원을 초과할 경우 당첨금 상한가인 300백만원을 뺀 차액을 전액 몰수 처리합니다.</li>
						<li>- 핸디캡/오버언더 기준점 변경전 50만원 배팅하고 기준점 변경 후 50만원 추가 배팅한 경우 최초게임만 인정하고 나머지 게임은 전부 취소처리합니다.</li>
						<li>- 축배팅시 당첨금은 400만원까지만 지급합니다. 400만원을 초과하는 금액은 회수처리합니다.</li>
					</ul>
				</dd>
				<dd>(2) 멀티배팅규정
					<ul>
						<!--<li>- 무승부가 있는 축구나 하키 경기에 배팅하실때 동일경기 무승무에 언더오버 배팅을 하실수 없습니다.<li>-->
						<li>- 동일경기 승무패 + 핸디캡 승,패 배팅하실 수 없습니다.</li>
						<li>- 동일경기 무 + 언더,오버 배팅하실 수 없습니다.</li>
						<li>- 1이닝 득점 무득점 경기는 핸디 언더오버와 크로스배팅 인정해드리지 않습니다.
						만약 1이닝 득점 무득점 경기로 핸디 언더오버와 크로스배팅 하신다면 전액 몰수 하겠습니다.
						* 쉽게 말씀드리자면 1이닝 득점/무득점 경기는 승무패 폴더에 있는경기만 조합이 가능합니다.</li>
						<li>- 전산상의 오류로 배팅하실 수 없는 배팅이 성립이 될시에는
						배팅규정을 모르셨다고 항의하셔도 적특처리 됨을 알려드립니다.
						
						배팅규정을 숙지하시고 피해보시는 일 없었으면 좋겠습니다.</li>
					</ul>
				</dd>
			</dl>

		</div>

		<div id="rule_special" <?php if($TPL_VAR["tab_index"]!=2){?>style="display:none;"<?php }?>>
			<dl>
				<dt>적중특례 기준</dt>
				<dd>다음의 경우 적중특례 규정이 적용됩니다.
				모든 축구 경기는 7M.CN 을 기준으로 하여 마감처리가 진행됩니다.</dd>

<li>- 축구 경기도중 Postponed(경기연기) 가 될시에는 경기시작시간부터 3시간후 적중특례 처리합니다 단 연기가 확정된 경기에대해서는 바로 마감 처리합니다</li>

<li>- 축구 경기도중 Undecided(지연) 으로 인해 경기가 지연될경우 경기시작시간부터 3시간 동안 경기가 재개되지않을시 적중특례 처리합니다</li>

<li>- 축구 경기도중 cut(중단) 으로 인해 경기가 중단될시 경기시작시간부터 3시간 동안 경기가 재개되지않을시 적중특례 처리합니다</li>

<li>- 축구 경기도중 Pause(잠시중지) 로 인해 경기가 중지될시 경기시작시간부터 3시간 동안 경기가 재개되지않을시 적중특례 처리합니다</li>

<li>- 축구 경기도중 중립(N) 미표기 시에는 정상적으로 게임진행을 처리하도록 하겠습니다

(경기시작 시간보다 빨리시작하여 적중특례 처리될때에는 그전에 배팅하셨다 하더라도 적중특례 적용됩니다)</li>
</dl>

<dl>
<dt>모든대상경기 공통 적중특례 기준</dt>

<li>- 잘못된 팀명표시 및 홈/원정 이 뒤 바뀔경우 적중 특례 처리합니다</li>

<li>- 대상경기 시간변동시 게임시작시간보다 먼저 시작한 경기의 경우에는 적중특례 처리합니다
(단 본 경기시작시간보다 늦게 시작한 경기에 대해서는 정상적으로 마감처리를 진행합니다)</li>

<li>- 핸디캡 스페셜게임에서 정배와 역배의 핸디의값이 잘못올라간 경우의 게임은 적중특례 처리합니다

(단 배당변경으로 인하여 변경된 게임은 정상처리됩니다)</li>
</dl>

<dl>
<dt>배당률오류관련 공지</dt>

<li>- 배당률 오류로 인한 공지사항을 말씀드리겠습니다.

2년넘게 운영하면서, 배당률 및 기준점 오류로 인한 문제는 저희사이트에서

100 퍼센트 회사책임으로 인정하여 정상적으로 처리를 하여 드렸으나, 오류부분을

"고의적으로(악용)" 배팅하시는 분들이 간혹 있으셔서 확실하게 선을 긋고자 말씀을

올립니다. 앞으로는 대상경기를 업데이트하는동안 시스템상으로 혹은 배당 산출상의 문제로

대상경기의 배당률및 기준점이 오류임이 분명할때,(ex>해외배당사이트와 정반대일경우 등)

저희 사이트는 해당 경기를 취소(적중특례) 처리하겠습니다.

이점 양지하여주시기 바랍니다.(오류부분이 없도록 더욱더 노력하는 운영팀이 되겠습니다.)</li>

			</dl>
		</div>

		<div id="rule_events" <?php if($TPL_VAR["tab_index"]!=3){?> style="display:none;"<?php }?>>
			<dl>
				<dt>◇ 야구</dt>
				<dd>- 승    패: 연장전을 반영하며 연장전에서도 승부를 가리지 못해 무승부 처리가 될 경우 1.0배 처리,승부치기 반영</dd>

				<dd>- 핸디캡: 연장전을 반영하지 않으며 정규 9회말을 채우지 못한 상황에서 경기 종료시 1.0배 처리</dd>
						<dd>- 야구 오버언더: 연장전을 반영하지 않으며 정규 9회말을 채우지 못한 상황에서 경기 종료시 1.0배 처리</dd>
						
						<dd>- 4이닝: 4회말 종료시점까지의 결과를 반영하며 핸디값 적용</dd>
						
						<dd>- 4이닝 오버언더: 4회말 종료시점까지의 양팀간의 점수합산을 반영하며 4회말을 채우지 못하고 경기가 종료된 경우 1.0배 처리</dd>
						<dd>- 기타: 포스트폰드,서스펜디드등 경기 도중 폭우 혹은 강풍으로 경기가 후일로 연기된 경우 1.0배 처리하며 9회를 채우지 못한 상황에서 
						경기가 종료되어도 해당 공식단체의 결과처리를 기준으로 정산</dd>
						<dd>- 야구 경기시작 3시간이후 지연시 적중 특례처리합니다.( 단. 미리 연기 공지가 올라온 경기는 결과처리로 진행합니다)</dd>
			</dl>

			<dl>
				<dt>◇ 야구 실시간 배팅(연장전 포함)</dt>
				<dd>- 공통 : KBO 공식 문자 중계를 기준으로 결과를 처리합니다.</dd>
				<dd>- 경기마감시간은 초구 스트라이크/볼 경기의 경우 전 이닝 2아웃이 되면 마감 처리되고 출루/아웃 경기는 해당경기의 대상선수 2타석 전 선수가 타석에 들어올 때 마감됩니다.<span>현지 인터넷사정이나 서버 불안으로 업무에 지장이 생겨 마감처리가 늦어질 경우 운영진은 해당경기를 적중특례 처리할 수 있음을 알려드립니다.</span></dd>
				<dd>- 실시간 초구 스트라이크/볼 : 매이닝 투수의 초구가 스트라이크인지 볼인지를 예상하여 배팅하는방식입니다.
초구는 투수의 매 이닝 첫 타자의 초구를 말하며 초구를 타격하여 파울이 될 경우 투수의 다음 투구로 결과 처리하며 초구를 타격하여 플레이가 진행된 경우 <span>(ex:번트,홈런,안타,아웃등) 다음 타자의 초구로 결과 처리합니다. 그리고 다음 타자의 경우도 위 규정을 소급하여 계속 적용합니다.</span>
					<ul>
						<li>헛스윙 및 파울팁은 스트라이크로 인정되며 KBO 공식 문자 중계를 기준으로 처리합니다.
							<ul class="example">
								<li>·예) 1구 파울 2구 볼 = 볼 </li>
								<li>·예) 1구 파울 2구 스트라이크 = 스트라이크</li>
								<li>·예) 1구 타격 후 아웃이나 출루 = 다음타자</li>
								<li>·예) 1구 헛스윙 = 스트라이크 처리</li>
								<li>·예) 1구 파울팁 = 스트라이크 처리</li>
								<li>·예) 1구 힛 바이 피치드 볼 (일명 데드볼) = 볼</li>
								<li>·예) 1구 파울 2구 파울 3구 스트라이크 낫아웃 = 스트라이크 처리</li>
							</ul>
						</li>
					</ul>
				</dd>
				<dd>- 실시간 출루/비출루 : 대상 선수가 출루할지 비출루할지를 예상하여 배팅하는 방식이며 어떤 경우라도 1루에 출루만하면 출루로 인정됩니다. <span>예)볼넷, 몸에 맞는 공, 안타, 2루타, 3루타, 홈런, 1루를 밟고 2루 혹은 3루로 주루 도중 주루사 할 경우, 야수선택에 의한 출루, 스트라이크 낫아웃에 의한 출루, 
실책에 의한 출루, 투수 보크에 의한 출루 등 모두 출루로 인정합니다. 단 고의사구의 경우 적중특례 처리합니다.</span></dd>
				<dd>- 첫볼넷 : 볼넷을 얻어내어 먼저 출루하는 팀을 맞추는 배팅방식입니다. 몸에 맞는 공(데드볼) 미포함이며 볼넷으로 출루하는것만 인정합니다.</dd>
				<dd>- 1이닝 득점/무득점 : 양팀의 1이닝을 기준으로하여 득점인지 무득점인지 맞추시는 배팅방식입니다.</dd>
				<dd>- 총득점 홀/짝 : 양팀의 점수를 합산하여 홀/짝을 맞추는 배팅방식입니다.</dd>
				<dd>- 시범경기는 연장전을 포함하지 않습니다.</dd>
			</dl>

			<dl>
				<dt>◇ 축구 </dt>
				<dd>- 전/후반까지의 결과 적용(연장전 및 승부차기 제외)</dd>
				<dd>- 해당단체 룰에 의해 90분 경기가 아닐 경우. 예를 들어 유소년/17세 경기(전후반 80분 룰)처럼 해당단체에서 공식적으로 인정한 경기는 정상적으로 결과를 적용하지만 이틀에 걸쳐 45분씩 진행되는 경기는 적중특례 처리함.</dd>
				<dd>- 승무패, 핸디캡, 오버언더 모두 같음.</dd>
			</dl>
			<dl>
				<dt>◇ 농구</dt>
				<dd>- 1~4쿼터까지 승부결과가 나지않을 시 연장전 경기결과 적용합니다.</dd>
				<dd>- 단, 핸디캡, 언더 오버는 연장전 미포함.</dd>
			</dl>
			<dl>
				<dt>◇ 배구</dt>
				<dd>- 정규세트까지 승부결과가 나지않을 시 연장전 경기결과 적용합니다.</dd>
				<dd>- 승무패, 핸디캡 같음. 단, 오버언더는 연장전 미포함.</dd>
			</dl>
			<dl>
				<dt>◇ NFL(미식축구)</dt>
				<dd>- 1~4쿼터까지 승부결과가 나지않을 시 연장전 경기결과 적용합니다.</dd>
				<dd>- 승무패, 핸디캡, 오버언더 모두 같음.</dd>
			</dl>
			<dl>
				<dt>◇ 아이스하키</dt>
				<dd>- 정규 3피리어드 까지의 결과 적용(연장전 및 승부치기 제외)</dd>
				<dd>- 승무패, 핸디캡, 언더오버  모두 같음</dd>
			</dl>
			
			<dl>
				<dt>◇ 야구</dt>
					<dd>- 승패: 연장전을 반영하며 연장전에서도 승부를 가리지 못해 무승부 처리가 될 경우 1.0배 처리,승부치기 반영 </dd>
					<dd>- 핸디캡: 연장전을 반영하지 않으며 정규 9회말을 채우지 못한 상황에서 경기 종료시 1.0배 처리</dd>
					<dd>- 야구 오버언더: 연장전을 반영하지 않으며 정규 9회말을 채우지 못한 상황에서 경기 종료시 1.0배 처리 </dd>						
					<dd>- 4이닝: 4회말 종료시점까지의 결과를 반영하며 핸디값 적용 </dd>						
					<dd>- 4이닝 오버언더: 4회말 종료시점까지의 양팀간의 점수합산을 반영하며 4회말을 채우지 못하고 경기가 종료된 경우 1.0배 처리 </dd>
					<dd>- 기타: 포스트폰드,서스펜디드등 경기 도중 폭우 혹은 강풍으로 경기가 후일로 연기된 경우 1.0배 처리하며 9회를 채우지 못한 상황에서 
					경기가 종료되어도 해당 공식단체의 결과처리를 기준으로 정산 </dd>
					<dd>- 야구 경기시작 3시간이후 지연시 적중 특례처리합니다.( 단. 미리 연기 공지가 올라온 경기는 결과처리로 진행합니다)</dd>
			</dl>	
			<dl>
				<dt>◇ 스타크래프트</dt>
					<dd> - 공식단체의 무승부판정으로 재경기를 가질 경우 재경기 경기로 정산처리를 원칙으로 하며 경기가 진행되지 않은 상태에서의 
					부전승 등은 취소처리를 원칙으로 합니다. </dd>
			</dl>
			<dl>
				<dt>◇ UFC</dt>
					<dd>- 모든 게임결과는 공식단체의 결과대로 처리하며 실격, 부상, 반칙패, 게임포기등의 사유도 공식단체의 결과대로 처리한다. 
					천재지변(폭우, 지진등)으로 인한 경기취소는 적특처리 </dd>
			</dl>
			<dl>
				<dt>◇ 스타크래프트 실시간 배팅</dt>
				<dd>- 대상경기 시작 후 임의로 마감처리합니다.</dd>
				<dd>- 관리자 서버 불안정 및 중계방송 시청 불가능 등의 이유로 정상적으로 게임을 진행할 수 없는 경우 관리자는 임의로 게임을 진행 여부를 결정할 수 있습니다.</dd>
				<dd>- 관리자 서버 불안정 등의 이유로 정삭적인 마감처리를 하지 못한 경우 경기시작 시간 이후 배팅에 대해서는 적중특례처리합니다</dd>
				<dd>- 몰수패, 선수실수, 천재지변에 의한 경기 중단 등 정상적으로 승패를 결정짓지 못한 경우 공식협회에서 인정한 내용을 결과에 반영합니다.</dd>
			</dl>
			<dl>
				<dt>◇ 이벤트성 경기</dt>
				<dd>- 야구 첫볼넷 : 첫볼넷을 얻을것 같은 팀을 예상하여 배팅하는 방식이며 정산 후 경기 진행중 폭우 등으로 5회말을 채우지 못하고 취소 되었더라도 최초 정산이 인정됨(고의사구는 인정 , 사구 즉 몸에 맞는 볼은 인정되지 않음)</dd>
				<dd>- 야구 첫홈런 : 홈런을 먼저 쳐내는 팀을 예상하여 배팅하는 방식이며 초 , 말 공격에 상관없이 처리됨. 정산 후경기 진행중 폭우 등으로 5회말을 채우지 못하고 취소 되었더라도 최초 정산이 인정됨</dd>
				<dd>- 야구 1이닝득점.무득점 : 1회초 시작시점부터 1회말이 끝나는시점 까지 양팀이 득점을 하냐 못하냐를 맞추는 게임 입니다 1회말 3아웃까지 채우지 못할시 적중 특례 됩니다.</dd>
				<dd>- 야구 첫득점 : 기본적으로 첫득점은 초, 말공격에 상관없이 먼저 득점하는 팀이 승리를 하는 게임입니다. <span>예) 기아 1회초 1점득점, 삼성 1회말 3점 득점한 경우 기아 첫득점이 승리합니다. 정산 후 경기 진행중 폭우 등으로 5회말을 채우지 못하고 취소 되었더라도 최초 정산이 인정됨</span></dd>
				<dd>- 농구 선수별 득점
					<ul>
						<li>예) 업데이트된 수선수중 많은 득점을 올리는 선수를 맞추는 방식입니다.</li>
						<li>예) 업데이트된 두명의 선수중 한선수라도 경기에 출전하지 못하면 적중특례 처리합니다.</li>
						<li>예) 업데이트된 두명의 선수중 1초라도 경기에 출전하면 정상 마감처리 됩니다 a선수는 20분을 뛰고 b선수는 1초만 뛰고 교페되어도 정상 마감처리 됩니다.</li>
						<li>예) 선수별 득점은 연장전을 포함합니다.</li>
					</ul>
				</dd>
				<dd>- 축구 옐로우카드 오버언더(연장전 미포함) : 양팀이 옐로우카드를 받는 개수의 합을 예상하여 기준점보다 많을지 적을지를 배팅하는 방식이며 레드카드의 경우 옐로우카드 2장으로 인정됩니다. <span>예) 옐로우카드 경기 기준점이 -3.5일때 옐로우카드가 1~3장 나왔을 경우 언더, 4장 이상 나왔을경우 오버</span></dd>
				<dd>- 축구 첫코너킥 : 양팀 중 첫 코너킥을 어느팀이 찰지를 예상하여 배팅하는 방식입니다.</dd>
				<dd>- 축구 코너킥 오버언더(연장전 미포함) : 양팀 코너킥 개수의 합을 예상하여 기준점보다 많은지 적을지를 배팅하는 방식입니다. <span>예) 양팀 코너킥의 개수를 합하여 -10.5일때 10개 이하일 경우 언더, 11개 이상은 오버입니다.</span></dd>
			</dl>

		</div>

		<div id="rule_guide" <?php if($TPL_VAR["tab_index"]!=4){?> style="display:none;"<?php }?>>
			<dl>
				<dt>특별규정</dt>
				<dd>(1) 동일IP 접속 불가
					<ul>
						<li>- 신규가입할 당시 추천인과의 동일아이피 접속외에 어떤 예외도 없이 2개 이상의 계정으로 동일한 아이피를 통해 접속하시는 모든 회원님들의 아이피를 1차적으로 차단하며 접속을 시도한 모든 아이디를 자체심사 후 경고조치 없이 탈퇴처리 할 수 있습니다.</li>
						<li>- 이전 고객센터를 통해 사무실,기숙사 등 어쩔수 없는 상황이라고 양해를 구하셨던 회원님들 역시 예외가 없으며 탈퇴처리 후 보유머니는 등록하신 환전계좌로 바로 출금처리 되며 배팅 진행중인 내역에 대해서는 오해의 소지를 없애기 위해 결과등록 후 미당첨 금액은 회수하고 당첨된 금액에 대해서는 정상으로 출금처리됩니다. </li>
					</ul>
				</dd>
				<dd>(2) 중요데이터 삭제
					<ul>
						<li>- 회원의 아이디/비번이 타인에게 노출되었을 경우를 대비하여 계좌번호/전화번호를 따로 저장하여 관리하기 때문에 마이페이지에서 핸드폰번호, 계좌번호가 화면상에 보이지 않습니다. 충전/환전 업무는 정상적으로 처리되오니 착오 없으시길 바랍니다. </li>
					</ul>
				</dd>
			</dl>
			<dl>
				<dt>회원 강제탈퇴 및 보유머니 몰수 처리 규정</dt>
				<dd>- 해킹으로 의심되는 방법이나 관리자가 인지하지 못하는 버그를 이용하는 등의 부정한 방법으로 배팅머니를 보유하였을 경우 별도의 통보 없이 해당회원의 보유머니를    전액 몰수 후 강제 탈퇴 처리할 수 있습니다.</dd>
				<dd>- 중복IP배팅, 입출금 및 활동내역이 없거나 아주 소액으로 활동하는 회원중 로그인 기록이 의심스러운 회원님에 대해 별도의 통보 없이 자체 판단하여 보유금액 출금처리 후 강제탈퇴 및 접속IP를 전부 차단할 수 있습니다.</dd>
				<dd>- 입금계좌 변경 및 도메인 변경시 운영진의 요청에 수차례 협조치 않아 보안에 심각한 위협이 된다고 판단되는 회원은 별도의 통보 없이 강제탈퇴 처리할 수 있습니다.</dd>
				<dd>- 동일한 입금내역을 수회 반복하여 입금신청하거나 입금 금액보다 더 많은 금액을 입금신청하는 등 고의적으로 관리자의 실수를 유도한다고 판단 될 만큼 자주 반복되는 경우 고의로 간주하여 추가입금액을 강제 출금 후 탈퇴처리 할 수 있습니다.</dd>
			</dl>
		</div>
		
		<div id="rule_matgo" <?php if($TPL_VAR["tab_index"]!=5){?>style="display:none;"<?php }?>>

			<dl>
				<dt>1. 비정상적인 종료시 유저의 권익 보호 및 공정성 유지를 위한 규정</dt>
				<dd>맞고 게임진행 중 게임이 비정상적으로 종료되었을 시 유저의 권익 보호 및 공정성 유지를 위해 비정상적 종료가 된 유저 대신 게임 인공지능이 게임을 계속 진행할 수 있으며, 이 결과는 정식 결과로 인정이 됩니다.<br><br> 비정상적 종료는 다음과 같은 경우로 규정됩니다.
					<ul>
						<li>- 천재지변 및 인터넷 접속 서비스 문제로 일어난 인터넷 연결 오류 등의 비정상적 종료</li>
						<li>- PC 강제 종료, LAN 선 차단, 인터넷 강제 접속차단 등 고의적인 방법을 통한 비정상적 종료</li>
						<li>- 개인 PC의 오류에 의한 비정상적 종료</li>
						<li>- 기타 불공정하고 고의적인 방법을 통한 비정상적 종료 행위시 </li>
					</ul>
					<br><br> 
				</dd>
				<dt>2. 맞고 게임 시 스포츠 베팅 게임은 베팅 불가</dt>
				<dd>맞고 게임을 실행 중일 시 스포츠 베팅은 불가하며, 게임 종료 후 스포츠 베팅이 가능합니다.</dd>
			</dl>

		</div>

	</div>