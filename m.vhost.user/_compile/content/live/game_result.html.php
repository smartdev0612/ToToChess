<?php /* Template_ 2.2.3 2014/10/22 22:12:00 D:\www_one-23.com\m.vhost.user\_template\content\live\game_result.html */
$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);
$TPL_league_list_1=empty($TPL_VAR["league_list"])||!is_array($TPL_VAR["league_list"])?0:count($TPL_VAR["league_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	function onFilterChange()
	{
		document.frm.submit();
	}
	
	function doSubmit()
	{
		document.frm.submit();
	}
</script>

	<div id="sub_menu">
		<ul>
			<li class="sub_menu_1"><a href="/race/game_result" class="sub_menu_1_text">경기결과</a></li>
			<li class="sub_menu_1_o"><a href="/LiveGame/game_result" class="sub_menu_1_o_text">라이브경기결과</a></li>
		</ul>
	</div>


		<div class="gamesort">
		<form name="frm" method="post" action="?">
			<label>정렬설정</label>
			<p>
				<select id="sport_name" name="sport_name" onchange="onFilterChange();">
					<option value="" <?php if($TPL_VAR["sport_name"]==""){?> selected<?php }?>>전체선택</option>
<?php if($TPL_category_list_1){foreach($TPL_VAR["category_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_V1["name"]==$TPL_VAR["sport_name"]){?>selected<?php }?> ><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
						
				<select name="league_sn" onchange="onFilterChange();">
					<option value="" <?php if($TPL_VAR["league_sn"]==""){?> selected<?php }?>>리그선택</option>
<?php if($TPL_league_list_1){foreach($TPL_VAR["league_list"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["sn"]?>" <?php if($TPL_V1["sn"]==$TPL_VAR["league_sn"]){?>selected<?php }?> ><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
						
				<select name="field">
				  <option value="team" <?php if($TPL_VAR["field"]=="team"){?>selected<?php }?>>팀명</option>
				</select>
				
				<input type="text" id="sv" name="keyword" value="<?php echo $TPL_VAR["keyword"]?>" class="inputstyle_normal" size="" maxlength="" />
				<a href="javascript:void();" onclick="doSubmit();"><img src="/img/btn_search.gif" class="btnmargin"></a>
			</p>
		</form>
		</div>
		
		
		<!-- list Begin -->
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<table class="tablestyle_gamelist" cellspacing="1" cellpadding="0" id="gameresult_live">
					<thead>
						<tr>
							<th>게임구분</th>
							<th class="livetable">베팅구좌</th>
							<th>스코어</th>
						</tr>
						<tr>
							<td class="league" colspan="3">
								<img src="<?php echo $TPL_V1["league_image"]?>"><?php echo $TPL_V1["league_name"]?><b><?php echo $TPL_V1["home_team"]?> VS <?php echo $TPL_V1["away_team"]?></b>
							</td>
						</tr>
						<tr>
							<td class="gameinfo" colspan="3">
								<span class="date"><?php echo $TPL_V1["start_time"]?></span><span class="score"><?php echo $TPL_V1["score"]?></span></p>
							</td>
						</tr>
					</thead>
					<tbody>						
<?php if($TPL_V1["odd_count"]==2){?>	
						<tr>
							<td class="type"><?php echo $TPL_V1["template_alias"]?></td>
							<td class="livetable">
									<table width="100%" cellspacing="0" cellpadding="0" class="oddtable">
										<tr>
											<td class="<?php if($TPL_V1["win_position"]=='Even'){?>odd win<?php }else{?>odd<?php }?>">
												<span class="name">
<?php if($TPL_V1["token_odds"][0][0]=='Even'){?>짝
<?php }elseif($TPL_V1["token_odds"][0][0]=='Odd'){?>홀
<?php }else{?><?php echo $TPL_V1["token_odds"][0][0]?>

<?php }?>
												</span>
											</td>
											<td class="<?php if($TPL_V1["win_position"]=='Odd'){?>odd win<?php }else{?>odd<?php }?>">
												<span class="name">
<?php if($TPL_V1["token_odds"][1][0]=='Even'){?>짝
<?php }elseif($TPL_V1["token_odds"][1][0]=='Odd'){?>홀
<?php }else{?><?php echo $TPL_V1["token_odds"][1][0]?>

<?php }?>
												</span>
											</td>
										</tr>
									</table>
							</td>
						  <td class="result">
<?php if($TPL_V1["win_position"]=='Even'){?><span class="win">(짝)승</span>
<?php }elseif($TPL_V1["win_position"]=='Odd'){?><span class="lose">(홀)승</span>
<?php }?>
						  </td>
						</tr>
<?php }elseif($TPL_V1["odd_count"]==3){?>	
						<tr>
							<td class="type"><?php echo $TPL_V1["template_alias"]?></td>
							<td class="livetable">
									<table width="100%" cellspacing="0" cellpadding="0" class="normaltable">
										<tr>
											<td class="<?php if($TPL_V1["win_position"]=='1'){?>homelive win<?php }else{?>homelive<?php }?>">
												<span class="name">
<?php if($TPL_V1["token_odds"][0][0]=='1'){?><?php echo $TPL_V1["home_team"]?>

<?php }else{?><?php echo $TPL_V1["token_odds"][0][0]?>

<?php }?>
												</span>
											</td>
											<td class="<?php if($TPL_V1["win_position"]=='X'){?>drawlive win<?php }else{?>drawlive<?php }?>">
												<span class="rate">
<?php if($TPL_V1["token_odds"][1][0]=='X'){?>무승부
<?php }else{?><?php echo $TPL_V1["token_odds"][1][0]?>

<?php }?>
												</span>
											</td>
											<td class="<?php if($TPL_V1["win_position"]=='2'){?>awaylive win<?php }else{?>awaylive<?php }?>">
												<span class="name">
<?php if($TPL_V1["token_odds"][2][0]=='2'){?><?php echo $TPL_V1["away_team"]?>

<?php }else{?><?php echo $TPL_V1["token_odds"][2][0]?>

<?php }?>
												</span>
											</td>
										</tr>
									</table>
							</td>
							<td class="result">
<?php if($TPL_V1["win_position"]=='1'){?><span class="win">홈승</span>
<?php }elseif($TPL_V1["win_position"]=='X'){?><span class="draw">무승부</span>
<?php }elseif($TPL_V1["win_position"]=='2'){?><span class="lose">원정승</span>
<?php }elseif($TPL_V1["win_position"]=='CANCEL'){?><span class="cancel">적특</span>
<?php }else{?>진행중
<?php }?>
							</td>
						</tr>											
<?php }elseif($TPL_V1["odd_count"]==26){?>
						<tr>
							<td class="type"><?php echo $TPL_V1["template_alias"]?></td>
							<td class="livetable">
									<table width="100%" cellspacing="0" cellpadding="0" class="scoretable">
										<tr>
											<td class="<?php if($TPL_V1["win_position"]=='0-0'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][0][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='1-0'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][1][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='1-1'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][2][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='0-1'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][3][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='2-0'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][4][0]?></span></td>
										</tr>
										<tr>
											<td class="<?php if($TPL_V1["win_position"]=='2-1'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][5][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='2-2'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][6][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='1-2'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][7][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='0-2'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][8][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='3-0'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][9][0]?></span></td>						  						
										</tr>
										<tr>
											<td class="<?php if($TPL_V1["win_position"]=='3-1'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][10][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='3-2'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][11][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='3-3'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][12][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='2-3'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][13][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='1-3'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][14][0]?></span></td>						  						
										</tr>
										<tr>
											<td class="<?php if($TPL_V1["win_position"]=='0-3'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][15][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='4-0'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][16][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='4-1'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][17][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='4-2'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][18][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='4-3'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][19][0]?></span></td>						  						
										</tr>						  											  					
										<tr>
											<td class="<?php if($TPL_V1["win_position"]=='4-4'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][20][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='3-4'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][21][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='2-4'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][22][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='1-4'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][23][0]?></span></td>
											<td class="<?php if($TPL_V1["win_position"]=='0-4'){?>score win<?php }else{?>score<?php }?>"><span class="name"><?php echo $TPL_V1["token_odds"][24][0]?></span></td>						  						
										</tr>						  											  					
									</table>
							</td>
							<td class="result">
<?php if($TPL_V1["win_position"]=='CANCEL'){?><span class="cancel">적특</span>
<?php }elseif($TPL_V1["win_position"]=='-1'){?>진행중
<?php }else{?><span class="win"><?php echo $TPL_V1["win_position"]?></span>
<?php }?>
							</td>
						</tr>
<?php }?>
<?php }}?>											
					</tbody>
				</table>

		
		<div class="wrap_page">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>