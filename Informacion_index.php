<?php

include("php/variables.php");
$_GET["wo"] = str_replace(" ","",$_GET["wo"]);
$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
			if (!$conn)
			  die ("conexionerror");
 echo '<table id="tabla-valor" class="table" style="width:50%"><tr><th colspan="1">Cliente</th><th colapsan= "1">Notas</th></tr>';			

$consulta = "SELECT [Cliente] ,[cNotas] from [MTY_PROD_SSM].[dbo].[VIEW_SSM_HI_TOLERANCIAS] WHERE WO_NO = '". strtoupper($_GET["wo"]) ."'";

$resultado = odbc_do($conn, $consulta);	
  $uno = 1;
  while (odbc_fetch_row($resultado)) {
	      echo "<tr><th>".odbc_result($resultado, 1) ."</th>";
		  echo "<br/>";
		  echo "<th>".odbc_result($resultado, 2)."</th></tr>";
	  $uno++;
	}
	if (odbc_result($resultado, 1) == 'INDUSTRIAL CONNECTIONS & SOLUTIONS LLC'){

		echo "<tr><th>INDUSTRIAL CONNECTIONS & SOLUTIONS LLC</th>";
		  echo "<th>Nota 4*: Validar que las cintas no cuenten con telescopio mayor a 2 mm.</th></tr>";
		   echo "<tr><th>INDUSTRIAL CONNECTIONS & SOLUTIONS LLC</th>";
		  echo "<th>Nota 5*: No pasar material con falta de recubrimiento aun cuando no presente continuidad OK - Sin faltante de recubrimiento NO-OK - Apariencia con faltante de recubrimiento</th></tr>";
		}


?>

