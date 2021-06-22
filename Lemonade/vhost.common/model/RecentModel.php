<?php
class RecentModel extends Lemon_Model
{
	function getList($page, $page_size)
	{
		$sql = "select a.home_team, a.away_team, a.gameDate, a.gameHour, a.gameTime, a.sport_name,";
		$sql.= "b.name, b.lg_img as league_image, ";
		$sql.= "c.home_rate, c.draw_rate, c.away_rate";
		$sql.= " from ".$this->db_qz."child a,".$this->db_qz."league b,".$this->db_qz."subchild c";
		$sql.= " where a.league_sn =b.sn and a.sn=c.child_sn";
		$sql.= " and a.kubun=1 ";
		$sql.= " order by a.gameDate desc, a.gameHour desc, a.gameTime, a.league_sn limit ".$page.",".$page_size." ";

		$rs = $this->db->exeSql($sql);
	
		return $rs;
	}
	
	public function getTotalCount()
	{
		$sql = "select count(*) as cnt ";
		$sql.= " from ".$this->db_qz."child a,".$this->db_qz."league b, ".$this->db_qz."subchild c,".$this->db_qz."nation d";
		$sql.= " where a.league_sn =b.sn and a.sn=c.child_sn and b.nation_sn=d.sn";
		$sql.= " and kubun = '1' ";
		
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['cnt'];
	}
	
	//
	function ajaxList($page, $page_size)
	{
		$array = $this->getList($page, $page_size);
		
		echo(json_encode($array));
	}
	
	function ajaxAdd($memberSn, $categorySn, $nationSn, $leagueSn)
	{
		$sql = "select member_sn
				from ".$this->db_qz."favorite_list 
					where member_sn=".$memberSn."and category_sn=".$categorySn." and nation_sn=".$nationSn."and league_sn=".$leagueSn;
					
		$rs = $this->db->exeSql($sql);
		
		if($rs[0]['mem_idx']!='')
		{
			echo('true');
			return;
		}
		
		$sql = "insert into ".$this->db_qz."favorite_list(member_sn,category_sn,nation_sn,league_sn) ";
		$sql.= "values(".$memberSn.",".$categorySn.",".$nationSn.",".$leagueSn.")";
		
		$rs = $this->db->exeSql($sql);
		
		if($rs>0) echo('true');
		else echo('false');
	}
	
	function ajaxDel($sn)
	{
		$sql = "delete from ".$this->db_qz."favorite_list 
				where sn=".$sn;
		
		$rs = $this->db->exeSql($sql);	
		if($rs>0) echo('true');
		else echo('false');
	}
}
?>