<?php /* Template_ 2.2.3 2014/10/23 19:06:56 D:\www_one-23.com\m.vhost.user\_template\content\board_view.html */
$TPL_bettingItem_1=empty($TPL_VAR["bettingItem"])||!is_array($TPL_VAR["bettingItem"])?0:count($TPL_VAR["bettingItem"]);
$TPL_replyList_1=empty($TPL_VAR["replyList"])||!is_array($TPL_VAR["replyList"])?0:count($TPL_VAR["replyList"]);?>
<script type="text/javascript">

function domodify(url)
{
	document.location.href=url;	
}

function dosubmit()
{
	document.FormReply.submit();
}


function dodel(url){ 
	var r=confirm("정말로 삭제 하시겠습니까?");
	if (r==true)
	{   
		document.location.href=url;
	}
}
</script>

            <div class="gap">
            </div>
            <div class="sub_title">
                <span class="sub_title_text">게시판</span>
                <?php if($TPL_VAR["bbsNo"]!=7&&$TPL_VAR["bbsNo"]!=9){?><a href="javascript:void()" onclick="location.href='/board/write'" class="bt_writh">글쓰기</a><?php }?>
            </div>    
            <div class="board_view">
                <ul>
                    <li class="board_view_head">
                        <span class="board_view_text"><?php echo $TPL_VAR["item"]["title"]?></span>
                        <span class="board_view_info">
                            <?php if($TPL_VAR["item"]["author"]=='관리자'){?><p class="board_level_admin">관리자</p><?php }else{?><p class="board_level_<?php echo $TPL_VAR["item"]["mem_lev"]?>">Lv <?php echo $TPL_VAR["item"]["mem_lev"]?></p><?php echo $TPL_VAR["item"]["author"]?><?php }?>
                            <p class="board_guide"></p>
                            <span class="board_view_time"><?php echo substr($TPL_VAR["item"]["time"],0,10)?></span>
                        </span>
                    </li>
                    <li class="board_view_center"><?php echo $TPL_VAR["item"]["content"]?></li>
                </ul>
								<ul>
<?php 
	if ( $TPL_VAR["sess_member_name"] == $TPL_VAR["item"]["author"] ) {
?>
<p class="board_writh_bt_box" style="margin-top:5px;">
				<a href="javascript:domodify('/board/write?act=edit&sn=<?php echo $TPL_VAR["item"]["id"]?>&author=<?php echo $TPL_VAR["article"]?>&title=<?php echo $TPL_VAR["item"]["title"]?>&content=<?php echo $TPL_VAR["item"]["content"]?>&bbsNo=<?php echo $TPL_VAR["bbsNo"]?>')">수정</a>
				<a href="javascript:dodel('?mode=hdel&hid=<?php echo $TPL_VAR["article"]?>&bbsNo=<?php echo $TPL_VAR["bbsNo"]?>')">삭제</a>
</p>
<?php
	}
?>									
								</ul>
            </div>

