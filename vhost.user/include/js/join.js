String.prototype.trim = function() {
	return this.replace(/\s/g, "");
}

function joinAction() {
	//-> 정규식
	var id_check = /^[a-z0-9_]{4,20}$/;
	var num_check = /^[0-9]+$/;
	var kor_check = /[^ㄱ-ㅎ가-힣]/g;

	var uid = $j('#userid').val();
	var nick = $j('#nick').val();
	var upass = $j('#upass').val();
	var confirm_upass = $j('#confirm_upass').val();
	var phone_num = $j('#phone1').val() + "-" + $j('#phone2').val();
	var phone2 = $j('#phone2').val();
	var bank_name = $j('#bank_name').val();
	var bank_account = $j('#bank_account').val();
	var bank_member = $j('#bank_member').val();
	var exchange_pass = $j('#exchange_pass').val();
	//var exchange_pass = "0000";

	if ( uid.length < 4 || uid.length > 20 ) {
		warning_popup("아이디는 4 ~ 20자로 입력해주세요.");
		return false;
	} else {
		if ( id_check.test(uid) ) {
			$j.ajaxSetup({async:false});
			var param = {uid:uid};
			$j.post("/member/addCheckAjax", param, function(result) {
				idCheckFlag = result;
			});
			if ( idCheckFlag == "true" ) {
				warning_popup("입력하신 아이디는 사용할 수 없습니다.\n\n아이디를 변경해주세요.");
				return false;
			}
		} else {
			warning_popup("아이디는 영문+숫자 조합으로만 입력가능합니다.");
			return false;
		}
	}
	if ( nick.length < 2 || nick.length > 12 ) {
		warning_popup("닉네임을 2 ~ 12자로 입력해주세요.");
		return false;
	} else {
		if ( !kor_check.test(nick) ) {
			$j.ajaxSetup({async:false});
			var param = {nick:nick};
			$j.post("/member/addCheckAjax", param, function(result) {
				nickCheckFlag = result;
			});
			if ( nickCheckFlag == "true" ) {
				warning_popup("입력하신 닉네임은 사용할 수 없습니다.\n\n닉네임을 변경해주세요.");
				return false;
			}
		} else {
			warning_popup("닉네임는 한글만 입력가능합니다.");
			return false;
		}
	}
	if ( upass.length < 4 || upass.length > 20 ) {
		warning_popup("비밀번호를 4 ~ 20자로 입력해주세요.");
		return false;
	}		
	if ( confirm_upass.length < 4 || confirm_upass.length > 20 ) {
		warning_popup("비밀번호 확인을 4 ~ 20자로 입력해주세요.");
		return false;
	}
	if ( upass != confirm_upass ) {
		warning_popup("비밀번호와 비밀번호 확인이 일치하지 않습니다.");
		return false;
	}
	if ( !num_check.test(phone2) ) {
		warning_popup("휴대폰 번호를 숫자만 입력해주세요.");
		return false;
	}
	if ( phone_num.length < 12 || phone_num.length > 13 ) {
		warning_popup("휴대폰 번호를 정확하게 입력해주세요.");
		return false;
	}	
	if ( bank_account.length < 7 || !num_check.test(bank_account) ) {
		warning_popup("계좌번호를 정확하게 입력해주세요. (숫자만가능)");
		return false;
	}
	if ( bank_member.length < 2 || bank_member.length > 4 || kor_check.test(bank_member) ) {
		warning_popup("예금주를 정확하게 입력해주세요. (2~4글자 이상, 한글만가능)");
		return false;
	}

	if ( !exchange_pass.length || exchange_pass.length != 4 || !num_check.test(exchange_pass) ) {
		warning_popup("출금비밀번호를 입력해주세요.(숫자 4자리)");
		return false;
	}

	if ( submitFlag == 1 ) {
		warning_popup("회원가입 처리중입니다. 잠시만기다려주세요.");
		return false;
	}

	//submitFlag = 1;
	var param = {"recode":recode, "uid":uid, "nick":nick, "upass":upass, "confirm_upass":confirm_upass, 
								"phone":phone_num, "bank_name":bank_name, "bank_account":bank_account, "bank_member":bank_member, "exchange_pass":exchange_pass, "partnerSn":partnerSn, "recommendUid":recommendUid};

	$j.ajax({
		url : "/member/addProcess",
		data : param,
		type : "post", cache : false, async	: false, timeout : 10000, scriptCharset : "utf-8", dataType : "json",
		success: function(res) {			
			if ( typeof(res) == "object" ) {
				if ( res.result == "ok" ) {
					warning_popup("회원가입이 완료 되었습니다.");
					top.location.href = "/";
				} else {
					warning_popup(res.error_msg);
					submitFlag = 0;
				}
			}
		},
		error: function(xhr,status,error) {
			warning_popup("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
			submitFlag = 0;
		}	
	});
	return false;
}

function parentCodeReset() {
	parentCodeFlag = 0;
}

function parentCodeCheck() {
	var parentCode = $j('#parentCode').val();
	if ( parentCode.length < 2 || parentCode.length > 20 ) {
		warning_popup("CODE를 입력해주세요.");
		return false;
	}

	$j.ajaxSetup({async:false});
	var param = {parent:parentCode};
	$j.post("/member/addCheckAjax", param, function(result) {
		if ( result.trim() == "true" ) {
			parentCodeFlag = 1;
			warning_popup("CODE가 확인되었습니다.");
		} else {
			parentCodeFlag = 0;
			warning_popup("CODE가 정확하지 않습니다.");
		}
	});
}