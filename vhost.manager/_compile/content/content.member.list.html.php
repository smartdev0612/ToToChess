<?php /* Template_ 2.2.3 2012/10/10 13:07:30 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.member.list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="wrap" id="members">

	<div id="route">
		<h5>관리자 시스템 > 회원 관리 > <b>회원목록</b></h5>
	</div>

	<h3>회원목록</h3>

	<div id="search">
		<div>
			<form action="?" method="get" name="form2" id="form2">
			<input type="hidden" name="perpage" value="<?=$perpage?>">
			<select name="field">
				<option value="mem_id" 	<?php if($TPL_VAR["field"]=="mem_id"){?>		selected <?php }?>>아이디</option>
				<option value="nick"  	<?php if($TPL_VAR["field"]=="nick"){?>		selected <?php }?>>닉네임</option>
				<option value="name"  	<?php if($TPL_VAR["field"]=="name"){?> 		selected <?php }?>>이름</option>
				<option value="partner" <?php if($TPL_VAR["field"]=="partner"){?> 	selected <?php }?>>파트너</option>
				<option value="reg_ip"  <?php if($TPL_VAR["field"]=="reg_ip"){?>	selected <?php }?>>가입IP</option>
				<option value="g_money" <?php if($TPL_VAR["field"]=="g_money"){?>	selected <?php }?>>보유금액xx원이상검색</option>
				<option value="rechargenum" <?php if($TPL_VAR["field"]=="rechargenum"){?> selected <?php }?>>충전회수xx회이상검색</option>
				<option value="mem_lev" <?php if($TPL_VAR["field"]=="mem_lev"){?>	selected <?php }?>>회원등급</option>
				<option value="bank_member" <?php if($TPL_VAR["field"]=="bank_member"){?> selected <?php }?>>예금주</option>
			</select>
            <input name="username" type="text" id="key" class="name" value="<?=$str?>" maxlength="20" onmouseover="this.focus()"/>
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
          </form>
		</div>
	</div>
	<div id="table_sort">
		<form action="?" method="GET" name="form3" id="form3">
		<span class="icon">출력</span><input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()"><input type="image" name="Submitok" src="/img/btn_s_sort.gif" class="imgType" title="정렬"/>
		</form>
	</div>

	<form id="form1" name="form1" method="post" action="?">
	<input type="hidden" id="act" name="act" value="delete">
	
	<table cellspacing="1" class="tableStyle_members" summary="회원목록">
	<legend class="blind">회원목록</legend>
	<thead>
    <tr>
		<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
		<th scope="col" class="id" id="user_idx">아이디</th><!--ID-->
		<th scope="col">닉네임</th>
		<th scope="col">이름</th>
		<th scope="col">보유금액</th>
		<th scope="col">등급</th>
		<th scope="col">그룹</th>
		<th scope="col">입금</th>
		<th scope="col">출금</th>
		<th scope="col">배팅</th>
		<th scope="col">쪽지</th>
		<th scope="col">상태</th>
		<th scope="col">가입일</th>
		<th scope="col">가입IP</th>
		<th scope="col">파트너</th>
    </tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr <?php echo $TPL_V1["bgcolor"]?>>
				<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["idx"]?>"  onclick="javascript:chkRow(this);"/></td>
				<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["idx"]?>',1024,600)"><?php echo $TPL_V1["mem_id"]?></a></td>        
				<td><?php echo $TPL_V1["nick"]?></td>
				<td><?php echo $TPL_V1["name"]?></td>
				<td>
<?php if(strpos($TPL_VAR["quanxian"],"1001")>=0){?>
						<a href="javascript:open_window('user_money_change.php?idx=<?php echo $TPL_V1["idx"]?>&act=money',400,250)"><?php echo number_format($TPL_V1["g_money"],0)?></a>
<?php }else{?>
						<?php echo number_format($TPL_V1["g_money"],0)?>

<?php }?>
				</td>
				<td><?php echo $TPL_VAR["arr_mem_lev"][$TPL_V1["mem_lev"]]?></td>
				<td>&nbsp;</td>
				<td><?php echo $TPL_V1["RechargeNum"]?></td>
				<td><?php echo $TPL_V1["changenum"]?></td>
				<td><?php echo $TPL_V1["betnum"]?></td>
				<td><a href="javascript:void(0)" onclick="open_window('../memo/memo_sendlist_acc.php?username=<?php echo $TPL_V1["memid"]?>',700,500)"><?php echo $TPL_V1["memo_new"]?>/<?php echo $TPL_V1["memo_total"]?></a></td>
				<td><?php echo $TPL_V1["status"]?></td>
				<td><?php echo $TPL_V1["regdate"]?></td>
				<td>[<?php echo $TPL_V1["country_code"]?>]<?php echo $TPL_V1["reg_ip"]?></td>
				<td><?php echo $TPL_V1["chu_member"]?></td>
			</tr>
<?php }}?>
	</tbody>
	</table>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
	<div id="wrap_btn">
		<p class="left">
			<input type="button" name="open" value="회원등록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="window.location.href='user_add.php'"/>
			<input type="button" name="open" value="회원정지" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="userStatusChange('stop')"/>
			<input type="button" name="open" value="불량회원" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="userStatusChange('bad')"/>
			<input type="button" name="open" value="회원탈퇴" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="userStatusChange('delete')"/>
		</p>
	</div>
	<span id="op1"></span>
	</form>

</div>