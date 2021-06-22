<?php
$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);?>
<script language="JavaScript">
function This_Check()
{
	var f = document.league;
	
	if (f.category.value == "") {
		alert("    경기종류를 선택 하십시오.        "); 
		f.category.focus();
		return;
	}
	if (f.league_name.value == "") {
		alert("    리그명을 입력하세요.        "); 
		f.league_name.focus();
		return;
	}
	f.submit();

}

function nation_flag(url){
	window.open(url,'','resizable=no width=650 height=600 scrollbars=yes');
}
</script>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>리그 등록</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<form name=league method=post action="/league/addProcess" enctype="multipart/form-data"> 
	<table cellspacing="1" class="tableStyle_membersWrite">	
		<tr>
			<th>종목</th>
			<td>
				<select name="category">
					<option value="">경기종류선택</option>
<?php if($TPL_category_list_1){foreach($TPL_VAR["category_list"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["name"]?>" ><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>리그명</th>
			<td><input type="text" maxLength="20" value="" name="league_name"></td>
		</tr>
		<tr>
			<th>리그이미지</th>
			<td><input type="file" name="upLoadFile" size="50"></td>
		</tr>
		<tr>
			<th>국가이미지</th>
			<td>
				<input type="text" name="nationflag" size="3" value="">
				<input type="button" value="국기"  onclick="window.open('/league/popup_nationlist?mode=list','','resizable=no width=650 height=600 scrollbars=yes');" class="btnStyle3"></td>
			</td>
		</tr>
	</table>
	<div id="wrap_btn">
		<input type="button" value="등  록" onclick="This_Check()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'";>
		<input type="button" value="돌아가기" onclick="window.close()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'";>
	</div>	

</div>
</form>
</body>
</html>