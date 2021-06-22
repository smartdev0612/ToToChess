<?
/**
 * 
 */ 
class Lemon_Email{
	
	/*
	 * 일반적인 메일 전송 - 화이트 도메인으로 등록 안되어 있을 경우 다음, 구글 등 특정 메일로는 전송이 안된다
	 */
	function send($from, $to, $subject, $mail_body) {
		$header = "MIME-Version: 1.0\r\nContent-type: text/plain;charset=UTF-8\r\nFrom: $from\r\n";
		$subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
		if(mail($to, $subject, $mail_body, $header, '-f'.$from))
			return true;
		else 
			return false;
	}
	
	/*
	 * 구글을 이용한 매일 전송 - 화이트 도메인이므로 어떤 메일 서비스 업체에게도 전부 전송 된다
	 */
	function sendByGoogle($fromEmail,$to,$subject,$body){
	    
		$isSend = true;
	    
		$m = new MAIL5;
		$m->From($fromEmail);
		$m->AddTo($to);
		$m->Subject($subject);
		$m->Html($body, 'UTF-8');
		
		// 구글 로그인
		$c = $m->Connect('smtp.gmail.com', 465, 'master@allthatstars.co.kr', 'ring0408', 'tls', 10, 'localhost', null, 'plain') or die(print_r($m->Result));
		
		if(!$m->Send($c)){
			$isSend = false;
		}
		
		$m->Disconnect();
		
		return $isSend;
	}
}
?>
