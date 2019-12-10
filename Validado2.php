<!DOCTYPE HTML>
<html lang="es">
   <head>
      <title>Hoja de Inspeccion SLT</title>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <?php include("php/Pagina_inicio.php"); ?>
      <!-- ---------------------------------------------------------- -->
      <div class="container-fluid">
        <br/>
        <br/>
         <div class="row">
              <div class= "col-lg-12 col-md-12 col-sm-12">

              <?php
              include("php/variables.php");
              $conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
                              if (!$conn)
                                die ("conexionerror");

              

              $consulta = "SELECT DISTINCT MOTHER_BOM FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE WO_NO = '". strtoupper($_GET["wo"]) ."' and MOTHER_BOM= '". strtoupper($_GET["bom"]) ."' and FINAL_CHECK is NULL order by mother_bom";
              $resultado = odbc_do($conn, $consulta); 
              $count = 0;
              while (odbc_fetch_row($resultado)) {
                $count++;
              }
              if($count > 0){
                //header("Location: tolerancias_ancho_inicio.php?wo=".$_GET["wo"]."&FBOM=".$FORMER_BOM);
                echo '<meta http-equiv="refresh" content="0;url=Validacion_ancho_inicio.php?wo='.$_GET["wo"].'">';
                die();

              }else{

                        
                echo "<h3>La Siguiente Work Order:".strtoupper($_GET["wo"])." ".strtoupper($_GET["bom"])." ya ha sido Validada</h3>";
                echo '<meta http-equiv="refresh" content="0;url=ImprimirWO.php?wo='.$_GET["wo"].'&bom='.$_GET["bom"].'">';


              }

              ?>



            </div>
         </div>
      </div>
      <br/>
      <!-- ---------------------------------------------------------- -->
      <!-- <footer class="footer" >
         <div class="container">
            <span>Servilamina Summit Mexicana</span>
         </div>
      </footer>-->
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="js/pikaday.js"></script>
      <link href="css/speech-input.css" rel="stylesheet">
      <script src="js/speech-input.js"></script>
      <script>

         
         $(document).ready(function()
           {
               $('#bodymain').loading('stop');
           });


      </script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      </body>
</html>