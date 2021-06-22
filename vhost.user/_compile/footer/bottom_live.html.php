<!-- 베팅카트 -->
	<!-- 모바일 푸터 메뉴 -->
	<div id="mobile_foot_menu">
		<ul class="foot_menu">
			<li style="width:33%;"><span class="ico_customer"><a href="/cs/cs_list"><img src="/10bet/images/10bet/ico_customer_01.png" alt="고객문의" /></a></span></li>
			<!--<li><span class="ico_chetting"><img src="/10bet/images/10bet/ico_chetting_01.png" alt="라이브채팅" /></span></li>-->
            <li style="width:33%;"><span class="ico_cart" id="ico_betting_cart"><img src="/10bet/images/10bet/ico_cart_01.png" alt="배팅카트" /></span></li>
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
                            <span class="count soc on total_count_soccer">0</span>
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
                            <span class="count soc on total_count_basketball">0</span>
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
                            <span class="count soc on total_count_baseball">0</span>
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
                            <span class="count soc on total_count_icehocky">0</span>
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
                            <span class="count soc on total_count_volleyball">0</span>
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

<script>
    $j(document).ready(function() {
        // console.log("LEFT");
        //getTodayGameInfo();
    });

    function getTodayGameInfo() {
        $.ajax({
            url: "/getTodayGameInfo",
            type: "GET",
            dataType: "json",
            success: function(res){ 
                $.each(res, function(index, item) {
                    switch(item.sport_name) {
                        case "축구":
                            var div_soccer = "";
                            div_soccer += '<ul class="li-soccer"  onclick=showLeagues("ul-soccer-' + item.nation_sn + '") style="display:none;">';
                            div_soccer += '<li class="menu2">';
                            div_soccer += '<a href="javascript:void(0)" class="st_marl10">';
                            div_soccer += '<img src="' + item.nation_img + '" width="15" style="margin-top:-4px;">'; 
                            div_soccer += item.nation_name;									
                            div_soccer += '<span class="f_right _center w35" style="margin-right:10px;">' + item.nation_cnt + '</span>';
                            div_soccer += '</a>';
                            div_soccer += '</li>';
                            div_soccer += '</ul>';
                            div_soccer += '<ul class="ul-soccer ul-soccer-' + item.nation_sn + ' sub-ul" style="display:none;">';
                            $.each(item.items, function(i, league){
                                div_soccer += `<li class="ss_bl1 li-bg" onClick="location.href='/game_list?game=abroad&sport=soccer&league_sn=` + league.league_sn + `&today=0'"`;
                                div_soccer += '<a href="javascript:void(0)">';
                                div_soccer += '<p class="txt_line1 _limit _w180 p-badge">' + league.league_name + '</p>';
                                div_soccer += '<span class="badge badge-info f_right _center w35 span-badge">' + league.league_cnt + '</span>';
                                div_soccer += '</a>';
                                div_soccer += '</li>';
                            });
                            div_soccer += '</ul>';
                            
                            $j(".div_soccer").append(div_soccer);
                            break;
                        case "농구":
                            var div_bask = "";
                            div_bask += '<ul class="li-bask" onclick=showLeagues("ul-bask-' + item.nation_sn + '")  style="display:none;">';
                            div_bask += '<li class="menu2">';
                            div_bask += '<a href="javascript:void(0)" class="st_marl10">';
                            div_bask += '<img src="' + item.nation_img + '" width="15" style="margin-top:-6px;">'; 
                            div_bask += item.nation_name;									
                            div_bask += '<span class="f_right _center w35" style="margin-right:10px;">' + item.nation_cnt + '</span>';
                            div_bask += '</a>';
                            div_bask += '</li>';
                            div_bask += '</ul>';
                            div_bask += '<ul class="ul-bask ul-bask-' + item.nation_sn + ' sub-ul" style="display:none;">';
                            $.each(item.items, function(i, league){
                                div_bask += `<li class="ss_bl1 li-bg" onClick="location.href='/game_list?game=abroad&sport=basketball&league_sn=` + league.league_sn + `&today=0'"`;
                                div_bask += '<a href="javascript:void(0)">';
                                div_bask += '<p class="txt_line1 _limit _w180 p-badge">' + league.league_name + '</p>';
                                div_bask += '<span class="badge badge-info f_right _center w35 span-badge">' + league.league_cnt + '</span>';
                                div_bask += '</a>';
                                div_bask += '</li>';
                            });
                            div_bask += '</ul>';
                            
                            $j(".div_bask").append(div_bask);
                            break;
                        case "야구":
                            var div_base = "";
                            div_base += '<ul class="li-base" onclick=showLeagues("ul-base-' + item.nation_sn + '")  style="display:none;">';
                            div_base += '<li class="menu2">';
                            div_base += '<a href="javascript:void(0)" class="st_marl10">';
                            div_base += '<img src="' + item.nation_img + '" width="15" style="margin-top:-6px;">'; 
                            div_base += item.nation_name;									
                            div_base += '<span class="f_right _center w35" style="margin-right:10px;">' + item.nation_cnt + '</span>';
                            div_base += '</a>';
                            div_base += '</li>';
                            div_base += '</ul>';
                            div_base += '<ul class="ul-base ul-base-' + item.nation_sn + ' sub-ul" style="display:none;">';
                            $.each(item.items, function(i, league){
                                div_base += `<li class="ss_bl1 li-bg" onClick="location.href='/game_list?game=abroad&sport=baseball&league_sn=` + league.league_sn + `&today=0'"`;
                                div_base += '<a href="javascript:void(0)">';
                                div_base += '<p class="txt_line1 _limit _w180 p-badge">' + league.league_name + '</p>';
                                div_base += '<span class="badge badge-info f_right _center w35 span-badge">' + league.league_cnt + '</span>';
                                div_base += '</a>';
                                div_base += '</li>';
                            });
                            div_base += '</ul>';
                            
                            $j(".div_base").append(div_base);
                            break;
                        case "아이스 하키":
                            var div_hock = "";
                            div_hock += '<ul class="li-hock" onclick=showLeagues("ul-hock-' + item.nation_sn + '")  style="display:none;">';
                            div_hock += '<li class="menu2">';
                            div_hock += '<a href="javascript:void(0)" class="st_marl10">';
                            div_hock += '<img src="' + item.nation_img + '" width="15" style="margin-top:-6px;">'; 
                            div_hock += item.nation_name;									
                            div_hock += '<span class="f_right _center w35" style="margin-right:10px;">' + item.nation_cnt + '</span>';
                            div_hock += '</a>';
                            div_hock += '</li>';
                            div_hock += '</ul>';
                            div_hock += '<ul class="ul-hock ul-hock-' + item.nation_sn + ' sub-ul" style="display:none;">';
                            $.each(item.items, function(i, league){
                                div_hock += `<li class="ss_bl1 li-bg" onClick="location.href='/game_list?game=abroad&sport=hockey&league_sn=` + league.league_sn + `&today=0'"`;
                                div_hock += '<a href="javascript:void(0)">';
                                div_hock += '<p class="txt_line1 _limit _w180 p-badge">' + league.league_name + '</p>';
                                div_hock += '<span class="badge badge-info f_right _center w35 span-badge">' + league.league_cnt + '</span>';
                                div_hock += '</a>';
                                div_hock += '</li>';
                            });
                            div_hock += '</ul>';
                            
                            $j(".div_hock").append(div_hock);
                            break;
                        case "배구":
                            var div_val = "";
                            div_val += '<ul class="li-val" onclick=showLeagues("ul-val-' + item.nation_sn + '")  style="display:none;">';
                            div_val += '<li class="menu2">';
                            div_val += '<a href="javascript:void(0)" class="st_marl10">';
                            div_val += '<img src="' + item.nation_img + '" width="15" style="margin-top:-6px;">'; 
                            div_val += item.nation_name;									
                            div_val += '<span class="f_right _center w35" style="margin-right:10px;">' + item.nation_cnt + '</span>';
                            div_val += '</a>';
                            div_val += '</li>';
                            div_val += '</ul>';
                            div_val += '<ul class="ul-val ul-val-' + item.nation_sn + ' sub-ul" style="display:none;">';
                            $.each(item.items, function(i, league){
                                div_val += `<li class="ss_bl1 li-bg" onClick="location.href='/game_list?game=abroad&sport=volleyball&league_sn=` + league.league_sn + `&today=0'"`;
                                div_val += '<a href="javascript:void(0)">';
                                div_val += '<p class="txt_line1 _limit _w180 p-badge">' + league.league_name + '</p>';
                                div_val += '<span class="badge badge-info f_right _center w35 span-badge">' + league.league_cnt + '</span>';
                                div_val += '</a>';
                                div_val += '</li>';
                            });
                            div_val += '</ul>';
                            
                            $j(".div_val").append(div_val);
                            break;
                    }
                });
            }
        });
    }

    $j(function(){ 
        var ww2 = window.innerWidth;
        if(ww2 <= 1200) {
            $j("#pc_betting_cart").empty();
        }else {
            $j("#mobile_betting_cart").empty();
        }
    });
    $j(window).resize(function() { 
        var ww2 = window.innerWidth;
        if(ww2 <= 1200) {
            $j("#pc_betting_cart").empty();
        }else {
            $j("#mobile_betting_cart").empty();
        }
    });

    $j(".icon-close").on("click", function(){
        $j(".mask_layer").click();
    });

    // 축구
    $j(".soc").on( "click", function() {
        console.log("축구");
        var submenu = $j(".li-soccer");
        var submenu1 = $j(".ul-soccer");


        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }

    });

    // 농구
    $j(".bask").on( "click", function() {
        
        var submenu = $j(".li-bask");
        var submenu1 = $j(".ul-bask");

        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }
    });

    // 야구
    $j(".base").on( "click", function() {
        
        var submenu = $j(".li-base");
        var submenu1 = $j(".ul-base");

        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }
    });

    // 아이스 하키
    $j(".hock").on( "click", function() {
        
        var submenu = $j(".li-hock");
        var submenu1 = $j(".ul-hock");

        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }
    });

    // 배구
    $j(".val").on( "click", function() {
        
        var submenu = $j(".li-val");
        var submenu1 = $j(".ul-val");

        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }
    });

    function showLeagues(className) {
        console.log(className);
        var submenu2 = $j("." + className);
        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu2.is(":visible") ){
            submenu2.slideUp("fast");
        }else{
            submenu2.slideDown("fast");
        }
    }
