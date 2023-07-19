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
$alumno->sexo = $datos['sexo'] ? 1:0;
$alumno->email = isset($datos['email']) ? $datos['email']:'';
$alumno->rfc =  isset($datos['rfc']) ? $datos['rfc']:'';
$alumno->ife = isset($datos['ife']) ? $datos['ife']:'';
$alumno->tel1 = isset($datos['tel1']) ? $datos['tel1']:'';
$alumno->tel2 = isset($datos['tel2']) ? $datos['tel2']:'';
$alumno->tel3 = isset($datos['tel3']) ? $datos['tel3']:'';
$alumno->ciudad = isset($datos['ciudad']) ? $datos['ciudad']:'0';
$alumno->region = isset($datos['region']) ? $datos['region']:'0';
$alumno->numero_empleado = isset($datos['numero_empleado']) ? $datos['numero_empleado']:'';
$alumno->plan_estudio = isset($datos['plan_estudio']) ? $datos['plan_estudio']:'';
$alumno->corporacion = isset($datos['corporacion']) ? $datos['corporacion']:'';
$alumno->activo = isset($datos['activo']) ? $datos['activo']:'';
$alumno->activo = $datos['activo'] ? 1:0;

$response->success = false;

$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
  mysql_select_db($database);
  $query = "call actualizar_alumno (" . $alumno->id . ",'" . $alumno->usuario . "','" . trim($alumno->contrasena) . "','" . $alumno->nombre . "','".$alumno->apellido1."','".$alumno->apellido2."'," . $alumno->sexo . ",'".$alumno->fecha_nacimiento."','" . $alumno->rfc . "','" . $alumno->ife . "'," . $alumno->ciudad . ", ".$alumno->region.",'".$alumno->email."','" . $alumno->tel1 . "','" . $alumno->tel2 . "','" . $alumno->tel3 . "'," . $alumno->corporacion . "," . $alumno->activo . ");";
  $resultado = mysql_query($query,$conexion);
  if($resultado) $response->success = true;
  else $response->error = mysql_error();
}
else $response->error = mysql_error();
echo json_encode($response);

?>