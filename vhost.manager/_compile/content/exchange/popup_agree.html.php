<?php /* Template_ 2.2.3 2012/11/12 12:16:26 D:\www\vhost.manager\_template\content\exchange\popup_agree.html */?>
<div id="wrap_pop">
	<div id="pop_title">
		<h1>출금승인</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<form name="frm" method="post" action="/exchange/popup_agree?mode=edit">
		<input type="hidden" name="money_idx" value="<?php echo $TPL_VAR["sn"]?>">
		<input type="hidden" name="rmoney" value="<?php echo $TPL_VAR["amount"]?>">
	
		<table cellspacing="1" class="tableStyle_membersWrite">
		<legend class="blind">출금승인</legend>
			<tr>
			  <th nowrap width="45%">출금액</th>
			  <td><?php echo number_format($TPL_VAR["amount"],0)?></td>
			</tr>
			<tr>
			  <th>출금확인</th>
			  <td>출금 신청을 <font color='red'>승인</font>시킵니다.</td>
			</tr>
		</table>
		
		<input type="submit" value="확 인"  class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'">
	</form>

</div>