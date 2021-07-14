<?php
$TPL_partner_list_1=empty($TPL_VAR["partner_list"])||!is_array($TPL_VAR["partner_list"])?0:count($TPL_VAR["partner_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '출금완료';</script>

<div class="wrap" id="Withdrawal_over">
	<div id="route">
		<h5>관리자 시스템 > 입출금 관리 > <b>출금완료</b></h5>
	</div>

	<h3>출금완료</h3>

	<ul id="tab">
		<li><a href="/charge/finlist_edit" id="Richer_over">입금</a></li>
		<li><a href="/exchange/finlist_edit" id="Withdrawal_over">출금</a></li>
	</ul>
	<div id="search">
		<div class="wrap">
			<form action="?" method="GET" name="form2" id="form2">
				<span class="icon2">출력</span>
				<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				<select name="orderby">
					<option value="regdate" <?php if($TPL_VAR["orderby"]=="regdate"){?>  selected <?php }?>>최근신청순</option>
					<option value="lev_up" <?php if($TPL_VAR["orderby"]=="lev_up"){?>  selected <?php }?>>회원레벨↑</option>
					<option value="lev_down" <?php if($TPL_VAR["orderby"]=="lev_down"){?>  selected <?php }?>>회원레벨↓</option>
				</select>
				&nbsp;
				<span class="icon2">사이트</span>
				<select name="filter_logo">
					<option value=""  <?php if($TPL_VAR["filter_logo"]==""){?>  selected <?php }?>>전체</option>
					<option value="gadget" <?php if($TPL_VAR["filter_logo"]=="gadget"){?>  selected <?php }?>>gadget</option>
				</select>
				&nbsp;
				<span class="icon2">처리상태</span>
				<select name="filter_state">
					<option value=""  <?php if($TPL_VAR["filter_state"]==""){?>  selected <?php }?>>전체</option>
					<option value="0"  <?php if($TPL_VAR["filter_state"]=="0"){?>  selected <?php }?>>처리중</option>
					<option value="1" <?php if($TPL_VAR["filter_state"]=="1"){?> selected <?php }?>>완료 </option>
				</select>
				&nbsp;
				<span class="icon2">날짜</span>
				<select name="date_type">
					<option value="regdate"  <?php if($TPL_VAR["date_type"]=="regdate"){?>  selected <?php }?>>신청시간</option>
					<option value="operdate" <?php if($TPL_VAR["date_type"]=="operdate"){?> selected <?php }?>>처리시간 </option>
				</select>	
				<input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				&nbsp;
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
	<table cellspacing="1" class="tableStyle_normal" summary="출금완료 목록">
	<legend class="blind">출금완료 목록</legend>
	<thead>
		<tr>
			<th scope="col">신청시간</th>
			<th scope="col">처리시간</th>
			<th scope="col" class="id">아이디</th>
			<th scope="col">레벨</th>
			<th scope="col">닉네임</th>
			<th scope="col">바로가기</td>
			<th scope="col">당시금액</th>
			<th scope="col">보유금액</th>
			<th scope="col">출금금액</th>
			<th scope="col">보너스</th>
			<th scope="col">은행명</th>
			<th scope="col">계좌번호</th>
			<th scope="col">예금주</th>
			<th scope="col">총판</th>
			<th scope="col">상태</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr class="link_lan" style="padding-left:1px;"  onMouseOver="this.style.backgroundColor='#e0eafe';" onMouseOut="this.style.backgroundColor=''" >
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["regdate"]?></td>        
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["operdate"]?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["mem_lev"]?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["nick"]?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>
				<input type="button" value="머니" style="cursor:pointer; padding:3px;" onClick="open_window('/log/popup_moneyloglist?field=uid&uid=<?php echo $TPL_V1["uid"]?>',1000,600);">
				<input type="button" value="배팅" style="cursor:pointer; padding:3px;" onClick="open_window('/member/popup_bet?mem_sn=<?php echo $TPL_V1["member_sn"]?>','1400',600);">
			</td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo number_format($TPL_V1["before_money"],0)?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo number_format($TPL_V1["g_money"],0)?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><b><font color='red'><?php echo number_format($TPL_V1["amount"],0)?></font></b></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo number_format($TPL_V1["bonus"],0)?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["bank"]?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["bank_account"]?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["bank_owner"]?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["recommendId"]?></td>
			<td <?php if($TPL_V1["state"]=='0'){?>style="background-color:#FAF4C0"<?php }?>>
<?php if($TPL_V1["state"] == 0){?>
					<a href="javascript:open_window('/exchange/popup_process?memberSn=<?php echo $TPL_V1["member_sn"]?>&amount=<?php echo $TPL_V1["amount"]?>&sn=<?php echo $TPL_V1["sn"]?>',400,250)">
						<img src="/img/btn_s_confirm2.gif" title="대기">
					</a>
					<a href="javascript:open_window('/exchange/popup_process?mode=cancel&memberSn=<?php echo $TPL_V1["member_sn"]?>&amount=<?php echo $TPL_V1["amount"]?>&sn=<?php echo $TPL_V1["sn"]?>',400,250)">
						<img src="/img/btn_s_cancel.gif" title="취소">
					</a>
<?php } else if ($TPL_V1["state"] == 3){?>
					<a href="javascript:open_window('/exchange/popup_agree?mode=edit&member_sn=<?php echo $TPL_V1["member_sn"]?>&amount=<?php echo $TPL_V1["amount"]?>&sn=<?php echo $TPL_V1["sn"]?>',450,200)">
						<img src="/img/btn_s_confirm2.gif" title="승인">
					</a>
<?php } else if ($TPL_V1["state"] == 2) { ?>
			<font color='red'>취소</font>
<?php } else if ($TPL_V1["state"] == 1){?>
			<font color='blue'>완료</font>
<?php } ?>	
			</td>
		</tr>
<?php }}?>
	</tbody>
	</table>
	</form>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>