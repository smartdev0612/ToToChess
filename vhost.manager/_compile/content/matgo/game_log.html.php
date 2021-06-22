<?php /* Template_ 2.2.3 2013/12/03 13:37:38 D:\www\vhost.manager\_template\content\matgo\game_log.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '맞고 게임관리-게임로그';</script>

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
			document.location = "/game/exceptionBetProcess?sn="+sn;
		}
	}
</script>

</head>

<body>

<div class="wrap">
	<div id="route">
		<h5>관리자 시스템 > 게임 관리 > 게임설정 > <b>게임로그</b></h5>
	</div>

	<h3>게임로그</h3>

	<div id="search">
		<form action="?" method="post" name="frm" id="frm">
			<div class="wrap">
				<input type="hidden" name="mode" value="search">
				<input type="hidden" name="page_state" value="<?php echo $TPL_VAR["page_state"]?>">
				<span class="icon">출력</span>
			  <input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<!-- 기간 필터 -->
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				
				<!--
				<span>방번호</span>
				<input type="text" name="room_no" value="<?php echo $TPL_VAR["room_no"]?>" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5">
				-->
				
				<span>검색</span>
				<select name="field">
					<option value="" 	<?php if($TPL_VAR["field"]==''){?>  selected <?php }?>>전체</option>
					<option value="userid" <?php if($TPL_VAR["field"]=='userid'){?>  selected <?php }?>>아이디</option>
				</select>
				
				<input type="text" name="keyword" value=<?php echo $TPL_VAR["keyword"]?>>
				<input name="Submit4" type="submit"  value="검색" class="btnStyle3"/>
			</div>
			
<?php if($TPL_VAR["sess_member_level"]==1){?>
			<div class="wrap">
				<span>총게임수 : <font color=blue><?php echo number_format($TPL_VAR["static_data"]["game_count"],0)?>건</font></span>
				<span>총배팅액 : <font color=blue><?php echo number_format($TPL_VAR["static_data"]["total_betting"],0)?>원</font></span> 
				<span>수수료(<?php echo $TPL_VAR["static_data"]["commission"]?>%) : <font color=blue><?php echo number_format($TPL_VAR["static_data"]["dealer_commission"],0)?>(Rp)</font> <font color='red'><?php echo number_format($TPL_VAR["static_data"]["dealer_commission"]*0.11,0)?>(원)</font></span> 
			</div>
<?php }?>
		
		</form>
	</div>
			
  <form id="form1" name="form1" method="post" action="?act=delete_user">
		<table border="0" cellspacing="1" class="tableStyle_gameList">
		<thead>
			<tr>					
				<th>시작시간</th>
				<th>승자 아이디</th>
				<th>총점</th>
				<th>획득금액</th>
				<th>종료금액</th>
				<th>패자 아이디</th>
				<th>잃은금액</th>
				<th>종료금액</th>
				<th>딜러금액</th>
				<th>비고</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><a href="javascript:open_window('/gameRecord/popup_game_log?room_no=<?php echo $TPL_V1["room_no"]?>&start_time=<?php echo $TPL_V1["dtLogTime"]?>',1800,1024)"><?php echo $TPL_V1["dtLogTime"]?></a></td>
				<td><?php echo $TPL_V1["szWinUserID"]?></td>
				<td><?php echo $TPL_V1["nTotalScore"]?></td>
				<td><?php echo number_format($TPL_V1["nWinAlterMoney"],0)?></td>
				<td><?php echo number_format($TPL_V1["nWinMoney"],0)?></td>
				<td><?php echo $TPL_V1["szLosUserID1"]?></td>
				<td><?php echo number_format($TPL_V1["nLosAlterMoney1"],0)?></td>
				<td><?php echo number_format($TPL_V1["nLosMoney1"],0)?></td>
				<td><?php echo number_format($TPL_V1["nPayMoney"],0)?></td>
				<td></td>
<?php }}?>	
		</tbody>
		</table>
		
			
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	</form>
</div>