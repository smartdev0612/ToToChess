<?php /* Template_ 2.2.3 2013/03/14 23:41:14 D:\www\m.vhost.user\_template\right\right_normal.html */?>
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
		calc();
		return rs;
	}
</script>


<div id="subbody">

	<div class="wrap_betslip" id="wrap_betslip">

		<ul id="leftbanner">
			<h3 class="blind">퀵메뉴</h3>
			<li class="guide"><a href="javascript:menu0118()"><span>배팅가이드</span></a></li>
			<li class="bethistory"><a href="javascript:menu0215()"><span>배팅내역</span></a></li>
			<li class="money"><a href="javascript:menu0211()"><span>충전&환전</span></a></li>
			<li class="inquiry"><a href="/cs/question"><span>1:1문의</span></a></li>
		</ul>

		<div id="infomation">
			<h3><img src="/img2/infomation_title.gif" title="한줄공지"></h3><marquee direction="up" scrollamount="3">정통 스포츠 배팅 페라리에 오신 것을 환영합니다.</marquee>
		</div>

		<div id="scorelink">
			<h3><img src="/img2/score_title.gif"></h3>
			<ul>
				<li class="livescore"><a href="http://www.livescore.co.kr" target="_blank"><span>라이브스코어</span></a></li>
				<li class="afreeca"><a href="http://www.afreeca.com" target="_blank"><span>아프리카</span></a></li>
				<li class="naver"><a href="http://sports.news.naver.com/sports/new/main/scoreboard.nhn" target="_blank"><span>네이버</span></a></li>
				<li class="daum"><a href="http://sports.media.daum.net/live/" target="_blank"><span>다음</span></a></li>
			</ul>
			<p><a href="javascript://" onClick="window.external.AddFavorite('http://mildtest.com', '페라리')"><img src="/img2/btn_favorite.gif"></a></p>
		</div>

	</div>


</div>