<?php
$datos = json_decode(file_get_contents("php://input")); 

   if (isset($datos)){
		      include 'config.php';

		$titulo= $datos->titulo;
          $tipo = $datos->tipo;
          $id_corporacion = $datos->id_corporacion;
          $id_plan_estudio = $datos->id_plan_estudio;
          $status = $datos->status;
          $mensaje = $datos->mensaje;
          $sexo = $datos->sexo;

         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");
         $mysql->Connectar();
   
				//optieneel ultimo folio
			$insert_mensaje="INSERT INTO escolar.tb_mensajes_plataforma (titulo,tipo,status,id_corporacion,id_plan_estudio,mensaje,sexo) values ('".$titulo."','".$tipo."','".$status."','0','".$id_plan_estudio."','".$mensaje."','".$sexo."')";
						
			if($result_actas=$mysql->Query($insert_mensaje)){
				echo 1;
			}else{
				echo "consulta error 1";
			}
         $mysql->Cerrar();
}



?>