<?php 
session_start();
require_once "configAyuda.php";

$regiones=[];
//$mysql= new Connect();


$mysql= new Connect();


if(isset($_SESSION['id_persona'])){
$j=0;
	if($mysql->Connectar()){
		if($result=$mysql->Query("SELECT escolar.tb_regiones.id,escolar.tb_regiones.nombre FROM escolar.tb_regiones where escolar.tb_regiones.id_corporacion=2  and escolar.tb_regiones.activo=1")){

			while ($reg=mysql_fetch_array($result)) {
				
					$regiones[$j]['id']=$reg['id'];
					$regiones[$j]['nombre']=$reg['nombre'];
				
				$j++;
			}
			
		}
			$mysql->Cerrar();
	}

}



		
echo json_encode($regiones);

?>