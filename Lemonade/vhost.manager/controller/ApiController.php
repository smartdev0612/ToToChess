<?php 
class ApiController extends WebServiceController {

    function bal_configAction() {
        $this->commonDefine();
        $this->view->define("content","content/api/bal_config.html");

        if ( !$this->auth->isLogin() ) {
            $this->redirect("/login");
            exit;
        }

        $apiModel = $this->getModel("ApiModel");
        $balanceInfo = $apiModel->get_balance_setting('sadari');
        $sadariRate = $apiModel->get_sadari_rate();

        $this->view->assign('balanceInfo', $balanceInfo);
        $this->view->assign('sadariRate', $sadariRate);
        $this->display();
    }

    function bal_config_dariAction() {
        $this->commonDefine();
        $this->view->define("content","content/api/bal_config_dari.html");

        if ( !$this->auth->isLogin() ) {
            $this->redirect("/login");
            exit;
        }

        $apiModel = $this->getModel("ApiModel");
        $balanceInfo = $apiModel->get_balance_setting('dari');
        $sadariRate = $apiModel->get_dari_rate();

        $this->view->assign('balanceInfo', $balanceInfo);
        $this->view->assign('sadariRate', $sadariRate);
        $this->display();
    }

    function bal_config_pbAction() {
        $this->commonDefine();
        $this->view->define("content","content/api/bal_config_pb.html");

        if ( !$this->auth->isLogin() ) {
            $this->redirect("/login");
            exit;
        }

        $apiModel = $this->getModel("ApiModel");
        $balanceInfo = $apiModel->get_balance_setting('power');
        $sadariRate = $apiModel->get_pwball_rate();

        $this->view->assign('balanceInfo', $balanceInfo);
        $this->view->assign('sadariRate', $sadariRate);
        $this->display();
    }

    function bal_realtimeAction() {
        $this->commonDefine();
        $this->view->define("content","content/api/bal_realtime.html");

        if ( !$this->auth->isLogin() ) {
            $this->redirect("/login");
            exit;
        }

        $apiModel = $this->getModel("ApiModel");

        $this->display();
    }

    function bal_realtime_dariAction() {
        $this->commonDefine();
        $this->view->define("content","content/api/bal_realtime_dari.html");

        if ( !$this->auth->isLogin() ) {
            $this->redirect("/login");
            exit;
        }

        $apiModel = $this->getModel("ApiModel");

        $this->display();
    }

    function bal_realtime_pbAction() {
        $this->commonDefine();
        $this->view->define("content","content/api/bal_realtime_pb.html");

        if ( !$this->auth->isLogin() ) {
            $this->redirect("/login");
            exit;
        }

        $apiModel = $this->getModel("ApiModel");

        $this->display();
    }

