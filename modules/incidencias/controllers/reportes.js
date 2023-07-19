$( document ).ready(function() {


	$(".menus").click(function(){
		$(".menus").removeClass('active');
		$(this).addClass('active');
		$(".views").hide();
		$("#view_"+$(this).attr('view')).show();

	});


	$("#btn_alumnobuscar").click(function(){

		if($("#id_plan_estudio").val()==""){
			alert("Selecciona una plataforma");
			return;
		}
		if($("#numero_empleado").val()==""){
			alert("Ingresa el numero de empleado");
			return;
		}
		GetIncidencias($("#id_plan_estudio").val(),$("#numero_empleado").val());
		GetIncidenciasAlumnoCategorias($("#id_plan_estudio").val(),$("#numero_empleado").val());
	});

	
	function GetComentarios(id_inci){

		var data_ajax={
			id_incidencia: id_inci
		};

		GetAjax(data_ajax, "GetComentarios", function(coments){
				RefreshComentarios(coments);

		});
	}



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

						if(i>0 && (comentarios_array[i]['estatus'] == 1 || comentarios_array[i]['estatus'] == 5) && comentarios_array[i]['comentarios'] != comentarios_array[i]['primer_comentario'] ){
							codigo_comentarios+='<div class="alert alert-primary" >Estatus:<label class="label label-primary" >En espera</label> <small class="pull-right" >'+comentarios_array[i]['fecha_registro']+'</small> <div class="well" >Problematica: <br>'+comentarios_array[i]['comentarios']+'</div></div>';
						}
						else if(i==0 && (comentarios_array[i]['estatus'] == 1 || comentarios_array[i]['estatus'] == 5) ){
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


				//codigo_table_incidencias+='	<button item-index="'+i+'" class="btn btn-success  btn_modal_i_terminar"  type="button" ><span class="glyphicon glyphicon-ok"></span></button>';
				//codigo_table_incidencias+='	<button item-index="'+i+'" class="btn btn-info btn_modal_i_proceso"  type="button" ><span class="glyphicon glyphicon-time"></span></button>';
				//+='	<button item-index="'+i+'" class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_i_eliminar" ><span class="glyphicon glyphicon-trash"></span></button>';  
			   	//codigo_table_incidencias+='	<button item-index="'+i+'" class="btn btn-info" type="button"  data-toggle="modal" data-target="#modal_i_trans"><span class="glyphicon glyphicon-random"></span></button>';

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
	}

	function GetIncidenciasTotales(){
		GetAjax([],"GetIncidenciasTotales",function(response){
			$("#i_g_activas").empty().append(parseInt(response[0]['conteo'])+parseInt(response[4]['conteo']));
			$("#i_g_proceso").empty().append(response[1]['conteo']);
			$("#i_g_realizadas").empty().append(response[2]['conteo']);
			$("#i_g_canceladas").empty().append(response[3]['conteo']);
 			 CanvasJS.addColorSet("statusColors",
                [//colorSet Array
                "Grey",
                "Skyblue",
                "Green",
                "Red"                
                ]);
			var chart = new CanvasJS.Chart("grafica_totales",
			{
				colorSet:"statusColors",
				title:{
					text: "Grafica Incidencias"
				},

				data: [
				{
					type: "bar",

					dataPoints: [
					{ x: 10, y: parseInt(response[0]['conteo'])+parseInt(response[4]['conteo']), label:"Activas" },
					{ x: 20, y: parseInt(response[1]['conteo']), label:"En proceso" },
					{ x: 30, y: parseInt(response[2]['conteo']), label:"Realizadas" },
					{ x: 40, y: parseInt(response[3]['conteo']), label:"Canceladas" }
					]
				}
				]
			});

			chart.render();
		});
	}

	function GetIncidenciasTotalesCategorias(){
		GetAjax([],"GetIncidenciasTotalesCategorias",function(response){
				var datosGraf=[];
					for (var i = response.length - 1; i >= 0; i--) {
						datosGraf.push({ x: i+10, y: parseInt(response[i]['conteo']), label: response[i]['nombre'] });
					}
				 CanvasJS.addColorSet("statusColors",
                [//colorSet Array

                "Grey",
                "Skyblue",
                "Green",
                "Red"                
                ]);
			var chart = new CanvasJS.Chart("grafica_categorias",
			{
				
				title:{
					text: "Por Categorias"
				},

				data: [
					{
						type: "bar",

						dataPoints:datosGraf
					}
				]
			});

			chart.render();
		});
	};

	function GetIncidenciasAlumnoCategorias(id_plan,n_empleado){
		GetAjax({id_plan_estudio:id_plan,numero_empleado:n_empleado},"GetIncidenciasAlumnoCategorias",function(response){
				var datosGraf=[];
				for (var i = 0; i < response.length; i++) {
						datosGraf.push({ x: i+10, y: parseInt(response[i]['conteo']), label: response[i]['nombre'] });
				}
				 CanvasJS.addColorSet("statusColors",
                [//colorSet Array
                "Grey",
                "Skyblue",
                "Green",
                "Red"                
                ]);
			var chart = new CanvasJS.Chart("grafica_alumno_categorias",
			{
				title:{
					text: "Incidiencias del alumno '"+n_empleado+"' por Categorias"
				},
				data: [
					{
						type: "bar",

						dataPoints:datosGraf
					}
				]
			});
			chart.render();
		});
	};

	function GetIncidenciasTotalesPlataformas(){
		GetAjax({},"GetIncidenciasTotalesPlataformas",function(response){
				var datosGraf=[];
				for (var i = 0; i < response.length; i++) {
						datosGraf.push({  y: parseInt(response[i]['conteo']), indexLabel: response[i]['nombre'] });
				}

			var chart = new CanvasJS.Chart("grafica_plataformas",
			{
				theme: "theme2",
				title:{
					text: "Incidencias por Plataforma"
				},
				data: [
					{
						type: "pie",
						showInLegend: true,
						toolTipContent: "{y} - #percent %",
						legendText: "{indexLabel}",
						dataPoints: datosGraf
					}
				]
			});
			chart.render();
		});

	}

	function GetIncidencias(id_plan,numero_empleado){
		var data_ajax_filtro={
				form_i_search_plataforma:id_plan,
				form_i_search_numero_empleado:numero_empleado,
				formato_fecha_master:"",
					}
				GetAjax(data_ajax_filtro, "GetIncidenciasByAlumno", function(incidencias){
					RefreshTableIncidencias(incidencias);
				});
	};

	function InitializeReportes(){
			GetAjax([], "GetPlanEstudios", function(planes){
				RefreshComboBox("id_plan_estudio", planes, "id", "nombre_corto");
			});

			GetIncidenciasTotales();
			GetIncidenciasTotalesCategorias();
			GetIncidenciasTotalesPlataformas();
	}
	InitializeReportes();
});