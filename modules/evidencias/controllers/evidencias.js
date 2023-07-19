$( document ).ready(function() {
	var url="";

	if(is_plataforma){
		url="https://agcollege.edu.mx/cereporte/modules/evidencias/";
	}

	//var id_alumno=0; // id_alumno en cuestion (de escolar)
	//var id_persona=0; // id_persona en cuestion (de escolar)
	//var id_moodle=0; // id_alumno en cuestion (de moodle)
	//var id_plan_estudio=16; // inicia con el id plan estudio de dgb
	//var id_corporacion=4; // inicia con el id_corporacion  de dgb
	

	//var unidad=0;
	//var course=20;

	var ejercicios;
	var ejercicios_save=[];	
	var ejercicios_finish=[];	
	var idx_current_ejercicios=0;

	window.onbeforeunload = function (e) {
		if(!ejercicios_save[idx_current_ejercicios]){
		    e = e || window.event;

		    // For IE and Firefox prior to version 4
		    if (e) {
		        e.returnValue = 'Estas seguro que quieres salir?';
		    }

		    // For Safari
		    return 'Estas seguro que quieres salir?';	
		}

	};

	function ShowMensaje(msg){
		$('#modal_aviso_msg').html(msg);
		$('#modal_aviso').modal('show');
	}

  	function ShowLoading(){
  	  //	$("#view_editar").hide();

  		$("#view_cargando").show();

  	}

  	function HideLoading(){

  		$(".view_cargando").hide();
  		//$("#view_editar").fadeIn('fast');
  		
  	} 	


  	$("#btn_save").click(function(){


		UpdateEjercicio(function(){
			console.log('Progreso guardado.');
			ejercicios_save[idx_current_ejercicios]=true;

		});
  	});


  	$("#btn_save_finish").click(function(){
  		if(confirm("¿Estas seguro que deseas finalizar tu actividad integradora? \n Si aceptas se dará por terminada tu actividad y ya no podrás hacer modificaciones.")){
  				
				
				UpdateEjercicioFinish(function(){
					console.log('Actividad finalizada.');
					ejercicios_save[idx_current_ejercicios]=true;
					ejercicios_finish[idx_current_ejercicios]=true;
					$("#btn_save").hide();
					$("#btn_save_finish").hide();
					$(".edicion").hide();
					$(".ejercicio_contenido_vista_previa").empty().append(CKEDITOR.instances.ejercicio_contenido.getData());
					$(".vista_previa").show();
					$("#label_finish").show();
				});
  		}else{

  		}
  		
		
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

	function GetEjerciciosHechos(){
		var data_ajax= {
				'id_moodle':id_moodle,
				'course':course,
				'unidad':unidad,
				'id_plan_estudio':id_plan_estudio,
				'id_corporacion':id_corporacion
			};

		GetAjax(
			data_ajax,
			"GetEjerciciosHechos",
			function(response){
				RefreshInicio(response);
				for (var i = 0; i < ejercicios_save.length; i++) {
					ejercicios_save[i]=true;
				}
			}
		);
	}

	function RefreshInicio(ejercicios_hechos){
		if(ejercicios_hechos.length==0 || ejercicios_hechos==null || ejercicios_hechos===undefined){

		}else{
			$("#ejercicios_realizados").empty().append("Ejercicios Realizados "+ejercicios_hechos[0]['hechos']+" de "+ejercicios_hechos[0]['totales']+" ");
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
					url+"php/ajaxHandler.php", postData
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
					url+"php/ajaxHandler.php", postData
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


function GetEjerciciosByMateriaUnidad (){
		var data_ajax= {
				'course':course,
				'unidad':unidad,
				'id_plan_estudio':id_plan_estudio
			};

		GetAjax(
			data_ajax,
			"GetEjerciciosByMateriaUnidad",
			function(response){
				RefreshEjercicios(response);
			}
		);
}
	

	function RefreshEjercicios(ejercicios_){
		var html_ejercicios='<li role="presentation" id="btn_view_inicio" class="active" ><a href="#">Inicio</a></li>';
		if(ejercicios_.length==0 || ejercicios_==null || ejercicios_===undefined){
			html_ejercicios='<li role="presentation" class="active" ><a href="#">Inicio</a></li>';

            ejercicios=[];
		}else{
			ejercicios=ejercicios_;
			for (var i = 0; i < ejercicios_.length; i++) {
				ejercicios_save.push(true);
				ejercicios_finish.push(false);
				html_ejercicios+='	<li role="presentation" item-index="'+i+'"  class="ejercicio_tab"><a href="#">Actividad '+(1+i)+'</a></li>'; 

				

			}
				//RenderEjercicio(0); activa el primer ejercicio
		}

		$("#content_ejercicios_tabs").empty().append(html_ejercicios);

		$(".ejercicio_tab").click(function(){
			

			if(ejercicios_save[idx_current_ejercicios]){
					
					var idx=$(this).attr("item-index");
					idx_current_ejercicios=idx;
					$("#view_inicio").hide();
					$("#view_editar").show();
					$(".ejercicio_tab").removeClass("active");
					$("#btn_view_inicio").removeClass("active");
					$(this).toggleClass("active");
					RenderEjercicio(idx_current_ejercicios);
			}else{
				if(confirm("No has guardado tu progreso. ¿Esta seguro que quieres cambiar de actividad? ")){
					
					var idx=$(this).attr("item-index");
					idx_current_ejercicios=idx;
					$("#view_inicio").hide();
					$("#view_editar").show();
					$(".ejercicio_tab").removeClass("active");
					$("#btn_view_inicio").removeClass("active");
					$(this).toggleClass("active");
					RenderEjercicio(idx_current_ejercicios);
				}			
			}


		});

		$("#btn_view_inicio").click(function(){

			if(ejercicios_save[idx_current_ejercicios]){ // ya cuardo
					$("#view_inicio").show();
					$("#view_editar").hide();
					$(".ejercicio_tab").removeClass("active");
					$(this).removeClass("active");

		  			$(this).toggleClass("active");
		  			GetEjerciciosHechos();
			}else{ //no haguardado
				if(confirm("No has guardado tu progreso. ¿Esta seguro que quieres salir de esta Actividad? ")){
					$("#view_inicio").show();
					$("#view_editar").hide();
					$(".ejercicio_tab").removeClass("active");
					$(this).removeClass("active");
					$(this).toggleClass("active");
		  			GetEjerciciosHechos();
				}
			}
			

		});
	}

	function RenderEjercicio(idx_ejercicio){

		$("#ejercicio_titulo").empty().append(ejercicios[idx_ejercicio]['name']);
		$("#ejercicio_desc").empty().append(ejercicios[idx_ejercicio]['content']);
		GetEjercicioAlumno(ejercicios[idx_ejercicio]['id']);

		ejercicios_save[idx_ejercicio]=false;
	}

	function GetEjercicioAlumno(id_ejercicio){
		var data_ajax= {
				'id_moodle':id_moodle,
				'id_ejercicio':id_ejercicio,
				'course':course,
				'unidad':unidad,
				'id_plan_estudio':id_plan_estudio,
				'id_corporacion':id_corporacion
			};

		GetAjax(
			data_ajax,
			"GetEjercicioAlumno",
			function(response){
				RefreshContenido(response);
				
			}
		);
	}


	function UpdateEjercicio(function_after){
			var data_ajax= {
				'unidad':unidad,
				'id_moodle':id_moodle,
				'id_ejercicio':ejercicios[idx_current_ejercicios]['id'],
				'course':course,
				'estatus':0,
				'id_corporacion':id_corporacion,
				'id_plan_estudio':id_plan_estudio,
				'contenido':CKEDITOR.instances.ejercicio_contenido.getData()
				
			};
		ShowLoading();
				 var postData = 
	                {
	                    'request':'UpdateEjercicio',
	                    'data':data_ajax
	                };

				$.post( 
					url+"php/ajaxHandler.php", postData
					  ).done(function( data ) {
					  	try {
					  		var datos=JSON.parse(data);
						  	if(datos['success']==true){
						  		ShowMensaje(datos['message']);
						  		console.log("SEND AJAX correctamente UpdateEjercicio");
						  		function_after();
						  	}else{
						  		ShowMensaje(datos['message']);
						    	console.log( "error al  SEND AJAX 2: "+datos['message'] );
						  	}	
					  	}catch(e){
					    	console.log( "error "+e+" al SEND AJAX 3: "+data);

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


	function UpdateEjercicioFinish(function_after){
			var data_ajax= {
				'unidad':unidad,
				'id_moodle':id_moodle,
				'id_ejercicio':ejercicios[idx_current_ejercicios]['id'],
				'course':course,
				'estatus':1,
				'id_corporacion':id_corporacion,
				'id_plan_estudio':id_plan_estudio,
				'contenido':CKEDITOR.instances.ejercicio_contenido.getData()
				
			};
		ShowLoading();
				 var postData = 
	                {
	                    'request':'UpdateEjercicio',
	                    'data':data_ajax
	                };

				$.post( 
					url+"php/ajaxHandler.php", postData
					  ).done(function( data ) {
					  	try {
					  		var datos=JSON.parse(data);
						  	if(datos['success']==true){
						  		ShowMensaje(datos['message']);
						  		console.log("SEND AJAX correctamente UpdateEjercicio status=1");
						  		function_after();
						  	}else{
						  		ShowMensaje(datos['message']);
						    	console.log( "error al  SEND AJAX 2: "+datos['message'] );
						  	}	
					  	}catch(e){
					    	console.log( "error "+e+" al SEND AJAX 3: "+data);

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


	function RefreshContenido(ejercicio_alumno){

			if(ejercicio_alumno.length==0 || ejercicio_alumno==null || ejercicio_alumno===undefined){
				
				CKEDITOR.instances.ejercicio_contenido.setData('');
				CKEDITOR.instances.ejercicio_contenido.updateElement();
				ejercicios_save[idx_current_ejercicios]=false;
				ejercicios_finish[idx_current_ejercicios]=false;
				$(".vista_previa").hide();
				$(".ejercicio_contenido_vista_previa").empty().append('');
				$("#btn_save").show();
				$("#btn_save_finish").show();
				$(".edicion").show();
				$("#label_finish").hide();
			}else{
				if(parseInt(ejercicio_alumno[0]['estatus'])==1){
					ejercicios_save[idx_current_ejercicios]=true;
					ejercicios_finish[idx_current_ejercicios]=true;
					$("#btn_save").hide();
					$("#btn_save_finish").hide();
					$(".edicion").hide();
					$(".ejercicio_contenido_vista_previa").empty().append(ejercicio_alumno[0]['contenido']);
					$(".vista_previa").show();
					$("#label_finish").show();
				}else{
					ejercicios_save[idx_current_ejercicios]=false;
					ejercicios_finish[idx_current_ejercicios]=false;								
					$(".vista_previa").hide();
					$(".ejercicio_contenido_vista_previa").empty().append(ejercicio_alumno[0]['contenido']);
					$("#btn_save").show();
					$("#btn_save_finish").show();
					$(".edicion").show();
					$("#label_finish").hide();
					CKEDITOR.instances.ejercicio_contenido.setData(ejercicio_alumno[0]['contenido']);
					CKEDITOR.instances.ejercicio_contenido.updateElement();

				}

				
			}

	}
	function RefreshComboBox(id_select,arrayData,keyArray_value,keyArray_option){
		var html_combobox="";
		if(arrayData.length==0 || arrayData==null || arrayData===undefined){
			html_combobox="<option value=''>Sin Registros</option>";
			$("#"+id_select).empty().append(html_combobox);
		}else{
			html_combobox="<option value=''>Selecciona una opción</option>";
			regiones=arrayData;
			for (var i = 0; i < arrayData.length; i++) {
	            html_combobox+='	<option  value="'+arrayData[i][keyArray_value]+'"  >'+arrayData[i][keyArray_option]+'</option>'; 
			}		
			$("#"+id_select).empty().append(html_combobox);
		}
	}





	/*function CKupdate(){
	    for ( instance in CKEDITOR.instances )
	        CKEDITOR.instances[instance].updateElement();
	}*/


	function InitializeEvidencias(){
		GetEjerciciosByMateriaUnidad();
	}

		

InitializeEvidencias();
/*
CKEDITOR.replace('ejercicio_contenido');
*/
/* SE ELIMINAN CIERTAS OPCIONES INNECESARIAS EN EL EDITOR DE LA ACTIVIDADES INTEGRADORAS */
CKEDITOR.replace('ejercicio_contenido', {
							toolbarGroups: [								
								{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
								//{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
								//{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
								//{ name: 'forms' },
								'/',
								{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
								{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
								//{ name: 'links' },
								//{ name: 'insert' },
								'/',
								//{ name: 'styles' },
								{ name: 'colors' },
								//{ name: 'tools' },
								//{ name: 'others' },
								//{ name: 'about' }
							]
                        });


});
