<?php 
require_once "config.php";
$response->success = false;
$postdata = file_get_contents("php://input");
$request =  json_decode($postdata,true);
$numero_empleado = $request['numero_empleado'];

$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select count(id) from tb_alumnos where numero_empleado = " . $numero_empleado;
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		if($fila = mysql_fetch_array($resultado))
			$response->success = 0 < $fila[0];
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