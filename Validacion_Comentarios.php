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
			if(isset($_GET['bom'])){
				$consulta = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_WO_C] @BOM_NO = '". strtoupper($_GET["bom"]) ."'";
				$resultado = odbc_do($conn, $consulta);
				echo "<center><h3>OBSERVACIONES FINALES </h3></center>";       
				echo "<h4>ROLLO MADRE: ".$_GET['bom']."</h4>";
				echo '<form id="datosform" action="" method="post" >
				<div class="row">
					<div class= "col-lg-4 col-md-4 col-sm-4">
						<div class="form-group">
							<label for="TURNO">Turno</label>
							<input type="hidden" name="MOTHER_BOM" value="'.strtoupper($_GET['bom']).'">
							<input type="hidden" name="WO_NO" value="'.strtoupper($_GET["wo"]).'">
							<input type="number" class="form-control" id="TURNO" name="TURNO" autocomplete="off" required>
						</div>
					</div>                                 
						<div class= "col-lg-5 col-md-5 col-sm-5">
							<div class="form-group">
								<label for="OPERADOR">Operador</label>
								<input type="text" step="any" class="form-control" id="OPERADOR" name="OPERADOR" autocomplete="off" autofocus="on" required>
							</div>
						</div>
					</div>			
					<div class="row">
						<div class= "col-lg-4 col-md-4 col-sm-4">
					 		<div class="form-group">
					 			<label for="OXIDO">Oxido</label>
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
						<input id="guardar" name="guardar"  type="submit" value="Guardar Informacion" class="btn btn-primary">
						<input id="continuar" name= "continuar"  type="submit" value="Mandar a Rechazo" class="btn btn-danger">
					</div>
				</form>';
//-----------------------------VALIDACION DEL OXIDO/CANTO OK---NO-OK-----------------------------------------//
			
			}
			else{
				echo "<h2>WO ".strtoupper($_GET["wo"])." VALIDADO.</h2>";
			}
		?>
	</div>
</div>
<br/>
<!-- --------------------------------------------------------------------------------------------------------------------- -->
	<script src="js/pikaday.js"></script>
	<link href="css/speech-input.css" rel="stylesheet">
	<script src="js/speech-input.js"></script>
	<script>
 	$(document).ready(function(){
		$('#bodymain').loading('stop');
	});
	$(function() {
		$("#guardar").click(function(e) {
			e.preventDefault();
			var actionurl = e.currentTarget.action;
			console.log($("#datosform").serialize());
			var isvalid = $("#datosform").valid();
			if (isvalid) {
				$.ajax({
					url: "insert_header.php",
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
							window.open("http://serlam2/servilaminamty/HojaInspeccion/HojaInspeccionSLT2.aspx");
							window.location.replace("Validado2.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"];?>");
						}
						else{
							toastr.error(data, 'Error ' + data, {timeOut: 5000, positionClass: "toast-top-center"})
						}
					}
				});
			}
		});
	});
//--------------------------------------ALERTA DE RECHAZO INTERNO------------------------------------------------//

$(function() {
		$("#continuar").click(function(e) {
			e.preventDefault();
			var actionurl = e.currentTarget.action;
			console.log($("#datosform").serialize());
			var isvalid = $("#datosform").valid();
			var mensaje = confirm("Mandar a rechazo interno: ");				
			if (mensaje) {
			if (isvalid) {
				$.ajax({
					url: "insert_header.php",
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
							window.open("http://mtyserlam1v1:8080/mtyblog/wp-login.php");
						window.location.replace("Rechazo_Validacion.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"]; ?>");
						}
						else{
							toastr.error(data, 'Error ' + data, {timeOut: 5000, positionClass: "toast-top-center"})
						}
					}
				});
			}
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