<?php
    $powerStartTime = "1291270089";
	$gameTh = floor((time() - $powerStartTime) / 300);
    $dayGameTh = ($gameTh + 135) % 288;
    if($dayGameTh == 0) {
        $dayGameTh = 288;
    }
?>

<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>파워볼 중계화면 - 엔트리 스코어</title>
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-title" content="엔트리" />
<meta name="generator" content="ntry.com" />
<meta name="author" content="ntry.com" />
<meta name="keywords" content="엔트리,스포츠" />
<meta name="description" content="스포츠 커뮤니티 엔트리" />
<meta name="robots" content="ALL,INDEX,FOLLOW" />
<meta name="format-detection" content="telephone=no" />
<meta property="og:title" content="파워볼 중계화면 - 엔트리 스코어" />
<meta property="og:site_name" content="ntry" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://ntry.com" />
<meta property="og:image" content="/public/img/og_image.png" />
<meta property="og:description" content="파워볼 중계화면 - 엔트리 스코어" />
<meta property="og:locale" content="ko" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="https://ntry.com" />
<meta name="twitter:title" content="파워볼 중계화면 - 엔트리 스코어" />
<meta name="twitter:description" content="파워볼 중계화면 - 엔트리 스코어" />
<meta name="twitter:image:src" content="/public/img/og_image.png" />
<meta itemprop="name" content="파워볼 중계화면 - 엔트리 스코어" />
<meta itemprop="url" content="https://ntry.com/" />
<meta itemprop="image" content="/public/img/og_image.png" />
<link rel="shortcut icon" type="image/x-icon" href="/public/img/favicon.ico" />
<link rel="apple-touch-icon-precomposed" href="/public/img/apple_home_icon.png" />
<link rel="stylesheet" type="text/css" href="/public/css/reset.css" />
<link rel="stylesheet" type="text/css" href="/public/css/score/ui_game/powerball.css" />
<link rel="stylesheet" type="text/css" href="/public/css/score/ui_game/room_newlist.css" />
<link rel="stylesheet" type="text/css" href="/public/css/score/ui_game/banner.css" />
<script type="text/javascript" src="/public/js/jquery-1.11.3.min.js"></script>
<script async src='/cdn-cgi/bm/cv/669835187/api.js'></script></head>
<body>


<div class="powerball_wrap">
<div class="hd">
<h1 class="blind">엔트리파워볼</h1>
<p class="blind">동행복권의 파워볼을 기준으로 5분단위로 추첨하며 288회차까지 진행</p>
<div class="summary_btn_area">
<a class="btn btn_ntry" href="http://ntry.com" target="_blank" title="엔트리 바로가기">엔트리</a>
<a class="btn btn_rank" href="http://ntry.com/tipster/rank.php?search_game=POWER" target="_blank" title="파워볼 랭킹">랭킹</a>
<a id="btn_tip" class="btn btn_tip" href="javascript:;" title="게임안내">게임안내</a>
<a id="btn_share" class="btn btn_share" href="javascript:;" title="퍼가기">퍼가기</a>
<a id="btn_sound" class="btn btn_sound on" href="javascript:;" title="소리 켜기/끄기">소리 켜기/끄기</a>
</div>
<dl id="ly_game_tip" class="ly_game_tip" style="display:none;">
<dt class="tit">엔트리 파워볼 게임 설명</dt>
<dd>동행복권의 파워볼을 기준으로 진행됩니다.</dd>
<dd>5분에 한번씩 매 2분55초, 7분55초에 게임이 실행 됩니다.</dd>
</dl>
<dl id="ly_share" class="ly_share" style="display:none;">
<dt class="tit">엔트리 파워볼 중계화면 퍼가기</dt>
<dd class="source">
<textarea><iframe src="http://ntry.com/scores/powerball/live.php" width="830" height="641" scrolling="no" frameborder="0"></iframe></textarea>
</dd>
 <dd>위의 HTML의 코드를 복사하여 원하시는 페이지에 아이프레임으로 추가하시면</dd>
