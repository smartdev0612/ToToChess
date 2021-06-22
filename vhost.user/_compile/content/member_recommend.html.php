<?php
	$TPL_sub_item_1=empty($TPL_VAR["sub_item"])||!is_array($TPL_VAR["sub_item"])?0:count($TPL_VAR["sub_item"]);
?>
<div id="contents_top">
    <div class="board_title">Recommend<span class="board_mini_title">지인현황</span></div>
</div>
<div id="contents_left" style="min-height:600px;background: white;width: 1140px;padding: 30px;font-size: 13px">
	<!--div id="top_title">
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
		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="color: black">
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
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
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

<!--
<div id="contents_left" style="background:#fff;">
	<div style="width:300px; height:80px; margin:20px auto; text-align:center;">
		<div><img src="/images/myfriend_title.png" alt=""/></div>
	</div>

	<div class="mb_mem_top">
		<em>수수료(%) : </em><strong headers="mb_list_nick" class=" sv_use"> <?php echo $TPL_VAR["item"]["rate"]?>%</strong>
		<em>누적포인트 : </em><strong headers="mb_list_nick" class=" sv_use"> <?php echo number_format($TPL_VAR["item"]["benefit"],0)?>P</strong>
		<em>누적회원수 : </em><strong headers="mb_list_nick" class=" sv_use"> <?php echo $TPL_VAR["item"]["sub_count"]?>명</strong>
	</div>

	<table class="tbl_style01 mb_mem" style="margin-top:20px;">
		<caption class="hidden">나를추천한회원</caption>
		<thead>
			<tr>
				<th scope="col"><strong>아이디</strong></th>
				<th scope="col"><strong>닉네임</strong></th>
				<th scope="col"><strong>누적포인트</strong></th>
				<th scope="col"><strong>추천날짜</strong></th>   
			</tr>
		</thead>
		<tbody>
<?php
	foreach ( $TPL_VAR["sub_item"] as $TPL_V1 ) {
?>
			<tr>
				<td class="site_n">
					<strong><?php echo $TPL_V1["uid"]?></strong>
				</td>
				<td><?php echo $TPL_V1["nick"]?></td>
				<td headers="mb_list_nick" class="sv_use"><?php echo number_format($TPL_V1["benefit"],0)?>P</td>
				<td class="site_date"><?php echo $TPL_V1["regdate"]?></td>
			</tr>
<?
	}

	if ( !count($TPL_VAR["sub_item"]) ) {
		echo "<tr><td colspan='4'>나를 추천한 회원이 없습니다.</td></tr>";
	}
?>
		</tbody>
	</table>
</div>

<?php
	$TPL_sub_item_1=empty($TPL_VAR["sub_item"])||!is_array($TPL_VAR["sub_item"])?0:count($TPL_VAR["sub_item"]);
?>
<div id="contents_left" style="min-height:700px; display:none;">
	<div id="top_title">
		<div class="title_icon"><img src="/new_images/sub_menu_icon.png" alt=""/></div>
		<div class="title_text"><img src="/new_images/title_recommend.png" alt=""/></div>
	</div> <!--// title 종료->

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
