<!DOCTYPE HTML>
<html lang="es">
<head>
	<title>Hoja de Inspeccion SLT2</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php include("php/Pagina_inicio.php"); ?>
	<!-- ------------------------- -->
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
				//------ INICIAMOS CON LA BUSQUEDA DE DATOS DEPENDIENDO DEL ROLLO MADRE (BOM_NO) ---------
				$consulta = "select count(WO_NO) existe_wo from openquery(hgdb,'select WO_NO from WK07_WO_RM where company_cd = ''MTY'' and WO_NO = ''". strtoupper($_GET["wo"]). "'' and BOM_NO = ''". strtoupper($_GET["bom"]) ."'' ')";
						$resultado = odbc_do($conn, $consulta);	
				while (odbc_fetch_row($resultado)) {
					if (odbc_result($resultado, 1) == "0"){
						echo "<script>$('#bodymain').loading('stop');</script>";
						echo "<h3>". strtoupper($_GET["wo"]) . " o " . strtoupper($_GET["bom"]) ." no existen.</h3>";
					}
					else{
						//------ BUSCAMOS LA MAQUINA EN LA QUE SE REALIZA LA INSPECCION O CORTE (WO_NO) -------
						$consulta = "select top 1 MACHINE_CD existe_wo from openquery(hgdb,'select MACHINE_CD from WK04_WO_HEADER where company_cd = ''MTY'' and WO_NO = ''". strtoupper($_GET["wo"]) ."'' ')";
						$resultado = odbc_do($conn, $consulta); 
						while (odbc_fetch_row($resultado)) {
							$maquina = odbc_result($resultado, 1);//RECTIFICA QUE SEA LLA MAQUINA A CORTAR INICIO-FINAL
							//------ INICIAN LOS SP PARA AGREGAR LOS DATOS (ROLLO MADRE, NOTAS, ORDEN INSPECCION) ------ 
							$consulta3 = "EXEC[MTY_PROD_SSM].[dbo].[SP_TOL_INSPECCION_MTY] @WO_NO = '". strtoupper($_GET["wo"]) ."'";
							$resultado3 = odbc_do($conn, $consulta3);
							
							//--- SE BUSCA QUE EL ROLLO MADRE SOLICITADO NO HALLA SIDO VALIDADO YA ---

							$resultado = odbc_do($conn, $consulta); 
							$yavalidado = 1;
							while (odbc_fetch_row($resultado)) {
								$yavalidado = 0;
								//--- REVISA QUE EXISTAN CAMPOS NULOS EN LA CONSULTA
								$consulta = "SELECT count(*) EDO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_RM_RECHAZO] WHERE MOTHER_BOM = '". strtoupper($_GET["bom"]) ."'  AND VAL_ANCHO_INI IS NULL ";
								$resultado = odbc_do($conn, $consulta); 
								while (odbc_fetch_row($resultado)) {
									if(odbc_result($resultado, 1) <> "0"){
										$consulta = "SELECT TOP 1 MOTHER_BOM, convert(varchar(20),PESO_INI) PESO_INI, Convert(varchar(20), MIN_PESO_INI) IN_PESO_INI, convert(varchar(20), MAX_PESO_INI) MAX_PESO_INI, convert(varchar(20),ANCHO_INI) ANCHO_INI, convert(varchar(20), MIN_ANCHO_INI) MIN_ANCHO_INI, convert(varchar(20), MAX_ANCHO_INI) MAX_ANCHO_INI, convert(varchar(20),ESPESOR_INI) ESPESOR_INI, VAL_PESO_INI, VAL_ANCHO_INI, VAL_ESPESOR_INI, CUSTOMER_NAME FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_RM_RECHAZO] WHERE MOTHER_BOM = '". strtoupper($_GET["bom"]) ."'";
										$resultado = odbc_do($conn, $consulta); 
										//echo "<center>WO: ". strtoupper($_GET["wo"])."</center>";
										//--- CREAMOS LA TABLA PARA PODER ACOMODAR LOS DATOS
										echo '<form id="campovalidar" action="insert_rechazo2.php" method="post">';
										echo '<center><h4>DATOS DEL ROLLO RECIBIDO (RECHAZO)</h4></center>';
										echo "<center><h4>WO: ". strtoupper($_GET["wo"])."</h4></center>";
										//echo '<table id="tabla-valor" class="table" style="width:100%"><tr><th colspan="1">ROLLO MADRE:</th><th>PESO</th><th>ANCHO</th><th>ESPESOR</th></tr>';
										$count = 1;
										while (odbc_fetch_row($resultado)) {
											echo '<table id="tabla-valor" class="table" style="width:100%"><tr><th colspan="1">ROLLO MADRE:</th><th><abbr title="'.odbc_result($resultado, 6).'-'.odbc_result($resultado, 7).'" rel="tooltip">ANCHO</abbr></th><th></th><th></th></tr>';
											echo '<tr><td>'.odbc_result($resultado, 1).'</td><td><input style="width:100px;" autocomplete="off" lang="es" type="number" id="'.odbc_result($resultado, 1).'" name="'.odbc_result($resultado, 1).'" value="'.odbc_result($resultado, 10).'"></td><td></td><td></td></tr>';
											$count++;
										}
										//--- SE CREA EL BOTON DE CONTINUAR ---
										echo '<tr><td></td><td><input type="hidden" name="campo" value="VAL_ANCHO_INI"><input id="Siguiente" type="submit" class="btn btn-primary" value="Siguiente">&ensp;<input id="continuar" style="display:none;" type="submit" value="Mandar a Rechazo" class="btn btn-primary"onclick="PagRec()"></td></tr></table></form>';
										//--- INICIAMOS VALIDACION DE LOS 3 CAMPOS ---
										}
									else{
										//MOSTRAR LA SIGUIENTE EVALUACION (ESPESOR ROLLO MADRE)
										header("Location: Rechazo_Espesor_rollo.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
										die();
									}
								}
							}
					
							}
						}
					}
				?>
			</div>
		</div>
	</div>
	<br/>
	<div><?php include("php/NotasInspeccion.php"); ?></div>
	<!-- ------------------------------------------------------------------------------------------------------------------------------------ -->

		<script src="js/pikaday.js"></script>
		<link href="css/speech-input.css" rel="stylesheet">
		<script src="js/speech-input.js"></script>
		<script>
		$(document).ready(function(){
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
						url: actionurl,
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
								window.location.replace("Rechazo_Espesor_rollo.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"]; ?>");
							}
							else{
								toastr.error(data, 'Error ' + data, {timeOut: 5000, positionClass: "toast-top-center"})
							}
						}
					});
				}
			});
		});

