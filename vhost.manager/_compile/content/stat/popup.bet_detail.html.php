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
		<h1>배팅 상세내역 (<?php echo $TPL_VAR["date"]?>)</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<div id="search">
		<div>
			<form action="?" method="get" >
			<input type="hidden" name="date" value="<?php echo $TPL_VAR["date"]?>">
			<span class="icon">유저아이디 </span><input type="input" name="member_id" value="<?php echo $TPL_VAR["member_id"]?>">
			<input type="submit" value="검색" class="btnStyle3" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
		<input type="hidden" name="mem_sn" value="<?php echo $TPL_VAR["mem_sn"]?>">
		<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
			
		<table cellspacing="1" class="tableStyle_normal" summary="배팅 내역">			
			<legend class="blind">배팅 내역</legend>
			<thead>
				<tr>
					<th width="5%">번호</th>
					 <th width="10%">아이디</th>
					 <th width="7%">베팅횟수</th>
					 <th width="7%">적중</th>
					 <th width="10%">적중율</th>
                     <th width="10%">적중비율</th>
					 <th width="15%">베팅금액</th>
					 <th width="15%">당첨금액</th>
					 <th width="15%">베팅수익</th>
					 <th width="7%">당첨비율</th>
				</tr>
			</thead>
            <tbody>
<?php if($TPL_list_1){
      $idx = 0;
      foreach($TPL_VAR["list"] as $key=>$TPL_V1){ $idx++; ?>

					<tr>
						<td width="5%"><?php echo $idx ?></td>
						<td width="10%"><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["sn"]?>',1024,600)"><?php echo $key?></a></td>
						<td width="7%"><?php echo $TPL_V1["count"]?></td>
						<td width="7%"><?php echo $TPL_V1["success"]?></td>
						<td width="10%">
                            <?php
                            if($TPL_V1["count"] == 0) {
                                echo "0.0%";
                            } else {
                                echo number_format($TPL_V1["success"] * 100 / $TPL_V1["count"],1)."%";
                            }
                            ?>

                        </td>
						<td width="10%">
                            <?php if($TPL_VAR["total_win_count"] == 0) {
                                      echo "0.0%";
                                  } else {
                                      echo number_format($TPL_V1["success"] * 100 / $TPL_VAR["total_win_count"], 1) . "%";
                                  }
                            ?>
                        </td>
						<td width="15%"><?php echo number_format($TPL_V1["bet_amount"],0)?></td>
						<td width="15%"><?php echo number_format($TPL_V1["get_amount"],0)?></td>
						<td width="15%"><?php echo number_format($TPL_V1["bet_amount"] - $TPL_V1["get_amount"],0)?></td>
						<td width="7%">
                            <?php
                            if($TPL_VAR["total_win_amt"] == 0) {
                                echo "0.0%";
                            } else {
                                echo number_format($TPL_V1["get_amount"] * 100 / $TPL_VAR["total_win_amt"], 1) . "%";
                            }
                            ?>
                        </td>
                    </tr>
<?php }}?>
		</tbody>
        <tfoot>
            <tr>
                <td colspan="2"><font color='#CC3D3D'>합계</font></td>
                <td><font color='#CC3D3D'><?php echo number_format($TPL_VAR["total_bet_count"],0)?></font></td>
                <td><font color='#CC3D3D'><?php echo number_format($TPL_VAR["total_win_count"],0)?></font></td>
                <td>
                    <font color='#CC3D3D'>
                        <?php
                        if($TPL_VAR["total_bet_count"] == 0)
                        {
                            echo "0.0%";
                        } else {
                            echo number_format($TPL_VAR["total_win_count"] * 100 / $TPL_VAR["total_bet_count"],1)."%";
                        }
                        ?>
                    </font>
                </td>
                <td><font color='#CC3D3D'>
                        <?php if($TPL_VAR["total_win_count"] == 0) echo "0.0%"; else echo "100.0%"?>
                    </font></td>
                <td><font color='#CC3D3D'><?php echo number_format($TPL_VAR["total_bet_amt"],0)?></font></td>
                <td><font color='#CC3D3D'><?php echo number_format($TPL_VAR["total_win_amt"],0)?></font></td>
                <td><font color='#CC3D3D'><?php echo number_format($TPL_VAR["total_bet_amt"]- $TPL_VAR["total_win_amt"],0)?></font></td>
                <td><font color='#CC3D3D'><?php if($TPL_VAR["total_win_count"] == 0) echo "0.0%"; else echo "100.0%"?></font></td>
            </tr>
        </tfoot>
	</table>
	
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
	
	</form>
	
</div>
</body>
</html>