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
		<form action="/gameUpload/popup_excelupload?mode=execl_collect" method="post" name="form2" id="form2" enctype='multipart/form-data'>								
			<!--<input type="hidden" id ="filepath" name="filepath" value="">-->
			<input type="file" name="fileUpload" size="50">
			<input type="submit" value="파일업로드">
			<!--<input type="button" value="파일업로드" onclick="FileUpload()">			-->
		</form>
		</div>
	</div>

	<table cellspacing="1" class="tableStyle_normal" summary="게임 정보">
	<thead>
		<tr>
			<th>종목</th>
			<th>게임옵션</th>
			<th>게임구분</th>
			<th>일자</th>
			<th>시간</th>
			<th>분</th>
			<th>리그명</th>
			<th>홈팀</th>
			<th>원정팀</th>
			<th>배당1</th>
			<th>배당2</th>
			<th>배당3</th>
			
		</tr>
	</thead>
	<tbody>
<?php if($TPL_gamearray_1){foreach($TPL_VAR["gamearray"] as $TPL_V1){?>			
		<tr>
			<td><?php echo $TPL_V1["cate_name"]?></td>					
			<td><?php echo $TPL_V1["kind"]?></td>					
			<td><?php echo $TPL_V1["game_type"]?></td>
			<td><?php echo $TPL_V1["game_date"]?></td>
			<td><?php echo $TPL_V1["gameHour"]?></td>			
			<td><?php echo $TPL_V1["gameTime"]?></td>			
			<td><?php echo $TPL_V1["league_name"]?></td>			
			<td><?php echo $TPL_V1["home_team"]?></td>			
			<td><?php echo $TPL_V1["away_team"]?></td>			
			<td><?php echo $TPL_V1["home_rate"]?></td>			
			<td><?php echo $TPL_V1["draw_rate"]?></td>
			<td><?php echo $TPL_V1["away_rate"]?></td>			
		</tr>
<?php }}?>	
	</tbody>
	</table>

	<div id="wrap_btn">
		<a href="#" onclick="window.close()"><img src="/img/btn_close.gif" title="창닫기"></a>
	</div>
</div>