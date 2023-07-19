<?php
require_once "config.php";
require_once "../clases/persona.php";
session_start();
$postdata = file_get_contents("php://input");
$request =  json_decode($postdata,true);
$datos = $request['datos'];
$persona = new persona();
$persona->usuario = isset($datos['usuario']) ? $datos['usuario']:'';
$persona->contrasena = isset($datos['contrasena']) ? $datos['contrasena']:'';
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "call proc_validarusuario('" . $persona->usuario . "','" . $persona->contrasena  . "')";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		if($fila = mysql_fetch_array($resultado))
		{

			$persona->id = $fila[0];
			$persona->permisos = $fila[1];
			$_SESSION['persona'] = $persona;
			$_SESSION['permisos'] = $persona->permisos;
		}
		echo json_encode($persona);
	}
	else echo mysql_error();
	mysql_close($conexion);
}
else echo mysql_error();
?>