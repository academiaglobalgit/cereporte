<?php 
require_once "config.php";
require_once "../clases/escuela.php";
$response = new stdClass();
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select id,nombre,id_corporacion from tb_escuelas";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$escuelas;

		for($indice = 0; $fila = mysql_fetch_array($resultado);$indice++)
		{
			$escuelas[$indice] = new escuela();
			$escuelas[$indice]->id = $fila[0];
			$escuelas[$indice]->nombre = $fila[1];
			$escuelas[$indice]->corporacion = $fila[2];
		}
		$response->success = true;
		$response->data = $escuelas;
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