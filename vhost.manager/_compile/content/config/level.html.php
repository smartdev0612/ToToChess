<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	
	function onEdit($value)
	{
		var $rs = $("#mode");
		
		if( $value == 'add' )
		{
			$rs.attr('value','add');
		}
		else
		{
			$rs.attr('value','del');
		}
		
		frm.submit();
	}

	function onMiniGameSave(sn) {
		var sminbet = $("#"+sn+"_sadari_min_bet").val();
		var smaxbet = $("#"+sn+"_sadari_max_bet").val();
		var smaxbns = $("#"+sn+"_sadari_max_bns").val();
		var rminbet = $("#"+sn+"_race_min_bet").val();
		var rmaxbet = $("#"+sn+"_race_max_bet").val();
		var rmaxbns = $("#"+sn+"_race_max_bns").val();
		var pminbet = $("#"+sn+"_powerball_min_bet").val();
		var pmaxbet = $("#"+sn+"_powerball_max_bet").val();
		var pmaxbns = $("#"+sn+"_powerball_max_bns").val();
		var dminbet = $("#"+sn+"_dari_min_bet").val();
		var dmaxbet = $("#"+sn+"_dari_max_bet").val();
		var dmaxbns = $("#"+sn+"_dari_max_bns").val();
		var aladin_minbet = $("#"+sn+"_aladin_min_bet").val();
		var aladin_maxbet = $("#"+sn+"_aladin_max_bet").val();
		var aladin_maxbns = $("#"+sn+"_aladin_max_bns").val();
		var lowhi_minbet = $("#"+sn+"_lowhi_min_bet").val();
		var lowhi_maxbet = $("#"+sn+"_lowhi_max_bet").val();
		var lowhi_maxbns = $("#"+sn+"_lowhi_max_bns").val();
		var powersadari_minbet = $("#"+sn+"_powersadari_min_bet").val();
        var powersadari_maxbet = $("#"+sn+"_powersadari_max_bet").val();
        var powersadari_maxbns = $("#"+sn+"_powersadari_max_bns").val();
        var kenosadari_minbet = $("#"+sn+"_kenosadari_min_bet").val();
        var kenosadari_maxbet = $("#"+sn+"_kenosadari_max_bet").val();
        var kenosadari_maxbns = $("#"+sn+"_kenosadari_max_bns").val();

        var mgmoddeven_minbet = $("#"+sn+"_mgmoddeven_min_bet").val();
        var mgmoddeven_maxbet = $("#"+sn+"_mgmoddeven_max_bet").val();
        var mgmoddeven_maxbns = $("#"+sn+"_mgmoddeven_max_bns").val();
        var mgmbacara_minbet = $("#"+sn+"_mgmbacara_min_bet").val();
        var mgmbacara_maxbet = $("#"+sn+"_mgmbacara_max_bet").val();
        var mgmbacara_maxbns = $("#"+sn+"_mgmbacara_max_bns").val();

        var nine_minbet = $("#"+sn+"_nine_min_bet").val();
        var nine_maxbet = $("#"+sn+"_nine_max_bet").val();
        var nine_maxbns = $("#"+sn+"_nine_max_bns").val();
        var twodari_minbet = $("#"+sn+"_twodari_min_bet").val();
        var twodari_maxbet = $("#"+sn+"_twodari_max_bet").val();
        var twodari_maxbns = $("#"+sn+"_twodari_max_bns").val();
        var threedari_minbet = $("#"+sn+"_threedari_min_bet").val();
        var threedari_maxbet = $("#"+sn+"_threedari_max_bet").val();
        var threedari_maxbns = $("#"+sn+"_threedari_max_bns").val();

        var choice_minbet = $("#"+sn+"_choice_min_bet").val();
        var choice_maxbet = $("#"+sn+"_choice_max_bet").val();
        var choice_maxbns = $("#"+sn+"_choice_max_bns").val();

        var roulette_minbet = $("#"+sn+"_roulette_min_bet").val();
        var roulette_maxbet = $("#"+sn+"_roulette_max_bet").val();
        var roulette_maxbns = $("#"+sn+"_roulette_max_bns").val();

        var pharaoh_minbet = $("#"+sn+"_pharaoh_min_bet").val();
        var pharaoh_maxbet = $("#"+sn+"_pharaoh_max_bet").val();
        var pharaoh_maxbns = $("#"+sn+"_pharaoh_max_bns").val();

        var fx_minbet = $("#"+sn+"_fx_min_bet").val();
        var fx_maxbet = $("#"+sn+"_fx_max_bet").val();
        var fx_maxbns = $("#"+sn+"_fx_max_bns").val();

		var param = {sn:sn, 
									sminbet:sminbet, smaxbet:smaxbet, smaxbns:smaxbns, 
									rminbet:rminbet, rmaxbet:rmaxbet, rmaxbns:rmaxbns,
									pminbet:pminbet, pmaxbet:pmaxbet, pmaxbns:pmaxbns,
									dminbet:dminbet, dmaxbet:dmaxbet, dmaxbns:dmaxbns,
									aladin_minbet:aladin_minbet, aladin_maxbet:aladin_maxbet, aladin_maxbns:aladin_maxbns,
									lowhi_minbet:lowhi_minbet, lowhi_maxbet:lowhi_maxbet, lowhi_maxbns:lowhi_maxbns,
									mgmoddeven_minbet:mgmoddeven_minbet, mgmoddeven_maxbet:mgmoddeven_maxbet, mgmoddeven_maxbns:mgmoddeven_maxbns,
									mgmbacara_minbet:mgmbacara_minbet, mgmbacara_maxbet:mgmbacara_maxbet, mgmbacara_maxbns:mgmbacara_maxbns,
                                    powersadari_minbet:powersadari_minbet, powersadari_maxbet:powersadari_maxbet, powersadari_maxbns:powersadari_maxbns,
                                    kenosadari_minbet:kenosadari_minbet, kenosadari_maxbet:kenosadari_maxbet, kenosadari_maxbns:kenosadari_maxbns,
                                    nine_minbet:nine_minbet, nine_maxbet:nine_maxbet, nine_maxbns:nine_maxbns,
                                    twodari_minbet:twodari_minbet, twodari_maxbet:twodari_maxbet, twodari_maxbns:twodari_maxbns,
                                    threedari_minbet:threedari_minbet, threedari_maxbet:threedari_maxbet, threedari_maxbns:threedari_maxbns,
                                    choice_minbet:choice_minbet, choice_maxbet:choice_maxbet, choice_maxbns:choice_maxbns,
                                    roulette_minbet:roulette_minbet, roulette_maxbet:roulette_maxbet, roulette_maxbns:roulette_maxbns,
                                    pharaoh_minbet:pharaoh_minbet, pharaoh_maxbet:pharaoh_maxbet, pharaoh_maxbns:pharaoh_maxbns,
                                    fx_minbet:fx_minbet, fx_maxbet:fx_maxbet, fx_maxbns:fx_maxbns
									};

		$.post("/config/pointSaveMiniGame", param, function(returnVal) {
			if ( returnVal.result == "ok" ) {
				alert("설정이 저장되었습니다.");
				top.location.reload();
			} else {
				alert("업데이트 항목이 없거나 오류가 발생되었습니다.");
			}
		}, "json");			
	}
	
	function onSave($sn)
	{
		var lev_name									= $('#tr_'+$sn+' input:text:eq(0)').val();
		var min_money 								= $('#tr_'+$sn+' input:text:eq(1)').val();
		var max_money 								= $('#tr_'+$sn+' input:text:eq(2)').val();
		var max_money_special 				= $('#tr_'+$sn+' input:text:eq(3)').val();
		var max_bonus 								= $('#tr_'+$sn+' input:text:eq(4)').val();
		var max_bonus_special 				= $('#tr_'+$sn+' input:text:eq(5)').val();
		var max_money_single 					= $('#tr_'+$sn+' input:text:eq(6)').val();
		var max_money_single_special 	= $('#tr_'+$sn+' input:text:eq(7)').val();
		var max_bonus_cukbet					= $('#tr_'+$sn+' input:text:eq(8)').val();
		var max_bonus_cukbet_special	= $('#tr_'+$sn+' input:text:eq(9)').val();
        var first_charge_rate 							= $('#tr_'+$sn+' input:text:eq(10)').val();
		var charge_rate 							= $('#tr_'+$sn+' input:text:eq(11)').val();
		var lose_rate 								= $('#tr_'+$sn+' input:text:eq(12)').val();
		var recommend_rate_type 			= $('#tr_'+$sn+' select:eq(0)').val();
		var recommend_rate 						= $('#tr_'+$sn+' input:text:eq(13)').val();
		var recommend_rate2 					= $('#tr_'+$sn+' input:text:eq(14)').val();

		/* 등급별 다폴더 마일리지를 사용하는 경우

		var folder_bonus3 						= $('#tr_'+$sn+' input:text:eq(11)').val();
		var folder_bonus4 						= $('#tr_'+$sn+' input:text:eq(12)').val();
		var folder_bonus5 						= $('#tr_'+$sn+' input:text:eq(13)').val();
		var folder_bonus6 						= $('#tr_'+$sn+' input:text:eq(14)').val();
		var folder_bonus7 						= $('#tr_'+$sn+' input:text:eq(15)').val();
		var folder_bonus8 						= $('#tr_'+$sn+' input:text:eq(16)').val();
		var folder_bonus9 						= $('#tr_'+$sn+' input:text:eq(17)').val();
		var folder_bonus10 						= $('#tr_'+$sn+' input:text:eq(18)').val();
		var bank 											= $('#tr_'+$sn+' input:text:eq(19)').val();
		var bank_account 							= $('#tr_'+$sn+' input:text:eq(20)').val();
		var bank_owner 								= $('#tr_'+$sn+' input:text:eq(21)').val();
		var min_charge 								= $('#tr_'+$sn+' input:text:eq(22)').val();
		var min_exchange 							= $('#tr_'+$sn+' input:text:eq(23)').val();
		var recommend_limit 					= $('#tr_'+$sn+' input:text:eq(24)').val();
		*/
		/*
		var bank 											= $('#tr_'+$sn+' input:text:eq(13)').val();
		var bank_account 							= $('#tr_'+$sn+' input:text:eq(14)').val();
		var bank_owner 								= $('#tr_'+$sn+' input:text:eq(15)').val();
		*/
		var min_charge 								= $('#tr_'+$sn+' input:text:eq(15)').val();
		var min_exchange 							= $('#tr_'+$sn+' input:text:eq(16)').val();
		var recommend_limit 					= $('#tr_'+$sn+' input:text:eq(17)').val();
		var domain_name			 					= $('#tr_'+$sn+' select:eq(1)').val();
		
		$('#sn').val($sn);
		$('#lev_name').val(lev_name);
		$('#min_money').val(min_money);
		$('#max_money').val(max_money);
		$('#max_money_special').val(max_money_special);
		$('#max_bonus').val(max_bonus);
		$('#max_bonus_special').val(max_bonus_special);
		$('#max_money_single').val(max_money_single);
		$('#max_money_single_special').val(max_money_single_special);
		$('#max_bonus_cukbet').val(max_bonus_cukbet);
		$('#max_bonus_cukbet_special').val(max_bonus_cukbet_special);
		$('#charge_rate').val(charge_rate);
        $('#first_charge_rate').val(first_charge_rate);
		$('#lose_rate').val(lose_rate);

		$('#recommend_rate_type').val(recommend_rate_type);
		$('#recommend_rate').val(recommend_rate);
		$('#recommend_rate2').val(recommend_rate2);

		/*
		$('#folder_bonus3').val(folder_bonus3);
		$('#folder_bonus4').val(folder_bonus4);
		$('#folder_bonus5').val(folder_bonus5);
		$('#folder_bonus6').val(folder_bonus6);
		$('#folder_bonus7').val(folder_bonus7);
		$('#folder_bonus8').val(folder_bonus8);
		$('#folder_bonus9').val(folder_bonus9);
		$('#folder_bonus10').val(folder_bonus10);
		*/
		/*
		$('#bank').val(bank);
		$('#bank_account').val(bank_account);
		$('#bank_owner').val(bank_owner);
		*/
		$('#min_charge').val(min_charge);
		$('#min_exchange').val(min_exchange);
		$('#recommend_limit').val(recommend_limit);
		$('#domain_name').val(domain_name);
				
		frm.submit();
	}
	
	$(function()
	{
		$('.quantity').keypress(function(event)
		{ 
	  		if (event.which && (event.which  > 47 && event.which  < 58 || event.which == 8)) { 
	  		}
	  		else{
	    		event.preventDefault(); 
	  		} 
		}); 
	});
