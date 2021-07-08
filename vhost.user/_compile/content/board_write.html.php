
	<div class="mask"></div>
	<div id="container">
		
    <form action="?" method="POST" name="form_write" onsubmit="return false;" enctype="multipart/form-data" style="margin:0px;">
        <input type="hidden" name="act" id="act" value="<?php echo $TPL_VAR["act"]?>">					
		<input type="hidden" name="sn" id="sn" value="<?php echo $TPL_VAR["sn"]?>">					
		<input type="hidden" name="author" value="<?php echo $TPL_VAR["sess_member_name"]?>">				
		<input type="hidden" name="bettings" value="<?php echo $TPL_VAR["bettings"]?>">		
        <div id="contents">
            <div class="board_box">
                <h2>게시판</h2>
                <!-- 게시판 -->
                <div class="board_write">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <colgroup><col width="23%" /><col width="*" /></colgroup>
                        <tr>
                            <td colspan="2"><input type="text" name="title" id="title" placeholder="제목" value="<?php echo iconv("euc-kr","utf-8",$TPL_VAR["title"])?>" /></td>
                        </tr>
                        <?php 
                        if ( count((array)$TPL_VAR["betting_item"]) > 0 ) {
                            foreach ( $TPL_VAR["betting_item"] as $TPL_V1 ) {
                                $TPL_betting_2 = empty($TPL_V1["betting"]) || !is_array($TPL_V1["betting"]) ? 0 : count($TPL_V1["betting"]);
                                if ( $TPL_betting_2 ) {
                                    foreach ( $TPL_V1["betting"] as $TPL_V2 ) {
                                        $TPL_item_3 = empty($TPL_V2["item"])||!is_array($TPL_V2["item"]) ? 0 : count($TPL_V2["item"]);
                                        if ( $TPL_item_3 ) {
                                            foreach ( $TPL_V2["item"] as $TPL_V3) {

                                                $gameTime = trim($TPL_V3["gameDate"])." ".trim($TPL_V3["gameHour"]) .":".trim($TPL_V3["gameTime"]);
                                                $strDay = date('w',strtotime($gameTime));
                                                switch($strDay) {
                                                    case 0: $week = "[일]";break;
                                                    case 1: $week = "[월]";break;
                                                    case 2: $week = "[화]";break;
                                                    case 3: $week = "[수]";break;
                                                    case 4: $week = "[목]";break;
                                                    case 5: $week = "[금]";break;
                                                    case 6: $week = "[토]";break;	
                                                }

                                                switch(date('w',strtotime($TPL_V2["bet_date"]))) {
                                                    case 0: $bet_week = "[일]";break;
                                                    case 1: $bet_week = "[월]";break;
                                                    case 2: $bet_week = "[화]";break;
                                                    case 3: $bet_week = "[수]";break;
                                                    case 4: $bet_week = "[목]";break;
                                                    case 5: $bet_week = "[금]";break;
                                                    case 6: $bet_week = "[토]";break;	
                                                }
                                                $bet_time = date("Y-m-d",strtotime($TPL_V2["bet_date"]))." ".$bet_week." ".date("H:i:s",strtotime($TPL_V2["bet_date"]));

                                                //-> 팀명 경기종류 적용
                                                if ( $TPL_V3["game_type"] == 4 ){
                                                    $homeTeamNameAdd = "&nbsp;<font class=\"gameType\">[오버]</font><span class=\"icon_up\">&nbsp;&nbsp;</span>";
                                                    $awayTeamNameAdd = "<span class=\"icon_down\">&nbsp;&nbsp;</span><font class=\"gameType\">[언더]</font>&nbsp;";
                                                } else if ( $TPL_V3["game_type"] == 2 ) {
                                                    $homeTeamNameAdd = "&nbsp;<font class=\"gameType\">[핸디캡]</font>";
                                                    $awayTeamNameAdd = "<font class=\"gameType\">[핸디캡]</font>&nbsp;";
                                                } else if ( $TPL_V3["game_type"] == 1 ) {
                                                    $homeTeamNameAdd = "&nbsp;<font class=\"gameType\">[승무패]</font>";
                                                    $awayTeamNameAdd = "<font class=\"gameType\">[승무패]</font>&nbsp;";
                                                } else {
                                                    unset($homeTeamNameAdd);
                                                    unset($awayTeamNameAdd);
                                                }

                                                $homeTeamName = $TPL_V3["home_team"].$homeTeamNameAdd;
                                                $awayTeamName = $awayTeamNameAdd.$TPL_V3["away_team"];
                        ?>
                        <tr>
                            <td colspan="2">
                                <div class='ko_sports_game'>
                                    <h4>
                                    <?php
                                        if( $TPL_V1["item"][0]["sport_name"] == "축구")
                                            echo "<img src=\"/images/ibet/sporticons_f.png\" class=\"arrow\" border=\"0\">";
                                        else if( $TPL_V1["item"][0]["sport_name"] == "야구")
                                            echo "<img src=\"/images/ibet/sporticons_b.png\" class=\"arrow\" border=\"0\">";
                                        else if( $TPL_V1["item"][0]["sport_name"] == "농구")
                                            echo "<img src=\"/images/ibet/sporticons_bk.png\" class=\"arrow\" border=\"0\">";
                                        else if( $TPL_V1["item"][0]["sport_name"] == "배구")
                                            echo "<img src=\"/images/ibet/sporticons_vb.png\" class=\"arrow\" border=\"0\">";
                                        else if( $TPL_V1["item"][0]["sport_name"] == "하키")
                                            echo "<img src=\"/images/ibet/sporticons_ih.png\" class=\"arrow\" border=\"0\">";
                                        else
                                            echo "<img src=\"/images/ibet/sporticons_e.png\" class=\"arrow\" border=\"0\">";
                                    ?>
                                        <img src="/10bet/images/10bet/arrow_01.png" class="arrow" alt="" />
                                        <img src="<?php echo $TPL_V3["league_image"]?>" width="20" height="16" class="arrow">  
                                        <?php echo $TPL_V3["league_name"]?>
                                        <span class='time'><?php echo substr($TPL_V3["gameDate"],5,5)?> <?php echo $week?>&nbsp;<?php echo $TPL_V3["gameHour"]?>:<?php echo $TPL_V3["gameTime"]?></span>
                                    </h4>
                                    <ul>
                                        <li>
                                            <div class='type01'>
                                                <?php
                                                    if ( $TPL_V3["game_type"] == 1 ) echo "승무패";
                                                    else if ( $TPL_V3["game_type"] == 2 ) echo "핸디캡";
                                                    else if ( $TPL_V3["game_type"] == 4 ) echo "언더오버";
                                                ?>
                                            </div>
                                            <div class='bet_area bet_history'>
                                                <div class="<?php if($TPL_V3["select_no"]==1){?>home on<?php }else{?>home<?php }?>" style="width:25%;">
                                                    <font class='team_name'><?php echo $homeTeamName?></font>
                                                    <span class='bed'><?php echo $TPL_V3["home_rate"]?></span>
                                                </div>
                                                <div class="<?php if($TPL_V3["select_no"]==3){?>draw on<?php }else{?>draw<?php }?>" style="width:15%;">
                                                <?php
                                                    if ( ($TPL_V3["game_type"] == 1 && ($TPL_V3["draw_rate"]=="1.00" || $TPL_V3["draw_rate"] == "1")) || ($TPL_V3["game_type"] == 2 && $TPL_V3["draw_rate"] == "0") ) {
                                                        echo "VS";
                                                    } else {		
                                                        echo $TPL_V3["draw_rate"];
                                                    }
                                                ?>
                                                </div>
                                                <div class="<?php if($TPL_V3["select_no"]==2){?>away on<?php }else{?>away<?php }?>" style="width:25%;">
                                                    <font class='team_name'><?php echo $awayTeamName?></font>
                                                    <span class='bed'><?php echo $TPL_V3["away_rate"]?></span>
                                                </div>
                                                <div class='result' style="width:15%;">
                                                <?php 
                                                    if ( $TPL_V3["betting_type"] == 4 ) echo $TPL_V3["home_score"]+$TPL_V3["away_score"];
                                                    else echo $TPL_V3["home_score"].":".$TPL_V3["away_score"];
                                                ?>
                                                </div>
                                                <div class='result' style="width:15%;">
                                                    <strong>
                                                    <?php
                                                        if ( $battingJT ) echo "<font color='#f65555'>적특</font>";
                                                        else if ( $TPL_V3["result"] == 1 ) echo "<font color='#ABF200'>적중</font>";
                                                        else if ( $TPL_V3["result"] == 2 ) echo "<font color='#ff0000'>미적중</font>";
                                                        else if ( $TPL_V3["result"] == 4 ) echo "<font color='#858585'>적특</font>";	
                                                        else echo "<font color='#ffffff'>진행중</font>";
                                                    ?>
                                                    </strong>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                                        } // if
                                    } // foreach
                                ?>
                                <div class='sports_game'>
                                        <div class='betting_info'>
                                            <ul>
                                                <li><?php echo $bet_time;?></li>
                                                <li>배팅금액 : <span class='fc01'><?php echo number_format($TPL_V2["betting_money"])?> 원</span></li>
                                                <li>배당 : <span class='fc01'><?php echo $TPL_V2["result_rate"]?></span></li>
                                                <li>예상당첨금 : <span class='fc01'><?php echo number_format($TPL_V2["betting_money"]*$TPL_V2["result_rate"])?> 원</span></li>
                                                <li>진행상태 : 
                                                    <span class='fc01'>&nbsp;
                                                        <span class='bold' style='color:red;'>
                                                        <?php 
                                                            if ( $TPL_V2["result"] == 0 ) echo "대기";
                                                            else if ( $TPL_V2["result"] == 2 ) echo "미적중";
                                                            else if ( $TPL_V2["result"] == 4 ) echo "취소";
                                                            else echo "적중";
                                                        ?>
                                                        </span> 
                                                    </span>
                                                </li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                            </ul>
                                        </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                                        } // if
                                    } // foreach
                                } // if
                            } // foreach
                        ?>
                        <tr>
                            <td colspan="2">
                                <textarea id="content" name="content" style='width:100%; word-break:break-all;background:#ffffff;border:1px #100e0f solid;color:#ffffff; color:#333333' rows=15 itemname="내용">
                                    <?php echo iconv("euc-kr","utf-8",str_replace("<br>",chr(13),$TPL_VAR["content"]))?>
                                </textarea>
                            </td>
                        </tr>
                    </table>
                    <div class="btn_center">
                        <button type="button" class="button_type01" onclick="open_window('/member/upload_betting',1200,900)">배팅첨부</button>
                        <button type="button" class="button_type01" onclick="dosubmit();">글쓰기</button>
                        <button type="button" class="button_type01" onClick="location.href='/board/'">목록보기</button>
                    </div>
                </div>
        </div>
	</form>
