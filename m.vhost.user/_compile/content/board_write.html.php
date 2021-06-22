<?php /* Template_ 2.2.3 2014/10/23 19:11:14 D:\www_one-23.com\m.vhost.user\_template\content\board_write.html */
$TPL_betting_item_1=empty($TPL_VAR["betting_item"])||!is_array($TPL_VAR["betting_item"])?0:count($TPL_VAR["betting_item"]);?>
<script type="text/javascript">
	function dosubmit()
	{
		var reVal = $('#act').attr('value');
		
		if( reVal == 'edit' )
			$('#act').val('editok');
		else
			$('#act').val('writeok');
		
		if(document.form_write.title.value=="")
		{
			alert("제목을 입력하여 주십시오!");
			document.form_write.title.focus();
			return;
		}
		else if(document.form_write.content.value=="")
		{
			alert("내용을 입력하십시오!!!");
			document.form_write.content.focus();
			return;
		}
		document.form_write.submit();
	}

	function open_window(url,width,height)
	{
		window.open(url,'','scrollbars=yes,width='+width+',height='+height+',left=5,top=0');
	}
</script>

			<form action="?" method="POST" name="form_write" onsubmit="return false;">
			<input type="hidden" name="act" id="act" value="<?php echo $TPL_VAR["act"]?>">					
			<input type="hidden" name="sn" id="sn" value="<?php echo $TPL_VAR["sn"]?>">					
			<input type="hidden" name="author" value="<?php echo $TPL_VAR["sess_member_name"]?>">				
			<input type="hidden" name="bettings" value="<?php echo $TPL_VAR["bettings"]?>">
            <div class="gap">
            </div>
            <div class="sub_title">
                <span class="sub_title_text">게시판</span>
            </div>
            <div class="board_writh">
                <p class="board_writh_title">
					<input name="title" type="text" id="title" size="120" value="<?php echo $TPL_VAR["title"]?>" placeholder="제목은 50자까지 입력 가능합니다.">
                </p>
                <p class="board_writh_content">
                    <textarea name="content" cols="20" rows="10" id="content" placeholder="내용은 200자까지 입력가능합니다."><?php echo str_replace("<br>",chr(13),$TPL_VAR["content"])?></textarea>
                </p>
                <p class="board_writh_bt_box">
                    <a href="javascript:dosubmit();" class="bt_writh_1" style="margin-left:5px;">등록</a>
										<a href="javascript:void();" class="bt_writh_1" onclick="open_window('/member/upload_betting',500,1200)">배팅첨부</a>
                    <a href="<?php if($TPL_VAR["bbsNo"]!=2){?>/board/?bbsNo=<?php echo $TPL_VAR["bbsNo"]; }else{?>/cs/?bbsNo=<?php echo $TPL_VAR["bbsNo"]; }?>" class="bt_list" style="margin-left:1px;">취소</a>
                </p>
            </div>
			</form>

            <div class="gap" style="margin:5px;"></div>


<!-- 배팅(첨부) 리스트 시작 -->
<?php
	if ( count((array)$TPL_VAR["betting_item"]) > 0 ) {
		if ( $TPL_betting_item_1 ) {
			foreach ( $TPL_VAR["betting_item"] as $TPL_V1 ) {
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
?>
<!-- 배팅(첨부) 리스트 끝 -->