<?php
require_once "config.php";
require_once "../clases/alumno.php";
$request =  json_decode(file_get_contents("php://input"),true);

$datos                       = $request['datos'];
$response->success           = true;
$basedatos[0]                = "agcollege-ag";
$basedatos[1]                = "prepacoppel";
$basedatos[2]                = "soriana";
$basedatos[3]                = "prepaley";
$basedatos[4]                = "prepacoppeldgb";
$basedatos[5]                = "prepatoks";


$newalumno                   = new alumno();
$newalumno->usuario          = $datos['usuario'];
$newalumno->contrasena       = $datos['contrasena'];
$newalumno->nombre           = $datos['nombre'];
$newalumno->apellido1        = $datos['apellido1'];
$newalumno->apellido2        = $datos['apellido2'];
$newalumno->sexo             = $datos['sexo'];
$newalumno->corporacion      = $datos['corporacion'];
$newalumno->plan_estudio     = $datos['plan_estudio'];
$newalumno->fecha_nacimiento = $datos['fecha_nacimiento'];
$newalumno->activo           = 1;
$newalumno->numero_empleado  = $datos['numero_empleado'];
$newalumno->plan_estudio     = $datos['plan_estudio'];
$newalumno->prueba 			 = $datos['prueba'];

$newalumno->fecha_nacimiento = str_replace("/","-",$newalumno->fecha_nacimiento);
if(split('-', $newalumno->fecha_nacimiento)[2] > 31)
{
	$dia = split('-',$newalumno->fecha_nacimiento)[0];
	$mes = split('-',$newalumno->fecha_nacimiento)[1];
	$anio = split('-',$newalumno->fecha_nacimiento)[2];
	$newalumno->fecha_nacimiento = $anio."-".$mes."-".$dia;

}

$basedatos = $basedatos[$newalumno->plan_estudio - 1];

if(isset($datos['ciudad'])) $newalumno->ciudad        = $datos['ciudad'];
if(isset($datos['region'])) $newalumno->region        = $datos['region'];
if(isset($datos['tipo'])) $newalumno->tipo            = $datos['tipo'];
if(isset($datos['telefonos']))	$newalumno->telefonos = $datos['telefonos'];
if(isset($datos['puesto'])) $newalumno->puesto        = $datos['puesto'];
if(isset($datos['sucursal'])) $newalumno->sucursal    = $datos['sucursal'];




