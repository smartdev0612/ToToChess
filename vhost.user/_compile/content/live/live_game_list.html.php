<?php /* Template_ 2.2.3 2014/09/19 22:00:27 D:\www_kd_20140905\vhost.user\_template\content\live\live_game_list.html */
$TPL_game_list_1=empty($TPL_VAR["game_list"])||!is_array($TPL_VAR["game_list"])?0:count($TPL_VAR["game_list"]);?>
<script language="javascript" src="/scripts/live.js"></script>
<script language="javascript" src="/scripts/live_betting.js"></script>
<script>
	$(window).unload(function() {
		end_live_list_listener();
	});
</script>
<script>begin_live_list_listener();</script>

	<div id="wrap_body">
		<h2 class="blind">내용</h2>
		<div id="subvisual" class="subvisual_betlist">
			<h3><img src="/images/title_soccer.gif"></h3>
		</div>
		<div id="body">	
			  <table width="100%" cellspacing="0"  class="tablestyle_gamelist_live" id="live_game_table">
					<tbody>
<?php if(count($TPL_VAR["game_list"])>0){?>
<?php if($TPL_game_list_1){foreach($TPL_VAR["game_list"] as $TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
						<tr>
							<td colspan="6" class="league">
								<img src="<?php echo $TPL_V1["league_image"]?>">
								<span style="color:#41FF3A;"><?php echo $TPL_V1["league_name"]?></span>
							</td>
						</tr>
						
<?php if($TPL_item_2){foreach($TPL_V1["item"] as $TPL_V2){?>
							<tr class="gamelist_enable" id="<?php echo $TPL_V2["event_id"]?>_tr">	
								<td class="date" nowrap><?php echo $TPL_V2["start_time"]?></td>		
								<td valign="top" class="game">
									<p class="home">
										<span class="name"><?php echo $TPL_V2["home_team"]?></span>
									</p>
									<p class="draw">VS</p>
									<p class="away">
										<span class="name"><?php echo $TPL_V2["away_team"]?></span>
									</p>
								</td>
<?php if($TPL_V2["state"]=='READY'){?>
								<td colspan="2" valign="top" class="timer">-</td>
<?php }else{?>
								<td valign="top" class="score">-</td>
								<td class="gameamount"><a href="/LiveGame/detail?event_id=<?php echo $TPL_V2["event_id"]?>">-</a></td>
<?php }?>
								
							</tr>
<?php }}?>
<?php }}?>
<?php }else{?>
						<tr>
							<td>등록된 라이브 게임이 없습니다.</td>
						</tr>
<?php }?>
					</tbody>
				</table>
		</div>
<?php $this->print_("right",$TPL_SCP,1);?>


	</div>