<dd>파워볼 게임 영역만 중계화면으로 이용 가능합니다.</dd>
</dl>
</div>
<div class="bd">
<div class="chat_list_area">
<h2 class="blind">엔트리 채팅방</h2>
<div id="chat_area"></div>
<div class="btn_area _tracking_buttons">
<a class="btn btn_chat_room" href="/nchat/?game=C" onclick="return open_room_chat(this);" title="채팅방 대기실">채팅방 대기실</a>
<a class="btn btn_pick" href="http://ntry.com/tipster/pick.php?qgame=POWER" title="파워볼 픽" target="_blank">파워볼 픽</a>
</div>
</div>
<div class="game_board_area">
<h2 class="blind">파워볼게임화면</h2>
<p id="clock" class="clock">----.--.-- --:--:--</p>
<div id="game_board" class="game_board">
<div class="cast_lots">
<span class="bg_board"></span>
<div class="bg_animation"><span class="ani0"></span></div>
</div>
</div>
<div id="waiting_board" class="waiting_board">
<div id="caution-area" class="inner">
<div id="timer_gauge" class="gauge" style="left:0"></div>
<div class="tx"><span id="countdown_clock" class="countdown_clock">-분 --초 후</span> <strong class="next_turn">205</strong>회차 추첨 시작</div>
</div>
</div>
<div id="score_board" class="score_board" style="display:none;">
<span class="curr_round"><strong>205 </strong><span>(1053862)</span></span>
<span class="result_ball"></span>
</div>
<dl id="result_board" class="result_board" style="display:none;">
<dt>회차</dt><dd class="round"></dd>
<dt>파워볼</dt><dd class="powerball"></dd>
<dt>숫자합</dt><dd class="sum"></dd>
</dl>
<p class="link"><a href="http://ntry.com" target="_blank">WWW.NTRY.COM</a></p>
<div id="dist_graph" class="dist_graph">
<dl class="item p_oe" rel="p_oe">
<dt>파워볼홀짝</dt>
<dd class="bar left"><span class="tx">0%</span><div class="gauge"></div></dd>
<dd class="bar right"><span class="tx">0%</span><div class="gauge"></div></dd>
</dl>
<dl class="item p_ou" rel="p_ou">
<dt>파워언오버</dt>
<dd class="bar left"><span class="tx">0%</span><div class="gauge"></div></dd>
<dd class="bar right"><span class="tx">0%</span><div class="gauge"></div></dd>
</dl>
<dl class="item b_oe" rel="b_oe">
<dt>일반홀짝</dt>
<dd class="bar left"><span class="tx">0%</span><div class="gauge"></div></dd>
<dd class="bar right"><span class="tx">0%</span><div class="gauge"></div></dd>
</dl>
<dl class="item b_ou" rel="b_ou">
<dt>일반언오버</dt>
<dd class="bar left"><span class="tx">0%</span><div class="gauge"></div></dd>
<dd class="bar right"><span class="tx">0%</span><div class="gauge"></div></dd>
</dl>
<div class="item bms" rel="b_sect">
<dl>
<dt class="big">대</dt>
<dd class="bar big"><span class="tx">0%</span><div class="gauge"></div></dd>
<dt class="middle">중</dt>
<dd class="bar middle"><span class="tx">0%</span><div class="gauge"></div></dd>
<dt class="small">소</dt>
<dd class="bar small"><span class="tx">0%</span><div class="gauge"></div></dd>
</dl>
</div>
 </div>
</div>
<div class="latest_result_area">
<h2 class="blind">지난회차</h2>
<div id="recent_result">
</div>
<div class="btn_area _tracking_buttons">
<a class="btn btn_date" href="http://ntry.com/stats/powerball/date.php" target="_blank" title="일별통계">일별통계</a>
<a class="btn btn_round" href="http://ntry.com/stats/powerball/round.php" target="_blank" title="회차통계">회차통계</a>
<a class="btn btn_pattern" href="http://ntry.com/stats/powerball/pattern.php" target="_blank" title="패턴통계">패턴통계</a>
<a class="btn btn_total" href="http://ntry.com/stats/powerball/total.php" target="_blank" title="예측통계">예측통계</a>
</div>
</div>
</div>
<div id="minigame_ad_banner">



</div>
<div id="check_time_cotton">
<div class="check_time_area"></div>
</div>
</div>

