<?php
	$TPL_sub_item_1=empty($TPL_VAR["sub_item"])||!is_array($TPL_VAR["sub_item"])?0:count($TPL_VAR["sub_item"]);
?>
<table class="tablestyle_normal" cellspacing="1">
	<thead>
		<tr>
			<th>아이디</th>
			<th>닉네임</th>
			<th>수수료(%)</th>
			<th>누적포인트</th>
			<th>누적회원수</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $TPL_VAR["item"]["uid"]?></td>
			<td><?php echo $TPL_VAR["item"]["nick"]?></td>
			<td class="rc_rate"><?php echo $TPL_VAR["item"]["rate"]?>%</td>
			<td class="rc_point"><?php echo number_format($TPL_VAR["item"]["benefit"],0)?></td>
			<td><?php echo $TPL_VAR["item"]["sub_count"]?></td>
		</tr>
	</tbody>
</table>

<table class="tablestyle_normal" cellspacing="1" id="skin2">
	<thead>
		<tr>
			<th>추천아이디</th>
			<th>닉네임</th>
			<th>누적포인트</th>
		</tr>
	</thead>
	<tbody>
<?php
	if ( $TPL_sub_item_1 ) {
		foreach ( $TPL_VAR["sub_item"] as $TPL_V1 ) {
?>
		<tr>
			<td><?php echo $TPL_V1["uid"]?></td>
			<td><?php echo $TPL_V1["nick"]?></td>
			<td class="rc_point"><?php echo number_format($TPL_V1["benefit"],0)?></td>
		</tr>
<?php
		}
	} else {
?>
			<tr><td colspan="4">내역이 없습니다</td></tr>
<?php
	}
?>
	</tbody>
</table>