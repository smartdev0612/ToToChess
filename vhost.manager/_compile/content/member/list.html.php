<?php
$TPL_partner_list_1=empty($TPL_VAR["partner_list"])||!is_array($TPL_VAR["partner_list"])?0:count($TPL_VAR["partner_list"]);
$TPL_config_rows_1=empty($TPL_VAR["config_rows"])||!is_array($TPL_VAR["config_rows"])?0:count($TPL_VAR["config_rows"]);
$TPL_domain_list_1=empty($TPL_VAR["domain_list"])||!is_array($TPL_VAR["domain_list"])?0:count($TPL_VAR["domain_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '회원관리-회원목록';</script>

<script>
	function onStateClick()
	{
		var filter_state="";
		
		$('#form2 input:checkbox').each(function(index)
		{
			if(this.name=='filter_member_state')
			{
				if(this.checked) 	{filter_state+="1";}
				else							{filter_state+="0";}
			}
		});
		
		$('#filter_state').val(filter_state);
		//document.form2.submit();
	}
	
	function onLevelClick()
	{
		var filter_level="";
		
		$('#form2 input:checkbox').each(function(index)
		{
			if(this.name=='filter_member_level')
			{
				if(this.checked)
				{
					filter_level+="1";
				}
				else
				{
					filter_level+="0";
				}
			}
		});
		
		$('#filter_level').val(filter_level);
		//document.form2.submit();
	}
	
	function onDomainClick()
	{
		var filter="";
		
		$('#form2 input:checkbox').each(function(index)
		{
			if(this.name=='domain')
			{
				if(this.checked)	{filter+="1";}
				else							{filter+="0";}
			}
		});
		
		$('#filter_domain').val(filter);
		//document.form2.submit();
	}
	
	//유저의 등급, 상태 변경시 호출
	function onMemberModifyState(member_sn, state)
	{
		document.form1.act.value="modify_state";
		
		document.form1.modify_member_sn.value=member_sn;
		document.form1.modify_state.value=state;
		document.form1.submit();
	}
	
	function onMemberModifyLevel(member_sn, level)
	{
		document.form1.act.value="modify_level";
		document.form1.modify_member_sn.value=member_sn;
		document.form1.modify_level.value=level;
		document.form1.submit();
	}
	
	function onMemberModifyDomain(member_sn, _domain)
	{
		document.form1.act.value="modify_domain";
		document.form1.modify_member_sn.value=member_sn;
		document.form1.modify_domain.value=_domain;
		document.form1.submit();
	}
	
	function onSave(sn)
	{
		var member_sn			= sn;
		//var bank_name 		= $('#'+sn+'_bank_name').val();
		//var bank_account 	= $('#'+sn+'_bank_account').val();
		var bank_member 	= $('#'+sn+'_bank_member').val();
		//var phone 				= $('#'+sn+'_phone').val();
		var board_write_auth = $('#'+sn+'_board_write_auth').attr("checked");
		var reply_write_auth = $('#'+sn+'_reply_write_auth').attr("checked");
		var question_write_auth = $('#'+sn+'_question_write_auth').attr("checked");
		var board_auth = "";
		if(board_write_auth=="checked") board_auth+=0;
		else														board_auth+=1;
		if(reply_write_auth=="checked") board_auth+=0;
		else														board_auth+=1;
		if(question_write_auth=="checked") board_auth+=0;
		else														board_auth+=1;
		
		$('#modify_member_sn').val(member_sn);
		//$('#modify_bank_name').val(bank_name);
		//$('#modify_bank_account').val(bank_account);
		$('#modify_bank_member').val(bank_member);
		//$('#modify_phone').val(phone);
		$('#modify_board_auth').val(board_auth);
		
		document.form1.act.value="modify";
		document.form1.submit();
	}

	function sortByMoney()
    {
        document.form2.sort_field.value="g_money";
        document.form2.sort_type.value="desc";
        document.form2.submit();
    }

    function sortByMileage()
    {
        document.form2.sort_field.value="point";
        document.form2.sort_type.value="desc";
        document.form2.submit();
    }
</script>

<div class="wrap" id="members">
	<div id="route">
		<h5>관리자 시스템 > 회원 관리 > <b>회원목록</b></h5>
	</div>

	<h3>회원목록</h3>

	<div id="search">
		<form action="?" method="get" name="form2" id="form2">

		<div class="wrap">
			<span class="icon">사이트</span>
				<select name="filter_logo">
					<option value=""  <?php if($TPL_VAR["filter_logo"]==""){?>  selected <?php }?>>전체</option>
					<option value="gadget" <?php if($TPL_VAR["filter_logo"]=="gadget"){?>  selected <?php }?>>gadget</option>
				</select>
			<span class="icon">출력</span>
			<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">

			<!-- 정렬 방법 -->
			<select name="sort_field">
				<option value="" 				<?php if($TPL_VAR["sort_field"]==""){?> selected <?php }?>>::정렬</option>
				<option value="regdate" <?php if($TPL_VAR["sort_field"]=="regdate"){?> selected <?php }?>>가입 일시</option>
				<option value="g_money" <?php if($TPL_VAR["sort_field"]=="g_money"){?> selected <?php }?>>보유 머니</option>
                <option value="point" <?php if($TPL_VAR["sort_field"]=="point"){?> selected <?php }?>>보유 포인트</option>
				<option value="benefit" <?php if($TPL_VAR["sort_field"]=="benefit"){?> selected <?php }?>>회원 수익</option>
				<option value="visit_count" <?php if($TPL_VAR["sort_field"]=="visit_count"){?> selected <?php }?>>접속 횟수</option>
                <option value="last_login" <?php if($TPL_VAR["sort_field"]=="last_login"){?> selected <?php }?>>최근접속</option>
			</select>

			<!-- 오름,내림차순 -->
			<select name="sort_type">
				<option value="desc"	<?php if($TPL_VAR["sort_type"]=="desc"){?> selected <?php }?>><b>↑</b></option>
				<option value="asc"		<?php if($TPL_VAR["sort_type"]=="asc"){?>  selected <?php }?>><b>↓</b></option>
			</select>

			<!-- 총판 필터 -->
			<select name="filter_partner_sn">
				<option value="" <?php if($TPL_VAR["filter_partner_sn"]==""){?> selected <?php }?>>총판</option>
<?php if($TPL_partner_list_1){foreach($TPL_VAR["partner_list"] as $TPL_V1){?>
					<option value=<?php echo $TPL_V1["Idx"]?> <?php if($TPL_VAR["filter_partner_sn"]==$TPL_V1["Idx"]){?> selected <?php }?>><?php echo $TPL_V1["rec_id"]?></option>
<?php }}?>
			</select>

			<!-- 키워드 검색 -->
			<select name="field">
				<option value="mem_id" 	<?php if($TPL_VAR["field"]=="mem_id"){?>	selected <?php }?>>아이디</option>
				<option value="nick"  	<?php if($TPL_VAR["field"]=="nick"){?>		selected <?php }?>>닉네임</option>
				<option value="phone"  	<?php if($TPL_VAR["field"]=="phone"){?>		selected <?php }?>>휴대폰</option>
				<option value="bank_member" <?php if($TPL_VAR["field"]=="bank_member"){?> selected <?php }?>>예금주</option>
                <option value="bank_account" <?php if($TPL_VAR["field"]=="bank_account"){?> selected <?php }?>>계좌번호</option>
				<option value="join_recommend" <?php if($TPL_VAR["field"]=="join_recommend"){?> selected <?php }?>>추천인</option>
				<option value="mem_ip"  <?php if($TPL_VAR["field"]=="mem_ip"){?>	selected <?php }?>>IP</option>
			</select>
			<input name="keyword" type="text" id="key" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20" onmouseover="this.focus()"/>

			<!-- 검색버튼 -->
			<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
		</div>
		<div class="wrap_search">
		  <!-- 더보기 -->
		  <!--<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" />-->
		  
		  <!-- 회원상태 -->
		  <!--N=일반, S=정지, B=불량, W=신규,D=탈퇴-->
		  
		  <span class="icon">상태</span>
		  <input type="hidden" 	 name="filter_state" id="filter_state" value="<?php echo $TPL_VAR["filter_member_state"]?>" class="radio">
		  <!--
		  <input type="checkbox" name="filter_member_state" value='W' <?php if(substr($TPL_VAR["filter_member_state"],0,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 신규
		  <input type="checkbox" name="filter_member_state" value='S' <?php if(substr($TPL_VAR["filter_member_state"],1,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 정지
		  <input type="checkbox" name="filter_member_state" value='B' <?php if(substr($TPL_VAR["filter_member_state"],2,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 불량
		  <input type="checkbox" name="filter_member_state" value='N' <?php if(substr($TPL_VAR["filter_member_state"],3,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 정상
		  <input type="checkbox" name="filter_member_state" value='D' <?php if(substr($TPL_VAR["filter_member_state"],4,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 탈퇴
		  <input type="checkbox" name="filter_member_state" value='G' <?php if(substr($TPL_VAR["filter_member_state"],5,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 테스트
		  -->
		  <input type="checkbox" name="filter_member_state" value='S' <?php if(substr($TPL_VAR["filter_member_state"],0,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 정지
		  <input type="checkbox" name="filter_member_state" value='N' <?php if(substr($TPL_VAR["filter_member_state"],1,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 정상
		  <input type="checkbox" name="filter_member_state" value='G' <?php if(substr($TPL_VAR["filter_member_state"],2,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 테스트
		  <input type="checkbox" name="filter_member_state" value='W' <?php if(substr($TPL_VAR["filter_member_state"],3,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 심사
		  <input type="checkbox" name="filter_member_state" value='D' <?php if(substr($TPL_VAR["filter_member_state"],4,1)=='1'){?> checked<?php }?> onClick="onStateClick();" class="radio"> 탈퇴
		  &nbsp;&nbsp;&nbsp;&nbsp;
		  
		  <!-- 회원등급 -->
		  <input type="hidden" 	 name="filter_level" id="filter_level" value="<?php echo $TPL_VAR["filter_level"]?>">
		  <span class="icon">등급</span>
<?php if($TPL_config_rows_1){$TPL_I1=-1;foreach($TPL_VAR["config_rows"] as $TPL_V1){$TPL_I1++;?>
				<input type="checkbox" name="filter_member_level" value='<?php echo $TPL_V1["lev"]?>' <?php if(substr($TPL_VAR["filter_level"],$TPL_I1,1)=='1'){?> checked<?php }?> onClick="onLevelClick();" class="radio"> <?php echo $TPL_V1["lev_name"]?>

<?php }}?>
		  <br>
		  <!-- 최종도메인 
		  <span class="icon">최종 도메인</span>
		  <input type="hidden" 	 name="filter_domain" id="filter_domain" value="<?php echo $TPL_VAR["filter_domain"]?>">
<?php if($TPL_domain_list_1){$TPL_I1=-1;foreach($TPL_VAR["domain_list"] as $TPL_V1){$TPL_I1++;?>
				<input type="checkbox" name="domain" value='<?php echo $TPL_V1["url"]?>' <?php if(substr($TPL_VAR["filter_domain"],$TPL_I1,1)=='1'){?> checked<?php }?> onClick="onDomainClick();" class="radio"> <?php echo $TPL_V1["url"]?>

<?php }}?>
		  -->
		</div>
		</form>
	</div>
	
	<form id="form1" name="form1" method="post" action="?">
		<input type="hidden" id="act" name="act" value="delete">
		<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
		<input type="hidden" name="sort_field" value="<?php echo $TPL_VAR["sort_field"]?>">
		<input type="hidden" name="sort_type" value="<?php echo $TPL_VAR["sort_type"]?>">
		<input type="hidden" name="filter_partner_sn" value="<?php echo $TPL_VAR["filter_partner_sn"]?>">
		<input type="hidden" name="field" value="<?php echo $TPL_VAR["field"]?>">
		<input type="hidden" name="keyword" value="<?php echo $TPL_VAR["keyword"]?>">
		<input type="hidden" name="filter_state" value="<?php echo $TPL_VAR["filter_member_state"]?>">
		<input type="hidden" name="filter_level" value="<?php echo $TPL_VAR["filter_level"]?>">
		<input type="hidden" name="filter_domain" value="<?php echo $TPL_VAR["filter_domain"]?>">
		<input type="hidden" name="page" value="<?php echo $TPL_VAR["current_page"]?>">
		
		<input type="hidden" id="modify_bank_name" name="modify_bank_name" value="">
		<input type="hidden" id="modify_bank_account" name="modify_bank_account" value="">
		<input type="hidden" id="modify_bank_member" name="modify_bank_member" value="">
		<input type="hidden" id="modify_phone" name="modify_phone" value="">
		<input type="hidden" id="modify_state" name="modify_state" value="">
		<input type="hidden" id="modify_level" name="modify_level" value="">
		<input type="hidden" id="modify_domain" name="modify_domain" value="">
		<input type="hidden" id="modify_member_sn" name="modify_member_sn" value="">
		<input type="hidden" id="modify_board_auth" name="modify_board_auth" value="">
		
		<table cellspacing="1" class="tableStyle_members" summary="회원목록">
		<legend class="blind">회원목록</legend>
		<thead>
	    <tr>
			<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
			<!--<th scope="col">계좌정보</th>-->
			<th scope="col" class="id" id="user_idx">사이트/아이디</th><!--ID-->
			<th scope="col">이름/닉네임</th>
			<!--<th scope="col">연락처</th>-->
            <th scope="col"><a href="javascript:sortByMoney()" style="color: white">보유머니</a>/<a href="javascript:sortByMileage()" style="color: white">마일리지</a></th>
			<th scope="col">등급</th>
			<!--<th scope="col">이벤트코인</th>-->
			<th scope="col">입금/출금</th>
			<th scope="col">진행 배팅액</th>
			<th scope="col">회원수익</th>
			<th scope="col">상태</th>
			<th scope="col">가입(날짜/도메인)</th>
			<th scope="col">최근(날짜/도메인)</th>
			<th scope="col">접속(IP/도메인)</th>
			<th scope="col">추천인</th>
			<th scope="col">총판</th>
            <th scope="col">추천가능</th>
			<th scope="col">진상관리</th>
<?php
	if ( $_SESSION['member']['sn'] < 1000 ) {
?>
			<th scope="col" class="lineRow">수정</th>
<?
	}
?>
	    </tr>
		</thead>
		<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_level_type_2=empty($TPL_V1["level_type"])||!is_array($TPL_V1["level_type"])?0:count($TPL_V1["level_type"]);
$TPL_permit_domain_list_2=empty($TPL_V1["permit_domain_list"])||!is_array($TPL_V1["permit_domain_list"])?0:count($TPL_V1["permit_domain_list"]);?>
				<tr bgcolor=<?php echo $TPL_V1["bgColor"]?>>
					<td rowspan="2"><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["sn"]?>"  onclick="javascript:chkRow(this);"/></td>
					<!--<td><input style="width:100px" type="text" id="<?php echo $TPL_V1["sn"]?>_bank_name" value="<?php echo $TPL_V1["bank_name"]?>"></td>-->
					<td title="상세정보"><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></a></td>        
					<td><input style="width:80px" type="hidden" id="<?php echo $TPL_V1["sn"]?>_bank_member" value="<?php echo $TPL_V1["bank_member"]?>"><?php echo $TPL_V1["bank_member"]?></td>
					<!--<td rowspan="2"><input style="width:100px" type="text" id="<?php echo $TPL_V1["sn"]?>_phone" value="<?php echo $TPL_V1["phone"]?>"></td>-->
					<!--<td><a href="javascript:open_window('/member/popup_moneychange?idx=<?php echo $TPL_V1["sn"]?>&act=money',400,250)"><?php echo number_format($TPL_V1["g_money"],0)?></a></td>-->
					<td title="머니내역"><a href="javascript:open_window('/log/popup_moneyloglist?uid=<?php echo $TPL_V1["uid"]?>',1000,600)"><font color='green'><?php echo number_format($TPL_V1["g_money"],0)?></font></a></td>
					<td rowspan="2">
						<select style="width:50px" name="lev" onChange="onMemberModifyLevel(<?php echo $TPL_V1["sn"]?>, this.value);">
<?php if($TPL_level_type_2){foreach($TPL_V1["level_type"] as $TPL_V2){?>
							<option value="<?php echo $TPL_V2["lev"]?>" <?php if($TPL_V1["mem_lev"]==$TPL_V2["lev"]){?>selected<?php }?>><?php echo $TPL_V2["lev_name"]?></option>
<?php }}?>
						</select>
					</td>
					
					<!--
					<td rowspan="2">
						<a href="javascript:void(0)" onclick="open_window('/member/popup_modifyEventCoin?sn=<?php echo $TPL_V1["sn"]?>',700,500)"><?php echo $TPL_V1["event_coin"]?></a>
					</td>
					-->
					<td title="강제충환전"><a href="javascript:open_window('/member/popup_moneychange?idx=<?php echo $TPL_V1["sn"]?>&act=money',400,250)"><font color='blue'><?php echo number_format($TPL_V1["charge_sum"],0)?></font></a></td>
					<td rowspan="2" title="배팅내역""><a href="javascript:void(0)" onclick="open_window('/member/popup_bet?mem_sn=<?php echo $TPL_V1["sn"]?>',1024,600)"><?php echo number_format($TPL_V1["bet_total"],0)?></a></td>
					<td rowspan="2"><?php echo number_format($TPL_V1["benefit"])?></td>
					<td rowspan="2">
							<select style="width:50px" name="mem_status" onChange="onMemberModifyState(<?php echo $TPL_V1["sn"]?>, this.value);">
								<option value="N" <?php if($TPL_V1["mem_status"]=='N'){?> selected <?php }?>>정상</option>
								<option style="color:blue" value="W" <?php if($TPL_V1["mem_status"]=='W'){?> selected <?php }?>>심사</option>
								<option style="color:red" value="S" <?php if($TPL_V1["mem_status"]=='S'){?> selected <?php }?>>정지</option>
								<!--
								<option style="color:blue" value="B" <?php if($TPL_V1["mem_status"]=='B'){?> selected <?php }?>>불량</option>
								-->
								<option style="color:red" value="D" <?php if($TPL_V1["mem_status"]=='D'){?> selected <?php }?>>탈퇴</option>
								<option style="color:gray" value="G" <?php if($TPL_V1["mem_status"]=='G'){?> selected <?php }?>>테스터</option>
							</select>
					</td>
					<td><?php echo $TPL_V1["regdate"]?></td>
					<td><?php echo $TPL_V1["last_date"]?></td>
					<td title="접속내역">
						<a href="javascript:open_window('/member/popup_loginlist?field=member_id&username=<?php echo $TPL_V1["uid"]?>',1000,600)">[<?php echo $TPL_V1["country_code"]?>]<?php echo $TPL_V1["mem_ip"]?></a>
					</td>
					<td title="추천인상세정보"><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["join_recommend_sn"]?>',1024,600)"><?php echo $TPL_V1["join_recommend_nick"]?></a></td>
					<td><?php echo $TPL_V1["rec_name"]?></td>
                    <td><?php echo $TPL_V1["is_recommender"] == 1 ? "추천가능" : "";?></td>
					<td>
						게&nbsp;/&nbsp;댓&nbsp;/&nbsp;고
					</td>
<?php
	if ( $_SESSION['member']['sn'] < 1000 ) {
?>
					<td rowspan="2"><input type="button" class="btnStyle3" value="적용" onclick="onSave(<?php echo $TPL_V1["sn"]?>);"/></a></td>
<?
	}
?>
				</tr>
				<tr bgcolor=<?php echo $TPL_V1["bgColor"]?>>
					<!--<td><input style="width:100px" type="text" id="<?php echo $TPL_V1["sn"]?>_bank_account" value="<?php echo $TPL_V1["bank_account"]?>"></td>-->
					<td><?php echo $TPL_V1["logo"];?></td>
					<td title="쪽지쓰기"><a href="javascript:open_window('/memo/popup_write?userid=<?php echo $TPL_V1["uid"]?>&logo=<?php echo $TPL_V1["logo"]?>',1024,600)"><?php echo $TPL_V1["nick"]?></a></td>
					<td title="마일리지내역"><a href="javascript:open_window('/log/popup_mileageloglist?uid=<?php echo $TPL_V1["uid"]?>',1000,600)"><?php echo number_format($TPL_V1["point"],0)?></a></td>
					<td><font color='red'><?php echo number_format($TPL_V1["exchange_sum"],0)?></font></td>
					<td><?php echo $TPL_V1["reg_domain"]?></td>
					<td><?php echo $TPL_V1["login_domain"]?></td>
					<td>
						<select style="width:100px" name="permit_domain" onChange="onMemberModifyDomain(<?php echo $TPL_V1["sn"]?>, this.value);">
<!--							<option value="nodata" <?php if($TPL_V1["permit_domain"]=="nodata"){?>selected<?php }?>>허용도메인</option>-->
<?php if($TPL_permit_domain_list_2){foreach($TPL_V1["permit_domain_list"] as $TPL_V2){?>
								<option value="<?php echo $TPL_V2["url"]?>" <?php if($TPL_V1["permit_domain"]==$TPL_V2["url"]){?>selected<?php }?>><?php echo $TPL_V2["url"]?></option>
<?php }}?>
						</select>
						<font color="red">[<?php echo $TPL_V1["visit_count"]?>]</font>
					</td>
					<td><?php echo $TPL_V1["join_recommend_bank_member"]?></td>
					<td><?php echo $TPL_V1["rec_id"]?></td>
                    <td></td>
					<td>
						<input type="checkbox" id="<?php echo $TPL_V1["sn"]?>_board_write_auth" <?php if(substr($TPL_V1["memo"],0,1)=="0"){?> checked <?php }?>>
						<input type="checkbox" id="<?php echo $TPL_V1["sn"]?>_reply_write_auth"<?php if(substr($TPL_V1["memo"],1,1)=="0"){?> checked <?php }?>>
						<input type="checkbox" id="<?php echo $TPL_V1["sn"]?>_question_write_auth"<?php if(substr($TPL_V1["memo"],2,1)=="0"){?> checked <?php }?>>
					</td>
				</tr>
<?php }}?>
		</tbody>
		</table>
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
		<div id="wrap_btn">
			<p class="left">
				<input type="button" name="open" value="회원등록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="window.location.href='/member/add'"/>
				<input type="button" name="open" value="회원정지" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="userStatusChange('stop')"/>
				<!--<input type="button" name="open" value="불량회원" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="userStatusChange('bad')"/>-->
				<input type="button" name="open" value="회원탈퇴" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="userStatusChange('delete')"/>
			</p>
		</div>
		<span id="op1"></span>
	</form>

</div>