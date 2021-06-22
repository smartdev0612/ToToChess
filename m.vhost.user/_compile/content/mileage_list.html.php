<?php /* Template_ 2.2.3 2014/04/26 17:22:26 D:\www\m.vhost.user\_template\content\mileage_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<style type="text/css">
	<!-- 
	#tmenu .point a
	{background-position:0px -29px}
	-->
</style>
		
		<script language="javascript" src="/scripts/Calendar.js"></script>
		
		<div id="wrap_body">
		<h2 class="blind">내용</h2>
		
		<div id="wrap_search">						
				<div id="nowmoney"><p><img src="/img/mileage_title.gif" title="보유마일리지"><span><?php echo number_format($TPL_VAR["mileage"])?>포인트</span></p></div>
				
				<form name='frm_filter' action='?' method='post'>
				<div id="search">
					<p><label>조회기간</label>
						<input type="text" class="date" maxlength="20" name="begin_date" maxlength="20" readonly onclick="new Calendar().show(this);" value=<?php echo $TPL_VAR["begin_date"]?>>&nbsp;~&nbsp;
						<input type="text" name="end_date" class="date" readonly maxlength="20" onclick="new Calendar().show(this);" value=<?php echo $TPL_VAR["end_date"]?> >
						<a href="#" onClick="submit();" ><img src="/img/btn_search.gif" title="조회" class="btnmargin"></a>
						<a href="#" onClick="resetForm();"><img src="/img/btn_clear.gif" title="초기화" class="btnmargin"></a>
					</p>
				</div>
				</form>
			</div>

		<ul id="subtab2">
			<li class="on"><a href="/member/mileagelist">합계</a></li>
			<li><a href="/member/mileagelist?type=2">추천인</a></li>
			<li><a href="/member/mileagelist?type=4">낙첨보험</a></li>
		</ul>
			<!-- 1=충전, 2=파트너, 3=다폴더,4=낙첨,5=이벤트,6=포인트전환,7=관리자수정, 8=롤백, 9=롤백처리, 10=게시글작성, 11=게시글취소, 12=추천인 낙첨마일리지 -->
			<table class="tablestyle_normal" cellspacing="1">
				<thead>
					<tr>
						<th>구분</th>
						<th>변경일자</th>
						<th>변경사유</th>
						<th>변경액</th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<?php if($TPL_list_1<=0){?>
						<tr><td colspan="4">내역이 없습니다.</td></tr>
<?php }else{?>
					<tr>
<?php }?>
						<td class="class">
<?php if($TPL_V1["state"]==2){?> 추천인
<?php }elseif($TPL_V1["state"]==4){?> 낙첨
<?php }?>
						</td>
						<td><?php echo $TPL_V1["regdate"]?></td>
						<td><?php echo $TPL_V1["status_message"]?></td>
						<td class="mileage">
<?php if($TPL_V1["amount"]<=0){?> <span class="usemileage"><?php echo number_format($TPL_V1["amount"])?></span>
<?php }else{?><?php echo number_format($TPL_V1["amount"])?>

<?php }?>
						</td>
					</tr>
<?php }}?>
				</tbody>
			</table>
			<div id="wrap_page">
				<?php echo $TPL_VAR["pagelist"]?>

			</div>
		
	</div>