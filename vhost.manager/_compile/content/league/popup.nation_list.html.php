<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script language=JavaScript>
	function changeGame(obj){
		window.location = "?GameKind="+obj.value;
	}

	function imgSource_write(imgIdx,imgName) {
		opener.league.nationflag.value = imgIdx
		alert (imgName + " 국가를 선택했습니다.")
		window.close();
	}

	function CheckForm()
	{
		fm = document.league;		
		if(fm.emblemname.value=="")
		{
			alert("검색 국가를 입력하세요.");
			return false;
			fm.emblemname.focus();	
		}else{
			fm.submit();	
		}	
	}
</script>

</head>

<div id="wrap_pop">

	<div id="pop_title">
		<h1>국가 목록 리스트</h1><p><a href="#"><img src="/img/btn_s_close.gif" onclick="self.close();"></a></p>
	</div>
	<div id="pop_search">
		<form name="league" method="post" action="nation_list.php?mode=link">
			<input type="text" name="emblemname" size="25" value="<?php echo $TPL_VAR["name"]?>" class="inputStyle1"><input type="button" name="Submit" value=" 검 색 " onclick="return CheckForm()" class="btnStyle3">
		</form>
	</div>

	<table cellspacing="1" class="tableStyle_normal">
	<thead>
		<tr>
			<th>이미지</th>
			<th>국가</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
			<td>
<?php if($TPL_V1["lg_img"]!=""){?><a href="javascript:void(0)" onClick="imgSource_write('<?php echo $TPL_V1["sn"]?>','<?php echo $TPL_V1["name"]?>')"><img src="<?php echo $TPL_VAR["UPLOAD_URL"]?>/upload/nation/<?php echo $TPL_V1["lg_img"]?>" width="40"></a><?php }?>
			</td>
			<td><a href="javascript:void(0)" onClick="imgSource_write('<?php echo $TPL_V1["sn"]?>','<?php echo $TPL_V1["name"]?>')"><?php echo $TPL_V1["name"]?></a></td>
			<td><a href="?mode=del&idx=<?php echo $TPL_V1["idx"]?>"><img src="/img/btn_s_del.gif"></a></td>
		</tr>
<?php }}?>
	</tbody>
	</table>