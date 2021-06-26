<div class="mask"></div>
    <div id="container">

    <script type="text/javascript" src="/10bet/js/left.js?1610345806"></script>
    <script type="text/javascript" src="/include/js/betting_list.js?v=1"></script>
    <link rel="stylesheet" type="text/css" href="/BET38/mo/_css/default.css?v=510">
    <link rel="stylesheet" type="text/css" href="/BET38/mo/_css/m_layout.css?v=525">
    <link rel="stylesheet" type="text/css" href="/BET38/mo/_css/btns.css?v=511">
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
        .top-2 {
            top: 2px;
        }
        .pointer {
            cursor: pointer;
        }
    </style>
    <div id="contents">
        <div class="st_container" id="centerPage" style="position:relative; overflow-y:scroll; height: 617px; padding-bottom:120px;">
            <!-- TITLE -->
            <div class="st_tit_bg">베팅내역 BETTING  LIST</div>
            <!--// TITLE -->
            <!-- CONTAINER AREA-->
            <div class="st_b_cont_bg clearfix">
                <!-- CONTAINER AREA LIST-->
                <!-- CONTAINER T TABS-->
                <div class="g_tabs9">
                    <ul>
                        <input type="hidden" id="type" value="<?=$TPL_VAR['type']?>">
                        <a href="javascript:void(0)" onclick="getBettingList(1,0,0)"><li class="bt_off tab_sport <?=$TPL_VAR["type"] == 1 ? "act" : ""?>">스포츠</li></a>
                        <a href="javascript:void(0)" onclick="getBettingList(2,0,0)"><li class="bt_off tab_live <?=$TPL_VAR["type"] == 2 ? "act" : ""?>">라이브</li></a>
                        <a href="javascript:void(0)" onclick="getBettingList(3,0,0)"><li class="bt_off tab_minigame <?=$TPL_VAR["type"] == 3 ? "act" : ""?>">미니게임</li></a>
                    </ul>
                    <div class="clear"></div>
                </div>
                <!-- bet list -->
                <div class="st_b_tit3"><img src="/BET38/pc/_img/c_tit_bl2.png" class="st_marr5">
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
                    <!--  베팅 리스트  -->
                    <div id="betting_list">
                        <?php 
                        if(count($TPL_VAR["list"]) > 0) {
                            foreach($TPL_VAR["list"] as $TPL_K1 => $TPL_V1) { 
                                $table = "";
                                $table .= '<table class="st10">
                                                <colgroup>
                                                    <col style="width:30%">
                                                    <col style="width:30%">
                                                    <col style="width:30%">
                                                    <col style="width:10%">
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">리그/시간</th>
                                                        <th scope="col">팀명/베팅항목</th>
                                                        <th scope="col">타입/상태</th>
                                                        <th scope="col" class="last">결과</th>
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
                                        $table .= '<tr><td>';
                                        $table .= '<img src="/BET38/_icon/sport/S' . $TPL_V2["sport_id"] . '.png" width="20">&nbsp;';
                                        if($TPL_V2["league_image"] == "")
                                            $table .= '<img src="/BET38/_icon/etc.svg" width="20">&nbsp;';
                                        else 
                                            $table .= '<img src="' . $TPL_V2["league_image"] . '" width="20">&nbsp;';
                                        $table .= $TPL_V2["league_name"];
                                        $table .= '</td>';
                                        $table .= '<td class="_left">';
                                        $table .= '<span class="txt_co6">홈팀</span> : ' . $TPL_V2["home_team"] . '<br>';
                                        $table .= '<span class="txt_co71">원팀</span> : ' . $TPL_V2["away_team"] . '</td>';			
                                        $table .= '<td>' . $TPL_V2["mname_ko"] . '</td>';
                                        $table .= '<td class="td_de" rowspan="2">';
                                        if($battingJT)
                                            $table .= '<span class="bt_none5 bt_45_none txt_co23">적특</span>';
                                        else if($TPL_V2["result"] == "1")
                                            $table .= '<span class="bt_none6 bt_45_none txt_co23">당첨</span>';
                                        else if($TPL_V2["result"] == "2")
                                            $table .= '<span class="bt_none3 bt_45_none txt_co23">낙첨</span>';
                                        else if($TPL_V2["result"] == "4")
                                            $table .= '<span class="bt_none5 bt_45_none txt_co23">취소</span>';
                                        else 
                                            $table .= '<span class="bt_none1 bt_45_none txt_co23">진행</span>';
                                        $table .= '</td></tr>';
                                        
                                        $table .= '<tr>';
                                        $table .= '<td>' . $TPL_V2["gameDate"] . ' ' . $TPL_V2["gameHour"] . ' : ' . $TPL_V2["gameTime"] . '</td>';
                                        $table .= '<td class="_left">';		 
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
                                        $table .= '<td>점수 : <span class="txt_co6">' . $TPL_V2["home_score"] . ':' . $TPL_V2["away_score"] . '</span></td>';
                                        $table .= '</tr>';
                                        $table .= '<tr id="Fid3628815" class="st_hide_list"></tr>';
                                    }
                                }
                                $table .= '</tbody>
                                        </table>
                                        <div class="betting_cart_btn4 clearfix"><ul>';
                                $table .= '<li class="betting_cart_40 betting_cart_bgno">베팅시간 : <span class="txt_co6">' . substr($TPL_V1["bet_date"], 5) . '</span></li>';
                                $table .= '<li class="betting_cart_40 betting_cart_bgno">베팅금 : <span class="txt_co6 st_marr15">' . $TPL_V1["betting_money"] . ' 원</span></li>';
                                $table .= '<li class="betting_cart_40 betting_cart_bgno">배당률 : <span class="txt_co6">' . $TPL_V1["result_rate"] .'</span></li>';
                                $table .= '<li class="betting_cart_40 betting_cart_bgno">예상당첨금 : <span class="txt_co3  st_marr15">' . $TPL_V1["win_money"] . ' 원</span></li>';
                                $table .= '<li class="betting_cart_40 betting_cart_bgno">당첨금 : <span class="txt_co3">' . $TPL_V1["result_money"] . ' 원</span></li>';
                                $table .= '<li class="betting_cart_40 betting_cart_bgno">상태 : ';

                                if($TPL_V1["result"] == "1")
                                    $table .= '<span class="st_marl5 bt_none6 bt_45_none txt_none3">당첨</span>';
                                else if($TPL_V1["result"] == "2")
                                    $table .= '<span class="st_marl5 bt_none3 bt_45_none txt_none3">낙첨</span>';
                                else if($TPL_V1["result"] == "4")
                                    $table .= '<span class="st_marl5 bt_none5 bt_45_none txt_none3">취소</span>';
                                else
                                    $table .= '<span class="st_marl5 bt_none1 bt_45_none txt_none3">진행</span>';
                                
                                $table .= '</li>';
                                $table .= '<li class="betting_cart_20 betting_cart_bgno">';
                                $table .= "<span class='st_marl5 bt_none5 bt_45_none txt_none3' onclick=hide_bet('/race/betlisthideProcess?betting_no=" . $TPL_K1 . "')>내역삭제</span>";
                                $table .= '</li></ul>
                                        </div>';
                                echo $table;
                            }
                        }
                        ?>
                    </div>
                    <!--// 베팅 리스트-->

                    <!-- CART B BTN-->
                    <div class="st_cart_btn st_mart15 st_marb10 txt_ac">
                        <div class="pointer bt_24p bt_gray2" onclick="hide_all_betting()">
                            <span class="bt_100_txt">전체삭제</span>
                        </div>
                    </div>
                    <!-- CART B BTN-->
                        
                <div class="pagination pagination-centered">
                    <ul>
                        <?php
                        if(count($TPL_VAR["list"]) > 0) { 
                            for($i = 0; $i < count($TPL_VAR["list"]) / 20; $i++) { 
                                if($i == 0) { ?>
                                    <li class="page p_<?=$i?> active"><a href="javascript:void(0)" onclick="goPage(0,<?=$i?>)"><?=$i + 1?></a></li>
                        <?php   } else { ?>
                                    <li class="page p_<?=$i?>"><a href="javascript:void(0)" onclick="goPage(0,<?=$i?>)"><?=$i + 1?></a></li>
                        <?php   }
                            } 
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<form name="form" method="post">
    <input type="hidden" name="bo_table">
    <input type="hidden" name="wr_1">
</form>
<form name="betting" method="post">
    <input type="hidden" name="gid" value="">
    <input type="hidden" name="mode" value="">
</form>