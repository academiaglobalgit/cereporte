<?php 
require_once "config.php";
require_once "../clases/examen.php";

$postdata = file_get_contents("php://input");
$request =  json_decode($postdata,true);
$datos = $request['datos'];
//var_dump($datos);
$examen = $datos;

$examenes;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "update tb_examenes set eliminado = 1 where id = ".$examen['id'];
	echo mysql_query($query,$conexion) ? "1" : mysql_error();
	mysql_close($conexion);
}
?>