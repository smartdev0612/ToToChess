
	<div class="mask"></div>
	<div id="container">

	<style type="text/css">
		.m_padding  { PADDING-LEFT: 12px; PADDING-BOTTOM: 2px; PADDING-TOP: 2px;}
		.m_padding2 { PADDING-LEFT: 0px; PADDING-top: 5px; PADDING-BOTTOM: 0px; }
		.m_padding3 { PADDING-LEFT: 0px; PADDING-top: 5px; PADDING-BOTTOM: 5px; }
		.reg_tb{border:1px #333 solid;}
		.ed { background-color:#fff; color:#000;border:1px solid #ddd;width:358px; padding-left:10px; height:40px;}
		.edh { background-color:#fff; color:#000;border:1px solid #ddd;width:109px; padding-left:10px; height:40px;}

		.pn { -webkit-text-security: disc; -moz-text-security:circle; text-security:circle; }
		.pn::-webkit-inner-spin-button, .pn::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
	</style>
	<script type="text/javascript">
		var recode = '<?=$_SESSION["recode"]?>';
		var partnerSn = '<?php echo $TPL_VAR["partnerSn"]?>';
		var recommendUid = '<?php echo $TPL_VAR["recommendUid"]?>';
		var parentCodeFlag = 0;
		var submitFlag = 0;
	</script>
	
	<div id="contents">
		<div class="board_box">
			<h2>내 정보</h2>
            <!-- 회원가입 폼 -->
            <form action="?mode=modify" method="post" name="form1" id="form1">
                <div class="member_section">
                    <div class="member_box" >
                        <div class="box01" style="width:100%">
                            <!-- 입력 박스 -->
                            <div class="input_area">
                                <div class="box_left">
                                    <h3>사용자 아이디</h3>
                                    <div class="input_box">
                                        <input type="text" value="<?php echo $TPL_VAR["sess_member_id"]?>" disabled/>
                                    </div>
                                </div>
                                <div class="box_left">
                                    <h3>닉네임</h3>
                                    <div class="input_box">
                                        <input type="text" value="<?php echo $TPL_VAR["sess_member_name"]?>" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="input_area">
                                <div class="box_left">
                                    <h3>기존비밀번호 *</h3>
                                    <div class="input_box">
                                        <input type="password" id="pass" name="pass"/>
                                        <p>※ 개인정보보호를 위해 자주 변경해주세요.</p>
                                    </div>
                                </div>
                                <div class="box_left">
                                    <h3>변경비밀번호 *</h3>
                                    <div class="input_box">
                                        <input type="password" id="newpass" name="newpass"/>
                                        <p>※ 비밀번호를 변경하시려면 입력하세요.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="input_area">
                                <div class="box_left">
                                    <h3>은행명</h3>
                                    <div class="input_box">
                                        <input type="text" value="<?php echo $TPL_VAR["bank_name"]?>" disabled/>
                                    </div>
                                </div>
                                <div class="box_left">
                                    <h3>예금주</h3>
                                    <div class="input_box">
                                        <input type="text" value="<?php echo substr($TPL_VAR["bank_member"], 0, -3) . "*"?>" disabled/>
                                        <p>예금주명은 변경이 불가하며 계좌 변경은 1:1고객센터에 문의하시기 바랍니다.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="input_area">
                                <div class="box_left">
                                    <h3>출금계좌</h3>
                                    <div class="input_box">
                                        <input type="text" value="<?php echo substr($TPL_VAR["bank_account"], 0, -3) . "***"?>" disabled/>
                                        <p>출금계좌는 변경이 불가하며 1:1고객센터에 문의하시기 바랍니다.</p>
                                    </div>
                                </div>
                                <div class="box_left">
                                    <h3>출금비번 *</h3>
                                    <div class="input_box">
                                        <input type="password" id="exchange_pass" name="exchange_pass" value="<?php echo $TPL_VAR["exchange_pass"]?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="input_area">
                                <div class="box_left">
                                    <h3>전화번호</h3>
                                    <div class="input_box">
                                        <?php 
                                            $phone = explode("-", $TPL_VAR["phone"]);
                                        ?>
                                        <input type="text" value="<?php echo $phone[0] . " - " . substr($phone[1], 0, 4) . " - ****"?>" disabled/>
                                        <p>전화번호 변경은 1:1고객센터에 문의하시기 바랍니다.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="input_area">
                                <div class="box_left" style="float:none;margin:0 auto;">
                                    <div class="btn_join">
                                        <button type="button" onClick="dosubmit();">회원정보수정</button>
                                        <button type="button" onClick="location.href='/';">취소</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
<script> 
	function LayerToggle(layer) {
		if(layer.style.display =='none') layer.style.display = 'block';
		else layer.style.display = 'none'
	}

	function dosubmit() {
		if(form1.pass.value=="") {
			warning_popup('현재 비밀번호를 입력하십시오.');
			form1.pass.focus();
			return false;
		}
		if(form1.pass.value.length<4 ||form1.pass.value.length>20) {
			warning_popup("현재 비밀번호를 4 ~ 20자리로 입력하여 주십시오.");
			form1.pass.focus();
			return false;
		}

		if(form1.newpass.value!="") {
			if(form1.newpass.value==""){
				warning_popup('변경 현재 비밀번호를 입력하십시오.');
				form1.newpass.focus();
				return false;
			}
			if(form1.newpass.value.length<4 ||form1.newpass.value.length>20) {
				warning_popup("변경 현재 비밀번호를 4 ~ 20자리로 입력하여 주십시오.");
				form1.newpass2.focus();
				return false;
			}
        }
        form1.submit();
	}
</script>
