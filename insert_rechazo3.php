<?php
session_start();
include("php/variables.php");

if (isset ($_SESSION['USSER'])) {

    $campo = "";
	foreach ($_POST as $name => $val)
	{
	  if($name == "campo"){
		 $campo = $val;        
	}
	}
}
   foreach ($_POST as $name => $val)
   {
	 if($name <> "campo"){
			$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
									if (!$conn)
										die ("conexionerror");



			$consulta = "update [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_RECHAZO] set ".$campo." = '".$val."',  SUP_RECHAZO = '".strtoupper($_SESSION['USSERNAME'])."', RECHAZO_DATE = getdate() where BOM_NO = '".$name."'";
			$resultado = odbc_do($conn, $consulta);	
			echo "Ok,";
		}
	}
?>