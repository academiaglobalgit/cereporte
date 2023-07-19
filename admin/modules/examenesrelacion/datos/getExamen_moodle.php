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
	$query = "select mdl_quiz.id,mdl_quiz.name,ag_examenes.duracion,case ag_examenes.id_tipo when 1 then 'Examen parcial' when 2 then 'examen final' when 3 then 'examen extraordinario' end as 'tipo de examen',now() from ag_examenes inner join mdl_course_modules on ag_examenes.id = mdl_course_modules.id inner join mdl_quiz on mdl_quiz.id = mdl_course_modules.instance where ag_examenes.id = " . $id_examen;
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		for($indice=0; $fila = mysql_fetch_array($resultado); $indice++)
		{
			$examenes[$indice] = new examen();
			$examenes[$indice]->id = $fila[0];
			$examenes[$indice]->nombre = utf8_encode($fila[1]);
			$examenes[$indice]->duracion = $fila[2];
			$examenes[$indice]->tipo = $fila[3];
			$examenes[$indice]->fecha_inicio = $fila[4]; 
		}
	}
	foreach($examenes as $examen)
	{
		$query = "select mdl_question.id,questiontext from mdl_quiz_question_instances inner join mdl_question on mdl_question.id = mdl_quiz_question_instances.question where mdl_quiz_question_instances.quiz = " . $examen->id." order by RAND()";
                                                                                 
		$resultado = mysql_query($query,$conexion);
		if($resultado)
		{
			$preguntas;
			for($indice = 0;$fila = mysql_fetch_array($resultado); $indice++)
			{
				$preguntas[$indice] = new pregunta();
				$preguntas[$indice]->id = $fila[0];
				$preguntas[$indice]->descripcion = utf8_encode(strip_tags($fila[1]));
			}
			$examen->preguntas = $preguntas;

			foreach($examen->preguntas as $pregunta)
			{
				$query = "select mdl_question_answers.id,answer from mdl_question inner join mdl_question_answers on mdl_question_answers.question = mdl_question.id where mdl_question_answers.question =" .$pregunta->id." order by RAND()";
				$resultado = mysql_query($query,$conexion);
				if($resultado)
				{
					$respuestas = null;
					for($indice = 0;$fila = mysql_fetch_array($resultado); $indice++)
					{
						$respuestas[$indice] = new respuesta();
						$respuestas[$indice]->id = $fila[0];
						$respuestas[$indice]->descripcion = utf8_encode(strip_tags($fila[1]));
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