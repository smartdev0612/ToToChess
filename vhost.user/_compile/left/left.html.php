
<!-- left 메뉴 -->
<?php 
$isApi = isset($TPL_VAR["api"]) ? $TPL_VAR["api"] : "";
if($isApi == "true")  {?>
    <div id="left_section" style="top:0px;">
<?php } else { ?>
    <div id="left_section">
<?php } ?>
    <div class="left_box">
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
                        <a href="/game_list?game=<?=$TPL_VAR['game_type']?>&sport=esports" style="color: white;">
                    <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                    <?php } ?>
                    
                    <span class="name pc-name">E스포츠</span>
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
    </div>
</div>
