<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="pragma" content="no-store">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <title>체스</title>
    <link rel="shortcut icon" href="/10bet/images/10bet/favicon.ico?v=1" type="image/x-icon">
    <link rel="icon" href="/10bet/images/10bet/favicon.ico?v=1" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/10bet/css/10bet/common.css?v=1610345910" />
    <link rel="stylesheet" type="text/css" href="/10bet/css/10bet/Scrollbar.css" />
    <link rel="stylesheet" type="text/css" href="/include/css/style.css?v=9" />
    <script type="text/javascript" src="/10bet/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="/10bet/js/common.js"></script>
    <script type="text/javascript">var $j = jQuery.noConflict(); jQuery.ajaxSetup({cache:false});</script>
    <script type="text/javascript" src="/10bet/js/jquery.lazyload.min.js"></script>
    <script type="text/javascript" src="/10bet/js/ion.sound.js"></script>
    <script type="text/javascript" src="/10bet/js/ajax.js?v=1"></script>
    <script type="text/javascript" src="/10bet/js/wsd.js"></script>

    <script type="text/javascript" src="/10bet/js/flash.js"></script>
    <script type="text/javascript" src="/10bet/js/jquery-animate-css-rotate-scale.js"></script>
    <script type="text/javascript" src="/10bet/js/10bet/Scrollbar.js"></script>
    <script type="text/javascript" src="/10bet/js/10bet/pub.js?v=1610345806"></script>
    <script type="text/javascript" src="/public/js/jBeep/jBeep.min.js"></script>
    
    <?php
        $vTime = time();
        if ( $_SERVER["REQUEST_URI"] == "/game_list?game=sadari" ) {
            echo "<script type=\"text/javascript\" src=\"/include/js/sadari.js?v={$vTime}\"></script>";
        } else if ( $_SERVER["REQUEST_URI"] == "/game_list?game=race" ) {
            echo "<script type=\"text/javascript\" src=\"/include/js/race.js?v={$vTime}\"></script>";
        } else if ( $_SERVER["REQUEST_URI"] == "/game_list?game=dari" ) {
            echo "<script type=\"text/javascript\" src=\"/include/js/dari.js?v={$vTime}\"></script>";
        } else {
            echo "<script type=\"text/javascript\" src=\"/include/js/sport.js?v={$vTime}\"></script>";
        }
        $isApi = isset($TPL_VAR["api"]) ? $TPL_VAR["api"] : "";
    ?>
    <script type="text/javascript" src="/include/js/common.js?v=<?=$vTime?>"></script>
    <script type="text/javascript" src="/include/js/include.js?v=<?=$vTime?>"></script>
</head>

<script type="text/javascript">
    var member_sn = "<?=$TPL_VAR["member_sn"]?>";
    var style_type = <?=$TPL_VAR["style_type"]?>;
    var api = '<?=$TPL_VAR["api"]?>';
    var uid = '<?=$TPL_VAR["uid"]?>';

    // F12 버튼 방지
    $j(document).ready(function(){
        $j(document).bind('keydown',function(e){
            if ( e.keyCode == 123 /* F12 */) {
                e.preventDefault();
                e.returnValue = false;
            }
        });
    });
