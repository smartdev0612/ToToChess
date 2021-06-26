<?php
	$TPL_top_list_1=empty($TPL_VAR["top_list"])||!is_array($TPL_VAR["top_list"])?0:count($TPL_VAR["top_list"]);
    $TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
    <div class="mask"></div>
	<div id="container">

<script type="text/javascript" src="/10bet/js/left.js?1610361825"></script>
<!-- 게시판 목록 시작 -->
<form id="fboardlist" method="post" style="margin:0;" action="?">
    <input type="hidden" name="act" value="add">
    <input type="hidden" name="site_code" value="site-a">
    <input type='hidden' id='title' name='title'>
    <input type='hidden' id='content' name='content'>
    <div id="contents">
        <div class="board_box">
            <h2>고객센터</h2>
            <div class="board_list">
                <table cellpadding="0" cellspacing="0" border="0">
                    <colgroup><col width="10%" /><col width="*" /><col width="20%" /><col width="10%" /><col width="10%" /></colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>작성일</th>
                            <th>상태</th>
                            <th>처리</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ( $TPL_list_1 ) { 
                                $TPL_I1 = -1;
                                foreach ( $TPL_VAR["list"] as $TPL_V1 ) { 
                                    $TPL_I1++;
                                    if ( count((array)$TPL_V1["reply"]) <= 0 ) {
                                        $reCallFalg++;
                                    }
                        ?>
                        <tr height="51" <?php if(count((array)$TPL_V1["reply"])>0){?> onclick="onTitleClick(<?php echo $TPL_I1+1?>);" style="cursor:pointer;"<?php }?>>
                            <td>
                                <?php echo $TPL_I1+1?>
                            </td>
                            <td class="ta_left"><?php echo nl2br($TPL_V1["subject"])?></td>
                            <td><span class='member' style='color:#ffffff;'><?php echo substr($TPL_V1["regdate"], 5)?></span></td>
                            <td><?php if(count((array)$TPL_V1["reply"])<=0){?>준비중<?php }else{?>완료<?php }?></td>
                            <td><a href="/cs/cs_list?act=del&amp;idx=<?php echo $TPL_V1["idx"]?>" class="btn btn-danger btnstyle_s" style="color: red;" >삭제</a></td>
                        </tr>
                        <?php if(count((array)$TPL_V1["reply"])>0){?>
	
                            <tr id="<?php echo $TPL_I1+1?>_content" class="cs_answer" style="display:none;">
                                <td colspan="5"><p><?php echo nl2br(html_entity_decode($TPL_V1["reply"]["content"]))?></p></td>
                            </tr>

                        <?php }?>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
                
                <!-- 검색 및 버튼 -->
                <div class="search_area" style="text-align:right;">
                    <span class="btn01" style="position:relative;">
                        <a href="https://telegram.me/<?=$TPL_VAR["telegramID"]?>" target="_blank"><button type="button" class="button_type01" style="background:#1a4050;">텔레그램 문의</button></a>
                        <button type="button" class="button_type01" onclick="ask_account();">계좌문의</button>
                        <button type="button" class="button_type01" onClick="view_write();">문의하기</button>
                    </span>
                </div>
                
                <!-- page skip -->
                <div class="page_skip">
                    <span class="num"></span>
                </div>
            </div>
        </div>
    </div>
</form>            
<script language="JavaScript">
    
    var reCallFalg = <?=$reCallFalg+0;?>;
	function view_write() {
		if ( reCallFalg > 0 ) {
			alert("앞선 문의의 관리자 답변을 기다리고 있습니다.\n답변을 받은 후 재문의 하여 주세요.");
			return;
		} else {
            location.href = "/cs/question";
        }
	}

	function onTitleClick($index) {
		// if(document.getElementById($index+"_content").style.display=="none") {
		// 	jq$("tr[id^="+$index+"_content]").css("display", "none");
		// 	jq$("tr[id="+$index+"_content]").css("display", "");
		// } else {
		// 	jq$("tr[id="+$index+"_content]").css("display", "none");
        // }
        $j("#" + $index + "_content").toggle();
	}

	function doSubmit() {
		if($j("#content").val()=="") {
			alert("문의할 내용을 입력하여 주십시오.");
			document.getElementById("content").focus();
			return;
        }
        $j("#fboardlist").submit();
	}

	function godel(url) {
		var r=confirm("정말로 삭제 하시겠습니까?");
		if (r==true) { 
			document.location.href=url;
		}
	}

	function ask_account() {
		if ( reCallFalg > 0 ) {
			alert("앞선 문의의 관리자 답변을 기다리고 있습니다.\n답변을 받은 후 재문의 하여 주세요.");
			return;
        }
        $j("#title").val("계좌문의");
        $j("#content").val("계좌문의");
		doSubmit();
	}
</script>
    <!-- 게시판 목록 끝 -->
