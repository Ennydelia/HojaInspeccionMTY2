<?php
session_start();
include("php/variables.php");

if (isset ($_SESSION['USSER'])) {
$BOM = $_POST["bomm"];
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

			$consulta = "update [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] set ".$campo." = '".$val."',  USER_INSERT = '".strtoupper($_SESSION['USSERNAME'])."', UPDATE_DATE = getdate() where BOM_NO = '".$name."'";
			$resultado = odbc_do($conn, $consulta);	
			echo "Ok,";
	   }
	}

	//------
	$campo2 = "";
	foreach ($_POST as $name => $val)
	{
	  if($name == "valor"){
		 $campo2 = $val;        
	}
	}

   foreach ($_POST as $name => $val)
   {
	 if($name <> "valor"){
			$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
									if (!$conn)
										die ("conexionerror");

			$consulta = "update [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] set ".$campo2." = '".$val."' where PROD_LINE_NO = '".$name."' and MOTHER_BOM = '".$BOM."'";
			$resultado = odbc_do($conn, $consulta);	
			echo "Ok,";
	   }
	}
	
	