//--------------VISUALIZACION DE BOTONES-------------------
		$("#campovalidar").on('change', function() {
			var isvalid = $("#campovalidar").valid();
			if (isvalid) {
				$("#continuar").hide();
				$("#Siguiente").show();
			} 
			else {
				$('#Siguiente').hide();
				$('#continuar').show();
			}
		});

//FUNCION QUE REDIRIGE A LA PAGINA DE RECHAOS INTERNOS
		function PagRec() {
			//Manda alerta para confirmar si desea mandar a rechazo interno 
			var mensaje = confirm("¿Desea mandar a Rechazo Interno?");
			if (mensaje) {
				window.open("http://mtyserlam1v1:8080/mtyblog/wp-login.php");
				window.location.replace("rechazo.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"]; ?>");
			}
			else {
				//alert("¡Haz denegado el mensaje!");
				}
		}
					
	$( function(){
		var targets = $( '[rel~=tooltip]' ),
		target  = false,
		tooltip = false,
		title   = false;
		targets.bind( 'mouseenter', function(){
			target  = $( this );
			tip     = target.attr( 'title' );
			tooltip = $( '<div id="tooltip"></div>' );
			if( !tip || tip == '' )
				return false;
			target.removeAttr( 'title' );
			tooltip.css( 'opacity', 0 )
			.html( tip )
			.appendTo( 'body' );
			var init_tooltip = function(){
				if( $( window ).width() < tooltip.outerWidth() * 1.5 )
					tooltip.css( 'max-width', $( window ).width() / 2 );
				else
					tooltip.css( 'max-width', 340 );
				var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ),
				pos_top  = target.offset().top - tooltip.outerHeight() - 20;
				if( pos_left < 0 ){
					pos_left = target.offset().left + target.outerWidth() / 2 - 20;
					tooltip.addClass( 'left' );
				}
				else
					tooltip.removeClass( 'left' );
				if( pos_left + tooltip.outerWidth() > $( window ).width() ){
					pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
					tooltip.addClass( 'right' );
				}
				else
					tooltip.removeClass( 'right' );
				if( pos_top < 0 ){
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
			var remove_tooltip = function(){
				tooltip.animate( { top: '-=10', opacity: 0 }, 50, function(){
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


	