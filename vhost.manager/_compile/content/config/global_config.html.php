<script>
	function confirmOk()
	{
		fm = document.frm;	
	    if(fm.admin_id.value=="")
	    {
				alert("아이디를 입력해 주세요.");
				fm.admin_id.focus();	
		}
		else if(fm.bank.value=="")
		{
			alert("은행명 입력해 주세요.");
			fm.bank.focus();	
		}
		else if(fm.bank_num.value=="")
		{
			alert("계좌번호를 입력해 주세요.");
			fm.bank_num.focus();	
		}
		else if(fm.name.value=="")
		{
			alert("예금주를 입력해 주세요.");
			fm.name.focus();
		}
		else if(fm.bettingendtime.value=="")
		{
			alert("배팅마감시간을 입력해 주세요.");
			fm.bettingendtime.focus();
		}
		else if(fm.bettingcanceltime.value=="")
		{
			alert("배팅취소허용시간을 입력해 주세요.");
			fm.bettingcanceltime.focus();
		}
		else if(fm.bettingcancelbeforetime.value=="")
		{
			alert("배팅취소허용시간을 입력해 주세요.");
			fm.bettingcancelbeforetime.focus();	
		}
		else if(fm.wel_memo_title.value=="")
		{
			alert("가입쪽지 제목을 입력하여 주세요.");
			fm.wel_memo_title.focus();	
		}
		else if(fm.wel_memo_content.value=="")
		{
			alert("가입쪽지 내용을 입력하여 주세요.");
			fm.wel_memo_content.focus();	
		}
		else
		{
			fm.action = "/config/globalProcess?logo="+"<?php echo $TPL_VAR["logo"]?>";
			fm.submit();	
		}
	}

//숫자 와 소주점만 가능
function onlyNumDecimalInput(){ 
 var code = window.event.keyCode; 
  
  if ((code >= 48 && code <= 57) || (code >= 96 && code <= 105) || code == 110 || code == 190 || 
      code == 8 || code == 9 || code == 13 || code == 46){ 
  window.event.returnValue = true; 
  return; 
  } 
  alert("숫자만 입력 가능 합니다!"); 
  window.event.returnValue = false; 
} 
</script>

