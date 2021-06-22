<?php
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
    $page = $TPL_VAR['page'];
?>
<script>document.title = '게임관리-배팅현황';</script>

<script language="JavaScript">
    $(document).ready(function () {
        setTimeout(function(){
            refreshBetList();
        },10000);
    });

    var now_page = <?php echo $page?>;
    //var master_admin = <?php echo $TPL_VAR["master_admin"]?>;
    var show_detail = <?php echo $TPL_VAR["show_detail"]?>;
    //var is_super = <?php echo $TPL_VAR["super"]?>;

    function refreshBetList() {
        var param = {
            "page": now_page,
            "perpage": $('#perpage').val(),
            "begin_date":$('#begin_date').val(),
            "end_date":$('#end_date').val(),
            "sel_result":$('#sel_result').val(),
            "select_keyword":$('#select_keyword').val(),
            "keyword":$('#keyword').val()
        }
        
        $.ajax({
            url : "/game/refreshMultiBetList",
            type : "post",
            cache : false,
            async : false,
            timeout : 5000,
            scriptCharset : "utf-8",
            data: param,
            dataType : "json",
            success: function(res) {
                if ( typeof(res) == "object" ) {
                    refreshBetResult(res['update']);
                    //refreshNewBet(res['new']);
                }
            },
            error: function(xhr,status,error) {
                alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
            }
        });

        // 업데이트 주기(5초)
        setTimeout(function(){
            refreshBetList();
        },10000);
    }

    function refreshBetResult(betlist)
    {
        for ( var key in  betlist ) {
            var item = betlist[key];
            var betting_no = item['betting_no'];
            var betting_sn = item['betting_sn'];
            var cart_result = item['cart_result'];
            var child_status = item['child_result'];
            var child_result = item['win'];

            var total_result = '';
            if(cart_result == 1)
            {
                total_result = '<font color=red>적  중</font>';
            } else if(cart_result == 2) {
                total_result = '실  패';
            } else if(cart_result == 4) {
                total_result = '적  특';
            } else {
                total_result = '경기중';
            }

            var game_result = '';
            if(child_result == 1)
            {
                game_result = '[홈승]';
            } else if(child_result == 3) {
                game_result = '[무승부]';
            } else if(child_result == 2) {
                game_result = '[원정승]';
            } else if(child_result == 4) {
                game_result = '[취소]';
            } else {
                game_result = '[대기]';
            }

            var game_status = '';
            var ico_class= '';
            if(child_status == 1)
            {
                game_status = '<font color=red>적중</font>';
                ico_class = 'win';
            } else if(child_status == 2) {
                game_status = '낙첨';
                ico_class = 'lose';
            } else if(child_status == 4 || child_status == 3) {
                game_status = '취소';
                ico_class = 'cencel';
            } else {
                game_status = '경기중';
                ico_class = '';
            }

            $('#'+betting_no+'_result').html(total_result);
            $('#'+betting_no+'_'+betting_sn+'_result').html(game_result);
            $('#'+betting_no+'_'+betting_sn+'_status').html(game_status);
            $('#'+betting_no+'_'+betting_sn+'_ico').attr('class', ico_class);


            $('#'+betting_no+'_result_amt').html(number_format(item['result_money']));
            if(item['home_score'] != null && item['away_score'] != null)
            {
                $('#'+betting_no+'_'+betting_sn+'_score').html(item['home_score']+":"+item['away_score']);
            }
        }
    }

    function number_format(str) {
        str += "";
        var objRegExp = new RegExp('(-?[0-9]+)([0-9]{3})');
        while (objRegExp.test(str)) {
            str = str.replace(objRegExp, '$1,$2');
        }
        return str;
    }

    function on_change()
	{
		document.form3.submit();
	}
	function go_delete(url)
	{
		if(confirm("정말 삭제하시겠습니까?  "))
		{

			url = url + "&perpage=<?php echo $TPL_VAR["perpage"]?>&sel_result=<?php echo $TPL_VAR["sel_result"]?>&select_keyword=<?php echo $TPL_VAR["select_keyword"]?>&keyword=<?php echo $TPL_VAR["keyword"]?>&page=<?php echo $TPL_VAR["page"]?>&show_detail=<?php echo $TPL_VAR["show_detail"]?>";
			document.location = url;
		}
		else
		{
			return;
		}
	}
	
	function toggle(id)
	{
		$( "#"+id ).slideToggle(100);
	}	
	
	function betting_view(url)
	{
		var newwindow = window.open(url,'','width=900,height=300,left=50,scrollbars=yes');
	}
	
	function onKeywordChange(frm)
	{
		if(frm.select_keyword.value=='')
		{
			frm.keyword.value='';
			frm.submit();
		}
	}
	
	var actionFlag = 0;	
	function onExceptionBetClick(sn)
	{
		if ( actionFlag == 0 ) {
			if(confirm("[적특] 처리하시겠습니까?"))
			{
				actionFlag = 1;
				document.location = "/game/exceptionBetProcessMulti?sn="+sn;
			}
		} else {
			alert('처리 중입니다. 잠시만 기다려주세요.');
		}
	}
