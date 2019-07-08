 <?php
    session_start();
    if (isset ($_SESSION['USSER'])) {
        header("Location: ../");
        exit();
    }
    ?>
<!DOCTYPE html>
<html lang="es" >

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Hoja de Inspeccion Slitter</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-responsive.min.css"> 
    <link rel="stylesheet" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../css/sticky-footer-navbar.css">
    <link rel="stylesheet" href="../css/toastr.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/pages/signin.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/toastr.min.js"></script>
    <script src="../js/funciones.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsenui.css">
</head>
<body>
<div class="account-container">
	
	<div class="content clearfix">
		
  <form id="formulario" method="POST" action="acceso.php">
		
			<h1>Inicio sesion</h1>		
			
			<div class="login-fields">
				
				<p>Acceso a la Hoja de Inspeccion Slitter</p>
				 
				<div class="login-form">
       
					<label for="username">Username</label>
					<input type="text" id="username" name="Username"  value="" placeholder="Usuario HG" class="login username-field" autofocus="" required />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Clave HG" class="login password-field"autofocus="" required/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				

				<button class="button btn btn-success btn-large">Iniciar Sesion</button>
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>

</html>
