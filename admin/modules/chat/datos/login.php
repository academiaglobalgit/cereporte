<?php
	session_start();

if((isset($_POST['usuario']) && isset($_POST['contrasena'])) && (!empty($_POST['contrasena']) && !empty($_POST['usuario'])) && (isset($_POST['id_corporacion']) && is_numeric($_POST['id_corporacion'])) ){
	require_once "configAyuda.php";

	$mysql= new Connect();
	$usuario=$_POST['usuario'];
	$contra=$_POST['contrasena'];
	$id_corporacion=$_POST['id_corporacion'];
	if($mysql->Connectar()){

		if($result=$mysql->Query("CALL escolar.proc_validarusuario('".$usuario."','".$contra."');")){

			$row=mysql_fetch_array($result);
			$id=$row['id'];
			$permisos=$row['permisos'];
			$user_id_corporacion=$row['id_corporacion'];
			$region=$row['region'];
			$conteo=1;

			if($permisos==102 && $conteo>0){

				$_SESSION['id_persona']=$id;
				$_SESSION['permisos']=$permisos;
				$_SESSION['user_id_corporacion']=$user_id_corporacion;
				$_SESSION['id_corporacion']=$id_corporacion;

				header('Location: ../index.php');
			}else{
				header('Location: ../index.php?error=1');

			}

		}else{
			header('Location: ../index.php?error=2');
		}

	}else{ // ERROR AL CONECTAR
		header('Location: ../index.php?error=3');
	}
}else{
	header('Location: ../index.php?error=1');
}



  ?>