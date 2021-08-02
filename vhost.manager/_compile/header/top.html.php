		<div id="gmenu">
            <ul class="top_m" style="width: 50px">
                <li><img src="/img/topmenu_icon4.gif" alt="알림정보" style="vertical-align:top;"></li>
            </ul>
            <ul class="top_m" style="width: 30%">

                <li id="top_newmember">회원가입[0]</li>
                <li id="top_question">고객센터[0]</li>
                <li id="top_rec_money_out">총판출금[0]</li>
                <li id="top_Withdrawal">출금신청[0]</li>
                <li id="top_richer">입금신청[0]</li>
                <li id="top_contents">게시판[0]</li>
                <li><a href="/gameUpload/gamelist?state=20&parsing_type=ALL"><span id="in_games">등록[0]</span></a></li>
                <li><a href="/gameUpload/gamelist?state=20&parsing_type=ALL"><span id="in_rates">배당[0]</span></a></li>
                <li><a href="/game/gamelist"><span id="in_dates">일시[0]</span></a></li>
                <li><a href="/gameUpload/result_list_resettle"><span id="in_results">결과[0]</span></a></li>
            </ul>
            <ul class="top_m" style="width: 5px">
                <li style="color:#999; font-size:18px; margin:0;">&nbsp;|&nbsp;</li>
                <li style="color:#999; font-size:18px; margin:0;">&nbsp;|&nbsp;</li>
            </ul>
            <ul class="top_m" style="width: 40%">
                <li><a href="/game/betlist?mode=search&last_special_code=0"><span id="bet_sport">스포츠 [0]</span></a></li>
                <li><a href="/game/betlist?mode=search&last_special_code=4"><span id="bet_live">라이브 [0]</span></a></li>
                <!--<li><a href="/game/betlist?mode=search&last_special_code=22"><span id="bet_vfootball">가상축구[0]</span></a></li>
                <li><a href="/game/betlist?mode=search&last_special_code=3"><span id="bet_sadari">사다리[0]</span></a></li>
                <li><a href="/game/betlist?mode=search&last_special_code=6"><span id="bet_dari">다리다리[0]</span></a></li>
                <li><a href="/game/betlist?mode=search&last_special_code=4"><span id="bet_rece">달팽이[0]</span></a></li>
				-->
            <?php 
            if($TPL_VAR["miniSetting"]["power_use"]==1){?>
                <li><a href="/game/betlist?mode=search&last_special_code=7"><span id="bet_power">파워볼[0]</span></a></li>
            <?php } 
            if($TPL_VAR["miniSetting"]["kenosadari_use"]==1){?>
                <li><a href="/game/betlist?mode=search&last_special_code=24"><span id="bet_kenosadari">키노사다리[0]</span></a></li>
            <?php } 
            if($TPL_VAR["miniSetting"]["powersadari_use"]==1){?>
                <li><a href="/game/betlist?mode=search&last_special_code=25"><span id="bet_powersadari">파워사다리[0]</span></a></li>
            <?php } 
            if($TPL_VAR["miniSetting"]["dari2_use"]==1){?> 
                <li><a href="/game/betlist?mode=search&last_special_code=30"><span id="bet_2dari">이다리[0]</span></a></li>
            <?php } 
            if($TPL_VAR["miniSetting"]["dari3_use"]==1){?>  
                <li><a href="/game/betlist?mode=search&last_special_code=31"><span id="bet_3dari">삼다리[0]</span></a></li>
            <?php } 
            if($TPL_VAR["miniSetting"]["choice_use"]==1){?>  
                <li><a href="/game/betlist?mode=search&last_special_code=32"><span id="bet_choice">초이스[0]</span></a></li>
            <?php } 
            if($TPL_VAR["miniSetting"]["roulette_use"]==1){?> 
                <li><a href="/game/betlist?mode=search&last_special_code=33"><span id="bet_roulette">룰렛[0]</span></a></li>
            <?php } 
            if($TPL_VAR["miniSetting"]["pharah_use"]==1){?>  
                <li><a href="/game/betlist?mode=search&last_special_code=34"><span id="bet_pharaoh">파라오[0]</span></a></li>
            <?php } 
            if($TPL_VAR["miniSetting"]["fx_use"]==1){?>
                <li><a href="/game/betlist?mode=search&last_special_code=fx"><span id="bet_fx">FX게임[0]</span></a></li>
            <?php } ?>
            </ul>
			<ul class="top_m_r" style="width: 320px">
				<li class="user"><b><?php echo $TPL_VAR["sess_member_id"]?></b> 님</li>
				<li><a href="/logout">로그아웃</a></li>
				<li><a href="javascript:void(0)" onclick="javascript:open_window('/etc/killiplist?act=list',604,400);"><span style="letter-spacing:1px;">ip</span>차단관리</a></li>
				<li><a href="javascript:void(0)" onclick="javascript:open_window('/etc/changepasswd',410, 210);">비밀번호관리</a></li>
			</ul>
		</div>

		<div id="topmenu" style="font-size:13px;">
			<ul>
				<li class="icon" style="background:none;"><img src="/img/topmenu_icon.gif" alt="현황정보"></li>
				<li><a href="javascript:;" onClick="open_window('/stat/new_popup_moneyloglist?date=<?php echo date("Y-m-d",time());?>&filter_state=1&flag=0',1200,600);">금일총입금 : <?php echo number_format($TPL_VAR["today_charge"],0)?></a></li>
				<li><a href="javascript:;" onClick="open_window('/stat/new_popup_moneyloglist?date=<?php echo date("Y-m-d",time());?>&filter_state=2&flag=1',1200,600);">금일총출금 : <?php echo number_format($TPL_VAR["today_exchange"],0)?></a></li>
				<li>총보유머니 : <?php echo number_format($TPL_VAR["totalmemberMoney"],0)?>원</li>
				<li>총보유포인트 : <?php echo number_format($TPL_VAR["totalmemberMileage"],0)?>원</li>
				<li>배팅대기 : <?php echo number_format($TPL_VAR["currentBetting"],0)?>원</li>
				<li>예상당첨액 : <?php echo number_format($TPL_VAR["expected_prize"],0)?>원</li>
                <li><a href="javascript:;" onClick="open_window('/member/popup_simul_list',1200,600);"><font style="font-size:15px;">현재접속자수[<span id="connect_cnt">0</span>]</font></a></li>
                <li><a href="/member/loginlist?isLogin_fail=on"><font style="font-size:15px;">접속실패[<span id="login_fail">0</span>]</font></a></li>
				<li id="top_va">
				</li>
				<li id="top_vb">
				</li>
				<li id="top_vc">
				</li>
				<li id="top_vd">
				</li>
				<li id="top_ve">
				</li>
				<li id="top_vf">
				</li>
				<li id="top_vg">
				</li>		
				<li id="top_vh">
				</li>
			</ul>
		</div>