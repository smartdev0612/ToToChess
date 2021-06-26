
	<div class="mask"></div>
	<div id="container">
	
<script type='text/javascript' src='/10bet/js/ajax.js'></script>
<script type="text/javascript" src="/10bet/js/left.js?1610942372"></script>
    <div id="contents">
        <div class="board_box">
            <h2>배팅규정</h2>
           
            <!-- 게시판 -->
            <div class="board_view">
                <div class="view_text">
                    <!-- 내용 출력 -->
                    <?php 
                    if(count($TPL_VAR["list"]) > 0) 
                        echo $TPL_VAR["list"]["content"];
                    else 
                        echo "<p style='text-align:center; font-size: 18px;'>내용이 없습니다.</p>";
                    ?>
                </div>
            </div>
        </div>
