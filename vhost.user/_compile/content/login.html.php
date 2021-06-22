<script language="JavaScript">
</script>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
    <title>BLACK9</title>
    <meta charset="euc-kr">
    <link href='https://fonts.googleapis.com/css?family=Michroma' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/include/css/ibet/intro.css?v03"/>
    <link rel="stylesheet" type="text/css" href="/include/css/ibet/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="/include/css/ibet/perfect-scrollbar.min.css">
    <script Language="Javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="./js/jquery.scrollbar.js"></script>
    <script type="text/javascript" src="/include/js/ibet/classie.js"></script><!-- 버튼클릭 애니메이션 레이어창 -->
    <script type="text/javascript" src="/include/js/ibet/modalEffects.js"></script><!-- 버튼클릭 애니메이션 레이어창 -->
    <script type="text/javascript" src="/include/js/ibet/selectFx.js"></script><!-- 설렉트박스 디자인관련 -->
    <script type="text/javascript" src="/include/js/ibet/sweetalert-dev.js"></script>
    <script type="text/javascript" src="/include/js/ibet/perfect-scrollbar.min.js"></script>
    <script type="text/javascript" src="/include/js/ibet/moment.min.js"></script>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<script>
    var pchk = true;
    var pchk_btn = false;
</script>
<style type="text/css">
    .text {
        font-style: italic;
    }
    .text_2 {
        letter-spacing:1px;
        font-size:0.5em;
        font-weight:400;
        font-style: italic;
    }
    .subtitle-top {
        letter-spacing:22px;
    }

    #join_content_s {
        position:relative;
        margin:0px auto;
        width:500px;
        height: 150px;
        overflow: hidden;
        color:#d2e5ff;
        font-size:12px;
        font-weight:100;
        border:1px solid #394a60;
        padding:10px;
    }
    .join_content {
        height:150px;
    }

    span#select_box {
        display:inline-block;
        position: relative;
        width: 51px;
        height: 30px;
        background: url(/images/ibet/sec.png) 37px center no-repeat;
        border: 2px solid #455e96;
        margin-left:12px;
        cursor:pointer;
    }
    span#select_box label {
        position: absolute;
        font-size: 14px;
        color: #455e96;
        top: 3px;
        left: 6px;
        letter-spacing: 1px;
        cursor:pointer;
    }
    span#select_box select#usr_hp_1 {
        width: 100%;
        height: 30px;
        min-height: 30px;
        line-height: 30px;
        opacity: 0;
        filter: alpha(opacity=0); /* IE 8 */
        cursor:pointer;
        background:#455e96;
        color:#f9f9f9;
        font-weight:100;
    }

    #usr_name, #usr_nick {
        -webkit-ime-mode:active;
        -moz-ime-mode:active;
        -ms-ime-mode:active;
        ime-mode:active;
    }
    .ins_1 {
        width: 40px;
        height: 34px;
        background-image: url(/images/ibet/ins_1.png);
        background-repeat: no-repeat;
    }
    .ins_2 {
        width: 40px;
        height: 34px;
        background-image: url(/images/ibet/ins_2.png);
        background-repeat: no-repeat;
    }

    #login_box{
		width: 500px;
        height: 350px;
		display:inline-block;
		text-align:center;
        top:20%;
		left:49%;
        margin-top:80px;
        z-index: 10;
		border:10px solid #f4c53f;
    }
	
    #btn_chat:hover {
        border-radius: 50%;
        background-image: url(/images/ibet/cus_login_on.png);
        background-repeat: no-repeat;
        background-size: contain;
        height: 100px;
        width: 100px;
        border: 0px;
		left:46%;
    }

    #btn_chat {
        border-radius: 50%;
        background-image: url(/images/ibet/cus_login.png);
        background-repeat: no-repeat;
        background-size: contain;
        height: 100px;
        width: 100px;
        border: 0px;
		left:46%;
    }

    .chat_header {
        font-size: 50px;
        text-align: center;
        margin-top: 25px;
        margin-left: 14px;
    }
</style>

