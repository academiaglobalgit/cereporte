$( document ).ready(function() {
  	var ShowDoge=false; //muestra dogge
  	var ShowDogeCounts=0; //muestra dogge

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

	function ShowMensaje(msg){
	$('#modal_aviso_msg').html(msg);
	$('#modal_aviso').modal('show');
	}

  	function ShowLoading(){

  		if(ShowDoge){
  			 $("#loading_dog").fadeIn('fast');

  		}else{
  			 $("#loading").fadeIn('fast');
  		}
  	}

  	function HideLoading(){

  		$(".loading").fadeOut('fast');

  	} 	

  	$("#dog_count").click(function() { // cuando cambia el select del plan de estudio
		ShowDogeCounts++;
		if(ShowDogeCounts>15){
			ShowDoge=true;
			$(".img-circle").removeAttr("src");
			$(".img-circle").attr("src","assets/img/shiva.gif");
		}
	});

  	$("#id_plan_estudio").change(function() { // cuando cambia el select del plan de estudio
		idx_current_planes=$("#id_plan_estudio option:selected").attr('item-index');
		id_current_plan_estudio=$(this).val();
	});


  	$("#f_i_id_plan_estudio").change(function() { // cuando cambia el select del plan de estudio

		if($(this).val()==16 || $(this).val()==21 || $(this).val()==19){
			GetEscuelas();


			if($(this).val()==16){
				$(".input-generacion").show();
			}

			$(".input-uclescuelas").show();


		} else{
			$(".input-uclescuelas").hide();
			$(".input-generacion").hide();
		}

		GetRegiones();
	});

  	$("#f_i_id_estado").change(function() { // cuando cambia el select del plan de estudio
		GetCiudades();
	});

 	$("#f_i_id_ciudad").change(function() { // cuando cambia el select del plan de estudio
		var idx=$("#f_i_id_ciudad option:selected").attr('item-index');
		$("#f_i_nombre_ciudad").val(ciudades[idx]['nombre']);
		$("#f_i_nomenclatura_ciudad").val(ciudades[idx]['nomenclatura']);
	});

 	$("#f_i_id_region").change(function() { // cuando cambia el select del plan de estudio
		var idx=$("#f_i_id_region option:selected").attr('item-index');
		$("#f_i_nombre_region").val(regiones[idx]['nomenclatura']);
	});

	$("#f_u_id_region").change(function() { // cuando cambia el select del region
		var nombre_region=$("#f_u_id_region option:selected").text();
		$("#f_u_nombre_region").val(nombre_region);
	});

	$("#f_u_id_estado").change(function() { // cuando cambia el select del id_estado
		var idx=$("#f_i_id_region option:selected").attr('item-index');
		GetSucursales();

	});


	$("#f_u_id_sucursal").change(function() { // cuando cambia el select del id_sucursal
		var abc=$("#f_u_id_sucursal option:selected").val();
		//ShowMensaje(abc);

	});

	/*END THREAD UPDATE BUTTONS*/

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
						if(valor.trim().length>1)
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
						ShowMensaje(input.attr("error"));
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
						  		ShowMensaje(datos['message']);
						  		console.log("SEND AJAX correctamente: "+request);
						  		$("#"+form_element)[0].reset();
						  		function_after();
						  	}else{
						  		ShowMensaje(datos['message']);
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
					    //ShowMensaje( "finished" );
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
				$("#view_usuario_update").hide();
			}
		);

	}

function GetRegiones(){
		var data_ajax= {
				'id_plan_estudio':$("#f_i_id_plan_estudio").val()
			};

		GetAjax(
			data_ajax,
			"GetRegiones",
			function(response){
				RefreshRegiones(response);

			}
		);
}


