<?php /* Template_ 2.2.3 2012/10/09 18:30:08 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\popup.member.exchange_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
</head>

<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>출금 내역</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<table cellspacing="1" class="tableStyle_normal" summary="출금 내역">
	<legend class="blind">출금 내역</legend>
	<thead>
		<tr>
		  <th>신청시간</th>
		  <th>처리시간</th>
		  <th>아이디</th>
		  <th>닉네임</th>
		  <th>당시금액</th>
		  <th>보유금액</th>
		  <th>출금금액</th>
		  <th>보너스</th>
		  <th>실입금액</th>
		  <th>계좌번호</th>
		  <th>예금주</th>
		  <th>파트너</th>
		  <th>상태</th>
		</tr>
	</head>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["regdate"]?></td>        
				<td><?php echo $TPL_V1["operdate"]?></td>
				<td><?php echo $TPL_V1["mem_id"]?></td>
				<td><?php echo $TPL_V1["nick"]?></td>
				<td><?php echo $TPL_V1["beforemoney"]?></td>
				<td><?php echo $TPL_V1["g_money"]?></td>
				<td><?php echo $TPL_V1["amount"]?></td>
				<td><?php echo $TPL_V1["bonus"]?></td>
				<td><?php echo $TPL_V1["bank"]?></td>
				<td><?php echo $TPL_V1["account"]?></td>
				<td><?php echo $TPL_V1["a_name"]?></td>
				<td><?php echo $TPL_V1["rec_id"]?></td>
				<td>
<?php if($TPL_V1["result"]==0){?>
						<font color='red'>신청</font>
<?php }elseif($TPL_V1["result"]==1){?>
						<font color='blue'>완료</font>
<?php }else{?>
						<font color='Purple'>대기</font>
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
		<div>
			<form action="?" method="get" name="form2" id="form2">
			<select name="seldate">
				<option value="regdate" <?php if($TPL_VAR["seldate"]=="regdate"){?> selected <?php }?>>신청시간</option>
				<option value="operdate" <?php if($TPL_VAR["seldate"]=="operdate"){?> selected <?php }?>>처리시간 </option>
			</select>	
			<span class="icon">날짜</span>
			<input name="date_id" type="text" id="date_id" value="<?php echo $TPL_VAR["date_id"]?>" maxlength="20" class="date" onclick="new Calendar().show(this);"> ~ <input name="date_id1" type="text" id="date_id1" value="<?php echo $TPL_VAR["date_id1"]?>" maxlength="20" class="date" onclick="new Calendar().show(this);">
			<select name="field">
				<option value="mem_id" 	<?php if($TPL_VAR["field"]=="mem_id"){?> 	selected <?php }?>>아이디</option>
				<option value="nick"  		<?php if($TPL_VAR["field"]=="nick"){?> 		selected <?php }?>>닉네임</option>
				<option value="bank"  	<?php if($TPL_VAR["field"]=="bank"){?> 		selected <?php }?>>은행명</option>
				<option value="account"  	<?php if($TPL_VAR["field"]=="account"){?> 	selected <?php }?>>은행계좌</option>
				<option value="a_name"  	<?php if($TPL_VAR["field"]=="a_name"){?>	selected <?php }?>>예금주</option>
				<option value="rec_id"  	<?php if($TPL_VAR["field"]=="rec_id"){?>		selected <?php }?>>파트너</option>
			</select>
            <input name="mem_id" type="text" id="key" class="name" value="<?php echo $TPL_VAR["id"]?>" maxlength="20"/>
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
          </form>
		</div>
	</div>

</div>

</body>
</html>