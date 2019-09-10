<style>
.cities {

  padding: 50px;
}
</style>
<!-- MENU DE INICIO-->
<?php include("php/Pagina_inicio.php"); ?>
<!------------------------------------------------>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap4.css"/>
<center><h3>REPORTE DE HOJA DE INSPECCION</h3></center>
</br>

<form method="post">
<div class ='container'>
		<label class="col-sm-4 col-form-label">CLIENTE:</label>
		<select name='CLIENTE' id="CLIENTE" class=' col-xs-6 col-md-4 form-control'>
			<?php
				include("php/variables.php");
				$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
				if (!$conn)
					die ("conexionerror");
				//------------- BUSQUEDA DE ROLLOS MADRE (INCLUYENDO LOS BALANCES)------------------------------
				$consulta = "SELECT CLIENTE FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] GROUP BY CLIENTE";
				$resultado = odbc_do($conn, $consulta); 
				$uno = 1;
				echo "<option> Seleccionar cliente..</option>";
				while (odbc_fetch_row($resultado)) {
					$FBOM = odbc_result($resultado, 1);
					echo "<option  value=".$FBOM ."> " .$FBOM ."</option> "; 
					$uno++;
				}
			?>
		</select>
		</br>
	<input type="submit"name = "submit" value="Buscar" class="btn btn-primary ">
	</div>
</form>
<!--   -->

	 
<div class="table-responsive" id="tabla">
	<table id="datatable" class="table table-striped table-bordered table-condensed table-hover">
		<thead>
            <tr>
                <th>CLIENTE</th>
                <th>WO_NO</th>
				<th>MOTHER_BOM</th>
				<th>BOM_NO</th>
            	<th>ANCHO</th>
				<th>ESPESOR</th>
				<th>REBABA</th>
				<th>ONDULACION</th>
            	<th>ANCHO INICIO</th>
				<th>ESPESOR INICIO</th>
				<th>REBABA OP INICIO</th>
				<th>REBABA MOT INICIO</th>
            	<th>ONDULACION INICIO</th>  
                <th>ANCHO FIN</th>
				<th>ESPESOR FIN</th>
				<th>REBABA OP FIN</th>
				<th>REBABA MOT FIN</th>
                <th>ONDULACION FIN</th>  
            </tr>
        </thead>
			<?php
				if(isset($_POST['submit'])){
					$selected_val = $_POST['CLIENTE'];  
					// echo "You have selected :" .$selected_val;
					include("php/variables.php");
					$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
					if (!$conn)
						die ("conexionerror");
					$consulta = "SELECT  CLIENTE, WO_NO, MOTHER_BOM, BOM_NO, VAL_INI_ANCHO, VAL_INI_ESPESOR, VAL_INI_REBABA_MOTOR, VAL_INI_REBABA_OP, VAL_ONDULACION_INI, VAL_FIN_ANCHO, VAL_FIN_ESPESOR, 
					VAL_FIN_REBABA_MOTOR, VAL_FIN_REBABA_OP, VAL_ONDULACION_FIN, ANCHO, ESPESOR, REBABA, ONDULACIONES FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] WHERE FINAL_CHECK = 1  AND CLIENTE LIKE '%".$selected_val ."%' order by UPDATE_DATE";
					$resultado = odbc_do($conn, $consulta);
					echo '<tbody>';
					while (odbc_fetch_row($resultado)) {
						
						echo '<tr>';
						echo '<th>'.odbc_result($resultado, 1).'</th>';
						echo '<th>'.odbc_result($resultado, 2).'</th>';
						echo '<th>'.odbc_result($resultado, 3).'</th>';
						echo '<th>'.odbc_result($resultado, 4).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 15)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 16)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 17)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 18)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 5)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 6)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 7)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 8)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 9)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 10)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 11)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 12)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 13)).'</th>';
						echo '<th>'.floatval(odbc_result($resultado, 14)).'</th>';
						echo '</tr>';
						
					} 
					echo '</tbody>';       
				}
            ?>
	</table>
</div>


<script src="js/pikaday.js"></script>
<link href="css/speech-input.css" rel="stylesheet">
<script src="js/speech-input.js"></script>
<script>
	

	
	$(document).ready(function(){
		$('#bodymain').loading('stop');
		
		$('#datatable').DataTable( {
		// Configure Export Buttons
	
			dom: 'Bfrtip',
			bAutoWidth: false,
			lengthChange: false,
			"searching": false,
			"info": false,
			"language": {
				"paginate": {
					"next": ">",
					"previous": "<"
				}
			},
			buttons: [
			{
				extend: 'excelHtml5',
				className: 'btn btn-success',
				text:'Descargar reporte',
				title: null,
				footer: true,
				autoFilter: true,
				extension: '.xlsx',
				filename: 'Reporte Hoja de Inspeccion '+ '',
			},]
		 });
	});
</script>
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.js"></script>
