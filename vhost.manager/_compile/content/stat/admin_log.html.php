<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 관리자 > <b>로그인 내역</b></h5>
	</div>

	<h3>로그인 내역</h3>

	<div id="search2">
		<div>
			<form action="?" method="GET" name="form2" id="form2">
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);" /> ~ 
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				<input name="Submit4" type="image" src="/img/btn_search.gif" onclick="on_click()" class="imgType" title="검색" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
		<table cellspacing="1" class="tableStyle_normal add" summary="관리자 로그인 내역">
			<legend class="blind">관리자 로그인 내역</legend>
			<thead>
				<tr>
					<th>아이디</th>
					<th>패스워드</th>
					<th>로그인IP</th>
					<th>로그인시간</th>
					<th>상태</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
					<tr>
						<td><?php echo $TPL_V1["admin_id"]?></td>
						<td><?php if($TPL_V1["admin_pw"]==""){?>
								***********
<?php }else{?>
								<?php echo $TPL_V1["admin_pw"]?>

<?php }?>
						</td>
						<td>[<?php echo $TPL_V1["country_code"]?>]<?php echo $TPL_V1["login_ip"]?></span></td>
						<td><?php echo $TPL_V1["login_date"]?></td>
						<td>
<?php if($TPL_V1["status"]==0){?>
								<?php echo $TPL_V1["result"]?>

<?php }else{?>
								<font color='red'><?php echo $TPL_V1["result"]?></font>
<?php }?>
						</td>
					</tr>
<?php }}?>
			</tbody>
		</table>
	</form>

	<div id="pages2">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>

</div>