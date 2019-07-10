<?php
session_start();
include("php/variables.php");

if (isset ($_SESSION['USSER'])) {
    $tipo = $_POST["Tipo_Liberacion"];
    $libero = $_POST["Libero"];
    $wo = $_POST["wo_no"];
    $bom = $_POST["mother_bom"];
    $lugar= $_POST["lugar"];
}
$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
if (!$conn)
    die ("conexionerror");
    $consulta = "insert into [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_REPORTE] (Tipo_Liberacion, Libero, WO_NO, MOTHER_BOM, Lugar_Validacion, Fecha_Liberacion)
     VALUES('".$tipo."', '".$libero."', '".$wo."', '".$bom."', '".$lugar."', getdate())";
    $resultado = odbc_do($conn, $consulta);	
    echo "ok";
?>