    function get_realtimeAction() {

        $ajaxResult = array();
        $type = trim($_POST["type"]);

        $apiModel = $this->getModel("ApiModel");
        $balanceInfo = $apiModel->get_balance_setting($type);

        $bal_id = $balanceInfo["id"];
        $bal_pw = $balanceInfo["passwd"];
        $bal_domain = $balanceInfo["domain"];


        $special = 3;
        if($type == 'dari')
        {
            $special = 8;
        }
        else if($type == 'power')
        {
            $special = 7;
        }

        $ajaxResult["bal_id"] = $bal_id;
        $ajaxResult["bal_type"] = $balanceInfo["bal_type"];
        $ajaxResult["bal_useFlag"] = $balanceInfo["use_flag"];

        /*$getData = json_encode(array("id"=>$bal_id, "pw"=>$bal_pw));
        $enData = $this->data_to_mcrypt($getData, "encode");
        $jsonData = json_decode(@file_get_contents("http://{$bal_domain}/api/balance_info?data={$enData}"),true);
        if ( !count($jsonData) ) {
            $ajaxResult["top_error_msg"] = "API 연결 불가. (도메인 확인)";
        } else {
            $ajaxResult["top_result"] = $jsonData["result"];
            $ajaxResult["top_error_msg"] = $jsonData["error_msg"];
            $ajaxResult["top_money"] = $jsonData["money"]+0;
            $ajaxResult["top_parent_per"] = $jsonData["parent_per"];
            $ajaxResult["top_sadari_rate"] = $jsonData["sadari_rate"];
        }*/
        $ajaxResult["top_sadari_rate"] = 1.95;
        $ajaxResult["top_dari_rate"] = 1.95;
        $ajaxResult["top_power_rate"] = 1.95;
        //-> 현사이트 사다리 배당.
        $ajaxResult["sadari_rate"] = $apiModel->get_sadari_rate();
        $ajaxResult["dari_rate"] = $apiModel->get_dari_rate();
        $ajaxResult["power_rate"] = $apiModel->get_pwball_rate();

        //-> 사다리 현재 회차 정보
        if($type == 'sadari')
        {
            $lastGameInfo = $this->getLastGameInfo();
            $id_oe = "s_oe";
            $id_lr = "s_lr";
            $id_34 = "s_34";
        }
        else if($type == 'dari')
        {
            $lastGameInfo = $this->getDariLastGameInfo();
            $id_oe = "d_oe";
            $id_lr = "d_lr";
            $id_34 = "d_34";
        }
        else if($type == 'power')
        {
            $lastGameInfo = $this->getPowerBallLastGameInfo();
            $id_oe = "p_n-oe";
            $id_lr = "p_eo-unover";
            $id_34 = "p_p-oe";
        }

        $gameDate = $lastGameInfo["gameYmd"];
        $gameTh = $lastGameInfo["gameTh"];

        $data_odd = $apiModel->get_betting_money($special, $gameDate, $gameTh, $id_oe, 1);	//-> 홀
        $sum_odd = $data_odd["money"];
        $sum_odd_cnt = $data_odd["count"];

        $data_even = $apiModel->get_betting_money($special, $gameDate, $gameTh, $id_oe, 2);	//-> 짝
        $sum_even = $data_even["money"];
        $sum_even_cnt = $data_even["count"];

        $data_left = $apiModel->get_betting_money($special, $gameDate, $gameTh, $id_lr, 1);	//-> 좌
        $sum_left = $data_left["money"];
        $sum_left_cnt = $data_left["count"];

        $data_right = $apiModel->get_betting_money($special, $gameDate, $gameTh, $id_lr, 2);	//-> 우
        $sum_right = $data_right["money"];
        $sum_right_cnt = $data_right["count"];

        $data_3line = $apiModel->get_betting_money($special, $gameDate, $gameTh, $id_34, 1);	//-> 3줄
        $sum_3line = $data_3line["money"];
        $sum_3line_cnt = $data_3line["count"];

        $data_4line = $apiModel->get_betting_money($special, $gameDate, $gameTh, $id_34, 2);	//-> 4줄
        $sum_4line = $data_4line["money"];
        $sum_4line_cnt = $data_4line["count"];

        //-> 발란스 배팅 내역
        $balanceData = $apiModel->get_balance_data($type, $gameDate,$gameTh);
        if ($balanceData == null || !count($balanceData) or !$balanceData["game_th"] ) {
            $ajaxResult["btData"] = 0;
        } else {
            $ajaxResult["balData"] = $balanceData;
        }

        $ajaxResult["sadari_gameDate"] = $gameDate;
        $ajaxResult["sadari_gameTh"] = $gameTh;
        $ajaxResult["sadari_limitSec"] = $lastGameInfo["limitSec"];
        $ajaxResult["dari_gameDate"] = $gameDate;
        $ajaxResult["dari_gameTh"] = $gameTh;
        $ajaxResult["dari_limitSec"] = $lastGameInfo["limitSec"];
        $ajaxResult["sum_odd"] = $sum_odd;
        $ajaxResult["sum_odd_cnt"] = $sum_odd_cnt;
        $ajaxResult["sum_even"] = $sum_even;
        $ajaxResult["sum_even_cnt"] = $sum_even_cnt;
        $ajaxResult["sum_left"] = $sum_left;
        $ajaxResult["sum_left_cnt"] = $sum_left_cnt;
        $ajaxResult["sum_right"] = $sum_right;
        $ajaxResult["sum_right_cnt"] = $sum_right_cnt;
        $ajaxResult["sum_3line"] = $sum_3line;
        $ajaxResult["sum_3line_cnt"] = $sum_3line_cnt;
        $ajaxResult["sum_4line"] = $sum_4line;
        $ajaxResult["sum_4line_cnt"] = $sum_4line_cnt;

        $result = json_encode($ajaxResult);
        echo $result;
        exit;
    }

    function bal_betlogAction() {
        $this->commonDefine();
        $this->view->define("content","content/api/bal_betlog.html");

        if ( !$this->auth->isLogin() ) {
            $this->redirect("/login");
            exit;
        }

        $apiModel = $this->getModel("ApiModel");

        $searchDate	= $this->request("searchDate");
        if ( !$searchDate ) {
            $searchDate = date("Y-m-d",time());
        }
        $logList = $apiModel->get_log_list('sadari', $searchDate);

        $this->view->assign('searchDate', $searchDate);
        $this->view->assign('logList', $logList);
        $this->display();
    }

