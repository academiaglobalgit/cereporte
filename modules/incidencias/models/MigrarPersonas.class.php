<?php 

class MigraPersonas {

	var $mysql;
	var $pg;
	var $id_plan_estudio;
	var $id_corporacion;

	public function MigraPersonas($mysql,$pg)
	{
		$this->mysql=$mysql;
		$this->pg=$pg;
	}

	function ShowError($msg){
			$this->pg->Close();
			$this->mysql->Close();
			die($msg);
	}

	function validateDate($date, $format = 'Y-m-d H:i:s')
	{
	    @$d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}

	function MigrarTBUsuarios(){ 
		//MIGRACION DE USUARIOS DE  tb_alumnos
		$query_usuarios="SELECT tp.*,tu.username as username_usuario, tu.password as password_usuario FROM escolar.tb_usuarios tu INNER JOIN escolar.tb_personas tp on tp.id=tu.id_persona ";
		$result_usuarios=$this->mysql->Query($query_usuarios);
		if($result_usuarios['success']){
			while ($row=mysqli_fetch_assoc($result_usuarios['data'])) {

				$estadocivil=7; // REGISTRO DE NO DEFINIDO

					if((int)$row['estadocivil']==0){ // MAPEO DE ESTADO CIVIL ESCOLAR -> MASTERAG
						$estadocivil=7;
					}else if((int)$row['estadocivil']==1) {
						$estadocivil=7;
					}else if((int)$row['estadocivil']==2) {
						$estadocivil=1;
					}else if((int)$row['estadocivil']==3) {
						$estadocivil=3;
					}
					if(!$this->validateDate($row['fecha_nacimiento'], 'Y-m-d')){ 
						// si no tiene fecha de nacimiento o no es valida se le pone una por default
						$row['fecha_nacimiento']="1970-01-01";
					}

					//QUERY DE INSERT EN masterag.tb_personas
					
					$primer_nombre=$this->StripPrimerNombre($row['nombre']);
					$segundo_nombre=$this->StripSegundoNombre($row['nombre']);
					
					$pg_query='INSERT INTO "masterag"."tb_personas" 
					( "id_rol", "nombre1", "nombre2", "apellido1", "apellido2", "fecha_nacimiento", "sexo", "curp", "id_estado_civil", "fecha_registro", "fecha_modificacion") VALUES (4,\''.$primer_nombre.'\',\''.$segundo_nombre.'\',\''.$row['apellido1'].'\',\''.$row['apellido2'].'\',\''.$row['fecha_nacimiento'].'\',\''.$row['sexo'].'\',\''.$row['curp'].'\','.$estadocivil.',\''.$row['fecha_registro'].'\',now());';
					

						$pg_result=$this->pg->Query($pg_query);

						if($pg_result['success']){

							$lastid=$this->pg->last_insert_table('tb_personas','id');

							//QUERY PARA SABER SI YA EXISTE EL ID ANTES DE MIGRARLO A LA masterag
							$existe_id=0;
							$pg_select_query='SELECT COUNT("id_nuevo") FROM "masterag"."tb_ids_escolar" WHERE "tb_ids_escolar"."id_nuevo"='.$lastid.' LIMIT 10';
							$pg_result_select=$this->pg->Query($pg_select_query);
							while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
							    foreach ($line as $col_value) {
							        $existe_id=$col_value;
							    }
							}

							if($existe_id==0){ // si el id ya no existe en la nueva BASE DE DATOS masterag lo inserta

								$pg_query_ids='INSERT INTO "masterag"."tb_ids_escolar" ("id_nuevo","idmoodle","id_persona","id_alumno","id_corporacion","id_plan_estudio","basededatos") VALUES ('.$lastid.',0,'.$row['id'].',0,0,0,\'USUARIO INTERNO\'); '; 
								
								$pg_result_ids=$this->pg->Query($pg_query_ids);
								if(!$pg_result_ids['success']){
									$this->ShowError($bd." ERROR EN LA QUERY tb_ids_escolar: \n ".$pg_query_ids." \n ".$pg_result_ids['message']);
								}else{
									$this->MigrarUsuariosInternos($lastid,$row['username_usuario'],$row['password_usuario']);
								}
							}else{ // si ya existe se detiene el proceso
							
								$this->ShowError($bd." PROCESO DETENIDO: USUARIOS TB PERSONAS EL ID:  ".$row['id']." Ya exíste");
							}


						}else{
						
							$this->ShowError($bd." ERROR EN LA QUERY tb_personas : \n ".$pg_query." \n ".$pg_result['message']);
						}



			}
		}else{
			$this->ShowError("USUARIOS: ERROR EN LA QUERY tb_usuarios : \n ".$query_usuarios." \n ".$result_usuarios['message']);

		}
		

	}

