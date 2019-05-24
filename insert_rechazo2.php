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
			 $consulta = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_RECHAZO] @MOTHER_BOM = '".$name."'";
              odbc_do($conn, $consulta);
             $consulta2 = "EXEC [MTY_PROD_SSM].[dbo].[SP_INSPECCION_RECHAZO2] @MOTHER_BOM = '".$name."'";
              odbc_do($conn, $consulta2);

			$consulta = "update [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_RM_RECHAZO] set ".$campo." = ".$val." where MOTHER_BOM = '".$name."'";
			$resultado = odbc_do($conn, $consulta);	
			echo "Ok,";
	   }
	}
?>