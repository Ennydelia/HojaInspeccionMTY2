<?php
    session_start();
    include("php/variables.php");

    if (isset ($_SESSION['USSER'])) {
        $tipo = $_POST["Tipo_Liberacion"];
        $wo = $_POST["wo_no"];
        $bom = $_POST["mother_bom"];
        $lugar= $_POST["lugar"];
        $user_id = $_POST["user_id"];

    }
    $conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
    if (!$conn)
        die ("conexionerror");

    //VUELVE A INVESTIGAR SI EXISTE LA CLAVE O USUARIO PARA AGREGARLO A LA BASE DE DATOS
    if(empty($_POST['user'])){
        $consulta2 = "select * from OPENQUERY (HGDB, 'select STAFF_CD, STAFF_NAME from MT02_STAFF where PASSWORD = ''".$user_id."'' AND COMPANY_CD = ''MTY'' ')";
        $resultado2 = odbc_do($conn, $consulta2);	
        while (odbc_fetch_row($resultado2)) {
            $libero = odbc_result($resultado2, 2);
        }
    }
    else{
        $consulta2 = "select * from OPENQUERY (HGDB, 'select STAFF_CD, STAFF_NAME from MT02_STAFF where STAFF_CD = ''".$_POST["user"]."'' AND PASSWORD = ''".$user_id."'' AND COMPANY_CD = ''MTY'' ')";
        $resultado2 = odbc_do($conn, $consulta2);	
        while (odbc_fetch_row($resultado2)) {
            $libero = odbc_result($resultado2, 2);
        }
    }    

    $consulta = "insert into [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_REPORTE] (Tipo_Liberacion, Libero, WO_NO, MOTHER_BOM, Lugar_Validacion, Fecha_Liberacion)
    VALUES('".$tipo."', '".$libero."', '".$wo."', '".$bom."', '".$lugar."', getdate())";
    $resultado = odbc_do($conn, $consulta);	
    echo "ok";
?>