<body>
<div style="width:100%;">
    <!--
	<div class="crome_div">
        <ul>
            <li style="float:left; padding-top:5px;"><img src="/images/ibet/crome_info.png"></li>
            <li style="float:left; padding-left:50px; padding-top:10px;"><a href="https://www.google.com/chrome/browser/desktop/index.html#eula" target="_blank"><img src="/images/ibet/crome_icon.png"></a></li>
            <li class="md-close close_btn crome-close" style="right:100px; top:30px;"></li>
        </ul>
    </div>
	-->
	<div class="login_box" id="login_box">
        <div style="display:inline-block; text-align:center; padding-top:150px; left:48%;">
            <form name="login" method="post" action="/loginProcess" onSubmit="return loginCheck();">
                <input type="hidden" name="sitecode" value="site-a">
                <input type="hidden" name="returl" value="<?php echo $TPL_VAR["returl"]?>">
                <div style="margin-top: -30px;">
                    <input class="form-control input_login" style="width: 392px; font-size: 1em;" type="text" name="uid" id="uid" onkeyup="eng(this)" placeholder="ID" autocomplete="off" required>
                </div>
                <div>
                    <input class="form-control input_login" style="width: 392px; font-size: 1em;" type="password" name="upasswd" id="upasswd" onkeyup="noSpaceForm(this);" onchange="noSpaceForm(this);" placeholder="PASSWORD" autocomplete="off" required/>
                </div>
                <div style="display: flex; margin-top: 20px;">
                    <input type="submit" id="login_btn" class="md-trigger button" value="로그인">
                    <input type="button" class="md-trigger button" id="register_btn" value="회원가입">
                </div>
            </form>
		</div>
		<div style="position:absolute; width:100%; margin-left:0px; color:#ffffff; font-weight:400; text-align:center; bottom:60px; font-family:Ubuntu; font-size:14px;">
		  <!--  COPYRIGHT(C) 2020. BY DayTona COMPANY. ALL RIGHT RESERVED.-->
		</div>
		<div style="position:absolute; top:50%; margin-top:-150px; width:100%; text-align:center; vertical-align:middle;">
			<img src="/images/ibet/logo_2.png?v6">
		</div>
	</div>
		<div style="position:absolute; bottom:50px; right:50px;cursor: pointer" data-modal="modal-join">
			<button class="md-trigger button" id="btn_chat"></button>
		</div>

    <div class="md-modal md-effect-login md-join" id="modal-join" style="width:900px; border:10px solid #f4c53f;">
        <div class="md-content" style="height:450px;">
            <ul class="input_line2"  style="height:100px;">
                <!--<li><img src="/images/ibet/logo_2.png?2" style="margin-top:5px; margin-left:320px;"></li>-->
                <li class="md-close close_btn colose_join" style="margin-left:90px;"></li>
            </ul>
            <div id="agree">
                <div style="margin-top:20px; color:#587191; font-size:14px; font-weight:100;"></div>
                <div class="content join_content">
				<!--
                    <div id="join_content_s" style="font-family:돋움; width:820px;height:220px; background:#05193a; font-size:12px;">
                        DayTona (이하 본사이트)는 성인용 사이트로서 만 19세 미만의 미성년자의 가입을 불허 합니다.<br><br>
                        본사이트는 만 19세 미만의 고객의 가입이라고 판단 되거나 확인 될 시 해당회원의 접속을 제한 하거나<br>
                        계정을 삭제 할 수 있습니다.<br><br>
                        회원이 되고자 하는 모은 고객은 가입시 본 사이트에서 필요로 하는 필수 기재 항몰을 반드시 기재 하여야 합니다.<br>
                        기재한 내용이 허위 이거나 정보가 불충분 할 경우 가입 인증이 되지 않거나 인증이 된 이후에도 이같은<br>
                        허위 기재 사실이 있는경우 가입을 반려 할 수 있습니다.<br><br>
                        본인의 아이디 즉, 접속계정을 타인에게 양도 또는 대여 할 수 없으며, 공유 할 수 없습니다.<br>
                        본인이 아닌 타인의 책임하에 사용된 아이디의 경우 문제가 발생 시 본사이트에서 절대로 책임을 질 수 없습니다.<br>
                        또 한, 이러한 사실이 있는 경우 해당 아이디의 정지 또는 삭제 처리가 불가피 하오니 회원은 이점을 <br>
                        꼭 숙지 하시셔야 합니다.<br><br>
                        회원은 자신의 보유 금액을 배팅 및 환전등의 요청을 통하여 언제든지 사용 할 수 있으며, 본사이트는 이러한<br>
                        요청에 대하여 신속히 처리할 의무가 있습니다. 단, 환전거래 시 불명확한 계좌정보 제공으로 인하여 환전처리가 <br>
                        지연 될 수 있으니 정확한 계좌정보의 제공은 회원이 지켜야 할 필수 항목 입니다.<br><br>
                        회원은 배팅금 또는 정산금 및 충전, 환전 등의 금액적인 부분에 대한 이의 제기 또는 오류 신고에 대하여는 회원<br>
                        스스로가 회사측에 먼저 알리고 해결을 요청할 의무가 있습니다. 고객 센터를 통한 재확인 문의 등이 먼저 이루어지지<br>
                        않은 경우 본사이트는 이러한 사항을 미리 알지 못활 경우가 있습니다.<br><br>
                        회원이 충전이나 환전시 이용할 계좌정보는 언제든지 변경이 가능하나, 반드시 본인 이름의 계좌만 가능 합니다.<br>
                        본사이트의 모든 서비스는 본인 이름의 계좌만 이용 할 수 있음을 숙지 하시기 바랍니다.<br><br>
                        본사이트와 회원은 항사 서로 믿고 신뢰하는 동반자로서의 의무를 다하며 어떠한 경우라도 회사에 불이익을 주는 행위나<br>
                        악의적인 시도에 대하여는 서로 타협하지 아니하며, 이러한 일이 발생 될 시 가능한 모든 방법을 동원하여 방어할 것입니다.<br>
                        이러한 행위 자체에 연류가 되어 있는 회원으로 간주 될 시 해당 아이디의 사용정지 또는 삭제(몰수) 등의<br>
                        조치를 취할 수 있습니다.
                    </div>
					-->
                    <form method="post" name="next" action="/member/add" onSubmit="return check_pincode();">
                    <ul class="" style="width:100%; height:50px; display:block; margin:0px; padding:20px 0px 0px 0px;">
                        <li style="text-align:center; vertical-align:middle;">
                            <input class="input_login" style="display:inline-block;" type="text" name="pincode" id="pincode" onkeyup="eng(this)" placeholder="가입코드를 입력하세요" autofocus autocomplete="off" required>
                        </li>
                    </ul>
                    <ul class="ajax_text_code" style="clear:both; font-weight:100; width:100%; display:block; margin:0px; padding:0px;  padding-top:10px; text-align:center;">
                        <br>
                    </ul>
                    <button id="agree_btn" class="md-trigger button" style="margin-left:345px; margin-top:20px;">인증확인</button>
                    </form>
                </div>
            </div>
            <div id="member_form">
                <div class="content join_content">

                    <article>
                        <ul class="input_line2" style="margin-top:15px;">
                            <li>
                                <label for="id"></label>
                                <input class="input input_join" name="usr_id" type="text" id="usr_id" maxlength="15" onkeyup="eng(this)" placeholder="ID (영문, 숫자포함 5자이상)" autocomplete="off" required>
                            </li>
                            <li>
                                <!--
                                <label for="recommend_id"></label>
                                <input class="input input_join" name="recommend_id" type="password" id="recommend_id" value="" maxlength="20" onkeyup="noSpaceForm(this);" onchange="noSpaceForm(this);" placeholder="추천인아이디(코드)" autocomplete="off" required  />
                                -->
                            </li>
                            <li class="ajax_text" style="width:350px;"><span class="ajax_text usr_id_msg" style="margin-right:20px;"><span style="color:#8eccff;">아이디를 입력해 주세요.</span></span><span class="ajax_text recommend_id_msg"></span></li>
                        </ul>
                        <ul class="input_line2">
                            <li>
                                <label for="pw"></label>
                                <input class="input input_join" name="usr_pw" type="password" id="usr_pw" maxlength="20" onkeyup="noSpaceForm(this);" onchange="noSpaceForm(this);" placeholder="PASSWORD (6자이상)" required/>
                            </li>
                            <li>
                                <label for="pw2"></label>
                                <input class="input input_join" type="password" name="usr_pw2" id="usr_pw2" maxlength="20" onkeyup="noSpaceForm(this);" onchange="noSpaceForm(this);" placeholder="PASSWORD 확인" required/>
                            </li>
                            <li class="ajax_text" style="width:350px;"><span class="ajax_text usr_pw_msg" style="margin-right:20px;"><span style="color:#8eccff;">비밀번호를 입력해주세요</span></span><span class="ajax_text usr_pw2_msg"></span></li>
                        </ul>
                        <ul class="input_line2">
                            <li>
                                <label for="name"></label>
                                <input class="input input_join" name="usr_name" type="text" id="usr_name" onkeyup="han(this);" onchange="noSpaceForm(this);" placeholder="이름 (예금주와 동일명)" autocomplete="off" required/>
                            </li>
                            <li>
                                <label for="nick"></label>
                                <input class="input input_join" name="usr_nick" type="text"  onkeyup="hannum(this)" onchange="noSpaceForm(this);" maxlength="10" id="usr_nick" placeholder="닉네임(한글만 7자내)" autocomplete="off" required/>
                            </li>
                            <li class="ajax_text usr_name_msg usr_nick_msg"><span style="color:#8eccff;">이름과 닉네임을 입력해주세요</span></li>
                        </ul>
                        <ul class="input_line2">
                            <li>
                                <input name="usr_hp" id="usr_hp" class="input input_join" maxlength="13" placeholder="휴대폰번호 (숫자만)" autocomplete="off" required/>
                            </li>

                            <button class="hp_btn ins_1" type="text" id="hp_btn" name="certification" onClick="chkP()" style="width:40px; margin-left:12px;"></button>
                            <li style="margin-left:-15px;">
                                <label for="certification"></label>
                                <input class="input input_join" style="width:97px;" name="usr_hp_cert" id="usr_hp_cert" onKeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="6" type="text"  placeholder="인증번호" autocomplete="off" required/>
                            </li>
                            <li>
                                <button class="hp_btn ins_2" type="text" id="hp_btn_ok" name="certification_ok" onclick="chkPN()" style="width:40px; color:#ffffff; margin-left:-5px;"></button>
                            </li>

                            <li class="ajax_text"><span class="ajax_text usr_hp_msg" style="margin-right:20px;"><span style="color:#8eccff;">휴대폰번호를 입력해 주세요</span></span></li><!--li class="ajax_text"></li//-->
                        </ul>
                        <ul class="input_line2">
                            <li>
                                <label for="bank"></label>
                                <select class="input input_join cs-select cs-skin-border" name="usr_bank" type="text" id="usr_bank" list="bank_name" required/>
                                <option value="" selected>은행선택</option>
                                <option value="국민">국민</option>
                                <option value="우리">우리</option>
                                <option value="신한">신한(조흥)</option>
                                <option value="농협">농협</option>
                                <option value="축협">축협</option>
                                <option value="기업">기업</option>
                                <option value="하나">하나</option>
                                <option value="우체국">우체국</option>
                                <option value="SC제일">SC제일</option>
                                <option value="외환">외환</option>
                                <option value="산업">산업</option>
                                <option value="씨티">씨티(한미)</option>
                                <option value="수협">수협</option>
                                <option value="신협">신협</option>
                                <option value="새마을금고">새마을금고</option>
                                <option value="상호저축">상호저축</option>
                                <option value="경기">경기</option>
                                <option value="경남">경남</option>
                                <option value="광주">광주</option>
                                <option value="부산">부산</option>
                                <option value="제주">제주</option>
                                <option value="전북">전북</option>
                                <option value="대구">대구</option>
                                <option value="대신증권">대신증권</option>
                                <option value="미래에셋">미래에셋</option>
                                <option value="삼성증권">삼성증권</option>
                                <option value="한화투자">한화투자</option>
                                <option value="NH투자">NH투자</option>
                                <option value="SK증권">SK증권</option>
                                <option value="현대증권">현대증권</option>
                                <option value="키움증권">키움증권</option>
                                </select>
                            </li>
                            <li>
                                <label for="bank_num"></label>
                                <input class="input input_join" type="text" name="usr_account" id="usr_account" maxlength="20" onKeyup="this.value=this.value.replace(/[^0-9]/g,'')" placeholder="계좌번호 (본인명 계좌)" autocomplete="off" required/>
                            </li>
                            <li class="ajax_text"><span class="ajax_text usr_account_msg" style="margin-right:20px;"><span style="color:#8eccff;">은행과 계좌번호를 입력해주세요</span></span></li>
                        </ul>
                        <ul class="input_line2">
                            <li>
                                <label for="exchange"></label>
                                <input class="input input_join" name="usr_account_pw" type="password" id="usr_account_pw" maxlength="20" onkeyup="noSpaceForm(this);" onchange="noSpaceForm(this);" placeholder="환전번호(로그인비번 사용불가)" required/>
                            </li>
                            <li>
                                <label for="exchange2"></label>
                                <input class="input input_join" type="password" name="usr_account_pw2" maxlength="20" id="usr_account_pw2" onkeyup="noSpaceForm(this);" onchange="noSpaceForm(this);" placeholder="환전번호 확인" required/>
                            </li>
                            <li class="ajax_text" style="width:350px;"><span class="ajax_text usr_account_pw_msg" style="margin-right:20px;"><span style="color:#8eccff;">환전비밀번호를 입력해주세요</span></span><span class="ajax_text usr_account_pw2_msg"></span></li>
                        </ul>
                        <ul>
                            <li>
                                <button class="join_btn" type="text" id="join_btn" name="register" style="margin-top:8px;margin-left:260px;"/>회원가입</button>
                            </li>
                        </ul>

                        <article>

                </div>
            </div>
        </div>
    </div>
    <div class="md-modal md-effect-login" id="modal-chat" style="width: 400px">
        <div class="md-content" style="height:580px;background:#262626;">
            <ul class="input_line2"  style="height:80px;">
                <li class="chat_header">고객상담</li>
                <li class="md-close close_btn colose_chat"></li>
            </ul>
            <div id="agree">
                <div style="margin-top:20px; color:#587191; font-size:14px; font-weight:100;"></div>
            </div>
            <div id="member_form">
                <div class="content join_content">

                    <article>
                        <ul class="input_line2" style="margin-top:15px;">
                            <li class="ajax_text_chat" style="width:350px;"><span class="ajax_text_chat usr_id_msg" style="margin-right:20px;"><span style="color:#8eccff;">아이디를 입력해 주세요.</span></span><span class="ajax_text recommend_id_msg"></span></li>
                            <li>
                                <label for="id"></label>
                                <input class="input input_chat" name="chat_usr_id" type="text" id="chat_usr_id" maxlength="15" onkeyup="eng(this)" placeholder="ID (영문, 숫자포함 5자이상)" autocomplete="off" required>
                            </li>
                        </ul>
                        <ul class="input_line2">
                            <li class="ajax_text_chat usr_name_msg usr_nick_msg"><span style="color:#8eccff;">이름과 닉네임을 입력해주세요</span></li>
                            <li>
                                <label for="name"></label>
                                <input class="input input_chat" name="chat_usr_name" type="text" id="chat_usr_name" onkeyup="han(this);" onchange="noSpaceForm(this);" placeholder="이름 (예금주와 동일명)" autocomplete="off" required/>
                            </li>
                            <li>
                                <label for="nick"></label>
                                <input class="input input_chat" name="chat_usr_nick" type="text"  onkeyup="hannum(this)" onchange="noSpaceForm(this);" maxlength="10" id="chat_usr_nick" placeholder="닉네임(한글만 7자내)" autocomplete="off" required/>
                            </li>
                        </ul>
                        <ul class="input_line2">
                            <li class="ajax_text_chat"><span class="ajax_text_chat usr_hp_msg" style="margin-right:20px;"><span style="color:#8eccff;">휴대폰번호를 입력해 주세요</span></span></li><!--li class="ajax_text"></li//-->
                            <li>
                                <input name="chat_usr_hp" id="chat_usr_hp" class="input input_chat" maxlength="13" placeholder="휴대폰번호 (숫자만)" autocomplete="off" required/>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <button class="join_btn" type="text" id="chat_btn" name="register" style="margin-top:8px;margin-left:0px;"/>상담요청</button>
                            </li>
                            <li class="ajax_text_chat" style="padding-top: 10px; margin-left: -15px;">
                                <span class="ajax_text_chat usr_hp_msg" style="margin-right:20px;">
                                    <span style="color:#8eccff;">로그인정보를 잃어버리셨을 경우 사용하세요.</span>
                                    <span style="color:#8eccff;">기존 회원만 상담이 가능하며 가입된 정보중 두개이상이 일치해야 상담이 가능합니다.</span>
                                </span>
                            </li>
                        </ul>
                        <article>
                </div>
            </div>
        </div>
    </div>
    <div style="position:absolute; bottom:50px; right:50px;">
    </div>
    <div class="md-overlay"></div>
