<?php
class StatModel extends Lemon_Model 
{
	//▶ 유저 통계
	function getMemberStatic($parentSn='', $partnerSn='', $beginDate='', $endDate='', $logo='')
	{
		$array = array();
		$param_logo = $logo;
		
		if($beginDate!='' && $endDate!='')
		{
			$sql = "select datediff(date('".$endDate."'),date('".$beginDate."'))+1 as sumday";
			
			$rs = $this->db->exeSql($sql);
			$sumday = $rs[0]["sumday"];

			for($i=$sumday; $i>0; --$i)
			{
				$item = array();
				$interval = $i-1;
				$sql = "select date(date_sub(date('".$endDate."'),interval ".$interval." day)) as current";
				$rsi = $this->db->exeSql($sql);
				
				$item[$i]['current_date']				=$currentDate = $rsi[0]["current"];
				$item[$i]['current_date_name']	=$this->dateName($currentDate);
				$where=" and date(regdate)=date('".$currentDate."')";
				
				$partnerWhere="";
				if($partnerSn!='')
				{
					$partnerWhere=" and recommend_sn='".$partnerSn."'";
				}
				
				//유져수
				if($logo!='') $logo = " and logo='".$param_logo."'";
				$sql = "select count(*) as cnt from ".$this->db_qz."member where (mem_status='N' or mem_status='W')".$logo.$where.$partnerWhere;
				$rs = $this->db->exeSql($sql);
				
				$item[$i]['member_count'] = $rs[0]['cnt'];
				
				//입금유져수
				if($logo!='') $logo = " and a.logo='".$param_logo."'";
				$sql = "select count(distinct a.sn) as cnt from ".$this->db_qz."member a inner join tb_charge_log b on a.sn=b.member_sn where (a.mem_status='N' or a.mem_status='W')".$logo;
				$sql.= " and date(b.regdate)=date('".$currentDate."')".$partnerWhere;
				$rs = $this->db->exeSql($sql);
				
				$item[$i]['charge_member_count'] = $rs[0]['cnt'];
				
				//접속유져수
				$sql = "select count(distinct a.sn) as cnt from ".$this->db_qz."member a inner join ".$this->db_qz."visit b on a.uid=b.member_id where (a.mem_status='N' or a.mem_status='W')".$logo;
				$sql.= " and date(b.visit_date)=date('".$currentDate."')".$partnerWhere;
				$rs = $this->db->exeSql($sql);
				
				$item[$i]['visit_member_count'] = $rs[0]['cnt'];
				
				//배팅유져수
				$sql = "select count(distinct a.sn) as cnt from ".$this->db_qz."member a inner join ".$this->db_qz."total_cart b on a.sn=b.member_sn where (a.mem_status='N' or a.mem_status='W')".$logo;
				$sql.= " and date(b.regdate)=date('".$currentDate."')".$partnerWhere;
				$rs = $this->db->exeSql($sql);
				
				$item[$i]['betting_member_count'] = $rs[0]['cnt'];
				
				//총 베팅금액, 베팅횟수
				$sql = "select sum(betting_money) as sum_bet,count(betting_no) as countbet from ".$this->db_qz."total_cart a inner join ".$this->db_qz."member b on a.member_sn=b.sn where";
				$sql.= " (b.mem_status='N' or b.mem_status='W') and date(a.regdate)=date('".$currentDate."')".$logo.$partnerWhere;
				$rs = $this->db->exeSql($sql);
				$item[$i]['sum_betting']	= $rs[0]['sum_bet'];
				$item[$i]['bet_count']	  = $rs[0]['countbet'];

				//진행중, 마감 게임
				$sql = "select count(sn) sumrace, kubun 
						from ".$this->db_qz."child 
							where kubun is not null group by kubun and date(gamedate)=date('".$currentDate."')";
				$rs = $this->db->exeSql($sql);
				
				if($rs[0]['kubun']==0)
					$item[$i]['ing_game'] = $rs[0]['sumrace'];
				else
					$item[$i]['fin_game'] = $rs[0]['sumrace'];

				

				//환전 횟수, 총합		
				$sql="select count(a.sn) as countexchange, sum(agree_amount) as sumexchange from ".$this->db_qz."exchange_log a inner join ".$this->db_qz."member b on a.member_sn=b.sn";
				$sql.=" where state = 1 and date(a.regdate)=date('".$currentDate."')".$logo.$partnerWhere;
				$rs = $this->db->exeSql($sql);
				
				$item[$i]['exchange_count'] = $rs[0]['countexchange'];
				$item[$i]['sum_exchange'] = $rs[0]['sumexchange'];
				
				//충전 횟수, 총합		
				$sql="select count(a.sn) as countcharge, sum(agree_amount) as sumcharge from ".$this->db_qz."charge_log a inner join ".$this->db_qz."member b on a.member_sn=b.sn";
				$sql.=" where state = 1 and date(a.regdate)=date('".$currentDate."')".$logo.$partnerWhere;

				$rs = $this->db->exeSql($sql);
				
				$item[$i]['charge_count'] = $rs[0]['countcharge'];
				$item[$i]['sum_charge'] = $rs[0]['sumcharge'];
				
				$array[] = $item[$i];
			}
		}
		

		
		return $array;
	}
	
	
	function getPartner($uid)
	{
		$sql = "select idx from ".$this->db_qz."recommend where rec_id='".$uid."' and logo='".$this->logo."'";				
		return $this->db->exeSql($sql);
	}
	
