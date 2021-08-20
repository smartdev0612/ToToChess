<?php
$TPL_categoryList_1=empty($TPL_VAR["categoryList"])||!is_array($TPL_VAR["categoryList"])?0:count($TPL_VAR["categoryList"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '게임등록-게임마감';</script>
<script>
	function team_betting(url)
	{
		window.open(url,'','resizable=no width=520 height=210');
	}
	function team_betting2(url)
	{
		window.open(url,'','resizable=no width=520 height=240');
	}
	function go_delete(url)
	{
		if(confirm("정말 삭제하시겠습니까?")) {document.location = url;}
		else {return;}
	}
	function onModifyGameClick()
	{
		var iCount=0;
		for (i=0;i<document.all.length;i++) 
		{
			if(document.all[i].name=="y_id[]")
			{
				if(document.all[i].checked==true)
				{
					iCount++;
				}
			}
			else if(document.all[i].name=="check_cancel[]")
			{
				if(document.all[i].checked==true)
				{
					document.all[i].value="1";
				}
			}
		}
		if(iCount==0)
		{
			alert("선택된 경기가 없습니다.");
			return false;
		}
		else
		{
			falg=window.confirm("수정하시겠습니까?"); 
			if(falg)
			{
				document.form1.act.value="modify";
				document.form1.submit();
			}
		}
	}
	
	function onGameResultClick()
	{
		var iCount=0;
		for (i=0;i<document.all.length;i++) 
		{
			if(document.all[i].name=="y_id[]")
			{
				if(document.all[i].checked==true)
				{
					iCount++;
				}
			}
			else if(document.all[i].name=="check_cancel[]")
			{
				if(document.all[i].checked==true)	{document.all[i].value="1";}
			}
		}
		if(iCount==0)
		{
			alert("선택된 경기가 없습니다.");
			return false;
		}
		else
		{
			falg=window.confirm("수정하시겠습니까?"); 
			if(falg)
			{
				document.form1.act.value="modify_result";
				document.form1.submit();
			}
		}
	}
	
	function account_popup()
	{
		var width = 1024;
		var height = 600;

		var left = (screen.width/2)-(width/2);
		var top = (screen.height/2)-(height/2);
			
		var win = window.open ("", "popupWindow", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+width+', height='+height+', top='+top+', left='+left);
		document.popup.action = "/gameUpload/popup_win_member_list";
		document.popup.target = "popupWindow";
		
		document.popup.submit();
		win.focus();
	}
	
	function autoCheck($i, $data)
	{
		$("input[name='y_id[]']:checkbox").each(function($index)
		{
			if($index==$i)
			{
				if($data.length > 0)
					$(this).attr("checked", true);
					
				if($(this).is(":checked")==true && $data.length<=0)
					$(this).attr("checked", false);
			}
			/*
			if($(this).attr("checked")==true && $data.length<=0)
			{
				alert('11');
				$(this).attr("checked", false);
			}
			*/
		});
	}
	
	function autoCheck_check($i)
	{
		var y_id = document.getElementsByName('y_id[]');

		y_id[$i].checked=true;
	}

	function select_all()
	{	
		var check_state = document.form1.chkAll.checked;
		for (i=0;i<document.all.length;i++) 
		{
			if (document.all[i].name=="y_id[]") 
			{
				document.all[i].checked = check_state;
			}
		}
	}
	
	function select_to(obj) {
		if ( $(obj).attr("checked") == "checked" ) {
			$(obj).parent("td").parent("tr").find("input[name^=y_id]").prop("checked",true);
		} else {
			$(obj).parent("td").parent("tr").find("input[name^=y_id]").prop("checked",false);
		}
	}
</script>

</head>

<body>
	<div id="route">
		<h5>관리자 시스템 - 경기마감 목록</h5>
	</div>
	<h3>항목 보기</h3>
	<div id="search">
		<div class="wrap2">
			
			<form name="popup" id="popup" method="post">
				<input type="hidden" id="account_param" name="account_param" method="post" value="<?php echo $TPL_VAR["account_param"]?>">
				<input type="hidden" name="game_sn_list" value="<?php echo $TPL_VAR["game_sn_list"]?>">
				<input type="hidden" name="param_page_act" value="<?php echo $TPL_VAR["param_page_act"]?>">
			</form>
			
			<form name=frmSrh method=post action="/gameUpload/result_list"> 
				<input type="hidden" name="category_name" value="">
				<span>출력</span>
				<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<span>설정</span>
				<input type="radio" name="state" value=22 <?php if($TPL_VAR["state"]==22){?>checked<?php }?> class="radio">발매(배팅종료)
				&nbsp;

				<select name="parsing_type">
					<option value="ALL" <?php if($TPL_VAR["parsing_type"]=="ALL"){?> selected <?php }?>>전체</option>
					<option value="A" <?php if($TPL_VAR["parsing_type"]=="A"){?> selected <?php }?>>경기A타입</option>
					<option value="C" <?php if($TPL_VAR["parsing_type"]=="C"){?> selected <?php }?>>경기C타입</option>
					<option value="D" <?php if($TPL_VAR["parsing_type"]=="D"){?> selected <?php }?>>경기D타입</option>
                    <option value="S" <?php if($TPL_VAR["parsing_type"]=="S"){?> selected <?php }?>>경기S타입</option>
                    <option value="N" <?php if($TPL_VAR["parsing_type"]=="N"){?> selected <?php }?>>경기N타입</option>
				</select>
				
				<select name="special_type">
					<option value="">대분류</option>
					<option value="1"  <?php if($TPL_VAR["special_type"]==1){?>  selected <?php }?>>스포츠</option>
					<option value="4"  <?php if($TPL_VAR["special_type"]==4){?>  selected <?php }?>>라이브</option>
                    <option value="22" <?php if($TPL_VAR["special_type"]==22){?> selected <?php }?>>가상축구</option>
					<option value="5"  <?php if($TPL_VAR["special_type"]==5){?>  selected <?php }?>>사다리</option>
                    <option value="8" <?php if($TPL_VAR["special_type"]==8){?> selected <?php }?>>다리다리</option>
                    <option value="6"  <?php if($TPL_VAR["special_type"]==6){?>  selected <?php }?>>달팽이</option>
					<option value="7" <?php if($TPL_VAR["special_type"]==7){?> selected <?php }?>>파워볼</option>
                    <option value="24" <?php if($TPL_VAR["special_type"]==24){?> selected <?php }?>>키노사다리</option>
                    <option value="25" <?php if($TPL_VAR["special_type"]==25){?> selected <?php }?>>파워사다리</option>
                    <option value="28" <?php if($TPL_VAR["special_type"]==28){?> selected <?php }?>>로하이</option>
                    <option value="29" <?php if($TPL_VAR["special_type"]==29){?> selected <?php }?>>알라딘</option>
                    <option value="30" <?php if($TPL_VAR["special_type"]==30){?> selected <?php }?>>이다리</option>
                    <option value="31" <?php if($TPL_VAR["special_type"]==31){?> selected <?php }?>>삼다리</option>
                    <option value="32" <?php if($TPL_VAR["special_type"]==32){?> selected <?php }?>>초이스</option>
                    <option value="33" <?php if($TPL_VAR["special_type"]==33){?> selected <?php }?>>룰렛</option>
                    <option value="34" <?php if($TPL_VAR["special_type"]==34){?> selected <?php }?>>파라오</option>
                    <option value="21" <?php if($TPL_VAR["special_type"]==21){?> selected <?php }?>>나인</option>
                    <option value="26" <?php if($TPL_VAR["special_type"]==26){?> selected <?php }?>>MGM홀짝</option>
                    <option value="27" <?php if($TPL_VAR["special_type"]==27){?> selected <?php }?>>MGM바카라</option>
				</select>
				
				<select name="categoryName">
					<option value="">종목</option>
<?php if($TPL_categoryList_1){foreach($TPL_VAR["categoryList"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["name"]?>"  <?php if($TPL_VAR["categoryName"]==$TPL_V1["name"]){?>  selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
				<select name="league_sn">
					<option value="">리그</option>
	<?php 
		if ( count($TPL_VAR["league_list"]) > 0 ) {
			foreach ( $TPL_VAR["league_list"] as $leagueInfo ) {
				if ( $TPL_VAR["league_sn"] == $leagueInfo['league_sn'] ) $selected = "selected";
				else $selected = "";
				if ( !trim($leagueInfo['alias_name']) ) $league_name = $leagueInfo['league_name'];
				else $league_name = $leagueInfo['alias_name'];
				echo "<option value=\"".$leagueInfo['league_sn']."\" {$selected}>".$league_name."</option>";
			}
		}
	?>
				</select>
				&nbsp;&nbsp;			
				<!-- 기간 필터 -->
			<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
			<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				
			<!-- 팀검색, 리그검색 -->
			<select name="filter_team_type">
				<option value="home_team" <?php if($TPL_VAR["filter_team_type"]=="home_team"){?> selected<?php }?>>홈팀</option>
				<option value="away_team" <?php if($TPL_VAR["filter_team_type"]=="away_team"){?> selected<?php }?>>원정팀</option>
				<option value="league" 		<?php if($TPL_VAR["filter_team_type"]=="league"){?> selected<?php }?>>리그명</option>
			</select>
			<input type="text" size="10" name="filter_team" value="<?php echo $TPL_VAR["filter_team"]?>" class="name">
			<!-- 검색버튼 -->
			<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			&nbsp;&nbsp;
			
			<!--<input type="checkbox" name="money_option" value="" <?php if($TPL_VAR["money_option"]==1){?>checked<?php }?> onClick="onCheckbox(this.form)" class="radio"><font color='red'>배팅금액 0↑</font>-->
				<span class="rightSort">
					<span>선택 항목을</span>
					<input type="hidden" name="mode">
					<input type="button" value="일괄정산처리" onclick="onGameResultClick()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
				</span>
			</form>
		</div>
	</div>
	
	<form id="form1" name="form1" method="post" action="?">
		<input type="hidden" name="act">
		<input type="hidden" name="select_home_score[]">
		<input type="hidden" name="select_away_score[]">
		<input type="hidden" name="select_game_type[]">
		
		<input type="hidden" name="page" value=<?php echo $TPL_VAR["page"]?>>
		<input type="hidden" name="perpage" value=<?php echo $TPL_VAR["perpage"]?>>
		<input type="hidden" name="state" value=<?php echo $TPL_VAR["state"]?>>
		<input type="hidden" name="special_type" value=<?php echo $TPL_VAR["special_type"]?>>
		<input type="hidden" name="categoryName" value=<?php echo $TPL_VAR["categoryName"]?>>
		<input type="hidden" name="begin_date" value=<?php echo $TPL_VAR["begin_date"]?>>
		<input type="hidden" name="end_date" value=<?php echo $TPL_VAR["end_date"]?>>
		<input type="hidden" name="filter_team_type" value=<?php echo $TPL_VAR["filter_team_type"]?>>
		<input type="hidden" name="filter_team" value=<?php echo $TPL_VAR["filter_team"]?>>
		<input type="hidden" name="winner_list" value=<?php echo $TPL_VAR["winner_list"]?>>
  	
		<table cellspacing="1" class="tableStyle_gameList" summary="항목보기">
		<legend class="blind">항목보기</legend>
			<thead>
				<tr>
					<th class="check" width="5"><input type="checkbox" name="chkAll" onClick="select_all()"/></th>
						<th>경기타입</th>
						<th>경기일시</th>
						<th>진행상태</th>
						<th>대분류</th>
						<th>종류</th>
						<th>종목</th>
						<th>리그</th>
						<th>승(홈팀)</th>
						<th>VS</th>
						<th>패(원정팀)</th>
	<?php if($TPL_VAR["state"]!=3){?>
						<th>결과</th>
	<?php }?>
				</tr>
	 		</thead>
			<tbody>
<?php if($TPL_list_1){$TPL_I1=-1;foreach($TPL_VAR["list"] as $TPL_V1){$TPL_I1++;?>
					<tr>
						<td><input name="y_id[]" type="checkbox" value="<?php echo $TPL_V1["sn"]?>" onClick="select_to(this);"/></td>
						<td><?php echo "타입".$TPL_V1["parsing_site"];?></td>
						<td><?php if($TPL_V1["update_enable"]==0){?><span style="border-bottom:1px solid red;"><?php }?><?php echo sprintf("%s %s:%s",substr($TPL_V1["gameDate"],5),$TPL_V1["gameHour"],$TPL_V1["gameTime"])?></td>
						<td>
<?php if(is_null($TPL_V1["kubun"])){?> <img src="/img/icon_gameStand.gif">
<?php }elseif($TPL_V1["kubun"]==0){?><img src="/img/icon_gameGoing.gif">
<?php }elseif($TPL_V1["kubun"]==1){?><img src="/img/icon_gameEnd.gif">
<?php }?>
						</td>
						<td>
<?php if($TPL_V1["special"] < 4){?>스포츠
<?php }elseif($TPL_V1["special"]==4){?>라이브
<?php }elseif($TPL_V1["special"]==5){?>사다리
<?php }elseif($TPL_V1["special"]==8){?>달팽이
<?php }elseif($TPL_V1["special"]==7){?>파워볼
<?php }elseif($TPL_V1["special"]==6){?>다리다리
<?php }elseif($TPL_V1["special"]==22){?>가상축구
<?php }elseif($TPL_V1["special"]==24){?>키노사다리
<?php }elseif($TPL_V1["special"]==25){?>파워사다리
<?php }elseif($TPL_V1["special"]==28){?>로하이
<?php }elseif($TPL_V1["special"]==29){?>알라딘
<?php }elseif($TPL_V1["special"]==30){?>이다리
<?php }elseif($TPL_V1["special"]==31){?>삼다리
<?php }elseif($TPL_V1["special"]==32){?>초이스
<?php }elseif($TPL_V1["special"]==33){?>룰렛
<?php }elseif($TPL_V1["special"]==34){?>파라오
<?php }elseif($TPL_V1["special"]==21){?>나인
<?php }elseif($TPL_V1["special"]==26){?>MGM홀짝
<?php }elseif($TPL_V1["special"]==27){?>MGM바카라
<?php }?>
						</td>
						<td>
							<input type="hidden" name="game_types[]" value=<?php echo $TPL_V1["type"]?>>
							<?php
								$pieces = explode("|", $TPL_V1["mname_ko"]);
								switch($TPL_V1["sport_id"]) {
									case 6046: // 축구
										echo $pieces[0];
										break;
									case 48242: // 농구
										echo $pieces[1];
										break;
									case 154914: // 야구
										echo $pieces[2];
										break;
									case 154830: // 배구
										echo $pieces[3];
										break;
									case 35232: // 아이스 하키
										echo $pieces[4];
										break;
									case 687890: // E스포츠
										echo $pieces[5];
										break;
								}
							?>
						</td>
						<td><?php echo $TPL_V1["sport_name"]?></td>
						<td><?php echo $TPL_V1["league_name"]?></td>
						<? if($TPL_V1["special"] < 5) { ?>
							<td class="homeName">
								<font color=blue><?php echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")?></font>
								[<?php echo $TPL_V1["home_rate"]?>]
								<br><?php echo number_format($TPL_V1["home_total_betting"],0)?>
							</td>
							<td>
								[<?php 
								switch($TPL_V1["mfamily"]) {
									case 1:
										echo $TPL_V1["draw_rate"]; 
										break;
									case 2:
										echo "VS";
										break;
									case 7:
										echo $TPL_V1["home_line"];
										break;
									case 8:
										$home_line = explode(" ", $TPL_V1["home_line"]);
										echo $home_line[0];
										break;
									case 10:
										echo "VS";
										break;
									case 11:
										echo $TPL_V1["home_name"];
										break;
									case 12:
										echo $TPL_V1["draw_rate"];
										break;
									case 47:
										echo $TPL_V1["home_line"];
										break;
								}
								?>]
								<br><?php echo number_format($TPL_V1["draw_total_betting"],0)?></td>
							<td class="awayName">
								<font color=blue><b><?php echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")?></b></font>
								[<?php echo $TPL_V1["away_rate"]?>]
								<br><?php echo number_format($TPL_V1["away_total_betting"],0)?>
							</td>
						<? } else { ?>
							<td class="homeName">
								<font color=blue><?=$TPL_V1["home_team"]?></font>
								[<?php echo $TPL_V1["home_rate"]?>]
								<br><?php echo number_format($TPL_V1["home_total_betting"],0)?>
							</td>
							<td>
								[<?php echo $TPL_V1["draw_rate"]?>]
								<br><?php echo number_format($TPL_V1["draw_total_betting"],0)?></td>
							<td class="awayName">
								<font color=blue><b><?=$TPL_V1["away_team"]?></b></font>
								[<?php echo $TPL_V1["away_rate"]?>]
								<br><?php echo number_format($TPL_V1["away_total_betting"],0)?>
							</td>
						<? } ?>
<?php if($TPL_VAR["state"]!=3){?>
						<td>
							<select name="game_result_<?php echo $TPL_V1["sn"]?>" onchange='autoCheck_check(<?php echo $TPL_I1?>)'>
								<option value="1">홈승</option>
								<option value="2">원정승</option>
								<option value="3">무승부</option>
								<option value="4">취소</option>
							</select>
						</td>
<?php }?>
					</tr>
<?php }}?>
			</tbody>
		</table>
 		
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	</form>
	

<?php if($TPL_VAR["account_param"]!=""){?>
	<script>account_popup();</script>
<?php }?>