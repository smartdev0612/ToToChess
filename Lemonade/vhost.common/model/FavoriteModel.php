<?php
class FavoriteModel extends Lemon_Model
{
	function getList($sn)
	{
		//nation_idx=0 items
		$sql = "select a.sn, a.category_sn, b.name as cate_name 
				from ".$this->db_qz."favorite_list a,".$this->db_qz."sport_list b
					where a.category_sn=b.idx and a.member_sn ='".$sn."' and a.nation_sn=0";
					
		$rs = $this->db->exeSql($sql);
	
		$array=array();	
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$tmp = array();
			
			$tmp['idx'] 		= $rs[$i]['idx'];
			$tmp['cate_idx'] 	= $rs[$i]['cate_idx'];
			$tmp['cate_name'] 	= $rs[$i]['cate_name'];
			$tmp['nation_idx'] 	= 0;
			$tmp['league_idx'] 	= 0;
			$tmp['nation_name'] = "";
			$tmp['league_name'] = "";
			array_push($array, $tmp);
		}
		//league_idx=0 items
		$sql = "select a.sn, a.category_sn, a.nation_sn, b.name as cate_name, d.name as nation_name 
				from ".$this->db_qz."favorite_list a,".$this->db_qz."sport_list b,".$this->db_qz."nation d
					where a.category_sn=b.idx and a.nation_sn=d.sn and a.member_sn='".$sn."' and a.league_sn=0";
		$rs = $this->db->exeSql($sql);
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$tmp = array();
			
			$tmp['idx'] 		= $rs[$i]['sn'];
			$tmp['cate_idx'] 	= $rs[$i]['category_sn'];
			$tmp['cate_name'] 	= $rs[$i]['cate_name'];
			$tmp['nation_idx'] 	= $rs[$i]['nation_idx'];
			$tmp['league_idx'] 	= 0;
			$tmp['nation_name'] = $rs[$i]['nation_name'];
			$tmp['league_name'] = "";
			array_push($array, $tmp);
		}	
			
		// all item
		$sql = "select a.sn, a.category_sn, a.nation_sn, a.league_sn, b.name as cate_name, d.name as nation_name, c.name as league_name
				from ".$this->db_qz."favorite_list a,".$this->db_qz."sport_list b,".$this->db_qz."league c,".$this->db_qz."nation d
					where a.category_sn=b.idx and a.nation_sn=d.sn and a.league_sn=c.sn and a.member_sn='".$sn."' and a.league_sn!=0 and a.nation_sn!=0";
		$rs = $this->db->exeSql($sql);
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$tmp = array();
			
			$tmp['idx'] 		= $rs[$i]['sn'];
			$tmp['cate_idx'] 	= $rs[$i]['category_sn'];
			$tmp['cate_name'] 	= $rs[$i]['cate_name'];
			$tmp['nation_idx'] 	= $rs[$i]['nation_sn'];
			$tmp['league_idx'] 	= $rs[$i]['league_sn'];
			$tmp['nation_name'] = $rs[$i]['nation_name'];
			$tmp['league_name'] = $rs[$i]['league_name'];
			array_push($array, $tmp);
		}
		
		return $array;
	}
	
	//ajax ���� return �� ���� �ȵȴ�.
	function ajaxList($sn)
	{
		$array = $this->getList($sn);
		echo(json_encode($array));
		return;
	}
	
	function ajaxAdd($sn, $cateIdx, $nationIdx, $leagueIdx)
	{
		$sql = "select member_sn 
				from ".$this->db_qz."favorite_list 
					where member_sn=".$sn."and category_sn=".$cateIdx." and nation_sn=".$nationIdx."and league_sn=".$leagueIdx;
					
		$rs = $this->db->exeSql($sql);
		
		if($rs[0]['member_sn']!='')
		{
			echo('true');
			return;
		}
		
		$sql = "insert into ".$this->db_qz."favorite_list(member_sn,category_sn,nation_sn,league_sn) ";
		$sql.= "values(".$sn.",".$cateIdx.",".$nationIdx.",".$leagueIdx.")";
		
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