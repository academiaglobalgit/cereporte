<?php 
	class Login extends Connection {

		function Login(){
		 	$this->Connect();
		}


		function GetLogin($usuario="",$contrasena=""){


					$usuario=strip_all($usuario);
					$contra=strip_all($contrasena);
					
					$salt_hash= '3;a2drrR@}kb;z=-^}Ga:Uwz3u';
			

					$query_login_tb_usuarios=" CALL escolar.rv_login_cereporte('".$usuario."'); ";

						$result=$this->Query($query_login_tb_usuarios);
						if($result['success']){


							//$conteo=mysql_num_rows($result);
							$row=mysqli_fetch_array($result['data']);
							
							
							$id=$row['id'];
							$id_persona=$row['id_persona'];
							$permisos=$row['permisos'];
							$id_permiso=$row['id_permiso'];
							$user_id_corporacion=$id_corporacion;
							$region=$row['region'];
							$nombre_completo=$row['nombre_completo'];
							$id_area=$row['id_area'];

							

							//$conteo=1;
							
							if(($row['username']==$usuario && (MD5($contra)==$row['contra_user'] || MD5($contra.$salt_hash)==$row['contra_user']) && $row['estatus']=='A')  

								||  

								($row['usuario']==$usuario && (MD5($contra)==$row['contra_persona'] || MD5($contra.$salt_hash)==$row['contra_persona']) && $row['permisos'] != 1 )

								){
								session_start();
								$_SESSION['id_usuario']=$id;
								$_SESSION['id_persona']=$id_persona;
								$_SESSION['nombre_completo']=$nombre_completo;
								$_SESSION['id_permiso']=$id_permiso;

								$_SESSION['permisos']=$permisos;
								$_SESSION['user_id_corporacion']=$id_corporacion;
								$_SESSION['id_corporacion']=$id_corporacion;
								$_SESSION['id_area']=$id_area;

								$result['data']=null;
								$result['success']=true;
								$result['message']="Se ha iniciadio sesión correctamente";

								return $result;
							}else{
								$result['data']=null;
								$result['success']=false;
								$result['message']="Usuario o contraseña incorrectos. ";
								return $result;
							}

						}else{
								$result['data']=null;
								$result['success']=false;
								$result['message']="No se ha podido iniciar sesión, Intente Mas tarde.";
								return $result;
						}

		}


	}
?>