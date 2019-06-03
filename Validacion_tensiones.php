<!DOCTYPE HTML>
<html lang="es">
<head>
<title>Servilamina</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php include("php/Pagina_inicio.php"); ?>
<!-- ---------------------------------------------------------- -->
<div class="container-fluid">     
  <div class="row">
    <div class= "col-lg-12 col-md-12 col-sm-12">
      <?php
        include("php/variables.php");
        $conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
        if (!$conn)
          die ("conexionerror");              
          if(isset($_GET['bom'])){
            $consulta = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_T] @BOM_NO = '". strtoupper($_GET["bom"]) ."'";
            odbc_do($conn, $consulta);
            //--REVISION DE AGREGADO DE DATOS---
            $consulta3 = "SELECT TOP(1)BOM_NO, TENSION_P_INI_1 FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_TEN] WHERE BOM_NO ='" .strtoupper(($_GET["bom"])). "' AND TENSION_P_INI_1 IS NULL";
            $resultado3 = odbc_do($conn, $consulta3);
            $yavalidado = 0;
            while(odbc_fetch_row($resultado3)){
              $yavalidado = 1;
                    
                echo "<center><label><h3>Check List/Registro de Tensiones</h3></label></center>
                <center><label><h4>Juego 1</h4></label></center>";
                echo '<form id="datosform" method="post" action="insert_tensiones.php">
                </div>
                  </div>
                   <div class="row">
                   <div class= "col-lg-12 col-md-12 col-sm-12">
                   <input id="cancelar" type="submit" value="Cancelar" class="btn btn-warning" tyle="float:right;" onclick="cancelar()">
                   </div>
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                    
                      <div class="form-group">
                        <center><label>Lecturas en MPA</label></center>
                        <input type="hidden" name="MOTHER_BOM" value="'.$_GET['bom'].'">
                        <input type="hidden" name="WO_NO" value="'.strtoupper($_GET["wo"]).'">
                      </div>
                    </div>                                 
                  </div>
                  <div class="row">
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Tensión Pad</label>
                      </div>
                    </div>
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Tensión Break</label>
                      </div>
                    </div>                                        
                  </div>
                  <div class="row">
                    <div class= "col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group">
                        <label for="TENSION_P_INI_1">Inicio</label>
                       <input type="text" step="any" class="form-control" id="TENSION_P_INI_1" name="TENSION_P_INI_1" autocomplete="off" required>
                      </div>
                    </div>
                    <div class= "col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group">
                      <label for="TENSION_P_FIN_1">Final</label>
                      <input type="text" step="any" class="form-control"  id="TENSION_P_FIN_1" name="TENSION_P_FIN_1" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_B_INI_1">Inicio</label>
                      <input type="text" step="any" class="form-control" id="TENSION_B_INI_1" name="TENSION_B_INI_1" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_B_FIN_1">Final</label>
                      <input type="text" step="any" class="form-control"  id="TENSION_B_FIN_1" name="TENSION_B_FIN_1" autocomplete="off" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="METROS_CAMB_1">Metros al Cambio (Tensión Pad)</label>
                      <input type="text" step="any" class="form-control" id="METROS_CAMB_1" name="METROS_CAMB_1" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                  </div>                           
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="METRO_CAMB_1">Metros al Cambio (tensión Break)</label>
                      <input type="text"class="form-control" id="METRO_CAMB_1" name="METRO_CAMB_1" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_ROLL_1">Tension Roll</label>
                      <input type="text" class="form-control" id="TENSION_ROLL_1" name="TENSION_ROLL_1" autocomplete="off"required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class= "col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group">
                      <label>Registro de espesor de fieltro</label>
                    </div>
                  </div>
                  <div class= "col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group">
                      <label>Condición de tabla "Tension Pad"</label>
                    </div>
                  </div>                                        
                </div>
                <div class="row">
                  <div class= "col-lg-2 col-md-2 col-sm-2">
                    <div class="form-group">
                      <label for="FIELTRO_1">Fieltro #1</label>
                      <input type="text" step="any" class="form-control" id="FIELTRO_1" name="FIELTRO_1" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-2 col-md-2 col-sm-2">
                    <div class="form-group">
                      <label for="FIELTRO_2">Fieltro #2</label>
                      <input type="text" step="any" class="form-control"  id="FIELTRO_2" name="FIELTRO_2" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-2 col-md-2 col-sm-2">
                    <div class="form-group">
                      <label for="FIELTRO_3">Fieltro #3</label>
                      <input type="text" step="any" class="form-control"  id="FIELTRO_3" name="FIELTRO_3" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TABLA_S">Tabla Superior</label>
                      <input type="text" step="any" class="form-control" id="TABLA_S" name="TABLA_S" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TABLA_I">Tabla Inferior</label>
                      <input type="text" step="any" class="form-control"  id="TABLA_I" name="TABLA_I" autocomplete="off" required>
                    </div>
                  </div>
                </div>  
                <div class="form-group">
                  <input id="continuar" type="submit" value="Continuar" class="btn btn-primary"onclick="PagRec()">
                </div>
              </form>';
            }
          }
