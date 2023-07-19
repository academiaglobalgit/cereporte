<?php
	require_once("config.php");
	require_once "../clases/respuesta.php";
	$postdata = file_get_contents("php://input");
  $request =  json_decode($postdata,true);
  session_start();

  if(isset($request['datos']) && isset($_SESSION['id_alumno']))
  {
    $id_examen = $request['datos'];
    $id_alumno = $_SESSION['id_alumno'];
    $indice = 0;
    $conexion = mysql_connect($server,$user,$password);
    if($conexion)
    {
      mysql_select_db($database);  
      echo mysql_query("insert into ag_evaluacion_examen(id_alumno,id_examen)values(" . $id_alumno . "," . $id_examen . ");",$conexion) ? mysql_insert_id($conexion) : mysql_error();
      mysql_close($conexion);
    }
    else echo mysql_error();
  }
?>
