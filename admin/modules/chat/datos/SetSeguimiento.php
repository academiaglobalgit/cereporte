<?php
require_once "configAyuda.php";

//$datos =  json_decode(file_get_contents("php://input"));
require_once('../../config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/querylib.php');


$id_usuario=$USER->id;
//$id_usuario=0;
if((isset($_POST['pregunta']) && trim($_POST['pregunta'])!="") && (isset($_POST['jerarquia']) && trim($_POST['jerarquia'])!="") && (isset($_POST['respuesta']) && trim($_POST['respuesta'])!="") ) {
	$response=0;


	//$mysql= new Connect();
	$mysql= new Connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);

	if($mysql->Connectar()){
		if($result=$mysql->Query("CALL proc_guardar_asunto (".$id_usuario.",'".$_POST['asunto']."','".$_POST['mensaje']."','".$_POST['telefono']."');")){
		 	$datos=mysql_fetch_array($result);
		 	$mysql->Cerrar();
		 	if(isset($_FILES['file'])){    // si subio imagen
				if(ValidateImg($_FILES['file'])){
						//$mysql2= new Connect();
						$mysql2= new Connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
					if($mysql2->Connectar()){
						if($result2=$mysql2->Query("CALL proc_guardar_archivo(".$datos['asunto'].");")){
							$archivo=mysql_fetch_array($result2);
							if(SaveImg($_FILES['file'],$archivo['archivo'])){
								$response=1;
							}else{
								$response=-1;
							}
						}
						$mysql2->Cerrar();
					}
				}
			}else{
				$response=1;
			}
		}
	}
	echo $response;

}else{

	echo 0;

}



function SaveImg($FILE,$id=0){

	    $errors= array();        
	    $file_name = $FILE['name'];
	    $file_size =$FILE['size'];
	    $file_tmp =$FILE['tmp_name'];
	    $file_type=$FILE['type'];   
	    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	    $extensions = array("jpeg","jpg","png");

	    if(in_array($file_ext,$extensions )=== false){
	         $errors[]="image extension not allowed, please choose a JPEG or PNG file.";
	       	return false;
	    }

	    if($file_size > 2097152){
	        $errors[]='File size cannot exceed 2 MB';
	        return false;
	    }

	    if(empty($errors)==true){
	    	$extencion = explode(".", $FILE["name"]);
			$newfilename = $id. '.' . end($extencion);
	       	if(move_uploaded_file($file_tmp,"../imagenes/".$newfilename)){
	       		return true;
	       	}else{
	       		return false;
	       	}
	    }else{
	        return false;
	    }


}


function ValidateImg($FILE){

	    $errors= array();        
	    $file_name = $FILE['name'];
	    $file_size =$FILE['size'];
	    $file_tmp =$FILE['tmp_name'];
	    $file_type=$FILE['type'];   
	    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	    $extensions = array("jpeg","jpg","png");

	    if(in_array($file_ext,$extensions )=== false){
	         $errors[]="image extension not allowed, please choose a JPEG or PNG file.";
	       	return false;
	    }

	    if($file_size > 2097152){
	        $errors[]='File size cannot exceed 2 MB';
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

function validateVideo($FILE){
	    $file_name = $FILES['file']['name'];
	    $file_type = $FILES['file']['type'];
	    $file_size = $FILES['file']['size'];

	    $allowed_extensions = array("webm", "mp4", "ogv");
	    $file_size_max = 2147483648;
	    $pattern = implode ($allowed_extensions, "|");

	    if (!empty($file_name))
	    {    //here is what I changed - as you can see above, I used implode for the array
	        // and I am using it in the preg_match. You pro can do the same with file_type,
	        // but I will leave that up to you
	        if (preg_match("/({$pattern})$/i", $file_name) && $file_size < $file_size_max)
	        {
	            if (($file_type == "video/webm") || ($file_type == "video/mp4") || ($file_type == "video/ogv"))
	            {
	                if ($_FILES['file']['error'] > 0)
	                {
	                    echo "Unexpected error occured, please try again later.";
	                } else {
	                    if (file_exists("secure/".$file_name))
	                    {
	                        echo $file_name." already exists.";
	                    } else {
	                        move_uploaded_file($_FILES["file"]["tmp_name"], "secure/".$file_name);
	                        echo "Stored in: " . "secure/".$file_name;
	                    }
	                }
	            } else {
	                echo "Invalid video format.";
	            }
	        }else{
	            echo "where is my mojo?? grrr";
	        }
	    } else {
	        echo "Please select a video to upload.";
	    }
	
}


?>