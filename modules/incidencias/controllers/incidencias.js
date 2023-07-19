$( document ).ready(function() {
	/*
	$(".btn_menu_filtros").click(function(e){ //TOGGLE PARA EL MENU
	 
		$(".filtro_avanzado").fadeToggle('fast');
	});
	*/

	var current_id_area=0;
	var current_id_permiso=0;
	current_id_area=id_area;
	current_id_permiso=id_permiso;


		$("#btn_form_proceso_incidencia").click(function(){
			SendAjax("form_i_proceso","ChangeStatusIncidencia",function(){
				$("#modal_i_proceso").modal('hide');
						var data_ajax=getFormData($("#form_i_search"));
						GetAjax(data_ajax, "get_incidencias_filtradas", function(incidencias){
							RefreshTableIncidencias(incidencias);
						});
			});
		});


		$("#btn_form_terminar_incidencia").click(function(){
			SendAjax("form_i_terminar","ChangeStatusIncidencia",function(){
						var data_ajax=getFormData($("#form_i_search"));
						GetAjax(data_ajax, "get_incidencias_filtradas", function(incidencias){
							RefreshTableIncidencias(incidencias);
						});
				$("#modal_i_terminar").modal('hide');
			});
		});

		$("#btn_form_cancelar_incidencia").click(function(){
			SendAjax("form_i_cancelar","ChangeStatusIncidencia",function(){
						var data_ajax=getFormData($("#form_i_search"));
						GetAjax(data_ajax, "get_incidencias_filtradas", function(incidencias){
							RefreshTableIncidencias(incidencias);
						});
				$("#modal_i_cancelar").modal('hide');
			});
		});

	GetAjax([], "get_areas_grupoag", function(areas){
		RefreshComboBox("form_i_search_area", areas, "id", "nombre");
		if(current_id_permiso != 1){
			$("#form_i_search_area option").each(function(){
				$(this).attr("disabled","disabled");
			});
			$("#form_i_search_area option[value=" + current_id_area + "]").removeAttr("disabled");
			$("#form_i_search_area").val(current_id_area);
			$("#form_i_search_area").attr("disabled","disabled");
			$("#div_i_search_area").hide();
			$("#form_i_search_id_usuario_registra").val(id_persona);
		}
	});

	GetAjax([], "get_categorias_problematicas", function(categorias){
		RefreshComboBox("form_i_search_categoria", categorias, "id", "nombre");
	});

	GetAjax([], "get_estatus_incidencias", function(estatus_incidencias){
		RefreshComboBox("form_i_search_estatus", estatus_incidencias, "id", "nombre");
	});

	/*
	GetAjax([], "get_years_incidencias", function(years){
		RefreshComboBox("form_i_search_year", years, "year", "year");
	});
	*/

	function RefreshComentarios(comentarios_array){
		var codigo_comentarios="";
		var codigo_comentarios_btn="";
		if(comentarios_array===undefined){
			codigo_comentarios+='<tr  class="text-center" >';
			codigo_comentarios+='	<td colspan="7"> <div class="row jumbotron"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </h1> <h6> No se encontraron registros para mostrar. </h6> </div> </td>';
			codigo_comentarios+='</tr>';
		}
		else if(comentarios_array.length==0 || comentarios_array==null){
			codigo_comentarios+='<tr  class="text-center" >';
			codigo_comentarios+='	<td colspan="7"> <div class="row jumbotron"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </h1> <h6> No se encontraron registros para mostrar. </h6> </div> </td>';
			codigo_comentarios+='</tr>';
		}else{

				for (var i = 0; i < comentarios_array.length; i++) {

					codigo_comentarios+='<div class="row" >';
						codigo_comentarios+='<div class="col-md-12" >';

						if(comentarios_array[i]['estatus'] == 1 || comentarios_array[i]['estatus'] == 5 ){
							codigo_comentarios+='<div class="alert alert-primary" >Estatus:<label class="label label-primary" >En espera</label> <small class="pull-right" >'+comentarios_array[i]['fecha_registro']+'</small> <div class="well" >Problematica: <br>'+comentarios_array[i]['comentarios']+'</div></div>';
						}
						else if(comentarios_array[i]['estatus'] == 2 ){
							codigo_comentarios+='<div class="alert alert-info" >Cambió Estatus: <label class="label label-info" >En Proceso</label> <small class="pull-right" >'+comentarios_array[i]['fecha_registro']+'</small><div class="well" >Comentario: <br>'+comentarios_array[i]['comentarios']+'</div> </div>';
							codigo_comentarios+='';
						}else if(comentarios_array[i]['estatus'] == 3 ){
							codigo_comentarios+='<div class="alert alert-success" >Cambió Estatus: <label class="label label-success" >Solucionada</label> <small class="pull-right" >'+comentarios_array[i]['fecha_registro']+'</small><div class="well" >Comentario: <br>'+comentarios_array[i]['comentarios']+'</div> </div>';

						}else if(comentarios_array[i]['estatus'] == 4 ){
							codigo_comentarios+='<div class="alert alert-danger" >Cambió Estatus: <label class="label label-danger" >Cancelada</label> <small class="pull-right" >'+comentarios_array[i]['fecha_registro']+'</small><div class="well" >Comentario: <br>'+comentarios_array[i]['comentarios']+'</div> </div>';
						}
						codigo_comentarios+='</div>';

					codigo_comentarios+='</div>';

				}
		}
			$("#div_comentarios").empty().append(codigo_comentarios);

	}


	function RefreshTableIncidencias(incidencias_array){
		var codigo_table_incidencias="";
		var codigo_table_incidencias_btn="";
		if(incidencias_array===undefined){
			codigo_table_incidencias+='<tr  class="text-center" >';
			codigo_table_incidencias+='	<td colspan="7"> <div class="row jumbotron"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </h1> <h6> No se encontraron registros para mostrar. </h6> </div> </td>';
			codigo_table_incidencias+='</tr>';
		}
		else if(incidencias_array.length==0 || incidencias_array==null){
			codigo_table_incidencias+='<tr  class="text-center" >';
			codigo_table_incidencias+='	<td colspan="7"> <div class="row jumbotron"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </h1> <h6> No se encontraron registros para mostrar. </h6> </div> </td>';
			codigo_table_incidencias+='</tr>';
		}else{
			for (var i = 0; i < incidencias_array.length; i++) {
				codigo_table_incidencias_btn="";
				codigo_table_incidencias+='<tr>';
				codigo_table_incidencias+='	<td item-index="'+i+'" > <center> '+incidencias_array[i]['id']+' </center> </td>'; 

				if(incidencias_array[i]['numero_empleado']==null || incidencias_array[i]['numero_empleado']==""){
					codigo_table_incidencias+='	<td item-index="'+i+'"  >'+incidencias_array[i]['nombre_usuario_registra']+'</td>';
				}else{
					codigo_table_incidencias+='	<td item-index="'+i+'"  >Alumno</td>';
				}
				codigo_table_incidencias+='	<td item-index="'+i+'"  >'+incidencias_array[i]['numero_empleado']+'</td>';

				codigo_table_incidencias+='	<td item-index="'+i+'"  >'+incidencias_array[i]['nombre_plan_estudios']+'</td>';

				codigo_table_incidencias+='	<td item-index="'+i+'"  >'+incidencias_array[i]['nombre_categoria']+'</td>';

				if(incidencias_array[i]['id_estatus'] == 1 || incidencias_array[i]['id_estatus'] == 5 ){
					codigo_table_incidencias+='<td item-index="'+i+'"  > <center> <h5> <span class="label label-primary"> '+incidencias_array[i]["estatus"]+' </span> </h5> </center> </td>';
					codigo_table_incidencias_btn+='	<button item-index="'+i+'" class="btn btn-success  btn_modal_i_terminar"  type="button" ><span class="glyphicon glyphicon-ok"></span></button>';
					codigo_table_incidencias_btn+='	<button item-index="'+i+'" class="btn btn-info  btn_modal_i_proceso"  type="button" ><span class="glyphicon glyphicon-time"></span></button>';
					codigo_table_incidencias_btn+='	<button item-index="'+i+'" class="btn btn-danger btn_modal_i_cancelar" type="button"  ><span class="glyphicon glyphicon-trash"></span></button>'; 
				}
				else if(incidencias_array[i]['id_estatus'] == 2){
					codigo_table_incidencias+='<td item-index="'+i+'"  > <center> <h5> <span class="label label-info"> '+incidencias_array[i]["estatus"]+' </span> </h5> </center> </td>';
					codigo_table_incidencias_btn+='	<button item-index="'+i+'" class="btn btn-success  btn_modal_i_terminar"  type="button" ><span class="glyphicon glyphicon-ok"></span></button>';
					codigo_table_incidencias_btn+='	<button item-index="'+i+'" class="btn btn-danger btn_modal_i_cancelar" type="button" ><span class="glyphicon glyphicon-trash"></span></button>'; 
				
				}
				else if(incidencias_array[i]['id_estatus'] == 3){
					codigo_table_incidencias+='<td item-index="'+i+'"  > <center> <h5> <span class="label label-success"> '+incidencias_array[i]["estatus"]+' </span> </h5> </center> </td>';
				}
				else if(incidencias_array[i]['id_estatus'] == 4){
					codigo_table_incidencias+='<td item-index="'+i+'"  > <center> <h5> <span class="label label-danger"> '+incidencias_array[i]["estatus"]+' </span> </h5> </center> </td>';
				}
				else{
					codigo_table_incidencias+='<td item-index="'+i+'"  > <center> <h5> <span class="label label-default"> No definido </span> </h5> </center> </td>';
				}
				codigo_table_incidencias+='	<td item-index="'+i+'"  >'+incidencias_array[i]['nombre_usuario_registra']+'</td>';
				codigo_table_incidencias+='	<td item-index="'+i+'"  >'+formato_fecha_master(incidencias_array[i]['fecha_registro'])+'</td>'; 
				codigo_table_incidencias+='<td>';

				if(current_id_permiso==1){

					codigo_table_incidencias+=codigo_table_incidencias_btn;
				}
				//codigo_table_incidencias+='	<button item-index="'+i+'" class="btn btn-success  btn_modal_i_terminar"  type="button" ><span class="glyphicon glyphicon-ok"></span></button>';
				//codigo_table_incidencias+='	<button item-index="'+i+'" class="btn btn-info btn_modal_i_proceso"  type="button" ><span class="glyphicon glyphicon-time"></span></button>';
				//+='	<button item-index="'+i+'" class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_i_eliminar" ><span class="glyphicon glyphicon-trash"></span></button>';  
			   	//codigo_table_incidencias+='	<button item-index="'+i+'" class="btn btn-info" type="button"  data-toggle="modal" data-target="#modal_i_trans"><span class="glyphicon glyphicon-random"></span></button>';
				if((current_id_permiso==1 || incidencias_array[i]['id_usuario_registra']==id_persona)  && incidencias_array[i]['id_estatus'] != 3){
					codigo_table_incidencias+='	<button item-index="'+i+'" class="btn btn-default btn_modal_i_editar" type="button" ><span class="glyphicon glyphicon-edit"></span></button>';
				} 
					codigo_table_incidencias+='	<button item-index="'+i+'" class="btn btn-default btn_modal_i_comentarios" type="button" ><span class="glyphicon glyphicon-list-alt"></span></button>';

				codigo_table_incidencias+='</td>';
				codigo_table_incidencias+='</tr>';
				
			}
		}

		$("#tabla_incidencias").empty().append(codigo_table_incidencias); // refresca la tabla con nuevos registros

		$(".btn_modal_i_comentarios").click(function(){
			var idx_current_inicidencia=$(this).attr('item-index');

			$("#modal_i_comentarios_id_moodle").empty().append(incidencias_array[idx_current_inicidencia]['idmoodle']);
			$("#modal_i_comentarios_numero_empleado").empty().append(incidencias_array[idx_current_inicidencia]['numero_empleado']);

			GetComentarios(incidencias_array[idx_current_inicidencia]['id']);
			$("#modal_i_comentarios").modal('show');

		});

		$(".btn_modal_i_proceso").click(function(){
			var idx_current_inicidencia=$(this).attr('item-index');
			$("#form_i_proceso_id_incidencia").val(incidencias_array[idx_current_inicidencia]['id']);
			$("#modal_i_proceso").modal('show');

		});

		$(".btn_modal_i_terminar").click(function(){
			var idx_current_inicidencia=$(this).attr('item-index');
			$("#form_i_terminar_id_incidencia").val(incidencias_array[idx_current_inicidencia]['id']);
			$("#modal_i_terminar").modal('show');
		});	

		$(".btn_modal_i_cancelar").click(function(){
			var idx_current_inicidencia=$(this).attr('item-index');
			$("#form_i_cancelar_id_incidencia").val(incidencias_array[idx_current_inicidencia]['id']);
			$("#modal_i_cancelar").modal('show');
		});	

		$(".btn_modal_i_editar").click(function(){
			var idx_current_inicidencia=$(this).attr('item-index');
			
			$("#form_i_editar_tipo_incidencia").val(incidencias_array[idx_current_inicidencia]['id_tipo']);

			if(incidencias_array[idx_current_inicidencia]['id_tipo'] == 1){
				$("#form_i_editar_externa").show();
				$("#form_i_editar_interna").hide();

				/*EXTERNA*/
				
				$("#form_i_editar_id_incidencia_externa").val(incidencias_array[idx_current_inicidencia]['id']);
				//$("#form_i_editar_id_plan_estudios_externa").val(incidencias_array[idx_current_inicidencia]['id_plan_estudios']);

				//$("#form_i_editar_numero_empleado_externa").val(incidencias_array[idx_current_inicidencia]['numero_empleado']);
				//$("#form_i_editar_idpersona_externa").val(incidencias_array[idx_current_inicidencia]['id_persona']);

				$("#form_i_editar_nombre_reporta_externa").val(incidencias_array[idx_current_inicidencia]['nombre_usuario_reporta']);
				$("#form_i_editar_nombre_registra_externa").val(incidencias_array[idx_current_inicidencia]['nombre_usuario_registra']);
				$("#form_i_editar_nombre_soluciona_externa").val(incidencias_array[idx_current_inicidencia]['nombre_usuario_soluciona']);

				$("#form_i_editar_id_categoria_externa").val(incidencias_array[idx_current_inicidencia]['id_categoria']);

				var data_ajax={
					id_categoria:incidencias_array[idx_current_inicidencia]['id_categoria']
				};
				GetAjax(data_ajax, "get_problematicas_by_categoria", function(data){
					RefreshComboBox("form_i_editar_problematica_externa", data, "id", "nombre");
					$("#form_i_editar_problematica_externa").val(incidencias_array[idx_current_inicidencia]['id_problematicas']);
				});

				$("#form_i_editar_comentarios_externa").val(incidencias_array[idx_current_inicidencia]['comentarios']);
				$("#form_i_editar_correo_externa").val(incidencias_array[idx_current_inicidencia]['correo']);
				$("#form_i_editar_numero_telefonico_externa").val(incidencias_array[idx_current_inicidencia]['telefono']);
			

			$("#modal_i_editar").modal('show');

			}
			else if(incidencias_array[idx_current_inicidencia]['id_tipo'] == 2){

				$("#form_i_editar_externa").hide();
				$("#form_i_editar_interna").show();
				
				/*INTERNA*/
				$("#form_i_editar_id_plan_estudios_interna").val(incidencias_array[idx_current_inicidencia]['id_plan_estudio']);
				$("#form_i_editar_numero_empleado_interna").val(incidencias_array[idx_current_inicidencia]['numero_empleado']);

				$("#form_i_editar_id_incidencia_interna").val(incidencias_array[idx_current_inicidencia]['id']);
				$("#form_i_editar_id_categoria_interna").val(incidencias_array[idx_current_inicidencia]['id_categoria']);
				
				$("#form_i_editar_nombre_reporta_interna").val(incidencias_array[idx_current_inicidencia]['nombre_usuario_reporta']);
				$("#form_i_editar_nombre_registra_interna").val(incidencias_array[idx_current_inicidencia]['nombre_usuario_registra']);
				$("#form_i_editar_nombre_soluciona_interna").val(incidencias_array[idx_current_inicidencia]['nombre_usuario_soluciona']);


				var data_ajax={
					id_categoria:incidencias_array[idx_current_inicidencia]['id_categoria']
				};

				GetAjax(data_ajax, "get_problematicas_by_categoria", function(data){
					RefreshComboBox("form_i_editar_problematica_interna", data, "id", "nombre");
					$("#form_i_editar_problematica_interna").val(incidencias_array[idx_current_inicidencia]['id_problematicas']);
				});

				$("#form_i_editar_comentarios_interna").val(incidencias_array[idx_current_inicidencia]['comentarios']);
				$("#form_i_editar_correo_interna").val(incidencias_array[idx_current_inicidencia]['correo']);
				$("#form_i_editar_numero_telefonico_interna").val(incidencias_array[idx_current_inicidencia]['telefono']);
				$("#form_i_editar_fecha_terminacion_interna").val(incidencias_array[idx_current_inicidencia]['fecha_terminacion']);
				$("#modal_i_editar").modal('show');

				
			}
			else{

				$("#form_i_editar_externa").hide();
				$("#form_i_editar_interna").hide();
			}


			
		});	

	}

	$("#btn_form_i_search").click(function(e){
		var data_ajax=getFormData($("#form_i_search"));
		GetAjax(data_ajax, "get_incidencias_filtradas", function(incidencias){
			RefreshTableIncidencias(incidencias);
		});
	});

	//------- CODIGO PERTENECIENTE A FORMULARIO DE REGISTRO DE INCIDENCIAS --------------

	$("#form_i_crear_tipo_incidencia").change(function(e){ // FORM CREAR
		if($("#form_i_crear_tipo_incidencia").val() == 1){
			$("#form_i_crear_externa").show();
			$("#form_i_crear_interna").hide();
		}
		else if($("#form_i_crear_tipo_incidencia").val() == 2){
			$("#form_i_crear_externa").hide();
			$("#form_i_crear_interna").show();
		}
		else{
			$("#form_i_crear_externa").hide();
			$("#form_i_crear_interna").hide();
		}
	});

	$("#form_i_editar_tipo_incidencia").change(function(e){ //FORM EDITAR

		if($("#form_i_editar_tipo_incidencia").val() == 1){
			$("#form_i_editar_externa").show();
			$("#form_i_editar_interna").hide();
		}
		else if($("#form_i_editar_tipo_incidencia").val() == 2){
			$("#form_i_editar_externa").hide();
			$("#form_i_editar_interna").show();
		}
		else{
			$("#form_i_editar_externa").hide();
			$("#form_i_editar_interna").hide();
		}

	});



	GetAjax([], "GetPlanEstudios", function(planes){
		RefreshComboBox("form_i_crear_id_plan_estudios_externa", planes, "id", "nombre_corto");
		RefreshComboBox("form_i_editar_id_plan_estudios_externa", planes, "id", "nombre_corto");
		RefreshComboBox("form_i_editar_id_plan_estudios_interna", planes, "id", "nombre_corto");
		RefreshComboBox("form_i_crear_id_plan_estudios_interna", planes, "id", "nombre_corto");
		RefreshComboBox("form_i_search_plataforma", planes, "id", "nombre_corto");

		

	});
	
	GetAjax([], "get_categorias_problematicas_externas", function(categorias_externas){
		RefreshComboBox("form_i_crear_id_categoria_externa", categorias_externas, "id", "nombre");
		RefreshComboBox("form_i_editar_id_categoria_externa", categorias_externas, "id", "nombre");

	});

	$("#form_i_crear_id_categoria_externa").change(function(e){ //FORM CREAR
		if($(this).val().trim() == ""){
			$("#form_i_crear_problematica_externa").html("");
		}
		else{
			var data_ajax={
				id_categoria: $(this).val().trim()
			};
			GetAjax(data_ajax, "get_problematicas_by_categoria", function(data){
				RefreshComboBox("form_i_crear_problematica_externa", data, "id", "nombre");
			});
		}
	});

	GetAjax([], "get_categorias_problematicas_internas", function(categorias_internas){
		RefreshComboBox("form_i_crear_id_categoria_interna", categorias_internas, "id", "nombre");
		RefreshComboBox("form_i_editar_id_categoria_interna", categorias_internas, "id", "nombre");
	});

	$("#form_i_crear_id_categoria_interna").change(function(e){
		if($(this).val().trim() == ""){
			$("#form_i_crear_problematica_interna").html("");
		}
		else{
			var data_ajax={
				id_categoria: $(this).val().trim()
			};
			GetAjax(data_ajax, "get_problematicas_by_categoria", function(data){
				RefreshComboBox("form_i_crear_problematica_interna", data, "id", "nombre");
				$("#form_i_crear_problematica_interna").val(data[0]['id']);
			});
		}
	});

	$("#form_i_editar_id_categoria_interna").change(function(e){
		if($(this).val().trim() == ""){
			$("#form_i_editar_problematica_interna").html("");
		}
		else{
			var data_ajax={
				id_categoria: $(this).val().trim()
			};
			GetAjax(data_ajax, "get_problematicas_by_categoria", function(data){
				RefreshComboBox("form_i_editar_problematica_interna", data, "id", "nombre");
				$("#form_i_editar_problematica_interna").val(data[0]['id']);
			});
		}
	});


	$("#form_i_editar_id_categoria_externa").change(function(e){
		if($(this).val().trim() == ""){
			$("#form_i_editar_problematica_externa").html("");
		}
		else{
			var data_ajax={
				id_categoria: $(this).val().trim()
			};
			GetAjax(data_ajax, "get_problematicas_by_categoria", function(data){
				RefreshComboBox("form_i_editar_problematica_externa", data, "id", "nombre");
			});
		}
	});

	$("#form_i_crear_numero_empleado_externa").focusout(function(e){
		if($("#form_i_crear_id_plan_estudios_externa").val() == ""){
			alert("Debe seleccionar un plan de estudios.");
			$(this).val("");
		}else{
			var data_ajax={
				numero_empleado: $(this).val().trim(),
				id_plan_estudios: $("#form_i_crear_id_plan_estudios_externa").val()
			};
			GetAjax(data_ajax, "get_informacion_alumno_by_num_empleado", function(data){
				console.log(data);
				if(data.length == 0){
					//alert("No se encontraron datos del alumno.");
					$("#form_i_crear_idpersona_externa").val("");
					$("#form_i_crear_nombre_alumno_externa").val("Número de empleado invalido, pruebe con un número diferente.");
				}
				else if(data[0]["id_persona"] == undefined || data[0]["id_persona"] == 0 || data[0]["nombre_completo"].trim() == ""){
					//alert("No se encontraron datos del alumno.");
					$("#form_i_crear_idpersona_externa").val("");
					$("#form_i_crear_nombre_alumno_externa").val("Número de empleado invalido, pruebe con un número diferente.");
				}
				else{
					$("#form_i_crear_idpersona_externa").val(data[0]["id_persona"]);
					$("#form_i_crear_nombre_alumno_externa").val(data[0]["nombre_completo"]);
				}
			});
		}
	});


	$("#form_i_crear_fecha_terminacion_interna").datepicker({ // FORM CREAR
      dateFormat: "yy-mm-dd"
    });

	$("#form_i_editar_fecha_terminacion_interna").datepicker({ // FORM EDITAR
      dateFormat: "yy-mm-dd"
    });


	$("#btn_form_i_registrar").click(function(e) { //FORM CREAR
		if($("#form_i_crear_tipo_incidencia").val() == 1){
			SendAjax("form_i_crear_externa", "insert_incidencias_externas", function(){
					
					$('#form_i_crear_externa')[0].reset();
					
					$("#form_i_crear_tipo_incidencia").val("");
					$("#form_i_crear_externa").hide();
					$("#form_i_crear_interna").hide();
					$("#modal_i_crear").modal('hide');

				var data_ajax=getFormData($("#form_i_search"));
				GetAjax(data_ajax, "get_incidencias_filtradas", function(incidencias){
					RefreshTableIncidencias(incidencias);
				});
			});
		}
		else if($("#form_i_crear_tipo_incidencia").val() == 2){
			SendAjax("form_i_crear_interna", "insert_incidencias_internas", function(){				
				$('#form_i_crear_interna')[0].reset();
				$("#form_i_crear_tipo_incidencia").val("2");
				$("#form_i_crear_externa").hide();
				$("#form_i_crear_interna").show();
				$("#modal_i_crear").modal('hide');
				var data_ajax=getFormData($("#form_i_search"));
				GetAjax(data_ajax, "get_incidencias_filtradas", function(incidencias){
					RefreshTableIncidencias(incidencias);
				});
			});
		}
		else{
			alert("Debe seleccionar el tipo de incidencia antes de continuar.");
		}
	});



	$("#btn_form_i_editar").click(function(e) { //FORM EDITAR
		if($("#form_i_editar_tipo_incidencia").val() == 1){
			SendAjax("form_i_editar_externa", "update_incidencias_externas", function(){
					$("#modal_i_editar").modal('hide');
					$("#form_i_editar_tipo_incidencia").val("");
					$("#form_i_editar_externa").hide();
					$("#form_i_editar_interna").hide();
					var data_ajax=getFormData($("#form_i_search"));
					GetAjax(data_ajax, "get_incidencias_filtradas", function(incidencias){
						RefreshTableIncidencias(incidencias);
					});
			});
		}
		else if($("#form_i_editar_tipo_incidencia").val() == 2){
			SendAjax("form_i_editar_interna", "update_incidencias_internas", function(){
					$("#modal_i_editar").modal('hide');
					$("#form_i_editar_tipo_incidencia").val("");
					$("#form_i_editar_externa").hide();
					$("#form_i_editar_interna").hide();
					var data_ajax=getFormData($("#form_i_search"));
					GetAjax(data_ajax, "get_incidencias_filtradas", function(incidencias){
						RefreshTableIncidencias(incidencias);
					});
		
			});
		}
		else{
			alert("Debe seleccionar el tipo de incidencia antes de continuar.");
		}
	});


	function GetComentarios(id_inci){

		var data_ajax={
			id_incidencia: id_inci
		};

		GetAjax(data_ajax, "GetComentarios", function(coments){
			RefreshComentarios(coments);

		});
	}


	//APLICA LOS PERMISOS PARA LOS FILTROS

	var data_ajax_filtro=getFormData($("#form_i_search"));
				GetAjax(data_ajax_filtro, "get_incidencias_filtradas", function(incidencias){
					RefreshTableIncidencias(incidencias);
				});

	
});
