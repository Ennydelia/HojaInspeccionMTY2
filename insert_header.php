<?php
session_start();
include("php/variables.php");

if (isset ($_SESSION['USSER'])) {

    $datos = "";
    $motherbom = "";
    $wono = "";
    foreach ($_POST as $name => $val)
    {
        if($name <> "MOTHER_BOM" && $name <> "WO_NO"){
            $datos = $datos." ".$name." = '".$val."',";      
        }
        elseif($name == "MOTHER_BOM"){
            $motherbom = $val;
        }
        else{
            $wono = $val;
        }
    }
}
    
    $conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
                                    if (!$conn)
                                        die ("conexionerror");

            $consulta = "UPDATE [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] SET FINAL_CHECK = 1 WHERE WO_NO = '".$wono."' and VAL_CAMBER_FIN is not NULL";
            $resultado = odbc_do($conn, $consulta);	

            $consulta = "UPDATE [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_RM] SET FINAL_CHECK = 1 WHERE WO_NO = '".$wono."' and VAL_ESPESOR_INI is not NULL";
            $resultado = odbc_do($conn, $consulta); 

            $consulta2 = "UPDATE [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_C] SET ".rtrim($datos,',').", UPDATE_DATE = getdate() WHERE [MOTHER_BOM] = '".$motherbom."'";
            $resultado2 = odbc_do($conn, $consulta2);	
            echo "Ok,";

//}



?>