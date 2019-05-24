<!--Entrar en base a un usuario-->
<?php
	session_start();
	if (!isset ($_SESSION['USSER'])) {
		header("Location: Acceso/");
		exit();
	}
	else{
		if (!isset ($_GET["id"])) {
			$_GET["id"] = 0;
		}
	}
?>
<style>
	body {
		zoom: 100%;
		/*-moz-transform: scale(0.90);*/
	}
	.required:invalid  {
		border: solid 1px #ff8400;
		background-color:#ffce9a;
	}

	
	.totheright{
		text-align:right;
	}

	input.invalid{
		/*background-color: #ff6f6f;*/
		background: linear-gradient(to right, #ff0000, #FFF);
		color:#fff;
		border-style: solid;
		border-width: 2px;
		border-color:#fefefe;
	}
	input.success{
		background-color: #ffffff;
		color:#000;
	}

	#tooltip{
		text-align: center;
		color: #fff;
		background: #111;
		position: absolute;
		z-index: 100;
		padding: 15px;
	}
 
	#tooltip:after /* triangle decoration */
	{
		width: 0;
		height: 0;
		border-left: 10px solid transparent;
		border-right: 10px solid transparent;
		border-top: 10px solid #111;
		content: '';
		position: absolute;
		left: 50%;
		bottom: -10px;
		margin-left: -10px;
	}
 
	#tooltip.top:after
	{
		border-top-color: transparent;
		border-bottom: 10px solid #111;
		top: -20px;
		bottom: auto;
	}
 
	#tooltip.left:after
	{
		left: 10px;
		margin: 0;
	}
 
	#tooltip.right:after
	{
		right: 10px;
		left: auto;
		margin: 0;
	}

</style>
<!-- Scripts pagina -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/pikaday.css">
	<link rel="stylesheet" href="css/toastr.css">
	<link rel="stylesheet" href="css/sticky-footer-navbar.css">
	<link href="css/loading.css" rel="stylesheet">
	<link rel="stylesheet" href="js/fulltable/jquery.fulltable.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/moment.min.js"></script>
	<script src="js/toastr.min.js"></script>
	<script src="js/funciones.js"></script>
	<script src="js/pikaday.js"></script>
	<script src="js/fulltable/jquery.fulltable.js"></script>
	<script src="js/loading.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/additional-methods.min.js"></script>


	<body id="bodymain">
		<script> $('#bodymain').loading();</script>
			<div style="background-color: #dc2929; color: #ffffff; width: 100%; height:40px;padding:20px;" id="old-browser"> Your browser is outdated or does not support JavaScript, please upgrade your browser. <a href="http://www.google.com/chrome/">Google Chrome</a></div>
		<script>
		if (navigator.appName != 'Microsoft Internet Explorer') {
			document.getElementById('old-browser').style.visibility = 'hidden';
			document.getElementById('old-browser').style.height = '0px';
			document.getElementById('old-browser').style.padding = '0px';
		} 
		</script>
		<meta charset="utf-8">
	   	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<nav class="navbar navbar-expand-lg navbarlight bg-light" style="background-color: #F7F7F7;">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" font size="20">Hoja de Inspeccion SLT2</a>
				</div>
				<ul class="nav navbar-nav">
					<li><a href="/HojaInspeccionMTY">Nueva WO NO</a></li>
					<li><a href="http://serlam2/servilaminamty/HojaInspeccion/HojaInspeccionSLT2.aspx"target="_blank">Imprimir WO NO</a></li>
					
					<li><a href="http://mtyserlam1v1:8080/mtyblog/wp-login.php" target="_blank">Blog Rechazos Internos</a></li>
					<li><a href="php/logout.php?user=<?php echo $_SESSION['USSER'];?>" style="color:#797979";>Salir</a></li>
				</ul> 
			</div>   
		</nav>