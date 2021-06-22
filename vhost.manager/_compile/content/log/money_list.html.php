<?php
$TPL_partner_list_1=empty($TPL_VAR["partner_list"])||!is_array($TPL_VAR["partner_list"])?0:count($TPL_VAR["partner_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '입출금 관리-머니내역';</script>

<div class="wrap" id="Richer">

	<div id="route">
		<h5>관리자 시스템 > 입출금 관리 > <b>머니내역</b></h5>
	</div>

	<h3>머니 내역</h3>

	<ul id="tab">
		<li><a href="/log/moneyloglist" id="Richer">머니 내역</a></li>
		<li><a href="/log/mileageloglist" id="Richer_over">마일리지 내역</a></li>
	</ul>

	<div id="search">
		<div class="wrap">
			<form action="?" method="GET" name="form2" id="form2">
				<span class="icon">출력</span>
				<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<!-- 기간 필터 -->
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				
				<!-- 총판 필터 -->
				<select name="filter_partner_sn">
					<option value="" <?php if($TPL_VAR["filter_partner_sn"]==""){?> selected <?php }?>>총판</option>
<?php if($TPL_partner_list_1){foreach($TPL_VAR["partner_list"] as $TPL_V1){?>
						<option value=<?php echo $TPL_V1["Idx"]?> <?php if($TPL_VAR["filter_partner_sn"]==$TPL_V1["Idx"]){?> selected <?php }?>><?php echo $TPL_V1["rec_id"]?></option>
<?php }}?>
				</select>
				
				<!-- 키워드 검색 -->
				<select name="field">
					<option value="uid" <?php if($TPL_VAR["field"]=="uid"){?> 	selected <?php }?>>아이디</option>
					<option value="nick"   <?php if($TPL_VAR["field"]=="nick"){?> 	selected <?php }?>>닉네임</option>
					<option value="bank_owner" <?php if($TPL_VAR["field"]=="bank_owner"){?> 	selected <?php }?>>예금주</option>
				</select>
				<input name="keyword" type="text" id="key" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20" onmouseover="this.focus()"/>
				
				<!-- 상태 검색 -->
				<select name="filter_state">
					<option value="" 	<?php if($TPL_VAR["filter_state"]==""){?> selected <?php }?>>::머니 발생사유</option>
					<option value="1" <?php if($TPL_VAR["filter_state"]==1){?> selected <?php }?>>+충전</option>
					<option value="2" <?php if($TPL_VAR["filter_state"]==2){?> selected <?php }?>>-환전</option>
					<option value="3" <?php if($TPL_VAR["filter_state"]==3){?> selected <?php }?>>-배팅</option>
					<option value="4" <?php if($TPL_VAR["filter_state"]==4){?> selected <?php }?>>+당첨</option>
					<option value="5" <?php if($TPL_VAR["filter_state"]==5){?> selected <?php }?>>배팅취소</option>
					<option value="6" <?php if($TPL_VAR["filter_state"]==6){?> selected <?php }?>>-포인트 전환</option>
					<option value="7" <?php if($TPL_VAR["filter_state"]==7){?> selected <?php }?>>관리자 강제 변환 머니</option>
					<option value="8" <?php if($TPL_VAR["filter_state"]==8){?> selected <?php }?>>정산취소</option>
					<option value="10" <?php if($TPL_VAR["filter_state"]==10){?> selected <?php }?>>맞고</option>
				</select>
				
				<!-- 검색버튼 -->
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=del">
		<table cellspacing="1" class="tableStyle_normal">
			<legend class="blind">머니 내역</legend>
			<thead>
			<tr>
				  <th scope="col">일시</th>
				  <th scope="col" class="id">아이디</th>
				  <th scope="col">닉네임</th>
				  <th scope="col">예금주</th>
				  <th scope="col">총판</th>
				  <th scope="col">당시금액</th>
				  <th scope="col">변동금액</th>
				  <th scope="col">최종금액</th>
				  <th scope="col">사유</th>
				  <th scope="col">충전횟수</th>
				  <th scope="col">비고</th>
			</tr>
			</thead>
			<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr class="link_lan" style="padding-left:1px;"  onMouseOver="this.style.backgroundColor='#e0eafe';" onMouseOut="this.style.backgroundColor=''">
					<td><?php echo $TPL_V1["log_regdate"]?></td>
					<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></td>
					<td><?php echo $TPL_V1["nick"]?></td>
					<td><?php echo $TPL_V1["bank_member"]?></td>
					<td><?php echo $TPL_V1["rec_id"]?></td>
									
					<td><?php echo number_format($TPL_V1["before_money"],0)?></td>
					<td>
<?php if($TPL_V1["amount"]<0){?><font color='red'><?php echo number_format($TPL_V1["amount"],0)?></font>
<?php }else{?><font color='blue'><?php echo number_format($TPL_V1["amount"],0)?></font>
<?php }?>
					</td>
					<td><?php echo number_format($TPL_V1["after_money"],0)?></td>					
					<td>
<?php
	if ( $TPL_V1["betting_no"]  > 0 )
		echo "<a href=\"javascript:open_window('http://master.memopow.com/member/popup_bet?mem_sn=".$TPL_V1["member_sn"]."&betting_no=".$TPL_V1["betting_no"]."',1024,600)\">".$TPL_V1["status_message"]."</a>";
	else
		echo $TPL_V1["status_message"];
?>
					</td>
					<td><?php echo $TPL_V1["charge_cnt"]?></td>
					<td><?php echo $TPL_V1["log_memo"]?></td>
				</tr>
<?php }}?>
			</tbody>
		</table>
	</form>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>