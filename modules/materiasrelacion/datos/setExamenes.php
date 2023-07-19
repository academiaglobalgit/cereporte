<?php

	require_once("config.php");
	require_once "../clases/examen.php";
  require_once "../clases/respuesta.php";
  require_once "../clases/pregunta.php";
	$postdata = file_get_contents("php://input");
  $request =  json_decode($postdata,true);
  session_start();
  $datos = $request['datos'];

  
  $examen = new examen();
  $examen->id = $datos['id'];
  $examen->nombre = $datos['nombre'];
  $examen->duracion = $datos['duracion'];
  $examen->secuencia = $datos['secuencia'];
  $examen->activo = $datos['secuencia'];
  $examen->tipo = $datos['tipo'];
  $examen->materia = $datos['materia'];
  $indice = 0;
  $index = 0;
  foreach($datos['preguntas'] as $pregunta)
  {
    $examen->preguntas[$indice] = new pregunta();
    $examen->preguntas[$indice]->id = $pregunta['id'];
    $examen->preguntas[$indice]->descripcion = $pregunta['descripcion'];
    foreach($pregunta['respuestas'] as $respuesta)
    {
      $examen->preguntas[$indice]->respuestas[$index] = new respuesta();
      $examen->preguntas[$indice]->respuestas[$index]->id = $respuesta['id'];
      $examen->preguntas[$indice]->respuestas[$index]->descripcion = $respuesta['descripcion'];
      $examen->preguntas[$indice]->respuestas[$index]->correcto = $respuesta['correcto'];
      $index++;
    }
    $indice++;
  }



  
  $conexion = mysql_connect($server,$user,$password);
  if($conexion)
  {
    mysql_select_db($database);
    if( $examen->id == null)
      $query = "insert into tb_examenes (nombre,duracion,secuencia,preguntas,id_tipo,id_materia) values ();";
    else
      $query = "";
    $query = "updat";
    $resultado = mysql_query($query,$conexion);
    if($resultado)
    {
      
    }
    else
    {
      $query = "insert into tb_examenes ()values();";
      $resultado = mysql_query($query,$conexion);
    }
    mysql_close($conexion);
  }
  
  
	echo json_encode($examen);

?>
