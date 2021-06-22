<div class="wrap" id="write">
	<div id="route">
		<h5>사다리 밸런스 > <b>발란스 옵션</b></h5>
	</div>

	<h3>발란스 옵션(다리다리)</h3>
	<form>
		<input type="hidden" name="" value="">
		<table cellspacing="1" class="tableStyle_membersWrite">
		<legend class="blind">발란스 옵션</legend>
			<tr>
				<th style="width:20%;">발란스 상부 사이트</th>
				<td><input id="domain" name="domain" type="text" value="<?php echo $TPL_VAR["balanceInfo"]["domain"];?>"></td>
			</tr>
			<tr>
				<th>발란스 아이디</th>
				<td><input id="bal_id" name="bal_id" type="text" value='<?php echo $TPL_VAR["balanceInfo"]["id"];?>'></td>
		  </tr>
		  <tr>
				<th>발란스 아이디 패스워드</th>
				<td><input id="bal_passwd" name="bal_passwd" type="text" value="<?php echo $TPL_VAR["balanceInfo"]["passwd"];?>"></td>
		  </tr>
<!--		  <tr>-->
<!--				<th>발란스 아이디 보유금</th>-->
<!--				<td><span id="money" style="color:red;">불러오는중...</span></td>-->
<!--		  </tr>-->
<!--		  <tr>-->
<!--				<th>발란스 배팅 비율</th>						-->
<!--				<td><span id="balance_per" style="color:red;">불러오는중...</span></td>-->
<!--		  </tr>-->
<!--		  <tr>-->
<!--				<th>발란스 롤링수익 비율</th>-->
<!--				<td><span id="parent_per" style="color:red;">불러오는중...</span></td>-->
<!--		  </tr>-->
<!--		  <tr>-->
<!--				<th>발란스 상부 사다리 배당</th>-->
<!--				<td><span id="top_sadari_rate" style="color:red;">불러오는중...</span></td>-->
<!--		  </tr>-->
		  <!--<tr>
				<th>내사이트 사다리 배당</th>
				<td><?php /*echo $TPL_VAR["sadariRate"];*/?></td>
		  </tr>-->
		  <!--<tr>
				<th>발란스 타입</th>
				<td>
					<input name="bal_type" type="radio" value="all" class="recomInput" <?php /*if($TPL_VAR["balanceInfo"]["bal_type"]=="all") echo "checked";*/?>> 전체
					<input name="bal_type" type="radio" value="balance" class="recomInput" <?php /*if($TPL_VAR["balanceInfo"]["bal_type"]=="balance") echo "checked";*/?>> 발란스
				</td>
		  </tr>-->
<!--
		  <tr>
				<th>발란스 배팅</th>
				<td>
					<input name="use_flag" type="radio" value="1" class="recomInput" <?php if($TPL_VAR["balanceInfo"]["use_flag"]=="1") echo "checked";?>> 사용
					<input name="use_flag" type="radio" value="2" class="recomInput" <?php if($TPL_VAR["balanceInfo"]["use_flag"]=="2") echo "checked";?>> 중지
				</td>
		  </tr>
-->
		</table>
		<div id="wrap_btn">
	      <input type="button" value="적  용" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onClick="balanceSave();">
	    </div>
	</form>
</div>

<script>
	$(document).ready(function() {
		/*setTimeout(function(){
			balanceLoad();
		},1000);*/
	});

	function balanceLoad() {
		var domain = $("#domain").val();
		var bal_id = $("#bal_id").val();
		var bal_passwd = $("#bal_passwd").val();
        var type ='dari';

        var data = {domain:domain, bal_id:bal_id, bal_passwd:bal_passwd, type:type};
		$.ajax({
			url : "/api/top_balance_info",
			data : data,
			type : "post", cache : false, async : false, timeout : 5000, scriptCharset : "utf-8", dataType : "json",
			success: function(res) {
				if ( typeof(res) == "object" ) {
					if ( res.result == "ok" ) {
						$("#money").html(FormatNumber(res.money)+"원");
						$("#balance_per").html(res.betting_per+"%");
						$("#parent_per").html(res.parent_per+"%");
						$("#top_sadari_rate").html(res.sadari_rate);
					} else {
						$("#money, #balance_per, #parent_per, #top_sadari_rate").html(res.error_msg);
					}
				}
			},
			error: function(xhr,status,error) {
				alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
			}	
		});
	}

	function balanceSave() {
		var domain = $("#domain").val();
		var bal_id = $("#bal_id").val();
		var bal_passwd = $("#bal_passwd").val();
		var bal_type = $(':radio[name="bal_type"]:checked').val();
		//var use_flag = $(':radio[name="use_flag"]:checked').val();
		var use_flag = 1;
        var type ='dari';

        var data = {domain:domain, bal_id:bal_id, bal_passwd:bal_passwd, bal_type:bal_type, use_flag:use_flag, type:type};
		$.ajax({
			url : "/api/save_config",
			data : data,
			type : "post", cache : false, async : false, timeout : 5000, scriptCharset : "utf-8", dataType : "json",
			success: function(res) {
				if ( typeof(res) == "object" ) {
					if ( res.result == "ok" ) {
						alert("적용 되었습니다.");
						$("#money, #balance_per, #parent_per, #top_sadari_rate").html("불러오는중...");
						setTimeout(function(){
							//balanceLoad();
						},1000);
					} else {
						alert(res.error_msg);
					}
				}
			},
			error: function(xhr,status,error) {
				alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
			}	
		});
	}
</script>