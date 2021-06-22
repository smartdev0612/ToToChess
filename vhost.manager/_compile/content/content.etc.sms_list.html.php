<?php /* Template_ 2.2.3 2012/10/05 20:24:41 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.etc.sms_list.html */
$TPL_smsList_1=empty($TPL_VAR["smsList"])||!is_array($TPL_VAR["smsList"])?0:count($TPL_VAR["smsList"]);?>
<div class="wrap" id="members">
	<div id="route">
		<h5>관리자 시스템 > 회원관리 > <b>인증문자 보내기</b></h5>
	</div>

	<h3>인증문자 전송 목록</h3>

	<form id="form1" name="form1" method="post" action="?act=del">
	<table cellspacing="1" class="tableStyle_members add" summary="인증문자 전송 목록">
	<legend class="blind">인증문자 전송 목록</legend>
	<thead>
	<tr>
	  <th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
	  <th scope="col">핸드폰</th>
	  <th scope="col">인증코드</th>
	  <th scope="col">시간</th>
	  <th scope="col">아이피</th>
	  <th scope="col">상태</th>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_smsList_1){foreach($TPL_VAR["smsList"] as $TPL_V1){?>
		<tr bgcolor=<?php if($TPL_V1["ckip"]>0){?>"#e8e620" <?php }else{?> "#f6f6f6"<?php }?> >
		   <td><input name="y_id[]" type="checkbox" id="y_id"  value="<?php echo $TPL_V1["id"]?>" onclick="javascript:chkRow(this);"/></td>
			<td><?php echo $TPL_V1["phone"]?></td>
			<td><?php echo $TPL_V1["code"]?></td>
			<td><?php echo $TPL_V1["time"]?></td>
			<td>[<?php echo $TPL_V1["country_code"]?>]<?php echo $TPL_V1["ip"]?></td>
			<td><?php if($TPL_V1["status"]==0){?>
					<font color="red"><a href="?act=send&phone=<?php echo $TPL_V1["phone"]?>&code=<?php echo $TPL_V1["code"]?>&id=<?php echo $TPL_V1["id"]?>">[미발송]</a></font>
<?php }else{?>
					<a href="?act=send&phone=<?php echo $TPL_V1["phone"]?>&code=<?php echo $TPL_V1["code"]?>&id=<?php echo $TPL_V1["id"]?>">[발송]</a>"}
<?php }?>
				
<?php if($TPL_V1["ckip"]>0){?>
					<a href="javascript:void(0)" onclick="todo('?act=remove&ip=<?php echo $TPL_V1["ip"]?>');">[IP해제]</a>
<?php }else{?>
					<a href="javascript:void(0)" onclick="todo('?act=block&ip=<?php echo $TPL_V1["ip"]?>');">[IP차단]</a>
<?php }?>
			</td>
	  </tr>
<?php }}?>
	</tbody>
	</table>

	<div id="pages2">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
	<div id="wrap_btn">
		<input type="button" name="open" value="삭  제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
	</div>
	</form>
</div>