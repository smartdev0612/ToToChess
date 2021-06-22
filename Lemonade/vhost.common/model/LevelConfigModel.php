<?php
/*
 *
 * 레벨별 설정 파일을 처리하는 모델
 *
*/
class LevelConfigModel extends Lemon_Model
{
	public $memberModel	="";
	public $configModel	="";
	
	function __construct()
	{
		$this->memberModel 	= Lemon_Instance::getObject("MemberModel",true);
		$this->configModel 	= Lemon_Instance::getObject("ConfigModel",true);
	}
	
	function getMemberLevel($memberSn)
	{
		return $this->memberModel->getMemberField($memberSn,'mem_lev');
	}
	
	//▶ 폴더보너스
	function getMemberFolderBounsRate($memberSn, $bettingCount)
	{
		$level	= $this->getMemberLevel($memberSn);
		
		$field  = $this->configModel->getLevelConfigRow($level,"lev_folder_bonus");
		$folderBonuses = explode(":", $field['lev_folder_bonus']);
		
		switch($bettingCount)
		{
			case 3:  $rate=$folderBonuses[0]; break;
			case 4:  $rate=$folderBonuses[1]; break;
			case 5:  $rate=$folderBonuses[2]; break;
			case 6:  $rate=$folderBonuses[3]; break;
			case 7:  $rate=$folderBonuses[4]; break;
			case 8:  $rate=$folderBonuses[5]; break;
			case 9:  $rate=$folderBonuses[6]; break;
			case 10: $rate=$folderBonuses[7]; break;
		}
		return $rate;
	}
}
?>