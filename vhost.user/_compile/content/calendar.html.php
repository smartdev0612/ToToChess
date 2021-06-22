
<?php
    $is_enable_check = $TPL_VAR["is_enable_check"];
    $is_checked = $TPL_VAR["is_checked"];

    // get params
    $currMonth= date("m");
    $currYear = date("Y");
    $currDay = date("j");
    $startDate = strtotime($currYear . "-" . $currMonth . "-01 00:00:01");
    $startDay= date("N", $startDate);
    $monthName = date("M",$startDate );

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date("m", $startDate), date( "Y", $startDate));
    $endDate = strtotime($currYear . "-" . $currMonth . "-" .  $daysInMonth ." 00:00:01");

    $endDay = date("N", $endDate);

    // php date sunday is zero
    if ($startDay> 6)
        $startDay = 7 -$startDay;

    $currElem = 0;
    $dayCounter = 0;
    $firstDayHasCome = false;
    $arrCal = array();
    for($i = 0; $i <= 5; $i ++) {
        for($j= 0; $j <= 6; $j++) {
            // decide what to show in the cell
            if($currElem < $startDay && !$firstDayHasCome)
                $arrCal[$i][$j] = "";
            else if ($currElem == $startDay && !$firstDayHasCome) {
                $firstDayHasCome= true;
                $arrCal[$i][$j] = ++$dayCounter;
            }
            else if ($firstDayHasCome) {
                if ($dayCounter < $daysInMonth)
                    $arrCal[$i][$j] = ++ $dayCounter;
                else
                    $arrCal[$i][$j] = "";
            }

            $currElem ++;
        }
    }
?>

    <div class="mask"></div>
	<div id="container">
	
<script type="text/javascript">

    function MM_swapImgRestore() { //v3.0
        var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
    }
    function MM_preloadImages() { //v3.0
        var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
        var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
        if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
    }

    function MM_findObj(n, d) { //v4.01
        var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
        if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
        for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
        if(!x && d.getElementById) x=d.getElementById(n); return x;
    }

    function MM_swapImage() { //v3.0
        var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
        if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
    }

</script>

<body>


