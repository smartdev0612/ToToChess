<?php /* Template_ 2.2.3 2013/01/02 14:42:46 D:\www\vhost.partner\_template\content\memo\popup.list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<title>받은 쪽지함</title>

<script>
function comfire_ok(url)
	{
		falg=window.confirm("정말 삭제하시겠습니까?"); 
		if(falg)
		{
			location.href=url;
		}
	}
</script>
</head>

<body id="memo_list">

<div id="wrap_pop">

	<div id="pop_title">
		<h1>받은 쪽지함</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<ul id="tab">
		<li><a href="/memo/popup_list" id="memo_list">받은 쪽지함</a></li>
		<li><a href="/memo/popup_sendlist" id="memo_sendlist">보낸 쪽지함</a></li>
		<li><a href="/memo/popup_write" id="memo_write">쪽지 쓰기</a></li>
	</ul>

	<form name="Form1" action="?act=change" method="post">
	<table cellspacing="1" class="tableStyle_normal" summary="받은 쪽지함">
	<legend class="blind">받은 쪽지함</legend>
	<thead>
	<tr>
		<th>보낸이</th>
		<th>제목</th>
		<th>날짜</th>
		<th>상태</th>
		<th>처리</th>
	</tr>
	</thead>
	<tbody>		 
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["fromid"]?></td>
			<td><a href="/memo/popup_view?id=<?php echo $TPL_V1["mem_idx"]?>" ><?php echo $TPL_V1["title"]?></td>
			<td><?php echo $TPL_V1["writeday"]?></td>
			<td>
<?php if($TPL_V1["newreadnum"]==0){?>안읽음
<?php }else{?>읽음
<?php }?>
			</td>
			<td><a href="/memo/popup_write"><img</a>&nbsp;&nbsp;<a href="#" onclick="comfire_ok('?act=del&memo_sn=<?php echo $TPL_V1["mem_idx"]?>');">[삭제]</a></td>
		</tr>
<?php }}?>
  
	</tbody>
	</table>
	<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

	</div>
	</form>

</div>
</body>
</html>