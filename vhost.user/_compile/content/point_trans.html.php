<div id="contents_left" class="money_wrap" style="background:#fff;">
	<div style="width:300px; height:70px; margin:20px auto; text-align:center;">
		<div><img src="/images/point_trans.png" alt=""/></div>
	</div>

	<form name="frm" method="post">
	<table class="tbl_style03">
		<caption>입출급신청 테이블</caption>
		<tbody>
			<tr>
				<th><strong>마이포인트</strong> </th>
				<td><input type="text" id="mypoint" class="mycash" value="<?php echo number_format($TPL_VAR["mileage"],0)?> P" readonly onFocus="blur();"></td>
			</tr>
			<tr>    
				<th><strong>환전할<br>포인트</strong></th>
				<td>        
					<span class="ab">고객님의 보유금액(캐시)을 확인하신 후 환전포인트를 선택하여주세요.</span>
					<input type="text" name="amount" id="amount" value="0" class="frm_input readonly" required readonly numeric onFocus="blur();" style="width:95%;margin-bottom:5px;">
					<div class="money_btn_area">
						<dl>
							<dt class="hidden">환전포인트</dt>
							<dd class="mn_plus">
								<input type="button" class="btn_mm mo01" onclick="onMoneyClick(10000000,0);" value="+1,000만원" title="천만원">
								<input type="button" class="btn_mm mo02" onclick="onMoneyClick(5000000,0);" value="+500만원" title="오백만원">
								<input type="button" class="btn_mm mo03" onclick="onMoneyClick(1000000,0);" value="+100만원" title="백만원">
								<input type="button" class="btn_mm mo04" onclick="onMoneyClick(500000,0);" value="+50만원" title="오십만원">
								<input type="button" class="btn_mm mo05" onclick="onMoneyClick(100000,0);" value="+10만원" title="십만원">
								<input type="button" class="btn_mm mo06" onclick="onMoneyClick(50000,0);" value="+5만원" title="오만원">
								<input type="button" class="btn_mm mo07" onclick="onMoneyClick(10000,0);" value="+1만원" title="만원">
							</dd>
							<dd class="mn_minus">
								<input type="button" class="btn_mm" onclick="onMoneyClick(-10000000,0);" value="-1,000만원" title="천만원">
								<input type="button" class="btn_mm" onclick="onMoneyClick(-5000000,0);" value="-500만원" title="오백만원">
								<input type="button" class="btn_mm" onclick="onMoneyClick(-1000000,0);" value="-100만원" title="백만원">
								<input type="button" class="btn_mm " onclick="onMoneyClick(-500000,0);" value="-50만원" title="오십만원">
								<input type="button" class="btn_mm" onclick="onMoneyClick(-100000,0);" value="-10만원" title="십만원">
								<input type="button" class="btn_mm " onclick="onMoneyClick(-50000,0);" value="-5만원" title="오만원">
								<input type="button" class="btn_mm" onclick="onMoneyClick(-10000,0);" value="-1만원" title="만원">
								<input type="button" class="btn_reset" value="정정" onclick="resetAmount();" title="리셋">
							</dd>
							<dd><input type="button" class="btn_alll" onclick="onMoneyClick(<?php echo $TPL_VAR["mileage"];?>,1);" value=" + <?php echo number_format($TPL_VAR["mileage"],0)?> 모두사용 "></dd>
						</dl>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	</form>

	<div style="text-align:center;">
		<input type="submit" value="전환하기" class="btn btn_submit" style="width:96%;margin:0 auto;" onclick="doSubmit();">
	</div>
</div>

<script>
	function FormatNumber3(num) {
		num=new String(num);
		num=num.replace(/,/gi,"");
		return FormatNumber2(num);
	}
	
	function FormatNumber2(num) {
		fl = "";
		if ( isNaN(num) ) {
			alert("문자는 사용할 수 없습니다.");
			return 0;
		}

		if ( num == 0 ) return num;	
		if ( num < 0 ) {
			num = num * (-1);
			fl = "-";
		} else {
			num = num * 1; //처음 입력값이 0부터 시작할때 이것을 제거한다.
		}
		num = new String(num);
		temp = "";
		co = 3;
		num_len = num.length;
		while ( num_len > 0 ) {
			num_len = num_len - co;
			if ( num_len < 0 ) {
				co = num_len + co;
				num_len = 0;
			}
			temp = "," + num.substr(num_len,co) + temp;
		}
		return fl + temp.substr(1);
	}
	
	//숫자만을 기입받게 하는 방법  
	function onlyNumber() {
		if ( (event.keyCode < 48) || (event.keyCode > 57) )
			event.returnValue=false;      
	}
	
	function doSubmit() {
		var fm = document.frm;

		if ( fm.amount.value == "" || fm.amount.value == "0" ) {
			alert("전환하실 포인트 금액을 설정하세요");
			return false;
		}

		var s = fm.amount.value;
		var result = s.replace(/,/gi, '');		
		if ( result > <?php echo $TPL_VAR["mileage"]?> ) {
			alert("환전금액이 보유포인트보다 많습니다.");
			return false;	
		}

		var param = {point:result};
		$.post("/member/toCashProcess", param, function(returnVal) {
			if ( returnVal.result == "ok" ) {
				alert("포인트 전환이 완료 되었습니다.");
				top.location.reload();
			} else {
				alert("처리중 오류가 발생되었습니다.");
			}
		}, "json");	
	}

	function onMoneyClick(amount, picks) {
		if ( amount != 0 ) {
			var prev_money = document.frm.amount.value.replace(/,/gi,"");
			if ( picks == 1 ) {
				amount = parseInt(amount);
			} else {
				amount = parseInt(amount) + parseInt(prev_money);
			}
			if ( amount < 0 ) amount = 0;
		} else {
			amount = 0;
		}
		document.frm.amount.value=FormatNumber3(amount);
	}
</script>