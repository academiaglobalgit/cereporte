<?php 
$response = [];
$response->success = false;
session_start();
if(isset($_SESSION['persona']))
{
	require_once "config.php";
	require_once "../clases/alumno.php";
	$conexion = mysql_connect($server,$user,$password);
	if($conexion)
	{
		mysql_select_db($database);
		$query = "select tbdgb_alumnos.id,matricula from tbdgb_alumnos";
		$resultado = mysql_query($query,$conexion);
		if($resultado)
		{
			$alumnos = [];
			$response->success = true;
			for($indice=0; $fila = mysql_fetch_array($resultado); $indice++)
			{
				$alumnos[$indice] = new alumno();
				$alumnos[$indice]->id = $fila[0];
				$alumnos[$indice]->matricula = $fila[1];
			}
		}
		else
		{
			$response->error = mysql_error();
		}

	}
	else
	{
		$response->error = mysql_error();
	}
}
echo json_encode($response);
?>