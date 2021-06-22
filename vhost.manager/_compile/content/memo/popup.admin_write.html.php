<?php /* Template_ 2.2.3 2014/10/07 22:37:20 D:\www_one-23.com\vhost.manager\_template\content\memo\popup.admin_write.html */
$TPL_level_list_1=empty($TPL_VAR["level_list"])||!is_array($TPL_VAR["level_list"])?0:count($TPL_VAR["level_list"]);
$TPL_partner_list_1=empty($TPL_VAR["partner_list"])||!is_array($TPL_VAR["partner_list"])?0:count($TPL_VAR["partner_list"]);
$TPL_domain_list_1=empty($TPL_VAR["domain_list"])||!is_array($TPL_VAR["domain_list"])?0:count($TPL_VAR["domain_list"]);?>
<script>
	function checknull()
	{
		var fm=document.form1;
		
		val=CheckStr(fm.subject.value," ",'');
		if(val==0)
		{
			alert("제목을 입력하세요.")
			fm.subject.focus();
			return;
		}
		val=CheckStr(fm.content.value," ",'');
		if(val==0)
		{
			alert("쪽지 내용을 입력하세요.");
			fm.content.focus();
			return;
		}
		
		fm.submit();
	}
</script>
</head>

<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>쪽지 쓰기</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<form method="post" name="form1" action="?act=send">	
	<table cellspacing="1" class="tableStyle_membersWrite" summary="쪽지 쓰기">
	<legend class="blind">쪽지 쓰기</legend>
		<tr>
		  <th>보내는이</th>
		  <td><input type=text name="fromid" maxlength="17" value="운영팀" readonly /></td>
		</tr>
		<tr>
		  <th>받는이</th>
		  <td>
<!--
			<select name="filter_logo">
				<option value=""  <?php if($TPL_VAR["filter_logo"]==""){?>  selected <?php }?>>전체</option>
				<option value="gadget" <?php if($TPL_VAR["filter_logo"]=="one23"){?>  selected <?php }?>>gadget</option>
			</select>
			&nbsp;
-->
			<select name="toid_level">
				<option value="">등급</option>
<?php if($TPL_level_list_1){foreach($TPL_VAR["level_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["lev"]?>"><?php echo $TPL_V1["lev_name"]?></option>
<?php }}?>
			</select>
			&nbsp;
			<select name="toid_partner">
				<option value="">총판</option>
<?php if($TPL_partner_list_1){foreach($TPL_VAR["partner_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["Idx"]?>"><?php echo $TPL_V1["rec_id"]?></option>
<?php }}?>
			</select>
<!--
			&nbsp;
			<select name="toid_domain">
				<option value="">도메인</option>
<?php if($TPL_domain_list_1){foreach($TPL_VAR["domain_list"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["url"]?>"><?php echo $TPL_V1["url"]?></option>
<?php }}?>
			</select>
-->
		  </td>
		</tr>
		<tr>
		  <th>제목</th>
		  <td><input type="text" name="subject" maxlength="50" class="wWhole"/></td>
		</tr>
		<tr>
		  <th>내용</th>
		  <td><textarea rows="8" name="content"></textarea></td>
		</tr>
	</table>
	<div id="wrap_btn">
	  <input type="button" value="보내기" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="checknull()">
	  &nbsp;
	  <input type="button" value="취 소" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="window.close();">
	</div>
	</form>
</div>

</body>
</html>