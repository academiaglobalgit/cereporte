<?php 
require_once "config.php";
require_once "../clases/respuesta.php";
require_once "../clases/pregunta.php";
require_once "../clases/examen.php";

$postdata = file_get_contents("php://input");
$request =  json_decode($postdata,true);
$datos = $request['datos'];
$id_examen = $datos['id_examen'];

$examenes;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select id,nombre,duracion from examenes where id = ".$id_examen;
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		for($indice=0; $fila = mysql_fetch_array($resultado); $indice++)
		{
			$examenes[$indice] = new examen();
			$examenes[$indice]->id = $fila[0];
			$examenes[$indice]->nombre = $fila[1];
			$examenes[$indice]->duracion = $fila[2];
			$examenes[$indice]->fecha_inicio = date("d-m-Y h:i:s"); 
		}
	}
	foreach($examenes as $examen)
	{
		$query = "select id,descripcion from preguntas where id_examen = " . $examen->id . " order by secuencia";
		$resultado = mysql_query($query,$conexion);
		if($resultado)
		{
			$preguntas;
			for($indice = 0;$fila = mysql_fetch_array($resultado); $indice++)
			{
				$preguntas[$indice] = new pregunta();
				$preguntas[$indice]->id = $fila[0];
				$preguntas[$indice]->descripcion = $fila[1];
			}
			$examen->preguntas = $preguntas;

			foreach($examen->preguntas as $pregunta)
			{
				$query = "select id,descripcion from respuestas where id_pregunta = " . $pregunta->id;
				$resultado = mysql_query($query,$conexion);
				if($resultado)
				{
					$respuestas = null;
					for($indice = 0;$fila = mysql_fetch_array($resultado); $indice++)
					{
						$respuestas[$indice] = new respuesta();
						$respuestas[$indice]->id = $fila[0];
						$respuestas[$indice]->descripcion = $fila[1];
					}
					$pregunta->respuestas = $respuestas;
				}
				
			}	
		}
	}
	mysql_close($conexion);
}

echo json_encode($examen);



?>