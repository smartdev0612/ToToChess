<?php
class LogModel extends Lemon_Model {
    //▶ URL 로그
	function insertURL($strUrl = "")
	{
		$sql = "INSERT INTO ".$this->db_qz."log_url (strUrl, strTime) VALUES ('" . $strUrl . "', NOW())"; 
		return $this->db->exeSql($sql);
	}
}
?>