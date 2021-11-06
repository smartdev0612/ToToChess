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
                    <img class="img-height" src='/images/level_icon_<?php echo $TPL_VAR["level"]?>.png?v=2'>&nbsp;&nbsp;&nbsp; 
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

            <!-- 베팅카트 -->
            <?php if(isset($TPL_VAR["page_type"]) && $TPL_VAR["page_type"] == "sports") {?>
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
                                        <li>최대당첨금액<span><?php echo number_format($TPL_VAR["maxBonus"])?></span></li>
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
                        </div>
                    </form>
                </div>
            <?php } else if($TPL_VAR["page_type"] == "casino" || $TPL_VAR["page_type"] == "slot") { ?>
                <div class="betting_cart box_type01">
                    <h3>
                        <img src="/10bet/images/10bet/ico_slot_01_01.png" alt="" />
                        <?php
                        if($TPL_VAR["page_type"] == "casino") 
                            echo "보유금액";
                        else
                            echo "슬롯보유금액";
                        ?>
                    </h3>
                    <div class="betting_box">
                        <div class="bet_arae">
                            <button type="button" class="btn_bet "onClick="location.href='/bbs/write.php?bo_table=b30'">카지노충전</button>
                            <button type="button" class="btn_del" onClick="location.href='/bbs/write.php?bo_table=b30&ca=1'">카지노환전</button>
                        </div>
                        <ul>
                        <?php if($TPL_VAR["page_type"] == "casino") {?>
                            <li>에볼루션<span>0 원</span></li>
                            
                            <li>올벳<span>0 원</span></li>
                            
                            <li>타이산<span>0 원</span></li>
                            
                            <li>WM카지노<span>0 원</span></li>
                            
                            <li>아시아게이밍<span>0 원</span></li>
                            
                            <li>오리엔탈게임<span>0 원</span></li>
                            
                            <li>드림게임<span>0 원</span></li>
                            
                            <li>VIVO<span>0 원</span></li>
                            
                            <li>섹시카지노<span>0 원</span></li>
                            
                            <li>BBIN<span>0 원</span></li>
                            
                            <li>HO게이밍<span>점검중 원</span></li>
                            
                            <li>카가얀<span>0 원</span></li>
                            
                            <li>마이다스<span>0 원</span></li>
                            
                            <li>88카지노<span>0 원</span></li>
                            
                            <li>오카다<span>0 원</span></li>
                            
                            <li>뉴마카오<span>0 원</span></li>
                            
                            <li>IDN포커<span>0 원</span></li>
                                                        
                            <li><span>0 원</span></li>
                                    
                            <li>하바네로<span>0 원</span></li>
                                    
                            <li>큐텍<span>점검중 원</span></li>
                                    
                            <li>프로그마틱<span>점검중 원</span></li>
                                    
                            <li>CQ9<span>0 원</span></li>
                                    
                            <li>비게이밍<span>0 원</span></li>
                                    
                            <li>비게이밍<span>0 원</span></li>
                                    
                            <li>드림테크<span>0 원</span></li>
                                    
                            <li>에보플레이<span>0 원</span></li>
                                    
                            <li>리얼타임게이밍<span>0 원</span></li>
                                    
                            <li>벳소프트<span>0 원</span></li>
                                    
                            <li>플레이스타<span>0 원</span></li>
                                    
                            <li>게임아트<span>0 원</span></li>
                                    
                            <li>제네시스<span>0 원</span></li>
                                    
                            <li>TPG<span>0 원</span></li>
                                    
                            <li>스타게임<span>0 원</span></li>
                                    
                            <li>플레이손<span>0 원</span></li>
                        <?php } else { ?>
                            <li>마이크로게이밍<span>0 원</span></li>
                            
                            <li>하바네로<span>0 원</span></li>
                                    
                            <li>큐텍<span>0 원</span></li>
                                    
                            <li>프로그마틱<span>0 원</span></li>
                                    
                            <li>CQ9<span>0 원</span></li>
                                    
                            <li>비게이밍<span>0 원</span></li>
                                    
                            <li>드림테크<span>0 원</span></li>
                                    
                            <li>에보플레이<span>0 원</span></li>
                                    
                            <li>리얼타임게이밍<span>0 원</span></li>
                                    
                            <li>벳소프트<span>0 원</span></li>
                                    
                            <li>플레이스타<span>0 원</span></li>
                                    
                            <li>게임아트<span>0 원</span></li>
                                    
                            <li>제네시스<span>0 원</span></li>
                                    
                            <li>TPG<span>0 원</span></li>
                                    
                            <li>스타게임<span>0 원</span></li>
                                    
                            <li>플레이손<span>0 원</span></li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
                <!-- 머니 이동 -->
                <form name="fwrite" method="post" onsubmit="return fwrite_check(this);" enctype="multipart/form-data" style="margin:0px;">
                    <input type=hidden name=bo_table value="b30">
                    <input type=hidden name=secret value='secret'>
                    <input type=hidden name=ca value="2">
                    <input type='hidden' name='my_credit' id='my_credit' value='' >
                    <input type='hidden' name='wr_subject' id='wr_subject' value='' >
                    <input type='hidden' name='wr_subject2' id='wr_subject2' value='' >
                    <input type="hidden" name="wr_10"  required itemname="충전/환전" value="환전신청" />
                    <div class="money_move">
                        <h3><img src="/10bet/images/10bet/ico_money_01.png" alt="" /> 게임머니이동</h3>
                        <div class="company_select">
                            <div class="btn_area">
                                <button type="button" class="before_select">이동전 게임 선택</button>
                            </div>
                            <ul class="company_list">
                                <li onClick="game_select('mc',this)">마이크로게이밍</li>
                                <li onClick="game_select('ev',this)">에볼루션</li>
                                <li onClick="game_select('ab',this)">올벳</li>
                                <li onClick="game_select('ta',this)">타이산</li>
                                <li onClick="game_select('wm',this)">WM카지노</li>
                                <li onClick="game_select('ag',this)">아시아게이밍</li>
                                <li onClick="game_select('og',this)">오리엔탈게임</li>
                                <li onClick="game_select('dr',this)">드림게임</li>
                                <li onClick="game_select('vv',this)">VIVO</li>
                                <li onClick="game_select('sx',this)">섹시카지노</li>
                                <li onClick="game_select('bb',this)">BBIN</li>
                                <li onClick="game_select('ho',this)">HO게이밍</li>
                                <li onClick="game_select('cg',this)">카가얀</li>
                                <li onClick="game_select('md',this)">마이다스</li>
                                <li onClick="game_select('88',this)">88카지노</li>
                                <li onClick="game_select('od',this)">오카다</li>
                                <li onClick="game_select('nw',this)">뉴마카오</li>
                                <li onClick="game_select('hb',this)">하바네로</li>
                                <li onClick="game_select('qt',this)">큐텍</li>
                                <li onClick="game_select('pr',this)">프로그마틱</li>
                                <li onClick="game_select('cq',this)">CQ9</li>
                                <li onClick="game_select('bg',this)">비게이밍</li>
                                <li onClick="game_select('drt',this)">드림테크</li>
                                <li onClick="game_select('ep',this)">에보플레이</li>
                                <li onClick="game_select('rt',this)">리얼타임게이밍</li>
                                <li onClick="game_select('bs',this)">벳소프트</li>
                                <li onClick="game_select('ps',this)">플레이스타</li>
                                <li onClick="game_select('ga',this)">게임아트</li>
                                <li onClick="game_select('gs',this)">제네시스</li>
                                <li onClick="game_select('tp',this)">TPG</li>
                                <li onClick="game_select('sg',this)">스타게임</li>
                                <li onClick="game_select('po',this)">플레이손</li>
                                <li onClick="game_select('idn',this)">IDN포커</li>
                            </ul>
                        </div>
                        <div class="input_area"><input type="text" name='wr_content' id="wr_content" placeholder="0" onblur="check();" required /></div>
                        <div class="company_select">
                            <div class="btn_area">
                                <button type="button" class="after_select">이동후 게임 선택</button>
                            </div>
                            <ul class="company_list">
                                <li onClick="game_select2('mc',this)">마이크로게이밍</li>
                                <li onClick="game_select2('ev',this)">에볼루션</li>
                                <li onClick="game_select2('ab',this)">올벳</li>
                                <li onClick="game_select2('ta',this)">타이산</li>
                                <li onClick="game_select2('wm',this)">WM카지노</li>
                                <li onClick="game_select2('ag',this)">아시아게이밍</li>
                                <li onClick="game_select2('og',this)">오리엔탈게임</li>
                                <li onClick="game_select2('dr',this)">드림게임</li>
                                <li onClick="game_select2('vv',this)">VIVO</li>
                                <li onClick="game_select2('sx',this)">섹시카지노</li>
                                <li onClick="game_select2('bb',this)">BBIN</li>
                                <li onClick="game_select2('ho',this)">HO게이밍</li>
                                <li onClick="game_select2('cg',this)">카가얀</li>
                                <li onClick="game_select2('md',this)">마이다스</li>
                                <li onClick="game_select2('88',this)">88카지노</li>
                                <li onClick="game_select2('od',this)">오카다</li>
                                <li onClick="game_select2('nw',this)">뉴마카오</li>
                                <li onClick="game_select2('hb',this)">하바네로</li>
                                <li onClick="game_select2('qt',this)">큐텍</li>
                                <li onClick="game_select2('pr',this)">프로그마틱</li>
                                <li onClick="game_select2('cq',this)">CQ9</li>
                                <li onClick="game_select2('bg',this)">비게이밍</li>
                                <li onClick="game_select2('drt',this)">드림테크</li>
                                <li onClick="game_select2('ep',this)">에보플레이</li>
                                <li onClick="game_select2('rt',this)">리얼타임게이밍</li>
                                <li onClick="game_select2('bs',this)">벳소프트</li>
                                <li onClick="game_select2('ps',this)">플레이스타</li>
                                <li onClick="game_select2('ga',this)">게임아트</li>
                                <li onClick="game_select2('gs',this)">제네시스</li>
                                <li onClick="game_select2('tp',this)">TPG</li>
                                <li onClick="game_select2('sg',this)">스타게임</li>
                                <li onClick="game_select2('po',this)">플레이손</li>
                                <li onClick="game_select2('idn',this)">IDN포커</li>
                            </ul>
                        </div>
                        <div class="user_box" style="height:auto;padding:0;margin:0;">
                            <button type="submit" class="charge">게임머니이동하기</button>
                        </div>
                    </div>
                </form>
            <?php } ?>
            
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