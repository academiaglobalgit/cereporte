<?php 
require_once "config.php";
require_once "../clases/ciudad.php";
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select id,nombre,nomenclatura,activo from tb_ciudades order by nombre";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$ciudades = [];
		for($indice = 0; $fila = mysql_fetch_array($resultado); $indice++)
		{
			$ciudades[$indice] = new ciudad();
			$ciudades[$indice]->id 	   = $fila[0];
			$ciudades[$indice]->nombre = utf8_encode($fila[1]);
			$ciudades[$indice]->nomenclatura = utf8_encode($fila[2]);

			$ciudades[$indice]->activo = $fila[3];
		}
		$response->data = $ciudades;
		$response->success = true;

	}
	else
	{
		$response->error = "No hay ciudades disponibles ". mysql_error();
	}
	mysql_close($conexion);
}
else
{
	$response->error = "No se pudo conectar a la base de datos ". mysql_error();
}
echo json_encode($response);
?>