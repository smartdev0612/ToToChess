<?php /* Template_ 2.2.3 2014/08/14 18:21:22 D:\www_one-23.com\vhost.partner\_template\content\member\popup.bet.category.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta name="author" content="" />
<meta name="copyright" content="" />
<title> 배팅 내역</title>
<link href="css/common.css" rel="stylesheet" type="text/css" />
<link href="css/article.css" rel="stylesheet" type="text/css" />
</head>
<body style="background-color:#E0EAFE">
<script type="text/javascript" src="../js/toggle.js"></script>
<script language="javascript" src="../js/js.js"></script>
<script type="text/javascript">
		function on_click(betting_no)
		{
			if(document.getElementById("d_"+betting_no).style.display=="none")
			{
				document.getElementById("d_"+betting_no).style.display="";
			}
			else
			{
				document.getElementById("d_"+betting_no).style.display="none";
			}
		}
		
		function go_delete(url){
			if(confirm("정말 삭제하시겠습니까?  ")){
					open_window(url);
			}else{
				return;
			}
	}
</script>
<div class="admin_main_nr_dbox">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
    <tr>
	    <td>
		  	<table width="500" border="0" cellspacing="2" cellpadding="0">
		      <tr>
	          <form action="?" method="get" name="form3" id="form3">
						  <input type="hidden" name="member_sn" value="<?php echo $TPL_VAR["member_sn"]?>">
						  <td width="40">출력：</td>
						  <td width="20"><input name="perpage" type="text" id="perpage"  style="width:30px; height:17px; color:#666666; border:1px #97ADCE solid; text-align:center"  onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" value="<?php echo $TPL_VAR["perpage"]?>" maxlength="3"onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/\D/g,''))"/></td>
						  <td width="81"><input  style="font-family:Arial; font-size:10px; height:21px;border:solid 1px #b1b1b1;background:#ffffff" type="submit" name="Submitok"  value="OK" /></td>
						</form>
						<td width="100" align="center">
					 	</td>
					 	<td>
						<form action="?" method="get" >
							<input type="hidden" name="member_sn" value="<?php echo $TPL_VAR["member_sn"]?>">
							<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
								배팅번호<input type="input" name="betting_no" value=""><input type="submit" value="검색">
						</form>
					 	</td>
			  	</tr>
	      </table>
		  </td>
    </tr>
  </table>
  <form id="form1" name="form1" method="post" action="?act=delete_user">
	  <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
	    <tr style="padding-left:8px;">
			  <td width="10%" align="center" bgcolor="#D0E2F7" >배팅번호</td>
		    <td width="5%" align="center" bgcolor="#D0E2F7" >아이디</td>
		    <td width="5%" align="center"  bgcolor="#D0E2F7">닉네임</td>
		    <td width="5%" align="center" bgcolor="#D0E2F7"  >게임</td>
		    <td width="8%" align="center" bgcolor="#D0E2F7"  >당시금액</td>
			  <td width="5%" align="center" bgcolor="#D0E2F7"  >배팅금액</td>
			  <td width="5%" align="center" bgcolor="#D0E2F7"  >배당율</td>
			  <td width="5%" align="center" bgcolor="#D0E2F7"  >예상금액</td>
			  <td width="5%" align="center" bgcolor="#D0E2F7"  >배당금액</td>
			  <td width="5%" align="center" bgcolor="#D0E2F7"  >파트너</td>
			  <td width="12%" align="center" bgcolor="#D0E2F7"  >배팅시간</td>
			  <td width="15%" align="center" bgcolor="#D0E2F7"  >처리시간</td>
			  <td width="5%" align="center" bgcolor="#D0E2F7"  >보너스</td>
			  
	    </tr>
	  </table>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
	  		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="link_lan">
					<tr  style="padding-left:8px;" id="t_<?php echo $TPL_V1["betting_no"]?>" onclick="on_click('<?php echo $TPL_V1["betting_no"]?>')" bgcolor="#f6f6f6" onMouseOver="this.style.backgroundColor='#e0eafe';" onMouseOut="this.style.backgroundColor=''">
						<td width="10%" align="center" height="34" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["betting_no"]?></td>	
						<td width="5%" align="center" height="34" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["member"]["uid"]?></td>					
						<td width="5%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["member"]["nick"]?></td>
						<td width="5%" align="center" style="border-bottom:1px #CCCCCC solid; color: #666666"><?php echo $TPL_V1["betting_cnt"]?></td>
						<td width="8%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo number_format($TPL_V1["before_money"],0)?></td>
						<td width="5%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["betting_money"]?></td>
						<td width="5%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["result_rate"]?></td>
						<td width="5%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo number_format(round($TPL_V1["betting_money"]*$TPL_V1["result_rate"]),0)?></td>
						<td width="5%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo number_format($TPL_V1["result_money"],0)?></td>
						<td width="5%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["rec_name"]?></td>
						<td width="12%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["regdate"]?></td>
						<td width="15%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["operdate"]?></td>
						<td width="5%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V1["bonus"]?></td>
						
					</tr>
				</table>				
				
				<table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" style="display:none;margin-left:50px;" id="d_<?php echo $TPL_V1["betting_no"]?>">
					<tr style="padding-left:8px;">				  
						<td width="70" align="center" bgcolor="#D0E2F7" >게임타입</td>
						<td width="105" align="center"  bgcolor="#D0E2F7">경기시간</td>
						<td width="100" align="center" bgcolor="#D0E2F7"  >리그</td>
						<td width="100" align="center" bgcolor="#D0E2F7" colspan="2" >홈팀</td>
						<td width="60" align="center" bgcolor="#D0E2F7"  >무</td>
						<td width="100" align="center" bgcolor="#D0E2F7"  colspan="2">원정팀</td>
						<td width="60" align="center" bgcolor="#D0E2F7"  >점수</td>
						<td width="60" align="center" bgcolor="#D0E2F7"  >배팅</td>
						<td width="50" align="center" bgcolor="#D0E2F7"  >결과</td>
						<td width="65" align="center" bgcolor="#D0E2F7"  >상태</td>
					</tr>
<?php if($TPL_item_2){foreach($TPL_V1["item"] as $TPL_V2){?>										
						<tr  style="padding-left:8px;" bgcolor="#ede8e8">				
							<td width="60" align="center"  style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php if($TPL_V2["game_type"]==1){?>[승무패]
<?php }elseif($TPL_V2["game_type"]==2){?>[핸디캡]
<?php }elseif($TPL_V2["game_type"]==3){?>[홀짝]
<?php }elseif($TPL_V2["game_type"]==4){?>[언더오버]
<?php }?>
							</td>
							<td width="105" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["g_date"]?></td>
							<td width="100" align="center" style="border-bottom:1px #CCCCCC solid; color: #666666"><?php echo $TPL_V2["league_name"]?></td>
							<td width="80" align="" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["home_team"]?></td>
							<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["home_rate"]?></td>
							<td width="60" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["draw_rate"]?></td>
							<td width="80" align="" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["away_team"]?></td>
							<td width="20" align="" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["away_rate"]?></td>
							<td width="40" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666"><?php echo $TPL_V2["home_score"]?>:<?php echo $TPL_V2["away_score"]?></td>
							<td width="60" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php if($TPL_V2["select_no"]==1){?>홈팀
<?php }elseif($TPL_V2["select_no"]==2){?>원정팀
<?php }elseif($TPL_V2["select_no"]==3){?>무
<?php }?>
							</td>
							<td width="50" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php if($TPL_V2["win"]==1){?>[홈승]
<?php }elseif($TPL_V2["win"]==3){?>[무승부]
<?php }elseif($TPL_V2["win"]==2){?>[원정승]
<?php }elseif($TPL_V2["win"]==4){?>[취소]
<?php }?>
							</td>
							<td width="65" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
<?php if($TPL_V2["result"]==0){?><font color=#666666>진행중</font>
<?php }elseif($TPL_V2["result"]==1){?><font color=red>적중</font>
<?php }elseif($TPL_V2["result"]==2){?><font color=blue>낙첨</font>
<?php }elseif($TPL_V2["result"]==4){?><font color=green>취소</font>
<?php }?>
							</td>
						</tr>							
<?php }}?>
<?php }}?>			
		</table>			
	  
	  <div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	
	</form>
</div>

</body>
</html>