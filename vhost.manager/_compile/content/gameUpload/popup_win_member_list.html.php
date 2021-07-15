<?php
$TPL_account_list_1=empty($TPL_VAR["account_list"])||!is_array($TPL_VAR["account_list"])?0:count($TPL_VAR["account_list"]);?>
<script>document.title = '게임관리-배팅현황';</script>

<script language="JavaScript">
		
	function on_change()
	{
		selvalue=document.getElementById("sel_result").value;
		//alert(selvalue);
		url="/gameUpload/betlist?mode=search&sel_result="+selvalue;
		document.location=url;
	}
	
	function go_delete(betting_no)
	{
		if(confirm("정말 삭제하시겠습니까?  "))
		{
			//document.location = url;
			$("#act").val("betting_cancel");
			$("#betting_no").val(betting_no);
			document.form1.submit();
		}
		else
		{
			return;
		}
	}
	
	function onRevoke(url)
	{
		if(confirm("정말 복구하시겠습니까?  "))
		{
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
			document.location = "/gameUpload/exceptionBetProcess?sn="+sn;
		}
	}
	
	function onAccount()
	{
		$("#act").val("account");
		document.form1.submit();
		/*
		opener.league.nationflag.value = imgIdx
		alert (imgName + " 국가를 선택했습니다.")
		window.close();
		*/
	}
</script>

</head>

<body>

<div class="wrap">
	<div id="route">
		<h5>관리자 시스템 > 게임 관리 > 게임설정 > <b>당첨현황</b></h5>
	</div>

	<h3>당첨현황</h3>
