<?php
	$TPL_list_1 = empty($TPL_VAR["list"]) || !is_array($TPL_VAR["list"]) ? 0 : count($TPL_VAR["list"]);
?>
    <div class="mask"></div>
	<div id="container">
	
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
        console.log($index);
        console.log($idx);
		if(document.getElementById($index+"_content").style.display=="none")
		{
			jq$("tr[id^="+$index+"_content]").css("display", "none");
			jq$("tr[id="+$index+"_content]").css("display", "");
			
			jq$.ajaxSetup({async:false});
			var param={idx:$idx};
            jq$.post("/member/readMemoCheck", param, testt($index));
		}
		else
		{
			jq$("tr[id="+$index+"_content]").css("display", "none");
		}
    }
    
    function memo_toggle(me_id, $idx){
        $j('#TD_'+me_id).toggle();
        var readStatus = parseInt($j('#readStatus_' + me_id).val());
        if(readStatus == 0) {
            var memoCnt = parseInt($j(".memoCnt").text());
            $j(".memoCnt").text(memoCnt - 1);
            $j('#span_status_' + me_id).text("읽음");
            $j('#readStatus_' + me_id).val(1);
            var param={idx : $idx};
            $j.ajax({
                url: "/member/readMemoCheck",
                type: "POST",
                data: param,
                success: function(res) {
                }
            });
        }
        
    }
	
	function testt($index)
	{
		//alert($index);
		jq$("#"+$index+"_img").attr('src', '/img/member/icon_memo2.gif');
	}
</script>

