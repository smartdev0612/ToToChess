<?php
/*
 *
 * 설정과 관련된 테이블
 * tb_admin, tb_point_config, tb_popup
 *
*/

class ConfigModel extends Lemon_Model 
{
	
	//▶ 팝업 수정
	function modifyPopup($P_SUBJECT,$P_CONTENT,$P_POPUP_U,$P_STARTDAY,$P_ENDDAY,$P_WIN_WIDTH,$P_WIN_HEIGHT,$P_WIN_LEFT,$P_WIN_TOP,$P_MOVEURL,$imgsrc,$P_STYLE,$P_LOGIN_POPUP_U,$idx)
	{
		$sql = "UPDATE ".$this->db_qz."popup SET P_SUBJECT = '".$P_SUBJECT."',";
		$sql .= " P_CONTENT = '".$P_CONTENT."',";
        $sql .= " P_LOGIN_POPUP_U='".$P_LOGIN_POPUP_U."',";
		$sql .= " P_POPUP_U= '".$P_POPUP_U."',";
		$sql .= " P_STARTDAY='".$P_STARTDAY."',";
		$sql .= " P_ENDDAY='".$P_ENDDAY."',";
		$sql .= " P_WIN_WIDTH='".$P_WIN_WIDTH."',";
		$sql .= " P_WIN_HEIGHT='".$P_WIN_HEIGHT."',";
		$sql .= " P_WIN_LEFT='".$P_WIN_LEFT."',";
		$sql .= " P_WIN_TOP='".$P_WIN_TOP."',";
		$sql .= " P_MOVEURL='".$P_MOVEURL."',";
		$sql .= " P_FILE='".$imgsrc."',";
		$sql .= " P_STYLE = '".$P_STYLE."' WHERE IDX = ".$idx."";
			
		return $this->db->exeSql($sql);						 
	}

    function modifyEvent($P_SUBJECT, $P_POPUP_U,$imgsrc, $idx)
    {
        $sql = "UPDATE ".$this->db_qz."event SET subject = '".$P_SUBJECT."',";
        $sql .= " is_use= '".$P_POPUP_U."',";
        $sql .= " file='".$imgsrc."' ";
        $sql .= " WHERE IDX = ".$idx."";

        return $this->db->exeSql($sql);
    }
	
	//▶ 기본설정 수정
	function modifyGlobal($PARAM, $logo)
	{

		$PARAM_cnt=count((array)$PARAM);		
		
		$sql = "UPDATE ".$this->db_qz."admin SET";
		foreach($PARAM as $key=>$value){
			$value = htmlspecialchars($value, ENT_QUOTES);
			$sql .= " ".$key."='".$value."'";
			$PARAM_cnt=$PARAM_cnt-1;
			if($PARAM_cnt!=0)	$sql .= ",";
		}
		$sql .= " WHERE logo='".$logo."'";
			
		return $this->db->exeSql($sql);						 
	}

    //▶ 기본설정 수정
    function modifyMiniConfig($PARAM)
    {

        $PARAM_cnt=count((array)$PARAM);

        $sql = "UPDATE ".$this->db_qz."mini_setting SET";
        foreach($PARAM as $key=>$value){
            $value = htmlspecialchars($value, ENT_QUOTES);
            $sql .= " ".$key."='".$value."'";
            $PARAM_cnt=$PARAM_cnt-1;
            if($PARAM_cnt!=0)	$sql .= ",";
        }
		
        return $this->db->exeSql($sql);
    }
	
