<?php /* Template_ 2.2.3 2013/01/02 15:32:26 D:\www\vhost.partner\_template\content\member\rolling_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<title>롤링 목록</title>

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
function open_window(url,width,height){
	window.open(url,'','scrollbars=yes,width='+width+',height='+height+',left=5,top=0');
}
</script>
</head>

<div id="wrap">
	<h1>롤링목록</h1>

	<form name='form3' action='' method='get'>
		<div id="search">
			<div>
				<span>검색항목</span>
				<select name='field' >
				  <option value='uid'  	<?php if($TPL_VAR["field"]=='uid'){?>	selected<?php }?>>아이디</option>
					<option value='name' 	<?php if($TPL_VAR["field"]=='name'){?>selected<?php }?>>이름</option>
					<option value='sn' 		<?php if($TPL_VAR["field"]=='sn'){?>selected<?php }?>>번호</option>
				</select>
				<span>검색어</span>
				<input type='text' name='keyword' value='<?php echo $TPL_VAR["keyword"]?>' class="name" onmouseover="this.focus()"/>
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</div>
		</div>
	</form>

	<form name="form2">
		<table cellspacing="1" class="tableStyle_normal" summary="롤링목록">
		<legend class="blind">롤링목록</legend>
		<thead>
		<tr>
			<th>아이디</th>
			<th>이름</th>
			<th>회원수</th>
			<th>입금회원</th>
			<th>입금금액</th>
			<th>출금금액</th>
			<th>배팅금액</th>
			<th>당첨금액</th>
			<th>상태</th>
			<th>가입날짜</th>
			<th>처리</th>
		</tr>
		</thead>
		<tbody>	
		
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><a href="#" onclick="javascript:open_window('/member/rolling_detail?rolling_sn=<?php echo $TPL_V1["Idx"]?>','650',450)";><?php echo $TPL_V1["rec_id"]?></a></td>
				<td><?php echo $TPL_V1["rec_name"]?></td>
				<td><?php echo $TPL_V1["member_count"]?></td>
				<td><?php echo $TPL_V1["charge_cnt"]?></td>
				<td><?php echo number_format($TPL_V1["charge_money"],0)?></td>
				<td><?php echo number_format($TPL_V1["exchange_money"],0)?></td>
				<td><?php echo number_format($TPL_V1["bet_money"],0)?></td>
				<td><?php echo number_format($TPL_V1["win_money"],0)?></td>
				<td>
<?php if($TPL_V1["status"]==1){?>정상
<?php }elseif($TPL_V1["status"]==0){?>정지
<?php }elseif($TPL_V1["status"]==2){?>신청
<?php }?>
				</td>
				<td><?php echo $TPL_V1["reg_date"]?></td>
				<td>
<?php if($TPL_V1["status"]==1){?><a href='?act=stop&partner_sn=<?php echo $TPL_V1["rec_id"]?>&state=0'><img src='/img/btn_s_stop.gif' title='정지'></a>						
<?php }else{?><a href='?act=stop&partner_sn=<?php echo $TPL_V1["rec_id"]?>&state=1'><img src='/img/btn_s_normal.gif' title='정상'></a>
<?php }?>&nbsp;
					<a href="javascript:void(0)" onclick="go_del('?act=delete&partner_sn=<?php echo $TPL_V1["rec_id"]?>');return false;"><img src="/img/btn_s_del.gif" title="삭제"></a>&nbsp;
					<!--<a href="javascript:void(0);" onclick="open_window('/member/memoadd_acc?toid=<?php echo $TPL_V1["rec_id"]?>',650,450)"><img src="/img/btn_s_memo.gif" title="메모"></a>-->
				</td>
			</tr>
<?php }}?>
		
		</tbody>
		</table>
		<div id="pages">
				<?php echo $TPL_VAR["pagelist"]?>

		</div>
		
		<div id="wrap_btn">
	  	<input type="submit" name="del_Submit" value="롤링 등록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="javascript:window.open('/member/popup_join','memo','width=650,height=350')"/>
	  </div>
	</form>