<?php
$TPL_categoryList_1=empty($TPL_VAR["categoryList"])||!is_array($TPL_VAR["categoryList"])?0:count($TPL_VAR["categoryList"]);
$TPL_list_1=empty($TPL_VAR["list"]) || !is_array($TPL_VAR["list"]) ? 0 : count($TPL_VAR["list"]);?>
<script>
	function select_delete()
	{
		var sn="";
		var sn = document.getElementsByName("sn[]");
		
		for(i=0;i<sn.length;i++)   
		{   
			if(sn[i].checked==true)
			{
				if($('#state_'+sn[i].value).val()!=-1)
				{
					alert("대기중인 게임만 삭제가능합니다.");
					return;
				}
				sn += sn[i].value+"\,";   
			}   
		}
		if(sn.length>0)
		{
			if ( confirm("정말 삭제하시겠습니까?") ) {
				sn=sn.substring(0,(sn.length)-1);
				param="sn="+sn+"&act=delete_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
				document.location="/gameUpload/gameMultiList?"+param;
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
		var subchild_sn="";
		var sn = document.getElementsByName("sn[]");
		
		for(i=0;i<sn.length;i++)   
		{   
			if(sn[i].checked==true)
		  {
		  	if($('#state_'+sn[i].value).val()!=-1 && $('#state_'+sn[i].value).val()!=0)
		  	{
		  		alert("완료된 게임은 배당변경이 불가합니다.");
					return;
		  	}
		  	subchild_sn += sn[i].value+"\,";
		  }   
		}

		if(subchild_sn.length>0)
		{
			state = "rateUpdate";
			act = "modify_state";
			subchild_sn=subchild_sn.substring(0,(subchild_sn.length)-1);
			if ( confirm("선택한 경기를 [배당변경] 하시겠습니까?") ) {
				param="sn="+subchild_sn+"&new_state="+state+"&act="+act+"&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
				if ( state == "rateUpdate" ) {
					document.location="/gameUpload/gameMultiList?"+param+"&page="+<?php echo $TPL_VAR["page"]?>;
				} else {
					document.location="/gameUpload/gameMultiList?"+param;
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
		var subchild_sn="";
		var sn = document.getElementsByName("sn[]");
		
        state=$('#select_state').val();
		
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

                subchild_sn += sn[i].value+"\,";
            }
        }

		if(subchild_sn.length>0)
		{
			subchild_sn=subchild_sn.substring(0,(subchild_sn.length)-1);
			
			if ( state == 0 ) alertTitle = "[발매]로";
			else if ( state == -1 ) alertTitle = "[대기]로";
			else if ( state == 1 ) alertTitle = "[마감]으로";
            else if ( state == 2 ) alertTitle = "[차단]으로";
			else alertTitle = "[배당]을";

			var act = "";
			if ( state == 1 ) act = "deadline_game";
			else act = "modify_state";

			if ( confirm("정말 "+alertTitle+" 변경하시겠습니까?") ) {
				if ( state == 1 ) {
					if ( !confirm("---------------- 경 고 ------------------\n\n정말 [ 마 감 ]으로 변경하시겠습니까?") ) {
						return;
					}
				}
				param="sn="+subchild_sn+"&new_state="+state+"&act="+act+"&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
				if ( state == "rateUpdate" ) {
					document.location="/gameUpload/gameMultiList?"+param+"&page="+<?php echo $TPL_VAR["page"]?>;
				} else {
					document.location="/gameUpload/gameMultiList?"+param;
				}
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
	
	function select_all()
	{	
		var check_state = document.form1.check_all.checked;
		for (i=0;i<document.all.length;i++) 
		{
			if (document.all[i].name=="sn[]") 
			{
				document.all[i].checked = check_state;
			}
			if (document.all[i].name=="sn_back[]") 
			{
				document.all[i].checked = check_state;
			}
		}
	}
	
	function select_to(obj) {
		if ( $(obj).attr("checked") == "checked" ) {
			$(obj).parent("td").parent("tr").find("input[name^=sn]").prop("checked",true);
		} else {
			$(obj).parent("td").parent("tr").find("input[name^=sn]").prop("checked",false);
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
	function onDelete(sn)
	{
		if(confirm("정말 삭제하시겠습니까?  "))
		{
			param="sn="+sn+"&act=delete_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
			document.location="/gameUpload/gameMultiList?"+param;
		}
		else
		{
			return;
		}
	}
    function onDeleteDB(sn)
    {
        if(confirm("정말 삭제하시겠습니까?  "))
        {
            param="sn="+sn+"&act=delete_game_db&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
            document.location="/gameUpload/gameMultiList?"+param;
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
			param="act=delete_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>&page=<?php echo $TPL_VAR["page"]?>";
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
	
	function onStateChange(sn)
	{
		state=$('#state_'+sn).val();
		param="sn="+sn+"&new_state="+state+"&act=modify_state&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
		document.location="/gameUpload/gameMultiList?"+param;
	}
	
	function onDeadLine(sn)
	{
		if(confirm("게임시간을 변경 하시겠습니까?"))
		{
			param="sn="+sn+"&act=deadline_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>&page=<?php echo $TPL_VAR["page"]?>";
			document.location="/gameUpload/gameMultiList?"+param;
		}
		else
		{
			return;
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

	<div id="route">
		<h5>관리자 시스템 - 항목 보기</h5>
	</div>
	<h3>항목 보기</h3>
    <div id="betting_2">
        <ul id="tab">
            <li><a href="/gameUpload/gamelist?state=20&parsing_type=ALL" id="sport_1">스포츠 I</a></li>
            <li><a href="/gameUpload/gameMultiList?state=20&parsing_type=ALL" id="sport_2">스포츠 II</a></li>
        </ul>
    </div>
	<div id="search">
		<div class="betList_option">
			<form action="?act=user" method="post" name="form3" id="form3">
				<input type="button" value="-경기등록-" class="Qishi_submit_a" onclick="window.open('/gameUpload/popup_gameMultiUpload?state=0','','resizable=yes scrollbars=yes top=5 left=5 width=1600 height=650')";>
			</form>
			<form action="?mode=execl_collect" method="post" name="form4" id="form4">
				<input type="button" value="-Excel-수집-" class="Qishi_submit_a" onclick="window.open('/gameUpload/popup_excelupload','','resizable=yes scrollbars=yes top=5 left=5 width=1100 height=650')";>
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
			<form name=frmSrh method=post action="/gameUpload/gameMultiList"> 
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
			
            <select id="categoryName" name="categoryName" onchange="changeGameType()">
				<option value="">종목</option>
<?php if($TPL_categoryList_1){foreach($TPL_VAR["categoryList"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["categoryName"]==$TPL_V1["name"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
			</select>

			<select id="game_type" name="game_type">
				<option value="">종류</option>
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
						<td><input type='checkbox' name='sn[]' id='sn' value='<?php echo $TPL_V1["sn"]?>' onClick="select_to(this);"><font color='blue'> <?php echo $TPL_V1["sn"]?></font></td>
						<td>
<?php
	if ( $TPL_V1["user_view_flag"] == 0 ) echo "<font style='color:red;'>".$TPL_V1["parsing_site"]."(숨김)</font>";
	else echo "타입".$TPL_V1["parsing_site"];
?>
						</td>
						<td><?php if($TPL_V1["update_game_date"]){?><span style="color:red;"><?php }?><?php if($TPL_V1["update_enable"]==0){?><span style="border-bottom:1px solid red;"><?php }?><?php echo sprintf("%s %s:%s",substr($TPL_V1["gameDate"],5),$TPL_V1["gameHour"],$TPL_V1["gameTime"])?></td>
						<td>
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
						<td><a onclick="window.open('/league/popup_edit?league_sn=<?php echo $TPL_V1["league_sn"];?>','','scrollbars=yes,width=600,height=400,left=5,top=0');" href="#"><?php echo $TPL_V1["league_name"]?></a></td>
						<td><?php echo $TPL_V1["alias_name"]?></td>
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
	//-> draw 배당 출력
	if ( ($TPL_V1["betting_type"] == 1 && $TPL_V1["draw_rate"] == '1.00') || ($TPL_V1["betting_type"] == 1 && $TPL_V1["draw_rate"] == '1') ){
		echo "VS";
	} else {
		echo $TPL_V1["draw_rate"];
	}
	if ( $TPL_V1["draw_rate"] != $TPL_V1["new_draw_rate"] and strlen($TPL_V1["new_draw_rate"]) > 0 ) {
		echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_draw_rate"]."</span>";
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
						 <td><?=$home_score?> : <?=$away_score?></td>
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
						 		<select name="play" id="state_<?php echo $TPL_V1["sn"]?>" onChange="onStateChange(<?php echo $TPL_V1["sn"]?>);">
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
							<input type='button' class='btnStyle4' value="배당수정" onclick=open_window('/gameUpload/modifyrateMulti?idx=<?php echo $TPL_V1["sn"]?>&gametype=<?php echo $TPL_V1["betting_type"]?>&sport_name=<?php echo $TPL_V1["sport_name"]?>&mode=edit','650','300')>
						</td>
						<td>
<?php if(($TPL_V1["special"]==1 or $TPL_V1["special"]==2)&&$TPL_V1["result"]!=1){?>
								<input type="button" class="btnStyle3" value="마감" onclick="onDeadLine(<?php echo $TPL_V1["sn"]?>)";>&nbsp;
<?php }?>
							<input type="button" class="btnStyle3" value="수정" onclick="window.open('/gameUpload/popup_modifyresultMulti?mode=edit&idx=<?php echo $TPL_V1["sn"]?>&result=<?php echo $TPL_V1["result"]?>','','resizable=no width=650 height=400')";>&nbsp;
<?php if($TPL_V1["result"]!=1){?>
								<input type="button" class="btnStyle3" value="삭제" onclick="onDelete(<?php echo $TPL_V1["sn"]?>)">
                                <input type="button" class="btnStyle3" value="완전삭제" onclick="onDeleteDB(<?php echo $TPL_V1["sn"]?>)">
<?php }else{?>
								<input type='button' class="btnStyle3" value="결과취소" style="color:red" onclick="go_rollback('/gameUpload/cancel_resultProcess?idx=<?php echo $TPL_V1["sn"]?>&type=<?php echo $TPL_VAR["type"]?>')")>
<?php }?>
						</td>
						<td><input type='checkbox' name='sn_back[]' id='sn_back' value='<?php echo $TPL_V1["sn"]?>' onClick="select_to(this);"></td>
					</tr>
<?php }}?>
			</tbody>
		</table>
 		
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	</form>