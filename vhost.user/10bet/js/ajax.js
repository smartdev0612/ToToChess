var req=null;var req2=null;function create_request(){var request=null;try{request=new XMLHttpRequest();}catch(trymicrosoft){try{request=new ActiveXObject("Msxml12.XMLHTTP");}catch(othermicrosoft){try{request=new ActiveXObject("Microsoft.XMLHTTP");}catch(failed){request=null;}}}
if(request==null)
alert("Error creating request object!");else
return request;}
var trackback_url="";function trackback_send_server(url){req=create_request();trackback_url=url;req.onreadystatechange=function(){if(req.readyState==4){if(req.status==200){var token=req.responseText;prompt("아래 주소를 복사하세요. 이 주소는 스팸을 막기 위하여 한번만 사용 가능합니다.",trackback_url+"/"+token);trackback_url="";}}}
req.open("POST",g4_path+'/'+g4_bbs+'/'+'tb_token.php',true);req.send(null);}
function newArticleCheck(){$j.post(g4_path+"/ajax.newUpdateCheck.php",function(data){if(!data)return;var jsonData=$j.parseJSON(data);var total=0;var divToday=$j('#divToday');for(var i=0;i<jsonData.length;i++){var json=jsonData[i];var cnt=parseInt(json.read_count);$j(".alarm_"+json.wr_type).html("<font color=red><b>"+cnt+"</b></font>");var hide=json.is_hide;if(hide==0){total+=cnt;}
if(cnt>0){if(json.url!=null){ion.sound.play(json.url);}}}
if(total>0){divToday.show();}else{divToday.hide();}});}
function change_xpoint(url,xpoint)
{var params=null;if(xpoint==undefined||xpoint==null){}else{params="xpoint="+xpoint;}
req=create_request();req.onreadystatechange=function(){if(req.readyState==4){if(req.status==200){var returntext=req.responseText;tmpstr=returntext.split("||");if(tmpstr[0]=="E0001")alert("적립포인트가 부족하여 전환을 할수 없습니다. \n\n적립포인트는 "+tmpstr[1]+"점 단위로 전환이 가능합니다.");if(tmpstr[0]=="S0001")
{alert("포인트를 "+tmpstr[1]+" 전환하였습니다.");location.href=g4_path+""+url;}}}}
req.open("POST",g4_path+'/ajax.change_xpoint.php',true);req.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");req.setRequestHeader("Cache-Control","no-cache, must-revalidate");req.setRequestHeader("Pragma","no-cache");req.send(params);}
function server_list(game,idx)
{$j.get(g4_path+"/sports_league.ajax.php",{"ca_id":game},function(data){if(game.length==3)
{data="<option value=''>리그를 선택해주세요.</option>"+data;$j("#sel_league_"+idx).html(data);}
if(game.length==6)
{data="<option value=''>팀을 선택해주세요.</option>"+data;$j("#sel_team_"+idx+"_1").html(data);$j("#sel_team_"+idx+"_2").html(data);}});}
function get_legue_list(bn_url,idx,alpha)
{if(!$j("#sel_league1_"+idx).val())
{alert("종류를 선택해주세요");return false;}
if(alpha)
bn_url=$j("#sel_league1_"+idx).val();$j.get(g4_path+"/ajax.get_legue.php",{"bn_url":bn_url,"alpha":encodeURI(alpha)},function(data){$j("#sel_league_"+idx).html(data);});}
function get_team_list(legue_id,idx)
{$j.get(g4_path+"/ajax.get_team.php",{"legue_id":legue_id},function(data){$j("#auto_sel_team_"+idx+"_1").html(data);$j("#auto_sel_team_"+idx+"_2").html(data);});}