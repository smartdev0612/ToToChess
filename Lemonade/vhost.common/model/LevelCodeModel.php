<?php

class LevelCodeModel extends Lemon_Model 
{	
	function makeMemberLevelCode($recommendSn)
	{
		$levelCode = "";
		if($recommendSn!="")
		{
			$sql 	= "select parent_sn from ".$this->db_qz."recommend where Idx=".$recommendSn;
			$rs	= $this->db->exeSql($sql);
			
			if(count((array)$rs)>0)
			{
				$levelCode = sprintf("%04d",$recommendSn);
						
				if($rs[0]['parent_sn']==0)
				{
					$levelCode.= "0000";
				}
				else
				{
					$sql 	= "select Idx from ".$this->db_qz."recommend where Idx=".$rs[0]['parent_sn'];
					$rs		= $this->db->exeSql($sql);
					$levelCode.= sprintf("%04d",$rs[0]['Idx']);
				}
			}
		}
		return $levelCode;
	}
	
	// end of class
}
?>