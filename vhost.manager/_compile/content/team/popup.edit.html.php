<?php
    $TPL_category_list=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);
	$TPL_nation_list=empty($TPL_VAR["nation_list"]) || !is_array($TPL_VAR["nation_list"]) ? 0 : count($TPL_VAR["nation_list"]);
	$TPL_league_list=empty($TPL_VAR["league_list"]) || !is_array($TPL_VAR["league_list"]) ? 0 : count($TPL_VAR["league_list"]);
	$team_sn = $TPL_VAR["team_sn"];
	if($team_sn == 0) {
		$title = "팀 등록";
		$btnTitle = "등록하기";
		$team_api_id = 0;
		$kind = "";
		$lsports_league_sn = 0;
		$nation_sn = 0;
		$team_name = "";
		$team_name_en = "";
		$team_img = "";
	} else {
		$title = "팀 정보수정";
		$btnTitle = "수정하기";
		$team_api_id = $TPL_VAR["item"]["Team_Id"];
		$kind = $TPL_VAR["item"]["Sport_Name"];
		$lsports_league_sn = $TPL_VAR["item"]["League_Id"];
		$nation_sn = $TPL_VAR["item"]["Location_Id"];
		$team_name = $TPL_VAR["item"]["Team_Name_Kor"];
		$team_name_en = $TPL_VAR["item"]["Team_Name"];
		$team_img = $TPL_VAR["item"]["Team_Img"];
	}
?>
<script language="JavaScript">
	$(document).ready(function() {
		$("#league").on("change", function() {
			var league_sn = $(this).val();
			var nation_sn = $(this).find(':selected').data('nation_sn');
			$("#nation_sn").val(nation_sn);
		});
	});

	function This_Check()
	{
		var f = document.team;
		if (f.team_name.value == "") {
			alert("팀명을 입력하세요."); 
			f.team_name.focus();
			return;
		}
		f.submit();
	}

	function listupLeague() {
		var kind = $("#kind").val();
		$.ajax({
			type: 'GET',
			url: "/league/getLeagueListByKind",
			dataType : 'text',
			data: {
				kind: kind
			},
			success: function(result) {
				console.log(result);
				var json = JSON.parse(result);
				$("#league").empty();
				var option = "<option value=''>리그명</option>";
				$.each(json, function(idx, e) {
					option += "<option value='" + e.lsports_league_sn + "' data-nation_sn='" + e.nation_sn + "'>" + e.name + "</option>";
				});
				$("#league").append(option);
			},
			error: function(e) {
				warning_popup(e.responseText);
			}
		});
	}

</script>
</head>
<div id="wrap_pop">

	<div id="pop_title">
		<h1><?=$title?></h1><p><a href="#"><img src="/img/btn_s_close.gif" onclick="self.close();"></a></p>
	</div>

<form name=team method="post" action="/team/popup_edit?mode=edit" enctype="multipart/form-data"> 
	<input type="hidden" name="team_sn" value="<?=$team_sn?>">
	<table cellspacing="1" class="tableStyle_membersWrite">
		<tr>
			<th>API 아이디</th>
			<td>
				<input type="text" maxLength="100" value="<?=$team_api_id?>" name="team_api_id"><br>
				<span style="color:red">이 번호는 API에 의해서 제공되므로 개발팀에 문의후 등록해주세요.</span>
			</td>
		</tr>
		<tr>
			<th>종목</th>
			<td>
				<select id="kind" name="kind" onChange="listupLeague();">
					<option value="">경기종목선택</option>
<?php if($TPL_category_list){foreach($TPL_VAR["category_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["name"]?>" <?php if($kind == $TPL_V1["name"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>리그명</th>
			<td>
				<select name="league" id="league" style="width:70%">
					<option value="0">리그명</option>
<?php if($TPL_league_list){foreach($TPL_VAR["league_list"] as $TPL_V1){?>
					<option value="<?=$TPL_V1["lsports_league_sn"]?>" data-nation_sn="<?=$TPL_V1["nation_sn"]?>" <?=($lsports_league_sn == $TPL_V1["lsports_league_sn"]) ? "selected" : ""?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>국가명</th>
			<td>
				<select id="nation_sn" name="nation_sn">
					<option value="0">국가명</option>
<?php if($TPL_nation_list){foreach($TPL_VAR["nation_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["sn"]?>" <?php if($nation_sn == $TPL_V1["sn"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>팀명 (국문)</th>
			<td><input type="text" maxLength="100" value="<?=$team_name?>" name="team_name"></td>
		</tr>
		<tr>
			<th>팀명 (영문)</th>
			<td><input type="text" maxLength="100" value="<?=$team_name_en?>" name="team_name_en"></td>
		</tr>
		<tr>
			<th>팀 이미지</th>
			<td>
				<p class="paddingTd">
                    <?php if($team_img != "") { ?>
                        <img src="<?=$team_img?>" width="40" height="30"><br>
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
		<input type="button" value="<?=$btnTitle?>" onclick="This_Check()" class="btnStyle1">&nbsp;<input type="button" value=" 닫  기 " onclick="self.close();" class="btnStyle2">
	</div>

</form>

</div>