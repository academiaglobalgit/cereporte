<?php 
require_once "config.php";
require_once "../clases/alumno.php";

$request =  json_decode(file_get_contents("php://input"),true);
$datos = $request['datos'];

$alumno = new alumno();
$alumno->id = isset($datos['id']) ? $datos['id']:'';
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "call delalumno(" . $alumno->id . ")";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
		echo 1;
	else echo mysql_error();
	mysql_close($conexion);
}
else mysql_error();
?>