<?php
require_once "config.php";
require_once "../clases/corporacion.php";
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select id,nombre,activo from view_corporaciones where id <> 5 ";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{

		$corporaciones = [];
		for($indice = 0; $fila = mysql_fetch_array($resultado); $indice++)
		{
			$corporaciones[$indice] = new corporacion();
			$corporaciones[$indice]->id = $fila[0];
			$corporaciones[$indice]->nombre = utf8_encode($fila[1]);
			$corporaciones[$indice]->activo = $fila[2];
		}

		$response->success = true;
		$response->data = $corporaciones;
	}
	else
	{
		$response->error = "No hay corporaciones disponibles " . mysql_error();
	}
	mysql_close($conexion);
}
else
{
	$response->error = "Error en la conexion " .mysql_error();
}
echo json_encode($response);
?>