<!--
	<div id="search">
		<form action="?" method="GET" name="form3" id="form3">
			<div>
				<input type="hidden" name="account_param" value="<?php echo $TPL_VAR["account_param"]?>">

				<span class="icon">출력</span>
			  <input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<input type="radio" name="show_detail" value=0 <?php if($TPL_VAR["show_detail"]=='0'){?>checked<?php }?> onClick="submit()" class="radio">숨기기
				<input type="radio" name="show_detail" value=1 <?php if($TPL_VAR["show_detail"]=='1'){?>checked<?php }?> onClick="submit()" class="radio">펼치기
				
				<input type='hidden' name='mode' value='search'>
				<span>검색</span>
				<select name="select_keyword" onChange="onKeywordChange(this.form)">
					<option value="" 	<?php if($TPL_VAR["select_keyword"]==''){?>  selected <?php }?>>전체</option>
					<option value="uid" <?php if($TPL_VAR["select_keyword"]=='uid'){?>  selected <?php }?>>아이디</option>
					<option value="nick"<?php if($TPL_VAR["select_keyword"]=='nick'){?>  selected <?php }?>>닉네임</option>
					<option value="betting_no"<?php if($TPL_VAR["select_keyword"]=='betting_no'){?>  selected <?php }?>>배팅번호</option>
				</select>
				<input type="text" name="keyword" value=<?php echo $TPL_VAR["keyword"]?>>
				<input name="Submit4" type="submit"  value="검색" class="btnStyle3"/>
			</div>
			<div class="wrap">
				<span>총배팅액 : <font color=blue><?php echo number_format($TPL_VAR["sumList"]["total_betting"],0)?>원</font></span> 
				<span>배당액 : <font color=blue><?php echo number_format($TPL_VAR["sumList"]["total_result"],0)?>원</font></span>
				<span>정산액 : <font color="blue"><?php echo number_format($TPL_VAR["sumList"]["total_betting"]-$TPL_VAR["sumList"]["total_result"],0)?>원</font></span>
			</div>
		</form>
	</div>
	-->
			
  <form id="form1" name="form1" method="post" action="?">
  	<input type="hidden" name="account_param" value="<?php echo $TPL_VAR["account_param"]?>">
  	<input type="hidden" name="game_sn_list" value="<?php echo $TPL_VAR["game_sn_list"]?>">
  	<input type="hidden" name="param_page_act" value="<?php echo $TPL_VAR["param_page_act"]?>">
  	<input type="hidden" id="act" name="act" value="">
		<table border="0" cellspacing="1" class="tableStyle_gameList" summary="게임별 배팅현황">
		<thead>
			<tr>					
				<th>배팅번호</th>
				<th>아이디</th>
				<th>닉네임</th>
				<th>배팅금액</th>
				<th>배당율</th>
				<th>당첨금액</th>					
				<th>배팅날짜</th>
				<th>배팅IP</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_account_list_1){foreach($TPL_VAR["account_list"] as $TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
				<tr id="t_<?php echo $TPL_V1["betting_no"]?>">
					<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["betting_no"]?></td>			    
					<td><?php echo $TPL_V1["uid"]?></td>
					<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["nick"]?></td>				    
					<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format($TPL_V1["betting_money"],0)?></td>
					<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["result_rate"]?></td>
					<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><font color='blue'><?php echo number_format($TPL_V1["result_rate"]*$TPL_V1["betting_money"],0)?></font></td>
					<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["bet_date"]?></td> 
					<td><?php echo $TPL_V1["betting_ip"]?></td>
				</tr>
				
				<tr id="d_<?php echo $TPL_V1["betting_no"]?>" <?php if($TPL_VAR["show_detail"]==0){?>style="display:none;"<?php }?> class="gameDetail">
					<td colspan="12">
						<table cellspacing="1" id="d_<?php echo $TPL_V1["betting_no"]?>">
							<tr>				  
								<th>게임타입</th>
								<th>경기시간</th>
								<th>종목</th>
								<th>리그</th>
								<th colspan="2" >홈팀</th>
								<th>무</th>
								<th colspan="2">원정팀</th>
								<th>점수</th>
								<th>결과</th>
								<th>상태</th>
								<!--<th width=10>적특</th>-->
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
										}
									?>
									</td>
<?php 
	if ( strtotime($TPL_V1["bet_date"]) >= strtotime($TPL_V2["game_date"]) ) {
		$stopMsg = "<font color='red' style='font-size:24px'>배팅이 경기가 시작된 후 생성되었습니다. 정산하지 말고 관리자에게 문의해주세요.</font>";
?>
									<td width="105" align="center" style="border-bottom:1px #CCCCCC solid;color: #ffffff; background:red;"><?php echo $TPL_V2["game_date"]?></td>
<?php
	} else {
		$stopMsg = "";
?>
									<td width="105" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666;"><?php echo $TPL_V2["game_date"]?></td>
<?php
	}
?>
									<td width="50" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["sport_name"]?></td>
									<td width="100" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["league_name"]?></td>
									<td width="100" align="" style="border-bottom:1px #CCCCCC solid;color: #666666? <?php if($TPL_V2["select_no"]==1){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["home_team"]?></td>
									<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["home_rate"]?></td>
									<td width="60" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==3){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["draw_rate"]?></td>
									<td width="100" align="" style="border-bottom:1px #CCCCCC solid;color: #666666<?php if($TPL_V2["select_no"]==2){?>;background :#fff111<?php }?>"><?php echo $TPL_V2["away_team"]?></td>
									<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["away_rate"]?></td>
									<td width="40" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["home_score"]?>:<?php echo $TPL_V2["away_score"]?></td>
									<td width="50" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
										<font color='green'>
<?php if($TPL_V2["win"]==1){?>홈승
<?php }elseif($TPL_V2["win"]==3){?>무승부
<?php }elseif($TPL_V2["win"]==2){?>원정승
<?php }elseif($TPL_V2["win"]==4){?>취소
<?php }else{?>[대기]
<?php }?>
										</font>
									</td>
									<td width="65" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php if($TPL_V2["result"]==0){?><font color=#666666>경기중</font>
<?php }elseif($TPL_V2["result"]==1){?><font color=red>적중</font>
<?php }elseif($TPL_V2["result"]==2){?><font color=blue>낙첨</font>
<?php }elseif($TPL_V2["result"]==4){?><font color=green>취소</font>
<?php }?>
									</td>
									<!--
									<td><input type="button" value="적특"  class="btnStyle3" onClick="onExceptionBetClick(<?php echo $TPL_V2["total_betting_sn"]?>);"></td>
									-->
								</tr>															
<?php }}?>
							</table>
					</td>
				</tr>
						
<?php }}?> <!-- end of account_list loop -->
	
		</tbody>
		</table>
		
		<div id="wrap_btn">
			<input type="button" name="box" value="정산" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="onAccount();">
			<input type="button" name="box" value="취소" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="self.close();">
		</div>
	</form>
</div>