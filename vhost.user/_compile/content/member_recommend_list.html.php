<div id="contents_left" class="content_wrap downline" style="background:#fff;">
	<div style="width:300px; height:80px; margin:20px auto; text-align:center;">
		<div><img src="/images/myfriend2_title.png" alt=""/></div>
	</div>

	<div class="totcnt" style="width:880px; font-size:14px;font-weight:bold;display:block;padding:10px;background:#eee; margin:0 auto 20px;">
		<form name="theForm" action="/contents/mypage_downline.do" method="post">
			<label><input type="radio" name="kind" value="day" checked="" onclick="viewType(this.value);"> 날짜별 보기</label>&nbsp;
			<label><input type="radio" name="kind" value="term" onclick="viewType(this.value);"> 기간별 보기</label>
			<input type="text" name="term_s" class="datepicker frm_input hasDatepicker" readonly="" value="2016-04-08" id="dp1460107662413">
			<span class="v_term" style="display: none;">~</span> <!-- 기간별 보기일 경우 'style="display: inline-block;"' -->
			<input type="text" name="term_e" class="datepicker frm_input v_term hasDatepicker" readonly="" value="2016-04-08" id="dp1460107662414" style="display: none;"> <!-- 기간별 보기일 경우 'style="display: inline-block;"' -->
			<input type="button" class="btn btn_b02" value="보기" onclick="get_list_data('line','1');">
		</form>
	</div>

	<div id="list_data">
		<div class="tbl_head02 tbl_wrap" id="tbl_depth_1">
			<table class="tbl_style01">
				<colgroup>
					<col>
					<col>
					<col>
					<col width="12%">
					<col width="12%">
					<col width="12%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th scope="col"><strong>아이디</strong></th>
						<th scope="col"><strong>회원수</strong></th>
						<th scope="col"><strong>요율</strong></th>
						<th scope="col"><strong>입금</strong></th>
						<th scope="col"><strong>출금</strong></th>
						<th scope="col"><strong>보유머니</strong></th>
						<th scope="col"><strong>사다리베팅</strong></th>
						<th scope="col"><strong>달팽이베팅</strong></th>
						<th scope="col"><strong>파워볼베팅</strong></th>
						<th scope="col"><strong>로하이베팅</strong></th>
					</tr>
				</thead>
				<tbody>
					<tr class="row">
						<th><strong><a href="javascript:;" onclick="get_list_data('hkmall','2');">hkmall</a></strong>  </th>
						<td><span class="count">3</span></td>
						<td><span class="rate">0.7%</span></td>
						<td class="ar"><span class="in">700,000</span></td>
						<td class="ar"><span class="out">0</span></td>
						<td class="ar"><span class="row">0</span></td>
						<td><span class="point1">2,288,410</span></td>
						<td><span class="point2">0</span></td>
						<td><span class="point3">0</span></td>
						<td><span class="point4">0</span></td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="row">
						<th scope="col" colspan="3"><strong>합계</strong></th>
						<td class="ar"><span class="out_sum ar">700,000</span></td>
						<td class="ar"><span class="mbmoney_sum ar">0</span></td>
						<td class="ar"><span class="mbmoney_sum ar">0</span></td>
						<td><span class="amount2">2,288,410</span></td>
						<td><span class="amount2">0</span></td>
						<td><span class="amount2">0</span></td>
						<td><span class="amount2">0</span></td>
					</tr>
				</tfoot>
			</table>
	</div>
	
</div>
	
</div>

<?php
	$TPL_sub_item_1=empty($TPL_VAR["sub_item"])||!is_array($TPL_VAR["sub_item"])?0:count($TPL_VAR["sub_item"]);
?>
<div id="contents_left" style="min-height:700px; display:none;">
	<div id="top_title">
		<div class="title_icon"><img src="/new_images/sub_menu_icon.png" alt=""/></div>
		<div class="title_text"><img src="/new_images/title_recommend.png" alt=""/></div>
	</div> <!--// title 종료-->

	<div id="list_table">
		<ul>
			<li class="recommend_head_table_1">아이디</li>
			<li class="recommend_head_table_2">닉네임</li>  
			<li class="recommend_head_table_3">수수료(%)</li>  
			<li class="recommend_head_table_4">누적포인트</li>
			<li class="recommend_head_table_5">누적회원수</li>
		</ul>
	</div>

	<div class="customer_normal_table">
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td class="recommend_head_table_1" style="text-align:center;"><?php echo $TPL_VAR["item"]["uid"]?></td>
				<td class="recommend_head_table_2" style="text-align:center;"><?php echo $TPL_VAR["item"]["nick"]?></td>
				<td class="recommend_head_table_3" style="text-align:center;"><?php echo $TPL_VAR["item"]["rate"]?>%</td>
				<td class="recommend_head_table_4" style="text-align:center;"><?php echo number_format($TPL_VAR["item"]["benefit"],0)?></td>
				<td class="recommend_head_table_5" style="text-align:center;"><?php echo $TPL_VAR["item"]["sub_count"]?></td>
			</tr>
		</table>
	</div>
		
	<div id="list_table" style="margin-top:50px;">
		<ul>
			<li class="recommend_content_table_1">번호</li>
			<li class="recommend_content_table_2">추천아이디</li>  
			<li class="recommend_content_table_3">닉네임</li>  
			<li class="recommend_content_table_4">누적포인트</li>
		</ul>
	</div>

<?php
	if ( $TPL_sub_item_1 ) {
?>
	<div class="customer_normal_table">
		<table border="0" cellspacing="0" cellpadding="0">
<?php
		foreach ( $TPL_VAR["sub_item"] as $TPL_V1 ) {
?>

			<tr>
				<td class="recommend_content_table_1" style="text-align:center;"><?php echo $TPL_V1["sn"]?></td>
				<td class="recommend_content_table_2" style="text-align:center;"><?php echo $TPL_V1["uid"]?></td>
				<td class="recommend_content_table_3" style="text-align:center;"><?php echo $TPL_V1["nick"]?></td>
				<td class="recommend_content_table_4" style="text-align:center;"><?php echo number_format($TPL_V1["benefit"],0)?></td>
			</tr>
<?php
		}
?>
		</table>
	</div>
<?php
	}
?>

</div> <!-- contents_left -->