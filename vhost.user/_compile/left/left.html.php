
<!-- left 메뉴 -->
<?php 
$isApi = isset($TPL_VAR["api"]) ? $TPL_VAR["api"] : "";
if($isApi == "true")  {?>
    <div id="left_section" style="top:0px;">
<?php } else { ?>
    <div id="left_section">
<?php } ?>
    <div class="left_box">
        <?php 
        if($TPL_VAR["page_type"] == "mini") { ?>
            <div class="other_menu_list	box_type01">
                <!-- 메뉴 리스트	-->
                <ul class="mune_list01">
                <?php 
                if($TPL_VAR["miniSetting"]["power_use"]==1){?>
                    <li>
                        <?php if($TPL_VAR["api"] == "true") { ?>
                            <a href="/api/game_list?game=power&userid=<?=$TPL_VAR["uid"]?>">
                        <?php } else { ?>
                            <a href="/game_list?game=power">
                        <?php } ?>
                            <div class="menu01 <?= $TPL_VAR["game_type"] == 'power' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_powerball_01.png" alt="ico" /> 
                                파워볼									
                            </div>
                        </a>
                    </li>
                <?php } 
                if($TPL_VAR["miniSetting"]["powersadari_use"]==1){?>
                    <li>
                        <?php if($TPL_VAR["api"] == "true") { ?>
                            <a href="/api/game_list?game=psadari&userid=<?=$TPL_VAR["uid"]?>">
                        <?php } else { ?>
                            <a href="/game_list?game=psadari">
                        <?php } ?>
                            <div class="menu01 <?= $TPL_VAR["game_type"] == 'psadari' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_powersadari_01.png" alt="ico" /> 
                                파워사다리									
                            </div>
                        </a>
                    </li>
                <?php } 
                if($TPL_VAR["miniSetting"]["kenosadari_use"]==1){?>
                    <li>
                        <a href="/game_list?game=kenosadari">
                            <div class="menu01 <?= $TPL_VAR["game_type"] == 'kenosadari' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_powersadari_01.png" alt="ico" /> 
                                키노사다리									
                            </div>
                        </a>
                    </li>
                <?php } 
                if($TPL_VAR["miniSetting"]["fx_use"]==1){?>
                    <li>
                        <a href="/game_list?game=fx&min=1">
                            <div class="menu01 <?= $TPL_VAR["min"] == '1' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                                FX1분									
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/game_list?game=fx&min=2">
                            <div class="menu01 <?= $TPL_VAR["min"] == '2' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                                FX2분									
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/game_list?game=fx&min=3">
                            <div class="menu01 <?= $TPL_VAR["min"] == '3' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                                FX3분									
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/game_list?game=fx&min=4">
                            <div class="menu01 <?= $TPL_VAR["min"] == '4' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                                FX4분									
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/game_list?game=fx&min=5">
                            <div class="menu01 <?= $TPL_VAR["min"] == '5' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                                FX5분									
                            </div>
                        </a>
                    </li>
                <?php } 
                if($TPL_VAR["miniSetting"]["choice_use"]==1){?>                        
                    <li>
                        <a href="/game_list?game=choice">
                            <div class="menu01 <?= $TPL_VAR["game_type"] == 'choice' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_sky_01.png" alt="ico" /> 
                                초이스									
                            </div>
                        </a>
                    </li>
                <?php } 
                if($TPL_VAR["miniSetting"]["roulette_use"]==1){?>                        
                    <li>
                        <a href="/game_list?game=roulette">
                            <div class="menu01 <?= $TPL_VAR["game_type"] == 'roulette' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_hand.png" alt="ico" /> 
                                룰렛									
                            </div>
                        </a>
                    </li>
                <?php } 
                if($TPL_VAR["miniSetting"]["pharah_use"]==1){?>                        
                    <li>
                        <a href="/game_list?game=pharaoh">
                            <div class="menu01 <?= $TPL_VAR["game_type"] == 'pharaoh' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_bubble.png" alt="ico" />
                                파라오									
                            </div>
                        </a>
                    </li>
                <?php } 
                if($TPL_VAR["miniSetting"]["dari2_use"]==1){?>    
                    <li>
                        <a href="/game_list?game=2dari">
                            <div class="menu01 <?= $TPL_VAR["game_type"] == '2dari' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_sky_01.png" alt="ico" /> 
                                이다리									
                            </div>
                        </a>
                    </li>
                <?php } 
                if($TPL_VAR["miniSetting"]["dari3_use"]==1){?>                        
                    <li>
                        <a href="/game_list?game=3dari">
                            <div class="menu01 <?= $TPL_VAR["game_type"] == '3dari' ? 'on' : ''; ?>">
                                <img src="/10bet/images/10bet/ico/ico_sky_01.png" alt="ico" /> 
                                삼다리									
                            </div>
                        </a>
                    </li>
                <?php } ?>
                </ul>
            </div>
        <?php } else if($TPL_VAR["page_type"] == "casino" || $TPL_VAR["page_type"] == "slot") { ?>
            <script>
                function casino_left() {
                    var dis = $j(".casino_menu").css('display');

                    if(dis == 'none') {
                        $j(".menu_list02").slideUp();
                        $j(".casino_menu").slideDown();
                    }else {
                        $j(".casino_menu").slideUp();
                    }
                }
                function slot_left() {
                    var dis2 = $j(".slot_menu").css('display');

                    
                    if(dis2 == 'none') {
                        $j(".menu_list02").slideUp();
                        $j(".slot_menu").slideDown();
                    }else {
                        $j(".slot_menu").slideUp();
                    }
                }
            </script>
            <!-- 카지노_슬롯 리스트 -->
            <div class="casino_slot_list box_type01">
                <!-- 메뉴 리스트	-->
                <ul class="mune_list01">
                    <li>
                        <?php 
                        if($TPL_VAR["page_type"] == "casino") { ?>
                            <div class="menu01 on" onclick="casino_left();">라이브카지노</div>
                        <?php } else if($TPL_VAR["page_type"] == "slot") { ?>
                            <div class="menu01" onclick="location.href='/casino';">라이브카지노</div>
                        <?php }
                        ?>
                        <ul class="menu_list02 casino_menu" style="display: <?=($TPL_VAR["page_type"] == "casino") ? "block" : "none"?>;">
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=pr'">
                                    <span class="ico01"><img src="/10bet/images/10bet/slot_ico_01.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">프로그마틱</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=mc'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_01.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">마이크로</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=ev'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_05.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">에볼루션</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=ab'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_04.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">올벳</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=wm'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_02.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">WM</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=ag'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_06.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">아시아</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=og'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_17.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">오리엔탈</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=xm&amp;ctype=dr'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_15.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">드림게임</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=xm&amp;ctype=vv'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_11.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">VIVO</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=xm&amp;ctype=sx'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_16.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">섹시카지노</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=xm&amp;ctype=bb'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_10.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">BBIN</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=xm&amp;ctype=ho'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_09.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">HO게이밍</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=cg&amp;ctype=cg'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_08.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">카가얀</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=cg&amp;ctype=md'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_07.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">마이다스</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=cg&amp;ctype=88'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_13.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">88카지노</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=cg&amp;ctype=od'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_12.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">오카다</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=cg&amp;ctype=nw'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_14.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">뉴마카오</span>
                                </div>
                            </li>
                            <li>
                                <div class="menu02 " onclick="location.href='/bbs/casino_open.php?ptype=cg&amp;ctype=wt'">
                                    <span class="ico01"><img src="/10bet/images/10bet/casino_ico_wt.png" alt="" class="mCS_img_loaded"></span>
                                    <span class="name01">월드카지노</span>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <?php 
                        if($TPL_VAR["page_type"] == "casino") { ?>
                            <div class="menu01" onclick="location.href='/slot';">슬롯게임</div>
                        <?php } else if($TPL_VAR["page_type"] == "slot") { ?>
                            <div class="menu01 on" onclick="slot_left();">슬롯게임</div>
                        <?php }
                        ?>
                        <ul class="menu_list02 slot_menu" style="display: <?=($TPL_VAR["page_type"] == "slot") ? "block" : "none"?>;">
                        <?php 
                        if(isset($TPL_VAR["slot_company_list"]) && count($TPL_VAR["slot_company_list"]) > 0) {
                            foreach($TPL_VAR["slot_company_list"] as $item) { ?>
                                <li>
                                    <div class="menu02 slot_submenu_<?=$item['nCode']?> " onclick="getSlotGameList(<?=$item['nCode']?>,'<?=$item['strName']?>')">
                                        <span class="ico01"><img src="/10bet/images/10bet/slot_ico_<?=$item["nCode"]?>.png?v=1" alt="" class="mCS_img_loaded"></span>
                                        <span class="name01"><?=$item["strName"]?></span>
                                    </div>
                                </li>
                        <?php    }
                        }
                        ?>
                        </ul>
                    </li>
                </ul>
            </div>
        <?php } else { ?>
            <!-- 스포츠 리스트 -->
            <div class="sports_menu_list box_type01" style="font-size: 14px !important; padding-top: 0px;">
                <h3>오늘의 경기 
                    <?php
                    // if($TPL_VAR['game_type'] == "multi" && $TPL_VAR['s_type'] == "2") 
                    //     echo "<span class='cor01'>SPORT-2</span>";
                    // else 
                    //     echo "<span class='cor01'>SPORT-1</span>";
                        echo "<span class='cor01'>스포츠</span>";
                    ?>
                    <span class="date"><?=date('Y-m-d')?></span>
                </h3>
                <ul id="sports_league_ul" class="main_left sports_league_ul">
                    <li class="soc li-height">
                        <img src="/10bet/images/10bet/ico/football-ico.png" alt="ico" style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                            <span class="name pc-name">축구</span>
                            <span class="count count-top on total_count_soccer">0</span>
                        </a>
                    </li>
                    <div class="div_soccer">
                    </div>

                    <li class="bask li-height">
                        <img src="/10bet/images/10bet/ico/basketball-ico.png" alt="ico"  style="margin-top:14px;">
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name pc-name">농구</span>
                        <span class="count count-top on total_count_basketball">0</span>
                        </a>
                    </li>
                    <div class="div_bask">
                    </div>

                    <li class="base li-height">
                        <img src="/10bet/images/10bet/ico/baseball-ico.png" alt="ico"  style="margin-top:14px;"/>
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name pc-name">야구</span>
                        <span class="count count-top on total_count_baseball">0</span></a>
                    </li>
                    <div class="div_base">
                    </div>

                    <li class="hock li-height">
                        <img src="/10bet/images/10bet/ico/hockey-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name pc-name">아이스 하키</span>
                        <span class="count count-top on total_count_icehocky">0</span></a>
                    </li>
                    <div class="div_hock">
                    </div>

                    <li class="val li-height">
                        <img src="/10bet/images/10bet/ico/volleyball-ico.png" alt="ico"  style="margin-top:14px;"/>
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>

                        <span class="name pc-name">배구</span>
                        <span class="count count-top on total_count_volleyball">0</span></a>
                    </li>
                    <div class="div_val">
                    </div>

                    <li class="espo li-height">
                        <img src="/10bet/images/10bet/ico/esport-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="javascript:void(0)" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        
                        <span class="name pc-name">E-sports</span>
                        <span class="count count-top on total_count_espo">0</span></a>
                    </li>
                    <div class="div_espo">
                    </div>

                    <li class="tenn li-height">
                        <img src="/10bet/images/10bet/ico/tennis-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=<?=$TPL_VAR['game_type']?>&sport=tennis" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        <span class="name pc-name">테니스</span>
                        <?php
                            $bChk = false;
                            foreach($TPL_VAR["game_count_info"] as $info) {
                                if($info['sport_name'] == '테니스') {
                                    echo '<span class="count count-top tenn on">'.$info['nCnt'];
                                    $bChk = true;
                                break;
                                }
                            }
                            if(!$bChk) {
                                echo '<span class="count count-top tenn">0';
                            }
                        ?></span></a>
                    </li>
                    <li class="hand li-height">
                        <img src="/10bet/images/10bet/ico/handball-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=<?=$TPL_VAR['game_type']?>&sport=handball" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        
                        <span class="name pc-name">핸드볼</span>
                        <span class="count count-top hand">0</span></a>
                    </li>
                    <li class="motor li-height">
                        <img src="/10bet/images/10bet/ico/motor-sport-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=<?=$TPL_VAR['game_type']?>&sport=mortor" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        
                        <span class="name pc-name">모터 스포츠</span>
                        <span class="count count-top motor">0</span></a>
                    </li>
                    <li class="rub li-height">
                        <img src="/10bet/images/10bet/ico/rugby-league-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=<?=$TPL_VAR['game_type']?>&sport=rugby" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        
                        <span class="name pc-name">럭비</span>
                        <span class="count count-top rub">0</span></a>
                    </li>
                    <li class="cri li-height">
                        <img src="/10bet/images/10bet/ico/speedway-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=<?=$TPL_VAR['game_type']?>&sport=criket" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        
                        <span class="name pc-name">크리켓</span>
                        <span class="count count-top cri">0</span></a>
                    </li>
                    <li class="dart li-height">
                        <img src="/10bet/images/10bet/ico/darts-ico.png" alt="ico"  style="margin-top:14px;"/>
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=<?=$TPL_VAR['game_type']?>&sport=darts" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?> 
                        
                        <span class="name pc-name">다트</span>
                        <span class="count count-top dart">0</span></a>
                    </li>
                    <li class="foot li-height">
                        <img src="/10bet/images/10bet/ico/futsal-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=<?=$TPL_VAR['game_type']?>&sport=futsal" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>

                        <span class="name pc-name">풋살</span>
                        <span class="count count-top foot">0</span></a>
                    </li>
                    <li class="ton li-height">
                        <img src="/10bet/images/10bet/ico/tabletennis-ico.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=<?=$TPL_VAR['game_type']?>&sport=badminton" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>
                        
                        <span class="name pc-name">배드민턴</span>
                        <span class="count count-top ton">0</span></a>
                    </li>
                    <li class="etc li-height">
                        <img src="/10bet/images/10bet/logo_01.png" alt="ico"  style="margin-top:14px;"/> 
                        <?php if(count((array)$_SESSION['member']) > 0) { ?>
                            <a href="/game_list?game=<?=$TPL_VAR['game_type']?>&sport=etc" style="color: white;">
                        <?php } else { ?>
                            <a href="javascript:login_open();" style="color: white;">
                        <?php } ?>

                        <span class="name pc-name">기타</span>
                        <span class="count count-top etc">0</span></a>
                    </li>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>