<style>
    .member {
        color: CC6699;
    }
    input, textarea {
        background: #000;
    }
    /*a:link, a:visited, a:active { text-decoration:none;color:#000; }
    a:hover { text-decoration:none;color:red; }
    */
    .memo_table { background-color:rgba(32,32,32,0.8); border-radius:5px; border:1px solid #000; margin-top:10px; table-layout:fixed; text-align:left;}
    .th_line {
        text-align: center;
        font-weight: bold;
        background-color: #555;
        height: 32px;
    }
    .attention0 td {
        background-color: #111;
        color: #666452;
        border-top: 1px solid #2a2a2a;
        border-right: 1px solid #111111;
        border-bottom: 1px solid #111111;
        border-left: 1px solid #2a2a2a
    }
    .attention1 td {
        background-color: #222;
        color: #585b66;
        border-top: 1px solid #2a2a2a;
        border-right: 1px solid #111111;
        border-bottom: 1px solid #111111;
        border-left: 1px solid #2a2a2a
    }
    .list-table {
        
    }
    .list-table table {
        border-collapse: separate!important;
        border: 0;
        width: 100%;
        margin-top:20px;
        
    }
    .list-table th {
        color: #fff;
        padding: 8px 0;
        border-right: 1px solid #2C2D31;
        border-bottom: 1px solid #2C2D31;
        background-color: #212226;
        color: #fff;
        height:45px;
    }
    .list-table td {
        color: #333;
        height:40px;
        background-color: #fff;
    }
    .list-table tr.even td {
        background-color: #292929;
        border-top: 1px solid #3b3b3b;
        border-right: 1px solid #1c1c1c;
        border-bottom: 1px solid #101010;
        border-left: 1px solid #363636
    }
    .list-table tr.odd td {
        background-color: #333;
        border-top: 1px solid #454545;
        border-right: 1px solid #262626;
        border-bottom: 1px solid #1a1a1a;
        border-left: 1px solid #404040
    }
    #forum-list th {
        text-align: center;
    }
    #forum-list td {
        line-height: 26px
    }
    #forum-list td.no {
        font-size: 11px;
        font-family: verdana;
        text-align: center;
        font-weight: normal;
    }
    #forum-list td.title {
        text-align: left;
        white-space: normal;
        
        font-size:15px;
        height:50px;
    }
    #forum-list td.title a {color:#1efc43;}
    #forum-list td.nickname {
        text-align: center
    }
    #forum-list td.nickname .rank-icon {
        float: left
    }
    #forum-list td.created_at {
        font-family: notosans;
        color:#2afd56 !important;
        text-align: center
    }
    #forum-list td.view_count {
        text-align: center
    }
    #forum-list td.betslip {
        text-align: center
    }
    #forum-list .n_comments {
        color: #ff7100;
        margin-left: 5px
    }
    #forum-list tr.notice { height:50px;}
    #forum-list tr.notice td {
        border-bottom: 1px solid #000;
        color:#fff;
        
    }
    #forum-list tr.notice td.title a {
        color: #fff;
        font-weight: bold
    }
    #forum-list tr.notice td.nickname {
        text-align: center;
        color: #ffc300
    }
    #forum-list tr.notice.new td {
        background: #513823;
    }
    #forum-list tr.document.written_by_manager td.title a {
        color: #ffc300;
        font-weight: bold
    }
    #forum-list tr.document.written_by_manager td.nickname {
        color: #ffc300
    }
    #forum-list .button {
        display: block;
        padding: 5px 7px 4px;
        margin: 0;
        cursor: pointer;
        border-top: 1px solid #ffd54d;
        border-right: 1px solid #ffc300;
        border-bottom: 1px solid #b38800;
        border-left: 1px solid #ffc300;
        background-color: #e6b000;
        background: -o-linear-gradient(#ffd54d, #e6b000);
        background: -moz-linear-gradient(top, #ffd54d, #e6b000);
        background: -webkit-gradient(linear, left top, left bottom, from(#ffd54d), to(#e6b000));
        outline: 0;
        text-decoration: none;
        color: #000;
        font: normal 9pt/1.2 Sans-serif;
        text-shadow: 0!important;
        text-align: center;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px
    }
    #forum-list .button:hover {
        text-decoration: none;
        background-color: #ffc91a;
        background: -o-linear-gradient(#ffe180, #ffc91a);
        background: -moz-linear-gradient(top, #ffe180, #ffc91a);
        background: -webkit-gradient(linear, left top, left bottom, from(#ffe180), to(#ffc91a))
    }
    #forum-list .button:active, #forum-list .button:focus {
        background-color: #ffc91a;
        background: -o-linear-gradient(#ffe180, #ffc91a);
        background: -moz-linear-gradient(top, #ffe180, #ffc91a);
        background: -webkit-gradient(linear, left top, left bottom, from(#ffe180), to(#ffc91a))
    }
    #forum-list .space {
        margin: 0 0 0 1em
    }
    #forum-list .space {
        float: left
    }
</style>
<!--좌측메뉴 -->
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
<script type="text/javascript" src="/10bet/js/left.js?1610683365"></script>

    <div id="contents">
        <div class="board_box">
            <h2>쪽지</h2>
            <div class="message_count">쪽지 <span>총 <?php echo $TPL_list_1?> 개</span> 입니다.</div>
            <div class="board_list">
                <table cellpadding="0" cellspacing="0" border="0">
                    <colgroup><col width="50" /><col width="*" /><col width="120" /><col width="100" /><col width="100" /></colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>내용</th>
                            <th>받은 시간</th>
                            <th>상태</th>
                            <th>삭제하기</th>
                        </tr>
                    <thead>
                    <tbody>
                        <?php
                        if ( $TPL_list_1 ) {
                            $TPL_I1 = -1;
                            foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
                                $TPL_I1++;
                        ?>
                        <tr onclick="memo_toggle('<?php echo $TPL_I1+1?>', '<?php echo $TPL_V1["mem_idx"]?>');" style="cursor:pointer;">
                            <td><?php echo ($TPL_I1 + 1)?></td>
                            <td class="ta_left"><?php echo $TPL_V1["title"]?></td>
                            <td><?php echo substr($TPL_V1["writeday"],5,19)?></td>
                            <td>
                                <input type="hidden" id="readStatus_<?=$TPL_I1 + 1?>" value="<?=$TPL_V1["newreadnum"]?>">
                                <span id="span_status_<?=$TPL_I1 + 1?>"><?=($TPL_V1["newreadnum"] == 1) ? "읽음" : "읽지 않음"?></span>
                            </td>
                            <td  class='state'><a href="javascript:void(0)" onclick="dodel('?mode=del&id=<?php echo $TPL_V1["mem_idx"]?>')" class="btn btn-danger" style="color: #ffa604;">삭제</a></td>
                        </tr>
                        <tr id="TD_<?php echo $TPL_I1+1?>" style="display:none; text-align:center;">
                            <td></td>
                            <td width="100%">
                                <p style="text-align: center; width: 100%;">
                                    <?php echo nl2br($TPL_V1["content"])?>                        			
                                </p>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
					
                <div class="btn_right">
                    <button type="button" class="button_type01" onclick="dodel('?mode=delete_all')">전부삭제</button>
                </div>
                
                <!-- page skip -->
                <div class="page_skip">
                    <!-- &nbsp;<a href='' class='on'>1</a>&nbsp;
                    <a href='?page=2'>2</a>&nbsp;
                    <a href='?page=3'>3</a>&nbsp;<a href='?page=4'>4</a>&nbsp;
                    <a href='?page=4' class="">맨끝</a>					 -->
                </div>
            </div>
        </div>
    </div>

<!--우측메뉴 -->
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
<script language='javascript' src='/10bet/js/filter.js'></script>
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