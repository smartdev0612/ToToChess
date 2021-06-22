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

	if (FormData.P_POPUP_U.value=="")
		{
		alert("사용여무을 선택하십시오.")
		FormData.P_POPUP_U.focus();
		return (false);
		}
	return (true);
}
</script>

<div class="wrap" id="popup_add">

	<div id="route">
		<h5>관리자 시스템 > 시스템 관리 > <b>이벤트 설정</b></h5>
	</div>

	<h3>이벤트 설정</h3>

	<ul id="tab">
		<li><a href="/config/eventlist" id="popup">이벤트 목록</a></li>
		<li><a href="/config/eventadd" id="popup_add">이벤트 추가</a></li>
	</ul>

	<form action="/config/eventProcess" method="post" enctype="multipart/form-data" name="FormData" onsubmit="return chk_form();">
		<input type= "hidden" name = "idx" Value = "<?php echo $TPL_VAR["idx"]?>">
		<input type= "hidden" name = "act" Value = "<?php echo $TPL_VAR["act"]?>">
		<table cellspacing="1" class="tableStyle_membersWrite" summary="이벤트 추가">
		<legend class="blind">이벤트 추가</legend>
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
				<td><input type="text" name="P_SUBJECT" value="<?php echo $TPL_VAR["list"]["subject"]?>"  maxlength="50"/></td>
			 </tr>
			 <tr>
				<th>내용</th>
				<td>
                    <img src="http://sona1k.com<?php echo $TPL_VAR["list"]["file"]?>" width="500">
                </td>
			  </tr>
			  <tr>
				<th>팝업 사용</th>
				<td>
                    <input name="P_POPUP_U" type="radio" value="Y" <?php if($TPL_VAR["list"]["is_use"] == null || $TPL_VAR["list"]["is_use"]=="Y"){?>checked<?php }?>>사용함
                    <input name="P_POPUP_U" type="radio" value=N <?php if($TPL_VAR["list"]["is_use"]=="N"){?>checked<?php }?>>사용안함
                </td>
			  </tr>
			  <tr>
				<th>이미지</th>
				<td><input type="file" name="P_FILE" class="w600" onkeydown="alert('열기를 클릭하여 이미지를 선택하십시오!');return false"/><?php if($TPL_VAR["act"]=="edit"){?> <br><font color='red'>이미지 수정을 안할 경우 공백을 남겨주십시오.</font><?php }?></td>
			  </tr>
			  <tr style="display: none">
				<th>링크 주소</td>
				<td><input name="P_MOVEURL" type="text" class="w600" id="url" value="<?php echo $TPL_VAR["list"]["file"]?>" maxlength="80" style="display: none"/>
                </td>
			  </tr>		
			  <tr>
		</table>
		  
		<div id="wrap_btn">
			<input type="submit" name="Submit3" value="등  록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'"/> <input name="submit22" type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="취  소" onclick="Javascript:window.history.go(-1)"/>
			<input name="type_id" type="hidden" value="2" />
		</div>
	</form>

</div>