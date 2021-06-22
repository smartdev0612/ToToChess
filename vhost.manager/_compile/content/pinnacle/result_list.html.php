<?php /* Template_ 2.2.3 2014/09/26 01:44:47 D:\www_kd_20140905\vhost.manager\_template\content\pinnacle\result_list.html */
$TPL_categoryList_1=empty($TPL_VAR["categoryList"])||!is_array($TPL_VAR["categoryList"])?0:count($TPL_VAR["categoryList"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '피나클게임관리-게임마감';</script>
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
		});
	}
	
	function autoCheck_check($i)
	{
		var chk_cancel = document.getElementsByName('check_cancel[]');
		var y_id = document.getElementsByName('y_id[]');

		if(chk_cancel[$i].checked)
		{
			y_id[$i].checked=true;
		}
		else
		{
			y_id[$i].checked=false;
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
			<form name=frmSrh method=post action="/PinnacleGame/result_list"> 
				<input type="hidden" name="category_name" value="">
				<span>출력</span>
				<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<select name="game_type">
					<option value="">종류</option>
					<option value="1"  <?php if($TPL_VAR["gameType"]==1){?>  selected <?php }?>>승무패</option>
					<option value="2"  <?php if($TPL_VAR["gameType"]==2){?>  selected <?php }?>>핸디캡</option>
					<option value="4"  <?php if($TPL_VAR["gameType"]==4){?>  selected <?php }?>>언더오버</option>
				</select>
				
				<select name="categoryName">
					<option value="">종목</option>
<?php if($TPL_categoryList_1){foreach($TPL_VAR["categoryList"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["name"]?>"  <?php if($TPL_VAR["categoryName"]==$TPL_V1["name"]){?>  selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
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
			
				<span class="rightSort">
					<span>선택 항목을</span>
					<input type="hidden" name="mode">
<?php if($TPL_VAR["state"]==3){?>
					<input type="button" value="선택게임수정" onclick="onModifyGameClick()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
<?php }else{?>
					<input type="button" value="일괄정산처리" onclick="onGameResultClick()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
<?php }?>
				</span>
			</form>
		</div>
	</div>
	
	<form id="form1" name="form1" method="post" action="/PinnacleGame/game_fin_process?page_act=<?php echo $TPL_VAR["page_act"]?>">
  	<input type="hidden" name="act">
  	<input type="hidden" name="select_home_score[]">
  	<input type="hidden" name="select_away_score[]">
  	<input type="hidden" name="select_game_type[]">
  	
  	<input type="hidden" name="page" value=<?php echo $TPL_VAR["page"]?>>
  	<input type="hidden" name="perpage" value=<?php echo $TPL_VAR["perpage"]?>>
  	<input type="hidden" name="special_type" value=<?php echo $TPL_VAR["special_type"]?>>
  	<input type="hidden" name="game_type" value=<?php echo $TPL_VAR["gameType"]?>>
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
	      	<th class="check" width="5"><input type="checkbox" name="chkAll" onclick="javascript:selectAll(this);"/></th>
					<th>경기일시</th>
					<th>진행상태</th>
					<th>종목</th>
					<th>리그</th>
					<th>승(홈팀)</th>
					<th>VS</th>
					<th>패(원정팀)</th>
<?php if($TPL_VAR["state"]!=3){?>
					<th>취소</th>
					<th>스코어</th>
					<th>이긴 팀</th>
<?php }?>
	    	</tr>
	 		</thead>
			<tbody>
<?php if($TPL_list_1){$TPL_I1=-1;foreach($TPL_VAR["list"] as $TPL_V1){$TPL_I1++;?>
					<tr>
						<td><input name="y_id[]" type="checkbox" value="<?php echo $TPL_V1["sn"]?>"/></td>
						<td><?php echo $TPL_V1["start_time"]?></td>
						<td>
<?php if($TPL_V1["state"]=='PLAY'){?><img src="/img/icon_gameGoing.gif">
<?php }elseif($TPL_V1["state"]=='FIN'){?><img src="/img/icon_gameEnd.gif">
<?php }?>
						</td>
						<td><?php echo $TPL_V1["sport"]?></td>
						<td><?php echo $TPL_V1["name"]?></td>
						<td class="homeName"><font color=blue><?php echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")?></font></td>
						<td><b><font color='red'>VS</font></b></td>
						<td class="awayName"><font color=blue><b><?php echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")?></b></font></td>
<?php if($TPL_VAR["state"]!=3){?>
						<td><input type="checkbox" name="check_cancel[]" onclick='autoCheck_check(<?php echo $TPL_I1?>)' ></td>
						<td>
							<input type="text" name="home_score[<?php echo $TPL_V1["sn"]?>]" size="5" value="<?php echo $TPL_V1["home_score"]?>" style="border:1px #97ADCE solid;" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")' onblur='autoCheck(<?php echo $TPL_I1?>, this.value)'>
							:
							<input type="text" name="away_score[<?php echo $TPL_V1["sn"]?>]" size="5" value="<?php echo $TPL_V1["away_score"]?>" style="border:1px #97ADCE solid;" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")'>
						</td>
						<td>
<?php if($TPL_V1["win"]=='-1'){?> 정산대기
<?php }elseif($TPL_V1["win"]=='1'){?> 홈승
<?php }elseif($TPL_V1["win"]=='2'){?> 원정승
<?php }elseif($TPL_V1["win"]=='X'){?> 무승부
<?php }elseif($TPL_V1["win"]=='CANCEL'){?> 취소/적특
<?php }else{?> &nbsp;
<?php }?>
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