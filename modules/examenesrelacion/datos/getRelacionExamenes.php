<?php 
require_once "config.php";
$response_server = new stdClass();
$response_server->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select * from view_relacionexamenes";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		while($row = mysql_fetch_assoc($resultado))
			$response_server->data[] = $row;
		$response_server->success = true;
	}
	else
	{
		$response_server->error = mysql_error();
	}
	mysql_close($conexion);
}
else
{
	$response_server->error = mysql_error();
}
echo json_encode($response_server);
?>