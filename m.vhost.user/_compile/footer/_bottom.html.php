<?php /* Template_ 2.2.3 2014/11/05 01:32:40 D:\www_one-23.com\m.vhost.user\_template\footer\bottom.html */?>
        <div class="scroll-to-top">
        </div>
        <div class="foot" style="margin-top:20px;">
            <p class="copy">ⓒ2016 MU-BAY Corp.</p>
            <a href="javascript:pcs();" class="bt_pc">PC 버전</a>
        </div>
    </div>
    <div class="sidebar-left" style="left: -250px;">
        <div class="sidebar-scroll-left">
            <div class="sidebar-header-left">
                <ul>
                    <li class="sidebar-member-info">
                        <p class="icon_level">Lv.<?php echo $TPL_VAR["level"]?></p> <span class="head_2_t_1"> <?php echo $TPL_VAR["nick"]?></span> 님 </li>
                    <li>
                        <a href="#" class="close-sidebar-left"></a>
                    </li>
                </ul>
            </div>
			<!--
            <div class="sidebar-header-left_1">
                <ul>
                    <li class="sidebar-member-info_1">보유금:<span class="head_2_t_3"><?php echo number_format($TPL_VAR["cash"],0)?></span>원</li>
                    <li class="sidebar-member-info_2">포인트:<span class="head_2_t_4"><?php echo number_format($TPL_VAR["mileage"],0)?></span>P</li>
                </ul>
            </div>
            <div class="sidebar-header-left_1">
                <ul>
                    <li class="sidebar-member-info_3">쪽지:<span class="head_2_t_2"><?php echo $TPL_VAR["new_memo_count"]?></span>통</li>
                    <li class="sidebar-member-info_4">
                        <a href="javascript:logout();">
                            <p>로그아웃</p>
                        </a>
                    </li>
                </ul>
            </div>
			-->
            <p class="sidebar-divider-text"><?php echo date("Y:m:d A h:i:s");?></p>
			<a href="#" id="submenu-two" class="nav-item info-nav">스포츠<em class="icon-drop"></em></a>
            <div class="submenu submenu-two" style="overflow: hidden; display: none;">
				<a href="/game_list?game=multi"><em></em>조합</a>
                <a href="/game_list?game=special"><em></em>스페셜</a>
                <a href="/game_list?game=real"><em></em>실시간</a>
			</div>
            <a href="/game_list?game=live" class="nav-item coach-nav">라이브<em class="icon-page"></em></a>
			<a href="#" id="submenu-five" class="nav-item info-nav">네임드<em class="icon-drop"></em></a>
            <div class="submenu submenu-five" style="overflow: hidden; display: none;">
				<a href="/game_list?game=sadari"><em></em>사다리</a>
                <a href="/game_list?game=dari"><em></em>다리다리</a>
                <a href="/game_list?game=race"><em></em>달팽이</a>
			</div>
			<a href="#" id="submenu-six" class="nav-item info-nav">미니게임<em class="icon-drop"></em></a>
            <div class="submenu submenu-six" style="overflow: hidden; display: none;">
				<a href="/game_list?game=power"><em></em>파워볼</a>
                <a href="/game_list?game=kenosadari"><em></em>키노사다리</a>
				<a href="/game_list?game=psadari"><em></em>파워사다리</a>
                <a href="/game_list?game=fx&min=1"><em></em>FX게임</a>
                <a href="/game_list?game=2dari"><em></em>2다리</a>
                <a href="/game_list?game=3dari"><em></em>3다리</a>
                <a href="/game_list?game=choice"><em></em>초이스</a>
                <a href="/game_list?game=roulette"><em></em>룰렛</a>
                <a href="/game_list?game=pharaoh"><em></em>파라오</a>
            </div>

			<!--<a href="#" id="submenu-seven" class="nav-item info-nav">MGM<em class="icon-drop"></em></a>
            <div class="submenu submenu-seven" style="overflow: hidden; display: none;">
				<a href="/game_list?game=mgmoddeven"><em></em>MGM홀짝</a>
				<a href="/game_list?game=mgmbacara"><em></em>MGM바카라</a>
			</div>-->
			<a href="#" id="submenu-eight" class="nav-item info-nav">BET365<em class="icon-drop"></em></a>
            <div class="submenu submenu-eight" style="overflow: hidden; display: none;">
				<a href="/game_list?game=vfootball"><em></em>가상축구</a>
			</div>
            <a href="#" id="submenu-one" class="nav-item info-nav">경기결과<em class="icon-drop"></em></a>
            <div class="submenu submenu-one" style="overflow: hidden; display: none;">
                <a href="/race/game_result?view_type=winlose"><em></em>조합</a>
                <a href="/race/game_result?view_type=special"><em></em>스페셜</a>
                <a href="/race/game_result?view_type=real"><em></em>실시간</a>
                <a href="/race/game_result?view_type=live"><em></em>라이브</a>
                <a href="/race/game_result?view_type=sadari"><em></em>사다리</a>
                <a href="/race/game_result?view_type=dari"><em></em>다리다리</a>
                <a href="/race/game_result?view_type=race"><em></em>달팽이</a>
                <a href="/race/game_result?view_type=power"><em></em>파워볼</a>
                <a href="/race/game_result?view_type=kenosadari"><em></em>키노사다리</a>
                <a href="/race/game_result?view_type=psadari"><em></em>파워사다리</a>
                <a href="/race/game_result?view_type=fx"><em></em>FX게임</a>
                <a href="/race/game_result?view_type=2dari"><em></em>2다리</a>
                <a href="/race/game_result?view_type=3dari"><em></em>3다리</a>
                <a href="/race/game_result?view_type=choice"><em></em>초이스</a>
                <a href="/race/game_result?view_type=roulette"><em></em>룰렛</a>
                <a href="/race/game_result?view_type=pharaoh"><em></em>파라오</a>
            </div>
            <a href="#" id="submenu-three" class="nav-item folio-nav">충전신청<em class="icon-drop"></em></a>
            <div class="submenu submenu-three">
                <a href="javascript:menu0211();"><em></em>충전신청</a>
                <a href="javascript:menu0212();"><em></em>충전신청내역</a>
            </div>
            <a href="#" id="submenu-four" class="nav-item folio-nav">환전신청<em class="icon-drop"></em></a>
            <div class="submenu submenu-four">
                <a href="javascript:menu0221();"><em></em>환전신청</a>
                <a href="javascript:menu0222();"><em></em>환전신청내역</a>
			</div>
			<a href="javascript:menu0240();" class="nav-item coach-nav">공지게시판<em class="icon-page"></em></a>
            <a href="javascript:menu0250();" class="nav-item coach-nav">고객센터<em class="icon-page"></em></a>
            <a href="javascript:menu0270();" class="nav-item coach-nav">추천인<em class="icon-page"></em></a>
            <a href="javascript:menu0230();" class="nav-item coach-nav">이벤트<em class="icon-page"></em></a>
            <a href="javascript:menu0280();" class="nav-item coach-nav">마이페이지<em class="icon-page"></em></a>
            <a href="javascript:menu0260();" class="nav-item coach-nav">쪽지<em class="icon-page"></em></a>
			<a href="javascript:menu0191();" class="nav-item coach-nav">배팅내역<em class="icon-page"></em></a>
            <a href="javascript:menu0281();" class="nav-item coach-nav">출석부<em class="icon-page"></em></a>
            <div class="sidebar-decoration">
            </div>
            <a href="javascript:pcs();"><p class="copyright-sidebar">PC 버전 보기 </p></a>
            <div class="sidebar-decoration">
            </div>
            <p class="copyright-sidebar">ⓒ2016 MU-BAY Corp.</p>
        </div>
    </div>

