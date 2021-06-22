<?php


class SmsModel extends Lemon_Model 
{
	//▶ 상태변경
	function modifyStatus($id, $status='1')
	{
		$sql = "update ".$this->db_qz."sms 
				set status=".$status." where id=".$id."";
		return $this->db->exeSql($sql);
	}
	
	//▶ 삭제
	function del($sn)
	{
		$sql = "delete from ".$this->db_qz."sms 
					where id in(".$sn.")";
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 차단
	function remove($ip)
	{
		$sql = "update sql_sqlin set  Kill_ip=NULL 
					where SqlIn_IP='".$ip."' and Kill_ip='true' and logo='".$this->logo."'";
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 추가
	function add($ip)
	{
		$sql = "insert into sql_sqlin(SqlIn_IP,SqlIn_WEB,SqlIn_TIME,Kill_ip,logo) 
				values ('".$ip."','인증문자 발송 페이지- IP차단',now(),'true','".$this->logo."')";
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 총합
	function getTotal($addWhere='')
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."sms
					where logo='".$this->logo."'".$addWhere;
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['cnt'];
	}
	
	//▶ 목록
	function getList($page, $page_size)
	{
		$sql = "select * 
				from ".$this->db_qz."sms
					where logo='".$this->logo."' order by status asc,time desc limit ".$page.",".$page_size;
					
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$ip = $rs[$i]['ip'];
			$sql="select *,(select count(*) from sql_sqlin where SqlIn_IP='".$ip."' and Kill_ip='true' and logo='".$this->logo."')as ckip 
					from ".$this->db_qz."ip_group_country 
						where  ip_start <= INET_ATON( '".$ip."' )  
							order by ip_start desc limit 1";
			$rsi = $this->db->exeSql($sql);
			
			$rs[$i]['country_code'] = $rsi[0][country_code];
			$rs[$i]['ckip'] = $rsi[0][ckip];
		}
		return $rs;
	}
}
?>