<?php /* Template_ 2.2.3 2013/01/14 00:50:10 D:\www\vhost.partner\_template\content\member\rolling_member_list.html */
$TPL_select_rolling_list_1=empty($TPL_VAR["select_rolling_list"])||!is_array($TPL_VAR["select_rolling_list"])?0:count($TPL_VAR["select_rolling_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<title>회원 목록</title>

<script language="javascript">

function getCheckboxItem()
{
	var allSel="";
	if(document.form2.id.value) return document.form2.id.value;
	for(i=0;i<document.form2.id.length;i++)
	{
		if(document.form2.id[i].checked)
		{
			if(allSel=="")
				allSel=document.form2.id[i].value;
			else
				allSel=allSel+"`"+document.form2.id[i].value;
		}
	}
	return allSel;
}

function getOneItem()
{
	var allSel="";
	if(document.form2.id.value) return document.form2.id.value;
	for(i=0;i<document.form2.id.length;i++)
	{
		if(document.form2.id[i].checked)
		{
				allSel = document.form2.id[i].value;
				break;
		}
	}
	return allSel;
}
function selAll()
{
	for(i=0;i<document.form2.id.length;i++)
	{
		if(!document.form2.id[i].checked)
		{
			document.form2.id[i].checked=true;
		}
	}
}
function noSelAll()
{
	for(i=0;i<document.form2.id.length;i++)
	{
		if(document.form2.id[i].checked)
		{
			document.form2.id[i].checked=false;
		}
	}
}
function open_window(url,width,height)
{
	window.open(url,'','scrollbars=yes,width='+width+',height='+height+',left=5,top=0');
}

function onRollingChange()
{
	document.form3.submit();
}
</script>
</head>

<div id="wrap">
	<h1>회원목록</h1>
	<form name='form3' action='' method='get'>
		<div id="search">
			<div>
				<!--
				<select name="filter_rolling_sn" onChange="onRollingChange();">
					<option value="" <?php if($TPL_VAR["filter_rolling_sn"]==""){?> selected<?php }?>>::롤링</option>
<?php if($TPL_select_rolling_list_1){foreach($TPL_VAR["select_rolling_list"] as $TPL_V1){?>
				  	<option value="<?php echo $TPL_V1["Idx"]?>" <?php if($TPL_VAR["filter_rolling_sn"]==$TPL_V1["Idx"]){?> selected<?php }?>><?php echo $TPL_V1["rec_id"]?></option>
<?php }}?>
				</select>
				-->
				
				<span>검색항목</span>
				<select name="field" >
				  <option value="uid" <?php if($TPL_VAR["field"]=="uid"){?> selected<?php }?>>아이디</option>
					<option value="nick" <?php if($TPL_VAR["field"]=="nick"){?> selected<?php }?>>닉네임</option>
					<option value="bank_member" <?php if($TPL_VAR["field"]=="bank_member"){?> selected<?php }?>>예금주</option>
				</select>
				
				<span>검색어</span>
				<input type='text' name='keyword' value='<?php echo $TPL_VAR["keyword"]?>' class="name" onmouseover="this.focus()"/>
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</div>
		</div>
	</form>

	<form name="form2">
	<table cellspacing="1" class="tableStyle_normal" summary="회원목록">
	<legend class="blind">회원목록</legend>
	<thead>
	<tr>
		<th>ID</th>
		<th>닉네임</th>
		<th>예금주</th>
	<!--	<th>롤링</th>-->
		<th>보유금액</th>
		<th>입금</th>
		<th>출금</th>
		<th>배팅</th>
		<th>배팅내역</th>
		<th>회원등급</th>
		<th>가입일</th>
		<th>가입IP</th>
		<th>상태</th>
	</tr>
	</thead>
	<tbody>	
	
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["uid"]?></td>
			<td><?php echo $TPL_V1["nick"]?></td>
			<td><?php echo $TPL_V1["bank_member"]?></td>
			<!--<td><?php echo $TPL_V1["rolling_uid"]?></td>-->
			<td><?php echo number_format($TPL_V1["g_money"],0)?></td>
			<td><?php echo number_format($TPL_V1["charge_money"],0)?></td>
			<td><?php echo number_format($TPL_V1["exchange_money"],0)?></td>
			<td><?php echo number_format($TPL_V1["bet_money"],0)?></td>
			<td><input type="button" value="배팅내역" onclick="javascript:open_window('/member/popup_BetCategory?member_sn=<?php echo $TPL_V1["sn"]?>','1400',600)";></td>
			<td width="5%"><?php echo $TPL_VAR["arr_mem_lev"][$TPL_V1["mem_lev"]]?></td>
			<td><?php echo $TPL_V1["regdate"]?></td>
			<td><?php echo $TPL_V1["mem_ip"]?></td>
			<td>
<?php if($TPL_V1["mem_status"]=='N'){?>정상
<?php }elseif($TPL_V1["mem_status"]=='S'){?>정지
<?php }elseif($TPL_V1["mem_status"]=='B'){?>불량
<?php }elseif($TPL_V1["mem_status"]=='W'){?>신규
<?php }elseif($TPL_V1["mem_status"]=='G'){?>테스터
<?php }?>
			</td>
		</tr>
<?php }}?>
	
	</tbody>
	</table>
	<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

	</div>
	</form>