	//▶ 팝업 추가
	function addPopup($P_SUBJECT,$P_CONTENT,$P_POPUP_U,$P_STARTDAY,$P_ENDDAY,$P_WIN_WIDTH,$P_WIN_HEIGHT,$P_WIN_LEFT,$P_WIN_TOP,$P_MOVEURL,$imgsrc,$P_STYLE, $P_LOGIN_POPUP_U, $logo = "hi-bet")
	{
		$sql = "insert into 
						".$this->db_qz."popup (P_SUBJECT,P_CONTENT,P_LOGIN_POPUP_U,P_POPUP_U,P_WRITEDAY,P_STARTDAY,P_ENDDAY,P_WIN_WIDTH,P_WIN_HEIGHT,P_WIN_LEFT,P_WIN_TOP,P_MOVEURL,P_FILE,P_STYLE,logo)
							 VALUES   ('".$P_SUBJECT."','".$P_CONTENT."','".$P_LOGIN_POPUP_U."','".$P_POPUP_U."',now(),'".$P_STARTDAY."','".$P_ENDDAY."','".$P_WIN_WIDTH."','".$P_WIN_HEIGHT."','".$P_WIN_LEFT."','".$P_WIN_TOP."','".$P_MOVEURL."','".$imgsrc."','".$P_STYLE."','".$logo."')";
							 
		return $this->db->exeSql($sql);						 
	}

    function addEvent($P_SUBJECT, $P_POPUP_U, $imgsrc, $logo = "now")
    {
        $sql = "insert into 
						".$this->db_qz."event (subject, is_use, regdate, file, logo)
							 VALUES   ('".$P_SUBJECT."','".$P_POPUP_U."',now(),'".$imgsrc."','".$logo."')";

        return $this->db->exeSql($sql);
    }

	//▶ 팝업 sn으로  삭제
	function delPopupbySn($sn)
	{
		$sql = "delete from ".$this->db_qz."popup 
							where IDX = '".$sn."'";

		return $this->db->exeSql($sql);					
	}

    function delEventbySn($sn)
    {
        $sql = "delete from ".$this->db_qz."event 
							where IDX = '".$sn."'";

        return $this->db->exeSql($sql);
    }

    function getEventbyOrderby()
    {
        $sql="select * from ".$this->db_qz."event order by logo, IDX desc ";

        return $this->db->exeSql($sql);
    }

	function getPopupbyOrderby()
	{
		$sql="select * from ".$this->db_qz."popup order by logo, IDX desc ";	
					  
		return $this->db->exeSql($sql);								  
	}

    function getEventRow($field, $addWhere='')
    {
        $where = " 1=1";

        if($addWhere!='') {$where .=' and '.$addWhere;}
        $rs = $this->getRow($field, $this->db_qz.'event', $where);

        if ( $field == "*" ) {
            return $rs;
        } else {
            return $rs[$field];
        }
    }

	//▶ 필드 데이터
	function getPopupRow($field, $addWhere='')
	{
		$where = " 1=1";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		$rs = $this->getRow($field, $this->db_qz.'popup', $where);

		if ( $field == "*" ) {
			return $rs;
		} else {
			return $rs[$field];
		}
	}
	
	//▶ 필드 데이터's
	function getPopupRows($field, $addWhere)
	{
		$where = "1=1";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRows($field, $this->db_qz.'popup', $where);
	}

    function getEventRows($field, $addWhere)
    {
        $where = "1=1";

        if($addWhere!='') {$where .=' and '.$addWhere;}

        return $this->getRows($field, $this->db_qz.'event', $where);
    }
	
	//▶ 회원가입 무료머니
	function getJoinFreeMoney()
	{
		$rs = $this->getRow('mem_join', $this->db_qz.'point_config', " 1=1");
		return $rs['mem_join'];
	}
	
