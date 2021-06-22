<?php
$TPL_categoryList_1=empty($TPL_VAR["categoryList"])||!is_array($TPL_VAR["categoryList"])?0:count($TPL_VAR["categoryList"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '게임등록-게임재정산';</script>
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

	function select_all()
	{	
		var check_state = document.form1.chkAll.checked;
		for (i=0;i<document.all.length;i++) 
		{
			if (document.all[i].name=="y_id[]") 
			{
				document.all[i].checked = check_state;
			}
			if (document.all[i].name=="y_id_back[]") 
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

	function changeGameType() 
    {
        var categoryName = $("#categoryName").val();
        var options = "";
        switch(categoryName) 
        {
            case "축구":           //축구
                options += "<option value=''>종류</option>;"
                options += "<option value='1'>승패</option>";
                options += "<option value='2'>핸디캡</option>";
                options += "<option value='3'>언더오버</option>";
                options += "<option value='4'>승무패</option>";
                options += "<option value='5'>전반전 승무패</option>";
                options += "<option value='6'>후반전 승무패</option>";
                options += "<option value='7'>전반전 언더오버</option>";
                options += "<option value='8'>후반전 언더오버</option>";
                options += "<option value='9'>득점홀짝</option>";
                options += "<option value='10'>전반전 홀짝</option>";
				options += "<option value='11'>핸디캡 추가기준점</option>";
				options += "<option value='12'>언더오버 추가기준점</option>";
				options += "<option value='13'>정확한 스코어</option>";
                break;
            case "농구":           //농구
                options += "<option value=''>종류</option>;"
                options += "<option value='1'>승패</option>";
                options += "<option value='2'>핸디캡</option>";
                options += "<option value='3'>언더오버</option>";
                options += "<option value='4'>1쿼터 승무패</option>";
                options += "<option value='5'>2쿼터 승무패</option>";
                options += "<option value='6'>3쿼터 승무패</option>";
                options += "<option value='7'>4쿼터 승무패</option>";
                options += "<option value='8'>1쿼터 핸디캡</option>";
                options += "<option value='9'>2쿼터 핸디캡</option>";
                options += "<option value='10'>3쿼터 핸디캡</option>";
                options += "<option value='11'>4쿼터 핸디캡</option>";
                options += "<option value='12'>1쿼터 언더오버</option>";
                options += "<option value='13'>2쿼터 언더오버</option>";
                options += "<option value='14'>3쿼터 언더오버</option>";
                options += "<option value='15'>4쿼터 언더오버</option>";
				options += "<option value='16'>핸디캡 추가기준점</option>";
				options += "<option value='17'>언더오버 추가기준점</option>";
                break;
            case "배구":           //배구
                options += "<option value=''>종류</option>;"
                options += "<option value='1'>승패</option>";
                options += "<option value='2'>핸디캡</option>";
                options += "<option value='3'>언더오버</option>";
                options += "<option value='4'>홀짝</option>";
                options += "<option value='5'>1세트 홀짝</option>";
				options += "<option value='6'>정확한 스코어</option>";
                break;
            case "야구":           //야구
                options += "<option value=''>종류</option>;"
                options += "<option value='1'>승패</option>";
                options += "<option value='2'>핸디캡</option>";
                options += "<option value='3'>언더오버</option>";
                options += "<option value='4'>1이닝 승무패</option>";
                options += "<option value='5'>3이닝 합계 핸디캡</option>";
                options += "<option value='6'>5이닝 합계 핸디캡</option>";
                options += "<option value='7'>7이닝 합계 핸디캡</option>";
                options += "<option value='8'>3이닝 합계 언더오버</option>";
                options += "<option value='9'>5이닝 합계 언더오버</option>";
                options += "<option value='10'>7이닝 합계 언더오버</option>";
				options += "<option value='11'>핸디캡 추가기준점</option>";
				options += "<option value='12'>언더오버 추가기준점</option>";
                break;
            case "하키":           //하키
                options += "<option value=''>종류</option>;"
                options += "<option value='1'>승패</option>";
                options += "<option value='2'>핸디캡</option>";
                options += "<option value='3'>언더오버</option>";
                options += "<option value='4'>승무패</option>";
                options += "<option value='5'>1피리어드 승패</option>";
                options += "<option value='6'>1피리어드 승무패</option>";
                options += "<option value='7'>1피리어드 핸디캡</option>";
                options += "<option value='8'>1피리어드 언더오버</option>";
                break;
        }
        console.log(options);
        $("#game_type").empty();
        $("#game_type").append(options);
    }
</script>

</head>

<body>
	<div id="route">
		<h5>관리자 시스템 - 경기마감 목록</h5>
	</div>
	<h3>항목 보기</h3>
	<div id="betting_2">
        <ul id="tab">
            <li><a href="/gameUpload/result_list_resettle" id="sport_1">스포츠 I</a></li>
            <li><a href="/gameUpload/result_list_resettle_multi" id="sport_2">스포츠 II</a></li>
        </ul>
    </div>

	<div id="search">
		<div class="wrap2">
			
			<form name="popup" id="popup" method="post">
				<input type="hidden" id="account_param" name="account_param" method="post" value="<?php echo $TPL_VAR["account_param"]?>">
				<input type="hidden" name="game_sn_list" value="<?php echo $TPL_VAR["game_sn_list"]?>">
				<input type="hidden" name="param_page_act" value="<?php echo $TPL_VAR["param_page_act"]?>">
			</form>
			
			<form name=frmSrh method=post action="/gameUpload/result_list_resettle_multi">
				<input type="hidden" name="category_name" value="">
				<span>출력</span>
				<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<!--<span>설정</span>
				<input type="radio" name="state" value=3 <?php /*if($TPL_VAR["state"]==3){*/?>checked<?php /*}*/?> class="radio">배당수정
				<input type="radio" name="state" value=21 <?php /*if($TPL_VAR["state"]==21){*/?>checked<?php /*}*/?> class="radio">발매(배팅가능)
				<input type="radio" name="state" value=22 <?php /*if($TPL_VAR["state"]==22){*/?>checked<?php /*}*/?> class="radio">발매(배팅종료)-->
				&nbsp;

				<select name="parsing_type">
					<option value="ALL" <?php if($TPL_VAR["parsing_type"]=="ALL"){?> selected <?php }?>>전체</option>
					<option value="A" <?php if($TPL_VAR["parsing_type"]=="A"){?> selected <?php }?>>경기A타입</option>
					<option value="C" <?php if($TPL_VAR["parsing_type"]=="C"){?> selected <?php }?>>경기C타입</option>
					<option value="D" <?php if($TPL_VAR["parsing_type"]=="D"){?> selected <?php }?>>경기D타입</option>
                    <option value="S" <?php if($TPL_VAR["parsing_type"]=="S"){?> selected <?php }?>>경기S타입</option>
                    <option value="N" <?php if($TPL_VAR["parsing_type"]=="N"){?> selected <?php }?>>경기N타입</option>
				</select>
				
				
				
				<select id="categoryName" name="categoryName" onchange="changeGameType()">
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
				<select id="game_type" name="game_type">
					<option value="">종류</option>
				</select>
				&nbsp;&nbsp;			
				<!-- 기간 필터 -->
			<span class="icon">날자&nbsp;</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
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
<?php if($TPL_VAR["state"]==3){?>
					<input type="button" value="선택게임수정" onclick="onModifyGameClick()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
<?php }else{?>
					<input type="button" value="일괄재정산처리" onclick="onGameResultClick()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
<?php }?>
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
	      	<th class="check" width="5"><input type="checkbox" name="chkAll" onClick="select_all()"/></th>
					<th>경기타입</th>
					<th>경기일시</th>
					<th>진행상태</th>
					<th>종류</th>
					<th>종목</th>
					<th>리그</th>
					<th>승(홈팀)</th>
					<th>VS</th>
					<th>패(원정팀)</th>
					<th>홈배당</th>
					<th>무배당</th>
					<th>원정배당</th>
					<!--<th>취소</th>-->
					<th>스코어</th>
					<th>이긴 팀</th>
					<th class="check" width="5"></th>
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
							<input type="hidden" name="game_types[<?php echo $TPL_V1["sn"]?>]" value=<?php echo $TPL_V1["betting_type"]?>>
							<?php 
							$detail_name = "";
							$home_score = "";
							$away_score = "";
							switch ($TPL_V1['sport_name']) {
								case "축구":
									switch ($TPL_V1['betting_type']) {
										case "1":
											$detail_name = "<span class='victory'>승패</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "2":
										case "11":
											$detail_name = "<span class='handicap'>핸디캡</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "3":
										case "12":
											$detail_name = "<span class='underover'>언더오버</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "4":
											$detail_name = "<span class='victory'>승무패</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "5":
											$detail_name = "<span class='victory'>승무패(전반)</span>";
											$home_score = $TPL_V1['home_half_time_score'];
											$away_score = $TPL_V1['away_half_time_score'];
											break;
										case "6":
											$detail_name = "<span class='victory'>승무패(후반)</span>";
											$home_score = $TPL_V1['home_2nd_half_time_score'];
											$away_score = $TPL_V1['away_2nd_half_time_score'];
											break;
										case "7":
											$detail_name = "<span class='underover'>언더오버(전반)</span>";
											$home_score = $TPL_V1['home_half_time_score'];
											$away_score = $TPL_V1['away_half_time_score'];
											break;
										case "8":
											$detail_name = "<span class='underover'>언더오버(후반)</span>";
											$home_score = $TPL_V1['home_2nd_half_time_score'];
											$away_score = $TPL_V1['away_2nd_half_time_score'];
											break;
										case "9":
											$detail_name = "<span>득점홀짝</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "10":
											$detail_name = "<span>득점홀짝(전반)</span>";
											$home_score = $TPL_V1['home_half_time_score'];
											$away_score = $TPL_V1['away_half_time_score'];
											break;
										case "13":
											$detail_name = "정확한 스코어 (" . $TPL_V1['point'] . ")";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
									}
									break;
								case "농구":
									switch ($TPL_V1['betting_type']) {
										case "1":
											$detail_name = "<span class='victory'>승패</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "2":
										case "16":
											$detail_name = "<span class='handicap'>핸디캡</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "3":
										case "17":
											$detail_name = "<span class='underover'>언더오버</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "4":
											$detail_name = "<span class='victory'>승무패(1쿼터)</span>";
											$home_score = $TPL_V1['home_1_time_score'];
											$away_score = $TPL_V1['away_1_time_score'];
											break;
										case "5":
											$detail_name = "<span class='victory'>승무패(2쿼터)</span>";
											$home_score = $TPL_V1['home_2_time_score'];
											$away_score = $TPL_V1['away_2_time_score'];
											break;
										case "6":
											$detail_name = "<span class='victory'>승무패(3쿼터)</span>";
											$home_score = $TPL_V1['home_3_time_score'];
											$away_score = $TPL_V1['away_3_time_score'];
											break;
										case "7":
											$detail_name = "<span class='victory'>승무패(4쿼터)</span>";
											$home_score = $TPL_V1['home_4_time_score'];
											$away_score = $TPL_V1['away_4_time_score'];
											break;
										case "8":
											$detail_name = "<span class='handicap'>핸디캡(1쿼터)</span>";
											$home_score = $TPL_V1['home_1_time_score'];
											$away_score = $TPL_V1['away_1_time_score'];
											break;
										case "9":
											$detail_name = "<span class='handicap'>핸디캡(2쿼터)</span>";
											$home_score = $TPL_V1['home_2_time_score'];
											$away_score = $TPL_V1['away_2_time_score'];
											break;
										case "10":
											$detail_name = "<span class='handicap'>핸디캡(3쿼터)</span>";
											$home_score = $TPL_V1['home_3_time_score'];
											$away_score = $TPL_V1['away_3_time_score'];
											break;
										case "11":
											$detail_name = "<span class='handicap'>핸디캡(4쿼터)</span>";
											$home_score = $TPL_V1['home_4_time_score'];
											$away_score = $TPL_V1['away_4_time_score'];
											break;
										case "12":
											$detail_name = "<span class='underover'>언더오버(1쿼터)</span>";
											$home_score = $TPL_V1['home_1_time_score'];
											$away_score = $TPL_V1['away_1_time_score'];
											break;
										case "13":
											$detail_name = "<span class='underover'>언더오버(2쿼터)</span>";
											$home_score = $TPL_V1['home_2_time_score'];
											$away_score = $TPL_V1['away_2_time_score'];
											break;
										case "14":
											$detail_name = "<span class='underover'>언더오버(3쿼터)</span>";
											$home_score = $TPL_V1['home_3_time_score'];
											$away_score = $TPL_V1['away_3_time_score'];
											break;
										case "15":
											$detail_name = "<span class='underover'>언더오버(4쿼터)</span>";
											$home_score = $TPL_V1['home_4_time_score'];
											$away_score = $TPL_V1['away_4_time_score'];
											break;
									}
									break;
								case "배구":
									switch ($TPL_V1['betting_type']) {
										case "1":
											$detail_name = "<span class='victory'>승패</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "2":
											$detail_name = "<span class='handicap'>핸디캡</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "3":
											$detail_name = "<span class='underover'>언더오버</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "4":
											$detail_name = "<span>홀짝</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "5":
											$detail_name = "<span>홀짝(1세트)</span>";
											$home_score = $TPL_V1['home_1_time_score'];
											$away_score = $TPL_V1['away_1_time_score'];
											break;
										case "6":
											$detail_name = "정확한 스코어 (" . $TPL_V1['point'] . ")";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
									}
									break;
								case "야구":
									switch ($TPL_V1['betting_type']) {
										case "1":
											$detail_name = "<span class='victory'>승패</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "2":
										case "11":
											$detail_name = "<span class='handicap'>핸디캡</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "3":
										case "12":
											$detail_name = "<span class='underover'>언더오버</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "4":
											$detail_name = "<span class='victory'>승무패(1이닝)</span>";
											$home_score = $TPL_V1['home_1_time_score'];
											$away_score = $TPL_V1['away_1_time_score'];
											break;
										case "5":
											$detail_name = "<span class='handicap'>핸디캡(3이닝)</span>";
											$home_score = intval($TPL_V1['home_1_time_score']) + intval($TPL_V1['home_2_time_score']) + intval($TPL_V1['home_3_time_score']);
											$away_score = intval($TPL_V1['away_1_time_score']) + intval($TPL_V1['away_2_time_score']) + intval($TPL_V1['away_3_time_score']);
											break;
										case "6":
											$detail_name = "<span class='handicap'>핸디캡(5이닝)</span>";
											$home_score = intval($TPL_V1['home_1_time_score']) + intval($TPL_V1['home_2_time_score']) + intval($TPL_V1['home_3_time_score']) + intval($TPL_V1['home_4_time_score']) + intval($TPL_V1['home_5_time_score']);
											$away_score = intval($TPL_V1['away_1_time_score']) + intval($TPL_V1['away_2_time_score']) + intval($TPL_V1['away_3_time_score']) + intval($TPL_V1['away_4_time_score']) + intval($TPL_V1['away_5_time_score']);
											break;
										case "7":
											$detail_name = "<span class='handicap'>핸디캡(7이닝)</span>";
											$home_score = intval($TPL_V1['home_1_time_score']) + intval($TPL_V1['home_2_time_score']) + intval($TPL_V1['home_3_time_score']) + intval($TPL_V1['home_4_time_score']) + intval($TPL_V1['home_5_time_score']) + intval($TPL_V1['home_6_time_score']) + intval($TPL_V1['home_7_time_score']);
											$away_score = intval($TPL_V1['away_1_time_score']) + intval($TPL_V1['away_2_time_score']) + intval($TPL_V1['away_3_time_score']) + intval($TPL_V1['away_4_time_score']) + intval($TPL_V1['away_5_time_score']) + intval($TPL_V1['away_6_time_score']) + intval($TPL_V1['away_7_time_score']);
											break;
										case "8":
											$detail_name = "<span class='underover'>언더오버(3이닝)</span>";
											$home_score = intval($TPL_V1['home_1_time_score']) + intval($TPL_V1['home_2_time_score']) + intval($TPL_V1['home_3_time_score']);
											$away_score = intval($TPL_V1['away_1_time_score']) + intval($TPL_V1['away_2_time_score']) + intval($TPL_V1['away_3_time_score']);
											break;
										case "9":
											$detail_name = "<span class='underover'>언더오버(5이닝)</span>";
											$home_score = intval($TPL_V1['home_1_time_score']) + intval($TPL_V1['home_2_time_score']) + intval($TPL_V1['home_3_time_score']) + intval($TPL_V1['home_4_time_score']) + intval($TPL_V1['home_5_time_score']);
											$away_score = intval($TPL_V1['away_1_time_score']) + intval($TPL_V1['away_2_time_score']) + intval($TPL_V1['away_3_time_score']) + intval($TPL_V1['away_4_time_score']) + intval($TPL_V1['away_5_time_score']);
											break;
										case "10":
											$detail_name = "<span class='underover'>언더오버(7이닝)</span>";
											$home_score = intval($TPL_V1['home_1_time_score']) + intval($TPL_V1['home_2_time_score']) + intval($TPL_V1['home_3_time_score']) + intval($TPL_V1['home_4_time_score']) + intval($TPL_V1['home_5_time_score']) + intval($TPL_V1['home_6_time_score']) + intval($TPL_V1['home_7_time_score']);
											$away_score = intval($TPL_V1['away_1_time_score']) + intval($TPL_V1['away_2_time_score']) + intval($TPL_V1['away_3_time_score']) + intval($TPL_V1['away_4_time_score']) + intval($TPL_V1['away_5_time_score']) + intval($TPL_V1['away_6_time_score']) + intval($TPL_V1['away_7_time_score']);
											break;
									}
									break;
								case "아이스하키":
									switch ($TPL_V1['betting_type']) {
										case "1":
											$detail_name = "<span class='victory'>승패</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "2":
											$detail_name = "<span class='handicap'>핸디캡</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "3":
											$detail_name = "<span class='underover'>언더오버</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "4":
											$detail_name = "<span class='victory'>승무패</span>";
											$home_score = $TPL_V1['home_score'];
											$away_score = $TPL_V1['away_score'];
											break;
										case "5":
											$detail_name = "<span class='victory'>승패(1피리어드)</span>";
											$home_score = $TPL_V1['home_1_time_score'];
											$away_score = $TPL_V1['away_1_time_score'];
											break;
										case "6":
											$detail_name = "<span class='victory'>승무패(1피리어드)</span>";
											$home_score = $TPL_V1['home_1_time_score'];
											$away_score = $TPL_V1['away_1_time_score'];
											break;
										case "7":
											$detail_name = "<span class='handicap'>핸디캡(1피리어드)</span>";
											$home_score = $TPL_V1['home_1_time_score'];
											$away_score = $TPL_V1['away_1_time_score'];
											break;
										case "8":
											$detail_name = "<span class='underover'>언더오버(1피리어드)</span>";
											$home_score = $TPL_V1['home_1_time_score'];
											$away_score = $TPL_V1['away_1_time_score'];
											break;
									}
									break;
							}
							echo $detail_name;  
							?>
						</td>
						<td><?php echo $TPL_V1["sport_name"]?></td>
						<td><?php echo $TPL_V1["league_name"]?></td>
						<td class="homeName"><font color=blue><?php echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")?></font></td>
						<td><b><font color='red'>VS</font></b></td>
						<td class="awayName"><font color=blue><b><?php echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")?></b></font></td>
						<td><input type="text" id="home_rate" readonly name="home_rate[<?php echo $TPL_V1["sn"]?>]" size="5" value="<?php echo $TPL_V1["home_rate"]?>" style="border:1px #97ADCE solid;" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")'><br><?php echo number_format($TPL_V1["home_total_betting"],0)?></td>
						<td><input type="text" id="draw_rate" readonly name="draw_rate[<?php echo $TPL_V1["sn"]?>]" size="5" value="<?php echo $TPL_V1["draw_rate"]?>" style="border:1px #97ADCE solid;"><br><?php echo number_format($TPL_V1["draw_total_betting"],0)?></td>
						<td><input type="text" id="away_rate" readonly name="away_rate[<?php echo $TPL_V1["sn"]?>]" size="5" value="<?php echo $TPL_V1["away_rate"]?>" style="border:1px #97ADCE solid;" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")'><br><?php echo number_format($TPL_V1["away_total_betting"],0)?></td>
						<!--<td><input type="checkbox" name="check_cancel[]" onclick='autoCheck_check(<?php /*echo $TPL_I1*/?>)' ></td>-->
						<td>
							<input type="text" name="home_score[<?php echo $TPL_V1["sn"]?>]" size="5" value="<?=$home_score?>" style="border:1px #97ADCE solid;" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")' onblur='autoCheck(<?php echo $TPL_I1?>, this.value)'>
							:
							<input type="text" name="away_score[<?php echo $TPL_V1["sn"]?>]" size="5" value="<?=$away_score?>" style="border:1px #97ADCE solid;" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")'>
						</td>
						<td>
<?php if($TPL_V1["win"]==1){?> 홈승
<?php }elseif($TPL_V1["win"]==2){?> 원정승
<?php }elseif($TPL_V1["win"]==3){?> 무승부
<?php }elseif($TPL_V1["win"]==4){?> 취소/적특
<?php }else{?> &nbsp;
<?php }?>
						</td>
						<td><input name="y_id_back[]" type="checkbox" value="<?php echo $TPL_V1["sn"]?>" onClick="select_to(this);"/></td>
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