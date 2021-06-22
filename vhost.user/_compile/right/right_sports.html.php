<div id="right_section">
    <div class="right_box">
        <?php
        if(count((array)$_SESSION['member']) > 0) { ?>
            <!-- 유저 정보 -->
            <div class="user_box box_type01">
                <div class="point">
                    <img src='/images/level_icon_<?php echo $TPL_VAR["level"]?>.png'>&nbsp; <?=$TPL_VAR["nick"]?>
                    <span class="change" onClick="location.href='/member/member'">나의 정보</span>
                </div>
                <div class="money">
                    <span class="head"><img src="/10bet/images/10bet/ico_01.png" alt="" /> 보유머니</span> 
                    <span class="member_inmoney"><?php echo number_format($TPL_VAR["cash"],0)?></span>				
                </div>
                <div class="point"><span class="head"><img src="/10bet/images/10bet/ico_01.png" alt="" /> 포인트</span> 
                <span id="member_mileage"><?php echo number_format($TPL_VAR["mileage"],0)?></span>&nbsp;P
                <!-- <span class="change" onClick="mileage2Cash();">포인트전환</span> -->
                <span class="change" onClick="location.href='/member/mileage?type=6'">포인트전환</span>
                </div>
                <div class="btn_list">
                    <button type="button" onClick="location.href='/member/memolist'">쪽지 <span class="memoCnt"><?php echo $TPL_VAR["new_memo_count"]?></span></button>
                    <!-- <button type="button" onClick="location.href='/bok'">복권 <span>0</span></button>
                    <button type="button" onClick="location.href='/coupon'">쿠폰 <span>0</span></button> -->
                    <button type="button" onClick="location.href='/calendar'">출석부</button>
                    <!-- <button type="button" onClick="location.href='/recommand'">추천인</button> -->
                    <!--<button type="button" onClick="location.href='/bbs/board.php?bo_table=z10'">1:1문의</button>-->
                    <button type="button" onClick="location.href='/logout'">로그아웃</button>
                </div>
                <button type="button" class="charge" onClick="location.href='/member/charge'">충전하기</button>
                <button type="button" class="exchange" onClick="location.href='/member/exchange'">환전하기</button>
            </div>
        <?php } else { ?>
            <!-- 로그인 -->
            <div class="user_box box_type01">
                <h3>Memer Login</h3>
                <form name="login" method="post" action="/loginProcess" onSubmit="return loginCheck();">
                    <input type="hidden" name="sitecode" value="site-a">
                    <input type="hidden" name="returl" value="<?php echo $TPL_VAR["returl"]?>">
                    <div class="login_input">
                        <input type="text" name="uid" id="uid" placeholder="아이디" />
                        <input type="password" name="upasswd" id="upasswd" placeholder="비밀번호" />
                    </div>
                    <button type="submit" id="login_btn" class="login">로그인</button>
                    <button type="button" id="register_btn" class="member_join" >회원가입</button>
                </form>
                <div class="btn_list">
                    <button onClick="login_open();" style="width:48%;">쪽지 <span>00</span></button>
                    <!-- <button onClick="login_open();">복권 <span>00</span></button>
                    <button onClick="login_open();">쿠폰 <span>00</span></button> -->
                    <button onClick="login_open();" style="width:48%;">출석부</button>
                    <!-- <button onClick="login_open();">추천인</button> -->
                    <!--<button onClick="login_open();">1:1문의</button>
                    <button onClick="location.href='/bbs/logout.php'">로그아웃</button>-->
                </div>
            </div>
        <?php 
        }?>
        
        <!-- 베팅카트 -->
        <div id="pc_betting_cart">
            <form name="betForm" method="post"  action="/race/bettingProcess" style="margin:0px;">
                <input type="hidden" value="betting" name="mode"> 
                <input type="hidden" name=strgametype> 
                <input type="hidden" name="gametype" value=<?=$bettype?>>
                <input type="hidden" name="game_type" value="<?php echo $TPL_VAR["game_type"]?>">
                <input type="hidden" name="special_type" value="<?php echo $TPL_VAR["special_type"]?>">
                <input type="hidden" name="member_sn" value="<?php echo $TPL_VAR["member_sn"]?>">
                <input type="hidden" name="result_rate">
                <input type="hidden" name="site_code" value="site-a">
                <textarea name="betcontent" style="display:none"></textarea>
                <div id="pc_betting_cart">
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
                                <li>보유머니<span><?php echo number_format($TPL_VAR["cash"],0)?> 원</span></li>
                                <li>예상적중배당<span id="sp_bet">00.00</span></li>
                                <li>최대배팅금액<span><?php echo number_format($TPL_VAR["betMaxMoney"])?></span></li>
                                <li>배팅금액<span><input type="text" name="betMoney" id="betMoney" value="0" onKeyUp="javascript:this.value=onMoneyChange(this.value);" onMouseOver="this.focus()" style="text-align: right; font-weight: bold;"/> 원</span></li>
                                <li>예상적중금액<span id="sp_total">0</span></li>
                            </ul>
                            <div class="btn_list">
                                <button type="button" onClick="bettingMoneyPlus('5000')">+ 5,000</button>
                                <button type="button" onClick="bettingMoneyPlus('10000')">+ 10,000</button>
                                <button type="button" onClick="bettingMoneyPlus('50000')">+ 50,000</button>
                                <button type="button" onClick="bettingMoneyPlus('100000')">+ 100,000</button>
                                <button type="button" onClick="bettingMoneyPlus('500000')">+ 500,000</button>
                                <button type="button" onClick="clearMoney()"><span>RESET</span></button>
                            </div>
                            <div class="max_bet">
                                <button type="button" onClick="onAllinClicked()">MAX BETTING</button>
                            </div>
                            <div class="bet_arae">
                                <button type="button" class="btn_bet" onClick="javascript:betting('betting');">배팅하기</button>
                                <button type="button" class="btn_del" onClick="javascript:bet_clear(<?=$TPL_VAR["s_type"]?>);">전체삭제</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- 배너 -->
            <div class="banner_area">
                <div><a href="https://telegram.me/<?=$TPL_VAR["telegramID"]?>" target="_blank"><img src="/10bet/images/10bet/ico_telegram_01.gif" alt="텔레그램" /></a></div><br>
                <div><img src="/10bet/images/10bet/kakao.png?v=2" alt="카카오톡 아이디"/><span style="position:relative; top:-47px; left:90px; color:#381e1e; font-size:25px; font-weight:bold;"><?=$TPL_VAR["kakaoID"]?></span></div><br>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	function startClock() {
		var today=new Date();
		var y=today.getFullYear();
		var M=today.getMonth();
		var d=today.getDate();
		var h=today.getHours();
		var m=today.getMinutes();
		var s=today.getSeconds();
		m = checkTime(m);
		s = checkTime(s);
		M = checkDate(M);
		M = checkTime(M);
		var time = M + "-" + d + " " + h + ":" + m + ":" + s;
		document.getElementById('Display_clock').innerHTML = time;
		var t = setTimeout(function(){startClock()},500);
	}
	function checkTime(i) {
		if (i<10) {i = "0" + i};
		return i;
	}
	function checkDate(i) {
		i = i+1 ;
		return i;
	}
</script>