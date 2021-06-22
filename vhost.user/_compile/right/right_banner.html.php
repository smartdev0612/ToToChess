<div id="contents_right">
<?php
	if ( $TPL_VAR["view_type"] != "sadari" and $TPL_VAR["view_type"] != "dari" and $TPL_VAR["view_type"] != "race" and $TPL_VAR["view_type"] != "power" ) {
?>
	<div id="betting_cart">
		<div class="banner_box_1">
			<ul style="height:158px;">
				<li class="banner_9" style="padding:0;"><a href="/game_list?game=dari"><img src="/images/sadari_banner.png" align="absmiddle" /></a></li>
				<li class="banner_9" style="padding:5px 0;"><a href="javascript:alert('서비스 준비중입니다.');"><img src="/images/real20_banner.png" align="absmiddle" /></a></li>
			</ul>
			<ul style="padding:2px; background:#000;">
				<li class="banner_1"><a href="http://named.com/" target="_new"><img src="/images/sub_banner_01.png"></a></li>
				<li class="banner_2"><a href="http://www.powerballgame.co.kr/" target="_new"><img src="/images/sub_banner_02.png"></a></li>
				<li class="banner_3"><a href="http://www.naver.com/" target="_new"><img src="/images/sub_banner_03.png"></a></li>
				<li class="banner_4"><a href="http://livescore.co.kr/" target="_new"><img src="/images/sub_banner_04.png"></a></li>
				<li class="banner_5"><a href="http://daum.net/" target="_new"><img src="/images/sub_banner_05.png"></a></li>
				<li class="banner_6"><a href="http://www.bet365.es" target="_new"><img src="/images/sub_banner_06.png"></a></li>
				<li class="banner_7"><a href="http://google.com" target="_new"><img src="/images/sub_banner_07.png"></a></li>
				<li class="banner_8"><a href="#"><img src="/images/sub_banner_08.png"></a></li>
				<!-- <li class="banner_9"><img src="/images/kakao.png" align="absmiddle"></li> -->
			</ul>
			
		</div> <!--//banner_box_1 종료-->
	</div> <!--// betting_cart 종료-->
<?php
	} else {
?>
		<div class="banner_box_1">
			<ul style="margin-left:30px;height:158px;">
				<li class="banner_9" style="padding:5px 0;"><a href="http://named.com/" target="_new"><img src="/images/result_right_banner.png"></a></li>
			</ul>
		</div> <!--//banner_box_1 종료-->
<?php
	}
?>
</div> <!--// contents_right 종료-->

<script type="text/javascript">initMoving();</script>