</script>
<body  oncontextmenu='return false'>
    <a name="g4_head"></a>
    <script language="javascript">
        function setPng24(obj) {
            obj.width=obj.height=1;
            obj.className=obj.className.replace(/\bpng24\b/i,'');
            obj.style.filter ="progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"',sizingMethod='image');";
            obj.src='';
            return '';
        }
    </script>

    <script language="javascript">
        var x =0
        var y=0
        drag = 0
        move = 0
        window.document.onmousemove = mouseMove
        window.document.onmousedown = mouseDown
        window.document.onmouseup = mouseUp
        window.document.ondragstart = mouseStop
        function mouseUp() {
            move = 0
        }
        function mouseDown() {
            if (drag) {
                clickleft = window.event.x - parseInt(dragObj.style.left)
                clicktop = window.event.y - parseInt(dragObj.style.top)
                dragObj.style.zIndex += 1
                move = 1
            }
        }
        function mouseMove() {
            if (move) {
                dragObj.style.left = window.event.x - clickleft
                dragObj.style.top = window.event.y - clicktop
            }
        }
        function mouseStop() {
            window.event.returnValue = false
        }
        function Show(divid)
        {
            divid.filters.blendTrans.apply();
            divid.style.visibility = "visible";
            divid.filters.blendTrans.play();
        }
        function Hide(divid) {
            divid.filters.blendTrans.apply();
            divid.style.visibility = "hidden";
            divid.filters.blendTrans.play();
        }
    </script>
    <!-- <script type="text/javascript" src="/10bet/js/10bet/jquery-2.0.3.min.js"></script> -->
    <script type="text/javascript">
        jQuery.noConflict();
        var $j = jQuery;
    </script>

    <script type="text/javascript" src="/10bet/js/clock.js?20160309"></script> 
    
    <div id="loading">
        <img src="/10bet/images/10bet/loading.png">
    </div>
    <div id="betLoading" style="display:none;">
        <img src="/10bet/images/Spinner.svg">
        <div class="betting-span"><span>배팅중... <span id="bettingSecond">7</span>초</div>
    </div>
    <div id="coverBG"></div>
    <div id="coverBG2"></div>
    <!-- 레이어 팝업 -->
    <div id="warning_popup" class="popup_section" style="margin-top:-50px;margin-left:-160px;display:none;">
        <div class="pop_box">
            <h2>알림</h2>
            <span class="close_pop" onClick="warning_popup_close();"><img src="/10bet/images/10bet/ico_close_01.png" alt="창닫기" /></span>
            <div class="pop_message">
                잘못된 경로 입니다.
            </div>
        </div>
    </div>
    <!-- 배팅취소 팝업 -->
    <div id="betUserCancel_popup" class="popup_section" style="margin-top:-50px;margin-left:-160px;display:none;top:12%;">
        <div class="pop_box">
            <h2>알림</h2>
            <input type="hidden" id="betting_no" value="0">
            <input type="hidden" id="type" value="0">
            <div class="pop_message">
                정말 취소하시겠습니까?
            </div>
            <div class="btn-center">
                <button type="button" class="confirm-yes" id="btnConfirm">예</button>
                <button type="button" class="confirm-no" id="btnCancel">아니오</button>
            </div>
        </div>
    </div>
    <!-- 확인 팝업 -->
    <div id="confirm_popup" class="popup_section" style="margin-top:-50px;margin-left:-160px;display:none;top:12%;">
        <div class="pop_box">
            <h2>알림</h2>
            <div class="pop_message">
                정말 배팅하시겠습니까?
            </div>
            <div class="btn-center">
                <button type="button" class="confirm-yes">예</button>
                <button type="button" class="confirm-no">아니오</button>
            </div>
        </div>
    </div>
    <div id="sports_popup" class="popup_section" style="margin-top:-50px;margin-left:-160px;display:none;top:12%;width:310px;">
        <div class="pop_box" style="height:300px;">
            <h2>알림</h2>
            <div class="pop_message" style="height:200px; text-align:left;">
                정말 배팅하시겠습니까?
            </div>
            <div class="btn-center">
                <button type="button" class="confirm-yes confirmBetting">예</button>
                <button type="button" class="confirm-no confirmNoBetting">아니오</button>
            </div>
        </div>
    </div>
    <!-- 쪽지 팝업 -->
    <div id="memo_popup" class="popup_section" style="margin-top:-50px;margin-left:-160px;display:none;top:12%;">
        <div class="pop_box">
            <h2>알림</h2>
            <div class="pop_message">
            </div>
            <div class="btn-center">
                <button type="button" class="confirm-yes" onClick="location.href='/cs/cs_list'">예</button>
            </div>
        </div>
    </div>
    <!-- 레이어 팝업 -->
    <div class="mask_layer" style="display:none;"></div>
    <div class="popup_message" style="display:none;" onClick="location.href='/member/memolist'">
        <div class="message_box">
            <img src="/10bet/images/10bet/img_message_01.png">
            <span class="count01"></span>
            <span class="count02"></span>
        </div>
    </div>
    <!-- 관리자 배팅취소알림 팝업 -->
    <div id="betCancel_popup" class="popup_section" style="margin-top:-50px;margin-left:-160px;display:none;top:12%;">
        <div class="pop_box">
            <h2>알림</h2>
            <div class="pop_message">
                배팅이 취소된 경기가 있습니다.
            </div>
            <div class="btn-center">
                <button type="button" class="confirm-yes" id="confirmBetCancel">확인</button>
            </div>
        </div>
    </div>
    <form name="login" method="post" action="/loginProcess" onSubmit="return loginCheck();">
        <input type="hidden" name="sitecode" value="site-a">
        <input type="hidden" name="returl" value="<?php echo $TPL_VAR["returl"]?>">
        <div id="popup_login" class="popup_section" style="top:30%;margin-left:-160px;display:none;">
            <div class="pop_box">
                <span class="close_pop" onClick="login_popup_close();"><img src="/10bet/images/10bet/ico_close_01.png" alt="창닫기" /></span>
                <div class="login_box">
                    <h3>Member Login</h3>
                    <ul class="input_area">
                        <li><input type="text" name="uid" id="uid" placeholder="username" class="login01" /></li>
                        <li><input type="password" name="upasswd" id="upasswd" placeholder="password" class="password01" /></li>
                    </ul>
                    <br>
                    <div class="btn_login">
                        <button type="submit">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" name="next" action="/member/add" onSubmit="return check_pincode();">
        <div id="popup_register" class="popup_section" style="top:30%;margin-left:-160px;display:none;">
            <div class="pop_box">
                <span class="close_pop" onClick="login_popup_close();"><img src="/10bet/images/10bet/ico_close_01.png" alt="창닫기" /></span>
                <div class="login_box">
                    <h3>회원가입</h3>
                    <ul class="input_area">
                        <li>
                            <input type="text" class="login01 text-center" name="pincode" id="pincode" onkeyup="eng(this)" placeholder="가입코드를 입력하세요" required>
                        </li>
                    </ul>
                    <br>
                    <div class="btn_login">
                        <button id="agree_btn"  style="height:40px; font-size:25px;">확인</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="wrap">
        <!-- 해더 웹 -->
        <header style="display:<?=($isApi == "true") ? "none" : "block"?>;">
            <div class="header_box">
                <h1><a href="/"><img src="/10bet/images/10bet/logo_01.png?v01" alt="Chess 로고" /></a></h1>
                
                <div id="gnb">
                    <ul class="on">
                    <?php 
                        if(count((array)$_SESSION['member']) > 0) { ?>
                            <li  onClick="location.href='/game_list?game=multi'"><img src="/10bet/images/10bet/ico/top_ico1.png" alt="Chess 로고" />국내형</li>
                            <li  onClick="location.href='/game_list?game=abroad'"><img src="/10bet/images/10bet/ico/top_ico1.png" alt="Chess 로고" />유럽형</li>
                            <li  onClick="location.href='/game_list?game=live'"><img src="/10bet/images/10bet/ico/top_ico3.png" alt="Chess 로고" />라이브</li>
                            <!-- <li  onClick="warning_popup('준비중입니다.');"><img src="/10bet/images/10bet/ico/top_ico5.png" alt="Chess 로고" />가상게임</li> -->
                            <li  onClick="location.href='/game_list?game=power'"><img src="/10bet/images/10bet/ico/top_ico4.png" alt="Chess 로고" />미니게임</li>
                        <?php } else { ?>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico1.png" alt="Chess 로고" />국내형</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico1.png" alt="Chess 로고" />유럽형</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico3.png" alt="Chess 로고" />라이브</li>
                            <!-- <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico5.png" alt="Chess 로고" />가상게임</li> -->
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico4.png" alt="Chess 로고" />미니게임</li>
                        <?php 
                            }
                        ?>
						<!--
                        <li  onClick="location.href='/poker'"><img src="/10bet/images/10bet/ico/top_ico14.png" alt="Chess 로고" />포커</li>
                        <li  onClick="location.href='/graph'"><img src="/10bet/images/10bet/ico/top_ico7.png" alt="Chess 로고" />그래프</li>
                        -->
                        <?php 
                        if(count((array)$_SESSION['member']) > 0) { ?>
                            <li  onClick="warning_popup('준비중입니다.');"><img src="/10bet/images/10bet/ico/top_ico14.png" alt="Chess 로고" />카지노</li>
                            <li  onClick="warning_popup('준비중입니다.');"><img src="/10bet/images/10bet/ico/top_ico6.png" alt="Chess 로고" />슬롯머신</li>
                            <!-- <li  onClick="location.href='/race/game_result?view_type=winlose'"><img src="/10bet/images/10bet/ico/top_ico8.png" alt="Chess 로고" />경기결과</li> -->
                            <li  onClick="location.href='/race/betting_list'"><img src="/10bet/images/10bet/ico/top_ico9.png" alt="Chess 로고" />배팅내역</li>
                            <li  onClick="location.href='/cs/cs_list'"><img src="/10bet/images/10bet/ico/top_ico10.png" alt="Chess 로고" />고객센터</li>
                            <li  onClick="location.href='/board/'"><img src="/10bet/images/10bet/ico/top_ico11.png" alt="Chess 로고" />공지사항</li>
                            <li  onClick="location.href='/board/?bbsNo=7'"><img src="/10bet/images/10bet/ico/top_ico12.png" alt="Chess 로고" />이벤트</li>
                            <li  onClick="location.href='/board/?bbsNo=8'"><img src="/10bet/images/10bet/ico/top_ico13.png" alt="Chess 로고" />배팅규정</li>
                        <?php } else { ?>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico14.png" alt="Chess 로고" />카지노</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico6.png" alt="Chess 로고" />슬롯머신</li>
                            <!-- <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico8.png" alt="Chess 로고" />경기결과</li> -->
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico9.png" alt="Chess 로고" />배팅내역</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico10.png" alt="Chess 로고" />고객센터</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico11.png" alt="Chess 로고" />공지사항</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico12.png" alt="Chess 로고" />이벤트</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico13.png" alt="Chess 로고" />배팅규정</li>
                        <?php 
                            }
                        ?>
                        
                    </ul>
                    <div class="arrow_area">
                        <button class="button_type01" id="gnb_right">→</button>
                        <button class="button_type01" id="gnb_left">←</button>
                    </div>
                </div>
                
                <!-- 모바일 해더 메뉴 -->
                <div class="mobile_header">
                    <!-- 메뉴 아이콘 -->
                    <div class="menu_ico" id="mobile_menu_ico">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1">
                                <g id="surface1">
                                    <path d="M 0 7.5 L 0 12.5 L 50 12.5 L 50 7.5 Z M 0 22.5 L 0 27.5 L 50 27.5 L 50 22.5 Z M 0 37.5 L 0 42.5 L 50 42.5 L 50 37.5 Z "></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- 모바일 레프트 메뉴 -->
                    <div class="mobile_left_menu" id="mobile_left_menu">
                        <div class="icon-close" style="width:15px; height:15px; float:right; color: #aDaEa5;">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" class="svg-inline--fa fa-times fa-w-11">
                                <path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path>
                            </svg>
                        </div>
                        <div class="logo">
                            <a href="/"><img src="/10bet/images/10bet/logo_01.png?v01" alt="Chess 로고" /></a>
                        </div>
                        <ul class="menu02">
                            <?php 
                            if(count((array)$_SESSION['member']) > 0) { ?>
                                <li class="button_type01 " onClick="location.href='/game_list?game=multi'"><img src="/10bet/images/10bet/ico/top_ico_min1.png" alt="Chess 로고" />&nbsp;국내형스포츠</li>
                                <li class="button_type01 " onClick="location.href='/game_list?game=abroad'"><img src="/10bet/images/10bet/ico/top_ico_min1.png" alt="Chess 로고" />&nbsp;유럽형스포츠</li>
                                <li class="button_type01 " onClick="location.href='/game_list?game=live'"><img src="/10bet/images/10bet/ico/top_ico_min3.png" alt="Chess 로고" />&nbsp;라이브스포츠</li>
                                <!-- <li class="button_type01 " onClick="warning_popup('준비중입니다.');">가상게임</li> -->
                                <li class="button_type01 " onClick="location.href='/game_list?game=power'"><img src="/10bet/images/10bet/ico/top_ico_min4.png" alt="Chess 로고" />&nbsp;미니게임</li>
                                <li class="button_type01 " onClick="warning_popup('준비중입니다.');"><img src="/10bet/images/10bet/ico/top_ico_min14.png" alt="Chess 로고" />&nbsp;카지노</li>
                                <li class="button_type01 " onClick="warning_popup('준비중입니다.');"><img src="/10bet/images/10bet/ico/top_ico_min6.png" alt="Chess 로고" />&nbsp;슬롯머신</li>
                            <?php } else { ?>
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min1.png" alt="Chess 로고" />&nbsp;국내형스포츠</li>
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min1.png" alt="Chess 로고" />&nbsp;유럽형스포츠</li>
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min3.png" alt="Chess 로고" />&nbsp;라이브스포츠</li>
                                <!-- <li class="button_type01 " onClick="login_open();">가상게임</li> -->
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min4.png" alt="Chess 로고" />&nbsp;미니게임</li>
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min14.png" alt="Chess 로고" />&nbsp;카지노</li>
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min6.png" alt="Chess 로고" />&nbsp;슬롯머신</li>
                            <?php } ?>
                            

                            <!-- <li class="button_type01 " onClick="login_open();">포커</li>
                            <li class="button_type01 " onClick="login_open();">그래프</li> -->
                        </ul>
                        <ul class="menu02">
                            <?php 
                            if(count((array)$_SESSION['member']) > 0) { ?>
                                <!-- <li class="button_type01 " onClick="location.href='/race/game_result?view_type=winlose'">경기결과</li> -->
                                <li class="button_type01 " onClick="location.href='/race/betting_list'"><img src="/10bet/images/10bet/ico/top_ico_min9.png" alt="Chess 로고" />&nbsp;배팅내역</li>
                                <li class="button_type01 " onClick="location.href='/cs/cs_list'"><img src="/10bet/images/10bet/ico/top_ico_min10.png" alt="Chess 로고" />&nbsp;고객센터</li>
                                <li class="button_type01 " onClick="location.href='/board/'"><img src="/10bet/images/10bet/ico/top_ico_min11.png" alt="Chess 로고" />&nbsp;공지사항</li>
                                <li class="button_type01 " onClick="location.href='/board/?bbsNo=7'"><img src="/10bet/images/10bet/ico/top_ico_min12.png" alt="Chess 로고" />&nbsp;이벤트</li>
                                <li class="button_type01 " onClick="location.href='/board/?bbsNo=8'"><img src="/10bet/images/10bet/ico/top_ico_min13.png" alt="Chess 로고" />&nbsp;배팅규정</li>
                            <?php } else { ?>
                                <!-- <li class="button_type01 " onClick="login_open();">경기결과</li> -->
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min9.png" alt="Chess 로고" />&nbsp;배팅내역</li>
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min10.png" alt="Chess 로고" />&nbsp;고객센터</li>
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min11.png" alt="Chess 로고" />&nbsp;공지사항</li>
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min12.png" alt="Chess 로고" />&nbsp;이벤트</li>
                                <li class="button_type01 " onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico_min13.png" alt="Chess 로고" />&nbsp;배팅규정</li>
                            <?php 
                                }
                            ?>
                            
                        </ul>
                    </div>
                    
                    <!-- 유저 아이콘 -->
                    <div class="mobile_user_ico" id="user_menu_ico">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.822 18.096c-3.439-.794-6.64-1.49-5.09-4.418 4.72-8.912 1.251-13.678-3.732-13.678-5.082 0-8.464 4.949-3.732 13.678 1.597 2.945-1.725 3.641-5.09 4.418-3.073.71-3.188 2.236-3.178 4.904l.004 1h23.99l.004-.969c.012-2.688-.092-4.222-3.176-4.935z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- 모바일 레프트 메뉴 -->
                    <div class="mobile_user_section" id="mobile_user_section">
                        <div class="icon-close" style="width:15px; height:15px; float:left; color: #aDaEa5;">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" class="svg-inline--fa fa-times fa-w-11">
                                <path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path>
                            </svg>
                        </div>
                        <div class="logo"><a href="#none"><img src="/10bet/images/10bet/logo_01.png?v01" alt="Chess 로고" /></a></div>
                        <? if (count((array)$_SESSION['member']) > 0) {?>
                        <!-- 유저 정보 -->
                        <div class="user_box box_type02">
                            <div class="user_name" style="display:flex;">
                                <img class="img-height" src='/images/level_icon_<?php echo $TPL_VAR["level"]?>.png' >&nbsp; 
                                <p class="_limit _w100 p-name"><?=$TPL_VAR["nick"]?></p>
                                <span class="change" onClick="location.href='/member/member'">내 정보</span>
                            </div>
                            <div class="money">
                                <span class="head">
                                    <img src="/10bet/images/10bet/ico_01.png" alt="" /> 보유머니
                                </span> 
                                <span class="member_inmoney"><?php echo number_format($TPL_VAR["cash"],0)?></span>				
                            </div>
                            <div class="point">
                                <span class="head"><img src="/10bet/images/10bet/ico_01.png" alt="" /> 포인트</span> 
                                <span class="member_mileage"><?php echo number_format($TPL_VAR["mileage"],0)?></span>&nbsp;P						
                                <!-- <span class="change" onClick="mileage2Cash();">포인트전환</span> -->
                                <span class="change" onClick="location.href='/member/mileage?type=6'">포인트전환</span>
                            </div>
                            <div class="btn_list">
                                <button type="button" onClick="location.href='/member/memolist'">쪽지 <span><?php echo $TPL_VAR["new_memo_count"]?></span></button>
                                <!-- <button type="button" onClick="location.href='/bbs/bok.php'">복권 <span>1</span></button>
                                <button type="button" onClick="location.href='/bbs/coupon_list.php'">쿠폰 <span>0</span></button> -->
                                <button type="button" onClick="location.href='/calendar'">출석부</button>
                                <!-- <button type="button" onClick="location.href='/mypage.php'">추천인</button> -->
                                <!--<button type="button" onClick="location.href='/bbs/board.php?bo_table=z10'">1:1문의</button>-->
                                <button type="button" onClick="location.href='/logout'">로그아웃</button>
                            </div>
                            <button type="button" class="charge" onClick="location.href='/member/charge'">충전하기</button>
                            <button type="button" class="exchange" onClick="location.href='/member/exchange'">환전하기</button>
                        </div>
                        <? } else { ?>
                        <!-- 로그인 -->
                        <div class="user_box box_type02">
                            <h3>Member Login</h3>
                            <form name="login" method="post" action="/loginProcess" onSubmit="return loginCheck();">
                                <input type="hidden" name="sitecode" value="site-a">
                                <input type="hidden" name="returl" value="<?php echo $TPL_VAR["returl"]?>">
                                <div class="login_input">
                                    <input type="text" name="uid" id="uid" placeholder="아이디" />
                                    <input type="password" name="upasswd" id="upasswd" placeholder="비밀번호" />
                                </div>
                                <button type="submit" class="login" id="login_btn">로그인</button>
                                <button type="button" class="member_join" onClick="register_open();">회원가입</button>
                            </form>
                            <div class="btn_list">
                                <button onClick="login_open();" style="width:48%;">쪽지 <span>00</span></button>
                                <!-- <button>복권 <span>00</span></button>
                                <button>쿠폰 <span>00</span></button> -->
                                <button onClick="login_open();" style="width:48%;">출석부</button>
                                <!-- <button>추천인</button> -->
                                <!--<button>1:1문의</button>-->
                                <!-- <button type="button" onClick="location.href='/logout'">로그아웃</button> -->
                            </div>
                        </div>
                        <? } ?>
                        <div><a href="https://telegram.me/<?=$TPL_VAR["telegramID"]?>" target="_blank"><img src="/10bet/images/10bet/ico_telegram_01.gif" alt="텔레그램" /></a></div><br>
                        <div><img src="/10bet/images/10bet/kakao.png?v=2" alt="카카오톡 아이디"/><span style="position:relative; top:-47px; left:90px; color:#381e1e; font-size:25px; font-weight:bold;"><?=$TPL_VAR["kakaoID"]?></span></div><br>
                    </div>
                </div>
            </div>
        </header>
        <!-- <marquee scrollamount="3"><span style="line-height:normal;"><?=$TPL_VAR["ads"]?></span></marquee> -->

