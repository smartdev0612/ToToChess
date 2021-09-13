<?php
$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);?>
<script language="JavaScript">
function This_Check()
{
	var f = document.league;
	
	if (f.category.value == "") {
		alert("경기종류를 선택 하십시오."); 
		f.category.focus();
		return;
	}
	if (f.league_name.value == "") {
		alert("리그명을 입력하세요."); 
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
			<th>번호</th>
			<td>
				<br>
				<input type="text" name="lsports_league_sn" value="<?php echo $TPL_VAR["league_sn"]?>"><br>
				<span style="color:red;">※이 번호는 해당 API에서 제공되므로 개발팀에 문의후 등록해주세요.</span>
			</td>
		</tr>
		<tr>
			<th>종목</th>
			<td>
				<select name="league_kind">
					<option value="">경기종류선택</option>
<?php if($TPL_category_list_1){foreach($TPL_VAR["category_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["item"]["kind"]==$TPL_V1["name"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>국가명</th>
			<td>
				<select name="nation_sn">
					<option value="">국가명</option>
<?php if($TPL_nation_list_1){foreach($TPL_VAR["nation_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["sn"]?>" <?php if($TPL_VAR["item"]["nation_sn"]==$TPL_V1["sn"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>리그명</th>
			<td><input type="text" maxLength="100" value="<?php echo $TPL_VAR["item"]["name"]?>" name="league_name" class="inputStyle1"></td>
		</tr>
		<tr>
			<th>스타일</th>
			<td>
				<select name='view_style'>
					<option value='' <?php if($TPL_VAR["item"]["view_style"]==''){?> selected <?php }?>>일반</option>
					<option value='0' <?php if($TPL_VAR["item"]["view_style"]=='0'){?> selected <?php }?>>초록색</option>
					<option value='1' <?php if($TPL_VAR["item"]["view_style"]=='1'){?> selected <?php }?>>연노랑</option>
					<option value='2' <?php if($TPL_VAR["item"]["view_style"]=='2'){?> selected <?php }?>>하늘색</option>
					<option value='50' <?php if($TPL_VAR["item"]["view_style"]=='50'){?> selected <?php }?>>연빨강</option>
					<option value='51' <?php if($TPL_VAR["item"]["view_style"]=='51'){?> selected <?php }?>>연주황</option>
					<option value='52' <?php if($TPL_VAR["item"]["view_style"]=='52'){?> selected <?php }?>>연두색</option>
					<option value='53' <?php if($TPL_VAR["item"]["view_style"]=='53'){?> selected <?php }?>>청녹색</option>
					<option value='54' <?php if($TPL_VAR["item"]["view_style"]=='54'){?> selected <?php }?>>파랑색</option>
					<option value='55' <?php if($TPL_VAR["item"]["view_style"]=='55'){?> selected <?php }?>>연보라</option>
					<option value='56' <?php if($TPL_VAR["item"]["view_style"]=='56'){?> selected <?php }?>>연자주</option>
					<option value='57' <?php if($TPL_VAR["item"]["view_style"]=='57'){?> selected <?php }?>>하얀색</option>
					<option value='5' <?php if($TPL_VAR["item"]["view_style"]=='5'){?> selected <?php }?>>TOP경기</option>
					<option value='10' <?php if($TPL_VAR["item"]["view_style"]=='10'){?> selected <?php }?>>LINK 리그</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>LINK_URL</th>
			<td><input type="text" maxLength="40" name="link_url" class="inputStyle1"></td>
		</tr>
		<tr>
			<th>매칭 리그명</th>
			<td><input type="text" maxLength="20" name="alias_league_name" class="inputStyle1"></td>
		</tr>
		<tr>
			<th>리그이미지</th>
			<td>
				<p class="paddingTd">
					<img src="<?php echo $TPL_VAR["item"]["lg_img"]?>" width="40" height="30"><br>
					<input type="file" name="upLoadFile" size="50">
				</p>
			</td>
		</tr>
		<tr>
			<th>사용여부</th>
			<td>
				<input type="radio" name="is_use" value="1" <?=$TPL_VAR["item"]["is_use"] == 1 ? "checked" : ""?>>사용
				<input type="radio" name="is_use" value="0" <?=$TPL_VAR["item"]["is_use"] == 0 ? "checked" : ""?>>미사용
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