function GetRegionesUpdate(){
		var data_ajax= {
				'id_plan_estudio':$("#f_u_id_plan_estudio").val()
			};

		GetAjax(
			data_ajax,
			"GetRegiones",
			function(response){
				RefreshComboBoxRegion("f_u_id_region",response,'id','nomenclatura');
				$("#f_u_id_region").val(usuarios[idx_current_usuarios]['region']);	
				$("#f_u_nombre_region").val($("#f_u_id_region option:selected").text());		
			}
		);
}
function GetEstados(){
		var data_ajax= {
				'id_plan_estudio':$("#f_i_id_plan_estudio").val()
			};

		GetAjax(
			data_ajax,
			"GetEstados",
			function(response){
				RefreshEstados(response);
				GetCiudades();
			}
		);
}
function GetCiudades(){
			var data_ajax= {
				'id_estado':$("#f_i_id_estado").val()
			};

		GetAjax(
			data_ajax,
			"GetCiudades",
			function(response){
				RefreshCiudades(response);
			}
		);
}
function GetSucursales(){
		var data_ajax= {
			'id_plan_estudio':$("#f_u_id_plan_estudio").val(),
			'id_estado':$("#f_u_id_estado").val()
		};

		GetAjax(
			data_ajax,
			"GetSucursales",
			function(response){
				RefreshComboBox("f_u_id_sucursal",response,'id','numero_nombre');
				$("#f_u_id_sucursal").val(usuarios[idx_current_usuarios]['sucursal']);
			}
		);
}

function GetEscuelas (){
		var data_ajax= {
				'id_plan_estudio':$("#f_i_id_plan_estudio").val()
			};

		GetAjax(
			data_ajax,
			"GetEscuelas",
			function(response){
				RefreshComboBox("f_i_id_escuela",response,'id','name');
			}
		);
}

	function GetMotivosBajasTelefonos (){
			var data_ajax= {
				
				};

			GetAjax(
				data_ajax,
				"GetMotivosBajasTelefonos",
				function(response){
					RefreshComboBox('form_modal_telefonos_id_motivo_baja',response,'id','nombre');
				}
			);
	}
	function GetTelefonos (){
			var data_ajax= {
					'id_alumno':$("#f_u_id_alumno").val()
				};

			GetAjax(
				data_ajax,
				"GetTelefonos",
				function(response){
					RefreshTelefonos(response);
				}
			);
	}


	$("#btn_insert_telefono").click(function(){
		SendAjax(
			"form_telefono_insert",
			"InsertTelefono",
			function(){
				$("#form_telefono_insert_telefono").val("");
				 GetTelefonos();
			});
	});


	$("#btn_form_delete_telefono").click(function(){
		SendAjax(
			"form_modal_telefonos",
			"DeleteTelefono",
			function(){

				$("#form_modal_telefonos_id_motivo_baja").val("");
		
				$("#modal_telefonos").modal('hide');
				 GetTelefonos ();
			
			});
	});

