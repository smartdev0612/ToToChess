<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script language="JavaScript">
	function betting_exception(detail_sn, betting_position, betting_sn)
	{
		if(confirm("[적특] 처리하시겠습니까?"))
		{
			document.location = "/LiveGame/popup_betting_exception?betting_sn="+betting_sn+"&detail_sn="+detail_sn+"betting_position="+betting_position;
		}
	}
</script>

</head>

<body>

<div class="wrap">
	<!--
	<div id="search">
		<form action="?" method="GET" name="form3" id="form3">
			<input type="hidden" name="child_sn" value="<?php echo $TPL_VAR["child_sn"]?>">
			<input type="hidden" name="select_no" value="<?php echo $TPL_VAR["select_no"]?>">
			<div class="wrap">
				<input type="hidden" name="mode" value="search">
				<span>정렬</span>
				<select name="page_size" onchange="submit()">
					<option value="30"  <?php if($TPL_VAR["perpage"]==30){?>  selected <?php }?>>30</option>
					<option value="50"  <?php if($TPL_VAR["perpage"]==50){?>  selected <?php }?>>50</option>
					<option value="100" <?php if($TPL_VAR["perpage"]==100){?> selected <?php }?>>100</option>
				</select>
				<span>구분</span>
				<select id="sel_result" name="sel_result" onchange="on_change()">
					<option value="9">전체</option>
					<option value="1" <?php if($TPL_VAR["sel_result"]=="1"){?> selected <?php }?>>당첨</option>
					<option value="2" <?php if($TPL_VAR["sel_result"]=="2"){?> selected <?php }?>>낙첨</option>
					<option value="0" <?php if($TPL_VAR["sel_result"]=="0"){?> selected <?php }?>>경기중</option>
				</select>
			</div>
			
			<div class="wrapRight">
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
		</form>
	</div>
	-->
			
  <form id="form1" name="form1" method="post" action="?act=delete_user">
		<table border="0" cellspacing="1" class="tableStyle_gameList" summary="게임별 배팅현황">
		<thead>
			<tr>					
				<th>배팅번호</th>
				<th>아이디</th>
				<th>닉네임</th>
				<th>배팅금액</th>
				<th>배당율</th>
				<th>예상배당</th>
				<th>게임결과</th>
				<th>당첨금액</th>					
				<th>배팅날짜</th>
				<!--<th>배팅취소</th>-->
				<th>배팅IP</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr class="gameGoing">
				<td><?php echo $TPL_V1["betting_no"]?></td>			    
				<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></a></td>					
				<td><?php echo $TPL_V1["nick"]?></td>				    
				<td><?php echo number_format($TPL_V1["betting_money"],0)?></td>
				<td><?php echo $TPL_V1["odd"]?></td>
				<td><?php echo number_format(bcmul($TPL_V1["betting_money"],bcmul($TPL_V1["odd"],1,2),0),0)?></td>
				<td>
<?php if($TPL_V1["betting_result"]=='WIN'){?><font color=red>적  중</font>
<?php }elseif($TPL_V1["betting_result"]=='LOS'){?>실  패
<?php }elseif($TPL_V1["betting_result"]=='CANCEL'){?>적  특
<?php }else{?>경기중
<?php }?>
				</td>
				<td><?php echo number_format($TPL_V1["prize"],0)?></td>
				<td><?php echo $TPL_V1["reg_time"]?></td> 
				<!--<td><input type="button" value="적특"  class="btnStyle3" onClick="betting_exception(<?php echo $TPL_VAR["detail_sn"]?>, <?php echo $TPL_VAR["betting_position"]?>,<?php echo $TPL_V1["betting_sn"]?>)"></td>-->
				<td><?php echo $TPL_V1["ip"]?></td>
			</tr>
<?php }}?>	
		</tbody>
		</table>
		
			
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	</form>
</div>