<script type="text/javascript" src="/public/js/score/ui_game/getNewAdList.js"></script>
<script type="text/javascript" src="/public/js/score/ui_game/powerball_board.js"></script>
<script type="text/javascript" src="/public/js/moment.min.js"></script>
<script type="text/javascript">
var live_game_type = "powerball";
var live_game_board = new PowerBallBoard(<?=$dayGameTh?>, live_game_type);
var sound_effect_seconds = 5;
var service_check = false;
</script>
<script type="text/javascript" src="/public/js/score/ui_game/power_execute.js"></script>
<script type="text/javascript" src="/public/js/score/ui_game/getNewChatList.js"></script>
<script type="text/javascript" src="/public/js/score/analytics.js"></script>
<script id="recent-result-list" type="text/template">
    <ul class="result_list">
        [% for (var k in data) { %]
        <li>
            <p class="round"><strong>[%=data[k].date_round%]</strong> ([%=data[k].round%])</p>
            <p class="result_ball">
                <em class="n[%=data[k].ball_1%]">[%=data[k].ball_1%]</em>
                <em class="n[%=data[k].ball_2%]">[%=data[k].ball_2%]</em>
                <em class="n[%=data[k].ball_3%]">[%=data[k].ball_3%]</em>
                <em class="n[%=data[k].ball_4%]">[%=data[k].ball_4%]</em>
                <em class="n[%=data[k].ball_5%]">[%=data[k].ball_5%]</em>
                <em class="p[%=data[k].powerball%]">[%=data[k].powerball%]</em>
            </p>
        </li>
        [% } %]
    </ul>
</script>
<script id="caution" type="text/template">
    <div class="game_check">
        <p class="tit">엔트리파워볼 점검시간안내</p>
        <p class="date">[%=data.start_dt%] ~ [%=data.end_dt%]</p>
    </div>
</script>
<script id="cotton" type="text/template">
    <div class="game_cotton">
        <div class="game_cotton_title_lottery">
            <div class="title"></div>
        </div>
        <div class="game_cotton_content">
            <p class="sub-title">안녕하세요. 엔트리 운영팀입니다.</p>
            <p clss="content">[%=content%]</p>
            <br/>
            <p class="date">일시 : [%=start_dt%] ~ [%=end_dt%]</p>
            <br/>
            <p class="help_address">기타문의는 help@ntry.com을 이용 바랍니다. 감사합니다.</p>
        </div>
    </div>
</script>
<script>
    let room_list_config = {
        bg_color: '_brown',
        box_height: '_h214',
        box_width: '_w195',
        profile_size: 91
    };
</script>
<script type="text/javascript">
    $(function() {
        $.get('/recent_result', function(res) {
            res = JSON.parse(res);
            window.latestRound = res[0].round;

            var htmlCode = `<ul class="result_list">`;

            for(var i = 0; i < res.length; i++) {
                htmlCode += `<li style="display: list-item;">
                                <p class="round"><strong>` + res[i].date_round + ` </strong>(` + res[i].round + `)</p>
                                <p class="result_ball">
                                    <em class="n` + res[i].ball_1 + `">` + res[i].ball_1 + `</em>
                                    <em class="n` + res[i].ball_2 + `">` + res[i].ball_2 + `</em>
                                    <em class="n` + res[i].ball_3 + `">` + res[i].ball_3 + `</em>
                                    <em class="n` + res[i].ball_4 + `">` + res[i].ball_4 + `</em>
                                    <em class="n` + res[i].ball_5 + `">` + res[i].ball_5 + `</em>
                                    <em class="p` + res[i].powerball + `">` + res[i].powerball + `</em>
                                </p>
                            </li>`;
            }
            htmlCode += `</ul>`;
            document.getElementById('recent_result').innerHTML = htmlCode;
        });

        $.get('/caution', function(res, textStatus, request) {
            const now = moment(parseInt('1610006395') * 1000).valueOf();
            const start_dt = moment(res.start_dt).format('YYYY-MM-DD HH:mm');
            const end_dt = moment(res.end_dt).format('YYYY-MM-DD HH:mm');

            const start = moment(start_dt).valueOf();
            const end = moment(end_dt).valueOf();

            if (start && end && start <= now && end >= now) {
                service_check = true;
                let html = new EJS({element: 'cotton'}).render({
                    content: res.content.replace(/\n/g, "<br />"),
                    start_dt : start_dt,
                    end_dt : end_dt
                });
                let html_time_bar = "-";
                $("#caution-area").html(html_time_bar);
                $("#check_time_cotton").find('.check_time_area').html(html);
                $("#check_time_cotton").addClass("check_time_cotton");
            }
        });
    });
