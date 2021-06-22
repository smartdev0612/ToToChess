<?php /* Template_ 2.2.3 2014/11/10 14:35:30 D:\www_skgood.com\vhost.manager\_template\left\left.html */?>
<script>
function mainchgna(vii)     
    {      
        if(document.getElementById("left_menu0"+vii).style.display=="") 
        {     
           document.getElementById("left_menu0"+vii).style.display="none";     
        }     
        else
        {
           document.getElementById("left_menu0"+vii).style.display="";     
        }
    }	
</script>
			<h2><span class="blind">메인메뉴</span></h2>
			
			<p class="m_menu" onclick="mainchgna('4')"><a href="javascript:void();"><font color='orange'>게임 관리</font></a></p>
			<div id="left_menu04">
				<ul>
					<li><a href='/game/gamelist?state=20'>게임관리</a></li>
					<li><a href='/game/betlist'>배팅현황</a></li>
				</ul>
			</div>
			