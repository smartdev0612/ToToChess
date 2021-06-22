<?php
/*
		$fileName = date("Ymd",time())."_5.log";
		$logFile = @fopen("/home/gadget/www_gadget.com/Lemonade/_logs/user/".$fileName,"r");
		if ( $logFile ) {
			unset($bettingLogArray);
			while ( !feof($logFile) ) {
				$bettingLog = fgets($logFile);
				if ( strlen(trim($bettingLog)) > 0 ) $bettingLogArray[] = str_replace("'","\"",$bettingLog);
			}
			if ( count($bettingLogArray) > 0 ) {
				$bettingLogArrayJson = implode(",",$bettingLogArray);
				$bettingLogArray = json_decode("{".$bettingLogArrayJson."}",true);
			}
			@fclose($logFile);
		}
		print_r($bettingLogArray);
*/
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<div id="route">
		<h5>관리자메인</h5>
	</div>
	<h3>관리자메인</h3>

	<table cellspacing="1" class="tableStyle_normal">
	<thead>
		<tr>
			<th scope="col" class="id">아이디</th>
			<th scope="col">닉네임</th>
			<th scope="col">상위총판</th>
			<!--<th scope="col">경로</th>-->
			<th scope="col">도메인</th>
			<th scope="col">아이피</th>
			<th scope="col">일주일간 접속횟수</th>
			<th scope="col">일주일간 충전금액</th>
			<th scope="col">일주일간 출금금액</th>
			<th scope="col">일주일간 당첨금액</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
			<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,580)"><?php echo $TPL_V1["uid"]?></td>
			<td><?php echo $TPL_V1["nick"]?></td>
			<td><?php echo $TPL_V1["rec_name"]?></td>
<!--
			<td>
<?php if(strpos($TPL_V1["login_domain"],"m.")===false){?>PC
<?php }else{?>모바일
<?php }?>
			</td>
-->
			<td><?php echo $TPL_V1["login_domain"]?></td>
			<td><?php echo $TPL_V1["mem_ip"]?></td>
			<td><?php echo number_format($TPL_V1["visit_count"],0)?> 회</td>
			<td><?php echo number_format($TPL_V1["total_charge"],0)?> 원</td>
			<td><?php echo number_format($TPL_V1["total_exchange"],0)?> 원</td>
			<td><?php echo number_format($TPL_V1["total_prize"],0)?> 원</td>
		</tr>
<?php }}?>
	</tbody>
	</table>
	
	<form name="frm" action="?" method="post">
		<input type="hidden" name="act" value="filter">
		<div id="search" class="topmargin">
			<div class="wrap">
				<span class="icon">이름</span>
				<input name="filter_userid" type="text" class="name" value="<?php echo $TPL_VAR["filter_userid"]?>" maxlength="20"/>
				<!--
				<span class="icon">당첨금액</span>
				<input name="filter_min_prize" type="text" id="" class="normal" value="<?php echo $TPL_VAR["filter_min_prize"]?>" maxlength="20"/>이상 <input name="filter_max_prize" type="text" id="" class="normal" value="<?php echo $TPL_VAR["filter_max_prize"]?>" maxlength="20"/>이하
				-->
				<input name="Submit4" type="image" src="/img/btn_search.gif"/>
			</div>
		</div>
	</form>

	<div id="" class="result_section">
		<h4>검색결과</h4>
		<table cellspacing="1" class="tablestyle_info">
			<tr>
				<th>아이디</th><td><?php echo $TPL_VAR["filter_member_rows"]['uid']?></td>
				<th>당첨금액</th><td><?php echo number_format($TPL_VAR["filter_member_rows"]['total_prize'],0)?>원<span>(단폴더 당첨금액 : <?php echo number_format($TPL_VAR["filter_member_rows"]['total_single_prize'],0)?>원)</span></td>
			</tr>
			<tr>
				<th>닉네임</th><td><?php echo $TPL_VAR["filter_member_rows"]['nick']?></td>
				<th>낙첨금액</th><td><?php echo number_format($TPL_VAR["filter_member_rows"]['failed_money'],0)?>원<span>(단폴더 낙첨금액 : <?php echo number_format($TPL_VAR["filter_member_rows"]['total_single_failed_money'],0)?>원)</span></td>
			</tr>
			<tr>
				<th>등급</th><td><?php echo $TPL_VAR["filter_member_rows"]['mem_lev']?></td>
				<th>충전금액</th><td><?php echo number_format($TPL_VAR["filter_member_rows"]['total_charge'],0)?>원</td>
			</tr>
			<tr>
				<th>총베팅액</th><td><?php echo number_format($TPL_VAR["filter_member_rows"]['total_betting_money'],0)?>원</td>
				<th>출금금액</th><td><?php echo number_format($TPL_VAR["filter_member_rows"]['total_exchange'],0)?>원</td>
			</tr>
			<tr>
				<th>전화번호</th><td><?php echo $TPL_VAR["filter_member_rows"]['phone']?></td>
				<th>관리자 정정액</th><td><?php echo number_format($TPL_VAR["filter_member_rows"]['manager_update_money'],0)?>원</td>
			</tr>
			<tr>
				<th>총판</th><td><?php echo $TPL_VAR["filter_member_rows"]['rec_name']?></td>
				<th>충전보너스 지급액</th><td><?php echo number_format($TPL_VAR["filter_member_rows"]['total_charge_mileage'],0)?> (P)</td>
			</tr>
			<tr>
				<th>보유금액</th><td><?php echo number_format($TPL_VAR["filter_member_rows"]['g_money'],0)?>원</td>
				<th>낙첨보너스 지급액</th><td><?php echo number_format($TPL_VAR["filter_member_rows"]['total_fail_mileage'],0)?> (P)</td>
			</tr>
			<tr>
				<th>보유마일리지</th><td><?php echo number_format($TPL_VAR["filter_member_rows"]['point'],0)?> (P)</td>
				<th class="none"></th><td></td>
			</tr>
			<tr>
			</tr>
			<tr>
			</tr>
		</table>
