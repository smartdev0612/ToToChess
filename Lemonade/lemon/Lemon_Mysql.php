<?
/**
* MySQL을 사용하기 위한 Class
*/
class Lemon_Mysql 
{
	private $dbInfo			= '';
	private $isDebug		= true;
	private $dmlType		= '';
	private $funcName		= '';
	private $transaction	= '';

	public $sql	= '';
	public $errorMsg = '';

	public $conn = '';

	public function __construct($db,$isPConnect='')
	{
		$this->getConnection($db,$isPConnect);
		if($db['db']!='')
			$this->changeDB($db['db']);

		$this->funcName = "^(PASSWORD|VERSION|QUOTE|ABS|CHAR|CURDATE|CURRENT_DATE|CURTIME|CURRENT_TIME|NEW|SYSDATE|NOW|DAYOFMONTH|DAYOFWEEK|WEEKDAY|DAYOFYEAR|ENCRYPT|MD5|SHA|SHA1|BENCHMARK|IF|LOWER|UPPER|MID|MOD|QUARTER|REPLACE|REVERSE|ROUND|RTRIM|TRIM|LOAD_FILE|SIGN|FLOOR|CEILING|EXP|LOG|LOG10|POW|SQRT|PI|COS|SIN|TAN|ACOS|ASIN|ATAN|RAND|LEAST|GREATEST|CONCAT|LENGTH|LPAD|RPAD|LEFT|RIGHT|SUBSTRING|LTRIM|SPACE|REPLACE|REVERSE|LCASE|UCASE|COUNT)\(.*\)$";
	}

	public function getConnection($db,$isPConnect='')
	{
		try 
		{
			if($isPConnect===true)
				$con = @mysqli_pconnect($db['host'],$db['user'],$db['password']);
			else 
			{
				if($db['port']!="")
					$con = @mysqli_connect($db['host'],$db['user'],$db['password'], $db['db'], $db['port']);
				else
					$con = @mysqli_connect($db['host'],$db['user'],$db['password'], $db['db']) or die("일시적인 장애입니다. 새로고침 해주세요.");
			}

			if(!$con)
				throw new Exception("[MySQL접속 Error] Mysql에 접속이 불가능 합니다. 호스트, 유저명,  패스워드를 확인하세요\n");

			$this->conn = $con;

			if($db['encoding']!='')
			{
				if(mysqli_query($con, "set names ".$db['encoding'])===false)
				{
					throw new Exception("[Mysql 인코딩 설정 오류] - ".mysqli_error($con));
				}
			}

			$this->dbInfo = $db;

		}
		catch(Exception $e)
		{
			echo $e;
			exit;
		}

		return $this->conn;
	}

	public function setDebugMode($mode='true'){
		$this->isDebug = $mode;
	}

	public function getDbInfo(){
		return $this->dbInfo;
	}

	public function changeDB($db){
		try {
			if(!mysqli_select_db($this->conn, $db))
				throw new Exception("[ MySQL DataBase 선택 Error ] ".mysqli_errno($this->conn)." : ".mysqli_error($this->conn)."\n");
		}catch(Exception $e){
			echo $e->getMessage();
			exit;
		}
	}

	public function getDMLType($sql){
		$types = array('select','update','insert','delete');

		$sql = trim($sql);
		if(in_array(strtolower(substr($sql,0,6)),$types)){
			$this->dmlType = strtolower(substr($sql,0,6));
		}
	}

	public function exeSql($sql=''){

		if($sql==''){
			if($this->sql=='')
				return false;
			else
				$sql = $this->sql;
		}
		else {
			$this->dmlType = '';
		}

		$this->getDMLType($sql);
		$error = false;

		$ips = "";
		if ( isset($_SERVER["HTTP_INCAP_CLIENT_IP"]) && isset($_SERVER["HTTP_INCAP_CLIENT_IP"]) ) {
			$ips = $_SERVER["HTTP_INCAP_CLIENT_IP"];
			//echo "HTTP_INCAP_CLIENT_IP";
		} else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) {
			$ips = $_SERVER["HTTP_X_FORWARDED_FOR"];
			//echo "HTTP_X_FORWARDED_FOR";
		} else if ( isset($_SERVER["HTTP_X_REAL_IP"]) && isset($_SERVER["HTTP_X_REAL_IP"]) ) {
			$ips = $_SERVER["HTTP_X_REAL_IP"];
			//echo "HTTP_X_REAL_IP";
		} else if ( isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ) {
			$ips = $_SERVER["HTTP_CF_CONNECTING_IP"];
			//echo "HTTP_CF_CONNECTING_IP";
		} else {
			$ips = $_SERVER["REMOTE_ADDR"];
			//echo "REMOTE_ADDR";
		}
		
		$selfUrl = $_SERVER["PHP_SELF"];

		$hDate = date("Y-m-d H:i:s",time());

