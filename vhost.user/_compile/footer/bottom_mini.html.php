	<!-- 베팅카트 -->
	<!-- 모바일 푸터 메뉴 -->
	<div id="mobile_foot_menu">
		<ul class="foot_menu">
            <li><span class="ico_customer"><a href="https://telegram.me/<?=$TPL_VAR["telegramID"]?>" target="_blank"><img src="/10bet/images/10bet/ico_telegram_01.png" alt="텔레그램"></a></span></li>
			<li><span class="ico_customer"><a href="/cs/cs_list"><img src="/10bet/images/10bet/ico_customer_01.png" alt="고객문의" /></a></span></li>
			<!--<li><span class="ico_chetting"><img src="/10bet/images/10bet/ico_chetting_01.png" alt="라이브채팅" /></span></li>-->
            <li>
                <span class="ico_cart">
                    BETSLIP
                    <img src="/10bet/images/10bet/ico_cart_01.png" alt="배팅카트" />
                </span>
            </li>
            <li>
                <span class="ico_bottom_menu" id="ico_bottom_menu">
                    MINI
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 33 35" fill="currentColor">
                        <rect width="33" height="7" rx="3.5" ry="3.5"></rect>
                        <rect y="14" width="33" height="7" rx="3.5" ry="3.5"></rect>
                        <rect y="28" width="33" height="7" rx="3.5" ry="3.5"></rect>
                    </svg>
				</span>
			</li>
		</ul>
	</div>
	
	<!-- 모바일 베팅카트 -->
    	
	<!-- 모바일 하단 메뉴 -->
    <div class="mobile_bottom_menu" id="mobile_bottom_menu">
        <div class="icon-close" style="width:15px; height:15px; float:left; color: #aDaEa5;">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" class="svg-inline--fa fa-times fa-w-11">
                <path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path>
            </svg>
        </div>
        <div class="other_menu_list	box_type01" style="box-shadow: none;">
            <!-- 메뉴 리스트	-->
            <ul class="mune_list01" style="margin-top: 25px;">
            <?php 
            if($TPL_VAR["miniSetting"]["power_use"]==1){?>
                <li>
                    <?php if($TPL_VAR["api"] == "true") { ?>
                        <a href="/api/game_list?game=power&userid=<?=$TPL_VAR["uid"]?>">
                    <?php } else { ?>
                        <a href="/game_list?game=power">
                    <?php } ?>
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'power' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_powerball_01.png" alt="ico" /> 
                            파워볼									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["powersadari_use"]==1){?>
                <li>
                    <a href="/game_list?game=psadari">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'psadari' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_powersadari_01.png" alt="ico" /> 
                            파워사다리									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["kenosadari_use"]==1){?>
                <li>
                    <?php if($TPL_VAR["api"] == "true") { ?>
                        <a href="/api/game_list?game=psadari&userid=<?=$TPL_VAR["uid"]?>">
                    <?php } else { ?>
                        <a href="/game_list?game=psadari">
                    <?php } ?>
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'kenosadari' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_powersadari_01.png" alt="ico" /> 
                            키노사다리									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["fx_use"]==1){?>
                <li>
                    <a href="/game_list?game=fx&min=1">
                        <div class="menu01 <?= $TPL_VAR["min"] == '1' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                            FX1분									
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/game_list?game=fx&min=2">
                        <div class="menu01 <?= $TPL_VAR["min"] == '2' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                            FX2분									
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/game_list?game=fx&min=3">
                        <div class="menu01 <?= $TPL_VAR["min"] == '3' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                            FX3분									
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/game_list?game=fx&min=4">
                        <div class="menu01 <?= $TPL_VAR["min"] == '4' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                            FX4분									
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/game_list?game=fx&min=5">
                        <div class="menu01 <?= $TPL_VAR["min"] == '5' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                            FX5분									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["choice_use"]==1){?>                              
                <li>
                    <a href="/game_list?game=choice">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'choice' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_sky_01.png" alt="ico" /> 
                            초이스									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["roulette_use"]==1){?>                          
                <li>
                    <a href="/game_list?game=roulette">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'roulette' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_hand.png" alt="ico" /> 
                            룰렛									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["pharah_use"]==1){?>                           
                <li>
                    <a href="/game_list?game=pharaoh">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'pharaoh' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_bubble.png" alt="ico" />
                            파라오									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["dari2_use"]==1){?>    
                <li>
                    <a href="/game_list?game=2dari">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == '2dari' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_sky_01.png" alt="ico" /> 
                            이다리									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["dari3_use"]==1){?>                              
                <li>
                    <a href="/game_list?game=3dari">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == '3dari' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_sky_01.png" alt="ico" /> 
                            삼다리									
                        </div>
                    </a>
                </li>
            <?php } ?>
            </ul>
        </div>
    </div>
<script language='javascript'> var g4_cf_filter = ''; </script>
<script language='javascript' src='/10bet/js/filter.js'></script>
	<footer>
		<ul class="foot_site">
			<li><img src="/10bet/images/10bet/foot_banner_01.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_02.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_03.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_04.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_05.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_06.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_07.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_08.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_09.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_10.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_11.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_12.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_13.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_14.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_15.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_16.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_17.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_18.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_19.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_20.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_21.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_22.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_23.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_24.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_25.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_26.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_27.png" alt="" /></li>
			<li><img src="/10bet/images/10bet/foot_banner_28.png" alt="" /></li>
		</ul>
		<div class="footer_bottom">
			<h1><img src="/10bet/images/10bet/foot_logo_01.png?v=1" alt="GG 로고" /></h1>
			<p><br>
            </p>
            <copyright>COPYRIGHT ⓒ <span>체스</span> ALL RIGHTS RESERVED.</copyright>
		</div>
	</foonter>
</div>
<!-- 레이어 팝업 -->

<div id="warning_popup" class="popup_section" style="margin-top:-50px;margin-left:-160px;display:none;">
	<div class="pop_box">
		<h2>알림창</h2>
		<span class="close_pop" onClick="warning_popup_close();"><img src="/10bet/images/10bet/ico_close_01.png" alt="창닫기" /></span>
		<div class="pop_message">
			잘못된 경로 입니다.
		</div>
	</div>
</div>
<script>
    $j(".icon-close").on("click", function(){
        $j(".mask_layer").click();
    });
</script>

<div id="basic-modal">
    <!-- modal content -->
    <div id="basic-modal-content">
        <h3>알림</h3>
        <p style="padding-top:25px;">새로운 쪽지가 <font color="#2afd56">1 건</font> 도착햇습니다.</p>
        <br />
        <p><a href='/bbs/memo.php' style="color:#2afd56; font-size:15px;"><img src="/10bet/images/icon_memo_tit.png" style=" vertical-align:top;" />&nbsp;쪽지보기</a></p>
    </div>
</div>

<!-- simple modal {{ -->
<link type='text/css' href='/10bet/simplemodal/css/basic.css' rel='stylesheet' media='screen' />
<script type='text/javascript' src='/10bet/simplemodal/js/jquery.simplemodal.js'></script>
<!-- simple modal }} -->
</body>
</html>