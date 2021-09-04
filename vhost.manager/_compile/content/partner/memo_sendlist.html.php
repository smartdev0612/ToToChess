<?php
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<script>
function show(c_Str) {
	$("#"+c_Str).toggle();
}

function high()
{
	if (event.srcElement.className=="k")
	{
		event.srcElement.style.background="336699"
		event.srcElement.style.color="white"
	}
}

function low()
{
	if (event.srcElement.className=="k")
	{
	event.srcElement.style.background="99CCFF"
	event.srcElement.style.color=""
	}
}

function go_del(url)
{
	if(confirm("정말 삭제하시겠습니까?"))
	{
		document.location = url;
	}
	else
	{
		return;
	}
}

</script>

<div class="wrap" id="partner_memo">

	<div id="route">
		<h5>관리자 시스템 > 파트너 관리 > <b>파트너 쪽지</b></h5>
	</div>

	<h3>파트너 쪽지</h3>

	<ul id="tab">
		<li><a href="/partner/memolist?p_type=<?=$TPL_VAR["p_type"]?>" id="partner_memo_box">받은 쪽지함</a></li>
		<li><a href="/partner/memosendlist?p_type=<?=$TPL_VAR["p_type"]?>" id="partner_memo">보낸 쪽지함</a></li>
		<li><a href="/partner/memoadd?p_type=<?=$TPL_VAR["p_type"]?>" id="partner_memo_add">쪽지 쓰기</a></li>
	</ul>

	<form id="form1" name="form1" method="post" action="?act=alldel">
		<table cellspacing="1" class="tableStyle_normal add" summary="파트너 보낸 쪽지함">
		<legend class="blind">보낸 쪽지함</legend>
		<thead>
			<tr>
				<th scope="col" style="width:35px;" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
				<th scope="col" style="width:150px;">받는 사람</th>
				<th scope="col" style="width:170px;">날짜</th>
				<th scope="col">내용</th>
				<th scope="col" style="width:100px;">상태</th>  
				<th scope="col" style="width:70px;">처리</th>  
			</tr>
		</head>
		<tbody>	
<?php
	if ( $TPL_list_1 ) {
		foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
			$idx = $TPL_V1["mem_idx"];
			if ( $TPL_V1["newreadnum"] == 1 ) $state = "읽음";
			else $state = "읽지않음";
?>	
			<tr>
				<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $idx?>"  onclick="javascript:chkRow(this);"/></td>
				<td><?php echo $TPL_V1["toid"]?></td>
				<td><?php echo $TPL_V1["writeday"]?></td>
				<td onclick="show('content<?php echo $idx?>')" style="cursor:pointer"><?php echo $TPL_V1["title"]?></td>
				<td><?php echo $state?></td>
				<td><a href="javascript:;" onclick="go_del('?act=del&id=<?php echo $idx?>');"><img src="/img/btn_s_del.gif" title="삭제"></a></td>   
			</tr>
			<tr id="content<?php echo $idx?>" style="display:none;" bgcolor="#f1f1f1">
				<td colspan="6" align="right"><div class="memo_answer"><?php echo $TPL_V1["content"]?></div></td>
			</tr>
<?php
		}
	}
?>
		</tbody>
		</table>
		<div id="pages2">
			<?php echo $TPL_VAR["pagelist"]?>
		</div>
		<div id="wrap_btn">	
			<input type="button" name="open" value="선택삭제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
      		<input type="button" name="Submit22" value="쪽지쓰기" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="window.location='/partner/memoadd?p_type=<?=$TPL_VAR["p_type"]?>'"/>
		</div>
	</form>
</div>