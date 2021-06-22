<?php /* Template_ 2.2.3 2012/11/30 16:47:20 D:\www\vhost.manager\_template\content\partner\notice_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="/js/selectAll.js"></script>
<script>
	function go_delete(url){
			if(confirm("정말 삭제하시겠습니까?  ")){
					document.location = url;
			}else{
				return;
			}
	}
</script>

<div class="wrap" id="partner_notice">

	<div id="route">
		<h5>관리자 시스템 > 파트너 관리 > <b>파트너 공지</b></h5>
	</div>

	<h3>파트너 공지</h3>

	<ul id="tab">
		<li><a href="/partner/noticelist" id="partner_notice">파트너 공지</a></li>
		<li><a href="/partner/noticeadd" id="partner_notice_add">공지 쓰기</a></li>
	</ul>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_normal add" summary="파트너 공지 목록">
		<legend class="blind">파트너 공지</legend>
		<thead>
			<tr>
				<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
				<th scope="col">제목</th>
				<th scope="col">등록일</th>
				<th scope="col">처리</th>
			</tr>
		</thead>
		<tbody>	
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr>
					<td><input name="y_id[]" type="checkbox" id="y_id" value="1"  onclick="javascript:chkRow(this);"/></td>
					<td><a href="/partner/noticeview?idx=<?php echo $TPL_V1["num"]?>" ><?php echo $TPL_V1["title"]?></a></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
					<td><a href="/partner/noticeview?idx=<?php echo $TPL_V1["num"]?>"><img src="/img/btn_s_modify.gif" title="수정"></a>&nbsp;<a href="javascript:void(0);" onclick="go_delete('/partner/noticelist?act=del&num=<?php echo $TPL_V1["num"]?>');"><img src="/img/btn_s_del.gif" title="삭제"></a></td>
				</tr>
<?php }}?>
		</tbody>
	</table>
	<div id="pages2">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>

	
	<div id="wrap_btn">
		<input type="button" name="open" value="삭  제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="openLayer('op1','tis')"/>
	</div>	
	
	</form>

</div>