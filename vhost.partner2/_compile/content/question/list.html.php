<?php /* Template_ 2.2.3 2012/10/27 20:20:07 D:\www\vhost.partner\_template\content\question\list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<title>1:1문의내역</title>

<script>
function show(c_Str)
{if(document.all(c_Str).style.display=='none')
{document.all(c_Str).style.display='block';}
else{document.all(c_Str).style.display='none';}}
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

<body>

<div id="wrap">

	<h1>1:1문의내역</h1>

	
	<form name="form2">

	<table cellspacing="1" class="tableStyle_normal" summary="1:1문의내역">
	<legend class="blind">1:1문의내역</legend>
	<thead>
	<tr>
		<th>제목</th>
		<th>상태</th>
		<th>날짜</th>
	</tr>
	</thead>
	<tbody>
	
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';" height="22" >
			<td><a href="javascript:void(0);" onclick="show('content<?php echo $TPL_V1["num"]?>');"><?php echo $TPL_V1["subject"]?></a></td>
			<td><?php if($TPL_V1["result"]==0){?>미답변<?php }else{?>답변<?php }?></td>
			<td><?php echo $TPL_V1["regdate"]?></td>
		</tr>
		<tr id="content<?php echo $TPL_V1["num"]?>" style="display:none;" bgcolor="#f5faf5">
			<td colspan="3">내용:<textarea cols="134"  rows="4" style="border:1px solid;border-color:#cccccc #cccccc #cccccc #cccccc;" readonly><?php echo $TPL_V1["content"]?></textarea>
<?php if($TPL_V1["sub_size"]!=0){?>
			답변:<textarea cols="60" rows="4" style="border:1px solid;border-color:#cccccc #cccccc #cccccc #cccccc;" readonly><?php echo $TPL_V1["sub_content"]?></textarea>
<?php }?>
			</td>
		</tr>
<?php }}?>
	
	</tbody>
	</table>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
	<div id="wrap_btn">
		<input type="button" value="문의하기" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="window.open('/Question/popup_write','question','width=700,height=430');">
	</div>

	</form>

</div>