<?php /* Template_ 2.2.3 2014/10/21 20:58:06 D:\www_one-23.com\m.vhost.user\_template\layout\layout.type.index.html */?>
<?php $this->print_("header",$TPL_SCP,1);?>

	<script type="text/javascript">
		function fnSearch() {document.frm_search.submit();}
		function frm_reset()
		{
			document.frm_search.cateIdx.value="0";
			document.frm_search.leagueIdx.value="";
			document.frm_search.submit();
		}
	</script>
</head>

<body>

<?php $this->print_("top",$TPL_SCP,1);?>

<?php $this->print_("content",$TPL_SCP,1);?>

<?php $this->print_("footer",$TPL_SCP,1);?>


</body>
</html>