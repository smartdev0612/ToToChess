<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '통계-수익통계';</script>
<script>
	function go_del(url)
	{
		if(confirm("정말 삭제하시겠습니까?"))
		{
			document.location = url;
		}
		else 
		{
			return;
		}
	}
	
	function toggle(id)
	{
		$( "#"+id ).slideToggle(100);
	}	
	
</script>

<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 통계 > <b>수익 통계</b></h5>
	</div>

	<h3>수익 통계 목록</h3>

	<div id="search">
		<div class="wrap">
			<form action="?" method="GET" name="form2" id="form2">
				<span>날짜</span>
				<input type="text" id="startDate" name="startDate" onclick='new Calendar().show(this);' value="<?php echo $TPL_VAR["startDate"]?>" class="date"> ~
				<input type="text" id="endDate" name="endDate" onclick='new Calendar().show(this);'  value="<?php echo $TPL_VAR["endDate"]?>" class="date">

				<!-- 키워드 검색 -->
				<select name="field">
					<option value="rec_id" <?php if($TPL_VAR["field"]=="rec_id"){?> selected <?php }?>>아이디</option>
					<option value="rec_name" <?php if($TPL_VAR["field"]=="rec_name"){?> selected <?php }?>>이름</option>
				</select>
				<input name="keyword" type="text" id="key" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20" onmouseover="this.focus()"/>
				
				<!-- 검색버튼 -->
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_members" summary="총판 목록">
	<legend class="blind">총판 목록</legend>
	<thead>
		<tr>
			<th scope="col">사이트</th>
			<th scope="col">아이디</th>
			<th scope="col">이름</th>
			<th scope="col">입금금액</th>
			<th scope="col">출금금액</th>
			<th scope="col">배팅금액</th>
			<th scope="col">당첨금액</th>
			<th scope="col">낙첨금액</th>
			<th scope="col">지급포인트</th>
			<th scope="col">본사수익</th>
			<th scope="col">단폴더</th>
<!--
			<th scope="col">정산기준</th>
			<th scope="col">정산비율</th>
			<th scope="col">정산금</th>
-->
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<?php
	$end_tex_money = 0;
	if ( $TPL_V1["rec_rate"] > 0 ) {
		$tex_type = "배팅금";
		if ( $TPL_V1["rec_one_folder_flag"] == 1 ) {
			$end_tex_money = ($TPL_V1["money_log"]["betting"]*$TPL_V1["rec_rate"])/100;
		} else {
			$end_tex_money = (($TPL_V1["money_log"]["betting"]-$TPL_V1["money_log"]["betting_one"])*$TPL_V1["rec_rate"])/100;
		}
	} else if ( $TPL_V1["rec_rate_fail"] > 0 ) {
		$tex_type = "낙첨금";
		if ( $TPL_V1["rec_one_folder_flag"] == 1 ) {
			$end_tex_money = ($TPL_V1["money_log"]["end_lose_money"]*$TPL_V1["rec_rate_fail"])/100;
		} else {
			$end_tex_money = (($TPL_V1["money_log"]["end_lose_money"]-$TPL_V1["money_log"]["end_lose_money_one"])*$TPL_V1["rec_rate_fail"])/100;
		}
	} else if ( $TPL_V1["rec_rate_inout"] > 0 ) {
		$tex_type = "입출금";
		$end_tex_money = ($TPL_V1["money_log"]["end_inout"]*$TPL_V1["rec_rate_inout"])/100;
	}
?>
			<tr>
				<td><?php echo $TPL_V1["logo"]?></td>
				<td><a href="javascript:open_window('/partner/memberDetails?idx=<?php echo $TPL_V1["Idx"]?>',640,440)"><?php echo $TPL_V1["rec_id"]?></a></td>
				<td><?php echo $TPL_V1["rec_name"]?></td>
				<td><?php echo number_format($TPL_V1["money_log"]["charge"],0)?></td>
				<td><?php echo number_format($TPL_V1["money_log"]["exchange"],0)?></td>
				<td><?php echo number_format($TPL_V1["money_log"]["betting"],0)?></td>
				<td><?php echo number_format($TPL_V1["money_log"]["win_money"],0)?></td>
				<td><?php echo number_format($TPL_V1["money_log"]["lose_money"],0)?></td>
				<td><?php echo number_format($TPL_V1["money_log"]["end_mileage_charge"],0)?></td>
				<td><?php echo number_format($TPL_V1["money_log"]["lose_money"]-$TPL_V1["money_log"]["win_money"]-$TPL_V1["money_log"]["end_mileage_charge"],0)?></td>
				<td>
<?php 
	if ( $TPL_V1["rec_one_folder_flag"] == 1 ) echo "포함";
	if ( $TPL_V1["rec_one_folder_flag"] == 0 ) echo "미포함";
?>
				</td>
<!--
				<td><?php echo $tex_type;?></td>
				<td><?php echo number_format($TPL_V1["rec_rate"]+$TPL_V1["rec_rate_fail"]+$TPL_V1["rec_rate_inout"],0)?>%</td>
				<td>
					<table width=100%>
						<tr bgcolor="#B2CCFF">
							<td><?php echo number_format($end_tex_money)?> 원</td>
						</tr>
					</table>
				</td>
-->
			</tr>		
<?php }}?>
	</tbody>
	</table>
</form>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>