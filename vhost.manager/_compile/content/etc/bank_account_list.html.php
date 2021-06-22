<?php /* Template_ 2.2.3 2012/12/19 23:06:02 D:\www\vhost.manager\_template\content\etc\bank_account_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
</head>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>회원 은행계좌 관리</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<table cellspacing="1" class="tableStyle_normal">
	<legend class="blind">IP 차단 관리</legend>
	<thead>
		<tr>
			<th width="18%">변경일</th>
			<th width="43%">은행명</th>
			<th width="25%">계좌번호</th>
			<th width="14%">예금주</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["regdate"]?></td>
				<td><?php echo $TPL_V1["bank_name"]?></td>
				<td align="center"><?php echo $TPL_V1["bank_account"]?></td>
				<td align="center"><?php echo $TPL_V1["bank_member"]?></td>
			</tr>
<?php }}?>
	</tbody>
	</table>
</body>
</html>