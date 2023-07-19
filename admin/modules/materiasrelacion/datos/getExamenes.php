<?php 
require_once "config.php";
require_once "../clases/respuesta.php";
require_once "../clases/pregunta.php";
require_once "../clases/examen.php";
require_once "../clases/materia.php";
require_once "../clases/tipo_examen.php";
$postdata = file_get_contents("php://input");
$request =  json_decode($postdata,true);
$datos = $request['datos'];
//var_dump($datos);
$materia = $datos;

$examenes;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select id,nombre,secuencia,duracion,preguntas,id_tipo,activo from view_examenes where id_materia = " . $materia["id"] . " order by activo desc";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		for($indice=0; $fila = mysql_fetch_array($resultado); $indice++)
		{
			$examenes[$indice] = new examen();
			$examenes[$indice]->id = $fila[0];
			$examenes[$indice]->nombre = utf8_encode($fila[1]);
			$examenes[$indice]->secuencia = $fila[2];
			$examenes[$indice]->duracion = $fila[3];
			$examenes[$indice]->preguntas_calificables = $fila[4];
			$examenes[$indice]->tipo = $fila[5];
			$examenes[$indice]->activo = $fila[6];
		}
		foreach($examenes as $examen)
		{
			$query = "select id,descripcion from view_tipos_examenes where id = ".$examen->tipo;
			$resultado = mysql_query($query,$conexion);
			if($resultado)
			{
				for($indice = 0; $fila = mysql_fetch_array($resultado); $indice++)
				{
					$examen->tipo = new tipoexamen();
					$examen->tipo->id = $fila[0];
					$examen->tipo->descripcion = utf8_encode($fila[1]);
				}
			}

			$query = "select id,descripcion,activo from view_preguntas where id_examen = " . $examen->id . " order by activo desc";
			$resultado = mysql_query($query,$conexion);
			if($resultado)
			{
				$preguntas=[];
				for($indice = 0;$fila = mysql_fetch_array($resultado); $indice++)
				{
					$preguntas[$indice] = new pregunta();
					$preguntas[$indice]->id = $fila[0];
					$preguntas[$indice]->descripcion = utf8_encode($fila[1]);
					$preguntas[$indice]->activo = $fila[2];
				}
				$examen->preguntas = $preguntas;

				foreach($examen->preguntas as $pregunta)
				{
					$query = "select id,descripcion,correcto,activo from view_respuestas where id_pregunta = " . $pregunta->id . " order by activo,correcto desc";

					$resultado = mysql_query($query,$conexion);
					if($resultado)
					{
						$respuestas = [];
						for($indice = 0;$fila = mysql_fetch_array($resultado); $indice++)
						{
							$respuestas[$indice] = new respuesta();
							$respuestas[$indice]->id = $fila[0];
							$respuestas[$indice]->descripcion = utf8_encode($fila[1]);
							$respuestas[$indice]->correcto = $fila[2];
							$respuestas[$indice]->activo = $fila[3];

						}
						$pregunta->respuestas = $respuestas;
					}
					
				}	
			}
		}
		echo json_encode($examenes);
	}
	
	mysql_close($conexion);
}
?>