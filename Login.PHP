 <?php
	session_start();
	if (isset ($_SESSION['USSER'])) {
		header("Location: ../");
		exit();
	}
	?>
<!--
	you can substitue the span of reauth email for a input with the email and
	include the remember me checkbox
	-->
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="../css/sticky-footer-navbar.css">
	<link rel="stylesheet" href="../css/toastr.css">
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/toastr.min.js"></script>
	<script src="../js/funciones.js"></script>
		<link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsenui.css">
<link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsen-css-components.min.css">
<script src="https://unpkg.com/onsenui/js/onsenui.min.js"></script>

	<script src="lib/onsen/js/onsenui.js"></script>
		<style>
		body {
			zoom: 100%;
			/*-moz-transform: scale(0.90);*/
		}
		.login-form {
  text-align: center;
  width: 80%;
  margin: 60px auto 0;
}

input[type=text], input[type=password] {
  display: block;
  width: 100%;
  margin: 0 auto;
  outline: none;
  height: 25px;
  padding-top: 15px;
  padding-bottom: 16px;
}

.forgot-password {
  display: block;
  margin: 8px auto 0 auto;
  font-size: 14px;
}
.button--large--cta {
  position: relative;
  display: inline-block;
  vertical-align: top;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-background-clip: padding-box;
  background-clip: padding-box;
  padding: 0;
  margin: 0;
  font: inherit;
  color: inherit;
  background: transparent;
  border: none;
  line-height: normal;
  font-family: -apple-system, 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  font-weight: 400;
  font-size: 17px;
  cursor: default;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
  height: auto;
  text-decoration: none;
  padding: 4px 10px;
  font-size: 17px;
  line-height: 32px;
  letter-spacing: 0;
  color: #fff;
  vertical-align: middle;
  background-color: #007bff;
  border: 0px solid currentColor;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  -webkit-transition: none;
  -moz-transition: none;
  -o-transition: none;
  transition: none;
  border: none;
  background-color: #007bff;
  color: #fff;
  font-size: 17px;
  font-weight: 500;
  line-height: 36px;
  padding: 4px 12px;
  width: 100%;
  text-align: center;
  display: block;
}
.button--large--cta:hover {
  -webkit-transition: none;
  -moz-transition: none;
  -o-transition: none;
  transition: none;
}
.button--large--cta:focus {
  outline: 0;
}
.button--large--cta:active {
  color: #fff;
  background-color: #007bff;
  -webkit-transition: none;
  -moz-transition: none;
  -o-transition: none;
  transition: none;
  opacity: 0.2;
}
.button--large--cta:disabled,
.button--large--cta[disabled] {
  opacity: 0.3;
  cursor: default;
  pointer-events: none;
}
		</style>

<body>
	<ons-page>

	  <div class="login-form">
		<form id="formulario" method="POST" action="lgn.php">
		<input type="text" class="text-input--underbar" placeholder="Usuario HG" name="Username" value="" autofocus="" required>
		<input type="password" class="text-input--underbar" placeholder="Contraseña HG" name="password" value="" required>
		<br><br>
		<button class="button--large--cta" >Entrar</button>
   </div>
   </form>
	</ons-page>
	
  </body>