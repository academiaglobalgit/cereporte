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
			$query = "select tbcb_alumnos.matricula,tb_personas.id,tb_personas.idmoodle,tb_personas.nombre,tb_personas.apellido1,tb_personas.apellido2,tb_corporaciones.nombre from tbcb_alumnos inner join tb_personas on tb_personas.id = tbcb_alumnos.id inner join tb_corporaciones on tb_corporaciones.id = tb_personas.id_corporacion inner join tb_calificaciones on tbcb_alumnos.id = tb_calificaciones.id_alumno inner join tbcb_materias_ids on tb_calificaciones.id_materia = tbcb_materias_ids.id_materia where 
			(select tbcb_actas_alumnos.folio from tbcb_actas inner join tbcb_actas_alumnos on tbcb_actas.folio = tbcb_actas_alumnos.folio where id_materia = tbcb_materias_ids.matricula and id_alumno = tbcb_alumnos.matricula) is null 
		  	and calificacion >= 6 and (select periodo from tbcb_materias where id = tbcb_materias_ids.matricula) = ".$periodo." and generacion <= " . $generacion . " group by tbcb_alumnos.matricula having count(tbcb_alumnos.matricula) =  (select count(id) from tbcb_materias where periodo = " . $periodo . ")";	
		}
		else
		{
			$query = "select tbcb_alumnos.matricula,tb_personas.id,tb_personas.idmoodle,tb_personas.nombre,tb_personas.apellido1,tb_personas.apellido2,tb_corporaciones.nombre from tbcb_alumnos inner join tb_personas on tb_personas.id = tbcb_alumnos.id inner join tb_corporaciones on tb_corporaciones.id = tb_personas.id_corporacion inner join tb_calificaciones on tbcb_alumnos.id = tb_calificaciones.id_alumno inner join tbcb_materias_ids on tb_calificaciones.id_materia = tbcb_materias_ids.id_materia where (select tbcb_actas_alumnos.folio from tbcb_actas inner join tbcb_actas_alumnos on tbcb_actas.folio = tbcb_actas_alumnos.folio where id_materia = tbcb_materias_ids.matricula and id_alumno = tbcb_alumnos.matricula) is null 
			and (select count(tbcb_actas_alumnos.id) from tbcb_actas_alumnos inner join tbcb_actas on tbcb_actas.folio = tbcb_actas_alumnos.folio inner join tbcb_materias on tbcb_materias.id = tbcb_actas.id_materia where periodo = " . $periodo - 1 . " and  id_alumno = tbcb_alumnos.matricula) = (select count(id) from tbcb_materias where periodo = ".$periodo - 1.") 
			and calificacion >= 6 and (select periodo from tbcb_materias where id = tbcb_materias_ids.matricula) = ".$periodo." and generacion <= " . $generacion . " group by tbcb_alumnos.matricula having count(tbcb_alumnos.matricula) =  (select count(id) from tbcb_materias where periodo = " . $periodo . ")";	
		}
		$resultado = mysql_query($query,$conexion);
		if($resultado)
		{
			$alumnos;
			for($indice = 0; $fila =  mysql_fetch_array($resultado); $indice++)
			{
				$alumnos[$indice]->matricula = $fila[0];
				$alumnos[$indice]->id = $fila[1];
				$alumnos[$indice]->idmoodle = $fila[2];
				$alumnos[$indice]->nombre = $fila[3];
				$alumnos[$indice]->apellido1 = $fila[4];
				$alumnos[$indice]->apellido2 = $fila[5];
				$alumnos[$indice]->corporacion = $fila[6];
			}
			$response->success = true;
			$response->data = $alumnos;
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