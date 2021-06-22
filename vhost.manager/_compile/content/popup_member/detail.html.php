<?php /* Template_ 2.2.3 2012/10/11 05:29:12 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\popup_member\detail.html */
$TPL_levelList_1=empty($TPL_VAR["levelList"])||!is_array($TPL_VAR["levelList"])?0:count($TPL_VAR["levelList"]);
$TPL_memoList_1=empty($TPL_VAR["memoList"])||!is_array($TPL_VAR["memoList"])?0:count($TPL_VAR["memoList"]);?>
<script>
	function check()
	{
		var fm=document.frm;
		if(fm.pwd.value !=""){
			if(fm.pwd.value.length<6){
				alert("비밀번호는 6자리 이상입니다");
				fm.pwd.focus();
				return;
			}
		}
		if(fm.email.value.length!=0){
			reg=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
			if(!reg.test(fm.email.value)){
				alert("이메일 격식이 틀립니다.");
				fm.email.focus();
				return;
			}
		}
		fm.submit();
	}
	
	function goSubmit() {
		var fm=document.frm;
		fm.submit();
	
		opener.document.location.reload();
	}
	
	function go(url){
		var result = confirm('정말로 전환 하시겠습니까?');
		if(result){
			location.href=url;
	
			opener.document.location.reload();
		 
		}
	} 
	
	function goDel_Membermemo( member_idx, context_idx ) {
		var result = confirm('정말로 삭제 하시겠습니까?');
		if(result){
			location.href="?mode=del_membermemo&idx="+member_idx+"&context_idx="+context_idx;
		}
	}
	</script>
</head>
<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>회원 상세정보</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<form name="frm" method="POST" action="?mode=add">
	<input type="hidden" name="memid" value="<?php echo $TPL_VAR["list"]["mem_id"]?>">
	<input type="hidden" name="urlidx" value="<?php echo $TPL_VAR["idx"]?>">
	<table cellspacing="1" class="tableStyle_membersWrite" summary="회원 정보">
	<legend class="blind">쪽지 쓰기</legend>
		<tr>
		  <th>아이디</th>
		  <td><?php echo $TPL_VAR["list"]["mem_id"]?></td>
		  <th>비밀번호</th>
		  <td><input type="password" name="pwd" value="default" class="w250"></td>
		</tr>
		<tr>
		  <th>닉네임</th>
		  <td><?php echo $TPL_VAR["list"]["nick"]?></td>
		  <th>이름</th>
		  <td><?php echo $TPL_VAR["list"]["name"]?></td>
		</tr>
		<tr>
		  <th>보유금액</th>
		  	<td>
<?php if(strpos($TPL_VAR["quanxian"],"1001")){?>
		  			<a href="javascript:open_window('user_money_change.php?idx=<?=$idx?>&act=money',400,250)"> <?php echo number_format($TPL_VAR["list"]["g_money"],0)?> </a>
<?php }else{?>
		  			<?php echo number_format($TPL_VAR["list"]["g_money"],0)?>

<?php }?>
		    	</td>
		  <th>배팅금액</th>
		  <td><?php echo number_format($TPL_VAR["list"]["bet_money"],0)?></td>
		</tr>
		<tr>
		  <th>은행명</th>
		  <td><input type="text" name="bank_name" value="<?php echo $TPL_VAR["list"]["bank_name"]?>" class="w250"></td>
		  <th>예금주</th>
		  <td><input type="text" name="bank_member" value="<?php echo $TPL_VAR["list"]["bank_member"]?>" class="w250"></td>
		</tr>
		<tr>
		  <th>계좌번호</th>
		  <td colspan="3"><input type="text" name="bank_count" value="<?php echo $TPL_VAR["list"]["bank_account"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" class="w250"/></td>
		</tr>
		
		<tr>
		  <th>가입일</th>
		  <td><?php echo $TPL_VAR["list"]["regdate"]?></td>
		  <th>로그인시간</th>
		  <td><?php echo $TPL_VAR["list"]["last_date"]?></td>
		</tr>
		<tr>
		  <th>가입아이피</th>
		  <td><?php echo $TPL_VAR["list"]["reg_ip"]?></td>
		  <th>로그인아이피</th>
		  <td>[<?php echo $TPL_VAR["country_code"]?>] <?php echo $TPL_VAR["list"]["mem_ip"]?></td>
		</tr>
		<tr>
		  <th>가입사이트</th>
		  <td><?php echo number_format($TPL_VAR["list"]["g_money"],0)?></td>
		  <th>파트너</th>
		  <td><input type="text" name="chu_member" <?php if(strpos($TPL_VAR["quanxian"],"1003")){?> readonly='true' <?php }?> value="<?php echo $TPL_VAR["list"]["chu_member"]?>" class="w250"></td>
		</tr>
		<tr>
		  <th>입금횟수</th>
		  <td><?php echo $TPL_VAR["list"]["RechargeNum"]?></td>
		  <th>출금횟수</th>
		  <td><?php echo $TPL_VAR["list"]["changenum"]?></td>
		</tr>
		<tr>
		  <th>입금총액</th>
		  <td><?php echo number_format($TPL_VAR["list"]["rechargecount"],0)?></td>
		  <th>출금총액</th>
		  <td><?php echo number_format($TPL_VAR["list"]["changecount"],0)?></td>
		</tr>
		<tr>
		  <th>회원등급</th>
		  <td>
		  	<select name="mem_lev">
<?php if($TPL_levelList_1){foreach($TPL_VAR["levelList"] as $TPL_V1){?>
		  			<option value="<?php echo $TPL_V1["lev"]?>" <?php if($TPL_VAR["list"]["mem_lev"]==$TPL_V1["lev"]){?> selected <?php }?>><?php echo $TPL_V1["lev_name"]?></option>	
<?php }}?>
			</select>
		  </td>
		  <th>상태</th>
		  <td>
