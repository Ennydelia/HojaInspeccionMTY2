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

			$consulta = "update [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] set ".$campo." = '".$val."',  USER_INSERT = '".strtoupper($_SESSION['USSERNAME'])."', UPDATE_DATE = getdate() where BOM_NO = '".$name."'";
			$resultado = odbc_do($conn, $consulta);	
			echo "Ok,";
				//echo $consulta." ==";
				//echo htmlspecialchars($name . ': ' . $val) . "\n";
				//strtoupper($_SESSION['USSERNAME'])
			//, USER_INSERT = '".strtoupper($_SESSION['USSERNAME'])."''
	   }
	}
//}
