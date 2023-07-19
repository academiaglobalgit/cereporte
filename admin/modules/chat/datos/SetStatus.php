<?php
require_once "configAyuda.php";

$datos =  json_decode(file_get_contents("php://input"));
require_once('../../../preparatoriascorporativas/prepacoppel/config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/querylib.php');

$id_usuario=$USER->id;
//$mysql= new Connect();

if((isset($datos->id_asunto) && trim($datos->id_asunto)!="") && (isset($datos->status) && trim($datos->status)!="") ) {
	$mysql= new Connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);

	if($mysql->Connectar()){
			$id_asunto=strip_tags($datos->id_asunto);
			if($result=$mysql->Query("CALL proc_guardar_status (".$id_asunto.",".$datos->status.") ")){
				echo 1;
			}else{
				echo mysql_error();
			}
			$mysql->Cerrar();
	}else{
		echo 0;
	}

}else{

	echo 0;

}

?>