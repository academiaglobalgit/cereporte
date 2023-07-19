<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 	header("Access-Control-Allow-Origin: * ");
	require_once("../models/Connection.class.php");
	require_once("../models/Forums.class.php");
	require_once("../models/Threads.class.php");
	require_once("../models/Posts.class.php");
	require_once("../models/Responses.class.php");
	require_once("../models/Courses.class.php");
	require_once("../models/Quizes.class.php");

	//require_once("../models/Validator.class.php");

	/*initialize result object*/
	$result['success']=false;
	$result['message']='Invalid Request';
	$result['data']=null;

	if(isset($_POST['request'])){
		$request=$_POST;
		switch ($request['request']) {

			/*==========######### FORUMS ##########============*/
			case "GetForums":
				
				if((isset($request['data']['id_course']) && is_numeric($request['data']['id_course'])) && (isset($request['data']['id_corporacion']) && is_numeric($request['data']['id_corporacion'])) && (isset($request['data']['id_plan_estudio']) && is_numeric($request['data']['id_plan_estudio'])) ){
					$forums = new Forums();
					$result=$forums->GetForums($request['data']['id_course'],$request['data']['id_corporacion'],$request['data']['id_plan_estudio']);
				}else{
					$result['message']="Introduce el id_materia correctamente";
				}
				
			break;

			case "GetForumsByExamenMoodle":
				
				if((isset($request['data']['id_course']) && is_numeric($request['data']['id_course'])) && (isset($request['data']['id_quiz']) && is_numeric($request['data']['id_quiz'])) && (isset($request['data']['id_plan_estudio']) && is_numeric($request['data']['id_plan_estudio']))   && (isset($request['data']['id_modo']) && is_numeric($request['data']['id_modo'])) ){

					$quizes = new Quizes();
					$id_tb_examen=null;
					$id_tb_examen=$quizes->GetQuizByMoodleQuiz($request['data']['id_plan_estudio'],$request['data']['id_course'],$request['data']['id_quiz'],$request['data']['id_modo']);
					if($id_tb_examen['success'] && !is_null($id_tb_examen['data'])){
						$forums = new Forums();
						$result=$forums->GetForumsByExamen($id_tb_examen['data'][0]['id']);
					}else{
						$result['message']="Examen/Bloque no encontrado.";
					}
					
				}else{
					$result['message']="Introduce el id_materia correctamente";
				}
				
			break;
			
			case "SetForum":
				
				if( (isset($request['data']['nombre']) && !empty($request['data']['nombre']) ) && (isset($request['data']['id_course']) && is_numeric($request['data']['id_course']) ) && (isset($request['data']['id_quiz']) && is_numeric($request['data']['id_quiz']) ) && (isset($request['data']['id_plan_estudio']) && is_numeric($request['data']['id_plan_estudio']) ) ){
					$forums = new Forums();
					$result=$forums->SetForum(strip_tags(($request['data']['nombre'])),$request['data']['id_course'],$request['data']['id_corporacion'],$request['data']['id_plan_estudio'],$request['data']['id_quiz']);
				}
				else{
					$result['message']="Introduce el nombre o el id_course correctamente";

				}
			break;

			case "UpdateForum":
				
				if( (isset($request['data']['nombre']) && !empty($request['data']['nombre']) ) && (isset($request['data']['id_forum']) && is_numeric($request['data']['id_forum'])) && (isset($request['data']['id_quiz']) && is_numeric($request['data']['id_quiz'])) ){
					$forums = new Forums();
					$result=$forums->UpdateForum($request['data']['id_forum'],strip_tags(($request['data']['nombre'])),$request['data']['id_quiz']);
				}
				else{
					$result['message']="Introduce el nombre o el id_forum correctamente";

				}
			break;

			case "DeleteForum":
				
				if(isset($request['data']['id_forum']) && is_numeric($request['data']['id_forum'])){
					$forums = new Forums();
					$result=$forums->DeleteForum($request['data']['id_forum']);
				}else{
					$result['message']="Introduce el id_forum correctamente";

				}
			break;			


			/*==========######## THREADS ########============*/
			
			case "GetThreads":
				if(isset($request['data']['id_forum']) && is_numeric($request['data']['id_forum'])){
					$threads = new Threads();
					$result=$threads->GetThreads($request['data']['id_forum']);
				}else{
					$result['message']="Introduce el id_forum correctamente";

				}
			break;

			case "SetThread":
				
				if( (isset($request['data']['nombre']) && !empty($request['data']['nombre']) ) && (isset($request['data']['id_forum']) && !empty($request['data']['id_forum']) )  && (isset($request['data']['texto']) && !empty($request['data']['texto']) ) ){
					$threads = new Threads();
					
					$responses=array();
					for ($i=0; $i < 20; $i++) {  //get the responses from the post
						$idxarray='responses_'.$i; // name of the responses from the form
						if(isset($request['data'][$idxarray])){
							$responses[]=$request['data'][$idxarray];
						}else{
							break;
						}
					}

					$result=$threads->SetThread(strip_tags(($request['data']['nombre'])),$request['data']['id_forum'],strip_tags(($request['data']['texto'])),strip_tags(($request['data']['texto_correcta'])),strip_tags(($request['data']['texto_incorrecta'])),$request['data']['id_persona'],$request['data']['tipo'],$responses,$request['data']['idx_correct']);
				}
				else{
					$result['message']=" Introduce el nombre o el id_forum correctamente: ".var_dump($request['data']);

				}
			break;

			case "UpdateThread":
				
				if( (isset($request['data']['nombre']) && !empty($request['data']['nombre']) ) && (isset($request['data']['id_thread']) && !empty($request['data']['id_thread']) )  && (isset($request['data']['texto']) && !empty($request['data']['texto']) ) ){
					$threads = new Threads();

					$responses=array();
					for ($i=0; $i < 20; $i++) {  //get the responses from the post
						$idxarray='responses_'.$i; // name of the responses from the form
						if(isset($request['data'][$idxarray])){
							$responses[]=$request['data'][$idxarray];
						}else{
							break;
						}
					}
					/*$responsesIds=array();
					for ($i=0; $i < 20; $i++) {  //get the responses ids from the post
						$idxarray='responses_id_'.$i; // name of the responses id from the form
						if(isset($request['data'][$idxarray])){
							$responsesIds[]=$request['data'][$idxarray];
						}else{
							break;
						}
					}*/					
					$result=$threads->UpdateThread($request['data']['id_thread'],strip_tags(($request['data']['nombre'])),strip_tags(($request['data']['texto'])),strip_tags(($request['data']['texto_correcta'])),strip_tags(($request['data']['texto_incorrecta'])),$request['data']['tipo'],$responses,$request['data']['idx_correct']);
				}
				else{
					$result['message']="Introduce el nombre, texto o el id_thread correctamente: ".var_dump($request['data']);
				}
			break;

			case "DeleteThread":
				
				if(isset($request['data']['id_thread']) && !empty($request['data']['id_thread'])){
					$threads = new Threads();
					$result=$threads->DeleteThread($request['data']['id_thread']);
				}else{
					$result['message']="Introduce el id_thread correctamente";

				}
			break;		

			/*==========######### POSTS ###########==========*/

			case "GetPosts":
				if(isset($request['data']['id_thread']) && is_numeric($request['data']['id_thread'])){
					$posts = new Posts();
					$result=$posts->GetPosts($request['data']['id_thread']);
				}else{
					$result['message']="Introduce el id_thread correctamente".var_dump($request['data']);

				}
			break;

			case "SetPost":
				
				if( (isset($request['data']['titulo']) && !empty($request['data']['titulo']) ) && (isset($request['data']['id_thread']) && is_numeric($request['data']['id_thread']) )  &&  (isset($request['data']['id_respuesta']) && is_numeric($request['data']['id_respuesta']) )  && (isset($request['data']['id_parent']) && is_numeric($request['data']['id_parent']) ) && (isset($request['data']['texto']) && !empty($request['data']['texto']) ) && (isset($request['data']['id_user']) && is_numeric($request['data']['id_user']) ) ){
					$posts = new Posts();
					$result=$posts->SetPost($request['data']['id_thread'],$request['data']['id_parent'],strip_tags(($request['data']['titulo'])),strip_tags(($request['data']['texto'])),$request['data']['id_respuesta'],$request['data']['id_user']);
				}
				else{
					$result['message']="Introduce el nombre o el id_thread correctamente: ".var_dump($request['data']);

				}
			break;

			case "UpdatePost":
				
				if( (isset($request['data']['titulo']) && !empty($request['data']['titulo']) ) && (isset($request['data']['id_post']) && is_numeric($request['data']['id_post']) )  && (isset($request['data']['texto']) && !empty($request['data']['texto']) ) ){
					$posts = new Posts();
					$result=$posts->UpdatePost($request['data']['id_post'],strip_tags(($request['data']['titulo'])),strip_tags(($request['data']['texto'])));
				}
				else{
					$result['message']="Introduce el titulo, texto o el id_post correctamente: ".var_dump($request['data']);

				}
			break;

			case "DeletePost":
				
				if(isset($request['data']['id_post']) && !empty($request['data']['id_post'])){
					$posts = new Posts();
					$result=$posts->DeletePost($request['data']['id_post']);
				}else{
					$result['message']="Introduce el id_post correctamente";

				}
			break;		

			/*=============== COURSES ============*/

			case "GetCourses":
				if(isset($request['data']['id_plan_estudio']) && is_numeric($request['data']['id_plan_estudio'])){
					$courses = new Courses();
					$result=$courses->GetCourses($request['data']['id_plan_estudio']);
				}else{
					$result['message']="Introduce el id_plan_estudio correctamente".var_dump($request['data']);

				}
			break;

			/*=============== QUIZES ============*/

			case "GetQuizes":
				if(isset($request['data']['id_plan_estudio']) && is_numeric($request['data']['id_plan_estudio'])){
					$quizes = new Quizes();
					$result=$quizes->GetQuizes($request['data']['id_plan_estudio'],$request['data']['id_course']);
				}else{
					$result['message']="Introduce el id_plan_estudio o id_course correctamente".var_dump($request['data']);

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