</div>

<script>
    var polyfilter_scriptpath = '/include/js/ibet/';
</script>
<script>
    (function() {
        [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
            new SelectFx(el);
        } );
    })();
</script>

<script>
    $("#register_btn").click(function(event) {
        event.preventDefault();
        $("#modal-join").addClass("md-show");
    });
    
    $( "#chat_btn" ).click(function( ) {
        //window.location = "/page/main/tutorial"
        check_userinfo();
    });

    $("#btn_chat").click(function() {
        $("#modal-chat").addClass("md-show");
    });

    $(".colose_join").click(function() {
        $("#modal-join").removeClass("md-show");
    });

    $(".colose_chat").click(function() {
        $("#modal-chat").removeClass("md-show");
    });

    function check_userinfo() {
        var chat_usr_id = $('#chat_usr_id').val();
        var chat_usr_name = $('#chat_usr_name').val();
        var chat_usr_nick = $('#chat_usr_nick').val();
        var chat_usr_hp = $('#chat_usr_hp').val();

        var m_count = 0;
        if (chat_usr_id.length > 0) {
            m_count++;
        }

        if (chat_usr_name.length > 0) {
            m_count++;
        }
        if (chat_usr_nick.length > 0) {
            m_count++;
        }

        if (chat_usr_hp.length > 0) {
            m_count++;
        }

        if(m_count < 2) {
            swal("정보가 부족합니다.");
        } else {
            $.ajaxSetup({async:false});
            var param={usr_id:chat_usr_id, usr_name:chat_usr_name,usr_nick:chat_usr_nick,usr_hp:chat_usr_hp};

            $.post("/member/userInfoPopup", param, function(result) {
                if( $.trim(result) == "false" ) {
                    swal("정보가 일치하지 않습니다.");
                } else {
                    swal(result);
                }
                return false;
            });
        }
        return false;
    }

    $( "#show_loginform" ).click(function() {
        $( "#login_id").val("");
        $( "#login_pw").val("");
        $( ".ajax_text_login" ).html("");
    });

