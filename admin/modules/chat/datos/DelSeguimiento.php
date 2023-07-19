<?php 
require_once "configAyuda.php";
require_once('../../../preparatoriascorporativas/prepacoppel/config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/querylib.php');

$datos =  json_decode(file_get_contents("php://input"));

$mysql= new Connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
if(isset($datos->id_asunto) && is_numeric($datos->id_asunto)){
	if($mysql->Connectar()){
		if($result=$mysql->Query("CALL proc_eliminar_asunto(".$datos->id_asunto.")")){
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