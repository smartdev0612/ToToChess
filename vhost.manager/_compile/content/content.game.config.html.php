<?php /* Template_ 2.2.3 2012/10/08 12:10:43 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.game.config.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	function openGameBetForm(intParentIdx)
	{
		window.open("totoGameResultForm2.asp?intParentIdx="+intParentIdx,"bet","width=350,height=150,left=550,top=100,scrollbars=yes");
	}

	function go_delete(url)
	{
			if(confirm("정말 삭제하시겠습니까?")) {document.location = url;}
			else	{return;}
	}

	function coin_add(url)
	{
		window.open(url,'','scrollbars=yes,width=500,height=360,left=5,top=0');
	}

	function coin_add1(url)
	{
		window.open(url,'','scrollbars=yes,resizable=yes,width=1000,height=700,left=5,top=0');
	}

</script>

<div class="wrap">
	<div id="route">
		<h5>관리자 시스템 > 게임 관리 > <b>게임설정</b></h5>
	</div>

	<h3>게임설정</h3>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
		<table cellspacing="1" class="tableStyle_normal" summary="게임 목록">
			<legend class="blind">게임 목록</legend>
			<thead>
				<tr>
					<th scope="col">회차번호</th>
					<th scope="col">마감날짜</th>
					<th scope="col">최소 배팅값</th>
					<th scope="col">최대 배당금액</th>
					<th scope="col">베팅현황보기</th>
					<th scope="col">게임종료</th>
					<th scope="col">항목보기</th>
					<th scope="col">경기수</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_VAR["total"]<=0){?>
				<tr bgcolor='#FFFFFF' height=30> <td colspan=9 align=center>데이타가 없습니다.</td></tr>
<?php }else{?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr>
					<td><?php echo $TPL_V1["intParentIdx"]?></td>
					<td><?php echo $TPL_V1["strGameEndTime"]?></td>
					<td><?php echo number_format($TPL_V1["intMinBetPrice"],0)?><br><font color="blue">(배)<?php echo number_format($TPL_V1["total_betting"],0)?></font></td>
					<td><?php echo number_format($TPL_V1["intMaxBetPrice"],0)?><br><font color="green">(당)<?php echo number_format($TPL_V1["total_result"],0)?></font></td>
					<td>
						<a href="totoRaceBetList.php?intParentIdx=<?php echo $TPL_V1["intParentIdx"]?>">[베팅현황보기]</a><br>
<?php if($TPL_V1["now_money"]>10000){?>
							<font color="blue"> <?php echo number_format($TPL_V1["now_money"],0)?> </font>
<?php }else{?>
							<font color=red> <?php echo number_format($TPL_V1["now_money"],0)?> </font>
<?php }?>
					</td>
					<td>
<?php if($TPL_V1["blnGameMsg"]=="Y"){?>
							종료
<?php }else{?>
							<font color='red'>진행중</font>
<?php }?>
					</td>
					<td><a href="contentTotalRace.php?intParentIdx=<?php echo $TPL_V1["intParentIdx"]?>">[항목보기]</a></td>
					<td><?php echo $TPL_V1["child_cnt"]?></td>					
				</tr>
<?php }}?>
<?php }?>
		</tbody>
		</table>
	</form>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>