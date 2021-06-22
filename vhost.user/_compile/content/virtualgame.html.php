
	<div class="mask"></div>
	<div id="container">
	
<script language="javascript" src="/10bet/js/sideview.js"></script>
<script language="javascript">
    var VarLadder="";
    var VarListViewMode = "1";
    var VarMoney = "0";
    var VarPoint = "";
    var VarMinBet = '5000';
    var VarMaxBet = '2000000';
    var VarMaxBet2 = '2000000';
    var VarMaxAmount = '6000000';
    var VarMaxAmount2 = '6000000';
    var VarMaxRatio = '100';
    var VarDanpolDown = "";
    var VarTwopolDown = "0";
    var VarMaxCount = '1';
    var VarBoTable = "a91";
    var VarBoTable2 = "a25";
    var VarBetContent = getCookie('betcontenta91');
    var VarSpBet = getCookie('sp_beta91');
    var VarSpBetMoney = getCookie('sp_BetMoneya91');
    var VarEndTime = "25";

    var VarEndTimeSoc = "0";
    var VarEndTimeBsk = "0";
    var VarEndTimeVol = "0";
    var VarEndTimeHoc = "0";

    var VarCa = "";
    var VarCaId = "";
    var VarSca = "";
    var is_admin = "";
    var VarColspan = "7";
    var VarMinBettingCount = "1";
    var VarNewGame = "";
    var VarGameType = "";

    var ca_names;
    var a_infos = new Array();
    var a_date = new Array();
    var a_time = new Array();
    var betList = new Array();
    var tmpObj = new Object;
    var tmp_Arr = new Array();
    var bettingCart = new Array();

    var is_content_chk = '';
    var div_content = '';
    var state = "";
    var is_notice = "";
    var is_endgame = false;
    var is_handyClick = false;
    var background_color = "111111";
    var chk1 = "";
    var chk2 = "";
    var chk3 = "";
    var s_mod2 = "";
    var b_type = "";

    $j().ready(function(){
        <?php
        if(count((array)$_SESSION['member']) > 0) {?>
        <?php } else { ?>
            setInterval(function(){ login_open(); }, 1000);
        <?php } ?>
        if( VarNewGame ){
            // NOWORK
        }
        else{
            if(VarBoTable == 'a25'){
                path = '/ajax.list.php?bo_table=a10&ca=&sca=&sfl=&stx=&b_type=2&cl=&sch=';
                init("" + g4_path + path);
        
                path2 = '/ajax.list.php?bo_table=a25&ca=&sca=&sfl=&stx=&sch=';
                init2("" + g4_path + path2);
                //setInterval("init('"+g4_path+ path +"')", 30000);
            }else {
                path = '/ajax.list.php?bo_table=a91&ca=&sca=&sfl=&stx=&b_type=&cl=&sch=';
                init("" + g4_path + path);
        
                path2 = '/ajax.list.php?bo_table=a25&ca=&sca=&sfl=&stx=&sch=';
                init2("" + g4_path + path2);
                //setInterval("init('"+g4_path+ path +"')", 30000);
            }
            
            var limit =600;
            $j('#right_box').scroll(function(){
                var scrollT = $j(this).scrollTop(); 
                var scrollH = $j(this).height();
                var contentH = $j('#right_box > #board_list').height();

                if(scrollT + scrollH +1 >= contentH) {
                    limit += 50;
                }
            });
        }
    });
</script>
<script language='javascript' src='/10bet/js/calendar2.js'></script>
<script type="text/javascript" src="/10bet/skin/board/betting/js/script.js"></script>
<!--[if lte ie 8]>-->
<script type="text/javascript" src="/10bet/js/math.ie8.shim.min.js"></script>
<script type="text/javascript" src="/10bet/js/math.ie8.sham.min.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="/10bet/js/math.min.js"></script>
<script>math.config({number: 'BigNumber'});</script>
<script type="text/javascript" src="/10bet/skin/board/betting/js/bet_365.js?1610534692"></script>
<script type="text/javascript" src="/10bet/skin/board/betting/js/float_layer.js?1610534692"></script>
<!--<link rel="stylesheet" href="../skin/board/betting/style.css" type="text/css">-->
<!-- 게시판 목록 시작 -->
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
<style>
    .ko_sports_game img {vertical-align:middle;}
    .display_none {display:none;}
    .title_area h4 {width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;}
