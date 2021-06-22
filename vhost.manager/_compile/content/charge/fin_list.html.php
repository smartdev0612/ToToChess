<?php /* Template_ 2.2.3 2014/01/07 17:54:38 D:\www\vhost.manager\_template\content\charge\fin_list.html */
$TPL_partner_list_1=empty($TPL_VAR["partner_list"])||!is_array($TPL_VAR["partner_list"])?0:count($TPL_VAR["partner_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '입금완료';</script>

<div class="wrap" id="Richer_over">
	<div id="route">
		<h5>관리자 시스템 > 입출금 관리 > <b>입금완료</b></h5>
	</div>

	<h3>입금완료</h3>

	<ul id="tab">
		<li><a href="/charge/list" id="Richer">입금신청</a></li>
		<li><a href="/charge/finlist" id="Richer_over">입금완료</a></li>
		<li><a href="/exchange/list" id="Withdrawal">출금신청</a></li>
		<li><a href="/exchange/finlist" id="Withdrawal_over">출금완료</a></li>
	</ul>
	<div id="search">
		<div class="wrap">
			<form action="?" method="GET" name="form2" id="form2">
				<span class="icon">출력</span>
				<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<!-- 날짜 타입  필터 -->
				<select name="date_type">
					<option value="regdate"  <?php if($TPL_VAR["date_type"]=="regdate"){?>  selected <?php }?>>신청시간</option>
					<option value="operdate" <?php if($TPL_VAR["date_type"]=="operdate"){?> selected <?php }?>>처리시간 </option>
				</select>	
				
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
				
				<!-- 검색버튼 -->
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=del">
	<table cellspacing="1" class="tableStyle_normal" summary="입금신청 목록">
	<legend class="blind">입금신청 목록</legend>
	<thead>
		<tr>
			<th scope="col">사이트</td>
			<th scope="col">신청시간</th>
			<th scope="col">처리시간</th>
			<th scope="col" class="id">아이디</th>
			<th scope="col">닉네임</th>
			<th scope="col">등급</th>
			<th scope="col">당시금액</td>
			<th scope="col">보유금액</th>
			<th scope="col">신청금액</th>
			<th scope="col">실입금액</td>
			<th scope="col">보너스</td>
			<th scope="col">입금자명</th>
			<th scope="col">총판</th>
			<th scope="col">상태</th>
			<!--<th scope="col">처리</th>-->
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr class="link_lan" style="padding-left:1px;"  onMouseOver="this.style.backgroundColor='#e0eafe';" onMouseOut="this.style.backgroundColor=''">
			<td><?php echo $TPL_V1["logo"];?></td>
			<td><?php echo $TPL_V1["regdate"]?></td>        
			<td><?php echo $TPL_V1["operdate"]?></td>
			<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></td>
			<td><?php echo $TPL_V1["nick"]?></td>
			<td><?php echo $TPL_V1["mem_lev"]?></td>
			<td><?php echo number_format($TPL_V1["before_money"],0)?></td>
			<td><?php echo number_format($TPL_V1["g_money"],0)?></td>
			<td><b><font color='blue'><?php echo number_format($TPL_V1["amount"],0)?></font></b></td>
			<td><?php echo number_format($TPL_V1["agree_amount"],0)?></td>			
			<td><font color='red'><?php echo number_format($TPL_V1["bonus"],0)?></font></td>
			<td><?php echo $TPL_V1["bank_owner"]?></td>
			<td><?php echo $TPL_V1["recommendId"]?></td>
			<td>완료</td>
			<!--
			<td>
				<a href="javascript:open_window('/charge/cancelProcess?sn=<?php echo $TPL_V1["sn"]?>',400,250)"><img src="/img/btn_s_cancel.gif"></a>
			</td>
			-->
		</tr>
<?php }}?>
	</tbody>
	</table>
	</form>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>