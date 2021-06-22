<?php $this->print_("header",$TPL_SCP,1);?>

	<script>
	window.onload = function()
	{
		refreshContent();
		beginTimer();
	}
	</script>
</head>

<body>
	<div id="wrap">
		<div id="header">
<?php $this->print_("top",$TPL_SCP,1);?>

		</div>
		<div id="wrap_body">
			
			<div id="body">
				<div id="main">
<?php $this->print_("content",$TPL_SCP,1);?>

				</div>

			</div>

			<div id="leftmenu">
<?php $this->print_("left",$TPL_SCP,1);?>

			</div>
		</div>

		<div id="footer">
<?php $this->print_("footer",$TPL_SCP,1);?>

		</div>
	</div>
</body>
</html>