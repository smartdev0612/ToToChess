<?php /* Template_ 2.2.3 2013/12/01 02:09:56 D:\www_mos1\m.vhost.user\_template\content\game.html */?>
<script>
	function onTitleClick($index)
	{
		if(document.getElementById($index+"_content").style.display=="none")
		{
			$("tr[id^="+$index+"_content]").css("display", "none");
			$("tr[id="+$index+"_content]").css("display", "");
		}
		else
		{
			$("tr[id="+$index+"_content]").css("display", "none");
		}
	}
	
	function doSubmit()
	{
		if(document.frm_write.content.value=="")
		{
			alert("문의할 내용을 입력하여 주십시오.");
			document.frm_write.content.focus();
			return;
		}
		document.frm_write.submit();
	}
	
	function godel(url)
	{
		var r=confirm("정말로 삭제 하시겠습니까?");
		if (r==true)
		{ 
			document.location.href=url;
		}
}  
</script>

	<div id="wrap_body">
		<h2 class="blind">내용</h2>
		<div id="subvisual" class="subvisual_helpdesk">
			<h3><img src="/img/bbs/title_game.gif"></h3>
		</div>
		<div id="body">
			<div id="gamedown">
				<p><a href="<?php echo $TPL_VAR["download_url"]?>"><img src="/img/bbs/btn_gamedown.jpg"></a></p>
			</div>

			<p class="gamedown2"><img src="/img/bbs/gamedown_info.jpg"></p>
		</div>
<?php $this->print_("right_normal",$TPL_SCP,1);?>

	</div>