/*######## usuariosS CLICKS LISTENERS ########*/
	$("#btn_form_search").click(function(){
			GetUsuarios();

	});

	$("#btn_new_usuario").click(function(){
			$("#view_usuarios").hide();
			$("#view_insert_usuario").show();
	});
	
	$("#btn_cancelar_new_usuario").click(function(){
			$("#view_usuarios").show();
			$("#view_insert_usuario").hide();
	});

	$("#btn_form_usuario_update").click(function(){
		SendAjax(
			"form_usuario_update",
			"UpdateUsuario",
			function(){
				
					$("#view_usuario_update").hide();
					$("#view_usuarios").show();
				GetUsuarios();
			});
	});

	$("#btn_usuario_insert").click(function(){
		SendAjax(
			"form_usuario_insert",
			"InsertUsuario",
			function(){

				$("#f_i_nombre").val("");
				$("#f_i_apellido1").val("");
				$("#f_i_apellido2").val("");

				$("#f_i_tipo_alumno").val("");

				$("#f_i_fecha_nacimiento").val("");
				$("#f_i_tipo_alumno").val("");

				$("#f_i_telefono_casa").val("");
				$("#f_i_telefono_celular").val("");
				$("#f_i_telefono_alternativo").val("");

				$("#f_i_email").val("");
				$("#f_i_id_estado").val("");
				$("#f_i_id_ciudad").val("");

				$("#f_i_id_region").val("");
				$("#f_i_numero_empleado").val("");

				$("#f_i_numero_sucursal").val("");
				$("#f_i_nombre_sucursal").val("");
				
				$("#f_i_sexo").val(0);
				$("#f_i_curp").val("");
				$("#f_i_generacion").val(0);
				$("#view_insert_usuario").hide();
				$("#view_usuarios").show();
			});
	});

	$(".btn_form_usuario_update_cancel").click(function(){
			$("#view_usuario_update").hide();
			$("#view_usuarios").show();

	});

	function RefreshComboBox(id_select,arrayData,keyArray_value,keyArray_option){
		var html_combobox="";
		if(arrayData.length==0 || arrayData==null || arrayData===undefined){
			html_combobox="<option value=''>Sin Registros</option>";
			$("#"+id_select).empty().append(html_combobox);
		}else{
			html_combobox="<option value=''>Selecciona una opción</option>";
			regiones=arrayData;
			for (var i = 0; i < arrayData.length; i++) {
	            html_combobox+='	<option  value="'+arrayData[i][keyArray_value]+'"  > '+arrayData[i][keyArray_option]+'</option>'; 
			}		
			$("#"+id_select).empty().append(html_combobox);
		}
	}

	function RefreshComboBoxRegion(id_select,arrayData,keyArray_value,keyArray_option){
		var html_combobox="";
		if(arrayData.length==0 || arrayData==null || arrayData===undefined){
			html_combobox="<option value=''>Sin Registros</option>";
			$("#"+id_select).empty().append(html_combobox);
		}else{
			html_combobox="<option value=''>Selecciona una opción</option>";
			regiones=arrayData;
			for (var i = 0; i < arrayData.length; i++) {
	            html_combobox+='	<option  value="'+arrayData[i][keyArray_value]+'"  > '+arrayData[i][keyArray_option]+'</option>'; 
			}		
			$("#"+id_select).empty().append(html_combobox);
		}
	}

	function RefreshRegiones(regiones_){
		var html_regiones="";
		if(regiones_.length==0 || regiones_==null || regiones_===undefined){
			html_regiones="<option value=''>Sin regiones</option>";
            regiones=[];
		}else{
			html_regiones="<option value=''>Selecciona una Region</option>";
			regiones=regiones_;
			for (var i = 0; i < regiones_.length; i++) {
	            html_regiones+='	<option  item-index="'+i+'" value="'+regiones_[i]['id']+'"  >'+regiones_[i]['nomenclatura']+'</option>'; 

			}		
			$("#f_i_id_region").empty().append(html_regiones);
		}
	}

	function RefreshCiudades(ciudades_){
		var html_ciudades="";
		if(ciudades_.length==0 || ciudades_==null || ciudades_===undefined){
			html_ciudades="<option value=''>Sin ciudades</option>";
            ciudades=[];
		}else{
			ciudades=ciudades_;
			html_ciudades="<option value=''>Selecciona una Ciudad</option>";
			for (var i = 0; i < ciudades_.length; i++) {
	            html_ciudades+='	<option  item-index="'+i+'" value="'+ciudades_[i]['id']+'"  >'+ciudades_[i]['nombre']+'</option>'; 
			}		
			$("#f_i_id_ciudad").empty().append(html_ciudades);
		}
	}

	function RefreshEstados(estados_){
		var html_estados="";
		if(estados_.length==0 || estados_==null || estados_===undefined){
			html_estados="<option value=''>Sin estados</option>";
            estados=[];
		}else{
			estados=estados_;
						html_estados="<option value=''>Selecciona un estado</option>";

			for (var i = 0; i < estados_.length; i++) {
	            html_estados+='	<option  item-index="'+i+'" value="'+estados_[i]['id']+'"  >'+estados_[i]['nombre']+'</option>'; 
			}		
			$("#f_i_id_estado").empty().append(html_estados);
			$("#f_u_id_estado").empty().append(html_estados);
		}
	}

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
			$("#f_i_id_plan_estudio").empty().append(html_planes);
		}
	}
	function RefreshTelefonos(telefonos_){
		var html_telefonos="";
		if(telefonos_.length==0 || telefonos_==null || telefonos_===undefined){
			html_telefonos+='<tr  class="text-center" >';
            html_telefonos+='	<td colspan="3" >El alumno no cuenta con telefonos registrados.</td>'; 
            html_telefonos+='</tr>';
          
		}else{
			
			for (var i = 0; i < telefonos_.length; i++) {
				html_telefonos+='<tr>';
	            html_telefonos+='	<td   item-index="'+i+'"  >'+telefonos_[i]['numero_telefonico']+'</td>'; 
	            html_telefonos+='	<td >';
	            html_telefonos+='		<a type="button"  href="#" class="btn btn-danger btn_modal_telefono" item-index="'+i+'"   ><i class="glyphicon glyphicon-remove"></i></a>'; 
	            html_telefonos+='	</td>';
	            html_telefonos+='</tr>';
			}			
		}

		$("#tabla_telefonos_alumno").empty().append(html_telefonos);

		$(".btn_modal_telefono").click(function(){
			var index=parseInt($(this).attr("item-index"));
			$("#form_modal_telefonos_id_telefono").val(telefonos_[index]['id']);
			$("#form_modal_telefonos_id_motivo_baja").val("");
			$('#modal_telefonos').modal('show');
		});
	}

	function RefreshUsuarios(usuarios_){
		var html_usuarios="";
		if(usuarios_.length==0 || usuarios_==null || usuarios_===undefined){
			html_usuarios+='<tr  class="text-center" >';
            html_usuarios+='	<td colspan="11" >No Se encontraron usuarios con esos datos O No se encuentra registrado en ESCOLAR.</td>'; 
            html_usuarios+='</tr>';
            usuarios=[];
		}else{
			usuarios=usuarios_;
			for (var i = 0; i < usuarios_.length; i++) {
				html_usuarios+='<tr>';
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuarios_[i]['idmoodle']+'</td>'; 
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuarios_[i]['numero_empleado']+'</td>'; 
	            html_usuarios+='	<td  class="active" item-index="'+i+'"  >'+usuarios_[i]['username']+'</td>'; 
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuarios_[i]['nombre']+'</td>'; 
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuarios_[i]['apellido1']+'</td>'; 
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuarios_[i]['apellido2']+'</td>'; 
	            html_usuarios+='	<td  class="active" item-index="'+i+'"  >'+usuarios_[i]['nombre_plataforma']+'</td>'; 
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuarios_[i]['numero_telefonico']+'</td>'; 
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuarios_[i]['nombre_estado']+'</td>'; 
	            html_usuarios+='	<td >';
	            html_usuarios+='		<button type="button" class="btn btn-default update_usuarios" item-index="'+i+'"   > <i class="glyphicon glyphicon-edit"></i></button>'; 
	            html_usuarios+='	</td>';
	          /*
	          	html_usuarios+='	<td >';
	            html_usuarios+='		<button type="button" class="btn btn-default pagos_usuarios" item-index="'+i+'"   > <i class="glyphicon glyphicon-credit-card"></i></button>'; 
	            html_usuarios+='	</td>';

	          */
	            html_usuarios+='</tr>';
			}			
		}

		$("#content_usuarios").empty().append(html_usuarios);
		$(".pagos_usuarios").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_usuarios=index;
			$("#form_pago_nombre").val(usuarios[idx_current_usuarios]['nombre']);
			$("#form_pago_id_moodle").val(usuarios[idx_current_usuarios]['idmoodle']);
			$("#form_pago_id_persona").val(usuarios[idx_current_usuarios]['id']);
			$("#form_pago_id_plan_estudio").val(usuarios[idx_current_usuarios]['id_plan_estudio']);
			$("#form_pago_id_alumno").val(usuarios[idx_current_usuarios]['id_alumno']);
			$("#form_pago_numero_empleado").val(usuarios[idx_current_usuarios]['numero_empleado']);
			$("#form_pago_fecha_pago").val("");
			$("#form_pago_fecha_pago_periodo").val("");
			$("#form_pago_monto").val("");

			$("#form_pago_nomenclatura").val("");
			$("#form_pago_reactivar").prop( "checked", false );
			$("#modal_pago").modal('show');
		});
		$(".update_usuarios").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_usuarios=index;

			$("#modal_title_usuario").empty().append('Edición de Alumno: '+usuarios[idx_current_usuarios]['nombre']+' '+usuarios[idx_current_usuarios]['apellido1']+' '+usuarios[idx_current_usuarios]['apellido2']);
			
			$("#f_u_nombre").val(usuarios[idx_current_usuarios]['nombre']);
			$("#f_u_id_moodle").val(usuarios[idx_current_usuarios]['idmoodle']);
			$("#f_u_apellido1").val(usuarios[idx_current_usuarios]['apellido1']);
			$("#f_u_apellido2").val(usuarios[idx_current_usuarios]['apellido2']);
			$("#f_u_id_persona").val(usuarios[idx_current_usuarios]['id']);
			$("#f_u_id_plan_estudio").val(usuarios[idx_current_usuarios]['id_plan_estudio']);
			$("#f_u_username").val(usuarios[idx_current_usuarios]['username']);
			$("#f_u_numero_empleado").val(usuarios[idx_current_usuarios]['numero_empleado']);
			$("#f_u_fecha_nacimiento").val(usuarios[idx_current_usuarios]['fecha_nacimiento']);
			$("#f_u_tipo_alumno").val(usuarios[idx_current_usuarios]['tipo']);
			$("#f_u_id_estado").val(usuarios[idx_current_usuarios]['estado']);
			$("#f_u_numero_sucursal").val(usuarios[idx_current_usuarios]['numero_sucursal']);
			$("#f_u_nombre_sucursal").val(usuarios[idx_current_usuarios]['nombre_sucursal']);
			$("#f_u_horario").val(usuarios[idx_current_usuarios]['horario']);
			$("#f_u_sexo").val(usuarios[idx_current_usuarios]['sexo']);
			$("#f_u_email").val(usuarios[idx_current_usuarios]['email']);
			$("#f_u_curp").val(usuarios[idx_current_usuarios]['curp']);
			$("#f_u_id_alumno").val(usuarios[idx_current_usuarios]['id_alumno']);
			$("#form_telefono_insert_id_alumno").val(usuarios[idx_current_usuarios]['id_alumno']);
			if(parseInt(usuarios[idx_current_usuarios]['id_area'])==0){
					$("#f_u_id_area").val(12);

			}else{
					$("#f_u_id_area").val(usuarios[idx_current_usuarios]['id_area']);

			}
			GetRegionesUpdate();
			GetSucursales();
			GetTelefonos();
			 
			//$("#modal_usuario_update").modal('show');
			$("#view_usuarios").hide();
			$("#view_usuario_update").show();

			if(usuarios[idx_current_usuarios]['id_plan_estudio']==9 || usuarios[idx_current_usuarios]['id_plan_estudio']==10){
				$(".input-a1toks").show();
				$(".input-a1toks").each(function(){
					//$(this).removeAttr("disabled");
				});

			}else if(usuarios[idx_current_usuarios]['id_plan_estudio']==16 || usuarios[idx_current_usuarios]['id_plan_estudio']==21 || usuarios[idx_current_usuarios]['id_plan_estudio']==19){

				$(".input-uclescuelas").show();

				$(".input-a1toks").hide();
				$(".input-a1toks").each(function(){
					//$(this).attr("disabled","disabled");
				});

			} else{

				$(".input-a1toks").hide();
				$(".input-a1toks").each(function(){
					//$(this).attr("disabled","disabled");
				});
			}

			

		});
	}



	function CKupdate(){
	    for ( instance in CKEDITOR.instances )
	        CKEDITOR.instances[instance].updateElement();
	}


	function InitializeUsuarios(){
		GetAjax(
			null,
			"GetPlanEstudios",
			function(response){
				RefreshPlanEstudios(response);
			}
		);
		 GetRegiones();
		 GetEstados();
		 GetMotivosBajasTelefonos ();
	}

		

InitializeUsuarios();



});
