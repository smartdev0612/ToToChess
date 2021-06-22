<?php
//Array ( [0] => Array ( [sn] => 13 [member_sn] => 1 [amount] => 50000 [state] => 1 [status_message] => 충전 [regdate] => 2016-04-16 22:44:59 ) [1] => Array ( [sn] => 5 [member_sn] => 1 [amount] => -8625 [state] => 6 [status_message] => 포인트전환 [regdate] => 2016-04-14 13:11:37 ) ) 
?>
<div id="contents_left" class="content_wrap" style="background:#fff;">
	<div style="width:300px; height:80px; margin:20px auto; text-align:center;">
		<div><img src="/images/point_title.png" alt=""/></div>
	</div>
	
	<table class="tbl_style01 mp">
		<caption class="hidden">스포츠북</caption>
		<colgroup>
				<col width="200">
				<col>
				<col width="200">
		</colgroup>
		<thead>
			<tr>
				<th><strong>일시</strong></th>
				<th><strong>내용</strong></th>
				<th><strong>변동포인트</strong></th>
			</tr>
		</thead>
    <tbody>
<?php
	foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
		$endAmount = $endAmount + $TPL_V1["amount"];
?>
			<tr>
				<td align="center"><?php echo $TPL_V1["regdate"]?></td>
				<td align="center"><?php echo $TPL_V1["status_message"]?></td>
				<td align="center"><strong><?php echo number_format($TPL_V1["amount"])?></strong></td>
			</tr>	
<?php
	}

	if ( !count($TPL_VAR["list"]) ) {
		echo "<tr><td colspan=\"3\">포인트 내역이 없습니다.</td></tr>"; 
	}
?>
		</tbody>
		<tfoot>
      <tr>
				<th scope="row" colspan="2"><strong>소계</strong></th>
				<td style="border-bottom:1px solid #ddd;border-top:1px solid #ddd;padding-left:10px;"><span class="point"><?php echo number_format($endAmount+0);?></span> P</td>
      </tr>
      <tr>
				<th scope="row" colspan="2"><strong>보유포인트</strong></th>
				<td colspan="2" style="font-weight:bold; color:#f00;font-size:20px;border-bottom:1px solid #ddd;padding-left:10px;"><?php echo number_format($TPL_VAR["mileage"],0)?> P</td>
      </tr>
    </tfoot>
  </table>

	<div class="bbs_move_icon" style="margin:20px 0 0 26px;">
		<?php echo $TPL_VAR["pagelist"]?>
	</div>
</div>