	//▶ 입출금 통계 
	function getMoneyList($parentSn='', $partnerSn='', $beginDate='', $endDate='', $logo='')
	{
		$list = array();
		
		$param_logo = $logo;
		if($logo!='') $logo = " and logo='".$param_logo."'";

		$cartModel = Lemon_Instance::getObject("CartModel",true);
		
		if($beginDate!="" && $endDate!="")
		{
			$sql = "select datediff(date('".$endDate."'),date('".$beginDate."'))+1 as sumday";
			
			$rs = $this->db->exeSql($sql);
			$sumday = $rs[0]["sumday"];
			
			$item = array();
			for($i=$sumday; $i>0; --$i)
			{
				$interval = $i-1;
				$sql = "select date(date_sub(date('".$endDate."'),interval ".$interval." day)) as current";
				
				$rsi = $this->db->exeSql($sql);
				
				$item[$i]['current_date'] = $currentDate = $rsi[0]["current"];
				$item[$i]['current_date_name']	=$this->dateName($currentDate);
				
				// 총배팅
				$rsi = $cartModel->getTotalBetMoney($partnerSn,'','',$currentDate, $currentDate, '', $param_logo);
				$item[$i]['betting'] = $rsi['total_betting'];
				
				// 총당첨
				$item[$i]['win_money'] = $rsi['total_result'];
				
				// 미당첨
				$rsi = $cartModel->getTotalBetMoney($partnerSn,'','',$currentDate, $currentDate, 2, $param_logo);
				$item[$i]['lose_money'] = $rsi['total_betting'];

				// 단폴더 총배팅
				$rsi = $cartModel->getTotalBetMoney($partnerSn,'','',$currentDate, $currentDate, '', $param_logo, 1);
				$item[$i]['betting_one'] = $rsi['total_betting'];

				// 단폴더 총당첨
				$item[$i]['win_money_one'] = $rsi['total_result'];

				// 단폴더 미당첨
				$rsi = $cartModel->getTotalBetMoney($partnerSn,'','',$currentDate, $currentDate, 2, $param_logo, 1);
				$item[$i]['lose_money_one'] = $rsi['total_betting'];
							
				// 배팅대기
				$rsi = $cartModel->getTotalBetMoney($partnerSn,'','',$currentDate, $currentDate, 0, $param_logo);
				$item[$i]['betting_ready_money'] = $rsi['total_betting'];
				
				// 출금총액
				$sql = "select count(*) as count_exchange, (case when sum(agree_amount) is null then 0 else sum(agree_amount) end) as sum_exchange 
								from ".$this->db_qz."exchange_log where date(regdate)=date('".$currentDate."') and state=1".$logo;			
				if($partnerSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
			
				$rsi = $this->db->exeSql($sql);
				
				$item[$i]['count_exchange'] = $rsi[0]["count_exchange"];
				$item[$i]['exchange'] 	= $rsi[0]["sum_exchange"];
				
				// 입금총액
				$sql = "select count(*) as count_charge, (case when sum(agree_amount) is null then 0 else sum(agree_amount) end) as sum_charge 
								from ".$this->db_qz."charge_log where date(regdate)=date('".$currentDate."') and state=1".$logo;
				if($partnerSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
				
				$rsi = $this->db->exeSql($sql);

				$item[$i]['count_charge'] 	= $rsi[0]["count_charge"];
				$item[$i]['charge'] 		= $rsi[0]["sum_charge"];
			
				// 관리자 입금
				$sql = "select ifnull(sum(amount),0) as sum_admin_charge from ".$this->db_qz."money_log 
								where state=7 and amount>0 and regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59' and (select mem_status from ".$this->db_qz."member where sn=member_sn ".$logo.")<>'G' ";
				if($partnerSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
				
				$rsi = $this->db->exeSql($sql);
				$item[$i]['admin_charge'] = $rsi[0]['sum_admin_charge'];
				
				// 관리자 출금
				$sql = "select ifnull(sum(amount),0) as sum_admin_exchange from ".$this->db_qz."money_log 
								where state=7 and amount<0 and regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59' and (select mem_status from ".$this->db_qz."member where sn=member_sn ".$logo.")<>'G'";
				if($partnerSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['admin_exchange'] = $rsi[0]['sum_admin_exchange'];

				// 포인트 지급 ( 포인트가 0보다 큰 것들 )
				$sql = "select ifnull(sum(amount),0) as sum_admin_charge from ".$this->db_qz."mileage_log 
								where amount > 0 
								and regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59'
								and member_sn in(select sn from ".$this->db_qz."member where mem_status!='G'".$logo.")";
				if($partnerSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['admin_mileage_charge'] = $rsi[0]['sum_admin_charge'];

				// 포인트 회사 ( 포인트가 0보다 작은 것들 )
				$sql = "select ifnull(sum(amount),0) as sum_admin_exchange from ".$this->db_qz."mileage_log 
								where amount < 0 
								and regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59'
								and member_sn in(select sn from ".$this->db_qz."member where mem_status!='G'".$logo.")";
				if($partnerSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['admin_mileage_exchange'] = $rsi[0]['sum_admin_exchange'];

				// 단폴더 지급된 낙첨 포인트
				$sql = "select ifnull(sum(a.amount),0) as one_folder_charge from ".$this->db_qz."mileage_log a, ".$this->db_qz."total_cart b
								where a.state = 4 and a.amount > 0
								and a.betting_no = b.betting_no and b.betting_cnt = 1 and a.regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59'
								and a.member_sn in(select sn from ".$this->db_qz."member where mem_status!='G'".$logo.")";
				if($partnerSn!='')
					$sql.= " and a.member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['one_folder_charge'] = $rsi[0]['one_folder_charge'];

				//-> 총판정산금 회원에게 내려준 포인트
				$sql = "select ifnull(sum(amount),0) as sum_tex_charge from ".$this->db_qz."recommend_money_log where state = 2 and amount > 0 and proc_flag = 1 
								and procdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59'";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['admin_tex_charge'] = $rsi[0]['sum_tex_charge'];

				// 수익
				$item[$i]['benefit'] = $item[$i]['charge']-$item[$i]['exchange'];

				$list[] = $item[$i];
			}
		}

		return $list;
	}

    //▶ 입출금 통계
    function getCheckList($field='', $keyword='', $beginDate='', $endDate='', $logo='')
    {
        $list = array();

        $param_logo = $logo;
        if($logo!='') $logo = " and logo='".$param_logo."'";

        $cartModel = Lemon_Instance::getObject("CartModel",true);
        $memModel = Lemon_Instance::getObject("MemberModel",true);

        if($beginDate!="" && $endDate!="")
        {
            $sql = "select datediff(date('".$endDate."'),date('".$beginDate."'))+1 as sumday";
            $rs = $this->db->exeSql($sql);
            $sumday = $rs[0]["sumday"];

            $memList = $memModel->getTotalList($field, $keyword, "sn, uid, nick");
            $checkList = $memModel->getCheckList($field, $keyword, $beginDate, $endDate);

            $itemList = array();
            $dateList = array();

            for($i=$sumday; $i>0; --$i)
            {
                $interval = $i-1;
                $sql = "select date(date_sub(date('".$endDate."'),interval ".$interval." day)) as current";

                $rsi = $this->db->exeSql($sql);
                $currentDate = $rsi[0]["current"];

                $temp = explode("-", $currentDate);
                $dateList[$i]['current_date'] = $currentDate;
                $dateList[$i]['current_date_name']	=$this->dateName($currentDate);
                $dateList[$i]['current_date_msg'] = $temp[2];

                if($temp[2] === "01")
                {
                    $dateList[$i]['current_date_msg'] = $temp[1].'월</br>1일';
                } else {
                    $dateList[$i]['current_date_msg'] = $temp[2].'</br>'.$dateList[$i]['current_date_name'];
                }

                $dateList[$i]['current_date_msg'] = $this->dateName2($currentDate, $dateList[$i]['current_date_msg']);


                foreach($memList as $k=>$mem)
                {
                    $uid = $mem['uid'];
                    if(array_key_exists($uid, $checkList) && in_array($currentDate, $checkList[$uid]))
                    {
                        $itemList[$mem['uid']][$currentDate] = 1;
                    } else {
                        $itemList[$mem['uid']][$currentDate] = 0;
                    }
                }
            }

            foreach($memList as $k=>$mem)
            {
                $sn = $mem['sn'];
                $uid = $mem['uid'];

                $daySum = $memModel->getCheckPointSum($sn, $beginDate, $endDate, '매일');
                $weekSum = $memModel->getCheckPointSum($sn, $beginDate, $endDate, '일주일');
                $monthSum = $memModel->getCheckPointSum($sn, $beginDate, $endDate, '한달');

                $itemList[$uid]['nick'] = $mem['nick'];
                $itemList[$uid]['d'] = $daySum;
                $itemList[$uid]['w'] = $weekSum;
                $itemList[$uid]['m'] = $monthSum;
            }

            $list = array('date'=>$dateList, 'item'=>$itemList);
        }

        return $list;
    }

	//▶ 롤링 입출금 통계 
	function getRollingMoneyList($parentSn='', $rollingSn='', $beginDate='', $endDate='')
	{
		$list = array();

		$cartModel = Lemon_Instance::getObject("CartModel",true);
		
		if($beginDate!="" && $endDate!="")
		{
			$sql = "select datediff(date('".$endDate."'),date('".$beginDate."'))+1 as sumday";
			
			$rs = $this->db->exeSql($sql);
			$sumday = $rs[0]["sumday"];
			
			$item = array();
			for($i=$sumday; $i>0; --$i)
			{
				$interval = $i-1;
				$sql = "select date(date_sub(date('".$endDate."'),interval ".$interval." day)) as current";
				
				$rsi = $this->db->exeSql($sql);
				
				$item[$i]['current_date'] = $currentDate = $rsi[0]["current"];
				
				// 총배팅
				$rsi = $cartModel->getRollingTotalBetMoney($rollingSn,'','',$currentDate, $currentDate);
				$item[$i]['betting'] = $rsi['total_betting'];
				
				// 총당첨
				$item[$i]['win_money'] = $rsi['total_result'];
				
				// 미당첨
				$rsi = $cartModel->getRollingTotalBetMoney($rollingSn,'','',$currentDate, $currentDate, 2);
				$item[$i]['lose_money'] = $rsi['total_betting'];

				// 단폴더 총배팅
				$rsi = $cartModel->getTotalBetMoney($partnerSn,'','',$currentDate, $currentDate, '', $param_logo, 1);
				$item[$i]['betting_one'] = $rsi['total_betting'];

				// 단폴더 총당첨
				$item[$i]['win_money_one'] = $rsi['total_result'];

				// 단폴더 미당첨
				$rsi = $cartModel->getTotalBetMoney($partnerSn,'','',$currentDate, $currentDate, 2, $param_logo, 1);
				$item[$i]['lose_money_one'] = $rsi['total_betting'];
							
				// 배팅대기
				$rsi = $cartModel->getRollingTotalBetMoney($rollingSn,'','',$currentDate, $currentDate, 0);
				$item[$i]['betting_ready_money'] = $rsi['total_betting'];
				
				// 출금총액
				$sql = "select count(*) as count_exchange, (case when sum(agree_amount) is null then 0 else sum(agree_amount) end) as sum_exchange 
								from ".$this->db_qz."exchange_log where logo='".$this->logo."' and date(regdate)=date('".$currentDate."') and state=1";			
				if($rollingSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where rolling_sn=".$rollingSn.") ";
				
				$rsi = $this->db->exeSql($sql);
				
				$item[$i]['count_exchange'] = $rsi[0]["count_exchange"];
				$item[$i]['exchange'] 	= $rsi[0]["sum_exchange"];
				
				// 입금총액
				$sql = "select count(*) as count_charge, (case when sum(agree_amount) is null then 0 else sum(agree_amount) end) as sum_charge 
								from ".$this->db_qz."charge_log where logo='".$this->logo."' and date(regdate)=date('".$currentDate."') and state=1";
				if($rollingSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where rolling_sn=".$rollingSn.") ";
				
				$rsi = $this->db->exeSql($sql);
				
				$item[$i]['count_charge'] 	= $rsi[0]["count_charge"];
				$item[$i]['charge'] 		= $rsi[0]["sum_charge"];
								
				// 관리자 입금
				$sql = "select ifnull(sum(amount),0) as sum_admin_charge from ".$this->db_qz."money_log 
								where state=7 and amount>0 and regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59'";
				if($rollingSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where rolling_sn=".$rollingSn.") ";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['admin_charge'] = $rsi[0]['sum_admin_charge'];
				
				// 관리자 출금
				$sql = "select ifnull(sum(amount),0) as sum_admin_exchange from ".$this->db_qz."money_log 
								where state=7 and amount<0 and regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59'";
				if($partnerSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where rolling_sn=".$rollingSn.") ";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['admin_exchange'] = $rsi[0]['sum_admin_exchange'];
				
				// 포인트 지급 ( 포인트가 0보다 큰 것들 )
				$sql = "select ifnull(sum(amount),0) as sum_admin_charge from ".$this->db_qz."mileage_log 
								where amount > 0 
								and regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59'
								and member_sn in(select sn from ".$this->db_qz."member where mem_status!='G'".$logo.")";
				if($partnerSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['admin_mileage_charge'] = $rsi[0]['sum_admin_charge'];

				// 포인트 회사 ( 포인트가 0보다 작은 것들 )
				$sql = "select ifnull(sum(amount),0) as sum_admin_exchange from ".$this->db_qz."mileage_log 
								where amount < 0 
								and regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59'
								and member_sn in(select sn from ".$this->db_qz."member where mem_status!='G'".$logo.")";
				if($partnerSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['admin_mileage_exchange'] = $rsi[0]['sum_admin_exchange'];

				// 단폴더 지급된 낙첨 포인트
				$sql = "select ifnull(sum(a.amount),0) as one_folder_charge from ".$this->db_qz."mileage_log a, ".$this->db_qz."total_cart b
								where a.state = 4 and a.amount > 0
								and a.betting_no = b.betting_no and b.betting_cnt = 1 and a.regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59'
								and a.member_sn in(select sn from ".$this->db_qz."member where mem_status!='G'".$logo.")";
				if($partnerSn!='')
					$sql.= " and a.member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['one_folder_charge'] = $rsi[0]['one_folder_charge'];

				//-> 총판정산금 회원에게 내려준 포인트
				$sql = "select ifnull(sum(amount),0) as sum_tex_charge from ".$this->db_qz."mileage_log where state = 20 and amount > 0 
								and regdate between '".$currentDate." 00:00:00' and '".$currentDate." 23:59:59'
								and member_sn in(select sn from ".$this->db_qz."member where mem_status!='G'".$logo.")";
				if($partnerSn!='')
					$sql.= " and member_sn in(select sn from ".$this->db_qz."member where recommend_sn=".$partnerSn.") ";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['admin_tex_charge'] = $rsi[0]['sum_tex_charge'];

				// 수익
				$item[$i]['benefit'] = $item[$i]['charge']-$item[$i]['exchange'];

				$list[] = $item[$i];
			}
		}

		return $list;
	}
	
	//배팅통계
	function getBetList($filter_logo='', $filter_category='', $filter_league='', $begin_date, $end_date)
	{
		$where = "";
		
		$sql = "select date(a.regdate) as regdate, a.result, sum(a.betting_money) as total_betting_money, count(a.betting_money) as total_betting_cnt, sum(a.result_money) as total_win_money, count(a.result_money) as total_win_cnt
					 from ".$this->db_qz."total_cart a, (select * from ".$this->db_qz."total_betting group by betting_no) b inner join ".$this->db_qz."subchild c on b.sub_child_sn=c.sn, ".$this->db_qz."child d
					 where a.betting_no=b.betting_no and c.child_sn=d.sn and a.is_account=1
					 and date(a.regdate)>='".$begin_date."' and date(a.regdate)<='".$end_date."'";


		if($filter_logo!='') 		{$where .= " and a.logo='".$filter_logo."'";}

		if($filter_category!='')
		{
			switch($filter_category)
			{
				case "normal" : $where .= " and d.special='0'";break;
				case "special" : $where .= " and d.special='1'";break;
				case "live" : $where .= " and d.special='2'";break;
				case "ladder" : $where .= " and d.special='3'";break;
				case "ladder_race" : $where .= " and d.special='4'";break;
				case "ladder_power" : $where .= " and d.special='5'";break;
                case "ladder_dari" : $where .= " and d.special='6'";break;
				case "coin" : $where .= " and d.special='6'";break;
				case "ladder_real20" : $where .= " and d.special='7'";break;
			}
		} 
		
		if($filter_league!="")			{$where .= " and d.league_sn='".$filter_league."'";}

		$groupby = " group by date(a.regdate), a.result";
					 		
		$sql = $sql.$where.$groupby;
		$rs = $this->db->exeSql($sql);
		
		return $rs;
	}

    //배팅통계
    function getBetDetailList($date, $member_id = '')
    {
        $where = "";

        $sql = "select b.member_sn, c.uid, c.nick, b.betting_no, b.operdate, b.betting_cnt, b.betting_money, b.result_rate, b.result 
                from (select * from tb_total_cart where str_to_date(bet_date,'%Y-%m-%d') = '{$date}') b, 
                     tb_member c
                where b.member_sn = c.sn";

        if($member_id != '')
        {
            $sql = "select b.member_sn, c.uid, c.nick, b.betting_no, b.operdate, b.betting_cnt, b.betting_money, b.result_rate, b.result 
                from   (select * from tb_total_cart where str_to_date(bet_date,'%Y-%m-%d') = '{$date}') b, 
                         (select * from tb_member where uid = '{$member_id}') c
                where b.member_sn = c.sn
                and c.uid = '{$member_id}'";
        }

        $rs = $this->db->exeSql($sql);

        return $rs;
    }

    //배팅통계
    function checkGameSpecialCode($betting_no)
    {
        $sql = "select a.bet_money, a.select_rate, a.game_type, a.result, d.special, d.type 
                from  tb_total_betting a,
                          tb_child d, 
                          tb_subchild e 
                where a.sub_child_sn = e.sn
                and d.sn = e.child_sn
                and a.betting_no = '{$betting_no}'";

        $rs = $this->db->exeSql($sql);

        return $rs;
    }

	//축구실시간 배팅통계
	function getLiveBetList($filter_logo='', $filter_league='', $begin_date, $end_date)
	{
		$where = "";
				 
		$sql = "select date(a.reg_time) as regdate, a.betting_result as result, sum(a.betting_money) as total_betting_money, count(a.betting_money) as total_betting_cnt, sum(a.prize) as total_win_money, count(a.prize) as total_win_cnt
					 from ".$this->db_qz."live_betting a, ".$this->db_qz."live_game b 
					 where a.live_sn=b.sn and (select mem_status from ".$this->db_qz."member c where c.sn=a.member_sn) <> 'G'
					 and date(a.reg_time)>='".$begin_date."' and date(a.reg_time)<='".$end_date."'";

		if($filter_logo!='') 		{$where .= " and a.logo='".$filter_logo."'";}

		if($filter_league!="")			{$where .= " and b.league_sn='".$filter_league."'";}

		$groupby = " group by date(a.reg_time), a.betting_result";
					 		
		$sql = $sql.$where.$groupby;
		$rs = $this->db->exeSql($sql);

		return $rs;
	}

	function getSettleTotal($where_mem, $where_date, $is_recommender)
    {
        $sql = "select count(*) as cnt
                    from 
                    (select m.sn, m.uid, m.nick, sum(c.amount) as charge_amt
                    from (select * from tb_member where 1=1 ".$where_mem.") m 
                                                               left join tb_charge_log c on c.member_sn=m.sn ".$where_date." group by m.sn) a,
                    (select m.sn, m.uid, m.nick, sum(c.amount) as exchange_amt
                    from (select * from tb_member where 1=1 ".$where_mem.") m 
                                                               left join tb_exchange_log c on c.member_sn=m.sn ".$where_date." group by m.sn) b 
                    where a.sn = b.sn";

        if($is_recommender == 1)
        {
            $sql = "select count(*) as cnt
                    from 
                    (select m.sn, m.uid, m.nick, sum(c.amount) as charge_amt
                    from (select * from tb_member where sn in (select recommend_sn from tb_join_recommend group by recommend_sn) ".$where_mem.") m 
                                                               left join tb_charge_log c on c.member_sn=m.sn ".$where_date." group by m.sn) a,
                    (select m.sn, m.uid, m.nick, sum(c.amount) as exchange_amt
                    from (select * from tb_member where sn in (select recommend_sn from tb_join_recommend group by recommend_sn)".$where_mem.") m 
                                                               left join tb_exchange_log c on c.member_sn=m.sn ".$where_date." group by m.sn) b 
                    where a.sn = b.sn";
        }

        $rs = $this->db->exeSql($sql);
        return $rs[0]['cnt'];
    }

    function getSettleList($where_mem, $where_date, $is_recommender, $page, $page_size)
    {
        $sql = "select  a.*, b.exchange_amt
                    from 
                    (select m.sn, m.uid, m.nick, sum(c.amount) as charge_amt
                    from (select * from tb_member where 1=1 ".$where_mem.") m 
                                                               left join tb_charge_log c on c.member_sn=m.sn ".$where_date." group by m.sn) a,
                    (select m.sn, m.uid, m.nick, sum(c.amount) as exchange_amt
                    from (select * from tb_member where 1=1 ".$where_mem.") m 
                                                               left join tb_exchange_log c on c.member_sn=m.sn ".$where_date." group by m.sn) b 
                    where a.sn = b.sn";

        if($is_recommender == 1)
        {
            $sql = "select a.*, b.exchange_amt
                from 
                (select m.sn, m.uid, m.nick, m.g_money, sum(c.amount) as charge_amt
                from (select * from tb_member where sn in (select recommend_sn from tb_join_recommend group by recommend_sn) ".$where_mem.") m 
                                                           left join tb_charge_log c on c.member_sn=m.sn ".$where_date." group by m.sn) a,
                (select m.sn, m.uid, m.nick, sum(c.amount) as exchange_amt
                from (select * from tb_member where sn in (select recommend_sn from tb_join_recommend group by recommend_sn)".$where_mem.") m 
                                                           left join tb_exchange_log c on c.member_sn=m.sn ".$where_date." group by m.sn) b 
                where a.sn = b.sn limit ".$page.",".$page_size;
        }

        $rs = $this->db->exeSql($sql);
        return $rs;
    }

	//▶ 회원베팅총합
	function getMemberBetTotal($sn, $where)
	{
		$sql = "select count(*) as cnt
				from ".$this->db_qz."total_cart 
					where  member_sn ='".$sn."' and logo='".$this->logo."' and kubun ='Y' ".$where;
					
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 회원베팅정보
	function getMemberBetList($sn, $where, $page, $page_size)
	{
		$sql = "select a.uid,a.nick,b.betting_no,b.betting_cnt,b.before_money,b.betting_money,b.result_rate,b.result_money,b.regdate,b.operdate,b.result,b.bonus
				from ".$this->db_qz."member a, ".$this->db_qz."total_cart b 
					where b.member_sn='".$sn."' and kubun='Y' ".$where." and b.logo='".$this->logo."' and a.sn=b.member_sn 
						order by regdate desc limit ".$page.",".$page_size;
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo = $rs[$i]['betting_no'];
			$sql = "select a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.game_type,a.result,b.name, c.home_team,c.home_score,c.away_team,c.away_score, 
					c.gameDate,c.gameHour,c.gameTime 
					from ".$this->db_qz."total_betting a, ".$this->db_qz."league b, ".$this->db_qz."child c 
						where a.betting_no='".$bettingNo."' and c.league_sn=b.sn and a.sub_child_sn=c.sn";
									
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['item'] = $rsi;
			
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				$rs[$i]['item'][$j]['date'] = substr($rsi[$j]['gameDate'],5,2)."/".  substr($rsi[$j]['gameDate'],8,2) ." ". $rsi[$j]['gameHour'] .":". $rsi[$j]['gameTime'];	
			}
			
		}
		return $rs;
	}
}

?>