		// //-> 업데이트에 대한 쿼리 로그. (SUB_CHILD_SN 업데이트)
		// if ( preg_match("/(update )/i",$sql,$match) != 0 ) {
		// 	if ( preg_match("/(vhost.user)/i",$selfUrl,$match) != 0 and preg_match("/(sub_child_sn)/i",$sql,$match) != 0 ) {
		// 		$fileName = "SQL_LOG_SUBCHILD_".date("Ymd",time()).".log";
		// 		$logFile = @fopen("D:\\project\\service\\ToToChess\\Lemonade\\_logs\\system\\".$fileName,"a");
		// 		if ( $logFile ) {
		// 			$logSql = str_replace("	","",$sql);
		// 			@fwrite($logFile, "\n{$ips} {$hDate} [{$selfUrl}] [{$logSql}]\n");
		// 			@fclose($logFile);
		// 		}
		// 		exit;
		// 	}
		// }

		// //-> 업데이트에 대한 쿼리 로그. (배팅뱡향 업데이트)
		// if ( preg_match("/(update )/i",$sql,$match) != 0 ) {
		// 	if ( preg_match("/(vhost.user)/i",$selfUrl,$match) != 0 and preg_match("/(select_no)/i",$sql,$match) != 0 ) {
		// 		$fileName = "SQL_LOG_SELECTNO_".date("Ymd",time()).".log";
		// 		$logFile = @fopen("D:\\project\\service\\ToToChess\\Lemonade\\_logs\\system\\".$fileName,"a");
		// 		if ( $logFile ) {
		// 			$logSql = str_replace("	","",$sql);
		// 			@fwrite($logFile, "\n{$ips} {$hDate} [{$selfUrl}] [{$logSql}]\n\n");
		// 			@fclose($logFile);
		// 		}
		// 		exit;
		// 	}
		// }

		// //-> 업데이트에 대한 쿼리 로그. (배당 업데이트)
		// if ( preg_match("/(update )/i",$sql,$match) != 0 ) {
		// 	if ( preg_match("/(home_rate)/i",$sql,$match) != 0 or preg_match("/(away_rate)/i",$sql,$match) != 0 or preg_match("/(draw_rate)/i",$sql,$match) != 0 ) {
				
		// 		$fileName = "SQL_LOG_RATE_".date("Ymd",time()).".log";
		// 		$logFile = @fopen("D:\\project\\service\\ToToChess\\Lemonade\\_logs\\system\\".$fileName,"a");
		// 		if ( $logFile ) {
		// 			$logSql = str_replace("	","",$sql);
		// 			@fwrite($logFile, "\n{$ips} {$hDate} [{$selfUrl}] [{$logSql}]\n\n");
		// 			@fclose($logFile);
		// 		}
		// 	}
		// }

		// //-> 업데이트에 대한 쿼리 로그. (계좌답변 업데이트)
		// if ( preg_match("/(update )/i",$sql,$match) != 0 ) {
		// 	if ( preg_match("/(qna_1)/i",$sql,$match) != 0 ) {
		// 		//-> 배팅로그 file
		// 		$fileName = "SQL_LOG_QUESTION_".date("Ymd",time()).".log";
		// 		$logFile = @fopen("D:\\project\\service\\ToToChess\\Lemonade\\_logs\\system\\".$fileName,"a");
		// 		if ( $logFile ) {
		// 			$logSql = str_replace("	","",$sql);					
		// 			@fwrite($logFile, "\n{$ips} {$hDate} [{$selfUrl}] [{$logSql}]\n\n");
		// 			@fclose($logFile);
		// 		}
		// 	}
		// }

		// //-> 업데이트에 대한 쿼리 로그. (유저정보 업데이트)
		// if ( preg_match("/(update )/i",$sql,$match) != 0 ) {
		// 	if ( preg_match("/(tb_people)/i",$sql,$match) != 0 ) {
		// 		if ( preg_match("/(nick|name|phone|bank_)/i",$sql,$match) != 0 ) {
		// 			//-> 유저변경로그 file
		// 			$fileName = "SQL_LOG_USER_".date("Ymd",time()).".log";
		// 			$logFile = @fopen("D:\\project\\service\\ToToChess\\Lemonade\\_logs\\system\\".$fileName,"a");
		// 			if ( $logFile ) {
		// 				$logSql = str_replace("	","",$sql);					
		// 				@fwrite($logFile, "\{$ips} {$hDate} [{$selfUrl}] [{$logSql}]\n\n");
		// 				@fclose($logFile);
		// 			}
		// 		}
		// 	}
		// }

		// //-> 업데이트에 대한 쿼리 로그. (파트너정보 업데이트)
		// if ( preg_match("/(update )/i",$sql,$match) != 0 ) {
		// 	if ( preg_match("/(tb_partner)/i",$sql,$match) != 0 ) {
		// 		if ( preg_match("/(id|name|phone|_bank)/i",$sql,$match) != 0 ) {
		// 			//-> 유저변경로그 file
		// 			$fileName = "SQL_LOG_PARTNER_".date("Ymd",time()).".log";
		// 			$logFile = @fopen("D:\\project\\service\\ToToChess\\Lemonade\\_logs\\system\\".$fileName,"a");
		// 			if ( $logFile ) {
		// 				$logSql = str_replace("	","",$sql);					
		// 				@fwrite($logFile, "\{$ips} {$hDate} [{$selfUrl}] [{$logSql}]\n\n");
		// 				@fclose($logFile);
		// 			}
		// 		}
		// 	}
		// }

