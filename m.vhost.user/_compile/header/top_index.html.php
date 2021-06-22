<?php /* Template_ 2.2.3 2013/04/15 15:55:44 C:\APM_Setup\htdocs\m.vhost.user_kingdom\_template\header\top_index.html */?>
<div id="wrap_header">
		<p id="logo"><a href="/"><h1 class="blind">FERRARI</h1></a></p>
		<ul id="grobal_menu">
			<h2 class="blind">글로벌메뉴</h2>
			<li class="bbs"><a href="javascript:menu0116()"><span>게시판</span></a></li>
			<li class="help"><a href="javascript:menu0117()"><span>고객센터</span></a></li>
		</ul>
		<div id="wrap_member">
			<h2 class="blind">회원정보</h2>
			<ul>
				<li class="name"><img src="/img/lvl<?php echo $TPL_VAR["level"]?>.gif"><b><?php echo $TPL_VAR["nick"]?></b>님</li>
				<li class="cash"><?php echo number_format($TPL_VAR["cash"],0)?></li>
				<li class="point"><?php echo number_format($TPL_VAR["mileage"],0)?></li>
				<li><a href="#" onClick="javascript:mileage2Cash();"><img src="/img/memberInfo_btn_cash.gif" ></a></li>
			</ul>
			<p><a href="/logout"><img src="img/btn_logout.gif"></a></p>
		</div>
	</div>