<!--
		<table cellspacing="1" class="tableStyle_normal">
		<thead>
			<tr>
				<th scope="col" colspan="5">현재 베팅내역(<?php echo number_format($TPL_VAR["filter_member_rows"]["total_current_betting_money"],0)?>원)</th>
				<!--
				<th scope="col" colspan="3">IP 서치</th>
				<th scope="col" colspan="3">충전내역(10만원/ 건)</th>
				<th scope="col" colspan="3">환전내역(20만원/ 건)</th>
				--
			</tr>
			<tr>
				<td>베팅날짜</td>
				<td>베당률</td>
				<td>예상배당</td>
				<td>게임</td>
				<td>당첨금액</td>
				<!--
				<td>접속날짜</td>
				<td>아이피</td>
				<td>타아이디접속</td>
				<td>충전일자</td>
				<td>충전금액</td>
				<td>누적충전금</td>
				<td>환전일자</td>
				<td>환전금액</td>
				<td>누적환전금</td>
				--
			</tr>
		</thead>
		<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["filter_member_rows"]["current_betting_rows"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["regdate"]?></td>
				<td><?php echo $TPL_V1["result_rate"]?></td>
				<td><?php echo number_format($TPL_V1["result_rate"]*$TPL_V1["betting_money"],0)?></td>
				<td>
					<ul class="tablestyle_game">
<?php if(is_array($TPL_R2=$TPL_V1["detail_rows"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<li <?php if($TPL_V2["result"]==1||$TPL_V2["result"]==3||$TPL_V2["result"]==4){?>class="win"<?php }elseif($TPL_VAR["result"]==2){?>class="lose"<?php }?>><?php if($TPL_V2["game_type"]==1){?>1<?php }elseif($TPL_V2["game_type"]==2){?>2<?php }elseif($TPL_V2["game_type"]==4){?>3<?php }?></li>
<?php }}?>
					</ul>
				</td>
				<td><?php echo number_format($TPL_V1["result_money"],0)?> 원</td>
				<!--
				<td></td>
				<td colspan="2"></td>
				<td></td>
				<td colspan="2"></td>
				<td></td>
				<td></td>
				<td></td>
				--
			</tr>
<?php }}?>
		</tbody>
		<thead>
			<tr>
				<th scope="col" colspan="5">총 베팅내역(<?php echo number_format($TPL_VAR["filter_member_rows"]["total_betting_money"],0)?>원) / 총당첨금액(<?php echo number_format($TPL_VAR["filter_member_rows"]["total_prize"],0)?>원)</th>
				<!--
				<th scope="col" colspan="3">고객센터 등록 내역( 건)</th>
				<th scope="col" colspan="3">쪽지발송 내용( 건)</th>
				<th scope="col" colspan="3">보너스금액 지급내역(20만원/ 건)</th>
				--
			</tr>
			<tr>
				<td>베팅날짜</td>
				<td>베당률</td>
				<td>예상배당</td>
				<td>게임</td>
				<td>당첨금액</td>
				<!--
				<td>게시날짜</td>
				<td colspan="2">제목</td>
				<td>발송날짜</td>
				<td colspan="2">제목</td>
				<td>보너스종류</td>
				<td>지급날짜</td>
				<td>지급금액</td>
				--
			</tr>
		</thead>
		<tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["filter_member_rows"]["total_betting_rows"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["regdate"]?></td>
				<td><?php echo $TPL_V1["result_rate"]?></td>
				<td><?php echo number_format($TPL_V1["result_rate"]*$TPL_V1["betting_money"],0)?></td>
				<td>
					<ul class="tablestyle_game">
<?php if(is_array($TPL_R2=$TPL_V1["detail_rows"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<li <?php if($TPL_V2["result"]==1||$TPL_V2["result"]==3||$TPL_V2["result"]==4){?>class="win"<?php }elseif($TPL_VAR["result"]==2){?>class="lose"<?php }?>><?php if($TPL_V2["game_type"]==1){?>1<?php }elseif($TPL_V2["game_type"]==2){?>2<?php }elseif($TPL_V2["game_type"]==4){?>3<?php }?></li>
<?php }}?>
					</ul>
				</td>
				<td><?php echo number_format($TPL_V1["result_money"],0)?> 원</td>
				<!--
				<td></td>
				<td colspan="2"></td>
				<td></td>
				<td colspan="2"></td>
				<td></td>
				<td></td>
				<td></td>
				--
			</tr>
<?php }}?>
		</tbody>
		</table>
-->
	</div>