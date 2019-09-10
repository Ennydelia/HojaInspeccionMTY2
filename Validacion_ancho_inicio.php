<!-- MENU DE INICIO-->
<?php include("php/Pagina_inicio.php"); ?>
<!--SOLO PARA VALIDAR EN EL ROLLO YA EXISTE INFORMACION VALIDADA-->
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
	    $consulta4 = "EXEC[MTY_PROD_SSM].[dbo].[SP_INSPECCION_ONDULACIONES] @WO_NO = '". strtoupper($_GET["wo"]) ."'";
		$resultado5 = odbc_do($conn, $consulta4);           	
		$consulta = "select ISNULL(MOTHER_BOM, 'BALANCE') AS MOTHER_BOM from [MTY_PROD_SSM].[dbo].[SSM_INSPECCION]  WHERE MOTHER_BOM = '". strtoupper($_GET["bom"]) ."'  AND WO_NO = '". strtoupper($_GET["wo"]) ."' and FINAL_CHECK is NULL or FINAL_CHECK = 0 and  MOTHER_BOM = '". strtoupper($_GET["bom"]) ."'  AND WO_NO = '". strtoupper($_GET["wo"]) ."' order by PROD_LINE_NO";//OBTIENE LOS FORMERS BOMS DE ESE WO
		$resultado = odbc_do($conn, $consulta);  
		$yavalidado = 1;
		while (odbc_fetch_row($resultado)) {
		    $yavalidado = 0;
		    $FORMER_BOM = odbc_result($resultado, 1);
		    $consulta = "SELECT count(*) EDO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."'  AND WO_NO = '". strtoupper($_GET["wo"]) ."' and VAL_INI_ANCHO is NULL";// IF HAY NULOS EN LA EVALUACION ANCHO_INICIO
		    $resultado = odbc_do($conn, $consulta); 
		    while (odbc_fetch_row($resultado)) {
		 		if(odbc_result($resultado, 1) <> "0"){
				}
				else{
					header("Location: Validacion_espesor_inicio.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
					die();
				}
			}
		}
		if($yavalidado == 1){
			header("Location: Validado.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
			die();
		}
	}
?>
<!---- DISEÑO HTML/PHP PARA LAS VARIABLES -->
<!DOCTYPE HTML>
<html lang="es">
<head>
<title>Hoja de Inspeccion SLT2</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
				$consulta = "select ISNULL(MOTHER_BOM, 'BALANCE') AS MOTHER_BOM FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_RM] WHERE MOTHER_BOM = '". strtoupper($_GET["bom"]) ."' AND WO_NO = '". strtoupper($_GET["wo"]) ."'";
				$resultado = odbc_do($conn, $consulta);
				while (odbc_fetch_row($resultado)) {
					$FORMER_BOM = odbc_result($resultado, 1);
					//SI HAY NULOS MUESTRA LOS CAMPOS PARA LLENAR VALORES
					$consulta = "SELECT ISNULL(BOM_NO, '') AS BOM_NO,  convert(varchar(20),MIN_ANCHO) MIN_ANCHO,  convert(varchar(20),MAX_ANCHO) MAX_ANCHO, VAL_INI_ANCHO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."' AND WO_NO = '". strtoupper($_GET["wo"]) ."' order by PROD_LINE_NO, BOM_NO";
					$resultado = odbc_do($conn, $consulta); 
					echo "<center><h4>VALIDACION INICIO ANCHO</h4></center>";
					echo "<center><h4>WO: ". strtoupper($_GET["wo"])."</h4></center>";
					echo "<input type='hidden' name='wo_no' id='wo_no' value='". strtoupper($_GET["wo"])."'>";
					echo "<input type='hidden' name='bom' id='bom' value='". strtoupper($_GET["bom"])."'>";	
					echo "<input name='liberar' id='liberar' type='submit' class='btn btn-warning' style='float:right; display:none;' value='Liberar' onclick='Liberar()'>";
					echo '</br>';
					echo '</br>';
					//aqui cambiar los IDs
					echo '<form id="campovalidar" action="" method="post">'; 
					echo '<table id="tabla-valor" class="table" style="width:100%"><tr><th colspan="2">ROLLO MADRE: '.$FORMER_BOM.'</th></tr><tr><th>BOM</th><th>INICIO ANCHO</th></tr>';
					$count = 1;
					while (odbc_fetch_row($resultado)) {
						echo '<tr><td><abbr title="'.odbc_result($resultado, 2).' - '.odbc_result($resultado, 3).'" rel="tooltip">'.odbc_result($resultado, 1).'</abbr></td>
						<td><input style="width:100px;" autocomplete="off" lang="es" autofocus="on"   type="number" id="'.odbc_result($resultado, 1).'" name="'.odbc_result($resultado, 1).'" value="'.odbc_result($resultado, 4).'"></td></tr>';
						$count++;
					} 
					//AQUI SE CAMBIA EL CAMPO A INSERTAR
					echo '<tr><td></td><td><input type="hidden" name="campo" value="VAL_INI_ANCHO"><input name="siguiente" id="siguiente" type="submit" class="btn btn-primary" value="Siguiente">&ensp;<input name="continuar" id="continuar" style="display:none;" type="button" value="Mandar a Rechazo" class="btn btn-danger"onclick="PagRec()"></td></tr></table></form>';
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
									$consulta = "SELECT BOM_NO,  convert(varchar(20),MIN_ANCHO) MIN_ANCHO,  convert(varchar(20),MAX_ANCHO) MAX_ANCHO, VAL_INI_ANCHO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."'  AND WO_NO = '". strtoupper($_GET["wo"]) ."' order by PROD_LINE_NO, BOM_NO";
									$resultado = odbc_do($conn, $consulta); 
									$count = 1;
									while (odbc_fetch_row($resultado)) {
										echo "".odbc_result($resultado, 1).": {
											required: true,
											min: ".odbc_result($resultado, 2).",
											max: ".odbc_result($resultado, 3).",	
										},";
										$count++;
									}
									echo  "extra: {
										required: true
									},
								},";
								echo "messages: {";
									$consulta = "SELECT BOM_NO,  convert(varchar(20),MIN_ANCHO) MIN_ANCHO,  convert(varchar(20),MAX_ANCHO) MAX_ANCHO, VAL_INI_ANCHO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE MOTHER_BOM = '".$FORMER_BOM."'  AND WO_NO = '". strtoupper($_GET["wo"]) ."' order by PROD_LINE_NO, BOM_NO";
									$resultado = odbc_do($conn, $consulta); 
									while (odbc_fetch_row($resultado)) {
										echo "".odbc_result($resultado, 1).": '',";
									}
									echo "extra: ''
								},												
							});	
						});
					</script>";
				}
			?>
		</div>
	</div>
