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
						
									//-----AGREGAR EL SP PARA AGREGAR DATOS DE LS TENSIONES------------
									$consulta = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_T] @BOM_NO = '". strtoupper($_GET["bom"]) ."'";
            			odbc_do($conn, $consulta);
									//-----CONSULTA PARA REVISAR SI EN EL ROLLO MADRE CONTIENE LA PALABRA 'VOLTRAN SA DE CV'--------
									$consulta2 ="SELECT  COUNT(BOM_NO) AS BOM_NO FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_TEN] WHERE BOM_NO ='" .strtoupper(($_GET["bom"])). "' AND TENSION_P_INI_1 IS NULL";
									$resultado2 = odbc_do($conn, $consulta2); 			
									$yavalidado = 1;
									$Contador = odbc_result($resultado2, 1);
									//echo $Contador;
							   	if(odbc_result($resultado2, 1) > "0"){
										$yavalidado = 0;
										if($yavalidado ==0){							
										//MUESTRA INSPECCION_ONDULAION
										header("Location: Validacion2.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
										die;
										}										
									 }
									ELSE{
									header("Location: Validacion_Comentarios.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
									die();
								}	
								
								
						
					?>
