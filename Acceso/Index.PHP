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
  <meta charset="UTF-8">
  <title>HOJA INSPECCION SLT2</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/sticky-footer-navbar.css">
    <link rel="stylesheet" href="../css/toastr.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/toastr.min.js"></script>
  <script src="../js/funciones.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/onsenui/css/onsenui.css">
  

  
  
  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>

  <div class="login">
  <div class="login-triangle"></div>
  
 <br/>

<body>
    <ons-page>
    <div class="login-form">
    <form id="formulario" method="POST" action="acceso.php">
    <center><h3>HOJA DE INSPECCION SLT2</h3></center>
        <input type="text" class="text-input--underbar" placeholder="Usuario HG" name="Username" value="" autofocus="" required>
        <input type="password" class="text-input--underbar" placeholder="Contraseña HG" name="password" value="" required>
        <br><br>
        <p><input type="submit" value="Log in"></p>
   </div>
   </form>
   </ons-page>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  

</body>

</html>

   