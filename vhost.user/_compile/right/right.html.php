<?php 
$isApi = isset($TPL_VAR["api"]) ? $TPL_VAR["api"] : "";
if($isApi == "true")  {?>
    <div id="right_section" style="top:0px;">
<?php } else { ?>
    <div id="right_section">
<?php } ?>
    <div class="right_box">
        <?php
        if(count((array)$_SESSION['member']) > 0) { ?>
            <!-- 유저 정보 -->
            <div class="user_box box_type01">
                <div class="point"  style="display:flex;">
                    <img class="img-height" src='/images/level_icon_<?php echo $TPL_VAR["level"]?>.png?v=1'>&nbsp;&nbsp;&nbsp; 
                    <p class="_limit _w100 p-name"><?=$TPL_VAR["nick"]?></p>
                    <span class="change" onClick="location.href='/member/member'">내 정보</span>
                </div>
                <div class="money">
                    <span class="head"><img src="/10bet/images/10bet/ico_01.png" alt="" /> 보유머니</span> 
                    <span class="member_inmoney"><?php echo number_format($TPL_VAR["cash"],0)?></span>					
                </div>
                <div class="point">
                    <span class="head"><img src="/10bet/images/10bet/ico_01.png" alt="" /> 포인트</span> 
                    <span class="member_mileage"><?php echo number_format($TPL_VAR["mileage"],0)?></span>&nbsp;P
                    <span class="change" onClick="location.href='/member/mileage?type=6'">포인트전환</span>
                </div>
                <div class="btn_list">
                    <button type="button" onClick="location.href='/member/memolist'">쪽지 <span class="memoCnt"><?php echo $TPL_VAR["new_memo_count"]?></span></button>
                    <button type="button" onClick="location.href='/calendar'">출석부</button>
                    <button type="button" onClick="location.href='/logout'">로그아웃</button>
                </div>
                <button type="button" class="charge" onClick="location.href='/member/charge'">충전하기</button>
                <button type="button" class="exchange" onClick="location.href='/member/exchange'">환전하기</button>
            </div>

            <!-- 배너 -->
            <?php 
            if($TPL_VAR["api"] != "true") { ?>
            <div class="banner_area">
                <div><a href="https://telegram.me/<?=$TPL_VAR["telegramID"]?>" target="_blank"><img src="/10bet/images/10bet/ico_telegram_01.gif" alt="텔레그램" /></a></div><br>
                <div><img src="/10bet/images/10bet/kakao.png?v=2" alt="카카오톡 아이디"/><span style="position:relative; top:-47px; left:90px; color:#381e1e; font-size:25px; font-weight:bold;"><?=$TPL_VAR["kakaoID"]?></span></div><br>
            </div>
            <?php } ?>

        <?php } else { ?>
            <!-- 로그인 -->
            <div class="user_box box_type01">
                <h3>Member Login</h3>
                <form name="login" method="post" action="/loginProcess" onSubmit="return loginCheck();">
                    <input type="hidden" name="sitecode" value="site-a">
                    <input type="hidden" name="returl" value="<?php $TPL_VAR["returl"]?>">
                    <div class="login_input">
                        <input type="text" name="uid" id="uid" placeholder="아이디" />
                        <input type="password" name="upasswd" id="upasswd" placeholder="비밀번호" />
                    </div>
                    <button type="submit" id="login_btn" class="login">로그인</button>
                    <button type="button" class="member_join" onClick="register_open();">회원가입</button>
                </form>
                <div class="btn_list">
                    <button onClick="login_open();" style="width:48%;">쪽지 <span>00</span></button>
                    <button onClick="login_open();" style="width:48%;">출석부</button>
                </div>
            </div>
        <?php 
        }?>
        
    </div>
</div>