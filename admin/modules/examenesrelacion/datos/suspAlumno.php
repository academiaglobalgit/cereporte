<?php
/*
require_once "config.php";
require_once "../clases/alumno.php";
$postdata = file_get_contents("php://input");
$request =  json_decode($postdata,true);
$datos = $request['datos'];
$alumno = new alumno();
$alumno->id = isset($datos['id']) ? $datos['id']:'';
$alumno->activo = $datos['activo'] ? 0:1;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "call activo_alumno(" . $alumno->id . "," . $alumno->activo  . ")";
	echo mysql_query($query,$conexion) ? "1" : mysql_error();
	mysql_close($conexion);
}
else mysql_error();
*/
?>