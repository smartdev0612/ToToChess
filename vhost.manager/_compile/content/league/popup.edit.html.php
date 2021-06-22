<?php
$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);?>
<script language="JavaScript">
function This_Check()
{
	var f = document.league;

	if (f.league_name.value == "") {
		alert("리그명을 입력하세요."); 
		f.league_name.focus();
		return;
	}
	f.submit();

}
function nation_flag(url)
{
	window.open(url,'','resizable=no width=650 height=600 scrollbars=yes');
}
</script>
</head>
<div id="wrap_pop">

	<div id="pop_title">
		<h1>리그 정보수정</h1><p><a href="#"><img src="/img/btn_s_close.gif" onclick="self.close();"></a></p>
	</div>

<form name=league method="post" action="/league/popup_edit?mode=edit" enctype="multipart/form-data"> 
	<input type="hidden" name="before_kind" value="<?php echo $TPL_VAR["item"]["kind"]?>">
	<input type="hidden" name="league_sn" value="<?php echo $TPL_VAR["league_sn"]?>">
	<table cellspacing="1" class="tableStyle_membersWrite">
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
			<th>리그명</th>
			<td><input type="text" maxLength="20" value="<?php echo $TPL_VAR["item"]["name"]?>" name="league_name" class="inputStyle1"></td>
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
			<td><input type="text" maxLength="40" value="<?php echo $TPL_VAR["item"]["link_url"]?>" name="link_url" class="inputStyle1"></td>
		</tr>
		<tr>
			<th>매칭 리그명</th>
			<td><input type="text" maxLength="20" value="<?php echo $TPL_VAR["item"]["alias_name"]?>" name="alias_league_name" class="inputStyle1"></td>
		</tr>
		<tr>
			<th>리그이미지</th>
			<td>
				<p class="paddingTd">
					<img src="<?php echo $TPL_VAR["UPLOAD_URL"]?><?php echo $TPL_VAR["item"]["lg_img"]?>" width="40" height="30"><?php echo $TPL_VAR["item"]["lg_img"]?><br>
					<input type="file" name="upLoadFile" size="50">
				</p>
			</td>
		</tr>
		<!--
		<tr>
			<th>국가이미지</th>
			<td>
				<p class="paddingTd">
					<img src="<?php echo $TPL_VAR["UPLOAD_URL"]?>/upload/nation/<?php echo $TPL_VAR["item"]["nation_image"]?>" width="40" height="30"><?php echo $TPL_VAR["item"]["nation_code"]?>[<?php echo $TPL_VAR["item"]["nation_image"]?>]
					<input type="text" name="nationflag" size="3" value="<?php echo $TPL_VAR["item"]["nation_code"]?>" class="inputStyle1">
					<input type="button" value="국기"  onclick="window.open('/league/popup_nationlist?mode=list','','resizable=no width=650 height=600 scrollbars=yes');" class="btnStyle3">
				</p>
			</td>
		</tr>
		-->
	</table>
	<div id="wrap_btn">
		<input type="button" value="수정하기" onclick="This_Check()" class="btnStyle1">&nbsp;<input type="button" value=" 닫  기 " onclick="self.close();" class="btnStyle2">
	</div>

</form>

</div>