<?php 
require_once "config.php";
$request =  json_decode(file_get_contents("php://input"),true);
$datos = $request['datos'];
$response->success = true;
$basedatos[0] = "agcollege-ag";
$basedatos[1] = "prepacoppel";
$basedatos[2] = "soriana";
$basedatos[3] = "prepaley";
$basedatos[4] = "prepacoppeldgb";

$basedatos = $basedatos[$datos['plan_estudio'] - 1];

$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
  	mysql_select_db($database);
  	$query = "select count(id) from `".$basedatos."`.mdl_user where lower(username) = lower('" . $datos['usuario'] . "')";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		if($fila = mysql_fetch_array($resultado))
		{
			if($fila[0] > 0)
			{
				$response->success = false;
				$response->error = "Ya existe un usuario en la plataforma moodle ".$basedatos;
			}
			else
			{
				$query = "select (select count(tb_personas.id) from tb_personas  where nombre = '" . $datos['nombre'] . "'".
				"and apellido1 = '" . $datos['apellido1'] . "' and apellido2 = '" . $datos['apellido2'] . "' and fecha_nacimiento = '" . $datos['fecha_nacimiento'] . "'),(select count(id) from tb_alumnos where numero_empleado = '".$datos['numero_empleado']."');";
				$resultado = mysql_query($query,$conexion);
				if($resultado)
				{
					if($fila = mysql_fetch_array($resultado))
					{
						if($fila[0] > 0 || $fila[1] > 0)
						{
							$response->success = false;
							$response->error = $fila[0] > 0 ? "Ya existe una persona registrada con los nombres y fechas de nacimiento":"Ya existe un alumno con el mismo numero de trabajador";
						}
					}
					else
					{

						$response->success = false;
						$response->error = mysql_error();
					}
				}
				else
				{

					$response->success = false;
					$response->error = mysql_error();
				}

			}
		}
		else
		{
			$response->success = false;
			$response->error = mysql_error();
		}
	}
	else
	{
		$response->success = false;
		$response->error = mysql_error();
	}
 mysql_close($conexion);
}
echo json_encode($response);
?>