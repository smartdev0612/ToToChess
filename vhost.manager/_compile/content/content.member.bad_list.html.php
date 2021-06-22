<?php /* Template_ 2.2.3 2012/10/10 13:07:18 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.member.bad_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="wrap" id="members">

	<div id="route">
		<h5>관리자 시스템 > 회원 관리 > <b>불량회원</b></h5>
	</div>

	<h3>불량회원</h3>

	<div id="search">
		<div>
			<form action="?" method="get" name="form2" id="form2">
			<span>아이디</span>
            <input name="username" type="text" id="key" class="name" value="<?php echo $TPL_VAR["nname"]?>" maxlength="20" onmouseover="this.focus()"/>
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
          </form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?mode=allchange">	
	<table cellspacing="1" class="tableStyle_members">
	<legend class="blind">불량회원</legend>
	<thead>
		<tr>
			<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
			<th scope="col">아이디</th>
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
			<th scope="col">처리</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
			<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["idx"]?>"  onclick="javascript:chkRow(this);"/></td>
			<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["idx"]?>',1024,600)"><?php echo $TPL_V1["mem_id"]?></a></td>        
			<td><?php echo $TPL_V1["nick"]?></td>
			<td><?php echo $TPL_VAR["name"]?></td>
			<td>
<?php if(strpos($TPL_VAR["quanxian"],"1001")){?>
					<a href="javascript:open_window('user_money_change.php?idx=<?php echo $TPL_V1["mem_id"]?>&act=money',400,250)"><?php echo number_format($TPL_V1["g_money"],0)?></a>
<?php }else{?>
					<?php echo number_format($TPL_V1["g_money"],0)?>;
<?php }?>
			</td>
			<td><?php echo $TPL_VAR["arr_mem_lev"][$TPL_V1["mem_lev"]]?></td>
			<td>&nbsp;</td>
			<td><?php echo $TPL_V1["RechargeNum"]?></td>
			<td><?php echo $TPL_V1["changenum"]?></td>
			<td><?php echo $TPL_V1["betnum"]?></td>
			<td><?php echo $TPL_V1["memoread"]?>/<?php echo $TPL_V1["memototle"]?></td>
			<td><?php echo $TPL_V1["status"]?></td>
			<td><?php echo $TPL_V1["regdate"]?></td>
			<td><?php echo $TPL_V1["reg_ip"]?></td>
			<td><?php echo $TPL_VAR["chu_member"]?></td>
			<td><a href="javascript:go(<?php echo $TPL_V1["idx"]?>);void(0);"><img src="/img/btn_s_cancel.gif" title="취소"></a></td>
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
			<input type="button" name="open" value="상태전환" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
		</p>
	</div>

	</form>

</div>