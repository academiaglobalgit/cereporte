<?php 
require_once "configAyuda.php";
require_once('../../../preparatoriascorporativas/prepacoppel/config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/querylib.php');

$totales;
$mysql= new Connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);

	if($mysql->Connectar()){
		if($result=$mysql->Query("SELECT nuevos,en_seguimiento,solucionados,no_solucionados FROM view_totales_asuntos")){

			$totales=mysql_fetch_object($result);
			echo json_encode($totales);

		}
			$mysql->Cerrar();

	}

?>