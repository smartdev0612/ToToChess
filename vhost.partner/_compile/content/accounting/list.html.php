<?php /* Template_ 2.2.3 2012/11/19 16:25:32 D:\www\vhost.partner\_template\content\accounting\list.html */?>
<title>정산신청</title>

</head>

<body>

<div id="wrap">

	<h1>정산신청</h1>

<?php if($TPL_VAR["list"]["size"]>0){?>
					<table cellspacing="1" class="tableStyle_membersWrite" summary="정산신청">
					<legend class="blind">정산신청</legend>
					<tr>
						<th>파트너ID</th>
						<th>정산시작</th>
						<th>정산마감</th>
						<th>충전금액</th>
						<th>환전금액</th>
						<th>비율</th>
						<th>은행명</th>
						<th>계좌번호</th>
						<th>예금주</th>
						<th>정산금액</th>
					</tr>
					<tr>
						<td><?php echo $TPL_VAR["list"]["name"]?></td>
						<td><?php echo $TPL_VAR["list"]["start_date"]?></td>
						<td><?php echo $TPL_VAR["list"]["end_date"]?></td>
						<td><?php echo number_format($TPL_VAR["list"]["charge_money"],0)?></td>
						<td><?php echo number_format($TPL_VAR["list"]["exchange_money"],0)?></td>						
						<td><?php echo $TPL_VAR["list"]["rate"]?>%</td>
						<td><?php echo $TPL_VAR["list"]["bank_name"]?></td>
						<td><?php echo $TPL_VAR["list"]["bank_num"]?></td>
						<td><?php echo $TPL_VAR["list"]["bank_username"]?></td>
						<td><?php echo number_format($TPL_VAR["list"]["opt_money"],0)?></td>
					</tr>
<?php }else{?>
		<!--  内容列表   -->
		<form name="Form1" action="?" method="post">
		<input type="hidden" name="act" value="change">
		<input type="hidden" name="partner_sn" value="<?php echo $TPL_VAR["sn"]?>">
		<input type="hidden" name="start_date" value="<?php echo $TPL_VAR["list"]["reg_date"]?>">
		<input type="hidden" name="end_date" value="<?php echo $TPL_VAR["list"]["objdate"]?>">
		<input type="hidden" name="exchange_money" value="<?php echo $TPL_VAR["list"]["exchange_money"]?>">
		<input type="hidden" name="charge_money" value="<?php echo $TPL_VAR["list"]["charge_money"]?>">
		<input type="hidden" name="rate" value="<?php echo $TPL_VAR["list"]["rate"]?>">
		<input type="hidden" name="optmoney" value="<?php echo ($TPL_VAR["list"]["charge_money"]-$TPL_VAR["list"]["exchange_money"])*((100-$TPL_VAR["list"]["rate"])/100)?>">
		<input type="hidden" name="bank_name" value="<?php echo $TPL_VAR["list"]["bank_name"]?>">
		<input type="hidden" name="bank_num" value="<?php echo $TPL_VAR["list"]["bank_num"]?>">
		<input type="hidden" name="bank_username" value="<?php echo $TPL_VAR["list"]["bank_username"]?>">
	
		<table cellspacing="1" class="tableStyle_membersWrite" summary="정산신청">
		<legend class="blind">정산신청</legend>
		<tr>
			<th>파트너ID</th><!--partner id-->
			<td width="70%"><?php echo $TPL_VAR["partner_name"]?></td>
			</tr>
		<tr>
			<th>정산시작</th><!--结束开始日期-->
			<td><?php echo $TPL_VAR["list"]["reg_date"]?></td>
			</tr>
	
		<tr>
			<th>정산완료</th><!--结算结束日期-->
			<td><?php echo $TPL_VAR["list"]["objdate"]?></td>
		</tr>
		<tr>
			<th>정산내역</th><!--结算内容-->
			<td>입금금액(<?php echo number_format($TPL_VAR["list"]["charge_money"],0)?>)-출금금액(<?php echo number_format($TPL_VAR["list"]["exchange_money"],0)?>)=(<?php echo number_format($TPL_VAR["list"]["charge_money"]-$TPL_VAR["list"]["exchange_money"],0)?>)의<?php echo $TPL_VAR["list"]["rate"]?>%</td>
		</tr>
		<tr>
			<th>정산금액</th><!--结算金额-->
			<td><?php echo number_format(($TPL_VAR["list"]["charge_money"]-$TPL_VAR["list"]["exchange_money"])*((100-$TPL_VAR["list"]["rate"])/100),0)?></td>
		</tr>
		<tr>
			<th>은행명</th><!--银行名-->
			<td><?php echo $TPL_VAR["list"]["bank_name"]?></td>
		</tr>
		<tr>
			<th>계좌번호</th><!--银行帐号-->
			<td><?php echo $TPL_VAR["list"]["bank_num"]?></td>
		</tr>
		<tr>
			<th>예금주</th><!--收款人姓名-->
			<td><?php echo $TPL_VAR["list"]["bank_username"]?></td>
		</tr>
		<tr>
			<td colspan="2" class="partner_acconting"> 
				  <font color="red">10,000원 이상부터 정산 신청이 가능합니다.</font>
			</td>
		</tr>
<?php if(($TPL_VAR["list"]["charge_money"]-$TPL_VAR["list"]["exchange_money"])*((100-$TPL_VAR["list"]["rate"])/100)>1000){?>		
					<tr>
						<td colspan="2" class="partner_acconting"> 
							  <font color="red">계좌번호 변경은 상단의 계좌변경 메뉴를 통해 가능합니다.</font>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="partner_acconting"> 
							   <input type="submit" value="정산신청" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
						</td>
					</tr>
<?php }?>
<?php }?>
		</table>
		</form>
</body>
</html>