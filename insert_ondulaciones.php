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
    
    $conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
                                    if (!$conn)
                                        die ("conexionerror");

            $consulta2 = "UPDATE [MTY_PROD_SSM].[dbo].[SSM_INSPECCION_OND_RM] SET ".rtrim($datos,',')." WHERE [BOM_NO] = '".$motherbom."'";
            $resultado2 = odbc_do($conn, $consulta2);   
            echo "Ok,";

}



?>