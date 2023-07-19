<?php 
require_once "config.php";
$response = new stdClass();
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select a.id,b.id as 'id autoridad',b.matricula,b.nombre as 'materia autoridad',b.periodo,c.id as 'id corporacion',c.nombre as 'materia corporacion',c.periodo,tb_materias_ids.id_plan_estudio as 'plan estudio' from tb_materias_relacion a inner join tb_materias b on b.id = a.id_materia_autoridad inner join tb_materias c on c.id = a.id_materia inner join tb_materias_ids on tb_materias_ids.id_materia = c.id";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$relacion_materias;
		for($indice = 0; $fila = mysql_fetch_array($resultado);$indice++)
		{
			
			$relacion_materias[$indice]['id'] = $fila[0];
			$materia_autoridad['id'] = $fila[1];
			$materia_autoridad['matricula'] = $fila[2];
			$materia_autoridad['nombre'] = utf8_encode($fila[3]);
			$materia_autoridad['periodo'] = $fila[4];
			$relacion_materias[$indice]['materia_autoridad'] = $materia_autoridad;
			$materia_corporacion['id'] = $fila[5];
			$materia_corporacion['nombre'] = utf8_encode($fila[6]);
			$materia_corporacion['periodo'] = $fila[7];
			$relacion_materias[$indice]['materia_corporacion'] = $materia_corporacion;
			$relacion_materias[$indice]['id_plan_estudio'] = $fila[8];

		}
		$response->success = true;
		$response->data = $relacion_materias;
	}
	else
	{
		$response->error = mysql_error();
	}
	mysql_close($conexion);
}
else
{
	$response->error = mysql_error();
}
echo json_encode($response);
?>