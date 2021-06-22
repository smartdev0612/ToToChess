var xmlHttp;
var page=1;
var page_size=5;
var total=0;

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

function pageup()
{
	if(page_size<=0) page_size=5;
	
	page=page+page_size;
	if(page>=total)
	{
		page=1;
	}
	listupRecentGame();
}

function pagedown()
{
	if(page_size<=0) page_size=5;

	page=page-page_size;
	if(page<=0)
	{
		page=1;
	}
	listupRecentGame();
}

function initializeRecentGame($total, $page_size)
{
	page = 1;
	page_size = $page_size;
	total = $total;
}

function listupRecentGame()
{
	$.ajaxSetup({async:false});
	var param={page:page};
	$.post("../ajax/ajax_recent_game.php?", param, onListupRecentGame, "json");
}

function onListupRecentGame(jsonText)
{
	var innerHTML ="";
	
	for(i=0; i<jsonText.dataList.length; ++i)
    {
    	//0=context|1=title|
    	var data = jsonText.dataList[i];
    	var len = data.context.length;
		if(len>=20)
		{
			innerHTML = innerHTML+"<li><a href='race/raceresult.php' title='"+data.title+"'> <marquee scrollamount='3'>"+data.context+"</marquee></a></li>";
		}
		else
		{
			innerHTML = innerHTML+"<li><a href='race/raceresult.php' title='"+data.title+"'> "+data.context+"</a></li>";
		}
	}
   
    if($('#recent_game_list').length>0)
    {
    	$('#recent_game_list').html(innerHTML);
    }
    
	return true;
}