</script>

<div class="wrap" id="members">

	<div id="route">
		<h5>관리자 시스템 > 시스템 관리 > <b>레벨 설정</b></h5>
	</div>

	<h3>레벨별 스포츠 금액설정</h3>
	
	<form id="frm" name="frm" method="post" action="?">
	<input type="hidden" id="mode" name="mode" value="save">
	<input type="hidden" id="sn" name="sn" value="">
	<input type="hidden" id="lev_name" name="lev_name" value="">
	<input type="hidden" id="min_money" name="min_money" value="">
	<input type="hidden" id="max_money" name="max_money" value="">
	<input type="hidden" id="max_money_special" name="max_money_special" value="">
	<input type="hidden" id="max_bonus" name="max_bonus" value="">
	<input type="hidden" id="max_bonus_special" name="max_bonus_special" value="">
	<input type="hidden" id="max_money_single" name="max_money_single" value="">
	<input type="hidden" id="max_money_single_special" name="max_money_single_special" value="">
	<input type="hidden" id="max_bonus_cukbet" name="max_bonus_cukbet" value="">
	<input type="hidden" id="max_bonus_cukbet_special" name="max_bonus_cukbet_special" value="">
    <input type="hidden" id="first_charge_rate" name="first_charge_rate" value="">
    <input type="hidden" id="charge_rate" name="charge_rate" value="">
	<input type="hidden" id="lose_rate" name="lose_rate" value="">
	<input type="hidden" id="recommend_rate_type" name="recommend_rate_type" value="">
	<input type="hidden" id="recommend_rate" name="recommend_rate" value="">
	<input type="hidden" id="recommend_rate2" name="recommend_rate2" value="">
	<!--
	<input type="hidden" id="folder_bonus3" name="folder_bonus3" value="">
	<input type="hidden" id="folder_bonus4" name="folder_bonus4" value="">
	<input type="hidden" id="folder_bonus5" name="folder_bonus5" value="">
	<input type="hidden" id="folder_bonus6" name="folder_bonus6" value="">
	<input type="hidden" id="folder_bonus7" name="folder_bonus7" value="">
	<input type="hidden" id="folder_bonus8" name="folder_bonus8" value="">
	<input type="hidden" id="folder_bonus9" name="folder_bonus9" value="">
	<input type="hidden" id="folder_bonus10" name="folder_bonus10" value="">
	-->
	<!--
	<input type="hidden" id="bank" name="bank" value="">
	<input type="hidden" id="bank_account" name="bank_account" value="">
	<input type="hidden" id="bank_owner" name="bank_owner" value="">
	-->
	<input type="hidden" id="min_charge" name="min_charge" value="">
	<input type="hidden" id="min_exchange" name="min_exchange" value="">
	<input type="hidden" id="recommend_limit" name="recommend_limit" value="">
	<input type="hidden" id="domain_name" name="domain_name" value="">
	
	<table cellspacing="1" class="tableStyle_members">
		<legend class="blind">레벨목록</legend>
		<thead>
			<tr>
				<th scope="col" class="lineRow">레벨</th>
				<th scope="col" class="lineRow">레벨이름</th>
				<th scope="col" class="lineRow">배팅최소</th>
				<th scope="col" colspan="2">배팅최대</th>
				<th scope="col" colspan="2">배팅상한</th>
				<th scope="col" colspan="2">단폴최대</th>
				<th scope="col" colspan="2">축벳상한</th>
				<th scope="col" class="lineRow">첫충(%)</th>
				<th scope="col" class="lineRow">매충(%)</th>
				<th scope="col" class="lineRow">낙첨(%)</th>
				<th scope="col" class="lineRow" style="display: none">추천인적립</th>
				<th scope="col" class="lineRow">최소입금</th>
				<th scope="col" class="lineRow">최소출금</th>
				<th scope="col" class="lineRow">추천제한</th>
				<th scope="col" class="lineRow">도메인</th>
				<th scope="col" class="lineRow">수정</th>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>일반</td>
				<td>스페셜</td>
				<td>일반</td>
				<td>스페셜</td>
				<td>일반</td>
				<td>스페셜</td>
				<td>일반</td>
				<td>스페셜</td>
				<td></td>
				<td></td>
				<td  style="display: none"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
                <td></td>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_domain_list_2=empty($TPL_V1["domain_list"])||!is_array($TPL_V1["domain_list"])?0:count($TPL_V1["domain_list"]);?>
				<tr id="tr_<?php echo $TPL_V1["Id"]?>">
					<td><?php echo $TPL_V1["lev"]?></td>
					<td><input style="width:50px" type="text" class="w120" size="6" value="<?php echo $TPL_V1["lev_name"]?>" /></td>
					<td><input style="width:80px" type="text" class="w120" size="10" value="<?php echo number_format($TPL_V1["lev_min_money"],0)?>"/></td>
					<td><input style="width:80px" type="text" class="w120" size="10" value="<?php echo number_format($TPL_V1["lev_max_money"],0)?>"/></td>
					<td><input style="width:80px" type="text" class="w120" size="10" value="<?php echo number_format($TPL_V1["lev_max_money_special"],0)?>"/></td>
					<td><input style="width:80px" type="text" class="w120" size="10" value="<?php echo number_format($TPL_V1["lev_max_bonus"],0)?>"/></td>
					<td><input style="width:80px" type="text" class="w120" size="10" value="<?php echo number_format($TPL_V1["lev_max_bonus_special"],0)?>"/></td>
					<td><input style="width:80px" type="text" class="w120" size="10" value="<?php echo number_format($TPL_V1["lev_max_money_single"],0)?>"/></td>
					<td><input style="width:80px" type="text" class="w120" size="10" value="<?php echo number_format($TPL_V1["lev_max_money_single_special"],0)?>"/></td>
					<td><input style="width:80px" type="text" class="w120" size="10" value="<?php echo number_format($TPL_V1["lev_max_bonus_cukbet"],0)?>"/></td>
					<td><input style="width:80px" type="text" class="w120" size="10" value="<?php echo number_format($TPL_V1["lev_max_bonus_cukbet_special"],0)?>"/></td>
                    <td><input style="width:20px" type="text" class="w120" size="5" value="<?php echo $TPL_V1["lev_first_charge_mileage_rate"]?>" />%</td>
					<td><input style="width:20px" type="text" class="w120" size="5" value="<?php echo $TPL_V1["lev_charge_mileage_rate"]?>" />%</td>
					<td><input style="width:20px" type="text" class="w120" size="5" value="<?php echo $TPL_V1["lev_bet_failed_mileage_rate"]?>" />%</td>
					<td style="display: none">기준
						<select id="recommend_mileage_rate_type" name="recommend_mileage_rate_type" style="width:95px;">
							<option value="lose" <?php if($TPL_V1["lev_join_recommend_mileage_rate_type"]=="lose") echo "selected";?>>낙첨금</option>
							<option value="betting" <?php if($TPL_V1["lev_join_recommend_mileage_rate_type"]=="betting") echo "selected";?>>배팅금</option>
						</select><br>
						1대 <input style="width:20px" type="text" class="w120" type="text" class="w120" size="2" value="<?php echo $TPL_V1["lev_join_recommend_mileage_rate_1"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/>%
						2대 <input style="width:20px" type="text" class="w120" type="text" class="w120" size="2" value="<?php echo $TPL_V1["lev_join_recommend_mileage_rate_2"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/>%
					</td>
					<td>
						<input type="text" class="w120" size="6" value="<?php echo number_format($TPL_V1["lev_bank_min_charge"],0)?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/>
					</td>
					
					<td>
						<input type="text" class="w120" size="6" value="<?php echo number_format($TPL_V1["lev_bank_min_exchange"],0)?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/>
					</td>
					
					<td>
						<input type="text" class="w120" size="2" value="<?php echo $TPL_V1["lev_recommend_limit"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/>
					</td>
					
					<td>
						<select style="width:100px" name="domain">
							<option value="<?php echo $TPL_V1["url"]?>" <?php if($TPL_V1["lev_domain"]==""){?>selected<?php }?>>도메인</option>
