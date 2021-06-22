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
		<form name="betForm" method="post"  action="/race/bettingProcess" style="margin:0px;">
            <input type="hidden" value="betting" name="mode"> 
            <input type="hidden" name=strgametype> 
            <input type="hidden" name="gametype" value=<?=$bettype?>>
            <input type="hidden" name="game_type" value="<?php echo $TPL_VAR["game_type"]?>">
            <input type="hidden" name="special_type" value="<?php echo $TPL_VAR["special_type"]?>">
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
        <!-- 모바일 스포츠 리스트 -->
		<div class="sports_menu_list box_type01">
            <div>
                <h3>
                    오늘의 경기 
                    <span class="cor01">Today Match</span>
                    <span class="date"><?=date("Y-m-d");?></span>
                </h3>
                <ul class="main_left sports_league_ul">
                    <li>
                        <img src="/10bet/images/10bet/ico/football-ico.png" alt="ico" style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="/game_list?game=multi&sport=soccer" style="color: white;">
                        <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                            <span class="name">축구</span>
                            <?php
                                $bChk = false;
                                foreach($TPL_VAR["game_count_info"] as $info) {
                                    if($info['sport_name'] == '축구') {
                                        echo '<span class="count soc on">'.$info['nCnt'];
                                        $bChk = true;
                                    break;
                                    }
                                }
                                if(!$bChk) {
                                    echo 0;
                                }
                            ?></span>
                        </a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/basketball-ico.png" alt="ico"  style="margin-top:14px;">
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="/game_list?game=multi&sport=basketball" style="color: white;">
                        <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">농구</span>
                        <?php
                            $bChk = false;
                            foreach($TPL_VAR["game_count_info"] as $info) {
                                if($info['sport_name'] == '농구') {
                                    echo '<span class="count bask on">'.$info['nCnt'];
                                    $bChk = true;
                                break;
                                }
                            }
                            if(!$bChk) {
                                echo '<span class="count bask">0';
                            }
                        ?></span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/baseball-ico.png" alt="ico"  style="margin-top:14px;"/>
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="/game_list?game=multi&sport=baseball" style="color: white;">
                        <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">야구</span>
                        <?php
                            $bChk = false;
                            foreach($TPL_VAR["game_count_info"] as $info) {
                                if($info['sport_name'] == '야구') {
                                    echo '<span class="count base on">'.$info['nCnt'];
                                    $bChk = true;
                                break;
                                }
                            }
                            if(!$bChk) {
                                echo '<span class="count base">0';
                            }
                        ?></span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/hockey-ico.png" alt="ico" style="margin-top:14px;" /> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="/game_list?game=multi&sport=hockey" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">아이스하키</span>
                        <?php
                            $bChk = false;
                            foreach($TPL_VAR["game_count_info"] as $info) {
                                if($info['sport_name'] == '하키') {
                                    echo '<span class="count hock on">'.$info['nCnt'];
                                    $bChk = true;
                                break;
                                }
                            }
                            if(!$bChk) {
                                echo '<span class="count hock">0';
                            }
                        ?></span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/tennis-ico.png" alt="ico" style="margin-top:14px;" /> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="/game_list?game=multi&sport=tennis" style="color: white;">
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
                        <img src="/10bet/images/10bet/ico/handball-ico.png" alt="ico" style="margin-top:14px;" /> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="/game_list?game=multi&sport=handball" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">핸드볼</span>
                        <span class="count hand">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/motor-sport-ico.png" alt="ico" style="margin-top:14px;" /> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="/game_list?game=multi&sport=mortor" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">모터 스포츠</span>
                        <span class="count motor">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/rugby-league-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="/game_list?game=multi&sport=rugby" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">럭비</span>
                        <span class="count rub">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/speedway-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=multi&sport=criket" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">크리켓</span>
                        <span class="count cri">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/darts-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=multi&sport=darts" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?> 
                        <span class="name">다트</span>
                        <span class="count dart">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/volleyball-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=multi&sport=volleyball" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>

                        <span class="name">배구</span>
                        <?php
                            $bChk = false;
                            foreach($TPL_VAR["game_count_info"] as $info) {
                                if($info['sport_name'] == '배구') {
                                    echo '<span class="count val on">'.$info['nCnt'];
                                    $bChk = true;
                                break;
                                }
                            }
                            if(!$bChk) {
                                echo '<span class="count val">0';
                            }
                        ?></span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/futsal-ico.png" alt="ico"  style="margin-top:14px;"/>
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=multi&sport=futsal" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?> 
                        <span class="name">풋살</span>
                        <span class="count foot">00</span></a>
                    </li>
                    <li>
                        <img src="/10bet/images/10bet/ico/tabletennis-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=multi&sport=badminton" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">배드민턴</span>
                        <span class="count ton">00</span></a>
                    </li>
                    <li class="espo">
                        <img src="/10bet/images/10bet/ico/esport-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=multi&sport=esports" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">이스포츠</span>
                        <span class="count espo">00</span></a>
                    </li>
                    <li class="etc">
                        <img src="/10bet/images/10bet/logo_01.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=multi&sport=etc" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name">기타</span>
                        <span class="count etc">00</span></a>
                    </li>
                </ul>
			</div>
		</div>
    </div>
