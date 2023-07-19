<?php
require_once "config.php";
require_once "../clases/estado_alumno.php";
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select id,tipo,descripcion from tb_alumnos_estados";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$estados_alumnos = [];
		for($indice = 0; $fila = mysql_fetch_array($resultado); $indice++)
		{
			$estados_alumnos[$indice]              = new estadoalumno();
			$estados_alumnos[$indice]->id          = $fila[0];
			$estados_alumnos[$indice]->tipo        = $fila[1];
			$estados_alumnos[$indice]->descripcion = utf8_encode($fila[2]);
		}
		$response->data = $estados_alumnos;
		$response->success = true;

	}
	else
	{
		$response->error = "No hay estados_alumnos disponibles ". mysql_error();
	}
	mysql_close($conexion);
}
else
{
	$response->error = "No se pudo conectar a la base de datos ". mysql_error();
}
echo json_encode($response);
?>