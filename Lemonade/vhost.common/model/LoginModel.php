<?php
class LoginModel extends Lemon_Model 
{
	//▶ 파트너 로그인 
	function Partner_login($id, $passwd, $rec_lev)
	{
		$sql = "select * from ".$this->db_qz."recommend where binary rec_id = '".$id."' and rec_psw='".$passwd."' and rec_lev = '".$rec_lev."'";
		$rs =  $this->db->exeSql($sql);				

		/*
		 * returun code
		 * 0:failed, 1:success, 2:ready user 4:stop user
		*/
		
		if( count((array)$rs) > 0 )	
		{
			if( $rs[0]["status"]==1)
			{
				$_SESSION['member']['id']		 			= $rs[0]['rec_id'];
				$_SESSION['member']['sn']		 			= $rs[0]['Idx'];
				$_SESSION['member']['parent_sn'] 	= $rs[0]['parent_sn'];
				$_SESSION['member']['name']		 		= $rs[0]['rec_name'];
				$_SESSION['member']['level']	 		= $rs[0]['rec_lev'];
				$_SESSION['member']['rate']		 		= $rs[0]['rec_rate'];
			}
			else if( $rs[0]["status"]==0)
			{
				return 0;
			}
			return $rs[0]["status"];				
		}
		else
		{
			return -1;
		}
		
		return 0;
	}	

	function isValidIP($remoteip)
    {
        $sql = "select count(*) as cnt from sql_sqlin	where kill_ip = 'true' and SqlIn_IP = '{$remoteip}'";
        $rs = $this->db->exeSql($sql);
        if ( $rs[0]['cnt'] != 0 )
        {
            return false;
        }

        return true;
    }

	function loginStoreMember($id, $passwd)
    {
        if ( isset($_SERVER["HTTP_INCAP_CLIENT_IP"]) && isset($_SERVER["HTTP_INCAP_CLIENT_IP"]) ) {
			$remoteip = $_SERVER["HTTP_INCAP_CLIENT_IP"];
		} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) {
			$remoteip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if ( isset($_SERVER["HTTP_X_REAL_IP"]) && isset($_SERVER["HTTP_X_REAL_IP"]) ) {
			$remoteip = $_SERVER["HTTP_X_REAL_IP"];
		} else if ( isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ) {
			$remoteip = $_SERVER["HTTP_CF_CONNECTING_IP"];
		} else {
			$remoteip = $_SERVER["REMOTE_ADDR"];
		}

        //$passwd = trim($passwd);
		
        //$sql = "select count(*) as cnt from tb_people where uid = '{$id}'";
        $sql = "select count(*) as cnt from tb_people m where is_store=1 and uid = '{$id}'";
        $rs = $this->db->exeSql($sql);

        if($rs[0]['cnt']<=0)
        {
            $result = "아이디 틀림";

            $sql = "insert into ".$this->db_qz."visit(member_id,visit_ip,visit_date,result,status,logo, is_read) 
					values('".$id."','".$remoteip."','".$hDate."','".$result."','1','".$this->logo."', 0)";
            $this->db->exeSql($sql);
            return 0;
        }

        $sql = "select * from tb_people where uid = '{$id}' and upass = '{$passwd}'";
        $rs = $this->db->exeSql($sql);
        if($rs[0]['uid']!='')
        {
            if($rs[0]['mem_status']=='S') 	 	{return 4;}
            else if($rs[0]['mem_status']=='D')	{return 5;}
            else if($rs[0]['mem_status']=='W')	{return 3;}
            else // login success
            {
                $result = "로그인 성공";
                $_SESSION['member']['id']			= $rs[0]['uid'];
                $_SESSION['member']['sn']			= $rs[0]['sn'];
                $_SESSION['member']['name']			= $rs[0]['nick'];
                $_SESSION['member']['level']		= $rs[0]['mem_lev'];
                $_SESSION['member']['recommender']	= $rs[0]['recommend_sn'];
                $_SESSION['member']['state']		= $rs[0]['mem_status'];
                $_SESSION['member']['rate']			= $rs[0]['rate'];

                $config = Lemon_Configure::readConfig('config');
                $_SESSION['conf'] = $config ;

                $sql = "update ".$this->db_qz."people 
								set last_date = now(), 
										sessionid='".session_id()."', 
										login_domain='".$_SERVER['HTTP_HOST']."',
										mem_ip='".$remoteip."'
								where logo='".$this->logo."' and uid = '".$id."' ";
                $this->db->exeSql($sql);

                $sql = "insert into ".$this->db_qz."visit(member_id,visit_ip,visit_date,result,status,logo)
								values('".$id."','".$remoteip."','".$hDate."','".$result."','0','".$this->logo."')";

                $this->db->exeSql($sql);

                return 1;
            }
        }
        else
        {
            $result = "비밀번호 틀림";

            $sql = "insert into ".$this->db_qz."visit(member_id,visit_ip,visit_date,result,status,logo,is_read) 
					values('".$id."','".$remoteip."','".$hDate."','".$result."','1','".$this->logo."', 0)";

            $this->db->exeSql($sql);
        }
        return 0;
    }
	