//------------------------ REVISA QUE NO HALLA DATOS EN LAS TENSIONES 2
          If($yavalidado == 0){
          //--REVISION DE AGREGADO DE DATOS---
            $consulta3 = "SELECT TOP(1)BOM_NO, TENSION_P_INI_2 FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_TEN] WHERE BOM_NO ='" .strtoupper(($_GET["bom"])). "' AND TENSION_P_INI_2 IS NULL";
            $resultado3 = odbc_do($conn, $consulta3);
            $yavalidado = 2;
            while(odbc_fetch_row($resultado3)){
              $yavalidado = 1;
                    
                echo "<center><label><h4>Check List/Registro de Tensiones</h4></label></center>
                <center><label><h4>Juego 2</h4></label></center>";
                echo '<form id="datosform" method="post" action="insert_tensiones.php">
                </div>
                  </div>
                   <div class="row">
                   <div class= "col-lg-12 col-md-12 col-sm-12">
                   <input id="cancelar" type="submit" value="Cancelar" class="btn btn-warning" tyle="float:right;" onclick="cancelar()">
                   </div>
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <center><label>Lecturas en MPA</label></center>
                        <input type="hidden" name="MOTHER_BOM" value="'.$_GET['bom'].'">
                        <input type="hidden" name="WO_NO" value="'.strtoupper($_GET["wo"]).'">
                      </div>
                    </div>                                 
                  </div>
                  <div class="row">
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Tensión Pad</label>
                      </div>
                    </div>
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Tensión Break</label>
                      </div>
                    </div>                                        
                  </div>
                  <div class="row">
                    <div class= "col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group">
                        <label for="TENSION_P_INI_2">Inicio</label>
                       <input type="text" step="any" class="form-control" id="TENSION_P_INI_2" name="TENSION_P_INI_2" autocomplete="off" required>
                      </div>
                    </div>
                    <div class= "col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group">
                      <label for="TENSION_P_FIN_2">Final</label>
                      <input type="text" step="any" class="form-control"  id="TENSION_P_FIN_2" name="TENSION_P_FIN_2" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_B_INI_2">Inicio</label>
                      <input type="text" step="any" class="form-control" id="TENSION_B_INI_2" name="TENSION_B_INI_2" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_B_FIN_2">Final</label>
                      <input type="text" step="any" class="form-control"  id="TENSION_B_FIN_2" name="TENSION_B_FIN_2" autocomplete="off" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="METROS_CAMB_1">Metros al Cambio (Tensión Pad)</label>
                      <input type="text" step="any" class="form-control" id="METROS_CAMB_2" name="METROS_CAMB_2" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                  </div>                           
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="METRO_CAMB_2">Metros al Cambio (tensión Break)</label>
                      <input type="text"class="form-control" id="METRO_CAMB_2" name="METRO_CAMB_2" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_ROLL_2">Tension Roll</label>
                      <input type="text" class="form-control" id="TENSION_ROLL_2" name="TENSION_ROLL_2" autocomplete="off"required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                 <input id="continuar" type="submit" value="Continuar" class="btn btn-primary"onclick="PagRec()">
                </div>
              </form>';
            }
//-----------------------------REVISA QUE NO EXISTAN DATOS EN LAS TENSIONES 3           
          If($yavalidado == 2){
             $consulta3 = "SELECT TOP(1)BOM_NO, TENSION_P_INI_3 FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_TEN] WHERE BOM_NO ='" .strtoupper(($_GET["bom"])). "' AND TENSION_P_INI_3 IS NULL";
            $resultado3 = odbc_do($conn, $consulta3);
            $yavalidado = 3;
            while(odbc_fetch_row($resultado3)){
              $yavalidado = 1;
                    
                echo "<center><label><h4>Check List/Registro de Tensiones</h4></label></center>
                <center><label><h4>Juego 3</h4></label></center>";
                echo '<form id="datosform" method="post" action="insert_tensiones.php">
                </div>
                  </div>
                   <div class="row">
                   <div class= "col-lg-12 col-md-12 col-sm-12">
                   <input id="cancelar" type="submit" value="Cancelar" class="btn btn-warning" tyle="float:right;" onclick="cancelar()">
                   </div>
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <center><label>Lecturas en MPA</label></center>
                        <input type="hidden" name="MOTHER_BOM" value="'.$_GET['bom'].'">
                        <input type="hidden" name="WO_NO" value="'.strtoupper($_GET["wo"]).'">
                      </div>
                    </div>                                 
                  </div>
                  <div class="row">
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Tensión Pad</label>
                      </div>
                    </div>
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Tensión Break</label>
                      </div>
                    </div>                                        
                  </div>
                  <div class="row">
                    <div class= "col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group">
                        <label for="TENSION_P_INI_3">Inicio</label>
                       <input type="text" step="any" class="form-control" id="TENSION_P_INI_3" name="TENSION_P_INI_3" autocomplete="off" required>
                      </div>
                    </div>
                    <div class= "col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group">
                      <label for="TENSION_P_FIN_3">Final</label>
                      <input type="text" step="any" class="form-control"  id="TENSION_P_FIN_3" name="TENSION_P_FIN_3" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_B_INI_3">Inicio</label>
                      <input type="text" step="any" class="form-control" id="TENSION_B_INI_3" name="TENSION_B_INI_3" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_B_FIN_3">Final</label>
                      <input type="text" step="any" class="form-control"  id="TENSION_B_FIN_3" name="TENSION_B_FIN_3" autocomplete="off" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="METROS_CAMB_3">Metros al Cambio (Tensión Pad)</label>
                      <input type="text" step="any" class="form-control" id="METROS_CAMB_3" name="METROS_CAMB_3" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                  </div>                           
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="METRO_CAMB_3">Metros al Cambio (tensión Break)</label>
                      <input type="text"class="form-control" id="METRO_CAMB_3" name="METRO_CAMB_3" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_ROLL_3">Tension Roll</label>
                      <input type="text" class="form-control" id="TENSION_ROLL_3" name="TENSION_ROLL_3" autocomplete="off"required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                 <input id="continuar" type="submit" value="Continuar" class="btn btn-primary"onclick="PagRec()">
                </div>
              </form>';
            }
          
          If($yavalidado == 3){
             $consulta3 = "SELECT TOP(1)BOM_NO, TENSION_P_INI_4 FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_TEN] WHERE BOM_NO ='" .strtoupper(($_GET["bom"])). "' AND TENSION_P_INI_4 IS NULL";
            $resultado3 = odbc_do($conn, $consulta3);
            $yavalidado = 4;
            while(odbc_fetch_row($resultado3)){
              $yavalidado = 1;
                    
                echo "<center><label><h4>Check List/Registro de Tensiones</h4></label></center>
                <center><label><h4>Juego 4</h4></label></center>";
                echo '<form id="datosform" method="post" action="insert_tensiones.php">
                </div>
                  </div>
                   <div class="row">
                   <div class= "col-lg-12 col-md-12 col-sm-12">
                   <input id="cancelar" type="submit" value="Cancelar" class="btn btn-warning" tyle="float:right;" onclick="cancelar()">
                   </div>
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <center><label>Lecturas en MPA</label></center>
                        <input type="hidden" name="MOTHER_BOM" value="'.$_GET['bom'].'">
                        <input type="hidden" name="WO_NO" value="'.strtoupper($_GET["wo"]).'">
                      </div>
                    </div>                                 
                  </div>
                  <div class="row">
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Tensión Pad</label>
                      </div>
                    </div>
                    <div class= "col-lg-6 col-md-6 col-sm-6">
                      <div class="form-group">
                        <label>Tensión Break</label>
                      </div>
                    </div>                                        
                  </div>
                  <div class="row">
                    <div class= "col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group">
                        <label for="TENSION_P_INI_4">Inicio</label>
                       <input type="text" step="any" class="form-control" id="TENSION_P_INI_4" name="TENSION_P_INI_4" autocomplete="off" required>
                      </div>
                    </div>
                    <div class= "col-lg-3 col-md-3 col-sm-3">
                      <div class="form-group">
                      <label for="TENSION_P_FIN_4">Final</label>
                      <input type="text" step="any" class="form-control"  id="TENSION_P_FIN_4" name="TENSION_P_FIN_4" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_B_INI_4">Inicio</label>
                      <input type="text" step="any" class="form-control" id="TENSION_B_INI_4" name="TENSION_B_INI_4" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_B_FIN_4">Final</label>
                      <input type="text" step="any" class="form-control"  id="TENSION_B_FIN_4" name="TENSION_B_FIN_4" autocomplete="off" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="METROS_CAMB_4">Metros al Cambio (Tensión Pad)</label>
                      <input type="text" step="any" class="form-control" id="METROS_CAMB_4" name="METROS_CAMB_4" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                  </div>                           
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="METRO_CAMB_4">Metros al Cambio (tensión Break)</label>
                      <input type="text"class="form-control" id="METRO_CAMB_4" name="METRO_CAMB_4" autocomplete="off" required>
                    </div>
                  </div>
                  <div class= "col-lg-3 col-md-3 col-sm-3">
                    <div class="form-group">
                      <label for="TENSION_ROLL_4">Tension Roll</label>
                      <input type="text" class="form-control" id="TENSION_ROLL_4" name="TENSION_ROLL_4" autocomplete="off"required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                 <input id="continuar" type="submit" value="Continuar" class="btn btn-primary"onclick="PagRec()">
                </div>
              </form>';
            }
          
          If($yavalidado == 4){
            header("Location: Validacion_etiqueta_operador.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
            die();

          }
          }
          }
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



                  $(function() {

                  $("#datosform").submit(function(e) {
                    e.preventDefault();
                    var actionurl = e.currentTarget.action;
                    console.log($("#datosform").serialize());
                    var isvalid = $("#datosform").valid();
                    if (isvalid) {
                    $.ajax({
                        url: actionurl,
                        type: 'post',
                        data: $("#datosform").serialize(),
                        success: function(data) {
                              var str = data;
                              var res = str.split(",");
                              
                              if(res[0]=="Error"){
                                toastr.error(res[1], 'Error', {timeOut: 5000, positionClass: "toast-top-center"})
                              }
                              else if(res[0]=="Warning"){
                                toastr.warning(res[1], 'Warning', {timeOut: 5000, positionClass: "toast-top-center"})
                              }
                              else if(res[0]=="Ok"){
                                toastr.success(res[1], 'Datos guardados correctamente', {timeOut: 2500, positionClass: "toast-top-center"});
                                 var mensaje = confirm("Continuar en tensiones");
                                 if (mensaje) {
                                  window.location.replace("Validacion2.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"]; ?>");
                                }
                                else {
                                  window.location.replace("Validacion_etiqueta_operador.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"]; ?>");
                                }
                                
                              }
                              else{
                                toastr.error(data, 'Error ' + data, {timeOut: 5000, positionClass: "toast-top-center"})
                              }
                            }
                      });
                    }
                      //

                  });

                });
$(function() {
		$("#cancelar").click(function(e) {
			e.preventDefault();
			var actionurl = e.currentTarget.action;
			var mensaje = confirm("¿Cancelar datos?");				
			if (mensaje) {
						window.location.replace("Validacion_ancho_fin.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"]; ?>");
						}
						else{
						
						}
				
				});
		});




   
      </script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      </body>
</html>