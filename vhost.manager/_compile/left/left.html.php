<script>
function mainchgna(vii)     
    {      
        if(document.getElementById("left_menu0"+vii).style.display=="") 
        {     
           document.getElementById("left_menu0"+vii).style.display="none";     
        }     
        else
        {
           document.getElementById("left_menu0"+vii).style.display="";     
        }
    }	
</script>
			<h2><span class="blind">메인메뉴</span></h2>
            <p class="m_menu" onclick="mainchgna('0')"><a href="javascript:void();">메인</a></p>
            <div id="left_menu00">
                <ul>
					<li><a href='/'>메인페이지</a></li>
					<li></li>
                    <li><a href='/partner/partner_struct'>파트너구조</a></li>
                    <li><a href='/stat/dashboard'>실시간 상황판</a></li>
                    <li><a href='/member/recommender_struct'>추천인구조</a></li>
					<li><a href='#' onclick="window.open('/gameUpload/popup_gameupload?state=0','','resizable=yes scrollbars=yes top=5 left=5 width=1600 height=650')";>경기등록</a></li>
                </ul>
            </div>
			<p class="m_menu" onclick="mainchgna('1')"><a href="javascript:void();">입금/출금 관리</a></p>
			<div id="left_menu01">
				<ul>
					<li><a href='/charge/finlist_edit'>회원입금</a></li>
					<li><a href='/exchange/finlist_edit'>회원출금</a></li>
					<li></li>
					<li><a href='/partner/exchange_list'>총판출금</a></li>
					<li><a href='/log/moneyloglist'>머니내역</a></li>
					<li><a href='/log/mileageloglist'>마일리지내역</a></li>					
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('2')"><a href="javascript:void();">회원 관리</a></p>
			<div id="left_menu02">
				<ul>
					<li><a href='/member/list?perpage=30&sort_type=desc&field=mem_id&filter_state=01000&filter_member_state=N'>회원목록</a></li>
					<li><a href='/member/loginlist'>접속기록</a></li>
					<li><a href='/memo/sendlist'>쪽지관리</a></li>
					<li><a href="javascript:void(0)" onclick="javascript:window.open('/memo/popup_adminwrite','memo','width=650,height=350')">쪽지쓰기</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('3')"><a href="javascript:void();">게시판 관리</a></p>
			<div id="left_menu03">
				<ul>
					<li><a href='/board/list?province=5'>자유게시판</a></li>
					<li><a href='/board/list?province=2'>공지사항</a></li>
					<!--<li><a href='/config/eventlist'>이벤트</a></li>-->
                    <li><a href='/board/list?province=7'>이벤트</a></li>
					<li><a href='/board/questionlist'>고객센터</a></li>
					<li><a href='/board/write'>게시물쓰기</a></li>
					<li><a href='/board/site_rule_edit?type=1'>회원약관 수정</a></li>
					<li><a href='/board/site_rule_edit?type=2'>배팅규정 수정</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('4')"><a href="javascript:void();" class="accent">게임 등록</a></p>
			<div id="left_menu04">
				<ul>
					<li><a href='/gameUpload/gamelist?state=20&parsing_type=ALL'>게임등록</a></li>
					<li><a href='/league/list'>리그관리</a></li>
                    <li><a href='/gameUpload/result_list'>게임마감</a></li>
					<li><a href='/league/category_list'>종목관리</a></li>

					<li><a href='/gameUpload/modify_rate'>배당수정</a></li>
					<!-- <li><a href='/gameBlock/list'>경기차단</a></li> -->
					<li><a href='/gameBlock/gamelist'>경기차단</a></li>
					<li><a href='/config/sportlimit'>스포츠배팅제한</a></li>
					<li><a href='/gameUpload/liveList?state=40&parsing_type=ALL'>라이브구독</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('5')"><a href="javascript:void();"><font color='orange'>게임 관리</font></a></p>
			<div id="left_menu05">
				<ul>
					<li><a href='/game/gamelist?state=20'>게임관리</a></li>
					<li><a href='/game/betlist'>배팅현황</a></li>
                    <li><a href='/gameUpload/result_list_resettle'>게임재정산</a></li>
					<li><a href='/game/betcancellist'>배팅취소현황</a></li>
                    <li><a href='/game/marketList'>마켓관리</a></li>
					<li><a href="/game/gamelist_sadari?state=20">사다리배팅현황</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('6')"><a href="javascript:void();"><font color='orange'>미니게임 관리</font></a></p>
			<div id="left_menu06">
				<ul>
					<li><a href='/config/miniconfig'>게임설정</a></li>
					<li><a href='/config/miniodds?lev=1'>배당설정</a></li>
				</ul>
			</div>
			<!--<p class="m_menu" onclick="mainchgna('6')"><a href="javascript:void();" class="accent"><font color='orange'>라이브 게임관리</font></a></p>
			<div id="left_menu06">
				<ul>
					<li><a href='/LiveGame/reload_today_game'>게임 리로드</a></li>
					<li><a href='#' onclick="window.open('/LiveGame/collect','','resizable=yes scrollbars=yes top=5 left=5 width=1100 height=650')">게임등록</a></li>
					<li><a href='/LiveGame/game_list'>게임관리</a></li>
					<li><a href='/LiveGame/betting_list'>배팅현황</a></li>
				</ul>
			</div>-->
			<!--
			<p class="m_menu" onclick="mainchgna('7')"><a href="javascript:void();"><font color='orange'>사다리 밸런스</font></a></p>
			<div id="left_menu07">
				<ul>
					<li><a href='/api/bal_config'>밸런스옵션</a></li>
					<li><a href='/api/bal_realtime'>실시간상황판</a></li>
				</ul>
			</div>

            <p class="m_menu" onclick="mainchgna('8')"><a href="javascript:void();"><font color='orange'>다리다리 밸런스</font></a></p>
            <div id="left_menu08">
                <ul>
                    <li><a href='/api/bal_config_dari'>밸런스옵션</a></li>
                    <li><a href='/api/bal_realtime_dari'>실시간상황판</a></li>
                </ul>
            </div>
			-->
            <p class="m_menu" onclick="mainchgna('9')"><a href="javascript:void();"><font color='orange'>파워볼 밸런스</font></a></p>
            <div id="left_menu09">
                <ul>
                    <li><a href='/api/bal_config_pb'>밸런스옵션</a></li>
                    <li><a href='/api/bal_realtime_pb'>실시간상황판</a></li>
                </ul>
            </div>

			<p class="m_menu" onclick="mainchgna('10')"><a href="javascript:void();">부본사 관리</a></p>
			<div id="left_menu010">
				<ul>
					<li><a href='/partner/list_top'>부본사목록</a></li>
					<li><a href='/partner/list_tex_top'>부본사정산</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('11')"><a href="javascript:void();">총판 관리</a></p>
			<div id="left_menu011">
				<ul>
					<li><a href='/partner/list'>총판목록</a></li>
                    <li><a href='/partner/list_tex'>총판정산</a></li>
                    <li><a href='/partner/memolist'>총판쪽지</a></li>
                    <li><a href='/partner/memoadd'>쪽지쓰기</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('12')"><a href="javascript:void();">통계</a></p>
			<div id="left_menu012">
				<ul>
					<li><a href='/stat/site'>사이트현황</a></li>
					<li><a href='/stat/money'>입/출금통계</a></li>
					<li><a href='/stat/bet'>배팅 통계</a></li>
                    <li><a href='/stat/check'>출석 통계</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('13')"><a href="javascript:void();">시스템 관리</a></p>
			<div id="left_menu013">
				<ul>
					<li><a href='/config/globalconfig' >기본 설정(A)</a></li>
					
					<li><a href='/config/point'>포인트설정</a></li>
					<li><a href='/config/level'>등급 설정</a></li>
					
					<li><a href='/config/popuplist'>팝업 설정</a></li>
					<!--<li><a href='/config/dataexcel'>DB추출</a></li>-->
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('14')"><a href="javascript:void();">관리자</a></p>
			<div id="left_menu014">
				<ul>
					<li><a href='/member/telegram'>텔레그람설정</a></li>
					<li><a href='/stat/adminlog'>로그인 내역</a></li>
					<li><a href='/member/kakao'>카카오톡설정</a></li>
				</ul>
			</div>