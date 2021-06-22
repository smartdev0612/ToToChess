<?php /* Template_ 2.2.3 2013/01/08 04:03:46 D:\www\vhost.user\_template\content\pincode_popup.html */?>
<?
include "include/head.html";
?>

<script language="JavaScript" type="text/JavaScript">

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

</script>


<script> 

function check_pincode()
{
	var pincode = $('#pincode').val();
	if(pincode.length<1)
	{
		$('#pincode_message').html('Pin-code를 입력하세요');
	}
	else
	{
		$.ajaxSetup({async:false});
		var param={pin:pincode};
		
		$.post("/member/pincodePopup", param, on_check_pincode);
	}
}

function on_check_pincode(result)
{
 	if(trim(result)=="false")
  {
  	$("#pincode").focus();
    $("#pincode_message").html("존재하지 않거나, 제한된 Pin-Code 입니다.");
	}
  else
  {
  	$("#pincode_message").html("<font color=#ffffff>확인되었습니다.</font>");
  	parent.location.href("/member/add");
  	self.close();
	}
}

</script>
<body>

<div id="mainbody">
	<div id="mainswf">
		<script>swf('img/main_logo.swf','350','200')</script>
	</div>
	
	<div id="record" style="border:1 solid #fff; display:none;">
		<table width="100%" border="0" cellpadding="3" cellspacing="3" bgcolor="#27384B">
		<tr>
			<td colspan="2" class="btr01 B">* 추천코드를 입력 해 주세요 *</td>
			<td class="btr01" align="center"><span onClick="document.all.record.style.display='none';" class="curHand">x</span></td>
		</tr>
		<tr>
			<td>추천코드 :</td>
			<td><input type="text" id="name" name="name" style="width:150px;" /></td>
			<td align="center">ok</td>
		</tr>
		</table>
	</div>
</div>

<?
include "include/bottom.html";
?>