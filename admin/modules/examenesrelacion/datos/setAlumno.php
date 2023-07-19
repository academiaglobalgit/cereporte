<?php 
require_once "config.php";
require_once "../clases/alumno.php";
$request =  json_decode(file_get_contents("php://input"),true);
$datos = $request['datos'];

$alumno = new alumno();
$alumno->id = isset($datos['id']) ? $datos['id']:'';
$alumno->idmoodle = isset($datos['idmoodle']) ? $datos['idmoodle']:'';
$alumno->usuario = isset($datos['usuario']) ? $datos['usuario']:'';
$alumno->contrasena = isset($datos['contrasena']) ? $datos['contrasena']:'';
$alumno->nombre = isset($datos['nombre']) ? $datos['nombre']:'';
$alumno->apellido1 = isset($datos['apellido1']) ? $datos['apellido1']:'';
$alumno->apellido2 = isset($datos['apellido2']) ? $datos['apellido2']:'';
$alumno->fecha_nacimiento = isset($datos['fecha_nacimiento']) ? $datos['fecha_nacimiento']:'';
$alumno->sexo = isset($datos['sexo']) ? $datos['sexo']:'';
$alumno->email = isset($datos['email']) ? $datos['email']:'';
$alumno->rfc =  isset($datos['rfc']) ? $datos['rfc']:'';
$alumno->ife = isset($datos['ife']) ? $datos['ife']:'';
$alumno->tel1 = isset($datos['tel1']) ? $datos['tel1']:'';
$alumno->tel2 = isset($datos['tel2']) ? $datos['tel2']:'';
$alumno->tel3 = isset($datos['tel3']) ? $datos['tel3']:'';
$alumno->region = isset($datos['region']) ? $datos['region']:'';
$alumno->numero_empleado = isset($datos['numero_empleado']) ? $datos['numero_empleado']:'';
$alumno->plan_estudio = isset($datos['plan_estudio']) ? $datos['plan_estudio']:'';
$alumno->corporacion = isset($datos['corporacion']) ? $datos['corporacion']:'';

$basedatos = [];
$basedatos[0] = 'agcollege-ag';
$basedatos[1] = 'prepacoppel';
$basedatos[2] = 'soriana';
$basedatos[3] = 'prepaley';
$basedatos[4] = 'prepacoppel-dgb';
$basedatos = $basedatos[$alumno->plan_estudio - 1];

$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
  mysql_select_db($database);
  if($alumno->id == null)
  {
  	$query = "insert into tb_personas(idmoodle,usuario,contrasena,permisos,nombre,apellido1,apellido2,sexo,fecha_nacimiento,id_corporacion) values (" . $alumno->idmoodle . ",'" . $alumno->usuario . "','" . $alumno->contrasena . "',1,'" . $alumno->nombre . "','".$alumno->apellido1."','".$alumno->apellido2."',1,'".$alumno->fecha_nacimiento."'," . $alumno->corporacion['id'] . ")";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{ 
	  $alumno->id = mysql_insert_id($conexion);
	  $query = "insert into tb_alumnos (id_persona,numero_empleado,id_plan_estudio,idmoodle) values (" . $alumno->id . "," . $alumno->numero_empleado . "," . $alumno->plan_estudio['id'] . ",".$alumno->idmoodle.")";	
	  $resultado = mysql_query($query,$conexion);
	  if($resultado)
	  {
	  	$query = "INSERT INTO " . $basedatos . ".mdl_user(auth,confirmed,mnethostid,username,password,firstname,lastname,email,phone1,phone2,city,country,timecreated) values ('manual',1,1,'".$alumno->usuario."',MD5(concat('" . $alumno->contrasena . "','3;a2drrR@}kb;z=-^}Ga:Uwz3u')),'" . $alumno->nombre . "','" . $alumno->apellido1 . " " . $alumno->apellido2 . "','" . $alumno->email . "','" . $alumno->tel1 . "','" . $alumno->tel2 . "','" . $alumno->region['nombre'] . "','mx',unix_timestamp(now()))";	
	  	$resultado = mysql_query($query,$conexion);
	  	if($resultado)
	  	{
	  	   $alumno->idmoodle = mysql_insert_id($conexion);
	  	   echo json_encode($alumno);
	  	}
	  }
	}




  }
  else
  {
  	$query = "update tb_personas set idmoodle = " . $alumno->idmoodle . ", usuario = '" . $alumno->usuario . "', contrasena = '" . $alumno->contrasena . "', nombre = '" . $alumno->nombre . "', apellido1 = '" . $alumno->apellido1 . "', apellido2 = '" . $alumno->apellido2 . "', sexo = " . $alumno->sexo . ", fecha_nacimiento = '" . $alumno->fecha_nacimiento . "', id_corporacion = " . $alumno->corporacion['id'] . " where id = " . $alumno->id;
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{ 
	  $query = "update tb_alumnos set numero_empleado = " . $alumno->id . ", id_plan_estudio = " . $alumno->plan_estudio['id'] . " where id =  " . $alumno->id;
	  $resultado = mysql_query($query,$conexion);
	  if($resultado)
	  {
	  	$pass = ($alumno->contrasena == null || $alumno->contrasena == '') ? "":"password = md5(concat('" . $alumno->contrasena . "','3;a2drrR@}kb;z=-^}Ga:Uwz3u')),";
	  	$query = "update " . $basedatos[$alumno->corporacion['id']] . ".mdl_user set username = '" . $alumno->usuario . "', " . $pass . " firstname = '" . $alumno->nombre . "',lastname = " . $alumno->apellido1 . " ". $alumno->apellido2 . ",email = " . $alumno->email . ",phone1 = '" . $alumno->tel1 . "' ,phone2 = '" . $alumno->tel2 . "',city = '" . $alumno->region['nombre'] . "', timemodified = UNIX_TIMESTAMP(now()) where id = " . $alumno->idmoodle;	
	  	$resultado = mysql_query($query,$conexion);
	  	if($resultado)
	  	{
	  		echo json_encode($alumno);
	  	}
	  }
	}
  }

  mysql_close($conexion);
}



?>