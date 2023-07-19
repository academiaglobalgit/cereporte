<?php
$datos = json_decode(file_get_contents("php://input")); 

		      include 'config.php';

            $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");
       	
            $mysql->Connectar();
			$mensajes=array();
			$query_mensajes="
            SELECT m.id,m.titulo,m.id_corporacion,m.id_plan_estudio,m.tipo,m.status,m.fecha_registro,m.fecha_modificado,m.mensaje,m.sexo  from escolar.tb_mensajes_plataforma m where m.eliminado=0 order by m.id DESC; ";

			if($result_mensajes=$mysql->Query($query_mensajes)){

					$row_titles=mysql_fetch_assoc($result_mensajes);
					$mensajes_titulos=array();
					foreach (array_keys($row_titles) as $key) {
						array_push($mensajes_titulos,$key);
					}

					//array_push($mensajes,$mensajes_titulos);
					mysql_data_seek($result_mensajes, 0);
					while ($row_mensajes=mysql_fetch_object($result_mensajes)) {
						array_push($mensajes,$row_mensajes);
					}

			}

				

            $mysql->Cerrar();
            $result=array();
            $result[0]=$mensajes;
            $result[1]=$query_mensajes;

 			echo json_encode($result);

    $errores=0;

?>