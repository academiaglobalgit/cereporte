<?php
$datos = json_decode(file_get_contents("php://input")); 

   if (isset($datos)){
		      include 'config.php';
			$id_mensaje= $datos->id_mensaje;

         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");
         $mysql->Connectar();
   
				//optiene el ultimo folio

			//$DELETE="DELETE FROM escolar.tb_mensajes_plataforma  WHERE id='".$id_mensaje."' limit 1  ";
			
			$DELETE="update escolar.tb_mensajes_plataforma set eliminado=1 WHERE id='".$id_mensaje."' limit 1  ";
			
			if($result_actas=$mysql->Query($DELETE)){

				echo 1;
			}else{
				echo "consulta error 1";
			}
         $mysql->Cerrar();

}



?>