	function loginMember($id, $passwd, $device = "PC")
	{
		if ( isset($_SERVER["HTTP_INCAP_CLIENT_IP"]) && isset($_SERVER["HTTP_INCAP_CLIENT_IP"]) ) {
			$remoteip = $_SERVER["HTTP_INCAP_CLIENT_IP"];
			//echo "HTTP_INCAP_CLIENT_IP";
		} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) {
			$remoteip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			//echo "HTTP_X_FORWARDED_FOR";
		} else if ( isset($_SERVER["HTTP_X_REAL_IP"]) && isset($_SERVER["HTTP_X_REAL_IP"]) ) {
			$remoteip = $_SERVER["HTTP_X_REAL_IP"];
			//echo "HTTP_X_REAL_IP";
		} else if ( isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ) {
			$remoteip = $_SERVER["HTTP_CF_CONNECTING_IP"];
			//echo "HTTP_CF_CONNECTING_IP";
		} else {
			$remoteip = $_SERVER["REMOTE_ADDR"];
			//echo "REMOTE_ADDR";
		}
		//echo "<br>" . $remoteip;
		//exit;
		
		$passwd = trim($passwd);

		//-> 짧은시간 많은 로그인 (10분에 20회 이상이면 IP 차단등록)
		$hDate = date("Y-m-d H:i:s",time());
		$prvDate = date("Y-m-d H:i:s",time()-600);
		$sql = "select count(idx) as cnt from tb_visit where status = 1 and visit_ip = '{$remoteip}' and visit_date >= '{$prvDate}' and visit_date <= '{$hDate}'";
		$rs = $this->db->exeSql($sql);
		if ( $rs[0]['cnt'] > 20 ) {
			$sql = "select count(id) as ip_cnt from sql_sqlin where SqlIn_IP = '{$remoteip}' and kill_ip = 'true'";
			$ipRes = $this->db->exeSql($sql);
			if ( $ipRes[0]["ip_cnt"] > 0 ) {
				$sql = "update sql_sqlin set kill_ip = 'true' where SqlIn_IP = '{$remoteip}'";
				$this->db->exeSql($sql);
			} else {
				$sql = "insert into sql_sqlin (SqlIn_IP, SqlIn_WEB, SqlIn_TIME, Kill_ip) values ('{$remoteip}','짧은시간 많은 로그인','{$hDate}','true')";
				$this->db->exeSql($sql);
			}
		}

		//-> 짧은시간 많은 로그인 (1분에 5회 이상이면 경고 메세지)
		$hDate = date("Y-m-d H:i:s",time());
		$prvDate = date("Y-m-d H:i:s",time()-60);
		$sql = "select count(idx) as cnt from tb_visit where status = 1 and visit_ip = '{$remoteip}' and visit_date >= '{$prvDate}' and visit_date <= '{$hDate}'";
		$rs = $this->db->exeSql($sql);
		if ( $rs[0]['cnt'] > 5 ) return 7;

		//-> 차단아이피 확인
		$sql = "select count(*) as cnt from sql_sqlin	where kill_ip = 'true' and SqlIn_IP = '{$remoteip}'";
		$rs = $this->db->exeSql($sql);
		if ( $rs[0]['cnt'] != 0 ) return 2;
		
		$sql = "select count(*) as cnt from tb_people where uid = '{$id}'";
		$rs = $this->db->exeSql($sql);
		
		/*등급에 설정된 도메인과 접속 도메인이 틀릴경우 회원 접속 제한
		$configModel = Lemon_Instance::getObject("ConfigModel",true);
		$lev_domain=$configModel->getLevelConfigField($rs[0]['mem_lev'], 'lev_domain');
		
		if(($lev_domain!=$_SERVER['HTTP_HOST'])||($lev_domain!="www.".$_SERVER['HTTP_HOST']))
		{
			return 6;
		}
		*/

