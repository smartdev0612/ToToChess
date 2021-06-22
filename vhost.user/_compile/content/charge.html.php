
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
        path = '/ajax.list.php?bo_table=a10&ca=&sca=&sfl=&stx=&b_type=2';
        init("" + g4_path + path);
        
        path2 = '/ajax.list.php?bo_table=a25&ca=&sca=&sfl=&stx=';
        init2("" + g4_path + path2);
        //setInterval("init('"+g4_path+ path +"')", 30000);
    });
</script>
<script type="text/javascript" src="/10bet/js/left.js?1610763509"></script>
		
<form name="frm" method="post" action="/member/chargeProcess" enctype="multipart/form-data" style="margin:0px;">
    <div id="contents">
        <div class="board_box">
            <h2>충전신청</h2>
            <div class="message_box">
                <p>
                    * 입금하실 계좌에 인터넷뱅킹, 폰뱅킹, 무통장입금, ATM등의 방법으로 금액 중 하나를 선택하여 입금합니다.<br/>
                    * 입금하신 금액을 체크박스로 선택하거나 입력해 주세요.<br/>
                    * 확인 버튼을 클릭하시면 충전이 완료됩니다.<br/>
                    * 입금액은 10,000원이상 1,000원 단위입니다.<br/>
                    * 입금 전 입금계좌정보를 꼭 확인해 주세요.<br/>
                    * 수표입금은 받지않습니다.입금시 몰수 처리됩니다.<br/>
                    * 머니충전 후 금액의 100% 이상 배팅하지 않고 환전시에는 보안을 위해 출금이 불가능 합니다.<br/>
                    <span>* 입금자명과 동일해야 입금 확인이 가능합니다.</span>
                </p>
            </div>
            <div class="money_box_01">
                <table cellpadding="0" cellspacing="0" border="0">
                    <colgroup><col width="24%" /><col width="*" /></colgroup>
                    <tr>
                        <th>입금계좌<br/>문의</th>
                        <td>
                            <button type="button" class="button_type01" onclick="ask_account();" style="padding-right: 10px; padding-left: 10px; color: yellow;">입금계좌 요청하기</button>&nbsp;&nbsp;&nbsp;
                            <span style="color:red; font-weight: 600;">주의: </span>
                            <span>입금계좌요청 하신후, 은행입금을 하시고 충전신청을 해주시기 바랍니다.</span>
                        </td>
                    </tr>
                    <tr>
                        <th>예금주명</th>
                        <td>고객센터 문의</td>
                    </tr>
                    <tr>
                        <th>충전금액</th>
                        <td>
                            <input type="text" name='money' id="money" placeholder="직접입력" required  onblur="javascript:this.value=FormatNumber3(this.value);" /> 
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
                    <button type="button" class="button_type01" onclick="doSubmit();">충전신청</span></a>
                </div>
            </div>
</form>  

<!-- 목록 -->
<div class="board_list">
    <table cellpadding="0" cellspacing="0" border="0">
        <colgroup><col width="10%" /><col width="10%" /><col width="*" /><col width="15%" /><col width="10%" /><col width="10%" /></colgroup>
        <thead>
            <tr>
                <th>신청번호</th>
                <th>신청금액</th>
                <th>신청인</th>
                <th>신청날자</th>
                <th>처리여부</th>
                <th>삭제</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
        if ( $TPL_list_1 ) {
            foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
        ?>
            <tr height="51">
                <td>
                    <?php echo $TPL_V1["sn"]?>
                </td>
                <td><?php echo number_format($TPL_V1["amount"])?></td>
                <td><?php echo $TPL_V1["bank_owner"]?></td>
                <td><?php echo $TPL_V1["regdate"]?></td>
                <td><?php if($TPL_V1["state"]==0){?>처리중<?php }elseif($TPL_V1["state"]==1){?>처리완료<?php }?></td>
                <td><?php	if($TPL_V1["state"]==0){echo "-";} else if ( $TPL_V1["state"] == 1 ) {?><a href="/member/chargelist?charge_sn=<?php echo $TPL_V1["sn"]?>"><img src="/images/bt_del_1.png" alt="삭제"/></a><?php	}?></td>
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

<!-- 계좌문의 -->
<div style="display:none;">
	<form name="cs_write" method="post" action="/cs/cs_list">
	<input type="hidden" name="act" value="add">
	<input type="text" name="title" id="title" value="계좌 문의">
	<input type="text" name="content" id="content" value="계좌 문의">
	</form>
</div>
		
<script>
    var f = document.frm;

    function addMoney(value)
    {
        var money = 0;
        tmp_money = f.money.value;
        if( tmp_money != "" ) money = parseInt(tmp_money.replace(/,/gi,""));
        f.money.value = ""+ MoneyFormat(money + value)+"";
        if( value == 0) f.money.value = "";
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

	function ask_account() {
		if( confirm("계좌문의(1:1문의)를 하시겠습니까?") ) {
			document.cs_write.submit();
		}
	}

	function doSubmit()
	{
		var fm = document.frm;

		if(fm.money.value == 0)
		{
			warning_popup("충전금액을 입력하세요");
			//fm.money.focus();
			return false;
		}

		if(FormatNumber5(fm.money.value) < 10000) 
		{
			warning_popup("10,000원 이상 충전이 가능 합니다.");
			//fm.money.focus();
			return false;	
		}

		if( (FormatNumber5(fm.money.value) % 1000) != 0 ) 
		{
			warning_popup("1000원 단위 이상 충전이 가능 합니다.");
			//fm.money.focus();
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
		if(isNaN(num)) { warning_popup("문자는 사용할 수 없습니다.");return 0}
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
			warning_popup("예치금 입금한도 1회 1,000만원 입니다.");
	        return;
	    }
	    
	    if(billMoney.length <= 0) {
	        warning_popup("충전금액을 입력하여 주십시요.");
	        return;
	    }
	    
		if(parseInt(billMoney) < 1000)   {	     
			warning_popup("1,000원 이상부터 충전 가능합니다.");
	    	return;
	    }
	
	
	    if(f.BillName.value.length <= 0) {
	        warning_popup("입금자명을 입력하여 주십시요.");
	        f.BillName.focus(); 
	        return;
	    }
		 if(rega.test(f.BillName.value)) {
	        warning_popup("특수문자를 사용하실수 없습니다.");
	        f.BillName.focus(); 
	        return;
	    }
		if(reg.test(f.BillName.value)) {
	        warning_popup("정확한 입금자명을 입력하십시오.");
	        f.BillName.focus(); 
	        return;
	    }
		if(f.BillName.value == 0) {
	        warning_popup("입금자명을 입력하여 주십시요.");
	        f.BillName.focus(); 
	        return;
	    }
		f.submit();
	}
</script>