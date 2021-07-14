<?php /* Template_ 2.2.3 2012/11/30 16:56:52 D:\www\vhost.partner\_template\content\memo\popup.sendlist.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<title>보낸 쪽지함</title>

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
<script>
function show(c_Str)
{
	$("#"+c_Str).toggle();
}
	
function high(){
	if (event.srcElement.className=="k"){
		event.srcElement.style.background="336699"
		event.srcElement.style.color="white"
	}
}

function low(){
	if (event.srcElement.className=="k"){
		event.srcElement.style.background="99CCFF"
		event.srcElement.style.color=""
	}
}
</script>
</head>

<body id="memo_sendlist">

<div id="wrap_pop">

	<div id="pop_title">
		<h1>보낸 쪽지함</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<ul id="tab">
		<li><a href="/memo/popup_list" id="memo_list">받은 쪽지함</a></li>
		<li><a href="/memo/popup_sendlist" id="memo_sendlist">보낸 쪽지함</a></li>
		<li><a href="/memo/popup_write" id="memo_write">쪽지 쓰기</a></li>
	</ul>

	<table cellspacing="1" class="tableStyle_normal" summary="받은 쪽지함">
	<legend class="blind">받은 쪽지함</legend>
	<thead>
	<tr>
		<th>받는이</th>
		<th>제목</th>
		<th>날짜</th>
	
	</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>	
		<tr>
			<td><?php echo $TPL_V1["toid"]?></td>
			<td><a href="javascript:void(0)" onclick="show('content<?php echo $TPL_V1["idx"]?>')" ><?php echo $TPL_V1["title"]?></td>
			<td><?php echo $TPL_V1["writeday"]?></td>		
		</tr>
		<tr style="display:none;" id="content<?php echo $TPL_V1["idx"]?>">
			<td colspan="3"><?php echo $TPL_V1["content"]?></td>
		</tr>
<?php }}?>
	
	</tbody>
	</table>
	<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>
</body>
</html>