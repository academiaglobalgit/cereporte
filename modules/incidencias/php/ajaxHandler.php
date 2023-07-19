<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
 	header("Access-Control-Allow-Origin: * ");

	require_once("../models/Connection.class.php");
	#require_once("../models/ConnectionPG.class.php");
	require_once("../models/Usuarios.class.php");
	require_once("../models/Permisos.class.php");
	require_once("../models/Areas.class.php");
	require_once("../models/Categorias.class.php");
	require_once("../models/Problematicas.class.php");
	require_once("../models/PlanEstudios.class.php");
	require_once("../models/Incidencias.class.php");
	require_once("../models/MigrarPersonas.class.php");

	//require_once("../models/Validator.class.php");

	/*initialize result object*/
	$result['success']=false;
	$result['message']='Invalid Request';
	$result['data']=null;

	if(isset($_POST['request'])){
		$request=$_POST;
		switch ($request['request']) {

			/*==========######### usuarios ##########============*/
			case "InsertUsuario":
						$usuarios = new Usuarios();
						$new_username=$usuarios->GetNewUsername($request['data']['nombre'],$request['data']['apellidop'],0);

						$exist_nombre=$usuarios->GetNombreCompleto(0,$request['data']['nombre'],$request['data']['apellidop'],$request['data']['apellidom'],$request['data']['fecha_nacimiento']);

						if((int)$exist_nombre['data'][0]['conteo']>0){ //ya existe nombre
							$result['message']="Lo sentimos este usuario ya exìste, porfavor ingrese correctamente su fecha de nacimiento para diferenciarlo";

						}else{

							$result=$usuarios->InsertUsuario('nodb',$request['data']['id_corporacion'],1,$request['data']['nombre'],$request['data']['apellidop'],$request['data']['apellidom'],$new_username,$request['data']['contrasena'],$request['data']['fecha_nacimiento'],$request['data']['telefono_casa'],$request['data']['telefono_celular'],$request['data']['telefono_alternativo'],$request['data']['email'],$request['data']['id_estado'],$request['data']['id_ciudad'],$request['data']['nombre_ciudad'],$request['data']['id_region'],$request['data']['nombre_region'],$request['data']['numero_sucursal'],$request['data']['nombre_sucursal'],$request['data']['tipo_alumno'],$request['data']['permiso'],$request['data']['area']);
						}

						$usuarios->Close();


			break;

			case "UpdateUsuario":

					if(isset($request['data']['id_usuario']) && is_numeric($request['data']['id_usuario'])){
						$usuarios = new Usuarios();
						$result=$usuarios->UpdateUsuario($request['data']['id_persona'],$request['data']['id_usuario'],$request['data']['nombre'],$request['data']['apellidop'],$request['data']['apellidom'],$request['data']['contrasena'],$request['data']['estatus'],$request['data']['permiso'],$request['data']['area']);
						$usuarios->Close();
					}else{
						$result['message']='ingrese el id de usuario correctamente';
					}

			break;

			case "DeleteUsuario":

				if(isset($request['data']['id_usuario']) && is_numeric($request['data']['id_usuario'])){
						$usuarios = new Usuarios();
						$result=$usuarios->DeleteUsuario($request['data']['id_usuario']);
						$usuarios->Close();
				}else{
					$result['message']='ingrese el id de usuario correctamente';
				}

			break;

			case "GetUsuarios":

				$usuarios= new Usuarios();
				$result=$usuarios->GetUsuarios($request['data']['nombre']);
				$usuarios->Close();
			break;

			/*==========######### PERMISOS ##########============*/

			case "GetPermisos":
				$permisos= new Permisos();
				$result=$permisos->GetPermisos();
				$permisos->Close();
			break;

			/*==========######### AREAS ##########============*/

			case "InsertArea":

				$areas= new Areas();
				$result=$areas->InsertArea($request['data']['descripcion'],$request['data']['orden']);
				$areas->Close();
			break;

			case "UpdateArea":

				$areas= new Areas();
				if(isset($request['data']['id_area']) && is_numeric($request['data']['id_area'])){
					$result=$areas->UpdateArea($request['data']['id_area'],$request['data']['descripcion'],$request['data']['estatus'],$request['data']['orden']);
				}else{
					$result['message']="Ingrese correctamente el id_area";
				}
				$areas->Close();

			break;


			case "GetAreas":

				$areas= new Areas();
				$result=$areas->GetAreas($request['data']['area']);
				$areas->Close();
			break;

			case "GetAreasActivas":

				$areas= new Areas();
				$result=$areas->GetAreasActivas();
				$areas->Close();
			break;

			/*==========######### categoriaS ##########============*/

			case "InsertCategoria":

				$categorias= new Categorias();
				$result=$categorias->InsertCategoria($request['data']['nombre'],$request['data']['tipo']);
				$categorias->Close();

			break;

			case "UpdateCategoria":

				$categorias= new Categorias();
				if(isset($request['data']['id_categoria']) && is_numeric($request['data']['id_categoria'])){
					$result=$categorias->UpdateCategoria($request['data']['id_categoria'],$request['data']['nombre'],$request['data']['tipo']);
				}else{
					$result['message']="Ingrese correctamente el id_categoria";
				}
				$categorias->Close();
			break;


			case "GetCategorias":

				$categorias= new Categorias();
				$result=$categorias->GetCategorias($request['data']['categoria']);
				$categorias->Close();
			break;

			case "GetCategoriasActivas":

				$categorias= new Categorias();
				$result=$categorias->GetCategoriasActivas();
				$categorias->Close();
			break;

			/*==========######### problematicas ##########============*/

			case "InsertProblematica":

				$problematicas= new Problematicas();
				$result=$problematicas->InsertProblematica($request['data']['nombre'],$request['data']['id_categoria'],$request['data']['id_area'],$request['data']['id_plan_estudios']);
				$problematicas->Close();
			break;

			case "UpdateProblematica":

				$problematicas= new Problematicas();
				if(isset($request['data']['id_problematica']) && is_numeric($request['data']['id_problematica'])){
					$result=$problematicas->UpdateProblematica($request['data']['id_problematica'],$request['data']['nombre'],$request['data']['estatus'],$request['data']['id_categoria'],$request['data']['id_area'],$request['data']['id_plan_estudios']);
				}else{
					$result['message']="Ingrese correctamente el id_problematica";
				}
				$problematicas->Close();
			break;

			case "GetProblematicas":

				$problematicas = new Problematicas();
				$result=$problematicas->GetProblematicas($request['data']['problematica']);
				$problematicas->Close();
			break;

			case "GetProblematicasActivas":

				$problematicas= new Problematicas();
				$result=$problematicas->GetProblematicasActivas();
				$problematicas->Close();
			break;


			/*==========######### plan de estudios ##########============*/

			case "GetPlanEstudios":

				$planestudios= new PlanEstudios();
				$result=$planestudios->GetPlanEstudios();
				$planestudios->Close();
			break;

			/*==========######### INCIDENCIAS ##########============*/

			case "GetIncidenciasTotales":
				$incidencias = new Incidencias();
				$result=$incidencias->GetIncidenciasTotales();
				$incidencias->Close();
			break;
			case "GetIncidenciasTotalesCategorias":
				$incidencias = new Incidencias();
				$result=$incidencias->GetIncidenciasTotalesCategorias();
				$incidencias->Close();
			break;
			case "GetIncidenciasTotalesUsuario":
				$incidencias = new Incidencias();
				$result=$incidencias->GetIncidenciasTotalesUsuario($_SESSION['id_persona']);
				$incidencias->Close();
			break;
			case "GetIncidenciasSolucionadasUsuario":
				$incidencias = new Incidencias();
				$result=$incidencias->GetIncidenciasSolucionadasUsuario($_SESSION['id_persona']);
				$incidencias->Close();
			break;
			case "GetIncidenciasTotalesPlataformas":
				$incidencias = new Incidencias();
				$result=$incidencias->GetIncidenciasTotalesPlataformas();
				$incidencias->Close();
			break;
			case "GetIncidenciasAlumnoCategorias":
				$incidencias = new Incidencias();
				$result=$incidencias->GetIncidenciasAlumnoCategorias($request['data']['id_plan_estudio'],$request['data']['numero_empleado']);
				$incidencias->Close();
			break;
			case "update_incidencias_externas":

				if(!isset($request["data"]["form_i_editar_id_incidencia"])){
					$result['message']="Debe seleccionar una incidencia.";
				}
				else if(!is_numeric($request["data"]["form_i_editar_id_incidencia"])){
					$result['message']="Debe seleccionar una incidencia.";
				}
				if(!isset($request["data"]["form_i_editar_tipo_incidencia"])){
					$result['message']="Debe seleccionar un tipo.";
				}
				else if(!is_numeric($request["data"]["form_i_editar_tipo_incidencia"])){
					$result['message']="Debe seleccionar un tipo.";
				}
				if(!isset($request["data"]["form_i_editar_id_categoria"])){
					$result['message']="Debe seleccionar una categoria.";
				}
				else if($request["data"]["form_i_editar_id_categoria"] == ""){
					$result['message']="Debe seleccionar una categoria.";
				}
				else if(!isset($request["data"]["form_i_editar_problematica"])){
					$result['message']="Debe seleccionar una problematica.";
				}
				else if($request["data"]["form_i_editar_problematica"] == ""){
					$result['message']="Debe seleccionar una problematica.";
				}
				else if(!isset($request["data"]["form_i_editar_comentarios"])){
					$result['message']="Debe agregar un comentario.";
				}
				else if($request["data"]["form_i_editar_comentarios"] == ""){
					$result['message']="Debe agregar un comentario.";
				}
				else if(!isset($request["data"]["form_i_editar_correo"])){
					$result['message']="Debe especificar un correo electrónico.";
				}
				else if($request["data"]["form_i_editar_correo"] == ""){
					$result['message']="Debe especificar un correo electrónico.";
				}
				else if(!isset($request["data"]["form_i_editar_numero_telefonico"])){
					$result['message']="Debe especificar un telefono.";
				}
				else if($request["data"]["form_i_editar_numero_telefonico"] == ""){
					$result['message']="Debe especificar un telefono.";

				}else{
						$incidencias = new Incidencias();
						$result=$incidencias->uptate_tb_incidencias_externa(
							$request["data"]["form_i_editar_id_incidencia"],
							$request["data"]["form_i_editar_tipo_incidencia"],
							$request["data"]["form_i_editar_comentarios"],
							$request["data"]["form_i_editar_id_categoria"],
							$request["data"]["form_i_editar_problematica"],
							$request["data"]["form_i_editar_correo"],
							$request["data"]["form_i_editar_numero_telefonico"]);
						$incidencias->Close();
				}

			break;

			case "update_incidencias_internas":

				if(!isset($request["data"]["form_i_editar_id_incidencia"])){
					$result['message']="Debe seleccionar una incidencia.";
				}
				else if(!is_numeric($request["data"]["form_i_editar_id_incidencia"])){
					$result['message']="Debe seleccionar una incidencia.";
				}
				if(!isset($request["data"]["form_i_editar_tipo_incidencia"])){
					$result['message']="Debe seleccionar un tipo.";
				}
				else if(!is_numeric($request["data"]["form_i_editar_tipo_incidencia"])){
					$result['message']="Debe seleccionar un tipo.";
				}
				if(!isset($request["data"]["form_i_editar_id_categoria"])){
					$result['message']="Debe seleccionar una categoria.";
				}
				else if($request["data"]["form_i_editar_id_categoria"] == ""){
					$result['message']="Debe seleccionar una categoria.";
				}
				else if(!isset($request["data"]["form_i_editar_problematica"])){
					$result['message']="Debe seleccionar una problematica.";
				}
				else if($request["data"]["form_i_editar_problematica"] == ""){
					$result['message']="Debe seleccionar una problematica.";
				}
				else if(!isset($request["data"]["form_i_editar_comentarios"])){
					$result['message']="Debe agregar un comentario.";
				}
				else if($request["data"]["form_i_editar_comentarios"] == ""){
					$result['message']="Debe agregar un comentario.";
				}
				else if(!isset($request["data"]["form_i_editar_id_plan_estudios"])){
					$result['message']="Debe especificar un plan de estudios.";
				}
				else if($request["data"]["form_i_editar_id_plan_estudios"] == ""){
					$result['message']="Debe especificar un plan de estudios.";
				}
				/*else if(!isset($request["data"]["form_i_editar_correo"])){
					$result['message']="Debe especificar un correo electrónico.";
				}
				else if($request["data"]["form_i_editar_correo"] == ""){
					$result['message']="Debe especificar un correo electrónico.";
				}
				else if(!isset($request["data"]["form_i_editar_numero_telefonico"])){
					$result['message']="Debe especificar un telefono.";
				}
				else if($request["data"]["form_i_editar_numero_telefonico"] == ""){
					$result['message']="Debe especificar un telefono.";

				}else if(!isset($request["data"]["form_i_crear_fecha_terminacion"])){
					$result['message']="Debe especificar un telefono.";
				}
				else if($request["data"]["form_i_crear_fecha_terminacion"] == ""){
					$result['message']="Debe especificar un telefono.";

				}*/else{
						$incidencias = new Incidencias();
						$result=$incidencias->uptate_tb_incidencias_interna(
							$request["data"]["form_i_editar_id_incidencia"],
							$request["data"]["form_i_editar_tipo_incidencia"],
							$request["data"]["form_i_editar_comentarios"],
							$request["data"]["form_i_editar_id_categoria"],
							$request["data"]["form_i_editar_problematica"],
							$request["data"]["form_i_crear_fecha_terminacion"],
							$request["data"]["form_i_editar_id_plan_estudios"],
							$request["data"]["form_i_editar_numero_empleado"]);
						$incidencias->Close();
				}

			break;

			case "ChangeStatusIncidencia":

				$incidencias = new Incidencias();
				$result=$incidencias->ChangeStatusIncidencia($request['data']['id_incidencia'],$request['data']['estatus'],$request['data']['comentarios']);
				$incidencias->Close();

			break;

			case "get_areas_grupoag":
				$incidencias = new Incidencias();
				$result = $incidencias->get_areas_grupoag();
				$incidencias->Close();
			break;

			case "get_categorias_problematicas":
				$incidencias = new Incidencias();
				$result = $incidencias->get_categorias();
				$incidencias->Close();
			break;

			case "get_estatus_incidencias":
				$incidencias = new Incidencias();
				$result = $incidencias->get_incidencias_estatus();
				$incidencias->Close();
			break;

			case "get_years_incidencias":
				$incidencias = new Incidencias();
				$result = $incidencias->get_incidencias_years();
				$incidencias->Close();
			break;

			case "get_incidencias_filtradas":
				$filtro = "";
				if($request['data']["form_i_search_id_ticket"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE a.id = '".trim($request['data']["form_i_search_id_ticket"])."' ";
					}
					else{
						$filtro .= " AND a.id = '".trim($request['data']["form_i_search_id_ticket"])."' ";
					}
				}
				if($request['data']["form_i_search_categoria"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE g.id_categoria = ".$request['data']["form_i_search_categoria"]." ";
					}
					else{
						$filtro .= " AND g.id_categoria = ".$request['data']["form_i_search_categoria"]." ";
					}
				}
				if($request['data']["form_i_search_area"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE a.id_area = ".$request['data']["form_i_search_area"]." ";
					}
					else{
						$filtro .= " AND a.id_area = ".$request['data']["form_i_search_area"]." ";
					}
				}
				if($request['data']["form_i_search_estatus"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE a.estatus = ".$request['data']["form_i_search_estatus"]." ";
					}
					else{
						$filtro .= " AND a.estatus = ".$request['data']["form_i_search_estatus"]." ";
					}
				}
				if($request['data']["form_i_search_month"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE MONTH(a.fecha_registro) = ".$request['data']["form_i_search_month"]." ";
					}
					else{
						$filtro .= " AND MONTH(a.fecha_registro) = ".$request['data']["form_i_search_month"]." ";
					}
				}
				if($request['data']["form_i_search_year"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE YEAR(a.fecha_registro) = ".$request['data']["form_i_search_year"]." ";
					}
					else{
						$filtro .= " AND YEAR(a.fecha_registro) = ".$request['data']["form_i_search_year"]." ";
					}
				}
				if($request['data']["form_i_search_id_persona_registra"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE a.id_usuario_registra = ".$request['data']["form_i_search_id_persona_registra"]." ";
					}
					else{
						$filtro .= " OR a.id_usuario_registra = ".$request['data']["form_i_search_id_persona_registra"]." ";
					}
				}

				if($request['data']["form_i_search_plataforma"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE a.id_plan_estudio = ".$request['data']["form_i_search_plataforma"]." ";
					}
					else{
						$filtro .= " OR a.id_plan_estudio = ".$request['data']["form_i_search_plataforma"]." ";
					}
				}
				if($request['data']["form_i_search_numero_empleado"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE a.numero_empleado = ".$request['data']["form_i_search_numero_empleado"]." ";
					}
					else{
						$filtro .= " OR a.numero_empleado = ".$request['data']["form_i_search_numero_empleado"]." ";
					}
				}

				$incidencias = new Incidencias();
				$result = $incidencias->get_incidencias($filtro);
				$incidencias->Close();
			break;



			case "GetIncidenciasByAlumno":
				$filtro="";
				if($request['data']["form_i_search_plataforma"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE a.id_plan_estudio = ".$request['data']["form_i_search_plataforma"]." ";
					}
					else{
						$filtro .= " AND a.id_plan_estudio = ".$request['data']["form_i_search_plataforma"]." ";
					}
				}
				if($request['data']["form_i_search_numero_empleado"] != ""){
					if($filtro == ""){
						$filtro .= " WHERE a.numero_empleado = ".$request['data']["form_i_search_numero_empleado"]." ";
					}
					else{
						$filtro .= " AND a.numero_empleado = ".$request['data']["form_i_search_numero_empleado"]." ";
					}
				}

				$incidencias = new Incidencias();
				$result = $incidencias->get_incidencias($filtro);
				$incidencias->Close();
			break;

			case "get_categorias_problematicas_externas":
				$incidencias = new Incidencias();
				$result = $incidencias->get_categorias_externas();
				$incidencias->Close();
			break;

			case "get_categorias_problematicas_internas":
				$incidencias = new Incidencias();
				$result = $incidencias->get_categorias_internas();
				$incidencias->Close();
			break;

			case "get_informacion_alumno_by_num_empleado":
				$incidencias = new Incidencias();
				$result = $incidencias->get_informacion_alumno_by_numero_empleado($request['data']['numero_empleado'], $request['data']['id_plan_estudios']);
				$incidencias->Close();
			break;

			case "get_problematicas_by_categoria":
				$incidencias = new Incidencias();
				$result = $incidencias->get_problematicas_by_categoria($request['data']['id_categoria']);
				$incidencias->Close();
			break;

			case "insert_incidencias_externas":

				$request["data"]["id_asesor"] =$_SESSION['id_persona'];

				if(!isset($request["data"]["form_i_crear_idpersona"])){
					$result['message']="No se encuentra el ID del usuario que reporta.";
				}
				else if($request["data"]["form_i_crear_idpersona"] == ""){
					$result['message']="No se encuentra el ID del usuario que reporta.";
				}
				else if(!isset($request["data"]["id_asesor"])){
					$result['message']="No se encuentra el ID del asesor.";
				}
				else if($request["data"]["id_asesor"] == ""){
					$result['message']="No se encuentra el ID del asesor.";
				}
				else if(!isset($request["data"]["form_i_crear_id_categoria"])){
					$result['message']="Debe seleccionar una categoria.";
				}
				else if($request["data"]["form_i_crear_id_categoria"] == ""){
					$result['message']="Debe seleccionar una categoria.";
				}
				else if(!isset($request["data"]["form_i_crear_problematica"])){
					$result['message']="Debe seleccionar una problematica.";
				}
				else if($request["data"]["form_i_crear_problematica"] == ""){
					$result['message']="Debe seleccionar una problematica.";
				}
				else if(!isset($request["data"]["form_i_crear_comentarios"])){
					$result['message']="Debe agregar un comentario.";
				}
				else if($request["data"]["form_i_crear_comentarios"] == ""){
					$result['message']="Debe agregar un comentario.";
				}
				else if(!isset($request["data"]["form_i_crear_correo"])){
					$result['message']="Debe especificar un correo electrónico.";
				}
				else if($request["data"]["form_i_crear_correo"] == ""){
					$result['message']="Debe especificar un correo electrónico.";
				}
				else if(!isset($request["data"]["form_i_crear_numero_telefonico"])){
					$result['message']="Debe especificar un telefono.";
				}
				else if($request["data"]["form_i_crear_numero_telefonico"] == ""){
					$result['message']="Debe especificar un telefono.";

				}else if(empty($request["data"]["form_i_crear_id_plan_estudios"])){
					$result['message']="Debe especificar una plataforma.";
				}
				else if(!is_numeric($request["data"]["form_i_crear_id_plan_estudios"])){
					$result['message']="Debe especificar una plataforma.";
				}
				else{
					$incidencias = new Incidencias();
					$response = $incidencias->get_problematica_by_id($request["data"]["form_i_crear_problematica"]);

					if(!isset($response["data"][0]["id_area"])){
						$result['message']="Ocurrio un error y no pudo obtenerse la información del área.";
					}else{

						$id_corporacion=0;

						$planestudios = new PlanEstudios();
						$plan_result=$planestudios->GetPlanEstudio($request["data"]["form_i_crear_id_plan_estudios"]);
						$id_corporacion=$plan_result['data'][0]['id_corporacion'];
						$planestudios->Close();
						$result = $incidencias->insert_tb_incidencias_externa(
							$request["data"]["form_i_crear_idpersona"],
							$request["data"]["form_i_crear_comentarios"],
							$response["data"][0]["id_area"],
							1,
							1,
							$request["data"]["id_asesor"],
							$request["data"]["form_i_crear_problematica"],
							$request["data"]["form_i_crear_correo"],
							$request["data"]["form_i_crear_numero_telefonico"],
							$request["data"]["form_i_crear_id_plan_estudios"],
							$id_corporacion,
							$request["data"]["form_i_crear_id_categoria"]
							);
					}
					$incidencias->Close();
				}

			break;

			case "insert_incidencias_internas" :

				$request["data"]["id_asesor"] =$_SESSION['id_persona'];

				if(!isset($request["data"]["id_asesor"])){
					$result['message']="No se encuentra el ID del asesor.";
				}
				else if($request["data"]["id_asesor"] == ""){
					$result['message']="No se encuentra el ID del asesor.";
				}
				else if(!isset($request["data"]["form_i_crear_id_categoria"])){
					$result['message']="Debe seleccionar una categoria.";
				}
				else if($request["data"]["form_i_crear_id_categoria"] == ""){
					$result['message']="Debe seleccionar una categoria.";
				}
				else if(!isset($request["data"]["form_i_crear_problematica"])){
					$result['message']="Debe seleccionar una problematica.";
				}
				else if($request["data"]["form_i_crear_problematica"] == ""){
					$result['message']="Debe seleccionar una problematica.";
				}
				else if(!isset($request["data"]["form_i_crear_comentarios"])){
					$result['message']="Debe agregar un comentario.";
				}
				else if($request["data"]["form_i_crear_comentarios"] == ""){
					$result['message']="Debe agregar un comentario.";
				}
				/*else if(!isset($request["data"]["form_i_crear_correo"])){
					$result['message']="Debe especificar un correo electrónico.";
				}
				else if($request["data"]["form_i_crear_correo"] == ""){
					$result['message']="Debe especificar un correo electrónico.";
				}
				else if(!isset($request["data"]["form_i_crear_numero_telefonico"])){
					$result['message']="Debe especificar un telefono.";
				}
				else if($request["data"]["form_i_crear_numero_telefonico"] == ""){
					$result['message']="Debe especificar un telefono.";
				}*/
				else if(empty($request["data"]["form_i_crear_id_plan_estudios"])){
					$result['message']="Debe especificar una plataforma.";
				}
				else if(!is_numeric($request["data"]["form_i_crear_id_plan_estudios"])){
					$result['message']="Debe especificar una plataforma.";
				}
				else{
					$incidencias = new Incidencias();
					$response = $incidencias->get_problematica_by_id($request["data"]["form_i_crear_problematica"]);
					if(!isset($response["data"][0]["id_area"])){
						$result['message']="Ocurrio un error y no pudo obtenerse la información del área.";
					}else{

						$id_corporacion=0;

						$planestudios = new PlanEstudios();
						$plan_result=$planestudios->GetPlanEstudio($request["data"]["form_i_crear_id_plan_estudios"]);
						$id_corporacion=$plan_result['data'][0]['id_corporacion'];
						$planestudios->Close();
						$id_persona_alumno=0;

						if(!empty($request["data"]["form_i_crear_numero_empleado"]) && is_numeric($request["data"]["form_i_crear_numero_empleado"]) ){
							$usuarios = new Usuarios();
							$usu_result=$usuarios ->GetAlumnoByNumeroEmpleado($request["data"]["form_i_crear_numero_empleado"],$request["data"]["form_i_crear_id_plan_estudios"]);
							if($usu_result['success']){
								$id_persona_alumno=$usu_result['data'][0]['id'];
							}else{
								$id_persona_alumno=$request["data"]["id_asesor"];
							}
						}else{
							$id_persona_alumno=$request["data"]["id_asesor"];
						}


						$result = $incidencias->insert_tb_incidencias_interna($id_persona_alumno, $request["data"]["form_i_crear_comentarios"], $response["data"][0]["id_area"], 2, 1, $request["data"]["id_asesor"], $request["data"]["form_i_crear_problematica"], $request["data"]["form_i_crear_fecha_terminacion"],$request["data"]["form_i_crear_id_categoria"],
							$id_corporacion,$request["data"]["form_i_crear_id_plan_estudios"]
							,$request["data"]["form_i_crear_numero_empleado"]);
					}
					$incidencias->Close();
				}



			break;

			case "GetComentarios":
				$incidencias = new Incidencias();
				$result = $incidencias->GetComentarios($request['data']['id_incidencia']);
				$incidencias->Close();
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
