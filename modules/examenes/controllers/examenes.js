$( document ).ready(function() {
  
var id_alumno=0; // id_alumno en cuestion (de escolar)
var id_persona=0; // id_persona en cuestion (de escolar)
var id_moodle=0; // id_alumno en cuestion (de moodle)
var id_current_plan_estudio=0; // inicia con el id plan estudio de dgb
var id_current_corporacion=5; // inicia con el id_corporacion  de dgb


var usuarios;
var idx_current_usuarios=0;
var planes;
var idx_current_planes=0;

var regiones;
var estados;
var ciudades;
var materias;

var idx_current_materias=0;
var id_current_materia=0;
var idx_current_examen=0;
var examenes;

  	function ShowLoading(){
  		$("#loading").fadeIn('fast');
  	}

  	function HideLoading(){
  		$("#loading").fadeOut('fast');
  	} 	


  	$("#id_plan_estudio").change(function() { // cuando cambia el select del plan de estudio
		idx_current_planes=$("#id_plan_estudio option:selected").attr('item-index');
		id_current_plan_estudio=$(this).val();

		$("#view_examenes").hide();
		GetUsuarios();
	});

  	$("#f_e_id_materia").change(function() { // cuando cambia el select del plan de estudio
		idx_current_materias=$("#f_e_id_materia option:selected").attr('item-index');
		id_current_plan_estudio=$(this).val();
		GetExamenesScorm();
	});

	function getFormData($form){
	    var unindexed_array = $form.serializeArray();
	    var indexed_array = {};
	    $.map(unindexed_array, function(n, i){
	        indexed_array[n['name']] = n['value'];
	    });

	    return indexed_array;
	}

    function validarTipo(input){ //VALIDADOR

		if(input.prop('required')){ // si es requerido
			var valor=input.val();
			var texto=input.children(':selected').text();
			var validado=false;
			if(!valor.trim()=="")// si no esta vacio sigue validando
			{ 
				switch(input.attr("type")) 
				{//Sicumple con los requerimientos de tipo de datos entonces el valor de validado se cambia a true
					case "text":
						if(valor.trim().length>2)
						{
							validado= !validado; //tiene que tener almenos 3 caracteres
						}
					break;

					case "number":
						if(!isNaN(valor))
						{
							validado= !validado; // sies numero
						}
					break;

					case "select":
						if((texto.indexOf("NO DEFINIDO") == -1) && (texto.indexOf("No definido") == -1) )
						{
							validado= !validado; // ES NODEFINIDO
						}
					break;
					case "hidden":
						if(!isNaN(valor))
						{
							validado= !validado; // es numero
						}
					break;

					case "radio": // VALIDA RADIO .   nota : solo funciona con un grupo de input Radios en el form
						var form=input.closest("form"); 
						var checkeds=0;
						var inputsradio=0;
						$("#"+form.attr('id')+" input:radio").each(function(){
							if($(this).is( ":checked" )){ // si es checked
								checkeds++;
							}
							inputsradio++;
						});
						if(checkeds>=1){ // SI TIENE UNO CHECKED entonces es true
							validado= !validado; 
						}

					break;
					default:
					break;
				} 
 

					return validado;
				
			}else
			{ // si está vacio devuelve false
				validado;
			}
		}else
		{
			return true;
		}
	}


	function SendAjax(form_element,request,function_after){
			var $form = $(".input-"+form_element);
			var validado=true;
			$form.each(function(){
				var input = $(this);
				input.parent().removeClass("has-error");
				if(!validarTipo(input)  ){
					if(input.attr("error")){
						alert(input.attr("error"));
					}
					input.focus();
					input.parent().toggleClass("has-error");
					validado=false;
					 return false;
				}
			});

			if(validado){
				ShowLoading();
				 var postData = 
	                {
	                    'request':request,
	                    'data':getFormData($("#"+form_element))
	                };

				$.post( 
					"php/ajaxHandler.php", postData
					  ).done(function( data ) {
					  	try {
					  		var datos=JSON.parse(data);
						  	if(datos['success']==true){
						  		alert(datos['message']);
						  		console.log("SEND AJAX correctamente: "+request);
						  		$("#"+form_element)[0].reset();
						  		function_after();
						  	}else{
						  		alert(datos['message']);
						    	console.log( "error al  SEND AJAX 2: "+datos['message'] );
						  	}	
					  	}catch(e){
					    	console.log( "error al SEND AJAX 3: "+data);

					  	}
			  	
				  	
				 }).fail(function( err) {

					   var keys = "";
					   for(var key in err){
					      keys+="|"+key;
					   }
					
					    console.log( "error al SEND AJAX 1: "+keys );
					    console.log( "error al SEND AJAX 1: "+err.responseText );
					    console.log( err.responseText );
					    console.log( err.getAllResponseHeaders() );
   						 console.log( err.getResponseHeader("Content-Type") );
   						  console.log( err.statusText );

   						 console.log( err.status );
   						 console.log( err.error );

					  })
					  .always(function() {
					    //alert( "finished" );
					    HideLoading();
				});
			}	
	}



	function GetAjax(data_array,request,result){
			var validado=true;
			if(validado){
					ShowLoading();
				 var postData = 
	                {
	                    'request':request,
	                    'data':data_array
	                };

				 $.post( 
					"php/ajaxHandler.php", postData
					  ).done(function( data ) {
					  	try {
					  		var datos=JSON.parse(data);
						  	if(datos['success']==true){
						  		console.log( "GetAjax correctamente "+request);
						  		result(datos['data']);
						  	}else{
						  		console.log( "error al  getAjax 2: "+request+" "+datos['message'] );
						  		result(datos['data']);
						  	}	
					  	}catch(e){
					    	console.log( "error:"+e+" | ERROR al getAjax 3: "+request+" "+data);
					    	result([]);
					  	}
				 }).fail(function() {
					    console.log("error al getAjax  1 "+request+" ");
					    result([]);
					  })
					  .always(function() {
					    HideLoading();
				});
				
				return result;
			}	
	}


	function GetUsuarios(){
			var data_ajax= {
				'id_moodle':$("#id_moodle").val(),
				'id_plan_estudio':$("#id_plan_estudio").val(),
				'numero_empleado':$("#numero_empleado").val(),
				'nombre':$("#nombre_completo").val()

			};

		GetAjax(
			data_ajax,
			"GetUsuarios",
			function(response){
				RefreshUsuarios(response);
				$("#view_usuarios").show();

				$("#view_insert_usuario").hide();
			}
		);

	}


	function GetMaterias(){
			var data_ajax= {
				'id_plan_estudio':$("#f_e_id_plan_estudio").val()

			};

		GetAjax(
			data_ajax,
			"GetMaterias",
			function(response){
				RefreshMaterias(response);
				GetExamenesScorm();
			}
		);
	}

	function GetExamenesScorm(){
			var data_ajax= {
				'id_plan_estudio':$("#f_e_id_plan_estudio").val(),
				'id_moodle':$("#f_e_id_moodle").val(),
				'id_materia':$("#f_e_id_materia").val()

			};

		GetAjax(
			data_ajax,
			"GetExamenesScorm",
			function(response){
				RefreshExamenes(response);
				idx_current_examen=0;
			}
		);
	}

	function UpdateExamen(){
		SendAjax(
			"f_e_scoe"+idx_current_examen,
			"UpdateExamen",
			function(){
				GetExamenesScorm();
			}
		);
	}
	function ResetExamen(){
		SendAjax(
			"f_e_scoe"+idx_current_examen,
			"ResetExamen",
			function(){
				GetExamenesScorm();
				$("#modal_reiniciar").modal('hide');
			}
		);
	}


/*######## usuariosS CLICKS LISTENERS ########*/
	$("#btn_form_search").click(function(){
			GetUsuarios();
	});


		$("#reset_examen_modal_btn").click(function(){
			ResetExamen();
		});


	function RefreshPlanEstudios(planes_){
		var html_planes="";
		if(planes_.length==0 || planes_==null || planes_===undefined){
			html_planes="<option value='0'>Sin planes de estudio</option>";
            planes=[];
		}else{
			planes=planes_;
			for (var i = 0; i < planes_.length; i++) {
	            html_planes+='	<option  item-index="'+i+'" value="'+planes_[i]['id']+'"  >'+planes_[i]['nombre']+'</option>'; 

			}		
			$("#id_plan_estudio").empty().append(html_planes);
		}
	}
	function RefreshMaterias(materias_){
		var html_materias="<option value='0'>Seleccione una materia</option>";
		if(materias_.length==0 || materias_==null || materias_===undefined){
			html_materias="<option value='0'>Sin materias</option>";
            materias=[];
		}else{
			materias=materias_;
			for (var i = 0; i < materias_.length; i++) {
	            html_materias+='	<option  item-index="'+i+'" value="'+materias_[i]['id']+'"  >'+materias_[i]['periodo']+' - '+materias_[i]['id']+' - '+materias_[i]['fullname']+'</option>'; 

			}		
			$("#f_e_id_materia").empty().append(html_materias);
		}
	}

	function RefreshUsuarios(usuarios_){
		var html_usuarios="";

		if(usuarios_.length==0 || usuarios_==null || usuarios_===undefined){
			html_usuarios+='<tr  class="text-center" >';
            html_usuarios+='	<td colspan="8" >No Se encontraron usuarios con esos datos O No se encuentra registrado en ESCOLAR.</td>'; 
            html_usuarios+='</tr>';
            usuarios=[];
		}else{
			usuarios=usuarios_;
			for (var i = 0; i < usuarios_.length; i++) {
				html_usuarios+='<tr>';
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuarios_[i]['id_moodle']+'</td>'; 
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuarios_[i]['numero_empleado']+'</td>'; 
	            html_usuarios+='	<td  class="active" item-index="'+i+'"  >'+usuarios_[i]['nombre_plataforma']+'</td>'; 

	            html_usuarios+='	<td >';
	            html_usuarios+='		<a href="#" class="update_usuarios" item-index="'+i+'"   ><span class="glyphicon glyphicon-list-alt" ></span> Examenes</a>'; 
	            html_usuarios+='	</td>';
	            html_usuarios+='</tr>';
			}			
		}

		$("#content_usuarios").empty().append(html_usuarios);

		$(".update_usuarios").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_usuarios=index;
			$("#modal_title_usuario").empty().append('Examenes del Alumno: '+usuarios[idx_current_usuarios]['nombre_plataforma']);
			$("#f_e_id_moodle").val(usuarios[idx_current_usuarios]['id_moodle']);
			$("#f_e_id_persona").val(usuarios[idx_current_usuarios]['id']);
			$("#f_e_id_plan_estudio").val(planes[idx_current_planes]['id']);
			GetMaterias();
			$("#view_examenes").show();

			
		});
	}



	function RefreshExamenes(examenes_){
		var html_examenes="";

		if(examenes_.length==0 || examenes_==null || examenes_===undefined){
			html_examenes+='<tr  class="text-center" >';
            html_examenes+='	<td colspan="8" >No se encontraron examenes hechos por este alumno.</td>'; 
            html_examenes+='</tr>';
            examenes=[];
		}else{
			examenes=examenes_;
			for (var i = 0; i < examenes_.length; i++) {
				html_examenes+='<tr>';

	            html_examenes+='	<td   >'+examenes_[i]['scormid']+'</td>'; 
	            html_examenes+='	<td    >'+examenes_[i]['name']+'</td>'; 
	            if(examenes_[i]['status']=="passed"){
	            	html_examenes+='	<td    ><label class="label label-success" data-toggle="tooltip" title="'+examenes_[i]['tiempo']+'" >'+examenes_[i]['status']+'</label></td>'; 
	            }else if(examenes_[i]['status']=="failed"){
	            	html_examenes+='	<td    ><label class="label label-warning"  data-toggle="tooltip" title="'+examenes_[i]['tiempo']+'">'+examenes_[i]['status']+'</label></td>'; 
	            }else if(examenes_[i]['status']=="complete"){
	            	html_examenes+='	<td     ><label class="label label-info" data-toggle="tooltip" title="'+examenes_[i]['tiempo']+'" >'+examenes_[i]['status']+'</label></td>'; 
	            }else{
	            	html_examenes+='	<td     ><label class="label label-default" data-toggle="tooltip" title="'+examenes_[i]['tiempo']+'">'+examenes_[i]['status']+'</label></td>'; 
	            }

	            html_examenes+='	<td   >'+examenes_[i]['tipo']+'</td>'; 
	            html_examenes+='<td>'; 
	            html_examenes+='	<form id="f_e_scoe'+i+'" name="f_e_scoe'+i+'"  >';
				html_examenes+='		<input id="f_e_scoe_userid'+i+'" type="hidden" name="userid" value="'+examenes_[i]['userid']+'" class="input-f_e_scoe'+i+'" >';
				html_examenes+='		<input id="f_e_scoe_scormid'+i+'" type="hidden" name="scormid" value="'+examenes_[i]['scormid']+'" class="input-f_e_scoe'+i+'" >';
				html_examenes+='		<input id="f_e_scoe_id_plan_estudio'+i+'" type="hidden" name="id_plan_estudio" value="'+planes[idx_current_planes]['id']+'" class="input-f_e_scoe'+i+'" >';
				if(examenes_[i]['status']=="incomplete" || examenes_[i]['status']=="complete"){
					html_examenes+='	<input  type="number" name="kjhgfds"  style="width: 35px; box-sizing: border-box;  border-radius: 4px;" value="'+examenes_[i]['calificacion']+'" disabled>';
				}else{
					html_examenes+='		<input id="f_e_scoe_calificacion'+i+'" type="number" name="calificacion"  style="width: 40px; box-sizing: border-box;  border-radius: 4px;" value="'+examenes_[i]['calificacion']+'" class="input-f_e_scoe'+i+'" ><button type="button" class="btn btn-default update_examenes" item-index="'+i+'" ><span class="glyphicon glyphicon-floppy-disk" ></span></button>';
				}

	           	html_examenes+='	</form>';
	            html_examenes+='</td>'; 

	            html_examenes+='	<td>';
	            html_examenes+='		<button type="button" class="btn btn-danger reset_examenes" item-index="'+i+'">Reiniciar</button>'; 	           
	            html_examenes+='	</td>';

	            html_examenes+='</tr>';
			}			
		}

		$("#content_examenes").empty().append(html_examenes);

		$(".update_examenes").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_examen=index;
			UpdateExamen();
		});

		$(".reset_examenes").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_examen=index;
			$("#modal_reiniciar").modal('show');
		});

		 $('[data-toggle="tooltip"]').tooltip(); 

	}



	function InitializeUsuarios(){
		GetAjax(
			null,
			"GetPlanEstudios",
			function(response){
				RefreshPlanEstudios(response);
			}
		);
	}

		

InitializeUsuarios();



});
