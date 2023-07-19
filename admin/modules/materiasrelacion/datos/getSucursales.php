<?php 
require_once "config.php";
require_once "../clases/sucursal.php";
$response = new stdClass();
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select id,numero,nombre,id_ciudad,id_corporacion from tb_sucursales";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$sucursales = [];
		for($indice = 0; $fila = mysql_fetch_array($resultado); $indice++)
		{
			$sucursales[$indice]              = new sucursal();
			$sucursales[$indice]->id          = $fila[0];
			$sucursales[$indice]->numero      = $fila[1];
			$sucursales[$indice]->nombre      = utf8_encode($fila[2]);
			$sucursales[$indice]->ciudad      = $fila[3];
			$sucursales[$indice]->corporacion = $fila[4];
		}
		$response->data = $sucursales;
		$response->success = true;

	}
	else
	{
		$response->error = "No hay sucursales disponibles ". mysql_error();
	}
	mysql_close($conexion);
}
else
{
	$response->error = "No se pudo conectar a la base de datos ". mysql_error();
}
echo json_encode($response);
?>