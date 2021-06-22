<?php

/*
 *인증코드 보내기 함수
 */
 function sms_send($phone,$code)
{
	//'한글이나 특수문자가 들어 있는 값은 urlencode 를 해주세요.특히 msg1 값 또는 resdate 값 등등..
	//'En_msg1 = Server.URLEncode("안녕하세요.문자왕국입니다.")
	//'En_resdate = Server.URLEncode("2004-03-01 00:00:00")

	//'전송 경로
	$url = "http://sms.nicesms.co.kr/cpsms_utf8/cpsms.aspx";
	//'userid (필수) 문자왕국 사용자 ID 
	$userid = "rdw1955";
	//'password (필수) 문자왕국 사용자 패스워드
	$password = "58c6073f83e8e2d04abcb5d5cd9c2131";
	//'msg1 (필수) 전송할 메세지 내용. 내용은 80 byte(영문 80자, 한글 40자)까지 유효합니다. 초과된 메세지는 삭제되어 전송됩니다. 
	$msg1 =URLEncode("[회원가입]인증번호<".$code.">를 입력하세요.");

	//'receivers (필수) 받는 사람 전화 번호 : 숫자만 입력해야 합니다.(예:01022223333) 
	$receivers = $phone;
	//'sender (필수) 보내는 사람 전화 번호 : 숫자만 입력해야 합니다.(예:01022223333) 
	$sender = "123456789";
	//'resflag 예약 전송은 "Y" , 바로 전송은 "N" 을 입력합니다. 생략하면 바로 전송이 됩니다. 
	$resflag = "N";
	//'resdate 예약 전송일 경우 예약 날짜를 입력합니다.(형식 : "2004-03-01 00:00:00"), 예약전송이 아닐 때는 생략 가능. 현재 이후의 시간을 설정해 주세요. 
	$resdate = URLEncode(date("Y-m-d H:i:s"));
	//'returnurl 결과를 받을 url을 입력합니다. 생략했을 경우 현재 요청 페이지에 결과가 출력됩니다. "결과 출력 형식" 참조 
	$returnurl = "";

	$Xurl = $url."?userid=".$userid."&password=".$password."&msgcnt=1&msg1=".$msg1."&receivers=".$receivers."&sender=".$sender."&resflag=".$resflag."&resdate=".$resdate;
	//'Xurl=url
	//'Yurl="userid="&userid&"&password="&password&"&msgcnt=1&msg1="&msg1&"&receivers="&receivers&"&sender="&sender&"&resflag="&resflag&"&resdate="&resdate
	$Retval=array();
	$Retval = GetResultFromURL($Xurl);

	//'결과 출력 형식
	//'returnurl 미지정시
	//'성공 result=OK&success=(전송성공 건수)&fail=(전송실패 건수)&dfree=(하루 한건 무료 건수)&free=(무료 사용 건수)&coupon=(쿠폰 사용 건수)&nicemoney=(나이스머니 사용 건수)&restsms=(남은 총 전송가능 건수) 출력
	//'에러 result=error&errcode=(에러코드)&MSG=(에러메시지) 출력
	//'테스트 result=OK&success=1&fail=0&dfree=0&free=0&coupon=0&nicemoney=1&restsms=327

	/*$arr_sms_result = explode($Retval, "&");
	$arr_result = explode($arr_sms_result[0], "=");
	$result = $arr_result[1];
	$sms_send_ok=$result;*/
	if($Retval['result'] == 'OK')
	{
		return "문자 전송 성공";
	}else {
		/*echo "전송실패";
		echo "실패원인:". $Retval['MSG'];*/
		return "문자 전송에 실패하였습니다.\n\n원인:".$Retval['MSG'];
	}
}

/*
 *내용보내기 함수
 */
 function sms_send_msg($phone,$msg)
{
	//'한글이나 특수문자가 들어 있는 값은 urlencode 를 해주세요.특히 msg1 값 또는 resdate 값 등등..
	//'En_msg1 = Server.URLEncode("안녕하세요.문자왕국입니다.")
	//'En_resdate = Server.URLEncode("2004-03-01 00:00:00")

	//'전송 경로
	$url = "http://sms.nicesms.co.kr/cpsms_utf8/cpsms.aspx";
	//'userid (필수) 문자왕국 사용자 ID 
	$userid = "rdw1955";
	//'password (필수) 문자왕국 사용자 패스워드
	$password = "58c6073f83e8e2d04abcb5d5cd9c2131";
	//'msg1 (필수) 전송할 메세지 내용. 내용은 80 byte(영문 80자, 한글 40자)까지 유효합니다. 초과된 메세지는 삭제되어 전송됩니다. 
	$msg1 =URLEncode($msg);

	//'receivers (필수) 받는 사람 전화 번호 : 숫자만 입력해야 합니다.(예:01022223333) 
	$receivers = $phone;
	//'sender (필수) 보내는 사람 전화 번호 : 숫자만 입력해야 합니다.(예:01022223333) 
	$sender = "123456789";
	//'resflag 예약 전송은 "Y" , 바로 전송은 "N" 을 입력합니다. 생략하면 바로 전송이 됩니다. 
	$resflag = "N";
	//'resdate 예약 전송일 경우 예약 날짜를 입력합니다.(형식 : "2004-03-01 00:00:00"), 예약전송이 아닐 때는 생략 가능. 현재 이후의 시간을 설정해 주세요. 
	$resdate = URLEncode(date("Y-m-d H:i:s"));
	//'returnurl 결과를 받을 url을 입력합니다. 생략했을 경우 현재 요청 페이지에 결과가 출력됩니다. "결과 출력 형식" 참조 
	$returnurl = "";

	$Xurl = $url."?userid=".$userid."&password=".$password."&msgcnt=1&msg1=".$msg1."&receivers=".$receivers."&sender=".$sender."&resflag=".$resflag."&resdate=".$resdate;
	//'Xurl=url
	//'Yurl="userid="&userid&"&password="&password&"&msgcnt=1&msg1="&msg1&"&receivers="&receivers&"&sender="&sender&"&resflag="&resflag&"&resdate="&resdate
	$Retval=array();
	$Retval = GetResultFromURL($Xurl);

	//'결과 출력 형식
	//'returnurl 미지정시
	//'성공 result=OK&success=(전송성공 건수)&fail=(전송실패 건수)&dfree=(하루 한건 무료 건수)&free=(무료 사용 건수)&coupon=(쿠폰 사용 건수)&nicemoney=(나이스머니 사용 건수)&restsms=(남은 총 전송가능 건수) 출력
	//'에러 result=error&errcode=(에러코드)&MSG=(에러메시지) 출력
	//'테스트 result=OK&success=1&fail=0&dfree=0&free=0&coupon=0&nicemoney=1&restsms=327

	/*$arr_sms_result = explode($Retval, "&");
	$arr_result = explode($arr_sms_result[0], "=");
	$result = $arr_result[1];
	$sms_send_ok=$result;*/
	if($Retval['result'] == 'OK')
	{
		return "문자 전송 성공";
	}else {
		/*echo "전송실패";
		echo "실패원인:". $Retval['MSG'];*/
		return "문자 전송에 실패하였습니다.\\n\\n원인:".$Retval['MSG'];
	}
}

  function GetResultFromURL($url)      // 지정 URL로 요청을 보내고 브라우저에 출력된 결과값을 가져옴
  {
   
    $result = file_get_contents($url);

    //------------------------------------------------------	

    $result = trim($result);

    parse_str($result, $arrayResult);

    return $arrayResult;
  }
?>