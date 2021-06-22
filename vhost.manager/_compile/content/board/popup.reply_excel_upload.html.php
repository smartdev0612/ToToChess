<?php
$TPL_replyarray_1=empty($TPL_VAR["replyarray"])||!is_array($TPL_VAR["replyarray"])?0:count($TPL_VAR["replyarray"]);?>
<script language="JavaScript">
	function _close()
	{
		window.opener.location.reload();
		window.close();
	}
</script>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>Excel Reply Upload</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<div id="search">
		<div>
		<form action="/board/popup_reply_excelupload?mode=execl_collect" method="post" name="form1" id="form1" enctype='multipart/form-data'>							
			<input type="hidden" name='id' value='<?php echo $TPL_VAR["id"]?>'>
			<input type="file" name="fileUpload" size="50">
			<input type="submit" value="파일업로드">
		</form>
		</div>
	</div>

	<table cellspacing="1" class="tableStyle_normal" summary="업로드 정보">
	<thead>
		<tr>
			<th>닉네임</th>
			<th>comment</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_replyarray_1){foreach($TPL_VAR["replyarray"] as $TPL_V1){?>			
		<tr>
			<td><?php echo $TPL_V1["nick"]?></td>					
			<td><?php echo $TPL_V1["comment"]?></td>			
		</tr>
<?php }}?>	
	</tbody>
	</table>

	<div id="wrap_btn">
		<a href="#" onclick="_close()"><img src="/img/btn_close.gif" title="창닫기"></a>
	</div>
</div>