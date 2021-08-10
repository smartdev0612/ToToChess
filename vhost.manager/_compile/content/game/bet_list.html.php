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
            "last_special_code":$('#last_special_code').val(),
            "sel_result":$('#sel_result').val(),
            "select_keyword":$('#select_keyword').val(),
            "keyword":$('#keyword').val()
        }

        $.ajax({
            url : "/game/refreshBetList",
            type : "post",
            cache : false,
            async : false,
            timeout : 5000,
            scriptCharset : "utf-8",
            data: param,
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
                total_result = '배팅중';
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
                game_status = '배팅중';
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
				document.location = "/game/exceptionBetProcess?sn="+sn;
			}
		} else {
			alert('처리 중입니다. 잠시만 기다려주세요.');
		}
	}
</script>

</head>

<body>

<div class="wrap" id="betting_1">
	<div id="route">
		<h5>관리자 시스템 > 게임 관리 > 게임설정 > <b>배팅현황</b></h5>
	</div>

	<h3>배팅현황</h3>
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
				<select id="last_special_code" name="last_special_code">
					<option value="9">전체</option>
					<?php if($TPL_VAR["membervip"] != "1"){?>
                        <option value="1" <?php if($TPL_VAR["last_special_code"]=="1"){?> selected <?php }?>>스포츠</option>
                        <!-- <option value="2" <?php if($TPL_VAR["last_special_code"]=="2"){?> selected <?php }?>>해외형</option> -->
                        <option value="4" <?php if($TPL_VAR["last_special_code"]=="4"){?> selected <?php }?>>라이브</option>
					<?php }?>
                    <option value="22" <?php if($TPL_VAR["last_special_code"]=="22"){?> selected <?php }?>>가상축구</option>
					<option value="5" <?php if($TPL_VAR["last_special_code"]=="5"){?> selected <?php }?>>사다리</option>
					<option value="6" <?php if($TPL_VAR["last_special_code"]=="6"){?> selected <?php }?>>달팽이</option>
					<option value="7" <?php if($TPL_VAR["last_special_code"]=="7"){?> selected <?php }?>>파워볼</option>
					<option value="8" <?php if($TPL_VAR["last_special_code"]=="8"){?> selected <?php }?>>다리다리</option>
                    <option value="24" <?php if($TPL_VAR["last_special_code"]==24){?> selected <?php }?>>키노사다리</option>
                    <option value="25" <?php if($TPL_VAR["last_special_code"]==25){?> selected <?php }?>>파워사다리</option>
                    <option value="28" <?php if($TPL_VAR["last_special_code"]==28){?> selected <?php }?>>로하이</option>
                    <option value="29" <?php if($TPL_VAR["last_special_code"]==29){?> selected <?php }?>>알라딘</option>
                    <option value="30" <?php if($TPL_VAR["last_special_code"]==30){?> selected <?php }?>>이다리</option>
                    <option value="31" <?php if($TPL_VAR["last_special_code"]==31){?> selected <?php }?>>삼다리</option>
                    <option value="32" <?php if($TPL_VAR["last_special_code"]==32){?> selected <?php }?>>초이스</option>
                    <option value="33" <?php if($TPL_VAR["last_special_code"]==33){?> selected <?php }?>>룰렛</option>
                    <option value="34" <?php if($TPL_VAR["last_special_code"]==34){?> selected <?php }?>>파라오</option>
                    <option value="21" <?php if($TPL_VAR["last_special_code"]==21){?> selected <?php }?>>나인</option>
                    <option value="26" <?php if($TPL_VAR["last_special_code"]==26){?> selected <?php }?>>MGM홀짝</option>
                    <option value="27" <?php if($TPL_VAR["last_special_code"]==27){?> selected <?php }?>>MGM바카라</option>
				</select>
				<select id="sel_result" name="sel_result">
					<option value="9">전체</option>
					<option value="1" <?php if($TPL_VAR["sel_result"]=="1"){?> selected <?php }?>>당첨</option>
					<option value="2" <?php if($TPL_VAR["sel_result"]=="2"){?> selected <?php }?>>낙첨</option>
					<option value="0" <?php if($TPL_VAR["sel_result"]=="0"){?> selected <?php }?>>배팅중</option>
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
			if ( $TPL_V2["special"] == 5 ) echo "<li id='{$icon_id}' {$resultClass}>S</li>";
			else if ( $TPL_V2["special"] == 7 ) echo "<li id='{$icon_id}' {$resultClass}>P</li>";
			else if ( $TPL_V2["special"] == 27 ) echo "<li id='{$icon_id}' {$resultClass}>B</li>";
			else if ( $TPL_V2["special"] == 8 ) echo "<li id='{$icon_id}' {$resultClass}>D</li>";
			else if ( $TPL_V2["special"] == 6 ) echo "<li id='{$icon_id}' {$resultClass}>R</li>";
			else if ( $TPL_V2["special"] == 25 ) echo "<li id='{$icon_id}' {$resultClass}>PS</li>";
			else if ( $TPL_V2["special"] == 24 ) echo "<li id='{$icon_id}' {$resultClass}>K</li>";
			else if ( $TPL_V2["special"] < 5 ) echo "<li id='{$icon_id}' {$resultClass}>{$TPL_V2["mid"]}</li>";

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
			<?php }else{?>배팅중
			<?php }?>
				</td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" id="<?php echo $TPL_V1["betting_no"]?>_result_amt"><?php echo number_format($TPL_V1["result_money"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["regDate"]?><?php echo $TPL_V1["regdate"]?></td> 
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["rec_id"]?><?php echo $TPL_V1["partner_id"]?></td>
				<td>
				<?php if($TPL_VAR["membervip"] != "1"){?>
				<input type="button" value="취소"  class="btnStyle3" onClick="go_delete('/game/betcancelProcess?betting_no=<?php echo $TPL_V1["betting_no"]?>&amp;result=<?php echo $TPL_V2["result"];?>&amp;oper=race&amp;check_date=<?php echo sprintf("%s %s:%s",$TPL_V1["item"][0]["gameDate"],$TPL_V1["item"][0]["gameHour"],$TPL_V1["item"][0]["gameTime"])?>')">
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
							<th>총 배팅액</th>
							<th>스코어</th>
							<th>결과</th>
							<th>상태</th>
							<th>처리</th>
						</tr>
					<?php
						if ( $TPL_item_2 ) {
							foreach ( $TPL_V1["item"] as $TPL_V2 ) {
								//-> 팀명 경기종류 적용
								if ( $TPL_V2["mfamily"] == 7 ){
									$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
									$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
								} else if ( $TPL_V2["mfamily"] == 8 ) {
									$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
									$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
									//unset($homeTeamNameAdd);
									//unset($awayTeamNameAdd);
								} else {
									unset($homeTeamNameAdd);
									unset($awayTeamNameAdd);
								}
					?>
							<tr bgcolor="#ede8e8" border=1>				
								<td width="60" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
								<?php
									$pieces = explode("|", $TPL_V2["mname_ko"]);
                                    switch($TPL_V2["sport_id"]) {
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
								<td width="80" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["g_date"]?><?php echo sprintf("%s/ %s %s:%s",substr($TPL_V2["gameDate"],5,2),substr($TPL_V2["gameDate"],8,2),$TPL_V2["gameHour"],$TPL_V2["gameTime"])?></td>
								<td width="100" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["league_name"]?></td>
								<td width="100" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==1){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["home_team"].$homeTeamNameAdd?></td>
								<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==1){?>;background :#fff111<?php }?>">
							<?php 	
								if ( $TPL_V2["select_no"] == 1 and $TPL_V2["game_home_rate"] != $TPL_V2["select_rate"] ) 
									echo $TPL_V2["home_rate"]." <span style='color:red;'>[<b>".$TPL_V2["game_home_rate"]."</b>]</span>";
								else 
									echo $TPL_V2["home_rate"]; 
							?>
								</td>
								<td width="60" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==3){?>;background :#fff111<?php }?>">
									<?php 
										switch($TPL_V2["mfamily"]) {
											case 1:
												if ( $TPL_V2["select_no"] == 3 and $TPL_V2["game_draw_rate"] != $TPL_V2["select_rate"] ) 
													echo $TPL_V2["draw_rate"]." <span style='color:red;'>[<b>".$TPL_V2["game_draw_rate"]."</b>]</span>";
												else 
													echo $TPL_V2["draw_rate"]; 
												break;
											case 2:
												echo "VS";
												break;
											case 7:
												echo $TPL_V2["home_line"];
												break;
											case 8:
												$home_line = explode(" ", $TPL_V2["home_line"]);
												echo $home_line[0];
												break;
											case 10:
												echo "VS";
												break;
											case 11:
												echo $TPL_V2["home_name"];
												break;
											case 12:
												echo $TPL_V2["draw_rate"];
												break;
											case 47:
												echo $TPL_V2["home_line"];
												break;
										}
										
									?>
								</td>
								<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==2){?>;background :#fff111<?php }?>">
							<?php
								if ( $TPL_V2["select_no"] == 2 and $TPL_V2["game_away_rate"] != $TPL_V2["select_rate"] ) 
									echo $TPL_V2["away_rate"]." <span style='color:red;'>[<b>".$TPL_V2["game_away_rate"]."</b>]</span>";
								else 
									echo $TPL_V2["away_rate"];
							?>
								</td>
								<td width="100" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==2){?>;background :#fff111<?php }?>"><?php echo $awayTeamNameAdd . $TPL_V2["away_team"]?></td>
								<td width="40" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
								<?php
									$selectedTeam = "";
									switch($TPL_V2["mfamily"]) {
										case 1:
										case 2:
											if($TPL_V2["select_no"] == "1")
												$selectedTeam = '홈팀';
											else if($TPL_V2["select_no"] == "2") 
												$selectedTeam = '원정팀';                       
											else if($TPL_V2["select_no"] == "3")                        
												$selectedTeam = '무승부'; 
											break;
										case 7:
											if($TPL_V2["select_no"] == "1") {
												$selectedTeam = '언더 <span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											} else if($TPL_V2["select_no"] == "2") {
												$selectedTeam = '오버 <span class="txt_co6">(' . $TPL_V2["away_line"] . ')</span>'; 
											}
											break;
										case 8:
											if($TPL_V2["select_no"] == "1") {
												$home_line = explode(" ", $TPL_V2["home_line"]);
												$selectedTeam = $TPL_V2["home_team"] . '<span class="txt_co6">(' . $home_line[0] . ')</span>';
											} else if($TPL_V2["select_no"] == "2") {
												$away_line = explode(" ", $TPL_V2["away_line"]);
												$selectedTeam = $TPL_V2["away_team"] . '<span class="txt_co6">(' . $away_line[0] . ')</span>'; 
											}
											break;
										case 10:
											if($TPL_V2["select_no"] == "1")
												$selectedTeam = '홀수';
											else if($TPL_V2["select_no"] == "2") 
												$selectedTeam = '짝수'; 
											break;
										case 11:
											$selectedTeam = $TPL_V2["home_name"];
											break;
										case 12:
											if($TPL_V2["select_no"] == "1")
												$selectedTeam = '승무';
											else if($TPL_V2["select_no"] == "2") 
												$selectedTeam = '무패';                       
											else if($TPL_V2["select_no"] == "3")                        
												$selectedTeam = '승패'; 
											break;
										case 47:
											if($TPL_V2["home_name"] == "1 And Under")
												$selectedTeam = '홈승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											else if($TPL_V2["home_name"] == "1 And Over") 
												$selectedTeam = '홈승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';                       
											else if($TPL_V2["home_name"] == "2 And Under")                        
												$selectedTeam = '원정승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>'; 
											else if($TPL_V2["home_name"] == "2 And Over")
												$selectedTeam = '원정승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											else if($TPL_V2["home_name"] == "3 And Under")
												$selectedTeam = '무 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											else if($TPL_V2["home_name"] == "3 And Over")
												$selectedTeam = '무 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											break;
									}
									echo $selectedTeam;
								?>
								</td>
								<td width="40" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["select_rate"];?></td>
								<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666"><a href="javascript:open_window('/member/popup_bet_detail?idx=<?php echo $TPL_V2["sub_child_sn"]?>',600,400)"><?=number_format($TPL_V2["nTotalBetMoney"],0)?></a></td>
								<td width="40" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666" id="<?php echo $TPL_V1["betting_no"].'_'.$TPL_V2["total_betting_sn"]?>_score">
								<?php 
									if($TPL_V2["live"] == 1)
										echo $TPL_V2["score"];
									else 
										echo $TPL_V2["home_score"] . "-" . $TPL_V2["away_score"];
								?>
								</td>
								<td width="50" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666" id="<?php echo $TPL_V1["betting_no"].'_'.$TPL_V2["total_betting_sn"]?>_result">
							<?php if($TPL_V2["win"]==1){?>[홈승]
							<?php }elseif($TPL_V2["win"]==3){?>[무승부]
							<?php }elseif($TPL_V2["win"]==2){?>[원정승]
							<?php }elseif($TPL_V2["win"]==4){?>[취소]
							<?php }else{?>[대기]
							<?php }?>
								</td>
								<td width="65" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666" id="<?php echo $TPL_V1["betting_no"].'_'.$TPL_V2["total_betting_sn"]?>_status">
							<?php if($TPL_V2["result"]==0){?><font color=#666666>배팅중</font>
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
							<?php }
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