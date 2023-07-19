<?php
	class Usuarios extends Connection {

		function Usuarios(){
		 	$this->Connect();
		}


		function GetAlumnoByNumeroEmpleado($numero='',$id_plan_estudio=0){


			$query="SELECT tp.* FROM escolar.tb_alumnos ta inner join escolar.tb_personas tp on tp.id=ta.id_persona where ta.numero_empleado='".$numero."' and ta.id_plan_estudio='".$id_plan_estudio."' limit 1";
			$result=$this->Query($query);


			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;

		}

		function GetUsuarios($nombre=""){
			$where="";

			/*if($numero_empleado==0 || $numero_empleado=="" || $numero_empleado=="null"){

			}else{
				$where.=" or tu.username LIKE '%".$numero_empleado."%' ";
			}*/

			if(empty($nombre) || $nombre=="" || $nombre=="null"){

			}else{
				$where.=" and concat(tu.nombre,' ',concat(tu.apellidop,' ',tu.apellidom)) LIKE '%".$nombre."%'  ";
			}

			/*if($id_moodle==0 || $id_moodle=="" || $id_moodle=="null"){

			}else{
				$where.=" or tu.id = '".$id_moodle."' ";
			}*/

			$query="SELECT tu.*,concat(tu.nombre,' ',concat(tu.apellidop,' ',tu.apellidom)) as nombre_completo,tua.descripcion as nombre_area,tup.descripcion as nombre_permiso FROM  escolar.tb_usuarios tu
			left join escolar.tb_usuarios_permisos tup on tup.id=tu.id_permiso
			left join escolar.tb_usuarios_areas tua on tua.id=tu.id_area
			where ( (1=1) ".$where." )  order by tu.id ASC; " ;

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}



		function InsertUsuario($bd='',$id_corporacion=1,$id_plan_estudio=1,$nombre="",$apellido1="",$apellido2="",$usuario="nodefinio",$numero_empleado='12345',$fecha_nacimiento="0000-00-00", $telefono_casa="",$telefono_celular="",$telefono_alternativo="",$email="sincorreo@agcollege.edu.mx",$id_estado=1,$id_ciudad=1,$nombre_ciudad="no definido",$id_region=1,$nombre_region="no definido",$numero_sucursal=1,$nombre_sucursal="NO_DEFINIDO",$tipo_alumno=0,$permiso=0,$area=0){

					$originalDate = $fecha_nacimiento;
					 @$fecha_nacimiento = date("Y-m-d", strtotime($originalDate));


					if(empty($email) or str_replace(" ","",$email)==""){
							$email=$usuario."@agcollege.edu.mx";
					}

					$salt_hash= '3;a2drrR@}kb;z=-^}Ga:Uwz3u'; // hash de la contraseña de las plataformas

					$contra=md5(str_replace(" ","",$numero_empleado).$salt_hash); // genera la contraseña

						$result=array();
						$result['data']=null;
						$result['success']=false;
						$result['message']="Lo sentimos el usuario no se ha podido registrar, intente mas tarde. 000";

					$this->begin_transaction();

					$query_tb_personas="INSERT INTO escolar.tb_personas ( idmoodle, usuario, contrasena, permisos, nombre, apellido1, apellido2, sexo, fecha_nacimiento, rfc, ife, curp, estado_civil, colonia, calle, numero, codigopostal, ciudad, municipio, estado, region, sucursal, puesto_nombre, puesto, area, email, whatsapp, facebook, tel1, tel2, tel3, id_corporacion, corporacion_origen, prueba, activo, fecha_registro, actualizado, eliminado, fecha_eliminado) VALUES ( 0, '".$usuario."', '".$contra."', '102', '".$nombre."', '".$apellido1."', '".$apellido2."', '1', '".$fecha_nacimiento."', 'NORFC', 'NOIFE', null, '1', '', '', '', '80000', '1', '1', '1','1', '1', 'PUESTO NO DEFINIDO', '1', '0', '".$email."', '', '', '".$telefono_casa."', '".$telefono_celular."', '".$telefono_alternativo."', '".$id_corporacion."', '".$id_corporacion."', '0', '1', now(), now(), '0', '0000-00-00 00:00:00') ";

						$result_tb_personas=$this->Query($query_tb_personas);

						if($result_tb_personas['success']){
							$new_id_persona=$this->last_insert_id();

							$query_tb_usuarios="INSERT INTO escolar.tb_usuarios (id_persona,username,password,nombre,apellidop,apellidom,id_permiso,id_area,estatus,id_corporacion,fecha_alta) VALUES (".$new_id_persona.",'".$usuario."','".$contra."','".$nombre."','".$apellido1."','".$apellido2."',".$permiso.",".$area.",'A','".$id_corporacion."',now()) ";

							$result_tb_usuarios=$this->Query($query_tb_usuarios);

							if($result_tb_usuarios['success']){

								$result=$result_tb_usuarios;
								$result['message']="El Usuario ".$nombre." ".$apellido1." ".$apellido2." se ha Inscrito correctamente.\n usuario: ".$usuario;
								$this->commit();
								/*
								$pg = new ConnectionPG(); //conexion postgres
								if(!$pg->Connect("localhost","postgres","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","masterag")){
										//NO CONNECT
								}
								$migrapersonas_produccion= new MigraPersonas($this, $pg);
								$semigro=false;

								$semigro=$migrapersonas_produccion->MigrarByPersonaV2('USUARIO INTERNO',0,0,10,'Alumno',0,$new_id_persona,true);

								$pg->Close();
								if($semigro){
									$this->commit();

									$result['message'].=".";
								}else{
									$this->rollback();

								}
								*/


							}else{ // error
								$result['message']="Lo sentimos el usuario no se ha podido registrar, intente mas tarde. 002:".$result_tb_usuarios['message'];



								$this->rollback();
							}

						}else{ // error PERSONA

							$result['message']="Lo sentimos el usuario no se ha podido registrar, intente mas tarde. 001:".$result_tb_personas['message'];
							$this->rollback();

						}

					return $result;
		}

		function UpdateUsuario($id_persona=0,$id_usuario=0,$nombre='',$apellidop='',$apellidom='',$contrasena='',$estatus='A',$permiso=0,$area=0){
			$result=array();
			$result['data']=null;
			$result['success']=false;
			$result['message']="Lo sentimos el usuario no se ha podido actualizar, intente mas tarde. 000";

			$update_pass="";
			if(empty($contrasena) || $contrasena=="" || $contrasena=="null"){
					$update_pass="";
			}else{

				$salt_hash= '3;a2drrR@}kb;z=-^}Ga:Uwz3u'; // hash de la contraseña de las plataformas

				$contra=md5(str_replace(" ","",$contrasena).$salt_hash); // genera la contraseña

				$update_pass=" tu.password='".$contra."' ,";


			}


			$query_tb_usuarios="UPDATE escolar.tb_usuarios tu SET

			".$update_pass."
			tu.nombre='".$nombre."',
			tu.apellidop='".$apellidop."',
			tu.apellidom='".$apellidom."',
			tu.id_permiso='".$permiso."',
			tu.id_area='".$area."',
			tu.estatus='".$estatus."'

			WHERE
			tu.id='".$id_usuario."' LIMIT 1 ";


			$result_tb_usuarios=$this->Query($query_tb_usuarios);

			if($result_tb_usuarios['success']){

				$result=$result_tb_usuarios;

				$result['message']="El Usuario ".$nombre." ".$apellidop." ".$apellidom." se ha ACTUALIZADO correctamente.\n usuario: ".$usuario." ";
				$this->commit();
				/*
				$pg = new ConnectionPG(); //conexion postgres
				if(!$pg->Connect("localhost","postgres","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","masterag")){
						//NO CONNECT
				}
				$migrapersonas_produccion= new MigraPersonas($this, $pg);
				$semigro=false;

				$semigro=$migrapersonas_produccion->MigrarByPersonaV2('USUARIO INTERNO',0,0,10,'Alumno',0,$id_persona,true);

				$pg->Close();
				if($semigro){
					$result['message'].=".";
				}
				*/


				//$_SESSION['id_permiso']=$permiso;
			}else{ // error
				$result['message']="Lo sentimos el usuario no se ha podido actualizar, intente mas tarde. 002:".$result_tb_usuarios['message'];

			}

			return $result;

		}



		function DeleteUsuario($id_usuario=0){
						$result=array();
			$result['data']=null;
			$result['success']=false;
			$result['message']="Lo sentimos el usuario no se ha podido eliminar, intente mas tarde. 000";


			$query_tb_usuarios_delete="SELECT 0;";
			$result_tb_usuarios=$this->Query($query_tb_usuarios_delete);

			if($result_tb_usuarios['success']){
				$result=$result_tb_usuarios;
				$result['message']="El Usuario se ha ELIMINADO correctamente. (prueba) ";
			}else{
				$result['message']="Lo sentimos el usuario no se ha podido actualizar, intente mas tarde. 002:".$result_tb_usuarios['message'];
			}
			return $result;
		}

		function GetUsername($username="nodefinido",$id_persona=0){

			$query="SELECT count(p.id) as conteo FROM escolar.tb_personas p WHERE p.usuario='".$username."' and p.id <> '".$id_persona."' " ;

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function GetNumeroEmpleado($id_persona=0,$numero_empleado=0,$id_corporacion=0){

			$query="SELECT count(ta.id) as conteo FROM escolar.tb_alumnos ta WHERE ta.id_persona <> '".$id_persona."' and ta.numero_empleado='".$numero_empleado."' and  ta.id_corporacion='".$id_corporacion."' limit 1 ";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}

			return $result;
		}


		function GetNombreCompleto($id_persona=0,$nombre="",$apellido1="",$apellido2="",$fecha_nacimiento="0000-00-00"){

			$nombre_completo=str_replace(" ","",$nombre).str_replace(" ","",$apellido1).str_replace(" ","",$apellido2);
			$query="SELECT count(tp.id) as conteo FROM escolar.tb_personas tp WHERE tp.id <> '".$id_persona."' and

LOWER(REPLACE(REPLACE(REPLACE(concat(tp.nombre,tp.apellido1,tp.apellido2),' ',''),'\t',''),'\n',''))
			=LOWER('".$nombre_completo."') and DATE(tp.fecha_nacimiento)=DATE('".$fecha_nacimiento."')  limit 1 ";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}


		function GetNewUsername($nombre, $apellido1,$id_persona=0){

			$nombre = str_replace("ñ", "n", $nombre);
			$nombre = str_replace("Ñ", "n", $nombre);
			$apellido1 = str_replace("ñ", "n", $apellido1);
			$apellido1 = str_replace("Ñ", "n", $apellido1);
			$apellido1 = str_replace(" ", "", $apellido1);
			$nombres = explode(" ", $nombre);
			$primer_nombre = strtolower($nombres[0]);
			$primer_apellido = strtolower($apellido1);

			$username = $primer_nombre.$primer_apellido;

			$username = str_replace(array('á','à','â','ã','ª','ä'),"a",$username);
			$username = str_replace(array('Á','À','Â','Ã','Ä'),"A",$username);
			$username = str_replace(array('Í','Ì','Î','Ï'),"I",$username);
			$username = str_replace(array('í','ì','î','ï'),"i",$username);
			$username = str_replace(array('é','è','ê','ë'),"e",$username);
			$username = str_replace(array('É','È','Ê','Ë'),"E",$username);
			$username = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$username);
			$username = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"O",$username);
			$username = str_replace(array('ú','ù','û','ü'),"u",$username);
			$username = str_replace(array('Ú','Ù','Û','Ü'),"U",$username);
			$username = str_replace(array('[','^','´','`','¨','~',']'),"",$username);
			$username = str_replace("ç","c",$username);
			$username = str_replace("Ç","C",$username);
			$username = str_replace("ñ","n",$username);
			$username = str_replace("Ñ","N",$username);
			$username = str_replace("Ý","Y",$username);
			$username = str_replace("ý","y",$username);


			$response = $this->GetUsername($username,$id_persona);
			$pre = $response["data"][0]['conteo'];
			if((int)$pre > 0){
				$cont = 1;
				while(true){
					$response = $this->GetUsername($username.$cont,$id_persona);
					$pre = $response["data"][0]['conteo'];
					if((int)$pre > 0){
						$cont++;
					}
					else{
						$username = $username.$cont;
						break;
					}
				}
			}
			return $username;
		}


	}
?>
