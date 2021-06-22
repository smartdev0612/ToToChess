<?php
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<div id="contents_left" style="min-height:600px;">
	<!--div id="top_title">
		<div class="title_icon"><img src="/new_images/sub_menu_icon.png" alt=""/></div>
		<div class="title_text"><img src="/new_images/title_money_out.png" alt=""/></div>
	</div> <!--// title 종료-->

	<div class="game_end_sub_menu">
		<div class="game_end_sub_menu_1">
			<ul>
				<li><a href="/member/exchange"><img src="/images/title_money_out_over.png" alt="배팅내역"/></a></li>
				<li><a href="/member/exchangelist"><img src="/images/sub_money_out_list_.png" alt="배팅취소내역"/></a></li>
			</ul>
		</div>
	</div>

	<div id="list_table">
		<ul>
			<li class="money_exchange_text_1">신청번호</li>
			<li class="money_exchange_text_2">환전금액</li>  
			<li class="money_exchange_text_3">신청인</li>  
			<li class="money_exchange_text_4">환전일시</li>  
			<li class="money_exchange_text_5">상태</li>  
			<li class="money_exchange_text_6">삭제여부</li>
		</ul>
	</div>
<?php
	if ( $TPL_list_1 ) { 
		foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
?>
	<div class="money_exchange_1">
		<ul>
			<li class="money_exchange_1_text_1"><?php echo $TPL_V1["sn"]?></li>
			<li class="money_exchange_1_text_2"><?php echo number_format($TPL_V1["amount"])?></li>
			<li class="money_exchange_1_text_3"><?php echo $TPL_V1["bank_owner"]?></li>
			<li class="money_exchange_1_text_4"><?php echo $TPL_V1["regdate"]?></li>
			<li class="money_exchange_1_text_5"><?php if($TPL_V1["state"]==0){?>처리중<?php }elseif($TPL_V1["state"]==1){?>환전완료<?php }?></li>
			<li class="money_exchange_1_text_6"><?php if($TPL_V1["state"]==0){echo "-";}elseif($TPL_V1["state"]==1){?><a href="/member/exchangelist?exchange_sn=<?php echo $TPL_V1["sn"]?>"><img src="/images/bt_del_1.png" alt="삭제"/></a><?php }?></li>
		</ul>
	</div>
<?php
		}
	}
?>

	<div class="bbs_move_icon" style="margin-top:40px;">
		<?php echo $TPL_VAR["pagelist"]?>
	</div>
</div> <!--// content_left 종료-->

<!--
<?php
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>

<div id="contents_left" class="content_wrap" style="background:#fff;">
	<div style="width:300px; height:80px; margin:20px auto; text-align:center;">
		<div><img src="/images/charge_title.png" alt=""/></div>
	</div>

	<div class="stop_mnu">
		<ul>
			<li>
				<a href="/member/chargelist">충전내역</a>
			</li>
			<li>
				<a href="/member/exchangelist" class="on">환전내역</a>
			</li>
		</ul>
	</div>

	<table class="tbl_style01 mp">
		<caption class="hidden">충전내역</caption>
		<thead>
			<tr>
				<th scope="col"><strong>신청금액</strong></th>
				<th scope="col"><strong>신청일시</strong></th>
				<th scope="col"><strong>처리일시</strong></th>
				<th scope="col"><strong>상태</strong></th>
			</tr>
		</thead>
		<tbody>
<?php
	foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
		if ( !$TPL_V1["operdate"] ) $TPL_V1["operdate"] = "-";
?>
			<tr>
				<td class="ac"><?php echo number_format($TPL_V1["amount"])?>원</td>
				<td class="ac"><?php echo $TPL_V1["regdate"]?></td>
				<td class="ac"><?php echo $TPL_V1["operdate"]?></td>
				<td class="ac"><?php if($TPL_V1["state"]==0){?>처리중<?php }elseif($TPL_V1["state"]==1){?>처리완료<?php }?></td>
			</tr>	
<?php
	}

	if ( !count($TPL_VAR["list"]) ) {
		echo "<tr><td colspan=\"4\" class=\"ac\">신청 내역이 없습니다.</td></tr>"; 
	}
?>				
		</tbody>
	</table>

	<div class="bbs_move_icon" style="margin:20px 0 0 26px;">
		<?php echo $TPL_VAR["pagelist"]?>
	</div>
</div>
-->