</script>

<script>
    function loginCheck() {
        var f = document.login;
        if ( f.uid.value == "" ) {
            swal('아이디를 입력하십시오.');
            //f.uid.focus();
            return false;
        }

        if ( f.upasswd.value == "" ) {
            swal("비밀번호를 입력하십시오.");
            f.upasswd.focus();
            return false;
        }

        f.submit();
        return false;
    }

    function loginEnter(e) {
        if ( e.keyCode == 13 ) {
            loginCheck();
        }
    }

    function check_pincode() {
        var pincode = $('#pincode').val();
        if ( pincode.length < 1 ) {
            swal('가입인증코드를 입력하세요');
            $('#pincode').focus();
            return false;
        } else {
            $.ajaxSetup({async:false});
            var param={pin:pincode};

            $.post("/member/pincodePopup", param, function(result) {
                if( $.trim(result) == "false" ) {
                    $("#pincode").focus();
                    swal("존재하지 않거나, 제한된 가입인증코드 입니다.");
                    return false;
                } else {
                    document.next.submit();
                }
            });
        }
        return false;
    }

    function joincode() {
        var req = $.ajax({
            cache: false,
            method: "POST",
            url: "./login.php",
            data: { mode: "code", frID: encodeURIComponent($("#frID").val()) }
        });
        req.done(function( result ) {
            var data = result.split("|");
            if( data[0] == "0000" ) {
                $("#agree").css("display", "none");
                $("#member_form").css("display", "");
            } else {
                data[1] = data[1].replace(/<p>/gi,"<span>").replace(/<\/p>/gi,"</span>");
                $( ".ajax_text_code" ).html(data[1]);
            }
        });
    }

    function autoHypenPhone(str){
        str = str.replace(/[^0-9]/g, '');
        var tmp = '';
        if( str.length < 4){
            return str;
        }else if(str.length < 7){
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3);
            return tmp;
        }else if(str.length < 11){
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3, 3);
            tmp += '-';
            tmp += str.substr(6);
            return tmp;
        }else{
            tmp += str.substr(0, 3);
            tmp += '-';
            tmp += str.substr(3, 4);
            tmp += '-';
            tmp += str.substr(7);
            return tmp;
        }
        return str;
    }

    var cellPhone = document.getElementById('usr_hp');
    cellPhone.onkeyup = function(event){
        event = event || window.event;
        var _val = this.value.trim();
        this.value = autoHypenPhone(_val) ;
    }

    /* 약관동의 */
    $("#member_form").css("display", "none");
    /*$("#agree_btn").click(function(){
        joincode();
    });*/






    /* 회원가입 */
    $( ".input_join" ).keypress(function( event ) {
        var index = $(".input_join").index(this);
        if ( event.which == 13 ) {
            var index_next = index + 1;
            //$(".input_join:eq("+index+")").focus();
        }
    });
    $( "#usr_hp" ).keyup(function( event ) {
        $( "#usr_hp" ).val($( "#usr_hp" ).val().substring(0,13));
    });
    var chk_usr_id = false;


    $("#join_btn").click(function (){
        if( pchk == true ) {
            alert("\n 휴대폰인증이 되지 않았습니다. \n");
            return;
        }else{
            var req = $.ajax({
                cache: false,
                method: "POST",
                url: "./Member_Regis.php",
                data: {
                    mode : "REG",
                    m_id: encodeURIComponent($("#usr_id").val()),
                    recommend_id: encodeURIComponent($("#recommend_id").val()),
                    m_pwd: encodeURIComponent($("#usr_pw").val()),
                    m_pwd_r: encodeURIComponent($("#usr_pw2").val()),
                    m_bankname: encodeURIComponent($("#usr_name").val()),
                    m_nick: encodeURIComponent($("#usr_nick").val()),
                    rcv_number: encodeURIComponent($("#usr_hp").val()),
                    m_bank: encodeURIComponent($("#usr_bank").val()),
                    m_banknum: encodeURIComponent($("#usr_account").val()),
                    m_expass: encodeURIComponent($("#usr_account_pw").val()),
                    m_expass_r: encodeURIComponent($("#usr_account_pw2").val())
                }
            });
            req.done(function( result ) {

                var data = result.split("|");
                if( data[0] == "0000" ) {

                    swal({
                        title: "회원가입완료",
                        text: "<span style='color:#ff6600;'> "+ $("#usr_id").val() +"</span> 님 가입을 축하드립니다.",
                        type: "success",
                        confirmButtonColor: '#ff8400',
                        confirmButtonText: 'OK',
                        html:true,
                        closeOnConfirm: true
                    }, function (){
                        window.location = "./"
                    });
                } else {

                    alert(data[1]);

                }
            });

        }
    });

    function chkP(){
        var phone_num = document.getElementById("usr_hp");
        if(pchk_btn == true){
            swal("승인번호가 전송중입니다.", "통신사의 사정에따라 문자전송이 지연될수 있으니 잠시만 기다려 주십시오.", "warning");
            return;
        }else if(pchk_btn == 'ok'){
            swal("휴대폰인증을 완료 하였습니다.", "", "success");
            return;
        }else if(phone_num.value.length < 12){
            swal("휴대폰번호를 \n정확하게 입력해 주세요.", "", "warning");
            return;
        }else{
            pchk_btn = true;
            var req = $.ajax({
                cache: false,
                method: "POST",
                url: "./sms_process.php",
                data: {
                    rcv_number: usr_hp.value
                }
            });
            req.done(function( result ) {

                var data = result.split("|");
                if( data[0] == "0000" ) {
                    swal("인증번호가 전송되었습니다", "인증번호 입력란에 전송받으신 인증번호를 입력해 주세요", "success");
                    //document.getElementById("hp_btn").style.display = "block";
                    phone_num.readOnly = true;
                } else {
                    pchk_btn = false;
                    phone_num.readOnly = false;
                    alert(data[1]);

                }
            });
        }

    }

    function chkPN(){

        var phone_num = document.getElementById("usr_hp");
        var cert_num = document.getElementById("usr_hp_cert");
        if(phone_num.value.length < 12){
            swal("인증요청을 먼저 진행해주세요.", "", "warning");
            return;
        }else if(cert_num.value.length < 4 ){
            swal("인증번호를 정확하게 입력해 주세요.", "", "warning");
            return;
        }else{
            phone_num.readOnly = true;
            var req = $.ajax({
                cache: false,
                method: "POST",
                url: "./sms_process_rec.php",
                data: {
                    send_num_sms: phone_num.value,
                    rec_sms: document.getElementById("usr_hp_cert").value
                }
            });
            req.done(function( result ) {
                var data = result.split("|");
                if( data[0] == "0000" ) {
                    swal("인증을 완료하였습니다.", "휴대폰인증이 정상적으로 완료되었습니다.", "success");
                    document.getElementById("usr_hp_cert").style.display = "none";
                    document.getElementById("hp_btn_ok").style.display = "none";
                    document.getElementById("hp_btn").style.display = "none";

                    pchk = false;
                } else {
                    pchk_btn = false;
                    phone_num.readOnly = false;
                    alert(data[1]);

                }
            });
        }
    }

    /* 마이페이지 스크롤 박스를 위한 스크립트 */
    function changeSize() {
        var width = parseInt($("#Width").val());
        var height = parseInt($("#Height").val());
        $("#join_content_s").width(width).height(height);
        Ps.update(document.getElementById('join_content_s'));
    }
    // update perfect scrollbar
    $(function() {
        Ps.initialize(document.getElementById('join_content_s'));
    });
    //크롬 부라우저 내용 닫기
    $(".crome-close").click(function(){
        $(".crome_div").addClass("crome");
    });

