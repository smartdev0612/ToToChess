<?php /* Template_ 2.2.3 2012/12/20 18:48:36 D:\www\vhost.manager\_template\content\partner\join_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	function go_delete(url){
			if(confirm("정말 삭제하시겠습니까?  ")){
					document.location = url;
			}else{
				return;
			}
	}
	function go_add(url){
			if(confirm("파트너 신청을 허락하시겠습니까?  ")){
					document.location = url;
			}else{
				return;
			}
	}
</script>

<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 파트너 관리 > <b>파트너 신청</b></h5>
	</div>

	<h3>파트너 신청</h3>

	<div id="search">
		<div class="wrap">
			<form action="?" method="get" name="form2" id="form2">
			<span>아이디</span>
            <input name="username" type="text" id="key" class="name" value="<?php echo $TPL_VAR["nname"]?>" maxlength="20"/>
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_members" summary="파트너 신청">
	<legend class="blind">파트너 신청</legend>
	<thead>
		<tr>
			<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></td>
			<th scope="col">아이디</td>
			<th scope="col">이름</td>
			<th scope="col">핸드폰</td>
			<th scope="col">이메일</td>
			<th scope="col">은행명</td>
			<th scope="col">계좌번호</td>
			<th scope="col">예금주</td>
			<th scope="col">가입시간</td>
			<th scope="col">처리</td>
		</tr>
	</thead>
	</tbody>	
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
			<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["Idx"]?>"  onclick="javascript:chkRow(this);"/></td>
			<td><?php echo $TPL_V1["rec_id"]?></td>
			<td><?php echo $TPL_V1["rec_name"]?></td>
			<td><?php echo $TPL_V1["rec_phone"]?></td>
			<td><?php echo $TPL_V1["rec_email"]?></td>
			<td><?php echo $TPL_V1["rec_bankname"]?></td>
			<td><?php echo $TPL_V1["rec_banknum"]?><?=$rec_banknum?></td>
			<td><?php echo $TPL_V1["rec_bankusername"]?></td>
			<td><?php echo $TPL_V1["reg_date"]?></td>
			<td><a href="javascript:void(0);" onclick="go_delete('/partner/join?act=delone&idx=<?php echo $TPL_V1["Idx"]?>');return false;"><img src="/img/btn_s_del.gif" title="삭제"></a>&nbsp;<a href="javascript:void(0)" onclick="go_add('/partner/join?act=add&idx=<?php echo $TPL_V1["Idx"]?>');return false"><img src="/img/btn_s_confirm2.gif" title="승인"></a></td>
		</tr>
<?php }}?>
	</tbody>
	</table>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>

	<div id="wrap_btn">
		<input type="button" name="open" value="선택승인" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick=""/>
		<input type="button" name="open" value="삭  제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
	</div>
	</form>


</div>