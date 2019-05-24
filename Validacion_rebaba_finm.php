<!DOCTYPE HTML>
<html lang="es">
	 <head>
			<title>Hoja de Inspeccion SLT2</title>
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
									$_GET["wo"] = str_replace(" ","",$_GET["wo"]);
									$_GET["bom"] = str_replace(" ","",$_GET["bom"]);
									$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
															if (!$conn)
																die ("conexionerror");

												 $consulta = "select top 1 MACHINE_CD existe_wo from openquery(hgdb,'select MACHINE_CD from WK04_WO_HEADER where company_cd = ''MTY'' and WO_NO = ''". strtoupper($_GET["wo"]) ."'' ')";
													$resultado = odbc_do($conn, $consulta); 
													while (odbc_fetch_row($resultado)) {
															$maquina = odbc_result($resultado, 1);

															odbc_do($conn, $consulta);
															$consulta = "select MOTHER_BOM from [MTY_PROD_SSM].[dbo].[SSM_INSPECCION]  WHERE MOTHER_BOM = '". strtoupper($_GET["bom"]) ."' and FINAL_CHECK is NULL or FINAL_CHECK = 0 AND MOTHER_BOM = '". strtoupper($_GET["bom"]) ."' order by PROD_LINE_NO";
															$resultado = odbc_do($conn, $consulta);	
															while (odbc_fetch_row($resultado)) {
																$FORMER_BOM = odbc_result($resultado, 1);
																$consulta = "SELECT count(*) EDO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."' and VAL_FIN_REBABA_MOTOR is NULL";
																$resultado = odbc_do($conn, $consulta);	
																while (odbc_fetch_row($resultado)) {
																	if(odbc_result($resultado, 1) <> "0"){
																			$consulta = "SELECT BOM_NO, convert(varchar(20),0) R1,  convert(varchar(20),REBABA) R2, VAL_FIN_REBABA_MOTOR FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."' order by PROD_LINE_NO, BOM_NO";
																			$resultado = odbc_do($conn, $consulta);
																			 echo "<center><h4>VALIDACION FINAL REBABA (LADO MOTOR)</h4></center>";	
																			echo "<center><h4>WO: ". strtoupper($_GET["wo"])."</h4></center>";
																			//aqui cambiar los IDs
																			echo '<form id="campovalidar" action="" method="post">';
																			echo '<table id="tabla-valor" class="table" style="width:100%"><tr><th colspan="2">ROLLO MADRE: '.$FORMER_BOM.'</th></tr><tr><th>BOM</th><th>MOTOR</th></tr>';
																			$count = 1;
																			while (odbc_fetch_row($resultado)) {
																					echo '<tr><td><abbr title="< '.odbc_result($resultado, 3).'" rel="tooltip">'.odbc_result($resultado, 1).'</abbr></td><td><input style="width:100px;" autocomplete="off" lang="es" type="number" id="'.odbc_result($resultado, 1).'" name="'.odbc_result($resultado, 1).'" value="'.odbc_result($resultado, 4).'"></td></tr>';
																					$count++;
																			}
																			//AQUI SE CAMBIA EL CAMPO A INSERTAR -------------------------------V
																			echo '<tr><td></td><td><input type="hidden" name="campo" value="VAL_FIN_REBABA_MOTOR"><input name="siguiente" id="siguiente" type="submit" class="btn btn-primary" value="Siguiente">&ensp;<input name="continuar" id="continuar" style="display:none;" type="submit" value="Mandar a Rechazo" class="btn btn-primary"onclick="PagRec()"></td></tr></table></form>';

																			//AQUI VA EL SCRIPT DE VALIDACION;
																		 echo" <script>
																					$(document).ready(function () {
																						$('#campovalidar').validate({ 
																								errorClass: 'invalid',
																								validClass: 'success',
																								rules: {";

																								$consulta = "SELECT BOM_NO, convert(varchar(20),0) R1,  convert(varchar(20),REBABA) R2, VAL_FIN_REBABA_MOTOR FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."' order by PROD_LINE_NO, BOM_NO";
																								$resultado = odbc_do($conn, $consulta);	
																								$count = 1;
																								while (odbc_fetch_row($resultado)) {
																										echo "".odbc_result($resultado, 1).": {
																												required: true,
																												min: ".odbc_result($resultado, 2).",
																												max: ".odbc_result($resultado, 3)."
																										},";
																										$count++;
																								}

																								echo  "extra: {
																												required: true
																										}
																								},";
																								echo "messages: {";
																								$consulta = "SELECT BOM_NO, convert(varchar(20),0) R1,  convert(varchar(20),REBABA) R2, VAL_FIN_REBABA_MOTOR FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."' order by PROD_LINE_NO, BOM_NO";
																								$resultado = odbc_do($conn, $consulta);	
																								while (odbc_fetch_row($resultado)) {
																										echo "".odbc_result($resultado, 1).": '',";
																								}
																						echo "extra: ''
																								}
																						});

																					});</script>";
	




																	}
																	else{
 
																					header("Location: Validacion_rebaba_fino.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
																			//}
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

					 $("input[type='number']").on("click", function () {
							$(this).select();
						});

			$(function() {
			$("#campovalidar").submit(function(e) {
				e.preventDefault();
				var actionurl = e.currentTarget.action;
				console.log($("#campovalidar").serialize());
				var isvalid = $("#campovalidar").valid();
				if (isvalid) {
					$.ajax({
						url: "insert_valores.php",
						type: 'post',
						data: $("#campovalidar").serialize(),
						success: function(data) {
							var str = data;
							var res = str.split(",");
															
															if(res[0]=="Error"){
																toastr.error(res[1], 'Error', {timeOut: 5000, positionClass: "toast-top-center"})
																$('#tabla-valor tr:last').after('<tr><td>...</td><td>...</td></tr>');
															}
															else if(res[0]=="Warning"){
																toastr.warning(res[1], 'Warning', {timeOut: 5000, positionClass: "toast-top-center"})
															}
															else if(res[0]=="Ok"){
																toastr.success(res[1], 'Datos correctos', {timeOut: 2500, positionClass: "toast-top-center"});
																<?PHP


																					echo "window.location.replace('Validacion_rebaba_fino.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]."')";
																			//}

																?>
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
		//-----------------------------SECCION DE RECHAZOS INTERNOS--------------------------------------

function PagRec() {
//Manda alerta para confirmar si desea mandar a rechazo interno 
	var mensaje = confirm("Mandar a rechazo interno: ");        
	if (mensaje) {              
		$(function() {

				console.log($("#campovalidar").serialize());
				$.ajax({
					url: "insert_valores.php",
					type: 'post',
					data: $("#campovalidar").serialize(),
					success: function(data) {
						var str = data;
						var res = str.split(",");             
						if(res[0]=="Error"){
							toastr.error(data, 'Error ', {timeOut: 5000, positionClass: "toast-top-center"})
							$('#tabla-valor tr:last').after('<tr><td>...</td><td>...</td></tr>');
						}
						else if(res[0]=="Warning"){
							toastr.warning(res[1], 'Warning', {timeOut: 5000, positionClass: "toast-top-center"})
						}
						else if(res[0]=="Ok"){
							toastr.success(res[1], 'Rechazado', {timeOut: 2500, positionClass: "toast-top-center"});
							window.open("http://mtyserlam1v1:8080/mtyblog/wp-login.php");
							window.location.replace("Rechazado.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"]; ?>");
						}
						else{
							toastr.error(data, 'Error ' + data, {timeOut: 5000, positionClass: "toast-top-center"})
						}
					}
				});
	
		});   
	}
	else {
	//alert("¡Haz denegado el mensaje!");
	}
}
$("#campovalidar").on('change', function() {
	var isvalid = $("#campovalidar").valid();
	if (isvalid) {
		$("#continuar").hide();
		$("#siguiente").show();
	} else {
		$('#siguiente').hide();
		$('#continuar').show();
 }
});   


					 $( function()
						{
								var targets = $( '[rel~=tooltip]' ),
										target  = false,
										tooltip = false,
										title   = false;
						
								targets.bind( 'mouseenter', function()
								{
										target  = $( this );
										tip     = target.attr( 'title' );
										tooltip = $( '<div id="tooltip"></div>' );
						
										if( !tip || tip == '' )
												return false;
						
										target.removeAttr( 'title' );
										tooltip.css( 'opacity', 0 )
													.html( tip )
													.appendTo( 'body' );
						
										var init_tooltip = function()
										{
												if( $( window ).width() < tooltip.outerWidth() * 1.5 )
														tooltip.css( 'max-width', $( window ).width() / 2 );
												else
														tooltip.css( 'max-width', 340 );
						
												var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ),
														pos_top  = target.offset().top - tooltip.outerHeight() - 20;
						
												if( pos_left < 0 )
												{
														pos_left = target.offset().left + target.outerWidth() / 2 - 20;
														tooltip.addClass( 'left' );
												}
												else
														tooltip.removeClass( 'left' );
						
												if( pos_left + tooltip.outerWidth() > $( window ).width() )
												{
														pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
														tooltip.addClass( 'right' );
												}
												else
														tooltip.removeClass( 'right' );
						
												if( pos_top < 0 )
												{
														var pos_top  = target.offset().top + target.outerHeight();
														tooltip.addClass( 'top' );
												}
												else
														tooltip.removeClass( 'top' );
						
												tooltip.css( { left: pos_left, top: pos_top } )
															.animate( { top: '+=10', opacity: 1 }, 50 );
										};
						
										init_tooltip();
										$( window ).resize( init_tooltip );
						
										var remove_tooltip = function()
										{
												tooltip.animate( { top: '-=10', opacity: 0 }, 50, function()
												{
														$( this ).remove();
												});
						
												target.attr( 'title', tip );
										};
						
										target.bind( 'mouseleave', remove_tooltip );
										tooltip.bind( 'click', remove_tooltip );
								});
						});

	 
			</script>
			<script src="js/popper.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			</body>
</html>