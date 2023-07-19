<?php 
require_once "config.php";
$response = new stdClass();
$response->success = false;
$request =  json_decode(file_get_contents("php://input"),true);
$id_relacion = $request['id'];
if($id_relacion > 0)
{
	$conexion = mysql_connect($server,$user,$password);
	if($conexion)
	{
		mysql_select_db($database);
		$query = "delete from tb_materias_relacion where id = $id_relacion";
		$resultado = mysql_query($query,$conexion);
		if($resultado)
		{
			
	
			$response->success = true;
			$response->data = "Registro eliminado correctamente";
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