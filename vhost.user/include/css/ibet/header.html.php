<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>DayTona </title>
<link rel="StyleSheet" type="text/css" href="/include/css/game.css">
<link rel="StyleSheet" type="text/css" href="/include/css/layout.css">

<link rel="StyleSheet" type="text/css" href="/include/css/ibet/style.css">

<link rel="StyleSheet" type="text/css" href="/include/css/ibet/style2.css?v03">
<link rel="stylesheet" type="text/css" href="/include/css/ibet/notyf.min.css">
<link href="https://fonts.googleapis.com/css?family=Michroma" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/include/css/ibet/gamestyle_n.css" type="text/css">

<script language="javascript" type="text/javascript" src="/include/js/ibet/gamescript_n.js"></script>
<script type="text/javascript" src="/include/js/ibet/js.js"></script>
<script type="text/javascript" src="/include/js/ibet/jsEmbedObject.js"></script>
<script language="Javascript" src="/include/js/ibet/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="/include/css/ibet/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="/include/css/ibet/mypage.css">
<link rel="stylesheet" type="text/css" href="/include/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/include/css/ibet/sweetalert.css">
<link rel="stylesheet" type="text/css" href="/include/css/ibet/perfect-scrollbar.min.css">

<script type="text/javascript" src="/include/js/ibet/jquery-ui.min.js"></script>
<script type="text/javascript" src="/include/js/ibet/jquery.simplyscroll.js"></script>
<script type="text/javascript" src="/include/js/ibet/jquery.totemticker.js"></script>


<script type="text/javascript">
    jQuery.noConflict();
    var jq$ = jQuery;
</script>
<script type="text/javascript" src="/include/js/common.js?v=<?=$vTime?>"></script>
<script type="text/javascript" src="/include/js/ibet/sweetalert.min.js?1"></script>


<script type="text/javascript" src="/include/js/ibet/html/prototype.js"></script>
<script language="javascript" src="/include/js/ibet/commonscript.js"></script>

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
<script type="text/javascript" src="/include/js/jquery.animateNumber.min.js"></script>

