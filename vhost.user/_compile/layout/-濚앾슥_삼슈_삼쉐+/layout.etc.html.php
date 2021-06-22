<?php $this->print_("header",$TPL_SCP,1);?>
</head>
<body>
<div id="whole">
<h2 class="blind"><a href="#wrap_body">내용 바로보기</a></h2>
	<div id="wrap_header">
		<div id="header">
		</div>
	</div>
	<div id="wrap_body">
		<h2 class="blind">내용</a></h2>
		<div id="body">
			<?php $this->print_("content",$TPL_SCP,1);?>
		</div>
	</div>
	<?php $this->print_("footer",$TPL_SCP,1);?>
</div>
</body>
</html>