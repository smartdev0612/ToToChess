<?php /* Template_ 2.2.3 2014/12/05 20:25:37 D:\www_one-23.com\vhost.partner\_template\login.html */?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta name="author" content="">
<meta name="copyright" content=""/>
<meta http-equiv="imagetoolbar" content="no">

<link rel="stylesheet" href="/css/default.css" type="text/css">
<script type="text/javascript" src="/js/common.js"></script>
<title>총판 로그인 페이지</title>

<script language="javascript">
   
function alertWin(title, msg, w, h){ 
    var titleheight = "22px"; // 提示窗口标题高度 
    var bordercolor = "#666699"; // 提示窗口的边框颜色 
    var titlecolor = "#FFFFFF"; // 提示窗口的标题颜色 
    var titlebgcolor = "#0064a6"; // 提示窗口的标题背景色
    var bgcolor = "#FFFFFF"; // 提示内容的背景色
    
    var iWidth = document.documentElement.clientWidth; 
    var iHeight = document.documentElement.clientHeight; 
    var bgObj = document.createElement("div"); 
    bgObj.id="bgObjId";
    bgObj.style.cssText = "position:absolute;left:0px;top:0px;width:"+iWidth+"px;height:"+Math.max(document.body.clientHeight, iHeight)+"px;filter:Alpha(Opacity=30);opacity:0.3;background-color:#000000;z-index:101;";
    document.body.appendChild(bgObj); 
    
    var msgObj=document.createElement("div");
    msgObj.id="msgObjId";
    msgObj.style.cssText = "position:absolute;font:11px '굴림';top:"+(iHeight-h)/2+"px;left:"+(iWidth-w)/2+"px;width:"+w+"px;height:"+h+"px;text-align:center;border:1px solid "+bordercolor+";background-color:"+bgcolor+";padding:1px;line-height:22px;z-index:102;";
    document.body.appendChild(msgObj);
    
    var table = document.createElement("table");
    msgObj.appendChild(table);
    table.style.cssText = "margin:0px;border:0px;padding:0px;";
    table.cellSpacing = 0;
    var tr = table.insertRow(-1);
    var titleBar = tr.insertCell(-1);
    titleBar.style.cssText = "width:90%;height:"+titleheight+"px;text-align:left;padding:3px;margin:0px;font:bold 13px '굴림';color:"+titlecolor+";border:0px solid " + bordercolor + ";cursor:move;background-color:" + titlebgcolor;
    titleBar.style.paddingLeft = "10px";
    titleBar.innerHTML = title;
    var moveX = 0;
    var moveY = 0;
    var moveTop = 0;
    var moveLeft = 0;
    var moveable = false;
    var docMouseMoveEvent = document.onmousemove;
    var docMouseUpEvent = document.onmouseup;
    titleBar.onmousedown = function() {
        var evt = getEvent();
        moveable = true; 
        moveX = evt.clientX;
        moveY = evt.clientY;
        moveTop = parseInt(msgObj.style.top);
        moveLeft = parseInt(msgObj.style.left);
        
        document.onmousemove = function() {
            if (moveable) {
                var evt = getEvent();
                var x = moveLeft + evt.clientX - moveX;
                var y = moveTop + evt.clientY - moveY;
                if ( x > 0 &&( x + w < iWidth) && y > 0 && (y + h < iHeight) ) {
                    msgObj.style.left = x + "px";
                    msgObj.style.top = y + "px";
                }
            }    
        };
        document.onmouseup = function () { 
            if (moveable) { 
                document.onmousemove = docMouseMoveEvent;
                document.onmouseup = docMouseUpEvent;
                moveable = false; 
                moveX = 0;
                moveY = 0;
                moveTop = 0;
                moveLeft = 0;
            } 
        };
    }
    
    var closeBtn = tr.insertCell(-1);
    closeBtn.style.cssText = "cursor:pointer; padding:2px;background-color:" + titlebgcolor;
    closeBtn.innerHTML = "<span style='font-size:9pt; color:"+titlecolor+";'>닫기</span>";
    closeBtn.onclick = function(){ 
        document.body.removeChild(bgObj); 
        document.body.removeChild(msgObj); 
    } 
    var msgBox = table.insertRow(-1).insertCell(-1);
    msgBox.style.cssText = "font:10pt '굴림';";
    msgBox.colSpan = 2;
    
    var msgs = "<table width='100%' border='0' align='center' cellpadding='5' cellspacing='1' bgcolor='#cccccc' style='font-size:12px;color:#5c5d5e;'>"
  +"<FORM METHOD='POST' name='reg_form' id='reg_form' action='partner_join_ok.php'>"
   +" <tr height='30'>"
     +"<td width='150'  bgcolor='#FFFFFF' align='right'>파트너ID</td>"
      +"<td width='311' bgcolor='#FFFFFF' align='left'>&nbsp;&nbsp;<input name='userid' type='text' class='input' id='userid'  maxlength='16' title='아이디 입력'>"
     
        +"</td>"
    +"</tr>"
   +" <tr height='30'>"
      +"<td align='right' bgcolor='#FFFFFF' style='padding-right:5px'>비밀번호</td>"
     +" <td bgcolor='#FFFFFF' align='left'>&nbsp;&nbsp;<input name='regpass' type='password' class='input' id='regpass' > </td>"
    +"</tr>"
    +"<tr height='30'>"
      +"<td align='right' bgcolor='#FFFFFF' style='padding-right:5px'>비밀번호확인</td>"
     +" <td bgcolor='#FFFFFF' align='left'>&nbsp;&nbsp;<input name='regpass2' type='password' class='input' id='regpass2' >      </td>"
    +"</tr>"
    +"<tr height='30'>"
      +"<td align='right' bgcolor='#FFFFFF' style='padding-right:5px'>E-mail</td>"
     +" <td bgcolor='#FFFFFF' align='left'>&nbsp;&nbsp;<input name='email' type='text' class='input' id='email'  >"
       +" <div id='ShowB' style='color:#FF0000;'></div>      </td>"
   +" </tr>"
   +"<tr height='30'>"
      +"<td align='right' bgcolor='#FFFFFF' style='padding-right:5px'>이름</td>"
     +" <td bgcolor='#FFFFFF' align='left'>&nbsp;&nbsp;<input name='name' type='text' class='input' id='name'  >"
       +" <div id='ShowB' style='color:#FF0000;'></div>      </td>"
   +" </tr>"
  +"  <tr height='30'>"
      +"<td align='right' bgcolor='#FFFFFF' style='padding-right:5px'>핸드폰</td>"
      +"<td bgcolor='#FFFFFF' align='left'>"
	  +"&nbsp;&nbsp;<input name='phone' type='text' class='input' id='phone'   maxlength='11'></td>"
    +"</tr>"
   +"<tr height='30'>"
     +"<td align='right' bgcolor='#FFFFFF' style='padding-right:5px'>은행명</td>"
    +"  <td bgcolor='#FFFFFF' align='left'>"
	  	+"&nbsp;&nbsp;<select name='bankname' id='bankname'>"
									  +"<option value='국민은행' selected>국민은행</option>"
									  +"<option value='기업은행'>기업은행</option>"
									  +"<option value='농협'>농협</option>"
										+"<option value='신한은행'>신한은행</option>"
									 +" <option value='외환은행'>외환은행</option>"
									 +"<option value='우체국'>우체국</option>"
									 +" <option value='SC제일은행'>SC제일은행</option>"
										+"<option value='하나은행'>하나은행</option>"
									+" <option value='한국씨티은행'>한국씨티은행</option>"
									 +" <option value='우리은행'>우리은행</option>"
									 +" <option value='경남은행'>경남은행</option>"
										+"<option value='광주은행'>광주은행</option>"
									 +" <option value='대구은행'>대구은행</option>"
									  +"<option value='도이치은행'>도이치은행</option>"
									  +"<option value='부산은행'>부산은행</option>"
										+"<option value='신협'>신협</option>"
									+"  <option value='수협'>수협</option>"
									  +"<option value='전북은행'>전북은행</option>"
									 +" <option value='제주은행'>제주은행</option>"
									 +" <option value='새마을금고'>새마을금고</option>"
									+"<option value='HSBC은행'>HSBC은행</option>"
									  +"<option value='상호저축은행'>상호저축은행</option>"
									+"</select> </td>"
 +"   </tr>"
    +"<tr height='30'>"
      +"<td align='right' bgcolor='#FFFFFF' style='padding-right:5px'>계좌번호</td>"
      +"<td bgcolor='#FFFFFF' align='left'>"
	 +"&nbsp;&nbsp;<input name='banknum' type='text' class='input'  size='10' id='banknum'>  </td>"
    +"</tr>"
    +"<tr height='30'>"
      +"<td align='right' bgcolor='#FFFFFF' style='padding-right:5px' >예금주</td>"
      +"<td bgcolor='#FFFFFF' align='left'>&nbsp;&nbsp;<input name='bankusername' type='text' class='input'  size='10' id='bankusername'>     </td>"
    +"</tr>"
 +" </form>"
+"</table>"

                +"<input type='button' value='가입하기' class='btnStyle3' onclick='getValue(\""+bgObj.id+"\",\""+msgObj.id+"\")' />";
				//alert(msgs);
    msgBox.innerHTML = msgs;
    
    // 获得事件Event对象，用于兼容IE和FireFox
    function getEvent() {
        return window.event || arguments.callee.caller.arguments[0];
    }
} 
 function isNum(e)
{
	if(e * 1 != e)
	{ 
		alert('숫자만 입력 가능합니다!');
		e ='';
		
		return false;
	} else{
	return true;
	}
}


