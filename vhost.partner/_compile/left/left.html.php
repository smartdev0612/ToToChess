<?php /* Template_ 2.2.3 2012/10/20 20:19:12 C:\APM_Setup\htdocs\www\vhost.partner\_template\left\left.html */?>
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
			<p class="m_menu" onclick="mainchgna('1')"><a href="#">입금/출금 관리</a></p>
			<div id="left_menu01">
				<ul>
					<li><a href='/charge/list'>입금신청</a></li>
					<li><a href='/exchange/list'>출금신청</a></li>
					<li><a href='/charge/finlist'>입금완료</a></li>
					<li><a href='/exchange/readylist'>출금대기</a></li>
					<li><a href='/exchange/finlist'>출금완료</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('2')"><a href="#">회원 관리</a></p>
			<div id="left_menu02">
				<ul>
					<li><a href='/member/list'>회원목록</a></li>
					<li><a href='/member/badlist'>불량회원</a></li>
					<li><a href='/member/loginlist'>접속기록</a></li>
					<li><a href='/member/levelconfig'>등급설정</a></li>
					<li><a href='/member/add'>회원등록</a></li>
					<li><a href='/member/del'>탈퇴신청</a></li>
					<li><a href='/memo/list'>쪽지관리</a></li>
					<li><a href="javascript:void(0)" onclick="javascript:window.open('/memo/popup_adminwrite','memo','width=650,height=350')">쪽지쓰기</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('3')"><a href="#">게시판 관리</a></p>
			<div id="left_menu03">
				<ul>
					<li><a href='/board/list'>게시물관리</a></li>
					<li><a href='/board/config'>게시판설정</a></li>
					<li><a href='/board/write'>게시물쓰기</a></li>
					<li><a href='/board/questionlist'>고객센터</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('4')"><a href="#">게임 관리</a></p>
			<div id="left_menu04">
				<ul>
					<li><a href='/game/config'>게임설정</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('5')"><a href="#">파트너 관리</a></p>
			<div id="left_menu05">
				<ul>
					<li><a href='/partner/list'>파트너목록</a></li>
					<li><a href='/partner/join'>파트너신청</a></li>
					<li><a href='/partner/noticelist'>파트너공지</a></li>
					<li><a href='/partner/noticeadd'>공지쓰기</a></li>
					<li><a href='/partner/memolist'>파트너쪽지</a></li>
					<li><a href='/partner/memoadd'>쪽지쓰기</a></li>
					<li><a href='/partner/accounting'>정산신청</a></li>
					<li><a href='/partner/accounting_fin'>정산완료</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('6')"><a href="#">통계</a></p>
			<div id="left_menu06">
				<ul>
					<li><a href='/stat/site'>사이트현황</a></li>
					<li><a href='/stat/money'>입/출금통계</a></li>
					<li><a href='/stat/bet'>배팅 통계</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('7')"><a href="#">시스템 관리</a></p>
			<div id="left_menu07">
				<ul>
					<li><a href='/config/globalconfig' >기본 설정</a></li>
					<li><a href='/config/point'>포인트설정</a></li>
					<li><a href='/config/level'>레벨 설정</a></li>
					<li><a href='/config/popuplist'>팝업 설정</a></li>
					<li><a href='/config/dataexcel'>DB추출</a></li>
				</ul>
			</div>
			<p class="m_menu" onclick="mainchgna('8')"><a href="#">관리자</a></p>
			<div id="left_menu08">
				<ul>
					<li><a href='/stat/adminlog'>로그인 내역</a></li>
					<li><a href='/stat/siteaccount'>사이트 정산</a></li>
				</ul>
			</div>