<!-- 배팅(첨부) 리스트 시작 -->
<?php
	//if ( sizeof($TPL_VAR["bettingItem"]) > 0 ) {
   if ( count((array)$TPL_VAR["bettingItem"][0]["betting"]) > 0 ) {
		if ( $TPL_bettingItem_1 ) {
			foreach ( $TPL_VAR["bettingItem"] as $TPL_V1 ) {
				$TPL_betting_2=empty($TPL_V1["betting"])||!is_array($TPL_V1["betting"])?0:count($TPL_V1["betting"]);
				if ( $TPL_betting_2 ) {
					foreach ( $TPL_V1["betting"] as $TPL_V2 ) {
						$TPL_item_3=empty($TPL_V2["item"])||!is_array($TPL_V2["item"])?0:count($TPL_V2["item"]);
?>
	<div class="my_bet_league" style="padding-top:8px;">
		<ul>
			<li class="my_bet_league_day" style="width:75%;"><span style="color:#EDD200;">배팅시간</span> <?php echo $TPL_V2["bet_date"]?></li>
			<li class="my_bet_league_name" style="width:5%;">&nbsp;</li>
		</ul>
	</div>
<?php
		if ( $TPL_item_3 ) {
			foreach ( $TPL_V2["item"] as $TPL_V3 ) {
				if ( $TPL_V3["home_rate"] < 1.1 and $TPL_V3["draw_rate"] < 1.1 and $TPL_V3["away_rate"] < 1.1  ) {
					$battingJT = "1";
				} else {
					$battingJT = "0";
				}
?>
	<div class="my_bet_game_data">
		<div style="float:left; width:95%; text-align: left; color:#47C83E;">
			<?php echo substr($TPL_V3["gameDate"],5,5)?> <?php echo $TPL_V3["gameHour"]?>:<?php echo $TPL_V3["gameTime"]?>
		</div>
<?php
	if ( $TPL_V3["select_no"] == 1 ) {
?>
		<div class="my_bet_home_over_box">
			<span class="my_bet_home_over" <?php if($TPL_V3["win"]==1){echo "style=\"border:#FFE08C 1px solid;\"";}?>>
				<span class="my_bet_home_o">
					<?php echo $TPL_V3["home_team"]?> <?php if($TPL_V3["game_type"]==4){?>▲<?php }?>
				</span>
				<span class="my_bet_home_odd_o"><?php echo $TPL_V3["home_rate"]+0?></span>
			</span>
		</div>
<?php
	} else {
?>
		<div class="my_bet_home_box">
			<span class="my_bet_home" <?php if($TPL_V3["win"]==1){echo "style=\"border:#FFE08C 1px solid;\"";}?>>
				<span class="my_bet_home_n">
					<?php echo $TPL_V3["home_team"]?> <?php if($TPL_V3["game_type"]==4){?>▲<?php }?>
				</span>
				<span class="my_bet_home_odd_n"><?php echo $TPL_V3["home_rate"]+0?></span>
			</span>
		</div>
<?php
	}
?>

		<div <?php if($TPL_V3["select_no"]==3){?>class="my_bet_odd_over_box"<?php }else{?>class="my_bet_odd_box"<?php }?>>
			<span <?php if($TPL_V3["select_no"]==3){?>class="my_bet_odd_over"<?php }else{?>class="my_bet_odd"<?php }?> <?php if($TPL_V3["win"]==3){echo "style=\"border:#FFE08C 1px solid;\"";}?>>

<?php
	if(($TPL_V3["game_type"]==1&&($TPL_V3["draw_rate"]=="1.00"||$TPL_V3["draw_rate"]=="1"))||($TPL_V3["game_type"]==2&&$TPL_V3["draw_rate"]=="0")){
		echo "<span class=\"my_bet_odd_n\"><b>VS</b></span>";
	}else{
		if ( $TPL_V3["select_no"] == 3 ) echo "<span class=\"my_bet_odd_o\">";
		else echo "<span class=\"my_bet_odd_n\">";
		if($TPL_V3["game_type"]==1){
			echo number_format($TPL_V3["draw_rate"],2);
		}else{
			echo $TPL_V3["draw_rate"]+0;
		}
		echo "</span>";
	}
?>
			</span>
		</div>
<?php
	if ( $TPL_V3["select_no"] == 2 ) {
?>  
		<div class="my_bet_away_over_box">
			<span class="my_bet_away_over" <?php if($TPL_V3["win"]==2){echo "style=\"border:#FFE08C 1px solid;\"";}?>>
				<span class="my_bet_away_o"><?php if($TPL_V3["game_type"]==4){?>▼<?php }?> <?php echo $TPL_V3["away_team"]?></span><span class="my_bet_away_odd_o"><?php echo $TPL_V3["away_rate"]+0?></span>
			</span>
		</div>
<?php
	} else {
?>
		<div class="my_bet_away_box">
			<span class="my_bet_away" <?php if($TPL_V3["win"]==2){echo "style=\"border:#FFE08C 1px solid;\"";}?>>
				<span class="my_bet_away_n"><?php if($TPL_V3["game_type"]==4){?>▼<?php }?> <?php echo $TPL_V3["away_team"]?></span><span class="my_bet_away_odd_n"><?php echo $TPL_V3["away_rate"]+0?></span>
			</span>
		</div>
<?php
	}
?>
		<div class="my_bet_score">
			<?php if($TPL_V3["home_score"]==""){?>-<?php }else{?><?php echo $TPL_V3["home_score"]?>:<?php echo $TPL_V3["away_score"]?><?php }?><br>
<?php
	if ( $battingJT ) echo "<font color='#41AF39'>적특</font>";
	else if ( $TPL_V3["result"] == 1 ) echo "<font color='#fff44b'>적중</font>";
	else if ( $TPL_V3["result"] == 2 ) echo "<font color='#fa1313'>낙첨</font>";
	else if ( $TPL_V3["result"] == 4 ) echo "<font color='#41AF39'>적특</font>";	
	else echo "<font color='#ffffff'>대기</font>";
?>
		</div>
	</div>
<?php
		}
	}
?>
	<div class="my_bet_game_result_head">
		<ul>
			<li class="my_bet_game_result_head_box">베팅금액: <span style="color:#EDD200;"><?php echo number_format($TPL_V2["betting_money"])?>원</span></li>
			<li class="my_bet_game_result_head_box">배당률: <span style="color:#EDD200;"><?php echo $TPL_V2["result_rate"]+0?></span></li>
			<li class="my_bet_game_result_head_box" style="clear:both;">
				당첨예상: <span style="color:#EDD200;"><?php echo number_format(abs($TPL_V2["betting_money"]*$TPL_V2["result_rate"]))?>원</span>
			</li>
			<li class="my_bet_game_result_head_box">
				<?php if($TPL_V2["result"]==1){?>당첨금: <span style="color:#0BC904;"><?php echo number_format($TPL_V2["win_money"])?>원</span><?php }?>
			</li>
			<li style="float:right; width:18%; text-align:right; margin-top:-15px; padding-right:18px;">
<?php 
	if($TPL_V2["result"]==0){
		echo "<span class=\"my_bet_league_result_text\">진행중</span>";
	}elseif($TPL_V2["result"]==2){
		echo "<span class=\"my_bet_league_result_text_x\">낙첨</span>";
	}elseif($TPL_V2["result"]==4){
		echo "<span class=\"my_bet_league_result_text_c\">적특</span>";
	}else{
		echo "<span class=\"my_bet_league_result_text_o\">적중</span>";
	}
?>
			</li>
		</ul>
	</div>
<?php
	}}}}}
	else
    {
        if($TPL_VAR["betting_temp_m"] != null && $TPL_VAR["betting_temp_m"] != '')
            echo $TPL_VAR["betting_temp_m"];
    }
