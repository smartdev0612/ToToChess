<?php /* Template_ 2.2.3 2013/01/14 00:51:26 D:\www_one-23.com\vhost.partner\_template\content\charge\list.html */
$TPL_select_rolling_list_1=empty($TPL_VAR["select_rolling_list"])||!is_array($TPL_VAR["select_rolling_list"])?0:count($TPL_VAR["select_rolling_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<title>입금내역</title>

<script language="javascript">
//获得选中文件的文件名
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

//获得选中其中一个的id
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

function onRollingChange()
{
	document.frm_filter.submit();
}

</script>
</head>

<body>

<div id="wrap">
	
	<form name="frm_filter" action="?" method="post">
		<div id="search">
			<div>
				<!--
<?php if($TPL_VAR["partner_level"]==1){?>
					<select name="filter_rolling_sn" onChange="onRollingChange();">
						<option value="" <?php if($TPL_VAR["filter_rolling_sn"]==""){?> selected<?php }?>>::롤링</option>
<?php if($TPL_select_rolling_list_1){foreach($TPL_VAR["select_rolling_list"] as $TPL_V1){?>
					  	<option value="<?php echo $TPL_V1["Idx"]?>" <?php if($TPL_VAR["filter_rolling_sn"]==$TPL_V1["Idx"]){?> selected<?php }?>><?php echo $TPL_V1["rec_id"]?></option>
<?php }}?>
					</select>
<?php }?>
				-->
				<span>날짜</span>
				<input type="text" id="date_id" name="beginDate" onclick='new Calendar().show(this);' value="<?php echo $TPL_VAR["beginDate"]?>" class="date" style="width:80px;"> ~
				<input type="text" id="date_id1" name="endDate" onclick='new Calendar().show(this);'  value="<?php echo $TPL_VAR["endDate"]?>" class="date" style="width:80px;">
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
	
	<h1>입금내역</h1>
	<form name="form2">

		<table cellspacing="1" class="tableStyle_normal" summary="입금내역">
		<legend class="blind">입금내역</legend>
		<thead>
		<tr>
			<th>아이디</th>
			<th>닉네임</th>	
			<th>예금주</th>
<?php if($TPL_VAR["partner_level"]==1){?>
	<!--		<th>롤링</th>-->
<?php }?>
			<th>신청금액</th>
			<th>실입금액</th>			
			<th>입금자명</th>
			<th>신청시간</th>
			<th>처리시간</th>
		</tr>
		</thead>
		<tbody>
		
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["uid"]?></td>
				<td><?php echo $TPL_V1["nick"]?></td>
				<td><?php echo $TPL_V1["bank_member"]?></td>
<?php if($TPL_VAR["partner_level"]==1){?>
		<!--		<td><?php echo $TPL_V1["rolling_id"]?></td>-->
<?php }?>
				<td><?php echo number_format($TPL_V1["amount"],0)?></td>
				<td><?php echo number_format($TPL_V1["agree_amount"],0)?></td>			
				<td><?php echo $TPL_V1["bank_owner"]?></td>
				<td><?php echo $TPL_V1["regdate"]?></td>
				<td><?php echo $TPL_V1["operdate"]?></td>
			</tr>
<?php }}?>
		
		</tbody>
		</table>
		<div id="pages">
				<?php echo $TPL_VAR["pagelist"]?>

		</div>
	</form>

<!--  搜索表单 
<form name='form3' action='' method='get'>
<table width='98%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#CBD8AC' align="center" style="margin-top:8px">
  <tr bgcolor='#EEF4EA'>
    <td background='skin/images/wbg.gif' align='center'>
      <table border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td  align='center'>검색:</td>
          <td >
          <select name='cid' >
          	<option value='1' <?php if($cid==1){ echo "selected";} ?>>아이디</option>
			<option value='2' <?php if($cid==2){ echo "selected";} ?>>닉네임</option>

          </select>
        </td>
        <td >
          검색어:
        </td>
        <td width='160'>
          	<input type='text' name='keyword' value='<?=$keyword?>' style='width:150px' />
        </td>
        
        <td>
          <input  type="image" src="skin/images/frame/search.gif" width="45" height="20" border="0" class="np" />
        </td>
       </tr>
      </table>
    </td>
  </tr>
</table>
</form> -->