	//▶ 필드 데이터
	function getPointConfigField($field, $addWhere='')
	{
        $where = " 1=1";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'point_config', $where);
		return $rs[$field];
	}
	
	//▶ 필드 데이터's
	function getPointConfigRow($field, $addWhere='')
	{
        $where = " 1=1";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		return $this->getRow($field, $this->db_qz.'point_config', $where);
	}
	
	//▶ 필드 데이터's
	function getPointConfigRows($field, $addWhere='')
	{
        $where = " 1=1";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRows($field, $this->db_qz.'point_config', $where);
	}
	
	//▶ 포인트 설정 저장
	function savePointConfig(	$joinFreeMoney, $bonus3, $bonus4, $bonus5, $bonus6, $bonus7, $bonus8, $bonus9, $bonus10, 
    							$folderPlus,
	                            $replyPoint, $replyLimit, $boardWritePoint, $boardWriteLimit, $bettingBoardWritePoint,
                                $bettingBoardWriteLimit, $jackpot, $jackpot_rate, $day_charge_bonus, $week_charge_bonus, $month_charge_bonus, $check_money)
	{
		$folderBonus	= sprintf("%d:%d:%d:%d:%d:%d:%d:%d:", $bonus3,$bonus4,$bonus5,$bonus6,$bonus7,$bonus8,$bonus9,$bonus10);
		$sql = "update ".$this->db_qz."level_config set lev_folder_bonus='".$folderBonus."'";
		$this->db->exeSql($sql);
		
		$sql = "update ".$this->db_qz."point_config 
						set mem_join=".$joinFreeMoney.", 
							folder_bouns3=".$bonus3.",folder_bouns4=".$bonus4.",folder_bouns5=".$bonus5.",folder_bouns6=".$bonus6.",
							folder_bouns7=".$bonus7.",folder_bouns8=".$bonus8.",folder_bouns9=".$bonus9.",folder_bouns10=".$bonus10.",
							chk_folder='".$folderPlus."',
							reply_point=".$replyPoint.", reply_limit=".$replyLimit.", board_write_point=".$boardWritePoint.",
							board_write_limit=".$boardWriteLimit.", betting_board_write_point=".$bettingBoardWritePoint.", betting_board_write_limit=".$bettingBoardWriteLimit.",
							jackpot_give_rate=".$jackpot_rate.", jackpot_sum_money=".$jackpot.",
							day_charge_bonus=".$day_charge_bonus.", week_charge_bonus=".$week_charge_bonus.", month_charge_bonus=".$month_charge_bonus.", check_money=".$check_money;

		return $this->db->exeSql($sql);
	}
	
	//▶ 필드 데이터
	function getAdminConfigField($field='*', $addWhere='')
	{
        $where = " 1=1";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'admin', $where);
		return $rs[$field];
	}
	
	//▶ 필드 데이터's
	function getAdminConfigRow($field='*', $addWhere='', $logo='')
	{
        $where = " 1=1";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRow($field, $this->db_qz.'admin', $where);
	}
	
	//▶ 필드 데이터's
	function getAdminConfigRows($field='*', $addWhere='', $logo)
	{
		$where = "logo='".$logo."'";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRows($field, $this->db_qz.'admin', $where);
	}
	
	function getHead($admin_id)
	{
		$sql="select * from ".$this->db_qz."head 
						where head_id = '".$admin_id."' and kubun=1";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 어드민 설정
	function getAdminConfig()
	{
		$sql="select * from ".$this->db_qz."admin";
						
		$rs =  $this->db->exeSql($sql);
		
		return $rs[0];
	}
	
	//▶ 잭팟 갱신
	function getPointConfig()
	{
		$sql="select * from ".$this->db_qz."point_config ";
						
		$rs =  $this->db->exeSql($sql);
		return $rs[0];				
	}
	
	//▶ 잭팟 금액
	function getJackpot()
	{
		$rs = $this->getRow('jackpot_sum_money', $this->db_qz.'point_config', "1=1");
		return $rs['jackpot_sum_money'];
	}
	
	//▶ 잭팟 갱신
	function modifyJackpot($jackpot)
	{
		$sql = "update ".$this->db_qz."point_config 
				set jackpot_sum_money=jackpot_sum_money-".$jackpot;
		$this->db->exeSql($sql);
	}
	
	function getJackpotRate()
	{
		$sql = "select jackpot_give_rate from ".$this->db_qz."point_config";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['jackpot_give_rate'];
	}
	
	//▶ 잭팟 givejackpot 갱신
	function modifygiveJackpot($jackpot)
	{
		$sql = "update ".$this->db_qz."point_config 
				set jackpot_sum_money=jackpot_sum_money+".$jackpot;
		$this->db->exeSql($sql);
	}
	
	//▶ 레벨 목록
	function getLevelConfigRows($field='*', $addWhere='')
	{
        $where = " 1=1";
		if($addWhere!='') $where.=" and ".$addWhere;
		
		return $this->getRows($field, $this->db_qz.'level_config', $where);
	}
	
	//▶ 미니게임 레벨 목록
	function getMiniGameLevelConfigRows($field='*', $addWhere='')
	{		
		$where = " sn > '0'";
		if($addWhere!='') $where.=" and ".$addWhere;		
		return $this->getRows($field, $this->db_qz.'level_config_minigame', $where);
	}

	//▶ 레벨 목록
	function getLevelConfigRow($level, $field='*', $addWhere='')
	{
		$where = " lev=".$level;
		if($addWhere!='') $where.=" and ".$addWhere;
		
		return $this->getRow($field, $this->db_qz.'level_config', $where);
	}
	
	//▶ 레벨 목록
	function getLevelConfigField($level, $field, $addWhere='')
	{
		$where = "lev=".$level." and logo='{$this->logo}'";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'level_config', $where);

		return $rs[$field];
	}

	//-> 미니게임 배팅 금액설정 저장
	function savePointConfigMiniGame($sn,$sadari_min_bet,$sadari_max_bet,$sadari_max_bns,
                                     $race_min_bet,$race_max_bet,$race_max_bns,
                                     $powerball_min_bet,$powerball_max_bet,$powerball_max_bns,
                                     $dari_min_bet,$dari_max_bet,$dari_max_bns,
                                     $aladin_min_bet, $aladin_max_bet, $aladin_max_bns,
                                     $lowhi_minbet, $lowhi_maxbet, $lowhi_maxbns,
                                     $powersadari_minbet,$powersadari_maxbet,$powersadari_maxbns,
                                     $kenosadari_minbet, $kenosadari_maxbet, $kenosadari_maxbns,
                                     $mgmoddeven_minbet, $mgmoddeven_maxbet, $mgmoddeven_maxbns,
                                     $mgmbacara_minbet, $mgmbacara_maxbet, $mgmbacara_maxbns,
                                     $nine_minbet, $nine_maxbet, $nine_maxbns,
                                     $twodari_minbet, $twodari_maxbet, $twodari_maxbns,
                                     $threedari_minbet, $threedari_maxbet, $threedari_maxbns,
                                     $choice_minbet, $choice_maxbet, $choice_maxbns,
                                     $roulette_minbet, $roulette_maxbet, $roulette_maxbns,
                                     $pharaoh_minbet, $pharaoh_maxbet, $pharaoh_maxbns,
                                     $fx_minbet, $fx_maxbet, $fx_maxbns) {
		$sql = "update tb_level_config_minigame set 
						sadari_min_bet = '{$sadari_min_bet}', sadari_max_bet = '{$sadari_max_bet}', sadari_max_bns = '{$sadari_max_bns}',
						race_min_bet = '{$race_min_bet}', race_max_bet = '{$race_max_bet}', race_max_bns = '{$race_max_bns}',
						powerball_min_bet = '{$powerball_min_bet}', powerball_max_bet = '{$powerball_max_bet}', powerball_max_bns = '{$powerball_max_bns}',
						dari_min_bet = '{$dari_min_bet}', dari_max_bet = '{$dari_max_bet}', dari_max_bns = '{$dari_max_bns}',
						aladin_min_bet = '{$aladin_min_bet}', aladin_max_bet = '{$aladin_max_bet}', aladin_max_bns = '{$aladin_max_bns}',
						lowhi_min_bet = '{$lowhi_minbet}', lowhi_max_bet = '{$lowhi_maxbet}', lowhi_max_bns = '{$lowhi_maxbns}',
						powersadari_min_bet = '{$powersadari_minbet}', powersadari_max_bet = '{$powersadari_maxbet}', powersadari_max_bns = '{$powersadari_maxbns}',
						kenosadari_min_bet = '{$kenosadari_minbet}', kenosadari_max_bet = '{$kenosadari_maxbet}', kenosadari_max_bns = '{$kenosadari_maxbns}',
						mgmoddeven_min_bet = '{$mgmoddeven_minbet}', mgmoddeven_max_bet = '{$mgmoddeven_maxbet}', mgmoddeven_max_bns = '{$mgmoddeven_maxbns}',
						mgmbacara_min_bet = '{$mgmbacara_minbet}', mgmbacara_max_bet = '{$mgmbacara_maxbet}', mgmbacara_max_bns = '{$mgmbacara_maxbns}',
						nine_min_bet = '{$nine_minbet}', nine_max_bet = '{$nine_maxbet}', nine_max_bns = '{$nine_maxbns}',
						2dari_min_bet = '{$twodari_minbet}', 2dari_max_bet = '{$twodari_maxbet}', 2dari_max_bns = '{$twodari_maxbns}',
						3dari_min_bet = '{$threedari_minbet}', 3dari_max_bet = '{$threedari_maxbet}', 3dari_max_bns = '{$threedari_maxbns}',
						choice_min_bet = '{$choice_minbet}', choice_max_bet = '{$choice_maxbet}', choice_max_bns = '{$choice_maxbns}',
						roulette_min_bet = '{$roulette_minbet}', roulette_max_bet = '{$roulette_maxbet}', roulette_max_bns = '{$roulette_maxbns}',
						pharaoh_min_bet = '{$pharaoh_minbet}', pharaoh_max_bet = '{$pharaoh_maxbet}', pharaoh_max_bns = '{$pharaoh_maxbns}',
						fx_min_bet = '{$fx_minbet}', fx_max_bet = '{$fx_maxbet}', fx_max_bns = '{$fx_maxbns}'
						where sn = '{$sn}'";
		return $this->db->exeSql($sql); 
	}
	
	//▶ 레벨 설정
	function modifyLevelConfig($sn, $levName, $minMoney, $maxMoney, $maxMoneySpecial, $maxBonus, $maxBonusSpecial, $maxSingle, $maxSingleSpecial, $chargeRate, $loseRate, $recommendRate, $folderBonus, $bank, $bankAccount, $bankOwner, $minCharge, $minExchange, $recommendLimit, $domain)
	{
		$sql = "update ".$this->db_qz."level_config 
						set lev_name='".$levName."',lev_min_money=".$minMoney.",lev_max_money=".$maxMoney.",lev_max_bonus=".$maxBonus.",lev_charge_mileage_rate=".$chargeRate.", lev_bet_failed_mileage_rate=".$loseRate.",
						lev_join_recommend_mileage_rate='".$recommendRate."',lev_folder_bonus='".$folderBonus."', lev_bank='".$bank."', lev_bank_account='".$bankAccount."', lev_bank_owner='".$bankOwner."',
						lev_max_money_special='".$maxMoneySpecial."',lev_max_bonus_special='".$maxBonusSpecial."', lev_max_money_single='".$maxSingle."', lev_max_money_single_special='".$maxSingleSpecial."',lev_recommend_limit=".$recommendLimit.",
						lev_bank_min_charge=".$minCharge.", lev_bank_min_exchange=".$minExchange.", lev_domain='".$domain."'
						where Id=".$sn;
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 레벨 설정(다폴더 보너스 마일리지가 없는 경우)
	function _modifyLevelConfig($sn, $levName, $minMoney, $maxMoney, $maxMoneySpecial, $maxBonus, $maxBonusSpecial, $maxBonusCukbet, $maxBonusCukbetSpecial, $maxSingle, $maxSingleSpecial, $first_chargeRate, $chargeRate, $loseRate, $recommendRateType, $recommendRate, $bank, $bankAccount, $bankOwner, $minCharge, $minExchange, $recommendLimit, $domain)
	{
		$sql = "update ".$this->db_qz."level_config 
						set lev_name='".$levName."',lev_min_money=".$minMoney.",lev_max_money=".$maxMoney.",lev_max_bonus=".$maxBonus.",lev_max_bonus_cukbet=".$maxBonusCukbet.",lev_charge_mileage_rate=".$chargeRate.", lev_first_charge_mileage_rate=".$first_chargeRate.", lev_bet_failed_mileage_rate=".$loseRate.",
						lev_join_recommend_mileage_rate_type='".$recommendRateType."', lev_join_recommend_mileage_rate='".$recommendRate."', lev_bank='".$bank." ', lev_bank_account='".$bankAccount."', lev_bank_owner='".$bankOwner."',
						lev_max_money_special='".$maxMoneySpecial."',lev_max_bonus_special='".$maxBonusSpecial."',lev_max_bonus_cukbet_special='".$maxBonusCukbetSpecial."', lev_max_money_single='".$maxSingle."', lev_max_money_single_special='".$maxSingleSpecial."',lev_recommend_limit=".$recommendLimit.",
						lev_bank_min_charge=".$minCharge.", lev_bank_min_exchange=".$minExchange.", lev_domain='".$domain."'
						where Id=".$sn;

		return $this->db->exeSql($sql);
	}
	
	//▶ 레벨 설정 추가
	function addLevelConfig()
	{
		$sql = "select max(lev) as level
				from ".$this->db_qz."level_config";
		$rs = $this->db->exeSql($sql);
		
		$level = $rs[0]['level']+1;
		
		$sql = "insert into ".$this->db_qz."level_config(lev,lev_min_money,lev_max_money,lev_max_bonus,lev_charge_mileage_rate,lev_first_charge_mileage_rate,lev_bet_failed_mileage_rate,logo)
				values(".$level.",0,0,0,0,0,0,'memopow')";
		$this->db->exeSql($sql);

        $sql = "insert into ".$this->db_qz."level_config_minigame(user_level)
				values(".$level.")";
        $this->db->exeSql($sql);

        $sql = "insert into ".$this->db_qz."mini_odds(level)
				values(".$level.")";
        return $this->db->exeSql($sql);
	}
	
	//▶ 레벨 설정 삭제
	function delLevelConfig()
	{
		$sql = "select Id as sn, lev
				from ".$this->db_qz."level_config order by lev desc";
		$rs = $this->db->exeSql($sql);
		
		$sn = $rs[0]['sn'];
		$level = $rs[0]['lev'];
		
		$sql = "delete from ".$this->db_qz."level_config 
				where Id =".$sn;
		$this->db->exeSql($sql);

        $sql = "delete from ".$this->db_qz."level_config_minigame 
				where user_level =".$level;
        $this->db->exeSql($sql);

        $sql = "delete from ".$this->db_qz."mini_odds 
				where level =".$level;
        return  $this->db->exeSql($sql);
	}
	
	//▶ 이벤트 설정 목록
	function getEventConfigRows($field='*', $addWhere='')
	{
        $where = " 1=1";
		if($addWhere!='') $where.=" and ".$addWhere;
		
		$sql = "select ".$field."
				from ".$this->db_qz."event_config ".$where;
		return $this->db->exeSql($sql);
	}
	
	//▶ 이벤트 설정 목록
	function getEventConfigRow($field='*', $addWhere='')
	{
        $where = " 1=1";
		if($addWhere!='') $where.=" and ".$addWhere;
		
		return $this->getRow($field, $this->db_qz.'event_config', $where);
	}
	
	//▶ 이벤트 설정 목록
	function getEventConfigField($field, $addWhere='')
	{
        $where = " 1=1";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'event_config', $where);
		return $rs[$field];
	}
	
	//▶ 이벤트 설정
	function modifyEventConfig($minCharge,$bonus1,$bonus2,$bonus3,$bonus4,$bonus5,$bonus6,$bonus7,$bonus8,$bonus9,$bonus10)
	{
		$sql = "update ".$this->db_qz."event_config 
				set min_charge=".$minCharge.",bonus1=".$bonus1.",bonus2=".$bonus2.",bonus3=".$bonus3.", bonus4=".$bonus4.",
				bonus5=".$bonus5.",bonus6=".$bonus6.",bonus7=".$bonus7.", bonus8=".$bonus8.",bonus9=".$bonus9.",bonus10=".$bonus10;
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 이벤트 추가
	function addEventConfig($minCharge,$bonus1,$bonus2,$bonus3,$bonus4,$bonus5,$bonus6,$bonus7,$bonus8,$bonus9,$bonus10)
	{
		if($minCharge=='')	$minCharge	= 100000;
		if($bonus1=='')		$bonus1 	= 0;
		if($bonus2=='')		$bonus2 	= 0;
		if($bonus3=='')		$bonus3 	= 5000;
		if($bonus4=='')		$bonus4 	= 10000;
		if($bonus5=='')		$bonus5 	= 30000;
		if($bonus6=='')		$bonus6 	= 100000;
		if($bonus7=='')		$bonus7 	= 200000;
		if($bonus8=='')		$bonus8 	= 700000;
		if($bonus9=='')		$bonus9 	= 1000000;
		if($bonus10=='')	$bonus10 	= 2000000;
		
		$sql = "insert into ".$this->db_qz."event_config(min_charge,bonus1,bonus2,bonus3,bonus4,bonus5,bonus6,bonus7,bonus8,bonus9,bonus10,logo)
				values(".$minCharge.",".$bonus1.",".$bonus2.",".$bonus3.",".$bonus4.",".$bonus5.",".$bonus6.",".$bonus7.",".$bonus8.",".$bonus9.",".$bonus10."'hi-bet')";
		return $this->db->exeSql($sql);
	}
	
	//▶ 사이트 설정 목록
	function getSiteConfigRows($field='*', $addWhere='')
	{
		$where = " 1=1";
		if($addWhere!='') $where.=" and ".$addWhere;
		
		$sql = "select ".$field."
				from ".$this->db_qz."site_config ".$where;
		return $this->db->exeSql($sql);
	}
	
	//▶ 사이트 설정 목록
	function getSiteConfigRow($field='*', $addWhere='')
	{
        $where = " 1=1";
		if($addWhere!='') $where.=" and ".$addWhere;
		
		return $this->getRow($field, $this->db_qz.'site_config', $where);
	}
	
	//▶ 사이트 설정 목록
	function getSiteConfigField($field, $addWhere='')
	{
        $where = " 1=1";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'site_config', $where);
		return $rs[$field];
	}
	
	//▶ 사이트 설정
	function modifySiteConfig($betRule,$betRulevh,$betRulevu,$betRulehu,$minBetCount)
	{
		$sql = "update ".$this->db_qz."site_config 
				set bet_rule=".$betRule.",bet_rule_vh=".$betRulevh.",bet_rule_vu=".$betRulevu.",bet_rule_hu=".$betRulehu.", min_bet_count=".$minBetCount;
					
		return $this->db->exeSql($sql);
	}
	
	function addSiteConfig($betRule,$betRulevh,$betRulevu,$betRulehu,$minBetCount)
	{
		if($minBetCount=='')	$minBetCount=1;
		$sql = "insert into ".$this->db_qz."site_config(bet_rule,bet_rule_vh,bet_rule_vu,bet_rule_hu,min_bet_count,logo)
				values(".$betRule.",".$betRulevh.",".$betRulevu.",".$betRulehu.",".$minBetCount.",'hi-bet')";
		return $this->db->exeSql($sql);
	}
	
	function getDomainList()
	{
		$sql = "select * from ".$this->db_qz."domain";
		return $this->db->exeSql($sql);
	}
	
	//-> 알람 필드 숫자 증가
	function modifyAlramFlag($field, $addNum) {
		if ( $addNum == 0 ) {
			$sql = "update tb_alarm_flag set {$field} = 0 where idx = 1";
		} else {
			$sql = "update tb_alarm_flag set {$field} = {$field} + {$addNum} where idx = 1";
		}		
		return $this->db->exeSql($sql);
	}

	// -> 등급별 충전보너스
    function getLevChargeMilage($mem_sn)
    {
        //$logo = $this->logo;
        $sql = "select b.lev_charge_mileage_rate, b.lev_first_charge_mileage_rate
                from tb_people a, tb_level_config b
                where a.mem_lev = b.lev
                and a.sn = ".$mem_sn;

        return $this->db->exeSql($sql);
    }

	// -> 배팅제한설정 (원기준)
    function getSportBettingSetting($field='*', $addWhere='', $logo='')
    {
        /*$where = " 1=1";

        if($addWhere!='') {$where .=' and '.$addWhere;}

        return $this->getRow($field, $this->db_qz.'sport_betting_setting', $where);*/

        $sql = "select * from tb_sport_betting_setting ".$addWhere;
        return $this->db->exeSql($sql);
    }

	// -> 배팅제한설정 (다기준)
	function getSportBettingSettingMulti($field='*', $addWhere='', $logo='')
    {
        /*$where = " 1=1";

        if($addWhere!='') {$where .=' and '.$addWhere;}

        return $this->getRow($field, $this->db_qz.'sport_betting_setting', $where);*/

        $sql = "select * from tb_sport_betting_setting_m ".$addWhere;
        return $this->db->exeSql($sql);
    }

    function getSportBettingSettingRow($field='*', $addWhere='', $logo='')
    {
        /*$where = " 1=1";

        if($addWhere!='') {$where .=' and '.$addWhere;}

        return $this->getRow($field, $this->db_qz.'sport_betting_setting', $where);*/

        $sql = "select * from tb_sport_betting_setting ".$addWhere;
        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

    function modifySportBettingSetting($PARAM, $level)
    {

        $PARAM_cnt=count((array)$PARAM);

        $sql = "UPDATE ".$this->db_qz."sport_betting_setting SET";
        foreach($PARAM as $key=>$value){
            $value = htmlspecialchars($value, ENT_QUOTES);
            $sql .= " ".$key."='".$value."'";
            $PARAM_cnt=$PARAM_cnt-1;
            if($PARAM_cnt!=0)	$sql .= ",";
        }
        $sql .= " where level=".$level;

        return $this->db->exeSql($sql);
    }

	// 다기준
	function modifySportBettingSettingMulti($PARAM, $level)
    {

        $PARAM_cnt=count((array)$PARAM);

        $sql = "UPDATE ".$this->db_qz."sport_betting_setting_m SET";
        foreach($PARAM as $key=>$value){
            $value = htmlspecialchars($value, ENT_QUOTES);
            $sql .= " ".$key."='".$value."'";
            $PARAM_cnt=$PARAM_cnt-1;
            if($PARAM_cnt!=0)	$sql .= ",";
        }
        $sql .= " where level=".$level;

        return $this->db->exeSql($sql);
    }

    function getMiniConfigRow($field='*', $addWhere='', $logo='')
    {
        $where = " 1=1";

        if($addWhere!='') {$where .=' and '.$addWhere;}

        return $this->getRow($field, $this->db_qz.'mini_setting', $where);
    }

    function getMiniOddsRow($field='*', $addWhere='', $logo='')
    {
        $where = " 1=1";

        if($addWhere!='') {$where .=' and '.$addWhere;}

        return $this->getRow($field, $this->db_qz.'mini_odds', $where);
    }

    function modifyOddsConfig($PARAM)
    {

        $PARAM_cnt=count((array)$PARAM);
        $level = $PARAM['lev'];

		$sql = "SELECT * FROM ".$this->db_qz."mini_odds WHERE level = ". $level;
        $rs = $this->db->exeSql($sql);
		if(count((array)$rs) == 0) {
			$sql = "INSERT INTO ".$this->db_qz."mini_odds ( ";
			$cnt = 0;
			foreach($PARAM as $key=>$value){
				$cnt++;
				if($key == 'lev') {
					$sql .= "level,";
				} else {
					if($cnt < count($PARAM)) {
						$sql .= $key . ",";
					} else {
						$sql .= $key . " ) VALUES ( ";
					}
				}
			}

			$cnt = 0;
			foreach($PARAM as $key=>$value){
				$cnt++;
				if($cnt < count($PARAM)) {
					$sql .= "'" . $value . "',";
				} else {
					$sql .= "'" . $value . "')";
				}
			}

			$this->db->exeSql($sql);
			return 1;
		} else {
			$sql = "UPDATE ".$this->db_qz."mini_odds SET";
			foreach($PARAM as $key=>$value){
				if($key == 'lev') continue;

				$value = htmlspecialchars($value, ENT_QUOTES);
				$sql .= " ".$key."='".$value."'";
				$PARAM_cnt=$PARAM_cnt-1;
				if($PARAM_cnt!=1)	$sql .= ",";
			}
			$sql .= " where level=".$level;
		}
		
        return $this->db->exeSql($sql);
    }

	function getCrossLimitCount($type = 0) {
		$sql = "SELECT count(*) as cnt FROM tb_cross_limit WHERE type_id = " . $type;
		$res = $this->db->exeSql($sql);
		$count = 0;
		if(count((array)$res) > 0) {
			$count = $res[0]["cnt"];
		}
		return $count;
	}
}

?>