<script>
	var betting_slip_state = 1; /*0=off, 1=on*/
</script>
<form name="betForm" action="/race/bettingProcess" method="post" onsubmit="return false">
	<input type="hidden" value="betting" name="mode"> 
	<input type="hidden" name=strgametype> 
	<input type="hidden" name="gametype" value=<?=$bettype?>>
	<input type="hidden" name="game_type" value="<?php echo $TPL_VAR["game_type"]?>">
	<input type="hidden" name="special_type" value="<?php echo $TPL_VAR["special_type"]?>">
	<input type="hidden" name="result_rate"> 
	<textarea style="display:none" name=betcontent></textarea>

    <div class="sidebar-right" style="right: -230px;">
        <div class="sidebar-scroll-right">
            <div class="sidebar-header-right">
                <a href="#" class="close-sidebar-right"></a>
                <img src="/images/logo.png" class="sidebar-right-logo" height=30px; style="margin-top:5px;" alt="img">
            </div>
            <div class="sidebar-divider-text_box">
                <p class="sidebar-divider-text_1">배팅카드</p>
                <a href="javascript:bet_clear();" class="sidebar-divider-text_2">전체삭제</a>
            </div>
            <div class="sidebar-center-right">
                <ul>
                    <li class="sidebar-center-right_l">보유금액 :</li>
					<li class="sidebar-center-right_r"><span class="sidebar-center-right_text"><?php echo number_format($TPL_VAR["cash"],0)?></span> 원</li>
                    <li class="sidebar-center-right_l">배당률 :</li>
					<li class="sidebar-center-right_r"><span class="sidebar-center-right_text" id="sp_bet">0.00</span> 배</li>
                    <li class="sidebar-center-right_l">베팅최소 :</li>
					<li class="sidebar-center-right_r"><span class="sidebar-center-right_text"><?php echo number_format($TPL_VAR["betMinMoney"])?></span> 원</li>
                    <li class="sidebar-center-right_l">베팅최대 :</li>
					<li class="sidebar-center-right_r"><span class="sidebar-center-right_text"><?php echo number_format($TPL_VAR["betMaxMoney"])?></span> 원</li>
                    <li class="sidebar-center-right_l">적중최대 :</li>
					<li class="sidebar-center-right_r"><span class="sidebar-center-right_text"><?php echo number_format($TPL_VAR["maxBonus"])?></span> 원</li>
                    <li class="sidebar-center-right_l">베팅금액 :</li>
                    <li class="sidebar-center-right_r">
						<input type="text" name="betMoney" id="betMoney" class="text-input" value="5,000" onkeyUp="javascript:this.value=onMoneyChange(this.value);" onmouseover="this.focus()"> 원
					</li>
                </ul>
            </div>
            <div class="sidebar-money">
                <ul>
                    <li class="sidebar-money_1"><a href="javascript:bettingMoneyPlus('5000');" class="bt_sidebar_money">5000</a>
                    </li>
                    <li class="sidebar-money_1"><a href="javascript:bettingMoneyPlus('10000');" class="bt_sidebar_money">10,000</a>
                    </li>
                    <li class="sidebar-money_1"><a href="javascript:bettingMoneyPlus('30000');" class="bt_sidebar_money">30,000</a>
                    </li>
                    <li class="sidebar-money_2"><a href="javascript:bettingMoneyPlus('50000');" class="bt_sidebar_money">50,000</a>
                    </li>
                    <li class="sidebar-money_2"><a href="javascript:bettingMoneyPlus('100000');" class="bt_sidebar_money">100,000</a>
                    </li>
                    <li class="sidebar-money_2"><a href="javascript:onAllinClicked();" class="bt_sidebar_money">MAX</a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-bet">
                <ul>
                    <li class="sidebar-center-right_l">예상당첨금</li>
                    <li class="sidebar-center-right_r"><span class="sidebar-center-right_text" id="sp_total">0</span> 원</li>
                </ul>
            </div>
            <div class="sidebar-bet_bt_box">
                <a href="javascript:betting('betting');" class="bt_sidebar_bt">배팅하기</a>
            </div>
            <div class="sidebar-bet_list">
							<table id="tb_list" cellspacing="0" summary="배팅슬립 배팅목록" style="display:visible">
								<tbody></tbody>
							</table>
            </div>
            <div class="sidebar-bet_foot">
                <a href="#">↑맨위로</a>
            </div>
        </div>
    </div>
</form>
</body>

</html>