<?php if($TPL_domain_list_2){foreach($TPL_V1["domain_list"] as $TPL_V2){?>
							<option value="<?php echo $TPL_V2["url"]?>" <?php if($TPL_V1["lev_domain"]==$TPL_V2["url"]){?>selected<?php }?>><?php echo $TPL_V2["url"]?></option>
<?php }}?>
					</td>
					
					<td>
						<input type="button" class="btnStyle3" value="적용" onclick="onSave(<?php echo $TPL_V1["Id"]?>);"/></a>
					</td>
				</tr>
<?php }}?>
		</tbody>
	</table>
	
	<span id="op1"></span>
	</form>
	
	<div id="wrap_btn">
		<p class="left">
			<input type="button" name="open" value="추가" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="onEdit('add')"/>
			<input type="button" name="open" value="제거" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="onEdit('del')"/>
		</p>
	</div>
	<br><br><br>
	<h3>레벨별 미니게임 금액설정</h3>

	<table cellspacing="1" class="tableStyle_members">
		<legend class="blind">레벨목록</legend>
		<thead>
			<tr>
				<th scope="col" style="width:100px;">회원레벨</th>
				<th scope="col" colspan="3">다리다리</th>
				<th scope="col" colspan="3">사다리</th>
				<th scope="col" colspan="3">달팽이</th>
				<th scope="col" colspan="3">파워볼</th>
				<th scope="col" colspan="3">처리</th>
			</tr>
			<tr>
				<td>-</td>
				<td>최소배팅금</td>
				<td>최대배팅금</td>
				<td>최대당첨금</td>
				<td>최소배팅금</td>
				<td>최대배팅금</td>
				<td>최대당첨금</td>
				<td>최소배팅금</td>
				<td>최대배팅금</td>
				<td>최대당첨금</td>
				<td>최소배팅금</td>
				<td>최대배팅금</td>
				<td>최대당첨금</td>
				<td>저장</td>
			</tr>
		</thead>
