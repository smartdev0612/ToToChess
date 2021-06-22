<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript">
		function on_click(t_id,x_id)
		{
			//alert(t_id);
			
			var d_id = new _toggle($.id(t_id));
			$.id(x_id).onclick=function()
			{
				d_id.toggle();
			}
			
		}
		
		
		function go_delete(url)
		{
			if(confirm("정말 삭제하시겠습니까?  "))
			{
				document.location = url;
			}
			else
			{
				return;
			}
		}
	
		function toggle(id)
		{
			$( "#"+id ).slideToggle(100);
		}	
	
	</script>
</head>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>배팅 내역</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<div id="search">
		<div>
			<form action="?" method="get" >
			<input type="hidden" name="mem_sn" value="<?php echo $TPL_VAR["mem_sn"]?>">
			<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
			<span class="icon">배팅 번호</span><input type="input" name="betting_no" value="<?php echo $TPL_VAR["betting_no"]?>"> 
			<input type="submit" value="검색" class="btnStyle3" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
		<input type="hidden" name="mem_sn" value="<?php echo $TPL_VAR["mem_sn"]?>">
		<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
			
		<table cellspacing="1" class="tableStyle_normal" summary="배팅 내역">			
			<thead>
				<tr>
					<!--<th width="2%"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>-->
					<th width="15%">팀</th>
				  	<th width="10%">배팅번호</th>
					 <th width="5%">아이디</th>
					 <th width="5%">닉네임</th>
					 <th width="5%">종류</th>
					 <th width="5%">베팅위치</th>
					 <th width="5%">배팅금액</th>
					 <th width="5%">배당율</th>
					 <th width="5%">예상금액</th>
					 <th width="5%">당첨금액</th>
					 <th width="12%">배팅시간</th>
					 <th width="5%">결과</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
					<tr id="t_<?php echo $TPL_V1["betting_no"]?>" >
						<!--<td width="2%"><input name="y_id[]" type="checkbox" id="y_id" value="1"  onclick="javascript:chkRow(this);"/></td>-->
						<td width="15%"><?php echo $TPL_V1["home_team"]?> <font color='blue'><b> VS </b></font> <?php echo $TPL_V1["away_team"]?></td>	
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="10%"><?php echo $TPL_V1["betting_no"]?></td>	
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"  width="5%"><?php echo $TPL_V1["uid"]?></td>					
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo $TPL_V1["nick"]?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo $TPL_V1["alias"]?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo $TPL_V1["betting_position"]?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo number_format($TPL_V1["betting_money"],0)?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo number_format($TPL_V1["odd"],2)?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo number_format(($TPL_V1["betting_money"]*$TPL_V1["odd"]),0)?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo number_format($TPL_V1["prize"],0)?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="12%"><?php echo $TPL_V1["reg_time"]?></td>
						<td width="5%"><?php if($TPL_V1["betting_result"]=="WIN"){?>당첨<?php }elseif($TPL_V1["betting_result"]=="LOS"){?>낙첨<?php }elseif($TPL_V1["betting_result"]=="CANCEL"){?>적특<?php }else{?>진행중<?php }?></td>
					</tr>
<?php }}?>
				</tbody>
		</table>
		
	
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
	
	</form>
	
</div>
</body>
</html>