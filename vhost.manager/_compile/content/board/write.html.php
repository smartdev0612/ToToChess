<?php
$TPL_muneList_1=empty($TPL_VAR["muneList"])||!is_array($TPL_VAR["muneList"])?0:count((array)$TPL_VAR["muneList"]);
$TPL_bettingItem_1=empty($TPL_VAR["bettingItem"])||!is_array($TPL_VAR["bettingItem"])?0:count((array)$TPL_VAR["bettingItem"]);
$TPL_array_game_1=empty($TPL_VAR["array_game"])||!is_array($TPL_VAR["array_game"])?0:count((array)$TPL_VAR["array_game"]);
$TPL_replyList_1=empty($TPL_VAR["replyList"])||!is_array($TPL_VAR["replyList"])?0:count((array)$TPL_VAR["replyList"]);?>
<script charset="utf-8" src="/web_editor_cocopa/kindeditor.js"></script>

<script>
function len(s) 
{ 
	var l = 0; 
	var a = s.split(""); 
	for (var i=0;i<a.length;i++) 
	{
		if (a[i].charCodeAt(0)<299) {l++;} 
		else {l+=2;} 
	} 
	return l; 
}

function Form_ok() 
{
	if (Form1.title.value == "") 
	{
		alert("제목 입력!!!");
		document.Form1.title.focus();
		return;
	}
	if(Form1.province.value == "")
	{
		alert("분류 선택!!!");
		document.Form1.province.focus();
		return;
	}
	if(Form1.author.value =="")
	{
		alert("작성자 선택!!!");
		document.Form1.author.focus();
		return;
	}
	if(Form1.time.value =="")
	{
		alert("시간 선택!!!");
		document.Form1.time.focus();
		return;
	}
	if(len(Form1.time.value) !=19)
	{
		alert("시간 격식이 틀립니다. 확인하십시오!!!");
		document.Form1.time.focus();
		return;
	}
	
	if (confirm("입력하신 내용을 등록 하시겠습니까 ?"))
	{
		document.Form1.imgsrc.value=KE.util.getpic('on');
		document.Form1.submit();
	}
	else {return;}
}

function check_reply()
{
	if(document.reply.comment.value=="")
	{
		alert("리플 내용을 입력하십시오.!");
		document.reply.comment.focus();
		return;
	}
	if(document.reply.reply_author.value=="")
	{
		alert("리플 닉네임을 입력하십시오.!");
		document.reply.reply_author.focus();
		return;
	}
	document.reply.submit();
}

// chltnwjd
function goDel(delsn, _id)
{
	var result = confirm('삭제 하시겠습니까?');
	if(result) {location.href="?act=delete_comment&sn="+delsn+"&id="+_id;}	
}

function goModify(sn, _id)
{
	var result = confirm('수정하시겠습니까?');
	var content = $('#'+sn+'_content').val();
	if(result) {location.href="?act=modify_comment&sn="+sn+"&content="+content+"&id="+_id;}	
}

function checkNumber(e)
{
	var key = window.event ? e.keyCode : e.which;
	var keychar = String.fromCharCode(key);
	//var el = document.getElementById('test');
	var msg = document.getElementById('msg');
	reg = /\d/;
	var result = reg.test(keychar);
	if(!result)
	{
		msg.innerHTML="<font color='red'>숫자만 입력 가능합니다.</font>";
		return false;
	}
	else
	{
		msg.innerHTML="";
		return true;
	}
}

var xmlHttp;
var re=false;
var re2=false;
var isChckRecommend = false;
var re4=false;

function createXMLHttpRequest()
{
	if(window.XMLHttpRequest)
  {
  	xmlHttp = new XMLHttpRequest();//mozilla브라우저
  }
  else if(window.ActiveXObject)
  {
  	try
    {
    	xmlHttp = new ActiveX0bject("Msxml2.XMLHTTP");//IE얼드버전
    }
    catch(e)
    {}
    try
    {
    	xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");//IE뉴버전
    }
    catch(e)
    {}
    if(!xmlHttp)
    {
    	window.alert("XMLHttpRequest-대상을 업그레이드 할 수가 없습니다.");
      return false;
    }
  }
}

function startRequest()
{
	var author = document.getElementById("author").value;
  
	createXMLHttpRequest();
	xmlHttp.open("GET","/board/addCheckAjax?author="+encodeURIComponent(author),true);
	xmlHttp.onreadystatechange = handleStateChange;
	xmlHttp.send(null);
}

function ajaxReplyNickRequest()
{
	var author = document.getElementById("reply_author").value;
  
	createXMLHttpRequest();
	xmlHttp.open("GET","/board/addCheckAjax?author="+encodeURIComponent(author),true);
	xmlHttp.onreadystatechange = onReplyNickResponse;
	xmlHttp.send(null);
}

function onReplyNickResponse()
{
	if(xmlHttp.readyState==4)
  {
  	if(xmlHttp.status==200)
    {
    	if(xmlHttp.responseText == "true")
    	{
      	document.getElementById("reply_nick_check_message").innerHTML = ' <font color=#ff0000>이미 가입된 닉네임 입니다.</font>';
      	document.reply.reply_author.value="";
				return false;
      }
      else if(xmlHttp.responseText == "false")
      {
      	document.getElementById("reply_nick_check_message").innerHTML = '<font color=blue>사용 가능한 닉네임 입니다.</font>';
				return true;
      }
     }
  }
}

function handleStateChange()
{
	if(xmlHttp.readyState==4)
  {
  	if(xmlHttp.status==200)
    {
    	if(xmlHttp.responseText == "true")
    	{
      	document.getElementById("ckauthor").innerHTML = ' <font color=#ff0000>이미 가입된 닉네임 입니다.</font>';
      	
				re=false;
				return false;
      }
      else if(xmlHttp.responseText == "false")
      {
      	document.getElementById("ckauthor").innerHTML = '<font color=#ff0000>사용 가능한 닉네임 입니다.</font>';
				re=true;
				return true;
      }
     }
  }
}

function excelUpload(_id)
{
	window.open('/board/popup_reply_excelupload?id='+_id,'','resizable=yes scrollbars=yes top=5 left=5 width=1100 height=650');
}

function changeAuthor(val)
{
	if(val!='5')
	{
		document.getElementById('author').value="관리자";
	}
}

</script>



<!-- content begin -->

<div class="wrap" id="write">

	<div id="route">
		<h5>관리자 시스템 > 게시판 관리 > <b>게시글 쓰기</b></h5>
	</div>

	<h3>게시글 쓰기</h3>

	<ul id="tab">
		<li><a href="/board/list?province=5" id="freeboard">자유게시판</a></li>
		<li><a href="/board/list?province=2" id="notice">공지사항</a></li>
		<li><a href="/board/list?province=7" id="event">이벤트</a></li>
		<li><a href="/board/questionlist" id="question_list">고객센터</a></li>
		<li><a href="/board/write" id="write">게시물 쓰기</a></li>
		<li><a href="/board/site_rule_edit?type=1" id="member_rule">회원약관 수정</a></li>
		<li><a href="/board/site_rule_edit?type=2" id="betting_rule">배팅규정 수정</a></li>
	</ul>

	<form action="/board/writeProcess?id=<?php echo $TPL_VAR["id"]?>" method="post" name="Form1">
		<input type="hidden" name="imgsrc"  value="">
		<table cellspacing="1" class="tableStyle_membersWrite">
		<legend class="blind">게시글 쓰기</legend>
			<tr>
				<th>배팅첨부</th>
				<td><a href="#" onclick="javascript:open_window('/board/popup_betting?province=<?php echo $TPL_VAR["province"]?>&perpage=100',1224,600)"><input type="button" value="배팅첨부"></a></td>
			</tr>
			<tr>
				<th>제목</th>
				<td><input name="title" type="text" class="wWhole"  value='<?php echo str_replace("'","\'",$TPL_VAR["list"]["title"])?>' onmouseover="this.focus()"></td>
		  </tr>
		  <tr>
				<th>분류</th>
				<td>
					<select name="province" onchange="changeAuthor(this.value)"><option value="">분류 선택</option>