</script>

</head>

<body>

<div class="wrap" id="betting_2">
	<div id="route">
		<h5>관리자 시스템 > 게임 관리 > 게임설정 > <b>배팅현황</b></h5>
	</div>

	<h3>배팅현황</h3>
	<ul id="tab">
		<li><a href="/game/betlist" id="sport_1">스포츠 I</a></li>
		<li><a href="/game/betlist_multi" id="sport_2">스포츠 II</a></li>
	</ul>
	<div id="search">
		<form action="?" method="GET" name="form3" id="form3">
			<div class="wrap">
				<input type="hidden" name="mode" value="search">
				<span class="icon">출력</span>
			    <input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				<!-- 기간 필터 -->
				<span class="icon">날짜</span>&nbsp;
				<input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />&nbsp;
				<select id="sel_result" name="sel_result">
					<option value="9">전체</option>
					<option value="1" <?php if($TPL_VAR["sel_result"]=="1"){?> selected <?php }?>>당첨</option>
					<option value="2" <?php if($TPL_VAR["sel_result"]=="2"){?> selected <?php }?>>낙첨</option>
					<option value="0" <?php if($TPL_VAR["sel_result"]=="0"){?> selected <?php }?>>경기중</option>
				</select>
				<select id="select_keyword" name="select_keyword" onChange="onKeywordChange(this.form)">
					<option value="" 	<?php if($TPL_VAR["select_keyword"]==''){?>  selected <?php }?>>전체</option>
					<option value="uid" <?php if($TPL_VAR["select_keyword"]=='uid'){?>  selected <?php }?>>아이디</option>
					<option value="nick"<?php if($TPL_VAR["select_keyword"]=='nick'){?>  selected <?php }?>>닉네임</option>
					<option value="betting_no"<?php if($TPL_VAR["select_keyword"]=='betting_no'){?>  selected <?php }?>>배팅번호</option>
					<option value="money_up"<?php if($TPL_VAR["select_keyword"]=='money_up'){?>  selected <?php }?>>배팅금↑</option>
					<option value="money_down"<?php if($TPL_VAR["select_keyword"]=='money_down'){?>  selected <?php }?>>배팅금↓</option>
					<option value="home"<?php if($TPL_VAR["select_keyword"]=='home'){?>  selected <?php }?>>팀명-홈</option>
					<option value="away"<?php if($TPL_VAR["select_keyword"]=='away'){?>  selected <?php }?>>팀명-어웨이</option>
				</select>
				<input type="text" id="keyword" name="keyword" value=<?php echo $TPL_VAR["keyword"]?>>
				<input name="Submit4" type="submit"  value="검색" class="btnStyle3"/>
				
				&nbsp;&nbsp;&nbsp;&nbsp;
				<span>구분</span>
				<input type="radio" name="show_detail" value=0 <?php if($TPL_VAR["show_detail"]=='0'){?>checked<?php }?> onClick="submit()" class="radio">숨기기
				<input type="radio" name="show_detail" value=1 <?php if($TPL_VAR["show_detail"]=='1'){?>checked<?php }?> onClick="submit()" class="radio">펼치기
				<input type='hidden' name='mode' value='search'>
			</div>
			<div class="wrapRight">
				<span>총배팅액 : <font color=blue><?php echo number_format($TPL_VAR["sumList"]["total_betting"],0)?>원</font></span> 
				<span>배당액 : <font color=blue><?php echo number_format($TPL_VAR["sumList"]["total_result"],0)?>원</font></span>
				<span>정산액 : <font color="blue"><?php echo number_format($TPL_VAR["sumList"]["total_betting"]-$TPL_VAR["sumList"]["total_result"],0)?>원</font></span>
			</div>
		</form>
	</div>
			
  <form id="form1" name="form1" method="post" action="?act=delete_user">
		<table border="0" cellspacing="1" class="tableStyle_gameList" summary="게임별 배팅현황">
		<thead>
			<tr>					
				<th>사이트</th>
				<th>배팅번호</th>
				<th>아이디</th>
				<th>닉네임</th>
				<th>게임</th>
				<th>배팅금액</th>
				<th>배당율</th>
				<th>예상배당</th>
				<th>게임결과</th>
				<th>당첨금액</th>					
				<th>배팅날짜</th>
				<th>총판</th>
				<th>배팅취소</th>
				<th>배팅IP</th>
			</tr>
		</thead>
		<tbody>
			<!-- 12.10.30 "종료" (list.blnGameEnd=="Y") 경우 tr class="gameEnd" / "진행중" 경우 tr class="gameGoing" -->
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
<?php if($TPL_V1["betting_cnt"]==1){?>
			<tr id="t_<?php echo $TPL_V1["betting_no"]?>" class="singleFolder" >
<?php }else{?>
<?php if($TPL_V1["result"]==0){?>
				<tr id="t_<?php echo $TPL_V1["betting_no"]?>" class="gameGoing" >
<?php }else{?>	
				<tr id="t_<?php echo $TPL_V1["betting_no"]?>" class="gameEnd" >
<?php }?>
<?php }?>
				<td><?php echo $TPL_V1["logo"];?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["betting_no"]?></td>			    
				<?php if($TPL_VAR["membervip"] != "1"){?>
				<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,600)"><?php echo $TPL_V1["member"]["uid"]?></a></td>			
				<?php }else{?>
				<td><?php echo $TPL_V1["member"]["uid"]?></td>
				<?php }?>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["member"]["nick"]?></td>				    
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')">
					<!--<span>(<?php echo $TPL_V1["win_count"]?>/<?php echo $TPL_V1["betting_cnt"]?>)</span>-->
					<ul class="tablestyle_game">
