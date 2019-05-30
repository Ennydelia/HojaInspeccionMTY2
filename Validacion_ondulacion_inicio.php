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
															$maquina = odbc_result($resultado, 1);//ESTA ES LA MAQUINA DONDE SE CORTA SLITTER SE MIDE AL PRINCIPIO Y AL FINAL
															$consulta = "select MOTHER_BOM from [MTY_PROD_SSM].[dbo].[SSM_INSPECCION]  WHERE MOTHER_BOM = '". strtoupper($_GET["bom"]) ."' and FINAL_CHECK is NULL or FINAL_CHECK = 0  AND MOTHER_BOM = '". strtoupper($_GET["bom"]) ."'order by PROD_LINE_NO";//OBTIENE LOS FORMERS BOMS DE ESE WO
															$resultado = odbc_do($conn, $consulta);  
															$yavalidado = 1;
															while (odbc_fetch_row($resultado)) {
																$yavalidado = 0;
																$FORMER_BOM = odbc_result($resultado, 1);
																$consulta = "SELECT count(*) EDO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."' and VAL_ONDULACION_INI is NULL";// IF HAY NULOS EN LA EVALUACION ANCHO_INICIO
																$resultado = odbc_do($conn, $consulta); 
																while (odbc_fetch_row($resultado)) {
																	if(odbc_result($resultado, 1) <> "0"){//SI HAY NULOS MUESTRA LOS CAMPOS PARA LLENAR VALORES
																			$consulta = "SELECT BOM_NO,  convert(varchar(20),ONDULACIONES) ONDULACION, VAL_ONDULACION_INI FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."' order by PROD_LINE_NO, BOM_NO";
																			$resultado = odbc_do($conn, $consulta);
																			echo "<center><h4> VALIDACION ONDULACION INICIO</center>";	
																			echo "<center><h4>WO: ". strtoupper($_GET["wo"])."</h4></center>";
																			echo "<input name='liberar' id='liberar' type='submit' class='btn btn-warning' style='float:right; display:none;' value='Liberar' onclick='Liberar()'>";
																			echo '</br>';
																			echo '</br>';
																
																			//aqui cambiar los IDs
																			echo '<form id="campovalidar" action="" method="post">';
																			echo '<table id="tabla-valor" class="table" style="width:100%"><tr><th colspan="2">ROLLO MADRE: '.$FORMER_BOM.'</th></tr><tr><th>BOM</th><th>INICIO ONDULACION</th></tr>';
																			$count = 1;
																			while (odbc_fetch_row($resultado)) {
																					echo '<tr><td><abbr title="<'.odbc_result($resultado, 2).'" rel="tooltip">'.odbc_result($resultado, 1).'</abbr></td><td><input style="width:100px;" autocomplete="off" lang="es" type="number" id="'.odbc_result($resultado, 1).'" name="'.odbc_result($resultado, 1).'" value="'.odbc_result($resultado, 3).'"></td></tr>';
																					$count++;
																			}
																			//AQUI SE CAMBIA EL CAMPO A INSERTAR -------------------------------V
																			echo '<tr><td></td><td><input type="hidden" name="campo" value="VAL_ONDULACION_INI"><input name="siguiente" id="siguiente" type="submit" class="btn btn-primary" value="Siguiente">&ensp;<input name="continuar" id="continuar" style="display:none;" type="submit" value="Mandar a Rechazo" class="btn btn-danger"onclick="PagRec()"></td></tr></table></form>';

																			//AQUI VA EL SCRIPT DE VALIDACION;
																		 echo" <script>
																					$(document).ready(function () {
																						$('#campovalidar').validate({ 
																							errorClass: 'invalid',
																							validClass: 'success',
																							errorPlacement: function(){
																								$('#liberar').show();
																								$('#continuar').show();
																								$('#siguiente').hide();
																								
																								},
																								rules: {";

																								$consulta = "SELECT BOM_NO,  convert(varchar(20),ONDULACIONES) ONDUACION, VAL_ONDULACION_INI FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."' order by PROD_LINE_NO, BOM_NO";
																								$resultado = odbc_do($conn, $consulta);	
																								$count = 1;
																								while (odbc_fetch_row($resultado)) {
																										echo "".odbc_result($resultado, 1).": {
																												required: true,
																												max: ".odbc_result($resultado, 2)."
																										},";
																										$count++;
																								}

																								echo  "extra: {
																												required: true
																										}
																								},";
																								echo "messages: {";
																								$consulta = "SELECT BOM_NO,  convert(varchar(20),ONDULACIONES) ONDULACION,  VAL_ONDULACION_INI FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."' order by PROD_LINE_NO, BOM_NO";
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
																			//REDIRIGE A LA SIGUIENTE EVALUCION (NUMERO DE ONDAS INICIO)
																			header("Location: Validacion_num_ondas_inicio.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
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
												//var mensaje = confirm("¿Continuar con las tensiones?");
             						//	if (mensaje) {
                  	// 		window.location.replace("val_tensiones.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"]; ?>");
            				//}
              				//else {
               				window.location.replace("Validacion_num_ondas_inicio.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"]; ?>");
             				//}
								}
								else{
								toastr.error(data, 'Error ' + data, {timeOut: 5000, positionClass: "toast-top-center"})
								}
							}
						});
					}
					

					});

				});
								//FUNCION QUE REDIRIGE A LA PAGINA DE RECHAOS INTERNOS
						function PagRec() {
						//Manda alerta para confirmar si desea mandar a rechazo interno	
						var mensaje = confirm("Mandar a rechazo interno: ");
						
						if (mensaje) {
								
						$(function() {
		

								console.log($("#campovalidar").serialize());
								//var isvalid = $("#campovalidar").valid();
								//if (isvalid) {
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
						//RESTABLECER TODO CON LA CLAVE DE USUARIO DE INSPECTORES 
						function Liberar() {
		$.confirm({
			title: 'Desbloquear informacion',
    	content: '' +
    	'<form action="" class="formName">' +
    	'<div class="form-group">' +
    	'<label>Porfavor escriba la clave:</label>' +
    	'<input type="password" placeholder="clave" class="name form-control" required />' +
    	'</div>' +
   		'</form>',
			 buttons: {
      	formSubmit: {
      	  text: 'Aceptar',
          btnClass: 'btn-red',
          action: function () {
          var name = this.$content.find('.name').val();
					//CLAVE ESPECIAL PARA INSPECTORES/CALIDAD 
          if(name == 'Inspectores2019' || name == 'Calidad2019') {
            $.alert('Datos desbloqueados');
					var validator = $( "#campovalidar" ).validate();
					validator.resetForm();
					$("#continuar").hide();
					$("#siguiente").show();
					$("#liberar").hide();
					// $("#campovalidar").removeAttr("readonly");
					// $("#campovalidar")[0].reset();	
          }
					else{
						$.alert('Clave incorrecta');
            return false;
          }
				}
      },
      cancel: function () {
      //close
      },
    },
    onContentReady: function () {
    // bind to events
    	var jc = this;
      this.$content.find('form').on('submit', function (e) {
      	 // if the user submits the form by pressing enter in the field.
        e.preventDefault();
        jc.$$formSubmit.trigger('click'); // reference the button and click it
      });
    }
	});
}
	
					
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
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
			</body>
</html>