<?php /* Template_ 2.2.3 2012/10/08 21:51:14 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.partner.list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	function go_del(url){
			if(confirm("정말 삭제하시겠습니까?"))
			{
					document.location = url;
			}
			else{
				return;
			}
	}
</script>

<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 파트너 관리 > <b>파트너 목록</b></h5>
	</div>

	<h3>파트너 목록</h3>
	<div id="search">
		<div>
			<form action="?" method="post" name="form2" id="form2">
			<span>아이디</span>
            <input name="search_id" type="text" id="key" class="name" value="<?php echo $TPL_VAR["rec_id"]?>" maxlength="20"/>
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_members" summary="파트너 목록">
	<legend class="blind">파트너 목록</legend>
	<thead>
		<tr>
			<th scope="col">아이디</th>
			<th scope="col">이름</th>
			<th scope="col">회원수</th>
			<th scope="col">입금회원</th>
			<th scope="col">입금금액</th>
			<th scope="col">출금금액</th>
			<th scope="col">배팅금액</th>
			<th scope="col">당첨금액</th>
			<th scope="col">정산방식</th>
			<th scope="col">정산비율</th>
			<th scope="col">상태</th>
			<th scope="col">가입날자</th>
			<th scope="col">처리</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><a href="javascript:open_window('partner_details.php?idx=<?php echo $TPL_V1["idx"]?>',610,330)"><?php echo $TPL_V1["rec_id"]?></a></td>
				<td><?php echo $TPL_V1["rec_name"]?></td>
				<td><?php echo $TPL_V1["countmem"]?></td>
				<td><?php echo $TPL_V1["chongmem"]?></td>
				<td><?php echo number_format($TPL_V1["recharge"],0)?></td>
				<td><?php echo number_format($TPL_V1["exchange"],0)?></td>
				<td><?php echo number_format($TPL_V1["betting"]-$TPL_V1["cancel_betting"],0)?></td>
				<td><?php echo number_format($TPL_V1["winning"])?></td>
				<td></td>
				<td><a href="javascript:void(0);" onclick="open_window('partner_rate.php?id=<?php echo $TPL_V1["rec_id"]?>&rate=<?php echo $TPL_V1["rec_rate"]?>',400,250)"><?php echo $TPL_V1["rec_rate"]?>%</a></td>
				<td><?php echo $TPL_V1["strstatus"]?></td>
				<td><?php echo $TPL_V1["reg_date"]?></td>
				<td>
<?php if($TPL_V1["status"]==1){?>
						<a href='?act=stop&id=<?php echo $TPL_V1["rec_id"]?>&send=0'><img src='/img/btn_s_stop.gif' title='정지'></a>						
<?php }else{?>
						<a href='?act=stop&id=<?php echo $TPL_V1["rec_id"]?>&send=1'><img src='/img/btn_s_normal.gif' title='정상'></a>
<?php }?>
						&nbsp;<a href="javascript:void(0)" onclick="go_del('?act=del&id=<?php echo $TPL_V1["rec_id"]?>');return false;"><img src="/img/btn_s_del.gif" title="삭제"></a>&nbsp;
						<a href="javascript:void(0);" onclick="open_window('partner_memo_add_acc.php?toid=<?php echo $TPL_V1["rec_id"]?>',650,450)"><img src="/img/btn_s_memo.gif" title="메모"></a>
				</td>
			</tr>
<?php }}?>
		
	</tbody>
	</table>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>


</div>