<?php
if ( $TPL_VAR["api"] != "true" && isset($TPL_VAR["popup_list"]) && count($TPL_VAR["popup_list"]) > 0 ) {
    $index = 0;
    $z_index = 900000;
    foreach ( $TPL_VAR["popup_list"] as $TPL_V1 ) {
        $checkCookie = "popup_".$TPL_V1["IDX"];
        if($TPL_V1["P_LOGIN_POPUP_U"] == "N" && count((array)$_SESSION['member']) > 0) {
            if ( !$_COOKIE[$checkCookie] ) { 
                if($TPL_VAR["checkAgent"] == "pc") {
                    $width = "450px";
                    $top = 95;
                    $left = 280 + $index * 450;
                } else {
                    $width = "100%";
                    $top = 0;
                    $left = 0;
                }
            ?>
            <div class="popup_section" id="<?php echo $checkCookie?>" style="position:absolute; left:<?=$left?>px;  top:<?=$top?>px; width:<?=$width?>; z-index:<?=$z_index?>;" onmouseover="dragObj=<?php echo $checkCookie?>; drag=1; move=0" onmouseout="drag=0">
                <div class="pop_box">
                    <h2>
                        <input type=checkbox name="gigan" value="1" onclick="setCookie('popup_'+<?php echo $TPL_V1['IDX']?>,'done',1); $j('#<?php echo $checkCookie?>').hide();" align=absmiddle> 
                        오늘하루 그만보기
                    </h2>
                    <span class="close_pop"><img src="/10bet/images/10bet/ico_close_01.png" alt="창닫기" onClick="$j('#<?php echo $checkCookie?>').hide();" /></span>
                    <span class="popup-content"><?php echo $TPL_V1["P_CONTENT"]?></span> 
                    <div class="event_img">
                        <img src="<?php echo $TPL_V1["P_FILE"];?>">   				    		
                    </div>
                </div>
            </div>
            <? 
                $index++;
                $z_index++;
                if($index == 3)
                    $index = 0;
            } 
        } else if ($TPL_V1["P_LOGIN_POPUP_U"] == "Y" && count((array)$_SESSION['member']) == 0) { 
            if ( !$_COOKIE[$checkCookie] ) {
                if($TPL_VAR["checkAgent"] == "pc") {
                    $width = "450px";
                    $top = 95;
                    $left = 280 + $index * 450;
                } else {
                    $width = "100%";
                    $top = 0;
                    $left = 0;
                }
            ?>
            <div class="popup_section" id="<?php echo $checkCookie?>" style="position:absolute; left:<?=$left?>px; top:<?=$top?>px; width:<?=$width?>; z-index:<?=$z_index?>;" onmouseover="dragObj=<?php echo $checkCookie?>; drag=1; move=0" onmouseout="drag=0">
                <div class="pop_box">
                    <h2>
                        <input type=checkbox name="gigan" value="1" onclick="setCookie('popup_'+<?php echo $TPL_V1['IDX']?>,'done',1); $j('#<?php echo $checkCookie?>').hide();" align=absmiddle> 
                        오늘하루 그만보기
                    </h2>
                    <span class="close_pop"><img src="/10bet/images/10bet/ico_close_01.png" alt="창닫기" onClick="$j('#<?php echo $checkCookie?>').hide();" /></span>
                    <span class="popup-content"><?php echo $TPL_V1["P_CONTENT"]?></span> 
                    <div class="event_img">
                        <img src="<?php echo $TPL_V1["P_FILE"];?>">   				    		
                    </div>
                </div>
            </div>
            <?php 
                $index++;
                $z_index++;
                if($index == 3)
                    $index = 0;
            }
        }
    }
}
?>
