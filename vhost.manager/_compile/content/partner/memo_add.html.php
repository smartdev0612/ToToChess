
<script>
	
function len(s)
{ 
	var l = 0; 
	var a = s.split(""); 
	for (var i=0;i<a.length;i++) 
	{ 
		if (a[i].charCodeAt(0)<299) 
		{ 
			l++; 
		} else
		{ 
			l+=2; 
		}	 
	} 
	return l; 
}
 
function Form_ok() 
{
		FormData = document.FormData;
		if (FormData.title.value == "") {
		   alert("제목 입력!!!");
		   document.FormData.title.focus();
		   return;
		}
		if(FormData.time.value ==""){
			alert("시간 선택!!!");
		    document.FormData.time.focus();
		    return;
		}
		if(len(FormData.time.value) !=19){
			alert("시간 격식이 틀립니다. 확인하십시오!!!");
		    document.FormData.time.focus();
		    return;
		}
		if (FormData.content.value == "") {
		   alert("내용 입력!!!");
		   document.FormData.content.focus();
		   return;
		}
		if (confirm("입력하신 내용을 등록 하시겠습니까 ?")) {		
			document.FormData.submit();
		}
		else 
		{
			return;
		}
}
</script>

<div class="wrap" id="partner_memo_add">

	<div id="route">
		<h5>관리자 시스템 > 파트너 관리 > <b>쪽지 쓰기</b></h5>
	</div>

	<h3>쪽지 쓰기</h3>

	<ul id="tab">
		<li><a href="/partner/memolist?p_type=<?=$TPL_VAR["p_type"]?>" id="partner_memo_box">받은 쪽지함</a></li>
		<li><a href="/partner/memosendlist?p_type=<?=$TPL_VAR["p_type"]?>" id="partner_memo">보낸 쪽지함</a></li>
		<li><a href="/partner/memoadd?p_type=<?=$TPL_VAR["p_type"]?>" id="partner_memo_add">쪽지 쓰기</a></li>
	</ul>

	<form action="?act=add" method="post"  name="FormData" id="FormData" >
		<input type="hidden" id="p_type" name="p_type" value=<?=$TPL_VAR["p_type"]?>>
		<table cellspacing="1" class="tableStyle_membersWrite" summary="파트너 메모 쓰기">
		<legend class="blind">메모 쓰기</legend>
			<tr>
				<th>제목</th>
				<td><input name="title" type="text"  class="wWhole" maxlength="45"/></td>
				</tr>
			<tr>
				<th>받는이</th>
				<td>
					<select id="toid" name="toid">
						<option value="">전체 파트너</option>
						<?php 
						foreach($TPL_VAR["partnerList"] as $partner) { ?>
							<option value="<?=$partner["rec_id"]?>"><?=$partner["rec_id"]?></option>
						<?php }
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th>날짜</th>
				<td><input type="text" name="time"  value="<?php echo date("Y-m-d H:i:s");?>" class="w120"/></td>
			</tr>
			<tr>
				<th>내용</th>
				<td><textarea name="content" rows="10" ></textarea></td>
			</tr>
		</table>

		<div id="wrap_btn">
			<input type="button" name="Submit" value="발  송" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="Form_ok();"/>
			<input type="reset" name="Submit2" value="초기화" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'"/></td>
		</div>
	</form>

</div>