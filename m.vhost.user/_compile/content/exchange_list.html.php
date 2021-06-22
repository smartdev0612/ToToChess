<?php /* Template_ 2.2.3 2014/09/27 14:59:22 D:\www_one-23.com\m.vhost.user\_template\content\exchange_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>

	<div id="sub_menu">
		<ul>
			<li class="sub_menu_1"><a href="/member/exchange" class="sub_menu_1_text">환전요청</a></li>
			<li class="sub_menu_1_o"><a href="/member/exchangelist" class="sub_menu_1_o_text">환전내역</a></li>
		</ul>
	</div>

			<form name="frm" action="?" method="post">
			<input type="hidden" id="exchange_sn" name="exchange_sn" value="">
            <div class="board_list">
                <ul>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
                    <li class="board_nomal_line">
                        <a href="#">
                            <div class="board_text" style="float:left;">
								<?php if($TPL_V1["state"]==0){?><p class="customer_end_icon">처리중</p><?php }elseif($TPL_V1["state"]==1){?><p class="customer_and_icon">완료</p><?php }?><span>환전금액: </span><?php echo number_format($TPL_V1["amount"])?>원
							</div>
                            <div class="board_text" style="float:right;">
                                <p class="board_bank"><span>예금주: </span><?php echo $TPL_V1["bank_owner"]?></p>
							</div>
                            <div class="board_info" style="float:left; clear: both;">
                                <p class="board_level_<?php echo $TPL_VAR["level"]?>">Lv <?php echo $TPL_VAR["level"]?></p>
                                <p class="board_name"><?php echo $TPL_VAR["nick"]?></p>
                                <p class="board_guide"></p>
                                <span class="board_time"><?php echo $TPL_V1["regdate"]?>
							</div>
                            <div class="board_checkbox" style="float:right;">
<?php if($TPL_V1["state"]==0){?>-
<?php }elseif($TPL_V1["state"]==1){?><a href="/member/exchangelist?exchange_sn=<?php echo $TPL_V1["sn"]?>"><p class="customer_bt_dell">삭제</p></a>
<?php }?>
                            </div>
                        </a>
                    </li>
<?php }}?>
                </ul>
            </div>
			</form>

			<div class="wrap_page">
					<?php echo $TPL_VAR["pagelist"]?>
			</div>