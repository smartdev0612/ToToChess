<?php


class EtcModel extends Lemon_Model 
{	
	function getLogoList()
	{
		$sql = "select * from logolist order by sn";
		
		return $this->db->exeSql($sql);							
	}
	
	//▶ 탑메뉴 리플레시 
	function getPartnerRefresh($id)
	{
		$array = array();
		$sql = "select count(*)as tot_cnt,newreadnum 
							from ".$this->db_qz."memoboard 
								where kubun=1 and isdelete!=1 and logo='".$this->logo."' and toid='".$id."' 
									group by newreadnum";

		$rs = $this->db->exeSql($sql);
		
		if($rs[0]["newreadnum"]==1)
		{
			$newreadnum = $rs[0]["tot_cnt"];
		}else if($rs[0]["newreadnum"]==0)
		{
			$newweinum = $rs[0]["tot_cnt"];
		}
		
		if(is_null($newreadnum) || $newreadnum=="")
		{
			$newreadnum=0;
		}
		if(is_null($newweinum) || $newweinum=="")
		{
			$newweinum=0;
		}
		
		$total = $newweinum+$newreadnum;
		
		$array[]=$id."@@@".$newweinum."@@@".$total;
		
		echo $array[0];

	}

	function getUnreadMemoCnt($id) {
		$sql = "select count(*) as tot_cnt 
				from ".$this->db_qz."memoboard 
				where kubun = 1 and isdelete != 1 and newreadnum = 0 and logo = '".$this->logo."' and toid='".$id."'";

		$rs = $this->db->exeSql($sql);

		$cnt = 0;
		if(count((array)$rs) > 0)
			$cnt = $rs[0]["tot_cnt"];

		return $cnt;
	}
	