		//-> 큐어리로그 file
		$fileName = "SQL_LOG_QUERY_".date("Ymd",time()).".log";
		$logFile = @fopen("D:\\project\\service\\ToToChess\\Lemonade\\_logs\\system\\".$fileName,"a");
		if ( $logFile ) {
			$logSql = str_replace("	","",$sql);					
			@fwrite($logFile, "\{$ips} {$hDate} [{$selfUrl}] [{$logSql}]\n\n");
			@fclose($logFile);
		}

		try {
			if(!$result=mysqli_query($this->conn, $sql)){
				$error = true;
				//echo "[MySQL Query Error] ".mysql_errno($this->conn)." : ".mysql_error($this->conn)."\n".$sql."\n";
				//exit;

				if($this->isDebug)
					throw new Exception("[MySQL Query Error] ".mysqli_errno($this->conn)." : ".mysqli_error($this->conn)."<br>".$sql);
				else
					throw new Exception("잘못된 접근 또는 오류가 발생했습니다");
			}

			if($this->dmlType=='select'){
				for($i=0;$row = $result->fetch_array(MYSQLI_ASSOC) ;$i++){
					$rows[$i]=$row;
				}
                mysqli_free_result($result);
				return $rows;
			} else if($this->dmlType=='insert'){
				$rs = mysqli_insert_id($this->conn);
				@mysqli_free_result($result);
				return $rs;
			} else if($this->dmlType=='update' || $this->dmlType=='delete'){
				$rs = mysqli_affected_rows($this->conn);
				@mysqli_free_result($result);
				return $rs;
			}

		}
		catch(Exception $e){
			if($this->transaction===true){
				$this->tranEnd(false);
			}

			if($this->isDebug){
				echo $e->getMessage();
				exit;
			}
			else {
				$this->errorMsg = $e->getMessage();
				return false;
			}
		}
	}

	public function setInsert($table,$value){
		$values = $this->valuesMakeAsInsert($value);
		$this->sql = "insert into " . $table . " " . $values;
	}

	public function setUpdate($table,$value,$where){
		$values = $this->valuesMakeAsUpdate($value);
		$this->sql = "update " . $table . " set " . $values . " where ".$where;
	}

	public function setDelete($table,$where){
		$this->sql = "delete from " . $table . " where ".$where;
	}

	public function valuesMakeAsInsert($value){
		$dml = '';

		foreach($value as $k => $v ){
			if($v!=''){
				$dmlField .= $k.",";

				if(preg_match("/".$this->funcName."/",strtoupper($v),$match)){
					$dmlValue .= $v.",";
				}
				else
					$dmlValue .= "'".$v."',";
			}
		}

		$dmlField = $dmlField==''?'':substr($dmlField,0,-1);
		$dmlValue = $dmlValue==''?'':substr($dmlValue,0,-1);
		$dml = "(" . $dmlField . ") values (" . $dmlValue . ")";
		return $dml;
	}

	public function valuesMakeAsUpdate($value){
		$dml = '';

		foreach($value as $k => $v ){
			if($v!=''){
				if(preg_match("/".$this->funcName."/",strtoupper($v),$match)){
					$dml .= $k."=".$v.",";
				}
				else
					$dml .= $k."="."'".$v."',";
			}
			else
				$dml .= $k."='',";
		}

		$dml = $dml==''?'':substr($dml,0,-1);
		return $dml;
	}

	// 트랙잭션 시작 함수
	// innodb 일때만 정상동작
	public function tranBegin(){
		try{
			mysqli_query($this->conn, "SET AUTOCOMMIT=0");
			if(!mysqli_query($this->conn, "BEGIN"))
				throw new Exception("START TRANSACTION Error : ".mysqli_errno($this->conn)." : ".mysqli_errno($this->conn));
		}
		catch(HtmlException $e){
			echo $e;
			exit;
		}

		$this->transaction = true;
	}

	// 트랙잭션 끝내는  함수 ( Commit ) ;
	public function tranEnd($result=true){
		try{
			if($this->transaction === true){
				if(!mysqli_query($this->conn, ($result===true?'COMMIT':'ROLLBACK')))
					throw new Exception(($result===true?'COMMIT':'ROLLBACK')." Error : ".mysqli_errno($this->conn)." : ".mysqli_errno($this->conn));
			}
		}
		catch(HtmlException $e){
			echo $e;
			exit;
		}

		$this->transaction = false;
	}

	public function close(){
		$this->__destruct();
	}

	/**
	* 소멸자로 DB의 커넥션이 열려있을 경우 접속을 중지하고 메모리를 반환한다.
	* @return void
	*/
	public function __destruct(){
		if($this->conn!='')
			@mysqli_close($this->conn);
	}
}
?>