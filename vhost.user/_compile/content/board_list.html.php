<?php
	$TPL_top_list_1 = empty($TPL_VAR["top_list"]) || !is_array($TPL_VAR["top_list"]) ? 0 : count($TPL_VAR["top_list"]);
	$TPL_list_1 = empty($TPL_VAR["list"]) || !is_array($TPL_VAR["list"]) ? 0 : count($TPL_VAR["list"]);
?>
<div class="mask"></div>
<div id="container">

<script>
    $j(document).ready(function(){
        // 게시판 페이징 맨끝 없애기
        $j('.next_end').hide();
    });
</script>

<!-- 게시판 목록 시작 -->
<form name="fboardlist" method="post" style="margin:0;">
    <input type='hidden' name='bo_table' value='z30'>
    <input type='hidden' name='sfl'  value=''>
    <input type='hidden' name='stx'  value=''>
    <input type='hidden' name='spt'  value=''>
    <input type='hidden' name='page' value='1'>
    <input type='hidden' name='sw'   value=''>
    <div id="contents">
        <div class="board_box">
            <h2>
                <?php
                if ( $TPL_VAR["bbsNo"] == 7) {
                    echo "이벤트";
                } else {
                    echo "공지사항";
                }
                ?>
            </h2>
            <div class="board_list">
                <table cellpadding="0" cellspacing="0" border="0">
                    <colgroup><col width="*" /><col width="25%" /><col width="25%" /></colgroup>
                    <thead>
                        <tr>
                            <th>제목</th>
                            <th class="ta_left">작성자</th>
                            <th>작성일</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( $TPL_top_list_1 ) {
                            foreach ( $TPL_VAR["top_list"] as $TPL_V1 ) {
                    ?>
                        <tr height="51">
                            <td class="ta_left">
                                <?php 
                                if(count((array)$_SESSION['member']) > 0) { ?>
                                    <a href="/board/view?bbsNo=<?php echo $TPL_VAR["bbsNo"]?>&Article_id=<?php echo $TPL_V1["id"]?>" style="color:#858585;padding-left:20px;"><?php echo $TPL_V1["title"]?></a>
                                <?php } else {?>
                                    <a href="#" onClick="login_open();" style="color:#858585;padding-left:20px;"><?php echo $TPL_V1["title"]?></a>
                                <?php } ?> 
                            </td>
                            <td class="ta_left"><span class='member' style='color:#ffffff;'>관리자</span></td>
                            <td><?php echo str_replace("-","/",substr($TPL_V1["time"],0,10))?></td>
                        </tr>
                    <?php
                            }
                        } 
                        if ($TPL_list_1) {
                            $TPL_I1=-1;
                            foreach ( $TPL_VAR["list"] as $TPL_V1 ) { 
                                $TPL_I1++;
                    ?>
                        <tr height="51">
                            <td class="ta_left">
                                <?php 
                                if(count((array)$_SESSION['member']) > 0) { ?>
                                    <a href="/board/view?bbsNo=<?php echo $TPL_VAR["bbsNo"]?>&Article_id=<?php echo $TPL_V1["id"]?>" style="color:#858585;padding-left:20px;"><?php echo $TPL_V1["title"]?></a>
                                <?php } else {?>
                                    <a href="#" onClick="login_open();" style="color:#858585;padding-left:20px;"><?php echo $TPL_V1["title"]?></a>
                                <?php } ?> 
                            </td>
                            <td class="ta_left">
                                <span class='member' style='color:#ffffff;'>
                                    <?php if($TPL_V1["author"]=='관리자'){?>관리자<?php }else{?><img src='/images/level_icon_<?php echo $TPL_V1["mem_lev"]?>.png' align="absmiddle"><?php }?>
                                    &nbsp;&nbsp;
                                    <?php
                                        if ( $TPL_V1["author"] != '관리자' ) {
                                            $author = explode("_",$TPL_V1["author"]);
                                            if ( count($author) == 2 ) echo $author[1];
                                            else echo $author[0];
                                        }
                                    ?>
                                </span>
                            </td>
                            <td><?php echo str_replace("-","/",substr($TPL_V1["time"],0,10))?></td>
                        </tr>
                    <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
                
                <!-- 검색 및 버튼 -->
                <div class="search_area" style="text-align:right;">
                    <span class="btn01" style="position:relative;">
                        <!-- <button type="button" class="button_type01" onClick="location.href='./write.php?bo_table=z30'">글쓰기</button> -->
                    </span>
                </div>
                
                <!-- page skip -->
                <div class="page_skip">
                    <span class="num">&nbsp;
                        <?php echo $TPL_VAR["pagelist"]?>
                        <!-- <a href='' class='on'>1</a>&nbsp;<a href='./board.php?bo_table=z30&ca=&page=2'>2</a>&nbsp;
                        <a href='./board.php?bo_table=z30&ca=&page=3'>3</a>&nbsp;
                        <a href='./board.php?bo_table=z30&ca=&page=4'>4</a>&nbsp;
                        <a href='./board.php?bo_table=z30&ca=&page=5'>5</a>&nbsp;
                        <a href='./board.php?bo_table=z30&ca=&page=6'>6</a>&nbsp;
                        <a href='./board.php?bo_table=z30&ca=&page=7'>7</a>&nbsp;
                        <a href='./board.php?bo_table=z30&ca=&page=8'>8</a>&nbsp;
                        <a href='./board.php?bo_table=z30&ca=&page=9'>9</a>&nbsp;
                        <a href='./board.php?bo_table=z30&ca=&page=10'>10</a>&nbsp;
                        <a href='./board.php?bo_table=z30&ca=&page=11' class="">다음</a>&nbsp;
                        <a href='./board.php?bo_table=z30&ca=&page=1926' class="">맨끝</a>						 -->
                    </span>
                </div>
            </div>
        </div>
    </div>
</form>            
<script language="JavaScript">
    function all_checked(sw) {
        var f = document.fboardlist;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_wr_id[]")
                f.elements[i].checked = sw;
        }
    }

    function check_confirm(str) {
        var f = document.fboardlist;
        var chk_count = 0;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            warning_popup(str + "할 게시물을 하나 이상 선택하세요.");
            return false;
        }
        return true;
    }

    // 선택한 게시물 삭제
    function select_delete() {
        var f = document.fboardlist;

        str = "삭제";
        if (!check_confirm(str))
            return;

        if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
            return;

        f.action = "./delete_all.php";
        f.submit();
    }

    // 선택한 게시물 복사 및 이동
    function select_copy(sw) {
        var f = document.fboardlist;

        if (sw == "copy")
            str = "복사";
        else
            str = "이동";

        if (!check_confirm(str))
            return;

        var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

        f.sw.value = sw;
        f.target = "move";
        f.action = "./move.php";
        f.submit();
    }
</script>
<!-- 게시판 목록 끝 -->
