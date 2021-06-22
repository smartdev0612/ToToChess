<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	function modify($sn)
	{
		$name = $('input[name=category_name]').val();
		document.frm.act.value="modify";
		document.frm.category_sn.value=$sn;
		document.frm.modify_name.value=$name;
		document.frm.submit();
	}
	
	function add()
	{
		$name = $('input[name=add_name]').val();
		
		if($name=='') {alert("추가할 종목을 넣어주세요");return;}
		
		document.frm.act.value="modify";
		document.frm.category_sn.value="";
		document.frm.modify_name.value=$name;
		document.frm.submit();
	}
	
	function del($sn)
	{
		document.frm.act.value="delete";
		document.frm.category_sn.value=$sn;
		document.frm.submit();
	}
</script>
	
	<div id="route">
		<h5>관리자 시스템 - 종목관리</h5>
	</div>
	<h3>종목관리</h3>

	<form id="frm" name="frm" method="post" action="?">
		<input type="hidden" name="act" value="">
		<input type="hidden" name="category_sn" value="">
		<input type="hidden" name="modify_name" value="">
		
		<table cellspacing="1" class="tableStyle_membersWrite thBig">
	    <tr>
				<th colspan='2'>
					추가&nbsp;&nbsp;&nbsp;&nbsp;
					<input name="add_name" type="text"  class="w120" value="" maxlength="30" />&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="#" onclick="add();"><img src="/img/btn_s_end.gif" title="추가"></a>
				</th>
	  	</tr>
	  </table>
		<table cellspacing="1" class="tableStyle_normal add">
			<legend class="blind">등록 리그 목록</legend>
			<thead>
			<tr>
			  <th>번호</th>
			  <th>종목명</th>
			  <th>처리</th>
			</tr>
			</thead>
			<tbody>
<?php if($TPL_list_1){$TPL_I1=-1;foreach($TPL_VAR["list"] as $TPL_V1){$TPL_I1++;?>
					<tr name="tr_<?php echo $TPL_V1["idx"]?>">
						<td><?php echo $TPL_I1+1?></td>
						<td><input type="text" name="category_name" value="<?php echo $TPL_V1["name"]?>" /></td>
						<td>
							<a href="#" onclick="modify(<?php echo $TPL_V1["idx"]?>);"><img src="/img/btn_s_modify.gif" title="수정"></a>
							<a href="#" onclick="del(<?php echo $TPL_V1["idx"]?>);"><img src="/img/btn_s_del.gif" title="삭제"></a>
						</td>
					 </tr>
<?php }}?>
			</tbody>
		</table>
	</form>