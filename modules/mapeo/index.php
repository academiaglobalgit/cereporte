<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="">
	<script type="text/javascript" src="" ></script>

</head>
<body>
 <center>
 	 <form name="form_migracion" method="post" action="index.php" >
	  <strong><label style="font-size:30px;" ><label style="color:red;">PRODUCCION </label> MIGRACIÓN escolar(mysql) -> masterag(PostgresSQL)</label></strong>
	  <br>
	  <select  style="font-size:30px; width:300px height:100px;"  name="migrar" >
	  	<option value="0" selected>Elige una opcion</option>
	  	<option value="1" style="color:green;" >MIGRACION UPDATE/INSERT</option>
	  	<option value="0" >elige una opcion</option>
	  	<option value="0" >elige una opcion</option>
	  	<option value="0" >elige una opcion</option>
	  	<option value="0" >elige una opcion</option>
	  	<option value="0" style="color:red;" >TRUNCATE masterag.tb_personas</option>
	  	<option value="0" style="color:red;" >TRUNCATE masterag.tb_ids_escolar</option>
	  	<option value="0" >elige una opcion</option>
	  	<option value="0" >elige una opcion</option>
	  	<option value="0" >elige una opcion</option>
	  	<option value="0" >elige una opcion</option>-->
	  	<option value="0" >Test función StripNumeric</option>
	  	<option value="0" >CONNECT PG PRUEBAS</option>

	  </select>
	  <input style="font-size:30px; width:300px height:100px;" type="submit" value="START" name="LOL">
	</form>
	<nr>
	<a href="http://agcollege.com.mx/analisis/analisis_migracion_bdu/" target="_blank">Dashboard de migración</a>
 </center>


<?php
if(isset($_POST['migrar'])){
	set_time_limit(3600);
	ini_set('display_errors', 1);
	error_reporting(E_ERROR | E_WARNING | E_PARSE); //para mostrar erroresy warnings
	require_once("ConnectionPG.class.php");
	require_once("Connection.class.php");
	require_once("MigraPersonas.class.php");

	 $mysql = new Connection("localhost","produccionremoto","meapesta1221","escolar"); //conexion mysql sumate //conexion mysql produccion/local

	$mysql_umi = new Connection("umi.edu.mx","umiremoto","meapesta1221","escolar"); //conexion mysql UMI

	$pg = new ConnectionPG(); //conexion postgres

	if(!$pg->Connect("localhost","postgres","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","masterag")){
			//echo "<center><strong  style='color:orange;' >Error conexion con PostgresSQL PRINCIPAL</strong></center>";
	}

	/*if(!$pg->Connect("agcollege.com.mx","postgres","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","masterag")){
			//echo "<center><strong  style='color:orange;' >Error conexion con PostgresSQL PRINCIPAL</strong></center>";
	}  */
	if(!$mysql->Connect()){
			echo "<center><strong  style='color:orange;' >Error conexion con mysql PRINCIPAL PRODUCCION</strong></center>";
	} 

	/*if(!$mysql_sumate->Connect()){
			echo "<center><strong  style='color:orange;' >Error conexion con prepasumate.mx</strong></center>";
	} // inicia conexion mysql sumate
	*/
	if(!$mysql_umi->Connect()){
			echo "<center><strong  style='color:orange;' >Error conexion con umi.edu.mx</strong></center>";
	} // inicia conexion mysql umi


	$migrapersonas_produccion= new MigraPersonas($mysql, $pg); 

	$migrapersonas_umi= new MigraPersonas($mysql_umi, $pg); 

	switch ($_POST['migrar']){
		
		case 1: // MIGRACION

				$migrapersonas_produccion->MigrarV2('USUARIO INTERNO',0,0,1,'alumno',true);
				// bd // corporaicon // plan estudios // fieldid // fieldid string //ESINTERNO? //

				$migrapersonas_produccion->MigrarV2('`agcollege-ag`',1,1,1,'Alumno'); // bd // corporaicon // plan estudios // fieldid // fieldid string
				$migrapersonas_produccion->MigrarV2('prepacoppel',2,2,1,'alumno'); 
				$migrapersonas_produccion->MigrarV2('prepaley',4,4,10,'Alumno'); 
				$migrapersonas_produccion->MigrarV2('uclic',4,14,1,'Alumno'); 
				$migrapersonas_produccion->MigrarV2('prepatoks',7,9,1,'Alumno'); 
				$migrapersonas_produccion->MigrarV2('toksuniversity',7,10,1,'Alumno');
				$migrapersonas_produccion->MigrarV2('prepasumate',8,13,1,'Alumno'); 
				$migrapersonas_umi->MigrarV2('posgrados',6,12,1,'Alumno'); 
				$migrapersonas_produccion->MigrarV2('agsocial',1,17,1,'Alumno'); 
				
				
		break;

		case 2:
			//TRUNCATE la tabla de tb_personas en masterag y tb_ids_escolar
			$migrapersonas_produccion->TruncateTable('tb_personas','id');
			$migrapersonas_produccion->TruncateTable('tb_ids_escolar','id_nuevo');

		break;

		case 3:
			$migrapersonas_produccion->TruncateTable('tb_personas','id');
		break;

		case 4:
			$migrapersonas_produccion->TruncateTable('tb_ids_escolar','id_nuevo');
		break;	


		case 5:
				$tels=$migrapersonas_produccion->StripNumeric("1111111 -	2222222 -	33333-000 44 55555");

				foreach ($tels as $key => $value) {
					echo $value."<br>";
				}
		break;	

		case 6:

				$pg_select_query='SELECT * FROM "masterag"."tb_personas" limit 5; ';
				$tabla="";
					$pg_result_select=$pg->Query($pg_select_query);
					while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
						$tabla.="<tr>";
					    foreach ($line as $col_value) {
					       $tabla.="<td>".$col_value."</td>";
					    }								
					    $tabla.="</tr>";

					}
				echo "<table>".$tabla."</table>";
		break;
		default:
			echo "<center><strong  style='color:orange;' >Elige una opción</strong></center>";
		break;
	}

	
	$pg->Close();
	$mysql->Close();
}
?>
<body>
</html>