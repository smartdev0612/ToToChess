<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-Equiv="Cache-Control" Content="no-cache">
    <meta http-Equiv="Pragma" Content="no-cache">
    <meta http-Equiv="Expires" Content="0">
    <script type="text/javascript" charset="utf-8" src="https://cdn.jsdelivr.net/gh/clappr/clappr@latest/dist/clappr.min.js"></script>
</head>
<body style="margin:0">
<div id="player-wrapper">
    <script>
        var playerElement = document.getElementById("player-wrapper");

        var player = new Clappr.Player({
            source: 'https://vsports.bet365.com/L1_C146_S1/playlist.m3u8',
            mute: true,
            height: 288,
            width: 512,
            controls: false,
            autoPlay: true,
            hideMediaControl: true,
            playbackNotSupportedMessage: '이 브라우저에서는 동영상을 지원하지 않습니다, 다른 브라우저를 이용해주세요'
        });
        player.attachTo(playerElement);
    </script>
</body>
</html>