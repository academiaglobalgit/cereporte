<?php 
require_once "config.php";
$response->success = false;
$postdata = file_get_contents("php://input");
$request =  json_decode($postdata,true);
$usuario = $request['usuario'];

$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select count(id) from tb_personas where usuario like '%" . $usuario . "%'";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$numero = 0;
		if($fila = mysql_fetch_array($resultado))
			$numero = $fila[0];
		$response->data = $numero;
		$response->success = $numero > 0;
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