<?php 
	if(is_array($TPL_R2=$TPL_V1["item"])&&!empty($TPL_R2)){
		$topResult = 0;
		$rateErrorCheckFlag = 0;
		foreach($TPL_R2 as $TPL_V2){
			if ( $TPL_V2["result"] == 1 ) {
				$resultClass = "class=\"win\"";
			} else if ( $TPL_V2["result"] == 2 ) {
				$resultClass = "class=\"lose\"";
				$topResult = 1;
			} else if ( $TPL_V2["result"] == 3 || $TPL_V2["result"] == 4 ) {
				$resultClass = "class=\"cencel\"";
			} else {
				unset($resultClass);
			}

			$icon_id =  $TPL_V1["betting_no"].'_'.$TPL_V2["total_betting_sn"]."_ico";
			if ( $TPL_V2["special"] == 3 ) echo "<li id='{$icon_id}' {$resultClass}>S</li>";
			else if ( $TPL_V2["special"] == 4 ) echo "<li id='{$icon_id}' {$resultClass}>P</li>";
			else if ( $TPL_V2["special"] == 5 ) echo "<li id='{$icon_id}' {$resultClass}>B</li>";
			else if ( $TPL_V2["special"] == 6 ) echo "<li id='{$icon_id}' {$resultClass}>D</li>";
			else if ( $TPL_V2["special"] == 7 ) echo "<li id='{$icon_id}' {$resultClass}>R</li>";
			else {
				switch ($TPL_V2['sport_name']) {
					case "축구":
						switch ($TPL_V2['game_type']) {
							case "1": // 승패
								echo "<li id='{$icon_id}' {$resultClass}>1</li>";
								break;
							case "2":
							case "11": // 핸디캡
								echo "<li id='{$icon_id}' {$resultClass}>2</li>";
								break;
							case "3":
							case "12": // 언더오버
								echo "<li id='{$icon_id}' {$resultClass}>3</li>";
								break;
							case "4": // 승무패
								echo "<li id='{$icon_id}' {$resultClass}>4</li>";
								break;
							case "5": // 승무패 (전반)
								echo "<li id='{$icon_id}' {$resultClass}>5</li>";
								break;
							case "6": // 승무패 (후반)
								echo "<li id='{$icon_id}' {$resultClass}>6</li>";
								break;
							case "7": // 언더오버 (전반)
								echo "<li id='{$icon_id}' {$resultClass}>7</li>";
								break;
							case "8": // 언더오버 (후반)
								echo "<li id='{$icon_id}' {$resultClass}>8</li>";
								break;
							case "9": // 득점홀짝
								echo "<li id='{$icon_id}' {$resultClass}>9</li>";
								break;
							case "10": // 득점홀짝 (전반)
								echo "<li id='{$icon_id}' {$resultClass}>10</li>";
								break;
							case "13": // 정확한 스코어
								echo "<li id='{$icon_id}' {$resultClass}>11</li>";
								break;
						}
						break;
					case "농구":
						switch ($TPL_V2['game_type']) {
							case "1": // 승패
								echo "<li id='{$icon_id}' {$resultClass}>1</li>";
								break;
							case "2":
							case "16": // 핸디캡
								echo "<li id='{$icon_id}' {$resultClass}>2</li>";
								break;
							case "3":
							case "17": // 언더오버
								echo "<li id='{$icon_id}' {$resultClass}>3</li>";
								break;
							case "4": // 승무패 (1쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>4</li>";
								break;
							case "5": // 승무패 (2쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>5</li>";
								break;
							case "6": // 승무패 (3쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>6</li>";
								break;
							case "7": // 승무패 (4쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>7</li>";
								break;
							case "8": // 핸디캡 (1쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>8</li>";
								break;
							case "9": // 핸디캡 (2쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>9</li>";
								break;
							case "10": // 핸디캡 (3쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>10</li>";
								break;
							case "11": // 핸디캡 (4쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>11</li>";
								break;
							case "12": // 언더오버 (1쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>12</li>";
								break;
							case "13": // 언더오버 (2쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>13</li>";
								break;
							case "14": // 언더오버 (3쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>14</li>";
								break;
							case "15": // 언더오버 (4쿼터)
								echo "<li id='{$icon_id}' {$resultClass}>15</li>";
								break;
						}
						break;
					case "배구":
						switch ($TPL_V2['game_type']) {
							case "1": // 승패
								echo "<li id='{$icon_id}' {$resultClass}>1</li>";
								break;
							case "2": // 핸디캡
								echo "<li id='{$icon_id}' {$resultClass}>2</li>";
								break;
							case "3": // 언더오버 
								echo "<li id='{$icon_id}' {$resultClass}>3</li>";
								break;
							case "4": // 홀짝
								echo "<li id='{$icon_id}' {$resultClass}>4</li>";
								break;
							case "5": // 홀짝 (1세트)
								echo "<li id='{$icon_id}' {$resultClass}>5</li>";
								break;
							case "6": // 정확한 스코어
								echo "<li id='{$icon_id}' {$resultClass}>6</li>";
								break;
						}
						break;
					case "야구":
						switch ($TPL_V2['game_type']) {
							case "1": // 승패
								echo "<li id='{$icon_id}' {$resultClass}>1</li>";
								break;
							case "2":
							case "11": // 핸디캡
								echo "<li id='{$icon_id}' {$resultClass}>2</li>";
								break;
							case "3":
							case "12": // 언더오버 
								echo "<li id='{$icon_id}' {$resultClass}>3</li>";
								break;
							case "4": // 승무패 (1이닝)
								echo "<li id='{$icon_id}' {$resultClass}>4</li>";
								break;
							case "5": // 핸디캡 (3이닝)
								echo "<li id='{$icon_id}' {$resultClass}>5</li>";
								break;
							case "6": // 핸디캡(5이닝)
								echo "<li id='{$icon_id}' {$resultClass}>6</li>";
								break;
							case "7": // 핸디캡 (7이닝)
								echo "<li id='{$icon_id}' {$resultClass}>7</li>";
								break;
							case "8": // 언더오버(3이닝)
								echo "<li id='{$icon_id}' {$resultClass}>8</li>";
								break;
							case "9": // 언더오버 (5이닝)
								echo "<li id='{$icon_id}' {$resultClass}>9</li>";
								break;
							case "10": // 언더오버 (7이닝)
								echo "<li id='{$icon_id}' {$resultClass}>10</li>";
								break;
						}
						break;
					case "아이스하키":
						switch ($TPL_V2['game_type']) {
							case "1": // 승패
								echo "<li id='{$icon_id}' {$resultClass}>1</li>";
								break;
							case "2": // 핸디캡
								echo "<li id='{$icon_id}' {$resultClass}>2</li>";
								break;
							case "3": // 언더오버 
								echo "<li id='{$icon_id}' {$resultClass}>3</li>";
								break;
							case "4": // 승무패
								echo "<li id='{$icon_id}' {$resultClass}>4</li>";
								break;
							case "5": // 승패 (1피리어드)
								echo "<li id='{$icon_id}' {$resultClass}>5</li>";
								break;
							case "6":// 승무패 (1피리어드)
								echo "<li id='{$icon_id}' {$resultClass}>6</li>";
								break;
							case "7": // 핸디캡 (1피리어드)
								echo "<li id='{$icon_id}' {$resultClass}>7</li>";
								break;
							case "8": // 언더오버 (1피리어드)
								echo "<li id='{$icon_id}' {$resultClass}>8</li>";
								break;
						}
						break;
					case "이벤트":
						echo "<li id='{$icon_id}' {$resultClass}>1</li>";
						break;
				}
			}

			if ( $TPL_V2["select_no"] == 1 and ($TPL_V2["game_home_rate"]+0.1) < $TPL_V2["select_rate"] ) $rateErrorCheckFlag = 1;
			if ( $TPL_V2["select_no"] == 2 and ($TPL_V2["game_away_rate"]+0.1) < $TPL_V2["select_rate"] ) $rateErrorCheckFlag = 1;
			if ( $TPL_V2["select_no"] == 3 and ($TPL_V2["game_draw_rate"]+0.1) < $TPL_V2["select_rate"] ) $rateErrorCheckFlag = 1;
		}

		if ( $rateErrorCheckFlag == 1 ) echo "<li style='width:36px; background:none; background-color:red;'>[검수]</li>";
	}
