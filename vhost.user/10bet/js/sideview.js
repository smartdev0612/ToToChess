if(typeof(SIDEVIEW_JS)=='undefined')
{if(typeof g4_is_member=='undefined')
alert('g4_is_member 변수가 선언되지 않았습니다. js/sideview.js');if(typeof g4_path=='undefined')
alert('g4_path 변수가 선언되지 않았습니다. js/sideview.js');var SIDEVIEW_JS=true;function insertHead(name,text,evt)
{var idx=this.heads.length;var row=new SideViewRow(-idx,name,text,evt);this.heads[idx]=row;return row;}
function insertTail(name,evt)
{var idx=this.tails.length;var row=new SideViewRow(idx,name,evt);this.tails[idx]=row;return row;}
function SideViewRow(idx,name,onclickEvent)
{this.idx=idx;this.name=name;this.onclickEvent=onclickEvent;this.renderRow=renderRow;this.isVisible=true;this.isDim=false;}
function renderRow()
{if(!this.isVisible)
return"";var str="<tr height='19'><td id='sideViewRow_"+this.name+"'>&nbsp;<font color=gray>&middot;</font>&nbsp;<span style='color: #A0A0A0;  font-family: 돋움; font-size: 11px;'>"+this.onclickEvent+"</span></td></tr>";return str;}
function showSideView(curObj,mb_id,name,email,homepage)
{var sideView=new SideView('nameContextMenu',curObj,mb_id,name,email,homepage);sideView.showLayer();}
function SideView(targetObj,curObj,mb_id,name,email,homepage)
{this.targetObj=targetObj;this.curObj=curObj;this.mb_id=mb_id;name=name.replace(/…/g,"");this.name=name;this.email=email;this.homepage=homepage;this.showLayer=showLayer;this.makeNameContextMenus=makeNameContextMenus;this.heads=new Array();this.insertHead=insertHead;this.tails=new Array();this.insertTail=insertTail;this.getRow=getRow;this.hideRow=hideRow;this.dimRow=dimRow;if(mb_id)
this.insertTail("memo","<a href=\"javascript:win_memo('"+g4_path+"/"+g4_bbs+"/memo_form.php?me_recv_mb_id="+mb_id+"');\">쪽지보내기</a>");if(homepage)
this.insertTail("homepage","<a href=\"javascript:;\" onclick=\"window.open('"+homepage+"');\">홈페이지</a>");if(mb_id)
this.insertTail("info","<a href=\"javascript:;\" onclick=\"win_profile('"+mb_id+"');\">자기소개</a>");if(g4_bo_table){if(mb_id)
this.insertTail("mb_id","<a href='"+g4_path+"/"+g4_bbs+"/board.php?bo_table="+g4_bo_table+"&sca="+g4_sca+"&sfl=mb_id,1&stx="+mb_id+"'>아이디로 검색</a>");else
this.insertTail("name","<a href='"+g4_path+"/"+g4_bbs+"/board.php?bo_table="+g4_bo_table+"&sca="+g4_sca+"&sfl=wr_name,1&stx="+name+"'>이름으로 검색</a>");}
if(g4_is_admin=="super"){if(mb_id)
this.insertTail("modify","<a href='"+g4_path+"/"+g4_admin+"/member_detail.php?mb_id="+mb_id+"' target='_blank'>자세히보기</a>");if(mb_id)
this.insertTail("modify","<a href='"+g4_path+"/"+g4_admin+"/member_form.php?w=u&mb_id="+mb_id+"' target='_blank'>회원정보변경</a>");if(mb_id)
this.insertTail("point","<a href='"+g4_path+"/"+g4_admin+"/point_list.php?sfl=mb_id&stx="+mb_id+"' target='_blank'>포인트내역</a>");if(mb_id)
this.insertTail("info","<a href=\"javascript:win_open('"+g4_path+"/"+g4_admin+"/total_cash_info.php?mb_id="+mb_id+"','_bet','left=0,top=0,width=600,height=60,scrollbars=0');\">총내역보기</a>");if(mb_id)
this.insertTail("betting","<a href=\""+g4_path+"/"+g4_admin+"/betting_list_user.php?page=1&mb_id="+mb_id+"\" target='_blank'>배팅내역보기</a>");}}
function showLayer()
{clickAreaCheck=true;var oSideViewLayer=document.getElementById(this.targetObj);var oBody=document.body;if(oSideViewLayer==null){oSideViewLayer=document.createElement("DIV");oSideViewLayer.id=this.targetObj;oSideViewLayer.style.position='absolute';oSideViewLayer.style.backgroundColor='white';oBody.appendChild(oSideViewLayer);}
oSideViewLayer.innerHTML=this.makeNameContextMenus();if(getAbsoluteTop(this.curObj)+this.curObj.offsetHeight+oSideViewLayer.scrollHeight+5>oBody.scrollHeight)
oSideViewLayer.style.top=getAbsoluteTop(this.curObj)-oSideViewLayer.scrollHeight;else
oSideViewLayer.style.top=getAbsoluteTop(this.curObj)+this.curObj.offsetHeight;oSideViewLayer.style.left=getAbsoluteLeft(this.curObj)-this.curObj.offsetWidth+14;divDisplay(this.targetObj,'block');selectBoxHidden(this.targetObj);}
function getAbsoluteTop(oNode)
{var oCurrentNode=oNode;var iTop=0;while(oCurrentNode.tagName!="BODY"){iTop+=oCurrentNode.offsetTop-oCurrentNode.scrollTop;oCurrentNode=oCurrentNode.offsetParent;}
return iTop;}
function getAbsoluteLeft(oNode)
{var oCurrentNode=oNode;var iLeft=0;iLeft+=oCurrentNode.offsetWidth;while(oCurrentNode.tagName!="BODY"){iLeft+=oCurrentNode.offsetLeft;oCurrentNode=oCurrentNode.offsetParent;}
return iLeft;}
function makeNameContextMenus()
{var str="<table border='0' cellpadding='3' cellspacing='0' width='100' style='border:1px solid #555;' bgcolor='white'>";var i=0;for(i=this.heads.length-1;i>=0;i--)
str+=this.heads[i].renderRow();var j=0;for(j=0;j<this.tails.length;j++)
str+=this.tails[j].renderRow();str+="</table>";return str;}
function getRow(name)
{var i=0;var row=null;for(i=0;i<this.heads.length;++i)
{row=this.heads[i];if(row.name==name)return row;}
for(i=0;i<this.tails.length;++i)
{row=this.tails[i];if(row.name==name)return row;}
return row;}
function hideRow(name)
{var row=this.getRow(name);if(row!=null)
row.isVisible=false;}
function dimRow(name)
{var row=this.getRow(name);if(row!=null)
row.isDim=true;}
function selectBoxHidden(layer_id)
{var ly=document.getElementById(layer_id);var ly_left=ly.offsetLeft;var ly_top=ly.offsetTop;var ly_right=ly.offsetLeft+ly.offsetWidth;var ly_bottom=ly.offsetTop+ly.offsetHeight;var el;for(i=0;i<document.forms.length;i++){for(k=0;k<document.forms[i].length;k++){el=document.forms[i].elements[k];if(el.type=="select-one"){var el_left=el_top=0;var obj=el;if(obj.offsetParent){while(obj.offsetParent){el_left+=obj.offsetLeft;el_top+=obj.offsetTop;obj=obj.offsetParent;}}
el_left+=el.clientLeft;el_top+=el.clientTop;el_right=el_left+el.clientWidth;el_bottom=el_top+el.clientHeight;if((el_left>=ly_left&&el_top>=ly_top&&el_left<=ly_right&&el_top<=ly_bottom)||(el_right>=ly_left&&el_right<=ly_right&&el_top>=ly_top&&el_top<=ly_bottom)||(el_left>=ly_left&&el_bottom>=ly_top&&el_right<=ly_right&&el_bottom<=ly_bottom)||(el_left>=ly_left&&el_left<=ly_right&&el_bottom>=ly_top&&el_bottom<=ly_bottom)||(el_top<=ly_bottom&&el_left<=ly_left&&el_right>=ly_right))
el.style.visibility='hidden';}}}}
function selectBoxVisible()
{for(i=0;i<document.forms.length;i++)
{for(k=0;k<document.forms[i].length;k++)
{el=document.forms[i].elements[k];if(el.type=="select-one"&&el.style.visibility=='hidden')
el.style.visibility='visible';}}}
function getAbsoluteTop(oNode)
{var oCurrentNode=oNode;var iTop=0;while(oCurrentNode.tagName!="BODY"){iTop+=oCurrentNode.offsetTop-oCurrentNode.scrollTop;oCurrentNode=oCurrentNode.offsetParent;}
return iTop;}
function getAbsoluteLeft(oNode)
{var oCurrentNode=oNode;var iLeft=0;iLeft+=oCurrentNode.offsetWidth;while(oCurrentNode.tagName!="BODY"){iLeft+=oCurrentNode.offsetLeft;oCurrentNode=oCurrentNode.offsetParent;}
return iLeft;}
function divDisplay(id,act)
{selectBoxVisible();document.getElementById(id).style.display=act;}
function hideSideView()
{if(document.getElementById("nameContextMenu"))
divDisplay("nameContextMenu",'none');}
var clickAreaCheck=false;document.onclick=function()
{if(!clickAreaCheck)
hideSideView();else
clickAreaCheck=false;}}