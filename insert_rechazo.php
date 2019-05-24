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

            $consulta = "UPDATE [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_RECHAZO] SET RECHAZO = 1 WHERE 
            MOTHER_BOM=  '" .$motherbom."'";
            $resultado = odbc_do($conn, $consulta);	

            $consulta3 = "UPDATE [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] SET DELETED = 1 WHERE WO_NO = '".$wono."' and MOTHER_BOM= ' " .$motherbom."'";
            $resultado3 = odbc_do($conn, $consulta3); 

            $consulta2 = "UPDATE [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_C_RECHAZO] SET ".rtrim($datos,',').", UPDATE_DATE = getdate() WHERE [MOTHER_BOM] = '".$motherbom."'";
            $resultado2 = odbc_do($conn, $consulta2);	
            echo "Ok,";
            ?>