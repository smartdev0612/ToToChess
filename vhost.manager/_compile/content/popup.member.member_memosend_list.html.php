<?php /* Template_ 2.2.3 2012/10/09 22:09:30 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\popup.member.member_memosend_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	var number=<?php if($TPL_VAR["total"]>$TPL_VAR["perpage"]){?> <?php echo $TPL_VAR["perpage"]?> <?php }else{?> <?php echo $TPL_VAR["total"]?> <?php }?>;

	function LMYC() 
	{
		var lbmc;
	    	for (i=1;i<=number;i++) 
	    	{
	       	lbmc = eval('LM' + i);
	        	lbmc.style.display = 'none';
	    	}
	}
	 
	function ShowFLT(i) 
	{
		lbmc = eval('LM' + i);
	    	if (lbmc.style.display == 'none') 
	    	{
			LMYC();
			lbmc.style.display = '';
	    	}
	    	else {lbmc.style.display = 'none';}
	}
</script>

</head>

<body id="members_smemo">

<div id="wrap_pop">
	<div id="pop_title">
		<h1>쪽지 관리 - 보낸 쪽지함</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<ul id="tab">
		<li><a href="/member/membermemo" id="members_rmemo">받은쪽지함</a></li>
		<li><a href="/member/sendmemolist" id="members_smemo">보낸쪽지함</a></li>
	</ul>

	<div id="search">
		<div>
			<form action="?" method="get" name="form2" id="form2">
			<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
				<span class="icon">아이디</span><input name="username" type="text" value="<?php echo $TPL_VAR["nname"]?>" maxlength="20" class="name"/>
				<input name="submit" type="submit"  value="검색" class="btnStyle3" />
			</form>
		</div>
	</div>
	<form id="form1" name="form1" method="get" action="?">
	<input type="hidden" name="act" value="del">
	<table cellspacing="1" class="tableStyle_members" summary="보낸 쪽지함">
	<legend class="blind">보낸 쪽지함 - 제목</legend>
	<thead>
		<tr>
			<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
			<th width="15%" scope="col">받는이</th>
			<th width="15%" scope="col">보낸이</th>
			<th width="34%" scope="col">제목</th>
			<th width="15%" scope="col">보낸 시간</th>
			<th width="10%" scope="col">상태</th>
			<th width="20%" scope="col">처리</th>
		</tr>
	</thead>
	</table>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<table cellspacing="1" class="tableStyle_normal" summary="보낸 쪽지함">
			<legend class="blind">보낸 쪽지함 - 내용</legend>
			<tbody>
				<tr onClick="javascript:ShowFLT(<?php echo $TPL_V1["idx"]?>)">
					<td class="check"><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["mem_idx"]?>"  onclick="javascript:chkRow(this);"/></td>
					<td width="15%"><?php echo $TPL_V1["toid"]?></td>
					<td width="15%"><?php echo $TPL_V1["fromid"]?></td>
					<td width="34%"><span class="subject"><?php echo mb_strimwidth($TPL_V1["title"],0,36,"..","utf-8")?></span></td>
					<td width="15%"><?php echo $TPL_V1["writeday"]?></td>
					<td width="10%">
<?php if($TPL_V1["newmemo"]==0){?>
							<font color='red'>안읽음</font>
<?php }else{?>
							"읽음"
<?php }?>
					</td>
					<td width="20%">
						<a href="javascript:confirm('정말 삭제하시겠습니까?');location.href='/member/sendmemolist?act=onedel&idx=<?php echo $TPL_V1["mem_idx"]?>';"><img src="/img/btn_s_del.gif" title="삭제"></a>
					</td>
				</tr>
			</tbody>
		</table>
		<table id="LM<?php echo $TPL_V1["idx"]?>" style="display:none" class="memo_answer">
			<tr class="line">
				<th valign="top">제목 :</th>
					<td><?php echo mb_strimwidth($TPL_V1["title"],0,36,"..","utf-8")?></td>
			</tr>
			<tr>
				<th valign="top">내용 :</th>
					<td><?php echo $TPL_V1["content"]?></td>
			</tr>
		</table>
<?php }}?>
    
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
	<div id="wrap_btn">
		<p class="left">
			<input type="button" name="open" value="삭  제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
		</p>
	</div>
	</form>
</div>

</body>
</html>