<script>
	function onSave()
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
		<h5>관리자 시스템 > 시스템 관리 > <b>배팅 설정</b></h5>
	</div>

	<h3>배팅설정</h3>
	
	<form id="frm" name="frm" method="post" action="?">
	<input type="hidden" id="mode" name="mode" value="save">
	
	<table cellspacing="1" class="tableStyle_members">
		<legend class="blind">배팅목록</legend>
		<thead>
	    <tr>
			<th scope="col">배팅방식</th>
			<th scope="col">승무패+핸디캡</th>
			<th scope="col">승무패+하이로우</th>
			<th scope="col">핸디캡+하이로우</th>
			<th scope="col">최소게임</th>
			<th scope="col">변경</th>
	    </tr>
		</thead>
		<tbody>
				<tr>
					<td>
						<select name="rule">
							<option value="0" <?php if($TPL_VAR["item"]["bet_rule"]==0){?> selected <?php }?>>혼합배팅</option>
							<option value="1" <?php if($TPL_VAR["item"]["bet_rule"]==1){?> selected <?php }?>>독립배팅</option>
						</select>
					</td>
					<td>
						<select name="vh">
							<option value="0" <?php if($TPL_VAR["item"]["bet_rule_vh"]==0){?> selected <?php }?>>가능</option>
							<option value="1" <?php if($TPL_VAR["item"]["bet_rule_vh"]==1){?> selected <?php }?>>불가능</option>
						</select>
					</td>
					<td>
						<select name="vu">
							<option value="0" <?php if($TPL_VAR["item"]["bet_rule_vu"]==0){?> selected <?php }?>>가능</option>
							<option value="1" <?php if($TPL_VAR["item"]["bet_rule_vu"]==1){?> selected <?php }?>>불가능</option>
						</select>
					</td>
					<td>
						<select name="hu">
							<option value="0" <?php if($TPL_VAR["item"]["bet_rule_hu"]==0){?> selected <?php }?>>가능</option>
							<option value="1" <?php if($TPL_VAR["item"]["bet_rule_hu"]==1){?> selected <?php }?>>불가능</option>
						</select>
					</td>
					<td>
						<input type="text" name="min_bet_count" class="w120" size="3" value="<?php echo $TPL_VAR["item"]["min_bet_count"]?>"/>
					</td>
					
					<td>
						<input type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" value="적용" onclick="onSave();"/></a>
					</td>
				</tr>
		</tbody>
	</table>
	
	<span id="op1"></span>
	</form>

</div>