<div class="wrap">
	
	<form  method="post" name="frm">
	<input type="hidden" name="logo" value="<?php echo $TPL_VAR["list"]["logo"]?>">
		<div id="route">
			<h5>관리자 시스템 > 시스템 관리 > <b>기본 설정</b></h5>
		</div>
	
		<h3>기본 설정</h3>
	
		
		<table cellspacing="1" class="tableStyle_membersWrite thBig" summary="기본 설정">
		<legend class="blind">기본 설정</legend>
		<tr>
			<th style="width:25%">서비스 점검</th>
			<td>
				<input type="radio" name="maintain" value="1" <?php if($TPL_VAR["list"]["maintain"]==1){?> checked <?php }?>> 서비스
				<input type="radio" name="maintain" value="2" <?php if($TPL_VAR["list"]["maintain"]==2){?> checked <?php }?>> 점검중
			</td>
	    </tr>
	    <tr>
			<th>점검중멘트</th>
			<td><textarea name="maintain_ment" rows="10" cols="55"><?php echo $TPL_VAR["list"]["maintain_ment"]?></textarea>
	    </tr>
	    <tr>
				<th width="25%">환전최소금액</th>
				<td><input name="exchange_money" type="text"  class="w60" id="admin_id" value="<?php echo $TPL_VAR["list"]["exchange_money"]?>" maxlength="30" /></td>
	    </tr>
		<tr>
			<th>환전시 자동쪽지 문구</th>
			<td><textarea name="exchange_memo" rows="10" cols="55"><?php echo $TPL_VAR["list"]["exchange_memo"]?></textarea>
	    </tr>
	    <tr>
			<th>은행계좌</th>
			<td>은행명 : <input type="text" class="w120" name="bank" value="<?php echo $TPL_VAR["list"]["bank"]?>" size="10" /> 계좌번호 : <input type="text" class="w120" name="bank_num" value="<?php echo $TPL_VAR["list"]["bank_num"]?>" size="10" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /> 예금주 : <input type="text" class="w60" name="name" value="<?php echo $TPL_VAR["list"]["name"]?>" size="10" />
			</td>
	    </tr>
	    <tr>
			<th>회원가입시 추천인</th>
			<td>
			<input type="radio" name="member_join_chu" value="1" <?php if($TPL_VAR["list"]["member_join_chu"]==1){?> checked <?php }?>> 입력필수
			<input type="radio" name="member_join_chu" value="2" <?php if($TPL_VAR["list"]["member_join_chu"]==2){?> checked <?php }?>> 필수아님
			<!--<input type="radio" name="member_join_chu" value="3" <?php if($TPL_VAR["list"]["member_join_chu"]==3){?> checked <?php }?>> 필요없음-->
			</td>
	    </tr>
	    <tr>
	    <!--
			<th>문자메세지(안전도메인)</th>
			<td><input type="text" class="w250" name="sms_safedomain" value="<?php echo $TPL_VAR["list"]["sms_safedomain"]?>" size="12" /></td>
	    </tr>
	    <tr>
			<th>문자메세지(적중)</th>
			<td><input name="sms_betting_ok_msg" value="<?php echo $TPL_VAR["list"]["sms_betting_ok_msg"]?>" type="text"  class="w250" id="bootom_tel"  maxlength="80" /><span class="infoCopy">적중금액 <?php echo $TPL_VAR["money"]?></span></td>
	    </tr>
	    -->
	    <tr>
				<th>한줄광고</th>
				<td><input name="ad" value="<?php echo $TPL_VAR["list"]["ad"]?>" type="text"  class="w600" id="ad" /></td>
	    </tr>
			<tr>
				<th>가입쪽지 제목 설정</th>
				<td><input name="wel_memo_title" value="<?php echo $TPL_VAR["list"]["wel_memo_title"]?>" type="text"  class="w250" id="bootom_tel"  maxlength="80" /></td>
	    </tr>
			<tr>
				<th>가입쪽지 문구 설정</th>
				<td><textarea name="wel_memo_content" rows="10" cols="55"><?php echo $TPL_VAR["list"]["wel_memo_content"]?></textarea></td>
	    </tr>
        <tr>
            <th>기본답변 설정</th>
            <td><textarea name="qna_main" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_main"]?></textarea></td>
        </tr>
	    <tr>
				<th>고객센터-2등급↓ 계좌</th>
				<td><textarea name="qna_1" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_1"]?></textarea></td>
	    </tr>
	    <tr>
				<th>고객센터-3등급↑ 계좌</th>
				<td><textarea name="qna_2" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_2"]?></textarea></td>
	    </tr>
	    <tr>
				<th>고객센터-롤링 미충족</th>
				<td><textarea name="qna_3" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_3"]?></textarea></td>
	    </tr>
	    <tr>
				<th>고객센터-환전요청답변</th>
				<td><textarea name="qna_4" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_4"]?></textarea>
	    </tr>
	    <tr>
				<th>고객센터-지속적인 단폴두폴 배팅시</th>
				<td><textarea name="qna_5" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_5"]?></textarea>
	    </tr>
	    <tr>
				<th>고객센터-재로그인(등급↑)</th>
				<td><textarea name="qna_6" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_6"]?></textarea>
	    </tr>
	    <tr>
				<th>고객센터-지인추천</th>
				<td><textarea name="qna_7" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_7"]?></textarea>
	    </tr>
	    <tr>
				<th>고객센터-지인추천 조건미달</th>
				<td><textarea name="qna_8" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_8"]?></textarea>
	    </tr>
	    <tr>
				<th>고객센터-경기오류제보</th>
				<td><textarea name="qna_9" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_9"]?></textarea>
	    </tr>
	    <tr>
				<th>고객센터-재입금안내</th>
				<td><textarea name="qna_10" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_10"]?></textarea>
	    </tr>
		<tr>
				<th>고객센터-결과처리 지연</th>
				<td><textarea name="qna_11" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_11"]?></textarea>
	    </tr>
		<tr>
				<th>고객센터-등록된 계좌외 입금</th>
				<td><textarea name="qna_12" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_12"]?></textarea>
	    </tr>
		<tr>
				<th>고객센터-입금신청시 입금액 다를 경우</th>
				<td><textarea name="qna_13" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_13"]?></textarea>
	    </tr>
		<tr>
				<th>고객센터-베팅타입에 제공중인 팀 미표기</th>
				<td><textarea name="qna_14" rows="10" cols="55"><?php echo $TPL_VAR["list"]["qna_14"]?></textarea>
	    </tr>
	    <tr>
			<th>배팅마감</th>
			<td>
			경기시간 <input type="text" class="w60" name="bettingendtime" value="<?php echo $TPL_VAR["list"]["bettingendtime"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />분전
			</td>
	    </tr>
	    <tr>
			<th>배팅취소허용시간</th>
			<td>
			배팅 후<input type="text" class="w60" name="bettingcanceltime" value="<?php echo $TPL_VAR["list"]["bettingcanceltime"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />분이내 / 경기시작 <input type="text" class="w60" name="bettingcancelbeforetime" value="<?php echo $TPL_VAR["list"]["bettingcancelbeforetime"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />분전
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;하루 배팅취소 <input type="text" class="w60" name="bettingcancelcnt" value="<?php echo $TPL_VAR["list"]["bettingcancelcnt"]?>"/>회 허용
			</td>
	    <tr>
			<th>쪽지 제목 길이</th>
			<td><input type="text" class="w60" name="memo_title_len" value="<?php echo $TPL_VAR["list"]["memo_title_len"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />글자</td>
		</tr>
		<tr >
			<th>쪽지 내용 길이</th>
			<td><input type="text" class="w60" name="memo_content_len" value="<?php echo $TPL_VAR["list"]["memo_content_len"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />글자</td>
		</tr>
		<tr>
			<th>고객센터 제목 길이</th>
			<td><input type="text" class="w60" name="quetion_title_len" value="<?php echo $TPL_VAR["list"]["quetion_title_len"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />글자</td>
		</tr>
		<tr>
			<th>고객센터 내용 길이</th>
			<td><input type="text" class="w60" name="quetion_content_len" value="<?php echo $TPL_VAR["list"]["quetion_content_len"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />글자</td>
		</tr>
		<tr>
			<th>게시판 제목 길이</th>
			<td><input type="text" class="w60" name="board_title_len" value="<?php echo $TPL_VAR["list"]["board_title_len"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />글자</td>
		</tr>
		<tr>
			<th>게시판 내용 길이</th>
			<td><input type="text" class="w60" name="board_content_len" value="<?php echo $TPL_VAR["list"]["board_content_len"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />글자</td>
		</tr>
		<tr>
			<th>댓글 내용 길이</td>
			<td><input type="text"class="w60" name="comment_content_len" value="<?php echo $TPL_VAR["list"]["comment_content_len"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />글자</td>
		</tr>
		<tr>
			<th>게시글 올리기 시간 간격</th>
			<td><input type="text" class="w60" name="board_write_time" value="<?php echo $TPL_VAR["list"]["board_write_time"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />분</td>
		</tr>
		<tr>
			<th>댓글달기 시간 간격</th>
			<td><input type="text" class="w60" name="comment_write_time" value="<?php echo $TPL_VAR["list"]["comment_write_time"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" />분</td>
		</tr>
	  </table>
	
	  <div id="wrap_btn">
		 <input type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="저  장" onclick="confirmOk();"/>
	  </div>
  </form>
	
</div>