<?php /* Template_ 2.2.3 2013/01/16 18:29:51 D:\www\vhost.manager\_template\content\board\type.html */
$TPL_poplist_1=empty($TPL_VAR["poplist"])||!is_array($TPL_VAR["poplist"])?0:count($TPL_VAR["poplist"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
function goDel(idx)
{
	var result = confirm('이 분류에 해당하는 모든 게시물이 삭제됩니다. 삭제하시겠습니까?');
	if(result){
		location.href="?del=ok&id="+idx;
	}	
}

function alertWin(title, msg, w, h){ 
    var titleheight = "22px"; // 提示窗口标题高度 
    var bordercolor = "#aac4f9"; // 提示窗口的边框颜色 
    var titlecolor = "#FFFFFF"; // 提示窗口的标题颜色 
    var titlebgcolor = "#aac4f9"; // 提示窗口的标题背景色
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
    titleBar.style.cssText = "width:100%;height:"+titleheight+"px;text-align:left;padding:3px;margin:0px;font:bold 13px '굴림';color:"+titlecolor+";border:1px solid " + bordercolor + ";cursor:move;background-color:" + titlebgcolor;
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
    closeBtn.innerHTML = "<span style='font-size:15pt; color:"+titlecolor+";'>×</span>";
    closeBtn.onclick = function(){ 
        document.body.removeChild(bgObj); 
        document.body.removeChild(msgObj); 
    } 
    var msgBox = table.insertRow(-1).insertCell(-1);
    msgBox.style.cssText = "font:10pt '굴림';";
    msgBox.colSpan = 2;
    
    var msgs = "<table width='100%' border='0' cellspacing='1' cellpadding='0' style='margin-bottom:3px;' class='link_lan' bgcolor='#ffffff'>"
					+"<tr width='50%'>"
				    +"<td width='30%' align='center' height='26' bgcolor='#e8edee' style='border-bottom:1px #CCCCCC solid;color: #666666'>분류명</td>"
				    +"<td width='70%' align='center' bgcolor='#e8edee' style='border-bottom:1px #CCCCCC solid;color: #666666'><input type='text' id='txtName' style='border:1px #cccccc solid'></td>"
				    +"</tr>"
			        +"<tr width='50%'>"
				    +"<td width='30%' align='center'  height='26' bgcolor='#e8edee' style='border-bottom:1px #CCCCCC solid;color: #666666'>영문명</td>"
				    +"<td width='70%' align='center' bgcolor='#e8edee' style='border-bottom:1px #CCCCCC solid;color: #666666'><input type='text'  id='txtPwd'  style='border:1px #cccccc solid'></td>"
					+"</tr>"
					+"<tr><td colspan='2' bgcolor='#e8edee'><input type='button' value='추가' style='border:solid 1px #b1b1b1;background:#ffffff' onclick='getValue(\""+bgObj.id+"\",\""+msgObj.id+"\")' /></td></tr>"
				    +"</table>"
               //+"<input type='button' value='추가' style='border:solid 1px #b1b1b1;background:#ffffff' onclick='getValue(\""+bgObj.id+"\",\""+msgObj.id+"\")' />";
    msgBox.innerHTML = msgs;
    
    // 获得事件Event对象，用于兼容IE和FireFox
    function getEvent() {
        return window.event || arguments.callee.caller.arguments[0];
    }
} 
//执行后台 click()
function getValue(bgObjId,msgObjId) 
{
    document.getElementById("a_1").value =  document.getElementById("txtName").value;
	document.getElementById("a_2").value =  document.getElementById("txtPwd").value;
    var bgObj = document.getElementById(bgObjId);
    var msgObj = document.getElementById(msgObjId);
    
    document.body.removeChild(bgObj); 
    document.body.removeChild(msgObj); 
	document.getElementById("form_add").submit();

    //document.form1.submit();
    //执行隐藏服务器按钮后台事件
    // document.getElementById("btnOk").click(); 
}
</script>
<?php 
//include "type_add.php";
?>
</head>

<body>
<div class="wrap" id="type">

	<div id="route">
		<h5>관리자 시스템 > 게시판 관리 > <b>분류 관리</b></h5>
	</div>

	<h3>분류 관리</h3>

	<ul id="tab">
		<li><a href="/board/type" id="type">분류 관리</a></li>
		<li><a href="/board/list?province=5" id="freeboard">자유게시판</a></li>
		<li><a href="/board/list?province=2" id="notice">공지사항</a></li>
		<li><a href="/board/list?province=4" id="faq">FAQ</a></li>
		<li><a href="/board/list?province=7" id="event">이벤트</a></li>
		<li><a href="/board/questionlist" id="question_list">고객센터</a></li>
<?php
	//-> 관리자 시퀀스가 1000 이상이면 뷰모드관리자
	if ( $_SESSION['member']['sn'] < 1000 ) {
?>
		<li><a href="/board/write" id="write">게시물 쓰기</a></li>
		<li><a href="/board/site_rule_edit?type=1">회원약관 수정</a></li>
		<li><a href="/board/site_rule_edit?type=2">배팅규정 수정</a></li>
<?php
	}
?>
	</ul>
	<div id="search2">
		<input type="button" value="분류 추가" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="alertWin('분류 추가','분류 추가',300,110);" />
	</div>
	<form action="?ok=yes" method="post"   name="form_add" id="form_add">
		<input type="hidden" name="name" value="" id="a_1">
		<input type="hidden" name="en" value="" id="a_2">
	</form>
	
	<form action="?<?php if($TPL_VAR["id"]==''){?>ok=yes<?php }else{?>up=ok<?php }?>" method="post"   name="form1" id="form1">	
<?php if($TPL_poplist_1){foreach($TPL_VAR["poplist"] as $TPL_V1){?>		
		<table class="tableStyle_pop add" >
			<tr>
				<th>분류명</th>
				<td><input type="text" name="name" value="<?php echo $TPL_V1["name"]?>" class="popInput"></td>
			</tr>
			<tr>
				<th>영문명</th>
				<td><input type="text" name="en" value="<?php echo $TPL_V1["en"]?>" class="popInput"></td>
				<td rowspan="1"></td>
			</tr>
			<input type="hidden" name="id" value="<?php echo $TPL_V1["id"]?>">
		</table>
		<div id="wrap_btn"><input type="submit" value="확인" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'"></div>
<?php }}?>		
	</form>

	<table cellspacing="1" class="tableStyle_normal add" summary="분류 목록">
	<legend class="blind">분류 목록</legend>
	<thead>
		<tr>
			<th>ID</th>
			<th>분류명</th>
			<th>영문명</th>
			<th>처리</th>
		</tr>
	</thead>
	<tbody>	
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["id"]?></td>
			<td><?php echo $TPL_V1["name"]?></td>
			<td><?php echo $TPL_V1["en"]?></td>
			<td><a href="?id=<?php echo $TPL_V1["id"]?>"><img src="/img/btn_s_modify.gif" title="수정"></a> <a href="javascript:void(0)" onclick="goDel(<?php echo $TPL_V1["id"]?>)"><img src="/img/btn_s_del.gif" title="삭제"></a></td>
		</tr>
<?php }}?>	
	</tbody>
	</table>

</div>

<?php
 //include "../main_foot.php";
 ?>
</body>
</html>