//执行后台 click()
function getValue(bgObjId,msgObjId) 
{
	if(document.getElementById("userid").value==""){
		alert('파트너 아이디를 입력하여주십시오!');
		document.getElementById("userid").focus();
		return;
	}
	
	if(document.getElementById("userid").value.length<4 || document.getElementById("userid").value.length>10){
		alert('파트너 아이디는 4-10 자리입니다.');
		document.getElementById("userid").focus();
		return;
	}
	var reg=/[@#\$%\^&\*]+/g ;
	if(reg.test(document.getElementById("userid").value)){
		alert('파트너 아이디 - 특수문자를 사용할수 없습니다.');
		document.getElementById("userid").focus();
		return;
	}
	if(document.getElementById("regpass").value==""){
		alert('비밀번호를 입력하여주십시오!');
		document.getElementById("pass").focus();
		return;
	}
	
	if(document.getElementById("regpass").value.length<6 || document.getElementById("regpass").value.length>15 ){
		alert('비밀번호는 5-15 자리 입니다.!');
		document.getElementById("regpass").focus();
		return;
	}
	if(document.getElementById("regpass").value=="12345" || document.getElementById("regpass").value=="123456" ||document.getElementById("regpass").value=="123456789"){
		alert('비밀번호를 문자 조합으로 입력하여주십시오');
		document.getElementById("pass").focus();
		return;
	}
	if(document.getElementById("regpass2").value==""){
		alert('비밀번호 재확인을 입력하여주십시오!');
		document.getElementById("pass2").focus();
		return;
	}
	if(document.getElementById("regpass").value!=document.getElementById("regpass2").value){
		alert('두번의 비밀번호가 정확하지 않습니다.확인하여 주십시오.');
		document.getElementById("regpass2").focus();
		return;
	}
    if(document.getElementById("email").value.length!=0)
	{    
			reg=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;    
			if(!reg.test(document.getElementById("email").value))
			{    
				alert('이메일 격식이 틀립니다.');
				document.getElementById("email").focus();
				return;
			}
			
	}else
	{
				alert('이메일을 입력하십시오!');
				document.getElementById("email").focus();
				return;
	}
	if(document.getElementById("name").value==""){
		alert('이름을 입력하여 주십시오.');
		document.getElementById("name").focus();
		return;
	}
	if(document.getElementById("phone").value==""){
		alert('핸드폰 번호를 입력하여주십시오.');
		document.getElementById("phone").focus();
		return;
	}
	if(document.getElementById("phone").value.length!=11){
		alert('핸드폰 번호를 정확히 입력하여주십시오.');
		document.getElementById("phone").focus();
		return;
	}
	if(isNum(document.getElementById("phone").value)==false){
		alert('핸드폰 번호를 정확히 입력하여주십시오.');
		document.getElementById("phone").focus();
		return;
	}
	if(document.getElementById("banknum").value==""){
		alert('계좌번호를 입력하여주십시오.');
		document.getElementById("banknum").focus();
		return;
	}

	if(!isNum(document.getElementById("banknum").value)){
		alert('계좌번호를 정확히 입력하여주십시오.');
		document.getElementById("banknum").focus();
		return;
	}
	if(document.getElementById("bankusername").value==""){
		alert('예금주를  입력하여주십시오.');
		document.getElementById("bankusername").focus();
		return;
	}
    document.getElementById("regname").value =  document.getElementById("userid").value;
	document.getElementById("password").value =  document.getElementById("regpass").value;
	document.getElementById("password2").value =  document.getElementById("regpass2").value;
	document.getElementById("e_mail").value =  document.getElementById("email").value;
	document.getElementById("n_name").value =  document.getElementById("name").value;
	document.getElementById("handphone").value =  document.getElementById("phone").value;
	document.getElementById("bank_name").value =  document.getElementById("bankname").value;
	document.getElementById("bank_num").value =  document.getElementById("banknum").value;
	document.getElementById("bank_username").value =  document.getElementById("bankusername").value;
    var bgObj = document.getElementById(bgObjId);
    var msgObj = document.getElementById(msgObjId);
    
    document.body.removeChild(bgObj); 
    document.body.removeChild(msgObj); 
	document.getElementById("regform").submit();

    //document.form1.submit();
    //执行隐藏服务器按钮后台事件
    // document.getElementById("btnOk").click(); 
}

function chk_input(){
	
		
    if(login.login_id.value=="")
    {
     alert('아이디를 입력하세요!');
     login.login_id.focus();
     return false;
     }
     if(login.login_pass.value==""){
     alert('비밀번호를 입력하세요!');
     login.login_pass.focus();
     return false;
     }
    
     return true;
}
    
</script>

</head>

<body id="wrap_login">


<div>


	<div id="loginWrap">

		<div id="loginWrap_inner">
			<form name="theForm" action="/loginProcess" method="post" onSubmit="return theForm_chk();">
				<p class="input"><img src="/img/login_tl_id.gif" title="아이디"><input name="username" type="text" size="10" maxlength="30" class="loginInput"></p>
				<p class="input"><img src="/img/login_tl_pw.gif" title="비밀번호"><input name="pass" type="password" size="10" maxlength="20" class="loginInput"></p>
				<p class="btn"><input type="image" src="/img/login_btn.gif" title="로그인" onfocus="blur()"></p>
				<!--
				<div class="joinPartner"><p class="icon_plus"><a href="javascript:void(0)" onclick="alertWin('파트너 가입','분류 추가',300,340);">파트너 가입</a></p></div>
				-->
			</form>
		</div>

	</div>

	<form action="/joinProcess" method="post" name="regform" id="regform" >
	<input type="hidden" name="regname" id="regname" value="">
	<input type="hidden" name="password" id="password" value="">
	<input type="hidden" name="password2" id="password2" value="">
	<input type="hidden" name="e_mail" id="e_mail" value="">
	<input type="hidden" name="n_name" id="n_name" value="" >
	<input type="hidden" name="handphone" id="handphone" value="">
	<input type="hidden" name="bank_name" id="bank_name" value="">
	<input type="hidden" name="bank_num" id="bank_num" value="">
	<input type="hidden" name="bank_username" id="bank_username" value="">
	</form>

</div>

<!--
<div id="wrap_login">
	<div id="loginWrap">
		<div id="loginWrap_inner">
			<form action="/loginProcess" name="login" id="login" method="post" onsubmit="return chk_input();">
			<p class="input"><img src="/img/login_tl_id.gif" title="아이디"><input type="text" name="login_id" class="loginInput"></p>
			<p class="input"><img src="/img/login_tl_pw.gif" title="비밀번호"><input type="password" name="login_pass" class="loginInput"></p>
			<p class="btn"><input type="image" src="/img/login_btn.gif" title="로그인"></p>
			<div class="joinPartner"><p class="icon_plus"><a href="javascript:void(0)" onclick="alertWin('파트너 가입','분류 추가',300,340);">파트너 가입</a></p></div>
			</form>
		</div>

	</div>
</div>
-->
</body>
</html>