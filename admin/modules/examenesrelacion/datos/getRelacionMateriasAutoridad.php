<?php 
require_once "config.php";
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select a.id,b.id as 'id autoridad',b.matricula,b.nombre as 'materia autoridad',b.periodo,( select id_plan_estudio from tb_lineas_formacion where id = b.id_linea_formacion ) as 'id_plan_estudio_autoridad',c.id as 'id corporacion',c.nombre as 'materia corporacion',c.periodo,d.id_plan_estudio as 'plan estudio' from tb_materias_relacion a inner join tb_materias b on b.id = a.id_materia_autoridad inner join tb_materias c on c.id = a.id_materia inner join tb_materias_ids d on d.id_materia = c.id ";
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
			$materia_autoridad['id_plan_estudio_autoridad'] = $fila[5];

			$relacion_materias[$indice]['materia_autoridad'] = $materia_autoridad;
			$materia_corporacion['id'] = $fila[6];
			$materia_corporacion['nombre'] = utf8_encode($fila[7]);
			$materia_corporacion['periodo'] = $fila[8];
			$relacion_materias[$indice]['materia_corporacion'] = $materia_corporacion;
			$relacion_materias[$indice]['id_plan_estudio'] = $fila[9];

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