<?php if($TPL_muneList_1){foreach($TPL_VAR["muneList"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1["sn"]?>" <?php if($TPL_V1["sn"]==$TPL_VAR["list"]["province"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
					</select>

					<select name="logo">
						<option value="gadget" <?php if($TPL_VAR["list"]["logo"]=="gadget"){?>  selected <?php }?>>gadget</option>
					</select>
					<font color='red'>사이트 선택은 [공지사항]일 경우에만 적용됩니다.</font>
				</td>
		  </tr>
		  <tr>
				<th>작성자</th>
				<td>
					<input id="author" name="author" type="text" onblur="startRequest();" value="<?php echo $TPL_VAR["list"]["author"]?>"/>	
					레벨
					<select id="lvl" name="lvl">
						<option value="1" <?php if($TPL_VAR["list"]["lvl"] == 1) {echo "selected";}?>>1</option>
						<option value="2" <?php if($TPL_VAR["list"]["lvl"] == 2) {echo "selected";}?>>2</option>
						<option value="3" <?php if($TPL_VAR["list"]["lvl"] == 3) {echo "selected";}?>>3</option>
						<option value="4" <?php if($TPL_VAR["list"]["lvl"] == 4) {echo "selected";}?>>4</option>
						<option value="5" <?php if($TPL_VAR["list"]["lvl"] == 5) {echo "selected";}?>>5</option>
					</select> &nbsp;<span id="ckauthor"></span>
					<select id="selectNick" onChange="selecteNick(this.value);">
						<option value="">::: 닉네임 선택 :::</option>
<?php
	for ( $i = 0 ; $i < count((array)$TPL_VAR["nickList"]) ; $i++ ) {
		echo "<option value='".$TPL_VAR["nickList"][$i]["nick"]."|".$TPL_VAR["nickList"][$i]["mem_lev"]."'  ".$selected.">".$TPL_VAR["nickList"][$i]["nick"]." (".$TPL_VAR["nickList"][$i]["mem_lev"].")</option>";
	}
?>
						<option value='히릿|2'>히릿</option>
						<option value='휘발류|2'>휘발류</option>
						<option value='훌라|2'>훌라</option>
						<option value='후라이드|2'>후라이드</option>
						<option value='홍합|2'>홍합</option>
						<option value='홍삼왕|2'>홍삼왕</option>
						<option value='홀짝베팅건승|2'>홀짝베팅건승</option>
						<option value='홀삼짝|2'>홀삼짝</option>
						<option value='호통령|2'>호통령</option>
						<option value='호날두|2'>호날두</option>
						<option value='호구너구리|2'>호구너구리</option>
						<option value='현금|2'>현금</option>
						<option value='헐크다람쥐|2'>헐크다람쥐</option>
						<option value='핸디|2'>핸디</option>
						<option value='해중님|2'>해중님</option>
						<option value='할매|2'>할매</option>
						<option value='한아름|2'>한아름</option>
						<option value='한수|2'>한수</option>
						<option value='한번만주세요|2'>한번만주세요</option>
						<option value='한글|2'>한글</option>
						<option value='학다리|2'>학다리</option>
						<option value='하이트|2'>하이트</option>
						<option value='하이염|2'>하이염</option>
						<option value='하음사랑|2'>하음사랑</option>
						<option value='하삼관|2'>하삼관</option>
						<option value='필립코쿠|2'>필립코쿠</option>
						<option value='피자|2'>피자</option>
						<option value='풍생토쟁이|2'>풍생토쟁이</option>
						<option value='퐈닝퐈니|2'>퐈닝퐈니</option>
						<option value='포카리|2'>포카리</option>
						<option value='포레스|2'>포레스</option>
						<option value='평창수|2'>평창수</option>
						<option value='퍼니잭|2'>퍼니잭</option>
						<option value='패가망신|2'>패가망신</option>
						<option value='파랑색|2'>파랑색</option>
						<option value='특별보스|2'>특별보스</option>
						<option value='트라|2'>트라</option>
						<option value='톰과제리|2'>톰과제리</option>
						<option value='토토왕김용만|2'>토토왕김용만</option>
						<option value='토토왕|2'>토토왕</option>
						<option value='토토완자|2'>토토완자</option>
						<option value='토창|2'>토창</option>
						<option value='토신이되쟈|2'>토신이되쟈</option>
						<option value='토성님님|2'>토성님님</option>
						<option value='토사장밥줄|2'>토사장밥줄</option>
						<option value='토나오네|2'>토나오네</option>
						<option value='털보|2'>털보</option>
						<option value='타토|2'>타토</option>
						<option value='타짜|2'>타짜</option>
						<option value='킼킼킼|2'>킼킼킼</option>
						<option value='큰손|2'>큰손</option>
						<option value='코코넛|2'>코코넛</option>
						<option value='코스튜움|2'>코스튜움</option>
						<option value='코보리아|2'>코보리아</option>
						<option value='코다리|2'>코다리</option>
						<option value='코난|2'>코난</option>
						<option value='코끼리뒷차기|2'>코끼리뒷차기</option>
						<option value='캡틴|2'>캡틴</option>
						<option value='캄포마|2'>캄포마</option>
						<option value='카네기|2'>카네기</option>
						<option value='친개입니다|2'>친개입니다</option>
						<option value='촉왕용|2'>촉왕용</option>
						<option value='초원|2'>초원</option>
						<option value='청보리|2'>청보리</option>
						<option value='첨단그녀석|2'>첨단그녀석</option>
						<option value='철희지인|2'>철희지인</option>
						<option value='천지인|2'>천지인</option>
						<option value='차사장|2'>차사장</option>
						<option value='찌루|2'>찌루</option>
						<option value='짱짱각짱짱|2'>짱짱각짱짱</option>
						<option value='짝대기|2'>짝대기</option>
						<option value='짜장형님|2'>짜장형님</option>
						<option value='집어등|2'>집어등</option>
						<option value='질러킴|2'>질러킴</option>
						<option value='진구|2'>진구</option>
						<option value='지온아빠|2'>지온아빠</option>
						<option value='줸장옆차기|2'>줸장옆차기</option>
						<option value='주한이|2'>주한이</option>
						<option value='좌사홀|2'>좌사홀</option>
						<option value='좌박꼼|2'>좌박꼼</option>
						<option value='종달새|2'>종달새</option>
						<option value='종규끼|2'>종규끼</option>
						<option value='종규사마|2'>종규사마</option>
						<option value='조르지마|2'>조르지마</option>
						<option value='젠터리|2'>젠터리</option>
						<option value='제발돈따자|2'>제발돈따자</option>
						<option value='제리|2'>제리</option>
						<option value='제로문|2'>제로문</option>
						<option value='정의의마귀|2'>정의의마귀</option>
						<option value='전주고니|2'>전주고니</option>
						<option value='적중왕|2'>적중왕</option>
						<option value='잠지|2'>잠지</option>
						<option value='잘해보자|2'>잘해보자</option>
						<option value='임페리얼|2'>임페리얼</option>
						<option value='일억환전|2'>일억환전</option>
						<option value='일수대출|2'>일수대출</option>
						<option value='이르마니|2'>이르마니</option>
						<option value='이도사|2'>이도사</option>
						<option value='음메|2'>음메</option>
						<option value='은재야부자되자|2'>은재야부자되자</option>
						<option value='유경|2'>유경</option>
						<option value='월드컵파|2'>월드컵파</option>
						<option value='원동만수|2'>원동만수</option>
						<option value='워니|2'>워니</option>
						<option value='웅담이|2'>웅담이</option>
						<option value='울산히어로|2'>울산히어로</option>
						<option value='우지니|2'>우지니</option>
						<option value='우정오프로|2'>우정오프로</option>
						<option value='우롱|2'>우롱</option>
						<option value='요거트|2'>요거트</option>
						<option value='와우|2'>와우</option>
						<option value='옹시루|2'>옹시루</option>
						<option value='올투바|2'>올투바</option>
						<option value='올쌈바|2'>올쌈바</option>
						<option value='오서방|2'>오서방</option>
						<option value='영혼촉|2'>영혼촉</option>
						<option value='연승|2'>연승</option>
						<option value='연면|2'>연면</option>
						<option value='역삼동|2'>역삼동</option>
						<option value='역배전문가|2'>역배전문가</option>
						<option value='여행가자|2'>여행가자</option>
						<option value='엠똥광|2'>엠똥광</option>
						<option value='엘레강스|2'>엘레강스</option>
						<option value='에헤라|2'>에헤라</option>
						<option value='에이비씨|2'>에이비씨</option>
						<option value='에버다임|2'>에버다임</option>
						<option value='엄마귀|2'>엄마귀</option>
						<option value='어린왕자|2'>어린왕자</option>
						<option value='애니콜|2'>애니콜</option>
						<option value='안졸리나졸라|2'>안졸리나졸라</option>
						<option value='안양구|2'>안양구</option>
						<option value='아이린|2'>아이린</option>
						<option value='아르르르르|2'>아르르르르</option>
						<option value='아롱이|2'>아롱이</option>
						<option value='아롤존잘|2'>아롤존잘</option>
						<option value='아따|2'>아따</option>
						<option value='아니요|2'>아니요</option>
						<option value='쏘랭이|2'>쏘랭이</option>
						<option value='실리콘|2'>실리콘</option>
						<option value='신태공|2'>신태공</option>
						<option value='신천호|2'>신천호</option>
						<option value='신의한수|2'>신의한수</option>
						<option value='시빈|2'>시빈</option>
						<option value='시골아이|2'>시골아이</option>
						<option value='스포츠만|2'>스포츠만</option>
						<option value='스포츠|2'>스포츠</option>
						<option value='스카이|2'>스카이</option>
						<option value='스딸벅스|2'>스딸벅스</option>
						<option value='스나이퍼|2'>스나이퍼</option>
						<option value='수탱이|2'>수탱이</option>
						<option value='쇼바님|2'>쇼바님</option>
						<option value='송아지|2'>송아지</option>
						<option value='송사리|2'>송사리</option>
						<option value='속담|2'>속담</option>
						<option value='소림사|2'>소림사</option>
						<option value='소라|2'>소라</option>
						<option value='세윤이|2'>세윤이</option>
						<option value='서우담배일진|2'>서우담배일진</option>
						<option value='서빈|2'>서빈</option>
						<option value='샤댤왕|2'>샤댤왕</option>
						<option value='샤끄투|2'>샤끄투</option>
						<option value='상무지구|2'>상무지구</option>
						<option value='상모동인간|2'>상모동인간</option>
						<option value='삼성동고니|2'>삼성동고니</option>
						<option value='사신|2'>사신</option>
						<option value='사랑이아빠|2'>사랑이아빠</option>
						<option value='사다리짱|2'>사다리짱</option>
						<option value='삥그르|2'>삥그르</option>
						<option value='뿌꾸뿌꾸|2'>뿌꾸뿌꾸</option>
						<option value='뽕따|2'>뽕따</option>
						<option value='빵떡|2'>빵떡</option>
						<option value='빤츠|2'>빤츠</option>
						<option value='비행기|2'>비행기</option>
						<option value='비수입니당|2'>비수입니당</option>
						<option value='비꾸치이|2'>비꾸치이</option>
						<option value='비꾸치|2'>비꾸치</option>
						<option value='블루가인|2'>블루가인</option>
						<option value='분석가토쟁이|2'>분석가토쟁이</option>
						<option value='부시맨|2'>부시맨</option>
						<option value='봉자느님|2'>봉자느님</option>
						<option value='봉겜방|2'>봉겜방</option>
						<option value='보햄|2'>보햄</option>
						<option value='보스|2'>보스</option>
						<option value='보빨달인|2'>보빨달인</option>
						<option value='보라돌이|2'>보라돌이</option>
						<option value='보들들|2'>보들들</option>
						<option value='별처럼|2'>별처럼</option>
						<option value='벤틀리|2'>벤틀리</option>
						<option value='베늄|2'>베늄</option>
						<option value='벅구다|2'>벅구다</option>
						<option value='백호|2'>백호</option>
						<option value='백기리|2'>백기리</option>
						<option value='백구|2'>백구</option>
						<option value='배팅의꽃|2'>배팅의꽃</option>
						<option value='밤에황재|2'>밤에황재</option>
						<option value='반응나니|2'>반응나니</option>
						<option value='박정수르|2'>박정수르</option>
						<option value='박순대나잇|2'>박순대나잇</option>
						<option value='박솰낸다|2'>박솰낸다</option>
						<option value='박도끼|2'>박도끼</option>
						<option value='바람머리|2'>바람머리</option>
						<option value='바람난작살|2'>바람난작살</option>
						<option value='바두기카페|2'>바두기카페</option>
						<option value='미친분|2'>미친분</option>
						<option value='미찌|2'>미찌</option>
						<option value='미안해요돈따서|2'>미안해요돈따서</option>
						<option value='뭣이중헌디|2'>뭣이중헌디</option>
						<option value='뭉치|2'>뭉치</option>
						<option value='묵자묵자|2'>묵자묵자</option>
						<option value='몽블랑짱|2'>몽블랑짱</option>
						<option value='목뒤에살모사|2'>목뒤에살모사</option>
						<option value='모아니면도|2'>모아니면도</option>
						<option value='모란봉|2'>모란봉</option>
						<option value='메가점프|2'>메가점프</option>
						<option value='멍게형님|2'>멍게형님</option>
						<option value='먹보|2'>먹보</option>
						<option value='매날올잉|2'>매날올잉</option>
						<option value='마이호레스|2'>마이호레스</option>
						<option value='마스터이|2'>마스터이</option>
						<option value='마슈슈슈슈소|2'>마슈슈슈슈소</option>
						<option value='마로|2'>마로</option>
						<option value='마귀탄|2'>마귀탄</option>
						<option value='리키|2'>리키</option>
						<option value='라일락|2'>라일락</option>
						<option value='라이브황제|2'>라이브황제</option>
						<option value='라이라이|2'>라이라이</option>
						<option value='라라라|2'>라라라</option>
						<option value='라기레아|2'>라기레아</option>
						<option value='떳다빅보스|2'>떳다빅보스</option>
						<option value='따자짱|2'>따자짱</option>
						<option value='딜려|2'>딜려</option>
						<option value='돼지|2'>돼지</option>
						<option value='동빵이다|2'>동빵이다</option>
						<option value='동빵이|2'>동빵이</option>
						<option value='돈폭탄|2'>돈폭탄</option>
						<option value='돈좀따보자|2'>돈좀따보자</option>
						<option value='독산동타자|2'>독산동타자</option>
						<option value='도미노|2'>도미노</option>
						<option value='대구리|2'>대구리</option>
						<option value='담양오리|2'>담양오리</option>
						<option value='담양닭|2'>담양닭</option>
						<option value='단결|2'>단결</option>
						<option value='닥치고한폴낙|2'>닥치고한폴낙</option>
						<option value='다박다박|2'>다박다박</option>
						<option value='다따가뿌자|2'>다따가뿌자</option>
						<option value='니끼미|2'>니끼미</option>
						<option value='눕혀보니스님|2'>눕혀보니스님</option>
						<option value='노원거지|2'>노원거지</option>
						<option value='노밤|2'>노밤</option>
						<option value='내가호구다|2'>내가호구다</option>
						<option value='낭낭|2'>낭낭</option>
						<option value='남자이야기|2'>남자이야기</option>
						<option value='난다리요|2'>난다리요</option>
						<option value='나즈막히|2'>나즈막히</option>
						<option value='나비|2'>나비</option>
						<option value='나드리|2'>나드리</option>
						<option value='꿀빅용|2'>꿀빅용</option>
						<option value='꼬마둥이|2'>꼬마둥이</option>
						<option value='깐똣|2'>깐똣</option>
						<option value='까만콩콩|2'>까만콩콩</option>
						<option value='김찬기|2'>김찬기</option>
						<option value='김연아|2'>김연아</option>
						<option value='김사장|2'>김사장</option>
						<option value='김사달ㅋ|2'>김사달ㅋ</option>
						<option value='김날두|2'>김날두</option>
						<option value='김구라다|2'>김구라다</option>
						<option value='기아|2'>기아</option>
						<option value='기브미어원달러|2'>기브미어원달러</option>
						<option value='급행열차|2'>급행열차</option>
						<option value='그들만의리그|2'>그들만의리그</option>
						<option value='규니님|2'>규니님</option>
						<option value='군산일자리|2'>군산일자리</option>
						<option value='국밥도베터닷|2'>국밥도베터닷</option>
						<option value='구스트롱|2'>구스트롱</option>
						<option value='구라짱|2'>구라짱</option>
						<option value='구땡|2'>구땡</option>
						<option value='관세음보살|2'>관세음보살</option>
						<option value='곰동이|2'>곰동이</option>
						<option value='골프맨|2'>골프맨</option>
						<option value='건승기원|2'>건승기원</option>
						<option value='건승|2'>건승</option>
						<option value='거리조준|2'>거리조준</option>
						<option value='갠민|2'>갠민</option>
						<option value='개팔이|2'>개팔이</option>
						<option value='개안체|2'>개안체</option>
						<option value='강프로님|2'>강프로님</option>
						<option value='강태공|2'>강태공</option>
						<option value='강남의전설|2'>강남의전설</option>
						<option value='감자깡|2'>감자깡</option>
						<option value='감감감|2'>감감감</option>
						<option value='가자미|2'>가자미</option>
						<option value='가라가|2'>가라가</option>
						<option value='사쿠라짱|2'>사쿠라짱</option>
						<option value='나오미|2'>나오미</option>
						<option value='붕가붕가|2'>붕가붕가</option>
						<option value='초록이|2'>초록이</option>
						<option value='캔스톤|2'>캔스톤</option>
						<option value='아이폰빠|2'>아이폰빠</option>
						<option value='초콜릿중독|2'>초콜릿중독</option>
						<option value='듀오덤|2'>듀오덤</option>
					</select>
				</td>
		  </tr>
		  <tr>
			<th>시간</th>						
<?php if($TPL_VAR["id"]==""){?>
			<td><input name="time" type="text"  class="w250" value="<?php echo date("Y-m-d H:i:s")?>"/>&nbsp;<font color="red">날자는 꼭 지정된 형식대로 적어주십시오.</font>
<?php }else{?>
			<td><input name="time" type="text"  class="w250" value="<?php echo $TPL_VAR["list"]["time"]?>"/>&nbsp;<font color="red">날자는 꼭 지정된 형식대로 적어주십시오.</font>
<?php }?>
			</td>
		  </tr>
		  <tr>
			<th>조회</th>
			<td><input name="hit" type="text"  value="<?php echo $TPL_VAR["list"]["hit"]?>" class="w60" onkeypress="return checkNumber(event);" onmouseover="this.focus()" onmouseover="this.focus()"/><span id="msg"></span></td>
		  </tr>
		  <tr>
			<th>추천</th>
			<td>
				<input name="top" type="radio"  value="1" <?php if($TPL_VAR["list"]["top"]==1){?> checked="checked" <?php }else{?> checked="checked <?php }?> class="recomInput"/> 추천안함
				<input name="top" type="radio"  value="2" <?php if($TPL_VAR["list"]["top"]==2){?> checked="checked" <?php }?> class="recomInput"/> 추천
				<span style="padding-left:30px;"><font color="red">↓이미지 업로드 경우 이미지 넓이를 무조건 720 이하로 설정하여 주십시오.</font></span
			</td>
		  </tr>
		  <tr>
		  
			<!-- 배팅 리스트 Begin -->
<?php if(count((array)$TPL_VAR["bettingItem"])){?>
<?php if($TPL_bettingItem_1){foreach($TPL_VAR["bettingItem"] as $TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count((array)$TPL_V1["item"]);?>
				<table cellspacing="1" class="tableStyle_gameList" style="width:auto">		  		
		  		<thead>
	    		<tr>     	      
		      	<th style="width:110px;">No</th>
						<th style="width:90px;">경기일시</th>
						<th style="width:50px;">대분류</th>
						<th style="width:50px;">종류</th>
						<th style="width:50px;">종목</th>
						<th style="width:140px;">리그</th>
						<th style="width:310px;" colspan="2">승(홈팀)</th>
						<th style="width:40px;">무</th>
						<th style="width:310px;" colspan="2">패(원정팀)</th>
						<th style="width:50px;">스코어</th>
						<th style="width:50px;">이긴 팀</th>					
	    		</tr>	    		
	 				</thead>
					<tbody>
<?php if($TPL_item_2){foreach($TPL_V1["item"] as $TPL_V2){?>
						<tr>
							<td><?php echo $TPL_V1["betting_no"]?></td>
							<td><?php echo sprintf("%s/%s %s:%s",substr($TPL_V2["gameDate"],5,2),substr($TPL_V2["gameDate"],8,2),$TPL_V2["gameHour"],$TPL_V2["gameTime"])?></td>
							<td>
<?php if($TPL_V2["special"]==0){?>일반
<?php }elseif($TPL_V2["special"]==1){?>실시간
<?php }elseif($TPL_V2["special"]==2){?>멀티
<?php }elseif($TPL_V2["special"]==3){?>고액
<?php }elseif($TPL_V2["special"]==4){?>이벤트
<?php }?>
							</td>
							<td>
<?php if($TPL_V2["game_type"]==1){?><span class="victory">승무패</span>
<?php }elseif($TPL_V2["game_type"]==2){?><span class="handicap">핸디캡</span>
<?php }elseif($TPL_V2["game_type"]==4){?><span class="underover">언더오버</span>
<?php }?>
							</td>
							<td><?php echo $TPL_V2["sport_name"]?></td>
							<td class="league"><?php echo $TPL_V2["league_name"]?></td>
							<td<?php if($TPL_V2["select_no"]==1){?> style="background:#FFE08C;"<?php }?>><?php echo $TPL_V2["home_team"]?></td>
							<td style="width:40px;" <?php if($TPL_V2["select_no"]==1){?> style="background:#FFE08C;"<?php }?>><?php echo $TPL_V2["home_rate"]?></td>
							<td<?php if($TPL_V2["select_no"]==3){?> style="background:#FFE08C;"<?php }?>><?php echo $TPL_V2["draw_rate"]?></td>
							<td<?php if($TPL_V2["select_no"]==2){?> style="background:#FFE08C;"<?php }?>><?php echo $TPL_V2["away_team"]?></td>
							<td style="width:40px;" <?php if($TPL_V2["select_no"]==2){?> style="background:#FFE08C;"<?php }?>><?php echo $TPL_V2["away_rate"]?></td>
							<td><?php echo $TPL_V2["home_score"]?>:<?php echo $TPL_V2["away_score"]?></td>
							<td>
<?php if($TPL_V2["win"]==1){?> 홈승
<?php }elseif($TPL_V2["win"]==2){?> 원정승
<?php }elseif($TPL_V2["win"]==3){?> 무승부
<?php }elseif($TPL_V2["win"]==4){?> 취소/적특
<?php }else{?> &nbsp;
<?php }?>
							</td>
						</tr>
<?php }}?>
					</tbody>
						<tfoot>
							<tr>
								<td colspan="11">
									배팅번호 :<span><b><?php echo $TPL_V1["betting_no"]?></b></span>&nbsp;&nbsp;//&nbsp;&nbsp;구매일시 :<span><?php echo $TPL_V1["bet_date"]?></span>&nbsp;&nbsp;//&nbsp;&nbsp;배팅금액 :<span><?php echo number_format($TPL_V1["betting_money"])?></span>&nbsp;&nbsp;//&nbsp;&nbsp;배당률 :<span><?php echo $TPL_V1["result_rate"]?></span>&nbsp;&nbsp;//&nbsp;&nbsp;
									예상금액 :<span><b><?php echo number_format($TPL_V1["win_money"])?>원</b></span>&nbsp;&nbsp;//&nbsp;&nbsp;결과 : <?php if($TPL_V1["result"]==0){?>진행중<?php }elseif($TPL_V1["result"]==2){?>낙첨<?php echo $TPL_V1["result"]==4?>취소<?php }else{?>당첨<?php }?>
								</td>
							</tr>
						</tfoot>
					</table>
<?php }}?>
<?php }?>					
					
			<!-- 배팅 리스트 End -->
			
			<!-- 배팅 리스트 Begin -->
			<!--
<?php if(count((array)$TPL_VAR["bettingItem"])){?>
					<table cellspacing="1" class="tableStyle_gameList">		  		
						<thead>
							<tr>
								<td>경기시간</td>
								<td>타입</td>
								<td>리그</td>
								<td>홈(승)</td>
								<td>VS(무)</td>
								<td>원정(패)</td>
								<td>스코어</td>
								<td>상태</td>
							</tr>
						</thead>
						<tbody>
<?php if($TPL_bettingItem_1){foreach($TPL_VAR["bettingItem"] as $TPL_K1=>$TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count((array)$TPL_V1["item"]);?>
<?php if($TPL_item_2){foreach($TPL_V1["item"] as $TPL_V2){?>
									<tr>
										<td><?php echo sprintf("%s/%s %s:%s",substr($TPL_V2["gameDate"],5,2),substr($TPL_V2["gameDate"],8,2),$TPL_V2["gameHour"],$TPL_V2["gameTime"])?></td>
										<td>
<?php if($TPL_V2["game_type"]==1){?>승패
<?php }elseif($TPL_V2["game_type"]==2){?>핸디캡
<?php }elseif($TPL_V2["game_type"]==3){?>스페셜
<?php }elseif($TPL_V2["game_type"]==4){?>멀티
<?php }?>
										</td>
										<td class="league">
											<?php echo $TPL_V2["league_name"]?>

										</td>
										<td <?php if($TPL_V2["select_no"]==1){?>style="border:1 solid #2d050b; background-color:#9FC93C;"<?php }?>><div class=""><span class="name"><?php echo $TPL_V2["home_team"]?></span><span class="rate"><?php echo $TPL_V2["home_rate"]?></span></div></td>
										<td <?php if($TPL_V2["select_no"]==3){?>style="border:1 solid #2d050b; background-color:#9FC93C;"<?php }?>><div class=""><span class="rate"><?php if($TPL_V2["game_type"]==1){?><?php echo $TPL_V1["draw_rate"]?><?php }else{?>(<?php echo $TPL_V2["draw_rate"]?>)<?php }?></span></div></td>
										<td <?php if($TPL_V2["select_no"]==2){?>style="border:1 solid #2d050b; background-color:#9FC93C;"<?php }?>><div class=""><span class="name"><?php echo $TPL_V2["away_team"]?></span><span class="rate"><?php echo $TPL_V2["away_rate"]?></span></div></td>
										<td>[ <?php echo $TPL_V1["home_score"]?>:<?php echo $TPL_V1["away_score"]?> ]</td>
										<td>
<?php if($TPL_V2["result"]==0){?>진행중
<?php }elseif($TPL_V2["result"]==1){?>당첨
<?php }elseif($TPL_V2["result"]==2){?>낙첨
<?php }elseif($TPL_V2["result"]==4){?>취소
<?php }?>
										</td>
									</tr>
<?php }}?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="8">
									배팅번호 :<span><b><?php echo $TPL_K1?></b></span>구매일시 :<span><?php echo $TPL_V1["regdate"]?></span>선택경기 :<span><?php echo $TPL_V1["betting_cnt"]?></span>배팅금액 :<span><?php echo number_format($TPL_V1["betting_money"])?></span>배당률 :<span><?php echo $TPL_V1["result_rate"]?></span>
								</td>
							</tr>
							<tr>
								<td colspan="8" class="info">
									<p>예상금액 :<span><b><?php echo number_format($TPL_V1["win_money"])?>원</b> (+<?php echo $TPL_V1["bonus_rate"]?>% <?php echo number_format($TPL_V1["folder_bonus"])?>포인트)</span>
										결과 : <?php if($TPL_V1["result"]==0){?>진행중<?php }elseif($TPL_V1["result"]==2){?><font color='red'>낙첨</font><?php }elseif($TPL_V1["result"]==4){?>취소<?php }else{?><font color='blue'>당첨</font><?php }?>
									</p>
											
								</td>
							</tr>
						</tfoot>
<?php }}?>
					</table>
<?php }?>
			-->
			<!-- 배팅 리스트 End -->
	
							
<?php if(count((array)$TPL_VAR["array_game"])){?>		  		
		  	<table cellspacing="1" class="tableStyle_gameList">		  		
		  		<input type="hidden" name="cart" value="add">				
		  		<input type="hidden" name="bet_date" value="<?php echo $TPL_VAR["bet_date"]?>">				
		  		<input type="hidden" name="bet_money" value="<?php echo $TPL_VAR["bet_money"]?>">				
		  			&nbsp;&nbsp;구매일시:&nbsp; <?php echo $TPL_VAR["bet_date"]?>

						&nbsp;&nbsp;배팅금액:&nbsp;	<?php echo number_format($TPL_VAR["bet_money"])?>원						
		  		<thead>
	    		<tr>     	      
		      	<th>No</th>
						<th>경기일시</th>
						<th>대분류</th>
						<th>종류</th>
						<th>종목</th>
						<th>리그</th>
						<th colspan="2">승(홈팀)</th>
						<th>무</th>
						<th colspan="2">패(원정팀)</th>
						<th>스코어</th>
						<th>이긴 팀</th>					
		    		</tr>	    		
	 				</thead>
	 				<tbody>
<?php if($TPL_array_game_1){foreach($TPL_VAR["array_game"] as $TPL_V1){?>
	 						<input type="hidden" name="child_sn[<?php echo $TPL_V1["child_sn"]?>]" value="<?php echo $TPL_V1["select_no"]?>">				
	 						<tr>
	 							<td><font color='blue'> <?php echo $TPL_V1["child_sn"]?></font></td>
	 							<td><?php echo sprintf("%s %s:%s",substr($TPL_V1["gameDate"],5),$TPL_V1["gameHour"],$TPL_V1["gameTime"])?></td>
	 							<td>
<?php if($TPL_V1["special"]==0){?>일반
<?php }elseif($TPL_V1["special"]==1){?>실시간
<?php }elseif($TPL_V1["special"]==2){?>멀티
<?php }elseif($TPL_V1["special"]==3){?>고액
<?php }elseif($TPL_V1["special"]==4){?>이벤트
<?php }?>
								</td>
								<td>
<?php if($TPL_V1["type"]==1){?><span class="victory">승무패</span>
<?php }elseif($TPL_V1["type"]==2){?><span class="handicap">핸디캡</span>
<?php }elseif($TPL_V1["type"]==4){?><span class="underover">언더오버</span>
<?php }?>
								</td>
								<td><?php echo $TPL_V1["sport_name"]?></td>
								<td><?php echo $TPL_V1["league_name"]?></td>
								<td><?php if($TPL_V1["select_no"]==1){?><font color='red'><?php echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")?></font><?php }else{?><?php echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")?><?php }?></td>
								<td><?php echo $TPL_V1["home_rate"]?></td>
								<td><?php if($TPL_V1["select_no"]==2){?><font color='red'><?php echo $TPL_V1["draw_rate"]?></font><?php }else{?><?php echo $TPL_V1["draw_rate"]?><?php }?></td>
								<td><?php if($TPL_V1["select_no"]==3){?><font color='red'><?php echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")?></font><?php }else{?><?php echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")?><?php }?></td>
								<td><?php echo $TPL_V1["away_rate"]?></td>
								<td><?php echo $TPL_V1["home_score"]?>:<?php echo $TPL_V1["away_score"]?></td>
								<td>
<?php if($TPL_V1["win"]==1){?> 홈승
<?php }elseif($TPL_V1["win"]==2){?> 원정승
<?php }elseif($TPL_V1["win"]==3){?> 무승부
<?php }elseif($TPL_V1["win"]==4){?> 취소/적특
<?php }else{?> &nbsp;
<?php }?>
								</td>
	 						</tr>
<?php }}?>
	 				</tbody>	
		  	</table>
<?php }?>	
		  	
			<th>내용</th>
			<td>
			<textarea id="on" name="content" cols="80" rows="4" onmouseover="this.focus()">
				<?php echo str_replace("/upload/images/",$TPL_VAR["UPLOAD_URL"],$TPL_VAR["list"]["content"])?>

			</textarea>
			<script>       
				KE.show({   id 			: "on", 
							width 		: "650px",
							height 		: "350px",
							filterMode 	: true,
							resizeMode 	: 1 ,
							items 		: [
											'source','|','fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold', 'italic', 'underline',
											'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
											'insertunorderedlist', '|',  'image', 'link','advtable']
			   			});
			</script>
			</td>
		  </tr>
		</table>
		<div id="wrap_btn">
	      <input type="button" name="ok" value="등  록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="Form_ok()"/>
	      <input type="reset" name="Submit2" value="초기화" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'"/></td>
	      <input type="button" name="excel_upload" value="엑셀업로드" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="jsvascript:excelUpload('<?php echo $TPL_VAR["id"]?>');"/>
	      <!--
<?php if(empty($TPL_VAR["id"])){?>
	      	<input type="button" name="betting" value="배팅내역첨부" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="javascript:open_window('/board/popup_betting',1024,600)" />
<?php }?>
	      -->
	    </div>
	</form>
	
	<form name="reply" action="?act=reply" method="post">
		<input type="hidden" name="replyid" value="<?php echo $TPL_VAR["id"]?>">
		<table cellspacing="1" class="tableStyle_comment" summary="댓글 쓰기">
			<legend class="blind">댓글 쓰기</legend>
			<tr>
				<th style="width:255px;">
					<input id="reply_author" name="reply_author" type="text" class="name" value="관리자" onblur="ajaxReplyNickRequest();" />
					<select id="selectReplyNick" onChange="selecteReplyNick(this.value);">
						<option value="">::: 닉네임 선택 :::</option>
<?php
	for ( $i = 0 ; $i < count((array)$TPL_VAR["nickList"]) ; $i++ ) {
		echo "<option value='".$TPL_VAR["nickList"][$i]["nick"]."|".$TPL_VAR["nickList"][$i]["mem_lev"]."'  ".$selected.">".$TPL_VAR["nickList"][$i]["nick"]." (".$TPL_VAR["nickList"][$i]["mem_lev"].")</option>";
	}
?>
						<option value='히릿|2'>히릿</option>
						<option value='휘발류|2'>휘발류</option>
						<option value='훌라|2'>훌라</option>
						<option value='후라이드|2'>후라이드</option>
						<option value='홍합|2'>홍합</option>
						<option value='홍삼왕|2'>홍삼왕</option>
						<option value='홀짝베팅건승|2'>홀짝베팅건승</option>
						<option value='홀삼짝|2'>홀삼짝</option>
						<option value='호통령|2'>호통령</option>
						<option value='호날두|2'>호날두</option>
						<option value='호구너구리|2'>호구너구리</option>
						<option value='현금|2'>현금</option>
						<option value='헐크다람쥐|2'>헐크다람쥐</option>
						<option value='핸디|2'>핸디</option>
						<option value='해중님|2'>해중님</option>
						<option value='할매|2'>할매</option>
						<option value='한아름|2'>한아름</option>
						<option value='한수|2'>한수</option>
						<option value='한번만주세요|2'>한번만주세요</option>
						<option value='한글|2'>한글</option>
						<option value='학다리|2'>학다리</option>
						<option value='하이트|2'>하이트</option>
						<option value='하이염|2'>하이염</option>
						<option value='하음사랑|2'>하음사랑</option>
						<option value='하삼관|2'>하삼관</option>
						<option value='필립코쿠|2'>필립코쿠</option>
						<option value='피자|2'>피자</option>
						<option value='풍생토쟁이|2'>풍생토쟁이</option>
						<option value='퐈닝퐈니|2'>퐈닝퐈니</option>
						<option value='포카리|2'>포카리</option>
						<option value='포레스|2'>포레스</option>
						<option value='평창수|2'>평창수</option>
						<option value='퍼니잭|2'>퍼니잭</option>
						<option value='패가망신|2'>패가망신</option>
						<option value='파랑색|2'>파랑색</option>
						<option value='특별보스|2'>특별보스</option>
						<option value='트라|2'>트라</option>
						<option value='톰과제리|2'>톰과제리</option>
						<option value='토토왕김용만|2'>토토왕김용만</option>
						<option value='토토왕|2'>토토왕</option>
						<option value='토토완자|2'>토토완자</option>
						<option value='토창|2'>토창</option>
						<option value='토신이되쟈|2'>토신이되쟈</option>
						<option value='토성님님|2'>토성님님</option>
						<option value='토사장밥줄|2'>토사장밥줄</option>
						<option value='토나오네|2'>토나오네</option>
						<option value='털보|2'>털보</option>
						<option value='타토|2'>타토</option>
						<option value='타짜|2'>타짜</option>
						<option value='킼킼킼|2'>킼킼킼</option>
						<option value='큰손|2'>큰손</option>
						<option value='코코넛|2'>코코넛</option>
						<option value='코스튜움|2'>코스튜움</option>
						<option value='코보리아|2'>코보리아</option>
						<option value='코다리|2'>코다리</option>
						<option value='코난|2'>코난</option>
						<option value='코끼리뒷차기|2'>코끼리뒷차기</option>
						<option value='캡틴|2'>캡틴</option>
						<option value='캄포마|2'>캄포마</option>
						<option value='카네기|2'>카네기</option>
						<option value='친개입니다|2'>친개입니다</option>
						<option value='촉왕용|2'>촉왕용</option>
						<option value='초원|2'>초원</option>
						<option value='청보리|2'>청보리</option>
						<option value='첨단그녀석|2'>첨단그녀석</option>
						<option value='철희지인|2'>철희지인</option>
						<option value='천지인|2'>천지인</option>
						<option value='차사장|2'>차사장</option>
						<option value='찌루|2'>찌루</option>
						<option value='짱짱각짱짱|2'>짱짱각짱짱</option>
						<option value='짝대기|2'>짝대기</option>
						<option value='짜장형님|2'>짜장형님</option>
						<option value='집어등|2'>집어등</option>
						<option value='질러킴|2'>질러킴</option>
						<option value='진구|2'>진구</option>
						<option value='지온아빠|2'>지온아빠</option>
						<option value='줸장옆차기|2'>줸장옆차기</option>
						<option value='주한이|2'>주한이</option>
						<option value='좌사홀|2'>좌사홀</option>
						<option value='좌박꼼|2'>좌박꼼</option>
						<option value='종달새|2'>종달새</option>
						<option value='종규끼|2'>종규끼</option>
						<option value='종규사마|2'>종규사마</option>
						<option value='조르지마|2'>조르지마</option>
						<option value='젠터리|2'>젠터리</option>
						<option value='제발돈따자|2'>제발돈따자</option>
						<option value='제리|2'>제리</option>
						<option value='제로문|2'>제로문</option>
						<option value='정의의마귀|2'>정의의마귀</option>
						<option value='전주고니|2'>전주고니</option>
						<option value='적중왕|2'>적중왕</option>
						<option value='잠지|2'>잠지</option>
						<option value='잘해보자|2'>잘해보자</option>
						<option value='임페리얼|2'>임페리얼</option>
						<option value='일억환전|2'>일억환전</option>
						<option value='일수대출|2'>일수대출</option>
						<option value='이르마니|2'>이르마니</option>
						<option value='이도사|2'>이도사</option>
						<option value='음메|2'>음메</option>
						<option value='은재야부자되자|2'>은재야부자되자</option>
						<option value='유경|2'>유경</option>
						<option value='월드컵파|2'>월드컵파</option>
						<option value='원동만수|2'>원동만수</option>
						<option value='워니|2'>워니</option>
						<option value='웅담이|2'>웅담이</option>
						<option value='울산히어로|2'>울산히어로</option>
						<option value='우지니|2'>우지니</option>
						<option value='우정오프로|2'>우정오프로</option>
						<option value='우롱|2'>우롱</option>
						<option value='요거트|2'>요거트</option>
						<option value='와우|2'>와우</option>
						<option value='옹시루|2'>옹시루</option>
						<option value='올투바|2'>올투바</option>
						<option value='올쌈바|2'>올쌈바</option>
						<option value='오서방|2'>오서방</option>
						<option value='영혼촉|2'>영혼촉</option>
						<option value='연승|2'>연승</option>
						<option value='연면|2'>연면</option>
						<option value='역삼동|2'>역삼동</option>
						<option value='역배전문가|2'>역배전문가</option>
						<option value='여행가자|2'>여행가자</option>
						<option value='엠똥광|2'>엠똥광</option>
						<option value='엘레강스|2'>엘레강스</option>
						<option value='에헤라|2'>에헤라</option>
						<option value='에이비씨|2'>에이비씨</option>
						<option value='에버다임|2'>에버다임</option>
						<option value='엄마귀|2'>엄마귀</option>
						<option value='어린왕자|2'>어린왕자</option>
						<option value='애니콜|2'>애니콜</option>
						<option value='안졸리나졸라|2'>안졸리나졸라</option>
						<option value='안양구|2'>안양구</option>
						<option value='아이린|2'>아이린</option>
						<option value='아르르르르|2'>아르르르르</option>
						<option value='아롱이|2'>아롱이</option>
						<option value='아롤존잘|2'>아롤존잘</option>
						<option value='아따|2'>아따</option>
						<option value='아니요|2'>아니요</option>
						<option value='쏘랭이|2'>쏘랭이</option>
						<option value='실리콘|2'>실리콘</option>
						<option value='신태공|2'>신태공</option>
						<option value='신천호|2'>신천호</option>
						<option value='신의한수|2'>신의한수</option>
						<option value='시빈|2'>시빈</option>
						<option value='시골아이|2'>시골아이</option>
						<option value='스포츠만|2'>스포츠만</option>
						<option value='스포츠|2'>스포츠</option>
						<option value='스카이|2'>스카이</option>
						<option value='스딸벅스|2'>스딸벅스</option>
						<option value='스나이퍼|2'>스나이퍼</option>
						<option value='수탱이|2'>수탱이</option>
						<option value='쇼바님|2'>쇼바님</option>
						<option value='송아지|2'>송아지</option>
						<option value='송사리|2'>송사리</option>
						<option value='속담|2'>속담</option>
						<option value='소림사|2'>소림사</option>
						<option value='소라|2'>소라</option>
						<option value='세윤이|2'>세윤이</option>
						<option value='서우담배일진|2'>서우담배일진</option>
						<option value='서빈|2'>서빈</option>
						<option value='샤댤왕|2'>샤댤왕</option>
						<option value='샤끄투|2'>샤끄투</option>
						<option value='상무지구|2'>상무지구</option>
						<option value='상모동인간|2'>상모동인간</option>
						<option value='삼성동고니|2'>삼성동고니</option>
						<option value='사신|2'>사신</option>
						<option value='사랑이아빠|2'>사랑이아빠</option>
						<option value='사다리짱|2'>사다리짱</option>
						<option value='삥그르|2'>삥그르</option>
						<option value='뿌꾸뿌꾸|2'>뿌꾸뿌꾸</option>
						<option value='뽕따|2'>뽕따</option>
						<option value='빵떡|2'>빵떡</option>
						<option value='빤츠|2'>빤츠</option>
						<option value='비행기|2'>비행기</option>
						<option value='비수입니당|2'>비수입니당</option>
						<option value='비꾸치이|2'>비꾸치이</option>
						<option value='비꾸치|2'>비꾸치</option>
						<option value='블루가인|2'>블루가인</option>
						<option value='분석가토쟁이|2'>분석가토쟁이</option>
						<option value='부시맨|2'>부시맨</option>
						<option value='봉자느님|2'>봉자느님</option>
						<option value='봉겜방|2'>봉겜방</option>
						<option value='보햄|2'>보햄</option>
						<option value='보스|2'>보스</option>
						<option value='보빨달인|2'>보빨달인</option>
						<option value='보라돌이|2'>보라돌이</option>
						<option value='보들들|2'>보들들</option>
						<option value='별처럼|2'>별처럼</option>
						<option value='벤틀리|2'>벤틀리</option>
						<option value='베늄|2'>베늄</option>
						<option value='벅구다|2'>벅구다</option>
						<option value='백호|2'>백호</option>
						<option value='백기리|2'>백기리</option>
						<option value='백구|2'>백구</option>
						<option value='배팅의꽃|2'>배팅의꽃</option>
						<option value='밤에황재|2'>밤에황재</option>
						<option value='반응나니|2'>반응나니</option>
						<option value='박정수르|2'>박정수르</option>
						<option value='박순대나잇|2'>박순대나잇</option>
						<option value='박솰낸다|2'>박솰낸다</option>
						<option value='박도끼|2'>박도끼</option>
						<option value='바람머리|2'>바람머리</option>
						<option value='바람난작살|2'>바람난작살</option>
						<option value='바두기카페|2'>바두기카페</option>
						<option value='미친분|2'>미친분</option>
						<option value='미찌|2'>미찌</option>
						<option value='미안해요돈따서|2'>미안해요돈따서</option>
						<option value='뭣이중헌디|2'>뭣이중헌디</option>
						<option value='뭉치|2'>뭉치</option>
						<option value='묵자묵자|2'>묵자묵자</option>
						<option value='몽블랑짱|2'>몽블랑짱</option>
						<option value='목뒤에살모사|2'>목뒤에살모사</option>
						<option value='모아니면도|2'>모아니면도</option>
						<option value='모란봉|2'>모란봉</option>
						<option value='메가점프|2'>메가점프</option>
						<option value='멍게형님|2'>멍게형님</option>
						<option value='먹보|2'>먹보</option>
						<option value='매날올잉|2'>매날올잉</option>
						<option value='마이호레스|2'>마이호레스</option>
						<option value='마스터이|2'>마스터이</option>
						<option value='마슈슈슈슈소|2'>마슈슈슈슈소</option>
						<option value='마로|2'>마로</option>
						<option value='마귀탄|2'>마귀탄</option>
						<option value='리키|2'>리키</option>
						<option value='라일락|2'>라일락</option>
						<option value='라이브황제|2'>라이브황제</option>
						<option value='라이라이|2'>라이라이</option>
						<option value='라라라|2'>라라라</option>
						<option value='라기레아|2'>라기레아</option>
						<option value='떳다빅보스|2'>떳다빅보스</option>
						<option value='따자짱|2'>따자짱</option>
						<option value='딜려|2'>딜려</option>
						<option value='돼지|2'>돼지</option>
						<option value='동빵이다|2'>동빵이다</option>
						<option value='동빵이|2'>동빵이</option>
						<option value='돈폭탄|2'>돈폭탄</option>
						<option value='돈좀따보자|2'>돈좀따보자</option>
						<option value='독산동타자|2'>독산동타자</option>
						<option value='도미노|2'>도미노</option>
						<option value='대구리|2'>대구리</option>
						<option value='담양오리|2'>담양오리</option>
						<option value='담양닭|2'>담양닭</option>
						<option value='단결|2'>단결</option>
						<option value='닥치고한폴낙|2'>닥치고한폴낙</option>
						<option value='다박다박|2'>다박다박</option>
						<option value='다따가뿌자|2'>다따가뿌자</option>
						<option value='니끼미|2'>니끼미</option>
						<option value='눕혀보니스님|2'>눕혀보니스님</option>
						<option value='노원거지|2'>노원거지</option>
						<option value='노밤|2'>노밤</option>
						<option value='내가호구다|2'>내가호구다</option>
						<option value='낭낭|2'>낭낭</option>
						<option value='남자이야기|2'>남자이야기</option>
						<option value='난다리요|2'>난다리요</option>
						<option value='나즈막히|2'>나즈막히</option>
						<option value='나비|2'>나비</option>
						<option value='나드리|2'>나드리</option>
						<option value='꿀빅용|2'>꿀빅용</option>
						<option value='꼬마둥이|2'>꼬마둥이</option>
						<option value='깐똣|2'>깐똣</option>
						<option value='까만콩콩|2'>까만콩콩</option>
						<option value='김찬기|2'>김찬기</option>
						<option value='김연아|2'>김연아</option>
						<option value='김사장|2'>김사장</option>
						<option value='김사달ㅋ|2'>김사달ㅋ</option>
						<option value='김날두|2'>김날두</option>
						<option value='김구라다|2'>김구라다</option>
						<option value='기아|2'>기아</option>
						<option value='기브미어원달러|2'>기브미어원달러</option>
						<option value='급행열차|2'>급행열차</option>
						<option value='그들만의리그|2'>그들만의리그</option>
						<option value='규니님|2'>규니님</option>
						<option value='군산일자리|2'>군산일자리</option>
						<option value='국밥도베터닷|2'>국밥도베터닷</option>
						<option value='구스트롱|2'>구스트롱</option>
						<option value='구라짱|2'>구라짱</option>
						<option value='구땡|2'>구땡</option>
						<option value='관세음보살|2'>관세음보살</option>
						<option value='곰동이|2'>곰동이</option>
						<option value='골프맨|2'>골프맨</option>
						<option value='건승기원|2'>건승기원</option>
						<option value='건승|2'>건승</option>
						<option value='거리조준|2'>거리조준</option>
						<option value='갠민|2'>갠민</option>
						<option value='개팔이|2'>개팔이</option>
						<option value='개안체|2'>개안체</option>
						<option value='강프로님|2'>강프로님</option>
						<option value='강태공|2'>강태공</option>
						<option value='강남의전설|2'>강남의전설</option>
						<option value='감자깡|2'>감자깡</option>
						<option value='감감감|2'>감감감</option>
						<option value='가자미|2'>가자미</option>
						<option value='가라가|2'>가라가</option>
						<option value='사쿠라짱|2'>사쿠라짱</option>
						<option value='나오미|2'>나오미</option>
						<option value='붕가붕가|2'>붕가붕가</option>
						<option value='초록이|2'>초록이</option>
						<option value='캔스톤|2'>캔스톤</option>
						<option value='아이폰빠|2'>아이폰빠</option>
						<option value='초콜릿중독|2'>초콜릿중독</option>
						<option value='듀오덤|2'>듀오덤</option>
					</select>
				</th>
				<td><textarea  name="comment" class="comment" style="width:480px;"></textarea></td>
				<td class="btn"><input type="button" name="ok" value="답변" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="check_reply()" style="margin-right:8px;"></td>
			</tr>
		</table>
	</form>
	<span id="reply_nick_check_message"></span>
	
<?php if(isset($TPL_VAR["id"])){?>
<?php if($TPL_replyList_1){foreach($TPL_VAR["replyList"] as $TPL_V1){?>
			<table cellspacing="1" class="tableStyle_comment" summary="댓글 목록">
				<legend class="blind">댓글 목록</legend>
				<tr>
					<th>
<?php if($TPL_V1["mem_id"]=="관리자 리플"){?>
							<font color='red'><?php echo $TPL_V1["mem_nick"]?></font>
<?php }else{?>
							<?php echo $TPL_V1["mem_nick"]?>

<?php }?>
						
					</th>
					<td><textarea cols="60" rows="2" id='<?php echo $TPL_V1["idx"]?>_content' class="replyContents" <?php if($TPL_V1["mem_id"]!="관리자 리플"){?> readonly <?php }?>><?php echo $TPL_V1["content"]?></textarea></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
					<td>
						<a href="javascript:goModify( <?php echo $TPL_V1["idx"]?>, <?php echo $TPL_VAR["id"]?> );void(0);">[수정]</a>
						<a href="javascript:goDel( <?php echo $TPL_V1["idx"]?>, <?php echo $TPL_VAR["id"]?> );void(0);">[삭제]</a>
					</td>
				</tr>
			</table>
<?php }}?>
<?php }?>
</div>

<script>
	function selecteNick(val) {
		var nickInfo = val.split("|");
		$("#author").val(nickInfo[0]);
		$("#lvl").val(nickInfo[1]);
	}
	function selecteReplyNick(val) {
		var nickInfo = val.split("|");
		$("#reply_author").val(nickInfo[0]);
	}
</script>