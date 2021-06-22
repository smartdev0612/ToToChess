var xmlHttp;
var page=1;
var page_size=5;
var total=0;

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
	var param={page:0, page_size:7};
	$.post("/recent/list?", param, onListupRecentGame, "json");
}

function onListupRecentGame(jsonText)
{
	if(jsonText==null || jsonText.length<=0)
		return true;
   
  	objTable = document.getElementById('recent_table');
  
  	if(objTable!=null)
  	{
  		for(i=0; i<jsonText.length; ++i)
  		{
  			var data = jsonText[i];
	  		var objRow = objTable.insertRow();
	  	
		  	var cell_1 = objRow.insertCell(0);
			var cell_2 = objRow.insertCell(1);
			var cell_3 = objRow.insertCell(2);
			var cell_4 = objRow.insertCell(3);
			var cell_5 = objRow.insertCell(4);
			
			//{? (item.type==1 && item.draw_rate=="1.00")||(item.type==2 && item.draw_rate=="0")}
			
			var draw_rate = data.draw_rate;
			if(draw_rate==1) 
				draw_rate = "VS"; 
				
			cell_1.innerHTML = "<span class='date'>"+data.gameHour+":"+data.gameTime+"</span>";
			cell_2.innerHTML = "<p class='leagueTd'><img style='width:30px;height:20px;' src='http://kd-ss21a.com"+data.league_image+"'><span class='date'>"+data.name+"</span></p>";
			cell_3.innerHTML = "<div class='home'><span class='name'>"+data.home_team+"</span><span class='rate'>"+data.home_rate+"</span></div>";
			cell_4.innerHTML = "<div class='draw'><span class='rate'>"+draw_rate+"</span></div>";
			cell_5.innerHTML = "<div class='away'><span class='name'>"+data.away_team+"</span><span class='rate'>"+data.away_rate+"</span></div>";
		}
	}
	else
  	{
  		var objRow = objTable.insertRow();
		var cell_1 = objRow.insertCell(0);
		cell_1.innerHTML = "최근 마감된 경기가 없습니다.";
  	}
	return true;
}