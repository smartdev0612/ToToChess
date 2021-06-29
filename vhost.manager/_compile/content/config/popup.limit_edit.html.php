<script language="JavaScript">
	function This_Check()
	{
		var f = document.crossfrm;

		if (f.cross_script.value == "") {
			alert("조합스크립트를 입력하세요."); 
			f.cross_script.focus();
			return;
		}
		f.submit();
	}
</script>
</head>
<div id="wrap_pop">

	<div id="pop_title">
		<h1><?=($TPL_VAR["limit_id"] > 0) ? "배팅제한 편집" : "배팅제한 추가"?></h1>
		<p><a href="#"><img src="/img/btn_s_close.gif" onclick="self.close();"></a></p>
	</div>

<form name=crossfrm method="post" action="/config/crosslimit?act=save" enctype="multipart/form-data"> 
	<input type="hidden" name="limit_id" value="<?php echo $TPL_VAR["limit_id"]?>">
	<table cellspacing="1" class="tableStyle_membersWrite">
		<tr>
			<th>스크립트</th>
			<td>
			<?php 
			if($TPL_VAR["limit_id"] > 0) {
			?>
				<input type="text" id="cross_script" name="cross_script" value="<?=$TPL_VAR["script"]["cross_script"]?>" placeholder="Ex: 1+2">
			<?php } else {?>
				<input type="text" id="cross_script" name="cross_script" value="" placeholder="Ex: 1+2">
			<?php } ?>
			</td>
		</tr>
		<tr>
			<th>타입</th>
			<td>
				<select name="type_id">
				<?php 
				if($TPL_VAR["limit_id"] > 0) {
				?>
					<option value="1" <?=$TPL_VAR["script"]["type_id"] == 1 ? "selected" : ""?>>국내형</option>
					<option value="2" <?=$TPL_VAR["script"]["type_id"] == 2 ? "selected" : ""?>>해외형</option>
					<option value="3" <?=$TPL_VAR["script"]["type_id"] == 3 ? "selected" : ""?>>라이브</option>
				<?php } else {?>
					<option value="1">국내형</option>
					<option value="2">해외형</option>
					<option value="3">라이브</option>
				<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>종목</th>
			<td>
				<select name="sport_id">
				<?php 
				foreach($TPL_VAR["sport_list"] as $sport) { 
					if($TPL_VAR["limit_id"] > 0) { ?>
					<option value="<?=$sport["sn"]?>" <?=$TPL_VAR["script"]["sport_id"] == $sport["sn"] ? "selected" : ""?>><?=$sport["name"]?></option>
				<?php } else { ?>
					<option value="<?=$sport["sn"]?>"><?=$sport["name"]?></option>
				<?php }
				}
				?>
				</select>
			</td>
		</tr>
	</table>
	<div id="wrap_btn">
		<input type="button" value=" 보 관 " onclick="This_Check()" class="btnStyle1">&nbsp;<input type="button" value=" 닫  기 " onclick="self.close();" class="btnStyle2">
	</div>

</form>

</div>