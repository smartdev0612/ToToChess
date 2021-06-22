<?
/*
* 부모 모델. 모든 모델은 이 모델을 상속해야함.
*/

class Lemon_Model extends Lemon_Object {
	
	public  $db = '';
	var 	$logo  = "gadget";
	var 	$db_qz = "tb_";
	
	function __construct()
	{
		global $t_req, $t_config, $t_path, $t_message, $t_auth;
		
		parent::setRequest($t_req);
		parent::setConfig($t_config);
		parent::setPath($t_path);
		parent::setMessage($t_message);
		parent::setAuth($t_auth);		
		
		$this->setLogo();
	}
	
	public function setLogo()
	{
		if(isset($_SESSION["logo"]) )
		{		
			$this->logo = $_SESSION["logo"];	
		}	
	}
	
	public function setDB($db)
	{
		$this->db = $db;
	}
	
	public function getRow($select='*', $table, $where='')
	{
		$sql = "select " . $select . " from " . $table . " where " . $where;
		$rs = $this->db->exeSql($sql);
		
		return $rs[0];
	}
	
	public function getRows($select='*', $table, $where='')
	{
		$sql = "select " . $select . " from " . $table . " where " . $where;

		$rs = $this->db->exeSql($sql);
		return $rs;
	}

	public function getCount($table,$where=''){
		$sql = "select count(1) as cnt from ".$table.($where!=''?" where ".$where:'');
		if(($rs = $this->db->exeSql($sql))===false)
			throw new Lemon_ScriptException("에러 : ",$this->db->errorMsg);

		return $rs[0]['cnt'];
	}

	// 경기 IDX 구하기  
	public function getMid($day, $cnt) {
		$sql = "select mid from fight where playday='$day' and playcnt='$cnt' " ;
		$rs = $this->db->exeSql($sql);
		return $rs[0]['mid'];
	}
	
	// 요일구하기
	public function dateName($date){
	 $date_1=substr($date,0,4);
	 $date_2=substr($date,5,2);
	 $date_3=substr($date,8,2);
	 $t_i=mktime(0,0,0,$date_2,$date_3,$date_1);
	 $date_show=date('D',$t_i);
	 
	 switch($date_show){
	  case('Mon'):return "월";break;
	  case('Tue'):return "화";break;
	  case('Wed'):return "수";break;
	  case('Thu'):return "목";break;
	  case('Fri'):return "금";break;
	  case('Sat'):return "<font color='blue'>토</font>";break;
	  case('Sun'):return "<font color='red'>일</font>";break;
 		}
	}

    public function dateName2($date, $msg){
        $date_1=substr($date,0,4);
        $date_2=substr($date,5,2);
        $date_3=substr($date,8,2);
        $t_i=mktime(0,0,0,$date_2,$date_3,$date_1);
        $date_show=date('D',$t_i);

        switch($date_show){
            case('Mon'):return $msg;break;
            case('Tue'):return $msg;break;
            case('Wed'):return $msg;break;
            case('Thu'):return $msg;break;
            case('Fri'):return $msg;break;
            case('Sat'):return "<font color='blue'>{$msg}</font>";break;
            case('Sun'):return "<font color='red'>{$msg}</font>";break;
        }
    }
}

?>