<?php
require_once "config.php";
require_once "../clases/alumno.php";

$request =  json_decode(file_get_contents("php://input"),true);

$pagina = $request['pagina'];
$porpagina = $request['porpagina'];


$response->success = false; 
$conexion = mysql_connect($server,$user,$password);

if($conexion)
{
	mysql_select_db($database);
	mysql_set_charset("UTF8", $conexion);
	$total = 0;
	$query = "select count(tb_alumnos.id) from tb_alumnos inner join tb_personas on  tb_personas.id = tb_alumnos.id_persona where tb_personas.eliminado = 0";
	$resultado = mysql_query($query,$conexion);
	if($resultado) if($fila = mysql_fetch_array($resultado)) $total = $fila[0];

	$query = "select tb_alumnos.id_persona,usuario,sucursal,nombre,apellido1,apellido2,sexo,fecha_nacimiento,email,rfc,ife,tel1,tel2,tel3,numero_empleado,activo,tb_alumnos.id_corporacion,id_plan_estudio,tb_alumnos.idmoodle,ciudad,estado_civil,tb_alumnos.estado from tb_alumnos inner join tb_personas on tb_alumnos.id_persona = tb_personas.id where tb_personas.eliminado = 0 or tb_alumnos.eliminado = 0 and tb_personas.permisos = 1 order by nombre,apellido1,apellido2 limit ".($pagina - 1) * $porpagina  . " , ". $pagina * $porpagina;
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$alumnos = [];
		for($indice = 0; $fila =  mysql_fetch_array($resultado); $indice++)
		{
			$alumnos[$indice] = new alumno();
			$alumnos[$indice]->id = $fila[0];
			$alumnos[$indice]->usuario = $fila[1];
			$alumnos[$indice]->sucursal = $fila[2];
			$alumnos[$indice]->nombre = $fila[3];
			$alumnos[$indice]->apellido1 = $fila[4];
			$alumnos[$indice]->apellido2 = $fila[5];
			$alumnos[$indice]->sexo = $fila[6];
			$alumnos[$indice]->fecha_nacimiento = $fila[7];
			$alumnos[$indice]->email = $fila[8];
			$alumnos[$indice]->rfc = $fila[9];
			$alumnos[$indice]->ife = $fila[10];
			$alumnos[$indice]->tel1 = $fila[11];
			$alumnos[$indice]->tel2 = $fila[12];
			$alumnos[$indice]->tel3 = $fila[13];
			$alumnos[$indice]->numero_empleado = $fila[14];
			$alumnos[$indice]->activo = $fila[15];
			$alumnos[$indice]->id_corporacion = $fila[16];
			$alumnos[$indice]->plan_estudio = $fila[17];
			$alumnos[$indice]->idmoodle = $fila[18];
			$alumnos[$indice]->ciudad = $fila[19];
			$alumnos[$indice]->estado_civil = $fila[20];
			$alumnos[$indice]->estado = $fila[21];

		}
		$response->success = true;
		$response->data->alumnos = $alumnos;
		$response->data->total = (int)$total;
	}
	else
	{
		$response->error = "No hay alumnos disponibles ".mysql_error();
	}
	mysql_close($conexion);
	
}
else
{
	$response->error = "No se pudo conectar a la base de datos" . mysql_error();
}
echo json_encode($response);
?>