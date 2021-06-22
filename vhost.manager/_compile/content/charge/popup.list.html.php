<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
</head>
	
<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>입금 내역</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<table cellspacing="1" class="tableStyle_normal" summary="입금 내역">
	<legend class="blind">회원목록</legend>
	<thead>
		<tr>
		  <th>신청시간</th>
		  <th>처리시간</th>
		  <th>아이디</th>
		  <th>닉네임</th>
		  <th>당시금액</th>
		  <th>보유금액</th>
		  <th>신청금액</th>
		  <th>실입금액</th>
		  <th>입금자명</th>
		  <th>파트너</th>
		  <th>상태</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr class="link_lan" style="padding-left:1px;"  onMouseOver="this.style.backgroundColor='#e0eafe';" onMouseOut="this.style.backgroundColor=''" >
				<td><?php echo $TPL_V1["regdate"]?></td>        
				<td><?php echo $TPL_V1["operdate"]?></td>
				<td><?php echo $TPL_V1["uid"]?></td>
				<td><?php echo $TPL_V1["nick"]?></td>
				<td><?php echo number_format($TPL_V1["before_money"],0)?></td>
				<td><?php echo number_format($TPL_V1["g_money"],0)?></td>
				<td><?php echo number_format($TPL_V1["amount"],0)?></td>
				<td><?php echo number_format($TPL_V1["agree_amount"],0)?></td>
				<td><?php echo $TPL_V1["bank_owner"]?></td>
				<td><?php echo $TPL_V1["recommendId"]?></td>
				<td>
<?php if($TPL_V1["state"]==0){?>
						<font color='red'>신청</font>
<?php }elseif($TPL_V1["state"]==1){?>
						<font color='blue'>완료</font>
<?php }else{?>
						<font color='yellow'>삭제</font>
<?php }?>
				</td>
		  	</tr>
<?php }}?>
	</tbody>
	</table>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>

	<div id="search">
		<div class="wrap">
			<form action="?" method="get" name="form2" id="form2">
			<select name="seldate">
				<option value="regdate" <?php if($TPL_VAR["seldate"]=="regdate"){?> selected <?php }?>>신청시간</option>
				<option value="operdate" <?php if($TPL_VAR["seldate"]=="operdate"){?> selected <?php }?>>처리시간 </option>
			</select>	
			<span class="icon">날짜</span>
			<input name="date_id" type="text" id="date_id" value="<?php echo $TPL_VAR["date_id"]?>" maxlength="20" class="date" onclick="new Calendar().show(this);" /> ~ 
			<input name="date_id1" type="text" id="date_id1" value="<?php echo $TPL_VAR["date_id1"]?>" maxlength="20" class="date" onclick="new Calendar().show(this);">
			<select name="field">
				<option value="mem_id" 	<?php if($TPL_VAR["field"]=="mem_id"){?> selected <?php }?>>아이디</option>
				<option value="nick"  	<?php if($TPL_VAR["field"]=="nick"){?> 	selected <?php }?>>닉네임</option>
				<option value="rec_id"  <?php if($TPL_VAR["field"]=="rec_id"){?>	selected <?php }?>>파트너</option>
				<option value="a_name"  <?php if($TPL_VAR["field"]=="a_name"){?>	selected <?php }?>>입금자명</option>
			</select>
            <input name="mem_id" type="text" id="key" class="name" maxlength="20" value="<?php echo $TPL_VAR["uid"]?>"/>
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
          </form>
		</div>
	</div>

</div>

</body>
</html>