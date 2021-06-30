<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=euc-kr">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>체스</title>
    <link rel="shortcut icon" href="/10bet/images/10bet/favicon.ico?v=1" type="image/x-icon">
    <link rel="icon" href="/10bet/images/10bet/favicon.ico?v=1" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/10bet/css/10bet/common.css?v=1610345888" />
    <link rel="stylesheet" type="text/css" href="/10bet/css/10bet/Scrollbar.css" />
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
        } else if ( $_SERVER["REQUEST_URI"] == "/game_list?game=power" ) {
            echo "<script type=\"text/javascript\" src=\"/include/js/powerball.js?v={$vTime}\"></script>";
        } else if ( $_SERVER["REQUEST_URI"] == "/game_list?game=dari" ) {
            echo "<script type=\"text/javascript\" src=\"/include/js/dari.js?v={$vTime}\"></script>";
        } else {
            echo "<script type=\"text/javascript\" src=\"/include/js/sport.js??v={$vTime}\"></script>";
        }
    ?>
    <script type="text/javascript" src="/include/js/common.js?v=<?=$vTime?>"></script>
    <script type="text/javascript" src="/include/js/include.js?v=<?=$vTime?>"></script>
</head>

<script type="text/javascript">
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

    <style>
        .font_11{font-size:11px;font-family:돋움}
        .popup-content {
            margin: 10px;
        }
            
        .pagination {
            margin: 10px 0;
        }

        .pagination ul {
            display: inline-block;
            *display: inline;
            margin-bottom: 0;
            margin-left: 0;
            -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                    border-radius: 4px;
            *zoom: 1;
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .pagination ul > li {
            display: inline;
        }

        .pagination ul > li > a,
        .pagination ul > li > span {
            float: left;
            font-size: 1em;
            padding: 2px 8px;
            color: #22b486;
            line-height: 20px;
            text-decoration: none;
            border-left-width: 0;
        }

        .pagination ul > li > a:hover,
        .pagination ul > li > a:focus,
        .pagination ul > .active > a,
        .pagination ul > .active > span {
            background-color: #22b486;
            border-radius: 4px;
        }

        .pagination ul > .active > a,
        .pagination ul > .active > span {
            color: #000;
            cursor: default;
        }

        .pagination ul > .disabled > span,
        .pagination ul > .disabled > a,
        .pagination ul > .disabled > a:hover,
        .pagination ul > .disabled > a:focus {
            color: #fff;
            cursor: default;
            background-color: transparent;
        }

        .pagination ul > li:first-child > a,
        .pagination ul > li:first-child > span {
            border-radius: 4px;
        }

        .pagination ul > li:last-child > a,
        .pagination ul > li:last-child > span {
            border-radius: 4px;
        }

        .pagination-centered {
            text-align: center;
            font-size: 1.3em;
        }

        .name {
            vertical-align: top;
            font-size: 14px;
        }
        .menu2-a {
            color:white !important; 
            line-height:24px;
        }
        .menu2-img {
            vertical-align: middle;
        }
        .menu2-span {
            float:right; 
            margin-right:10px;
        }
        .p-badge {
            margin-top:7px !important;
            margin-right:10px !important;
        }
        .span-badge {
            float: right;
            margin-right:10px;
            margin-top:-5px;
            color:white;
        }
        .sub-ul {
            width:95% !important; 
            margin-left:13px !important;
        }
        .li-bg {
            background:#000 !important;
        }
        ._w180 {
            width: 140px;
        }
        ._limit {
            text-overflow:ellipsis;
            overflow:hidden;
            white-space:nowrap;
        }
        .text_line1{
            display:inline-block;
            height:15px;
        }

        .span-badge-abroad {
            margin-top:13px !important;
            margin-right:10px !important;
            color:white;
        }

        .btn-center {
            text-align: center;
        }

        .confirm-yes:hover {
            border: 1px solid #ff0000;
            background: #ff0000;
        }

        .confirm-yes {
            width: 20%;
            height: 30px;
            border: 1px solid #ff0012;
            background: #501a1a;
            border-radius: 3px;
            font-size: 12px;
            box-shadow: rgb(0 0 0 / 50%) 0px 2px 3px;
            margin-bottom: 10px;
            transition: 200ms all;
        }

        .confirm-no:hover {
            border: 1px solid #00bfff;
            background: #00bfff;
        }

        .confirm-no {
            width: 20%;
            height: 30px;
            border: 1px solid #00bfff;
            background: #1a4050;
            border-radius: 3px;
            font-size: 12px;
            box-shadow: rgb(0 0 0 / 50%) 0px 2px 3px;
            margin-bottom: 10px;
            transition: 200ms all;
        }

        .hidden-xs {
            display: block !important;
        }

        .hidden-sm {
            display: none !important;
        }

        .betting-cart-name {
            font-size: 0.74rem;
            text-align: left;
            width: 80%;
            float: left;
            line-height: 26px;
            color: #ffd200;
        }

        .lis {
            display: block;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .checkBtn {
            height: 40px;
            border: 1px solid #ff0012;
            background: #501a1a;
            border-radius: 3px;
            padding:5px;
            position: relative;
            top: -10px;
            margin-left:15px;
        }

        .checkBtn:hover {
            border: 1px solid #ff0000;
            background: #ff0000;
        }

        img {
            vertical-align: middle;
        }

        @media screen and (max-width: 900px) { 
            .hidden-xs {
                display: none !important;
            }

            .hidden-sm {
                display: block !important;
            }

            .main_minigame ul {
                height: 160px;
            }

            .main_minigame ul li .box01 .bottom01 {
                line-height: 30px;
            }
        }
    </style>
    <!-- <script type="text/javascript" src="/10bet/js/10bet/jquery-2.0.3.min.js"></script> -->
    <script type="text/javascript">
        jQuery.noConflict();
        var $j = jQuery;
    </script>

    
    <script type="text/javascript">
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

        function MM_swapImgRestore() { //v3.0
            var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
        }

        function MM_swapImage() { //v3.0
            var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
            if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
        }
    </script>
    <script type="text/javascript" src="/10bet/js/clock.js?20160309"></script> 
    
    <div id="loading">
        <img src="/10bet/images/10bet/loading.png">
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
    <!-- 확인 팝업 -->
    <div id="confirm_popup" class="popup_section" style="margin-top:-50px;margin-left:-160px;display:none;top:12%;">
        <div class="pop_box">
            <h2>알림</h2>
            <div class="pop_message">
                정말 배팅하시겠습니까?
            </div>
            <div class="btn-center">
                <button type="button" class="confirm-yes confirmBetting">예</button>
                <button type="button" class="confirm-no confirmNoBetting">아니오</button>
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
    <!-- 배팅취소알림 팝업 -->
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
        <header>
            <div class="header_box">
                <h1><a href="/"><img src="/10bet/images/10bet/logo_01.png?v01" alt="IO BET 로고" /></a></h1>
                
                <div id="gnb">
                    <ul class="on">
                    <?php 
                        if(count((array)$_SESSION['member']) > 0) { ?>
                            <li  onClick="location.href='/game_list?game=multi'"><img src="/10bet/images/10bet/ico/top_ico1.png" alt="IO BET 로고" />국내형</li>
                            <li  onClick="location.href='/game_list?game=abroad'"><img src="/10bet/images/10bet/ico/top_ico1.png" alt="IO BET 로고" />유럽형</li>
                            <li  onClick="location.href='/game_list?game=live'"><img src="/10bet/images/10bet/ico/top_ico3.png" alt="IO BET 로고" />라이브</li>
                            <!-- <li  onClick="warning_popup('준비중입니다.');"><img src="/10bet/images/10bet/ico/top_ico5.png" alt="IO BET 로고" />가상게임</li> -->
                            <li  onClick="location.href='/game_list?game=power'"><img src="/10bet/images/10bet/ico/top_ico4.png" alt="IO BET 로고" />미니게임</li>
                        <?php } else { ?>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico6.png" alt="IO BET 로고" />국내형</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico6.png" alt="IO BET 로고" />유럽형</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico9.png" alt="IO BET 로고" />라이브</li>
                            <!-- <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico5.png" alt="IO BET 로고" />가상게임</li> -->
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico4.png" alt="IO BET 로고" />미니게임</li>
                        <?php 
                            }
                        ?>
						<!--
                        <li  onClick="location.href='/poker'"><img src="/10bet/images/10bet/ico/top_ico14.png" alt="IO BET 로고" />포커</li>
                        <li  onClick="location.href='/graph'"><img src="/10bet/images/10bet/ico/top_ico7.png" alt="IO BET 로고" />그래프</li>
                        -->
                        <?php 
                        if(count((array)$_SESSION['member']) > 0) { ?>
                            <li  onClick="warning_popup('준비중입니다.');"><img src="/10bet/images/10bet/ico/top_ico6.png" alt="IO BET 로고" />카지노</li>
                            <!-- <li  onClick="location.href='/race/game_result?view_type=winlose'"><img src="/10bet/images/10bet/ico/top_ico8.png" alt="IO BET 로고" />경기결과</li> -->
                            <li  onClick="location.href='/race/betting_list'"><img src="/10bet/images/10bet/ico/top_ico9.png" alt="IO BET 로고" />배팅내역</li>
                            <li  onClick="location.href='/cs/cs_list'"><img src="/10bet/images/10bet/ico/top_ico10.png" alt="IO BET 로고" />고객센터</li>
                            <li  onClick="location.href='/board/'"><img src="/10bet/images/10bet/ico/top_ico11.png" alt="IO BET 로고" />공지사항</li>
                            <li  onClick="location.href='/board/?bbsNo=7'"><img src="/10bet/images/10bet/ico/top_ico12.png" alt="IO BET 로고" />이벤트</li>
                            <li  onClick="location.href='/game_guide'"><img src="/10bet/images/10bet/ico/top_ico13.png" alt="IO BET 로고" />배팅규정</li>
                        <?php } else { ?>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico6.png" alt="IO BET 로고" />카지노</li>
                            <!-- <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico8.png" alt="IO BET 로고" />경기결과</li> -->
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico9.png" alt="IO BET 로고" />배팅내역</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico10.png" alt="IO BET 로고" />고객센터</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico11.png" alt="IO BET 로고" />공지사항</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico12.png" alt="IO BET 로고" />이벤트</li>
                            <li  onClick="login_open();"><img src="/10bet/images/10bet/ico/top_ico13.png" alt="IO BET 로고" />배팅규정</li>
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
                            <a href="/"><img src="/10bet/images/10bet/logo_01.png?v01" alt="IO BET 로고" /></a>
                        </div>
                        <ul class="menu02">
                            <?php 
                            if(count((array)$_SESSION['member']) > 0) { ?>
                                <li class="button_type01 " onClick="location.href='/game_list?game=multi'">국내형</li>
                                <li class="button_type01 " onClick="location.href='/game_list?game=abroad'">유럽형</li>
                                <li class="button_type01 " onClick="location.href='/game_list?game=live'">라이브</li>
                                <!-- <li class="button_type01 " onClick="warning_popup('준비중입니다.');">가상게임</li> -->
                                <li class="button_type01 " onClick="warning_popup('준비중입니다.');">카지노</li>
                                <li class="button_type01 " onClick="location.href='/game_list?game=power'">미니게임</li>
                            <?php } else { ?>
                                <li class="button_type01 " onClick="login_open();">국내형</li>
                                <li class="button_type01 " onClick="login_open();">유럽형</li>
                                <li class="button_type01 " onClick="login_open();">라이브</li>
                                <!-- <li class="button_type01 " onClick="login_open();">가상게임</li> -->
                                <li class="button_type01 " onClick="login_open();">카지노</li>
                                <li class="button_type01 " onClick="login_open();">미니게임</li>
                            <?php } ?>
                            

                            <!-- <li class="button_type01 " onClick="login_open();">포커</li>
                            <li class="button_type01 " onClick="login_open();">그래프</li> -->
                        </ul>
                        <ul class="menu02">
                            <?php 
                            if(count((array)$_SESSION['member']) > 0) { ?>
                                <!-- <li class="button_type01 " onClick="location.href='/race/game_result?view_type=winlose'">경기결과</li> -->
                                <li class="button_type01 " onClick="location.href='/race/betting_list'">배팅내역</li>
                                <li class="button_type01 " onClick="location.href='/cs/cs_list'">고객센터</li>
                                <li class="button_type01 " onClick="location.href='/board/'">공지사항</li>
                                <li class="button_type01 " onClick="location.href='/board/?bbsNo=7'">이벤트</li>
                                <li class="button_type01 " onClick="location.href='/game_guide'">배팅규정</li>
                            <?php } else { ?>
                                <!-- <li class="button_type01 " onClick="login_open();">경기결과</li> -->
                                <li class="button_type01 " onClick="login_open();">배팅내역</li>
                                <li class="button_type01 " onClick="login_open();">고객센터</li>
                                <li class="button_type01 " onClick="login_open();">공지사항</li>
                                <li class="button_type01 " onClick="login_open();">이벤트</li>
                                <li class="button_type01 " onClick="login_open();">배팅규정</li>
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
                        <div class="logo"><a href="#none"><img src="/10bet/images/10bet/logo_01.png?v01" alt="IO BET 로고" /></a></div>
                        <? if (count((array)$_SESSION['member']) > 0) {?>
                        <!-- 유저 정보 -->
                        <div class="user_box box_type02">
                            <div class="user_name">
                                <img src='/images/level_icon_<?php echo $TPL_VAR["level"]?>.png' style="margin-top:6px;">&nbsp; <?=$TPL_VAR["nick"]?>
                            </div>
                            <div class="money">
                                <span class="head">
                                    <img src="/10bet/images/10bet/ico_01.png" alt="" /> 보유머니
                                </span> 
                                <span class="member_inmoney"><?php echo number_format($TPL_VAR["cash"],0)?></span>				
                            </div>
                            <div class="point">
                                <span class="head"><img src="/10bet/images/10bet/ico_01.png" alt="" /> 포인트</span> 
                                <span id="member_mileage"><?php echo number_format($TPL_VAR["mileage"],0)?></span>&nbsp;P						
                                <!-- <span class="change" onClick="mileage2Cash();">포인트전환</span> -->
                                <span class="change" onClick="location.href='/xpoint'">포인트전환</span>
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
                            <h3>Memer Login</h3>
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
<script>
    var member_sn = "<?=$TPL_VAR["member_sn"]?>";
    var style_type = <?=$TPL_VAR["style_type"]?>;
</script>
<?php
if ( isset($TPL_VAR["popup_list"]) && count($TPL_VAR["popup_list"]) > 0 ) {
    foreach ( $TPL_VAR["popup_list"] as $TPL_V1 ) {
        $checkCookie = "popup_".$TPL_V1["IDX"];
        if($TPL_V1["P_LOGIN_POPUP_U"] == "N" && count((array)$_SESSION['member']) > 0) {
            if ( !$_COOKIE[$checkCookie] ) { ?>
            <div class="popup_section" id="<?php echo $checkCookie?>" style="position:absolute; top:<?php echo $TPL_V1["P_WIN_TOP"]?>px; left:<?php echo $TPL_V1["P_WIN_LEFT"]?>px; width:<?php echo $TPL_V1["P_WIN_WIDTH"]?>px; height:<?php echo $TPL_V1["P_WIN_HEIGHT"]?>px; z-index:900000000;">
                <div class="pop_box">
                    <h2>
                        <input type=checkbox name="gigan" value="1" onclick="setCookie('popup_'+<?php echo $TPL_V1['IDX']?>,'done',1); $j('#<?php echo $checkCookie?>').hide();" align=absmiddle> 
                        오늘하루 그만보기
                    </h2>
                    <span class="close_pop"><img src="/10bet/images/10bet/ico_close_01.png" alt="창닫기" onClick="$j('#<?php echo $checkCookie?>').hide();" /></span>
                    <div style="width: 100%;height: 100%;background-image: url('<?php echo $TPL_V1["P_FILE"];?>'); background-repeat: no-repeat; background-position: center center; margin-bottom: 10px;" >
                        <span class="popup-content"><?php echo $TPL_V1["P_CONTENT"]?></span>    				    		
                    </div>
                </div>
            </div>
            <? } ?>
        <?php 
        } else if ($TPL_V1["P_LOGIN_POPUP_U"] == "Y" && count((array)$_SESSION['member']) == 0) { 
            if ( !$_COOKIE[$checkCookie] ) { ?>
            <div class="popup_section" id="<?php echo $checkCookie?>" style="position:absolute; top:<?php echo $TPL_V1["P_WIN_TOP"]?>px; left:<?php echo $TPL_V1["P_WIN_LEFT"]?>px; width:<?php echo $TPL_V1["P_WIN_WIDTH"]?>px; height:<?php echo $TPL_V1["P_WIN_HEIGHT"]?>px; z-index:900000000;">
                <div class="pop_box">
                    <h2>
                        <input type=checkbox name="gigan" value="1" onclick="setCookie('popup_'+<?php echo $TPL_V1['IDX']?>,'done',1); $j('#<?php echo $checkCookie?>').hide();" align=absmiddle> 
                        오늘하루 그만보기
                    </h2>
                    <span class="close_pop"><img src="/10bet/images/10bet/ico_close_01.png" alt="창닫기" onClick="$j('#<?php echo $checkCookie?>').hide();" /></span>
                    <div style="width: 100%;height: 100%;background-image: url('<?php echo $TPL_V1["P_FILE"];?>'); background-repeat: no-repeat; background-position: center center; margin-bottom: 10px;">
                        <span class="popup-content"><?php echo $TPL_V1["P_CONTENT"]?></span> 				    		
                    </div>
                </div>
            </div>
            <?php 
            }
        }
    }
}
?>
