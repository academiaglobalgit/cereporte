<?php 
require_once "config.php";
require_once "../clases/puesto.php";
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select id,nombre,id_corporacion from tb_puestos";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$puestos = [];
		for($indice = 0; $fila = mysql_fetch_array($resultado); $indice++)
		{
			$puestos[$indice] = new puesto();
			$puestos[$indice]->id 	   = $fila[0];
			$puestos[$indice]->nombre = utf8_encode($fila[1]);
			$puestos[$indice]->id_corporacion = $fila[2];
		}
		$response->data = $puestos;
		$response->success = true;

	}
	else
	{
		$response->error = "No hay puestos disponibles ". mysql_error();
	}
	mysql_close($conexion);
}
else
{
	$response->error = "No se pudo conectar a la base de datos ". mysql_error();
}
echo json_encode($response);
?>