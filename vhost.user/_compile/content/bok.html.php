
<div class="mask"></div>
<div id="container">
	
<script src="/10bet//code.jquery.com/jquery-1.11.0.min.js"></script>
<style type="text/css">
    .bok_wrap {width:100%;text-align:center; position:relative;padding-top:10px;}
    .bok_wrap table {vertical-align:top;}
    .bok_wrap2 {width:1017px;text-align:center;margin:0 auto; position:relative;display:inline-block;background-color:rgba(0,0,0,0.8);}
    .bok_wrap2 .bok_count {color:#fff; font-weight:bold; font-size:24px; width:52px; height:36px; text-align:center; position:absolute; top:564px; left:315px;}
    .bok_wrap2 .next_bok_btn {position:absolute; top:549px; left:425px;}
    .bok_wrap2 .all_bok_btn {position:absolute; top:549px; left:658px;}
    .bok_table { width:100%;}
    .bok_table th {background:#09021f; color:#fff; font-size:14px; font-weight:bold; height:42px; }
    .bok_table .bok_tbg { background:#2b2626; border-bottom:1px solid #000; text-align:center; color:#fff; font-size:12px; height:30px;}

    .page_num strong {color:yellow;}
    .page_num span , .page_num span a {color:#ddd;}
    .page_num a{color:#fff;}
    .page_num a:hover{color:#ddd;}
    .lottery_box .event_area{background:url("/10bet/images/10bet/bok_event_new.png");padding:0;}
    .lottery_box .event_area .img01 {width:100%;}
    .lottery_box .event_area .img01 img {opacity:0;position:relative;}
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
<script type="text/javascript" src="/10bet/js/left.js?1610745599"></script>
		
<form name="form" method="post">
	<input type="hidden" name="bo_table">
	<input type="hidden" name="wr_1">
</form>
<form name="bettingList" style="margin:0;">
    <div id="contents">
        <div class="board_box">
            <h2>복권이벤트</h2>
            <div class="lottery_box">
                <div class="box01">
                    <h3><img src="/10bet/images/10bet/title_lottery_01.png" alt="복권이벤트" /></h3>
                    <div class="event_area">
                        <div class="img01">
                            <!--<img src="/10bet/images/10bet/img_lottery_01.jpg" alt="10,000원 당첨" />
                            <div class="mask01"><span>마우스로 복권을 긁어주세요.</span></div>-->
                            <img src="/10bet/images/10bet/bok_event_new.png" />
                            <div id="bok_click" style="position:absolute; top:37px; left:63px; z-index:1000;cursor:pointer;">
                                <canvas id="bokCanvas" style="cursor:pointer;display:none;" width="687" height="205"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="info_area">
                        <div class="count">남은복권 <span>0개</span></div>
                        <div class="btn_area">
                            <button type="button" onClick="warning_popup('남은 복권이 없습니다');">다음 복권 긁기</button>
                            <button type="button" onClick="bok_all_go();">전체 복권 긁기</button>
                        </div>
                    </div>
                </div>					
            </div>
            
            <h2>복권 이벤트 내역</h2>
            
            <div class="board_list">
                <table cellpadding="0" cellspacing="0" border="0">
                    <colgroup><col width="10%" /><col width="50%" /><col width="*" /></colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>사용일</th>
                            <th>당첨금</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">내역이 없습니다.</td>
                        </tr>								
                    </tbody>
                </table>
                
                <!-- page skip -->
                <div class="page_skip"></div>
            </div>
        </div>
</form>
	<!-- 베팅카트 -->
	<!-- 모바일 푸터 메뉴 -->
	<div id="mobile_foot_menu">
		<ul class="foot_menu">
			<li><span class="ico_customer"><a href="https://t.me/tenbetkorea" target="_blank"><img src="/10bet/images/10bet/ico_telegram_01.png" alt="텔레그램" /></a></span></li>
			<li><span class="ico_customer"><a href="/bbs/board.php?bo_table=z10"><img src="/10bet/images/10bet/ico_customer_01.png" alt="고객문의" /></a></span></li>
			<!--<li><span class="ico_chetting"><img src="/10bet/images/10bet/ico_chetting_01.png" alt="라이브채팅" /></span></li>-->
    					<li><span class="ico_cart" id="ico_betting_cart"><img src="/10bet/images/10bet/ico_cart_01.png" alt="배팅카트" /></span></li>
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
		<input type="hidden" name="bo_table" value="">
		<input type="hidden" name="ca" value="">
		<input type="hidden" name="betcontent" value="0">
		<input type="hidden" name="strgametype" value="">
		<input type="hidden" name="sp_bets" value="">
		<input type="hidden" name="sp_totals" value="">
		<input type="hidden" name="b_type" value="">
		<div class="logo"><a href="#none"><img src="/10bet/images/10bet/logo_01.png" alt="IO BET 로고" /></a></div>
		<!-- 베팅카트 -->
		<div class="betting_cart box_type01">
			<h3><img src="/10bet/images/10bet/ico_cart_01.png" alt="" /> betting cart</h3>
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
    <script language='javascript' src='../js/filter.js'></script>
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

    <script type="text/javascript">
    function bok_go(){
        document.location.href ='/bbs/bok.php';
    }
    function bok_all_go(){
        document.location.href ='/bbs/bok_text.php?mode=all';
    }

    function select_check_one(gid){
        var f = document.bettingList;
        for( var i = 0; i < f['chk'].length; i++){
            if( f['chk'][i].value == gid ) {
                f['chk'][i].checked=true;
                break;
            }
        }
    }
    function select_betting() {
        var f = document.bettingList;
        var tmpGid = "";

        for( var i = 0; i < f['chk'].length; i++) {
            if( f['chk'][i].checked == true ) tmpGid +=  f['chk'][i].value+",";
        }

        if( typeof(f['chk'].length) == "undefined" ) {
            tmpGid += f['chk'].value+",";
        }

        if( tmpGid == "" ) {
            warning_popup("추첨내역을 선택해주세요!");
            return false;
        }

        if (!confirm("해당건을 게시판에 등록하시겠습니까?"))
            return;

        document.form.bo_table.value = "z30";
        document.form.wr_1.value = "[bok:"+tmpGid+"]";

        document.form.action = "./write.php";
        document.form.submit();
    }

    var COMPLETE_PERCENTAGE = 20;
    var LINE_WIDTH = 40;
    var STROKE_STYLE = "#000";
    var CANVAS_ID = "bokCanvas";
    var CANVAS_FONT = "50px Gulim";

    var W = 0;
    var H = 0;

    var ARRAY_X = 20;
    var ARRAY_Y = 5;

    var positions_arr = [];
    var isAlert = false;
    var clearCount = 0;
    var c = null;
    var bok_cnt = 0;

    if(bok_cnt > 0){
        var image = { // back and front images
            'back': { 'url':'/10bet/images/10bet/img_lottery_01.jpg', 'txt':'' },
            'front': { 'url':'/10bet/images/10bet/bok_new_bg.jpg', 'txt':null }
        };
    }else {
        var image = { // back and front images
            'back': { 'url':'/10bet/images/10bet/no_bok.png?v=1', 'txt':'' },
            'front': { 'url':'/10bet/images/10bet/bok_new_bg.jpg', 'txt':null }
        };
        }
    var canvas = {'temp':null, 'draw':null}; // temp and draw canvases
    var mouseDown = false;

    function getLocalCoords(elem, ev) {
        var ev_n = ev;
        var ox = 0, oy = 0;
        var first;
        var pageX, pageY;

        // Walk back up the tree to calculate the total page offset of the
        // currentTarget element.  I can't tell you how happy this makes me.
        // Really.
        while (elem != null) {
            ox += elem.offsetLeft;
            oy += elem.offsetTop;
            elem = elem.offsetParent;
        }
        //if (w <= 370) {
        if (ev.hasOwnProperty('changedTouches')) {
            first = ev.changedTouches[0];
            pageX = first.pageX;
            pageY = first.pageY;
        } else {
            pageX = ev.pageX;
            pageY = ev.pageY;
        }
        return { 'x': pageX - ox, 'y': pageY - oy };

    }

    function recompositeCanvases() {
        var main = c;
        var tempctx = canvas.temp.getContext('2d');
        var mainctx = main.getContext('2d');
        
        // Step 1: clear the temp

        canvas.temp.width = canvas.temp.width; // resizing clears
        // Step 2: stamp the draw on the temp (source-over)

        tempctx.drawImage(canvas.draw, 0, 0);
        
        /* !!!! this way doesn't work on FF:
            // Step 3: stamp the foreground on the temp (!! source-out mode !!)
            tempctx.globalCompositeOperation = 'source-out';
            tempctx.drawImage(image.front.img, 0, 0);
            // Step 4: stamp the background on the display canvas (source-over)
            //mainctx.drawImage(image.back.img, 0, 0);
            // Step 5: stamp the temp on the display canvas (source-over)
            mainctx.drawImage(canvas.temp, 0, 0);
        */
        // Step 3: stamp the background on the temp (!! source-atop mode !!)

        tempctx.globalCompositeOperation = 'source-atop';
        
        //tempctx.drawImage(image.back.img, 0, 0);
        //mainctx.drawImage(image.front.img, 0, 0);
        
        if (image.back.txt != null) {
            tempctx.font = "20px Gulim";
            tempctx.textAlign="center";
            tempctx.fillStyle="#ddd";

            tempctx.drawImage(image.back.img, 0, 0, W, H);
            tempctx.fillText(image.back.txt, W*0.5, H*0.5);
        } else {
            tempctx.font = "50px Gulim";
            tempctx.textAlign="center";
            tempctx.drawImage(image.back.img, 0, 0, W*1, H);
        }

        if (image.front.txt != null) {
            mainctx.font = "50px Gulim";
            mainctx.textAlign="center";
            mainctx.fillStyle="#ddd";
            mainctx.fillText(image.front.txt, W*0.5, H*0.5);
        } else {
            //mainctx.drawImage(image.front.img, 0, 0);
            mainctx.drawImage(image.front.img, 0, 0, W, H);
        }

        //mainctx.drawImage(canvas.temp, 0, 0);
        mainctx.drawImage(canvas.temp, 0, 0, W, H);
        
    }

    function scratchLine(can, x, y, fresh) {
        if (x >= W) x = W-1;
        if (y >= H) y = H-1;
        if (x < 0)  x = 0;
        if (y < 0)  y = 0;
        // array 처럼 20X5 로 index 를 구함.
        var distance = W / ARRAY_X;
        var xIndex = Math.floor(x / distance);

        distance = H / ARRAY_Y;
        var yIndex = Math.floor(y / distance);
        //console.log(x + " / " + y);

        var ctx = can.getContext('2d');
        ctx.lineWidth = LINE_WIDTH;
        ctx.lineCap = ctx.lineJoin = 'round';
        ctx.strokeStyle = STROKE_STYLE; // can be any opaque color
        if (fresh) {
            ctx.beginPath();
            ctx.moveTo(x+0.01, y);
        }
        
        ctx.lineTo(x, y);
        ctx.stroke();

        if (!isAlert && positions_arr[yIndex][xIndex] == 0) {
            positions_arr[yIndex][xIndex] = 1;
            clearCount++;
            if( clearCount==1 ){
                //console.log("1%");
            }
            else if (clearCount >= COMPLETE_PERCENTAGE) {
                //removeListener();
                //console.log('complete');
                if (!isAlert) {
                    isAlert = true;
                    //warning_popup("");
                }
                
            }
        }
    }

    /**
     * Set up the main canvas and listeners
     */
    function setupCanvases() {
        c.width = W;
        c.height = H;
        //c.width = image.back.img.width;
        //c.height = image.back.img.height;

        // create the temp and draw canvases, and set their dimensions
        // to the same as the main canvas:
        canvas.temp = document.createElement('canvas');
        canvas.draw = document.createElement('canvas');
        canvas.temp.width = canvas.draw.width = c.width;
        canvas.temp.height = canvas.draw.height = c.height;
        recompositeCanvases();
        /**
        * On mouse down, draw a line starting fresh
        */

        c.addEventListener('mousedown', mousedown_handler, false);
        c.addEventListener('touchstart', mousedown_handler, false);

        window.addEventListener('mousemove', mousemove_handler, false);
        window.addEventListener('touchmove', mousemove_handler, false);

        window.addEventListener('mouseup', mouseup_handler, false);
        window.addEventListener('touchend', mouseup_handler, false);
    }

    function removeListener() {
        c.removeEventListener('mousedown', mousedown_handler);
        c.removeEventListener('touchstart', mousedown_handler);

        window.removeEventListener('mousemove', mousemove_handler);
        window.removeEventListener('touchmove', mousemove_handler);

        window.removeEventListener('mouseup', mouseup_handler);
        window.removeEventListener('touchend', mouseup_handler);
    }

    var is_init = false;
    function mousedown_handler(e) {

        if (!is_init) {
            $j.ajax({
                url: "/bbs/bok_text.php",
                dataType: 'json',
                success: function(data) {
                    if(data["coupon_count"]>0){
                        image.back.txt = data["bok_text"];
                    }else{
                        image.back.txt = null;
                    }
                }
            });
            is_init = true;
        }


        var local = getLocalCoords(c, e);
        mouseDown = true;
        scratchLine(canvas.draw, local.x, local.y, true);
        recompositeCanvases();

        if (e.cancelable) { e.preventDefault(); } 
        return false;
    };

    /**
    * On mouse move, if mouse down, draw a line
    *
    * We do this on the window to smoothly handle mousing outside
    * the canvas
    */
    function mousemove_handler(e) {
        if (!mouseDown) { return true; }
        var local = getLocalCoords(c, e);
        scratchLine(canvas.draw, local.x, local.y, false);
        recompositeCanvases();

        if (e.cancelable) { e.preventDefault(); } 
        return false;
    };
    /**
    * On mouseup.  (Listens on window to catch out-of-canvas events.)
    */
    function mouseup_handler(e) {
        if (mouseDown) {
            mouseDown = false;
            if (e.cancelable) { e.preventDefault(); } 
            return false;
        }
        return true;
    };

    function loadingComplete() {
        /*
        var loading = document.getElementById('loading');
        var main = document.getElementById('main');
        loading.className = 'hidden';
        main.className = '';
        */
    }

    /**
     * Handle loading of needed image resources
     */

    function loadImages() {
        var loadCount = 0;
        var loadTotal = 0;
        var loadingIndicator;

        function imageLoaded(e) {
            loadCount++;
            if (loadCount >= loadTotal) {
                setupCanvases();
                loadingComplete();
            }
        }

        for (k in image) if (image.hasOwnProperty(k))
            loadTotal++;

        for (k in image) if (image.hasOwnProperty(k)) {
            image[k].img = document.createElement('img'); // image is global
            image[k].img.addEventListener('load', imageLoaded, false);
            image[k].img.src = image[k].url;
        }
        
    }

    // 캔버스를 최초로 그려준다.
    function init_canvas(){
        c = document.getElementById(CANVAS_ID);
        
        var ww = $j(".lottery_box .event_area .img01 img").parent().outerWidth();
        var hh = $j(".lottery_box .event_area .img01 img").parent().outerHeight();
        c.width = ww-128;
        c.height = hh-120;

        W = c.width;
        H = c.height;

        // position array 를 100개를 만든다.
        for (var i=0; i<ARRAY_Y; i++) {
            positions_arr[i] = [];
            for (var j=0; j<ARRAY_X; j++) {
                positions_arr[i][j] = 0;
            }
        }

        loadImages();
    }



    /**
     * Handle page load
     */
    // 클릭하면 캔버스 노출
    /*
    var is_init = false;
    $j("#bok_click").click( function() {

        if( is_init ) return;

        $j.ajax({
            url: "/bbs/bok_text.php",
            dataType: 'json',
            success: function(data) {
                if(data["coupon_count"]>0){
                is_init = true;
                image.back.txt = data["bok_text"];
                document.getElementById("bokCanvas").style.display = "inline-block";
                // canvas 새로 그려줘야한다.
                init_canvas();
                }else{
                    warning_popup(data["coupon_text"]);
                }
            }
        });
        

    });
    */
    $j(function() {
        document.getElementById("bokCanvas").style.display = "inline-block";
        init_canvas();  
    });
//]]>
</script>