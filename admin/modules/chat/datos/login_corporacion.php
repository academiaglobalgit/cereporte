<?php
	session_start();

if((isset($_SESSION['id_persona']) && isset($_SESSION['permisos'])) && (isset($_POST['id_corporacion']) && is_numeric($_POST['id_corporacion'])) ){

	$id_corporacion=$_POST['id_corporacion'];

			if($_SESSION['permisos']==102 or $_SESSION['permisos']==104 or $_SESSION['permisos']==101){

				$_SESSION['user_id_corporacion']=$id_corporacion;
				$_SESSION['id_corporacion']=$id_corporacion;

				header('Location: ../index.php');
			}else{
				header('Location: ../index.php?error=1');

			}

}else{
	header('Location: ../index.php?error=2');
}



  ?>