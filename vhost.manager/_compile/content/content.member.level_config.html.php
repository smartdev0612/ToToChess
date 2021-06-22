<?php /* Template_ 2.2.3 2012/10/06 18:20:35 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.member.level_config.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="wrap" id="members">

	<div id="route">
		<h5>관리자 시스템 > 회원 관리 > <b>등급설정</b></h5>
	</div>

	<h3>등급설정</h3>

	<form id="form1" name="form1" method="get" action="?">
		<table cellspacing="1" class="tableStyle_members grade" summary="등급설정">
		<legend class="blind">회원 등급설정</legend>
		<thead>
			<tr>
			  <th>회원등급</th>
			  <th>등급명</th>
			  <th>최소베팅금액</th>
			  <th>최대베팅금액</th>
			  <th>최대당첨금액</th>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr>
				  <td class="level"><?php echo $TPL_V1["lev"]?></td>
				  <td><input type="text" class="levelName" name="lev_name<?php echo $TPL_V1["id"]?>" value="<?php echo $TPL_V1["lev_name"]?>" onmouseover="this.focus()"></td>
				  <td><input type="text" name="lev_min_money<?php echo $TPL_V1["id"]?>" value="<?php echo number_format($TPL_V1["lev_min_money"],0)?>" onkeyUp="javascript:this.value=FormatNumber(this.value);" onmouseover="this.focus()"></td>
				  <td><input type="text" name="lev_max_money<?php echo $TPL_V1["id"]?>" value="<?php echo number_format($TPL_V1["lev_max_money"],0)?>" onkeyUp="javascript:this.value=FormatNumber(this.value);" onmouseover="this.focus()"></td>
				  <td><input type="text" name="lev_max_bouns<?php echo $TPL_V1["id"]?>" value="<?php echo number_format($TPL_V1["lev_max_bouns"],0)?>" onkeyUp="javascript:this.value=FormatNumber(this.value);" onmouseover="this.focus()"></td>	
				</tr>
<?php }}?>
		</table>	
	
		<input type="hidden" value="<?php echo $TPL_VAR["ids"]?>" name="strid">
		<div id="wrap_btn">
			<p class="left">
				<input type="submit" name="open" value="수  정" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'"/>
			</p>
		</div>
	</form>
</div>