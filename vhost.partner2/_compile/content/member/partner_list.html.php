<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<title>총판 목록</title>
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
function open_window(url,width,height){
	window.open(url,'','scrollbars=yes,width='+width+',height='+height+',left=5,top=0');
}

function sub_open(idx) {
	$("#sub_"+idx).toggle();
}
</script>
</head>

<div id="wrap">
	<h1>총판목록</h1>
	<form name='form3' action='' method='get'>
		<div id="search">
			<div>
				<input name="del_Submit" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="javascript:window.open('/member/popup_join','memo','width=650,height=350')" type="submit" value="총판 등록">
				<span>검색항목</span>
				<select name="field" >
				  <option value="rec_id" <?php if($TPL_VAR["field"]=="rec_id"){?> selected<?php }?>>총판-아이디</option>
					<option value="rec_name" <?php if($TPL_VAR["field"]=="rec_name"){?> selected<?php }?>>총판-닉네임</option>
					<option value="rec_bankusername" <?php if($TPL_VAR["field"]=="rec_bankusername"){?> selected<?php }?>>총판-예금주</option>
				</select>
				<span>검색어</span>
				<input type='text' name='keyword' value='<?php echo $TPL_VAR["keyword"]?>' class="name" onmouseover="this.focus()"/>
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</div>
		</div>
	</form>

	<form name="form2">
	<table border="1" cellspacing="0" class="tableStyle_normal" summary="총판목록">
		<tr>
			<th>총판ID</th>
			<th>닉네임</th>
			<th>유저수(회원)</th>
			<th>회원-누적입금금액</th>
			<th>회원-누적출금금액</th>
			<!--<th>회원-누적배팅금액</th>-->
			<th>회원-보유캐쉬</th>
			<th>총판-정산금액합계</th>
			<th>총판-보유마일리지</th>
			<th>정산비율</th>
			<th>가입일</th>
		</tr>
<?php
	if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
		$total_charge_money += $TPL_V1["charge_money"];
		$total_exchange_money += $TPL_V1["exchange_money"];
		$total_bet_money += $TPL_V1["bet_money"];
		$total_total_mem_money += $TPL_V1["total_mem_money"];
		$total_tex_money += $TPL_V1["tex_money"];
		$total_rec_money += $TPL_V1["rec_money"];
		$recTexRate = $TPL_V1["rec_rate_inout"] + $TPL_V1["rec_rate_in"] + $TPL_V1["rec_rate"] + $TPL_V1["rec_rate_fail"];
		$recRateSport = $TPL_V1["rec_rate_sport"];
		$recRateMinigame = $TPL_V1["rec_rate_minigame"];
?>
		<tr onClick="sub_open('<?php echo $TPL_V1["Idx"];?>');">
			<td><a href="javascript:open_window('/member/popup_details?idx=<?php echo $TPL_V1["Idx"];?>',660,460)"><?php echo $TPL_V1["rec_id"];?></a></td>
			<td><?php echo $TPL_V1["rec_name"];?></td>
			<td><?php echo $TPL_V1["member_count"];?></td>
			<td><?php echo number_format($TPL_V1["charge_money"]);?></td>
		    <td><?php echo number_format($TPL_V1["exchange_money"]);?></td>
			<!--<td><?php echo number_format($TPL_V1["bet_money"]);?></td>-->
			<td><?php echo number_format($TPL_V1["total_mem_money"]);?></td>
			<td><?php echo number_format($TPL_V1["tex_money"]);?></td>
			<td><?php echo number_format($TPL_V1["rec_money"]);?></td>
			<td><?php echo $recRateSport;?>% / <?php echo $recRateMinigame;?>%</td>
			<td><?php echo $TPL_V1["reg_date"];?></td>
		</tr>
		<tr id="sub_<?php echo $TPL_V1["Idx"];?>" style="display:none;">
			<td colspan="10" bgcolor="#000000"><center>
				<table width="95%" border="0" cellspacing="0" style="margin:5px 0 10px 0;">
					<tr>
						<th>회원ID</th>
						<th>닉네임</th>
						<th>예금주</th>
						<th>입금금액</th>
						<th>출금금액</th>
						<th>배팅금액</th>
						<th>보유캐쉬</th>
						<th>가입일</th>
					</tr>
<?php 
		if (count($TPL_V1["item"])>0){foreach($TPL_V1["item"] as $TPL_V2){
?>
					<tr>
						<td><?php echo $TPL_V2["uid"];?></td>
						<td><?php echo $TPL_V2["nick"];?></td>
						<td><?php echo $TPL_V2["bank_member"];?></td>
						<td><?php echo number_format($TPL_V2["charge_money"]);?></td>
						<td><?php echo number_format($TPL_V2["exchange_money"]);?></td>
						<td><?php echo number_format($TPL_V2["bet_money"]);?></td>
						<td><?php echo number_format($TPL_V2["g_money"]);?></td>
						<td><?php echo $TPL_V2["regdate"];?></td>
					</tr>
<?php
		}}
?>
				</table></center>
			</td>
		</tr>	
<?php
	}}
?>
		<tr>
			<th colspan="3">합계</th>
			<th><?php echo number_format($total_charge_money);?></th>
			<th><?php echo number_format($total_exchange_money);?></th>
			<!--<th><?php echo number_format($total_bet_money);?></th>-->
			<th><?php echo number_format($total_total_mem_money);?></th>
			<th><?php echo number_format($total_tex_money);?></th>
			<th><?php echo number_format($total_rec_money);?></th>
			<th colspan="2">-</th>
		</tr>
	</table>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>
	</div>
	</form>