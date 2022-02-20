<?php

class GameFinModel extends Lemon_Model 
{
	function finProcess()
	{
		$process_model = Lemon_Instance::getObject("ProcessModel",true);
		
		$sql = "select a.sn, a.vender_sn, a.home_score, a.away_score, a.is_cancel, a.state 
					from tb_vender_game_fin a, tb_child b  
					where a.vender_sn=b.vender_sn and a.state=0 and a.vender_sn > 0";
		$rows = $this->db->exeSql($sql);
		
		for( $i=0; $i < count((array)$rows); ++$i)
		{
			$vender_sn = $rows[$i]['vender_sn'];
			
			if($vender_sn=="")
				continue;
				
			$sql = "select * from tb_child where vender_sn=".$vender_sn;
			$game_rows = $this->db->exeSql($sql);
			if( $game_rows[0]['kubun']==1)
			{
			}
			else
			{				
				$game_sn = $game_rows[0]['sn'];
				
				if($game_sn=="")
					continue;
					
				/*��������� ������ �ع����� ����̿�����, 
				��ȹ�� ����
				���ھ �Է��� �ϰ� ������ ���� ������� �����
				*/
				//����ó����� �� ��� �ּ� ����
				//$process_model->resultGameProcessing($game_sn, $rows[$i]['home_score'], $rows[$i]['away_score'], $rows[$i]['is_cancel']);
				
				//���ھ �Է��� ���
				//Begin
				$home_score = $rows[$i]['home_score'];
				$away_score = $rows[$i]['away_score'];
				
				unset($data);
				$data['home_score'] = $home_score;
				$data['away_score'] = $away_score;
				
				$this->db->setUpdate("tb_child", $data, "sn=".$game_sn);
				$result = $this->db->exeSql();
				//End
			}
			
			unset($data);
			
			$data['state']=1;
			$this->db->setUpdate("tb_vender_game_fin", $data, "sn=".$rows[$i]['sn']);
			$result = $this->db->exeSql();
			
			unset($data);
		}
	}
}

?>