    function bal_betlog_dariAction() {
        $this->commonDefine();
        $this->view->define("content","content/api/bal_betlog_dari.html");

        if ( !$this->auth->isLogin() ) {
            $this->redirect("/login");
            exit;
        }

        $apiModel = $this->getModel("ApiModel");

        $searchDate	= $this->request("searchDate");
        if ( !$searchDate ) {
            $searchDate = date("Y-m-d",time());
        }
        $logList = $apiModel->get_log_list('dari', $searchDate);

        $this->view->assign('searchDate', $searchDate);
        $this->view->assign('logList', $logList);
        $this->display();
    }

    function bal_betlog_pbAction() {
        $this->commonDefine();
        $this->view->define("content","content/api/bal_betlog_pb.html");

        if ( !$this->auth->isLogin() ) {
            $this->redirect("/login");
            exit;
        }

        $apiModel = $this->getModel("ApiModel");

        $searchDate	= $this->request("searchDate");
        if ( !$searchDate ) {
            $searchDate = date("Y-m-d",time());
        }
        $logList = $apiModel->get_log_list('power', $searchDate);

        $this->view->assign('searchDate', $searchDate);
        $this->view->assign('logList', $logList);
        $this->display();
    }

    //-> 발란스 옵션 저장.
    function save_configAction() {
        $ajaxResult = array();
        $ajaxResult["result"]	= "error";

        if ( !$this->auth->isLogin() ) {
            echo json_encode(array("error_msg"=>"로그인 정보가 없습니다. 재로그인 해주세요."));
            exit;
        }

        $apiModel = $this->getModel("ApiModel");

        $domain = trim($_POST["domain"]);
        $bal_id = trim($_POST["bal_id"]);
        $bal_passwd = trim($_POST["bal_passwd"]);
        $bal_type = 'all'; //trim($_POST["bal_type"]);
        $use_flag = trim($_POST["use_flag"]);
        $type = trim($_POST["type"]);

        if ( !$domain or !$bal_id or !$bal_passwd ) {
            echo json_encode(array("error_msg"=>"사이트, 아이디, 패스워드를 정확하게 입력해주세요."));
            exit;
        }

        $apiModel->up_balance_setting($type, $domain, $bal_id, $bal_passwd, $bal_type, $use_flag);
        echo json_encode(array("result"=>"ok"));
        exit;
    }

    //-> 상부 사이트 정보 추출.
    function top_balance_infoAction() {
        $ajaxResult = array();
        $ajaxResult["result"]	= "error";

        if ( !$this->auth->isLogin() ) {
            echo json_encode(array("error_msg"=>"로그인 정보가 없습니다. 재로그인 해주세요."));
            exit;
        }

        $domain = trim($_POST["domain"]);
        $bal_id = trim($_POST["bal_id"]);
        $bal_passwd = trim($_POST["bal_passwd"]);
        if ( !$domain or !$bal_id or !$bal_passwd ) {
            echo json_encode(array("error_msg"=>"사이트, 아이디, 패스워드를 정확하게 입력해주세요."));
            exit;
        }

        $getData = json_encode(array("id"=>$bal_id, "pw"=>$bal_passwd));
        $enData = $this->data_to_mcrypt($getData, "encode");
        $jsonData = @file_get_contents("http://{$domain}/api/balance_info?data={$enData}");
        if ( !$jsonData ) {
            echo json_encode(array("error_msg"=>"API 연결 불가. (도메인 확인)"));
            exit;
        }
        echo $jsonData;
    }

    //-> 데이터 암호화
    function data_to_mcrypt($data, $type) {
        $key = "wT65gowG2Hwdov5WWWdo6slxl";

        if ( $type == "encode" ) {
            $data = urlencode(trim($data));
            $encrypted_data_on_binary = mcrypt_ecb (MCRYPT_SERPENT, $key, $data, MCRYPT_ENCRYPT);
            $encrypted_data = base64_encode($encrypted_data_on_binary);
            return urlencode($encrypted_data);
        } else if ( $type == "decode" ) {
            $decrypted_data_on_binary = base64_decode(urldecode($data));
            $plain_data = mcrypt_ecb (MCRYPT_SERPENT, $key, $decrypted_data_on_binary, MCRYPT_DECRYPT);
            return trim(urldecode($plain_data));
        }
    }

    //-> 현재 진행중인 회차/날짜/배팅가능시간 정보를 가져옴.
    public function getLastGameInfo() {
        $yyyy = date("Y");
        $mm = date("m");
        $dd = date("d");
        $hour = date("H");
        $min = date("i");
        $sec = date("s");

        $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
        $gameTh = floor($secTemp / 300) + 1;
        $limitSec = ($gameTh * 300) - $secTemp;

        $gameYmd = date("Y-m-d",time()+$limitSec);
        $gameH = date("H",time()+$limitSec);
        $gameI = date("i",time()+$limitSec);
        $gameS = date("s",time()+$limitSec);

        if ( $gameTh == "288" ) {
            $gameYmd = date("Y-m-d",time()-300);
            $gameH = "23";
            $gameI = "59";
        }

        return array("gameTh"=>$gameTh,"gameYmd"=>$gameYmd,"gameH"=>$gameH,"gameI"=>$gameI,"gameS"=>$gameS,"limitSec"=>$limitSec);
    }