	//▶ 탑메뉴 리플레시
	function getRefresh()
	{
		//-> 회원가입 / 게시판등록 / 타입별 배팅수
		$sql = "select * from ".$this->db_qz."alarm_flag";
		$rs = $this->db->exeSql($sql);
		$joinAlarm = $rs[0]['new_member']+0;
		$contentAlarm = $rs[0]['new_content']+0;
		$sportAlarm = $rs[0]['betting_sport']+0;
		$realtimeAlarm = $rs[0]['betting_realtime']+0;
		$liveAlarm = $rs[0]['betting_live']+0;
		$sport2Alarm = $rs[0]['betting_sport_m']+0;
		$sadariAlarm = $rs[0]['betting_sadari']+0;
		$dariAlarm = $rs[0]['betting_dari']+0;
		$raceAlarm = $rs[0]['betting_race']+0;
		$powerAlarm = $rs[0]['betting_powerball']+0;
		$lowhiAlarm = $rs[0]['betting_lowhi']+0;
        $aladinAlarm = $rs[0]['betting_aladin']+0;
        $mgmoddevenAlarm = $rs[0]['betting_mgmoddeven']+0;
        $mgmbacaraAlarm = $rs[0]['betting_mgmbacara']+0;
        $vfootballAlarm = $rs[0]['betting_vfootball']+0;
        $kenosadariAlarm = $rs[0]['betting_kenosadari']+0;
        $powersadariAlarm = $rs[0]['betting_powersadari']+0;
        $nineAlarm = $rs[0]['betting_nine']+0;
        $twodariAlarm = $rs[0]['betting_2dari']+0;
        $threedariAlarm = $rs[0]['betting_3dari']+0;
        $choiceAlarm = $rs[0]['betting_choice']+0;
        $rouletteAlarm = $rs[0]['betting_roulette']+0;
        $pharaohAlarm = $rs[0]['betting_pharaoh']+0;
        $fxAlarm = $rs[0]['betting_fx']+0;

		$sportBigAlarm = $rs[0]['betting_sport_big']+0;
		$sport2BigAlarm = $rs[0]['betting_sport_m_big']+0;
		$realtimeBigAlarm = $rs[0]['betting_realtime_big']+0;
		$liveBigAlarm = $rs[0]['betting_live_big']+0;
		$sadariBigAlarm = $rs[0]['betting_sadari_big']+0;
		$dariBigAlarm = $rs[0]['betting_dari_big']+0;
		$raceBigAlarm = $rs[0]['betting_race_big']+0;
		$powerBigAlarm = $rs[0]['betting_powerball_big']+0;
		$lowhiBigAlarm = $rs[0]['betting_lowhi_big']+0;
        $aladinBigAlarm = $rs[0]['betting_aladin_big']+0;
        $mgmoddevenBigAlarm = $rs[0]['betting_mgmoddeven_big']+0;
        $mgmbacaraBigAlarm = $rs[0]['betting_mgmbacara_big']+0;
        $vfootballBigAlarm = $rs[0]['betting_vfootball_big']+0;
        $kenosadariBigAlarm = $rs[0]['betting_kenosadari_big']+0;
        $powersadariBigAlarm = $rs[0]['betting_powersadari_big']+0;
        $nineBigAlarm = $rs[0]['betting_nine_big']+0;
        $twodariBigAlarm = $rs[0]['betting_2dari_big']+0;
        $threedariBigAlarm = $rs[0]['betting_3dari_big']+0;
        $choiceBigAlarm = $rs[0]['betting_choice_big']+0;
        $rouletteBigAlarm = $rs[0]['betting_roulette_big']+0;
        $pharaohBigAlarm = $rs[0]['betting_pharaoh_big']+0;
        $fxBigAlarm = $rs[0]['betting_fx_big']+0;
	
		//-> 고객센터
		$sql = "select idx, is_read from tb_question where result = 0 and reply = 0";
		$rs = $this->db->exeSql($sql);
		$questionSn = $rs[0]['idx']+0;
		$questionAlarm = count((array)$rs)+0;

		//-> 총판쪽지
		$sql = "select count(mem_idx) as cnt from tb_memoboard where toid = '운영팀' and newreadnum = 0 and p_type = 2";
		$rs = $this->db->exeSql($sql);
		$partner_memo_cnt = $rs[0]['cnt'];

		//-> 부본사쪽지
		$sql = "select count(mem_idx) as cnt from tb_memoboard where toid = '운영팀' and newreadnum = 0 and p_type = 1";
		$rs = $this->db->exeSql($sql);
		$agent_memo_cnt = $rs[0]['cnt'];

		//-> 총판 출금 신청
		$sql = "select count(sn) as cnt from tb_recommend_money_log where proc_flag = 0";
		$rs = $this->db->exeSql($sql);
		$recExchangeAlarm = $rs[0]['cnt']+0;
	
		//-> 출금신청
		$sql = "select count(sn) as cnt from tb_exchange_log where state = 0";
		$rs = $this->db->exeSql($sql);
		$exchangeAlarm = $rs[0]['cnt']+0;

		//-> 입금신청
		$sql = "select count(sn) as cnt from tb_charge_log where state = 0";
		$rs = $this->db->exeSql($sql);
		$chargeAlarm = $rs[0]['cnt']+0;

		//-> 파싱 알람.
		$sql = "select * from parsing_status";
		$rs = $this->db->exeSql($sql);
		$new_games = $rs[0]['new_game']+0;
		$new_rates = $rs[0]['new_rate']+0;
		$new_dates = $rs[0]['new_date']+0;
		$new_results = $rs[0]['new_result']+0;

		//-> 서버에 세션중 용량이 0바이트 이상인것들만 가져와 IN쿼리를 실행 할 수 있또록 문자열을 만든다.
		// @exec("find C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\m.vhost.user\\session -size +1c",$sessionList_mobile);
		// unset($sessionList_mobile[0]);
		// @exec("find C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\vhost.user\\session -size +1c",$sessionList_pc);
		// unset($sessionList_pc[0]);

		$sessionList = array();
		$sessionList_mobile = array();
		$sessionList_pc = array();

		$path    = "C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\m.vhost.user\\session\\";
		$temp_mobile = scandir($path);
		$temp_mobile = array_diff(scandir($path), array('.', '..'));
		foreach($temp_mobile as $file) {
			if(filesize($path . $file) > 0) {
				$pieces = explode("_", $file);
				array_push($sessionList_mobile, $pieces[1]);
			}
		}
		
		$path    = "C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\vhost.user\\session\\";
		$temp_pc = scandir($path);
		$temp_pc = array_diff(scandir($path), array('.', '..'));
		foreach($temp_pc as $file) {
			if(filesize($path . $file) > 0) {
				$pieces = explode("_", $file);
				array_push($sessionList_pc, $pieces[1]);
			}
		}

		$sessionList = array_merge($sessionList_mobile,$sessionList_pc);

		if ( count($sessionList) > 0 ) {
            //$sessionListStr = "'".str_replace("C:\xampp\htdocs\gadget\www_gadget_o2_lsports.com\vhost.user\session/sess_","",implode("','",$sessionList))."'";
            // $sessionListStr = "'".str_replace("C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\vhost.user\\session\\sess_","",
            //         str_replace("C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\m.vhost.user\\session\\sess_","",implode("','",$sessionList)))."'";
			$sessionListStr = "'" . implode("','", $sessionList) . "'";

			//-> DB에 저장된 5분 미만 페이지 로딩한 회원들을 서버 세션과 비교해서 동접을 확인한다.
			$ckTime = date("Y-m-d H:i:s",time()-600);
			$sql = "select count(sn) as connect_cnt from tb_member where page_load_date > '{$ckTime}' and sessionid IN ({$sessionListStr})";
			$rs = $this->db->exeSql($sql);			
		}
		$connectCnt = $rs[0]['connect_cnt']+0;

        $sql = "select count(*) as login_fail_count from tb_visit where status=1 and is_read = 0;";
        $rs = $this->db->exeSql($sql);
        $login_fail = $rs[0]['login_fail_count'];

		$returnStr = $joinAlarm."||".$questionAlarm."||".$questionSn."||".$recExchangeAlarm."||".$exchangeAlarm."||".$chargeAlarm."||".$contentAlarm."||".$new_games."||".$new_rates."||".$new_dates."||".$new_results."||";
		$returnStr .= $sportAlarm."||".$sadariAlarm."||".$dariAlarm."||".$raceAlarm."||".$powerAlarm."||".$lowhiAlarm."||".$aladinAlarm."||".$mgmoddevenAlarm."||".$mgmbacaraAlarm."||"
                     .$sportBigAlarm."||".$sadariBigAlarm."||".$dariBigAlarm."||".$raceBigAlarm."||".$powerBigAlarm."||".$lowhiBigAlarm."||".$aladinBigAlarm."||".$mgmoddevenBigAlarm."||".$mgmbacaraBigAlarm."||"
                     .$kenosadariAlarm."||".$kenosadariBigAlarm."||".$powersadariAlarm."||".$powersadariBigAlarm."||".$vfootballAlarm."||".$vfootballBigAlarm."||"
                     .$nineAlarm."||".$nineBigAlarm."||".$twodariAlarm."||".$twodariBigAlarm."||".$threedariAlarm."||".$threedariBigAlarm."||"
                     .$choiceAlarm."||".$choiceBigAlarm."||".$rouletteAlarm."||".$rouletteBigAlarm."||".$pharaohAlarm."||".$pharaohBigAlarm."||".$fxAlarm."||".$fxBigAlarm."||"
                     .$connectCnt."||".$login_fail."||".$sport2Alarm."||".$sport2BigAlarm."||".$liveAlarm."||".$liveBigAlarm."||".$partner_memo_cnt."||".$agent_memo_cnt."||".$realtimeAlarm."||".$realtimeBigAlarm;
		
		return $returnStr;
	}
	
