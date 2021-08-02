<?php
class NationModel extends Lemon_Model {
    //▶ 국가 목록
	function getNationList()
	{
		$sql = "select * from ".$this->db_qz."nation where inactive = 1 order by name asc"; 
		return $this->db->exeSql($sql);
	}
	
	//▶ 국가 목록
	function getNationByName($name)
	{
		$sql ="select * from ".$this->db_qz."nation where name like '%".$name."%'";
		return $this->db->exeSql($sql);
	}

	//▶ 국가 목록
	function getNationImage($sn)
	{
		$sql = "select img from ".$this->db_qz."nation where sn = '".$sn."'";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['img'];
	}
	
}
?>