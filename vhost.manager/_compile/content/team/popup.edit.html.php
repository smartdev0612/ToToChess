<?php
    $TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"]) ? 0 : count($TPL_VAR["category_list"]);
    $TPL_nation_list_1=empty($TPL_VAR["nation_list"]) || !is_array($TPL_VAR["nation_list"]) ? 0 : count($TPL_VAR["nation_list"]);
?>
<script language="JavaScript">
function This_Check()
{
	var f = document.team;

	if (f.team_name.value == "") {
		alert("리그명을 입력하세요."); 
		f.team_name.focus();
		return;
	}
	f.submit();
}
</script>
</head>
<div id="wrap_pop">

	<div id="pop_title">
		<h1>팀 정보수정</h1><p><a href="#"><img src="/img/btn_s_close.gif" onclick="self.close();"></a></p>
	</div>

<form name=team method="post" action="/team/popup_edit?mode=edit" enctype="multipart/form-data"> 
	<input type="hidden" name="team_sn" value="<?php echo $TPL_VAR["team_sn"]?>">
	<table cellspacing="1" class="tableStyle_membersWrite">
		<tr>
			<th>종목</th>
			<td>
                <?php echo $TPL_VAR["item"]["Sport_Name"]?>
			</td>
		</tr>
		<tr>
			<th>국가명</th>
			<td>
                <?php echo $TPL_VAR["item"]["Location_Name_Kor"]?>
			</td>
		</tr>
		<tr>
			<th>팀명</th>
			<td><input type="text" maxLength="20" value="<?php echo $TPL_VAR["item"]["Team_Name_Kor"]?>" name="team_name" class="inputStyle1"></td>
		</tr>
		<tr>
			<th>팀 이미지</th>
			<td>
				<p class="paddingTd">
                    <?php if($TPL_VAR["item"]["Team_Img"] != "") { ?>
                        <img src="<?php echo $TPL_VAR["item"]["Team_Img"]?>" width="40" height="30"><br>
                    <?php } ?>
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