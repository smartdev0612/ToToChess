 
    <div class="mask"></div>
	    <div id="container">

        <script type="text/javascript" src="/10bet/js/left.js?1610345806"></script>
        <script type="text/javascript" src="/include/js/betting_list.js?v=13"></script>
        <link rel="stylesheet" type="text/css" href="/BET38/pc/_css/layout.css?v=516">
        <link rel="stylesheet" type="text/css" href="/BET38/pc/_css/btns.css?v=511">
        <link rel="stylesheet" type="text/css" href="/BET38/css/etc.css?v=514">
        <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.structure.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.theme.min.css"> -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <link rel="stylesheet" href="/BET38/css/font-awesome-animation.min.css">
        <style>
            .padding-top-5 {
                padding-top: 5px;
            }
            .top-3 {
                top: 3px;
            }
            .img-top {
                top: 4px;
            }
            .pointer {
                cursor: pointer;
            }
        </style>
<div id="contents">
<div class="st_cont_bg">	
  <!-- CONTAINER TITLE-->
<!--<div class="st_tit_bg">
	<img src="/pc/_img/c_tit_bl.png" class="st_padr5"> 베팅내역 BETTING LIST
</div>-->
<!--// CONTAINER TITLE-->
<!-- CONTAINER AREA-->
<div class="st_b_cont_bg clearfix">
<!-- CONTAINER AREA LIST-->
<!-- CONTAINER T TABS-->
<div class="g_tabs_bet">
	<div class="g_tabs_bet_tit">
		베팅내역 BETTING LIST
	</div>
	   <ul>
           <input type="hidden" id="type" value="<?=$TPL_VAR['type']?>">
		   <a href="javascript:void(0)" onclick="getBettingList(1,1,0)"><li class="g_tabs_170 bt_off tab_sport <?=$TPL_VAR["type"] == 1 ? "act" : ""?>">스포츠</li></a>
		   <a href="javascript:void(0)" onclick="getBettingList(2,1,0)"><li class="g_tabs_170 bt_off tab_live <?=$TPL_VAR["type"] == 2 ? "act" : ""?>">라이브</li></a>
		   <a href="javascript:void(0)" onclick="getBettingList(3,1,0)"><li class="g_tabs_170 bt_off tab_minigame <?=$TPL_VAR["type"] == 3 ? "act" : ""?>">미니게임</li></a>
	   </ul>
	   <div class="clear"></div>
	</div>
	<!-- CONTAINER T TABS-->
	<!-- CONTAINER AREA T TIT-->
	<div class="_width_100" style="height: 969px;">
		<div class="scroll-wrapper scrollbar-center" style="position: relative;">
            <div class="scrollbar-center scroll-content scroll-scrolly_visible" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 859px;">
			    <div class="st_b_tit3"><img class="st_marr5" src="/BET38/pc/_img/c_tit_bl2.png">
                    <span id="betType">
                        <?php 
                        if($TPL_VAR["type"] == 1)
                            echo "스포츠&nbsp;";
                        else if($TPL_VAR["type"] == 2)
                            echo "라이브&nbsp;";
                        else if($TPL_VAR["type"] == 3)
                            echo "미니게임&nbsp;";
                        ?>
                    </span> 
                    베팅내역
                </div>
                <!--// CONTAINER AREA T TIT-->
                <!-- BETTING LIST-->
                <div id="betting_list">
                    <?php 
                    if(count($TPL_VAR["list"]) > 0) {
                        foreach($TPL_VAR["list"] as $TPL_K1 => $TPL_V1) { 
                            $table = "";
                            $table .= '<table class="st10">
                                        <colgroup>
                                            <col style="width: 12%;">
                                            <col style="width: 22%;">
                                            <col style="width: 19%;">
                                            <col style="width: 11%;">
                                            <col style="width: 17%;">
                                            <col style="width: 6%;">
                                            <col style="width: 6%;">
                                            <col>
                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th scope="col">경기시간</th>
                                                <th scope="col">리그명</th>
                                                <th scope="col">홈팀 VS 원정팀</th>
                                                <th scope="col">타입</th>
                                                <th scope="col">베팅팀</th>
                                                <th scope="col">스코어</th>
                                                <th scope="col">배당</th>
                                                <th class="last" scope="col">상태</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                    
                            if(count($TPL_V1["item"]) > 0) {
                                $battingJT = "0";
                                foreach ( $TPL_V1["item"] as $TPL_V2 ) {
                                    if ( $TPL_V2["home_rate"] < 1.01 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
                                        $TPL_V2["home_rate"] = $TPL_V2["game_home_rate"];
                                        $TPL_V2["draw_rate"] = $TPL_V2["game_draw_rate"];
                                        $TPL_V2["away_rate"] = $TPL_V2["game_away_rate"];
                                        $battingJT = "1";
                                    }
                                    $table .= '<tr data-game_id="1731940" data-fid="6967104" data-mid="1" data-gb_id="25322682" data-betid="20609690316967104">';
                                    $table .= '<td>' . $TPL_V2["gameDate"] . ' ' . $TPL_V2["gameHour"] . ' : ' . $TPL_V2["gameTime"] . '</td>';
                                    $table .= '<td class="txt_left st_padl5">';
                                    $table .= '<img src="/BET38/_icon/sport/S' . $TPL_V2["sport_id"] . '.png" width="23">&nbsp;';
                                    if($TPL_V2["league_image"] == "")
                                        $table .= '<img src="/BET38/_icon/etc.svg" width="23">&nbsp;';
                                    else 
                                        $table .= '<img src="' . $TPL_V2["league_image"] . '" width="23">&nbsp;&nbsp;';
                                    $table .= '<span>' . $TPL_V2["league_name"] . '</span>'; 
                                    $table .= '</td>';
                                    $table .= '<td class="txt_left st_padl5">';
                                    $table .= '<div>';
                                    $table .= '<span class="txt_co6">홈팀</span> : ' . $TPL_V2["home_team"];
                                    $table .= '</div>';
                                    $table .= '<div class="padding-top-5"><span class="txt_co71">원팀</span> : ' . $TPL_V2["away_team"]  . '</td></div>';
                                    $pieces = explode("|", $TPL_V2["mname_ko"]);
                                    switch($TPL_V2["sport_id"]) {
                                        case 6046: // 축구
                                            $table .= '<td>' . $pieces[0] . '</td>';
                                            break;
                                        case 48242: // 농구
                                            $table .= '<td>' . $pieces[1] . '</td>';
                                            break;
                                        case 154914: // 야구
                                            $table .= '<td>' . $pieces[2] . '</td>';
                                            break;
                                        case 154830: // 배구
                                            $table .= '<td>' . $pieces[3] . '</td>';
                                            break;
                                        case 35232: // 아이스 하키
                                            $table .= '<td>' . $pieces[4] . '</td>';
                                            break;
                                        default:
                                            $table .= '<td>' . $pieces[0] . '</td>';
                                            break;
                                    }
                                    $table .= '<td class="txt_ac st_padl5">';
                                    switch($TPL_V2["mfamily"]) {
                                        case "1":
                                        case "2":
                                            if($TPL_V2["select_no"] == "1")
                                                $table .= '<span class="txt_co6">(홈)</span>  ' . $TPL_V2["home_team"];
                                            else if($TPL_V2["select_no"] == "2") 
                                                $table .= '<span class="txt_co6">(원)</span>  ' . $TPL_V2["away_team"];                       
                                            else if($TPL_V2["select_no"] == "3")                        
                                                $table .= '(무) 무승부'; 
                                            break;
                                        case "7":
                                            if($TPL_V2["select_no"] == "1") {
                                                $table .= '언더 <span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
                                            } else if($TPL_V2["select_no"] == "2") {
                                                $table .= '오버 <span class="txt_co6">(' . $TPL_V2["away_line"] . ')</span>'; 
                                            }
                                            break;
                                        case "8":
                                            if($TPL_V2["select_no"] == "1") {
                                                $home_line = explode(" ", $TPL_V2["home_line"]);
                                                $table .= $TPL_V2["home_team"] . '<span class="txt_co6">(' . $home_line[0] . ')</span>';
                                            } else if($TPL_V2["select_no"] == "2") {
                                                $away_line = explode(" ", $TPL_V2["away_line"]);
                                                $table .= $TPL_V2["away_team"] . '<span class="txt_co6">(' . $away_line[0] . ')</span>'; 
                                            }
                                            break;
                                        case "10":
                                            if($TPL_V2["select_no"] == "1")
                                                $table .= '홀수';
                                            else if($TPL_V2["select_no"] == "2") 
                                                $table .= '짝수'; 
                                            break;
                                        case "11":
                                            $table .= $TPL_V2["home_name"];
                                            break;
                                        case "12":
                                            if($TPL_V2["select_no"] == "1")
                                                $table .= '승무';
                                            else if($TPL_V2["select_no"] == "2") 
                                                $table .= '무패';                       
                                            else if($TPL_V2["select_no"] == "3")                        
                                                $table .= '승패'; 
                                            break;
                                        case "47":
                                            if($TPL_V2["home_name"] == "1 And Under")
                                                $table .= '홈승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
                                            else if($TPL_V2["home_name"] == "1 And Over") 
                                                $table .= '홈승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';                       
                                            else if($TPL_V2["home_name"] == "2 And Under")                        
                                                $table .= '원정승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>'; 
                                            else if($TPL_V2["home_name"] == "2 And Over")
                                                $table .= '원정승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
                                            else if($TPL_V2["home_name"] == "3 And Under")
                                                $table .= '무 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
                                            else if($TPL_V2["home_name"] == "3 And Over")
                                                $table .= '무 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
                                            break;
                                    }
                                              
                                    $table .= '</td>';
                                    $table .= '<td><span class="txt_co6">' . $TPL_V2["home_score"] . ':' . $TPL_V2["away_score"] . '</span></td>';
                                    $table .= '<td>' . $TPL_V2["select_rate"] . ' 배</td>';
                                    if($battingJT)
                                        $table .= '<td rowspan="1"><span class="bt_none5 bt_45_none">적특</span></td>';
                                    else if($TPL_V2["result"] == "1")
                                        $table .= '<td rowspan="1"><span class="bt_none6 bt_45_none">당첨</span></td>';
                                    else if($TPL_V2["result"] == "2")
                                        $table .= '<td rowspan="1"><span class="bt_none3 bt_45_none">낙첨</span></td>';
                                    else if($TPL_V2["result"] == "4")
                                        $table .= '<td rowspan="1"><span class="bt_none5 bt_45_none" style="color:#e44e4e !important;">취소</span></td>';
                                    else 
                                        $table .= '<td rowspan="1"><span class="bt_none1 bt_45_none">진행</span></td>';
                                    $table .= '</tr>';
                                    $table .= '<tr id="Fid2996007" class="st_hide_list"></tr>';     
                                } 
                            }
                            
                            $table .= '</tbody>
                                    </table>
                                    <div class="st_b_result" data-oid="1605133">';
                            $table .= '베팅접수시간 : <span class="txt_co3 st_padr10">' . $TPL_V1["bet_date"] . '</span>';
                            $table .= '예상당첨금액 : <span class="txt_co3 st_padr10">(베팅 ' . $TPL_V1["betting_money"] . ' x 배당 ' . $TPL_V1["result_rate"] .') = ' . $TPL_V1["win_money"] . '</span>';
                            $table .= '결과당첨금액 : <span class="txt_co3 st_padr10">' . $TPL_V1["result_money"] . '</span>';
                            
                            if($TPL_V1["result"] == "1") {
                                $table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=hide_bet('" . $TPL_K1 . "')>베팅내역삭제</span>";
                                $table .= '<span class="bt_45_none bt_none6 f_right st_mart5">당첨</span>';
                            } else if($TPL_V1["result"] == "2") {
                                $table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=hide_bet('" . $TPL_K1 . "')>베팅내역삭제</span>";
                                $table .= '<span class="bt_45_none bt_none3 f_right st_mart5">낙첨</span>';
                            } else if($TPL_V1["result"] == "4") {
                                $table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=hide_bet('" . $TPL_K1 . "')>베팅내역삭제</span>";
                                $table .= '<span class="bt_45_none bt_none5 f_right st_mart5" style="color:#e44e4e !important;">취소</span>';
                            } else {
                                if($TPL_VAR["type"] != 2)
                                    $table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=cancel_bet('" . $TPL_K1 . "')>베팅취소</span>";
                                $table .= '<span class="bt_45_none bt_none1 f_right st_mart5">진행</span>';
                            }
                            $table .= '</td></div>';

                            echo $table;
                        }
                    }
                    ?>
                </div>
                
                <!--// BETTING LIST-->
                <?php
                    if(count($TPL_VAR["list"]) > 0) { ?>
                        <div class="bbs_btn_area clearfix">
                            <!-- <div class="f_right bt_150 bt_gray st_marr10 pointer" onclick="hide_all_betting()">
                                <span class="bt_100_txt">베팅내역 전체삭제</span>
                            </div> -->
                        <!--<div class="f_right bt_120 bt_gray txt_size1 st_marl10 st_marr10  pointer" onclick="sendBoard()"><span class="bt_120_txt">베팅첨부</span></div>-->
                        </div>
                <?php 
                    }
                ?>
                <!--// CONTAINER AREA LIST-->
                <!-- PAGEING-->
                
                <div class="pagination pagination-centered">
                    <ul>
                    <?php
                    if(count($TPL_VAR["list"]) > 0) { 
                        for($i = 0; $i < count($TPL_VAR["list"]) / 20; $i++) { 
                            if($i == 0) { ?>
                                <li class="page p_<?=$i?> active"><a href="javascript:void(0)" onclick="goPage(1,<?=$i?>)"><?=$i + 1?></a></li>
                    <?php   } else { ?>
                                <li class="page p_<?=$i?>"><a href="javascript:void(0)" onclick="goPage(1,<?=$i?>)"><?=$i + 1?></a></li>
                    <?php   }
                        } 
                    }
                    ?>
                    </ul>
                </div>
                <div class="_h100"></div>
		    </div><div class="scroll-element scroll-x scroll-scrolly_visible"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="width: 100px;"></div></div></div><div class="scroll-element scroll-y scroll-scrolly_visible"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="height: 39px; top: 0px;"></div></div></div></div>
	</div>
</div>
</div>
</div>