<style type="text/css">
    ul, li {list-style:none outside;}
    A {text-decoration:none;}
    .attendance_table { border:1px solid #000; border-radius:5px;background-color: rgba(32,32,32,0.8); }
    .attendance_table td { border:1px solid #000; }
    .attendance_table th{ border-bottom:1px solid #31ed61;background-color: rgba(52,52,52,0.8); height:50px; border-left:1px solid #000;}

    /* date */

    #date_layer {text-align:left;}

    #date_layer #box {width:252px; height:55px; text-align:center; display:block;  background: linear-gradient( to left, #34fc67, #04b757 );
        box-shadow: 1px 1px 1px #fff inset; border-radius:100px; margin:20px auto;}
    #date_layer #box .top {width:40px; float:left;line-height:60px; text-align:center; }
    #date_layer #box .day {width:170px; float:left;}

    #date_layer .w {line-height:55px;  font-size:26px; font-weight:bold;  color:#000;  }
    #date_layer .title {color:#fff; font-size:12px;  padding:0 0 0 0;}
    #date_layer .title1 {color:#5b82c7; font-size:12px;  padding:0 0 0 0;}
    #date_layer .title2 {color:#d82900; font-size:12px;  padding:0 0 0 0; }

    #date_layer .sun1 {color:#ff0000; font-size:12px; float:left;}
    #date_layer .sat1 {color:#007eff; font-size:12px; float:left;}
    #date_layer .day1 {color:#fff; font-size:12px; float:left;}

    #date_layer .sun2 {font-weight:bold; line-height:20px; color:#d82900; font-size:12px; float:left;}
    #date_layer .sat2 {font-weight:bold; line-height:20px; color:#000fd8; font-size:12px; float:left;}
    #date_layer .day2 {font-weight:bold; line-height:20px; color:#FF9933; font-size:12px; float:left;}

    #date_layer .sun3 {color:#d82900; font-size:11px; }
    #date_layer .sat3 {color:#000fd8; font-size:11px; }
    #date_layer .day3 {color:#999999; font-size:11px; }

    #date_layer .dot {color:#000000; font-size:12px; }

    #date_layer .check {color:#126420; font-size:11px; }
    #date_layer .check2 {color:#999999; font-size:11px; }


    /* list */
    #list_layer .input {width:600px; height:22px; background-color:#f3f3f3; border:0px; padding:5px 2px 2px 2px; font-weight:bold; color:#333333;  font-size:12px;}

    #list_layer .msg {padding:6px 0 0 3px; float:left;}
    #list_layer .sub {padding:5px 0 0 3px; float:left;}
    #list_layer .submit {padding:3px 0 0 5px; float:left;}

    #list_layer #info li {line-height:18px; color:#898989;  font-size:11px;}

    #list_layer .title {font-weight:bold; color:#333333;  font-size:12px;}
    #list_layer .list {line-height:20px; color:#898989;  font-size:11px;}

    #list_layer .no {line-height:25px; font-size:12px; color:#898989;}

    #list_layer .bgcolor0 {background-color:#ffffff;}
    #list_layer .bgcolor1 {background-color:#f1f1f1;}
    #list_layer .bgcolor2 {background-color:#ffffff;}
    .warning_bg { text-align:center;width:100%; height:86px; position:relative; border:1px solid #000; background: linear-gradient( to bottom, #000000, #000000, #317440 ); border-radius:300px; margin:20px 0;}
    .warning_bg2 {  width:1000px; height:220px; position:relative; margin:0 auto; text-align:center;}
    .warning_txt1 { position:absolute; top:25px; left:55px;}
    .warning_txt2  { font-size:20px; color:#fff; text-align:center; line-height:88px; padding-left:150px;}
    .warning_txt2 .red_text { color:#ff0000;font-size:20px; font-weight:bold;}
    .warning_txt2 .gr_text { color:#28ee51;font-size:20px;font-weight:bold;}
</style>
<script type="text/javascript" src="/10bet/js/left.js?1610709439"></script>
<script type="text/javascript">
    $j(document).ready(function(){
        <?php if($is_checked == 0) { ?>
            warning_popup("오늘 출석체크 하세요.");
        <?php } ?>
    });

    function moveMonth() {
        $j.ajax({
            type: 'POST',
            url: "calendarAjax.php?mov=",
            dataType : 'text',
            success: function(result) {
                if (result != null) {
                    $j('#calendarResualt').html(result);
                }
            },
            error: function(e) {
                warning_popup(e.responseText);
            }
        });
    };

    function chkDay(){
        $j.ajax({
            type: 'POST',
            url: "calendarAjax_proc",
            dataType : 'text',
            success: function(result) {
                console.log(result);
                result = result.trim();

                if (result == "OK") {
                    warning_popup('출석 체크 하셨습니다.');
                    location.reload();
                    //moveMonth();
                }else if (result == "ReOK") {
                    warning_popup('이미 출석 체크 하셨습니다.');
                    //moveMonth();
                }else if (result == "NoOK") {
                    warning_popup('출석 체크 실패하셨습니다.');
                    //moveMonth();
                }
            },
            error: function(e) {
                warning_popup(e.responseText);
            }
        });
    }
</script>
<div id="contents">
    <div class="board_box">
        <h2>출석부</h2>
        <div class="attend_box">
            <h3><img src="/10bet/images/10bet/title_attend_01.png" alt="출석부" /></h3>
            <div class="month">
                <?php echo $currYear.'년 '.$currMonth.'월'?>
            </div>
            <div class="attend_table">
                <table cellspacing="1" cellpadding="0">
                    <?php
                        $currElem = 0;
                        $dayCounter = 0;
                        $firstDayHasCome = false;

                        for($i = 0; $i <= 5; $i ++) {
                            echo "<tr>";
                            for($j= 0; $j <= 6; $j++) {
                                if($arrCal[$i][$j] == '')
                                {
                                    if($j == 0)
                                        echo ("<td align='center' valign='top' style=' border-top:1px solid #2c2d31;'><span class='sun3'></span>");
                                    else 
                                        echo ("<td align='center' valign='top' style='border-left:1px solid #2c2d31; border-top:1px solid #2c2d31;'><span class='day3'></span>");
                                } else {
                                    if($currDay == $arrCal[$i][$j])
                                    {
                                        echo ("<td align='center' valign='top' style='border-left:1px solid #2c2d31; border-top:1px solid #2c2d31; background-color: #00a2d8; opacity: 0.8;'>");
                                    } else {
                                        echo ("<td align='center' valign='top' style='border-left:1px solid #2c2d31; border-top:1px solid #2c2d31;'>");
                                    }
                                    echo ("<div style='padding:5px;'></div>");
                                    echo ("<div style='margin:10px;'>");
                                    if($currDay == $arrCal[$i][$j])
                                    {
                                        if($is_checked == 0)
                                        {
                                            if($is_enable_check == 0)
                                            {
                                                echo ("<a href=\"javascript:warning_popup('충전금액이 부족합니다.');\"><img src='/10bet/images/10bet/ico_attend_01.png'></a>");
                                            } else {
                                                echo ("<a href=\"javascript:chkDay();\"><img src='/10bet/images/10bet/ico_attend_01.png'></a>");
                                            }
                                        } else {
                                            echo ("<img src='/10bet/images/10bet/ico_attend_02.png'>");
                                        }
                                    } else {
                                        echo ("<img src='/10bet/images/10bet/ico_attend_01.png'>");
                                    }
                                    echo ('<span>'.$arrCal[$i][$j].'</span>');
                                    echo ('</div>');
                                }
                                echo ("</td>");
                            }
                            //echo("</div>\r\n");
                            echo "</tr>";
                        }

                    ?>
                </table>
            </div>
        </div>
    </div>
	<!-- 베팅카트 -->
	<!-- 모바일 푸터 메뉴 -->
	<div id="mobile_foot_menu">
		<ul class="foot_menu">
			<li><span class="ico_customer"><a href="https://t.me/tenbetkorea" target="_blank"><img src="/10bet/images/10bet/ico_telegram_01.png" alt="텔레그램" /></a></span></li>
			<li><span class="ico_customer"><a href="/bbs/board.php?bo_table=z10"><img src="/10bet/images/10bet/ico_customer_01.png" alt="고객문의" /></a></span></li>
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
		<form name="betForm" method="post"  action="../bbs/betting.php" onSubmit="return check(this)" style="margin:0px;">
            <input type="hidden" name="mode" value="cart">
            <input type="hidden" name="bo_table" value="">
            <input type="hidden" name="ca" value="">
            <input type="hidden" name="betcontent" value="0">
            <input type="hidden" name="strgametype" value="">
            <input type="hidden" name="sp_bets" value="">
            <input type="hidden" name="sp_totals" value="">
            <input type="hidden" name="b_type" value="">
            <div class="logo"><a href="#none"><img src="/10bet/images/10bet/logo_01.png" alt="IO BET 로고" /></a></div>
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
                        <li>보유머니<span>0 원</span></li>
                        <li>예상적중배당<span id="sp_bet">00.00</span></li>
                        <li>최대배팅금액<span>0</span></li>
                        <li>배팅금액<span><input type="text" name="betprice" id="betprice" value="" onKeyUp="cart_input(this,event)" onKeydown="if(event.keyCode == 13) return false;" value=""/> 원</span></li>
                        <li>예상적중금액<span id="sp_total">0</span></li>
                    </ul>
                    <div class="btn_list">
                        <button type="button" onClick="cart_money_input(1000)">+ 1,000</button>
                        <button type="button" onClick="cart_money_input(5000)">+ 5,000</button>
                        <button type="button" onClick="cart_money_input(10000)">+ 10,000</button>
                        <button type="button" onClick="cart_money_input(50000)">+ 50,000</button>
                        <button type="button" onClick="cart_money_input(100000)">+ 100,000</button>
                        <button type="button" onClick="cart_money_input(500000)">+ 500,000</button>
                        <button type="button" onClick="cart_money_clear()"><span>RESET</span></button>
                        <button type="button" onClick="cart_del_all();">초기화</button>
                    </div>
                    <div class="max_bet">
                        <button type="button" onClick="cart_max_input();return false">MAX BETTING</button>
                    </div>
                    <div class="bet_arae">
                        <button type="button" class="btn_bet" onClick="betting('betting')">배팅하기</button>
                        <button type="button" class="btn_del" onClick="cart_del_all()">전체삭제</button>
                    </div>
                </div>
            </div>
        </form>
	</div>
		
<!-- 모바일 하단 메뉴 -->
<script language='javascript'> var g4_cf_filter = ''; </script>
<script language='javascript' src='../js/filter.js'></script>
<script>
    function check(){
        var f = document.fwrite;
        var ex_point = f.wr_content.value.replace(/,/gi, "");
        //var mb_point = 0;
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
        //var mb_point = 0;
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

        /*if(f.wr_10.value == "환전신청")
        {
            f.wr_8.value = f.wr_8.value - f.wr_content.value;
        }*/
        
        //$j("#check_bg").show();	
        //$j("#submit_btn").hide();	
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
<script type="text/javascript">
    function dateGo(day) {
        document.location.href = "?d="+day;
    }
</script>