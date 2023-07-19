<?php 
require_once "config.php";
$response->success = false;
$request =  json_decode(file_get_contents("php://input"),true);
$id_materia_corporacion = $request['id_materia_corporacion'];
$id_materia_autoridad = $request['id_materia_autoridad'];
if($id_materia_corporacion > 0)
{
	if($id_materia_autoridad > 0)
	{

		$conexion = mysql_connect($server,$user,$password);
		if($conexion)
		{
			mysql_select_db($database);
			$query = "insert into tb_materias_relacion(id_materia,id_materia_autoridad)values($id_materia_corporacion,$id_materia_autoridad)";
			$resultado = mysql_query($query,$conexion);
			if($resultado)
			{
				$response->success = true;
				$response->id =  mysql_insert_id($conexion);
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
		$response->error = "El identificador de la materia autoridad no es valida";
	}

}
else
{
	$response->error = "El identificador de la materia corporacion no es valida";
}

echo json_encode($response);
?>