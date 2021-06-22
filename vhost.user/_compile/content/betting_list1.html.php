
    <div class="mask"></div>
	<div id="container">
	
<style>
    .ko_sports_game .bet_area .home {width:25%;}
    .ko_sports_game .bet_area .away {width:25%;}
    .ko_sports_game .bet_area .result {width:15%;}
    .sports_game .bet_box{height:auto;}
    .sports_game .bet_box .colum02{display:block;}
    .sports_game .bet_box .colum03{display:block;}
    .marging-top-3 {margin-top:3px;}
</style>
<script>
    var VarBoTable = "a10";
    var VarBoTable2 = "a25";
    var VarCaId = "";
    var VarColspan = "7";
    $j().ready(function(){
        path = '/ajax.list.php?bo_table=a10&ca=스포츠&sca=&sfl=&stx=&b_type=2';
        init("" + g4_path + path);
        
        path2 = '/ajax.list.php?bo_table=a25&ca=스포츠&sca=&sfl=&stx=';
        init2("" + g4_path + path2);
        //setInterval("init('"+g4_path+ path +"')", 30000);
    });
</script>
<script type="text/javascript" src="/10bet/js/left.js?1610345806"></script>

<div id="contents">
	<div class="board_box">
		<h2>배팅내역</h2>
	</div>
	<!-- 스포츠 컨텐츠 상단 -->
	<!-- <div class="sports_head">
		<ul class="menu_list">
			<li>
                <button class="button_type01 on" onClick="location.href='/race/betting_list?special_code=1'">
					<span class="link">스포츠</span>
				</button>
			</li>
			<li>
                <button class="button_type01" onClick="location.href='/race/betting_list?special_code=4'">
					<span>라이브</span>
				</button>
			</li>
			<li>
                <button class="button_type01 " onClick="location.href='/race/betting_list'">
					<span>미니게임</span>
				</button>
			</li>
		</ul>
    </div> -->
    <form name="bettingList" style="margin:0;">
        <?php
        foreach ( $TPL_VAR["list"] as $TPL_K1 => $TPL_V1 ) {
            $TPL_item_2=empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);
            $firstJT_date = "";
            if ( $TPL_item_2 ) { 
                foreach ( $TPL_V1["item"] as $TPL_V2 ) {
                    if ( $TPL_V2["home_rate"] < 1.01 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
                        $TPL_V2["home_rate"] = $TPL_V2["game_home_rate"];
                        $TPL_V2["draw_rate"] = $TPL_V2["game_draw_rate"];
                        $TPL_V2["away_rate"] = $TPL_V2["game_away_rate"];
                        $battingJT = "1";
                        if ( $firstJT_date == "" ) {
                            $firstJT_date = $TPL_V2["operdate"];
                        }
                    } else {
                        $battingJT = "0";
                    }
                    
                    if ( $TPL_V1["bet_enable"] == 0 ) {
                        $gameTime = trim($TPL_V2["gameDate"])." ".trim($TPL_V2["gameHour"]) .":".trim($TPL_V2["gameTime"]);
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
                        
                        switch(date('w',strtotime($TPL_V1["bet_date"]))) {
                            case 0: $bet_week = "[일]";break;
                            case 1: $bet_week = "[월]";break;
                            case 2: $bet_week = "[화]";break;
                            case 3: $bet_week = "[수]";break;
                            case 4: $bet_week = "[목]";break;
                            case 5: $bet_week = "[금]";break;
                            case 6: $bet_week = "[토]";break;	
                        }
                        $bet_time = date("Y-m-d",strtotime($TPL_V1["bet_date"]))." ".$bet_week." ".date("H:i:s",strtotime($TPL_V1["bet_date"]));

                        if ( $TPL_V2["result"] == 4 ) {
                            $TPL_V2["home_rate"] = "1.00";
                            $TPL_V2["away_rate"] = "1.00";
                        }
        ?>
        <div class="ko_sports_game">
            <h4>
            <?php
                if( $TPL_V1["item"][0]["sport_name"] == "축구")
                    echo "<img src=\"/images/ibet/sporticons_f.png\" class=\"arrow marging-top-3\">";
                else if( $TPL_V1["item"][0]["sport_name"] == "야구")
                    echo "<img src=\"/images/ibet/sporticons_b.png\" class=\"arrow marging-top-3\">";
                else if( $TPL_V1["item"][0]["sport_name"] == "농구")
                    echo "<img src=\"/images/ibet/sporticons_bk.png\" class=\"arrow marging-top-3\">";
                else if( $TPL_V1["item"][0]["sport_name"] == "배구")
                    echo "<img src=\"/images/ibet/sporticons_vb.png\" class=\"arrow marging-top-3\">";
                else if( $TPL_V1["item"][0]["sport_name"] == "아이스 하키")
                    echo "<img src=\"/images/ibet/sporticons_ih.png\" class=\"arrow marging-top-3\">";
                else
                    echo "<img src=\"/images/ibet/sporticons_e.png\" class=\"arrow marging-top-3\">";
            ?>
                <img src="/10bet/images/10bet/arrow_01.png" class="arrow" alt="">
                <img src="<?=$TPL_V2["league_image"]?>" width="20" height="16" style="padding-top:8px;">
                <?php echo $TPL_V2["league_name"]?>
                <span class="time"><?php echo substr($TPL_V2["gameDate"],5,5)?> <?php echo $week?>&nbsp;<?php echo $TPL_V2["gameHour"]?>:<?php echo $TPL_V2["gameTime"]?></span>
            </h4>
            <ul>
                <li>
                    <div class="type01">
                    <?php
                        $pieces = explode(" ", $TPL_V2["mname_ko"]);
                        echo $pieces[0];
                    ?>
                    </div>
                    <div class="bet_area bet_history">
                        <div class="<?php if($TPL_V2["select_no"]==1){?>home on<?php }else{?>home<?php }?>">
                            <font class="team_name"> 
                                <?php echo $TPL_V2["home_team"]?>
                                <?php if($TPL_V2["game_type"]==2 || $TPL_V2["game_type"]==28){?>&nbsp;
                                <font class="gameType">[언더]</font>
                                <span class="icon_up">&nbsp;&nbsp;</span>
                                <?php }elseif($TPL_V2["game_type"]==3 || $TPL_V2["game_type"]==342 || $TPL_V2["game_type"]==866){?>&nbsp;
                                    <font class="gameType">[핸디캡]</font>
                                <?php }elseif($TPL_V2["game_type"]==1){?>
                                    <font class="gameType">[승무패]</font>
                                <?php }elseif($TPL_V2["game_type"]==226 || $TPL_V2["game_type"]==52){?>
                                    <font class="gameType">[승패]</font>
                                <?php } ?>
                            </font>
                            <span class="bed"><?php echo sprintf("%2.2f",$TPL_V2["home_rate"])?></span>
                        </div>
                        <div class="<?php if($TPL_V2["select_no"]==3){?>draw on<?php }else{?>draw<?php }?>">
                            <?php
                                if ( $TPL_V2["game_type"] == 226 ||  $TPL_V2["game_type"] == 52 ) {
                                    echo "VS";
                                } else {
                                    $pos = strpos($TPL_V2["mname_ko"], "승무패");
                                    if ( $pos === false ) echo $TPL_V2["home_line"];
                                    else echo sprintf("%2.2f",$TPL_V2["draw_rate"]);
                                }
                            ?>
                        </div>
                        <div class="<?php if($TPL_V2["select_no"]==2){?>away on<?php }else{?>away<?php }?>">
                            <font class="team_name">
                                <?php if($TPL_V2["game_type"]==2 || $TPL_V2["game_type"]==28){?>
                                    <span class="icon_down">&nbsp;&nbsp;</span>
                                    <font class="gameType">[오버]</font>&nbsp;
                                <?php }elseif($TPL_V2["game_type"]==3 || $TPL_V2["game_type"]==342 || $TPL_V2["game_type"]==866){?>
                                    <font class="gameType">[핸디캡]</font>&nbsp;
                                <?php }elseif($TPL_V2["game_type"]==1){?>
                                    <font class="gameType">[승무패]</font>&nbsp;
                                <?php }elseif($TPL_V2["game_type"]==226 || $TPL_V2["game_type"]==52){?>
                                    <font class="gameType">[승패]</font>
                                <?php } ?><?php echo $TPL_V2["away_team"]?>
                            </font>
                            <span class="bed"><?php echo sprintf("%2.2f",$TPL_V2["away_rate"])?></span>
                        </div>
                        <div class="result">
                            <?php 
                                // if ( $TPL_V2["game_type"]==2 || $TPL_V2["game_type"]==28 ) echo $TPL_V2["home_score"]+$TPL_V2["away_score"];
                                // else echo $TPL_V2["home_score"].":".$TPL_V2["away_score"];
                                if($TPL_V2["live"] == 1) 
                                    echo "[LIVE] " . $TPL_V2["score"];
                                else 
                                    echo $TPL_V2["home_score"].":".$TPL_V2["away_score"];
                            ?>
                        </div>
                        <div class="result">
                            <strong>
                                <?php
                                    if ( $battingJT ) echo "<font color='#f65555'>적특</font>";
                                    else if ( $TPL_V2["result"] == 1 ) echo "<font color='#ABF200'>적중</font>";
                                    else if ( $TPL_V2["result"] == 2 ) echo "<font color='#ff0000'>미적중</font>";
                                    else if ( $TPL_V2["result"] == 4 ) echo "<font color='#858585'>적특</font>";	
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
        <div class="sports_game">
            <div class="betting_info">
                <ul>
                    <li>
                        <?php echo $bet_time;?>
                    </li>
                    <li>배팅금액 : <span class="fc01"><?php echo number_format($TPL_V1["betting_money"])?> 원</span></li>
                    <li>배당 : <span class="fc01"><?php echo sprintf("%2.2f",$TPL_V1["result_rate"]);?></span></li>
                    <li>예상당첨금 : <span class="fc01"><?php echo number_format($TPL_V1["betting_money"]*$TPL_V1["result_rate"])?> 원</span></li>
                    <li>진행상태 : 
                        <span class="fc01">&nbsp;
                            <span class="bold" style="color:red;">
                                <?php 
                                    if ( $TPL_V1["result"] == 0 ) echo "대기";
                                    else if ( $TPL_V1["result"] == 2 ) echo "미적중";
                                    else if ( $TPL_V1["result"] == 4 ) echo "취소";
                                    else echo "적중";
                                ?>
                            </span> 
                        </span>
                    </li>
                    <li></li>
                    <!-- <li><button type="button" class="button_type01" onclick="on_upload('<?php echo $TPL_K1?>');">첨부</button></li> -->
                    <li><button type="button" class="button_type01" onClick="hide_bet('/race/betlisthideProcess?betting_no=<?php echo $TPL_K1?>')">삭제하기</button></li>
                </ul>
            </div>
        </div>
        <?php
                } // if
            } // foreach
        ?>
                    
        <div class='page_skip'>
            <?php echo $TPL_VAR["pagelist"]?>
        </div>
        <div align="right">
            <button type="button" class="button_type01" onClick="hide_all_betting()" style='width:80px;height:26px;'>전체삭제</button>
        </div>
    </form>

</div>

<script>
	function cancel_bet(url)
	{
		if(confirm("정말 취소하시겠습니까?")) {document.location = url;}
		else{return;}
	}
	
	function hide_bet(url)
	{
		if(confirm("정말 삭제 하시겠습니까?  ")) {document.location = url;}
		else{return;}
	}
	
	function hide_all_betting() {
		if(confirm("정말 모든 배팅내역을 삭제하시겠습니까?")) {
			document.location = "/race/hide_all_betting";
		}
	}
	
	function on_upload(bettings) {
		if ( !bettings ) {
			var bettings="";
			$("[name=upload_checkbox]").each( function(index) {
				if(this.checked) {
					var betting_no = this.value;
					bettings += betting_no;
					bettings += ";";
				}
			});
		}
		document.location.href="/board/write?bettings="+bettings;
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

<form name="form" method="post">
    <input type="hidden" name="bo_table">
    <input type="hidden" name="wr_1">
</form>
<form name="betting" method="post">
    <input type="hidden" name="gid" value="">
    <input type="hidden" name="mode" value="">
</form>
<script language="JavaScript">
    var page = "1";
    var mode = "betting";

    function select_check_one(gid){
        var f = document.bettingList;
        for( var i = 0; i < f['chk'].length; i++){
            if( f['chk'][i].value == gid ) {
                f['chk'][i].checked=true;
                break;
            }
        }
    }
    function select_betting() {
        var f = document.bettingList;
        var tmpGid = "";

        for( var i = 0; i < f['chk'].length; i++)
        {
            if( f['chk'][i].checked == true ) tmpGid +=  f['chk'][i].value+",";
        }

        if( typeof(f['chk'].length) == "undefined" )
        {
            tmpGid += f['chk'].value+",";
        }

        if( tmpGid == "" )
        {
            warning_popup("배팅내역을 선택해주세요!");
            return false;
        }

        if (!confirm("해당경기를 게시판에 등록하시겠습니까?"))
            return;

        if( opener && opener.fwrite){
            opener.fwrite.wr_1.value = "["+tmpGid+"]";
            window.close();

        }else{

            document.form.bo_table.value = "z30";
            document.form.wr_1.value = "["+tmpGid+"]";

            document.form.action = "./write.php";
            document.form.submit();
        }
    }

    function select_delete(all_flag) {
        if(typeof(all_flag)=="undefined") all_flag=false;
        else all_flag=true;

        var f = document.bettingList;
        var tmpGid = "";

        var cnt = f['chk'].length;
        for( var i = 0; i < cnt; i++)
        {
            if( f['chk'][i].checked == true || all_flag ) tmpGid +=  f['chk'][i].value+",";
        }

        if( typeof(f['chk'].length) == "undefined"  )
        {
            if( f['chk'].checked == true || all_flag ) tmpGid =  f['chk'].value+",";
        }

        if( tmpGid == "" )
        {
            warning_popup("배팅내역을 선택해주세요!");
            return false;
        }

        if (!confirm("해당 배팅내역을 삭제하시겠습니까?"))
            return;

        req = create_request();
        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    var returntext = req.responseText;
                    tmpstr = returntext.split("||");
                    if( tmpstr[0] == "E0000") warning_popup("해당 배팅내역은 미정산내역이므로 삭제할 수 없습니다.");
                    if( tmpstr[0] == "E0001") warning_popup("선택하신 내역중 미정산내역은 제외하고 "+tmpstr[1]+" 삭제됩니다.");
                    if( tmpstr[0] == "S0001") warning_popup("선택하신 내역중 미정산인 경기를 제외하고 "+tmpstr[1]+" 삭제하였습니다.");
                    location.href=g4_path+"/bbs/betting.php?mode="+mode+"&&page="+page;
                }
            }
        }

        req.open("POST", g4_path+'/bbs/betting_delete.php', true);
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        var params = '&gid='+tmpGid+'&mode='+mode+'&page='+page;

        req.send(params);
    }

    function delete_cart(gid, mode, page) {
            if (!confirm("해당 세트를 삭제하시겠습니까?"))
                return;

            window.location = "./betting_delete.php?gid="+gid+"&mode="+mode+"&page="+page;
    }

    function cancel_betting(gid,mode){
        document.location.href = 'betting_cancel.php?gid='+gid;
    }
</script>