    public function getDariLastGameInfo() {
        $yyyy = date("Y");
        $mm = date("m");
        $dd = date("d");
        $hour = date("H");
        $min = date("i");
        $sec = date("s");

        $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
        $gameTh = floor($secTemp / 180) + 1;
        $limitSec = ($gameTh * 180) - $secTemp;

        $gameYmd = date("Y-m-d",time()+$limitSec);
        $gameH = date("H",time()+$limitSec);
        $gameI = date("i",time()+$limitSec);
        $gameS = date("s",time()+$limitSec);

        if ( $gameTh == "480" ) {
            $gameYmd = date("Y-m-d",time()-180);
            $gameH = "23";
            $gameI = "59";
        }

        return array("gameTh"=>$gameTh,"gameYmd"=>$gameYmd,"gameH"=>$gameH,"gameI"=>$gameI,"gameS"=>$gameS,"limitSec"=>$limitSec);
    }

    public function getPowerBallLastGameInfo() {
        $yyyy = date("Y");
        $mm = date("m");
        $dd = date("d");
        $hour = date("H");
        $min = date("i");
        $sec = date("s");

        $powerStartTime = "1293883470";
        $gameTh = floor((time() - $powerStartTime) / 300);
        $limitSec = $powerStartTime + (($gameTh+1) * 300) - time();

        $gameYmd = date("Y-m-d",time()+$limitSec);
        $gameH = date("H",time()+$limitSec);
        $gameI = date("i",time()+$limitSec);
        $gameS = date("s",time()+$limitSec);

        $limitSec = $limitSec - 12;

        return array("gameTh"=>$gameTh,"gameYmd"=>$gameYmd,"gameH"=>$gameH,"gameI"=>$gameI,"gameS"=>$gameS,"limitSec"=>$limitSec);
    }

    public function sadariBetAction()
    {
        $id = $this->request("id");
        $date = $this->request("date");
        $cnt = $this->request("cnt");
        $bet1 = $this->request("bet1");
        $bet2 = $this->request("bet2");
        $bet3 = $this->request("bet3");
        $money1 = $this->request("money1");
        $money2 = $this->request("money2");
        $money3 = $this->request("money3");

        $url = "http://www.joy-vip.com/api/ladder.php?id=".$id."&date=".$date."&cnt=".$cnt
            ."&bet1=".$bet1."&bet2=".$bet2."&bet3=".$bet3."&money1=".$money1."&money2=".$money2
            ."&money3=".$money3;

        $results = $this->fetch($url);

        echo $results;
    }

    public function dariBetAction()
    {
        $id = $this->request("id");
        $date = $this->request("date");
        $cnt = $this->request("cnt");
        $bet1 = $this->request("bet1");
        $bet2 = $this->request("bet2");
        $bet3 = $this->request("bet3");
        $money1 = $this->request("money1");
        $money2 = $this->request("money2");
        $money3 = $this->request("money3");

        $url = "http://www.joy-vip.com/api/dari.php?id=".$id."&date=".$date."&cnt=".$cnt
            ."&bet1=".$bet1."&bet2=".$bet2."&bet3=".$bet3."&money1=".$money1."&money2=".$money2
            ."&money3=".$money3;

        $results = $this->fetch($url);

        echo $results;
    }

    public function powerBetAction()
    {
        $id = $this->request("id");
        $cnt = $this->request("cnt");
        $bet1 = $this->request("bet1");
        $bet2 = $this->request("bet2");
        $bet3 = $this->request("bet3");
        $money1 = $this->request("money1");
        $money2 = $this->request("money2");
        $money3 = $this->request("money3");

        $url = "http://www.joy-vip.com/api/pb.php?id=".$id."&cnt=".$cnt
            ."&bet1=".$bet1."&bet2=".$bet2."&bet3=".$bet3."&money1=".$money1."&money2=".$money2
            ."&money3=".$money3;

        $results = $this->fetch($url);

        echo $results;
    }

    function fetch($url)
    {
        $base_url = "http://www.joy-vip.com/";
        $header = array(
            "Content-Type:application/x-www-form-urlencoded",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36",
            "Accept-Language: ko-KR,ko;q=0.8,en-US;q=0.6,en;q=0.4",
            "Referer: " . $base_url
        );

        $defaults = array(
            CURLOPT_POST => 0,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_SSL_VERIFYPEER => false
        );
        $ch = curl_init();
        curl_setopt_array($ch, $defaults);

        $result = curl_exec($ch);

        return $result;
    }
}
?>