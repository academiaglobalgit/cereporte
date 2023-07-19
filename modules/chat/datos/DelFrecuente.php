<?php 
require_once "configAyuda.php";
require_once('../../../preparatoriascorporativas/prepacoppel/config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/querylib.php');

$datos =  json_decode(file_get_contents("php://input"));

$mysql= new Connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
if(isset($datos->id_frecuente) && is_numeric($datos->id_frecuente)){
	if($mysql->Connectar()){
		if($result=$mysql->Query("CALL proc_eliminar_preguntasfrecuentes(".$datos->id_frecuente.")")){
			$video_a_eliminar="../../../preparatoriascorporativas/prepacoppel/ayuda/videos/".$datos->id_frecuente.".mp4";
			/*if (file_exists($video_a_eliminar)) {
				unlink($video_a_eliminar);
			}*/
			echo 1;
		}else{
			echo 0;
		}
			$mysql->Cerrar();

	}else{
		echo 0;
	}
}else{
	echo 0;
}

?>