<?php /* Template_ 2.2.3 2014/03/19 17:00:06 D:\www_kd_20140905\vhost.manager\_template\content\pinnacle\betting_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '라이브-배팅현황';</script>

<script language="JavaScript">
		
	function on_change()
	{
		document.form3.submit();
	}
	function go_delete(url)
	{
		if(confirm("정말 삭제하시겠습니까?  "))
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
	
	function betting_exception(sn)
	{
		if(confirm("[적특] 처리하시겠습니까?"))
		{
			document.location = "/LiveGame/betting_exception?betting_sn="+sn;
		}
	}
</script>

</head>

<body>

<div class="wrap">
	<div id="route">
		<h5>관리자 시스템 > 라이브 > <b>배팅현황</b></h5>
	</div>

	<h3>배팅현황</h3>

	<div id="search">
		<form action="?" method="GET" name="form3" id="form3">
			<div class="wrap">
				<input type="hidden" name="act" value="search">
				<span class="icon">출력</span>
			  <input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
			  &nbsp;&nbsp;&nbsp;&nbsp;
			  <!--검색-->
				<span>검색</span>
				<select id="filter_betting_result" name="filter_betting_result">
					<option value="">전체</option>
					<option value="WIN" <?php if($TPL_VAR["filter_betting_result"]=="WIN"){?> selected <?php }?>>당첨</option>
					<option value="LOS" <?php if($TPL_VAR["filter_betting_result"]=="LOS"){?> selected <?php }?>>낙첨</option>
					<option value="-1" <?php if($TPL_VAR["filter_betting_result"]=="-1"){?> selected <?php }?>>경기중</option>
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
				<input type='hidden' name='act' value='search'>
			</div>
			<div class="wrapRight">
				<span>총배팅액 : <font color=blue><?php echo number_format($TPL_VAR["sumList"]["betting_money"],0)?>원</font> (<?php echo $TPL_VAR["sumList"]["count"]?>)건</span> 
				<span>당첨금 : <font color=blue><?php echo number_format($TPL_VAR["sumList"]["prize"],0)?>원</font></span>
				<span>수익 : <font color="blue"><?php echo number_format($TPL_VAR["sumList"]["betting_money"]-$TPL_VAR["sumList"]["prize"],0)?>원</font></span>
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
				<th>배팅금액</th>
				<th>배당율</th>
				<th>예상배당</th>
				<th>게임결과</th>
				<th>당첨금액</th>					
				<th>배팅날짜</th>
				<!--
				<th>배팅취소</th>
				-->
				<th>배팅IP</th>
			</tr>
		</thead>
		<tbody>

<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr id="t_<?php echo $TPL_V1["betting_no"]?>" class="gameGoing" >
				<td><?php echo $TPL_V1["logo"];?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["betting_no"]?></td>			    
				<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></a></td>					
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["nick"]?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format($TPL_V1["betting_money"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo bcmul($TPL_V1["odd"],1,2)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format(bcmul($TPL_V1["betting_money"],bcmul($TPL_V1["odd"],1,2),0),0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')">
<?php if($TPL_V1["betting_result"]=='WIN'){?><font color=red>적  중</font>
<?php }elseif($TPL_V1["betting_result"]=='LOS'){?>실  패
<?php }elseif($TPL_V1["betting_result"]=='CANCEL'){?>적  특
<?php }elseif($TPL_V1["betting_result"]=='-1'){?>경기중
<?php }?>
				</td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo number_format($TPL_V1["prize"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"><?php echo $TPL_V1["reg_time"]?></td> 
				
				<td><?php echo $TPL_V1["ip"]?></td>
			</tr>
			<tr id="d_<?php echo $TPL_V1["betting_no"]?>" <?php if($TPL_VAR["show_detail"]==0){?>style="display:none;"<?php }?> class="gameDetail">
				<td colspan="13">
					<table cellspacing="1" id="d_<?php echo $TPL_V1["betting_no"]?>">
						<tr>				  
							<th>게임타입</th>
							<th>경기시간</th>
							<th>리그</th>
							<th>홈팀</th>
							<th>원정팀</th>
							<th>점수</th>
							<th>베팅</th>
							<th>상태</th>
							<th>적특</th>
						</tr>
						
						<tr bgcolor="#ede8e8" border=1>				
							<td width="60" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
								<?php echo $TPL_V1["template_alias"]?>

							</td>
							<td width="80" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["start_time"]?></td>
							<td width="100" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["league_name"]?></td>
							
							<td width="100" align="" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["home_team"]?></td>
							<td width="100" align="" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["away_team"]?></td>
							
							<td width="40" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["view_score"]?></td>
							<td width="50" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php if($TPL_V1["betting_position"]=='1'){?>홈팀
<?php }elseif($TPL_V1["betting_position"]=='2'){?>원정팀
<?php }elseif($TPL_V1["betting_position"]=='X'){?>무
<?php }else{?><?php echo $TPL_V1["betting_position"]?>

<?php }?>
									
							</td>
							<td width="65" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php if($TPL_V1["betting_result"]=='WIN'){?><font color=red>적  중</font>
<?php }elseif($TPL_V1["betting_result"]=='LOS'){?>실  패
<?php }elseif($TPL_V1["betting_result"]=='CANCEL'){?>적  특
<?php }elseif($TPL_V1["betting_result"]=='-1'){?>경기중
<?php }?>
							</td>
							<td width="30"><input type="button" value="적특"  class="btnStyle3" onClick="betting_exception(<?php echo $TPL_V1["sn"]?>);"></td>
						</tr>															
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