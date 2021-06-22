<?php
	class CoinModel extends Lemon_Model {
		function misGameList($date) {
			$sql = "select * from ".$this->db_qz."child where league_sn='571' and kubun<>1 and gameDate='".$date."' and  concat(gameDate, ' ', gameHour, ':', gameTime) < now()";
			$rs = $this->db->exeSql($sql);
			return $rs;
		}
		
	}
?>