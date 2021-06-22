<?php
$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	function onSelectAll(chk)
	{	
		var chk = document.frm.chkAll.checked;
		for (i=0;i<document.all.length;i++) 
		{
			if (document.all[i].name=="child_sn[]") 
			{
				document.all[i].checked=chk;
			}
		}
	}

	function onCopyClick()
	{
		var iCount=0;
		for (i=0;i<document.all.length;i++) 
		{
			if(document.all[i].name=="child_sn[]")
			{
				if(document.all[i].checked==true)
				{
					iCount++;
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
			falg=window.confirm("복사 하시겠습니까?"); 
			if(falg)
			{
				var checkboxes;
				if(document.frm.handicap.checked) 	{checkboxes="1";}
				else															{checkboxes="0";}
					
				if(document.frm.underover.checked) 	{checkboxes+="1";}
				else															{checkboxes+="0";}
					
				if(document.frm.s_handicap.checked) 		{checkboxes+="1";}
				else															{checkboxes+="0";}
					
				if(document.frm.s_underover.checked) 		{checkboxes+="1";}
				else															{checkboxes+="0";}
					
				document.frm.checkboxes.value=checkboxes;
				
				document.frm.submit();
			}
		}
	}
</script>
</head>

	<div id="route">
		<h5>관리자 시스템 - 게임 복사</h5>
	</div>
	<h3>게임 복사</h3>

	<div id="search">
		<div class="betList_option">
			<form name="frmSrh" method="post" action="/gameUpload/game_copy_list">
				
				<span class="icon">날짜</span>
				<input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>
				~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>
				
				<span>종목</span>
				<select name="keyword_category" onchange="submit()">
					<option value="">::전체</option>
<?php if($TPL_category_list_1){foreach($TPL_VAR["category_list"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["keyword_category"]==$TPL_V1["name"]){?>selected<?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
				
				<span>검색</span>
				<select name="selector">
					<option value="league" <?php if($TPL_VAR["selector"]=="league"){?>selected<?php }?>>리그명</option>
					<option value="home_team" <?php if($TPL_VAR["selector"]=="home_team"){?>selected<?php }?>>홈팀명</option>
					<option value="away_team" <?php if($TPL_VAR["selector"]=="away_team"){?>selected<?php }?>>원정팀명</option>
				</select>
				<input type="text" name="keyword" value="<?php echo $TPL_VAR["keyword"]?>">
				<input type="button" value="검색" onclick="submit()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
			</form>
		</div>
		
		<div class="wrap_search">	
			<form name="frm" method="post" action="?">
			<input type="hidden" name="mode" value="copy">
			<input type="hidden" name="checkboxes" value="">
			<span>설정</span>
			핸디캡 : <input type="text" name="handicap_rate" size="5" value="1.86" style="border:1px #97ADCE solid;" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")'>
			언더오버 : <input type="text" name="underover_rate" size="5" value="1.86" style="border:1px #97ADCE solid;" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")'>
			실시간 핸디캡 : <input type="text" name="special_handicap_rate" size="5" value="1.86" style="border:1px #97ADCE solid;" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")'>
			실시간 언더오버 : <input type="text" name="special_underover_rate" size="5" value="1.86" style="border:1px #97ADCE solid;" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")'>
			<br>
			<input type="checkbox" name="handicap" class="radio">핸디캡
			<input type="checkbox" name="underover" class="radio">언더오버
			<input type="checkbox" name="s_handicap" class="radio">핸디캡(실시간)
			<input type="checkbox" name="s_underover" class="radio">언더오버(실시간)
			<input type="button" value="일괄복사" onclick="onCopyClick()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		</div>
	</div>
	
  	
	<table cellspacing="1" class="tableStyle_gameList">
		<legend class="blind">항목보기</legend>
			<thead>
	    	<tr>
	      	<th class="check" width="5"><input type="checkbox" name="chkAll" onclick="javascript:onSelectAll(this);"/></th>
					<th>No</th>
					<th>경기일시</th>
					<th>종목</th>
					<th>리그</th>
					<th>홈팀</th>
					<th>홈배당</th>
					<th>무배당(기준점)</th>
					<th>원정팀</th>
					<th>원정배당</th>
	    	</tr>
	 		</thead>
			<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
					<tr>
						<td><input name="child_sn[]" type="checkbox" value="<?php echo $TPL_V1["sn"]?>"/></td>
						<td><?php echo $TPL_V1["sn"]?></td>
						<td><input name="game_date[<?php echo $TPL_V1["sn"]?>]" type="hidden" value="<?php echo sprintf("%s %s:%s",$TPL_V1["gameDate"],$TPL_V1["gameHour"],$TPL_V1["gameTime"])?>"/><?php echo sprintf("%s %s:%s",substr($TPL_V1["gameDate"],5),$TPL_V1["gameHour"],$TPL_V1["gameTime"])?></td>
						<td><input name="category[<?php echo $TPL_V1["sn"]?>]" type="hidden" value="<?php echo $TPL_V1["sport_name"]?>"/><?php echo $TPL_V1["sport_name"]?></td>
						<td><input name="league_sn[<?php echo $TPL_V1["sn"]?>]" type="hidden" value="<?php echo $TPL_V1["league_sn"]?>"/><?php echo $TPL_V1["league_name"]?></td>
						<td class="homeName"><input name="home_team[<?php echo $TPL_V1["sn"]?>]" type="hidden" value="<?php echo $TPL_V1["home_team"]?>"/><font color=blue><?php echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")?></font></td>
						<td><input type='hidden' name="home_rate[<?php echo $TPL_V1["sn"]?>]" value="<?php echo $TPL_V1["home_rate"]?>"/><?php echo $TPL_V1["home_rate"]?></td>
						<td><input type='hidden' name="draw_rate[<?php echo $TPL_V1["sn"]?>]" value="<?php echo $TPL_V1["draw_rate"]?>"/><?php echo $TPL_V1["draw_rate"]?></td>
						<td class="awayName"><input name="away_team[<?php echo $TPL_V1["sn"]?>]" type="hidden" value="<?php echo $TPL_V1["away_team"]?>"/><font color=blue><b><?php echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")?></b></font></td>
						<td><input type='hidden' name="away_rate[<?php echo $TPL_V1["sn"]?>]" value="<?php echo $TPL_V1["away_rate"]?>"/><?php echo $TPL_V1["away_rate"]?></td>
					</tr>
<?php }}?>
			</tbody>
		</table>
	</form>
	
</div>