<script language='javascript'> var g4_cf_filter = ''; </script>
<script language='javascript' src='/10bet/js/filter.js'></script>
<script>
    function check(){
        var f = document.fwrite;
        var ex_point = f.wr_content.value.replace(/,/gi, "");
        //var mb_point = ;
        var mb_point = f.my_credit.value.replace(/,/gi, "");
        var min_point = 10000;
        if( f.wr_10.value == "환전신청" && ex_point != "")
        {
            if(parseInt(ex_point) > parseInt(mb_point)) {
                warning_popup('보유한 크레딧보다 더 신청하실 수 없습니다.');
                f.wr_content.value = "";
                f.wr_content.focus();
                return false;
            }

            if(ex_point < min_point) {
                warning_popup('10000원 이상만 환전신청을 하실 수 있습니다!')
                f.wr_content.value = "";
                f.wr_content.focus();
                return false;
            }
        }
        var pricecheck = parseInt(ex_point / 1000);
        pricecheck = pricecheck * 1000;
        if (pricecheck != ex_point)
        {
            warning_popup("금액은 천원단위로 입력하십시오.");
            f.wr_content.value = "";
            f.wr_content.focus();
            return false;
        }
    }

    function fwrite_check(f) {
        var s = "";
        check();
        if( f.wr_10.value == "" )
        {
            warning_popup("충/환전을 선택해주세요.");
            return false;
        }

        if( f.wr_content.value == "" )
        {
            warning_popup("요청금액을 입력해주세요.");
            return false;
        }
        for(var i=0; i < 2; i++)
        {
            f.wr_content.value = f.wr_content.value.replace(",", "");
        }

        if (s = word_filter_check(f.wr_content.value)) {
            warning_popup("내용에 금지단어('"+s+"')가 포함되어있습니다");
            return false;
        }

        if (document.getElementById('char_count')) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(document.getElementById('char_count').innerHTML);
                if (char_min > 0 && char_min > cnt) {
                    warning_popup("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    warning_popup("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        if (typeof(f.wr_key) != "undefined") {
            if (hex_md5(f.wr_key.value) != md5_norobot_key) {
                warning_popup("자동등록방지용 빨간글자가 순서대로 입력되지 않았습니다.");
                f.wr_key.focus();
                return false;
            }
        }

        var geditor_status = document.getElementById("geditor_wr_content_geditor_status");

        if (geditor_status != null)
        {
            if (geditor_status.value == "TEXT") {
                f.html.value = "html2";
            }
            else if (geditor_status.value == "WYSIWYG") {
                f.html.value = "html1";
            }
        }

        f.action = '/bbs/write_update.php';	return true;
    }
    function mcheck(){
        var f = document.mfwrite;
        var ex_point = f.wr_content.value.replace(/,/gi, "");
        //var mb_point = ;
        var mb_point = f.my_credit.value.replace(/,/gi, "");
        var min_point = 10000;
        if( f.wr_10.value == "환전신청" && ex_point != "")
        {
            if(parseInt(ex_point) > parseInt(mb_point)) {
                warning_popup('보유한 크레딧보다 더 신청하실 수 없습니다.')
                f.wr_content.value = "";
                f.wr_content.focus();
                return false;
            }

            if(ex_point < min_point) {
                warning_popup('10000원 이상만 환전신청을 하실 수 있습니다!')
                f.wr_content.value = "";
                f.wr_content.focus();
                return false;
            }
        }
        var pricecheck = parseInt(ex_point / 1000);
        pricecheck = pricecheck * 1000;
        if (pricecheck != ex_point)
        {
            warning_popup("금액은 천원단위로 입력하십시오.");
            f.wr_content.value = "";
            f.wr_content.focus();
            return false;
        }
    }

    function mfwrite_check(f) {
        var s = "";
        mcheck();
        if( f.wr_10.value == "" )
        {
            warning_popup("충/환전을 선택해주세요.");
            return false;
        }

        if( f.wr_content.value == "" )
        {
            warning_popup("요청금액을 입력해주세요.");
            return false;
        }
        for(var i=0; i < 2; i++)
        {
            f.wr_content.value = f.wr_content.value.replace(",", "");
        }

        if (s = word_filter_check(f.wr_content.value)) {
            warning_popup("내용에 금지단어('"+s+"')가 포함되어있습니다");
            return false;
        }

        if (document.getElementById('char_count')) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(document.getElementById('char_count').innerHTML);
                if (char_min > 0 && char_min > cnt) {
                    warning_popup("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    warning_popup("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        if (typeof(f.wr_key) != "undefined") {
            if (hex_md5(f.wr_key.value) != md5_norobot_key) {
                warning_popup("자동등록방지용 빨간글자가 순서대로 입력되지 않았습니다.");
                f.wr_key.focus();
                return false;
            }
        }

        var geditor_status = document.getElementById("geditor_wr_content_geditor_status");

        if (geditor_status != null)
        {
            if (geditor_status.value == "TEXT") {
                f.html.value = "html2";
            }
            else if (geditor_status.value == "WYSIWYG") {
                f.html.value = "html1";
            }
        }

        f.action = '/bbs/write_update.php';	return true;
    }
    function game_select(game,e) {
        get_casino_money(game);
        var text = $j(e).text();
        $j("#wr_subject").val(game);
        $j(".before_select").text(text);
        $j(".company_list").hide();
    }
    function game_select2(game,e) {
        var text = $j(e).text();
        $j("#wr_subject2").val(game);
        $j(".after_select").text(text);
        $j(".company_list").hide();
    }
    function get_casino_money(game) {
        $j.ajax({
            url: '/ajax.get_casino_money.php',
            type: 'POST',
            data: {'ptype' : game},
            dataType: 'json',
            success: function(data) {
                //$j("#have_money").val(data.money+"원");
                $j("#my_credit").val(data.money);
            }
        });
    }
</script>
<script>
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
			<p><br></p>
			<copyright>COPYRIGHT ⓒ <span>체스</span> ALL RIGHTS RESERVED.</copyright>
		</div>
	</foonter>
</div>
<!-- 레이어 팝업 -->

</form>
    
<div id="warning_popup" class="popup_section" style="margin-top:-50px;margin-left:-160px;display:none;">
	<div class="pop_box">
		<h2>알림창</h2>
		<span class="close_pop" onClick="warning_popup_close();"><img src="/10bet/images/10bet/ico_close_01.png" alt="창닫기" /></span>
		<div class="pop_message">
			잘못된 경로 입니다.
		</div>
	</div>
</div>

<div id="basic-modal">
    <!-- modal content -->
    <div id="basic-modal-content">
        <h3>알림</h3>
        <p style="padding-top:25px;">새로운 쪽지가 <font color="#2afd56">{count}건</font> 도착햇습니다.</p>
        <br />
        <p><a href='/bbs/memo.php' style="color:#2afd56; font-size:15px;"><img src="/10bet/images/icon_memo_tit.png" style=" vertical-align:top;" />&nbsp;쪽지보기</a></p>
    </div>
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
<script language="javascript" src="/10bet/js/wrest.js"></script>


</body>
</html>

