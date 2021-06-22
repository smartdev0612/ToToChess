<?php /* Template_ 2.2.3 2012/10/23 14:51:20 C:\APM_Setup\htdocs\www\vhost.partner\_template\content\memo\popup_list.html */?>
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
		<li><a href="memo_list.php" id="memo_list">받은 쪽지함</a></li>
		<li><a href="memo_sendlist.php" id="memo_sendlist">보낸 쪽지함</a></li>
		<li><a href="memo_write.php" id="memo_write">쪽지 쓰기</a></li>
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
  <?php
  /*
	$sql="select * from ".$db_qz."memoboard where logo='".$logo."' and toid='".$_SESSION["partner_name"]."'  and kubun='1' and isdelete='0' order by newreadnum asc,writeday desc";
	$db->mysql=$sql;
	$db->getresule();
	$totle=$db->getnum();
	$sql="select * from ".$db_qz."memoboard where logo='".$logo."' and  toid='".$_SESSION["partner_name"]."'  and kubun='1' and isdelete='0' order by newreadnum asc,writeday desc limit ".$page2.",".$page_size;
	$db->mysql=$sql;
	$db->getresule();
	
	while($db->getrow()){
		$mem_idx=$db->row["mem_idx"];
		$fromid=$db->row["fromid"];
		$title=$db->row["title"];
		$content=$db->row["content"];
		$writeday=$db->row["writeday"];
		$newreadnum=$db->row["newreadnum"];
		if($newreadnum==0){
			$newreadnum="안읽음";
		}
		if($newreadnum==1){
			$newreadnum="읽음";
		}
		*/
  ?>
	<tr>
		<td><?=$fromid?></td>
		<td><a href="memo_view.php?id=<?=$mem_idx?>" ><?=csubstr($title,0,35)?></td>
		<td><?=$writeday?></td>
		<td><?=$newreadnum?></td>
		<td><a href="memo_write.php"><img</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="comfire_ok('?act=del&id=<?=$mem_idx?>');">[삭제]</a></td>
	</tr>

  <?php
  
//	}
 // $db->dbclose();
  ?>
	</tbody>
	</table>
	<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

	</div>

</div>
</body>
</html>