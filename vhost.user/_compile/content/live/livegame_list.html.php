<?php $TPL_game_list_1=empty($TPL_VAR["game_list"])||!is_array($TPL_VAR["game_list"])?0:count($TPL_VAR["game_list"]);?>
<script>
	$(window).unload(function() {
		end_live_list_listener();
	});
</script>
<script>begin_live_list_listener();</script>

<?php if(count($TPL_VAR["game_list"])>0){?>
					<table width="100%" cellspacing="0" id="live_game_table">
					<thead>
						<th colspan="3">라이브베팅 목록 <span><?php echo $TPL_VAR["live_game_count"]?></span></th>
					</thead>
					<tbody>
					
<?php if($TPL_game_list_1){foreach($TPL_VAR["game_list"] as $TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
						<tr>
							<td colspan="3" class="league">
								<img src="<?php echo $TPL_V1["league_image"]?>">
								<span><?php echo $TPL_V1["league_name"]?></span>
								<!--<a href="javascript:void();" onclick="#" class="fvrt">즐겨찾기</a></li>-->
								<!-- 즐겨찾기된 목록은 <a href>에 class="on" 처리 -->
							</td>
						</tr>
<?php if($TPL_item_2){foreach($TPL_V1["item"] as $TPL_V2){?>
							<tr <?php if($TPL_VAR["event_id"]==$TPL_V2["event_id"]){?>class="on"<?php }else{?>class="gamelist_enable"<?php }?> id="<?php echo $TPL_V2["event_id"]?>_tr" onclick="location.href='/LiveGame/list?event_id=<?php echo $TPL_V2["event_id"]?>'">		
								<td class="home" style="padding-left:5px;"><?php echo $TPL_V2["home_team"]?></td>
								<td class="draw">VS</td>
								<td class="away" style="padding-right:5px;"><?php echo $TPL_V2["away_team"]?></td>
<?php if($TPL_V2["state"]=='READY'){?>
							</tr>
							<tr class="date">
								<td colspan="2"><?php echo $TPL_V2["start_time"]?></td>
								<td><span class="remain_timer"></span></td>
<?php }else{?>
							</tr>
							<tr class="data" id="<?php echo $TPL_V2["event_id"]?>_tr_score">
								<td colspan="2"><?php echo $TPL_V2["start_time"]?></td>
								<td><span class="score"></span></td>
<?php }?>
							</tr>
<?php }}?>
<?php }}?>
<?php }else{?>
					<table width="100%" cellspacing="0" id="live_game_table" class="nonlive">
					<thead>
						<tr>
							<th>None livegame</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>등록된 라이브 게임이 없습니다.</td>
						</tr>
<?php }?>
					</tbody>
				</table>