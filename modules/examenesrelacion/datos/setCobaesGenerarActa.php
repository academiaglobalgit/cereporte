<?php 
require_once "config.php";
$request =  json_decode(file_get_contents("php://input"),true);
$datos = $request['datos'];

$response->success = false;
$generacion = isset($datos['generacion']) ? $datos['generacion']:0;
$periodo = isset($datos['periodo']) ? $datos['periodo']:0;

if($generacion > 0 && $periodo > 0)
{
	$conexion = mysql_connect($server,$user,$password);
	if($conexion)
	{
		mysql_select_db($database);
		mysql_set_charset("UTF8", $conexion);
		if($periodo == 1)
		{
			$query = "select tbcb_alumnos.matricula from tbcb_alumnos inner join tb_calificaciones on tbcb_alumnos.id = tb_calificaciones.id_alumno inner join tbcb_materias_ids on tb_calificaciones.id_materia = tbcb_materias_ids.id_materia where 
			(select tbcb_actas_alumnos.folio from tbcb_actas inner join tbcb_actas_alumnos on tbcb_actas.folio = tbcb_actas_alumnos.folio where id_materia = tbcb_materias_ids.matricula and id_alumno = tbcb_alumnos.matricula) is null 
		  	and calificacion >= 6 and (select periodo from tbcb_materias where id = tbcb_materias_ids.matricula) = ".$periodo." and generacion <= " . $generacion . " group by tbcb_alumnos.matricula having count(tbcb_alumnos.matricula) =  (select count(id) from tbcb_materias where periodo = " . $periodo . ")";	
		}
		else
		{
			$query = "select tbcb_alumnos.matricula from tbcb_alumnos inner join tb_calificaciones on tbcb_alumnos.id = tb_calificaciones.id_alumno inner join tbcb_materias_ids on tb_calificaciones.id_materia = tbcb_materias_ids.id_materia where (select tbcb_actas_alumnos.folio from tbcb_actas inner join tbcb_actas_alumnos on tbcb_actas.folio = tbcb_actas_alumnos.folio where id_materia = tbcb_materias_ids.matricula and id_alumno = tbcb_alumnos.matricula) is null 
			and (select count(tbcb_actas_alumnos.id) from tbcb_actas_alumnos inner join tbcb_actas on tbcb_actas.folio = tbcb_actas_alumnos.folio inner join tbcb_materias on tbcb_materias.id = tbcb_actas.id_materia where periodo = " . $periodo - 1 . " and  id_alumno = tbcb_alumnos.matricula) = (select count(id) from tbcb_materias where periodo = ".$periodo - 1.") 
			and calificacion >= 6 and (select periodo from tbcb_materias where id = tbcb_materias_ids.matricula) = ".$periodo." and generacion <= " . $generacion . " group by tbcb_alumnos.matricula having count(tbcb_alumnos.matricula) =  (select count(id) from tbcb_materias where periodo = " . $periodo . ")";	
		}
		
		$resultado = mysql_query($query,$conexion);
		if($resultado)
		{
			$matriculas;
			for($indice = 0; $fila =  mysql_fetch_array($resultado); $indice++)
			{
				$matriculas[$indice] = $fila[0];
			}
			$materias=[];
			$alumnos = [];
			$calificaciones=[];
			$indice = 0;
			foreach($matriculas as $matricula)
			{
				$query = "select tbcb_alumnos.matricula,tbcb_materias.id,tb_calificaciones.calificacion from tb_calificaciones inner join tbcb_alumnos on tbcb_alumnos.id = tb_calificaciones.id_alumno inner join tbcb_materias_ids on tbcb_materias_ids.id_materia = tb_calificaciones.id_materia inner join tbcb_materias on tbcb_materias.id = tbcb_materias_ids.matricula where periodo = ".$periodo." and tbcb_alumnos.matricula = ".$matricula;
				$resultado = mysql_query($query,$conexion);
				if($resultado)
				{
					while($fila =  mysql_fetch_array($resultado))
					{ 
						$alumnos[$indice]			= $fila[0];
						$materias[$indice]			= $fila[1];
						$calificaciones[$indice] 	= $fila[2];
						$indice++;
					}

					for($indice = 0; $indice < count($alumnos);  $indice++)
					{
						$query="call cb_generar_acta(".$alumnos[$indice].",".$materias[$indice].",".$calificaciones[$indice].",".$generacion.");";
						$resultado = mysql_query($query,$conexion);
						if($resultado)
						{
							$registro++;
						}
						else
						{
							$error++;
						}
					}
						

				}
			}
		}
		else
		{
			$response->error = "No hay alumnos disponibles " . mysql_error();
		}
		mysql_close($conexion);
	}
	else
	{
		$response->error = "No se pudo conectar a la base de datos ".mysql_error();
	}
}
else
{
	$response->error = "No se enviaron los datos nesesarios";
}
echo json_encode($response);
?>