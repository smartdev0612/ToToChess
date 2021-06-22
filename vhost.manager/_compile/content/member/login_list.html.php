<?php
$TPL_partnerList_1=empty($TPL_VAR["partnerList"])||!is_array($TPL_VAR["partnerList"])?0:count($TPL_VAR["partnerList"]);
$TPL_domainList_1=empty($TPL_VAR["domainList"])||!is_array($TPL_VAR["domainList"])?0:count($TPL_VAR["domainList"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '회원관리-접속기록';</script>

<script language="javascript">
	function onClickRecent3Hour(frm)
	{
		var keyword = frm.keyword.value;
		var perpage = frm.perpage.value;
		var field		= frm.field.value;
		location.href="?act=recent3hour&perpage="+perpage+"&keyword="+keyword+"&field="+field;
		return true;	
	}
</script>

<div class="wrap" id="members">
	<div id="route">
		<h5>관리자 시스템 > 회원 관리 > <b>접속 기록</b></h5>
	</div>

	<h3>접속 기록</h3>

	<div id="search">
		<div class="wrap">
			<form action="?" method="get" name="form2" id="form2">
				<span class="icon">사이트</span>
				<select name="filter_logo">
					<option value=""  <?php if($TPL_VAR["filter_logo"]==""){?>  selected <?php }?>>전체</option>
					<option value="gadget" <?php if($TPL_VAR["filter_logo"]=="gadget"){?>  selected <?php }?>>gadget</option>
				</select>
				<span class="icon">출력</span>
				<input name="perpage" type="text" class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<select name="partner_idx">
					<option value="" <?php if($TPL_VAR["filter_partner_idx"]==""){?> selected <?php }?>>총판</option>
<?php if($TPL_partnerList_1){foreach($TPL_VAR["partnerList"] as $TPL_V1){?>
					<option value=<?php echo $TPL_V1["Idx"]?> <?php if($TPL_VAR["filter_partner_idx"]==$TPL_V1["Idx"]){?> selected <?php }?>><?php echo $TPL_V1["rec_id"]?></option>
<?php }}?>
				</select>
				
				<select name="domain_name">
					<option value="" <?php if($TPL_VAR["filter_domain_name"]==""){?> selected <?php }?>>최종도메인</option>
<?php if($TPL_domainList_1){foreach($TPL_VAR["domainList"] as $TPL_V1){?>
					<option value=<?php echo $TPL_V1["url"]?> <?php if($TPL_VAR["filter_domain_name"]==$TPL_V1["url"]){?> selected <?php }?>><?php echo $TPL_V1["url"]?></option>
<?php }}?>
				</select>
				
				<!--<input type="checkbox" name="isDuplication_connection" <?php if($TPL_VAR["duplication_connection"]=='1'){?> checked<?php }?> class="radio"> 중복접속-->
				
				<input type="checkbox" name="isLogin_fail" <?php if($TPL_VAR["isLogin_fail"]=='on'){?> checked<?php }?> class="radio"> 로그인실패
				&nbsp;&nbsp;&nbsp;&nbsp;
				<select name="field">
					<option value="member_id" 	<?php if($TPL_VAR["field"]=="member_id"){?> selected <?php }?>>아이디</option>
					<option value="nick" 				<?php if($TPL_VAR["field"]=="nick"){?> selected <?php }?>>닉네임</option>
					<option value="bank_member" <?php if($TPL_VAR["field"]=="bank_member"){?> selected <?php }?>>예금주</option>
					<option value="visit_ip"  	<?php if($TPL_VAR["field"]=="visit_ip"){?>	 selected <?php }?>>로그인IP</option>
				</select>
				
	      <input name="keyword" type="text" id="key" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20"/>
	      <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
	      &nbsp;&nbsp;&nbsp;&nbsp;
	      <input type="button" name="recent3hour" value="최근 3시간" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="onClickRecent3Hour(this.form)"/>
	      <input type="button" name="all" value="전체보기" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="submit()"/>
	     	
			</form>
		</div>
	</div>
	
	<form id="form1" name="form1" method="post" action="?act=delete_user">
		<table cellspacing="1" class="tableStyle_normal">
		<legend class="blind">접속기록</legend>
		<thead>
		<tr>
			<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
			<th scope="col">사이트</td>
			<th scope="col" class="id">아이디</td>
			<th scope="col">닉네임</td>
			<th scope="col">예금주</td>
			<th scope="col">등급</td>
			<th scope="col">보유금액</td>
			<th scope="col">접속시간</td>
			<th scope="col">접속IP</td>
			<th scope="col">접속 도메인</td>
			<th scope="col">상태</td>
			<th scope="col">총판</td>
			<th scope="col">처리</td>
		</tr>
		</thead>
		<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr>
					<td><input type="checkbox" name="y_id[]" value="<?php echo $TPL_V1["idx"]?>" onclick="javascript:chkRow(this);"/></td>
					<td><?php echo $TPL_V1["logo"];?></td>
					<td>
<?php if($TPL_V1["status"]==0){?>
							<a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["aidx"]?>',1024,600)"><?php echo $TPL_V1["member_id"]?></a>
<?php }else{?>
							<?php echo $TPL_V1["member_id"]?>

<?php }?>
					</td>
					<td><?php echo $TPL_V1["nick"]?></td>
					<td><?php echo $TPL_V1["bank_member"]?></td>
					<td><?php echo $TPL_VAR["arr_mem_lev"][$TPL_V1["mem_lev"]]?></span></td>
					
					<td><?php echo number_format($TPL_V1["g_money"],0)?></td>
					<td><?php echo $TPL_V1["visit_date"]?></td>
					<td <?php if($TPL_V1["duplicate_ip"]==1){?>bgcolor='#0078B7'<?php }?>>[<?php echo $TPL_V1["country_code"]?>]<?php echo $TPL_V1["visit_ip"]?></td>
					<td><?php echo $TPL_V1["login_domain"]?></td>	
					<td>
<?php if($TPL_V1["status"]==1){?><font color='red'><?php echo $TPL_V1["result"]?></font>
<?php }else{?><?php echo $TPL_V1["result"]?>

<?php }?>
					</td>
					<td>
<?php if($TPL_V1["recommend_id"]!=''){?><?php echo $TPL_V1["recommend_id"]?>

<?php }else{?>무소속
<?php }?>
					</td>
					<td><a href="javascript:void(0)" onclick="comfire_ok(<?php echo $TPL_V1["idx"]?>,'loginlist?act=deleteone&idx=')"><img src="/img/btn_s_del.gif" title="삭제"></a></td>
				</tr>  
<?php }}?>
		</tbody>
		</table>
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
		<div id="wrap_btn">
			<p class="left">
				<input type="button" name="open" value="선택삭제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
			</p>
		</div>
	</form>
</div>