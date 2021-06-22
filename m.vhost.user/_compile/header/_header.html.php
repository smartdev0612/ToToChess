<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, target-densitydpi=medium-dpi">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no, address=no, email=no" />
    <title> BLACK9 </title>
    <link rel="stylesheet" type="text/css" href="/css/layout.css?v04" />
    <link rel="stylesheet" type="text/css" href="/css/game.css?v03=<?php echo time();?>" />
    <link rel="stylesheet" type="text/css" href="/css/slide_menu.css?v04" />
	<link rel="stylesheet" type="text/css" href="/css/jquery.jscrollpane.css?v04">
    <script src="/js/jquery.min.js" type="text/javascript"></script>
    <script src="/js/jquery-ui-min.js" type="text/javascript"></script>
    <script src="/js/contact.js" type="text/javascript"></script>
    <script src="/js/custom.js" type="text/javascript"></script>
    <script src="/js/comma.js" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="/css/default.css?v04=<?php echo time();?>">
	<script language="javascript" src="/scripts/javascript.js?v04"></script>
	<script language="javascript" src="/scripts/jquery.js"></script>
<!--<script language="javascript" src="/scripts/jquery.mousewheel.js"></script>-->
<!--<script language="javascript" src="/scripts/jquery.jscrollpane.min.js"></script>-->
<!--<script language="javascript" src="/scripts/jquery.slides.js"></script>-->
	<script language="javascript" src="/scripts/script.js"></script>
	<script language="javascript" src="/scripts/member.js"></script>
	<script language="javascript" src="/scripts/live.js"></script>
    <script language="javascript" src="/scripts/live_betting.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script>
        jQuery(document).ready(function() {
            var offset = 200;
            var duration = 500;
            jQuery(window).scroll(function() {
                if (jQuery(this).scrollTop() > offset) {
                    jQuery('.scroll-to-top').fadeIn(duration);
                } else {
                    jQuery('.scroll-to-top').fadeOut(duration);
                }
            });
            jQuery('.scroll-to-top').click(function(event) {
                event.preventDefault();
                jQuery('html, body').animate({
                    scrollTop: 0
                }, duration);
                return false;
            })
        });
    </script>
</head>

<body>

