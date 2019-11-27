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
		<label class="col-sm-4 col-form-label">SUPERVISOR:</label>
		<select name='CLIENTE' id="CLIENTE" class=' col-xs-6 col-md-4 form-control'>
			<?php
				include("php/variables.php");
				$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
				if (!$conn)
					die ("conexionerror");
				//------------- BUSQUEDA DE ROLLOS MADRE (INCLUYENDO LOS BALANCES)------------------------------
				$consulta = "SELECT USER_INSERT FROM [MTY_PROD_SSM].[dbo].[SSM_INSPECCION] GROUP BY USER_INSERT";
				$resultado = odbc_do($conn, $consulta); 
				$uno = 1;
				echo "<option> Seleccionar supervisor..</option>";
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
                <th>SUPERVISOR</th>
                <th>PESO</th>
				<th>ANCHO</th>
				<th>ESPESOR</th>
            	<th>Tension Pad inicio 1</th>
				<th>Tension Pad fin 1</th>
				<th>Metros al cambio 1</th>
				<th>Tension Break inicio 1</th>
            	<th>Tension Break fin 1</th>
				<th>Metros al cambio 1</th>
				<th>Tension roll 1</th>
                <th>Tension Pad inicio 2</th>
				<th>Tension Pad fin 2</th>
				<th>Metros al cambio 2</th>
				<th>Tension Break inicio 2</th>
            	<th>Tension Break fin 2</th>
				<th>Metros al cambio 2</th>
				<th>Tension roll 2</th>
                <th>Tension Pad inicio 3</th>
				<th>Tension Pad fin 3</th>
				<th>Metros al cambio 3</th>
				<th>Tension Break inicio 3</th>
            	<th>Tension Break fin 3</th>
				<th>Metros al cambio 3</th>
				<th>Tension roll 3</th>
                <th>Tension Pad inicio 4</th>
				<th>Tension Pad fin 4</th>
				<th>Metros al cambio 4</th>
				<th>Tension Break inicio 4</th>
            	<th>Tension Break fin 4</th>
				<th>Metros al cambio 4</th>
				<th>Tension roll 4</th>
            </tr>
        </thead>
			<?php
				if(isset($_POST['submit'])){
                    $selected_val = $_POST['CLIENTE']; 
                    
										include("php/variables.php");
					$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
					if (!$conn)
						die ("conexionerror");
					$consulta = "SELECT  USER_INSERT, VAL_PESO_INI, VAL_INI_ANCHO, VAL_INI_ESPESOR, TENSION_P_INI_1, TENSION_P_FIN_1, 
                    METROS_CAMB_1, TENSION_B_INI_1, TENSION_B_FIN_1, METRO_CAMB_1, TENSION_ROLL_1, TENSION_P_INI_2, TENSION_P_FIN_2, 
                    METROS_CAMB_2, TENSION_B_INI_2, TENSION_B_FIN_2, METRO_CAMB_2, TENSION_ROLL_2, TENSION_P_INI_3, TENSION_P_FIN_3, 
                    METROS_CAMB_3, TENSION_B_INI_3, TENSION_B_FIN_3, METRO_CAMB_3, TENSION_ROLL_3, TENSION_P_INI_4, TENSION_P_FIN_4, 
                    METROS_CAMB_4, TENSION_B_INI_4, TENSION_B_FIN_4, METRO_CAMB_4, TENSION_ROLL_4                    
                    FROM [MTY_PROD_SSM].[dbo].[VIEW_SSM_INSPECCION_INGENIERIA] WHERE USER_INSERT LIKE '%".$selected_val ."%' ";
					$resultado = odbc_do($conn, $consulta);
					echo '<tbody>';
					while (odbc_fetch_row($resultado)) {
						
						echo '<tr>';
                        echo '<th>'.odbc_result($resultado, 1).'</th>';
                        echo '<th>'.floatval(odbc_result($resultado, 2)).'</th>';
                        echo '<th>'.floatval(odbc_result($resultado, 3)).'</th>';	
                        echo '<th>'.floatval(odbc_result($resultado, 4)).'</th>';
                        echo '<th>'.odbc_result($resultado, 5).'</th>';
                        echo '<th>'.odbc_result($resultado, 6).'</th>';
                        echo '<th>'.odbc_result($resultado, 7).'</th>';
                        echo '<th>'.odbc_result($resultado, 8).'</th>';
                        echo '<th>'.odbc_result($resultado, 9).'</th>';
                        echo '<th>'.odbc_result($resultado, 10).'</th>';
                        echo '<th>'.odbc_result($resultado, 11).'</th>';
                        echo '<th>'.odbc_result($resultado, 12).'</th>';
                        echo '<th>'.odbc_result($resultado, 13).'</th>';
                        echo '<th>'.odbc_result($resultado, 14).'</th>';
                        echo '<th>'.odbc_result($resultado, 15).'</th>';
                        echo '<th>'.odbc_result($resultado, 16).'</th>';
                        echo '<th>'.odbc_result($resultado, 17).'</th>';
                        echo '<th>'.odbc_result($resultado, 18).'</th>';
                        echo '<th>'.odbc_result($resultado, 19).'</th>';
                        echo '<th>'.odbc_result($resultado, 20).'</th>';
                        echo '<th>'.odbc_result($resultado, 21).'</th>';
                        echo '<th>'.odbc_result($resultado, 22).'</th>';
                        echo '<th>'.odbc_result($resultado, 23).'</th>';
                        echo '<th>'.odbc_result($resultado, 24).'</th>';
                        echo '<th>'.odbc_result($resultado, 25).'</th>';
                        echo '<th>'.odbc_result($resultado, 26).'</th>';
                        echo '<th>'.odbc_result($resultado, 27).'</th>';
                        echo '<th>'.odbc_result($resultado, 28).'</th>';
                        echo '<th>'.odbc_result($resultado, 29).'</th>';
                        echo '<th>'.odbc_result($resultado, 30).'</th>';
                        echo '<th>'.odbc_result($resultado, 31).'</th>';
                        echo '<th>'.odbc_result($resultado, 32).'</th>';
						echo '</tr>';
						
					} 
					echo '</tbody>';       
                }
                else{
                   
                    
										include("php/variables.php");
					$conn = odbc_connect("Driver={SQL Server};Server=".$server2.";", $user2,$pass2);
					if (!$conn)
						die ("conexionerror");
					$consulta = "SELECT  USER_INSERT, VAL_PESO_INI, VAL_INI_ANCHO, VAL_INI_ESPESOR, TENSION_P_INI_1, TENSION_P_FIN_1, 
                    METROS_CAMB_1, TENSION_B_INI_1, TENSION_B_FIN_1, METRO_CAMB_1, TENSION_ROLL_1, TENSION_P_INI_2, TENSION_P_FIN_2, 
                    METROS_CAMB_2, TENSION_B_INI_2, TENSION_B_FIN_2, METRO_CAMB_2, TENSION_ROLL_2, TENSION_P_INI_3, TENSION_P_FIN_3, 
                    METROS_CAMB_3, TENSION_B_INI_3, TENSION_B_FIN_3, METRO_CAMB_3, TENSION_ROLL_3, TENSION_P_INI_4, TENSION_P_FIN_4, 
                    METROS_CAMB_4, TENSION_B_INI_4, TENSION_B_FIN_4, METRO_CAMB_4, TENSION_ROLL_4                    
                    FROM [MTY_PROD_SSM].[dbo].[VIEW_SSM_INSPECCION_INGENIERIA] ";
					$resultado = odbc_do($conn, $consulta);
					echo '<tbody>';
					while (odbc_fetch_row($resultado)) {
						
						echo '<tr>';
                        echo '<th>'.odbc_result($resultado, 1).'</th>';
                        echo '<th>'.floatval(odbc_result($resultado, 2)).'</th>';
                        echo '<th>'.floatval(odbc_result($resultado, 3)).'</th>';	
                        echo '<th>'.floatval(odbc_result($resultado, 4)).'</th>';
                        echo '<th>'.odbc_result($resultado, 5).'</th>';
                        echo '<th>'.odbc_result($resultado, 6).'</th>';
                        echo '<th>'.odbc_result($resultado, 7).'</th>';
                        echo '<th>'.odbc_result($resultado, 8).'</th>';
                        echo '<th>'.odbc_result($resultado, 9).'</th>';
                        echo '<th>'.odbc_result($resultado, 10).'</th>';
                        echo '<th>'.odbc_result($resultado, 11).'</th>';
                        echo '<th>'.odbc_result($resultado, 12).'</th>';
                        echo '<th>'.odbc_result($resultado, 13).'</th>';
                        echo '<th>'.odbc_result($resultado, 14).'</th>';
                        echo '<th>'.odbc_result($resultado, 15).'</th>';
                        echo '<th>'.odbc_result($resultado, 16).'</th>';
                        echo '<th>'.odbc_result($resultado, 17).'</th>';
                        echo '<th>'.odbc_result($resultado, 18).'</th>';
                        echo '<th>'.odbc_result($resultado, 19).'</th>';
                        echo '<th>'.odbc_result($resultado, 20).'</th>';
                        echo '<th>'.odbc_result($resultado, 21).'</th>';
                        echo '<th>'.odbc_result($resultado, 22).'</th>';
                        echo '<th>'.odbc_result($resultado, 23).'</th>';
                        echo '<th>'.odbc_result($resultado, 24).'</th>';
                        echo '<th>'.odbc_result($resultado, 25).'</th>';
                        echo '<th>'.odbc_result($resultado, 26).'</th>';
                        echo '<th>'.odbc_result($resultado, 27).'</th>';
                        echo '<th>'.odbc_result($resultado, 28).'</th>';
                        echo '<th>'.odbc_result($resultado, 29).'</th>';
                        echo '<th>'.odbc_result($resultado, 30).'</th>';
                        echo '<th>'.odbc_result($resultado, 31).'</th>';
                        echo '<th>'.odbc_result($resultado, 32).'</th>';
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
