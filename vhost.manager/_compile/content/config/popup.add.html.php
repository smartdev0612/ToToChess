<script> 
function chk_form()
{
	FormData = document.FormData;
	if (FormData.P_SUBJECT.value=="")
	{
		alert("제목을 입력하십시오.")
		FormData.P_SUBJECT.focus();
		return (false);
	}
	// if (FormData.P_CONTENT.value=="")
	// {
	// 	alert("내용을 입력하십시오.")
	// 	FormData.P_CONTENT.focus();
	// 	return (false);
	// }
	if (FormData.P_POPUP_U.value=="")
		{
		alert("사용여무을 선택하십시오.")
		FormData.P_POPUP_U.focus();
		return (false);
		}
	if (FormData.P_STARTDAY.value=="")
		{
		alert("시작일을 입력하십시오.")
		FormData.P_STARTDAY.focus();
		return (false);
		}
	if (FormData.P_ENDDAY.value=="")
		{
		alert("마감일을 입력하십시오.")
		FormData.P_ENDDAY.focus();
		return (false);
		}
	// if (FormData.P_WIN_LEFT.value=="" )
	// 	{
	// 	alert("left를 입력하십시오.")
	// 	FormData.P_WIN_LEFT.focus();
	// 	return (false);
	// 	}
	// if (FormData.P_WIN_TOP.value=="" )
	// 	{
	// 	alert("top를 입력하십시오.")
	// 	FormData.P_WIN_TOP.focus();
	// 	return (false);
	// 	}
	// if (FormData.P_WIN_WIDTH.value=="" )
	// 	{
	// 	alert("width를 입력하십시오.")
	// 	FormData.P_WIN_WIDTH.focus();
	// 	return (false);
	// 	}
	// if (FormData.P_WIN_HEIGHT.value=="" )
	// 	{
	// 	alert("height를 입력하십시오.")
	// 	FormData.P_WIN_HEIGHT.focus();
	// 	return (false);
	// 	}
	return (true);
}
</script>

<div class="wrap" id="popup_add">

	<div id="route">
		<h5>관리자 시스템 > 시스템 관리 > <b>팝업 설정</b></h5>
	</div>

	<h3>팝업 설정</h3>

	<ul id="tab">
		<li><a href="/config/popuplist" id="popup">팝업창 목록</a></li>
		<li><a href="/config/popupadd" id="popup_add">팝업창 추가</a></li>
	</ul>

	<form action="/config/popupProcess" method="post" enctype="multipart/form-data" name="FormData" onsubmit="return chk_form();">
		<input type= "hidden" name = "idx" Value = "<?php echo $TPL_VAR["idx"]?>">
		<input type= "hidden" name = "act" Value = "<?php echo $TPL_VAR["act"]?>">
		<table cellspacing="1" class="tableStyle_membersWrite" summary="팝업창 추가">
		<legend class="blind">팝업창 추가</legend>
			<tr>
				<th>사이트</th>
				<td>
					<select name="logo">
					<option value="gadget"  <?php if($TPL_VAR["logo"]=="gadget"){?>  selected <?php }?>>gadget</option>
				</select>
				</td>
			 </tr>
			 <tr>
			<tr>
				<th>제목</th>
				<td><input type="text" name="P_SUBJECT" value="<?php echo $TPL_VAR["list"]["P_SUBJECT"]?>"  maxlength="50"/></td>
			 </tr>
			 <tr>
				<th>내용</th>
				<td><textarea name="P_CONTENT" style="height:300px;"><?php echo $TPL_VAR["list"]["P_CONTENT"]?></textarea></td>
			  </tr>
			  <tr>
				<th>팝업 사용</th>
				<td>
                    <input name="P_POPUP_U" type="radio" value="Y" <?php if($TPL_VAR["list"]["P_POPUP_U"]=="Y"){?>checked<?php }?>>사용함
                    <input name="P_POPUP_U" type="radio" value=N <?php if($TPL_VAR["list"]["P_POPUP_U"]=="N"){?>checked<?php }?>>사용안함

                    <input name="P_LOGIN_POPUP_U" type="checkbox" style="margin-left: 30px" <?php if($TPL_VAR["list"]["P_LOGIN_POPUP_U"]=="Y"){?>checked<?php }?>>로그인 팝업
                </td>
			  </tr>
			  <tr>
				<th>게재 기간 설정</th>
				<td>시작일 <input name="P_STARTDAY" type="text" class="date" value="<?php echo $TPL_VAR["list"]["P_STARTDAY"]?>" maxlength="10" onclick="new Calendar().show(this);"/> 마감일 <input name="P_ENDDAY" type="text" class="date"  value="<?php echo $TPL_VAR["list"]["P_ENDDAY"]?>" maxlength="10" onclick="new Calendar().show(this);"/></td>
			 </tr>
			  <!-- <tr>
				<th>위치/크기 설정</th>
				<td>left <input name="P_WIN_LEFT" type="text" class="w60" id="x" value="<?php echo $TPL_VAR["list"]["P_WIN_LEFT"]?>" maxlength="5" /> top <input name="P_WIN_TOP" type="text" class="w60"id="y" value="<?php echo $TPL_VAR["list"]["P_WIN_TOP"]?>" maxlength="5" /> width <input name="P_WIN_WIDTH" type="text" class="w60" id="w" value="<?php echo $TPL_VAR["list"]["P_WIN_WIDTH"]?>" maxlength="5" /> height <input name="P_WIN_HEIGHT" type="text" class="w60" id="h" value="<?php echo $TPL_VAR["list"]["P_WIN_HEIGHT"]?>" maxlength="5" /></td>
			  </tr> -->
			  <tr>
				<th>이미지</th>
				<td><input type="file" name="P_FILE" class="w600" onkeydown="alert('열기를 클릭하여 이미지를 선택하십시오!');return false"/><?php if($TPL_VAR["act"]=="edit"){?> <br><font color='red'>이미지 수정을 안할 경우 공백을 남겨주십시오.</font><?php }?></td>
			  </tr>
			  <tr>
				<th>링크 주소</td>
				<td><input name="P_MOVEURL" type="text" class="w600" id="url" value="<?php echo $TPL_VAR["list"]["P_MOVEURL"]?>" maxlength="80" /></td>
			  </tr>		
			  <tr>
		</table>
		  
		<div id="wrap_btn">
			<input type="submit" name="Submit3" value="등  록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'"/> <input name="submit22" type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="취  소" onclick="Javascript:window.history.go(-1)"/>
			<input name="type_id" type="hidden" value="2" />
		</div>
	</form>

</div>