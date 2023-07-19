<?php 
	class Usuarios extends Connection {

		function Usuarios(){
		 	$this->Connect();
		}

		function GetUsuarios($bd="",$id_plan_estudio=0,$id_moodle=0,$numero_empleado="null",$nombre=""){
			$where="";

			if($numero_empleado==0 || $numero_empleado=="" || $numero_empleado=="null"){

			}else{
				$where.=" or ta.numero_empleado LIKE '%".$numero_empleado."%' ";
			}

			if(empty($nombre) || $nombre=="" || $nombre=="null"){

			}else{
				$where.=" or concat(tp.nombre,' ',tp.apellido1,' ',tp.apellido2) LIKE '%".$nombre."%'  ";
			}

			if($id_moodle==0 || $id_moodle=="" || $id_moodle=="null"){

			}else{
				$where.=" or m.id = '".$id_moodle."' ";
			}

			$query="SELECT tp.*,ta.idmoodle,ta.numero_empleado,ta.id_plan_estudio,m.username,concat(m.firstname,' ',m.lastname) as nombre_plataforma,ta.tipo, m.email,te.nombre as nombre_estado,tp.region  FROM escolar.tb_personas tp 
			inner join escolar.tb_alumnos ta on ta.id_persona=tp.id 
			inner join ".$bd.".mdl_user m on m.id=ta.idmoodle
			left join escolar.tb_estados te on te.id=tp.estado
			where ( (1=2) ".$where." ) and  ta.id_plan_estudio='".$id_plan_estudio."'  order by ta.idmoodle   limit 10; " ;


			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					
					if($row['id_plan_estudio']==9 || $row['id_plan_estudio']==10){ //OPTIENE EL NUMERO Y NOMBRE DE SUCURSAL DE MOODLE

						$query_infodata_numero_unidad="SELECT m.data from  ".$bd.".mdl_user_info_data m  WHERE m.userid=".$row['idmoodle']." and m.fieldid=5  limit 1" ;
						$result_numero_unidad=$this->Query($query_infodata_numero_unidad);
						if($result_numero_unidad['success']){
							$row_numero_unidad=mysqli_fetch_assoc($result_numero_unidad['data']);
							$row['numero_sucursal']=$row_numero_unidad['data'];
						}	

						$query_infodata_nombre_unidad="SELECT m.data from ".$bd.".mdl_user_info_data m  WHERE m.userid=".$row['idmoodle']." and m.fieldid=11  limit 1" ;

						$result_nombre_unidad=$this->Query($query_infodata_nombre_unidad);

						if($result_nombre_unidad['success']){
							$row_nombre_unidad=mysqli_fetch_assoc($result_nombre_unidad['data']);
							$row['nombre_sucursal']=$row_nombre_unidad['data'];
						}

						$query_horario="SELECT a1.horario1 FROM escolar.tb_a1 a1 WHERE a1.idmoodle='".$id_moodle."' AND a1.id_plan_estudios='".$id_plan_estudio."'  limit 1 ;";
						$result_horario=$this->Query($query_horario);

						if($result_horario['success']){
							$row_horario=mysqli_fetch_assoc($result_horario['data']);
							$row['horario']=$row_horario['horario1'];
						}

					}else if($row['id_plan_estudio']==4) { //prepaley

						$query_infodata_numero_unidad="SELECT m.data from  ".$bd.".mdl_user_info_data m  WHERE m.userid=".$row['idmoodle']." and m.fieldid=12  limit 1" ;
						$result_numero_unidad=$this->Query($query_infodata_numero_unidad);
						if($result_numero_unidad['success']){
							$row_numero_unidad=mysqli_fetch_assoc($result_numero_unidad['data']);
							$row['numero_sucursal']=$row_numero_unidad['data'];
						}	
					}else{ // otras plataformas
						$query_infodata_numero_unidad="SELECT m.data from  ".$bd.".mdl_user_info_data m  WHERE m.userid=".$row['idmoodle']." and m.fieldid=5  limit 1" ;
						$result_numero_unidad=$this->Query($query_infodata_numero_unidad);
						if($result_numero_unidad['success']){
							$row_numero_unidad=mysqli_fetch_assoc($result_numero_unidad['data']);
							$row['numero_sucursal']=$row_numero_unidad['data'];
						}	

						$query_infodata_nombre_unidad="SELECT m.data from ".$bd.".mdl_user_info_data m  WHERE m.userid=".$row['idmoodle']." and m.fieldid=11  limit 1" ;
						$result_nombre_unidad=$this->Query($query_infodata_nombre_unidad);
						if($result_nombre_unidad['success']){
							$row_nombre_unidad=mysqli_fetch_assoc($result_nombre_unidad['data']);
							$row['nombre_sucursal']=$row_nombre_unidad['data'];
						}	
					}

					$arrayResult[]=$row;


				}
				$result['data']=$arrayResult;
			}
			return $result;
		}




		function UpdateUsuario($bd="",$id_plan_estudio=0,$id_moodle=0,$id_persona=0,$nombre="",$apellido1="",$apellido2="",$usuario="nodefinio",$numero_empleado,$fecha_nacimiento="0000-00-00",$tipo_alumno=1,$numero_sucursal='',$nombre_sucursal='',$horario='',$id_estado=1,$sexo=0,$email='noemail@agcollege.edu.mx',$id_sucursal=0,$id_region=0,$nombre_region='no definido'){
			

			$numero_empleado=trim($numero_empleado);
			$nombre=trim($nombre);
			$apellido1=trim($apellido1);
			$usuario=trim($usuario);
			$apellido2=trim($apellido2);


			if($id_estado==0 || $id_estado=="" || $id_estado=="null"){
				$id_estado=1;
			}

			if($id_sucursal==0 || $id_sucursal=="" || $id_sucursal=="null"){
				$id_sucursal=1;
			}
				$salt_hash= '3;a2drrR@}kb;z=-^}Ga:Uwz3u'; // hash de la contraseña de las plataformas

				$contra=md5(str_replace(" ","",$numero_empleado).$salt_hash); // genera la contraseña

				$str_tipo_alumno="No Definido";

			if($tipo_alumno==1){
				$str_tipo_alumno="No Definido";

			}else if($tipo_alumno==2){
				$str_tipo_alumno="Colaborador";

			}else if($tipo_alumno==3) {
				$str_tipo_alumno="Familiar";
			}


			if($id_plan_estudio==9 || $id_plan_estudio==10){ // si es toks
				
				$query_infodata_numero_unidad="UPDATE ".$bd.".mdl_user_info_data m SET m.data='".$numero_sucursal."' WHERE m.userid=".$id_moodle." and m.fieldid=5  limit 1" ;
				
				$query_infodata_nombre_unidad="UPDATE ".$bd.".mdl_user_info_data m SET m.data='".$nombre_sucursal."' WHERE m.userid=".$id_moodle." and m.fieldid=11  limit 1" ;

				$query_tb_a1="UPDATE escolar.tb_a1 a1 SET a1.numero_centro='".$numero_sucursal."', a1.nombre_centro='".$nombre_sucursal."', a1.numero_empleado='".$numero_empleado."', a1.apellido1='".$apellido1."',a1.apellido2='".$apellido2."', a1.nombre='".$nombre."',  a1.horario1='".$horario."', a1.horario2='".$horario."', a1.id_estado='".$id_estado."' WHERE a1.idmoodle='".$id_moodle."' AND a1.id_plan_estudios='".$id_plan_estudio."',a1.region='".$nombre_region."'  limit 1 ";

				$query_infodata_nombre_region="UPDATE ".$bd.".mdl_user_info_data m SET m.data='".$nombre_region."' WHERE m.userid=".$id_moodle." and m.fieldid=10  limit 1" ;

				$query_infodata_nombre_region=$this->Query($query_infodata_nombre_region);

				$query_tb_a1=$this->Query($query_tb_a1);
				$query_infodata_numero_unidad=$this->Query($query_infodata_numero_unidad);
				$query_infodata_nombre_unidad=$this->Query($query_infodata_nombre_unidad);

			}else if($id_plan_estudio==4) { // ley

				$query_infodata_numero_unidad="UPDATE ".$bd.".mdl_user_info_data m SET m.data='".$numero_sucursal."' WHERE m.userid='".$id_moodle."' and m.fieldid=12  limit 1" ;
				$query_infodata_numero_unidad=$this->Query($query_infodata_numero_unidad);

			}else{ // otras plataformas

				$query_infodata_numero_unidad="UPDATE ".$bd.".mdl_user_info_data m SET m.data='".$numero_sucursal."' WHERE m.userid=".$id_moodle." and m.fieldid=5  limit 1" ;
				
				$query_infodata_nombre_unidad="UPDATE ".$bd.".mdl_user_info_data m SET m.data='".$nombre_sucursal."' WHERE m.userid=".$id_moodle." and m.fieldid=11  limit 1" ;

				$query_infodata_nombre_region="UPDATE ".$bd.".mdl_user_info_data m SET m.data='".$nombre_region."' WHERE m.userid=".$id_moodle." and m.fieldid=10  limit 1" ;

				$query_infodata_numero_unidad=$this->Query($query_infodata_numero_unidad);
				$query_infodata_nombre_unidad=$this->Query($query_infodata_nombre_unidad);
				$query_infodata_nombre_region=$this->Query($query_infodata_nombre_region);

			}


			$query_tb_alumnos="UPDATE escolar.tb_alumnos ta set ta.tipo='".$tipo_alumno."' ,ta.numero_empleado='".$numero_empleado."' WHERE ta.id_persona=".$id_persona." and ta.id_plan_estudio='".$id_plan_estudio."' limit 1" ;


			$query_infodata_n_empleado="UPDATE ".$bd.".mdl_user_info_data m SET m.data='".$numero_empleado."' WHERE m.userid=".$id_moodle." and m.fieldid=4  limit 1" ;

			
			$query_tb_personas="UPDATE escolar.tb_personas tp SET tp.sexo='".$sexo."',tp.fecha_nacimiento='".$fecha_nacimiento."', tp.contrasena='".$contra."', tp.usuario='".$usuario."', tp.nombre='".$nombre."', tp.apellido1='".$apellido1."', tp.apellido2='".$apellido2."',tp.sucursal='".$id_sucursal."',tp.estado='".$id_estado."',tp.region='".$id_region."' WHERE tp.id='".$id_persona."' limit 1 " ;

			$query_mdl_user="UPDATE ".$bd.".mdl_user m SET m.password='".$contra."', m.username='".$usuario."',m.firstname='".$nombre."',m.lastname='".$apellido1." ".$apellido2."',m.email='".$email."' WHERE m.id='".$id_moodle."' limit 1 ";

				$query_infodata_tipo_alumno="UPDATE ".$bd.".mdl_user_info_data m SET m.data='".$str_tipo_alumno."' WHERE m.userid=".$id_moodle." and m.fieldid=9  limit 1" ; 

			$query_check_tipo="SELECT count(m.id) as conteo FROM ".$bd.".mdl_user_info_data m WHERE m.userid=".$id_moodle." and m.fieldid=9  "; 

			$result_check_tipo=$this->Query($query_check_tipo);
			$conteo=1;
			if($result_check_tipo['success']){
				while($row=mysqli_fetch_assoc($result_check_tipo['data'])){
					$conteo=$row['conteo'];
				}

				if((int)$conteo>0){
					$result_infodata_tipo_alumno=$this->Query($query_infodata_tipo_alumno);

				}else{

					$query_infodata_tipo_alumno="INSERT INTO ".$bd.".mdl_user_info_data (data,userid,fieldid) VALUES('".$str_tipo_alumno."','".$id_moodle."',9)" ;
					$result_infodata_tipo_alumno=$this->Query($query_infodata_tipo_alumno);
				}
				
			}else{
				$result_infodata_tipo_alumno=$this->Query($query_infodata_tipo_alumno);

			}


			$result_tb_personas=$this->Query($query_tb_personas);
			$result_tb_alumnos=$this->Query($query_tb_alumnos);
			$result_mdl_user=$this->Query($query_mdl_user);
			$result_infodata_n_empleado=$this->Query($query_infodata_n_empleado);





			$arrayResult=array();
			if($result_tb_personas['success'] && $result_mdl_user['success'] && $result_tb_alumnos['success'] && $result_infodata_n_empleado['success'] && $result_infodata_tipo_alumno['success']){

				$result['success']=true;
				$result['message']="Usuario actualizado correctamente";

				$this->Bitacora($_SESSION['id_persona'],"ALUMNOS","MODIFICACION",$bd.": IDMOODLE: ".$id_moodle);

			}else{
				$result['success']=false;
				$result['message']="El usuario no se pudo actualizar, \n razónes: error en la base de datos o el usuario puede estar duplicado o no cuente con INFODATA de moodle. 001. ".$result_tb_personas['message']." | ".$result_mdl_user['message']." | ".$result_tb_alumnos['message']." | ".$result_infodata_n_empleado['message']." | ".$result_infodata_tipo_alumno['message'];

			}

			return $result;
		}

		function InsertUsuario($bd="",$id_corporacion=0,$id_plan_estudio=0,$nombre="",$apellido1="",$apellido2="",$usuario="nodefinio",$numero_empleado=0,$fecha_nacimiento="0000-00-00", $telefono_casa="",$telefono_celular="",$telefono_alternativo="",$email="sincorreo@agcollege.edu.mx",$id_estado=0,$id_ciudad=0,$nombre_ciudad="no definido",$id_region=0,$nombre_region="no definido",$numero_sucursal=0,$nombre_sucursal="NO_DEFINIDO",$tipo_alumno=0,$sexo=0,$nomenclatura_ciudad="No Definido",$id_ucl_escuela=0){


			$numero_empleado=trim($numero_empleado);
			$nombre=trim($nombre);
			$apellido1=trim($apellido1);
			$usuario=trim($usuario);
			$apellido2=trim($apellido2);


			$originalDate = $fecha_nacimiento;
			 @$fecha_nacimiento = date("Y-m-d", strtotime($originalDate));
			$str_alumno_tipo="Colaborador";

			if((int)$tipo_alumno==2){
				$str_alumno_tipo="Colaborador";
			}else if((int)$tipo_alumno==3){
				$str_alumno_tipo="Familiar";
			}

			if(empty($email) or str_replace(" ","",$email)==""){
					$email=$usuario."@agcollege.edu.mx";
			}

			$salt_hash= '3;a2drrR@}kb;z=-^}Ga:Uwz3u'; // hash de la contraseña de las plataformas

			$contra=md5(str_replace(" ","",$numero_empleado).$salt_hash); // genera la contraseña

				$result=array();
				$result['data']=null;
				$result['success']=false;
				$result['message']="Lo sentimos el usuario no se ha podido registrar, intente mas tarde. ";

			$this->begin_transaction();

			if((int)$id_plan_estudio==2){ //si es coppel
				$ciudad_moodle=$nomenclatura_ciudad;
			}else{
				$ciudad_moodle=$nombre_ciudad;
			}

			$query_mdl_user="INSERT INTO ".$bd.".mdl_user ( auth, confirmed, policyagreed, deleted, suspended, mnethostid, username, password, idnumber, firstname, lastname, email, emailstop, icq, skype, yahoo, aim, msn, phone1, phone2, institution, department, address, city, country, lang, theme, timezone, firstaccess, lastaccess, lastlogin, currentlogin, lastip, secret, picture, url, description, descriptionformat, mailformat, maildigest, maildisplay, htmleditor, autosubscribe, trackforums, timecreated, timemodified, trustbitmask, imagealt, screenreader) VALUES ( 'manual', '1', '0', '0', '0', '1', '".$usuario."', '".$contra."', '', '".$nombre."','".$apellido1." ".$apellido2."', '".$email."', '0', '', '', '', '', '', '', '', '', '', '', '".$ciudad_moodle."', 'MX', 'es_mx', '', '99',UNIX_TIMESTAMP(now()),UNIX_TIMESTAMP(now()), UNIX_TIMESTAMP(now()), UNIX_TIMESTAMP(now()), '', '', '0', '', '', '1', '1', '0', '2', '1', '1', '0', UNIX_TIMESTAMP(now()), UNIX_TIMESTAMP(now()), '0', '', '0'); ";


			
			$result_mdl_user=$this->Query($query_mdl_user);

			


			if($result_mdl_user['success']){
				$new_id_moodle=$this->last_insert_id();


				if((int)$id_plan_estudio==4){ //es ley
									$query_infodata=" 

							INSERT INTO ".$bd.".mdl_user_info_data ( userid, fieldid, data, dataformat) VALUES 
							  ( '".$new_id_moodle."', '4', '".$numero_empleado."', '0'),
							 	( '".$new_id_moodle."', '6', '0', '0'),
								( '".$new_id_moodle."', '7', 'No Definido', '0'),
								( '".$new_id_moodle."', '9', 'No definido', '0'),
								( '".$new_id_moodle."', '10', 'Alumno', '0'),
								( '".$new_id_moodle."', '12', '".$numero_sucursal."', '0')  ";
				}else{
									

							if((int)$id_plan_estudio==2){ //inserta en prepacoppel.ag_alumnos para el sistema viejo de casa
								$query_ag_alumnos=" INSERT INTO prepacoppel.ag_alumnos (id,numero_trabajador) values ('".$new_id_moodle."','".$numero_empleado."') ";
								$result_ag_alumnos=$this->Query($query_ag_alumnos);
							}


							if((int)$id_plan_estudio==16){ // SI ES UCL ESCUELAS
									$query_infodata=" 
									INSERT INTO ".$bd.".mdl_user_info_data ( userid, fieldid, data, dataformat) VALUES 
									( '".$new_id_moodle."', '1', 'Alumno', '0'),
									 ( '".$new_id_moodle."', '3', 'No Definido', '0'),
									  ( '".$new_id_moodle."', '4', '".$numero_empleado."', '0'),
									   ( '".$new_id_moodle."', '5', '".$numero_sucursal."', '0'),
									 	( '".$new_id_moodle."', '6', '0', '0'),
										( '".$new_id_moodle."', '7', '".$telefono_casa."', '0'),
										( '".$new_id_moodle."', '8', '".$telefono_celular."', '0'),
										( '".$new_id_moodle."', '9', '".$str_alumno_tipo."', '0'),
										( '".$new_id_moodle."', '10', '".$nombre_region."', '0'),
										( '".$new_id_moodle."', '11', '".$nombre_sucursal."', '0'),
										( '".$new_id_moodle."', '12', 'No Definido', '0') ,
										( '".$new_id_moodle."', '13', '".$id_ucl_escuela."', '0')  ";
							}else{
									$query_infodata=" 
									INSERT INTO ".$bd.".mdl_user_info_data ( userid, fieldid, data, dataformat) VALUES 
									( '".$new_id_moodle."', '1', 'Alumno', '0'),
									 ( '".$new_id_moodle."', '3', 'No Definido', '0'),
									  ( '".$new_id_moodle."', '4', '".$numero_empleado."', '0'),
									   ( '".$new_id_moodle."', '5', '".$numero_sucursal."', '0'),
									 	( '".$new_id_moodle."', '6', '0', '0'),
										( '".$new_id_moodle."', '7', '".$telefono_casa."', '0'),
										( '".$new_id_moodle."', '8', '".$telefono_celular."', '0'),
										( '".$new_id_moodle."', '9', '".$str_alumno_tipo."', '0'),
										( '".$new_id_moodle."', '10', '".$nombre_region."', '0'),
										( '".$new_id_moodle."', '11', '".$nombre_sucursal."', '0'),
										( '".$new_id_moodle."', '12', 'No Definido', '0')  ";
							}
				}



				$result_infodata=$this->Query($query_infodata);

				if($result_infodata['success']){

					$query_tb_personas="INSERT INTO escolar.tb_personas ( idmoodle, usuario, contrasena, permisos, nombre, apellido1, apellido2, sexo, fecha_nacimiento, rfc, ife, curp, estado_civil, colonia, calle, numero, codigopostal, ciudad, municipio, estado, region, sucursal, puesto_nombre, puesto, area, email, whatsapp, facebook, tel1, tel2, tel3, id_corporacion, corporacion_origen, prueba, activo, fecha_registro, actualizado, eliminado, fecha_eliminado) VALUES ( '".$new_id_moodle."', '".$usuario."', '".$contra."', '1', '".$nombre."', '".$apellido1."', '".$apellido2."', '".$sexo."', '".$fecha_nacimiento."', 'NORFC', 'NOIFE', null, '1', '', '', '', '80000', '".$id_ciudad."', '1', '".$id_estado."','".$id_region."', '1', 'PUESTO NO DEFINIDO', '1', '0', '".$email."', '', '', '".$telefono_casa."', '".$telefono_celular."', '".$telefono_alternativo."', '".$id_corporacion."', '".$id_corporacion."', '0', '1', now(), now(), '0', '0000-00-00 00:00:00'); ";

						$result_tb_personas=$this->Query($query_tb_personas);

						if($result_tb_personas['success']){
							$new_id_persona=$this->last_insert_id();
							$query_tb_alumnos="INSERT INTO escolar.tb_alumnos ( id_persona, idmoodle, asesor, numero_empleado, id_plan_estudio, estado, fecha_reporte_estado, carga_automatica, acta_nacimiento, certificado_secundaria, certificado_parcial_estudios, tipo, prepa_equivalencia, id_rvoe, fecha_inscripcion, fecha_convocatoria, fecha_registro, actualizado, eliminado, fecha_eliminado, id_corporacion, curso_induccion, id_reponsable_curso_induccion) VALUES ( '".$new_id_persona."', '".$new_id_moodle."', '202', '".$numero_empleado."', '".$id_plan_estudio."', '1', now(), '0', '0', '0', '0', '".$tipo_alumno."', '0', NULL, now(), '0000-00-00', now(),now(), NULL, '0000-00-00 00:00:00', '".$id_corporacion."', '0', NULL);";
							
							$result_tb_alumnos=$this->query($query_tb_alumnos);



							if($result_tb_alumnos['success']){ //registro èxitoso

								 $id_alumno_last=$this->last_insert_id();

								if(!empty($telefono_casa) && $telefono_casa != "" ){

									 $query_tb_numeros1="INSERT INTO escolar.tb_numeros_telefonicos ( id_alumno, id_asesor, numero_telefonico, fecha_alta) VALUES ( '".$id_alumno_last."', '".$_SESSION['id_usuario']."','".$telefono_casa."',now());";
									$result_tb_numeros1=$this->query($query_tb_numeros1);

								}
								
								if(!empty($telefono_celular) && $telefono_celular != "" ){
									$query_tb_numeros2="INSERT INTO escolar.tb_numeros_telefonicos ( id_alumno, id_asesor, numero_telefonico, fecha_alta) VALUES ( '".$id_alumno_last."', '".$_SESSION['id_usuario']."', '".$telefono_celular."',now());";
									$result_tb_numeros2=$this->query($query_tb_numeros2);
								}
								
								if(!empty($telefono_alternativo) && $telefono_alternativo != "" ){
									$query_tb_numeros3="INSERT INTO escolar.tb_numeros_telefonicos ( id_alumno, id_asesor, numero_telefonico, fecha_alta) VALUES ( '".$id_alumno_last."', '".$_SESSION['id_usuario']."', '".$telefono_alternativo."',now());";
									$result_tb_numeros3=$this->query($query_tb_numeros3);
								}

								$result=$result_tb_alumnos;
								$result['message']=" El Usuario ".$nombre." ".$apellido1." ".$apellido2." se ha Inscrito correctamente a la plataforna.  \n usuario: ".$usuario." contraseña: ".$numero_empleado." ";

								$this->commit();


								$query_a1=" INSERT INTO escolar.tb_a1 (idmoodle, numero_centro, nombre_centro, gerente, numero_empleado, ciudad, region, apellido1, apellido2, nombre, puesto, telefono1, telefono2, telefono3, horario1, horario2, facebook, email, acceso_internet, equivalencia, acta_nacimiento, certificado_secundaria, certificado_parcial, comentarios, estatus, fecha_alta, fecha_modificacion, fecha_baja, motivo_baja, id_corporacion, id_plan_estudios, id_region, id_ciudad, id_estado, departamento, celular, computadora, tableta, escuela_anterior, carga_materias, origen,usuario_alta) VALUES ('".$new_id_moodle."','".$numero_sucursal."', '".$nombre_sucursal."', NULL, '".$numero_empleado."', '".$ciudad_moodle."', '".$nombre_region."', '".$apellido1."','".$apellido2."', '".$nombre."', NULL, '".$telefono_casa."', '".$telefono_celular."', '".$telefono_alternativo."', NULL, NULL, NULL, '".$email."', NULL, NULL, NULL, NULL, NULL, 'REGISTRADO DESDE CEREPORTE SISTEMA GLOBAL', 5, now(), NULL, NULL, NULL, '".$id_corporacion."',  '".$id_plan_estudio."', '".$id_region."', '".$id_ciudad."', '".$id_estado."', NULL, NULL, NULL, NULL, NULL, NULL, 'CEREPORTE SISTEMA GLOBAL','".$_SESSION['id_usuario']."') " ;

								$result_a1=$this->query($query_a1);


								$this->Bitacora($_SESSION['id_persona'],"ALUMNOS","CREACION",$bd.": IDMOODLE: ".$new_id_moodle);

												
							}else{
								$result['message']="Lo sentimos el usuario no se ha podido registrar, intente mas tarde. 004".$result_tb_personas['message'];
								$this->rollback();
							}

						}else{ // error PERSONA

							$result['message']="Lo sentimos el usuario no se ha podido registrar, intente mas tarde. 003:".$result_tb_personas['message'];
							$this->rollback();

						}



				}else{ //ERROR INFODATA
					$result['message']="Lo sentimos el usuario no se ha podido registrar, intente mas tarde. 002:".$result_infodata['message'];
					$this->rollback();
				}

			}else{ // error MDL_USER
				$result['message']="Lo sentimos el usuario no se ha podido registrar, intente mas tarde. 001 : ".$result_mdl_user['message'];
				$this->rollback();
			}

			return $result;
		}

		function GetUsername($bd="nodefinido",$username="nodefinido",$id_moodle=0){

			$query="SELECT count(m.id) as conteo FROM ".$bd.".mdl_user m WHERE m.username='".$username."' and m.id <> '".$id_moodle."' " ;

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


		function GetNewUsername($bd,$nombre, $apellido1,$id_moodle=0){
		
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

			
			$response = $this->GetUsername($bd,$username,$id_moodle);
			$pre = $response["data"][0]['conteo'];
			if((int)$pre > 0){
				$cont = 1;
				while(true){
					$response = $this->GetUsername($bd,$username.$cont,$id_moodle);
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