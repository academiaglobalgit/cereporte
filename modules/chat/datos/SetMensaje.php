<?php
session_start();
require_once "configAyuda.php";
$datos =  json_decode(file_get_contents("php://input"));
$id_facilitador=0;
if(isset($_SESSION['id_persona'])){
	$id_facilitador=$_SESSION['id_persona'];

}
if((isset($datos->id_asunto) && is_numeric($datos->id_asunto)) && (isset($datos->mensaje) && trim($datos->mensaje)!="") ) {
	$mysql= new Connect();

	if($mysql->Connectar()){
			$id_asunto=strip_tags($datos->id_asunto);
			$query="CALL proc_guardar_mensaje(0,".$id_facilitador.",".$id_asunto.",'".mysql_real_escape_string(strip_tags($datos->mensaje))."')";
			if($result=$mysql->Query($query)){
				echo 1;
			}else{
				echo "error - ".			$query." : ".mysql_error();
			}

			$mysql->Cerrar();
	}else{
		echo "error 2";
	}

}else{

	echo "error 1";

}

?>