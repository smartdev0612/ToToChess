<?php
$TPL_broadcasts_1=empty($TPL_VAR["broadcasts"])||!is_array($TPL_VAR["broadcasts"])?0:count($TPL_VAR["broadcasts"]);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>합계</title>

<script>
	function on_fin(period/*2=전반마감, 4=후반,풀타임마감*/)
	{
		document.frm.period.value=period;
		document.frm.submit();
	}
</script>

</head>

<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h2>수동 마감</h2>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<form name="frm" method="post" action="/LiveGame/manual_finProcess">
		<input type="hidden" name="period">
		<input type="hidden" name="live_sn" value="<?php echo $TPL_VAR["live_sn"]?>">
		
		<table cellspacing="1" class="tableStyle_normal" summary="게임 상세 정보">
		<legend class="gameDetail_name"><?php echo $TPL_VAR["list"]["home_team"]?><span>VS</span><?php echo $TPL_VAR["list"]["away_team"]?></legend>
		<thead>
			<tr>
				<th colspan="3">전반전</th>
				<th colspan="3">풀타임</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="15%"><?php if($TPL_VAR["list"]["first_score"]=='-1'){?><input type="text" name="first_home_score" ><?php }else{?><?php echo $TPL_VAR["list"]["first_score_0"]?><?php }?></td>
				<td width="15%"><?php if($TPL_VAR["list"]["first_score"]=='-1'){?><input type="text" name="first_away_score" ><?php }else{?><?php echo $TPL_VAR["list"]["first_score_1"]?><?php }?></td>
				<td width="20%"><?php if($TPL_VAR["list"]["first_score"]=='-1'){?><input type="button" value="(전)마감"  class="btnStyle3" onClick="on_fin(2)"><?php }else{?>완료<?php }?></td>
				<td width="15%"><input type="text" name="second_home_score" ></td>
				<td width="15%"><input type="text" name="second_away_score"></td>
				<td width="20%"><input type="button" value="마감"  class="btnStyle3" onClick="on_fin(4)"></td>
			</tr>
		</tbody>
		</table>
		
<?php if($TPL_broadcasts_1){foreach($TPL_VAR["broadcasts"] as $TPL_V1){?>
			[ <?php echo $TPL_V1["timer"]?> ]  <?php echo $TPL_V1["content"]?> <br>
<?php }}?>
	</form>

</div>
</body>
</html>