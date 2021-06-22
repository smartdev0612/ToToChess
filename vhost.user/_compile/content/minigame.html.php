
    <div class="mask"></div>
    <div id="container">
		<div id="contents" style="margin:0;">
		<!-- 미니게임 메인 -->
		<div class="minigame_main">
			<?php 
            if($TPL_VAR["miniSetting"]["power_use"]==1){?>
			<div class="box01">
				<div class="img_box"><a href="/game_list?game=power"><img src="/10bet/images/10bet/img_mini_menu_03.png?v01" alt="파워볼" /></a></div>
			</div>
			<?php } 
            if($TPL_VAR["miniSetting"]["powersadari_use"]==1){?>
			<div class="box01">
				<div class="img_box"><a href="/game_list?game=psadari"><img src="/10bet/images/10bet/img_mini_menu_04_new.png?v01" alt="파워사다리" /></a></div>
			</div>
			<?php } 
            if($TPL_VAR["miniSetting"]["kenosadari_use"]==1){?>
			<div class="box01">
				<div class="img_box"><a href="/game_list?game=kenosadari"><img src="/10bet/images/10bet/img_mini_menu_80_new.png?v01" alt="키노사다리" /></a></div>
			</div>
			<?php } 
            if($TPL_VAR["miniSetting"]["fx_use"]==1){?>
			<div class="box01">
				<div class="img_box"><img src="/10bet/images/10bet/img_mini_menu_06.png?v01" alt="fx게임" /></div>
				<ul class="menu_list">
					<li><button type="button" onClick="location.href='/game_list?game=fx&min=1'">FX1게임</button></li>
					<li><button type="button" onClick="location.href='/game_list?game=fx&min=2'">FX2게임</button></li>
					<li><button type="button" onClick="location.href='/game_list?game=fx&min=3'">FX3게임</button></li>
					<li><button type="button" onClick="location.href='/game_list?game=fx&min=4'">FX4게임</button></li>
					<li><button type="button" onClick="location.href='/game_list?game=fx&min=5'">FX5게임</button></li>
				</ul>
			</div>
			<!--
			<div class="box01">
				<div class="img_box"><a href="/bbs/board.php?bo_table=a61"><img src="/10bet/images/10bet/img_mini_menu_07_new.png?v01" alt="엔트리스피드키노" /></a></div>
			</div>
			-->
			<?php } 
            if($TPL_VAR["miniSetting"]["choice_use"]==1){?>
			<div class="box01">
				<div class="img_box"><a href="/game_list?game=choice"><img src="/10bet/images/10bet/img_mini_menu_08.png?v01" alt="초이스" /></a></div>
			</div>
			<!--
			<div class="box01">
				<div class="img_box"><img src="/10bet/images/10bet/img_mini_menu_11.png?v01" alt="보글보글" /></div>
				<ul class="menu_list">
					<li><button type="button" onClick="location.href='/bbs/board.php?bo_table=a611'">보글보글1분게임</button></li>
					<li><button type="button" onClick="location.href='/bbs/board.php?bo_table=a612'">보글보글2분게임</button></li>
					<li><button type="button" onClick="location.href='/bbs/board.php?bo_table=a613'">보글보글3분게임</button></li>
					
				</ul>
			</div>
			-->
			<?php } 
            if($TPL_VAR["miniSetting"]["pharah_use"]==1){?>
			<div class="box01">
				<div class="img_box"><a href="/game_list?game=pharaoh"><img src="/10bet/images/10bet/img_mini_menu_12.png?v01" alt="파라오" /></a></div>
			</div>
			<?php } 
            if($TPL_VAR["miniSetting"]["roulette_use"]==1){?>
			<div class="box01">
				<div class="img_box"><a href="/game_list?game=roulette"><img src="/10bet/images/10bet/img_mini_menu_13.png?v01" alt="룰렛" /></a></div>
			</div>
			<?php } 
            if($TPL_VAR["miniSetting"]["dari2_use"]==1){?>
			<div class="box01">
				<div class="img_box"><a href="/game_list?game=2dari"><img src="/10bet/images/10bet/img_mini_menu_01.png?v01" alt="이다리" /></a></div>
			</div>
			<?php } 
            if($TPL_VAR["miniSetting"]["dari3_use"]==1){?>
			<div class="box01">
				<div class="img_box"><a href="/game_list?game=3dari"><img src="/10bet/images/10bet/img_mini_menu_02.png?v01" alt="삼다리" /></a></div>
			</div>
			<?php } ?>
			<!-- <div class="box01">
				<div class="img_box"><img src="/10bet/images/10bet/img_mini_menu_05.png?v01?ver=1" alt="mgm" /></div>
				<ul class="menu_list">
					<li><button type="button" onClick="location.href='/bbs/board.php?bo_table=a96'">MGM홀짝</button></li>
					<li><button type="button" onClick="warning_popup('준비중입니다.');">MGM바카라</button></li>
				</ul>
			</div> -->
		</div>

	<script>
		$j(function(){ 
			<?php
			if(count((array)$_SESSION['member']) > 0) {?>
			<?php } else { ?>
				setInterval(function(){ login_open(); }, 500);
			<?php } ?>
		});
	</script>

	
	