<!-- 베팅카트 -->
	<!-- 모바일 푸터 메뉴 -->
	<div id="mobile_foot_menu">
		<ul class="foot_menu">
            <li><span class="ico_customer"><a href="https://telegram.me/<?=$TPL_VAR["telegramID"]?>" target="_blank"><img src="/10bet/images/10bet/ico_telegram_01.png" alt="텔레그램"></a></span></li>
			<li><span class="ico_customer"><a href="/cs/cs_list"><img src="/10bet/images/10bet/ico_customer_01.png" alt="고객문의" /></a></span></li>
			<!--<li><span class="ico_chetting"><img src="/10bet/images/10bet/ico_chetting_01.png" alt="라이브채팅" /></span></li>-->
            <li><span class="ico_cart" id="ico_betting_cart"><img src="/10bet/images/10bet/ico_cart_01.png" alt="배팅카트" /></span></li>
            <li><span class="ico_bottom_menu" id="ico_bottom_menu">
                    SPORT
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
    <div class="mobile_betting_cart" id="mobile_betting_cart">
        <div class="icon-close" style="width:15px; height:15px; float:left; color: #aDaEa5;">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" class="svg-inline--fa fa-times fa-w-11">
                <path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path>
            </svg>
        </div>
		<form name="betForm" method="post"  action="/race/bettingProcess" style="margin:0px;">
            <input type="hidden" value="betting" name="mode"> 
            <input type="hidden" name=strgametype> 
            <input type="hidden" name="gametype" value=<?=$bettype?>>
            <input type="hidden" name="game_type" value="<?php echo $TPL_VAR["game_type"]?>">
            <input type="hidden" name="s_type" value="<?php echo $TPL_VAR["s_type"]?>">
            <input type="hidden" name="special_type" value="<?php echo $TPL_VAR["special_type"]?>">
            <input type="hidden" name="member_sn" value="<?php echo $TPL_VAR["member_sn"]?>">
            <input type="hidden" name="result_rate">
            <input type="hidden" name="site_code" value="site-a">
            <textarea name="betcontent" style="display:none"></textarea>
            <div class="logo"><a href="/"><img src="/10bet/images/10bet/logo_01.png" alt="IO BET 로고" /></a></div>
            <!-- 베팅카트 -->
            <div class="betting_cart box_type01">
                <h3><img src="/10bet/images/10bet/ico_cart_01.png" alt="" /> betting cart</h3>
                <ul class="betting_list">
                    <li>
                    <table id="tb_list" width="100%"  cellspacing="0" cellpadding="0" align="center">
                    </table>
                    </li>
                </ul>
                
                <div class="betting_box">
                    <ul>
                        <li>보유머니<span class="member_inmoney"><?php echo number_format($TPL_VAR["cash"],0)?> 원</span></li>
                        <li>예상적중배당<span id="sp_bet">00.00</span></li>
                        <li>최대배팅금액<span><?php echo number_format($TPL_VAR["betMaxMoney"])?></span></li>
                        <li>배팅금액<span><input type="text" class="text-right" name="betMoney" id="betMoney" value="0" onKeyUp="javascript:this.value=onMoneyChange(this.value);" onMouseOver="this.focus()"/> 원</span></li>
                        <li>예상적중금액<span id="sp_total">0</span></li>
                    </ul>
                    <div class="btn_list">
                        <button type="button" onClick="bettingMoneyPlus('5000')" <?=count((array)$_SESSION['member']) > 0 ? "" : "disabled"?>>+ 5,000</button>
                        <button type="button" onClick="bettingMoneyPlus('10000')" <?=count((array)$_SESSION['member']) > 0 ? "" : "disabled"?>>+ 10,000</button>
                        <button type="button" onClick="bettingMoneyPlus('50000')" <?=count((array)$_SESSION['member']) > 0 ? "" : "disabled"?>>+ 50,000</button>
                        <button type="button" onClick="bettingMoneyPlus('100000')" <?=count((array)$_SESSION['member']) > 0 ? "" : "disabled"?>>+ 100,000</button>
                        <button type="button" onClick="bettingMoneyPlus('500000')" <?=count((array)$_SESSION['member']) > 0 ? "" : "disabled"?>>+ 500,000</button>
                        <button type="button" onClick="clearMoney()" <?=count((array)$_SESSION['member']) > 0 ? "" : "disabled"?>><span>RESET</span></button>
                    </div>
                    <div class="max_bet">
                        <button type="button" onClick="onAllinClicked()" <?=count((array)$_SESSION['member']) > 0 ? "" : "disabled"?>>MAX BETTING</button>
                    </div>
                    <div class="bet_arae">
                        <button type="button" class="btn_bet" onClick="javascript:betting('betting');" <?=count((array)$_SESSION['member']) > 0 ? "" : "disabled"?>>배팅하기</button>
                        <button type="button" class="btn_del" onClick="javascript:bet_clear();" <?=count((array)$_SESSION['member']) > 0 ? "" : "disabled"?>>전체삭제</button>
                    </div>
                </div>
            </div>
        </form>
	</div>
		
	<!-- 모바일 하단 메뉴 -->
    <div class="mobile_bottom_menu" id="mobile_bottom_menu">
        <div class="icon-close" style="width:15px; height:15px; float:left; color: #aDaEa5;">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" class="svg-inline--fa fa-times fa-w-11">
                <path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path>
            </svg>
        </div>
        <!-- 모바일 스포츠 리스트 -->
		<div class="sports_menu_list box_type01" style="box-shadow:none;">
            
            <div>
                <h3>
                    오늘의 경기 
                    <?php
                    if($TPL_VAR['game_type'] == "multi" && $TPL_VAR['s_type'] == "2") 
                        echo "<span class='cor01'>SPORT-2</span>";
                    else 
                        echo "<span class='cor01'>SPORT-1</span>";
                    ?>
                    <span class="date"><?=date("Y-m-d");?></span>
                </h3>
                <ul class="main_left sports_league_ul">
                    <li class="soc">
                        <img src="/10bet/images/10bet/ico/football-ico.png" alt="ico" style="margin-top:4px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                            <span class="name">축구</span>
                            <span class="count on total_count_soccer">0</span>
                        </a>
                    </li>
                    <div class="div_soccer"></div>

                    <li class="bask">
                        <img src="/10bet/images/10bet/ico/basketball-ico.png" alt="ico"  style="margin-top:4px;">
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                            <span class="name">농구</span>
                            <span class="count on total_count_basketball">0</span>
                        </a>
                    </li>
                    <div class='div_bask'></div>

                    <li class="base">
                        <img src="/10bet/images/10bet/ico/baseball-ico.png" alt="ico"  style="margin-top:4px;"/>
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                            <span class="name">야구</span>
                            <span class="count on total_count_baseball">0</span>
                        </a>
                    </li>
                    <div class="div_base"></div>

                    <li class="hock">
                        <img src="/10bet/images/10bet/ico/hockey-ico.png" alt="ico" style="margin-top:4px;" /> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                            <span class="name">아이스하키</span>
                            <span class="count on total_count_icehocky">0</span>
                        </a>
                    </li>
                    <div class="div_hock"></div>

                    <li class="val">
                        <img src="/10bet/images/10bet/ico/volleyball-ico.png" alt="ico"  style="margin-top:4px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                            <span class="name">배구</span>
                            <span class="count on total_count_volleyball">0</span>
                        </a>
                    </li>
                    <div class="div_val"></div>

                    <li>
                        <img src="/10bet/images/10bet/ico/tennis-ico.png" alt="ico" style="margin-top:4px;" /> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">테니스</span>
                        <?php
                            $bChk = false;
                            foreach($TPL_VAR["game_count_info"] as $info) {
                                if($info['sport_name'] == '테니스') {
                                    echo '<span class="count tenn on">'.$info['nCnt'];
                                    $bChk = true;
                                break;
                                }
                            }
                            if(!$bChk) {
                                echo '<span class="count tenn">0';
                            }
                        ?></span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/handball-ico.png" alt="ico" style="margin-top:4px;" /> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">핸드볼</span>
                        <span class="count hand">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/motor-sport-ico.png" alt="ico" style="margin-top:4px;" /> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">모터 스포츠</span>
                        <span class="count motor">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/rugby-league-ico.png" alt="ico"  style="margin-top:4px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">럭비</span>
                        <span class="count rub">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/speedway-ico.png" alt="ico"  style="margin-top:4px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">크리켓</span>
                        <span class="count cri">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/darts-ico.png" alt="ico"  style="margin-top:4px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?> 
                        <span class="name">다트</span>
                        <span class="count dart">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/futsal-ico.png" alt="ico"  style="margin-top:4px;"/>
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?> 
                        <span class="name">풋살</span>
                        <span class="count foot">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/tabletennis-ico.png" alt="ico"  style="margin-top:4px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">배드민턴</span>
                        <span class="count ton">00</span></a>
                    </li>
                    <li class="espo">
                        <img src="/10bet/images/10bet/ico/esport-ico.png" alt="ico"  style="margin-top:4px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">이스포츠</span>
                        <span class="count espo">00</span></a>
                    </li>
                    <li class="etc">
                        <img src="/10bet/images/10bet/logo_01.png" alt="ico"  style="margin-top:4px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">기타</span>
                        <span class="count ton">00</span></a>
                    </li>
                </ul>
			</div>
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
</footer>
</div>

<!-- simple modal {{ -->
<link type='text/css' href='/10bet/simplemodal/css/basic.css' rel='stylesheet' media='screen' />
<script type='text/javascript' src='/10bet/simplemodal/js/jquery.simplemodal.js'></script>
<!-- simple modal }} -->

<!-- 새창 대신 사용하는 iframe -->
<iframe width=0 height=0 name='hiddenframe' style='display:none;'></iframe>
</body>
</html>
<!-- 사용스킨 : event -->