<script>
    WebFontConfig = {
        google: { families: [ 'Raleway:400,100,200,300,600,700,800,900,500:latin', 'Ubuntu:400,700italic,700,500italic,500,400italic,300italic,300:latin', 'Abel::latin' ] }
    };
    (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();



    jq$(window).load(function() {
        jq$("#loading").fadeOut("fast");
    })

    jq$(function(){
        jq$('#vertical-ticker').totemticker({
            row_height	:	'35px',
            next		:	'#ticker-next',
            previous	:	'#ticker-previous',
            stop		:	'#stop',
            start		:	'#start',
            mousestop	:	true,
        });
    });

    function MME(EW){
        document.MMPOPUP.SetVariable("_MMF",EW);
    }
    function getData(serverURL, objID) {
        new Ajax.Updater(objID,serverURL,{asynchronous:true, evalScripts:true});
    }
    /*var Connect_User=function(COIN){
        //document.TitleMovie.SetVariable('_Param',COIN);
        AlarmFade.style.display = "block";
        AlarmPage.location.replace('./Alarm.php?view=3&coin='+COIN);
    };*/
    var Connect_Point=function(Point){
        document.TitleMovie.SetVariable('_Point',Point);
    };
    /*var Connect_Cus=function(CUS){
        //document.TitleMovie.SetVariable('_Cus',CUS);
        AlarmFade.style.display = "block";
        AlarmPage.location.replace('./Alarm.php?view=1');
    };*/
    /*var Connect_Newmemo=function(Val){
        //document.TitleMovie.SetVariable('_MemoUpdate',Val);
        AlarmFade.style.display = "block";
        AlarmPage.location.replace('./Alarm.php?view=2');
    };*/
    var Money_Update=function(Val){
        //document.TitleMovie.SetVariable('_MoneyUpdate',Val);
        document.Pointcy.MoneyVal.value = Val;
    };
    var Point_Update=function(Val){
        //document.TitleMovie.SetVariable('_PointUpdate',Val);
        document.Pointcy.UserPointVal.value = Val;
    };
    //var LoginChk=function(){
    //    alert("서버와의 연결이 종료 되었습니다.");
    //    document.location.replace('./?mode=logout&PgSet=login');
    //};
    /*var ftom=function(){getData('./html/connect.php','ok');};*/
    //setInterval('ftom()',30000);

    function xypos(){
        posY = (document.StateFade) ? e.pageY :
            document.body.scrollTop+event.clientY
    }
    document.onmousemove = xypos;
    function StateView(BID,UID,HOME,AWAY,GAME){
        //if(StateFade.style.display == "none"){
        StateFade.style.top = posY-300;
        StateFade.style.display = "block";
        StatePage.location.replace('./stats/?NO='+BID+'&UID='+UID+'&HOME='+HOME+'&AWAY='+AWAY+'&GAMECAT='+GAME);
        //}else{
        //	StateFade.style.display = "none";
        //	StatePage.location.replace('about:blank');
        //}
    }
    function StateClose(){
        StateFade.style.display = "none";
        StatePage.location.replace('about:blank');
    }
    function CMoney_Update(val){ //20120116
        var f=document.CPointF;
        f.CPoint.value = val;
        document.getElementById("CPoint_txt").innerHTML = val;
        document.getElementById("left_usr_money").innerHTML = val;

    }
    function btClose(){
        textFade.style.display = "none";
    }
    function btView() {
        textFade.style.display = "block";
    }
    function PopupClose(){
        PopupFade.style.display = "none";
    }
    function PopupView(){
        //view('PopupFade');
        //PopupFade.style.display = "block";
    }
    function CategoryView(){
        if(GameCategory.style.display == "none"){
            GameCategory.style.display = "block";
        }else{
            GameCategory.style.display = "none";
        }
    }
    function GameMore(lot){
        var btn = document.getElementById('GameMore_Btn');
        for(i=0;i<lot;i++){
            var n = document.getElementById('GameMore_'+i);
            if(n!=null){
                n.style.display = "block";
            }
        }
        btn.style.display = "none";
    }
    function Alarm_Close(){
        AlarmPage.location.replace('about:blank');
        AlarmFade.style.display = "none";
    }
    var Point	=	false;
    function applyPoint(){
        var PointForm = document.Pointcy;
        if(Point){
            alert("포인트전환이 진행중입니다.\n잠시만 기다려 주십시오.");
            return;
        }

        if(PointForm.UserPoint.value < 1){
            alert("1 포인트 이상 가능합니다.");
            return;
        }
        if(!confirm("포인트를 머니로 전환 하시겠습니까?")){
            return;
        }
        Point	=	true;

        PointForm.mode.value="write";
        PointForm.PgSet.value="applyPoint";
        PointForm.page.value="";
        PointForm.action	=	"./";
        PointForm.target = "hiddenframe";
        PointForm.submit();

    }

    var tmpX = screen.width;
    var tmpY = screen.height;
    function setSize(id, h){
        var obj = document.getElementById(id);
        obj.height = h;
    }
    function ResizeWin(){
        self.moveTo(0,0);
        self.resizeTo(tmpX,tmpY);
    }
    function winClose(){
        top.window.opener = top;
        top.window.open('','_parent','');
        top.window.close();
    }
    function login(){
        window.alert('로그인후 이용 가능합니다.');
    }
    function PgTop(){
        document.location.href('#PG');
    }
    function ReDirect(){
        var Popinterval = 10000; // 인터벌 시간
        setInterval("ReDirectHome();",Popinterval);
    }
    //document.getElementById("bodywrap").focus();


    function MM_preloadImages() { //v3.0
        var d=document;
        if(d.images){
            if(!d.MM_p)
                d.MM_p=new Array();
            var i, j=d.MM_p.length, a= MM_preloadImages.arguments;
            for(i=0; i<a.length; i++)
                if (a[i].indexOf("#")!=0){
                    d.MM_p[j]=new Image;
                    d.MM_p[j++].src=a[i];
                }
        }
    }
    if (!parent.bottomFrame || parent.bottomFrame.closed){
        //parent.location.replace('/');
    }
    function leftTime(time){
        var nt = new Date();
        var lt = time*1000 - nt;
        lt = lt / 1000;
        d = parseInt(lt / 86400);
        h = parseInt((lt % 86400) / 3600);
        m = parseInt((lt % 3600) / 60);
        s = parseInt((lt % 60));
        return d + "일 " + h + ":" + m + ":" + s;
    }
    function echoLeftTime(id, time){
        var tmp = document.getElementById(id);
        var time = leftTime(time);
        tmp.innerHTML = time;
    }

    function fncInit(tbA,tbB,tbM,sizeA,sizeB,sizeM){
        var tb_A  = document.getElementById(tbA);
        var tb_B  = document.getElementById(tbB);
        var tb_M  = document.getElementById(tbM);
        var img_A  = document.getElementById(tbA+'_img');
        var img_B  = document.getElementById(tbB+'_img');
        var img_M  = document.getElementById(tbM+'_img');

        if(sizeA != 0){ tb_A.width = sizeA+'%';img_A.src = '/images/ibet/grp_a_rotate.gif';} else {img_A.src = '/images/ibet/blank.gif'; }
        if(sizeB != 0){ tb_B.width = sizeB+'%';img_B.src = '/images/ibet/grp_b.gif';} else {img_B.src = '/images/ibet/blank.gif'; }
        if(tb_M!=null){
            //if(sizeM != 0) tb_M.width = sizeM+'%'; else tb_M.width = '1%';
            if(sizeM != 0) {tb_M.width = sizeM+'%';img_M.src = '/images/ibet/grp_m.gif';} else {img_M.src = '/images/ibet/blank.gif'; }
        }

        var text_A  = document.getElementById(tbA+'_text');
        var text_B  = document.getElementById(tbB+'_text');
        var text_M  = document.getElementById(tbM+'_text');

        text_A.value = sizeA+'%';
        text_B.value = sizeB+'%';
        if(text_M!=null){
            text_M.value = sizeM+'%';
        }
    }

    //카트아이콘 ->
    if(typeof document.compatMode!='undefined'&&document.compatMode!='BackCompat'){
        cot_t1_DOCtp="_top:expression(document.documentElement.scrollTop+document.documentElement.clientHeight-this.clientHeight);_left:expression(document.documentElement.scrollLeft + document.documentElement.clientWidth - offsetWidth);}";
    }else{
        cot_t1_DOCtp="_top:expression(document.body.scrollTop+document.body.clientHeight-this.clientHeight);_left:expression(document.body.scrollLeft + document.body.clientWidth - offsetWidth);}";
    }
    var windowWidth = jq$( window ).width();
    var cart_bodyCSS='* html {background:#fff1b8;}';
    var cart_fixedCSS='#cart_fixed{position:fixed;';
    var cart_fixedCSS=cart_fixedCSS+'_position:absolute;';
    var cart_fixedCSS=cart_fixedCSS+'z-index:4;';
    var cart_fixedCSS=cart_fixedCSS+'width:100%;';
    var cart_fixedCSS=cart_fixedCSS+'top:255px;';
    if(windowWidth < 1830){
        var cart_fixedCSS=cart_fixedCSS+'right:10px;';
    }else{
        var cart_fixedCSS=cart_fixedCSS+'right:50%;';
        var cart_fixedCSS=cart_fixedCSS+'margin-right:-690px;';
    }
    var cart_fixedCSS=cart_fixedCSS+'clip:rect(0 100% 100% 0);';
    var cart_fixedCSS=cart_fixedCSS+cot_t1_DOCtp;
    document.write('<style type="text/css">'+cart_bodyCSS+cart_fixedCSS+'</style>');

    //카트 ->
    if(typeof document.compatMode!='undefined'&&document.compatMode!='BackCompat'){
        cot_t2_DOCtp="_top:expression(document.documentElement.scrollTop+this.clientHeight-this.clientHeight);_left:expression(document.documentElement.scrollLeft + document.documentElement.clientWidth - offsetWidth);}";
    }else{
        cot_t2_DOCtp="_top:expression(document.body.scrollTop+this.clientHeight-this.clientHeight);_left:expression(document.body.scrollLeft + document.body.clientWidth - offsetWidth);}";
    }
    var windowWidth = jq$( window ).width();
    var menu_bodyCSS='* html {background:#fff1b8;}';
    var menu_fixedCSS='#menu_fixed{position:fixed;';
    var menu_fixedCSS=menu_fixedCSS+'_position:absolute;';
    var menu_fixedCSS=menu_fixedCSS+'z-index:4;';
    var menu_fixedCSS=menu_fixedCSS+'width:100%;';
    //var menu_fixedCSS=menu_fixedCSS+'top:255px;';
    if(windowWidth < 1830){
        var menu_fixedCSS=menu_fixedCSS+'right:10px;';
    }else{
        var menu_fixedCSS=menu_fixedCSS+'right:50%;';
        var menu_fixedCSS=menu_fixedCSS+'margin-right:-910px;';
    }
    var menu_fixedCSS=menu_fixedCSS+'clip:rect(0 100% 100% 0);';
    var menu_fixedCSS=menu_fixedCSS+cot_t2_DOCtp;
    document.write('<style type="text/css">'+menu_bodyCSS+menu_fixedCSS+'</style>');
    function cartView() {
        var mp = document.getElementById('menu_fixed');
        var bp = document.getElementById('cart_fixed');
        if(mp.style.display == "none"){
            mp.style.display = "block";
            bp.style.display = "none";
        }else{
            mp.style.display = "none";
            bp.style.display = "block";
        }
    }

    function fncOnload(){
        setTimeout(fncSetTop,1000);
    }
    function fncSetTop(){
        document.documentElement.scrollTop = 0;
    }
</script>
<style type="text/css">* html {background:#fff1b8;}#cart_fixed{position:fixed;_position:absolute;z-index:4;width:100%;top:255px;right:50%;margin-right:-690px;clip:rect(0 100% 100% 0);_top:expression(document.body.scrollTop+document.body.clientHeight-this.clientHeight);_left:expression(document.body.scrollLeft + document.body.clientWidth - offsetWidth);}</style><style type="text/css">* html {background:#fff1b8;}#menu_fixed{position:fixed;_position:absolute;z-index:4;width:100%;right:50%;margin-right:-910px;clip:rect(0 100% 100% 0);_top:expression(document.body.scrollTop+this.clientHeight-this.clientHeight);_left:expression(document.body.scrollLeft + document.body.clientWidth - offsetWidth);}</style>
<style>
    body, html{
        color:#EAEAEA;
        text-decoration:none; word-break:break-all;
        margin:0px auto;
        margin:0px auto;
        background-color:#000;
        height:100%;
        width:100%;
        min-width:1280px;
        font-family: 'Nanum Gothic', sans-serif;
        background:url('/images/ibet/body_background.jpg?v02');
        background-attachment: fixed;
        background-position: center center;
        background-size: 100% 100%;
    }
	.money_bbg {
	position:absolute;
	width:195px;
	height:31px;
	top:0px;
	right:380px;
	display:inline-block; 
	cursor:pointer; 
	color:#95c0ff; 
	font-weight:700; 
	font-size:10px;
	padding:5px 0px 0px 0px;
	text-align:center;
	background:url('/images/ibet/money_bg.png');
	transition: all 0.3s;
}
.money_bbg:hover {
	background:url('/images/ibet/money_bg2.png');
	transition: all 0.3s;
}

    .remain_time
    {
        display: block;
        color: #ffce25;
        font-size: 50px;
        padding: 0px 0 5px;
        line-height: 30px;
        font-family: 'Noto Sans',맑은 고딕,'Malgeun Gothic','맑은 고딕',dotum;
    }
    /*.game_info {
        text-align: center;
        font-size: 16px;
        float: left;
        width: 100%;
        height: 105px;
        margin: 4px;
        line-height: 30px;
        background: #1B1B1B;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        overflow: hidden;
    }*/
    /*.btn_refresh{
        width: 108px;
        height: 32px;
        background: url(/images/ibet/ladder_img.png) -206px -79px;
        display: block;
        text-indent: -99999px;
        margin: 20px auto 0;
        display: block;
    }*/
    .incontent {
        background: #071821;
        width: 100%;
        padding: 3px;
        margin: 0;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px;
    }

    .incontent_bl {
        background: #071821;
        width: 100%;
        padding: 10px;
        margin: 0;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px;
        *opacity :0.8;
    }

    .incontent_in {
        background: #071821;
        width: 1160px;
        padding: 3px;
        margin: 0px;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px;
    }
    .incontent_f {
        background: #FFFFFF;
        width: 1160px;
        padding: 3px;
        margin: 0;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px;
    }
    .menu_fixed {
        background: #06141C;
        width: 100%;
        padding: 0px;
        margin: 0px;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px;
        *opacity:0.9;
        border : 2px solid #69C291;
    }
    .cart_fixed {
        width: 100%;
        padding: 0px;
        margin: 0px;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px;
        *opacity:0.9;
        border : 2px solid #C6EAD8;
        background: #68C190;
        background: -moz-linear-gradient(top,  #68C190 0%, #2B7550 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  #68C190 0%,#2B7550 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  #68C190 0%,#2B7550 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#68C190', endColorstr='#2B7550',GradientType=0 ); /* IE6-9 */
    }
    .input {
        font-family: 'Proxima Nova', Arial, sans-serif;
        color: #000000;
        font-size:16px;
        background: #FFFFFF;
        border: 2px solid #69C291;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        margin: 0; padding: 2px;
    }
    .shadow {box-shadow: 0px 0px 10px 0px #000000}
    .shadow1 {box-shadow: 0px 0px 25px 0px #000000}
    .shadow2 {box-shadow: 0px 0px 4px -1px #777777}
</style>
</head>


<body id="main" oncontextmenu="return true" ondragstart="return false" onselectstart="return false" style="">
<div>
    <style>
        .game_more_btn {
            animation-duration: 1s;
            animation-iteration-count: infinite;
            animation-name: slidein;
        }
        @keyframes slidein {
            0% {
                color:#ff6600;
            }

            50% {
                color:#000000;
            }
            100% {
                color:#ff6600;
            }
        }


        .ajax_type {
            display:none;
            position:relative;
            margin-bottom:0px;
            -webkit-box-shadow: 0px 0px 100px 0px rgba(0,0,0,0.3);
            -moz-box-shadow: 0px 0px 100px 0px rgba(0,0,0,0.3);
            box-shadow: 0px 0px 100px 0px rgba(0,0,0,0.3);
            margin:20px 0px 70px 0px;
        }
        .ajax_type .ajax_type_top {
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+0,f3f3f3+50,ededed+51,ffffff+100;White+Gloss+%232 */
            background: #ffffff; /* Old browsers */
            background: -moz-linear-gradient(top,  #ffffff 0%, #f3f3f3 50%, #ededed 51%, #ffffff 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(top,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
            border-width:5px 0px 0px 0px;
            border-style:solid;
            border-color:#2d5191;
        }
        .ajax_type_son {
            padding:15px;
            position:relative;
        }
        .ajax_type_top {
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+0,f3f3f3+50,ededed+51,ffffff+100;White+Gloss+%232 */
            background: #ffffff; /* Old browsers */
            background: -moz-linear-gradient(top,  #ffffff 0%, #f3f3f3 50%, #ededed 51%, #ffffff 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(top,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom,  #ffffff 0%,#f3f3f3 50%,#ededed 51%,#ffffff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */

        }
        .ajax_type_close {
            cursor:pointer;
        }
        .sort_tab {
            background:#f0f0f0;
            color:#666666;
            padding:5px 10px 5px 10px;
            margin-right:10px;
            border-radius:3px 3px 3px 3px;
            border:1px solid #888888;
            margin-bottom:5px;
            font-size:12px;
            font-family:Nanum Gothic;
            font-weight:700;
            cursor:pointer;
        }
        .sort_tab:hover{
            background:#ffffff;
        }
        .sort_tab_on {
            background:#406fc0;
            color:#ffffff;
            padding:5px 10px 5px 10px;
            margin-right:10px;
            border-radius:3px 3px 3px 3px;
            border:1px solid #406fc0;
            margin-bottom:5px;
            font-size:12px;
            font-family:Nanum Gothic;
            font-weight:700;
            cursor:pointer;
        }
        .sort_tab_on:hover{
            background:#578be3;
        }
        .page_bt {
            display:inline-block;
            padding:7px 10px 7px 10px;
            cursor:pointer;
        }
        .page_bt:hover {
            background-color:#e7efff;
            color:#3963b0;
        }
        .page_btno {
            background:#ffffff;
            border:1px solid #e4e4e4;
            color:#3963b0;
        }
        .page_bton {
            background:#3963b0;
            border:1px solid #3963b0;
            color:#ffffff;
        }
    </style>
    <div style="width:100%; min-width:1280px;">
        <header class="clearfix" style="min-width:1280px;">
            <div class="cbp-af-header" style="box-shadow: 0px 0px 25px #000000; min-width:1280px;">
                <div class="cbp-ci"> </div>
                <div class="cbp-af-inner" style="">
				<!--
						<div class="live_casino" onclick="location.href='/game_list?game=multi'" style="cursor:pointer;">
							<img src="/images/ibet/casino_top.png">
						</div>
						-->
                    <h1><a href="/"><img src="/images/ibet/logo_2.png?v02"></a></h1>

                    <nav class="top-menu">
					<span class="big_menu" style="width:98px;">      <!-- 스포츠-->
						<a class="topmenu_1" href="/game_list?game=multi" style="width:98px;"></a>
						<ul class="submenu_1" style="display: none;">
							<li onclick="goUrl('/game_list?game=multi')"><img src="/images/ibet/spo_1.png" class="ball_icon" style="margin-right:15px;"><span>조합배팅</span><span class="game_count">Cross</span></li>
							<!--<li onclick="goUrl('/game_list?game=handi')"><img src="/images/ibet/spo_5.png" class="ball_icon" style="margin-right:15px;"><span>핸디캡</span><span class="game_count">Handicap</span></li>-->
                            <li onclick="goUrl('/game_list?game=special')"><img src="/images/ibet/spo_55.png" class="ball_icon" style="margin-right:15px;"><span>스페셜</span><span class="game_count">Special</span></li>
                            <li onclick="goUrl('/game_list?game=real')"><img src="/images/ibet/spo_2.png" class="ball_icon" style="margin-right:15px;"><span>실시간</span><span class="game_count">Realtime</span></li>
						</ul>
					</span>
                        <span class="big_menu" style="width:100px;">  <!--미니게임-->
                            <a class="topmenu_7"></a>
                            <ul class="submenu_2" style="display: none;">
                                <li onclick="goUrl('/game_list?game=power')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;파워볼</li>
                                <li onclick="goUrl('/game_list?game=lowhi')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;로하이</li>
                                <li onclick="goUrl('/game_list?game=aladin')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;알라딘</li>
								
								<li onclick="goUrl('/game_list?game=psadari');"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;파워사다리</li>
                                <li onclick="goUrl('/game_list?game=kenosadari');"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;키노사다리</li>
                                <li onclick="goUrl('/game_list?game=2dari')""><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;이다리</li>
                                <li onclick="goUrl('/game_list?game=3dari')""><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;삼다리</li>
                                <li onclick="goUrl('/game_list?game=choice')""><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;초이스</li>
                                <li onclick="goUrl('/game_list?game=nine')""><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;나인</li>
                                <li onclick="goUrl('/game_list?game=roulette')""><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;룰렛</li>
                                <li onclick="goUrl('/game_list?game=pharaoh')""><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;파라오</li>
                                <!--
				<li onclick="javascript:swal('서비스 준비중입니다.');"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;888주사위</li>
                                <li onclick="javascript:swal('서비스 준비중입니다.');"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;나인볼</li>
								-->
                            </ul>
                        </span>
                        <span class="big_menu" style="width:140px;"> <!--카지노-->
						<a class="topmenu_2" href="/game_list?game=sadari"></a>
						<ul class="submenu_3" style="display: none;">
							<li onclick="goUrl('/game_list?game=sadari')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;사다리</li>
							<li onclick="goUrl('/game_list?game=dari')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;다리다리</li>
							<li onclick="goUrl('/game_list?game=race')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;달팽이</li>
						</ul>
					</span>

                        <span class="big_menu" style="width:92px;"> <!--파워볼-->
						<a class="topmenu_3" href="/game_list?game=mgmoddeven"></a>
							<ul class="submenu_4" style="display: none;">
							    <li onclick="goUrl('/game_list?game=mgmoddeven')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;MGM홀짝</li>
                                <li onclick="goUrl('/game_list?game=mgmbacara')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;MGM바카라</li>
							</ul>
					</span>
					<!--
                    <span class="big_menu" href="#" style="width:104px;">
                         <a class="topmenu_4"></a>
                         <ul class="submenu_5" style="display: none;">
                             <li onclick="javascript:swal('서비스 준비중입니다.');"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;LOTUS홀짝</li>
                             <li onclick="javascript:swal('서비스 준비중입니다.');"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;LOTUS바카라</li>
                         </ul>
                     </span>
					 -->
                        <span class="big_menu" href="#" style="width:60px;">     <!-- 출석부-->
						<a class="topmenu_5" href="/game_list?game=vfootball"></a>
						<ul class="submenu_6" style="display: none;">
						<li onclick="goUrl('/game_list?game=vfootball')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;가상축구</li>
							<!--<li onclick="javascript:swal('서비스 준비중입니다.');"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;가상개경주</li>-->
						</ul>

					</span>
                        <span class="big_menu" href="#" style="width:74px;">    <!-- 경기결과-->
						<a class="topmenu_6" href="/race/game_result?view_type=winlose"></a>
					</span>
                        <span class="big_menu" href="#" style="width:75px;">    <!-- 커뮤니티-->
						<a class="topmenu_8"></a>
						<ul class="submenu_8">
                            <li onclick="goUrl('/board/')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;공지게시판</li>
                            <li onclick="goUrl('/cs/cs_list')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;고객상담센터</li>
                            <li onclick="goUrl('/race/betting_list')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;나의 배팅내역</li>
                            <!--<li onclick="goUrl('/game_guide')"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;&nbsp;베팅규정</li>-->
						</ul>
						<div style="position:absolute; margin-top:-50px; right:-10px;">

												</div>
				</span>

<!--
						<span href="#">

							<div>

								<a class="topmenu_14"><i class="fa fa-user" style="width:30px;margin-right:100px;"></i></a>
								<span class="cart_number" style="padding-left:5px;color:#e2eeff; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7); font-weight:400;">&#8361;</span>
								<span id="CPoint_txt" style="margin-left:-15px;display:inline-block;width:100px;color:#FFFFFF"><?php/* echo number_format($TPL_VAR["cash"],0)*/?></span>
								<input type="hidden" id="CPoint" value="<?php/* echo number_format($TPL_VAR["cash"],0)*/?>">
								<a class="topmenu_13" href="javascript:mCharge();"><i class="fa fa-battery-4" style="width:30px;"></i><img src="/images/ibet/blank.gif" width="90" height="1"></a>
								<a class="topmenu_12" href="javascript:mExchange();"><i class="fa fa-battery-1" style="width:30px;"></i><img src="/images/ibet/blank.gif" width="90" height="1"></a>
								<a class="topmenu_11" href="/cs/cs_list"><i class="fa fa-pencil-square-o" style="width:30px;"></i><img src="/images/ibet/blank.gif" width="90" height="1"></a>

							</div>

						</span>
-->
                        </div>
                        <div class="cbp-af-header1" style="width:800px;float:right;">
                    </nav>
                </div>
                <div class="mypage_btn">
			        <span style="display:inline-block; margin-right:10px; vertical-align:text-top;">
                        <a href="/member/memolist" id="pop_memo_btn_top" style="cursor:pointer;" class="md-trigger" data-modal="modal-memo">
                            <img src="/images/ibet/memo2.png" style="width:22px; height:14px; margin-top:5px; margin-left:15px;" onmouseover="this.src='/images/ibet/memo2_on.png'" onmouseout="this.src='/images/ibet/memo2.png'">
                            <span style="width:20px; height:20px;
                                        background:#ff3300; color:#ffffff;
                                        line-height:20px; font-size:12px;
                                        font-weight:700;  border-radius:10px;
                                        text-align:center; display:inline-block;
                                        position:absolute;
                                        right:190px;"><?php echo $TPL_VAR["new_memo_count"]?>
                             </span>
                        </a>
                        <span class="tip3" style="display:inline-block; margin-right:20px; vertical-align:text-top; padding-top:-5px;">
                            <a href="/logout" style="cursor:pointer;">
                                <img src="/images/ibet/sesion3.png" style="width:21px; height:23px; margin-top:-1px; margin-left:15px;" onmouseover="this.src='/images/ibet/sesion4.png'" onmouseout="this.src='/images/ibet/sesion3.png'">
                            </a>
                            <span class="tooltip3" style="width:60px; text-align:center;">로그아웃</span>
			            </span>
						<!-- 상단 보유머니 -->
						<a class="money_bbg" data-modal="modal-money"><span class="cart_number" style="color:#e2eeff; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7); font-weight:400;">&#8361; <span id="left_usr_money"><?php echo number_format($TPL_VAR["cash"],0)?></span></span></a>
			            <a id="showLeft" class="ahref2" style="cursor:pointer;">my page</a>
			        </span>
                </div>
            </div>
        </header>
    </div>
    <div class="menu_fixed_top"> </div>
    <script>
        jq$(document).ready(function(){
            jq$(".cbp-af-inner").show();
        });
        jq$('.big_menu').hover(function(){
            jq$(this).children("ul").show();

        },function(){
            jq$(this).children("ul").hide();
        });
    </script>
														<!-- 죄측 충/환전 배터 -->
			<div id="pop_charge_btn" style= "width:37px; height:267px; position:fixed; important; left: 0px;margin-top:240px;">
			<img onclick="javascript:location.href='/member/charge';" id="pop_charge_btn" class="md-trigger button" data-modal="modal-charge" style="width:37px; height:134px; cursor:pointer;" src="../images/ibet/chex_bg1.png">
			<img onclick="javascript:location.href='/member/exchange';" id="pop_charge_btn" class="md-trigger button" data-modal="modal-excharge" style="width:37px; height:134px; cursor:pointer;" src="../images/ibet/chex_bg2.png">
			</div>
    <script type="text/javascript">PopupView();</script>
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s1"  style="box-shadow: 0px 25px 25px #000000;z-index:999999999;">
        <div class="slide_box_right">
            <div id="showLeft_2" class="close_btn colose_cart"></div>
            <span style="float:right; margin-right:85px; margin-top:3px;">my page</span>
        </div>
        <li style="text-align:left;width:100%;">
            <a href="/member/memolist" id="pop_memo_btn" class="md-trigger button big big_over" data-modal="modal-memo" style="padding-left:40px">
                <i class="fa fa-envelope" style="width:30px;"></i>나의 편지함
                <span style="background-color:#ff6600; font-size:11px; padding:2px 5px 2px 5px; margin-left:10px; border-radius:3px;"><?php echo $TPL_VAR["new_memo_count"]?></span>
            </a>
            <a href="javascript:mCharge();" id="pop_charge_btn" class="md-trigger button big big_over" data-modal="modal-charge" style="padding-left:40px"><i class="fa fa-battery-4" style="width:30px;"></i>입금신청</a>
            <a href="javascript:mExchange();" id="pop_exchange_btn" class="md-trigger button big big_over" data-modal="modal-exchange" style="padding-left:40px"><i class="fa fa-battery-1" style="width:30px;"></i>출금신청</a>
            <a href="/race/betting_list" class="button big big_over" style="padding-left:40px"><i class="fa fa-pencil-square-o" style="width:30px;"></i>베팅내역</a>
            <a href="/member/member" class="button big big_over" style="padding-left:40px"><i class="fa fa-user" style="width:30px;"></i>나의정보</a>
            <a href="javascript:mileage2Cash();" class="button big big_over" style="padding-left:40px" ><i class="fa fa-play-circle" style="width:30px;"></i>포인트전환</a>
        </li>
        <table height="100%" width="100%">
            <tr>
                <td style="vertical-align:bottom; padding-bottom:790px; text-align:center;">
                    <img src="/images/ibet/m_level1.png" style="height:150px; padding-bottom:5px;">
                    <div style="padding:10px; color:#ffffff; background-color:#206C95; text-align:center; margin:5px; font-size:12px; font-weight:bold;">
                        <?php echo $TPL_VAR["nick"];?> 님
                    </div>

                    <div style="padding:8px 8px 8px 18px; color:#ffffff; background-color:#206C95; text-align:left; margin:5px; font-size:12px; font-weight:bold;"><span>보유머니</span>
                        <span class="cart_number" style="font-weight:400; text-shadow:1px 1px 1px rgba(0, 0, 0, 0.4)">&#8361; <span id="left_usr_money"><?php echo number_format($TPL_VAR["cash"],0)?></span></span></div>
                    <div style="padding:8px 8px 8px 18px; color:#ffffff; background-color:#206C95; text-align:left; margin:5px; font-size:12px; font-weight:bold;"><span>포인트</span>
                        <span class="cart_number" style="font-weight:400; text-shadow:1px 1px 1px rgba(0, 0, 0, 0.4);padding-left:21px;">&#8361; <span id="left_usr_point"><?php echo number_format($TPL_VAR["mileage"],0)?></span></span></div>
                    <div style="padding:8px 8px 8px 18px; color:#ffffff; background-color:#206C95; text-align:left; margin:5px; font-size:12px; font-weight:bold;"><span>배팅현황</span>
                        <span class="cart_number" style="font-weight:400; text-shadow:1px 1px 1px rgba(0, 0, 0, 0.4)"> <span id="left_usr_betc"><?php echo number_format($TPL_VAR["bet_count"],0)?> 건</span></span></div>
                    <div style="padding:8px 8px 8px 18px; color:#ffffff; background-color:#206C95; text-align:left; margin:5px; font-size:12px; font-weight:bold;"><span>배팅금액</span>
                        <span class="cart_number" style="font-weight:400; text-shadow:1px 1px 1px rgba(0, 0, 0, 0.4)">&#8361; <span id="left_usr_betmoney"><?php echo number_format($TPL_VAR["bet_money"],0)?></span></span></div>
                    <div style="padding:8px 8px 8px 18px; color:#ffffff; background-color:#206C95; text-align:left; margin:5px; font-size:12px; font-weight:bold;"><span>적중예상</span>
                        <span class="cart_number" style="font-weight:400; text-shadow:1px 1px 1px rgba(0, 0, 0, 0.4)">&#8361; <span id="left_usr_stmoney"><?php echo number_format($TPL_VAR["profit_money"],0)?></span></span></div>

                    <form name='CPointF'>
                        <input id='CPoint' type=hidden value="122,850">
                    </form>
                    <form name="Pointcy" method="post" action=""/>
                    <input type="hidden" name="mode" value=""/>
                    <input type="hidden" name="page" value=""/>
                    <input type="hidden" name="PgSet" value=""/>
                    <input type="hidden" name="Money" value="122,850"/>
                    <input type="hidden" name="UserPoint" value="1,500"/>
                    </form>
                </td>
            </tr>
        </table>
    </nav>

    <div class="md-overlay"></div>

    <script>

        var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
            menuLeft_2 = document.getElementById( 'cbp-spmenu-s1' ),
            showLeft = document.getElementById( 'showLeft' ),
            showLeft_2 = document.getElementById( 'showLeft_2' ),
            body = document.body;
        showLeft.onclick = function() {
            classie.toggle( this, 'active' );
            classie.toggle( menuLeft, 'cbp-spmenu-open' );
            //disableOther( 'showLeft' );
        };
        showLeft_2.onclick = function() {
            classie.toggle( this, 'active' );
            classie.toggle( menuLeft, 'cbp-spmenu-open' );
            //disableOther( 'showLeft' );
        };
    </script>

    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2"  style="box-shadow: 25px 25px 25px 25px #000;">
        <div class="slide_box">
            <div id="showRight_2" class="close_btn colose_mypage"></div>
            <span style="float:right; margin-right:20px; margin-top:3px;">betting cart</span>
        </div>
		<div class="right_quick" style="position:fixed; top:225px; right:10px;">
			<li><a href="/cs/cs_list"><img src="../images/ibet/cus.png"></a></li>
	<li><a id="pop_search_btn" class="md-trigger" data-modal="modal-search" href="/race/betting_list"><img src="../images/ibet/search.png"></a></li>
	<li><a href="#"><img src="../images/ibet/tutorial.png"></a></li>
</div>
    </nav>

    <script type="text/javascript" src="/include/js/ibet/cbpAnimatedHeader.min.js?7"></script>
    <script type="text/javascript" src="/include/js/ibet/classie.js"></script>
