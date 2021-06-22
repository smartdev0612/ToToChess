<?php /* Template_ 2.2.3 2014/10/23 18:10:20 D:\www_one-23.com\m.vhost.user\_template\content\exchange.html */?>
<script>
	function FormatNumber3(num)
	{
		num=new String(num);
		num=num.replace(/,/gi,"");
		return FormatNumber2(num);
	}
	
	function onMoneyClick(amount)
	{
		var prev_money=document.frm.amount.value.replace(/,/gi,"");
		if(prev_money=="")
		 	old_amount=0;
		 	
		amount = parseInt(amount) + parseInt(prev_money);

		document.frm.amount.value=FormatNumber3(amount);
	}
	function onClearMoney()
	{
		document.frm.amount.value=FormatNumber3('0');
	}
	
	function FormatNumber2(num)
	{
		fl="";
		if(isNaN(num)) { alert("문자는 사용할 수 없습니다.");return 0;}
		if(num==0) return num;
		
		if(num<0)
		{
			num=num*(-1);
			fl="-";
		}
		else
		{
			num=num*1; //처음 입력값이 0부터 시작할때 이것을 제거한다.
		}
		num = new String(num);
		temp="";
		co=3;
		num_len=num.length;
		while(num_len>0)
		{
			num_len=num_len-co;
			if(num_len<0){co=num_len+co;num_len=0;}
			temp=","+num.substr(num_len,co)+temp;
		}
		return fl+temp.substr(1);
	}
	
	function onlyNumber()  //숫자만을 기입받게 하는 방법  
	{
	   if((event.keyCode < 48)||(event.keyCode > 57))
		  event.returnValue=false;      
	}
	
	function doSubmit()
	{
		var fm = document.frm;

		if(fm.amount.value == "")
		{
			alert("환전신청액을 입력하세요");
			fm.amount.focus();
			return false;
		}
		if(fm.exchange_pass.value == "")
		{
			alert("출금 비밀번호를 입력해 주세요.");
			fm.exchange_pass.focus();
			return false;	
		}
		
		if(fm.amount.value < <?php echo $TPL_VAR["min_exchange"]?>) 
		{
			alert("최소 환전 금액이상 입력하세요");
			fm.amount.focus();
			return false;	
		}
	
		var s = fm.amount.value;
		var result = s.replace(/,/gi, '');
		
		if(result > <?php echo $TPL_VAR["cash"]?>)
		{
			alert("환전 가능 금액 초과입니다!");
			fm.amount.focus();
			return false;	
		}
	
		//10,000원 단위로 환전가능체크---
		var iLen = result.length;
		rlen_money = (result.substring(iLen,iLen - 4))
		rlen_money = String(rlen_money);
		
		if (rlen_money != "0000") 
		{
			alert ("10,000원 단위로 환전이 가능합니다.");
			return false;
		}
		
		fm.submit();
	
	}
</script>

	<div id="sub_menu">
		<ul>
			<li class="sub_menu_1_o"><a href="/member/exchange" class="sub_menu_1_o_text">환전요청</a></li>
			<li class="sub_menu_1"><a href="/member/exchangelist" class="sub_menu_1_text">환전내역</a></li>
		</ul>
	</div>

            <div class="coin_in">
                <ul>
                    <li class="coin_in_head">
                        <span class="coin_in_title">주의사항</span>
                    </li>
                    <li class="coin_in_center">
                        <p>※은행점검시간 
						<span class="coin_in_center_text">
						(23:30 부터~00:30 까지는 타행이체불가-은행별
						점검시간이므로 점검시간을 피해서 환전신청 해주시기 
						바랍니다.)</span>
						 </p>
						
                    </li>
                </ul>
            </div>
			<form name="frm" method="post" action="/member/exchangeProcess">
			<fieldset>
            <div class="coin_in_bet">
                <ul>
                    <li>
                        <span class="coin_in_text_1">보유금액</span>
                        <input type="text" maxlength="50" readonly value="<?php echo number_format($TPL_VAR["cash"])?>">
                    </li>
                    <li>
                        <span class="coin_in_text_1">환전계좌</span>
                        <input type="text" maxlength="50" readonly value="*환전계좌 변경은 고객센터로 문의바랍니다.">
                    </li>
                    <!-- <li>
                        <span class="coin_in_text_1">계좌번호</span>
                        <input name="#" type="text" maxlength="50" id="#" value="000000-04-000000">
                    </li>
                    <li>
                        <span class="coin_in_text_1">예금주</span>
                        <input name="#" type="text" maxlength="50" id="#" value="홍길동">
                    </li> -->

                    <li>
                        <span class="coin_in_text_1">환전금액</span>
                        <p><a href="javascript:void()" onClick="onMoneyClick(10000);">10,000</a>
                        </p>
                        <p><a href="javascript:void()" onClick="onMoneyClick(30000);">30,000</a>
                        </p>
                        <p><a href="javascript:void()" onClick="onMoneyClick(50000);">50,000</a>
                        </p>
                        <p><a href="javascript:void()" onClick="onMoneyClick(70000);">70,000</a>
                        </p>
                        <p><a href="javascript:void()" onClick="onMoneyClick(100000);">100,000</a>
                        </p>
                        <p><a href="javascript:void()" onClick="onMoneyClick(300000);">300,000</a>
                        </p>
                        <p><a href="javascript:void()" onClick="onMoneyClick(500000);">500,000</a>
                        </p>
                        <p><a href="javascript:void()" onClick="onMoneyClick(1000000);">1,000,000</a>
                        </p>
                        <p><a class="bt_coin_in_reset" href="javascript:void();" onClick="onClearMoney();">정정</a>
                        </p>
                    </li>
                    <li>
                        <input type="text" name="amount" maxlength="20" id="amount" value="0" onkeyUp="javascript:this.value=FormatNumber3(this.value);" placeholder="정확한 금액을 입력 해주세요.">
                        <span class="coin_in_text_2">※최소환전가능금액 <?php echo number_format($TPL_VAR["min_exchange"],0)?>원</span>
                    </li>
                    <li>
                        <span class="coin_in_text_1">출금비밀번호</span>
                        <input type="password" id="exchange_pass" name="exchange_pass" size="11" maxlength="12" placeholder="출금 비밀번호를 입력해 주시기 바랍니다.">
                        <span class="coin_in_text_2">출금비밀번호 분실시 고객센터로 문의 바랍니다.</span>
                    </li>
                    <li>
                        <a href="javascriot:void();" class="bt_coin_in_bet" onclick="doSubmit();return false;">환전하기</a>
                    </li>
                </ul>
            </div>
			</fieldset>
			</form>
