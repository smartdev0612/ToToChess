
<div class="mask"></div>
<div id="container">
	
<style type="text/css">
    .latest_list th{color:#ffffff; font-size:12px;}
    .latest_list td{ border-bottom:1px solid #333333;height:28px;}
    .latest_list .list0{background:#edf2fb;}
    .latest_list .list1{background:#edf2fb;}
    body {
        margin-left: 10px;
        margin-top: 10px;
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>
<script>
    var VarBoTable = "a10";
    var VarBoTable2 = "a25";
    var VarCaId = "";
    var VarColspan = "7";
    $j().ready(function(){
        path = '/ajax.list.php?bo_table=a10&ca=&sca=&sfl=&stx=&b_type=2';
        init("" + g4_path + path);
        
        path2 = '/ajax.list.php?bo_table=a25&ca=&sca=&sfl=&stx=';
        init2("" + g4_path + path2);
        //setInterval("init('"+g4_path+ path +"')", 30000);
    });
</script>
<script type="text/javascript" src="/js/left.js?1610763291"></script>
		
		<div id="contents">
			<div class="board_box">
				<h2>추천인</h2>
				<div class="message_count">내가 추천한 회원은 <span>총 0명</span> 입니다.</div>
				<div class="board_list">
					<table cellpadding="0" cellspacing="0" border="0">
						<colgroup><col width="10%" /><col width="*" /><col width="30%" /></colgroup>
						<thead>
							<tr>
								<th>번호</th>
								<th>추천인 아이디</th>
								<th>가입일</th>
                    			<th><strong>충전금액</strong></th>
			                    <th><strong>충전횟수</strong></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="5">내역이 없습니다.</td>
							</tr>								
						</tbody>
					</table>
					<!-- page skip -->
					<div class="page_skip"></div>
				</div>
			</div>
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
        <form name="betForm" method="post"  action="./bbs/betting.php" onSubmit="return check(this)" style="margin:0px;">
            <input type="hidden" name="mode" value="cart">
            <input type="hidden" name="bo_table" value="">
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
<script language='javascript' src='./js/filter.js'></script>
<script>
    function check(){
        var f = document.fwrite;
        var ex_point = f.wr_content.value.replace(/,/gi, "");
        //var mb_point = 0;
        var mb_point = f.my_credit.value.replace(/,/gi, "");
        var min_point = 10000;
        if( f.wr_10.value == "환전신청" && ex_point != "")
        {
            if(parseInt(ex_point) > parseInt(mb_point)) {
                warning_popup('보유한 크레딧보다 더 신청하실 수 없습니다.');
                f.wr_content.value = "";
                f.wr_content.focus();
                return false;
            }

            if(ex_point < min_point) {
                warning_popup('10000원 이상만 환전신청을 하실 수 있습니다!')
                f.wr_content.value = "";
                f.wr_content.focus();
                return false;
            }
        }
        var pricecheck = parseInt(ex_point / 1000);
        pricecheck = pricecheck * 1000;
        if (pricecheck != ex_point)
        {
            warning_popup("금액은 천원단위로 입력하십시오.");
            f.wr_content.value = "";
            f.wr_content.focus();
            return false;
        }
    }

    function fwrite_check(f) {
        var s = "";
        check();
        if( f.wr_10.value == "" )
        {
            warning_popup("충/환전을 선택해주세요.");
            return false;
        }

        if( f.wr_content.value == "" )
        {
            warning_popup("요청금액을 입력해주세요.");
            return false;
        }
        for(var i=0; i < 2; i++)
        {
            f.wr_content.value = f.wr_content.value.replace(",", "");
        }

        if (s = word_filter_check(f.wr_content.value)) {
            warning_popup("내용에 금지단어('"+s+"')가 포함되어있습니다");
            return false;
        }

        if (document.getElementById('char_count')) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(document.getElementById('char_count').innerHTML);
                if (char_min > 0 && char_min > cnt) {
                    warning_popup("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    warning_popup("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        if (typeof(f.wr_key) != "undefined") {
            if (hex_md5(f.wr_key.value) != md5_norobot_key) {
                warning_popup("자동등록방지용 빨간글자가 순서대로 입력되지 않았습니다.");
                f.wr_key.focus();
                return false;
            }
        }

        var geditor_status = document.getElementById("geditor_wr_content_geditor_status");

        if (geditor_status != null)
        {
            if (geditor_status.value == "TEXT") {
                f.html.value = "html2";
            }
            else if (geditor_status.value == "WYSIWYG") {
                f.html.value = "html1";
            }
        }

        /*if(f.wr_10.value == "환전신청")
        {
            f.wr_8.value = f.wr_8.value - f.wr_content.value;
        }*/
        
        //$j("#check_bg").show();	
        //$j("#submit_btn").hide();	
        f.action = '/bbs/write_update.php';	return true;
    }
    function mcheck(){
        var f = document.mfwrite;
        var ex_point = f.wr_content.value.replace(/,/gi, "");
        //var mb_point = 0;
        var mb_point = f.my_credit.value.replace(/,/gi, "");
        var min_point = 10000;
        if( f.wr_10.value == "환전신청" && ex_point != "")
        {
            if(parseInt(ex_point) > parseInt(mb_point)) {
                warning_popup('보유한 크레딧보다 더 신청하실 수 없습니다.')
                f.wr_content.value = "";
                f.wr_content.focus();
                return false;
            }

            if(ex_point < min_point) {
                warning_popup('10000원 이상만 환전신청을 하실 수 있습니다!')
                f.wr_content.value = "";
                f.wr_content.focus();
                return false;
            }
        }
        var pricecheck = parseInt(ex_point / 1000);
        pricecheck = pricecheck * 1000;
        if (pricecheck != ex_point)
        {
            warning_popup("금액은 천원단위로 입력하십시오.");
            f.wr_content.value = "";
            f.wr_content.focus();
            return false;
        }
    }

    function mfwrite_check(f) {
        var s = "";
        mcheck();
        if( f.wr_10.value == "" )
        {
            warning_popup("충/환전을 선택해주세요.");
            return false;
        }

        if( f.wr_content.value == "" )
        {
            warning_popup("요청금액을 입력해주세요.");
            return false;
        }
        for(var i=0; i < 2; i++)
        {
            f.wr_content.value = f.wr_content.value.replace(",", "");
        }

        if (s = word_filter_check(f.wr_content.value)) {
            warning_popup("내용에 금지단어('"+s+"')가 포함되어있습니다");
            return false;
        }

        if (document.getElementById('char_count')) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(document.getElementById('char_count').innerHTML);
                if (char_min > 0 && char_min > cnt) {
                    warning_popup("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    warning_popup("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        if (typeof(f.wr_key) != "undefined") {
            if (hex_md5(f.wr_key.value) != md5_norobot_key) {
                warning_popup("자동등록방지용 빨간글자가 순서대로 입력되지 않았습니다.");
                f.wr_key.focus();
                return false;
            }
        }

        var geditor_status = document.getElementById("geditor_wr_content_geditor_status");

        if (geditor_status != null)
        {
            if (geditor_status.value == "TEXT") {
                f.html.value = "html2";
            }
            else if (geditor_status.value == "WYSIWYG") {
                f.html.value = "html1";
            }
        }

        /*if(f.wr_10.value == "환전신청")
        {
            f.wr_8.value = f.wr_8.value - f.wr_content.value;
        }*/
        
        //$j("#check_bg").show();	
        //$j("#submit_btn").hide();	
        f.action = '/bbs/write_update.php';	return true;
    }
    function game_select(game,e) {
        get_casino_money(game);
        var text = $j(e).text();
        $j("#wr_subject").val(game);
        $j(".before_select").text(text);
        $j(".company_list").hide();
    }
    function game_select2(game,e) {
        var text = $j(e).text();
        $j("#wr_subject2").val(game);
        $j(".after_select").text(text);
        $j(".company_list").hide();
    }
    function get_casino_money(game) {
        $j.ajax({
            url: '/ajax.get_casino_money.php',
            type: 'POST',
            data: {'ptype' : game},
            dataType: 'json',
            success: function(data) {
                //$j("#have_money").val(data.money+"원");
                $j("#my_credit").val(data.money);
            }
        });
    }
</script>
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