<?php
	foreach($TPL_VAR["list_minigame"] as $val) {
		$sn = $val["sn"];
?>
		<tr>
			<td><?php echo $val["user_level"];?></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_dari_min_bet" size="10" value="<?php echo number_format($val["dari_min_bet"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_dari_max_bet" size="10" value="<?php echo number_format($val["dari_max_bet"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_dari_max_bns" size="10" value="<?php echo number_format($val["dari_max_bns"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_sadari_min_bet" size="10" value="<?php echo number_format($val["sadari_min_bet"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_sadari_max_bet" size="10" value="<?php echo number_format($val["sadari_max_bet"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_sadari_max_bns" size="10" value="<?php echo number_format($val["sadari_max_bns"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_race_min_bet" size="10" value="<?php echo number_format($val["race_min_bet"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_race_max_bet" size="10" value="<?php echo number_format($val["race_max_bet"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_race_max_bns" size="10" value="<?php echo number_format($val["race_max_bns"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_powerball_min_bet" size="10" value="<?php echo number_format($val["powerball_min_bet"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_powerball_max_bet" size="10" value="<?php echo number_format($val["powerball_max_bet"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_powerball_max_bns" size="10" value="<?php echo number_format($val["powerball_max_bns"],0)?>"/></td>
			<td><input type="button" class="btnStyle3" value="저장" onclick="onMiniGameSave(<?php echo $sn;?>);" style="cursor:pointer;" /></td>
		</tr>
<?php
	}
?>
	</table>
<br>
	<table cellspacing="1" class="tableStyle_members">
		<legend class="blind">레벨목록</legend>
		<thead>
			<tr>
				<th scope="col" style="width:100px;">회원레벨</th>
				<th scope="col" colspan="3">로하이</th>
                <th scope="col" colspan="3">알라딘사다리</th>
                <th scope="col" colspan="3">파워사다리</th>
                <th scope="col" colspan="3">키노사다리</th>
				<th scope="col" colspan="3">처리</th>
			</tr>
			<tr>
				<td>-</td>
				<td>최소배팅금</td>
				<td>최대배팅금</td>
				<td>최대당첨금</td>
				<td>최소배팅금</td>
				<td>최대배팅금</td>
				<td>최대당첨금</td>
				<td>최소배팅금</td>
				<td>최대배팅금</td>
				<td>최대당첨금</td>
                <td>최소배팅금</td>
                <td>최대배팅금</td>
                <td>최대당첨금</td>
				<td>저장</td>
			</tr>
		</thead>
<?php
	foreach($TPL_VAR["list_minigame"] as $val) {
		$sn = $val["sn"];
?>
		<tr>
			<td><?php echo $val["user_level"];?></td>
            <td><input style="width:90%" type="text" id="<?php echo $sn;?>_lowhi_min_bet" size="10" value="<?php echo number_format($val["lowhi_min_bet"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_lowhi_max_bet" size="10" value="<?php echo number_format($val["lowhi_max_bet"],0)?>"/></td>
			<td><input style="width:90%" type="text" id="<?php echo $sn;?>_lowhi_max_bns" size="10" value="<?php echo number_format($val["lowhi_max_bns"],0)?>"/></td>
            <td><input style="width:90%" type="text" id="<?php echo $sn;?>_aladin_min_bet" size="10" value="<?php echo number_format($val["aladin_min_bet"],0)?>"/></td>
            <td><input style="width:90%" type="text" id="<?php echo $sn;?>_aladin_max_bet" size="10" value="<?php echo number_format($val["aladin_max_bet"],0)?>"/></td>
            <td><input style="width:90%" type="text" id="<?php echo $sn;?>_aladin_max_bns" size="10" value="<?php echo number_format($val["aladin_max_bns"],0)?>"/></td>
            <td><input style="width:90%" type="text" id="<?php echo $sn;?>_powersadari_min_bet" size="10" value="<?php echo number_format($val["powersadari_min_bet"],0)?>"/></td>
            <td><input style="width:90%" type="text" id="<?php echo $sn;?>_powersadari_max_bet" size="10" value="<?php echo number_format($val["powersadari_max_bet"],0)?>"/></td>
            <td><input style="width:90%" type="text" id="<?php echo $sn;?>_powersadari_max_bns" size="10" value="<?php echo number_format($val["powersadari_max_bns"],0)?>"/></td>
            <td><input style="width:90%" type="text" id="<?php echo $sn;?>_kenosadari_min_bet" size="10" value="<?php echo number_format($val["kenosadari_min_bet"],0)?>"/></td>
            <td><input style="width:90%" type="text" id="<?php echo $sn;?>_kenosadari_max_bet" size="10" value="<?php echo number_format($val["kenosadari_max_bet"],0)?>"/></td>
            <td><input style="width:90%" type="text" id="<?php echo $sn;?>_kenosadari_max_bns" size="10" value="<?php echo number_format($val["kenosadari_max_bns"],0)?>"/></td>
			<td><input type="button" class="btnStyle3" value="저장" onclick="onMiniGameSave(<?php echo $sn;?>);" style="cursor:pointer;" /></td>
		</tr>
<?php
	}
?>
	</table>
    <br>
    <table cellspacing="1" class="tableStyle_members">
        <legend class="blind">레벨목록</legend>
        <thead>
        <tr>
            <th scope="col" style="width:100px;">회원레벨</th>
            <th scope="col" colspan="3">MGM홀짝</th>
            <th scope="col" colspan="3">MGM바카라</th>
            <th scope="col" colspan="3">나인</th>
            <th scope="col" colspan="3">이다리</th>
            <th scope="col" colspan="3">삼다리</th>
            <th scope="col" colspan="3">처리</th>
        </tr>
        <tr>
            <td>-</td>
            <td>최소배팅금</td>
            <td>최대배팅금</td>
            <td>최대당첨금</td>
            <td>최소배팅금</td>
            <td>최대배팅금</td>
            <td>최대당첨금</td>
            <td>최소배팅금</td>
            <td>최대배팅금</td>
            <td>최대당첨금</td>
            <td>최소배팅금</td>
            <td>최대배팅금</td>
            <td>최대당첨금</td>
            <td>최소배팅금</td>
            <td>최대배팅금</td>
            <td>최대당첨금</td>
            <td>저장</td>
        </tr>
        </thead>
        <?php
        foreach($TPL_VAR["list_minigame"] as $val) {
            $sn = $val["sn"];
            ?>
            <tr>
                <td><?php echo $val["user_level"];?></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_mgmoddeven_min_bet" size="10" value="<?php echo number_format($val["mgmoddeven_min_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_mgmoddeven_max_bet" size="10" value="<?php echo number_format($val["mgmoddeven_max_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_mgmoddeven_max_bns" size="10" value="<?php echo number_format($val["mgmoddeven_max_bns"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_mgmbacara_min_bet" size="10" value="<?php echo number_format($val["mgmbacara_min_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_mgmbacara_max_bet" size="10" value="<?php echo number_format($val["mgmbacara_max_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_mgmbacara_max_bns" size="10" value="<?php echo number_format($val["mgmbacara_max_bns"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_nine_min_bet" size="10" value="<?php echo number_format($val["nine_min_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_nine_max_bet" size="10" value="<?php echo number_format($val["nine_max_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_nine_max_bns" size="10" value="<?php echo number_format($val["nine_max_bns"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_twodari_min_bet" size="10" value="<?php echo number_format($val["2dari_min_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_twodari_max_bet" size="10" value="<?php echo number_format($val["2dari_max_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_twodari_max_bns" size="10" value="<?php echo number_format($val["2dari_max_bns"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_threedari_min_bet" size="10" value="<?php echo number_format($val["3dari_min_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_threedari_max_bet" size="10" value="<?php echo number_format($val["3dari_max_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_threedari_max_bns" size="10" value="<?php echo number_format($val["3dari_max_bns"],0)?>"/></td>
                <td><input type="button" class="btnStyle3" value="저장" onclick="onMiniGameSave(<?php echo $sn;?>);" style="cursor:pointer;" /></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <br>
    <table cellspacing="1" class="tableStyle_members">
        <legend class="blind">레벨목록</legend>
        <thead>
        <tr>
            <th scope="col" style="width:100px;">회원레벨</th>
            <th scope="col" colspan="3">초이스</th>
            <th scope="col" colspan="3">룰렛</th>
            <th scope="col" colspan="3">파라오</th>
            <th scope="col" colspan="3">FX</th>
            <th scope="col" colspan="3">처리</th>
        </tr>
        <tr>
            <td>-</td>
            <td>최소배팅금</td>
            <td>최대배팅금</td>
            <td>최대당첨금</td>
            <td>최소배팅금</td>
            <td>최대배팅금</td>
            <td>최대당첨금</td>
            <td>최소배팅금</td>
            <td>최대배팅금</td>
            <td>최대당첨금</td>
            <td>최소배팅금</td>
            <td>최대배팅금</td>
            <td>최대당첨금</td>
            <td>저장</td>
        </tr>
        </thead>
        <?php
        foreach($TPL_VAR["list_minigame"] as $val) {
            $sn = $val["sn"];
            ?>
            <tr>
                <td><?php echo $val["user_level"];?></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_choice_min_bet" size="10" value="<?php echo number_format($val["choice_min_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_choice_max_bet" size="10" value="<?php echo number_format($val["choice_max_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_choice_max_bns" size="10" value="<?php echo number_format($val["choice_max_bns"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_roulette_min_bet" size="10" value="<?php echo number_format($val["roulette_min_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_roulette_max_bet" size="10" value="<?php echo number_format($val["roulette_max_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_roulette_max_bns" size="10" value="<?php echo number_format($val["roulette_max_bns"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_pharaoh_min_bet" size="10" value="<?php echo number_format($val["pharaoh_min_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_pharaoh_max_bet" size="10" value="<?php echo number_format($val["pharaoh_max_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_pharaoh_max_bns" size="10" value="<?php echo number_format($val["pharaoh_max_bns"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_fx_min_bet" size="10" value="<?php echo number_format($val["fx_min_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_fx_max_bet" size="10" value="<?php echo number_format($val["fx_max_bet"],0)?>"/></td>
                <td><input style="width:90%" type="text" id="<?php echo $sn;?>_fx_max_bns" size="10" value="<?php echo number_format($val["fx_max_bns"],0)?>"/></td>
                <td><input type="button" class="btnStyle3" value="저장" onclick="onMiniGameSave(<?php echo $sn;?>);" style="cursor:pointer;" /></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
