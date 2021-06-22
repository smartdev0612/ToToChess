if(typeof(COMMON_JS)=='undefined'){var COMMON_JS=true;var errmsg="";var errfld;function check_field(fld,msg)
{if((fld.value=trim(fld.value))=="")
error_field(fld,msg);else
clear_field(fld);return;}
function error_field(fld,msg)
{if(msg!="")
errmsg+=msg+"\n";if(!errfld)errfld=fld;fld.style.background="#BDDEF7";}
function clear_field(fld)
{fld.style.background="#FFFFFF";}
function trim(s)
{var t="";var from_pos=to_pos=0;for(i=0;i<s.length;i++)
{if(s.charAt(i)==' ')
continue;else
{from_pos=i;break;}}
for(i=s.length;i>=0;i--)
{if(s.charAt(i-1)==' ')
continue;else
{to_pos=i;break;}}
t=s.substring(from_pos,to_pos);return t;}
function number_format(data)
{var tmp='';var number='';var cutlen=3;var comma=',';var i;len=data.length;mod=(len%cutlen);k=cutlen-mod;for(i=0;i<data.length;i++)
{number=number+data.charAt(i);if(i<data.length-1)
{k++;if((k%cutlen)==0)
{number=number+comma;k=0;}}}
return number;}
function popup_window(url,winname,opt)
{window.open(url,winname,opt);}
function original_chk(gid)
{url=g4_path+"/adm/popup_betoriginal.php?gid="+gid;win_open(url,"winOriginal","left=50,top=50,width=900,height=460,scrollbars=1");}
function win_regcode(url)
{if(!url)
url=g4_path+"/popup_regcode.php";win_open(url,"winRegcode","left=50,top=50,width=700,height=460,scrollbars=1");}
function win_recommend(url)
{if(!url)
url=g4_path+"/popup_recommend.php";win_open(url,"winRegcode","left=50,top=50,width=700,height=460,scrollbars=1");}
function win_auth(url)
{if(!url)
url=g4_path+"/auth/AuthMobile.php?token="+document.fregisterform.token.value;win_open(url,"winAuth","left=50,top=50,width=300,height=360,scrollbars=1");}
function win_partner(url)
{if(!url)
url=g4_path+"/popup_partner.php";win_open(url,"winPartner","left=50,top=50,width=800,height=660,scrollbars=1");}
function win_manager(url)
{if(!url)
url=g4_path+"/popup_manager.php";win_open(url,"winManager","left=50,top=50,width=800,height=660,scrollbars=1");}
function popup_formmail(url)
{opt='scrollbars=yes,width=417,height=385,top=10,left=20';popup_window(url,"wformmail",opt);}
function no_comma(data)
{var tmp='';var comma=',';var i;for(i=0;i<data.length;i++)
{if(data.charAt(i)!=comma)
tmp+=data.charAt(i);}
return tmp;}
function del(href)
{if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?"))
document.location.href=href;}
function set_cookie(name,value,expirehours,domain)
{var today=new Date();today.setTime(today.getTime()+(60*60*1000*expirehours));document.cookie=name+"="+escape(value)+"; path=/; expires="+today.toGMTString()+";";if(domain){document.cookie+="domain="+domain+";";}}
function get_cookie(name)
{var find_sw=false;var start,end;var i=0;for(i=0;i<=document.cookie.length;i++)
{start=i;end=start+name.length;if(document.cookie.substring(start,end)==name)
{find_sw=true
break}}
if(find_sw==true)
{start=end+1;end=document.cookie.indexOf(";",start);if(end<start)
end=document.cookie.length;return document.cookie.substring(start,end);}
return"";}
function delete_cookie(name)
{var today=new Date();today.setTime(today.getTime()-1);var value=get_cookie(name);if(value!="")
document.cookie=name+"="+value+"; path=/; expires="+today.toGMTString();}
function image_window(img)
{var w=img.tmp_width;var h=img.tmp_height;var winl=(screen.width-w)/2;var wint=(screen.height-h)/3;if(w>=screen.width){winl=0;h=(parseInt)(w*(h/w));}
if(h>=screen.height){wint=0;w=(parseInt)(h*(w/h));}
var js_url="<script language='JavaScript1.2'> \n";js_url+="<!-- \n";js_url+="var ie=document.all; \n";js_url+="var nn6=document.getElementById&&!document.all; \n";js_url+="var isdrag=false; \n";js_url+="var x,y; \n";js_url+="var dobj; \n";js_url+="function movemouse(e) \n";js_url+="{ \n";js_url+="  if (isdrag) \n";js_url+="  { \n";js_url+="    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x; \n";js_url+="    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y; \n";js_url+="    return false; \n";js_url+="  } \n";js_url+="} \n";js_url+="function selectmouse(e) \n";js_url+="{ \n";js_url+="  var fobj      = nn6 ? e.target : event.srcElement; \n";js_url+="  var topelement = nn6 ? 'HTML' : 'BODY'; \n";js_url+="  while (fobj.tagName != topelement && fobj.className != 'dragme') \n";js_url+="  { \n";js_url+="    fobj = nn6 ? fobj.parentNode : fobj.parentElement; \n";js_url+="  } \n";js_url+="  if (fobj.className=='dragme') \n";js_url+="  { \n";js_url+="    isdrag = true; \n";js_url+="    dobj = fobj; \n";js_url+="    tx = parseInt(dobj.style.left+0); \n";js_url+="    ty = parseInt(dobj.style.top+0); \n";js_url+="    x = nn6 ? e.clientX : event.clientX; \n";js_url+="    y = nn6 ? e.clientY : event.clientY; \n";js_url+="    document.onmousemove=movemouse; \n";js_url+="    return false; \n";js_url+="  } \n";js_url+="} \n";js_url+="document.onmousedown=selectmouse; \n";js_url+="document.onmouseup=new Function('isdrag=false'); \n";js_url+="//--> \n";js_url+="</"+"script> \n";var settings;if(g4_is_gecko){settings='width='+(w+10)+',';settings+='height='+(h+10)+',';}else{settings='width='+w+',';settings+='height='+h+',';}
settings+='top='+wint+',';settings+='left='+winl+',';settings+='scrollbars=no,';settings+='resizable=yes,';settings+='status=no';win=window.open("","image_window",settings);win.document.open();win.document.write("<html><head> \n<meta http-equiv='imagetoolbar' CONTENT='no'> \n<meta http-equiv='content-type' content='text/html; charset="+g4_charset+"'>\n");var size="이미지 사이즈 : "+w+" x "+h;win.document.write("<title>"+size+"</title> \n");if(w>=screen.width||h>=screen.height){win.document.write(js_url);var click="ondblclick='window.close();' style='cursor:move' title=' "+size+" \n\n 이미지 사이즈가 화면보다 큽니다. \n 왼쪽 버튼을 클릭한 후 마우스를 움직여서 보세요. \n\n 더블 클릭하면 닫혀요. '";}
else
var click="onclick='window.close();' style='cursor:pointer' title=' "+size+" \n\n 클릭하면 닫혀요. '";win.document.write("<style>.dragme{position:relative;}</style> \n");win.document.write("</head> \n\n");win.document.write("<body leftmargin=0 topmargin=0 bgcolor=#dddddd style='cursor:arrow;'> \n");win.document.write("<table width=100% height=100% cellpadding=0 cellspacing=0><tr><td align=center valign=middle><img src='"+img.src+"' width='"+w+"' height='"+h+"' border=0 class='dragme' "+click+"></td></tr></table>");win.document.write("</body></html>");win.document.close();if(parseInt(navigator.appVersion)>=4){win.window.focus();}}
function win_open(url,name,option)
{var popup=window.open(url,name,option);popup.focus();}
function win_zip(frm_name,frm_zip1,frm_zip2,frm_addr1,frm_addr2)
{url=g4_path+"/"+g4_bbs+"/zip.php?frm_name="+frm_name+"&frm_zip1="+frm_zip1+"&frm_zip2="+frm_zip2+"&frm_addr1="+frm_addr1+"&frm_addr2="+frm_addr2;win_open(url,"winZip","left=50,top=50,width=616,height=460,scrollbars=1");}
function win_memo(url)
{if(!url)
url=g4_path+"/"+g4_bbs+"/memo.php";win_open(url,"winMemo","left=50,top=50,width=620,height=460,scrollbars=1");}
function win_point(url)
{win_open(g4_path+"/"+g4_bbs+"/point.php","winPoint","left=20, top=20, width=616, height=635, scrollbars=1");}
function win_scrap(url)
{if(!url)
url=g4_path+"/"+g4_bbs+"/scrap.php";win_open(url,"scrap","left=20, top=20, width=616, height=500, scrollbars=1");}
function win_password_forget()
{win_open(g4_path+"/"+g4_bbs+"/password_forget.php",'winPasswordForget','left=50, top=50, width=616, height=500, scrollbars=1');}
function win_comment(url)
{win_open(url,"winComment","left=50, top=50, width=800, height=600, scrollbars=1");}
function win_formmail(mb_id,name,email)
{if(g4_charset.toLowerCase()=='euc-kr')
win_open(g4_path+"/"+g4_bbs+"/formmail.php?mb_id="+mb_id+"&name="+name+"&email="+email,"winFormmail","left=50, top=50, width=600, height=500, scrollbars=0");else
win_open(g4_path+"/"+g4_bbs+"/formmail.php?mb_id="+mb_id+"&name="+encodeURIComponent(name)+"&email="+email,"winFormmail","left=50, top=50, width=600, height=480, scrollbars=0");}
function win_agent()
{win_open(g4_path+"/"+g4_agent+"/member_list.php",'winAgent','left=50, top=50, width=1200, height=700, scrollbars=1');}
function win_calendar(fld,cur_date,delimiter,opt,obj)
{var left,top;if(obj){left=get_left_pos(obj)-120;top=get_top_pos(obj)+140;}else{left=50;top=50;}
if(!opt)
opt="left="+left+", top="+top+", width=240, height=230, scrollbars=0,status=0,resizable=0";win_open(g4_path+"/"+g4_bbs+"/calendar.php?fld="+fld+"&cur_date="+cur_date+"&delimiter="+delimiter,"winCalendar",opt);}
function win_calendar2(fld,cur_date,delimiter,opt,e)
{if(!opt)
opt="left="+left+", top="+top+", width=240, height=230, scrollbars=0,status=0,resizable=0";win_open(g4_path+"/"+g4_bbs+"/calendar.php?fld="+fld+"&cur_date="+cur_date+"&delimiter="+delimiter,"winCalendar",opt);}
function win_poll(url)
{if(!url)
url="";win_open(url,"winPoll","left=50, top=50, width=616, height=500, scrollbars=1");}
function win_profile(mb_id)
{win_open(g4_path+"/"+g4_bbs+"/profile.php?mb_id="+mb_id,'winProfile','left=50,top=50,width=620,height=510,scrollbars=1');}
var last_id=null;function menu(id)
{if(id!=last_id)
{if(last_id!=null)
document.getElementById(last_id).style.display="none";document.getElementById(id).style.display="block";last_id=id;}
else
{document.getElementById(id).style.display="none";last_id=null;}}
function textarea_decrease(id,row)
{if(document.getElementById(id).rows-row>0)
document.getElementById(id).rows-=row;}
function textarea_original(id,row)
{document.getElementById(id).rows=row;}
function textarea_increase(id,row)
{document.getElementById(id).rows+=row;}
function check_byte(content,target)
{var i=0;var cnt=0;var ch='';var cont=document.getElementById(content).value;for(i=0;i<cont.length;i++){ch=cont.charAt(i);if(escape(ch).length>4){cnt+=2;}else{cnt+=1;}}
var el=document.getElementById(target);if(el.type=='text'){el.value=cnt;}else{el.innerHTML=cnt;}
return cnt;}
function get_left_pos(obj)
{var parentObj=null;var clientObj=obj;var left=obj.offsetLeft;while((parentObj=clientObj.offsetParent)!=null)
{left=left+parentObj.offsetLeft;clientObj=parentObj;}
return left;}
function get_top_pos(obj)
{var parentObj=null;var clientObj=obj;var top=obj.offsetTop;while((parentObj=clientObj.offsetParent)!=null)
{top=top+parentObj.offsetTop;clientObj=parentObj;}
return top;}
function flash_movie(src,ids,width,height,wmode)
{var wh="";if(parseInt(width)&&parseInt(height))
wh=" width='"+width+"' height='"+height+"' ";return"<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' "+wh+" id="+ids+"><param name=wmode value="+wmode+"><param name=movie value="+src+"><param name=quality value=high><embed src="+src+" quality=high wmode="+wmode+" type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash' "+wh+"></embed></object>";}
function obj_movie(src,ids,width,height,autostart,repeat)
{var wh="";if(parseInt(width)&&parseInt(height))
wh=" width='"+width+"' height='"+height+"' ";if(!autostart)autostart=false;return"<embed src='"+src+"' "+wh+" autostart='"+autostart+"' repeat='"+repeat+"'></embed>";}
function doc_write(cont)
{document.write(cont);}}
function check_key(){var char_ASCII=event.keyCode;if((char_ASCII>=48&&char_ASCII<=57)||(char_ASCII==46)||(char_ASCII==43)||(char_ASCII==45))
return 1;else if((char_ASCII>=65&&char_ASCII<=90)||(char_ASCII>=97&&char_ASCII<=122))
return 2;else if((char_ASCII>=33&&char_ASCII<=47)||(char_ASCII>=58&&char_ASCII<=64)||(char_ASCII>=91&&char_ASCII<=96)||(char_ASCII>=123&&char_ASCII<=126))
return 4;else if((char_ASCII>=12592)||(char_ASCII<=12687))
return 3;else
return 0;}
function nonHangulSpecialKey(){if(check_key()!=1&&check_key()!=2){event.returnValue=false;alert("숫자나 영문자만 입력하세요!");return;}}
function numberKey(){if(check_key()!=1){event.returnValue=false;alert("숫자만 입력할 수 있습니다.");return;}}
function number_format(data)
{var tmp='';var number='';var cutlen=3;var comma=',';var i;len=data.length;mod=(len%cutlen);k=cutlen-mod;for(i=0;i<data.length;i++)
{number=number+data.charAt(i);if(i<data.length-1)
{k++;if((k%cutlen)==0)
{number=number+comma;k=0;}}}
return number;}
save_layer=null;argument=null;sector=null;view_way=null;function layer_view(link_id,menu_id,opt,sect,view_way)
{var link=document.getElementById(link_id);var menu=document.getElementById(menu_id);var x=0;var y=7;sector=sect;if(save_layer!=null)
{save_layer.style.display="none";selectBoxVisible();}
if(link_id=='')
return;if(opt=='hide')
{menu.style.display='none';selectBoxVisible();}
else
{x=parseInt(x);y=parseInt(y);if(sector=="mypage"&&view_way=="filter")
{if(navigator.appName&&navigator.appName.indexOf("Microsoft")!=-1)
{spotNum=-89;var wraps=document.getElementById('spotLayerBody');menu.style.top=get_top_pos(link)+wraps.scrollTop+y+(spotNum);}
else
{spotNum=-50;menu.style.top=get_top_pos(link)+link.offsetHeight+y+(spotNum);}
menu.style.left=get_left_pos(link)+x-50;menu.style.display='block';}
else if(sector=="mypage"&&view_way=="pop")
{spotNum=-40;menu.style.left=get_left_pos(link)+x-30;menu.style.top=get_top_pos(link)+document.body.scrollTop+y+spotNum;menu.style.display='block';}
else
{spotNum=20;menu.style.left=get_left_pos(link)+x-30;menu.style.top=get_top_pos(link);menu.style.display='block';}}
save_layer=menu;}
function setCookie(name,value)
{document.cookie=name+"="+escape(value)+"; path=/;";}
function getCookie(name)
{var nameOfCookie=name+"=";var x=0;while(x<=document.cookie.length)
{var y=(x+nameOfCookie.length);if(document.cookie.substring(x,y)==nameOfCookie){if((endOfCookie=document.cookie.indexOf(";",y))==-1)
endOfCookie=document.cookie.length;return unescape(document.cookie.substring(y,endOfCookie));}
x=document.cookie.indexOf(" ",x)+1;if(x==0)
break;}
return"";}
function deleteCookie(cookieName){document.cookie=cookieName+"= "+"; path=/";}
function MoveL(surl){location.href=surl;}