</style>
<!-- left 메뉴 -->
<div id="left_section">
    <div class="left_box">
        <div class="other_menu_list	box_type01">
            <!-- 메뉴 리스트	-->
            <ul class="mune_list01">
                <li>
                    <a href="/bbs/board.php?bo_table=a91">
                        <div class="menu01 on"><img src="/10bet/images/10bet/ico/ico_virtual_01.png" alt="ico" /> BET365 가상축구									<span class="time a91">0:00</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/bbs/board.php?bo_table=a92">
                        <div class="menu01 "><img src="/10bet/images/10bet/ico/ico_dog_01.png" alt="ico" /> BET365 개경주									<span class="time a92">0:00</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/bbs/board.php?bo_table=a912">
                        <div class="menu01 "><img src="/10bet/images/10bet/ico/ico_virtual_01.png" alt="ico" /> BETFAIR 가상축구									<span class="time a912">0:00</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    $j(function() {
        var json_arr = [];
        setInterval(function() {
            calc_min();
        }, 1000);

        function calc_min() {
            var json;
            for (var i=0; i<json_arr.length; i++) {
                json = json_arr[i];
                calc_remain(json.bo_table, parseInt(json.interval), parseInt(json.dif));
            }
        }
        function calc_remain(bo_table, interval, dif) {
            var ct = clock.time_str;
            var ms = ct.substr( (ct.length - 5), 5 );
            ms = ms.split(":");
            var m = parseInt(ms[0]);
            var s = parseInt(ms[1]);
            
            var total_s = (m*60) + s;
            
            var next_s = dif;
            while( total_s > next_s ) {
                next_s += interval;
            }
            
            var calc_s = next_s - total_s;
            //console.log(bo_table + " => " + ct + " : " + total_s + " => " + next_s);

            var str = "0:00";
            if (calc_s > 0) {
                m = parseInt(calc_s / 60);
                s = parseInt(calc_s % 60);
                if (s < 10) s = "0"+s;
                str = m+":"+s;
            }
            $j("."+bo_table).html(str);
        }
    });
</script>
			
