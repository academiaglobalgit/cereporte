<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
 	header("Access-Control-Allow-Origin: * ");

	require_once("../models/Connection.class.php");
	require_once("../models/Permisos.class.php");
	require_once("../models/Scorms.class.php");
	require_once("../models/PlanEstudios.class.php");
	require_once("../models/Materias.class.php");


	//require_once("../models/Validator.class.php");

	/*initialize result object*/
	$result['success']=false;
	$result['message']='Invalid Request';
	$result['data']=null;

	if(isset($_POST['request'])){
		$request=$_POST;
		switch ($request['request']) {

			/*==========######### MATERIAS ##########============*/

			case "GetTbMaterias":
				$planestudios= new PlanEstudios();
				$plan_estudio=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
				$bd=$plan_estudio['data'][0]['basededatos'];
				$materias= new Materias();
				$result=$materias->GetTbMaterias($bd,$request['data']['id_plan_estudio']);
			break;

			case "GetMateriasMoodle":
				$planestudios= new PlanEstudios();
				$plan_estudio=$planestudios->GetPlanEstudio($request['data']['id_plan_estudio']);
				$bd=$plan_estudio['data'][0]['basededatos'];
				$materias= new Materias();
				$result=$materias->GetMateriasMoodle($bd);
				
			break;

			/*==========######### PERMISOS ##########============*/

			case "GetPermisos":

				$permisos= new Permisos();
				$result=$permisos->GetPermisos();

			break;


			/*==========######### Scorms ##########============*/

			case "InsertScorm":

			$output_dir_scorms = "../uploads/scorms/";
			$output_dir_players = "../players/";
				if(isset($_FILES["scorm_zip"]))
				{
					$ret = array();
					$error =$_FILES["scorm_zip"]["error"];
					//You need to handle  both cases
					//If Any browser does not support serializing of multiple files using FormData() 
					if(!is_array($_FILES["scorm_zip"]["name"])) //single file
					{
				 	 	$fileName = $_FILES["scorm_zip"]["name"];
				 	 	$t=time();
				 	 	$urlhash=md5($t);
				 	 	$file_url_out=$output_dir_scorms.'/'.$urlhash.'/'.$fileName;

				 	 	if(mkdir($output_dir_scorms.'/'.$urlhash, 0777) && mkdir($output_dir_players.'/'.$urlhash, 0777)){ // CREA DIRECTORIO SCORM

							if(move_uploaded_file($_FILES["scorm_zip"]["tmp_name"],$file_url_out)){ //MUEVE SCORM AL DIRECTORIO
					 			$scorms= new Scorms();
								$result=$scorms->InsertScorm($request['data']['nombre'],$request['data']['id_materia'],$urlhash);

								if($result['success']){

									$id_scorm_last=$scorms->last_insert_id();
									if(mkdir($output_dir_players.'/'.$urlhash.'/'.$urlhash, 0777)){

										$zip = new ZipArchive;
										$res = $zip->open($file_url_out);

										if ($res === TRUE) {
										  // extract it to the path we determined above
										  $zip->extractTo($output_dir_players.'/'.$urlhash.'/'.$urlhash);
										  $zip->close();
										  $result=$scorms->InsertScormFile($id_scorm_last,$urlhash,$fileName);
										  
										} else {
											$result['message']="Error al descomprimir el archivo zip scorm: 07";
										}

									}else{
										$result['message']="Error al subir el archivo zip scorm: 06";
									}
					 
								}else{
									$result['message']="Error al subir el archivo zip scorm: 05";
								}
								
					 		}else{
					 			$result['message']="Error al subir el archivo zip scorm: 02";
					 		}

				 	 	}else{
							$result['message']="Error al  el archivo zip scorm: 04";
				 	 	}
				 		
					}else{
						$result['message']="Error al subir el archivo zip scorm: 03";
					}
				    
				 }else{
				 	$result['message']="Error al subir el archivo zip scorm: 01";
				 }

			break;

			case "UpdateScorm":

				$scorms= new Scorms();
				if(isset($request['data']['id_scorm']) && is_numeric($request['data']['id_scorm'])){
					$result=$scorms->UpdateScorm($request['data']['id_scorm'],$request['data']['nombre'],$request['data']['id_materia']);
				}else{
					$result['message']="Ingrese correctamente el id_scorm";
				}

			break;

			case "UploadScorm":

				/* 
					$scorms= new Scorms();
					if(isset($request['data']['id_scorm']) && is_numeric($request['data']['id_scorm'])){
						$result=$scorms->UpdateScorm($request['data']['id_scorm'],$request['data']['nombre'],$request['data']['id_materia'],$request['data']['scoid']);
					}else{
						$result['message']="Ingrese correctamente el id_scorm";
					} 
				*/


				$output_dir_scorms = "../uploads/scorms/";
				$output_dir_players = "../players/";

				if(isset($_FILES["scorm_zip"]) && (isset($request['data']['id_scorm']) && is_numeric($request['data']['id_scorm'])) )
				{
					$ret = array();
					$error =$_FILES["scorm_zip"]["error"];
					//You need to handle  both cases
					//If Any browser does not support serializing of multiple files using FormData() 
					if(!is_array($_FILES["scorm_zip"]["name"])) //single file
					{

						$scorms= new Scorms();
						$result_scorm=$scorms->GetScorm($request['data']['id_scorm']);

				 	 	$fileName = $_FILES["scorm_zip"]["name"];
				 	 	$t=time();
				 	 	$urlhash=md5($t);
				 	 	
				 	 	$file_url_out=$output_dir_scorms.'/'.$result_scorm['data'][0]['url'].'/'.$fileName;

							if(move_uploaded_file($_FILES["scorm_zip"]["tmp_name"],$file_url_out)){ //MUEVE SCORM AL DIRECTORIO

								$id_scorm_last=$result_scorm['data'][0]['id'];
								if(mkdir($output_dir_players.'/'.$result_scorm['data'][0]['url'].'/'.$urlhash, 0777)){

									$zip = new ZipArchive;
									$res = $zip->open($file_url_out);

									if ($res === TRUE) {
									  // extract it to the path we determined above
									  $zip->extractTo($output_dir_players.'/'.$result_scorm['data'][0]['url'].'/'.$urlhash);
									  $zip->close();
									  $result=$scorms->InsertScormFile($id_scorm_last,$urlhash,$fileName);
									  
									} else {
										$result['message']="Error al descomprimir el archivo zip scorm: 07";
									}

								}else{
									$result['message']="Error al subir el archivo zip scorm: 06";
								}
					 
					 		}else{
					 			$result['message']="Error al subir el archivo zip scorm: 02";
					 		}
				 		
					}else{
						$result['message']="Error al subir el archivo zip scorm: 03";
					}
				    
				 }else{
				 	$result['message']="Error al subir el archivo zip scorm: 01";
				 }




			break;


			case "ChangeScormFile":

				$scorms= new Scorms();
				$result=$scorms->ChangeScormFile($request['data']['id_scorm'],$request['data']['id_scorm_file']);

			break;

			case "GetScorms":

				$scorms= new Scorms();
				$result=$scorms->GetScorms($request['data']['scorm']);

			break;

			case "GetScormFiles":

				$scorms= new Scorms();
				$result=$scorms->GetScormFiles($request['data']['id_scorm']);

			break;


			case "GetScormsActivas":

				$scorms= new Scorms();
				$result=$scorms->GetScormsActivas($request['data']['scorm']);
				
			break;
 

			case "DeleteScorm":
				$scorms= new Scorms();
				$result=$scorms->DeleteScorm($request['data']['id_scorm']);

			break;


			case "GetScormsTracks":
				$scorms= new Scorms();
				$result=$scorms->GetScormsTracks($request['data']['scormid'],$request['data']['userid']);

			break;

			case "DeleteScormsTracks":
				$scorms= new Scorms();
				$result=$scorms->DeleteScormsTracks($request['data']['scormid'],$request['data']['userid']);

			break;			

			/*==========######### plan de estudios ##########============*/

			case "GetPlanEstudios":

				$planestudios= new PlanEstudios();
				$result=$planestudios->GetPlanEstudios();
				
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