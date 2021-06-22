
	<div class="mask"></div>
	<div id="container">
	
<script language="javascript" src="/10bet/js/sideview.js"></script>
<script type='text/javascript' src='/10bet/js/ajax.js'></script>
<script type="text/javascript" src="/10bet/js/left.js?1610942372"></script>
    <div id="contents">
        <div class="board_box">
            <h2>이용규정</h2>
           
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

<!-- 새코멘트스킨 시작 -->
<!-- New코멘트입력 시작 -->
<form name="fviewcomment" method="post" action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" autocomplete="off" style="margin:0px;">
    <input type=hidden name=w           id=w value='c'>
    <input type=hidden name=bo_table    value='e10'>
    <input type=hidden name=wr_id       value='64'>
    <input type=hidden name=comment_id  id='comment_id' value=''>
    <input type=hidden name=sca         value='' >
    <input type=hidden name=sfl         value='' >
    <input type=hidden name=stx         value=''>
    <input type=hidden name=spt         value=''>
    <input type=hidden name=page        value=''>
    <input type=hidden name=cwin        value=''>
    <input type=hidden name=is_good     value=''>


    <!-- New코멘트입력 끝 -->
    <ul class="reply_list">
    </ul>



</td></tr></table>
<script language='javascript'> var g4_cf_filter = ''; </script>
<script language='javascript' src='/10bet/js/filter.js'></script>
    </div>
</div>

	<!-- 베팅카트 -->
	<!-- 모바일 푸터 메뉴 -->
	<div id="mobile_foot_menu">
		<ul class="foot_menu">
			<li><span class="ico_customer"><a href="https://t.me/tenbetkorea" target="_blank"><img src="/images/10bet/ico_telegram_01.png" alt="텔레그램" /></a></span></li>
			<li><span class="ico_customer"><a href="/bbs/board.php?bo_table=z10"><img src="/images/10bet/ico_customer_01.png" alt="고객문의" /></a></span></li>
			<!--<li><span class="ico_chetting"><img src="/images/10bet/ico_chetting_01.png" alt="라이브채팅" /></span></li>-->
    					<li><span class="ico_cart" id="ico_betting_cart"><img src="/images/10bet/ico_cart_01.png" alt="배팅카트" /></span></li>
						<li><span class="ico_bottom_menu" id="ico_bottom_menu">
								SPORT
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 33 35" fill="currentColor">
					<rect width="33" height="7" rx="3.5" ry="3.5"></rect>
					<rect y="14" width="33" height="7" rx="3.5" ry="3.5"></rect>
					<rect y="28" width="33" height="7" rx="3.5" ry="3.5"></rect>
				</svg>
				</span>
			</li>
		</ul>
	</div>
	
	<!-- 모바일 베팅카트 -->
    <div class="mobile_betting_cart" id="mobile_betting_cart">
		<form name="betForm" method="post"  action="../bbs/betting.php" onSubmit="return check(this)" style="margin:0px;">
            <input type="hidden" name="mode" value="cart">
            <input type="hidden" name="bo_table" value="e10">
            <input type="hidden" name="ca" value="">
            <input type="hidden" name="betcontent" value="0">
            <input type="hidden" name="strgametype" value="">
            <input type="hidden" name="sp_bets" value="">
            <input type="hidden" name="sp_totals" value="">
            <input type="hidden" name="b_type" value="">
            <div class="logo"><a href="#none"><img src="/images/10bet/logo_01.png" alt="IO BET 로고" /></a></div>
            <!-- 베팅카트 -->
            <div class="betting_cart box_type01">
                <h3><img src="/images/10bet/ico_cart_01.png" alt="" /> betting cart</h3>
                <ul class="betting_list">
                    <li>
                    <table id="tb_list" width="100%"  cellspacing="0" cellpadding="0" align="center">
                    </table>
                    </li>
                </ul>
                
                <div class="betting_box">
                    <ul>
                        <li>보유머니<span>0 원</span></li>
                        <li>예상적중배당<span id="sp_bet">00.00</span></li>
                        <li>최대배팅금액<span>0</span></li>
                        <li>배팅금액<span><input type="text" name="betprice" id="betprice" value="" onKeyUp="cart_input(this,event)" onKeydown="if(event.keyCode == 13) return false;" value=""/> 원</span></li>
                        <li>예상적중금액<span id="sp_total">0</span></li>
                    </ul>
                    <div class="btn_list">
                        <button type="button" onClick="cart_money_input(1000)">+ 1,000</button>
                        <button type="button" onClick="cart_money_input(5000)">+ 5,000</button>
                        <button type="button" onClick="cart_money_input(10000)">+ 10,000</button>
                        <button type="button" onClick="cart_money_input(50000)">+ 50,000</button>
                        <button type="button" onClick="cart_money_input(100000)">+ 100,000</button>
                        <button type="button" onClick="cart_money_input(500000)">+ 500,000</button>
                        <button type="button" onClick="cart_money_clear()"><span>RESET</span></button>
                        <button type="button" onClick="cart_del_all();">초기화</button>
                    </div>
                    <div class="max_bet">
                        <button type="button" onClick="cart_max_input();return false">MAX BETTING</button>
                    </div>
                    <div class="bet_arae">
                        <button type="button" class="btn_bet" onClick="betting('betting')">배팅하기</button>
                        <button type="button" class="btn_del" onClick="cart_del_all()">전체삭제</button>
                    </div>
                </div>
            </div>
	    </form>
	</div>
		
<!-- 모바일 하단 메뉴 -->
<script language='javascript'> var g4_cf_filter = ''; </script>
<script language='javascript' src='/10bet/js/filter.js'></script>
<script>
    $j(function(){ 
        var ww2 = window.innerWidth;
        if(ww2 <= 1200) {
            $j("#pc_betting_cart").empty();
        }else {
            $j("#mobile_betting_cart").empty();
        }
    });
    $j(window).resize(function() { 
        var ww2 = window.innerWidth;
        if(ww2 <= 1200) {
            $j("#pc_betting_cart").empty();
        }else {
            $j("#mobile_betting_cart").empty();
        }
    });
</script>
<!-- 추가스킨(프로그램입힐곳) 시작 --> 

<script language="JavaScript">
    function file_download(link, file) {
        document.location.href=link;
    }
</script> 
<script language="JavaScript" src="/10bet/js/board.js"></script> 
</script> 
<!-- 게시글 보기 끝 --> 