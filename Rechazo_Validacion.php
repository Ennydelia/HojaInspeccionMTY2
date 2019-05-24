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
							//------ BUSCAMOS LA MAQUINA EN LA QUE SE REALIZA LA INSPECCION O CORTE (WO_NO) -------
							$consulta = "select top 1 MACHINE_CD existe_wo from openquery(hgdb,'select MACHINE_CD from WK04_WO_HEADER where company_cd = ''MTY'' and WO_NO = ''". strtoupper($_GET["wo"]) ."'' ')";
							$resultado = odbc_do($conn, $consulta);
							while (odbc_fetch_row($resultado)) {
								$maquina = odbc_result($resultado, 1);//RECTIFICA QUE SEA LLA MAQUINA A CORTAR INICIO-FINAL
								//------- AGREGAR LOS DATOS DEL RECHAZO-----------
								$consulta = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_RECHAZO] @MOTHER_BOM = '". strtoupper($_GET["bom"]) ."'";
              	odbc_do($conn, $consulta);
             		$consulta2 = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_RECHAZO2] @MOTHER_BOM = '". strtoupper($_GET["bom"]) ."'";
              	odbc_do($conn, $consulta2);
								//-----CONSULTA PARA REVISAR SI EN EL ROLLO MADRE CONTIENE LA PALABRA 'VOLTRAN SA DE CV'--------
								$consulta = "SELECT  MOTHER_BOM, CUSTOMER_NAME FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_RM_RECHAZO] WHERE MOTHER_BOM = '". strtoupper($_GET["bom"]) ."' and CUSTOMER_NAME ='VOLTRAN SA DE CV'";
								$resultado = odbc_do($conn, $consulta); 			
								$yavalidado = 1;
							  while (odbc_fetch_row($resultado)) {
									$yavalidado = 0;
									if($yavalidado == 0){
										//MUESTRA INSPECCION_ONDULAION
										header("Location: Rechazo_Insp_Ondulacion.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
										die();
									}
								}
								$count2 ++;
							}	
						if($yavalidado ==1){
							header("Location: Rechazo_Peso_Rollo.php?wo=".$_GET["wo"]."&bom=".$_GET["bom"]);
							die();
						}
					//}
				//}
			?>