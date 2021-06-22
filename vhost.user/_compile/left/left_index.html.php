<!-- <script type="text/javascript" src="/10bet/js/left.js?1610361882"></script> -->
<!-- left 메뉴 -->
<div id="left_section">
    <div class="left_box">
        <style>
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
                margin-top:7px;
                margin-right:10px;
            }
            .span-badge {
                float: right;
                margin-right:10px;
                margin-top:-5px;
                color:white;
            }
            .sub-ul {
                width:95%; 
                margin-left:13px;
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
        </style>
        
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
                        <span class="count count-top soc on total_count_soccer">0</span>
                    </a>
                </li>
                <div class='div_soccer'>
                </div>

                <li class="bask li-height">
                    <img src="/10bet/images/10bet/ico/basketball-ico.png" alt="ico"  style="margin-top:14px;">
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                    <a href="javascript:void(0)" style="color: white;">
                    <?php } else { ?>
                    <a href="javascript:login_open();" style="color: white;">
                    <?php } ?>
                    <span class="name pc-name">농구</span>
                    <span class="count count-top soc on total_count_basketball">0</span></a>
                </li>
                <div class='div_bask'>
                </div>

                <li class="base li-height">
                    <img src="/10bet/images/10bet/ico/baseball-ico.png" alt="ico"  style="margin-top:14px;"/>
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                    <a href="javascript:void(0)" style="color: white;">
                    <?php } else { ?>
                    <a href="javascript:login_open();" style="color: white;">
                    <?php } ?>
                    <span class="name pc-name">야구</span>
                    <span class="count count-top soc on total_count_baseball">0</span></a>
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
                    <span class="count count-top soc on total_count_icehocky">0</span>
                    </a>
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
                    <span class="count count-top soc on total_count_volleyball">0</span>
                    </a>
                </li>
                <div class="div_val">
                </div>
                
                <li class="tenn li-height">
                    <img src="/10bet/images/10bet/ico/tennis-ico.png" alt="ico"  style="margin-top:14px;"/> 
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
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
                        <a href="javascript:void(0)" style="color: white;">
                    <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                    <?php } ?>
                    
                    <span class="name pc-name">핸드볼</span>
                    <span class="count count-top hand">0</span></a>
                </li>
                <li class="motor li-height">
                    <img src="/10bet/images/10bet/ico/motor-sport-ico.png" alt="ico"  style="margin-top:14px;"/> 
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                    <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                    <?php } ?>
                    
                    <span class="name pc-name">모터 스포츠</span>
                    <span class="count count-top motor">0</span></a>
                </li>
                <li class="rub li-height">
                    <img src="/10bet/images/10bet/ico/rugby-league-ico.png" alt="ico"  style="margin-top:14px;"/> 
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                    <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                    <?php } ?>
                    
                    <span class="name pc-name">럭비</span>
                    <span class="count count-top rub">0</span></a>
                </li>
                <li class="cri li-height">
                    <img src="/10bet/images/10bet/ico/speedway-ico.png" alt="ico"  style="margin-top:14px;"/> 
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                    <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                    <?php } ?>
                    
                    <span class="name pc-name">크리켓</span>
                    <span class="count count-top cri">0</span></a>
                </li>
                <li class="dart li-height">
                    <img src="/10bet/images/10bet/ico/darts-ico.png" alt="ico"  style="margin-top:14px;"/>
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                    <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                    <?php } ?> 
                    
                    <span class="name pc-name">다트</span>
                    <span class="count count-top dart">0</span></a>
                </li>
                <li class="foot li-height">
                    <img src="/10bet/images/10bet/ico/futsal-ico.png" alt="ico"  style="margin-top:14px;"/> 
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                    <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                    <?php } ?>

                    <span class="name pc-name">풋살</span>
                    <span class="count count-top foot">0</span></a>
                </li>
                <li class="ton li-height">
                    <img src="/10bet/images/10bet/ico/tabletennis-ico.png" alt="ico"  style="margin-top:14px;"/> 
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                    <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                    <?php } ?>
                    
                    <span class="name pc-name">배드민턴</span>
                    <span class="count count-top ton">0</span></a>
                </li>
                <li class="espo li-height">
                    <img src="/10bet/images/10bet/ico/esport-ico.png" alt="ico"  style="margin-top:14px;"/> 
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
                    <?php } else { ?>
                        <a href="javascript:login_open();" style="color: white;">
                    <?php } ?>
                    
                    <span class="name pc-name">이스포츠</span>
                    <span class="count count-top espo">0</span></a>
                </li>
                <li class="etc li-height">
                    <img src="/10bet/images/10bet/logo_01.png" alt="ico"  style="margin-top:14px;"/> 
                    <?php if(count((array)$_SESSION['member']) > 0) { ?>
                        <a href="javascript:void(0)" style="color: white;">
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
<script>
    $j(document).ready(function() {
        ws.onopen = function (event) {
            packet = {
                "m_strSports"   :   "",
                "m_nLeague"     :   0,
                "m_nLive"       :   1,
                "m_nPageIndex"  :   0,
                "m_nPageSize"   :   30
            };

            sendPacket(PACKET_SPORT_LIST, JSON.stringify(packet));
        };
    });

    function onRevGameList(strPacket) {
        showJson = JSON.parse(strPacket);
    
        if(showJson.length > 0) {
            var jsonCountInfo = showJson[0].m_lstSportsCnt;
            showSportsTotalCount(jsonCountInfo, true);
        }
    }

    function onRecvAjaxList(strPacket) {
        var json = JSON.parse(strPacket);
        if(json.length > 0) {
            var jsonCountInfo = json[0].m_lstSportsCnt;
            showSportsTotalCount(jsonCountInfo, true);
        } 
    }

    function onClickLeague(nLeague) {
        // getGameList(0, "", nLeague, 0);
    }

    function onRecvAjaxList() {

    }

    function realTime() {

    }
</script>
	