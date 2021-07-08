
	<div class="mask"></div>
	<div id="container">
	
<link rel="stylesheet" href="/10bet/css/common.css" type="text/css" />
<link rel="stylesheet" href="/10bet/css/charge.css" type="text/css" />

<script language="javascript">
    // 글자수 제한
    var char_min = parseInt(0); // 최소
    var char_max = parseInt(0); // 최대
</script>
<script>
    var VarBoTable = "a10";
    var VarBoTable2 = "a25";
    var VarCaId = "";
    var VarColspan = "7";
    $j().ready(function(){
        path = '/ajax.list.php?bo_table=a10&ca=1&sca=&sfl=&stx=&b_type=2';
        init("" + g4_path + path);
        
        path2 = '/ajax.list.php?bo_table=a25&ca=1&sca=&sfl=&stx=';
        init2("" + g4_path + path2);
        //setInterval("init('"+g4_path+ path +"')", 30000);
    });
</script>
<script type="text/javascript" src="/10bet/js/left.js?1610769619"></script>
		
<form name="frm" method="post" action="/member/exchangeProcess" enctype="multipart/form-data" style="margin:0px;">
    <div id="contents">
        <div class="board_box">
            <h2>환전신청</h2>
            <div class="message_box">
                <p>
                    * 24시간 자유롭게 출금이 가능하며 최장 3 - 5분 소요됩니다.<br/>
                    <span>(단, 은행별 점검시간 00:00분부터 - 00:30분 까지는 은행점검으로 이체가 되지 않을 수 있습니다.)</span><br/>
                    * 환전은 신청 즉시 아이디에서 차감됩니다.<br/>
                    * 10분이상 입금이 지연될시 회원님 계좌정보를 잘못 기입한 경우가 많습니다. 그럴경우 상단메뉴 고객센터로 계좌정보를 정확히 보내주세요.<br/>
                    * 충전 및 배팅 내역이 없으신 분은 환전하실 수 없습니다.<br/>
                    * 입금 받으실 계좌정보를 고객센터에 꼭 확인해 주세요.<br/>
                    * 보안상 충전하신 금액의 100% 이상 배팅하신 경우에만 출금신청 가능합니다.<br/>
                </p>
            </div>
            <div class="money_box_01">
                <table cellpadding="0" cellspacing="0" border="0">
                    <colgroup><col width="24%" /><col width="*" /></colgroup>
                    <tr>
                        <th>계좌번호</th>
                        <td>* 환전계좌변경은 고객센터로 문의바랍니다.</td>
                    </tr>
                    <tr>
                        <th>예금주명</th>
                        <td><?php echo $TPL_VAR["member"]["bank_member"]?></td>
                    </tr>
                    <tr>
                        <th>환전비밀번호</th>
                        <td><input id="exchange_pass" name="exchange_pass" type="password" class="field" value=""  required itemname="환전비번"></td>
                    </tr>
                    <tr>
                        <th>보유금액</th>
                        <td><span class="fc01"><?php echo number_format($TPL_VAR["cash"])?> 원</span></td>
                    </tr>
                    <tr>
                        <th>환전금액</th>
                        <td>
                            <input type="text"name='amount' id="amount" placeholder="직접입력" required onkeyUp="javascript:this.value=FormatNumber3(this.value);"  /> 
                            <button type="button" class="button_type01" onclick="addMoney(0);">정정하기</button>
                            <div class="btn_area">
                                <button type="button" class="button_type01" onclick="addMoney(10000);">10,000원</span></a>
                                <button type="button" class="button_type01" onclick="addMoney(30000);">30,000원</span></a>
                                <button type="button" class="button_type01" onclick="addMoney(50000);">50,000원</span></a>
                                <button type="button" class="button_type01" onclick="addMoney(100000);">100,000원</span></a>
                                <button type="button" class="button_type01" onclick="addMoney(500000);">500,000원</span></a>
                                <button type="button" class="button_type01" onclick="addMoney(1000000);">1,000,000원</span></a>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <div class="btn_center">
                    <button type="button" class="button_type01" onclick="doSubmit()">환전신청</span></a>
                </div>
            </div>
