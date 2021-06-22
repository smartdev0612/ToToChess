<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="/js/is_show.js"></script>
<script Language='Javascript'>
function goDel(idx){
	var result = confirm('삭제하시겠습니까?');
	if(result){
		location.href="?act=del&idx="+idx;
	}	
}
</script>

<div class="wrap" id="popup">

	<div id="route">
		<h5>관리자 시스템 > 시스템 관리 > <b>팝업 설정</b></h5>
	</div>

	<h3>팝업 설정</h3>

	<ul id="tab">
		<li><a href="/config/popuplist" id="popup">팝업창 목록</a></li>
		<li><a href="/config/popupadd" id="popup_add">팝업창 추가</a></li>
	</ul>

	<form id="form1" name="form1" method="post" action="?act=del_ad">
		<table cellspacing="1" class="tableStyle_normal add" summary="팝업창 목록">
		<legend class="blind">팝업창 목록</legend>
		<thead>
			<tr>
				<th>사이트</th>
				<th>유형</th>
				<th>제목</th>
				<th>위치</th>
				<th>추가날짜</th>
				<th>유효기간</th>
				<th>처리</th>
			</tr>
		</thead>
		<tbody>	
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["logo"];?></td>
				<td>이미지</td>
				<td>				
					<span><?php echo mb_substr($TPL_V1["P_SUBJECT"],0,10,"utf-8")?></span>
<?php if($TPL_V1["P_FILE"]!=""){?>				 					
[I]<!--<img src="../images/photo.gif" width="16" height="16" border="0" align="absmiddle" border="0" align="absmiddle">-->
<?php }?>				
				</td>
				<td>x:<?php echo $TPL_V1["P_WIN_LEFT"]?>  y:<?php echo $TPL_V1["P_WIN_TOP"]?> w:<?php echo $TPL_V1["P_WIN_WIDTH"]?> h:<?php echo $TPL_V1["P_WIN_HEIGHT"]?></td>
				<td><?php echo mb_substr($TPL_V1["P_WRITEDAY"],0,10,"utf-8")?></td>
				<td><?php echo $TPL_V1["P_STARTDAY"]?>~<?php echo $TPL_V1["P_ENDDAY"]?></td>
				<td><a href="/config/popupadd?act=edit&idx=<?php echo $TPL_V1["IDX"]?>&logo=<?php echo $TPL_V1["logo"]?>"><img src="/img/btn_s_modify.gif" title="수정"></a><a href="javascript:goDel(<?php echo $TPL_V1["IDX"]?>)" ><img src="/img/btn_s_del.gif" title="삭제"></a></td>
			</tr>
<?php }}?>	
		</tbody>	
		</table>
	</form>
</div>