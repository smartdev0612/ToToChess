<?php /* Template_ 2.2.3 2014/07/01 00:05:06 D:\www_one-23.com\vhost.manager\_template\content\game\bet_cancel_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '게임관리-배팅현황';</script>

<script language="JavaScript">
		
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
	
	function onExceptionBetClick(sn)
	{
		if(confirm("[적특] 처리하시겠습니까?"))
		{
			document.location = "/game/exceptionBetProcess?sn="+sn;
		}
	}
</script>

</head>

<body>

<div class="wrap">
	<div id="route">
		<h5>관리자 시스템 > 게임 관리 > 게임설정 > <b>배팅현황</b></h5>
	</div>

	<h3>배팅취소현황</h3>
	<div id="search">
		<form action="?" method="GET" name="form3" id="form3">
			<div class="wrap">
				<input type="hidden" name="mode" value="search">
				<span class="icon">출력</span>
			  <input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
			  &nbsp;&nbsp;&nbsp;&nbsp;
			  <!--검색-->
				<span>검색</span>
				<!-- 기간 필터 -->
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<select id="sel_result" name="sel_result">
					<option value="9">전체</option>
					<option value="1" <?php if($TPL_VAR["sel_result"]=="1"){?> selected <?php }?>>당첨</option>
					<option value="2" <?php if($TPL_VAR["sel_result"]=="2"){?> selected <?php }?>>낙첨</option>
					<option value="0" <?php if($TPL_VAR["sel_result"]=="0"){?> selected <?php }?>>경기중</option>
				</select>
				<select name="select_keyword" onChange="onKeywordChange(this.form)">
					<option value="" 	<?php if($TPL_VAR["select_keyword"]==''){?>  selected <?php }?>>전체</option>
					<option value="uid" <?php if($TPL_VAR["select_keyword"]=='uid'){?>  selected <?php }?>>아이디</option>
					<option value="nick"<?php if($TPL_VAR["select_keyword"]=='nick'){?>  selected <?php }?>>닉네임</option>
					<option value="betting_no"<?php if($TPL_VAR["select_keyword"]=='betting_no'){?>  selected <?php }?>>배팅번호</option>
				</select>
				<input type="text" name="keyword" value=<?php echo $TPL_VAR["keyword"]?>>
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
				<th>예상당첨금</th>
				<th>게임결과</th>
				<th>배팅날짜</th>
				<th>취소날짜</th>
				<th>취소자</th>
				<th>총판</th>
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
				<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,600)"><?php echo $TPL_V1["member"]["uid"]?></a></td>					
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["member"]["nick"]?></td>				    
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["win_count"]?>/<?php echo $TPL_V1["betting_cnt"]?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format($TPL_V1["betting_money"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["result_rate"]?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format($TPL_V1["result_rate"]*$TPL_V1["betting_money"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')">배팅취소</td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["regDate"]?><?php echo $TPL_V1["regdate"]?></td> 
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["regDate"]?><?php echo $TPL_V1["operdate"]?></td> 
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["cancel_by"]?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["rec_id"]?><?php echo $TPL_V1["partner_id"]?></td>
				<td><?php echo $TPL_V1["betting_ip"]?></td>
			</tr>
			<tr id="d_<?php echo $TPL_V1["betting_no"]?>" <?php if($TPL_VAR["show_detail"]==0){?>style="display:none;"<?php }?> class="gameDetail">
				<td colspan="14">
					<table cellspacing="1" id="d_<?php echo $TPL_V1["betting_no"]?>">
						<tr>				  
							<th>게임타입</th>
							<th>경기시간</th>
							<th>리그</th>
							<th colspan="2">홈팀</th>
							<th>무</th>
							<th colspan="2">원정팀</th>
							<th>배팅방향</th>
							<th>배팅배당</th> 
							<th>상태</th>
						</tr>
<?php if($TPL_item_2){foreach($TPL_V1["item"] as $TPL_V2){?>
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
								<td width="80" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==1){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["home_team"]?></td>
								<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==1){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["home_rate"]?></td>
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
											case 9:
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
								<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==2){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["away_rate"]?></td>
								<td width="80" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==2){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["away_team"]?></td>
								<td width="50" align="">
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
										case 9:
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
											else if($TPL_V2["select_no"] == "3") 
												$selectedTeam = '무패';                       
											else if($TPL_V2["select_no"] == "2")                        
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
											else if($TPL_V2["home_name"] == "X And Under")
												$selectedTeam = '무 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											else if($TPL_V2["home_name"] == "X And Over")
												$selectedTeam = '무 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											break;
									}
									echo $selectedTeam;
								?>
								</td>
								<td width="30" align="center"><?php echo $TPL_V2["select_rate"];?></td>
								<td width="50" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">배팅취소</td>
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