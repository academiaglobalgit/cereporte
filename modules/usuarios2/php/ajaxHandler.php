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
	require_once("../models/MateriasMoodle.class.php");
	require_once("../models/ConnectionPG.class.php");
	require_once("../models/MigraPersonas.class.php");
	require_once("../models/Telefonos.class.php");

	//require_once("../models/Validator.class.php");

	/*initialize result object*/
	$result['success']=false;
	$result['message']='Invalid Request';
	$result['data']=null;


	if(isset($_POST['request'])){
		$request=$_POST;
		switch ($request['request']) {

			/*==========######### Usuarios ##########============*/
			case "GetUsuarios":

					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
					$bd_plan='`'.$res_plan['data'][0]['basededatos'].'`';
					$usuarios = new Usuarios();
					$result=$usuarios->GetUsuarios($bd_plan,$request['data']['id_plan_estudio'],$request['data']['id_moodle'],$request['data']['numero_empleado'],$request['data']['nombre']);
					$usuarios->Close();
					$planestudios->Close();

			break;

			case "UpdateUsuario":

				if((isset($_SESSION['permisos']) && (int)$_SESSION['permisos'] != 1 ) or true){
						$planestudios = new PlanEstudios();
						$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
						$bd_plan='`'.$res_plan['data'][0]['basededatos'].'`';
						$usuarios = new Usuarios();
						$new_username=$usuarios->GetNewUsername($bd_plan,$request['data']['nombre'],$request['data']['apellido1'],$request['data']['id_moodle']);

						$exist_num_emp=$usuarios->GetNumeroEmpleado($request['data']['id_persona'],$request['data']['numero_empleado'],$res_plan['data'][0]['id_corporacion']);

						if((int)$exist_num_emp['data'][0]['conteo']>1){
							$result['message']="Lo sentimos El numero de empleado/Estafeta que ingresó ya se encuentra registrado en esta corporacion";
						}else{
							$result=$usuarios->UpdateUsuario($bd_plan,$res_plan['data'][0]['id_corporacion'],$request['data']['id_plan_estudio'],$request['data']['id_moodle'],$request['data']['id_persona'],$request['data']['nombre'],$request['data']['apellido1'],$request['data']['apellido2'],$new_username,$request['data']['numero_empleado'],$request['data']['fecha_nacimiento'],$request['data']['tipo_alumno'],$request['data']['numero_sucursal'],$request['data']['nombre_sucursal'],$request['data']['horario'],$request['data']['id_estado'],$request['data']['sexo'],$request['data']['email'],$request['data']['id_sucursal'],$request['data']['id_region'],$request['data']['nombre_region'],$request['data']['curp'],$request['data']['id_area']);
							//$result['message'].="sucursal request:".$request['data']['id_sucursal'];
						}

						$usuarios->Close();
						$planestudios->Close();
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
							$result=$usuarios->InsertUsuario($bd_plan,$res_plan['data'][0]['id_corporacion'],$request['data']['id_plan_estudio'],$request['data']['nombre'],$request['data']['apellido1'],$request['data']['apellido2'],$new_username,$request['data']['numero_empleado'],$request['data']['fecha_nacimiento'],$request['data']['telefono_casa'],$request['data']['telefono_celular'],$request['data']['telefono_alternativo'],$request['data']['email'],$request['data']['id_estado'],$request['data']['id_ciudad'],$request['data']['nombre_ciudad'],$request['data']['id_region'],$request['data']['nombre_region'],$request['data']['numero_sucursal'],$request['data']['nombre_sucursal'],$request['data']['tipo_alumno'],$request['data']['sexo'],$request['data']['nomenclatura_ciudad'],$request['data']['id_escuela'],$request['data']['documentacion_estatus'],$request['data']['curp'],$request['data']['id_area'],$request['data']['tipo_usuario'],$request['data']['generacion']);
						}

					}

				$usuarios->Close();
				$planestudios->Close();

			}else{
				$result['success']=false;
					$result['message']="LO SENTIMOS. ESTE USUARIO NO ESTÁ AUTORIZADO PARA REALIZAR ESTA ACCIÓN.: ".$_SESSION['permisos'];
			}

			break;


			/*=============PLAN DE ESTUDIOS===============*/
			case "GetPlanEstudios":

					$planestudios = new PlanEstudios();
					$result=$planestudios->GetPlanEstudios();
					$planestudios->Close();

			break;

			/*=============MATERIAS / ESCUELAS UCL===============*/
			case "GetEscuelas":

					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);

					$materiasmoodle= new MateriasMoodle();
					$result=$materiasmoodle->GetEscuelas($res_plan['data'][0]['basededatos']);

					$materiasmoodle->Close();
					$planestudios->Close();
			break;
			/*=============== GEO LOCALIDADES ===============*/

			case "GetRegiones":
					$geo = new Geo();
					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
					$result=$geo->GetRegiones($res_plan['data'][0]['id_corporacion']);

					$geo->Close();
					$planestudios->Close();
			break;

			case "GetEstados":
					$geo = new Geo();
					$result=$geo->GetEstados();
					$geo->Close();
			break;

			case "GetCiudades":
				$geo = new Geo();
				$result=$geo->GetCiudades($request['data']['id_estado']);
				$geo->Close();
			break;


			/*=============== SUCURSALES ===============*/

			case "GetSucursales":
				$sucursales = new Sucursales();
				$planestudios = new PlanEstudios();
				$res_plan=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
				$result=$sucursales->GetSucursales($res_plan['data'][0]['id_corporacion'],$request['data']['id_estado']);
				$planestudios->Close();
				$sucursales->Close();
			break;

			/*=============== TELEFONOS ===============*/

			case "GetTelefonosPreview":
				$telefonos = new Telefonos();
				$result=$telefonos->GetTelefonosPreview($request['data']['id_alumno']);
				$telefonos->Close();
			break;

			case "GetTelefonos":
				$telefonos = new Telefonos();
				$result=$telefonos->GetTelefonos($request['data']['id_alumno']);
				$telefonos->Close();
			break;

			case "GetMotivosBajasTelefonos":
				$telefonos = new Telefonos();
				$result=$telefonos->GetMotivosBajasTelefonos();
				$telefonos->Close();
			break;

			case "InsertTelefono":

				if (is_numeric($request['data']['id_alumno']) && $request['data']['id_alumno']>0 && is_numeric($request['data']['telefono']) )  {
					$telefonos = new Telefonos();
					$result=$telefonos->InsertTelefono($request['data']['id_alumno'],$_SESSION['id_usuario'],$request['data']['telefono']);
					$telefonos->Close();
				}else{
					$result['message']="Ingrese los datos correctamente para guardar el telefono." ;
				}

			break;

			case "DeleteTelefono":
				if (is_numeric($request['data']['id_telefono']) && $request['data']['id_telefono']>0 && is_numeric($request['data']['id_motivo_baja']) ) {
					$telefonos = new Telefonos();
					$result=$telefonos->DeleteTelefono($request['data']['id_telefono'],$request['data']['id_motivo_baja']);
					$telefonos->Close();
				}else{
					$result['message']="Ingrese los datos correctamente para eliminar el telefono." ;

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
