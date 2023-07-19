<?php 
require_once "config.php";
require_once "../clases/region.php";
$response->success = false; 
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	mysql_set_charset("UTF8", $conexion);
	$query = "select id,nombre,nomenclatura,id_corporacion from tb_regiones";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$regiones = [];
		for($indice = 0; $fila =  mysql_fetch_array($resultado); $indice++)
		{
			$regiones[$indice] = new region();
			$regiones[$indice]->id = $fila[0];
			$regiones[$indice]->nombre = $fila[1];
			$regiones[$indice]->nomenclatura = $fila[2];
			$regiones[$indice]->corporacion = $fila[3];
		}
		$response->success = true;
		$response->data = $regiones;
	}
	else
	{
		$response->error = "No hay regiones disponibles ".mysql_error();
	}
	mysql_close($conexion);
}
else
{
	$response->error = "No se pudo conectar a la base de datos" . mysql_error();
}
echo json_encode($response);
?>