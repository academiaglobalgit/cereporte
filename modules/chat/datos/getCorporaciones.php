<?php 
session_start();
require_once "configAyuda.php";

$corporaciones=[];
$mysql= new Connect();



$j=0;
	if($mysql->Connectar()){
		if($result=$mysql->Query("SELECT escolar.tb_corporaciones.id,escolar.tb_corporaciones.nombre FROM escolar.tb_corporaciones WHERE escolar.tb_corporaciones.activo=1")){

			while ($reg=mysql_fetch_array($result)) {
				
					$corporaciones[$j]['id']=$reg['id'];
					$corporaciones[$j]['nombre']=$reg['nombre'];
				
				$j++;
			}
			
		}
			$mysql->Cerrar();
	}



		
echo json_encode($corporaciones);

?>