	function Migrar($bd='',$corporacion=2,$plan_estudios=2,$fieldid=1,$fieldid_str='alumno')
	{

	 	$this->id_corporacion=$corporacion;
	 	$this->id_plan_estudio=$plan_estudios;
	 	$fieldid_alumno=$fieldid;
	 	$fieldid_alumno_str=$fieldid_str;

		$mysql_query="SELECT tp.*,m.id as idmoodle,ta.id as id_alumno FROM ".$bd.".mdl_user m
		 inner join escolar.tb_alumnos ta on ta.idmoodle=m.id 
		 inner join escolar.tb_personas tp on tp.id=ta.id_persona
		 where 
		 m.deleted=0
		 and
		  (select mdata.data from ".$bd.".mdl_user_info_data mdata where mdata.fieldid = ".$fieldid_alumno." and mdata.userid = m.id limit 1) = '".$fieldid_alumno_str."'
		 and ta.id_corporacion=".$this->id_corporacion." and ta.id_plan_estudio=".$this->id_plan_estudio." order by tp.id asc";
		
		$mysql_result_escolar=$this->mysql->Query($mysql_query);
		if($this->mysql->con){
				while ($row=mysqli_fetch_assoc($mysql_result_escolar['data'])) {
					
					$estadocivil=7; // REGISTRO DE NO DEFINIDO

					if((int)$row['estadocivil']==0){ // MAPEO DE ESTADO CIVIL ESCOLAR -> MASTERAG
						$estadocivil=7;
					}else if((int)$row['estadocivil']==1) {
						$estadocivil=7;
					}else if((int)$row['estadocivil']==2) {
						$estadocivil=1;
					}else if((int)$row['estadocivil']==3) {
						$estadocivil=3;
					}
					if(!$this->validateDate($row['fecha_nacimiento'], 'Y-m-d')){ 
						// si no tiene fecha de nacimiento o no es valida se le pone una por default
						$row['fecha_nacimiento']="1970-01-01";
					}

					//QUERY DE INSERT EN masterag.tb_personas
					
					$primer_nombre=$this->StripPrimerNombre($row['nombre']);
					$segundo_nombre=$this->StripSegundoNombre($row['nombre']);
					
					$pg_query='INSERT INTO "masterag"."tb_personas" 
					( "id_rol", "nombre1", "nombre2", "apellido1", "apellido2", "fecha_nacimiento", "sexo", "curp", "id_estado_civil", "fecha_registro", "fecha_modificacion") VALUES (2,\''.$primer_nombre.'\',\''.$segundo_nombre.'\',\''.$row['apellido1'].'\',\''.$row['apellido2'].'\',\''.$row['fecha_nacimiento'].'\',\''.$row['sexo'].'\',\''.$row['curp'].'\','.$estadocivil.',\''.$row['fecha_registro'].'\',now());';
					



						$pg_result=$this->pg->Query($pg_query);

						if($pg_result['success']){

							$lastid=$this->pg->last_insert_table('tb_personas','id');

							//QUERY PARA SABER SI YA EXISTE EL ID ANTES DE MIGRARLO A LA masterag
							$existe_id=0;
							$pg_select_query='SELECT COUNT("id_nuevo") FROM "masterag"."tb_ids_escolar" WHERE "tb_ids_escolar"."id_nuevo"='.$lastid.' LIMIT 10';
							$pg_result_select=$this->pg->Query($pg_select_query);
							while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
							    foreach ($line as $col_value) {
							        $existe_id=$col_value;
							    }
							}

							if($existe_id==0){ // si el id ya no existe en la nueva BASE DE DATOS masterag lo inserta

								$pg_query_ids='INSERT INTO "masterag"."tb_ids_escolar" ("id_nuevo","idmoodle","id_persona","id_alumno","id_corporacion","id_plan_estudio","basededatos") VALUES ('.$lastid.','.$row['idmoodle'].','.$row['id'].','.$row['id_alumno'].','.$this->id_corporacion.','.$this->id_plan_estudio.',\''.$bd.'\'); '; 
								
								$pg_result_ids=$this->pg->Query($pg_query_ids);
								if(!$pg_result_ids['success']){
									$this->ShowError($bd." ERROR EN LA QUERY tb_ids_escolar: \n ".$pg_query." \n ".$pg_result['message']);
								}else{

									$this->MigrarPerfiles($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_perfiles
									$this->MigrarDatosEmpresa($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_datos_empresas
									$this->MigrarUsuarios($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_usuarios
									$this->MigrarPersonasInscripcion($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_personas_inscripcion
									$this->MigrarPersonasTelefonos($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_personas_telefonos
									//$this->MigrarPersonasInscripcionUPDATETaxonomia($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //ACTUALIZA ESTATUS DE TAXONOMIA PROSPECTO , PREINSCRITO INSCRITO

								}
							}else{ // si ya existe se detiene el proceso
							
								$this->ShowError($bd." PROCESO DETENIDO: ".$bd." EL ID:  ".$row['id']." Ya exíste");
							}


						}else{
						
							$this->ShowError($bd." ERROR EN LA QUERY tb_personas : \n ".$pg_query." \n ".$pg_result['message']);
						}


				}// final while del select de escolar


				
			echo "<center><strong style='color:green;'>MIGRACION ".$bd." TB_PERSONAS DE MASTERAG SATISFACTORIO</strong></center>";
		}else{
			echo "<center><strong style='color:red;'>MIGRACION ".$bd." TB_PERSONAS DE NO SE PUDO CONECTAR A BASEDEDATOS</strong></center>";
	
		}
		
	}



	function MigrarV2($bd='',$corporacion=2,$plan_estudios=2,$fieldid=1,$fieldid_str='alumno',$interno=false) 
	{
		$updates=0;
		$inserts=0;
		$registros=0;
		//SI NO ENCUENTRA EL ALUMNO SE INSERTA Y SI YA EXISTE SE ACTUALIZA
	 	$this->id_corporacion=$corporacion;
	 	$this->id_plan_estudio=$plan_estudios;
	 	$fieldid_alumno=$fieldid;
	 	$fieldid_alumno_str=$fieldid_str;

		$mysql_query="SELECT tp.*,m.id as idmoodle,ta.id as id_alumno,m.deleted as eliminado FROM ".$bd.".mdl_user m
		 inner join escolar.tb_alumnos ta on ta.idmoodle=m.id 
		 inner join escolar.tb_personas tp on tp.id=ta.id_persona
		 where 
		  (select mdata.data from ".$bd.".mdl_user_info_data mdata where mdata.fieldid = ".$fieldid_alumno." and mdata.userid = m.id limit 1) = '".$fieldid_alumno_str."'
		 and ta.id_corporacion=".$this->id_corporacion." and ta.id_plan_estudio=".$this->id_plan_estudio." order by tp.id asc";

		if($interno){
			$mysql_query="SELECT tp.*,tu.username as username_usuario, tu.password as password_usuario,0 as idmoodle,0 as id_alumno FROM escolar.tb_usuarios tu INNER JOIN escolar.tb_personas tp on tp.id=tu.id_persona ";

			$bd="USUARIO INTERNO";
		}
		
		
		if($this->mysql->con){

				$mysql_result_escolar=$this->mysql->Query($mysql_query);
				if($mysql_result_escolar['success']){
					while ($row=mysqli_fetch_assoc($mysql_result_escolar['data'])) {

						
						$estadocivil=7; // REGISTRO DE NO DEFINIDO

						if((int)$row['estadocivil']==0){ // MAPEO DE ESTADO CIVIL ESCOLAR -> MASTERAG
							$estadocivil=7;
						}else if((int)$row['estadocivil']==1) {
							$estadocivil=7;
						}else if((int)$row['estadocivil']==2) {
							$estadocivil=1;
						}else if((int)$row['estadocivil']==3) {
							$estadocivil=3;
						}
						if(!$this->validateDate($row['fecha_nacimiento'], 'Y-m-d')){ 
							// si no tiene fecha de nacimiento o no es valida se le pone una por default
							$row['fecha_nacimiento']="1970-01-01";
						}

						
						
						$primer_nombre=$this->StripPrimerNombre($row['nombre']);
						$segundo_nombre=$this->StripSegundoNombre($row['nombre']);
						

						//QUERY PARA SABER SI YA EXISTE EL ID ANTES DE UPDATEARLO A LA masterag
						$lastid=0; // id_persona NUEVO
						$pg_select_query='SELECT "id_nuevo" FROM "masterag"."tb_ids_escolar" WHERE 

						"tb_ids_escolar"."idmoodle"='.$row['idmoodle'].' AND
						"tb_ids_escolar"."id_persona"='.$row['id'].' AND
						"tb_ids_escolar"."id_alumno"='.$row['id_alumno'].' AND
						"tb_ids_escolar"."id_corporacion"='.$this->id_corporacion.' AND
						"tb_ids_escolar"."id_plan_estudio"='.$this->id_plan_estudio.' 
						 LIMIT 1';
						$pg_result_select=$this->pg->Query($pg_select_query);
						while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
						    foreach ($line as $col_value) {
						        $lastid=$col_value;
						    }
						}

						if($lastid==0 || !is_numeric($lastid)){ // si el id ya no existe en la nueva BASE DE DATOS masterag lo inserta

							//QUERY DE INSERT EN masterag.tb_personas
							$pg_query='INSERT INTO "masterag"."tb_personas" ( "id_rol", "nombre1", "nombre2", "apellido1", "apellido2", "fecha_nacimiento", "sexo", "curp", "id_estado_civil", "fecha_registro", "fecha_modificacion","eliminado") VALUES (2,\''.$primer_nombre.'\',\''.$segundo_nombre.'\',\''.$row['apellido1'].'\',\''.$row['apellido2'].'\',\''.$row['fecha_nacimiento'].'\',\''.$row['sexo'].'\',\''.$row['curp'].'\','.$estadocivil.',\''.$row['fecha_registro'].'\',now(),'.$row['eliminado'].');';
						
							$pg_result=$this->pg->Query($pg_query);

							if($pg_result['success']){

								$lastid=$this->pg->last_insert_table('tb_personas','id');


								$pg_query_ids='INSERT INTO "masterag"."tb_ids_escolar" ("id_nuevo","idmoodle","id_persona","id_alumno","id_corporacion","id_plan_estudio","basededatos") VALUES ('.$lastid.','.$row['idmoodle'].','.$row['id'].','.$row['id_alumno'].','.$this->id_corporacion.','.$this->id_plan_estudio.',\''.$bd.'\'); '; 
								
								$pg_result_ids=$this->pg->Query($pg_query_ids);
								if(!$pg_result_ids['success']){
									$this->ShowError($bd." ERROR EN LA QUERY tb_ids_escolar: \n ".$pg_query." \n ".$pg_result['message']);
								}else{


									if($interno){
										$this->MigrarUsuariosInternos($lastid,$row['username_usuario'],$row['password_usuario']);

									}else{
										$this->MigrarPerfiles($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_perfiles
										$this->MigrarDatosEmpresa($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_datos_empresas
										$this->MigrarUsuarios($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_usuarios
										$this->MigrarPersonasInscripcion($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_personas_inscripcion
										$this->MigrarPersonasTelefonos($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_personas_telefonos
									}
									
									$inserts++;
									//INSERT SUCCESS
								}


							}else{ 
							
								$this->ShowError($bd." ERROR EN LA QUERY  insert tb_personas : \n ".$pg_query." \n ".$pg_result['message']);
							}

						}else{ // si EXISTE ENTONCES LO UPDATEA AL  REGISTRO

							$pg_query='UPDATE "masterag"."tb_personas" SET 
							"id_rol"=2, 
							"nombre1"=\''.$primer_nombre.'\', 
							"nombre2"=\''.$segundo_nombre.'\', 
							"apellido1"=\''.$row['apellido1'].'\', 
							"apellido2"=\''.$row['apellido2'].'\', 
							"fecha_nacimiento"=\''.$row['fecha_nacimiento'].'\', 
							"sexo"=\''.$row['sexo'].'\', 
							"curp"=\''.$row['curp'].'\', 
							"id_estado_civil"='.$estadocivil.', 
							"fecha_modificacion"=now(),
							"eliminado"='.$row['eliminado'].'
							WHERE "id"='.$lastid.' ; ';
							
							$pg_result=$this->pg->Query($pg_query);

							if($pg_result['success']){

								if($interno){

									$this->MigrarUsuariosInternosUPDATE($lastid,$row['username_usuario'],$row['password_usuario']);
									$updates++;
								}else{
									$perfil=$this->MigrarPerfilesUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_perfiles
									$empresa=$this->MigrarDatosEmpresaUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_datos_empresas
									$usuario=$this->MigrarUsuariosUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_usuarios
									$inscripcion=$this->MigrarPersonasInscripcionUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_personas_inscripcion
									//$this->MigrarPersonasTelefonos($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_personas_telefonos
									//$this->MigrarPersonasInscripcionUPDATETaxonomia($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //ACTUALIZA ESTATUS DE TAXONOMIA PROSPECTO , PREINSCRITO INSCRITO

									if($perfil && $empresa && $usuario && $inscripcion){
										//UPDATE SUCCESS
										$updates++;
									}else{
										$this->ShowError($bd." ERROR EN EL UPDATE 001 ");
									}

								}

								
							
							}else{
								$this->ShowError($bd." ERROR EN LA QUERY update TB PERSONAS : \n ".$pg_query." \n ".$pg_result['message']);

							}


						}
						$registros++;
					}// final while del select de escolar

				}else{
					//ERROR ENE LA QUERY DE TB PERSONAS
					$this->ShowError($bd." ERROR EN LA QUERY escolar : \n ".$mysql_query." \n ".$mysql_result_escolar['message']);

				}

				
			echo "<center><strong style='color:green;'>MIGRACION ".$bd." TB_PERSONAS DE MASTERAG SATISFACTORIO | INSERTS[".$inserts."] UPDATES[".$updates."]  TOTAL:[".$registros."]</strong></center>";
		}else{
			echo "<center><strong style='color:red;'>MIGRACION ".$bd." TB_PERSONAS DE NO SE PUDO CONECTAR A BASEDEDATOS</strong></center>";
	
		}
		
	}



	function MigrarByPersonaV2($bd='',$corporacion=2,$plan_estudios=2,$fieldid=1,$fieldid_str='alumno',$id_moodle=0,$id_persona=0,$interno=false) 
	{
		$updates=0;
		$inserts=0;
		$registros=0;
		//SI NO ENCUENTRA EL ALUMNO SE INSERTA Y SI YA EXISTE SE ACTUALIZA
	 	$this->id_corporacion=$corporacion;
	 	$this->id_plan_estudio=$plan_estudios;
	 	$fieldid_alumno=$fieldid;
	 	$fieldid_alumno_str=$fieldid_str;

		$mysql_query="SELECT tp.*,m.id as idmoodle,ta.id as id_alumno,m.deleted as eliminado FROM ".$bd.".mdl_user m
		 inner join escolar.tb_alumnos ta on ta.idmoodle=m.id 
		 inner join escolar.tb_personas tp on tp.id=ta.id_persona
		 where 
		  (select mdata.data from ".$bd.".mdl_user_info_data mdata where mdata.fieldid = ".$fieldid_alumno." and mdata.userid = m.id limit 1) = '".$fieldid_alumno_str."'

		 and ta.id_corporacion=".$this->id_corporacion." and ta.id_plan_estudio=".$this->id_plan_estudio." 
		 AND m.id=".$id_moodle."
		 order by tp.id asc";

		if($interno){
			$mysql_query="SELECT tp.*,tu.username as username_usuario, tu.password as password_usuario,0 as idmoodle,0 as id_alumno FROM escolar.tb_usuarios tu INNER JOIN escolar.tb_personas tp on tp.id=tu.id_persona 
				WHERE tp.id=".$id_persona."
				 ";

			$bd="USUARIO INTERNO";
		}
		
		
		if($this->mysql->con){

				$mysql_result_escolar=$this->mysql->Query($mysql_query);
				if($mysql_result_escolar['success']){
					while ($row=mysqli_fetch_assoc($mysql_result_escolar['data'])) {

						
						$estadocivil=7; // REGISTRO DE NO DEFINIDO

						if((int)$row['estadocivil']==0){ // MAPEO DE ESTADO CIVIL ESCOLAR -> MASTERAG
							$estadocivil=7;
						}else if((int)$row['estadocivil']==1) {
							$estadocivil=7;
						}else if((int)$row['estadocivil']==2) {
							$estadocivil=1;
						}else if((int)$row['estadocivil']==3) {
							$estadocivil=3;
						}
						if(!$this->validateDate($row['fecha_nacimiento'], 'Y-m-d')){ 
							// si no tiene fecha de nacimiento o no es valida se le pone una por default
							$row['fecha_nacimiento']="1970-01-01";
						}

						
						
						$primer_nombre=$this->StripPrimerNombre($row['nombre']);
						$segundo_nombre=$this->StripSegundoNombre($row['nombre']);
						

						//QUERY PARA SABER SI YA EXISTE EL ID ANTES DE UPDATEARLO A LA masterag
						$lastid=0; // id_persona NUEVO
						$pg_select_query='SELECT "id_nuevo" FROM "masterag"."tb_ids_escolar" WHERE 

						"tb_ids_escolar"."idmoodle"='.$row['idmoodle'].' AND
						"tb_ids_escolar"."id_persona"='.$row['id'].' AND
						"tb_ids_escolar"."id_alumno"='.$row['id_alumno'].' AND
						"tb_ids_escolar"."id_corporacion"='.$this->id_corporacion.' AND
						"tb_ids_escolar"."id_plan_estudio"='.$this->id_plan_estudio.' 
						 LIMIT 1';
						$pg_result_select=$this->pg->Query($pg_select_query);
						while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
						    foreach ($line as $col_value) {
						        $lastid=$col_value;
						    }
						}

						if($lastid==0 || !is_numeric($lastid)){ // si el id ya no existe en la nueva BASE DE DATOS masterag lo inserta

							//QUERY DE INSERT EN masterag.tb_personas
							$pg_query='INSERT INTO "masterag"."tb_personas" ( "id_rol", "nombre1", "nombre2", "apellido1", "apellido2", "fecha_nacimiento", "sexo", "curp", "id_estado_civil", "fecha_registro", "fecha_modificacion","eliminado") VALUES (2,\''.$primer_nombre.'\',\''.$segundo_nombre.'\',\''.$row['apellido1'].'\',\''.$row['apellido2'].'\',\''.$row['fecha_nacimiento'].'\',\''.$row['sexo'].'\',\''.$row['curp'].'\','.$estadocivil.',\''.$row['fecha_registro'].'\',now(),'.$row['eliminado'].');';
						
							$pg_result=$this->pg->Query($pg_query);

							if($pg_result['success']){

								$lastid=$this->pg->last_insert_table('tb_personas','id');


								$pg_query_ids='INSERT INTO "masterag"."tb_ids_escolar" ("id_nuevo","idmoodle","id_persona","id_alumno","id_corporacion","id_plan_estudio","basededatos") VALUES ('.$lastid.','.$row['idmoodle'].','.$row['id'].','.$row['id_alumno'].','.$this->id_corporacion.','.$this->id_plan_estudio.',\''.$bd.'\'); '; 
								
								$pg_result_ids=$this->pg->Query($pg_query_ids);
								if(!$pg_result_ids['success']){
									//$this->ShowError($bd." ERROR EN LA QUERY tb_ids_escolar: \n ".$pg_query." \n ".$pg_result['message']);
									return false;
								}else{


									if($interno){
										$this->MigrarUsuariosInternos($lastid,$row['username_usuario'],$row['password_usuario']);
									}else{
										$this->MigrarPerfiles($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_perfiles
										$this->MigrarDatosEmpresa($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_datos_empresas
										$this->MigrarUsuarios($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_usuarios
										$this->MigrarPersonasInscripcion($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_personas_inscripcion
										$this->MigrarPersonasTelefonos($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_personas_telefonos
									}
									
									$inserts++;
									//INSERT SUCCESS
									return true;
								}


							}else{ 
								return false;
								//$this->ShowError($bd." ERROR EN LA QUERY  insert tb_personas : \n ".$pg_query." \n ".$pg_result['message']);
							}

						}else{ // si EXISTE ENTONCES LO UPDATEA AL  REGISTRO

							$pg_query='UPDATE "masterag"."tb_personas" SET 
							"id_rol"=2, 
							"nombre1"=\''.$primer_nombre.'\', 
							"nombre2"=\''.$segundo_nombre.'\', 
							"apellido1"=\''.$row['apellido1'].'\', 
							"apellido2"=\''.$row['apellido2'].'\', 
							"fecha_nacimiento"=\''.$row['fecha_nacimiento'].'\', 
							"sexo"=\''.$row['sexo'].'\', 
							"curp"=\''.$row['curp'].'\', 
							"id_estado_civil"='.$estadocivil.', 
							"fecha_modificacion"=now(),
							"eliminado"='.$row['eliminado'].'
							WHERE "id"='.$lastid.' ; ';
							
							$pg_result=$this->pg->Query($pg_query);

							if($pg_result['success']){

								if($interno){

									$this->MigrarUsuariosInternosUPDATE($lastid,$row['username_usuario'],$row['password_usuario']);
									$updates++;
									return true;
								}else{
									$perfil=$this->MigrarPerfilesUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_perfiles
									$empresa=$this->MigrarDatosEmpresaUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_datos_empresas
									$usuario=$this->MigrarUsuariosUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_usuarios
									$inscripcion=$this->MigrarPersonasInscripcionUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_personas_inscripcion
									//$this->MigrarPersonasTelefonos($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_personas_telefonos
									//$this->MigrarPersonasInscripcionUPDATETaxonomia($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //ACTUALIZA ESTATUS DE TAXONOMIA PROSPECTO , PREINSCRITO INSCRITO

									if($perfil && $empresa && $usuario && $inscripcion){
										//UPDATE SUCCESS
										$updates++;
										return true;
									}else{
										return false;
										//$this->ShowError($bd." ERROR EN EL UPDATE 001 ");
									}

								}

								
							
							}else{
								//$this->ShowError($bd." ERROR EN LA QUERY update TB PERSONAS : \n ".$pg_query." \n ".$pg_result['message']);
								return false;
							}


						}
						$registros++;
					}// final while del select de escolar

				}else{
					//ERROR ENE LA QUERY DE TB PERSONAS
					return false;
					//$this->ShowError($bd." ERROR EN LA QUERY escolar : \n ".$mysql_query." \n ".$mysql_result_escolar['message']);

				}

				return true;
				
			//echo "<center><strong style='color:green;'>MIGRACION ".$bd." TB_PERSONAS DE MASTERAG SATISFACTORIO | INSERTS[".$inserts."] UPDATES[".$updates."]  TOTAL:[".$registros."]</strong></center>";
		}else{
			//echo "<center><strong style='color:red;'>MIGRACION ".$bd." TB_PERSONAS DE NO SE PUDO CONECTAR A BASEDEDATOS</strong></center>";
			return false;
		}
		
	}

	/*function MigrarDirecciones($id_nuevo,$id_moodle,$id_persona,$id_alumno)
	{
			$select_tb_personas='SELECT 0;';
			$result_tb_personas=$this->mysql->Query($select_tb_personas);
			while ($row = mysqli_fetch_assoc($result_tb_personas['data'])) {

			}
	}*/


	function MigrarPerfiles($id_nuevo,$id_moodle,$id_persona,$id_alumno) 
	{
			/*MIGRACION PERFILES
				Tabla origen: escolar.tb_personas
							  escolar.tb_a1
				tabla destino: masterag.tb_perfiles
			*/
			$mysql_select_tb_personas='SELECT tp.* FROM escolar.tb_personas tp where tp.id='.$id_persona.' limit 1';
			$mysql_result_tb_personas=$this->mysql->Query($mysql_select_tb_personas);
			$array_tb_personas=array();
			if($mysql_result_tb_personas['success']){
				while ($row = mysqli_fetch_assoc($mysql_result_tb_personas['data'])) {
					$array_tb_personas[]=$row;
				}
			}

			$mysql_select_tb_a1='SELECT a1.* FROM escolar.tb_a1 a1 WHERE a1.idmoodle='.$id_moodle.' and a1.id_plan_estudios='.$this->id_plan_estudio.' and a1.id_corporacion='.$this->id_corporacion.'  limit 1;';
			$array_tb_a1=array();

			$mysql_result_tb_a1=$this->mysql->Query($mysql_select_tb_a1);
			if($mysql_result_tb_a1['success']){
				while ($row = mysqli_fetch_assoc($mysql_result_tb_a1['data'])) {
					$array_tb_a1[]=$row;
				}				
			}


			$facebook="";
			$email="";
			$acceso_internet='false';

			if(count($array_tb_personas)>0 ){

			//	if($array_tb_personas[0]['fb'] != null  && $array_tb_personas[0]['fb']!=""){
					$facebook=$array_tb_a1[0]['facebook'];
				//}

			//	if($array_tb_personas[0]['email'] != null  && $array_tb_personas[0]['email']!=""){
					$email=$array_tb_personas[0]['email'];
			//	}
					if($array_tb_a1[0]['acceso_internet']=="Si"){
						$acceso_internet='true';
					}else{
						$acceso_internet='false';
					}

			}else if(count($array_tb_a1)>0) {

				//if($array_tb_a1[0]['facebook'] != null  && $array_tb_a1[0]['facebook']!=""){
					$facebook=$array_tb_a1[0]['facebook'];
				//}

				//if($array_tb_a1[0]['email'] != null  && $array_tb_a1[0]['email']!=""){
					$email=$array_tb_a1[0]['email'];
				//}

				//if($array_tb_a1[0]['acceso_internet'] != null && $array_tb_a1[0]['acceso_internet']!=""){

					if($array_tb_a1[0]['acceso_internet']=="Si"){
						$acceso_internet='true';
					}else{
						$acceso_internet='false';
					}
				//}
			}

			$facebook=str_replace("'", "", $facebook);

			$pg_query_ins='INSERT INTO "masterag"."tb_perfiles" ("id_persona", "facebook", "email", "acceso_internet", "hijos", "hobbies", "fecha_registro") VALUES ( '.$id_nuevo.', \''.$facebook.'\',  \''.$email.'\', '.$acceso_internet.', 0, \'\', now());';

			$pg_result=$this->pg->Query($pg_query_ins);
			if(!$pg_result['success'])
			{
				$this->ShowError("ERROR EN MigrarPerfiles: ".$pg_result['message']);
			}

	}


	function MigrarPerfilesUPDATE($id_nuevo,$id_moodle,$id_persona,$id_alumno) 
	{
			/*MIGRACION PERFILES
				Tabla origen: escolar.tb_personas
							  escolar.tb_a1
				tabla destino: masterag.tb_perfiles
			*/
			$mysql_select_tb_personas='SELECT tp.* FROM escolar.tb_personas tp where tp.id='.$id_persona.' limit 1';
			$mysql_result_tb_personas=$this->mysql->Query($mysql_select_tb_personas);
			$array_tb_personas=array();
			if($mysql_result_tb_personas['success']){
				while ($row = mysqli_fetch_assoc($mysql_result_tb_personas['data'])) {
					$array_tb_personas[]=$row;
				}
			}

			$mysql_select_tb_a1='SELECT a1.* FROM escolar.tb_a1 a1 WHERE a1.idmoodle='.$id_moodle.' and a1.id_plan_estudios='.$this->id_plan_estudio.' and a1.id_corporacion='.$this->id_corporacion.'  limit 1;';
			$array_tb_a1=array();

			$mysql_result_tb_a1=$this->mysql->Query($mysql_select_tb_a1);
			if($mysql_result_tb_a1['success']){
				while ($row = mysqli_fetch_assoc($mysql_result_tb_a1['data'])) {
					$array_tb_a1[]=$row;
				}				
			}


			$facebook="";
			$email="";
			$acceso_internet='false';

			if(count($array_tb_personas)>0 ){

			//	if($array_tb_personas[0]['fb'] != null  && $array_tb_personas[0]['fb']!=""){
					$facebook=$array_tb_a1[0]['facebook'];
				//}

			//	if($array_tb_personas[0]['email'] != null  && $array_tb_personas[0]['email']!=""){
					$email=$array_tb_personas[0]['email'];
			//	}
					if($array_tb_a1[0]['acceso_internet']=="Si"){
						$acceso_internet='true';
					}else{
						$acceso_internet='false';
					}

			}else if(count($array_tb_a1)>0) {

				//if($array_tb_a1[0]['facebook'] != null  && $array_tb_a1[0]['facebook']!=""){
					$facebook=$array_tb_a1[0]['facebook'];
				//}

				//if($array_tb_a1[0]['email'] != null  && $array_tb_a1[0]['email']!=""){
					$email=$array_tb_a1[0]['email'];
				//}

				//if($array_tb_a1[0]['acceso_internet'] != null && $array_tb_a1[0]['acceso_internet']!=""){

					if($array_tb_a1[0]['acceso_internet']=="Si"){
						$acceso_internet='true';
					}else{
						$acceso_internet='false';
					}
				//}
			}

			$facebook=str_replace("'", "", $facebook);

			$pg_query_UPDATE='UPDATE "masterag"."tb_perfiles" SET "facebook"= \''.$facebook.'\', "email"=\''.$email.'\', "acceso_internet"='.$acceso_internet.', "hijos"=0, "hobbies"=\'\', "fecha_modificacion"=now() WHERE "id_persona"='.$id_nuevo.' ;';

			$pg_result=$this->pg->Query($pg_query_UPDATE);
			if(!$pg_result['success'])
			{
				return false;
			}else{
				return true;
			}

	}

	function MigrarDatosEmpresa($id_nuevo,$id_moodle,$id_persona,$id_alumno)
	{
		/*
			tabla origen: escolar.tb_personas, escolar.tb_alumnos
			tabla destino: masterag.tb_datos empresas
			datos faltantes: id_gerente,id_delegacion,id_departamento
		*/

		$mysql_select_tb_personas='SELECT tp.* FROM escolar.tb_personas tp where tp.id='.$id_persona.' limit 1';
		$mysql_result_tb_personas=$this->mysql->Query($mysql_select_tb_personas);
		$array_tb_personas=array();
		if($mysql_result_tb_personas['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_personas['data'])) {
				$array_tb_personas[]=$row;
			}
		}

		$mysql_select_tb_alumnos='SELECT ta.* FROM escolar.tb_alumnos ta where ta.id='.$id_alumno.' limit 1';
		$mysql_result_tb_alumnos=$this->mysql->Query($mysql_select_tb_alumnos);
		$array_tb_alumnos=array();
		if($mysql_result_tb_alumnos['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_alumnos['data'])) {
				$array_tb_alumnos[]=$row;
			}
		}
		
		$id_region=186;
		if($array_tb_personas[0]["region"]==null || $array_tb_personas[0]["region"]==0 || $array_tb_personas[0]["region"]==""){
			$id_region=186;
		}else{
			$id_region=$array_tb_personas[0]["region"];
		}


		$ref_bancaria=$this->get_referencia_bancaria($array_tb_alumnos[0]['numero_empleado']);

		$pg_query_ins='INSERT INTO "masterag"."tb_datos_empresas" ("id_persona", "id_empresa", "numero_empleado", "id_puesto","id_sucursal", "fecha_registro","referencia_bancaria","id_region") VALUES ( '.$id_nuevo.', '.$this->id_corporacion.',  \''.$array_tb_alumnos[0]['numero_empleado'].'\', '.$array_tb_personas[0]["puesto"].', '.$array_tb_personas[0]['sucursal'].', now(),\''.$ref_bancaria.'\','.$id_region.');';

		$pg_result=$this->pg->Query($pg_query_ins);
		if(!$pg_result['success'])
		{
			$this->ShowError("ERROR EN Migrar Datos Empresa: ".$pg_result['message']);
		}

	}

	function MigrarDatosEmpresaUPDATE($id_nuevo,$id_moodle,$id_persona,$id_alumno)
	{
		/*
			tabla origen: escolar.tb_personas, escolar.tb_alumnos
			tabla destino: masterag.tb_datos empresas
			datos faltantes: id_gerente,id_delegacion,id_departamento
		*/

		$mysql_select_tb_personas='SELECT tp.* FROM escolar.tb_personas tp where tp.id='.$id_persona.' limit 1';
		$mysql_result_tb_personas=$this->mysql->Query($mysql_select_tb_personas);
		$array_tb_personas=array();
		if($mysql_result_tb_personas['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_personas['data'])) {
				$array_tb_personas[]=$row;
			}
		}

		$mysql_select_tb_alumnos='SELECT ta.* FROM escolar.tb_alumnos ta where ta.id='.$id_alumno.' limit 1';
		$mysql_result_tb_alumnos=$this->mysql->Query($mysql_select_tb_alumnos);
		$array_tb_alumnos=array();
		if($mysql_result_tb_alumnos['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_alumnos['data'])) {
				$array_tb_alumnos[]=$row;
			}
		}
		
		$id_region=186;
		if($array_tb_personas[0]["region"]==null || $array_tb_personas[0]["region"]==0 || $array_tb_personas[0]["region"]==""){
			$id_region=186;
		}else{
			$id_region=$array_tb_personas[0]["region"];
		}


		$ref_bancaria=$this->get_referencia_bancaria($array_tb_alumnos[0]['numero_empleado']);

		$pg_query_UPDATE='UPDATE "masterag"."tb_datos_empresas" SET  "numero_empleado"= \''.$array_tb_alumnos[0]['numero_empleado'].'\', "id_puesto"='.$array_tb_personas[0]["puesto"].',"id_sucursal"='.$array_tb_personas[0]['sucursal'].',"fecha_modificacion"=now(),"referencia_bancaria"=\''.$ref_bancaria.'\',"id_region"='.$id_region.' WHERE "id_persona"='.$id_nuevo.'; ';

		$pg_result=$this->pg->Query($pg_query_UPDATE);
		if(!$pg_result['success'])
		{
			return false;
		}else{
			return true;
		}

	}

	function MigrarPersonasPermisos($id_nuevo,$id_moodle,$id_persona,$id_alumno)
	{
		/*
			tabla origen: NINGUNA
			tabla destino: masterag.tb_permisos_personas 
			
		*/

		$pg_query_ins='INSERT INTO "masterag"."tb_permisos_personas" ("id_persona", "id_permiso","fecha_registro") VALUES ( '.$id_nuevo.',1, now());';

		$pg_result=$this->pg->Query($pg_query_ins);
		if(!$pg_result['success'])
		{
			$this->ShowError("ERROR EN MigrarPersonasPermisos: ".$pg_result['message']);
		}
	}

	function MigrarUsuariosInternos($id_nuevo,$username,$password)
	{
		/*
			tabla origen: bd vieja escolar.tb_usuarios y tb_personas
			tabla destino: masterag.tb_usuarios 
			
		*/
	
		$pg_query_ins='INSERT INTO "masterag"."tb_usuarios" ("id_persona", "usuario","contrasena","fecha_registro","id_plan_estudios" ) VALUES ( '.$id_nuevo.',\''.$username.'\',\''.$password.'\', now(),1);';

		$pg_result=$this->pg->Query($pg_query_ins);
		if(!$pg_result['success'])
		{
			$this->ShowError("ERROR EN MigrarUsuariosInternos: ".$pg_result['message']);
		}

	}



	function MigrarUsuariosInternosUPDATE($id_nuevo,$username,$password)
	{
		/*
			tabla origen: bd vieja escolar.tb_usuarios y tb_personas
			tabla destino: masterag.tb_usuarios 
			
		*/
	
		$pg_query_UPDATE='UPDATE "masterag"."tb_usuarios" SET "usuario"=\''.$username.'\',"contrasena"=\''.$password.'\',"fecha_modificacion"=now() WHERE "id_persona"='.$id_nuevo.' ';

		$pg_result=$this->pg->Query($pg_query_UPDATE);
		if(!$pg_result['success'])
		{
			$this->ShowError("ERROR EN MigrarUsuariosInternosUPDATE: ".$pg_result['message']);
		}


	}

	function MigrarUsuarios($id_nuevo,$id_moodle,$id_persona,$id_alumno,$bd)
	{
		/*
			tabla origen: plataforma_moodle.mdl_user
			tabla destino: masterag.tb_usuarios 
			
		*/
		$mysql_select_mdl_user='SELECT m.* FROM '.$bd.'.mdl_user m where m.id='.$id_moodle.' limit 1';
		$mysql_result_mdl_user=$this->mysql->Query($mysql_select_mdl_user);
		$array_mdl_user=array();
		if($mysql_result_mdl_user['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_mdl_user['data'])) {
				$array_mdl_user=$row;
			}
		}

		$pg_query_ins='INSERT INTO "masterag"."tb_usuarios" ("id_persona", "usuario","contrasena","fecha_registro","id_plan_estudios" ) VALUES ( '.$id_nuevo.',\''.$array_mdl_user['username'].'\',\''.$array_mdl_user['password'].'\', now(),'.$this->id_plan_estudio.');';

		$pg_result=$this->pg->Query($pg_query_ins);
		if(!$pg_result['success'])
		{
			$this->ShowError("ERROR EN MigrarUsuarios: ".$pg_result['message']);
		}

	}

	function MigrarUsuariosUPDATE($id_nuevo,$id_moodle,$id_persona,$id_alumno,$bd)
	{
		/*
			tabla origen: plataforma_moodle.mdl_user
			tabla destino: masterag.tb_usuarios 
			
		*/
		$mysql_select_mdl_user='SELECT m.* FROM '.$bd.'.mdl_user m where m.id='.$id_moodle.' limit 1';
		$mysql_result_mdl_user=$this->mysql->Query($mysql_select_mdl_user);
		$array_mdl_user=array();
		if($mysql_result_mdl_user['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_mdl_user['data'])) {
				$array_mdl_user=$row;
			}
		}

		$pg_query_ins='UPDATE "masterag"."tb_usuarios" SET "usuario"=\''.$array_mdl_user['username'].'\',"contrasena"=\''.$array_mdl_user['password'].'\',"fecha_modificacion"=now() WHERE "id_persona"='.$id_nuevo.' ; ';

		$pg_result=$this->pg->Query($pg_query_ins);
		if(!$pg_result['success'])
		{
			return false;
		}else{
			return true;
		}

	}


	function MigrarPersonasTelefonos($id_nuevo,$id_moodle,$id_persona,$id_alumno,$bd)
	{
		/*
			tabla origen: escolar.tb_personas,escolar.tb_telefonos,escolar.tb_numero_telefonicos, escolar.tb_a1
			tabla destino: masterag.tb_personas_telefonos 
		*/

		$mysql_select_tb_personas='SELECT tp.* FROM escolar.tb_personas tp where tp.id='.$id_persona.' limit 1';
		$mysql_result_tb_personas=$this->mysql->Query($mysql_select_tb_personas);
		$array_tb_personas=array();
		if($mysql_result_tb_personas['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_personas['data'])) {
					/*tel 1*/
					$existe_id=0;
					$pg_select_query='SELECT COUNT("id") FROM "masterag"."tb_personas_telefonos" WHERE "tb_personas_telefonos"."id_persona"='.$id_nuevo.' and "tb_personas_telefonos"."numero"=\''.$row['tel1'].'\' LIMIT 10';
					$pg_result_select=$this->pg->Query($pg_select_query);
					while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
					    foreach ($line as $col_value) {
					        $existe_id=$col_value;
					    }
					}
					if($existe_id==0 && ($row['tel1'] != "" && $row['tel1']!=null)){
						$pg_query_ins='INSERT INTO "masterag"."tb_personas_telefonos" ("id_persona", "numero","fecha_registro" ) VALUES ( '.$id_nuevo.',\''.$row['tel1'].'\', now());';

						$pg_result=$this->pg->Query($pg_query_ins);
						if(!$pg_result['success'])
						{
							$this->ShowError("ERROR EN MigrarPersonasTelefonos tb_personas: ".$pg_result['message']);
						}
					}

					/*tel 2*/
					$existe_id=0;
					$pg_select_query='SELECT COUNT("id") FROM "masterag"."tb_personas_telefonos" WHERE "tb_personas_telefonos"."id_persona"='.$id_nuevo.' and "tb_personas_telefonos"."numero"=\''.$row['tel2'].'\' LIMIT 10';
					$pg_result_select=$this->pg->Query($pg_select_query);
					while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
					    foreach ($line as $col_value) {
					        $existe_id=$col_value;
					    }
					}
					if($existe_id==0 && ($row['tel2'] != "" && $row['tel2']!=null)){
						$pg_query_ins='INSERT INTO "masterag"."tb_personas_telefonos" ("id_persona", "numero","fecha_registro" ) VALUES ( '.$id_nuevo.',\''.$row['tel2'].'\', now());';

						$pg_result=$this->pg->Query($pg_query_ins);
						if(!$pg_result['success'])
						{
							$this->ShowError("ERROR EN MigrarPersonasTelefonos tb_personas: ".$pg_result['message']);
						}
					}

					/*tel 3*/
					$existe_id=0;
					$pg_select_query='SELECT COUNT("id") FROM "masterag"."tb_personas_telefonos" WHERE "tb_personas_telefonos"."id_persona"='.$id_nuevo.' and "tb_personas_telefonos"."numero"=\''.$row['tel3'].'\' LIMIT 10';
					$pg_result_select=$this->pg->Query($pg_select_query);
					while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
					    foreach ($line as $col_value) {
					        $existe_id=$col_value;
					    }
					}
					if($existe_id==0 && ($row['tel3'] != "" && $row['tel3']!=null)){
						$pg_query_ins='INSERT INTO "masterag"."tb_personas_telefonos" ("id_persona", "numero","fecha_registro" ) VALUES ( '.$id_nuevo.',\''.$row['tel3'].'\', now());';

						$pg_result=$this->pg->Query($pg_query_ins);
						if(!$pg_result['success'])
						{
							$this->ShowError("ERROR EN MigrarPersonasTelefonos tb_personas: ".$pg_result['message']);
						}
					}
			}
		}

		/* TB_A1 */
		$mysql_select_tb_a1='SELECT a1.* FROM escolar.tb_a1 a1 where a1.id='.$id_persona.' limit 1';
		$mysql_result_tb_a1=$this->mysql->Query($mysql_select_tb_a1);
		$array_tb_a1=array();
		if($mysql_result_tb_a1['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_a1['data'])) {

					/*TELEFONO 1*/
					$existe_id=0;
					$pg_select_query='SELECT COUNT("id") FROM "masterag"."tb_personas_telefonos" WHERE "tb_personas_telefonos"."id_persona"='.$id_nuevo.' and "tb_personas_telefonos"."numero"=\''.$row['telefono1'].'\' LIMIT 10';
					$pg_result_select=$this->pg->Query($pg_select_query);
					while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
					    foreach ($line as $col_value) {
					        $existe_id=$col_value;
					    }
					}
					if($existe_id==0 && ($row['telefono1'] != "" && $row['telefono1']!=null)){
						$pg_query_ins='INSERT INTO "masterag"."tb_personas_telefonos" ("id_persona", "numero","fecha_registro" ) VALUES ( '.$id_nuevo.',\''.$row['telefono1'].'\', now());';

						$pg_result=$this->pg->Query($pg_query_ins);
						if(!$pg_result['success'])
						{
							$this->ShowError("ERROR EN MigrarPersonasTelefonos tb_a1: ".$pg_result['message']);
						}
					}

					/*TELEFONO 2*/
					$existe_id=0;
					$pg_select_query='SELECT COUNT("id") FROM "masterag"."tb_personas_telefonos" WHERE "tb_personas_telefonos"."id_persona"='.$id_nuevo.' and "tb_personas_telefonos"."numero"=\''.$row['telefono2'].'\' LIMIT 10';
					$pg_result_select=$this->pg->Query($pg_select_query);
					while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
					    foreach ($line as $col_value) {
					        $existe_id=$col_value;
					    }
					}
					if($existe_id==0 && ($row['telefono2'] != "" && $row['telefono2']!=null)){
						$pg_query_ins='INSERT INTO "masterag"."tb_personas_telefonos" ("id_persona", "numero","fecha_registro" ) VALUES ( '.$id_nuevo.',\''.$row['telefono2'].'\', now());';

						$pg_result=$this->pg->Query($pg_query_ins);
						if(!$pg_result['success'])
						{
							$this->ShowError("ERROR EN MigrarPersonasTelefonos tb_a1: ".$pg_result['message']);
						}
					}

					/*TELEFONO 3*/
					$existe_id=0;
					$pg_select_query='SELECT COUNT("id") FROM "masterag"."tb_personas_telefonos" WHERE "tb_personas_telefonos"."id_persona"='.$id_nuevo.' and "tb_personas_telefonos"."numero"=\''.$row['telefono3'].'\' LIMIT 10';
					$pg_result_select=$this->pg->Query($pg_select_query);
					while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
					    foreach ($line as $col_value) {
					        $existe_id=$col_value;
					    }
					}
					if($existe_id==0 && ($row['telefono3'] != "" && $row['telefono3']!=null)){
						$pg_query_ins='INSERT INTO "masterag"."tb_personas_telefonos" ("id_persona", "numero","fecha_registro" ) VALUES ( '.$id_nuevo.',\''.$row['telefono3'].'\', now());';

						$pg_result=$this->pg->Query($pg_query_ins);
						if(!$pg_result['success'])
						{
							$this->ShowError("ERROR EN MigrarPersonasTelefonos tb_a1: ".$pg_result['message']);
						}
					}

			}
		}

		/*TB NUMEROS TELEFONICOS*/
		$mysql_select_tb_numero_tel='SELECT tp.*,tu.id_persona as asesor FROM escolar.tb_numero_telefonicos tp 
		inner join escolar.tb_usuarios tu on tu.id=tp.id_asesor where tp.id_alumno='.$id_alumno.' limit 1';
		$mysql_result_tb_numero_tel=$this->mysql->Query($mysql_select_tb_numero_tel);
		
		
		if($mysql_result_tb_numero_tel['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_numero_tel['data'])) {

				$numeros_telefonicos=$this->StripNumeric($row['numero_telefonico']);
				foreach ($numeros_telefonicos as $key => $telefono) {
					
					$existe_id=0;
					$pg_select_query='SELECT COUNT("id") FROM "masterag"."tb_personas_telefonos" WHERE "tb_personas_telefonos"."id_persona"='.$id_nuevo.' and "tb_personas_telefonos"."numero"=\''.$telefono.'\' LIMIT 10';
					$pg_result_select=$this->pg->Query($pg_select_query);
					while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
					    foreach ($line as $col_value) {
					        $existe_id=$col_value;
					    }
					}

					if($existe_id==0 && ( $telefono != "" &&  $telefono!=null)){
						$pg_query_ins='INSERT INTO "masterag"."tb_personas_telefonos" ("id_persona", "numero","fecha_registro" ,"id_persona_registra") VALUES ( '.$id_nuevo.',\''. $telefono.'\', now(),'.$row['asesor'].');';

						$pg_result=$this->pg->Query($pg_query_ins);
						if(!$pg_result['success'])
						{
							$this->ShowError("ERROR EN MigrarPersonasTelefonos tb_numero_telefonicos: ".$pg_result['message']);
						}
					}
				}

			}
		}

	}


	function MigrarPersonasInscripcion($id_nuevo,$id_moodle,$id_persona,$id_alumno)
	{

		/*
			tabla origen: NINGUNA
			tabla destino: masterag.tb_personas_inscripcion 
		*/

		$mysql_select_tb_induccion='SELECT tc.* FROM escolar.tb_cursos_induccion tc where tc.id_alumno='.$id_alumno.' limit 1';
		$mysql_result_tb_induccion=$this->mysql->Query($mysql_select_tb_induccion);
		$array_tb_induccion=array();
		$array_tb_induccion['id_tipo']=0;
		$array_tb_induccion['estatus']=0;
		if($mysql_result_tb_induccion['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_induccion['data'])) {
				$array_tb_induccion=$row;
			}
		}

		$mysql_select_tb_alumnos='SELECT ta.* FROM escolar.tb_alumnos ta where ta.id='.$id_alumno.' limit 1';
		$mysql_result_tb_alumnos=$this->mysql->Query($mysql_select_tb_alumnos);
		$array_tb_alumnos=array();
		if($mysql_result_tb_alumnos['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_alumnos['data'])) {
				$array_tb_alumnos=$row;
			}
		}

		$estatus_academico=1;
		$estatus_desercion=7;
		$desercion_motivo=46;

		if($this->id_plan_estudio==9 || $this->id_plan_estudio==10){
			if($array_tb_alumnos['documentacion_estatus']==1){ //INSCRITOS
				$estatus_academico=2;
			}else if($array_tb_alumnos['documentacion_estatus']==2) { // PREINSCRITOS
				$estatus_academico=3;
			}else if($array_tb_alumnos['documentacion_estatus']==3){ //SIN DOCUMENTACION
				$estatus_academico=4;
			}else{
				$estatus_academico=1;
			}
		}else{
			$estatus_academico=2; //PONE A TODOS COMO INSCRITOS

		}
		
		if($array_tb_alumnos['estado']==2){ // baja del empresa
			$estatus_desercion=2;
			$desercion_motivo=20;

		}

		if($array_tb_alumnos['estado']==3){ // baja del programa
			$estatus_desercion=4;
			$desercion_motivo=19;
		}


		if($array_tb_alumnos['estado']==4){ // suspendido por documentos
			$estatus_desercion=6;
			$desercion_motivo=47;
		}

		if($array_tb_alumnos['estado']==5){ // suspendido por inactividad
			$estatus_desercion=6;
			$desercion_motivo=48;

		}

		if($array_tb_alumnos['estado']==6){ //suspendido por tiempo
			$estatus_desercion=6;
			$desercion_motivo=49;
		}


		if($array_tb_alumnos['estado']==9){ //suspendido por pago
			$estatus_desercion=6;
			$desercion_motivo=50;
		}

		if($array_tb_alumnos['estado']==8){ //EGRESADO
			$estatus_academico=5;
		}

		if($array_tb_alumnos['estado']==7 || $array_tb_alumnos['estado']==12){ //FUTURA BAJA EMPRESA
			$estatus_desercion=6;
			$desercion_motivo=30;
		}


		if($array_tb_alumnos['estado']==10){ //no inscrito 
			$estatus_desercion=1;
			$desercion_motivo=10;
		}

		if($array_tb_alumnos['estado']==11){ //no elegible 
			$estatus_desercion=5;
			$desercion_motivo=45;
		}

		$pg_query_ins='INSERT INTO "masterag"."tb_personas_inscripcion" ( "id_persona", "id_plan_estudio", "id_estado_academico", "id_desercion", "id_motivo_desercion", "id_estatus_curso", "id_tipo_induccion", "fecha_registro") VALUES ( '.$id_nuevo.', '.$this->id_plan_estudio.', '.$estatus_academico.', '.$estatus_desercion.', '.$desercion_motivo.', '.$array_tb_induccion['estatus'].','.$array_tb_induccion['id_tipo'].', now() );';

		$pg_result=$this->pg->Query($pg_query_ins);
		if(!$pg_result['success'])
		{
			$this->ShowError("ERROR EN MigrarPersonasInscripcion: ".$pg_result['message']);
		}

	}

	function MigrarPersonasInscripcionUPDATE($id_nuevo,$id_moodle,$id_persona,$id_alumno)
	{

		/*
			tabla origen: NINGUNA
			tabla destino: masterag.tb_personas_inscripcion 
		*/

		$mysql_select_tb_induccion='SELECT tc.* FROM escolar.tb_cursos_induccion tc where tc.id_alumno='.$id_alumno.' limit 1';
		$mysql_result_tb_induccion=$this->mysql->Query($mysql_select_tb_induccion);
		$array_tb_induccion=array();
		$array_tb_induccion['id_tipo']=0;
		$array_tb_induccion['estatus']=0;
		if($mysql_result_tb_induccion['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_induccion['data'])) {
				$array_tb_induccion=$row;
			}
		}

		$mysql_select_tb_alumnos='SELECT ta.* FROM escolar.tb_alumnos ta where ta.id='.$id_alumno.' limit 1';
		$mysql_result_tb_alumnos=$this->mysql->Query($mysql_select_tb_alumnos);
		$array_tb_alumnos=array();
		if($mysql_result_tb_alumnos['success']){
			while ($row = mysqli_fetch_assoc($mysql_result_tb_alumnos['data'])) {
				$array_tb_alumnos=$row;
			}
		}

		$estatus_academico=1;
		$estatus_desercion=7;
		$desercion_motivo=46;

		if($this->id_plan_estudio==9 || $this->id_plan_estudio==10){
			if($array_tb_alumnos['documentacion_estatus']==1){ //INSCRITOS
				$estatus_academico=2;
			}else if($array_tb_alumnos['documentacion_estatus']==2) { // PREINSCRITOS
				$estatus_academico=3;
			}else if($array_tb_alumnos['documentacion_estatus']==3){ //SIN DOCUMENTACION
				$estatus_academico=4;
			}else{
				$estatus_academico=1;
			}
		}else{
			$estatus_academico=2; //PONE A TODOS COMO INSCRITOS

		}
		
		if($array_tb_alumnos['estado']==2){ // baja del empresa
			$estatus_desercion=2;
			$desercion_motivo=20;

		}

		if($array_tb_alumnos['estado']==3){ // baja del programa
			$estatus_desercion=4;
			$desercion_motivo=19;
		}


		if($array_tb_alumnos['estado']==4){ // suspendido por documentos
			$estatus_desercion=6;
			$desercion_motivo=47;
		}

		if($array_tb_alumnos['estado']==5){ // suspendido por inactividad
			$estatus_desercion=6;
			$desercion_motivo=48;

		}

		if($array_tb_alumnos['estado']==6){ //suspendido por tiempo
			$estatus_desercion=6;
			$desercion_motivo=49;
		}


		if($array_tb_alumnos['estado']==9){ //suspendido por pago
			$estatus_desercion=6;
			$desercion_motivo=50;
		}

		if($array_tb_alumnos['estado']==8){ //EGRESADO
			$estatus_academico=5;
		}

		if($array_tb_alumnos['estado']==7 || $array_tb_alumnos['estado']==12){ //FUTURA BAJA EMPRESA
			$estatus_desercion=6;
			$desercion_motivo=30;
		}


		if($array_tb_alumnos['estado']==10){ //no inscrito 
			$estatus_desercion=1;
			$desercion_motivo=10;
		}

		if($array_tb_alumnos['estado']==11){ //no elegible 
			$estatus_desercion=5;
			$desercion_motivo=45;
		}

		$pg_query_ins='UPDATE "masterag"."tb_personas_inscripcion" SET "id_plan_estudio"='.$this->id_plan_estudio.', "id_estado_academico"='.$estatus_academico.', "id_desercion"='.$estatus_desercion.', "id_motivo_desercion"='.$desercion_motivo.', "id_estatus_curso"='.$array_tb_induccion['estatus'].', "id_tipo_induccion"='.$array_tb_induccion['id_tipo'].', "fecha_modificacion"=now() WHERE "id_persona"='.$id_nuevo.' ; ';

		$pg_result=$this->pg->Query($pg_query_ins);
		if(!$pg_result['success'])
		{
			return false;
		}else{

			return true;
		}

	}

/*	function MigrarPersonasInscripcionUPDATETaxonomia($id_nuevo,$id_moodle,$id_persona,$id_alumno)
	{
		$documentacion="SINREGISTRO";
		$pg_documentacion='SELECT "documentacion" from "masterag"."excel_documentacion" where "id_moodle"='.$id_moodle.' AND "id_plan_estudios"='.$this->id_plan_estudio.' LIMIT 1;';
		$pg_result_docu=$this->pg->Query($pg_documentacion);
		if($pg_result_docu['success'])
		{
			while ($row = pg_fetch_array($pg_result_docu['data'], null, PGSQL_ASSOC)) 
			{
			    foreach ($row as $col) 
			    {
			        $documentacion=$col;
			    }
			}
		}

		$id_estado_academico=1;

		$documentacion= trim(strtoupper($documentacion));

		if($documentacion == "COMPLETO")
		{
			$id_estado_academico=2; //INSCRITO

		}
		else if(
			$documentacion=="TRAE ACTA DE OTRA PERSONA" 
			|| $documentacion=="INCOMPLETO (CERT.SEC CON FOTOGRAFIA DUDOSA" 
			|| $documentacion=="INCOMPLETO" 
			|| $documentacion=="INCOMPLETO/ SIN ACTA DE NAC"  
			|| $documentacion=="INCOMPLETO INSCRITO PERO NO LLEGÓ NINGUN DOCUMENTO" 
			|| $documentacion=="CONSULTAR"
			 )
		{
			$id_estado_academico=3; 
		}else if(
			$documentacion=="S/DOCUMENTOS" 
			|| $documentacion=="SIN DOCUMENTOS" 
			|| $documentacion=="" 
			)
		{
			$id_estado_academico=4; 

		}else if ($documentacion=="SINREGISTRO") {
			$id_estado_academico=1; 
		}

		$pg_query_update='UPDATE "masterag"."tb_personas_inscripcion" SET "id_estado_academico"='.$id_estado_academico.' WHERE "id_persona"='.$id_nuevo.' ' ; 

		$pg_result=$this->pg->Query($pg_query_update);
		if(!$pg_result['success'])
		{
			$this->ShowError("ERROR EN MigrarPersonasInscripcionUPDATETaxonomia: ".$pg_result['message']);
		}	
	}
*/

	function StripNumeric($str){
		

		$str_nospace=str_replace( array(' ') ,'',$str); // quita espacios

		preg_match_all('!\d+!', $str, $matches); // saca los numeros de el string y los pone en un array dentro de otro array

		$array_telefonos=$matches[0];

		/*$array_telefonos_fix=array();

		for ($i=0;$i<count($array_telefonos);$i++;) {


			if($i>0){ // segunda itereacion en adelante

				 if($array_telefonos[$i]>=6){ // si tiene mas de 6 numeros es valido
				 		$array_telefonos_fix[$i]=$array_telefonos[$i];
				 }else{ // es una extencion de pocos numeros


				 	if($array_telefonos[$i-1]>=6){
				 		$array_telefonos_fix[$i-1].=$array_telefonos[$i];
				 	}else{
				 		$array_telefonos_fix[$i-1].=$array_telefonos[$i];

				 	}
				 }

			}else{ // primera iteracion
				 
				 $array_telefonos_fix[$i]=$array_telefonos[$i];

			}
			 
		}*/
		return $array_telefonos;

	}

	function StripSegundoNombre($str){

		$pos=strpos($str, ' ');

		if($pos===false){ // no encuentra 
			return '';
		}else{
			$str=substr($str, $pos);
			return $str;
		}
			
	}


	function StripPrimerNombre($str){

		$pos=strpos($str, ' ');

		if($pos===false){ // no encuentra 
			return $str;
		}else{
			$str=substr($str,0,$pos);
			return $str;
		}
			
	}

	function get_referencia_bancaria($numero){
        #echo $numero."<br>";
        $numero = str_split(trim(strval($numero)));
        $numero_caracteres_referencia = count($numero);
        $vuelta = 0;
        #echo "NUMERO DE CARACTERES DE LA CADENA: ".$numero_caracteres_referencia."<br>";
        if ($numero_caracteres_referencia%2 == 0){
            $vuelta = 1;
            #echo "LA REFERENCIA ES PAR<br>";
        }
        else{
            $vuelta = 2;
            #echo "LA REFERENCIA ES IMPAR<br>";
        }
        #se multiplican los caracteres ya sea el calo por 1 o por 2
        $arreglo_1 = array();
        for($i = 0; $i < $numero_caracteres_referencia; $i++){
            if($vuelta == 1){
                $arreglo_1[$i] = $numero[$i] * 1;
                #echo $numero[$i]." x 1 = ".$arreglo_1[$i]."<br>";
                $vuelta = 2;
            }
            else{
                $arreglo_1[$i] = $numero[$i] * 2;
                #echo $numero[$i]." x 2 = ".$arreglo_1[$i]."<br>";
                $vuelta = 1;
            }
        }
        #se suman los caracteres individuales del resultado de la multiplicacion
        #si un numero tiene dos digitos, estos se suman
        #echo "SUMA DE DIGITOS INDIVIDUALES:<br>";
        $arreglo_2 = array();
        for($k = 0; $k < $numero_caracteres_referencia; $k++){
            $digitos = str_split(trim($arreglo_1[$k].""));
            $arreglo_2[$k] = 0;
            for($kk = 0; $kk < count($digitos); $kk++){
                $arreglo_2[$k] += $digitos[$kk];
            }
            #echo $arreglo_2[$k]."<br>";
        }

        $sumatoria = 0;
        for($j = 0; $j < $numero_caracteres_referencia; $j++){
            $sumatoria += $arreglo_2[$j];
        }
        #echo "SUMATORIA DE LOS NUMERO INDIVIDUALES: ".$sumatoria."<br>";
        $residuo = $sumatoria%10;
        #echo "RESIDUO / 10: ".$residuo."<br>";
        #echo "RESIDUO: ".$residuo."<br>";
        if($residuo != 0){
            $residuo = (10-$residuo);
        }
        #echo "REFERENCIA BANCARIA: ".$residuo."<br>";
        return $residuo;
    }

	function TruncateTable($tabla,$columna_id)
	{
		//QUERY PARA SABER SI YA EXISTE EL ID ANTES DE MIGRARLO A LA masterag
		$truncate_id="";
		$pg_truncate_id="select pg_get_serial_sequence('".$tabla."', '".$columna_id."');";
		$pg_result_truncate=$this->pg->Query($pg_truncate_id);
		if($pg_result_truncate['success'])
		{
			while ($line2 = pg_fetch_array($pg_result_truncate['data'], null, PGSQL_ASSOC)) 
			{
			    foreach ($line2 as $col_value2) 
			    {
			        $truncate_id=$col_value2;
			    }
			}
		}

		/* == Borra toda la tabla de tb_personas de la base de datos masterag == */
		$pg_result_trun=$this->pg->Query('TRUNCATE "masterag"."'.$tabla.'" ;');
		if(!$pg_result_trun['success'])
		{
			$this->ShowError("ERROR EN LA TRUNCATE: ".$pg_result_trun['message']);
		}

		/* == Reinicia el id autoincrement == */
			$msg_autoincrement="";
		if($truncate_id == null  || $truncate_id=="")
		{
				//NO AUTOINCREMENTE EN LA TABLE
		}
		else
		{
			$pg_result_seq=$this->pg->Query("ALTER SEQUENCE ".$truncate_id." RESTART WITH 1;");
			if(!$pg_result_seq['success']){
				$this->ShowError("ERROR EN LA ALTER SEQUENSE: ".$pg_result_seq['message']);
			}
			$msg_autoincrement="y su AUTO INCREMENT";

		}
		echo "<center><strong  style='color:green;' >TRUNCEADA LA TABLA ".$tabla." ".$msg_autoincrement." de masterag </strong></center>";
	}

	function MigrarbyPersona($bd='',$corporacion=2,$plan_estudios=2,$fieldid=1,$fieldid_str='alumno',$id_moodle=0)
	{

	 	$this->id_corporacion=$corporacion;
	 	$this->id_plan_estudio=$plan_estudios;
	 	$fieldid_alumno=$fieldid;
	 	$fieldid_alumno_str=$fieldid_str;

		$mysql_query="SELECT tp.*,m.id as idmoodle,ta.id as id_alumno FROM ".$bd.".mdl_user m
		 inner join escolar.tb_alumnos ta on ta.idmoodle=m.id 
		 inner join escolar.tb_personas tp on tp.id=ta.id_persona
		 where 
		 m.deleted=0
		 and
		 m.id='".$id_moodle."'
		 and
		  (select mdata.data from ".$bd.".mdl_user_info_data mdata where mdata.fieldid = ".$fieldid_alumno." and mdata.userid = m.id limit 1) = '".$fieldid_alumno_str."'
		 and ta.id_corporacion=".$this->id_corporacion." and ta.id_plan_estudio=".$this->id_plan_estudio." order by tp.id asc";
		
	
		if($this->mysql->con){

				$mysql_result_escolar=$this->mysql->Query($mysql_query);
				if($mysql_result_escolar['success']){

					while ($row=mysqli_fetch_assoc($mysql_result_escolar['data'])) {
						
						$estadocivil=7; // REGISTRO DE NO DEFINIDO

						if((int)$row['estadocivil']==0){ // MAPEO DE ESTADO CIVIL ESCOLAR -> MASTERAG
							$estadocivil=7;
						}else if((int)$row['estadocivil']==1) {
							$estadocivil=7;
						}else if((int)$row['estadocivil']==2) {
							$estadocivil=1;
						}else if((int)$row['estadocivil']==3) {
							$estadocivil=3;
						}
						if(!$this->validateDate($row['fecha_nacimiento'], 'Y-m-d')){ 
							// si no tiene fecha de nacimiento o no es valida se le pone una por default
							$row['fecha_nacimiento']="1970-01-01";
						}

						//QUERY DE INSERT EN masterag.tb_personas
						
						$primer_nombre=$this->StripPrimerNombre($row['nombre']);
						$segundo_nombre=$this->StripSegundoNombre($row['nombre']);
						
						$pg_query='INSERT INTO "masterag"."tb_personas" 
						( "id_rol", "nombre1", "nombre2", "apellido1", "apellido2", "fecha_nacimiento", "sexo", "curp", "id_estado_civil", "fecha_registro", "fecha_modificacion") VALUES (2,\''.$primer_nombre.'\',\''.$segundo_nombre.'\',\''.$row['apellido1'].'\',\''.$row['apellido2'].'\',\''.$row['fecha_nacimiento'].'\',\''.$row['sexo'].'\',\''.$row['curp'].'\','.$estadocivil.',\''.$row['fecha_registro'].'\',now());';
						



							$pg_result=$this->pg->Query($pg_query);

							if($pg_result['success']){

								$lastid=$this->pg->last_insert_table('tb_personas','id');

								//QUERY PARA SABER SI YA EXISTE EL ID ANTES DE MIGRARLO A LA masterag
								$existe_id=0;
								$pg_select_query='SELECT COUNT("id_nuevo") FROM "masterag"."tb_ids_escolar" WHERE "tb_ids_escolar"."id_nuevo"='.$lastid.' LIMIT 10';
								$pg_result_select=$this->pg->Query($pg_select_query);
								while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
								    foreach ($line as $col_value) {
								        $existe_id=$col_value;
								    }
								}

								if($existe_id==0){ // si el id ya no existe en la nueva BASE DE DATOS masterag lo inserta

									$pg_query_ids='INSERT INTO "masterag"."tb_ids_escolar" ("id_nuevo","idmoodle","id_persona","id_alumno","id_corporacion","id_plan_estudio","basededatos") VALUES ('.$lastid.','.$row['idmoodle'].','.$row['id'].','.$row['id_alumno'].','.$this->id_corporacion.','.$this->id_plan_estudio.',\''.$bd.'\'); '; 
									
									$pg_result_ids=$this->pg->Query($pg_query_ids);
									if(!$pg_result_ids['success']){
										$this->ShowError($bd." ERROR EN LA QUERY tb_ids_escolar: \n ".$pg_query." \n ".$pg_result['message']);
									}else{

										$this->MigrarPerfiles($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_perfiles
										$this->MigrarDatosEmpresa($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_datos_empresas
										$this->MigrarUsuarios($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_usuarios
										$this->MigrarPersonasInscripcion($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_personas_inscripcion
										$this->MigrarPersonasTelefonos($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_personas_telefonos
										//$this->MigrarPersonasInscripcionUPDATETaxonomia($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //ACTUALIZA ESTATUS DE TAXONOMIA PROSPECTO , PREINSCRITO INSCRITO

									}
								}else{ // si ya existe se detiene el proceso
								
									$this->ShowError($bd." PROCESO DETENIDO: ".$bd." EL ID:  ".$row['id']." Ya exíste");
								}


							}else{
							
								$this->ShowError($bd." ERROR EN LA QUERY tb_personas : \n ".$pg_query." \n ".$pg_result['message']);
							}


					}// final while del select de escolar
				}else{
					//error en select query personas
				}

		}else{
			//echo "<center><strong style='color:red;'>MIGRACION ".$bd." TB_PERSONAS DE NO SE PUDO CONECTAR A BASEDEDATOS</strong></center>";
	
		}
		
	}



	function MigrarbyPersonaUPDATE($bd='',$corporacion=0,$plan_estudios=0,$fieldid=1,$fieldid_str='alumno',$id_moodle=0,$interno=false)
	{

	 	$this->id_corporacion=$corporacion;
	 	$this->id_plan_estudio=$plan_estudios;
	 	$fieldid_alumno=$fieldid;
	 	$fieldid_alumno_str=$fieldid_str;

		$mysql_query="SELECT tp.*,m.id as idmoodle,ta.id as id_alumno FROM ".$bd.".mdl_user m
		 inner join escolar.tb_alumnos ta on ta.idmoodle=m.id 
		 inner join escolar.tb_personas tp on tp.id=ta.id_persona
		 where 
		 m.deleted=0
		 and
		 m.id='".$id_moodle."'
		 and
		  (select mdata.data from ".$bd.".mdl_user_info_data mdata where mdata.fieldid = ".$fieldid_alumno." and mdata.userid = m.id limit 1) = '".$fieldid_alumno_str."'
		 and ta.id_corporacion=".$this->id_corporacion." and ta.id_plan_estudio=".$this->id_plan_estudio." order by tp.id asc";


		
		if($this->mysql->con){

				$mysql_result_escolar=$this->mysql->Query($mysql_query);
				if($mysql_result_escolar['success']){

					while ($row=mysqli_fetch_assoc($mysql_result_escolar['data'])) {
						


								//QUERY PARA SABER SI YA EXISTE EL ID ANTES DE UPDATEARLO A LA masterag
								$lastid=0; // id_persona NUEVO
								$pg_select_query='SELECT "id_nuevo" FROM "masterag"."tb_ids_escolar" WHERE 

								"tb_ids_escolar"."idmoodle"='.$id_moodle.' AND
								"tb_ids_escolar"."id_persona"='.$row['id'].' AND
								"tb_ids_escolar"."id_alumno"='.$row['id_alumno'].' AND
								"tb_ids_escolar"."id_corporacion"='.$this->id_corporacion.' AND
								"tb_ids_escolar"."id_plan_estudio"='.$this->id_plan_estudio.' 
								 LIMIT 1';
								$pg_result_select=$this->pg->Query($pg_select_query);
								while ($line = pg_fetch_array($pg_result_select['data'], null, PGSQL_ASSOC)) {
								    foreach ($line as $col_value) {
								        $lastid=$col_value;
								    }
								}

								if($lastid==0 || !is_numeric($lastid)){ // si el id ya no existe en la nueva BASE DE DATOS masterag lo inserta
									//$this->ShowError($bd." ERROR EN LA QUERY tb_personas3 : \n ".$pg_select_query." \n ".$pg_result_select['message']);

									return false;
									
								}else{ // si ya existe se detiene el proceso

									$estadocivil=7; // REGISTRO DE NO DEFINIDO

									if((int)$row['estadocivil']==0){ // MAPEO DE ESTADO CIVIL ESCOLAR -> MASTERAG
										$estadocivil=7;
									}else if((int)$row['estadocivil']==1) {
										$estadocivil=7;
									}else if((int)$row['estadocivil']==2) {
										$estadocivil=1;
									}else if((int)$row['estadocivil']==3) {
										$estadocivil=3;
									}
									if(!$this->validateDate($row['fecha_nacimiento'], 'Y-m-d')){ 
										// si no tiene fecha de nacimiento o no es valida se le pone una por default
										$row['fecha_nacimiento']="1970-01-01";
									}

									//QUERY DE INSERT EN masterag.tb_personas
									$primer_nombre=$this->StripPrimerNombre($row['nombre']);
									$segundo_nombre=$this->StripSegundoNombre($row['nombre']);
									
									$pg_query='UPDATE "masterag"."tb_personas" SET 
									"id_rol"=2, 
									"nombre1"=\''.$primer_nombre.'\', 
									"nombre2"=\''.$segundo_nombre.'\', 
									"apellido1"=\''.$row['apellido1'].'\', 
									"apellido2"=\''.$row['apellido2'].'\', 
									"fecha_nacimiento"=\''.$row['fecha_nacimiento'].'\', 
									"sexo"=\''.$row['sexo'].'\', 
									"curp"=\''.$row['curp'].'\', 
									"id_estado_civil"='.$estadocivil.', 
									"fecha_modificacion"=now()
									WHERE "id"='.$lastid.' ; ';
									
									$pg_result=$this->pg->Query($pg_query);

									if($pg_result['success']){

										$perfil=$this->MigrarPerfilesUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_perfiles
										$empresa=$this->MigrarDatosEmpresaUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_datos_empresas
										$usuario=$this->MigrarUsuariosUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_usuarios
										$inscripcion=$this->MigrarPersonasInscripcionUPDATE($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //migrar tb_personas_inscripcion
										//$this->MigrarPersonasTelefonos($lastid,$row['idmoodle'],$row['id'],$row['id_alumno'],$bd); //migrar tb_personas_telefonos
										//$this->MigrarPersonasInscripcionUPDATETaxonomia($lastid,$row['idmoodle'],$row['id'],$row['id_alumno']); //ACTUALIZA ESTATUS DE TAXONOMIA PROSPECTO , PREINSCRITO INSCRITO


										if($perfil && $empresa && $usuario && $inscripcion){
											return true;
										}else{

											//$this->ShowError($bd." ERROR EN LA QUERY tb_personas1 ");
											return false;

										}
									
									}else{
										//$this->ShowError($bd." ERROR EN LA QUERY tb_personas2 : \n ".$pg_query." \n ".$pg_result['message']);

										return false;
									}

									
								}


					}// final while del select de escolar
				}else{
					return false; // error select persona
				}

		}else{
			//echo "<center><strong style='color:red;'>MIGRACION ".$bd." TB_PERSONAS DE NO SE PUDO CONECTAR A BASEDEDATOS</strong></center>";
			return false;
		}
		
	}


}




?>