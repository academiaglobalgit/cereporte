<?php
require_once "configAyuda.php";

//$datos =  json_decode(file_get_contents("php://input"));
require_once('../../../preparatoriascorporativas/prepacoppel/config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/querylib.php');

//$id_usuario=0;
if((isset($_FILES['file']) && ValidateVideo($_FILES['file'])) && (isset($_POST['pregunta']) && trim($_POST['pregunta'])!="") && (isset($_POST['jerarquia']) && is_numeric($_POST['jerarquia'])) && (isset($_POST['respuesta']) && trim($_POST['respuesta'])!="") ) {
	$response=0;


	$mysql= new Connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);

	if($mysql->Connectar()){
		if($result=$mysql->Query("CALL proc_guardar_preguntasFrecuentes ('".mysql_real_escape_string($_POST['pregunta'])."','".mysql_real_escape_string($_POST['respuesta'])."',".$_POST['jerarquia'].")")){
		 	$datos=mysql_fetch_array($result);
			if(SaveVideo($_FILES['file'],$datos['id'])){
				$response=1;
			}else{
				$response=0;
			}
		}else{
			$response=0;
		}

		$mysql->Cerrar();

	}
	echo $response;

}else{

	echo 0;

}



function SaveVideo($FILE,$id=0){

	    $errors= array();        
	    $file_name = $FILE['name'];
	    $file_size =$FILE['size'];
	    $file_tmp =$FILE['tmp_name'];
	    $file_type=$FILE['type'];   
	    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	    $extensions = array("mp4");

	    if(in_array($file_ext,$extensions )=== false){
	         $errors[]="VIDEO extension not allowed, please choose a MP4 file.";
	       	return false;
	    }

	    if($file_size > 10097152){
	        $errors[]='File size cannot exceed 10 MB';
	        return false;
	    }

	    if(empty($errors)==true){
	    	$extencion = explode(".", $FILE["name"]);
			$newfilename = $id. '.' . end($extencion);
	       	if(move_uploaded_file($file_tmp,"../../../preparatoriascorporativas/prepacoppel/ayuda/videos/".$newfilename)){
	       		return true;
	       	}else{
	       		return false;
	       	}
	    }else{
	        return false;
	    }
}


function ValidateVideo($FILE){

	    $errors= array();        
	    $file_name = $FILE['name'];
	    $file_size =$FILE['size'];
	    $file_tmp =$FILE['tmp_name'];
	    $file_type=$FILE['type'];   
	    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	    $extensions = array("mp4");

	    if(in_array($file_ext,$extensions )=== false){
	         $errors[]="VIDEO extension not allowed, please choose a MP4  file.";
	       	return false;
	    }

	    if($file_size > 10097152){
	        $errors[]='File size cannot exceed 10 MB';
	        return false;
	    }

	    if(empty($errors)==true){
	       /* move_uploaded_file($file_tmp,"PlayerAvatar/".$file_name);
	        echo " uploaded file: " . "images/" . $file_name;*/
	        return true;
	    }else{
	        return false;
	        //print_r($errors);
	    }

}
?>