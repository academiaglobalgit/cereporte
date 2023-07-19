<?php 
require_once "config.php";
$response->success = false;
$request =  json_decode(file_get_contents("php://input"),true);
$id_examen = $request['id_examen'];
$id_examen_autoridad = $request['id_examen_autoridad'];
if($id_examen > 0)
{
	if($id_examen_autoridad > 0)
	{

		$conexion = mysql_connect($server,$user,$password);
		if($conexion)
		{
			mysql_select_db($database);
			$query = "call proc_add_examenes_relacion($id_examen,$id_examen_autoridad);";
			$resultado = mysql_query($query,$conexion);
			if($resultado)
			{
				if($fila = mysql_fetch_assoc($resultado))
				{
					$response->success = true;
					$response->data = $fila;
				}
				else
				{
					$response->error = "El proceso almacenado no regresó valor";				
				}
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