$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
    mysql_select_db($database);
	$query = "insert into `" . $basedatos . "`.mdl_user (mnethostid,deleted,suspended,auth,confirmed,idnumber,country,city,username,password,firstname,lastname,email)values(1,0,0,'manual',1,' ',' ','no definido',lower('".$newalumno->usuario."'),md5(trim('" . $newalumno->contrasena . "3;a2drrR@}kb;z=-^}Ga:Uwz3u')),'" . $newalumno->nombre . "',trim('" . $newalumno->apellido1 . ' ' . $newalumno->apellido2 . "'),'".$newalumno->usuario."@agcollege.edu.mx');";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$newalumno->idmoodle = mysql_insert_id();
		if($newalumno->idmoodle > 0)
		{
			$query = "insert into tb_personas(idmoodle,usuario,contrasena,nombre,apellido1,apellido2,fecha_nacimiento,sexo,id_corporacion,corporacion_origen,prueba)
			values(".$newalumno->idmoodle.",lower('".$newalumno->usuario."'),trim('".$newalumno->contrasena."'),trim('".$newalumno->nombre."'),trim('".$newalumno->apellido1."'),trim('".$newalumno->apellido2."'),'".$newalumno->fecha_nacimiento."',".$newalumno->sexo.",".$newalumno->corporacion.",".$newalumno->corporacion."," . $newalumno->prueba . ");";
			$resultado = mysql_query($query,$conexion);
			if($resultado)
			{
				$newalumno->id = mysql_insert_id();
				if(isset($newalumno->puesto)) 		mysql_query("update tb_personas set puesto = ".$newalumno->puesto." where id = ".$newalumno->id,$conexion);
				if($newalumno->region > 0) 		mysql_query("update tb_personas set region = ".$newalumno->region." where id = ".$newalumno->id,$conexion);
				if($newalumno->ciudad > 0) 		mysql_query("update tb_personas set ciudad = ".$newalumno->ciudad." where id = ".$newalumno->id,$conexion);
				if(isset($newalumno->sucursal))		mysql_query("update tb_personas inner join tb_sucursales on tb_personas.sucursal = tb_sucursales.id set tb_personas.sucursal = ".$newalumno->sucursal." where tb_sucursales.id_corporacion = tb_personas.id_corporacion and tb_personas.id = ".$newalumno->id,$conexion);
				if(isset($datos['numero_centro']))
					if($datos['numero_centro'] > 0) mysql_query("update tb_personas set sucursal = (select id from tb_sucursales where tb_sucursales.id_corporacion = tb_personas.id_corporacion and numero = ".$datos['numero_centro'] .") where tb_personas.id = ".$newAlumno->id,$conexion);

				foreach($newalumno->telefonos as $telefono)
				{
					mysql_query("insert into tb_telefonos(id_persona,telefono)values(".$newalumno->id.",'".$telefono."')",$conexion);
				}

				$query = "insert into tb_alumnos(idmoodle,id_corporacion,id_persona,numero_empleado,id_plan_estudio,fecha_inscripcion)values(".$newalumno->idmoodle."," . $newalumno->corporacion . ",".$newalumno->id.",".$newalumno->numero_empleado.",".$newalumno->plan_estudio.",now())";



				$resultado = mysql_query($query,$conexion);
				if($resultado)
				{
					if(isset($newalumno->tipo)) mysql_query("update tb_alumnos set tipo = ".$newalumno->tipo." where id = ".$newalumno->id,$conexion);
					if( $newalumno->plan_estudio <= 2)
					{

						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid)values(1,'".($newalumno->prueba ? "prueba":"alumno")."',".$newalumno->idmoodle.")",$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid)values(4,'".$newalumno->numero_empleado."',".$newalumno->idmoodle.")",$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) select 5, nombre,".$newalumno->idmoodle."  from tb_sucursales where id = ".$newalumno->centro,$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) select 9,tb_estudiantestipo.nombre,idmoodle from tb_personas inner join tb_alumnos on tb_personas.id = tb_alumnos.id inner join tb_estudiantestipo on tb_estudiantestipo.id = tb_alumnos.tipo where  tb_personas.id = " . $newalumno->id,$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) select 10,tb_regiones.nombre,idmoodle from tb_personas inner join tb_regiones on tb_personas.region = tb_regiones.id where tb_personas.id = " . $newalumno->id,$conexion);

					}
					else if($newalumno->plan_estudio == 3)
					{

						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid)values(10,'".($newalumno->prueba ? "prueba":"alumno")."',".$newalumno->idmoodle.")",$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid)values(9,'".$newalumno->sexo ? 'Masculino':'Femenino' ."',".$newalumno->idmoodle.")",$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) select 7,tb_puestos.nombre,idmoodle from tb_personas inner join tb_puestos on tb_personas.puesto = tb_puestos.id where tb_personas.id = ".$newalumno->id,$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) select 4,tel1,idmoodle from tb_personas where id = ". $newalumno->id,$conexion);
					}
					else if($newalumno->plan_estudio == 4)
					{
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) select 7,tb_puestos.nombre,idmoodle from tb_personas inner join tb_puestos on tb_personas.puesto = tb_puestos.id where tb_personas.id = " . $newalumno->id,$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) select 12,tb_sucursales.nombre,idmoodle from tb_personas inner join tb_sucursales on tb_personas.sucursal = tb_sucursales.id where tb_personas.id = " . $newalumno->id,$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid)values(4,'".$newalumno->numero_empleado."',".$newalumno->idmoodle.")",$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid)values(9,'".$newalumno->sexo ? 'Masculino':'Femenino' ."',".$newalumno->idmoodle.")",$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) values (10,'".($newalumno->prueba ? "prueba":"alumno")."',".$newalumno->idmoodle.")",$conexion);

					}
					else if($newalumno->plan_estudio == 5)
					{
						//Prepacoppeldgb
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid)values(1,'".($newalumno->prueba ? "prueba":"alumno")."',".$newalumno->idmoodle.")",$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid)values(4,'".$newalumno->numero_empleado."',".$newalumno->idmoodle.")",$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) select 5, nombre,".$newalumno->idmoodle."  from tb_sucursales where id = ".$newalumno->centro,$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) select 9,tb_estudiantestipo.nombre,idmoodle from tb_personas inner join tb_alumnos on tb_personas.id = tb_alumnos.id inner join tb_estudiantestipo on tb_estudiantestipo.id = tb_alumnos.tipo where  tb_personas.id = " . $newalumno->id,$conexion);
						mysql_query("insert into `".$basedatos."`.mdl_user_info_data (fieldid,data,userid) select 10,tb_regiones.nombre,idmoodle from tb_personas inner join tb_regiones on tb_personas.region = tb_regiones.id where tb_personas.id = " . $newalumno->id,$conexion);


					}
					else if($newalumno->plan_estudio == 7)
					{
						//Prepatoks

					}
					else if($newalumno->plan_estudio == 8)
					{
						//Universidad toks
					}


					$response->success = true;
					$response->data = $newalumno;
				}
				else
				{
					$response->success = false;
					$response->error = "No se pudo guardar en tb_alumnos " . mysql_error();
				}
			}
			else
			{

				$response->success = false;
				$response->error = "No se pudo guardar en tb_personas ".mysql_error();
			}
		}
		else
		{
			$response->success = false;
			$response->error   = "no se pudo recuperar idmoodle";
		}
	}
	else
	{
			$response->success = false;
			$response->error   = mysql_error();
	}
 mysql_close($conexion);
}
else
{
	$response->success = false;
	$response->error = mysql_error();
}

echo json_encode($response);


?>