</script>
<script type="text/javascript">
    let IS_GIF = true;
    function onErrorImage(img, profile_path){
        // REMOVED EXTENSION .png
        profile_path = profile_path.replace(/\.[^/.]+$/, "");
        //JPG로 시도, 없으면 GIF, 없으면 기본 이미지
        $.ajax({
            url: profile_path + '.jpg',
            success : function(){ img.src = profile_path + '.jpg'; },
            error: function () {
                $.ajax({
                    url: profile_path + '.gif',
                    success : function(){ img.src = profile_path + '.gif'; },
                    error: function () { img.src = 'http://ntry.com/public/img/fam/default_31x31.png?v=160224'; }
                });
            }
        });
    }

    $(function() {
        $.get('/nchat_room_list', function(res) {
            res = JSON.parse(res);
            var htmlCode = `<ul class="chat_newlist _tracking_room_buttons">
                                <li class="multi _h214 _w195 _brown">
                                    <a href="/nchat/?room/` + res[0].roomNo + `" class="premium_link" aria-haspopup="true" onclick="return open_room_chat(this)" title="` + res[0].title + `" value="0">
                                        <div class="photo">
                                            <span class="profile_image ">
                                                <img src="http://ntry.com` + res[0].image + `" onerror="onErrorImage(this, &quot;/data/ad/resize/7rn2qx6344cad4de9cd726280b8a8126543b4c2f_1602766936245064.png&quot;)" width="91" height="91"></span>
                                        </div>
                                        <div class="label">
                                            <p class="title">` + res[0].title + `</p>
                                        </div>
                                    </a>
                                </li>`;
            for(var i = 1; i < 5; i++) {
                htmlCode += `<li class="inline _w195 _brown">
                                <a href="/nchat/?room/` + res[i].roomNo + `" aria-haspopup="true" onclick="return open_room_chat(this)" title="` + res[i].title + `" value="4">
                                    <p>` + res[i].title + `</p>
                                </a>
                            </li>`;
            }
            htmlCode += `</ul>`;
            document.getElementById('chat_area').innerHTML = htmlCode;
        });
    });
</script><script type="text/javascript" src="/public/js/score/clock.js"></script>
<script type="text/javascript" src="/public/js/score/dist.js"></script>
<script type="text/javascript">

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-161443936-1', 'auto');
    ga('set', 'userId', '');
    var dimension1Value = 'Guest';
    ga('set', 'dimension1', dimension1Value);
    ga('set', 'dimension2', '파워볼');

    var dimension3Value = 'browser';
    if (/HeadlessChrome/.test(window.navigator.userAgent)) {
        dimension3Value = 'bot';
    }
    if (!window.navigator.languages) {
        dimension3Value = 'bot';
    }
    ga('set', 'dimension3', dimension3Value);

    try {
        if (self !== top && top.location.host === self.location.host) {
            ga('send', 'pageview', location.pathname.replace('/live.php', '/main.php'));
        } else {
            throw "new window";
        }
    } catch (e) {
        ga('send', 'pageview');
    }

    (function clock_update() {
        game_clock.update();
        setTimeout(clock_update, 100);
    }());

    (function(){
        game_clock.sync_clock();
    })();

    (function dist_update() {
        game_dist.set_dist();
        setTimeout(dist_update, 3000);
    }());
</script>
<script type="text/javascript" src="/public/js/common.js"></script>
<script type="text/javascript" src="/public/js/cookie.js"></script>
<script type="text/javascript" src="/public/js/ejs/ejs_production.js"></script>
<script type="text/javascript">(function(){window['__CF$cv$params']={r:'60dc24622a0da1cb',m:'90c8a0a4847df3ea5c78ff4b822bff2a39caf88f-1610006395-1800-AYQkO41RfHnY+wliUKAbhgoF9zj3rFztLm71607RvyoxQHgcEk/ZqhoFwuKwx7yPdsYah2wpZZeJrLijKUuLhguWkWPt9Tv4PSm0XlShfl8kTnb4G/B0l1sjUJtFNIQB7dSIcXNSaMGw5GIHpMnBbgg=',s:[0xadefb7f534,0xe7457eeb5f],}})();</script></body>
</html>
