<?php 
require_once "config.php";
$response->success = false;
$request =  json_decode(file_get_contents("php://input"),true);
$id = $request['id'];
if($id  > 0)
{
	$conexion = mysql_connect($server,$user,$password);
	if($conexion)
	{
		mysql_select_db($database);
		$query = "delete from tb_examenes_relacion where id = $id";
		$resultado = mysql_query($query,$conexion);
		if($resultado)
		{
			$response->success = true;
			$response->data = "Registro eliminado correctamente:".$id;
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
}
else
{
	$response->error = "El id de registro no es valido";
}

echo json_encode($response);
?>