		if($rs[0]['cnt']<=0) 
		{
			$result = "아이디 틀림";
			
			$sql = "insert into ".$this->db_qz."visit(member_id,visit_ip,visit_date,result,status,logo, is_read, device) 
					values('".$id."','".$remoteip."','".$hDate."','".$result."','1','".$this->logo."', 0, '" . $device . "')";
			$this->db->exeSql($sql);
			return 0;
		}
		
		$sql = "select * from tb_people where uid = '{$id}' and upass = '{$passwd}'";
		$rs = $this->db->exeSql($sql);
		if($rs[0]['uid']!='')
		{
			if($rs[0]['mem_status']=='S') 			{return 4;}
			else if($rs[0]['mem_status']=='D')	{return 5;}
			else if($rs[0]['mem_status']=='W')	{return 3;}
			else // login success
			{
				$result = "로그인 성공";
				
				$_SESSION['member']['id']						= $rs[0]['uid'];
				$_SESSION['member']['sn']						= $rs[0]['sn'];
				$_SESSION['member']['name']					= $rs[0]['nick'];
				$_SESSION['member']['level']				= $rs[0]['mem_lev'];
				$_SESSION['member']['recommender']	= $rs[0]['recommend_sn'];
				$_SESSION['member']['state']				= $rs[0]['mem_status'];
				
				$config = Lemon_Configure::readConfig('config');
				$_SESSION['conf'] = $config ;
				
				$sql = "update ".$this->db_qz."people 
								set last_date = now(), 
										sessionid='".session_id()."', 
										login_domain='".$_SERVER['HTTP_HOST']."',
										mem_ip='".$remoteip."'
								where logo='".$this->logo."' and uid = '".$id."' "; 
				$this->db->exeSql($sql); 
				
				$sql = "insert into ".$this->db_qz."visit(member_id,visit_ip,visit_date,result,status,logo,device)
								values('".$id."','".$remoteip."','".$hDate."','".$result."','0','".$this->logo."', '" . $device . "')";
						
				$this->db->exeSql($sql);
								
				return 1;
			}
		}
		else
		{
			$result = "비밀번호 틀림";
			
			$sql = "insert into ".$this->db_qz."visit(member_id,visit_ip,visit_date,result,status,logo,is_read) 
					values('".$id."','".$remoteip."','".$hDate."','".$result."','1','".$this->logo."', 0)";
					
			$this->db->exeSql($sql);
		}
		return 0;
	}

	function updateVisitLog()
    {
        $sql = "update tb_visit set is_read = 1 where status=1 ";
        $result = $this->db->exeSql($sql);
    }

	//▶ 로그인
	function login($uid, $passwd, $inputPwd, $ip)
	{
		$sql = "select *
						from ".$this->db_qz."head 
						where logo='".$this->logo."' and binary head_id = '".$uid."' and head_pw='".$passwd."'"; 
			
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)>0)
		{
			// 관리자 아이피가 접속가능 아이피목록에 있는지 체크.
			// $sql = "select * from ".$this->db_qz."head_ip where head_idx = '".$rs[0]['idx']."' and login_ip = '" . $ip . "'"; 
			// $ip_list = $this->db->exeSql($sql);
			// if(count((array)$ip_list) == 0) {
			// 	$sql = "insert into ".$this->db_qz."admin_log (admin_id,admin_pw,login_ip,login_date,result,status,logo) 
			// 			values ('".$uid."','".$inputPwd."','".$ip."',now(),'접속 불가능한 아이피','1','".$this->logo."')";
			// 	$this->db->exeSql($sql);
			// 	return 3; // 접속불가능한 아이피
			// }
				
			$_SESSION["quanxian"] = $rs[0]["part_num"];
		
			$sql = "update ".$this->db_qz."head 
							set loginnum=loginnum+1 ,lastlogintime=now(),lastloginip='".$ip."' where logo='".$this->logo."' and  head_id='".$uid."'";	
				
			$this->db->exeSql($sql);
			
			$sql = "insert into ".$this->db_qz."admin_log (admin_id,login_ip,login_date,result,status,logo)
					values ('".$uid."','".$ip."',now(),'로그인 성공','0','".$this->logo."')";
			$this->db->exeSql($sql);
			
			$_SESSION["member"]["id"] = $uid;
			$_SESSION["member"]["sn"] = $rs[0]['idx']; 
			$_SESSION["member"]["ip"] = $ip;

			return 1; // 로그인 성공
		}
		else
		{
			$sql = "insert into ".$this->db_qz."admin_log (admin_id,admin_pw,login_ip,login_date,result,status,logo) 
				values ('".$uid."','".$inputPwd."','".$ip."',now(),'로그인 실패','1','".$this->logo."')";
			$this->db->exeSql($sql);
			return 2; // 로그인 실패 (아이디 혹은 비번 틀림)
		}
	}

	//▶ 로그인
	function api_loginMember($id = "", $passwd = "")
	{
		if ( isset($_SERVER["HTTP_INCAP_CLIENT_IP"]) && isset($_SERVER["HTTP_INCAP_CLIENT_IP"]) ) {
			$remoteip = $_SERVER["HTTP_INCAP_CLIENT_IP"];
		} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) {
			$remoteip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if ( isset($_SERVER["HTTP_X_REAL_IP"]) && isset($_SERVER["HTTP_X_REAL_IP"]) ) {
			$remoteip = $_SERVER["HTTP_X_REAL_IP"];
		} else if ( isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ) {
			$remoteip = $_SERVER["HTTP_CF_CONNECTING_IP"];
		} else {
			$remoteip = $_SERVER["REMOTE_ADDR"];
		}
		
		$passwd = trim($passwd);

		//-> 짧은시간 많은 로그인 (10분에 20회 이상이면 IP 차단등록)
		$hDate = date("Y-m-d H:i:s",time());
		$prvDate = date("Y-m-d H:i:s",time()-600);
		$sql = "select count(idx) as cnt from tb_visit where status = 1 and visit_ip = '{$remoteip}' and visit_date >= '{$prvDate}' and visit_date <= '{$hDate}'";
		$rs = $this->db->exeSql($sql);
		if ( $rs[0]['cnt'] > 20 ) {
			$sql = "select count(id) as ip_cnt from sql_sqlin where SqlIn_IP = '{$remoteip}' and kill_ip = 'true'";
			$ipRes = $this->db->exeSql($sql);
			if ( $ipRes[0]["ip_cnt"] > 0 ) {
				$sql = "update sql_sqlin set kill_ip = 'true' where SqlIn_IP = '{$remoteip}'";
				$this->db->exeSql($sql);
			} else {
				$sql = "insert into sql_sqlin (SqlIn_IP, SqlIn_WEB, SqlIn_TIME, Kill_ip) values ('{$remoteip}','짧은시간 많은 로그인','{$hDate}','true')";
				$this->db->exeSql($sql);
			}
		}

		//-> 짧은시간 많은 로그인 (1분에 5회 이상이면 경고 메세지)
		$hDate = date("Y-m-d H:i:s",time());
		$prvDate = date("Y-m-d H:i:s",time()-60);
		$sql = "select count(idx) as cnt from tb_visit where status = 1 and visit_ip = '{$remoteip}' and visit_date >= '{$prvDate}' and visit_date <= '{$hDate}'";
		$rs = $this->db->exeSql($sql);
		if ( $rs[0]['cnt'] > 5 ) return 7;

		//-> 차단아이피 확인
		$sql = "select count(*) as cnt from sql_sqlin	where kill_ip = 'true' and SqlIn_IP = '{$remoteip}'";
		$rs = $this->db->exeSql($sql);
		if ( $rs[0]['cnt'] != 0 ) return 2;
		
		$sql = "select count(*) as cnt from tb_people where uid = '{$id}'";
		$rs = $this->db->exeSql($sql);
		
		/*등급에 설정된 도메인과 접속 도메인이 틀릴경우 회원 접속 제한
		$configModel = Lemon_Instance::getObject("ConfigModel",true);
		$lev_domain=$configModel->getLevelConfigField($rs[0]['mem_lev'], 'lev_domain');
		
		if(($lev_domain!=$_SERVER['HTTP_HOST'])||($lev_domain!="www.".$_SERVER['HTTP_HOST']))
		{
			return 6;
		}
		*/

		if($rs[0]['cnt']<=0) 
		{
			$result = "아이디 틀림";
			
			$sql = "insert into ".$this->db_qz."visit(member_id,visit_ip,visit_date,result,status,logo, is_read) 
					values('".$id."','".$remoteip."','".$hDate."','".$result."','1','".$this->logo."', 0)";
			$this->db->exeSql($sql);
			return 0;
		}
		
		$sql = "select * from tb_people where uid = '{$id}' and upass = '{$passwd}'";
		$rs = $this->db->exeSql($sql);
		if($rs[0]['uid']!='')
		{
			if($rs[0]['mem_status']=='S') 			{return 4;}
			else if($rs[0]['mem_status']=='D')	{return 5;}
			else if($rs[0]['mem_status']=='W')	{return 3;}
			else // login success
			{
				$result = "로그인 성공";
				
				$_SESSION['member']['id']						= $rs[0]['uid'];
				$_SESSION['member']['sn']						= $rs[0]['sn'];
				$_SESSION['member']['name']					= $rs[0]['nick'];
				$_SESSION['member']['level']				= $rs[0]['mem_lev'];
				$_SESSION['member']['recommender']	= $rs[0]['recommend_sn'];
				$_SESSION['member']['state']				= $rs[0]['mem_status'];
				
				$config = Lemon_Configure::readConfig('config');
				$_SESSION['conf'] = $config ;
				
				$sql = "update ".$this->db_qz."people 
								set last_date = now(), 
										sessionid='".session_id()."', 
										login_domain='".$_SERVER['HTTP_HOST']."',
										mem_ip='".$remoteip."'
								where logo='".$this->logo."' and uid = '".$id."' "; 
				$this->db->exeSql($sql); 
				
				$sql = "insert into ".$this->db_qz."visit(member_id,visit_ip,visit_date,result,status,logo)
								values('".$id."','".$remoteip."','".$hDate."','".$result."','0','".$this->logo."')";
						
				$this->db->exeSql($sql);
								
				return 1;
			}
		}
		else
		{
			$result = "비밀번호 틀림";
			
			$sql = "insert into ".$this->db_qz."visit(member_id,visit_ip,visit_date,result,status,logo,is_read) 
					values('".$id."','".$remoteip."','".$hDate."','".$result."','1','".$this->logo."', 0)";
					
			$this->db->exeSql($sql);
		}
		return 0;
	}

	//▶ 로그인
	function login_skip($uid, $ip = "")
	{
		$sql = "select * from ".$this->db_qz."head where logo='".$this->logo."' and binary head_id = '".$uid."'"; 
		$rs = $this->db->exeSql($sql);
		if ( count((array)$rs) > 0 ) {
			// 관리자 아이피가 접속가능 아이피목록에 있는지 체크.
			// $sql = "select * from ".$this->db_qz."head_ip where head_idx = '".$rs[0]['idx']."' and login_ip = '" . $ip . "'"; 
			// $ip_list = $this->db->exeSql($sql);
			// if(count((array)$ip_list) == 0)
			// 	return 3;

			$_SESSION["quanxian"] = $rs[0]["part_num"];		
			$_SESSION["member"]["id"] = $uid;
			$_SESSION["member"]["sn"]	= $rs[0]['idx']; 
			return 1;
		}
		return 2;
	}

	//▶ 로그인 로그 목록
	function getList($where, $page, $page_size)
	{
		$eModel = Lemon_Instance::getObject("EtcModel",true);
		
		$sql = "select a.logo, a.sn as aidx, a.nick,a.mem_lev,a.g_money, a.login_domain, a.bank_member, (select rec_id from ".$this->db_qz."recommend where Idx=a.recommend_sn) as recommend_id, b.member_id,b.idx,b.visit_date,b.visit_ip,b.result,b.status,b.device 
				from ".$this->db_qz."people a right outer join ".$this->db_qz."visit b on a.uid=b.member_id 
				where a.mem_status<>'G'".$where." order by b.visit_date desc  limit ".$page.",".$page_size ;
					
		$rs = $this->db->exeSql($sql);

		$searchArray  = array();
		$blackIpArray = array();

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$ip  = $rs[$i]['visit_ip'];
			$memberSn = $rs[$i]['aidx'];
			
			if($searchArray[$ip][0]!='')
			{
				if($searchArray[$ip][0]!=$memberSn)
				{
					$blackIpArray[]=$ip;
				}
			}
			else
			{
				$searchArray[$ip][0]=$memberSn;
			}
			
			$rs[$i]['country_code'] = $eModel->getNationByIp($ip);
		}
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			if(strlen(array_search(trim($rs[$i]['visit_ip']), $blackIpArray))>0) {$rs[$i]['duplicate_ip']=1;}
			else	$rs[$i]['duplicate_ip']=0;
		}
		
		return $rs;
	}

    //▶ 로그인 로그 목록
    function getSimultaneousList()
    {
        $eModel = Lemon_Instance::getObject("EtcModel",true);

        //-> 서버에 세션중 용량이 0바이트 이상인것들만 가져와 IN쿼리를 실행 할 수 있또록 문자열을 만든다.
        // @exec("find D:\\project\\service\\ToToChess\\m.vhost.user\\session -size +1c",$sessionList_mobile);
        // unset($sessionList_mobile[0]);
        // @exec("find D:\\project\\service\\ToToChess\\vhost.user\\session -size +1c",$sessionList_pc);
        // unset($sessionList_pc[0]);

		$sessionList = array();
		$sessionList_mobile = array();
		$sessionList_pc = array();

		$path    = "D:\\project\\service\\ToToChess\\m.vhost.user\\session\\";
		$temp_mobile = scandir($path);
		$temp_mobile = array_diff(scandir($path), array('.', '..'));
		foreach($temp_mobile as $file) {
			if(filesize($path . $file) > 0) {
				$pieces = explode("_", $file);
				array_push($sessionList_mobile, $pieces[1]);
			}
		}
		
		$path    = "D:\\project\\service\\ToToChess\\vhost.user\\session\\";
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
            // $sessionListStr = "'".str_replace("D:\\project\\service\\ToToChess\\vhost.user\\session\\sess_","",
            //         str_replace("D:\\project\\service\\ToToChess\\m.vhost.user\\session\\sess_","",implode("','",$sessionList)))."'";

			$sessionListStr = "'" . implode("','", $sessionList) . "'";

            //-> DB에 저장된 5분 미만 페이지 로딩한 회원들을 서버 세션과 비교해서 동접을 확인한다.
            $ckTime = date("Y-m-d H:i:s", time() - 300);
            /*$sql = "select count(sn) as connect_cnt from tb_people where page_load_date > '{$ckTime}' and sessionid IN ({$sessionListStr})";
            $rs = $this->db->exeSql($sql);*/

            $sql = "select * from ".$this->db_qz."people 
						where mem_status<>'G' and  page_load_date > '{$ckTime}' and sessionid IN ({$sessionListStr}) ";

            $rs = $this->db->exeSql($sql);
        }

        return $rs;
    }

	//▶ 로그인 로그 총합
	function getTotal($where)
	{
		$sql = "select count(*) as cnt
				from ".$this->db_qz."people a right outer join ".$this->db_qz."visit b on a.uid=b.member_id 
					where 1=1 ".$where ;
					
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 로그인 로그 삭제
	function del($sn)
	{
		$sql = "delete from ".$this->db_qz."visit 
				where idx in(".$sn.")";
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 로그인한 관리자가 유령관리자인지 아닌지 검사
	function isGhostManger($sn) {
		$sql = "SELECT is_ghost FROM tb_head WHERE idx = " . $sn;
		$res = $this->db->exeSql($sql);
		$isGhost = 0;
		if(count((array)$res) > 0)
			$isGhost = $res[0]["is_ghost"];
		return $isGhost;		
	}

	//▶ 관리자 로그인 로그 총합
	function getAdminLoginTotal($where)
	{
		$sql = "select count(*) as cnt
				from ".$this->db_qz."admin_log 
					left join tb_head on tb_admin_log.admin_id = tb_head.head_id 
				where tb_admin_log.logo='".$this->logo."' ".$where;
				
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 관리자 로그인 로그 목록
	function getAdminLogList($where, $page, $page_size)
	{
		$eModel = Lemon_Instance::getObject("EtcModel",true);
		
		$sql = "select * 
				from ".$this->db_qz."admin_log 
						left join tb_head on tb_admin_log.admin_id = tb_head.head_id 
				where tb_admin_log.logo='".$this->logo."' ".$where." 
				order by login_date desc limit ".$page.",".$page_size;
						
		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$ip  = $rs[$i]['login_ip'];
			$rs[$i]['country_code'] = $eModel->getNationByIp($ip);
		}

		return $rs;
    }
}
?>