<?php /* Template_ 2.2.3 2014/10/23 17:51:42 D:\www_one-23.com\m.vhost.user\_template\content\charge.html */?>
<script>
	function doSubmit()
	{
		var fm = document.frm;

		if(fm.money.value == 0)
		{
			alert("충전금액을 입력하세요");
			fm.money.focus();
			return false;
		}

		if(FormatNumber5(fm.money.value) < 10000) 
		{
			alert("10,000원 이상 충전이 가능 합니다.");
			fm.money.focus();
			return false;	
		}

		fm.submit();
	}
	
	
	function onMoneyClick(amount)
	{
		var prev_money=document.frm.money.value.replace(/,/gi,"");
		if(prev_money=="")
		 	old_amount=0;
		 	
		amount = parseInt(amount) + parseInt(prev_money);

		document.frm.money.value=FormatNumber3(amount);
	}
	function onClearMoney()
	{
		document.frm.money.value=FormatNumber3('0');
	}
	
	function commaStr( num )
	{
	 num = num+"";
	 point = num.length%3
	 len = num.length;
	
	 str = num.substring(0,point);
	 while( point < len){
	  if( str != "" ) str += ",";
	  str += num.substring( point , point+3);
	  point +=3;
	 }
	 return str;
	}
	
	function FormatNumber5(num)
	{
			num=new String(num);
			num=num.replace(/,/gi,"");
			return num;
	}
	
	function FormatNumber3(num)
	{
			num=new String(num)
			num=num.replace(/,/gi,"")
			return FormatNumber2(num)
	}
	
	function FormatNumber2(num)
	{
		fl=""
		if(isNaN(num)) { alert("문자는 사용할 수 없습니다.");return 0}
		if(num==0) return num
		
		if(num<0){ 
				num=num*(-1)
				fl="-"
		}else{
				num=num*1 //처음 입력값이 0부터 시작할때 이것을 제거한다.
		}
		num = new String(num)
		temp=""
		co=3
		num_len=num.length
		while (num_len>0){
				num_len=num_len-co
				if(num_len<0){co=num_len+co;num_len=0}
				temp=","+num.substr(num_len,co)+temp
		}
		return fl+temp.substr(1)
	}
	
	function money_in_check(form)
	{
		var f = document.frm;
		var billMoney=document.frm.money.value.replace(/,/gi,"");
		var rega=/[!~\'\"<@>(),._|\[\]\{\}#\-+\\;=:/?\$%\^&\*]+/g ;
		var reg=/[0-9]/;
		if(parseInt(billMoney) > 10000000) {
			alert("예치금 입금한도 1회 1,000만원 입니다.");
	        return;
	    }
	    
	    if(billMoney.length <= 0) {
	        alert("충전금액을 입력하여 주십시요.");
	        return;
	    }
	    
		if(parseInt(billMoney) < 1000)   {	     
			alert("1,000원 이상부터 충전 가능합니다.");
	    	return;
	    }
	
	
	    if(f.BillName.value.length <= 0) {
	        alert("입금자명을 입력하여 주십시요.");
	        f.BillName.focus(); 
	        return;
	    }
		 if(rega.test(f.BillName.value)) {
	        alert("특수문자를 사용하실수 없습니다.");
	        f.BillName.focus(); 
	        return;
	    }
		if(reg.test(f.BillName.value)) {
	        alert("정확한 입금자명을 입력하십시오.");
	        f.BillName.focus(); 
	        return;
	    }
		if(f.BillName.value == 0) {
	        alert("입금자명을 입력하여 주십시요.");
	        f.BillName.focus(); 
	        return;
	    }
		f.submit();
	}
</script>

	<div id="sub_menu">
		<ul>
			<li class="sub_menu_1_o"><a href="/member/charge" class="sub_menu_1_o_text">충전요청</a></li>
			<li class="sub_menu_1"><a href="/member/chargelist" class="sub_menu_1_text">충전내역</a></li>
		</ul>
	</div>

            <div class="coin_in">
                <ul>
                    <li class="coin_in_head">
                   
                        <span class="coin_in_title">주의사항</span>
                    </li>
                    <li class="coin_in_center">
                        <p>1. 충전신청 하시기 전 무조건 계좌문의 해주시기 
						</p>
						바랍니다.
						</p>
						<span class="coin_in_center_text">
						(입금계좌는 수시로 변경되며, 변경 전 계좌로 입금
						</p>
						시 그 책임은 본인에게 있습니다.)</span>
                        </p>
                        <br/>
                        <p>2. 입금자명이 다를 경우 충전신청이 되지 않습니다. 
						</p>
						<span class="coin_in_center_text">
						(본인 성함으로 입금 하셔야 합니다.)</span>
						</p>
                        <br/>
                        <p>3. 수표로 입금 시 어떤 경우라도 충전신청 되지 않으며,
						</p>
						그 즉시 탈퇴처리 됩니다.
						
                    </li>
                </ul>
            </div>
		 <form name="frm" method="post" action="/member/chargeProcess">
			<fieldset>
            <div class="coin_in_bet">
                <ul>
                    <li>
                        <span class="coin_in_text_1">보유금액</span>
                        <input name="#" type="text" maxlength="50" id="#" value="<?php echo number_format($TPL_VAR["cash"])?>" placeholder="<?php echo number_format($TPL_VAR["cash"])?>" readonly>
                    </li>
                    <li>
                        <span class="coin_in_text_1">입금계좌</span>
                        <input name="#" type="text" maxlength="50" id="#" value="반드시 계좌 문의 후 충전 해주시기 바랍니다." placeholder="반드시 계좌 문의 후 충전 해주시기 바랍니다." readonly>
                    </li>
                    <li>
                        <span class="coin_in_text_1">충전금액</span>
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
                        <input type="text" name="money" maxlength="20" id="money" value="0" onkeyUp="javascript:this.value=FormatNumber3(this.value);">
                    </li>
<!--
                    <li>
                        <span class="coin_in_text_1">입금자명</span>
                        <input name="#" type="text" maxlength="50" id="#" placeholder="<?php echo $TPL_VAR["member"]["bank_member"]?>">
                    </li>
-->
                    <li>
                        <span class="coin_in_text_2">반드시 계좌 문의 후 충전 해주시길 바랍니다.</span>
                        <a href="javascript:void()" class="bt_coin_in_bet" onclick="doSubmit();return false;">충전하기</a>
                    </li>
                </ul>
            </div>
			</fieldset>
		 </form>
        </div>
