<?php
	$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);
	$TPL_nation_list_1=empty($TPL_VAR["nation_list"]) || !is_array($TPL_VAR["nation_list"]) ? 0 : count($TPL_VAR["nation_list"]);
	$league_sn = $TPL_VAR["league_sn"];
	if($league_sn == 0) {
		$title = "리그 등록";
		$btnTitle = "등록하기";
		$kind = "";
		$lsports_league_sn = 0;
		$nation_sn = 0;
		$league_name = "";
		$league_name_en = "";
		$view_style = "";
		$link_url = "";
		$alias_name = "";
		$lg_img = "";
		$is_use = 0;
	} else {
		$title = "리그 정보수정";
		$btnTitle = "수정하기";
		$kind = $TPL_VAR["item"]["kind"];
		$lsports_league_sn = $TPL_VAR["item"]["lsports_league_sn"];
		$nation_sn = $TPL_VAR["item"]["nation_sn"];
		$league_name = $TPL_VAR["item"]["name"];
		$league_name_en = $TPL_VAR["item"]["name_en"];
		$view_style = $TPL_VAR["item"]["view_style"];
		$link_url = $TPL_VAR["item"]["link_url"];
		$alias_name = $TPL_VAR["item"]["alias_name"];
		$lg_img = $TPL_VAR["item"]["lg_img"];
		$is_use = $TPL_VAR["item"]["is_use"];
	}
?>
<script language="JavaScript">
function This_Check()
{
	var f = document.league;

	if (f.league_name.value == "") {
		alert("리그명을 입력하세요."); 
		f.league_name.focus();
		return;
	}

	if (f.league_kind.value == "") {
		alert("경기종목을 선택하세요."); 
		f.league_kind.focus();
		return;
	}

	if (f.nation_sn.value == "0") {
		alert("국가를 선택하세요."); 
		f.nation_sn.focus();
		return;
	}
	f.submit();

}

function nation_flag(url)
{
	window.open(url,'','resizable=no width=650 height=600 scrollbars=yes');
}
</script>
<style>
	.th-width {
		width: 20% !important;
	}

	.full-width {
		width: 80% !important;
	}
</style>
</head>
<div id="wrap_pop">

	<div id="pop_title">
		<h1><?=$title?></h1><p><a href="#"><img src="/img/btn_s_close.gif" onclick="self.close();"></a></p>
	</div>

<form name=league method="post" action="/league/popup_edit?mode=edit" enctype="multipart/form-data"> 
	<input type="hidden" name="before_kind" value="<?=$kind?>">
	<input type="hidden" name="league_sn" value="<?=$league_sn?>">
	<table cellspacing="1" class="tableStyle_membersWrite">
		<tr>
			<th>번호</th>
			<td>
				<input type="text" name="lsports_league_sn" value="<?=$lsports_league_sn?>"><br>
				<span style="color:red">이 번호는 API에 의해서 제공되므로 개발팀에 문의후 등록해주세요.</span>
			</td>
		</tr>
		<tr>
			<th>종목</th>
			<td>
				<select name="league_kind">
					<option value="">경기종목선택</option>
<?php if($TPL_category_list_1){foreach($TPL_VAR["category_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["name"]?>" <?php if($kind == $TPL_V1["name"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>국가명</th>
			<td>
				<select name="nation_sn">
					<option value="0">국가명</option>
<?php if($TPL_nation_list_1){foreach($TPL_VAR["nation_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["sn"]?>" <?php if($nation_sn == $TPL_V1["sn"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th class="th-width">리그명 (국문)</th>
			<td><input type="text" maxLength="100" value="<?=$league_name?>" name="league_name" class="full-width"></td>
		</tr>
		<tr>
			<th class="th-width">리그명 (영문)</th>
			<td><input type="text" maxLength="100" value="<?=$league_name_en?>" name="league_name_en" class="full-width"></td>
		</tr>
		<tr>
			<th>스타일</th>
			<td>
				<select name='view_style'>
					<option value='' <?php if($view_style==''){?> selected <?php }?>>일반</option>
					<option value='0' <?php if($view_style=='0'){?> selected <?php }?>>초록색</option>
					<option value='1' <?php if($view_style=='1'){?> selected <?php }?>>연노랑</option>
					<option value='2' <?php if($view_style=='2'){?> selected <?php }?>>하늘색</option>
					<option value='50' <?php if($view_style=='50'){?> selected <?php }?>>연빨강</option>
					<option value='51' <?php if($view_style=='51'){?> selected <?php }?>>연주황</option>
					<option value='52' <?php if($view_style=='52'){?> selected <?php }?>>연두색</option>
					<option value='53' <?php if($view_style=='53'){?> selected <?php }?>>청녹색</option>
					<option value='54' <?php if($view_style=='54'){?> selected <?php }?>>파랑색</option>
					<option value='55' <?php if($view_style=='55'){?> selected <?php }?>>연보라</option>
					<option value='56' <?php if($view_style=='56'){?> selected <?php }?>>연자주</option>
					<option value='57' <?php if($view_style=='57'){?> selected <?php }?>>하얀색</option>
					<option value='5' <?php if($view_style=='5'){?> selected <?php }?>>TOP경기</option>
					<option value='10' <?php if($view_style=='10'){?> selected <?php }?>>LINK 리그</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>LINK_URL</th>
			<td><input type="text" maxLength="100" value="<?=$link_url?>" name="link_url" class="full-width"></td>
		</tr>
		<tr>
			<th>매칭 리그명</th>
			<td><input type="text" maxLength="100" value="<?=$alias_name?>" name="alias_league_name" class="full-width"></td>
		</tr>
		<tr>
			<th>리그이미지</th>
			<td>
				<p class="paddingTd">
					<?php if($lg_img != "") { ?>
						<img src="<?=$lg_img?>" width="40" height="30"><br>
					<?php } ?>
					<input type="file" name="upLoadFile" size="50">
				</p>
			</td>
		</tr>
		<tr>
			<th>사용여부</th>
			<td>
				<input type="radio" name="is_use" value="1" <?=$is_use == 1 ? "checked" : ""?>>사용
				<input type="radio" name="is_use" value="0" <?=$is_use == 0 ? "checked" : ""?>>미사용
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
		<input type="button" value="<?=$btnTitle?>" onclick="This_Check()" class="btnStyle1">&nbsp;<input type="button" value=" 닫  기 " onclick="self.close();" class="btnStyle2">
	</div>

</form>

</div>