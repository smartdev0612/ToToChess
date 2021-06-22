<?php /* Template_ 2.2.3 2014/10/07 22:45:26 D:\www_mos1\m.vhost.user\_template\layout\layout.index.html */
$TPL_popup_list_1=empty($TPL_VAR["popup_list"])||!is_array($TPL_VAR["popup_list"])?0:count($TPL_VAR["popup_list"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script type="text/javascript">
		function getCookie(name)
		{
		//<![CDATA[
			var nameOfCookie = name + "=";
		  var x = 0; 
		  while(x<=document.cookie.length)
		  {
		  	var y = (x+nameOfCookie.length);
		    if(document.cookie.substring(x,y) == nameOfCookie)
		    {
		    	if((endOfCookie=document.cookie.indexOf(";",y))==-1)
		      	endOfCookie = document.cookie.length;
					return unescape(document.cookie.substring(y,endOfCookie));
				}
		    x = document.cookie.indexOf("",x)+1;  //��¥����
		    if(x==0) break;
			}
			return "";
		//]]>
		}
		function setCookie(name, value, expiredays )
		{
			//<![CDATA[
			var today = new Date();
		  today.setDate( today.getDate() + expiredays );
		  document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + 
		  today.toGMTString() + ";";
			//  return;
		//]]>
		}
		
		function Popup(sn, title, content, width, height, top, left)
		{		
			if(getCookie("popup_"+sn)!="done")
			{
		    var win = window.open ("", sn, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+width+', height='+height+', top='+top+', left='+left);
		    document.popup.action = "/popup";
		    document.popup.title.value=title;
		    document.popup.content.value=content;
		    document.popup.popup_sn.value=sn;
		    document.popup.target = sn;
		    document.popup.submit();
    	}
		}
		
		function onLoaded() {
		}
	</script>
	
	<body onLoad="onLoaded();">
	
	<form name="popup" id="popup" method="post">
		<input type="hidden" id="title" name="title" value="">
		<input type="hidden" id="popup_sn" name="popup_sn" value="">
		<input type="hidden" id="content" name="content" value="">
	</form>
	

<?php $this->print_("content",$TPL_SCP,1);?>
<?php $this->print_("footer",$TPL_SCP,1);?>

<?php 
	if ( $TPL_popup_list_1 ) {
		foreach ( $TPL_VAR["popup_list"] as $TPL_V1 ) {
?>
<!--<script>Popup(<?php echo $TPL_V1["IDX"]?>,'<?php echo $TPL_V1["P_SUBJECT"]?>', '<?php echo $TPL_V1["P_CONTENT"]?>', <?php echo $TPL_V1["P_WIN_WIDTH"]?>,<?php echo $TPL_V1["P_WIN_HEIGHT"]?>,<?php echo $TPL_V1["P_WIN_TOP"]?>,<?php echo $TPL_V1["P_WIN_LEFT"]?>);</script>-->
<?php 
		}
	}
?>