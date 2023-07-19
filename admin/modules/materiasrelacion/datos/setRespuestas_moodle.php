<?php

	require_once "config.php";
	require_once "../clases/respuesta.php";
  require_once "../clases/evaluacion.php";
	$postdata = file_get_contents("php://input");
  $request =  json_decode($postdata,true);
  session_start();
  $datos = $request['datos'];
  $indice = 0;
  //var_dump($evaluacion);
  //print_r($evaluacion);

  $evaluacion= new evaluacion();
  $evaluacion->id_alumno =$_SESSION['id_alumno'];
  $evaluacion->id = $datos[0];
  $resultado = $datos[1];
  $indice = 0;
  $respuestas;
  foreach($resultado as $respuesta)
  {
    $respuestas[$indice]= new respuesta();
    $respuestas[$indice]->id = $respuesta['id'];
    $respuestas[$indice]->descripcion = $respuesta['descripcion'];
    $indice++;
  }
  $evaluacion->respuestas = $respuestas;






  $conexion = mysql_connect($server,$user,$password);
  if($conexion)
  {
    mysql_select_db($database);

    $query = "update ag_evaluacion_examen set fin = now(),fecha_actualizacion = now() where id =  ".  $evaluacion->id;
    $resultado = mysql_query($query,$conexion);
    if($resultado)
    {
      foreach($evaluacion->respuestas as $respuesta)
      {
        
        $query = "insert into ag_alumno_respuesta(id_evaluacion,id_respuesta)values(" . $evaluacion->id . "," . $respuesta->id . ");";
        $resultado = mysql_query($query,$conexion);
        if($resultado)
        {
            $query = "select if (fraction > 0,true,false) as correcto from mdl_question_answers where id = ". $respuesta->id;
            $resultado = mysql_query($query,$conexion);
            if($resultado)
            {
                if($fila = mysql_fetch_array($resultado))
                {
                  $respuesta->correcto = $fila[0];
                }
            }
           
        } 
      }

      $query = "update ag_evaluacion_examen set calificacion = round((select count(ag_alumno_respuesta.id) * 10 from ag_alumno_respuesta inner join mdl_question_answers on ag_alumno_respuesta.id_respuesta = mdl_question_answers.id where fraction > 0 and id_evaluacion = ".$evaluacion->id.") / (select count(id) from ag_alumno_respuesta where id_evaluacion = " . $evaluacion->id . "),2) where id = ".$evaluacion->id;
      $resultado = mysql_query($query,$conexion);
      if($resultado)
      {
        $query = "select calificacion from ag_evaluacion_examen where id = " . $evaluacion->id;
        $resultado = mysql_query($query,$conexion);
        if($resultado)
        {
          if($fila = mysql_fetch_array($resultado))
          $evaluacion->calificacion = $fila[0];
        }
      }
      else echo mysql_error();
    }
    else echo mysql_error();
    mysql_close($conexion);
  }
	echo json_encode($evaluacion);

//var_dump($evaluacion);
?>
