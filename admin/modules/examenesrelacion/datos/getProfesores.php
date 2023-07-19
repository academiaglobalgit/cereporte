<?php 
$response->success = false;
session_start();
if(isset($_SESSION['persona']))
{
	require_once "config.php";
	require_once "../clases/profesor.php";
	$conexion = mysql_connect($server,$user,$password);
	if($conexion)
	{
  		mysql_select_db($database);
  		$query = "select id,nombre,apellido1,apellido2,usuario,sexo,fecha_nacimiento,edad,cedula,titulo,nacionalidad,estado_civil,activo from view_profesores";
  		$resultado = mysql_query($query,$conexion);
 		if($resultado)
 		{
 			$response->success = true;
 			$profesores = [];
 			for($indice = 0; $fila = mysql_fetch_array($resultado); $indice++)
 			{
 				$profesores[$indice] = new profesor();
 				$profesores[$indice]->id = $fila[0];
 				$profesores[$indice]->nombre = utf8_encode($fila[1]);
 				$profesores[$indice]->apellido1 = utf8_encode($fila[2]);
 				$profesores[$indice]->apellido2 = utf8_encode($fila[3]);
 				$profesores[$indice]->usuario = utf8_encode($fila[4]);
 				$profesores[$indice]->sexo = $fila[5];
 				$profesores[$indice]->fecha_nacimiento = $fila[6];
 				$profesores[$indice]->edad = $fila[7];
 				$profesores[$indice]->cedula = $fila[8];
 				$profesores[$indice]->titulo = $fila[9];
 				$profesores[$indice]->nacionalidad = $fila[10];
 				$profesores[$indice]->estado_civil = $fila[11];
 				$profesores[$indice]->activo = $fila[12];
 			}
 			$response->data = $profesores;
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
 	mysql_close($conexion);
}
else
{
	$response->error = "Usuario no registrado";
}
echo json_encode($response);
?>