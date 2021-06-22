
function listupBookMark()
{
	$.ajaxSetup({async:false});
	var param={mode:"list"};
	
	$.post("/favorite/list?", param, onListupBookMark, "json");
}

function insertBookMark($cate_idx, $nation_idx, $league_idx)
{
	cateIdx 	= parseInt($cate_idx);
	nationIdx 	= ($nation_idx!="")?parseInt($nation_idx):0;
	leagueIdx 	= ($league_idx!="")?parseInt($league_idx):0;
	
	var param={mode:"insert", cateIdx:cateIdx, nationIdx:nationIdx, leagueIdx:leagueIdx};
	
	$.post("/favorite/add?", param, onInsertBookMark);
}

function deleteBookMark($idx)
{
	idx 	= parseInt($idx);

	var param={mode:"delete", idx:idx};
	$.post("/favorite/del?", param, onDeleteBookMark);
}

function onInsertBookMark(strText)
{
	if(strText == "true")
    {
    	alert("즐겨찾기에 추가되었습니다.");
    	listupBookMark();
		return true;
    }
    else if(strText == "false")
    {
    	alert("죄송합니다. 처리중 에러가 발생하였습니다.");
		return true;
    }
}

function onDeleteBookMark(strText)
{
	if(strText == "true")
    {
    	alert("즐겨찾기에서 제거되었습니다.");
    	listupBookMark();
		return true;
    }
    else if(strText == "false")
    {
    	alert("죄송합니다. 처리중 에러가 발생하였습니다.");
		return true;
    }
}

function onListupBookMark(jsonText)
{
    var innerHTML ="";
    
    if(jsonText.length<=0)
    {
    	innerHTML="<li><a href='#' class='fav' title='삭제'><span>★</span></a><a href='/?cateIdx=1' class='game'>축구</a></li>";
    	innerHTML=innerHTML+"<li><a href='#' class='fav' title='삭제'><span>★</span></a><a href='/?cateIdx=2' class='game'>야구</a></li>";
    }
    else
    {
    	for(i=0; i<jsonText.length; ++i)
    	{
    		//0=idx|1=cate_idx|2=nation_idx|3=league_idx|4=cate_name|5=nation_name|6=league_name|
    				
    		var data = jsonText[i];
    				
    			link 	= "cateIdx="+data.cate_idx;
				content	= data.cate_name;
				title 	= data.cate_name;
				
				if(data.nation_name!="" && data.nation_name!=0)
				{
					title=title+":"+data.nation_name;
					content=data.nation_name;
				}
				if(data.league_name!="" && data.league_name!=0)
				{
					link = link+"&leagueIdx="+data.league_idx;
					content=data.league_name;
					title=title+":"+data.league_name;
				}
				innerHTML = innerHTML+"<li><a href='javascript:deleteBookMark("+data.idx+");' class='fav' title='제거'><span>X</span></a><a href=/category?"+link+" class='game' title='"+title+"'>"+content+"</a></li>";
	   	}
    }
   
    if($('#favorite_list').length>0)
    {
    	$('#favorite_list').html(innerHTML);
    }
    
   	return true;
}