<!--COSIGO PHP PARA LA BUSQUEDA DE ROLLOS MADRE DEPENDIENDO DEL WO_NO-->
<?php
include("php/variables.php");
$_GET["wo"] = str_replace(" ","",$_GET["wo"]);
$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
			if (!$conn)
				die ("conexionerror");

//------------- BUSQUEDA DE ROLLOS MADRE (INCLUYENDO LOS BALANCES)------------------------------
$consulta = "SELECT  CNOORDEN, ISNULL(NOTAG, 'BALANCE' ) AS NOTAG FROM OPENQUERY(HGDB, 'SELECT WODE.WO_NO AS cNoOrden, WOPR.RM_BOM_NO AS NoTag
from WK06_WO_DETAIL WODE RIGHT JOIN MT11_CUSTOMER CUS ON WODE.CUSTOMER_CD = CUS.CUSTOMER_CD AND CUS.COMPANY_CD =  WODE.COMPANY_CD LEFT JOIN WK10_WO_PRODUCTS WOPR ON WODE.WO_NO =  WOPR.WO_NO AND  WODE.WO_LINE_NO = WOPR.WO_LINE_NO
WHERE WODE.COMPANY_CD = ''MTY'' AND WODE.WO_NO = ''". strtoupper($_GET["wo"]) ."'' ORDER BY WODE.WO_NO DESC, WOPR.SLIT_NO
') AS derivedtbl_1 GROUP BY CNOORDEN, NOTAG";

$resultado = odbc_do($conn, $consulta); 
	$uno = 1;
	echo "<option> Seleccionar Rollo Madre..</option>";
	while (odbc_fetch_row($resultado)) {
		$FBOM = odbc_result($resultado, 2);
		echo "<option  value=".$FBOM ."> " .$FBOM ."</option> "; 
		$uno++;
 
	}
?>
