<?php
	//session_start();
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

 	header("Access-Control-Allow-Origin: * ");

 	

	require_once("../models/Connection.class.php");
	require_once("../models/Usuarios.class.php");
	require_once("../models/PlanEstudios.class.php");
	require_once("../models/MateriasMoodle.class.php");
	require_once("../models/ConnectionPG.class.php");
	require_once("../models/Login.class.php");

	//require_once("../models/Validator.class.php");

	/*initialize result object*/

	function limpiarString($text){

	 $chars =   array("\\", "¨", "º", "~",
	              "|", "!", "\"",
	             "·", "$", "%", "&", "/",
	             "(", ")", "'", "¡",
	              "[", "^", "`", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "<"
	             );
	        

	$clean = str_replace($chars, "", $text);
	return $clean;
	}

	function strip_all($text){

	  return limpiarString(strip_tags($text));

	}

	$id_plan_estudio=16;
	$id_corporacion=4;


	$result['success']=false;
	$result['message']='Invalid Request';
	$result['data']=null;


	if(isset($_POST['request'])){
		$request=$_POST;
		switch ($request['request']) {
			/* LOGIN */

			case "GetLogin":

					if(isset($request['data']['usuario']) && isset($request['data']['contra']) && !empty($request['data']['usuario']) && !empty($request['data']['contra']) ) {
						$login = new Login();
						$result=$login->GetLogin($request['data']['usuario'],$request['data']['contra']);
						$login->Close();
					}else{
						$result['success']=false;
						$result['message']='Ingresa los datos correctamente.';
						$result['data']=null;
					}
					
			break;


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


			case "GetAlumnosByMateria":
				
					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($id_plan_estudio);
					$bd_plan='`'.$res_plan['data'][0]['basededatos'].'`';
					$usuarios = new Usuarios();
					

					$filtro=strip_all($request['data']['filtro']);
					$result=$usuarios->GetAlumnosByMateria($bd_plan,$request['data']['id_course'],$id_corporacion,$id_plan_estudio,$filtro);
					
				

					$usuarios->Close();
					$planestudios->Close();
				
			break;



			/*=============PLAN DE ESTUDIOS===============*/
			case "GetPlanEstudios":
				
					$planestudios = new PlanEstudios();
					$result=$planestudios->GetPlanEstudios();
					$planestudios->Close();
				
			break;

			/*=============MATERIAS / ESCUELAS UCL===============*/
			case "GetMaterias":
				
					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($id_plan_estudio);

					$materiasmoodle= new MateriasMoodle();
					$result=$materiasmoodle->GetMaterias($res_plan['data'][0]['basededatos']);

					$materiasmoodle->Close();
					$planestudios->Close();
			break;

			case "GetEjerciciosByMateriaUnidad":
				
					$planestudios = new PlanEstudios();
					$res_plan=$planestudios->GetPlanEstudio($id_plan_estudio);

					$materiasmoodle= new MateriasMoodle();

					if(is_numeric($request['data']['course']) && is_numeric($request['data']['unidad'])){
						$result=$materiasmoodle->GetEjerciciosByMateriaUnidad($res_plan['data'][0]['basededatos'],$request['data']['course'],$request['data']['unidad']);
					}else{
						$result['message']="Ingrese los datos correctamente para optener los ejercicios.";
					}
					
					$materiasmoodle->Close();
					$planestudios->Close();

			break;


			case "GetEjercicioAlumno":

					$materiasmoodle= new MateriasMoodle();
					$usuarios = new Usuarios();

					if(is_numeric($request['data']['id_moodle']) && is_numeric($request['data']['course']) && is_numeric($request['data']['id_ejercicio']) && is_numeric($request['data']['unidad']) ){
						$result_materia=$materiasmoodle->GetMateriaEscolarByMoodle($request['data']['course'],$id_plan_estudio);
						$id_materia_escolar=$result_materia['data'][0]['id'];

						$result_usuario=$usuarios->GetAlumnoByMoodle($request['data']['id_moodle'],$id_plan_estudio);
						$id_alumno=$result_usuario['data'][0]['id'];
						
						$result=$materiasmoodle->GetEjercicioAlumno($id_alumno,$id_materia_escolar,$request['data']['id_ejercicio'],$request['data']['unidad'],$id_corporacion,$id_plan_estudio);

					}else{
						$result['message']="Ingrese los datos correctamente para optener el ejercicio del alumno.";
					}
					
					$materiasmoodle->Close();
					$usuarios->Close();
			break;



			case "GetEjerciciosHechos":

					$planestudios = new PlanEstudios();
					$materiasmoodle= new MateriasMoodle();
					$usuarios = new Usuarios();

					if(is_numeric($request['data']['id_moodle']) && is_numeric($request['data']['course']) && is_numeric($request['data']['unidad']) )
					{
						$res_plan=$planestudios->GetPlanEstudio($id_plan_estudio);
						$result_usuario=$usuarios->GetAlumnoByMoodle($request['data']['id_moodle'],$id_plan_estudio);
						$id_alumno=$result_usuario['data'][0]['id'];
						
						$result=$materiasmoodle->GetEjerciciosHechos($res_plan['data'][0]['basededatos'],$id_alumno,$request['data']['course'],$request['data']['unidad'],$id_corporacion,$id_plan_estudio);
					}else{
						$result['message']="Ingrese los datos correctamente.";
					}
					$planestudios->Close();
					$materiasmoodle->Close();
					$usuarios->Close();
			break;


			case "UpdateEjercicio":

					$materiasmoodle= new MateriasMoodle();
					$usuarios = new Usuarios();

					if(isset($request['data']['contenido'])){
						
						if( is_numeric($request['data']['id_moodle']) && is_numeric($request['data']['course']) && is_numeric($request['data']['id_ejercicio']) && is_numeric($request['data']['unidad']) ){

							$result_materia=$materiasmoodle->GetMateriaEscolarByMoodle($request['data']['course'],$id_plan_estudio);
							$id_materia_escolar=$result_materia['data'][0]['id'];

							$result_usuario=$usuarios->GetAlumnoByMoodle($request['data']['id_moodle'],$id_plan_estudio);
							$id_alumno=$result_usuario['data'][0]['id'];
						
							$result=$materiasmoodle->UpdateEjercicio($request['data']['contenido'],$id_alumno,$id_materia_escolar,$request['data']['id_ejercicio'],$request['data']['unidad'],$id_corporacion,$id_plan_estudio,$request['data']['estatus']);
							
						}else{
							$result['message']="No se ha podido guardar, intente mas tarde. 002";
						}

					}else{
						$result['message']="No se ha podido guardar, intente mas tarde. 001";
					}
					
					
					$materiasmoodle->Close();
					$usuarios->Close();

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