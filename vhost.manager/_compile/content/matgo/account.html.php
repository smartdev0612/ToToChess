<?php /* Template_ 2.2.3 2013/12/05 16:58:06 D:\www\vhost.manager\_template\content\matgo\account.html */
$TPL_partner_list_1=empty($TPL_VAR["partner_list"])||!is_array($TPL_VAR["partner_list"])?0:count($TPL_VAR["partner_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '맞고 통계-입/출금 통계';</script>
<script>
	function on_click()
	{
		data=document.getElementById("date_id").value;
		data1=document.getElementById("date_id1").value;
		if(data=="" || data1=="")
		{
			alert("시간을 선택하여 주십시오.");
			return false;
		}
		else if(data1<data)
		{
			alert("끝나는 날자가 시작하는 날자보다 작을수 없습니다.");
			return false;
		}
		document.getElementById("form2").submit();
	}
</script>

<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 통계 > <b>입출금 통계</b></h5>
	</div>

	<h3>입출금 통계</h3>

	<div id="search2">
		<div>
			<form action="?" method="GET" name="form2" id="form2">
				<!-- 총판 필터 -->
				<select name="filter_partner_sn">
					<option value="" <?php if($TPL_VAR["filter_partner_sn"]==""){?> selected <?php }?>>총판</option>
<?php if($TPL_partner_list_1){foreach($TPL_VAR["partner_list"] as $TPL_V1){?>
						<option value=<?php echo $TPL_V1["Idx"]?> <?php if($TPL_VAR["filter_partner_sn"]==$TPL_V1["Idx"]){?> selected <?php }?>><?php echo $TPL_V1["rec_id"]?></option>
<?php }}?>
				</select>
				
				<!-- 기간 검색 -->
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="25" onclick="new Calendar().show(this);" > ~ 
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="25"  onclick="new Calendar().show(this);" >
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_normal add" summary="입/출금 통계">
	<legend class="blind">입/출금</legend>
	<thead>
		<tr>
			<th scope="col">날짜</th>
			<th scope="col">수수료</th>
			<th scope="col">관리자 수익</th>
			<th scope="col">유저 수익</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><a href="#" onclick="open_window('/stat/popup_money?date=<?php echo $TPL_V1["current_date"]?>&filter_partner_sn=<?php echo $TPL_VAR["filter_partner_sn"]?>',900,400)"><?php echo $TPL_V1["current_date"]?></a></td>
				<td class="betTd"><?php echo number_format($TPL_V1["commission"],0)?></td>
				<td class="betTd"><?php echo number_format($TPL_V1["manager_amount"],0)?></td>
				<td class="betTd"><?php echo number_format($TPL_V1["user_amount"],0)?></td>
			 </tr>
<?php }}?>
	</tbody>
	<tfoot>
		<tr>
			<td>합계</td>
			<td><?php echo number_format($TPL_VAR["sumList"]["sum_commission"],0)?></td>
			<td><?php echo number_format($TPL_VAR["sumList"]["sum_manager_amount"],0)?></td>
			<td><?php echo number_format($TPL_VAR["sumList"]["sum_user_amount"],0)?></td>
		 </tr>
	</tfoot>
	</table>		 
	</form>	

</div>