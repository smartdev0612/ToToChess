<?php /* Template_ 2.2.3 2012/10/06 21:01:15 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.member.del.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="wrap" id="members">

	<div id="route">
		<h5>관리자 시스템 > 회원 관리 > <b>탈퇴신청</b></h5>
	</div>

	<h3>탈퇴신청</h3>

	<div id="table_sort">
		<form action="?act=pay_list" method="GET" name="form3" id="form3">
			<input type="hidden" name="username" value="<?=$nname?>">
			<span class="icon">출력</span>
			<input name="perpage" type="text" id="perpage" class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" value="<?php echo $TPL_VAR["perpage"]?>" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/\D/g,''))">
			<input type="image" name="Submitok" src="/img/btn_s_sort.gif" class="imgType" title="정렬"/>
		</form>
	</div>
 
	<form id="form1" name="form1" method="post" action="?act=delete">
		<table cellspacing="1" class="tableStyle_members" summary="탈퇴신청 목록">
			<legend class="blind">탈퇴신청</legend>
			<thead>
				<tr>
					<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></td>
					<th scope="col">아이디</td>
					<th scope="col">닉네임</td>
					<th scope="col">등급</td>
					<th scope="col">입금횟수</td>
					<th scope="col">보유금액</td>
					<th scope="col">출금횟수</td>
					<th scope="col">탈퇴원인</td>
					<th scope="col">연계전화</td>
					<th scope="col">이메일</td>
					<th scope="col">처리</td>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
					<tr style="padding-left:1px;">
						<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["idx"]?>"  onclick="javascript:chkRow(this);"/></td>
						<td><?php echo $TPL_V1["mem_id"]?></td>
						<td><?php echo $TPL_V1["nick"]?></td>
						<td><?php echo $TPL_VAR["arr_mem_lev"][$TPL_V1["mem_lev"]]?></td>
						<td><?php echo $TPL_V1["rechargenum"]?></td>
						<td><?php echo $TPL_V1["g_money"]?></td>
						<td><?php echo $TPL_V1["changenum"]?></td>
						<td><?php echo $TPL_V1["quit_reason"]?></td>
						<td><?php echo $TPL_V1["phone"]?></td>
						<td><?php echo $TPL_V1["email"]?></td>
						<td><a onclick="comfire_ok(<?=$idx?>,'user_quit.php?act=deleteone&idx=')"><img src="/img/btn_s_confirm2.gif" title="승인"></a></td>
					</tr>
<?php }}?>
			</tbody>
		</table>
		
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
		
		<div id="wrap_btn">
			<p class="left">
			  <input type="button" name="open" value="삭  제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
			</p>
	    </div>
		<span id="op1"></span>
	</form>

	<div id="tis" style="display: none">
		<div style="width:480px; height:80px;">
			<div style="width:480px; background-color: #F9FCFD; height:25px;" onmouseover="Drag(this)"   onmousedown="StartDrag(this)" onmouseup="StopDrag(this)">
				<div style="height:25px; width:25px; float:right; cursor:pointer">
					<img src="../images/close.gif" width="25" height="25"  onclick="closeLayer()"/>
				</div>
				<div class="clear"></div>
			</div>
		  	<table width="470" height="10" border="0" align="center" cellpadding="0" cellspacing="0" >
				<tr>
			  		<td height="30">&nbsp;</td>
			  		<td height="30" align="center"><strong  style="color:#0066CC; font-size:12px;">정말로 삭제하시겠습니까?</strong></td>
				</tr>	 
		  	</table>
		  	<table width="350" border="0" align="center" cellpadding="0" cellspacing="0" >
				<tr>
			  		<td height="60" colspan="2" align="center" style="border-top: 1px #A3C7DA solid;"><input type="button" name="delete" value="삭   제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isCheck()"/>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" name="revocation" value="취  소" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="closeLayer()"/></td>
			  	</tr>
	  		</table>
		</div>
	</div>
</div>