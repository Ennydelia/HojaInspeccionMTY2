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
				<br/>
				<br/>
				 <div class="row">
							<div class= "col-lg-12 col-md-12 col-sm-12">

							<?php
							include("php/variables.php");
							$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
															if (!$conn)
																die ("conexionerror");

							

					if(isset($_GET['bom']))
					{
							$consulta3 = "EXEC[MTY_PROD_SSM].[dbo].[SP_BOMS_INSPECCION_MTY] @WO_NO = '". strtoupper($_GET["wo"]) ."'";
							$resultado1 = odbc_do($conn, $consulta3);
							$consulta3 = "EXEC[MTY_PROD_SSM].[dbo].[SP_TOL_INSPECCION_MTY] @WO_NO = '". strtoupper($_GET["wo"]) ."'";
							$resultado3 = odbc_do($conn, $consulta3);
															$consulta4 = "EXEC[MTY_PROD_SSM].[dbo].[SP_INSPECCION_ONDULACIONES] @WO_NO = '". strtoupper($_GET["wo"]) ."'";
								$resultado4 = odbc_do($conn, $consulta4);
							$consulta6 = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_T] @BOM_NO = '". strtoupper($_GET["bom"]) ."'";
						odbc_do($conn, $consulta6);
							$consulta5 = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_WO_C] @BOM_NO = '". strtoupper($_GET["bom"]) ."'";
							odbc_do($conn, $consulta5);
							 $consulta = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_RECHAZO] @MOTHER_BOM = '". strtoupper($_GET["bom"]) ."'";
							odbc_do($conn, $consulta);
						 $consulta2 = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_RECHAZO2] @MOTHER_BOM = '". strtoupper($_GET["bom"]) ."'";
						 odbc_do($conn, $consulta2);
						 $consulta8 = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_UPDATE] @BOM = '". strtoupper($_GET["bom"]) ."'";
							odbc_do($conn, $consulta8);
							
								$consulta = "SELECT count(*) EDO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_RECHAZO] WHERE MOTHER_BOM = '". strtoupper($_GET["bom"]) ."' and VAL_CARLITE_FIN is not NULL ";
									$resultado = odbc_do($conn, $consulta);
									while (odbc_fetch_row($resultado)) {
										if(odbc_result($resultado, 1) > "0"){
								
						
						

								echo "<center><h4>OBSERVACIONES RECHAZO </h4></center>";       
								echo "<h4>ROLLO MADRE: ".$_GET['bom']."</h4>";
								echo '<form id="datosform" method="post" action="insert_rechazo.php">
								</div>
								</div>
								 <div class="row">
									<div class= "col-lg-4 col-md-4 col-sm-4">
									<div class="form-group">
										<label for="TURNO">Turno</label>
										<input type="hidden" name="MOTHER_BOM" value="'.strtoupper($_GET['bom']).'">
										<input type="hidden" name="WO_NO" value="'.strtoupper($_GET["wo"]).'">
										<input type="number" class="form-control" id="TURNO" name="TURNO" autocomplete="off" autofocus="on" required>
									</div>
									</div>                                 
									<div class= "col-lg-5 col-md-5 col-sm-5">
									<div class="form-group">
										<label for="OPERADOR">Operador</label>
										<input type="text" step="any" class="form-control" id="OPERADOR" name="OPERADOR" autocomplete="on" required>
									</div>
									</div>
									</div>
									
									<div class="row">
									<div class= "col-lg-4 col-md-4 col-sm-4">
									 <div class="form-group">
										<label for="OXIDO">Oxido</label> &ensp;
										<label>(OK/NO OK)</label>
										<input type="text" step="any" class="form-control" id="OXIDO" name="OXIDO" autocomplete="off" required>
									</div>
									</div>
									</div>
									<div class="row">
									<div class= "col-lg-4 col-md-4 col-sm-4">
									<div class="form-group">
										<label for="CAN_PIC">Validacion de cantos sin picos</label> &ensp;
										<label>(OK/NO OK)</label>
										<input type="text" class="form-control" id="CAN_PIC" name="CAN_PIC" autocomplete="off" required>
									</div>
									</div>
									<div class= "col-lg-5 col-md-5 col-sm-5">
									 <div class="form-group">
										<label for="OBS_CAN_PIC">Observaciones</label>
										<textarea rows="1" class="form-control id="OBS_CAN_PIC" name="OBS_CAN_PIC" autocomplete="off"></textarea> 
									</div>
									</div>
									</div>
									<div class="form-group">
								
									
										<label for="COMENTARIOS">Comentarios</label>
										<br/>
										<label >Registrar cualquier defecto encontrado (Basarse en el catalogo de defectos)</label>
										<textarea rows="4" class="form-control" id="COMENTARIOS" name="COMENTARIOS" autocomplete="off"></textarea> 
									</div>
									
									<div class="form-group">
									<button type="submit" class="btn btn-primary">Guardar Rechazo</button>
									</div>
								</form>';

					}
					else{

						header("Location: Rechazado2.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
											die();

		 

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
																window.location.replace("Rechazado2.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"];?>");
																window.open("http://serlam2/servilaminamty/HojaInspeccion/HojaInspeccionSLT2R.aspx");
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