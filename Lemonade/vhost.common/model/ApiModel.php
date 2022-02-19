<?php
	class ApiModel extends Lemon_Model {
		//-> api 발란스 정보
		function get_balance_setting($type) {
			$sql = "select * from api_setting where type = '{$type}'";
			$rs = $this->db->exeSql($sql);
			return $rs[0];
		}

		//-> api 발란스 정보 저장
		function up_balance_setting($type, $domain, $bal_id, $bal_passwd, $bal_type, $use_flag) {
			$sql = "update api_setting set domain = '{$domain}', id = '{$bal_id}', passwd = '{$bal_passwd}', bal_type = '{$bal_type}', use_flag = '{$use_flag}' where type = '{$type}'";
			return $this->db->exeSql($sql);
		}

		//-> 사다리 홀짝 배당
		function get_sadari_rate() {
			$sql = "select b.home_rate as rate from tb_child a, tb_subchild b where a.sn = b.child_sn and a.special = 3 and game_code = 's_oe' order by a.sn desc limit 1";
			$rs = $this->db->exeSql($sql);
			if ( !$rs[0]["rate"] ) $rs[0]["rate"] = "1.95";
			return $rs[0]["rate"];
		}

        //-> 다리다리 홀짝 배당
        function get_dari_rate() {
            $sql = "select b.home_rate as rate from tb_child a, tb_subchild b where a.sn = b.child_sn and a.special = 6 and game_code = 'd_oe' order by a.sn desc limit 1";
            $rs = $this->db->exeSql($sql);
            if ( !$rs[0]["rate"] ) $rs[0]["rate"] = "1.95";
            return $rs[0]["rate"];
        }

        //-> 파워볼 홀짝 배당
        function get_pwball_rate() {
            $sql = "select b.home_rate as rate from tb_child a, tb_subchild b where a.sn = b.child_sn and a.special = 5 and game_code = 'p_n-oeㅏ' order by a.sn desc limit 1";
            $rs = $this->db->exeSql($sql);
            if ( !$rs[0]["rate"] ) $rs[0]["rate"] = "1.95";
            return $rs[0]["rate"];
        }

		//-> 사다리 항목별 배팅 합계 및 카운트
		function get_betting_money($special, $gameDate, $gameTh, $gameCode, $selectNo) {
			GLOBAL $dbs;
				$sql = "select count(c.sn) as count, sum(c.bet_money) as money from tb_child a, tb_subchild b, tb_game_betting c, tb_game_cart d, tb_member m  
								where a.sn = b.child_sn and b.sn = c.sub_child_sn and c.betting_no = d.betting_no and c.member_sn = m.sn and m.balance_flag = 1 and a.special = {$special} and 
											a.game_code = '{$gameCode}' and a.gameDate = '{$gameDate}' and a.game_th = '{$gameTh}' and c.select_no = '{$selectNo}' and d.is_account = 1";
				$row = $this->db->exeSql($sql);

				$returnData = array();
				$returnData["count"] = $row[0]["count"]+0;
				$returnData["money"] = $row[0]["money"]+0;
				return $returnData;
		}

		//-> 최근 발란스 배팅 정보 가져오기. (1개 전용)
		function get_balance_data($gameType, $gameDate, $gameTh) {
			$sql = "select * from api_betting_log where game_type= '{$gameType}' and game_date = '{$gameDate}' and game_th = '{$gameTh}'";
			$rs = $this->db->exeSql($sql);
			return $rs[0];
		}

		//-> 로그 리스트 가져오기.
		function get_log_list($gameType, $searchDate) {
			$sql = "select * from api_betting_log where game_type='{$gameType}' and game_date = '{$searchDate}' order by game_th desc";
			return $this->db->exeSql($sql);
		}
	}
?>