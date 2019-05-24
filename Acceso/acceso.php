<?php

session_start();
include("../php/variables.php");

$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
						if (!$conn)
							die ("Error,error de conexion.");

$consulta = "select * from OPENQUERY (HGDB, 'select STAFF_NAME, ''@'' CORREO, ROLE_CD from MT02_STAFF where STAFF_CD = ''".strtoupper($_POST["Username"])."'' AND PASSWORD = ''".$_POST["password"]."'' AND COMPANY_CD = ''MTY'' ')";

$hay_usuario = false;		  
$resultado = odbc_do($conn, $consulta);	
	while (odbc_fetch_row($resultado)) {
		$nombre = utf8_decode(odbc_result($resultado, 1));
		$correo = odbc_result($resultado, 2);
		$es_autorizador = odbc_result($resultado, 3);
		$hay_usuario = true;
	}

	if($hay_usuario){
		$_SESSION['USSER'] = $_POST["Username"];
		$_SESSION['USSERNAME'] = $nombre;
		$_SESSION['USSEREMAIL'] = $correo;
		$_SESSION['ISAUTH'] = $es_autorizador;
		die("OK,Login correct, Redirecting...");
	}
	else{
		die("Error,usuario/clave incorrecta");
	}
	
?>
