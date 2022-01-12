<?php
header("Content-Type: text/html; charset=UTF-8");   
class ConfigController extends WebServiceController 
{
	//▶ 기본 설정
	function globalconfigAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/config/global_config.html");
		
		$logo = $this->request('logo');
		if($logo=='')
			$logo = $this->logo;
		
		$model = $this->getModel("ConfigModel");
		$list = $model->getAdminConfigRow("*", "", $logo);
		
		$this->view->assign( "list", $list);
		$this->view->assign( "logo", $logo);
			
		$this->display();
	}
	
	//▶ 기본 설정 수정
	function globalProcessAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/config/global_config.html");
		
		
		$adminConfigArr	= $_POST;
		
		$logo = $this->request('logo');
		if($logo=='')
			$logo = $this->logo;

		$rs=$this->getModel("ConfigModel")->modifyGlobal($adminConfigArr, $logo);
		
		if($rs>0)
		{
			throw new Lemon_ScriptException("수정되었습니다.","","go","/config/globalconfig?logo=".$logo);
		}
		else{
			throw new Lemon_ScriptException("변경내역이 없거나 정상처리 되지 않았습니다..","","go","/config/globalconfig?logo=".$logo);
			exit;
		}
		
		//$this->globalconfigAction();
	}

    function miniconfigProcessAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/mini_config.html");


        $adminConfigArr	= $_POST;

        $logo = $this->request('logo');
        if($logo=='')
            $logo = $this->logo;

        $rs=$this->getModel("ConfigModel")->modifyMiniConfig($adminConfigArr, $logo);

        if($rs>0)
        {
            throw new Lemon_ScriptException("수정되었습니다.","","go","/config/miniconfig");
        }
        else{
            throw new Lemon_ScriptException("변경내역이 없거나 정상처리 되지 않았습니다..","","go","/config/miniconfig");
            exit;
        }

        //$this->globalconfigAction();
    }

	function miniUseConfigProcessAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/mini_config.html");


        $adminConfigArr	= $_POST;

        $logo = $this->request('logo');
        if($logo=='')
            $logo = $this->logo;

        $rs=$this->getModel("ConfigModel")->modifyMiniConfig($adminConfigArr, $logo);

        if($rs>0)
        {
            throw new Lemon_ScriptException("수정되었습니다.","","go","/config/miniUseConfig");
        }
        else{
            throw new Lemon_ScriptException("변경내역이 없거나 정상처리 되지 않았습니다..","","go","/config/miniUseConfig");
            exit;
        }

        //$this->globalconfigAction();
    }

	// 조합배팅제한
    function crosslimitAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }

        $this->view->define("content","content/config/cross_limit.html");

		$model 	= $this->getModel("GameModel");

		$act = empty($this->request('act')) ? "" : $this->request('act');

		if($act == "save") {
			$limit_id = empty($this->request('limit_id')) ? 0 : $this->request('limit_id');
			$cross_script = empty($this->request('cross_script')) ? "" : $this->request('cross_script');
			$type_id = empty($this->request('type_id')) ? 0 : $this->request('type_id');
			$sport_id = empty($this->request('sport_id')) ? 0 : $this->request('sport_id');

			$model->saveCrossScript($limit_id, $cross_script, $type_id, $sport_id);

			throw new Lemon_ScriptException("","","script","alert('성공적으로 보관되였습니다.'); opener.document.location.reload(); self.close();");
		} else if ($act == "delete") {
			$limit_id = empty($this->request('limit_id')) ? 0 : $this->request('limit_id');
			$model->deleteCrossScript($limit_id);
		}
		
	
		$list = $model->getCrossMarkets();
		$sportlist = $model->getSportList();
		$crossLimitList = $model->getCrossLimitList();

        $this->view->assign( "list", $list);
		$this->view->assign( "sportlist", $sportlist);
		$this->view->assign( "crossLimitList", $crossLimitList);

        $this->display();
    }

	// 배팅제한을 위한 마켓목록 가져오기
	function getCrossMarketsAction() {
		$sport_id = empty($this->request('sport_id')) ? 0 : $this->request('sport_id');
		$market_name = empty($this->request('market_name')) ? "" : $this->request('market_name');

		$model 	= $this->getModel("GameModel");

		$list = $model->getCrossMarkets($sport_id, $market_name);
		echo json_encode($list);
	}

	// 배팅제한 (원기준)
    function sportlimitAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/sport_limit.html");

        $logo = $this->request('logo');
        if($logo=='')
            $logo = $this->logo;

        $model = $this->getModel("ConfigModel");
        $list = $model->getSportBettingSetting("*", "", $logo);

        $this->view->assign( "list", $list);
        $this->view->assign( "logo", $logo);

        $this->display();
    }

	// 배팅제한 (다기준)
    function sportlimitMultiAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/sport_limit_multi.html");

        $logo = $this->request('logo');
        if($logo=='')
            $logo = $this->logo;

        $model = $this->getModel("ConfigModel");
        $list = $model->getSportBettingSettingMulti("*", "", $logo);

        $this->view->assign( "list", $list);
        $this->view->assign( "logo", $logo);

        $this->display();
    }

    function sportlimitProcessAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/sport_limit.html");


        $adminConfigArr	= $_POST;
        $level = $this->request('level');
        $logo = $this->request('logo');
        if($logo=='')
            $logo = $this->logo;

        $rs=$this->getModel("ConfigModel")->modifySportBettingSetting($adminConfigArr, $level);

        if($rs>0)
        {
            throw new Lemon_ScriptException("수정되었습니다.","","go","/config/sportlimit");
        }
        else{
            throw new Lemon_ScriptException("변경내역이 없거나 정상처리 되지 않았습니다..","","go","/config/sportlimit");
            exit;
        }

        //$this->globalconfigAction();
    }

	// 다기준
	function sportlimitProcessMultiAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/sport_limit_multi.html");


        $adminConfigArr	= $_POST;
        $level = $this->request('level');
        $logo = $this->request('logo');
        if($logo=='')
            $logo = $this->logo;

        $rs=$this->getModel("ConfigModel")->modifySportBettingSettingMulti($adminConfigArr, $level);

        if($rs>0)
        {
            throw new Lemon_ScriptException("수정되었습니다.","","go","/config/sportlimitMulti");
        }
        else{
            throw new Lemon_ScriptException("변경내역이 없거나 정상처리 되지 않았습니다..","","go","/config/sportlimitMulti");
            exit;
        }

        //$this->globalconfigAction();
    }

    function miniconfigAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/mini_config.html");

        $logo = $this->request('logo');
        if($logo=='')
            $logo = $this->logo;

        $model = $this->getModel("ConfigModel");
        $list = $model->getMiniConfigRow("*", "", $logo);

        $this->view->assign( "list", $list);
        $this->view->assign( "logo", $logo);

        $this->display();
    }

    function minioddsAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/mini_odds.html");

        $logo = $this->request('logo');
        $lev = $this->request('lev');

        if($logo=='')
            $logo = $this->logo;

        $model = $this->getModel("ConfigModel");
        $list = $model->getMiniOddsRow("*", "level=".$lev, $logo);
        $configRows  = $model->getLevelConfigRows();
		$minigameSetting = $model->getMiniConfigRow("*", "", $logo);

        $this->view->assign('config_rows', $configRows);
        $this->view->assign( "list", $list);
		$this->view->assign( "minigameSetting", $minigameSetting);
        $this->view->assign( "logo", $logo);
        $this->view->assign( "lev", $lev);

        $this->display();
    }

    function minioddsProcessAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/mini_odds.html");

        $adminConfigArr	= $_POST;
        $lev = $this->request('lev');
        $logo = $this->request('logo');
        if($logo=='')
            $logo = $this->logo;

        $rs=$this->getModel("ConfigModel")->modifyOddsConfig($adminConfigArr, $lev, $logo);
		
        if($rs>0)
        {
            throw new Lemon_ScriptException("수정되었습니다.","","go","/config/miniodds?lev=".$lev);
        }
        else{
            throw new Lemon_ScriptException("변경내역이 없거나 정상처리 되지 않았습니다..","","go","/config/miniodds?lev=".$lev);
            exit;
        }

        //$this->globalconfigAction();
    }

	//▶ 포인트 설정
	function pointAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/config/point.html");
		
		$configModel = $this->getModel("ConfigModel");
	
		$field = "*";		

		$item = $configModel->getPointConfigRow($field);

		$this->view->assign('item', $item);	
		
		$this->display();
	}
	
	//▶ 레벨 설정
	function levelAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/config/level.html");
		
		$model = $this->getModel("ConfigModel");
		
		$mode = $this->request('mode');
		if($mode=='save')
		{
			$sn								= $this->request('sn');
			$levelName 				= $this->request('lev_name');
			
			$minMoney 				= $this->request('min_money');
			$minMoney 				= str_replace(",","",$minMoney);
			
			$maxMoney 				= $this->request('max_money');
			$maxMoney 				= str_replace(",","",$maxMoney);
			
			$maxMoneySpecial 	= $this->request('max_money_special');
			$maxMoneySpecial 	= str_replace(",","",$maxMoneySpecial);
			
			$maxBonus 		= $this->request('max_bonus');
			$maxBonus 		= str_replace(",","",$maxBonus);
			
			$maxBonusSpecial 		= $this->request('max_bonus_special');
			$maxBonusSpecial 		= str_replace(",","",$maxBonusSpecial);

			$maxBonusCukbet 		= $this->request('max_bonus_cukbet');
			$maxBonusCukbet 		= str_replace(",","",$maxBonusCukbet);
			
			$maxBonusCukbetSpecial 		= $this->request('max_bonus_cukbet_special');
			$maxBonusCukbetSpecial 		= str_replace(",","",$maxBonusCukbetSpecial);			

			$maxMoney 		= $this->request('max_money');
			$maxMoney 		= str_replace(",","",$maxMoney);
			
			$maxSingle 		= $this->request('max_money_single');
			$maxSingle 		= str_replace(",","",$maxSingle);
			
			$maxSingleSpecial 		= $this->request('max_money_single_special');
			$maxSingleSpecial 		= str_replace(",","",$maxSingleSpecial);

            $first_chargeRate 	= $this->request('first_charge_rate');
			$chargeRate 	= $this->request('charge_rate');
			$loseRate 		= $this->request('lose_rate');

			$recommendRateType	= $this->request('recommend_rate_type');
			$recommendRate	= $this->request('recommend_rate');
			$recommendRate2	= $this->request('recommend_rate2');

			/*
			$folderBonus3 	= $this->request('folder_bonus3');
			$folderBonus4 	= $this->request('folder_bonus4');
			$folderBonus5 	= $this->request('folder_bonus5');
			$folderBonus6	= $this->request('folder_bonus6');
			$folderBonus7 	= $this->request('folder_bonus7');
			$folderBonus8 	= $this->request('folder_bonus8');
			$folderBonus9 	= $this->request('folder_bonus9');
			$folderBonus10 	= $this->request('folder_bonus10');
			*/
			/*
			$bank			= $this->request('bank');
			$bankAccount	= $this->request('bank_account');
			$bankOwner		= $this->request('bank_owner');
			*/
			$minCharge		= $this->request('min_charge');
			$minCharge 		= str_replace(",","",$minCharge);
			$minExchange		= $this->request('min_exchange');
			$minExchange 		= str_replace(",","",$minExchange);

			$recommendRate  = sprintf("%d:%d:%d", $recommendRate, $recommendRate2, 0);
			//$folderBonus	= sprintf("%d:%d:%d:%d:%d:%d:%d:%d:", $folderBonus3,$folderBonus4,$folderBonus5,$folderBonus6,$folderBonus7,$folderBonus8,$folderBonus9,$folderBonus10);
			
			$recommendLimit = $this->request('recommend_limit');
            $recommendLimit 		= str_replace(",","",$recommendLimit);
			$domain					= $this->request('domain_name');

			//등급별 다폴더보너스 마일리지를 사용하는 경우
			//$rs = $model->modifyLevelConfig($sn, $levelName, $minMoney, $maxMoney, $maxMoneySpecial, $maxBonus, $maxBonusSpecial, $maxSingle, $maxSingleSpecial, $chargeRate, $loseRate, $recommendRate, $folderBonus, $bank, $bankAccount, $bankOwner, $minCharge, $minExchange, $recommendLimit);
			
 			$rs = $model->_modifyLevelConfig($sn, $levelName, $minMoney, $maxMoney, $maxMoneySpecial, $maxBonus, $maxBonusSpecial, $maxBonusCukbet, $maxBonusCukbetSpecial, $maxSingle, $maxSingleSpecial, $first_chargeRate, $chargeRate, $loseRate, $recommendRateType, $recommendRate, $bank, $bankAccount, $bankOwner, $minCharge, $minExchange, $recommendLimit, $domain);
			
			if($rs>0)
			{
				throw new Lemon_ScriptException("변경되었습니다.","","go","/config/level");
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("변경에 실패하였습니다.","","go","/config/level");
				exit;
			}
		}
		else if( $mode == 'add' )
		{
			$model->addLevelConfig();
		}
		else if( $mode == 'del' )
		{
			$model->delLevelConfig();
		}
		
		$list = $model->getLevelConfigRows('*');
		$list_minigame = $model->getMiniGameLevelConfigRows('*');

		$domain_list=$model->getDomainList();

		for($i=0; $i<count((array)$list); ++$i)
		{
			$array = explode(':', $list[$i]['lev_join_recommend_mileage_rate']);
				
			$list[$i]['lev_join_recommend_mileage_rate_1'] = $array[0];
			$list[$i]['lev_join_recommend_mileage_rate_2'] = $array[1];
			$list[$i]['lev_join_recommend_mileage_rate_3'] = $array[2];
				
			$array = explode(':', $list[$i]['lev_folder_bonus']);
			$list[$i]['lev_folder_bonus_3']  = $array[0];
			$list[$i]['lev_folder_bonus_4']  = $array[1];
			$list[$i]['lev_folder_bonus_5']  = $array[2];
			$list[$i]['lev_folder_bonus_6']  = $array[3];
			$list[$i]['lev_folder_bonus_7']  = $array[4];
			$list[$i]['lev_folder_bonus_8']  = $array[5];
			$list[$i]['lev_folder_bonus_9']  = $array[6];
			$list[$i]['lev_folder_bonus_10'] = $array[7];
			
			$list[$i]['domain_list'] = $domain_list;
		}
	
		$this->view->assign('list', $list);	
		$this->view->assign('list_minigame', $list_minigame);	
		$this->display();
	}

	//-> 미니게임 포인트 설정 저장
	function pointSaveMiniGameAction() {
		$this->commonDefine();

		if(!$this->auth->isLogin()) {
			$this->redirect("/login");
			exit;
		}

		$model = $this->getModel("ConfigModel");
		$sn = $this->request("sn");
		$sadari_min_bet = str_replace(",","",$this->request("sminbet"));
		$sadari_max_bet = str_replace(",","",$this->request("smaxbet"));
		$sadari_max_bns = str_replace(",","",$this->request("smaxbns"));
		$race_min_bet = str_replace(",","",$this->request("rminbet"));
		$race_max_bet = str_replace(",","",$this->request("rmaxbet"));
		$race_max_bns = str_replace(",","",$this->request("rmaxbns"));
		$powerball_min_bet = str_replace(",","",$this->request("pminbet"));
		$powerball_max_bet = str_replace(",","",$this->request("pmaxbet"));
		$powerball_max_bns = str_replace(",","",$this->request("pmaxbns"));
		$dari_min_bet = str_replace(",","",$this->request("dminbet"));
		$dari_max_bet = str_replace(",","",$this->request("dmaxbet"));
		$dari_max_bns = str_replace(",","",$this->request("dmaxbns"));
        $aladin_min_bet = str_replace(",","",$this->request("aladin_minbet"));
        $aladin_max_bet = str_replace(",","",$this->request("aladin_maxbet"));
        $aladin_max_bns = str_replace(",","",$this->request("aladin_maxbns"));
        $lowhi_minbet = str_replace(",","",$this->request("lowhi_minbet"));
        $lowhi_maxbet = str_replace(",","",$this->request("lowhi_maxbet"));
        $lowhi_maxbns = str_replace(",","",$this->request("lowhi_maxbns"));
        $powersadari_minbet = str_replace(",","",$this->request("powersadari_minbet"));
        $powersadari_maxbet = str_replace(",","",$this->request("powersadari_maxbet"));
        $powersadari_maxbns = str_replace(",","",$this->request("powersadari_maxbns"));
        $kenosadari_minbet = str_replace(",","",$this->request("kenosadari_minbet"));
        $kenosadari_maxbet = str_replace(",","",$this->request("kenosadari_maxbet"));
        $kenosadari_maxbns = str_replace(",","",$this->request("kenosadari_maxbns"));
        $mgmoddeven_minbet = str_replace(",","",$this->request("mgmoddeven_minbet"));
        $mgmoddeven_maxbet = str_replace(",","",$this->request("mgmoddeven_maxbet"));
        $mgmoddeven_maxbns = str_replace(",","",$this->request("mgmoddeven_maxbns"));
        $mgmbacara_minbet = str_replace(",","",$this->request("mgmbacara_minbet"));
        $mgmbacara_maxbet = str_replace(",","",$this->request("mgmbacara_maxbet"));
        $mgmbacara_maxbns = str_replace(",","",$this->request("mgmbacara_maxbns"));
        $nine_minbet = str_replace(",","",$this->request("nine_minbet"));
        $nine_maxbet = str_replace(",","",$this->request("nine_maxbet"));
        $nine_maxbns = str_replace(",","",$this->request("nine_maxbns"));
        $twodari_minbet = str_replace(",","",$this->request("twodari_minbet"));
        $twodari_maxbet = str_replace(",","",$this->request("twodari_maxbet"));
        $twodari_maxbns = str_replace(",","",$this->request("twodari_maxbns"));
        $threedari_minbet = str_replace(",","",$this->request("threedari_minbet"));
        $threedari_maxbet = str_replace(",","",$this->request("threedari_maxbet"));
        $threedari_maxbns = str_replace(",","",$this->request("threedari_maxbns"));
        $choice_minbet = str_replace(",","",$this->request("choice_minbet"));
        $choice_maxbet = str_replace(",","",$this->request("choice_maxbet"));
        $choice_maxbns = str_replace(",","",$this->request("choice_maxbns"));
        $roulette_minbet = str_replace(",","",$this->request("roulette_minbet"));
        $roulette_maxbet = str_replace(",","",$this->request("roulette_maxbet"));
        $roulette_maxbns = str_replace(",","",$this->request("roulette_maxbns"));
        $pharaoh_minbet = str_replace(",","",$this->request("pharaoh_minbet"));
        $pharaoh_maxbet = str_replace(",","",$this->request("pharaoh_maxbet"));
        $pharaoh_maxbns = str_replace(",","",$this->request("pharaoh_maxbns"));
        $fx_minbet = str_replace(",","",$this->request("fx_minbet"));
        $fx_maxbet = str_replace(",","",$this->request("fx_maxbet"));
        $fx_maxbns = str_replace(",","",$this->request("fx_maxbns"));


		$model = $this->getModel("ConfigModel");
		$res = $model->savePointConfigMiniGame(
		    $sn,$sadari_min_bet,$sadari_max_bet,$sadari_max_bns,
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
            $fx_minbet, $fx_maxbet, $fx_maxbns
            );
		if ( $res ) echo json_encode(array("result"=>"ok"));
		else echo json_encode(array("result"=>"error"));
	}
	
	//▶ 포인트 설정 저장
	function pointSaveProcessAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$model = $this->getModel("ConfigModel");
		//
		$joinFreeMoney 		= $this->request("mem_join");
		$folder_bouns3 		= $this->request("folder_bouns3");
		$folder_bouns4 		= $this->request("folder_bouns4");
		$folder_bouns5 		= $this->request("folder_bouns5");
		$folder_bouns6 		= $this->request("folder_bouns6");
		$folder_bouns7 		= $this->request("folder_bouns7");
		$folder_bouns8 		= $this->request("folder_bouns8");
		$folder_bouns9 		= $this->request("folder_bouns9");
		$folder_bouns10 	= $this->request("folder_bouns10");
		$chk_folder 			= $this->request("chk_folder");
		
		$replyPoint				= $this->request("reply_point");
		$replyLimit				= $this->request("reply_limit");
		
		$boardWritePoint				= $this->request("board_write_point");
		$boardWriteLimit				= $this->request("board_write_limit");
		$bettingBoardWritePoint	= $this->request("betting_board_write_point");
		$bettingBoardWriteLimit	= $this->request("betting_board_write_limit");
		$jackpot = $this->request("jackpot_sum_money");
		$jackpot_rate = $this->request("jackpot_give_rate");
		$day_charge_bonus = $this->request("day_charge_bonus");
        $week_charge_bonus = $this->request("week_charge_bonus");
        $month_charge_bonus = $this->request("month_charge_bonus");
        $check_money = $this->request("check_money");

		$model->savePointConfig($joinFreeMoney, $folder_bouns3, $folder_bouns4, $folder_bouns5, $folder_bouns6, 
			$folder_bouns7, $folder_bouns8, $folder_bouns9, $folder_bouns10, $chk_folder,
            $replyPoint, $replyLimit, $boardWritePoint, $boardWriteLimit, $bettingBoardWritePoint,
            $bettingBoardWriteLimit, $jackpot, $jackpot_rate,
            $day_charge_bonus, $week_charge_bonus, $month_charge_bonus, $check_money);
		
		throw new Lemon_ScriptException("올바르게 수정되었습니다.","","go","/config/point");
		
	}
	
	//▶ 이벤트 설정
	function eventAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/config/event.html");
		
		$model = $this->getModel("ConfigModel");
		
		$mode = $this->request("mode");
		$item = $model->getEventConfigRow();
		if($mode=="save")
		{
			$minCharge	= $this->request("min_charge");
			$bonus1		= $this->request("bonus1");
			$bonus2		= $this->request("bonus2");
			$bonus3		= $this->request("bonus3");
			$bonus4		= $this->request("bonus4");
			$bonus5		= $this->request("bonus5");
			$bonus6		= $this->request("bonus6");
			$bonus7		= $this->request("bonus7");
			$bonus8		= $this->request("bonus8");
			$bonus9		= $this->request("bonus9");
			$bonus10	= $this->request("bonus10");
			
			
			if($item['sn']=='') {$rs = $model->addEventConfig($minCharge,$bonus1,$bonus2,$bonus3,$bonus4,$bonus5,$bonus6,$bonus7,$bonus8,$bonus9,$bonus10);}
			else				{$rs = $model->modifyEventConfig($minCharge,$bonus1,$bonus2,$bonus3,$bonus4,$bonus5,$bonus6,$bonus7,$bonus8,$bonus9,$bonus10);}
			
			if($rs>0)
			{
				throw new Lemon_ScriptException("변경되었습니다.","","go","/config/event");
				exit;
			}
		}
		
		$this->view->assign('item', $item);	
		$this->display();
	}

    function eventlistAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/event.list.html");

        $model = $this->getModel("ConfigModel");

        $conf = Lemon_Configure::readConfig('config');
        if($conf['site']!='')
        {
            $UPLOAD_URL	 = $conf['site']['upload_url'];
            $SITE_DOMAIN = $conf['site']['site_domain'];
        }
        $ph_path  = $UPLOAD_URL."/upload/popup/";

        $act = $this->request("act");
        $idx = $this->request("idx");
        if($act == "del")
        {
            $rs =	$model->getPopupRow("P_FILE", "IDX=".$idx."" );
            if( count((array) $rs ) > 0 )
            {
                if(file_exists($ph_path.$rs))
                {
                    unlink($ph_path.$rs);
                }
            }
            $model->delEventbySn( $idx );
        }

        $list = $model->getEventRows('*','');

        $this->view->assign('list', $list);
        $this->view->assign('ph_path', $ph_path);

        $this->display();
    }

    function eventaddAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/event.add.html");

        $model = $this->getModel("ConfigModel");

        $act = $this->request("act");
        $idx = $this->request("idx");
        $logo = $this->request("logo");

        if($logo=='') $logo = $this->logo;

        if($act=="edit")
        {
            $rs =	$model->getEventRows("*", "IDX=".$idx." and logo='".$logo."'" );


            $rs[0]['P_CONTENT'] = str_replace("<br />","",$rs[0]['P_CONTENT']);

            //print_r($rs);
            $this->view->assign( 'list', $rs[0]);
            $this->view->assign( 'act', $act);
            $this->view->assign( 'idx', $idx);
            $this->view->assign( 'logo', $logo);

        }

        $this->display();
    }

    function eventProcessAction()
    {
        $model = $this->getModel("ConfigModel");

        $act = $this->request("act");
        $idx = $this->request("idx");
        $logo = $this->request("logo");
        if($logo=='') $logo = $this->logo;
        if($act=='') $act="add";

        if ( $_FILES["P_FILE"]["size"] > 0 and $_FILES["P_FILE"]["error"] == 0 ) {
            //-> ini 파일에 파일 저장 경로 정보 가져옴.
            /*$uploadInfo = Lemon_Configure::readConfig('config');
            $upload_sitecode = $uploadInfo['site']['site_code'];
            $upload_domain = $uploadInfo['site']['file_domain'];
            $upload_ip = $uploadInfo['ftp']['ip'];
            $upload_port = $uploadInfo['ftp']['port'];
            $upload_user = $uploadInfo['ftp']['user'];
            $upload_passwd = $uploadInfo['ftp']['passwd'];*/
            $upload_domain = "http://sonalk.com";
            $img_dir = "/home/gadget/www_gadget_1.com/vhost.user/upload/popup/";
            $img_dir2 = "/home/gadget/www_gadget_1.com/vhost.manager/upload/popup/";
            $img_dir3 = "/home/gadget/www_gadget_1.com/m.vhost.user/upload/popup/";
            /*$img_dir = "C:\\xampp\\htdocs\\black\\vhost.user\\upload\\popup\\";
            $img_dir2 = "C:\\xampp\\htdocs\\black\\vhost.manager\\upload\\popup\\";
            $img_dir3 = "C:\\xampp\\htdocs\\black\\m.vhost.user\\upload\\popup\\";*/

            //-> 파일 사이즈 체크. (최대 2MB
            if ( $_FILES["P_FILE"]["size"] > 2000000 ) {
                throw new Lemon_ScriptException("첨부 파일 용량은 최대 2메가 입니다.","","back");
                exit;
            }

            //-> 파일 확장자 체크.
            $imgCheckType = array("^","image/jpeg","image/jpg","image/gif","image/png");
            if ( array_search($_FILES["P_FILE"]["type"], $imgCheckType) > 0 ) {

                //-> 파일에 확장자 추출.
                $fileType = explode(".",$_FILES["P_FILE"]["name"]);
                $fileTypeName = $fileType[count($fileType)-1];

                //-> 파일명은 년월일시분초
                $fileName = date("YmdHis").".".$fileTypeName;

                /*$fp = fopen($_FILES['P_FILE']['tmp_name'], 'r');
                $conn_id = ftp_connect($upload_ip, $upload_port);

                $login_result = ftp_login($conn_id, $upload_user, $upload_passwd);
                ftp_chdir($conn_id, $upload_sitecode);*/

                //if ( !ftp_fput($conn_id, $fileName, $fp, FTP_BINARY) )
                if (is_dir($img_dir) && is_writable($img_dir))
                {
                    if ( ! move_uploaded_file($_FILES["P_FILE"]["tmp_name"] , $img_dir . $fileName))
                    {
                        throw new Lemon_ScriptException("파일 업로드를 실패 했습니다. 관리자에게 문의해주세요.","","back");
                        exit;
                    }
                } else {
                    throw new Lemon_ScriptException("파일 업로드를 실패 했습니다. 관리자에게 문의해주세요.","","back");
                    exit;
                }

                copy($img_dir . $fileName, $img_dir2 . $fileName);
                copy($img_dir . $fileName, $img_dir3 . $fileName);

                /*ftp_close($conn_id);
                fclose($fp);*/

                //-> DB저장될 파일 풀경로.
                //$imgsrc = $upload_domain."/upload/popup/".$fileName;
                $imgsrc = "/upload/popup/".$fileName;
            } else {
                throw new Lemon_ScriptException("jpg, gif, png 파일만 업로드 가능합니다.","","back");
                exit;
            }
        }

        $P_SUBJECT 			= $this->request("P_SUBJECT");				/// 제목
        $P_POPUP_U 			= $this->request("P_POPUP_U");				/// 팝업 사용유무
        $P_STARTDAY 		= $this->request("P_STARTDAY");			/// 시작일
        $P_ENDDAY 			= $this->request("P_ENDDAY");				/// 마감일
        $P_WIN_WIDTH 		= $this->request("P_WIN_WIDTH");			/// 팝업창 가로 사이즈
        $P_WIN_HEIGHT 	= $this->request("P_WIN_HEIGHT");		/// 팝업창 세로 사이지
        $P_WIN_LEFT 		= $this->request("P_WIN_LEFT");			/// 팝업 위치
        $P_WIN_TOP 			= $this->request("P_WIN_TOP");				/// 팝업 위치
        $P_STYLE 				= $this->request("P_STYLE");					/// 바디 스타일 이미지 통 또는 html
        $P_MOVEURL 			= $this->request("P_MOVEURL");				/// 이미지 통일 경우 클릭시 이동할 주소
        $P_CONTENT 			= $this->request("P_CONTENT");				/// Html 내용
        $P_LOGIN_POPUP_U 			= $this->request("P_LOGIN_POPUP_U");
        if($P_LOGIN_POPUP_U === "on")
            $P_LOGIN_POPUP_U = "Y";
        else
            $P_LOGIN_POPUP_U = "N";

        $P_CONTENT = nl2br($P_CONTENT);

        if ($P_WIN_WIDTH == "") $P_WIN_WIDTH = 0;
        if ($P_WIN_HEIGHT == "") $P_WIN_HEIGHT = 0;
        if ($P_WIN_LEFT == "") $P_WIN_LEFT = 0;
        if ($P_WIN_TOP == "") $P_WIN_TOP = 0;

        if ( $act == "edit" ) {
            $rs =	$model->geteventRows("*", "IDX=".$idx." and logo='".$logo."'");
            if ( !$imgsrc ) {
                $imgsrc = $rs[0]["P_FILE"];
            }
        }

        if($act=="add") {
            $model->addEvent($P_SUBJECT,$P_POPUP_U, $imgsrc, $logo);
        }
        if($act=="edit") {
            $model->modifyEvent($P_SUBJECT,$P_POPUP_U,$imgsrc,$idx);
        }

        throw new Lemon_ScriptException("처리 되였습니다.","","go","/config/eventlist");
        exit;
    }

	//▶ 베팅 설정
	function betAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/config/bet.html");
		
		$model = $this->getModel("ConfigModel");
		
		$mode = $this->request("mode");
		$item = $model->getSiteConfigRow();
		if($mode=="save")
		{
			$rule 			= $this->request("rule");
			$vh	 			= $this->request("vh");
			$vu 			= $this->request("vu");
			$hu 			= $this->request("hu");
			$min_bet_count 	= $this->request("min_bet_count");
			
			if($item['sn']=='') {$rs = $model->addSiteConfig($rule, $vh, $vu, $hu, $min_bet_count);}
			else				{$rs = $model->modifySiteConfig($rule, $vh, $vu, $hu, $min_bet_count);}
			
			if($rs>0)
			{
				throw new Lemon_ScriptException("변경되었습니다.","","go","/config/bet");
				exit;
			}
		}
		
		$this->view->assign('item', $item);	
		
		$this->display();
	}
	
	//▶ DB 추출
	function dataexcelAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/config/data_excel.html");
		
		$model = $this->getModel("ConfigModel");
		
		$this->display();
	}
	
	function popuplistAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/config/popup.list.html");
		
		$model = $this->getModel("ConfigModel");
		
		$conf = Lemon_Configure::readConfig('config');
		if($conf['site']!='')
		{
			$UPLOAD_URL	 = $conf['site']['upload_url'];
			$SITE_DOMAIN = $conf['site']['site_domain'];
		}
		$ph_path  = $UPLOAD_URL."/upload/popup/";
		
		$act = $this->request("act");
		$idx = $this->request("idx");
		if($act == "del") 
		{
			$rs =	$model->getPopupRow("P_FILE", "IDX=".$idx."" );
			if( count((array) $rs ) > 0 )
			{
				if(file_exists($ph_path.$rs))
				{
					unlink($ph_path.$rs);
				}		
			}			
			$model->delPopupbySn( $idx );			
		}
		
		$list = $model->getPopupbyOrderby();
		
		$this->view->assign('list', $list);
		$this->view->assign('ph_path', $ph_path);
		
		$this->display();
	}
	
	function popupaddAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/config/popup.add.html");
		
		$model = $this->getModel("ConfigModel");
	
		$act = $this->request("act");
		$idx = $this->request("idx");
		$logo = $this->request("logo");
		
		if($logo=='') $logo = $this->logo;
		
		if($act=="edit")
		{
			$rs =	$model->getPopupRows("*", "IDX=".$idx." and logo='".$logo."'" );
		
			
			$rs[0]['P_CONTENT'] = str_replace("<br />","",$rs[0]['P_CONTENT']);

			//print_r($rs);
			$this->view->assign( 'list', $rs[0]);
			$this->view->assign( 'act', $act);
			$this->view->assign( 'idx', $idx);
			$this->view->assign( 'logo', $logo);
			
		}
	
		$this->display();
	}
	
	function popupProcessAction()
	{
		$model = $this->getModel("ConfigModel");
		
		$act = $this->request("act");
		$idx = $this->request("idx");
		$logo = $this->request("logo");
		if($logo=='') $logo = $this->logo;
		if($act=='') $act="add";

		if ( $_FILES["P_FILE"]["size"] > 0 and $_FILES["P_FILE"]["error"] == 0 ) {
			//-> ini 파일에 파일 저장 경로 정보 가져옴.
			/*$uploadInfo = Lemon_Configure::readConfig('config');
			$upload_sitecode = $uploadInfo['site']['site_code'];
			$upload_domain = $uploadInfo['site']['file_domain'];
			$upload_ip = $uploadInfo['ftp']['ip'];
			$upload_port = $uploadInfo['ftp']['port'];
			$upload_user = $uploadInfo['ftp']['user'];
			$upload_passwd = $uploadInfo['ftp']['passwd'];*/
            $upload_domain = "http://memopow.com";
            $img_dir = "D:\\project\\service\\ToToChess\\vhost.user\\upload\\popup\\";
            $img_dir2 = "D:\\project\\service\\ToToChess\\vhost.manager\\upload\\popup\\";
            $img_dir3 = "D:\\project\\service\\ToToChess\\m.vhost.user\\upload\\popup\\";

			//-> 파일 사이즈 체크. (최대 2MB
			if ( $_FILES["P_FILE"]["size"] > 2000000 ) {
				throw new Lemon_ScriptException("첨부 파일 용량은 최대 2메가 입니다.","","back");
				exit;
			}

			//-> 파일 확장자 체크.
			$imgCheckType = array("^","image/jpeg","image/jpg","image/gif","image/png");
			if ( array_search($_FILES["P_FILE"]["type"], $imgCheckType) > 0 ) {

				//-> 파일에 확장자 추출.
				$fileType = explode(".",$_FILES["P_FILE"]["name"]);
				$fileTypeName = $fileType[count($fileType)-1];

				//-> 파일명은 년월일시분초
				$fileName = date("YmdHis").".".$fileTypeName;

				/*$fp = fopen($_FILES['P_FILE']['tmp_name'], 'r');
				$conn_id = ftp_connect($upload_ip, $upload_port);
				
				$login_result = ftp_login($conn_id, $upload_user, $upload_passwd);  
				ftp_chdir($conn_id, $upload_sitecode);*/

				//if ( !ftp_fput($conn_id, $fileName, $fp, FTP_BINARY) )
                if (is_dir($img_dir) && is_writable($img_dir))
                {
                    if ( ! move_uploaded_file($_FILES["P_FILE"]["tmp_name"] , $img_dir . $fileName))
                    {
                        throw new Lemon_ScriptException("파일 업로드를 실패 했습니다. 관리자에게 문의해주세요.","","back");
                        exit;
                    }
				} else {
                    throw new Lemon_ScriptException("파일 업로드를 실패 했습니다. 관리자에게 문의해주세요.","","back");
                    exit;
                }

                 copy($img_dir . $fileName, $img_dir2 . $fileName);
                copy($img_dir . $fileName, $img_dir3 . $fileName);

				/*ftp_close($conn_id);
				fclose($fp);*/

				//-> DB저장될 파일 풀경로.
				//$imgsrc = $upload_domain."/upload/popup/".$fileName;
                $imgsrc = "/upload/popup/".$fileName;
			} else {
				throw new Lemon_ScriptException("jpg, gif, png 파일만 업로드 가능합니다.","","back");
				exit;
			}
		}

 		$P_SUBJECT 			= $this->request("P_SUBJECT");				/// 제목
		$P_POPUP_U 			= $this->request("P_POPUP_U");				/// 팝업 사용유무
		$P_STARTDAY 		= $this->request("P_STARTDAY");			/// 시작일 
		$P_ENDDAY 			= $this->request("P_ENDDAY");				/// 마감일
		$P_WIN_WIDTH 		= $this->request("P_WIN_WIDTH");			/// 팝업창 가로 사이즈
		$P_WIN_HEIGHT 	= $this->request("P_WIN_HEIGHT");		/// 팝업창 세로 사이지
		$P_WIN_LEFT 		= $this->request("P_WIN_LEFT");			/// 팝업 위치
		$P_WIN_TOP 			= $this->request("P_WIN_TOP");				/// 팝업 위치
		$P_STYLE 				= $this->request("P_STYLE");					/// 바디 스타일 이미지 통 또는 html
		$P_MOVEURL 			= $this->request("P_MOVEURL");				/// 이미지 통일 경우 클릭시 이동할 주소
		$P_CONTENT 			= $this->request("P_CONTENT");				/// Html 내용
        $P_LOGIN_POPUP_U 			= $this->request("P_LOGIN_POPUP_U");
        if($P_LOGIN_POPUP_U === "on")
            $P_LOGIN_POPUP_U = "Y";
        else
            $P_LOGIN_POPUP_U = "N";

		$P_CONTENT = nl2br($P_CONTENT);

		if ($P_WIN_WIDTH == "") $P_WIN_WIDTH = 0;
		if ($P_WIN_HEIGHT == "") $P_WIN_HEIGHT = 0;
		if ($P_WIN_LEFT == "") $P_WIN_LEFT = 0;
		if ($P_WIN_TOP == "") $P_WIN_TOP = 0;

		if ( $act == "edit" ) {
			$rs =	$model->getPopupRows("*", "IDX=".$idx." and logo='".$logo."'");
			if ( !$imgsrc ) {
				$imgsrc = $rs[0]["P_FILE"];
			}
		}

		if($act=="add") {
			$model->addPopup($P_SUBJECT,$P_CONTENT,$P_POPUP_U,$P_STARTDAY,$P_ENDDAY,$P_WIN_WIDTH,$P_WIN_HEIGHT,$P_WIN_LEFT,$P_WIN_TOP,$P_MOVEURL,$imgsrc,$P_STYLE, $P_LOGIN_POPUP_U, $logo);
		}
		if($act=="edit") {
			$model->modifyPopup($P_SUBJECT,$P_CONTENT,$P_POPUP_U,$P_STARTDAY,$P_ENDDAY,$P_WIN_WIDTH,$P_WIN_HEIGHT,$P_WIN_LEFT,$P_WIN_TOP,$P_MOVEURL,$imgsrc,$P_STYLE,$P_LOGIN_POPUP_U,$idx);
		}
		
		throw new Lemon_ScriptException("처리 되였습니다.","","go","/config/popuplist");
		exit;
	}
	
	function export_DBProcessAction()
	{
		$model = $this->getModel("MemberModel");
		$cmodel = $this->getModel("CartModel");
		
		$_TYPE 			= $this->request("_TYPE");				/// DB추출 구분값 (0:회원내역, 1:배팅내역)
		if(!strpos($_SESSION["quanxian"],"1004") or $_TYPE == 0)
		{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script>alert(' 해당 권한이 제한되었습니다 ');history.back();</script>";
			
			exit();

		}else
		{
		$filename="";
		
		switch($_TYPE){
			case '0':$rs=$model->getMember_Export();$filename="member_";break;
			case '1':$rs=$cmodel->getBet_Export();$filename="betting_";break;
		}

	
		$filename.=date('YmdHis').".csv";//시간격식으로 파일 이름 지정

		Header("Content-type:charset=UTF-8");  //인코딩 설정
		header("Content-type:text/csv");//수출 파일 지정 csv
	    header("Content-Disposition:attachment;filename=".$filename);
	    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	    header('Expires:0');
	    header('Pragma:public');
			echo $this->array_to_string($rs, $_TYPE);//처리 할 내용 
		}
	}

	function array_to_string($array, $_TYPE)
	{
    if(empty($array)){
        return ("noData..Check Please");
    }
    
    if($_TYPE==0){
	    $data=$this->convertformat("아이디").','.$this->convertformat("닉네임").','.$this->convertformat("비밀번호").','.$this->convertformat("환전비밀번호").','.$this->convertformat("전화번호").','.$this->convertformat("은행").','.$this->convertformat("예금주").','.$this->convertformat("계좌번호").','.$this->convertformat("보유머니").','.$this->convertformat("회원상태").','.$this->convertformat("총판").','.$this->convertformat("등록도메인").','.$this->convertformat("레벨").','.$this->convertformat("등록일").','.$this->convertformat("총입금액").','.$this->convertformat("총환전액")."\n";
	    
	    for($i=0;$i<count((array)$array);++$i){
		    $uid						="[".$array[$i]['uid']."]";
		    $nick						="[".$array[$i]['nick']."]";
		    $upass					="[".$array[$i]['upass']."]";
		    $exchange_pass	="[".$array[$i]['exchange_pass']."]";
		    $phone					="[".$array[$i]['phone']."]";
		    $bank_name			="[".$array[$i]['bank_name']."]";
		    $bank_member		="[".$array[$i]['bank_member']."]";
		    $bank_account		="[".$array[$i]['bank_account']."]";
		    $g_money				="[".$array[$i]['g_money']."]";
		    $mem_status			="[".$array[$i]['mem_status']."]";
		    $recommend_id		="[".$array[$i]['recommend_id']."]";
		    $reg_domain			="[".$array[$i]['reg_domain']."]";
		    $mem_lev				="[".$array[$i]['mem_lev']."]";
		    $regdate					="[".$array[$i]['regdate']."]";
		    $tot_charge			="[".$array[$i]['tot_charge']."]";
		    $tot_exchange		="[".$array[$i]['tot_exchange']."]";
		    
	      $data.=$this->convertformat($uid).','.$this->convertformat($nick).','.$this->convertformat($upass).','.$this->convertformat($exchange_pass).','.$this->convertformat($phone).','.$this->convertformat($bank_name).','.$this->convertformat($bank_member).','.$this->convertformat($bank_account).','.$this->convertformat($g_money).','.$this->convertformat($mem_status).','.$this->convertformat($recommend_id).','.$this->convertformat($reg_domain).','.$this->convertformat($mem_lev).','.$this->convertformat($regdate).','.$this->convertformat($tot_charge).','.$this->convertformat($tot_exchange)."\n";
			}
		}else {
			$data="";
			for($i=0;$i<count((array)$array);++$i){
				switch($array[$i]['aresult']){
					case 0:$game_result="진행중";break;	
					case 1:$game_result="적중";break;	
					case 2:$game_result="실패";break;	
				}
				$data.=$this->convertformat("배팅번호").','.$this->convertformat("아이디").','.$this->convertformat("닉네임").','.$this->convertformat("배팅금액").','.$this->convertformat("배당율").','.$this->convertformat("예상배당액").','.$this->convertformat("배팅날짜").','.$this->convertformat("결과")."\n";
	      $data.=$this->convertformat($array[$i]['betting_no']).','.$this->convertformat($array[$i]['uid']).','.$this->convertformat($array[$i]['nick']).','.$this->convertformat($array[$i]['betting_money']).','.$this->convertformat($array[$i]['result_rate']).','.$this->convertformat($array[$i]['result_money']).','.$this->convertformat($array[$i]['regDate']).','.$this->convertformat($game_result)."\n";
	      $data.=$this->convertformat("게임타입").','.$this->convertformat("경기시간").','.$this->convertformat("리그").','.$this->convertformat("홈팀").','.$this->convertformat("홈배당").','.$this->convertformat("무배당/기준점").','.$this->convertformat("원정팀").','.$this->convertformat("원정배당").','.$this->convertformat("점수").','.$this->convertformat("결과").','.$this->convertformat("배팅")."\n";
	      
	      $rsi=$array[$i]['item'];
	      for($j=0;$j<count((array)$rsi);++$j){
	      	
	      	$game_type="";
	      	switch($rsi[$j]['special']){
	      		case 0:$game_type="일반";break;
	      		case 1:$game_type="스페셜";break;
	      		case 2:$game_type="실시간";break;
	      		case 3:$game_type="고액";break;
	      		case 4:$game_type="이벤트";break;
	      	}
	      	switch($rsi[$j]['game_type']){
	      		case 1:$game_type.="(승무패)";break;
	      		case 2:$game_type.="(핸디캡)";break;
	      		case 4:$game_type.="(언더오버)";break;
	      	}
	      	switch($rsi[$j]['select_no']){
	      		case 1:$selected_team="Home";break;
	      		case 2:$selected_team="Away";break;
	      		case 3:$selected_team="Draw";break;
	      	}
	      	$data.=$this->convertformat($game_type).','.$this->convertformat($rsi[$j]['gameDate'].'('.$rsi[$j]['gameHour'].':'.$rsi[$j]['gameTime'].')').','.$this->convertformat($rsi[$j]['league_name']).','.$this->convertformat($rsi[$j]['home_team']).','.$this->convertformat($rsi[$j]['home_rate']).','.$this->convertformat($rsi[$j]['draw_rate']).','.$this->convertformat($rsi[$j]['away_team']).','.$this->convertformat($rsi[$j]['away_rate']).','.$this->convertformat($rsi[$j]['home_score'].':'.$rsi[$j]['away_score']).','.$this->convertformat($rsi[$j]['win_team']).','.$this->convertformat($selected_team)."\n";	
	      }
	      $data.="\n\n";
			}
		}
    return $data;
	}
	
	
	function convertformat($strInput)
	{
	    return iconv('utf-8','euc-kr',$strInput);//페이지코드가 utf-8인 경우 사용 ,아니면 한글 깨짐
	}
	
	function export_NewBettingListAction() {
		if ( !$_SESSION or !strpos($_SESSION["quanxian"],"1004") ) {
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script>alert(' 해당 권한이 제한되었습니다 ');history.back();</script>";
			exit();
		}

		$cartModel = $this->getModel("CartModel");
		$arrayData = $cartModel->getBet_Export();

		if ( !count($arrayData) or !count($arrayData[0]['item']) ) {
			echo "<script>alert('경기가 없습니다.'); window.history.back();</script>";
			exit;
		}

		$hDate = date("YmdHis",time());
		$fileName = "bettingList_{$hDate}.xls";

		header("Content-type: application/vnd.ms-excel");
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename = {$fileName}");
		header("Content-Description: PHP4 Generated Data");

		for ( $i = 0 ; $i < count((array)$arrayData) ; $i++ ) {
			switch ( $arrayData[$i]['aresult'] ) {
				case 0 : $game_result = "진행중"; break;	
				case 1 : $game_result = "<font color='blue'>적중</font>"; break;	
				case 2 : $game_result = "<font color='red'>실패</font>"; break;	
			}

			$betting_no = $arrayData[$i]['betting_no'];
			$user_id = $arrayData[$i]['uid'];
			$user_nick = $arrayData[$i]['nick'];
			$game_count = count($arrayData[$i]['item']);
			$betting_date = $arrayData[$i]['regDate'];
			$betting_money = number_format($arrayData[$i]['betting_money']);
			$result_rate = $arrayData[$i]['result_rate'];
			$result_money = number_format(floor($arrayData[$i]['betting_money'] * $arrayData[$i]['result_rate']));

			$ex_data .= "<table border='1'>
				<tr bgcolor='#B8B8B8' align='center'>
				 <td><b>배팅번호</b></td>
				 <td><b>ID</b></td>
				 <td><b>사이트</b></td>
				 <td>&nbsp;&nbsp;<b>게임수&nbsp;&nbsp;</b></td>
				 <td><b>&nbsp;&nbsp;배당율&nbsp;&nbsp;</b></td>
				 <td><b>&nbsp;&nbsp;배팅액&nbsp;&nbsp;</b></td>
				 <td><b>&nbsp;&nbsp;예상배당금&nbsp;&nbsp;</b></td>
				 <td><b>배팅시간</b></td>
				 <td><b>&nbsp;&nbsp;&nbsp;결 과&nbsp;&nbsp;&nbsp;</b></td>
				</tr>
				<tr align='center'>
				 <td>{$betting_no}</td>
				 <td>{$user_id} [{$user_nick}]</td>
				 <td>dodo007.com</td>
				 <td>{$game_count}</td>
				 <td>{$result_rate}</td>
				 <td>{$betting_money}원</td>
				 <td>{$result_money}원</td>
				 <td>{$betting_date}</td>
				 <td>{$game_result}</td>
				</tr>
				<tr bgcolor='#DCDCDC' align='center'>
				 <td>&nbsp;경&nbsp;&nbsp;기&nbsp;&nbsp;일&nbsp;&nbsp;자&nbsp;</td>
				 <td>리&nbsp;&nbsp;&nbsp;그</td>
				 <td>홈    vs    원    정</td>
				 <td>승</td>
				 <td>무</td>
				 <td>패</td>
				 <td>최종점수</td>
				 <td>배팅내역</td>
				 <td>&nbsp;&nbsp;&nbsp;결 과&nbsp;&nbsp;&nbsp;</td>
				</tr>";

			$items = $arrayData[$i]['item'];
			for ( $j = 0 ; $j < count((array)$items) ; $j++ ) {
				switch ( $items[$j]['special'] ) {
					case 0 : $specialType = "일반"; break;
					case 1 : $specialType = "스페셜"; break;
					case 2 : $specialType = "실시간"; break;
				}
				switch ( $items[$j]['game_type'] ) {
					case 1 : $gameType = "승무패"; break;
					case 2 : $gameType = "핸디캡"; break;
					case 4 : $gameType = "언더오버"; break;
				}
				switch ( $items[$j]['select_no'] ) {
					case 1 : $selectedTeam = "<font color='#F29661'>승</font>"; break;
					case 2 : $selectedTeam = "<font color='#FF0000'>패</font>"; break;
					case 3 : $selectedTeam = "<font color='#8C8C8C'>무</font>"; break;
				}
				switch ( $items[$j]['result'] ) {
					case 0 : $gameResult = "진행중"; break;	
					case 1 : $gameResult = "<font color='#F29661'>적중</font>"; break;	
					case 2 : $gameResult = "<font color='#FF0000'>실패</font>"; break;	
					case 2 : $gameResult = "적특"; break;	
					case 2 : $gameResult = "취소"; break;	
				}

				$gameDate = $items[$j]['gameDate']." ".$items[$j]['gameHour'].":".$items[$j]['gameTime'];
				$leagueName = $items[$j]['league_name'];
				$homeTeam = $items[$j]['home_team'];
				$homeRate = $items[$j]['home_rate'];
				$drawRate = $items[$j]['draw_rate'];
				$awayTeam = $items[$j]['away_team'];
				$awayRate = $items[$j]['away_rate'];
				$homeScore = $items[$j]['home_score']+0;
				$awayScore = $items[$j]['away_score']+0;
				$winTeam = $items[$j]['win_team'];

				$ex_data .= "<tr align='center'>
					 <td>{$gameDate}</td>
					 <td>{$leagueName} [{$gameType}]</td>
					 <td>{$homeTeam} : {$awayTeam}</td>
					 <td>{$homeRate}</td>
					 <td>{$drawRate}</td>
					 <td>{$awayRate}</td>
					 <td>{$homeScore} : {$awayScore}</td>
					 <td>{$selectedTeam}</td>
					 <td>{$gameResult}</td>
					</tr>";
			}
			$ex_data .= "</table><br>";
		}

		echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";  
		echo $ex_data;
	}

	function popup_limit_editAction() {
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/config/popup.limit_edit.html");
		
		$model = $this->getModel("gameModel");
	
		$limit_id = empty($this->request("limit_id")) ? 0 : $this->request("limit_id");

		$sport_list = $model->getSportList();

		$script = "";

		if($limit_id > 0) {
			$script = $model->getLimitScript($limit_id);
			$this->view->assign( 'script', $script);
			$this->view->assign( 'limit_id', $limit_id);
			$this->view->assign( 'sport_list', $sport_list);
		} else {
			$this->view->assign( 'script', $script);
			$this->view->assign( 'limit_id', $limit_id);
			$this->view->assign( 'sport_list', $sport_list);
		}
		
	
		$this->display();
	}

	function miniUseConfigAction() {
		$this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/config/mini_use_config.html");

        $logo = $this->request('logo');
        if($logo=='')
            $logo = $this->logo;

        $model = $this->getModel("ConfigModel");
        $list = $model->getMiniConfigRow("*", "", $logo);

        $this->view->assign( "list", $list);
        $this->view->assign( "logo", $logo);

        $this->display();
	}
}
?>