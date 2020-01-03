<?php
    session_start();
    include("php/variables.php");
    if (isset ($_SESSION['USSER'])) {
        if(!empty($_POST['user_id'])){
            $conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
            if (!$conn)
                die ("conexionerror");

            $consulta = "select COUNT(STAFF_CD) from OPENQUERY (HGDB, 'select STAFF_CD from MT02_STAFF where STAFF_CD = ''".$_POST["user"]."'' AND PASSWORD = ''".$_POST["user_id"]."''  AND COMPANY_CD = ''MTY'' ')";
            $resultado = odbc_do($conn, $consulta);	
            while (odbc_fetch_row($resultado)) {
                $CONT = odbc_result($resultado, 1);
            }

            if ($CONT > 1){
        
            $data['status'] = 'duplicado';
            }
            else if ($CONT == 1){
                $data['status'] = 'ok';
            }
        
            else{
            $data['status'] = 'error';   
            }
            echo json_encode($data); 
        }   
    }
?>