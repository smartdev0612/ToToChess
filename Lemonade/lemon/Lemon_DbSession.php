<?
global $id;

class Lemon_DbSession {

	static $db = '';
	var $maxlifetime = 1800;
	
	function __construct(){

	}

	function sess_open( $save_path, $session_name ){

		$sdb = Lemon_Configure::readConfig('database');
		$chost = $sdb['default']['host'] ;
		$cuser = $sdb['default']['user'] ;
		$cpwd = $sdb['default']['password'] ;
		$cdb = $sdb['default']['db'] ;		

		$this->db = mysql_connect($chost,$cuser,$cpwd) or die("sess_open db_con error");
		$rs = mysql_select_db($cdb , $this->db);
		//mysql_query("set names euckr");
		return true;
	}

	function sess_close(){
		return true;
	}

	function sess_read( $key ){
		$sql = "SELECT value FROM session WHERE sesskey='$key' AND expiry > " . time();
		$result = mysql_query($sql,$this->db);
		$sessCnt = mysql_num_rows($result);
		$row = mysql_fetch_array($result);

		if( $sessCnt == 1 ){
			return $row['value'];
		}
		else {
			$sql = "DELETE FROM session WHERE sesskey='$key'";
			$result = mysql_query($sql,$this->db);
			return false;
		}
	}

	function sess_write( $key, $sess_data ){
		$ret = false;

		$expiry = time() + $this->maxlifetime;
		$value = addslashes( $sess_data );
		$remoteip = $_SERVER["HTTP_X_FORWARDED_FOR"];

		// 세션정보가 존재하는지 체크
		$sql = "SELECT * FROM session WHERE sesskey='$key' AND value IS NOT NULL";
		$result = mysql_query($sql,$this->db);
		$sessCnt = mysql_num_rows($result);
//echo "key : $key, sess cnt : $sessCnt, value : $value <br>";		
		if ( $sessCnt == 1 ){
			$sql = "UPDATE session SET expiry='$expiry' WHERE sesskey='$key' AND expiry > " . time();
			if(mysql_query($sql,$this->db)===true)
				$ret = true;
		}
		else if ( $sessCnt == 0 ){
			if ( $sess_data ){
				$id = str_replace(array("'","&"),"",$_POST['uid']);
				if($id!=''){
					$sql = "SELECT value FROM session WHERE userid='$id'";
					$result = mysql_query($sql,$this->db);
					$row = mysql_fetch_array($result);
		//			print_r ( $this->db ) ; echo "<p>" ;

					if($row['value']!=''){
						echo " 중복 로그인 - 기존 로그인 정보 삭제 ";
						$sql = "DELETE FROM session WHERE userid='$id' ";
						mysql_query($sql,$this->db);						
					}
				}
		//		print_r ( $this->db ) ; echo "<p>" ;
				mysql_query("lock tables session write", $this->db);

				// 세션추가
				$sql = "INSERT INTO session ( sesskey, expiry, value, userid, remoteip ) VALUES ( '$key', '$expiry', '$value', '$id', '$remoteip' )";
				if(mysql_query($sql,$this->db)===true)
					$ret = true;
				else {
					echo "sql : $sql <br>";
					mysql_error();
					exit;
				}
				mysql_query("unlock tables", $this->db);
			}
		}

		return $ret;
	}

	function sess_destroy( $key ){
		mysql_query("DELETE FROM session WHERE sesskey='$key'");
		return true;
	}

	function sess_gc( $maxlifetime ){
		mysql_query("DELETE FROM session WHERE expiry < " . time());
		return true;
	}
}

?>