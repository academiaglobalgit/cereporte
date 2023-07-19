<?php 
require_once "config.php";
require_once "../clases/plan_estudio.php";
$response = new stdClass();
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	#$query = "select id,nombre,id_escuela,activo from tb_plan_estudio";
	$query = "
		SELECT
			id,
			CONCAT(nombre_corto, ' [', nombre, ']') AS 'nombre',
			id_escuela,
			inscripcion AS 'activo'
		FROM
			escolar.view_planes_estudio
		ORDER BY
			id_corporacion,
			id
	";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$PlanEstudios;
		for($indice = 0; $fila = mysql_fetch_array($resultado);$indice++)
		{
			$PlanEstudios[$indice] = new planestudio();
			$PlanEstudios[$indice]->id = $fila[0];
			$PlanEstudios[$indice]->nombre = utf8_encode($fila[1]);
			$PlanEstudios[$indice]->escuela = $fila[2];
			$PlanEstudios[$indice]->activo = $fila[3];

		}
		$response->success = true;
		$response->data = $PlanEstudios;
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