<?
		require "./gsms_msg.php";
		require "./gsms_class.php";

		$gsmsSocket = new Request();
		
		$tran_id				= "tlscjdwjdqh";
		$tran_passwd		= "tlscjdwjdqh1";
		$tran_phone			= $_REQUEST["phone_num"];
		$tran_callback	= "1004";
		$tran_date			= 0;
		$tran_msg				= rand(400000, 499999);

		$gsmsSocket->cTranid = $tran_id;
		$gsmsSocket->cTranpasswd = $tran_passwd;
		$gsmsSocket->cTranphone = $tran_phone;
		$gsmsSocket->cTrancallback = $tran_callback;
		$gsmsSocket->cTrandate = $tran_date;
		$gsmsSocket->cTranmsg = $tran_msg;

		$Response = $gsmsSocket->Submit();
		
		echo 'reponse='.$Response;

		$gsmsSocket->Destroy();
		unset($gsmsSocket);
    unset($Response);
?>
