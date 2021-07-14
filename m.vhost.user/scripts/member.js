function moneyFormat(str)
{
	var re="";
	str = str + "";
	str=str.replace(/-/gi,"");
	str=str.replace(/ /gi,"");
	
	str2=str.replace(/-/gi,"");
	str2=str2.replace(/,/gi,"");
	str2=str2.replace(/\./gi,"");	
	
	if(isNaN(str2) && str!="-") return "";
	try
	{
		for(var i=0;i<str2.length;i++)
		{
			var c = str2.substring(str2.length-1-i,str2.length-i);
			re = c + re;
			if(i%3==2 && i<str2.length-1) re = "," + re;
		}
		
	}catch(e)
	{
		re="";
	}
	
	if(str.indexOf("-")==0)
	{
		re = "-" + re;
	}
	
	return re;

}

function stringSplit(strData, strIndex)
{ 
	var stringList = new Array(); 
 	while(strData.indexOf(strIndex) != -1)
 	{
  		stringList[stringList.length] = strData.substring(0, strData.indexOf(strIndex)); 
  		strData = strData.substring(strData.indexOf(strIndex)+(strIndex.length), strData.length); 
 	} 
 	stringList[stringList.length] = strData; 
 	return stringList; 
}

//
// Call Functions
//

function mileage2Cash()
{
	amount = parseInt($('.member_mileage').text().replace(/^\$|,/g, ""));
	if(amount == 0)
	{
		alert('포인트가 없습니다.');
		return;
	}
	
	if(!confirm('마일리지를 캐쉬로 전환하시겠습니까?'))
	{
		return;
	}
	
	var param={mode:"toCash"};
	$.post("/member/toCashProcess", param, onMileage2Cash, "json");
	
	alert('포인트 전환이 완료되었습니다.');
	top.location.reload();
}

function listupMileageList($mileageType)
{
	var param={mode:"mileageList", mileageType:$mileageType, page:page, page_size:page_size};
	$.post("../ajax/ajax_member.php?", param, onListupMileage, "json");
}

//
// Event Functions
//

function pageUp()
{
}

function pageDown()
{
}

function onMileage2Cash(jsonText)
{
	newCash = jsonText['g_money'];
	newMileage = jsonText['point'];
	
	newCash = moneyFormat(newCash);
		
	$("#member_cash").text(moneyFormat(newCash));
  $(".member_mileage").text(moneyFormat(newMileage));
	
    return true;
}