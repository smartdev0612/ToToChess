<?php /* Template_ 2.2.3 2012/10/09 18:30:16 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\popup.member.login_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
</head>

<body>
<div class="wrap" id="members">

	<div id="route">
		<h5>관리자 시스템 > 회원 관리 > <b>접속 기록</b></h5>
	</div>

	<h3>접속 기록</h3>

	<div id="search">
		<div>
			<form action="?" method="get" name="form2" id="form2">
			<select name="field">
				<option value="member_id" 	<?php if($TPL_VAR["field"]=="member_id"){?> 	selected <?php }?>>아이디</option>
				<option value="visit_ip" 		<?php if($TPL_VAR["field"]=="visit_ip"){?>		selected <?php }?>>로그인IP</option>
			</select>
            <input name="username" type="text" id="key" class="name" value="<?php echo $TPL_VAR["str"]?>" maxlength="20"/>
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
          </form>
		</div>
	</div>
	<div id="table_sort">
		<form action="?" method="GET" name="form3" id="form3">
			<span class="icon">출력</span>
			<input name="perpage" type="text" id="perpage" class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" value="<?php echo $TPL_VAR["perpage"]?>" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/\D/g,''))"><input type="image" name="Submitok" src="/img/btn_s_sort.gif" class="imgType" title="정렬"/>
		</form>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_normal" summary="회원 접속기록">
	<legend class="blind">접속기록</legend>
	<thead>
	<tr>
		<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
		<th scope="col" class="id">아이디</td>
		<th scope="col">닉네임</td>
		<th scope="col">등급</td>
		<th scope="col">입금횟수</td>
		<th scope="col">보유금액</td>
		<th scope="col">접속시간</td>
		<th scope="col">접속IP</td>
		<th scope="col">상태</td>
		<th scope="col">처리</td>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><input name="y_id[]" type="checkbox" id="y_id"  value="<?php echo $TPL_V1["idx"]?>" onclick="javascript:chkRow(this);"/></td>
				<td>
<?php if($TPL_V1["status"]==0){?>
						<a href="javascript:open_window('user_details.php?idx=<?php echo $TPL_V1["aidx"]?>',1024,600)"><?php echo $TPL_V1["member_id"]?></a>
<?php }else{?>
						<?php echo $TPL_V1["member_id"]?>

<?php }?>
				</td>
				<td><?php echo $TPL_V1["nick"]?></td>
				<td><?php echo $TPL_VAR["levelList"][$TPL_V1["mem_lev"]]?></span></td>
				<td><?php echo $TPL_V1["RechargeNum"]?></td>
				<td><?php echo number_format($TPL_V1["g_money"],0)?></td>
				<td><?php echo $TPL_V1["visit_date"]?></td>
				<td>[<?php echo $TPL_V1["country_code"]?>]<?php echo $TPL_V1["visit_ip"]?></td>
				<td><?php echo $TPL_V1["result"]?></td>
				<td><a href="javascript:void(0)" onclick="comfire_ok(<?php echo $TPL_V1["idx"]?>,'/member/poploginlist?act=deleteone&idx=')"><img src="/img/btn_s_del.gif" title="삭제"></a></td>    
			  </tr>  
<?php }}?>
	</tbody>
	</table>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
	<div id="wrap_btn">
		<p class="left">
			<input type="button" name="open" value="선택삭제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
		</p>
	</div>
	</form>
</div>
</body>
</html>