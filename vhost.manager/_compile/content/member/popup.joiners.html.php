<?php
$TPL_joiners_1=empty($TPL_VAR["joiners"])||!is_array($TPL_VAR["joiners"])?0:count($TPL_VAR["joiners"]);?>
</head>
	
<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>가입시킨 회원정보</h1>
	</div>

	<table cellspacing="1" class="tableStyle_normal" summary="회원정보">
	<legend class="blind">회원목록</legend>
	<thead>
		<tr>
		  <th>아이디</th>
		  <th>닉네임</th>
		  <th>보유머니</th>
		  <th>보유포인트</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_joiners_1){foreach($TPL_VAR["joiners"] as $TPL_V1){?>
			<tr class="link_lan" style="padding-left:1px;"  onMouseOver="this.style.backgroundColor='#e0eafe';" onMouseOut="this.style.backgroundColor=''" >
				<td title="상세정보"><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></a></td>        
				<td><?php echo $TPL_V1["nick"]?></td>
				<td><?php echo $TPL_V1["g_money"]?></td>
				<td><?php echo $TPL_V1["point"]?></td>
			</tr>
<?php }}?>
	</tbody>
	</table>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>

</body>
</html>