<?php
$TPL_categoryList_1=empty($TPL_VAR["categoryList"])||!is_array($TPL_VAR["categoryList"])?0:count($TPL_VAR["categoryList"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	function select_delete()
	{
		var child_sn="";
		var sn = document.getElementsByName("child_sn[]");
		
		for(i=0;i<sn.length;i++)   
		{   
			if(sn[i].checked==true)
			{
				if($('#state_'+sn[i].value).val()!=-1)
				{
					alert("대기중인 게임만 삭제가능합니다.");
					return;
				}
				child_sn += sn[i].value+"\,";   
			}   
		}
		if(child_sn.length>0)
		{
			if ( confirm("정말 삭제하시겠습니까?") ) {
				child_sn=child_sn.substring(0,(child_sn.length)-1);
				param="child_sn="+child_sn+"&act=delete_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
				document.location="/gameUpload/gamelist?"+param;
			} else {
				return;
			}
		}
		else
		{
			alert("경기를 선택!");
			return;
		}
	}

	function select_modify_rate() {
		var child_sn="";
		var sn = document.getElementsByName("child_sn[]");
		for(i=0;i<sn.length;i++)   
		{   
			if(sn[i].checked==true)
		  {
		  	if($('#state_'+sn[i].value).val()!=-1 && $('#state_'+sn[i].value).val()!=0)
		  	{
		  		alert("완료된 게임은 배당변경이 불가합니다.");
					return;
		  	}
		  	child_sn += sn[i].value+"\,";
		  }   
		}

		if(child_sn.length>0)
		{
			state = "rateUpdate";
			act = "modify_state";
			child_sn=child_sn.substring(0,(child_sn.length)-1);

			if ( confirm("선택한 경기를 [배당변경] 하시겠습니까?") ) {
				param="child_sn="+child_sn+"&new_state="+state+"&act="+act+"&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
				if ( state == "rateUpdate" ) {
					document.location="/gameUpload/gamelist?"+param+"&page="+<?php echo $TPL_VAR["page"]?>;
				} else {
					document.location="/gameUpload/gamelist?"+param;
				}
			} else {
				return;
			}
		}
		else
		{
			alert("배당을 변경하실 경기를 선택하세요.");
			return;
		}
	}

	function select_modify_state()
	{
		var child_sn="";
		var sn = document.getElementsByName("child_sn[]");
		console.log(sn);
        state=$('#select_state').val();
		console.log(state);
        for(i=0;i<sn.length;i++)
        {
            if(sn[i].checked==true)
            {
                if(state != 2)
                {
                    if($('#state_'+sn[i].value).val()!=-1 && $('#state_'+sn[i].value).val()!=0)
                    {
                        alert("완료된 게임은 상태변경이 불가합니다.");
                        return;
                    }
                }

                child_sn += sn[i].value+"\,";
            }
        }

		if(child_sn.length>0)
		{
			child_sn=child_sn.substring(0,(child_sn.length)-1);
			console.log(child_sn);
			// if ( state == 0 ) alertTitle = "[발매]로";
			// else if ( state == -1 ) alertTitle = "[대기]로";
			// else if ( state == 1 ) alertTitle = "[마감]으로";
            // else if ( state == 2 ) alertTitle = "[차단]으로";
			// else alertTitle = "[배당]을";

			// var act = "";
			// if ( state == 1 ) act = "deadline_game";
			// else act = "modify_state";

			// if ( confirm("정말 "+alertTitle+" 변경하시겠습니까?") ) {
			// 	if ( state == 1 ) {
			// 		if ( !confirm("---------------- 경 고 ------------------\n\n정말 [ 마 감 ]으로 변경하시겠습니까?") ) {
			// 			return;
			// 		}
			// 	}
			// 	param="child_sn="+child_sn+"&new_state="+state+"&act="+act+"&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
			// 	if ( state == "rateUpdate" ) {
			// 		document.location="/gameUpload/gamelist?"+param+"&page="+<?php echo $TPL_VAR["page"]?>;
			// 	} else {
			// 		document.location="/gameUpload/gamelist?"+param;
			// 	}
			// } else {
			// 	return;
			// }
		}
		else
		{
			alert("경기를 선택!");
			return;
		}
	}
	
	function select_all()
	{	
		var check_state = document.form1.check_all.checked;
		for (i=0;i<document.all.length;i++) 
		{
			if (document.all[i].name=="child_sn[]") 
			{
				document.all[i].checked = check_state;
			}
			if (document.all[i].name=="child_sn_back[]") 
			{
				document.all[i].checked = check_state;
			}
		}
	}
	
	function select_to(obj) {
		if ( $(obj).attr("checked") == "checked" ) {
			$(obj).parent("td").parent("tr").find("input[name^=child_sn]").prop("checked",true);
		} else {
			$(obj).parent("td").parent("tr").find("input[name^=child_sn]").prop("checked",false);
		}
	}
	
	function team_betting(url)
	{
		window.open(url,'','resizable=no width=520 height=210');
		
	}
	function team_betting2(url)
	{
		window.open(url,'','resizable=no width=520 height=240');
	}
	function onDelete(child_sn)
	{
		if(confirm("정말 삭제하시겠습니까?  "))
		{
			param="child_sn="+child_sn+"&act=delete_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
			document.location="/gameUpload/gamelist?"+param;
		}
		else
		{
			return;
		}
	}
    function onDeleteDB(child_sn)
    {
        if(confirm("정말 삭제하시겠습니까?  "))
        {
            param="child_sn="+child_sn+"&act=delete_game_db&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
            document.location="/gameUpload/gamelist?"+param;
        }
        else
        {
            return;
        }
    }
	function go_rollback(url)
	{
		if(confirm("게임결과와 배당지급이 취소됩니다. 진행하시겠습니까?  "))
		{
			param="act=delete_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>&page=<?php echo $TPL_VAR["page"]?>";
			document.location = url+"&"+param;
		}
		else
		{
			return;
		}
	}
	
	function onCheckbox(frm)
	{
		if(frm.money_option.checked==true)
		{
			frm.money_option.value=1
		}
		else
			frm.money_option.value=0
		frm.submit();
	}
	
	function onStateChange(child_sn)
	{
		state=$('#state_'+child_sn).val();
		param="child_sn="+child_sn+"&new_state="+state+"&act=modify_state&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
		document.location="/gameUpload/gamelist?"+param;
	}
	
	function onDeadLine(child_sn)
	{
		if(confirm("게임시간을 변경 하시겠습니까?"))
		{
			param="child_sn="+child_sn+"&act=deadline_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>&page=<?php echo $TPL_VAR["page"]?>";
			document.location="/gameUpload/gamelist?"+param;
		}
		else
		{
			return;
		}
	}
</script>
</head>

	<div id="route">
		<h5>관리자 시스템 - 항목 보기</h5>
	</div>
	<h3>항목 보기</h3>
	<div id="search">
		<div class="betList_option">
			<form action="?act=user" method="post" name="form3" id="form3">
				<input type="button" value="-경기등록-" class="Qishi_submit_a" onclick="window.open('/gameUpload/popup_gameupload?state=0','','resizable=yes scrollbars=yes top=5 left=5 width=1600 height=650')";>
			</form>
			<form action="?mode=execl_collect" method="post" name="form4" id="form4">
				<input type="button" value="-Excel-수집-" class="Qishi_submit_a" onclick="window.open('/gameUpload/popup_excelupload','','resizable=yes scrollbars=yes top=5 left=5 width=500 height=150')";>
			</form>
			<!--<form action="?mode=collect" method="post" name="form5" id="form5">
				<input type="button" value="-7m-수집-" class="Qishi_submit_a" onclick="window.open('/gameUpload/collect7m','','resizable=yes scrollbars=yes top=5 left=5 width=1100 height=650')";>
			</form>-->
            <!--<form action="?mode=story188" method="post" name="form5" id="form5">
                <input type="button" value="-story188-" class="Qishi_submit_a" onclick="window.open('/gameUpload/collectStory188','','resizable=yes scrollbars=yes top=5 left=5 width=1100 height=650')";>
            </form>-->
			<input type="button" value="-게임복사-" class="Qishi_submit_a" onclick="window.open('/gameUpload/game_copy_list','','resizable=yes scrollbars=yes top=5 left=5 width=1100 height=650')";>
		</div>
		
		<div class="wrap_search">
			<form name=frmSrh method=post action="/gameUpload/gamelist"> 
			<input type="hidden" name="search" value="search">				
			<input type="hidden" name="category_name" value="">
			
			<span>출력</span>
			<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">

			<span>설정</span>
			<input type="radio" name="state" value=0 <?php if($TPL_VAR["state"]==0){?>checked<?php }?> class="radio" >전체
			<input type="radio" name="state" value=1 <?php if($TPL_VAR["state"]==1){?>checked<?php }?> class="radio">종료
			<input type="radio" name="state" value=20 <?php if($TPL_VAR["state"]==20){?>checked<?php }?> class="radio">발매(배팅가능)
			<input type="radio" name="state" value=21 <?php if($TPL_VAR["state"]==21){?>checked<?php }?> class="radio">발매(배팅마감)
			<input type="radio" name="state" value=3 <?php if($TPL_VAR["state"]==3){?>checked<?php }?> class="radio">대기
			<input type="checkbox" name="modifyFlag" <?php if($TPL_VAR["modifyFlag"]===0){?>checked<?php }?> > 경기수정
			&nbsp;
			<span class="icon">정렬</span>
			<select name="parsing_type">
				<option value="ALL" <?php if($TPL_VAR["parsing_type"]=="ALL"){?> selected <?php }?>>전체</option>
                <option value="A" <?php if($TPL_VAR["parsing_type"]=="A"){?> selected <?php }?>>경기A타입</option>
                <option value="S" <?php if($TPL_VAR["parsing_type"]=="S"){?> selected <?php }?>>경기S타입</option>
			</select>
			
			<select name="special_type">
				<option value="">대분류</option>
				<option value="1" <?php if($TPL_VAR["special_type"]==1){?> selected <?php }?>>국내형</option>
				<option value="2" <?php if($TPL_VAR["special_type"]==2){?> selected <?php }?>>해외형</option>
				<option value="3" <?php if($TPL_VAR["special_type"]==3){?> selected <?php }?>>실시간</option>
				<option value="4" <?php if($TPL_VAR["special_type"]==4){?> selected <?php }?>>라이브</option>
                <!-- <option value="50" <?php if($TPL_VAR["special_type"]==50){?> selected <?php }?>>라이브</option> -->
                <option value="22" <?php if($TPL_VAR["special_type"]==22){?> selected <?php }?>>가상축구</option>
				<option value="5" <?php if($TPL_VAR["special_type"]==5){?> selected <?php }?>>사다리</option>
                <option value="8" <?php if($TPL_VAR["special_type"]==8){?> selected <?php }?>>다리다리</option>
				<option value="6" <?php if($TPL_VAR["special_type"]==6){?> selected <?php }?>>달팽이</option>
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
					<option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["categoryName"]==$TPL_V1["name"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
			</select>
			
			<select name="game_type">
				<option value="">종류</option>
				<option value="1" <?php if($TPL_VAR["gameType"]==1){?> selected <?php }?>>승무패</option>
				<option value="2" <?php if($TPL_VAR["gameType"]==2){?> selected <?php }?>>핸디캡</option>
				<option value="4" <?php if($TPL_VAR["gameType"]==4){?> selected <?php }?>>언더오버</option>
				<option value="24"  <?php if($TPL_VAR["gameType"]==24){?>  selected <?php }?>>핸디+언오버</option>
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
				<input type="button" value="배당수정" onclick="select_modify_rate();" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
				<select name="select_state" id="select_state">
					<option value=0  <?php if($TPL_VAR["select_state"]==0){?>  selected <?php }?>>발매</option>
<?php if($TPL_VAR["state"]!=21){?>
					<option value=-1 <?php if($TPL_VAR["select_state"]== -1){?> selected <?php }?>>대기</option>
<?php }?>
					<option value=1  <?php if($TPL_VAR["select_state"]==1){?>  selected <?php }?>>마감</option>
                    <option value=2  <?php if($TPL_VAR["select_state"]==2){?>  selected <?php }?>>차단</option>
				</select>
				<input type="button" value="선택상태변경" onclick="select_modify_state();" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
				<input type="button" value="선택삭제" onclick="select_delete();" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
			</span>
			</form>
		</div>
	</div>
	
	<form id="form1" name="form1" method="post" action="?">
  	<input type="hidden" name="act" value="delete">
		<table cellspacing="1" class="tableStyle_gameList">
		<legend class="blind">항목보기</legend>
			<thead>
	    		<tr>     
	      	<th><input type="checkbox" name="check_all" onClick="select_all()"/> No</th>
					<th>경기타입</th>
					<th>경기일시</th>
					<th>대분류</th>
					<th>종류</th>
					<th>종목</th>
					<th>리그</th>
					<th>매칭리그</th>
					<th colspan="2">승(홈팀)</th>
					<th>무</th>
					<th colspan="2">패(원정팀)</th>
					<th>스코어</th>
					<th>이긴 팀</th>
					<th>진행상태</th>
					<th>배당관리</th>
					<th>처리</th>
					<th>No</th>
	    		</tr>
	 		</thead>
			<tbody>
<?php 
	if ( $TPL_list_1 ) {
		foreach ( $TPL_VAR["list"] as $TPL_V1) {
			if ( $TPL_V1["user_view_flag"] == 0 ) $addTrStyle = "_notView";
			else $addTrStyle = "";
?>
<?php if(is_null($TPL_V1["kubun"])){?>
						<tr class="<?=$addTrStyle;?>">
<?php }elseif($TPL_V1["kubun"]==0){?>
                <?php
                $gameDateTime = mktime($TPL_V1["gameHour"],$TPL_V1["gameTime"],0,substr($TPL_V1["gameDate"],5,2),substr($TPL_V1["gameDate"],8,2),substr($TPL_V1["gameDate"],0,4));
                if ( $gameDateTime > time() ) {
                    ?>
		 				<tr class="gameGoing<?=$addTrStyle;?>">
                    <? } else { ?>
                        <tr class="gameEnd<?=$addTrStyle;?>">
                    <? } ?>
<?php }elseif($TPL_V1["kubun"]==1){?>		
		 				<tr class="gameEnd<?=$addTrStyle;?>">
<?php }?>
						<td><input type='checkbox' name='child_sn[]' id='child_sn' value='<?php echo $TPL_V1["child_sn"]?>' onClick="select_to(this);"><font color='blue'> <?php echo $TPL_V1["child_sn"]?></font></td>
						<td>
<?php
	if ( $TPL_V1["user_view_flag"] == 0 ) echo "<font style='color:red;'>".$TPL_V1["parsing_site"]."(숨김)</font>";
	else echo "타입".$TPL_V1["parsing_site"];
?>
					</td>
						<td><?php if($TPL_V1["update_game_date"]){?><span style="color:red;"><?php }?><?php if($TPL_V1["update_enable"]==0){?><span style="border-bottom:1px solid red;"><?php }?><?php echo sprintf("%s %s:%s",substr($TPL_V1["gameDate"],5),$TPL_V1["gameHour"],$TPL_V1["gameTime"])?></td>
						<td>
<?php if($TPL_V1["special"]<3){?>스포츠
<?php }elseif($TPL_V1["special"]==3){?>실시간
<?php }elseif($TPL_V1["special"]==4){?>라이브
<?php }elseif($TPL_V1["special"]==5){?>사다리
<?php }elseif($TPL_V1["special"]==6){?>달팽이
<?php }elseif($TPL_V1["special"]==7){?>파워볼
<?php }elseif($TPL_V1["special"]==8){?>다리다리
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
						<td><a onclick="window.open('/league/popup_edit?league_sn=<?php echo $TPL_V1["league_sn"];?>','','scrollbars=yes,width=600,height=400,left=5,top=0');" href="#"><?php echo $TPL_V1["league_name"]?></a></td>
						<td><?php echo $TPL_V1["league_name"]?></td>
						<td colspan="2">
<table width="100%">
	<tr>
		<td>
<?php
	if ( $TPL_V1["total_betting"] > 0 ) {
		echo "<font color=\"blue\"><b>".mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")."</b></font>";
	} else {
		echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8");
	}
?>
		</td>
		<td width="35">
<?php
	//-> home 배당 출력
	echo $TPL_V1["home_rate"];
	if ( $TPL_V1["home_rate"] != $TPL_V1["new_home_rate"] and strlen($TPL_V1["new_home_rate"]) > 0 ) { 
		echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_home_rate"]."</span>";
	}
?>
		</td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:#3163C9;"><?=number_format($TPL_V1["home_total_betting"],0);?></span></td>
	</tr>
</table>
						</td>
						<td>
<table width="100%">
	<tr>
		<td>
		<?php 
			switch($TPL_V1["mfamily"]) {
				case 1:		// 승무패
					if ( $TPL_V1["select_no"] == 3 and $TPL_V1["new_draw_rate"] != $TPL_V1["select_rate"] ) 
						echo $TPL_V1["draw_rate"]." <span style='color:red;'>[<b>".$TPL_V1["new_draw_rate"]."</b>]</span>";
					else 
						echo $TPL_V1["draw_rate"]; 
					break;
				case 2:		// 승패
					echo "VS";
					break;
				case 7:		// 언더오버
					echo $TPL_V1["home_line"];
					break;
				case 8:		// 아시안핸디캡
					$home_line = explode(" ", $TPL_V1["home_line"]);
					echo $home_line[0];
					break;
				case 9:		// E스포츠 핸디캡
					echo $TPL_V1["home_line"];
					break;
				case 10:	// 홀짝
					echo "VS";
					break;
				case 11:	// 정확한 스코어
					echo $TPL_V1["home_name"];
					break;
				case 12:	// 더블찬스
					echo $TPL_V1["draw_rate"];
					break;
				case 47:	// 승무패 + 언더오버
					echo $TPL_V1["home_line"];
					break;
			}			
		?>
		</td>
	</tr>
	<tr>
		<td><span style="color:#3163C9;"><?=number_format($TPL_V1["draw_total_betting"],0);?></span></td>
	</tr>
</table>
						</td>
						<td colspan="2">
<table width="100%">
	<tr>
		<td width="35">
<?php
	//-> away 배당 출력
	echo $TPL_V1["away_rate"];
	if ( $TPL_V1["away_rate"] != $TPL_V1["new_away_rate"] and strlen($TPL_V1["new_away_rate"]) > 0 ) {
		echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_away_rate"]."</span>";
	}
?>
		</td>
		<td>
<?php
	if ( $TPL_V1["total_betting"] > 0 ) {
		echo "<font color=\"blue\"><b>".mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")."</b></font>";
	} else {
		echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")."&nbsp;&nbsp;";
	}
?>
		</td>
	</tr>
	<tr>
		<td colspan="2"><span style="color:#3163C9;"><?=number_format($TPL_V1["away_total_betting"],0);?></span></td>
	</tr>
</table>
						</td>
						 <td><?php echo $TPL_V1["home_score"]?>:<?php echo $TPL_V1["away_score"]?></td>
						 <td>
<?php if($TPL_V1["win"]==1){?> 홈승
<?php }elseif($TPL_V1["win"]==2){?> 원정승
<?php }elseif($TPL_V1["win"]==3){?> 무승부
<?php }elseif($TPL_V1["win"]==4){?> 취소/적특
<?php }else{?> &nbsp;
<?php }?>
						 	</td>
						 	
						 	<td>
<?php if($TPL_V1["kubun"]==1){?>
						 		종료
<?php }else{?>
						 		<select name="play" id="state_<?php echo $TPL_V1["child_sn"]?>" onChange="onStateChange(<?php echo $TPL_V1["child_sn"]?>);">
<?php
	$gameDateTime = mktime($TPL_V1["gameHour"],$TPL_V1["gameTime"],0,substr($TPL_V1["gameDate"],5,2),substr($TPL_V1["gameDate"],8,2),substr($TPL_V1["gameDate"],0,4));
	if ( $gameDateTime > time() ) {
?>
						 			<option value=0  <?php if($TPL_V1["kubun"]==0){?>  selected <?php }?>>발매</option>
<?php } else { ?>
						 			<option value=0  <?php if($TPL_V1["kubun"]==0){?>  selected <?php }?>>마감</option>
<?php } ?>
<?php		if($TPL_VAR["state"]!=21){?>
									<option value=-1 <?php if($TPL_V1["kubun"]==''){?> selected <?php }?>>대기</option>
<?php		}?>
								</select>
<?php }?>
							</td>
						<td>
							<input type='button' class='btnStyle4' value="배당수정" onclick=open_window('/gameUpload/modifyrate?idx=<?php echo $TPL_V1["sn"]?>&gametype=<?php echo $TPL_V1["betting_type"]?>&mode=edit','650','300')>
						</td>
						<td>
<?php if(($TPL_V1["special"]==1 or $TPL_V1["special"]==2)&&$TPL_V1["result"]!=1){?>
								<input type="button" class="btnStyle3" value="마감" onclick="onDeadLine(<?php echo $TPL_V1["child_sn"]?>)";>&nbsp;
<?php }?>
							<input type="button" class="btnStyle3" value="수정" onclick="window.open('/gameUpload/popup_modifyresult?mode=edit&idx=<?php echo $TPL_V1["child_sn"]?>&result=<?php echo $TPL_V1["result"]?>','','resizable=no width=650 height=400')";>&nbsp;
<?php if($TPL_V1["result"]!=1){?>
								<input type="button" class="btnStyle3" value="삭제" onclick="onDelete(<?php echo $TPL_V1["child_sn"]?>)">
                                <input type="button" class="btnStyle3" value="완전삭제" onclick="onDeleteDB(<?php echo $TPL_V1["child_sn"]?>)">
<?php }else{?>
								<input type='button' class="btnStyle3" value="결과취소" style="color:red" onclick="go_rollback('/gameUpload/cancel_resultProcess?idx=<?php echo $TPL_V1["child_sn"]?>&type=<?php echo $TPL_VAR["type"]?>')")>
<?php }?>
						</td>
						<td><input type='checkbox' name='child_sn_back[]' id='child_sn_back' value='<?php echo $TPL_V1["child_sn"]?>' onClick="select_to(this);"></td>
					</tr>
<?php }}?>
			</tbody>
		</table>
 		
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	</form>