</form>
    <form name="fboardlist" method="post" style="margin:0;">
        <input type='hidden' name='bo_table' value='b10'>
        <input type='hidden' name='sfl'  value=''>
        <input type='hidden' name='stx'  value=''>
        <input type='hidden' name='spt'  value=''>
        <input type='hidden' name='page' value=''>
        <input type='hidden' name='sw'   value=''>
        <div class="board_list">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th class="th-mini">환전금액</th>
                        <th class="th-mini">신청인</th>
                        <th class="th-mini">환전날자</th>
                        <th class="th-mini">처리여부</th>
                        <th class="th-mini">삭제</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
                if ( $TPL_list_1 ) {
                    foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
                        $date = explode(":", substr($TPL_V1["regdate"], 5));
                        $exchangeDate = $date[0] . ":" . $date[1];
                ?>
                    <tr height="51">
                        <td class="th-mini"><?php echo number_format($TPL_V1["amount"])?></td>
                        <td class="th-mini"><?php echo $TPL_V1["bank_owner"]?></td>
                        <td class="th-mini"><?php echo $exchangeDate?></td>
                        <td class="th-mini">
                            <?php if($TPL_V1["state"] == 0){
                                    echo "처리중";
                                } elseif($TPL_V1["state"] == 1){
                                    echo "완료";
                                } elseif($TPL_V1["state"] == 2){
                                    echo "취소";
                                }
                            ?>
                        </td>
                        <td class="th-mini"><?php	if($TPL_V1["state"]==0){echo "-";} else if ( $TPL_V1["state"] == 1 ) {?><a href="/member/exchangelist?exchange_sn=<?php echo $TPL_V1["sn"]?>"><img src="/images/bt_del_1.png" alt="삭제"/></a><?php	}?></td>
                    </tr>
                <?php
                    }
                }
                ?>
                    <tr height="51">
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        <!-- <div class="page_skip">
            <span class="num"></span>
        </div> -->

<script>
    var f = document.frm;

    function addMoney(value)
    {
        var money = 0;
        tmp_money = f.amount.value;
        if( tmp_money != "" ) money = parseInt(tmp_money.replace(/,/gi,""));
        f.amount.value = ""+ MoneyFormat(money + value)+"";
        if( value == 0) f.amount.value = "";
    }

    function MoneyFormat(str)
    {
        var re="";
        str = str + "";
        str=str.replace(/-/gi,"");
        str=str.replace(/ /gi,"");

        str2=str.replace(/-/gi,"");
        str2=str2.replace(/,/gi,"");
        str2=str2.replace(/\./gi,"");

        if(isNaN(str2) && str!="-") return "";
        try
        {
            for(var i=0;i<str2.length;i++)
            {
                var c = str2.substring(str2.length-1-i,str2.length-i);
                re = c + re;
                if(i%3==2 && i<str2.length-1) re = "," + re;
            }

        }catch(e)
        {
            re="";
        }

        if(str.indexOf("-")==0)
        {
            re = "-" + re;
        }

        return re;
    }
    
	function FormatNumber3(num)
	{
		num=new String(num);
		num=num.replace(/,/gi,"");
		return FormatNumber2(num);
	}
	
	function FormatNumber2(num)
	{
		fl="";
		if(isNaN(num)) { warning_popup("문자는 사용할 수 없습니다.");return 0;}
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
			warning_popup("환전신청액을 입력하세요");
			//fm.amount.focus();
			return false;
		}
/*
		if(fm.exchange_pass.value == "")
		{
			warning_popup("출금 비밀번호를 입력해 주세요.");
			fm.exchange_pass.focus();
			return false;	
		}
*/	
		if(fm.amount.value < <?php echo $TPL_VAR["min_exchange"]?>) 
		{
			warning_popup("최소 환전 금액이상 입력하세요");
			//fm.amount.focus();
			return false;	
		}
	
		var s = fm.amount.value;
		var result = s.replace(/,/gi, '');
		
		if(result > <?php echo $TPL_VAR["cash"]?>)
		{
			warning_popup("환전 가능 금액 초과입니다!");
			//fm.amount.focus();
			return false;	
		}
	
		//10,000원 단위로 환전가능체크---
		var iLen = result.length;
		rlen_money = (result.substring(iLen,iLen - 4))
		rlen_money = String(rlen_money);
		
		if (rlen_money != "0000") 
		{
			warning_popup ("10,000원 단위로 환전이 가능합니다.");
			return false;
		}
		
		fm.submit();	
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
</script>