<?php /* Template_ 2.2.3 2014/05/26 16:08:18 D:\www_one-23.com\vhost.manager\_template\content\game\game_list.html */
$TPL_categoryList_1=empty($TPL_VAR["categoryList"])||!is_array($TPL_VAR["categoryList"])?0:count($TPL_VAR["categoryList"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<script>document.title = '게임관리-게임관리';</script>

<script>

    window.setInterval(function(){
        SearchAjax();
    },3000);

    function SearchAjax()
    {
        var perpage = $("#perpage").val();
        var state = $('input[name=state]:checked').val();
        var search = $('#search').val();
        var parsing_type = $("#parsing_type").val();
        var special_type = $("#special_type").val();
        var game_type = $("#game_type").val();
        var categoryName = $("#categoryName").val();
        var league_sn = $("#league_sn").val();
        var begin_date = $("#begin_date").val();
        var end_date = $("#end_date").val();
        var filter_team_type = $("#filter_team_type").val();
        var filter_team = $("#filter_team").val();
        var filter_betting_total = $("#filter_betting_total").val();

        $.ajax({
            url : "/game/gamelist_ajax",
            data : {"perpage":perpage, "state":state, "search":search, "parsing_type":parsing_type, "special_type":special_type,
                "game_type":game_type, "categoryName":categoryName, "league_sn":league_sn,
                "begin_date":begin_date,"end_date":end_date,"filter_team_type":filter_team_type,
                "filter_team":filter_team,"filter_betting_total":filter_betting_total},
            type : "post",
            cache : false,
            async : false,
            timeout : 5000,
            scriptCharset : "utf-8",
            dataType : "json",
            success: function(res) {
                if ( res != null ) {

                    $.each(res, function(key, value) {
                        var child_sn = value["child_sn"];

                        $("#home_total_betting_"+child_sn).text(value["home_total_betting"]+"("+value["active_home_total_betting"]+")");
                        $("#draw_total_betting_"+child_sn).text(value["draw_total_betting"]+"("+value["active_draw_total_betting"]+")");
                        $("#away_total_betting_"+child_sn).text(value["away_total_betting"]+"("+value["active_away_total_betting"]+")");
                    });
                }
            },
            error: function(xhr,status,error) {}
        });
    }

    function java_mktime(hour,minute,month,day,year) {
        return new Date(year, month - 1, day, hour, minutes, 0, 0).getTime() / 1000;
    }

	function addall()
	{
		var intChildIdx="";
		var   c   =   document.getElementsByName("intChildIdx");   
		for(i=0;i<c.length;i++)   
		{   
			if(c[i].checked == true )   
		    {   
				var val=c[i].value;
				var rate1=document.getElementById(val+"_rate1").value;
				var rate3=document.getElementById(val+"_rate3").value;
				if(rate1=="0.00" || rate3=="0.00")
				{
					alert(val+" -  배당이 틀립니다.확인하세요.");
					return;
				}
		        intChildIdx += c[i].value+"\,";   
			}   
		} 
		if(intChildIdx.length>0)
		{
			intChildIdx=intChildIdx.substring(0,(intChildIdx.length)-1);  	
			url="/game/modifyStausProcess?mode=edit&idx="+intChildIdx+"&play=0";
			team_betting(url);		
		}
		else
		{
			alert("발매경기를 선택!");
		 	return;
		 }
	}
	
	function delall()
	{
		var intChildIdx="";
		var   c   =   document.getElementsByName("intChildIdx");   
		for(i=0;i<c.length;i++)   
		{   
		      if(c[i].checked == true )   
		      {   
		                intChildIdx += c[i].value+"\,";   
		      }   
		 } 
		 if(intChildIdx.length>0)
		 {
			 intChildIdx=intChildIdx.substring(0,(intChildIdx.length)-1);  				
			 document.location="/game/delchildProcess?idx="+intChildIdx+"&type=<?php echo $TPL_VAR["type"]?>";
			
		 }else
		 {
		 	alert("발매경기를 선택!");
		 	return;
		 }
	}
	function checkAll()
	{
		var   c   =   document.getElementsByName("intChildIdx");
		for( i=0;i<c.length;i++)
		{
			c[i].checked=true;
		}  
	}
	function clearAll()
	{
		var   c   =   document.getElementsByName("intChildIdx");
		for(i=0;i<c.length;i++)
		{
		    
			c[i].checked=false;
		}  	
	}
	function team_betting(url)
	{
		window.open(url,'','resizable=no width=520 height=210');
		//alert(url);
	}
	function team_betting2(url)
	{
		window.open(url,'','resizable=no width=520 height=240');
		//alert(url);
	}
	function go_delete(url)
	{
		if(confirm("정말 삭제하시겠습니까?  "))
		{
			document.location = url;
		}
		else{return;}
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
	
	function onDeadLine(child_sn)
	{
		if(confirm("게임시간을 변경 하시겠습니까?"))
		{
			param="child_sn="+child_sn+"&act=deadline_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>&page=<?php echo $TPL_VAR["page"]?>";
			document.location="/game/gamelist?"+param;
		}
		else
		{
			return;
		}
	}
</script>
</head>

<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 - 항목 보기</h5>
	</div>
	<h3>항목 보기</h3>
	<div id="search">
		<form name=frmSrh id=frmSrh method=post action="/game/gamelist">
			<input type="hidden" name="search" id="search" value="search">
			<input type="hidden" name="type" id="type" value="<?php echo $TPL_VAR["type"]?>">
			<input type="hidden" name="category_name" id="category_name" value="">
			
			<div class="betList_option">
				
				<span>출력</span>
				<input name="perpage" id="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<span class="icon">설정</span>
				<input type="radio" name="state" id="state" value=0 <?php if($TPL_VAR["state"]==0){?>checked<?php }?> onClick="submit()" class="radio">전체
				<input type="radio" name="state" id="state" value=1 <?php if($TPL_VAR["state"]==1){?>checked<?php }?> onClick="submit()" class="radio">종료
				<input type="radio" name="state" id="state" value=20 <?php if($TPL_VAR["state"]==20){?>checked<?php }?> onClick="submit()" class="radio">발매(배팅가능)
				<input type="radio" name="state" id="state" value=21 <?php if($TPL_VAR["state"]==21){?>checked<?php }?> onClick="submit()" class="radio">발매(배팅마감)
				<input type="radio" name="state" id="state" value=3 <?php if($TPL_VAR["state"]==3){?>checked<?php }?> onClick="submit()" class="radio">대기
				<input type="checkbox" name="modifyFlag" <?php if($TPL_VAR["modifyFlag"]===0){?>checked<?php }?> > 경기수정
				&nbsp;&nbsp;
				
					<span class="icon">정렬</span>
					<?php if($TPL_VAR["membervip"] == "1"){?>
						<select name="special_type" id="special_type" onchange="submit()">
						<option value="5"  <?php if($TPL_VAR["special_type"]==5){?>  selected <?php }?>>사다리</option>
						<option value="6"  <?php if($TPL_VAR["special_type"]==6){?>  selected <?php }?>>달팽이</option>
						<option value="7" <?php if($TPL_VAR["special_type"]==7){?> selected <?php }?>>파워볼</option>
						<option value="8" <?php if($TPL_VAR["special_type"]==8){?> selected <?php }?>>다리다리</option>
					</select>
					
					<?php }else{?>
					<select name="parsing_type" id="parsing_type">
						<option value="ALL" <?php if($TPL_VAR["parsing_type"]=="ALL"){?> selected <?php }?>>전체</option>
						<option value="A" <?php if($TPL_VAR["parsing_type"]=="A"){?> selected <?php }?>>경기A타입</option>
						<option value="S" <?php if($TPL_VAR["parsing_type"]=="S"){?> selected <?php }?>>경기S타입</option>
                        <option value="N" <?php if($TPL_VAR["parsing_type"]=="N"){?> selected <?php }?>>경기N타입</option>
					</select>
					<select name="special_type" id="special_type" onchange="submit()">
						<option value="">대분류</option>
						<option value="1"  <?php if($TPL_VAR["special_type"]==1){?>  selected <?php }?>>국내형</option>
						<option value="2"  <?php if($TPL_VAR["special_type"]==2){?>  selected <?php }?>>해외형</option>
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
					<?php }?>
					
					<select name="game_type" id="game_type" onchange="submit()">
						<option value="">종류</option>
						<option value="1"  <?php if($TPL_VAR["gameType"]==1){?>  selected <?php }?>>승무패</option>
						<option value="2"  <?php if($TPL_VAR["gameType"]==2){?>  selected <?php }?>>핸디캡</option>
						<option value="4"  <?php if($TPL_VAR["gameType"]==4){?>  selected <?php }?>>언더오버</option>
						<option value="24"  <?php if($TPL_VAR["gameType"]==24){?>  selected <?php }?>>핸디+언오버</option>
					</select>
					<?php if($TPL_VAR["membervip"] != "1"){?>
					<select name="categoryName" id="categoryName" onchange="submit()">
						<option value="">종목</option>
	<?php if($TPL_categoryList_1){foreach($TPL_VAR["categoryList"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["name"]?>"  <?php if($TPL_VAR["categoryName"]==$TPL_V1["name"]){?>  selected <?php }?>><?php echo $TPL_V1["name"]?></option>
	<?php }}?>
					</select>
					<select name="league_sn" id="league_sn" onchange="submit()">
						<option value="">리그</option>
	<?php 
		if ( count($TPL_VAR["league_list"]) > 0 ) {
			foreach ( $TPL_VAR["league_list"] as $leagueInfo ) {
				if ( $TPL_VAL["league_sn"] == $leagueInfo['league_sn'] ) $selected = "selected";
				else $selected = "";
				echo "<option value=\"".$leagueInfo['league_sn']."\" {$selected}>".$leagueInfo['league_name']."</option>";
			}
		}
	?>
					</select>
			<?php }?>		
					<!--<input type="checkbox" name="money_option" value="" <?php if($TPL_VAR["money_option"]==1){?>checked<?php }?> onClick="onCheckbox(this.form)"><font color='red'> 배팅금액 0↑</font>-->

				</div>
				<div class="wrap_search">		
					<!-- 기간 필터 -->
					<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"  style="margin-left:4px;"/>&nbsp;~
					<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
					
					<!-- 팀검색, 리그검색 -->
					<select name="filter_team_type" id="filter_team_type">
						<option value="home_team" <?php if($TPL_VAR["filter_team_type"]=="home_team"){?> selected<?php }?>>홈팀</option>
						<option value="away_team" <?php if($TPL_VAR["filter_team_type"]=="away_team"){?> selected<?php }?>>원정팀</option>
						<option value="league" 		<?php if($TPL_VAR["filter_team_type"]=="league"){?> selected<?php }?>>리그명</option>
					</select>
					<input type=text" size=10 name="filter_team" id="filter_team" value="<?php echo $TPL_VAR["filter_team"]?>" class="name">
					
					<!-- 배팅총액 검색-->
					배팅총액 <input type=text" size=10 name="filter_betting_total" id="filter_betting_total" value="<?php echo $TPL_VAR["filter_betting_total"]?>" onkeypress="javascript:pressNumberCheck();" class="name" style="IME-MODE: disabled;">만원 이상
					
					<!-- 검색버튼 -->
					<input name="Submit4" id="search_btn" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />

			</div>
		</form>
	</div>
	
	<form id="form1" name="form1" method="post" action="?">
  	<input type="hidden" name="act" value="delete">  	
		<table cellspacing="1" class="tableStyle_gameList">
			<legend class="blind">게임별 상세항목</legend>
			<thead>
				<tr>
					<th scope="col">번호</th>
					<th scope="col">진행상태</th>
					<th scope="col">대분류</th>
					<th scope="col">종류</th>
					<th scope="col">종목</th>
					<th scope="col">경기일시</th>
					<th scope="col">리그</th>
					<th scope="col" colspan="2">승(홈팀)</th>
					<th scope="col">무</th>
					<th scope="col" colspan="2">패(원정팀)</th>
					<th scope="col">스코어</th>
					<th scope="col">이긴 팀</th>
					<th scope="col">배당관리</th>
					<th scope="col">배팅수정</th>
					<th scope="col">마감</th>
					<th scope="col">홈배팅(낙첨제외)</th>
					<th scope="col">무배팅(낙첨제외)</th>
					<th scope="col">원정배팅(낙첨제외)</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<?php if(is_null($TPL_V1["kubun"])){?>
					<tr>	
<?php }elseif($TPL_V1["kubun"]==0){?>
 					<tr class="gameGoing">
<?php }elseif($TPL_V1["kubun"]==1){?>		
 					<tr class="gameEnd">	
<?php }?>
						<td>
<?php if($TPL_VAR["type"]==3){?>
								<input type='checkbox' name='intChildIdx' value='<?php echo $TPL_V1["child_sn"]?>'><font color=blue><?php echo $TPL_V1["child_sn"]?></font>
<?php }else{?>
								<font color='blue'><?php echo $TPL_V1["child_sn"]?></font>
<?php }?>
							
<?php if(is_null($TPL_V1["kubun"])){?>
								<input type='button' class='btnStyle_s' value='발매' onclick=open_window('/game/modifyStausProcess?mode=edit&idx=<?php echo $TPL_V1["child_sn"]?>&play=0','300','200')>
<?php }?>
						</td>
						<td>
<?php if(is_null($TPL_V1["kubun"])){?> <img src="/img/icon_gameStand.gif">
<?php 
			}elseif($TPL_V1["kubun"]==0){
				$gameDateTime = mktime($TPL_V1["gameHour"],$TPL_V1["gameTime"],0,substr($TPL_V1["gameDate"],5,2),substr($TPL_V1["gameDate"],8,2),substr($TPL_V1["gameDate"],0,4));
				if ( $gameDateTime > time() ) {
					echo "발매";
				} else {
					echo "마감";
				}
?>
<!--<img src="/img/icon_gameGoing.gif">-->
<?php }elseif($TPL_V1["kubun"]==1){?><img src="/img/icon_gameEnd.gif">
<?php }?>
						<!-- 12.10.29 "대기중" 게임일 때 <img src="/img/icon_gameStand.gif"> / "진행중" 게임일 때 <img src="/img/icon_gameGoing.gif"> / "완료" 게임일 때 <img src="/img/icon_gameEnd.gif"> -->
					</td>
					<td>
<?php if($TPL_V1["special"]<4){?>일반

<?php }elseif($TPL_V1["special"]==4){?>실시간
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
<?=$TPL_V1["mname_ko"]?>
						</td>
						<td><?php echo $TPL_V1["sport_name"]?></td>
						<td><?php if($TPL_V1["update_game_date"]){?><span style="color:red;"><?php }?><?php if($TPL_V1["update_enable"]==0){?><span style="border-bottom:1px solid red;"><?php }?><?php echo sprintf("%s %s:%s",substr($TPL_V1["gameDate"],5),$TPL_V1["gameHour"],$TPL_V1["gameTime"])?></td>
						<!--<td><?php echo $TPL_V1["regDate"]?></td>-->
						<td><?php echo $TPL_V1["league_name"]?></td>
						<td class="homeName">
							<a href=javascript:team_betting2("/game/popup_gamedetail?child_sn=<?php echo $TPL_V1["child_sn"]?>"); style='cursor:hand' onmousemove="showpup('<?php echo $TPL_V1["home_team"]?>&nbsp;&nbsp;VS&nbsp;&nbsp;<?php echo $TPL_V1["away_team"]?>')" onmouseout='hidepup()'>
								<?php echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")?>

							</a>
						</td>
						<td>
<?php
	//-> home 배당 출력
	echo $TPL_V1["home_rate"];
	if ( $TPL_V1["home_rate"] != $TPL_V1["new_home_rate"] and strlen($TPL_V1["new_home_rate"]) > 0 ) { 
		echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_home_rate"]."</span>";
	}
?>
						</td>
						<td>
<?php
	//-> draw 배당 출력
	if ( ($TPL_V1["type"] == 1 && $TPL_V1["draw_rate"] == '1.00') || ($TPL_V1["type"] == 1 && $TPL_V1["draw_rate"] == '1') ){
		echo "VS";
	} else {
		echo $TPL_V1["draw_rate"];
	}
	if ( $TPL_V1["draw_rate"] != $TPL_V1["new_draw_rate"] and strlen($TPL_V1["new_draw_rate"]) > 0 ) {
		echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_draw_rate"]."</span>";
	}
?>
						</td>
						<td>
<?php
	//-> away 배당 출력
	echo $TPL_V1["away_rate"];
	if ( $TPL_V1["away_rate"] != $TPL_V1["new_away_rate"] and strlen($TPL_V1["new_away_rate"]) > 0 ) {
		echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_away_rate"]."</span>";
	}
?>
						</td>
						<td class="awayName">
							<a href=javascript:team_betting2("/game/popup_gamedetail?child_sn=<?php echo $TPL_V1["child_sn"]?>"); style='cursor:hand' onmousemove="showpup('<?php echo $TPL_V1["home_team"]?>&nbsp;&nbsp;VS&nbsp;&nbsp;<?php echo $TPL_V1["away_team"]?>')" onmouseout='hidepup()'>
								<?php echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")?>

							</a>
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
						<!--<td>
							<input type='hidden' id='<?php echo $TPL_V1["child_sn"]?>_home_rate' value='<?php echo $TPL_V1["home_rate"]?>'>
							<input type='checkbox' <?php if($TPL_V1["win"]==1){?> checked <?php }?>><?php echo $TPL_V1["home_rate"]?>

							<input type='hidden' id='<?php echo $TPL_V1["child_sn"]?>_draw_rate' value='<?php echo $TPL_V1["draw_rate"]?>'>
							<input type='checkbox' <?php if($TPL_V1["win"]==3){?> checked <?php }?>><?php echo $TPL_V1["draw_rate"]?>

							<input type='hidden' id='<?php echo $TPL_V1["child_sn"]?>_away_rate' value='<?php echo $TPL_V1["away_rate"]?>'>
							<input type='checkbox' <?php if($TPL_V1["win"]==2){?> checked <?php }?>><?php echo $TPL_V1["away_rate"]?>

						</td>-->
						<td>
							<?php if($TPL_VAR["membervip"] != "1"){?>
							<input type='button' class='btnStyle4' value='배당수정' onclick=open_window('/game/modifyrate?idx=<?php echo $TPL_V1["child_sn"]?>&gametype=<?php echo $TPL_V1["type"]?>&mode=edit','650','300')>
							<?php }?>

						</td>
						<td>
<?php if($TPL_V1["special"]==2&&$TPL_V1["result"]!=1){?>
								<input type="button" class="btnStyle3" value="마감" onclick="onDeadLine(<?php echo $TPL_V1["child_sn"]?>)";>&nbsp;
<?php }?>
						</td>
						<td><?php echo $TPL_V1["betting_count"]?></td>
					<?php if($TPL_VAR["membervip"] != "1"){?>
        <td><a href="#" onclick="open_window('/game/popup_bet_list?child_sn=<?php echo $TPL_V1["child_sn"]?>&select_no=1','1024','600')"><span id="home_total_betting_<?php echo $TPL_V1["child_sn"]?>"><?php echo number_format($TPL_V1["home_total_betting"],0)?>(<?php echo number_format($TPL_V1["active_home_total_betting"])?>)</span></a></td>
						<td><a href="#" onclick="open_window('/game/popup_bet_list?child_sn=<?php echo $TPL_V1["child_sn"]?>&select_no=3','1024','600')"><span id="draw_total_betting_<?php echo $TPL_V1["child_sn"]?>"><?php echo number_format($TPL_V1["draw_total_betting"])?>(<?php echo number_format($TPL_V1["active_draw_total_betting"])?>)</span></a></td>
						<td><a href="#" onclick="open_window('/game/popup_bet_list?child_sn=<?php echo $TPL_V1["child_sn"]?>&select_no=2','1024','600')"><span id="away_total_betting_<?php echo $TPL_V1["child_sn"]?>"><?php echo number_format($TPL_V1["away_total_betting"])?>(<?php echo number_format($TPL_V1["active_away_total_betting"])?>)</span></a></td>
					<?php }else{?>
                        <td><span id="home_total_betting_<?php echo $TPL_V1["child_sn"]?>"><?php echo number_format($TPL_V1["home_total_betting"],0)?>(<?php echo number_format($TPL_V1["active_home_total_betting"],0)?>)</span></td>
						<td><span id="draw_total_betting_<?php echo $TPL_V1["child_sn"]?>"><?php echo number_format($TPL_V1["draw_total_betting"],0)?>(<?php echo number_format($TPL_V1["active_draw_total_betting"],0)?>)</span></td>
						<td><span id="away_total_betting_<?php echo $TPL_V1["child_sn"]?>"><?php echo number_format($TPL_V1["away_total_betting"],0)?>(<?php echo number_format($TPL_V1["active_away_total_betting"],0)?>)</span></td>
					<?php }?>
					</tr>
<?php }}?>
<?php if($TPL_VAR["type"]==3){?>
		    	<tr height="26">
						<td  colspan="9">
							<input type="button" value="전체선택" onclick="checkAll()" class="input">
							<input type="button" value="선택해제" onclick="clearAll()" class="input">
							<input type="button" value="선택발매" onclick="addall()" class="input">
							<input type="button" value="선택삭제" onclick="delall()" class="input">
						</td>
					</tr>
<?php }?>
            </tbody>
	  </table>
	  
	  <div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	
	</form>
</div>