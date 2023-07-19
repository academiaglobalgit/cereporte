<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

 	header("Access-Control-Allow-Origin: * ");
	require_once("../models/Connection.class.php");
	require_once("../models/Usuarios.class.php");
	require_once("../models/PlanEstudios.class.php");
	require_once("../models/Geo.class.php");
	require_once("../models/Sucursales.class.php");


	//require_once("../models/Validator.class.php");

	/*initialize result object*/
	$result['success']=false;
	$result['message']='Invalid Request';
	$result['data']=null;


	if(isset($_POST['request'])){
		$request=$_POST;
		switch ($request['request']) {

			/*==========######### usuarios ##########============*/
			case "GetUsuarios":
				
					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
					$bd_plan='`'.$res_plan['data'][0]['basededatos'].'`';
					$usuarios = new Usuarios();
					$result=$usuarios->GetUsuarios($bd_plan,$request['data']['id_plan_estudio'],$request['data']['id_moodle'],$request['data']['numero_empleado'],$request['data']['nombre']);		
				
			break;
		
			case "UpdateUsuario":

				if((isset($_SESSION['permisos']) && (int)$_SESSION['permisos'] != 1 ) or true){
						$planestudios = new PlanEstudios();
						$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
						$bd_plan='`'.$res_plan['data'][0]['basededatos'].'`';
						$usuarios = new Usuarios();
						$new_username=$usuarios->GetNewUsername($bd_plan,$request['data']['nombre'],$request['data']['apellido1'],$request['data']['id_moodle']);

						$exist_num_emp=$usuarios->GetNumeroEmpleado($request['data']['id_persona'],$request['data']['numero_empleado'],$res_plan['data'][0]['id_corporacion']);

						if((int)$exist_num_emp['data'][0]['conteo']>0){
							$result['message']="Lo sentimos El numero de empleado/Estafeta que ingresó ya se encuentra registrado en esta corporacion";
						}else{
							$result=$usuarios->UpdateUsuario($bd_plan,$request['data']['id_plan_estudio'],$request['data']['id_moodle'],$request['data']['id_persona'],$request['data']['nombre'],$request['data']['apellido1'],$request['data']['apellido2'],$new_username,$request['data']['numero_empleado'],$request['data']['fecha_nacimiento'],$request['data']['tipo_alumno'],$request['data']['numero_sucursal'],$request['data']['nombre_sucursal'],$request['data']['horario'],$request['data']['id_estado'],$request['data']['sexo'],$request['data']['email'],$request['data']['id_sucursal']);
							//$result['message'].="sucursal request:".$request['data']['id_sucursal'];
						}
				}else{
					$result['success']=false;
					$result['message']="LO SENTIMOS. ESTE USUARIO NO ESTÁ AUTORIZADO PARA REALIZAR ESTA ACCIÓN.: ".$_SESSION['permisos'];
				}

					
			break;


			case "InsertUsuario":

			if((isset($_SESSION['permisos']) && (int)$_SESSION['permisos'] != 1 ) or true){

					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
					$bd_plan='`'.$res_plan['data'][0]['basededatos'].'`';
					$usuarios = new Usuarios();
					$new_username=$usuarios->GetNewUsername($bd_plan,$request['data']['nombre'],$request['data']['apellido1'],0);
					$exist_num_emp=$usuarios->GetNumeroEmpleado(0,$request['data']['numero_empleado'],$res_plan['data'][0]['id_corporacion']);

					if((int)$exist_num_emp['data'][0]['conteo']>0){// ya existe # empleado
						$result['message']="Lo sentimos El numero de empleado/Estafeta que ingresó ya se encuentra registrado en esta corporacion";
					}else{ 
						$exist_nombre=$usuarios->GetNombreCompleto(0,$request['data']['nombre'],$request['data']['apellido1'],$request['data']['apellido2'],$request['data']['fecha_nacimiento']);

						if((int)$exist_nombre['data'][0]['conteo']>0){ //ya existe nombre
							$result['message']="Lo sentimos este usuario ya exìste, porfavor ingrese correctamente su fecha de nacimiento para diferenciarlo";

						}else{
							$result=$usuarios->InsertUsuario($bd_plan,$res_plan['data'][0]['id_corporacion'],$request['data']['id_plan_estudio'],$request['data']['nombre'],$request['data']['apellido1'],$request['data']['apellido2'],$new_username,$request['data']['numero_empleado'],$request['data']['fecha_nacimiento'],$request['data']['telefono_casa'],$request['data']['telefono_celular'],$request['data']['telefono_alternativo'],$request['data']['email'],$request['data']['id_estado'],$request['data']['id_ciudad'],$request['data']['nombre_ciudad'],$request['data']['id_region'],$request['data']['nombre_region'],$request['data']['numero_sucursal'],$request['data']['nombre_sucursal'],$request['data']['tipo_alumno'],$request['data']['sexo']);
							//$planestudios->Close();
							//$usuarios->Close();
						}
						
					}
			}else{
				$result['success']=false;
					$result['message']="LO SENTIMOS. ESTE USUARIO NO ESTÁ AUTORIZADO PARA REALIZAR ESTA ACCIÓN.: ".$_SESSION['permisos'];
			}

			break;


			/*=============PLAN DE ESTUDIOS===============*/
			case "GetPlanEstudios":
				
					$planestudios = new PlanEstudios();
					$result=$planestudios->GetPlanEstudios();
				
			break;


			/*=============== GEO LOCALIDADES ===============*/

			case "GetRegiones":
					$geo = new Geo();
					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
					$result=$geo->GetRegiones($res_plan['data'][0]['id_corporacion']);
			break;

			case "GetEstados":
					$geo = new Geo();
					$result=$geo->GetEstados();
			break;

			case "GetCiudades":
				$geo = new Geo();
				$result=$geo->GetCiudades($request['data']['id_estado']);
			break;


			/*=============== SUCURSALES ===============*/

			case "GetSucursales":
				$sucursales = new Sucursales();
				$planestudios = new PlanEstudios();
				$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
				$result=$sucursales->GetSucursales($res_plan['data'][0]['id_corporacion'],$request['data']['id_estado']);
			break;


			default:
				# code...
			break;
		}

		

		echo json_encode($result);


	}else{
		echo json_encode($result);
	}

?>