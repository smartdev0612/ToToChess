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

<form name=league method="post" action="/leagueBlock/popup_edit?mode=edit" enctype="multipart/form-data">
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
			<td><input type="text" maxLength="100" value="<?php echo $TPL_VAR["item"]["name"]?>" name="league_name" class="inputStyle1"></td>
		</tr>
	</table>
	<div id="wrap_btn">
		<input type="button" value="수정하기" onclick="This_Check()" class="btnStyle1">&nbsp;<input type="button" value=" 닫  기 " onclick="self.close();" class="btnStyle2">
	</div>

</form>

</div>