?>

<!-- 배팅(첨부) 리스트 끝 -->

		<form name="FormReply" action="?mode=comment" method="post" onsubmit="return dosubmit();">
			<input type="hidden"  name="Article_id" value="<?php echo $TPL_VAR["article"]?>">
			<input type="hidden"  name="bbsNo" value="<?php echo $TPL_VAR["bbsNo"]?>">
			<input type="hidden" name="mid" value="<?php echo $TPL_VAR["sess_member_id"]?>">
			<input type="hidden" name="mnk" value="<?php echo $TPL_VAR["sess_member_name"]?>">
            <div class="board_reply" style="padding-bottom:38px;">
                <p>
                    <textarea name="reply" type="text" id="#" placeholder="욕설,비방은 금지 부탁드립니다." style="margin-bottom:6px;"></textarea>
					<a href="javascript:FormReply.submit();" class="bt_reply">댓글달기</a>
                    <a href="<?php if($TPL_VAR["bbsNo"]!=2){?>/board/?bbsNo=<?php echo $TPL_VAR["bbsNo"]; }else{?>/cs/?bbsNo=<?php echo $TPL_VAR["bbsNo"]; }?>" class="bt_list">목록으로</a>
                    <icon></icon>
                </p>
            </div>

<?php
	if ( $TPL_replyList_1 ) {		
?>
            <div class="reply_list">
                <ul>
<?php
		foreach ( $TPL_VAR["replyList"] as $TPL_V1 ) {
			if ( $TPL_V1["mem_nick"] == "관리자" ) {
				$level = "admin";
				$levelStr = "ADMIN";
			} else {
				$level = $TPL_V1["level"];
				if ( !$level ) $level = 1;
				$levelStr = "Lv ".$level;
			}
?>
                    <li>
                        <span class="reply_info">
                            <?php if($TPL_VAR["bbsNo"]==5){?><p class="board_level_<?php echo $level?>"><?php echo $levelStr?></p><?php }?><?php echo $TPL_V1["mem_nick"]?>
<!--
                            <p class="board_guide"></p>
                            <span class="reply_time"><?php echo substr($TPL_V1["regdate"],2,14)?></span>
-->
														<span class="reply_time"">
<?php 
	if ( $TPL_VAR["sess_member_name"] == $TPL_V1["mem_nick"] and $TPL_VAR["bbsNo"] != 7 ) {
?>
<a href="javascript:dodel('/board/view?mode=del&reid=<?php echo $TPL_V1["idx"]?>&id=<?php echo $TPL_V1["mem_id"]?>&Article_id=<?php echo $TPL_VAR["article"]?>&bbsNo=<?php echo $TPL_VAR["bbsNo"]?>');"><img src="/img/btn_bbs_delete_reply.gif"></a>
<?php
	}
?>
														</span>
                        </span>
                        <span class="reply_text" style="margin-top:3px;"><?php echo $TPL_V1["content"]?></span>
                    </li>
<?php
		}
	}
?>
                </ul>
            </div>          
			</form>
			<div class="gap" style="margin:20px;"></div>
