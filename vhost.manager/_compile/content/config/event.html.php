<?php /* Template_ 2.2.3 2012/11/30 16:46:54 D:\www\vhost.manager\_template\content\config\event.html */?>
<script>
	function onSave($sn)
	{
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
		<h5>관리자 시스템 > 시스템 관리 > <b>이벤트 설정</b></h5>
	</div>

	<h3>이벤트목록</h3>
	
	<form id="frm" name="frm" method="post" action="?">
	<input type="hidden" id="mode" name="mode" value="save">
	
	<table cellspacing="1" class="tableStyle_members">
		<legend class="blind">이벤트목록</legend>
		<thead>
	    <tr>
			<th scope="col">이벤트코인 입금금액</th>
			<th scope="col" colspan="10">폴더수/당첨금액</th>
			<th scope="col">수정</th>
	    </tr>
	    <tr>
	    	<td></td>
	    	<td class="eventCoin">1</th>
	    	<td class="eventCoin">2</th>
	    	<td class="eventCoin">3</th>
	    	<td class="eventCoin">4</th>
	    	<td class="eventCoin">5</th>
	    	<td class="eventCoin">6</th>
	    	<td class="eventCoin">7</th>
	    	<td class="eventCoin">8</th>
	    	<td class="eventCoin">9</th>
	    	<td class="eventCoin">10</th>
	    	<td></td>
		</tr>
		</thead>
		<tbody>
			<tr>
			</tr>
				<tr id="tr">
					<td><input type="text" name="min_charge" class="w120" value="<?php echo $TPL_VAR["item"]["min_charge"]?>" 	onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"></td>
					<td><input type="text" name="bonus1" class="w120" size="10" value="<?php echo $TPL_VAR["item"]["bonus1"]?>" 	onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" /></td>
					<td><input type="text" name="bonus2" class="w120" size="10" value="<?php echo $TPL_VAR["item"]["bonus2"]?>" 	onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/></td>
					<td><input type="text" name="bonus3" class="w120" size="10" value="<?php echo $TPL_VAR["item"]["bonus3"]?>"	onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/></td>
					<td><input type="text" name="bonus4" class="w120" size="10" value="<?php echo $TPL_VAR["item"]["bonus4"]?>" 	onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/></td>
					<td><input type="text" name="bonus5" class="w120" size="10" value="<?php echo $TPL_VAR["item"]["bonus5"]?>" 	onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/></td>
					<td><input type="text" name="bonus6" class="w120" size="10" value="<?php echo $TPL_VAR["item"]["bonus6"]?>" 	onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/></td>
					<td><input type="text" name="bonus7" class="w120" size="10" value="<?php echo $TPL_VAR["item"]["bonus7"]?>" 	onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/></td>
					<td><input type="text" name="bonus8" class="w120" size="10" value="<?php echo $TPL_VAR["item"]["bonus8"]?>" 	onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/></td>
					<td><input type="text" name="bonus9" class="w120" size="10" value="<?php echo $TPL_VAR["item"]["bonus9"]?>" 	onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/></td>
					<td><input type="text" name="bonus10" class="w120" size="10" value="<?php echo $TPL_VAR["item"]["bonus10"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"/></td>
					<td><input type="button" class="btnStyle_s" value="수정" onclick="onSave();"/></a></td>
				</tr>
		</tbody>
	</table>
	</form>

</div>