</script>
<script type="text/javascript">
    // 웹폰트 로더 활용
    WebFontConfig = {
        google: { families: [ 'Raleway:400,100,200,300,600,700,800,900,500:latin', 'Ubuntu:400,700italic,700,500italic,500,400italic,300italic,300:latin', 'Abel::latin'] }
    };
    (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();
    // 공백사용못하게
    function noSpaceForm(obj) { // 공백사용못하게
        var str_space = /\s/;  // 공백체크
        if(str_space.exec(obj.value)) { //공백 체크
            obj.focus();
            obj.value = obj.value.replace(' ',''); // input 공백제거
            return false;
        }
    }

    function han(obj) {
        var pattern = /[^(ㄱ-힣)]/; //한글만 허용 할때
        if (pattern.test(obj.value)) {
            //swal("Warning", "한글만 허용합니다!", "warning");
            obj.value = '';
            obj.focus();
            return false;
        }
    }
    function eng(obj) {
        var pattern = /[^(a-zA-Z0-9)]/; //영문만 허용
        if (pattern.test(obj.value)) {
            swal("Warning", "영문과 숫자만 허용합니다!", "warning");
            obj.value = '';
            obj.focus();
            return false;
        }
    }
    function hannum(obj) {
        var pattern = /[^(ㄱ-힣0-9)]/; //한글과 숫자 허용 할때
        if (pattern.test(document.getElementById('name').value)) {
            //swal("Warning", "한글과 숫자만 허용합니다!", "warning");
            obj.value = '';
            obj.focus();
            return false;
        }
    }
    //$("#recommend_id").val("");
</script>
</body>
</html></body>
</html>