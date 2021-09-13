<?php
$TPL_gamearray_1=empty($TPL_VAR["gamearray"])||!is_array($TPL_VAR["gamearray"])?0:count($TPL_VAR["gamearray"]);?>
<script language="JavaScript">
	
function FileUpload()
{
	/*
	if (document.form2.fileUpload.value == "")
	{
		alert("업로드할 파일을 선택하여 주십시오.! "); 
		return;
	}
	
	document.getElementById("fileUpload").select();
	var path = document.getElementById('filepath').value = document.selection.createRange().text.toString();
	
	alert("value: "+path);
	*/
	document.form2.submit();
}

</script>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>Excel Upload</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<div id="search">
		<div>
		<form action="/gameUpload/popup_excelupload?mode=excel_collect" method="post" name="form2" id="form2" enctype='multipart/form-data'>								
			<!--<input type="hidden" id ="filepath" name="filepath" value="">-->
			<input type="file" name="fileUpload" size="50">
			<input type="submit" value="파일업로드">
			<!--<input type="button" value="파일업로드" onclick="FileUpload()">			-->
		</form>
		</div>
	</div>

	<div id="wrap_btn">
		<a href="#" onclick="window.close()"><img src="/img/btn_close.gif" title="창닫기"></a>
	</div>
</div>