	//-> 파싱정보 초기화
	function updateParsingStatus($field = "new_game") {
		$sql = "update parsing_status set ".$field." = '0'";
		return $this->db->exeSql($sql);
	}

	//▶ 아이피를 통한 국가명 검색
	function getNationByIp($ip)
	{
		$sql = "select country_code
				from ".$this->db_qz."ip_group_country 
					where ip_start <= INET_ATON( '".$ip."' ) 
						order by ip_start desc limit 1 ";
						
		$rs = $this->db->exeSql($sql);
		return $rs[0]['country_code'];
	}
	
	//▶ 레벨 정보
	function getLevel()
	{
		$sql = "select lev, lev_name from ".$this->db_qz."level_config 
					where logo='".$this->logo."'";
					
		return $this->db->exeSql($sql);
	}
	
	function getLevelName($level)
	{
		if ( !$level ) $level = 1;
		$sql = "select lev_name from ".$this->db_qz."level_config
					where lev=".$level;
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['lev_name'];
	}
	
	//▶ 멤버레벨
	function getMemberLevRow($level, $field)
	{
		$where = "lev=".$level." and logo='".$this->logo."'";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRow($field, $this->db_qz.'level_config', $where);
	}

	//▶ 멤버레벨 미니게임
	function getMemberLevRowMiniGame($level) {
		$where = "user_level = ".$level;		
		return $this->getRow("*", "tb_level_config_minigame", $where);
	}
	