?>
					</ul>
				</td>
				<td <?php if( $TPL_V1["betting_money"] >= 300000 ) {?> style="background-color:#4374D9;color:#fff;" <?php } ?> onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format($TPL_V1["betting_money"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo sprintf("%3.2f",$TPL_V1["result_rate"]);?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format($TPL_V1["result_rate"]*$TPL_V1["betting_money"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" id="<?php echo $TPL_V1["betting_no"]?>_result">
<?php if($TPL_V1["result"]==1){?><font color=red>적  중</font>
<?php }elseif($TPL_V1["result"]==2 or $topResult==1){?>실  패
<?php }elseif($TPL_V1["result"]==4){?>적  특
<?php }else{?>경기중
<?php }?>
				</td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" id="<?php echo $TPL_V1["betting_no"]?>_result_amt"><?php echo number_format($TPL_V1["result_money"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["regDate"]?><?php echo $TPL_V1["regdate"]?></td> 
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["rec_id"]?><?php echo $TPL_V1["partner_id"]?></td>
				<td>
				<?php if($TPL_VAR["membervip"] != "1"){?>
				<input type="button" value="취소"  class="btnStyle3" onClick="go_delete('/game/betcancelProcessMulti?betting_no=<?php echo $TPL_V1["betting_no"]?>&amp;result=<?php echo $TPL_V2["result"];?>&amp;oper=race&amp;check_date=<?php echo sprintf("%s %s:%s",$TPL_V1["item"][0]["gameDate"],$TPL_V1["item"][0]["gameHour"],$TPL_V1["item"][0]["gameTime"])?>')">
				<?php }?>
				</td>
				<!--<td><input type="button" value="취소"  class="btnStyle3" onClick="go_delete('/game/betcancelProcess?betting_no=<?php echo $TPL_V1["betting_no"]?>&oper=race')"></td>-->
				<td><?php echo $TPL_V1["betting_ip"]?></td>
			</tr>
			
			<tr id="d_<?php echo $TPL_V1["betting_no"]?>" <?php if($TPL_VAR["show_detail"]==0){?>style="display:none;"<?php }?> class="gameDetail">
				<td colspan="14">
					<table cellspacing="1" id="d_<?php echo $TPL_V1["betting_no"]?>">
						<tr>				  
							<th>게임타입</th>
							<th>경기시간</th>
							<th>리그</th>
							<th colspan="2" >홈팀</th>
							<th>무</th>
							<th colspan="2">원정팀</th>
							<th>배팅방향</th>
							<th>배팅배당</th>
							<th>점수</th>
							<th>결과</th>
							<th>상태</th>
							<th>적특</th>
						</tr>
<?php
	if ( $TPL_item_2 ) {
		foreach ( $TPL_V1["item"] as $TPL_V2 ) {
			$detail_name = "";
			$home_score = "";
			$away_score = "";
			$homeTeamNameAdd = "";
			$awayTeamNameAdd = "";
			switch ($TPL_V2['sport_name']) {
				case "축구":
					switch ($TPL_V2['betting_type']) {
						case "1":
							$detail_name = "<span class='victory'>승패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "2":
						case "11":
							$detail_name = "<span class='handicap'>핸디캡</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "3":
						case "12":
							$detail_name = "<span class='underover'>언더오버</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "4":
							$detail_name = "<span class='victory'>승무패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "5":
							$detail_name = "<span class='victory'>승무패(전반)</span>";
							$home_score = $TPL_V2['home_half_time_score'];
							$away_score = $TPL_V2['away_half_time_score'];
							break;
						case "6":
							$detail_name = "<span class='victory'>승무패(후반)</span>";
							$home_score = $TPL_V2['home_2nd_half_time_score'];
							$away_score = $TPL_V2['away_2nd_half_time_score'];
							break;
						case "7":
							$detail_name = "<span class='underover'>언더오버(전반)</span>";
							$home_score = $TPL_V2['home_half_time_score'];
							$away_score = $TPL_V2['away_half_time_score'];
							break;
						case "8":
							$detail_name = "<span class='underover'>언더오버(후반)</span>";
							$home_score = $TPL_V2['home_2nd_half_time_score'];
							$away_score = $TPL_V2['away_2nd_half_time_score'];
							break;
						case "9":
							$detail_name = "<span>득점홀짝</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>[홀]</span>";
							$awayTeamNameAdd = "<span style='color:red'>[짝]</span>&nbsp;";
							break;
						case "10":
							$detail_name = "<span>득점홀짝(전반)</span>";
							$home_score = $TPL_V2['home_half_time_score'];
							$away_score = $TPL_V2['away_half_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>[홀]</span>";
							$awayTeamNameAdd = "<span style='color:red'>[짝]</span>&nbsp;";
							break;
						case "13":
							$detail_name = "정확한 스코어 (" . $TPL_V2['point'] . ")";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];

							break;
					}
					break;
				case "농구":
					switch ($TPL_V2['betting_type']) {
						case "1":
							$detail_name = "<span class='victory'>승패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "2":
						case "16":
							$detail_name = "<span class='handicap'>핸디캡</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "3":
						case "17":
							$detail_name = "<span class='underover'>언더오버</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "4":
							$detail_name = "<span class='victory'>승무패(1쿼터)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							break;
						case "5":
							$detail_name = "<span class='victory'>승무패(2쿼터)</span>";
							$home_score = $TPL_V2['home_2_time_score'];
							$away_score = $TPL_V2['away_2_time_score'];
							break;
						case "6":
							$detail_name = "<span class='victory'>승무패(3쿼터)</span>";
							$home_score = $TPL_V2['home_3_time_score'];
							$away_score = $TPL_V2['away_3_time_score'];
							break;
						case "7":
							$detail_name = "<span class='victory'>승무패(4쿼터)</span>";
							$home_score = $TPL_V2['home_4_time_score'];
							$away_score = $TPL_V2['away_4_time_score'];
							break;
						case "8":
							$detail_name = "<span class='handicap'>핸디캡(1쿼터)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "9":
							$detail_name = "<span class='handicap'>핸디캡(2쿼터)</span>";
							$home_score = $TPL_V2['home_2_time_score'];
							$away_score = $TPL_V2['away_2_time_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "10":
							$detail_name = "<span class='handicap'>핸디캡(3쿼터)</span>";
							$home_score = $TPL_V2['home_3_time_score'];
							$away_score = $TPL_V2['away_3_time_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "11":
							$detail_name = "<span class='handicap'>핸디캡(4쿼터)</span>";
							$home_score = $TPL_V2['home_4_time_score'];
							$away_score = $TPL_V2['away_4_time_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "12":
							$detail_name = "<span class='underover'>언더오버(1쿼터)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "13":
							$detail_name = "<span class='underover'>언더오버(2쿼터)</span>";
							$home_score = $TPL_V2['home_2_time_score'];
							$away_score = $TPL_V2['away_2_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "14":
							$detail_name = "<span class='underover'>언더오버(3쿼터)</span>";
							$home_score = $TPL_V2['home_3_time_score'];
							$away_score = $TPL_V2['away_3_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "15":
							$detail_name = "<span class='underover'>언더오버(4쿼터)</span>";
							$home_score = $TPL_V2['home_4_time_score'];
							$away_score = $TPL_V2['away_4_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
					}
					break;
				case "배구":
					switch ($TPL_V2['betting_type']) {
						case "1":
							$detail_name = "<span class='victory'>승패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "2":
							$detail_name = "<span class='handicap'>핸디캡</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "3":
							$detail_name = "<span class='underover'>언더오버</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "4":
							$detail_name = "<span>홀짝</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>[홀]</span>";
							$awayTeamNameAdd = "<span style='color:red'>[짝]</span>&nbsp;";
							break;
						case "5":
							$detail_name = "<span>홀짝(1세트)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>[홀]</span>";
							$awayTeamNameAdd = "<span style='color:red'>[짝]</span>&nbsp;";
							break;
						case "6":
							$detail_name = "정확한 스코어 (" . $TPL_V2['point'] . ")";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
					}
					break;
				case "야구":
					switch ($TPL_V2['betting_type']) {
						case "1":
							$detail_name = "<span class='victory'>승패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "2":
						case "11":
							$detail_name = "<span class='handicap'>핸디캡</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "3":
						case "12":
							$detail_name = "<span class='underover'>언더오버</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "4":
							$detail_name = "<span class='victory'>승무패(1이닝)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							break;
						case "5":
							$detail_name = "<span class='handicap'>핸디캡(3이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "6":
							$detail_name = "<span class='handicap'>핸디캡(5이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['home_4_time_score'] != null && $TPL_V2['home_5_time_score'] != null 
								&& $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null && $TPL_V2['away_4_time_score'] != null &&  $TPL_V2['away_5_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']) + intval($TPL_V2['home_4_time_score']) + intval($TPL_V2['home_5_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']) + intval($TPL_V2['away_4_time_score']) + intval($TPL_V2['away_5_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "7":
							$detail_name = "<span class='handicap'>핸디캡(7이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['home_4_time_score'] != null && $TPL_V2['home_5_time_score'] != null && $TPL_V2['home_6_time_score'] != null && $TPL_V2['home_7_time_score'] != null 
								&& $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null && $TPL_V2['away_4_time_score'] != null &&  $TPL_V2['away_5_time_score'] != null && $TPL_V2['away_6_time_score'] != null &&  $TPL_V2['away_7_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']) + intval($TPL_V2['home_4_time_score']) + intval($TPL_V2['home_5_time_score']) + intval($TPL_V2['home_6_time_score']) + intval($TPL_V2['home_7_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']) + intval($TPL_V2['away_4_time_score']) + intval($TPL_V2['away_5_time_score']) + intval($TPL_V2['away_6_time_score']) + intval($TPL_V2['away_7_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "8":
							$detail_name = "<span class='underover'>언더오버(3이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "9":
							$detail_name = "<span class='underover'>언더오버(5이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['home_4_time_score'] != null && $TPL_V2['home_5_time_score'] != null 
								&& $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null && $TPL_V2['away_4_time_score'] != null &&  $TPL_V2['away_5_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']) + intval($TPL_V2['home_4_time_score']) + intval($TPL_V2['home_5_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']) + intval($TPL_V2['away_4_time_score']) + intval($TPL_V2['away_5_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "10":
							$detail_name = "<span class='underover'>언더오버(7이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['home_4_time_score'] != null && $TPL_V2['home_5_time_score'] != null && $TPL_V2['home_6_time_score'] != null && $TPL_V2['home_7_time_score'] != null 
								&& $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null && $TPL_V2['away_4_time_score'] != null &&  $TPL_V2['away_5_time_score'] != null && $TPL_V2['away_6_time_score'] != null &&  $TPL_V2['away_7_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']) + intval($TPL_V2['home_4_time_score']) + intval($TPL_V2['home_5_time_score']) + intval($TPL_V2['home_6_time_score']) + intval($TPL_V2['home_7_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']) + intval($TPL_V2['away_4_time_score']) + intval($TPL_V2['away_5_time_score']) + intval($TPL_V2['away_6_time_score']) + intval($TPL_V2['away_7_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
					}
					break;
				case "아이스하키":
					switch ($TPL_V2['betting_type']) {
						case "1":
							$detail_name = "<span class='victory'>승패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "2":
							$detail_name = "<span class='handicap'>핸디캡</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "3":
							$detail_name = "<span class='underover'>언더오버</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "4":
							$detail_name = "<span class='victory'>승무패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "5":
							$detail_name = "<span class='victory'>승패(1피리어드)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							break;
						case "6":
							$detail_name = "<span class='victory'>승무패(1피리어드)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							break;
						case "7":
							$detail_name = "<span class='handicap'>핸디캡(1피리어드)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "8":
							$detail_name = "<span class='underover'>언더오버(1피리어드)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
					}
					break;
			}
?>
							<tr bgcolor="#ede8e8" border=1>				
								<td width="60" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
								<?=$detail_name?>
								</td>
								<td width="80" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["g_date"]?><?php echo sprintf("%s/ %s %s:%s",substr($TPL_V2["gameDate"],5,2),substr($TPL_V2["gameDate"],8,2),$TPL_V2["gameHour"],$TPL_V2["gameTime"])?></td>
								<td width="100" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["alias_name"]?></td>
								<td width="100" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==1){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["home_team"] . $homeTeamNameAdd?></td>
								<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==1){?>;background :#fff111<?php }?>">
<?php 	
	if ( $TPL_V2["select_no"] == 1 and $TPL_V2["game_home_rate"] != $TPL_V2["select_rate"] ) echo $TPL_V2["home_rate"]." <span style='color:red;'>[<b>".$TPL_V2["game_home_rate"]."</b>]</span>";
	else echo $TPL_V2["home_rate"]; 
?>
								</td>
								<td width="60" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==3){?>;background :#fff111<?php }?>">
<?php 
	if ( $TPL_V2["select_no"] == 3 and $TPL_V2["game_draw_rate"] != $TPL_V2["select_rate"] ) echo $TPL_V2["draw_rate"]." <span style='color:red;'>[<b>".$TPL_V2["game_draw_rate"]."</b>]</span>";
	else echo $TPL_V2["draw_rate"];
?>
								</td>
								<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==2){?>;background :#fff111<?php }?>">
<?php 	
	if ( $TPL_V2["select_no"] == 2 and $TPL_V2["game_away_rate"] != $TPL_V2["select_rate"] ) echo $TPL_V2["away_rate"]." <span style='color:red;'>[<b>".$TPL_V2["game_away_rate"]."</b>]</span>";
	else echo $TPL_V2["away_rate"];
?>
								</td>
								<td width="100" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==2){?>;background :#fff111<?php }?>"><?php echo $awayTeamNameAdd . $TPL_V2["away_team"]?></td>
								<td width="40" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php
	if ( $TPL_V2["select_no"] == 1 ) echo "홈팀";
	else if ( $TPL_V2["select_no"] == 2 ) echo "원정팀";
	else if ( $TPL_V2["select_no"] == 3 ) echo "무";
?>
								</td>
								<td width="40" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["select_rate"];?></td>
								<td width="40" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666" id="<?php echo $TPL_V1["betting_no"].'_'.$TPL_V2["total_betting_sn"]?>_score"><?=$home_score?> : <?=$away_score?></td>
								<td width="50" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666" id="<?php echo $TPL_V1["betting_no"].'_'.$TPL_V2["total_betting_sn"]?>_result">
<?php if($TPL_V2["win"]==1){?>[홈승]
<?php }elseif($TPL_V2["win"]==3){?>[무승부]
<?php }elseif($TPL_V2["win"]==2){?>[원정승]
<?php }elseif($TPL_V2["win"]==4){?>[취소]
<?php }else{?>[대기]
<?php }?>
								</td>
								<td width="65" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666" id="<?php echo $TPL_V1["betting_no"].'_'.$TPL_V2["total_betting_sn"]?>_status">
<?php if($TPL_V2["result"]==0){?><font color=#666666>경기중</font>
<?php }elseif($TPL_V2["result"]==1){?><font color=red>적중</font>
<?php }elseif($TPL_V2["result"]==2){?><font color=blue>낙첨</font>
<?php }elseif($TPL_V2["result"]==4){?><font color=green>취소</font>
<?php }?>
								</td>
								<td width="30">
<?php 
	if ( $TPL_V2["home_rate"] < 1.01 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1 ) {
?>
<span style="color:#D9418C;"><b>적특됨</b></span>
<?php
	} else {
?>
<?php if($TPL_VAR["membervip"] != "1"){?>
<input type="button" value="적특"  class="btnStyle3" onClick="onExceptionBetClick(<?php echo $TPL_V2["total_betting_sn"]?>);"></td>
<?php }?>
<?php
	}
?>
							</tr>															
<?php }}?>
						</table>
				</td>
			</tr>
<?php }}?>	
		</tbody>
		</table>
		
			
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	</form>
</div>