</script>
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


<!-- 레이어 팝업 -->
<div class="mask_layer" style="display:none;"></div>
<div class="popup_message" style="display:none;" onClick="location.href='/bbs/memo.php'">
	<div class="message_box">
		<img src="/10bet/images/10bet/img_message_01.png" />
		<span class="count01"></span>
		<span class="count02"></span>
	</div>
</div>

<!-- simple modal {{ -->
<link type='text/css' href='/10bet/simplemodal/css/basic.css' rel='stylesheet' media='screen' />
<script type='text/javascript' src='/10bet/simplemodal/js/jquery.simplemodal.js'></script>
<!-- simple modal }} -->
<script>
    var page_load_time="2021-01-11 19:44:42";
    function memo_polling(){
        $j.ajax({
            url: "/ajax.polling.php",
            type: 'POST',
            data: {
                t: page_load_time
            },
            dataType: 'json',
            success: function(data) {
                if( data["new_mail_count"]>0 ){
                    $j('#new_mail_count').html(data["new_mail_count"]);
                    if( typeof(ion) != "undefined" ) ion.sound.play("new_mail");
                    
                    $j(".mask_layer").show();
                    $j(".popup_message").show();
                    $j(".count01").html(data["new_mail_count"]+"개");
                    $j(".count02").html(data["new_mail_count"]+"개");
                    //var html = $j('#basic-modal-content').html().replace('{count}',data["new_mail_count"]);
                    //$j('#basic-modal-content').html(html).modal();
                    
                }else{
                    $j.modal.close();
                }
                if( data["auto_logout"] ){
                    if( data["auto_logout_desc"] ) warning_popup(data["auto_logout_desc"]);
                    document.location.href='/bbs/logout.php';
                    return;
                }
            }
        });
    }
</script>
<script language="javascript" src="/10bet/js/wrest.js"></script>
<!-- 새창 대신 사용하는 iframe -->
<iframe width=0 height=0 name='hiddenframe' style='display:none;'></iframe>
</body>
</html>
<!-- 사용스킨 : event -->