	//▶ 레벨 설정 변경
	function modifyLevelConfig($value, $levelName, $levelMin, $levelMax, $levelBonus)
	{
		$sql = "update ".$this->db_qz."level_config 
				set lev_name='".$levelName."',lev_min_money='".$levelMin."',lev_max_money='".$levelMax."',lev_max_bouns='".$levelBonus."' 
					where id='".$value."' and logo='".$lthis->ogo."'";
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 유저 접속횟수
	function visitCount($memberId)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."visit where member_id='".$memberId."'";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 아이피 차단해제
	function revokeIp($ip)
	{
		$sql = "update sql_sqlin 
				set  Kill_ip=NULL 
					where SqlIn_IP='".$ip."' and Kill_ip='true'";
		return $this->db->exeSql($sql);
	}
	
	//▶ 아이피 차단
	function killIp($ip, $web)
	{
		$sql = "insert into sql_sqlin (SqlIn_IP,SqlIn_WEB,SqlIn_TIME,Kill_ip) 
				values ('".trim($ip)."','".htmlspecialchars($web)."',now(),'true')";
		return $this->db->exeSql($sql);
	}
	
	//▶ 차단아이피 총합
	function killIpTotal()
	{
		$sql = "select count(*) as cnt 
				from sql_sqlin 
					where Kill_ip='true'";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 차단아이피 목록
	function killIpList($page, $page_size)
	{
		$sql = "select * 
				from sql_sqlin 
					where Kill_ip='true' order by SqlIn_TIME desc limit ".$page.",".$page_size;
		return $this->db->exeSql($sql);
	}
	
	function isKillIp($remoteIp)
	{
		$sql = "select count(id) as cnt from sql_sqlin where kill_ip='true' and SqlIn_IP='".$remoteIp."'";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 관리자 암호
	function getAdminPasswd($password)
	{
		$sql = "select * 
				from ".$this->db_qz."head 
					where head_pw=md5('".$password."') and head_id='".$_SESSION["member"]["id"]."' and logo='".$this->logo."'";
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 관리자 암호변경
	function modifyAdminPasswd($newPasswd)
	{
		$sql = "update ".$this->db_qz."head 
				set head_pw=md5('".$newPasswd."') 
					where head_id='".$_SESSION["member"]["id"]."' and logo='".$this->logo."'";
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 유저잭팟 초기화
	function clearJackpot()
	{
		$sql = "update ".$this->db_qz."member 
						set jackpot_num=0 
						where logo='".$this->logo."'";
		
		return $this->db->exeSql($sql);
	}
	
	function getPopup()
	{
		$today = date("Y-m-d");
		
		$sql = "select * 
						from ".$this->db_qz."popup 
						where logo='".$this->logo."'
						and P_POPUP_U='Y'
						and P_STARTDAY <= '".$today."' and P_ENDDAY >='".$today."' ";
	
		return $this->db->exeSql($sql);
	}

    function getLoginPopup()
    {
        $today = date("Y-m-d");

        $sql = "select * 
						from ".$this->db_qz."popup 
						where logo='".$this->logo."'
						and P_POPUP_U='Y'
						and P_LOGIN_POPUP_U='Y'
						and P_STARTDAY <= '".$today."' and P_ENDDAY >='".$today."' ";

        return $this->db->exeSql($sql);
    }

	//-> 네임드 보안서버 적용 여부.
	function namedSecurityState() {
		$sql = "select security from main_parsing_mubayo2_lsports._parsing_state where type = 'named'";
		$res = $this->db->exeSql($sql);
		return $res[0]["security"];
	}
}
?>