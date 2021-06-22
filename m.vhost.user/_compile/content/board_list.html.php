<?php /* Template_ 2.2.3 2014/10/23 18:16:12 D:\www_one-23.com\m.vhost.user\_template\content\board_list.html */
$TPL_top_list_1=empty($TPL_VAR["top_list"])||!is_array($TPL_VAR["top_list"])?0:count($TPL_VAR["top_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>

	<div class="sub_title" style="margin-top:10px;">
		<span class="sub_title_text">
<?php
	if ( $TPL_VAR["bbsNo"] == 5 ) echo "게시판";
	else echo "이벤트";
?>
		</span>
		<?php if($TPL_VAR["bbsNo"]!=7&&$TPL_VAR["bbsNo"]!=9){?><a href="javascript:void()" onclick="location.href='/board/write'" class="bt_writh">글쓰기</a><?php }?>
	</div>

            <div class="board_list">
                <ul>
<?php if($TPL_top_list_1){foreach($TPL_VAR["top_list"] as $TPL_V1){?>
                    <li class="board_notice_line">
                        <a href="/board/view?bbsNo=<?php echo $TPL_VAR["bbsNo"]?>&Article_id=<?php echo $TPL_V1["id"]?>">
                            <span class="board_text"><span class="notice_text_color_1">[공지] <?php echo $TPL_V1["title"]?></span></span>
                            <span class="board_info">
                                <p class="board_level_admin">관리자</p>관리자
                                <p class="board_guide"></p>
                                <span class="board_time"><?php echo substr($TPL_V1["time"],0,10)?></span>
                            </span>
                        </a>
                    </li>
<?php }}?>

<?php if($TPL_list_1){$TPL_I1=-1;foreach($TPL_VAR["list"] as $TPL_V1){$TPL_I1++;?>
                    <li class="board_nomal_line">
                        <a href="/board/view?bbsNo=<?php echo $TPL_VAR["bbsNo"]?>&Article_id=<?php echo $TPL_V1["id"]?>">
                            <span class="board_text"><?php echo $TPL_V1["title"]?>(<?php echo $TPL_V1["reply"]?>)<?php if($TPL_V1["isBet_list"]!=""){?><p class="board_bet_icon">B</p><?php }?> <?php if(date("Y-m-d")==date("Y-m-d",strtotime($TPL_V1["time"]))){?><img src="/img/icon_bbs_new.gif"><?php }?></span>
                            <span class="board_info">
                                <?php if($TPL_V1["author"]=='관리자'){?><p class="board_level_admin">관리자</p><?php }else{?><p class="board_level_<?php echo $TPL_V1["mem_lev"]?>">Lv <?php echo $TPL_V1["mem_lev"]?></p><?php echo $TPL_V1["author"]?><?php }?>
                                <p class="board_guide"></p>
                                <span class="board_time"><?php echo substr($TPL_V1["time"],0,10)?></span>
                            </span>
                        </a>
                    </li>
<?php }}?>

                </ul>
            </div>
			<div class="wrap_page">
				<?php echo $TPL_VAR["pagelist"]?>
			</div>
		</div>
