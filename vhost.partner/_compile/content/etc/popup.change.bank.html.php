<?php /* Template_ 2.2.3 2012/11/30 16:56:48 D:\www\vhost.partner\_template\content\etc\popup.change.bank.html */?>
<title>파트너 계좌번호 변경</title>

<script>
function Form_ok() {
		if (Form1.banknum.value == "") {
		   alert("계좌번호를 입력하세요!");
		   document.Form1.banknum.focus();
		   return;
		}
		
		if(Form1.bankusername.value ==""){
			alert("예금주를 입력하세요!");
		    document.Form1.bankusername.focus();
		    return;
		}
		
		if (confirm("계좌번호를 변경합니다")) {
			document.Form1.submit();
		} else {
			return;
		}
}

</script>
</head>

<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>계좌번호 변경</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>
	
	<form name="Form1" action="?act=change" method="post">
		<table cellspacing="1" class="tableStyle_membersWrite thBig" summary="계좌번호 변경">
			<legend class="blind">계좌번호 변경</legend>
			<tr>
				<th>은행명</th>
				<td>
					<select name="bankname">
						<option value="국민은행" 		<?php if($TPL_VAR["list"]["rec_bankname"]=="국민은행"){?>selected<?php }?>>국민은행</option>
						<option value="광주은행" 		<?php if($TPL_VAR["list"]["rec_bankname"]=="광주은행"){?>selected<?php }?>>광주은행</option>
						<option value="경남은행" 		<?php if($TPL_VAR["list"]["rec_bankname"]=="경남은행"){?>selected<?php }?>>경남은행</option>
						<option value="기업은행" 		<?php if($TPL_VAR["list"]["rec_bankname"]=="기업은행"){?>selected<?php }?>>기업은행</option>
						<option value="농협" 				<?php if($TPL_VAR["list"]["rec_bankname"]=="농협"){?>selected<?php }?>>농협</option>
						<option value="대구은행" 		<?php if($TPL_VAR["list"]["rec_bankname"]=="대구은행"){?>selected<?php }?>>대구은행</option>
						<option value="도이치은행" 	<?php if($TPL_VAR["list"]["rec_bankname"]=="도이치은행"){?>selected<?php }?>>도이치은행</option>
						<option value="부산은행" 		<?php if($TPL_VAR["list"]["rec_bankname"]=="부산은행"){?>selected<?php }?>>부산은행</option>
						<option value="상호저축은행" 	<?php if($TPL_VAR["list"]["rec_bankname"]=="상호저축은행"){?>selected<?php }?>>상호저축은행</option>
						<option value="새마을금고"		<?php if($TPL_VAR["list"]["rec_bankname"]=="새마을금고"){?>selected<?php }?>>새마을금고</option>
						<option value="수협" 					<?php if($TPL_VAR["list"]["rec_bankname"]=="수협"){?>selected<?php }?>>수협</option>
						<option value="신협" 					<?php if($TPL_VAR["list"]["rec_bankname"]=="신협"){?>selected<?php }?>>신협</option>
						<option value="신한은행" 			<?php if($TPL_VAR["list"]["rec_bankname"]=="신한은행"){?>selected<?php }?>>신한은행</option>
						<option value="외환은행" 			<?php if($TPL_VAR["list"]["rec_bankname"]=="외환은행"){?>selected<?php }?>>외환은행</option>
						<option value="우리은행" 			<?php if($TPL_VAR["list"]["rec_bankname"]=="우리은행"){?>selected<?php }?>>우리은행</option>
						<option value="우체국" 				<?php if($TPL_VAR["list"]["rec_bankname"]=="우체국"){?>selected<?php }?>>우체국</option>
						<option value="전북은행" 			<?php if($TPL_VAR["list"]["rec_bankname"]=="전북은행"){?>selected<?php }?>>전북은행</option>
						<option value="제주은행" 			<?php if($TPL_VAR["list"]["rec_bankname"]=="제주은행"){?>selected<?php }?>>제주은행</option>
						<option value="하나은행" 			<?php if($TPL_VAR["list"]["rec_bankname"]=="하나은행"){?>selected<?php }?>>하나은행</option>
						<option value="한국씨티은행" 	<?php if($TPL_VAR["list"]["rec_bankname"]=="한국씨티은행"){?>selected<?php }?>>한국씨티은행</option>
						<option value="HSBC은행" 			<?php if($TPL_VAR["list"]["rec_bankname"]=="HSBC은행"){?>selected<?php }?>>HSBC은행</option>
						<option value="SC제일은행" 		<?php if($TPL_VAR["list"]["rec_bankname"]=="SC제일은행"){?>selected<?php }?>>SC제일은행</option>
					</select>
				</td>
				</tr>
			<tr>
				<th>계좌번호</th>
				<td><input type="text" name="banknum" value="<?php echo $TPL_VAR["list"]["rec_banknum"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" onmouseover="this.focus()"></td>
				</tr>
		
			<tr>
				<th>예금주</th>
				<td><input type="text" name="bankusername" value="<?php echo $TPL_VAR["list"]["rec_bankusername"]?>" onmouseover="this.focus()"></td>
			</tr>
		</table>
		<div id="wrap_btn">
			<input type="button" value="변경" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="Form_ok();">
			<input type="button" value="취소" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="window.close();">
		</div>
	</form>

</div>
</body>
</html>