<div id="contents">
    <div class="mini_game_bet">
        <h2>BET365 가상축구</h2>	
    </div>
    <div class="sports_head">
        <div class="menu_list">
            <ul>
                <li style="width:32%;"><button class="button_type01 on" onClick="location.href='/bbs/board.php?bo_table=a91'">
                        <span>BET365 가상축구</span>
                    </button>
                </li>
                <li style="width:32%;"><button class="button_type01 " onClick="location.href='/bbs/board.php?bo_table=a92'">
                        <span>BET365 개경주</span>
                    </button>
                </li>
                <li style="width:32%;"><button class="button_type01 " onClick="location.href='/bbs/board.php?bo_table=a912'">
                        <span>BETFAIR 가상축구</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
        <tr>
            <td valign="top">
                <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" align="left" style="position:relative;background-color:rgba(0,0,0,0.8);">
                    <tr>
                        <td valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" valign="top" >
                                                    <!--<script>(function (d, sid) {if(!document.getElementById(sid)){var s = d.createElement('script');s.id=sid;s.src='https://live.statscore.com/livescorepro/generator';s.async=1;d.body.appendChild(s);}})(document, 'STATSCORE_LMP_GENERATOR_SCRIPT');
                                                    </script>
                                                    <div id="tracker-1" class="STATSCORE__Tracker" data-event="3172034" data-lang="ko" data-config="687" data-zone="" data-use-mapped-id="0"></div>
                                                    <iframe id="game_stat" scrolling="no" frameborder="0" src="/10bet/game_info_iframe.php?game_id=0" width="100%" height="472" style="display:none;"></iframe>-->
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" valign="top" >
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td valign="top" width="100%" height="500">
                                                                <!-- 가상 경기 영역 -->
                                                                <div class="virtual_sports">
                                                                    <section>
                                                                        <div class="vod_box">
                                                                            <div class="vod_area">
                                                                                <iframe src="http://b1.nusub365.com/ios?vn=1&sw=520&sh=300" id="bet365" frameborder="0" width="100%" height="300" style="overflow-x:hidden" scrolling="no"></iframe> 
                                                                            </div>
                                                                            <!--<div class="title_area"><span class="dot"></span><span class="week">Week 27</span> - TV Match Highlights</div>-->
                                                                        </div>
                                                                    </section>
                                                                    <section>
                                                                        <div class="match_box">
                                                                            <div class="tv_match">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                                                    <path d="M21 6h-7.59l3.29-3.29L16 2l-4 4-4-4-.71.71L10.59 6H3c-1.1 0-2 .89-2 2v12c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V8c0-1.11-.9-2-2-2zm0 14H3V8h18v12zM9 10v8l7-4z"></path>
                                                                                </svg>
                                                                                MATCH
                                                                            </div>
                                                                            <div class="team_name">
                                                                                <div class="home"><span>Watford Hornets</span></div>
                                                                                <div class="vs"><span>VS</span></div>
                                                                                <div class="away"><span>South Saints</span></div>
                                                                            </div>
                                                                            <div class="match_result">
                                                                                <div class="title">Match Result (1X2)</div>
                                                                                <div class="button_area">
                                                                                    <button onClick="check_bet(810974, '1');">3.6</button>
                                                                                    <button onClick="check_bet(810974, '3');">2.75</button>
                                                                                    <button onClick="check_bet(810974, '2');">1.97</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="btn_box">
                                                                            <button class="button_type01 Premiership  on" onClick="change_soc('http://b1.nusub365.com/ios?vn=1&sw=520&sh=300','Premiership');">Premiership</button>
                                                                            <button class="button_type01 Superleague " onClick="change_soc('http://b1.nusub365.com/ios?vn=2&sw=520&sh=300','Superleague');">Superleague</button>
                                                                            <button class="button_type01 EuroCup" onClick="change_soc('http://b1.nusub365.com/ios?vn=13&sw=520&sh=300','EuroCup');">Euro Cup</button>
                                                                            <button class="button_type01 WorldCup" onClick="change_soc('http://b1.nusub365.com/ios?vn=3&sw=520&sh=300','WorldCup');">World Cup</button>
                                                                        </div>
                                                                    </section>
                                                                </div>
                                                                <!-- Body -->
                                                                <!--<div id="tracker-1" class="STATSCORE__Tracker" data-event="3172034" data-lang="ko" data-config="687" data-zone="" data-use-mapped-id="0"></div> -->
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="" id="board_list2" " style="padding:18px;float:left;">
                                                                </table>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="" id="board_list" class="sports_game" style="padding:18px;float:left;">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="game_title">
                                                                                <h4><img src="/10bet/images/10bet/ico/ico_virtual_01.png" alt="ico"> BET365</h4>
                                                                                <div class="title_area">
                                                                                    <div class="title01" style="width:100%;">Match Result (1X2)</div>
                                                                                    <!--<div class='title02'>Total Goals Over/Under</div><div class='title03'>Handicap</div>-->
                                                                                </div>
                                                                                <div class="bookmark">
                                                                                    <span><!-- 클릭시 <span class='on'> -->
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 16" fill="currentColor">
                                                                                            <path id="Shape_2_copy" data-name="Shape 2 copy" class="cls-1" d="M12,16V0H0V16L6,11.97Z"></path>
                                                                                        </svg>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="game_list">
                                                                                <div class="game_head">
                                                                                    <div class="mach_info">
                                                                                        <div class="time">01-19&nbsp;19:12</div>
                                                                                    </div>
                                                                                    <div class="title_area">
                                                                                        <h3>Mersey Blues <span>-</span> East End Utd</h3>
                                                                                        <h4>가상축구 [프리미어]</h4>
                                                                                    </div>
                                                                                    <span class="favortes"><!-- 클릭시 <span class='favortes on'>-->
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 30" fill="currentColor">
                                                                                            <path class="cls-1" d="M15.4,1.221c0.884-1.654,2.331-1.654,3.215,0L22.8,9.064l9.374,1.258c1.977,0.265,2.424,1.535.993,2.823l-6.783,6.1,1.6,8.62c0.338,1.818-.833,2.6-2.6,1.744L17,25.543l-8.385,4.07c-1.768.858-2.938,0.073-2.6-1.744l1.6-8.62-6.783-6.1c-1.43-1.287-.983-2.558.994-2.823L11.2,9.064Z"></path>
                                                                                        </svg>
                                                                                    </span>
                                                                                </div>
                                                                                <div id="box_detail_2664_202101191855081996" class="bet_box box_col_2664_202101191855081996">
                                                                                    <div class="colum01" style="width:100%;">
                                                                                        <div class="box01">
                                                                                            <div class="btn_area">
                                                                                                <button id="chk_822260_1" class="btn_bet01 menuOff_magam">2.80</button>
                                                                                            </div>
                                                                                            <div class="btn_area">
                                                                                                <button id="chk_822260_3" class="btn_bet01 menuOff_magam">2.75</button>
                                                                                            </div>
                                                                                            <div class="btn_area">
                                                                                                <button id="chk_822260_2" class="btn_bet01 menuOff_magam">2.49</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- 닫힘 확임 -->
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="game_title">
                                                                                <h4><img src="/10bet/images/10bet/ico/ico_virtual_01.png" alt="ico"> BET365</h4>
                                                                                <div class="title_area">
                                                                                    <div class="title01" style="width:100%;">Match Result (1X2)</div>
                                                                                    <!--<div class='title02'>Total Goals Over/Under</div><div class='title03'>Handicap</div>-->
                                                                                </div>
                                                                                <div class="bookmark">
                                                                                    <span><!-- 클릭시 <span class='on'> -->
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 16" fill="currentColor">
                                                                                            <path id="Shape_2_copy" data-name="Shape 2 copy" class="cls-1" d="M12,16V0H0V16L6,11.97Z"></path>
                                                                                        </svg>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="game_list">
                                                                                <div class="game_head">
                                                                                    <div class="mach_info">
                                                                                        <div class="time">01-19&nbsp;20:35</div>
                                                                                    </div>
                                                                                    <div class="title_area">
                                                                                        <h3>Honduras <span>-</span> Chile</h3>
                                                                                        <h4>가상축구 [월드컵]</h4>
                                                                                    </div>
                                                                                    <span class="favortes"><!-- 클릭시 <span class='favortes on'>-->
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 30" fill="currentColor">
                                                                                            <path class="cls-1" d="M15.4,1.221c0.884-1.654,2.331-1.654,3.215,0L22.8,9.064l9.374,1.258c1.977,0.265,2.424,1.535.993,2.823l-6.783,6.1,1.6,8.62c0.338,1.818-.833,2.6-2.6,1.744L17,25.543l-8.385,4.07c-1.768.858-2.938,0.073-2.6-1.744l1.6-8.62-6.783-6.1c-1.43-1.287-.983-2.558.994-2.823L11.2,9.064Z"></path>
                                                                                        </svg>
                                                                                    </span>
                                                                                </div>
                                                                                <div id="box_detail_2663_202101192018092205" class="bet_box box_col_2663_202101192018092205">
                                                                                    <div class="colum01" style="width:100%;">
                                                                                        <div class="box01">
                                                                                            <div class="btn_area">
                                                                                                <button id="chk_822370_1" class="btn_bet01 menuOff" onclick="check_bet(822370, '1')">3.70</button>
                                                                                            </div>
                                                                                            <div class="btn_area">
                                                                                                <button id="chk_822370_3" class="btn_bet01 menuOff" onclick="check_bet(822370, '3')">2.75</button>
                                                                                            </div>
                                                                                            <div class="btn_area">
                                                                                                <button id="chk_822370_2" class="btn_bet01 menuOff" onclick="check_bet(822370, '2')">1.87</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- 닫힘 확임 -->
                                                                        </td>
                                                                    </tr>
                                                                </table>
                				                            </td>
                                                <div style="text-align:center;"> </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- 게시판 목록 끝 -->
          
                            </td>
                        
                            </tr>
                        
                        </table>
                        </td>
                        
                        </tr>
                        
                    </table>
                        </td>
                            
                            </tr>
                            </td>
                            </tr>
                        </table>
                        </td>
                        </tr>
                    </table>
                    </form>
                    
                    </td>
                    
                    </tr>
                    
                </table>
                    </td>
            </td>
        </tr>
    </table>

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
            <input type="hidden" name="bo_table" value="a91">
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
                        <li>최대배팅금액<span>2,000,000</span></li>
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
<script language='javascript' src='/10bet/js/filter.js'></script>
<!-- 헤더 -->
<script type="text/JavaScript">
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
    $j(function(){
        MM_preloadImages('/images/sc01on.png','/images/sc02on.png','/images/sc03on.png');
    });

    function change_soc(url,name) {
    $j('#bet365').attr('src',url);
    $j('.button_type01').removeClass('on');
    $j('.'+name).addClass('on');
        change_team(name);
    }
</script>
<style>
    .virtual_sports .btn_box button {width:24.5%;}
</style>
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

        /*if(f.wr_10.value == "환전신청")
        {
            f.wr_8.value = f.wr_8.value - f.wr_content.value;
        }*/
        
        //$j("#check_bg").show();	
        //$j("#submit_btn").hide();	
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
</div>