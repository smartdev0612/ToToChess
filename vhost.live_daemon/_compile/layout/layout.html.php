<?php /* Template_ 2.2.3 2014/02/14 08:31:40 D:\www_one-23.com\vhost.live_daemon\_template\layout\layout.html */?>
<?php $this->print_("header",$TPL_SCP,1);?>

	<script>
	window.onload = function()
	{
		begin_live_listener();
	}
	</script>
</head>

	<body>
		<div id="wrap">
			<div id="header">
<?php $this->print_("top",$TPL_SCP,1);?>

			</div>
			<div id="body">
				
				<div id="wrap_main">
					<div id="main">라이브 데몬이 구동중입니다.</div>
				</div>

				<div id="leftMenu">
<?php $this->print_("left",$TPL_SCP,1);?>

				</div>
			</div>

			<div id="footer">
<?php $this->print_("footer",$TPL_SCP,1);?>

			</div>
		</div>
	</body>
</html>