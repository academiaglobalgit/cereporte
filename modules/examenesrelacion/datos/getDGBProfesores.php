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
  		$query = "select tb_personas.id,nombre,apellido1,apellido2,usuario,if(sexo = 1,'Masculino','Femenino') as sexo,fecha_nacimiento,TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) as edad,cedula,titulo,nacionalidad,tb_profesores.estado_civil,tb_personas.activo from tb_personas inner join tb_profesores on tb_personas.id = tb_profesores.id inner join tb_materias_profesores on tb_materias_profesores.id_profesor = tb_profesores.id inner join tbdgb_materias_ids on tbdgb_materias_ids.id_materia = tb_materias_profesores.id_materia group by tb_personas.id";
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