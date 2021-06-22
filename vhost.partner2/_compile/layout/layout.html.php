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
	<div class="wrap">
		<div id="header">
<?php $this->print_("top",$TPL_SCP,1);?>

		</div>
	
		<div id="body">
			<div id="main">
<?php $this->print_("content",$TPL_SCP,1);?>

			</div>
			<div id="footer">
<?php $this->print_("footer",$TPL_SCP,1);?>

			</div>
		</div>
	</div>
</body>
</html>