</div>
<!-- ---------------------------------------------------------- -->
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
//Desactiva la tecla enter al tener el boton de rechazo activo
	$('#campovalidar').bind('keydown', function(e) {
		if (e.which == 13) {
	 		return false;
		}
	});

//------------------SE INICIA A VALIDAR LOS CAMPOS-------------------------
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
        	       		window.location.replace("Validacion_espesor_inicio.php?wo=<?php echo $_GET["wo"]."&bom=".$_GET["bom"]; ?>");
					}
				  	else{
						toastr.error(data, 'Error ' + data, {timeOut: 5000, positionClass: "toast-top-center"})
					}
				}
			});
		}
	});
});
//------------------FUNCION QUE REDIRIGE A LA PAGINA DE RECHAOS INTERNOS-------------------------------------
function PagRec() {
	$.confirm({
		title: 'Mandar a Rechazo Interno',
    	content: 'Para mandar a Rechazo es necesaria la clave de acceso:' +
    	'<form action="" class="formName">' +
    	'<div class="form-group">' +		
    	'<input type="password" placeholder="clave" class="password form-control" required />' +
    	'</div>' +
   		'</form>',
    	buttons: {
      		formSubmit: {
				text: 'Aceptar',
				btnClass: 'btn-red',
				action: function () {
					var name = this.$content.find('.password').val();
					//CLAVE ESPECIAL PARA INSPECTORES/CALIDAD 
					if(name == 'CT101010' || name == 'JJ651510' ||name == 'FP654417' || name == 'AS622461' ||name == "IO734384"||name == 'IO731603' || name == 'IO756514'||name == 'SP916101' || name == 'SP957102'||name == 'SP936703' || name == 'SP991604'||name == 'SP988605'||name == 'SP948506'||name == 'SP928607'||name == 'SP908908'||name == 'SP968009' ||name =='SP934311' ) 
					{
						if(name=="CT101010"){$user="Carlos Tovar"}
						if(name=="JJ651510"){$user="Jessica Jimenez"}
						if(name=="FP654417"){$user="Fernanda Perales"}
						if(name=="AS622461"){$user="Alfredo Silva"}
						if(name=="IO734384"){$user="Roberto Guerrero"}
						if(name=="IO731603"){$user="Rene Nolasco"}
						if(name=="IO756514"){$user="Inspector 3"}
						if(name=="SP916101"){$user="Carlos Valdez"}
						if(name=="SP957102"){$user="Carlos Domínguez"}
						if(name=="SP936703"){$user="Ricardo Garcia"}
						if(name=="SP991604"){$user="Roberto Cerda"}
						if(name=="SP988605"){$user="Noe Mendoza"}
						if(name=="SP948506"){$user="Adrián Saucedo"}
						if(name=="SP928607"){$user="Mauricio Lumbreras"}
						if(name=="SP908908"){$user="Luciano Platas"}
						if(name=="SP968009"){$user="Blas Escobar"}
						if(name=="SP934311"){$user="Orlando Morales"}
						$tipo = "Rechazo";
						$wo_no = document.getElementById("wo_no").value; 
						$mother_bom = document.getElementById("bom").value; 
						$lugar = "Validacion Ancho inicio";
						$.alert('Mandado a rechazo por: ' + $user);
						$(function() {
							$.ajax({
								type: "POST",
								url: "insertpersonal.php",
								data:{
									'Tipo_Liberacion' : $tipo,
									'Libero' :$user,
									'wo_no' : $wo_no,
									'mother_bom': $mother_bom,
									'lugar': $lugar
								},
							});
						});
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
//------------------------------------------FUNCION PARA LIBERAR INFORMACION------------------------
function Liberar() {
	$.confirm({
		title: 'Liberar informacion',
		content: '' +
		'<form action="" class="formName">' +
		'<div class="form-group">' +
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
					if(name == 'CT101010' || name == 'JJ651510' ||name == 'FP654417' || name == 'AS622461' ||name == "IO734384"||name == 'IO731603' || name == 'IO756514'||name == 'SP916101' || name == 'SP957102'||name == 'SP936703' || name == 'SP991604'||name == 'SP988605'||name == 'SP948506'||name == 'SP928607'||name == 'SP908908'||name == 'SP968009' ||name =='SP934311' ) 
					{
						if(name=="CT101010"){$user="Carlos Tovar"}
						if(name=="JJ651510"){$user="Jessica Jimenez"}
						if(name=="FP654417"){$user="Fernanda Perales"}
						if(name=="AS622461"){$user="Alfredo Silva"}
						if(name=="IO734384"){$user="Roberto Guerrero"}
						if(name=="IO731603"){$user="Rene Nolasco"}
						if(name=="IO756514"){$user="Inspector 3"}
						if(name=="SP916101"){$user="Carlos Valdez"}
						if(name=="SP957102"){$user="Carlos Domínguez"}
						if(name=="SP936703"){$user="Ricardo Garcia"}
						if(name=="SP991604"){$user="Roberto Cerda"}
						if(name=="SP988605"){$user="Noe Mendoza"}
						if(name=="SP948506"){$user="Adrián Saucedo"}
						if(name=="SP928607"){$user="Mauricio Lumbreras"}
						if(name=="SP908908"){$user="Luciano Platas"}
						if(name=="SP968009"){$user="Blas Escobar"}
						if(name=="SP934311"){$user="Orlando Morales"}
						$tipo = "Liberacion";
						$wo_no = document.getElementById("wo_no").value; 
						$mother_bom = document.getElementById("bom").value; 
						$lugar = "Validacion Ancho inicio";
						$.alert('Datos desbloqueados por: ' + $user);
						$(function() {
							$.ajax({
								type: "POST",
								url: "insertpersonal.php",
								data:{
									'Tipo_Liberacion' : $tipo,
									'Libero' :$user,
									'wo_no' : $wo_no,
									'mother_bom': $mother_bom,
									'lugar': $lugar
									},
								});
							});
							var validator = $( "#campovalidar" ).validate();
							validator.resetForm();
							$("#continuar").hide();
							$("#siguiente").show();
							$("#liberar").hide();	
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
	
//---------------------------------------------------------------------------------------------------//					
		   	$( function(){
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
		