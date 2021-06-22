<?php /* Template_ 2.2.3 2014/10/07 20:46:52 D:\www_one-23.com\m.vhost.user\_template\content\cs_list.html */
$TPL_top_list_1=empty($TPL_VAR["top_list"])||!is_array($TPL_VAR["top_list"])?0:count($TPL_VAR["top_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	function onTitleClick($index)
	{
		if(document.getElementById($index+"_content").style.display=="none")
		{
			$("tr[id^="+$index+"_content]").css("display", "none");
			$("tr[id="+$index+"_content]").css("display", "");
		}
		else
		{
			$("tr[id="+$index+"_content]").css("display", "none");
		}
	}
	
	function doSubmit()
	{
		if(document.frm_write.content.value=="")
		{
			alert("문의할 내용을 입력하여 주십시오.");
			document.frm_write.content.focus();
			return;
		}
		document.frm_write.submit();
	}
	
	function godel(url)
	{
		var r=confirm("정말로 삭제 하시겠습니까?");
		if (r==true)
		{ 
			document.location.href=url;
		}
}  
</script>
            <div class="sub_title" style="margin-top:10px;">
                <span class="sub_title_text">고객센터</span>
								<a href="javascript:ask_account();" class="bt_writh" style="background-color:#B70000;">계좌문의</a>
								<a href="javascript:void()" class="bt_writh" onClick="document.all.wrap_qnaadd.style.display=''; document.all.content.focus();">질문하기</a>
								<a href="javascript:window.location.reload();" class="bt_writh">새로고침</a>
            </div>
            <div class="board_list">
                <ul>
<?php if($TPL_list_1){$TPL_I1=-1;foreach($TPL_VAR["list"] as $TPL_V1){$TPL_I1++;?>
                    <li class="board_nomal_line">
                        <a href="javascript:;" onclick="onTitleClick(<?php echo $TPL_I1+1?>);" style="cursor:hand">
                            <span class="board_text"><?php if(count((array)$TPL_V1["reply"])<=0){?><p class="customer_and_icon">진행</p><?php }else{?><p class="customer_end_icon">완료</p><?php }?><?php echo $TPL_V1["content"]?></span>
                            <span class="board_info">
                                <p class="board_level_4">Lv <?php echo $TPL_VAR["level"]?></p><?php echo $TPL_VAR["nick"]?>
                                <p class="board_guide"></p>
                                <span class="board_time"><?php echo $TPL_V1["regdate"]?></span>
																<span class="board_checkbox" style="float:right;"><img src="/img/bt_del_1.png" onclick="godel('?act=del&idx=<?php echo $TPL_V1["idx"]?>');"></span>
                            </span>
                        </a>
                    </li>
<?php /*if(sizeof($TPL_V1["reply"])>0){*/?>
                    <li class="board_nomal_line" id="<?php echo $TPL_I1+1?>_content" style="display:none;">
											<?php echo nl2br(html_entity_decode($TPL_V1["reply"]["content"]))?>
                    </li>
<?php }}?>
                </ul>
            </div>


            <div class="board_writh" id="wrap_qnaadd" style="width:97%;display:none;">
							<center>
			 <form name="frm_write" method="post" action="?">
				<input type="hidden" name="act" value="add">
                <p class="board_writh_content">
				    <textarea name="content" rows="10" id="content" placeholder="내용은 200자까지 입력가능합니다." style="width:94%"><?php echo str_replace("<br>",chr(13),$TPL_VAR["content"])?></textarea>
                </p>
                <p class="board_writh_bt_box">
                    <a href="javascript:;" class="bt_writh_1" onclick="doSubmit();">등록</a>
                    <a href="javascript:;" class="bt_back" onClick="document.all.wrap_qnaadd.style.display='none';">취소</a>
                </p>
			 </form>
							</center>
            </div>

            <div class="wrap_page" style="margin-top:15px;"><?php echo $TPL_VAR["pagelist"]?></div>

<script>
	function view_write() {
		$("#wrap_qnaadd").toggle();
		$("#content").focus();
	}

	function onTitleClick($index) {
		if(document.getElementById($index+"_content").style.display=="none") {
			$("li[id^="+$index+"_content]").css("display", "none");
			$("li[id="+$index+"_content]").css("display", "");
		} else {
			$("li[id="+$index+"_content]").css("display", "none");
		}
	}

	function doSubmit() {
		if(document.frm_write.content.value=="") {
			alert("문의할 내용을 입력하여 주십시오.");
			document.frm_write.content.focus();
			return;
		}
		document.frm_write.submit();
	}

	function godel(url) {
		if (confirm("정말로 삭제 하시겠습니까?")) { 
			document.location.href=url;
		}
	}

	function ask_account() {
		document.frm_write.content.value='계좌 문의';
		doSubmit();
	}
</script>