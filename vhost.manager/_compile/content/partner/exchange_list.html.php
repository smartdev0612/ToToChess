<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	document.title = '총판 출금 신청 리스트';

	function actionProc(mode, log_sn) {
		var result = confirm("정말 처리 하시겠습니까?");
		if ( !result ) return;
		$("#procIframe").attr('src','/partner/exchange_popup_process?mode='+mode+'&log_sn='+log_sn);
	}
</script>

<div class="wrap" id="Withdrawal_over">
	<div id="route">
		<h5>관리자 시스템 > 총판 관리 > <b>총판출금</b></h5>
	</div>

	<h3>총판 출금 신청 리스트</h3>

	<div id="search">
		<div class="wrap">
			<form action="?" method="GET" name="form2" id="form2">
				<span class="icon2">출력</span>
				<input name="perpage" type="text" id="perpage" class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="icon2">처리상태</span>
				<select name="proc_flag">
					<option value="" <?php if($TPL_VAR["proc_flag"]==""){?>  selected <?php }?>>전체</option>
					<option value="0" <?php if($TPL_VAR["proc_flag"]=="0"){?>  selected <?php }?>>처리중</option>
					<option value="1" <?php if($TPL_VAR["proc_flag"]=="1"){?> selected <?php }?>>완료 </option>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="icon2">날짜</span>
				<select name="date_type">
					<option value="regdate"  <?php if($TPL_VAR["date_type"]=="regdate"){?>  selected <?php }?>>신청시간</option>
					<option value="procdate" <?php if($TPL_VAR["date_type"]=="procdate"){?> selected <?php }?>>처리시간 </option>
				</select>	
				<input name="start_date" type="text" id="start_date" class="date" value="<?php echo $TPL_VAR["start_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				&nbsp;&nbsp;&nbsp;&nbsp;			
				<!-- 키워드 검색 -->
				<select name="field">
					<option value="id" <?php if($TPL_VAR["field"]=="id"){?> 	selected <?php }?>>아이디</option>
					<option value="name" <?php if($TPL_VAR["field"]=="name"){?> 	selected <?php }?>>이름</option>
				</select>
				<input name="keyword" type="text" id="key" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20" onmouseover="this.focus()"/>
				
				<!-- 검색버튼 -->
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" />
			</form>
		</div>
	</div>

	<iframe src="about:Tabs" id="procIframe" name="procIframe" style="display:none;"></iframe>
	<table cellspacing="1" class="tableStyle_normal" summary="출금완료 목록">
	<legend class="blind">출금완료 목록</legend>
	<thead>
		<tr>
			<th scope="col">신청시간</th>
			<th scope="col">처리시간</th>
			<th scope="col" class="id">아이디</th>
			<th scope="col">이름</th>
			<th scope="col">당시금액</th>
			<th scope="col">보유금액</th>
			<th scope="col">출금금액</th>
			<th scope="col">출금설명</th>
			<th scope="col">상태</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr class="link_lan" style="padding-left:1px;"  onMouseOver="this.style.backgroundColor='#e0eafe';" onMouseOut="this.style.backgroundColor=''" >
			<td  <?php if($TPL_V1["proc_flag"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["regdate"]?></td>        
			<td  <?php if($TPL_V1["proc_flag"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["procdate"]?></td>
			<td  <?php if($TPL_V1["proc_flag"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><a href="javascript:open_window('/partner/memberDetails?idx=<?php echo $TPL_V1["rec_sn"]?>',640,440)"><?php echo $TPL_V1["rec_id"]?></td>
			<td  <?php if($TPL_V1["proc_flag"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["rec_name"]?></td>
			<td  <?php if($TPL_V1["proc_flag"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo number_format($TPL_V1["before_money"],0)?></td>
			<td  <?php if($TPL_V1["proc_flag"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo number_format($TPL_V1["rec_money"],0)?></td>
			<td  <?php if($TPL_V1["proc_flag"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><b><font color='red'><?php echo number_format($TPL_V1["amount"],0)?></font></b></td>
			<td  <?php if($TPL_V1["proc_flag"]=='0'){?>style="background-color:#FAF4C0"<?php }?>><?php echo $TPL_V1["status_message"]?></td>
			<td  <?php if($TPL_V1["proc_flag"]=='0'){?>style="background-color:#FAF4C0"<?php }?>>
<?php if($TPL_V1["proc_flag"]==0){?>
					<a href="javascript:actionProc('success','<?php echo $TPL_V1["log_sn"]?>');"><img src="/img/btn_s_confirm2.gif" title="승인"></a>
					<a href="javascript:actionProc('cancel','<?php echo $TPL_V1["log_sn"]?>');"><img src="/img/btn_s_cancel.gif" title="취소"></a>
<?php }elseif($TPL_V1["proc_flag"]==3){?>
				<font color='blue'>취소(반환)</font>
<?php }elseif($TPL_V1["proc_flag"]==1){?>
				<font color='blue'>완료</font>
<?php }?>	
			</td>
		</tr>
<?php }}?>
	</tbody>
	</table>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>
	</div>
</div>