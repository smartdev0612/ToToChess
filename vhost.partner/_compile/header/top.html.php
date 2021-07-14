<?php /* Template_ 2.2.3 2014/02/27 03:47:38 D:\www_one-23.com\vhost.partner\_template\header\top.html */?>
<div id="wrap_gMenu">
	<p id="logo"><a href="/"><img src="/img/top_logo.gif" alt="파트너 관리자 메인"></a><h1 class="blind">파트너 관리자 시스템</h1></p>
	<ul>				
		<!--<li><a href="javascript:void(0);" onclick="open_window('/etc/popup_ChangePassword',500,300);" >비번변경</a></li>-->
		<li><a href="/logout" target="_top">로그아웃</a></li>
	</ul>
</div>
<div id="topMenu_tab">
	<dl id="tpa">
	<dd><div class='itemsel' id='item1' ><a href="/">메인</a></div></dd>
	<dd><div class='item' id='item3' ><a href="/member/partner_struct">파트너구조</a></div></dd>
	<dd><div class='item' id='item3' ><a href="/member/list">회원목록</a></div></dd>
	<dd><div class='item' id='item4' ><a href="/charge/list" >입금내역</a></div></dd>
	<dd><div class='item' id='item5' ><a href="/exchange/list" >출금내역</a></div></dd>			
	<dd><div class='item' id='item6' ><a href="/statMoney/list" >입출금통계</a></div></dd>
	<dd><div class='item' id='item6' ><a href="javascript:void(0)" onclick="javascript:open_window('/memo/popup_list','800','620')">쪽지 (<span id="memoCnt"><?=$TPL_VAR["memoCnt"]?></span>)</a></div></dd>
	</dl>
</div>