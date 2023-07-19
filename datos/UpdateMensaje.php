<?php
$datos = json_decode(file_get_contents("php://input")); 

   if (isset($datos)){
		      include 'config.php';
			$id_mensaje= $datos->id_mensaje;

			$titulo= $datos->titulo;
          $tipo = $datos->tipo;
          $id_corporacion = $datos->id_corporacion;
          $id_plan_estudio = $datos->id_plan_estudio;

          $status = $datos->status;
          $mensaje = $datos->mensaje;
          $sexo = $datos->sexo;

         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");
         $mysql->Connectar();
   
				//optiene el ultimo folio
			$insert_mensaje="UPDATE escolar.tb_mensajes_plataforma set titulo='".$titulo."',tipo='".$tipo."',status='".$status."',id_corporacion='".$id_corporacion."',id_plan_estudio='".$id_plan_estudio."',mensaje='".$mensaje."',sexo='".$sexo."',fecha_modificado=NOW() WHERE id='".$id_mensaje."' limit 1  ";
						
			if($result_actas=$mysql->Query($insert_mensaje)){

				echo 1;
			}else{
				echo "consulta error 1".mysql_error();
			}
         $mysql->Cerrar();

}



?>