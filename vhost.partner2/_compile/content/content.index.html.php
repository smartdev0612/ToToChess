<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
		
	function show(c_Str)
	{
		if(document.all(c_Str).style.display=='none')
		{
				document.all(c_Str).style.display='block';
		}
		else
		{
			document.all(c_Str).style.display='none';
		}
	}
	function high(){
		if (event.srcElement.className=="k")
		{
			event.srcElement.style.background="336699"			
			event.srcElement.style.color="white"
		}
	}
	function low(){
		if (event.srcElement.className=="k")
		{
			event.srcElement.style.background="99CCFF"
			event.srcElement.style.color=""
		}
	}
	
	function copy()
	{
	  var obj = document.getElementById('url'); 
	   obj.select();
	   js = obj.createTextRange();
	   js.execCommand("Copy");
	   alert("복사되었습니다!");
	}
	
</script>		

	<div id="index_img"></div>

	<p class="icon_book"><b><?php echo $TPL_VAR["id"]?></b>님 로그인 ·회원수[오늘 <?php echo $TPL_VAR["countday"]?>명/전체 <?php echo $TPL_VAR["countmem"]?>명] ·보유금액 [<?php echo number_format($TPL_VAR["countmoney"],0)?>원/<?php echo $TPL_VAR["countmem"]?>명]</p>

	<table cellspacing="1" class="tableStyle_normal" summary="공지사항">
		<legend class="blind">공지사항</legend>
		<thead>
		<tr>
			<th colspan="3">공지사항</th>
		</tr>
		</thead>
		<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr>
					<td><a href="javascript:void(0);" onclick="show('content<?php echo $TPL_V1["num"]?>');"><?php echo $TPL_V1["title"]?></td><td><?php echo $TPL_V1["nick"]?></td><td><?php echo $TPL_V1["regdate"]?></td>
				</tr>
				<tr id="content<?php echo $TPL_V1["num"]?>" style="display:none;">
					<td colspan="3"><?php echo $TPL_V1["content"]?></td>
				</tr>
<?php }}?>
		</tbody>
	</table>

<!--
	<table cellspacing="1" class="tableStyle_normal ptnInfo" summary="광고 주소">
		<legend class="blind">광고 주소</legend>
		<thead>
		  <tr>
			<th colspan="2">광고 주소</th>
		  </tr>
		</thead>
		<tbody>
		  <tr>
			<th>광고 주소</th>
			<td><input type="text" value="<?php echo $TPL_VAR["partadd"]?>/?partner=<?php echo $TPL_VAR["sn"]?>" class="w600"  id="url" readonly>
				<input type="button" value="복사하기" onclick="copy()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
			</td>
		  </tr>
		</tbody>
	</table>

	<table cellspacing="1" class="tableStyle_normal ptnInfo" summary="파트너 정보">
	<legend class="blind">파트너 정보</legend>
	<thead>
	  <tr>
		<th colspan="2">파트너 정보</th>
	  </tr>
	</thead>
	<tbody>
	  <tr>
		<th>파트너 등급</th>
		<td><?php echo $TPL_VAR["lev"]?> Level</td>
	  </tr>
	  <tr>
		<th>정산 비율</th>
		<td><?php echo $TPL_VAR["rate"]?>%</td>
	  </tr>
	</tbody>
	</table>
-->