
/*
function open_window(url,width,height)
{
	var winl = (screen.width - width)  / 2;
 	var wint = (screen.height - height) / 2;

	window.open(url,'','scrollbars=yes,width='+width+',height='+height+',top='+wint+',left='+winl+');
}
*/

function open_window(url,w,h) 
{
	var winl = (screen.width - w) / 2;
	var wint = (screen.height - h) / 2;
	winprops = 'width='+w+',height='+h+',top='+wint+',left='+winl+',resizable=no,scrollbars=yes,toolbars=no,status=no,menu=no';
	win = window.open(url, "", winprops)
}

function FormatNumber(num)
{
			num=new String(num)
			num=num.replace(/,/gi,"")
			return FormatNumber_r(num)
}

function FormatNumber_r(num)
{
	fl=""
	if(isNaN(num)) { alert("문자는 사용할 수 없습니다.");return 0}
	if(num==0) return num
	
	if(num<0){ 
			num=num*(-1)
			fl="-"
	}else{
			num=num*1 //처음 입력값이 0부터 시작할때 이것을 제거한다.
	}
	num = new String(num)
	temp=""
	co=3
	num_len=num.length
	while (num_len>0){
			num_len=num_len-co
			if(num_len<0){co=num_len+co;num_len=0}
			temp=","+num.substr(num_len,co)+temp
	}
	return fl+temp.substr(1)
}

function comfire_ok(idx,url)
{
	falg=window.confirm("정말로 실행 하시겠습니까?"); 
	if(falg)
	{
		location.href=url+idx;
	}
}
	
function isChm()
{
	var xxx=0;
	for (i=0;i<document.all.length;i++) 
	{
		if (document.all[i].name=="y_id[]")
		{
			if(document.all[i].checked==true)
			{
				xxx++;
			}
		}
	}
	if(xxx==0)
	{
		alert("실행할 내용을 선택하십시오.");
		return false;
	}else
	{
		falg=window.confirm("정말로 실행 하시겠습니까?"); 
		if(falg)
		{
			document.form1.submit();
		}
	}
}

function userStatusChange(action_type)
{	
	if(action_type=="stop") 	{$('#act').val('stop');}
	else if(action_type=="bad")	{$('#act').val('bad');}
	else if(action_type=="delete")	{$('#act').val('delete');}
	
	var xxx=0;
	for (i=0;i<document.all.length;i++) 
	{
		if (document.all[i].name=="y_id[]")
		{
			//document.all[i].checked=chk;
			//chkRow(document.all[i]);
			if(document.all[i].checked==true)
			{
				xxx++;
			}
		}
	}
	if(xxx==0)
	{
		alert("실행할 내용을 선택하십시오.");
		return false;
	}else
	{
		falg=window.confirm("정말로 실행 하시겠습니까?"); 
		if(falg)
		{
			//location.href="user_loginlist.php?act=deleteone&idx="+idx;
			document.form1.submit();
		}
	}
}