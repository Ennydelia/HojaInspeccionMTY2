<!DOCTYPE html>
<html lang="es">
		<head>
			<title>Hoja de Inspeccion SLT2</title>
			<!-- Required meta tags -->
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<?php include("php/Pagina_Inicio.php"); ?>
	
			<!--------CONSULTA DE WO_NO-------->
			<div class="container-fluid">
					<br/>
					<br/>
					<div class="row">
						 <div class= "col-lg-6 col-md-6 col-sm-6">
						 <form action="Validacion.php" method="get"> 
								<div class="form-group col-md-8">
									<label class="col-sm-4 col-form-label">NO ORDEN:</label>
									<input type="text" class="col-SM-2 lg-6 form-control" id="wo" name="wo" required="required" autocomplete="off" placeholder="WO NO" aria-label="WO NO" lang="es">
									
									<input id="consultar" type="button" value="Consultar" class="btn btn-primary  lg-6 col-SM-4" onclick="DSQL()"> 
								</div>
						</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
					<div class= "col-lg-6 col-md-6 col-sm-6">
					 <select name='bom' id="DSQL2" class='col-md-12 col form-control' onchange='myFunction(this.value)' style="display:none;">
						</select>         
						</div>
					<input id="continuar" style="display:none;" type="submit" value="Continuar" class="btn btn-primary">
				</div>
				
					<div class="form-group col-md-8">
					
						<div class= "col-lg-14 col-md-14 col-sm-14">
							<div class="form-group col-md-14" id="DSQL">
						</form>
					</div>
			</div>
			</div>
		</form>
	</div>
			</br>
 
				<script src="js/pikaday.js"></script>
				<link href="css/speech-input.css" rel="stylesheet">
				<script src="js/speech-input.js"></script>
				<script>

						 $(document).ready(function()
					 {
							 $('#bodymain').loading('stop');
							
					 });

					 function DSQL() {
							 $("#continuar").show();
							 $("#DSQL2").show();

							 $.ajax({url: "Informacion_index.php?wo=" + $("#wo").val(), success: function(result){
							 $("#DSQL").html(result);
							 }});
							 $.ajax({url: "Informacion_index2.php?wo=" + $("#wo").val(), success: function(result){
							 $("#DSQL2").html(result);
							 }});

							 $("#consultar").hide();
						}
						
			</script>
			<script src="js/popper.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
		</body>
	</head>
</html>