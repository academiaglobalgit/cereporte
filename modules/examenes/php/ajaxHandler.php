<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 	header("Access-Control-Allow-Origin: * ");
	require_once("../models/Connection.class.php");
	require_once("../models/Usuarios.class.php");
	require_once("../models/PlanEstudios.class.php");
	require_once("../models/Geo.class.php");
	require_once("../models/MateriasMoodle.class.php");
	require_once("../models/Examenes.class.php");


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
					$bd_plan=$res_plan['data'][0]['basededatos'];
					$usuarios = new Usuarios();
					$result=$usuarios->GetUsuarios($bd_plan,$request['data']['id_plan_estudio'],$request['data']['id_moodle'],$request['data']['numero_empleado'],$request['data']['nombre']);
				
			break;
		
			case "UpdateUsuario":
					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
					$bd_plan=$res_plan['data'][0]['basededatos'];
					$usuarios = new Usuarios();
					$new_username=$usuarios->GetNewUsername($bd_plan,$request['data']['nombre'],$request['data']['apellido1'],$request['data']['id_moodle']);

					$exist_num_emp=$usuarios->GetNumeroEmpleado($request['data']['id_persona'],$request['data']['numero_empleado'],$res_plan['data'][0]['id_corporacion']);

					if((int)$exist_num_emp['data'][0]['conteo']>0){
						$result['message']="Lo sentimos El numero de empleado/Estafeta que ingresó ya se encuentra registrado en esta corporacion";
					}else{
						$result=$usuarios->UpdateUsuario($bd_plan,$request['data']['id_plan_estudio'],$request['data']['id_moodle'],$request['data']['id_persona'],$request['data']['nombre'],$request['data']['apellido1'],$request['data']['apellido2'],$new_username,$request['data']['numero_empleado'],$request['data']['fecha_nacimiento']);
					}
			
			break;



			case "InsertUsuario":
					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
					$bd_plan=$res_plan['data'][0]['basededatos'];
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
							$result=$usuarios->InsertUsuario($bd_plan,$res_plan['data'][0]['id_corporacion'],$request['data']['id_plan_estudio'],$request['data']['nombre'],$request['data']['apellido1'],$request['data']['apellido2'],$new_username,$request['data']['numero_empleado'],$request['data']['fecha_nacimiento'],$request['data']['telefono_casa'],$request['data']['telefono_celular'],$request['data']['telefono_alternativo'],$request['data']['email'],$request['data']['id_estado'],$request['data']['id_ciudad'],$request['data']['nombre_ciudad'],$request['data']['id_region'],$request['data']['nombre_region'],$request['data']['numero_sucursal'],$request['data']['nombre_sucursal'],$request['data']['tipo_alumno']);
							//$planestudios->Close();
							//$usuarios->Close();

						}
						
					}
					

			break;


			/*=============PLAN DE ESTUDIOS===============*/
			case "GetPlanEstudios":
				
					$planestudios = new PlanEstudios();
					$result=$planestudios->GetPlanEstudios();
				
			break;

			/*=============== Materiales ===============*/

			case "GetMaterias":
					$materiasmoodle = new MateriasMoodle();
					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
					$result=$materiasmoodle->GetMaterias($res_plan['data'][0]['basededatos']);
			break;

			/*=============== Examenes ===============*/

			case "GetExamenesScorm":
					$examenes = new Examenes();
					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
					$result=$examenes->GetExamenesScorm($res_plan['data'][0]['basededatos'],$request['data']['id_moodle'],$request['data']['id_materia']);
			break;


			case "UpdateExamen":
			

			if(isset($_SESSION['permisos']) && (int)$_SESSION['permisos']==104 ){

					if(isset($request['data']['calificacion']) && is_numeric($request['data']['calificacion']) && ($request['data']['calificacion']>=0 && $request['data']['calificacion']<=10)){
						$examenes = new Examenes();
						$planestudios = new PlanEstudios();
						$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
						$result=$examenes->UpdateExamen($res_plan['data'][0]['basededatos'],$request['data']['userid'],$request['data']['scormid'],$request['data']['calificacion']);
					}else{
						$result['success']=false;
						$result['message']="Porfavor Ingresa una Calificacion valida.";
					}
			}else{
				$result['success']=false;
				$result['message']="LO SENTIMOS. ESTE USUARIO NO ESTÁ AUTORIZADO PARA REALIZAR ESTA ACCIÓN.";
			}


			break;

			case "ResetExamen":

				if(isset($_SESSION['permisos']) && (int)$_SESSION['permisos']==104 ){

					if(isset($request['data']['userid']) && is_numeric($request['data']['userid']) && isset($request['data']['scormid']) && is_numeric($request['data']['scormid'])){
						$examenes = new Examenes();
						$planestudios = new PlanEstudios();
						$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
						$result=$examenes->ResetExamen($res_plan['data'][0]['basededatos'],$request['data']['userid'],$request['data']['scormid']);
					}else{
						$result['success']=false;
						$result['message']="No se ha podido reiniciar el examen.";
					}
				}else{
					$result['success']=false;
					$result['message']="LO SENTIMOS. ESTE USUARIO NO ESTÁ AUTORIZADO PARA REALIZAR ESTA ACCIÓN.";
				}
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