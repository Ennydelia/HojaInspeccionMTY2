<?php
	include("php/variables.php");
	$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
	if (!$conn)
		die ("conexionerror");
	if(isset($_GET['bom'])){
		//REGISTRA LOS DATOS DEL ROLLO MADRE
		$consulta = "EXEC[MTY_PROD_SSM].[dbo].[SP_BOMS_INSPECCION_MTY] @WO_NO = '". strtoupper($_GET["wo"]) ."'";
		$resultado1 = odbc_do($conn, $consulta);
		$consulta2 = "EXEC[MTY_PROD_SSM].[dbo].[SP_INSPECCION_RM_MTY] @WO_NO = '". strtoupper($_GET["wo"]) ."'";
		$resultado2 = odbc_do($conn, $consulta2);
		$consulta3 = "EXEC[MTY_PROD_SSM].[dbo].[SP_INSPECCION_OND_RM] @BOM_NO = '". strtoupper($_GET["bom"]) ."'";
		$resultado3 = odbc_do($conn, $consulta3);	
		//-----INSPECCIONA QUE LOS DATOS NO HAYAN SIDO AGREGADOS ANTERIORMENTE----
		$consulta = "SELECT count(*) EDO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_OND_RM] WHERE BOM_NO = '". strtoupper($_GET["bom"]) ."' and NUM_OND is NULL ";
		$resultado = odbc_do($conn, $consulta);
		while (odbc_fetch_row($resultado)) {
			if(odbc_result($resultado, 1) <> "0"){
			}
			else{
				header("Location: Validacion_Peso_rollo.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
				die();
			}
		}
	}	
?>

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

							

					if(isset($_GET['bom']))
					{
										 
								echo "<center><label><h4>Inspeccion de Ondulacion de Rollos Madre</h4></label></center>";
								//REGISTRA LOS DATOS DEL ROLLO MADRE
								$consulta = "EXEC[MTY_PROD_SSM].[dbo].[SP_BOMS_INSPECCION_MTY] @WO_NO = '". strtoupper($_GET["wo"]) ."'";
								$resultado1 = odbc_do($conn, $consulta);
								$consulta2 = "EXEC[MTY_PROD_SSM].[dbo].[SP_INSPECCION_RM_MTY] @WO_NO = '". strtoupper($_GET["wo"]) ."'";
								$resultado2 = odbc_do($conn, $consulta2);
								$consulta3 = "EXEC[MTY_PROD_SSM].[dbo].[SP_INSPECCION_OND_RM] @BOM_NO = '". strtoupper($_GET["bom"]) ."'";
								$resultado3 = odbc_do($conn, $consulta3);
						
								//-----INSPECCIONA QUE LOS DATOS NO HAYAN SIDO AGREGADOS ANTERIORMENTE----
								$consulta = "SELECT count(*) EDO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_OND_RM] WHERE BOM_NO = '". strtoupper($_GET["bom"]) ."' and NUM_OND is NULL ";
									$resultado = odbc_do($conn, $consulta);
									while (odbc_fetch_row($resultado)) {
										if(odbc_result($resultado, 1) <> "0"){
								echo "<center font size = '30'>WO: ". strtoupper($_GET["wo"])." 
								RM: ". strtoupper($_GET["bom"])."</center>";
								include('php/DATOSCU.php');
							//SE EL ACOMODO DE DATOS 
								echo '<form id="datosform" method="post" action="insert_ondulaciones.php">
								</div>
								</div>
								 <div class="row">
									<div class= "col-lg-12 col-md-12 col-sm-12">
									<div class="form-group">
										<input type="hidden" name="MOTHER_BOM" value="'.$_GET['bom'].'">
										<input type="hidden" name="WO_NO" value="'.strtoupper($_GET["wo"]).'">
									</div>
									</div>                                 
									</div>
							
									<div class="row">
									<div class= "col-lg-6 col-md-6 col-sm-6">
									<div class="form-group">
										<label for="INICIO">Inicio</label>
										<input type="text" step="any" class="form-control" id="INICIO" name="INICIO" autocomplete="off" autofocus="on" required>
									</div>
									</div>
									 <div class= "col-lg-6 col-md-6 col-sm-6">
									<div class="form-group">
										<label for="NUM_OND">Num. de ondas</label>
										<input type="text" step="any" class="form-control"  id="NUM_OND" name="NUM_OND" autocomplete="off" required>
									</div>
									</div>
									</div>
									
									
									<div class="form-group">
									<button type="submit" class="btn btn-primary">Continuar </button>
									</div>
								</form>';

					}


					else{
					}
				}
			}
		

				
							?>



						</div>
				 </div>
			</div>
			<br/>
			<!-- ---------------------------------------------------------- -->
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
																window.location.replace("Validacion_Peso_rollo.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"];?>");
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
	 
			</script>
			<script src="js/popper.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			</body>
</html>