<?php

include("php/variables.php");
$_GET["wo"] = str_replace(" ","",$_GET["wo"]);
$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
			if (!$conn)
			  die ("conexionerror");
 	

$consulta = "SELECT [Tondulacion] ,[cNotas] from [MTY_PROD_SSM].[dbo].[VIEW_SSM_HI_TOLERANCIAS] WHERE WO_NO = '". strtoupper($_GET["wo"]) ."' ";

$resultado = odbc_do($conn, $consulta);	
  $uno = 1;
  while (odbc_fetch_row($resultado)) {
	      //echo "<center font size = '20'>".odbc_result($resultado, 1) ."</center>";
		  echo "<br/>";
		  echo "<center font size = '20'>".odbc_result($resultado, 2)."</center>";
	  $uno++;
	}
	

?>

