<?php /* Template_ 2.2.3 2014/10/07 21:33:54 D:\www_one-23.com\m.vhost.user\_template\content\memo_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
            <div class="sub_title" style="margin-top:10px;">
                <span class="sub_title_text">쪽지</span>
            </div>

            <div class="board_list">
                <ul>
<?php if($TPL_list_1){$TPL_I1=-1;foreach($TPL_VAR["list"] as $TPL_V1){$TPL_I1++;?>
                    <li class="board_nomal_line">
                        <a href="javascript:;" onclick="onTitleClick('<?php echo $TPL_I1+1?>', '<?php echo $TPL_V1["mem_idx"]?>');" style="cursor:hand">
                            <span class="board_info">
                                <p class="board_level_5">Lv <?php echo $TPL_VAR["level"]?></p><?php echo $TPL_VAR["nick"]?>
                                <p class="board_guide"></p>
															  <span class="board_time"><?php echo substr($TPL_V1["writeday"],0,10)?></span>
																<span class="board_checkbox"><img src="/img/bt_del_1.png" onclick="dodel('?mode=del&id=<?php echo $TPL_V1["mem_idx"]?>');"></span>
                            </span>
                            <span class="board_text"><?php echo $TPL_V1["title"]?></span>
                        </a>
                    </li>
                    <li class="board_nomal_line" id="<?php echo $TPL_I1+1?>_content" style="padding:5px 0 15px 0;display:none;">
											<?php echo nl2br($TPL_V1["content"])?>
                    </li>
<?php }}?>
                </ul>
            </div>

            <div class="wrap_page" style="margin-top:15px;">
							<?php echo $TPL_VAR["pagelist"]?>
            </div>

<script>
	function dodel(url)
	{ 
		var r=confirm("정말로 삭제 하시겠습니까?");
		if (r==true)
		{   
			document.location.href=url;
		}
	}
	function onDeleteAll(url)
	{ 
		var r=confirm("정말로 삭제 하시겠습니까?");
		if (r==true)
		{   
			document.location.href=url;
		}
	}
	
	function onTitleClick($index, $idx)
	{
		if(document.getElementById($index+"_content").style.display=="none")
		{
			$("li[id^="+$index+"_content]").css("display", "none");
			$("li[id="+$index+"_content]").css("display", "");
			
			$.ajaxSetup({async:false});
			var param={idx:$idx};
			$.post("/member/readMemoCheck", param, testt($index));
		}
		else
		{
			$("li[id="+$index+"_content]").css("display", "none");
		}
	}
	
	function testt($index)
	{
		$("#"+$index+"_img").attr('src', '/img/member/icon_memo2.gif');
	}
	
</script>