<?php if($TPL_VAR["list"]["isStop"]=="W"){?>
				<font color='red'>신규</font>
<?php }elseif($TPL_VAR["list"]["isStop"]=="Y"){?>
				<font color='red'>정지</font>
<?php }elseif($TPL_VAR["list"]["isStop"]=="B"){?>
				<font color='red'>불량</font>
<?php }else{?>
				정상
<?php }?>
		  </td>
		</tr>
		<tr>
		  <th>이메일</th>
		  <td><input type="text" name="email" value="<?php echo $TPL_VAR["list"]["email"]?>" class="w250"></td>
		  <th>핸드폰</th>
		  <td><input type="text" name="phone" value="<?php echo $TPL_VAR["list"]["phone"]?>" class="w250" size="15" maxlength="12" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
		</tr>
		<tr>
		  <th>SMS설정</th>
		  <td>
			안전도메인<input type="checkbox" style="text-align:right;" name="sms_safedomain" value="1" <?php if($TPL_VAR["list"]["sms_safedomain"]==1){?> checked <?php }?>>
			&nbsp;&nbsp;이벤트<input type="checkbox" style="text-align:right;" name="sms_event" value="1" <?php if($TPL_VAR["list"]["sms_event"]==1){?> checked <?php }?>>
			&nbsp;&nbsp;적중<input type="checkbox" style="text-align:right;" name="sms_betting_ok" value="1" <?php if($TPL_VAR["list"]["sms_betting_ok"]==1){?> checked <?php }?>>
		  </td>
		  <th>잭팟횟수</th>
		  <td><input type="text" name="jackpot_num" value="<?php echo $TPL_VAR["list"]["jackpot_num"]?>" size="3" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" class="w120"></td>
		</tr>
		<tr>
		  <th>메모</th>
		  <td colspan="3">
				<table border="0" class="tableStyle_memo">
					<tr>
						<th>시간</th>
						<th>내용</th>
						<th>처리</th>
					</tr>
<?php if($TPL_memoList_1){foreach($TPL_VAR["memoList"] as $TPL_V1){?>
						<tr>
							<td><?php echo $TPL_V1["date"]?></td>
							<td><?php echo $TPL_V1["context"]?></td>
							<td width="10%" align="center" >
								<a href="../memo/member_memo.php?act=view&idx=<?php echo $TPL_VAR["idx"]?>&context_idx=<?php echo $TPL_V1["idx"]?>">[수정]</a>&nbsp;&nbsp;
								<a href="javascript:goDel_Membermemo(<?php echo $TPL_VAR["idx"]?>,{memoList.idx{);void(0);">[삭제]</a>
							</td>
						</tr>
<?php }}?>
				</table>
		  </td>
		</tr>
	</table>
	<div id="wrap_btn">
		<input type="button" onclick="javascript:open_window('/popmember/charge?field=mem_id&mem_id=<?php echo $TPL_VAR["list"]["mem_id"]?>',1000,600)" value="입금내역" class="btnStyle1">
		<input type="button" onclick="javascript:open_window('/popmember/exchange?field=mem_id&mem_id=<?php echo $TPL_VAR["list"]["mem_id"]?>',1000,600)" value="출금내역" class="btnStyle1">
		<input type="button" onclick="javascript:open_window('/popmember/bet?memidx=<?php echo $TPL_VAR["idx"]?>','1400',600)" value="배팅내역" class="btnStyle1">
		<input type="button" onclick="javascript:open_window('/popmember/loginlist?field=member_id&username=<?php echo $TPL_VAR["list"]["mem_id"]?>',1000,600)" value="접속기록" class="btnStyle1">
		<input type="button" value="메모쓰기" onclick="javascript:open_window('/popmember/notewrite?idx=<?php echo $TPL_VAR["idx"]?>',700,500)" class="btnStyle1">
		
		<input type="button" value="쪽지함" onclick="javascript:open_window('/memo/memo?username=<?php echo $TPL_VAR["list"]["mem_id"]?>',700,500)" class="btnStyle1">
		<input type="button" value="쪽지쓰기" onclick="javascript:open_window('/memo/write?userid=<?php echo $TPL_VAR["list"]["mem_id"]?>&phone=<?php echo $TPL_VAR["list"]["phone"]?>',650,300)" class="btnStyle1">
		<input type="button" value="불량회원" onclick="go('/popmember/detail?mode=changestatusbad&idx=<?php echo $TPL_VAR["idx"]?>');" class="btnStyle1">
		<input type="button" value="탈퇴" onclick="go('/popmember/detail?mode=deleteuser&idx=<?php echo $TPL_VAR["idx"]?>');" class="btnStyle1">
		
<?php if($TPL_VAR["list"]["isStop"]=="W"){?>
			<input type="button" value="이전" onclick="go('/popmember/detail?mode=changestatus&idx=<?php echo $TPL_VAR["idx"]?>');" class="btnStyle1">
<?php }elseif($TPL_VAR["list"]["isStop"]=="Y"||$TPL_VAR["list"]["isStop"]=="B"){?>
			<input type="button" value="해제" onclick="go('/popmember/detail?mode=changestatus&idx=<?php echo $TPL_VAR["idx"]?>');" class="btnStyle1">
<?php }else{?>
			<input type="button" value="정지" onclick="go('/popmember/detail?mode=changestatusstop&idx=<?php echo $TPL_VAR["idx"]?>');" class="btnStyle1">
<?php }?>
		<input type="button" value="수정" onClick="goSubmit()" class="btnStyle1">
		<input type="button" onclick="window.close()" value="닫기" class="btnStyle2">
		
	</div>
	</form>
</div>

</body>
</html>