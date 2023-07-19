$( document ).ready(function() {
	var url="";
	var url_compiler="http://agcollege.edu.mx/cereporte/modules/simuladores/";
	if(is_plataforma){
		url="http://agcollege.edu.mx/cereporte/modules/evidencias/";
	}

	//var id_alumno=0; // id_alumno en cuestion (de escolar)
	//var id_persona=0; // id_persona en cuestion (de escolar)
	//var id_moodle=0; // id_alumno en cuestion (de moodle)
	//var id_plan_estudio=0; // inicia con el id plan estudio de dgb
	//var id_corporacion=4; // inicia con el id_corporacion  de dgb
	//var id_lenguaje=1 ; // 1 = SIGNIFICA TEXTO las demas son lenguajes de progrmacion 

	//var unidad=0;
	//var course=20;

	var editor=null;
	var id_tipo=2; // tipo de actividad 1=texto 2=codigo simulador
	var ejercicios;
	var ejercicios_save=[];	
	var ejercicios_finish=[];	
	var idx_current_ejercicios=0;


	window.onbeforeunload = function (e) {
		if(!ejercicios_save[idx_current_ejercicios]){
		    e = e || window.event;

		    // For IE and Firefox prior to version 4
		    if (e) {
		        e.returnValue = '¿Estas seguro que quieres salir?';
		    }

		    // For Safari
		    return '¿Estas seguro que quieres salir?';	
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

	$("#uparchivo").click(function(){

	/*alert("llamar aqui");
                UpdateEjercicio(function(){
                        console.log('Progreso guardado.');
                        ejercicios_save[idx_current_ejercicios]=true;

                });*/
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
					;
						
					if(id_tipo==1){
						$(".ejercicio_contenido_vista_previa").empty().append(CKEDITOR.instances.ejercicio_contenido.getData());
						$(".vista_previa").show();

					} else if(id_tipo==2){
						//$(".ejercicio_contenido_vista_previa").empty().append('<code>'+editor.getValue('\n').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')+'</code>');
						RefreshEditor(editor.getValue(),true,ejercicios[idx_current_ejercicios]['id_lenguaje'],ejercicios[idx_current_ejercicios]['url']);
					
						$(".preview").hide();
					}
					$("#label_finish").show();
              				 $("#uparchivo").hide();
                                        $("#imagen").hide();
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

					if(ejercicios[idx_current_ejercicios]['section']==7){ // texto
						id_tipo=1;
						id_lenguaje=1;
					} else if(ejercicios[idx_current_ejercicios]['section']==9){ // simulador codigo
						id_tipo=2;
						id_lenguaje=ejercicios[idx_current_ejercicios]['id_lenguaje'];
						$("#console .content").empty().append('<p class="msg">Consola Lista.</p>');
					}

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
					if(parseInt(ejercicios[idx_current_ejercicios]['section'])==7){ // texto
						id_tipo=1;
						id_lenguaje=1;
					} else if(parseInt(ejercicios[idx_current_ejercicios]['section'])==9){ // simulador codigo
						id_tipo=2;
						id_lenguaje=ejercicios[idx_current_ejercicios]['id_lenguaje'];
						$("#console .content").empty().append('<p class="msg">Consola Lista.</p>');
					}
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
				'id_tipo':id_tipo,
				'id_lenguaje':id_lenguaje,
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
//alert("entra");
			var contenido="";


			if(id_tipo==1){ //texto
				contenido=CKEDITOR.instances.ejercicio_contenido.getData();
				console.log(contenido);
			}else if(id_tipo=2){ //simulador
				contenido=editor.getValue('\n');

			}
			var ruta_archivo = $("#ruta_archivo").val();	
			var data_ajax= {
				'unidad':unidad,
				'id_moodle':id_moodle,
				'id_ejercicio':ejercicios[idx_current_ejercicios]['id'],
				'course':course,
				'estatus':0,
				'id_tipo':id_tipo,
				'id_lenguaje':id_lenguaje,
				'id_corporacion':id_corporacion,
				'id_plan_estudio':id_plan_estudio,
				'ruta_archivo':ruta_archivo,
				'contenido':contenido
				
			};
//alert(ruta_archivo);
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


			var contenido="";


			if(id_tipo==1){ //texto
				contenido=CKEDITOR.instances.ejercicio_contenido.getData();
			}else if(id_tipo=2){ //simulador
				contenido=editor.getValue('\n');

			}

			 var ruta_archivo = $("#ruta_archivo").val();
			var data_ajax= {
				'unidad':unidad,
				'id_moodle':id_moodle,
				'id_ejercicio':ejercicios[idx_current_ejercicios]['id'],
				'course':course,
				'estatus':1,
				'id_tipo':id_tipo,
				'id_lenguaje':id_lenguaje,
				'id_corporacion':id_corporacion,
				'id_plan_estudio':id_plan_estudio,
				'ruta_archivo':ruta_archivo,
				'contenido':contenido
				
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

				$(".edicion").hide();
				$(".vista_previa").hide();
				$(".actividad_tipo_2").hide();
				

			if(ejercicio_alumno.length==0 || ejercicio_alumno==null || ejercicio_alumno===undefined){
				//alert("entro2");
				CKEDITOR.instances.ejercicio_contenido.setData('');
				CKEDITOR.instances.ejercicio_contenido.updateElement();
				var html_default='';

				ejercicios_save[idx_current_ejercicios]=false;
				ejercicios_finish[idx_current_ejercicios]=false;
				$(".vista_previa").hide();
				$(".ejercicio_contenido_vista_previa").empty().append('');


				if(id_tipo==1){ //actividad normal de texto
					$("#btn_save").show();
					$("#btn_save_finish").show();
					$(".edicion").show();
					$("#label_finish").hide();
					$(".ejercicio_contenido_vista_previa").empty().append('');
				}else if(id_tipo==2){// actividad de simulador codigo
					$(".actividad_tipo_2").show();
					
					$(".preview").show();
					$("#btn_save").show();
					$("#btn_save_finish").show();
					
					$("#label_finish").hide();
					RefreshEditor(html_default,false,ejercicios[idx_current_ejercicios]['id_lenguaje'],ejercicios[idx_current_ejercicios]['url']);
				}
			}else{

				if(id_tipo==1){ //actividad normal de texto

					if(parseInt(ejercicio_alumno[0]['estatus'])==1){	
						//alert("entro1");	
						ejercicios_save[idx_current_ejercicios]=true;
						ejercicios_finish[idx_current_ejercicios]=true;
						$("#btn_save").hide();
						$("#btn_save_finish").hide();
						$(".edicion").hide();
						$(".ejercicio_contenido_vista_previa").empty().append(ejercicio_alumno[0]['contenido']);
                                                //$(".ejercicio_contenido_vista_previa").empty().append(ejercicio_alumno[0]['comentarios']);
						if(ejercicio_alumno[0]['comentarios'] ==""){
							$(".comen").html("");
						}	
						$(".ejercicio_comentarios_vista_previa").empty().append(ejercicio_alumno[0]['comentarios']);
						$(".vista_previa").show();
						$("#label_finish").show();
						$("#uparchivo").hide();
						$("#imagen").hide();
					}else{
						//alert("entro");
						ejercicios_save[idx_current_ejercicios]=false;
						ejercicios_finish[idx_current_ejercicios]=false;								
						$(".vista_previa").hide();
						$(".ejercicio_contenido_vista_previa").empty().append(ejercicio_alumno[0]['contenido']);
						$(".ejercicio_comentarios_vista_previa").empty().append(ejercicio_alumno[0]['comentarios']);
						$("#btn_save").show();
						$("#btn_save_finish").show();
						$(".edicion").show();
						$("#label_finish").hide();
						$(".comen").html("");
						CKEDITOR.instances.ejercicio_contenido.setData(ejercicio_alumno[0]['contenido']);
 						CKEDITOR.instances.ejercicio_contenido.updateElement();
						var file = ejercicio_alumno[0]['file'];
						if(file!== null){
							$(".showImage").html("<h2 class='circularbook'>Visualizar:</h2><a href='files/"+file+"' target='blanck_'>"+file+"</a><input type='hidden' id='ruta_archivo' class='ruta_archivo' name='ruta_archivo' value='"+file+"'>");	
						}	
					}

				}else if(id_tipo==2){// actividad de simulador codigo

					//alert("entro3");
					if(parseInt(ejercicio_alumno[0]['estatus'])==1){
						//alert("ENTRO");
						ejercicios_save[idx_current_ejercicios]=true;
						ejercicios_finish[idx_current_ejercicios]=true;
						$("#btn_save").hide();
						$("#btn_save_finish").hide();			
						$(".actividad_tipo_2").show();
						$(".preview").hide();
						$("#label_finish").show();
						$("#uparchivo").hide();
                                                $("#imagen").hide();						
						RefreshEditor(ejercicio_alumno[0]['contenido'],true,ejercicios[idx_current_ejercicios]['id_lenguaje'],ejercicios[idx_current_ejercicios]['url']);
					}else{
//alert("entro23");
						$(".actividad_tipo_2").show();
						$(".preview").show();

						ejercicios_save[idx_current_ejercicios]=false;
						ejercicios_finish[idx_current_ejercicios]=false;								
						$(".vista_previa").hide();
						var file = ejercicio_alumno[0]['file'];
						if(file!== null){
						  $(".showImage").html("<h2 class='circularbook'>Visualizar:</h2><a href='files/"+file+"' target='blanck_'>"+file+"</a><input type='hidden' id='ruta_archivo' class='ruta_archivo' name='ruta_archivo' value='"+file+"'>");
						}
						//$(".ejercicio_contenido_vista_previa").empty().append('<code>'+ejercicio_alumno[0]['contenido'].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')+'</code>');
						$("#btn_save").show();
						$("#btn_save_finish").show();
						
						$("#label_finish").hide();
						RefreshEditor(ejercicio_alumno[0]['contenido'],false,ejercicios[idx_current_ejercicios]['id_lenguaje'],ejercicios[idx_current_ejercicios]['url']);

						

					}


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
CKEDITOR.replace('ejercicio_contenido');
RefreshEditor('',false,0,'dummystr');

function RefreshEditor(stringCode,readonly,lenguaje,stringCompiler){
		var tmp_url_compiler=url_compiler+stringCompiler+"/";
		
		if(readonly){
			$(".preview").hide();
		}

		switch(parseInt(lenguaje)) {

			case 1:
					console.log("Actividad de texto");
					$(".preview").hide();
					$("#banner_iframe").hide();
					$("#iframe_preview").hide();
			break;


			case 2: //html css js
					if(!readonly){
						$(".preview").hide();
						$("#banner_iframe").show();
						$("#iframe_preview").show();
						
					}
					console.log("Actividad JS html css");
					if(editor!=null){
  						editor.toTextArea();
  					}
					
					if(stringCode == null || stringCode=='' || stringCode===undefined){
						document.getElementById("editor").value="";
					}else{
						document.getElementById("editor").value=stringCode;
					}
					var tema="icecoder";
					if(readonly){
						tema="default";
					}
					editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
					    mode: "text/html",
					    theme: tema,
					    tabMode: "indent",
					    styleActiveLine: true,
					    lineNumbers: true,
					    lineWrapping: true,
					    autoCloseTags: true,
					    foldGutter: true,
					    dragDrop : true,
					    readOnly:readonly,
					    lint: true,
					    gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter", "CodeMirror-lint-markers"]
				  	});

				      // ruleSets for HTMLLint
					  var ruleSets = {
					    "tagname-lowercase": true,
					    "attr-lowercase": true,
					    "attr-value-double-quotes": true,
					    "doctype-first": false,
					    "tag-pair": true,
					    "spec-char-escape": true,
					    "id-unique": true,
					    "src-not-empty": true,
					    "attr-no-duplication": true
					  };

					  (function(CodeMirror) {
					    "use strict";

					    CodeMirror.registerHelper("lint", "html", function(text) {
					      var found = [], message;
					      if (!window.HTMLHint) return found;
					      var messages = HTMLHint.verify(text, ruleSets);
					      for ( var i = 0; i < messages.length; i++) {
					        message = messages[i];
					        var startLine = message.line -1, endLine = message.line -1, startCol = message.col -1, endCol = message.col;
					        found.push({
					          from: CodeMirror.Pos(startLine, startCol),
					          to: CodeMirror.Pos(endLine, endCol),
					          message: message.message,
					          severity : message.type
					        });
					      }
					      return found;
					    }); 
					  });


				  // Live preview
				  if(!readonly){
				  		var delay;

					  editor.on('change', function() {
					    clearTimeout(delay);
					    delay = setTimeout(updatePreview, 300);
					  });

					  function updatePreview() {
					    var previewFrame = document.getElementById('iframe_preview');
					    var preview =  previewFrame.contentDocument ||  previewFrame.contentWindow.document;
					    preview.open();
					    preview.write(editor.getValue());
					    preview.close();

					    var iframes = preview.querySelectorAll('iframe');
						for (var i = 0; i < iframes.length; i++) {
						    iframes[i].parentNode.removeChild(iframes[i]);
						}

					    

					  }
					  setTimeout(updatePreview, 300);
				  }

			break; 

			case 3: 
					if(!readonly){
						$(".preview").hide();
						$("#console").show();
					}
					console.log("Actividad C");
					var console_div = document.querySelector("#console");
					var console_content = document.querySelector("#console .content");
					var CCompiler = {

						compiler_options: { optimize: false },
						show_warnings: false, //not used

						waiting: false, //waiting server response (to avoid flooding)
						editor: null,

						//instances allowed to be called from the worker
						safe_instances: { console: console },

						init: function()
						{
							if(editor!=null){
				  						editor.toTextArea();
				  			}
									
							if(stringCode == null || stringCode=='' || stringCode===undefined){
								document.getElementById("editor").value="";
							}else{
								document.getElementById("editor").value=stringCode;
							}
							var tema="icecoder";
							if(readonly){
								tema="default";
							}

							//create code mirror area
							 textarea = document.getElementById("editor");
							 editor = CodeMirror.fromTextArea(textarea, {
								mode: "text/x-c++src",
								theme: tema,
								lineNumbers: true,
								readOnly:readonly,
								extraKeys: {
										"Ctrl-Space": "autocomplete",
										"Cmd-Space": "autocomplete",
										"Ctrl-S": "save",
										"Cmd-S": "save",
										"Ctrl-L": "load",
										"Cmd-L": "load",
										"Ctrl-Enter": "compile",
										"Cmd-Enter": "compile",
										}
							});
							this.editor = editor;

							CodeMirror.commands.autocomplete = function(cm) {
								//CodeMirror.showHint(cm, CodeMirror.javascriptHint );
								//TODO
							}

							CodeMirror.commands.compile = function(cm) {
								var code = editor.getValue();
								CCompiler.compile( code );
							}

							CodeMirror.commands.save = function(cm) {
								var code = editor.getValue();
								localStorage.setItem("ccompiler-code", code);
								cout("Codigo Guardado","color: #AAF");
							}

							CodeMirror.commands.load = function(cm) {
								var code = localStorage.getItem("ccompiler-code");
								if(code)
								{
									editor.setValue( code );
									cout("Codigo Cargado","color: #AAF");
								}
								else
									cout("No se encontro codigo a cargar","color: #AAF");
							}

							//bind buttons
							$("#help-button").click( CCompiler.showHelp.bind( CCompiler ) );
							$("#compile-button").click( function() { CodeMirror.commands.compile(); } );
							$("#clear-button").click( console.clear );
							$("#kill-button").click( CCompiler.killProcess.bind( CCompiler ) );
							$("#optimize-button").click( function() { $(this).toggleClass("clicked"); CCompiler.compiler_options.optimize = !CCompiler.compiler_options.optimize; });
						},

						compile: function(code)
						{
							if( this.waiting )
							{
								//cout("Espera a que la compilación previa haya terminado...");
								return;
							}

							this.killProcess();
							console.clear();
							var line = cout("Compilando...");

							//Server request to get the code transpiled...
							$.post(tmp_url_compiler+"compiler.php",{code: code, options: this.compiler_options },null,"json")
							.done( function(resp) {
								CCompiler.waiting = false;
								if(resp.error)
								{
									line.innerHTML = "Compilando... <span style='color: red'>ERROR</span>";
									cout( resp.error, "color: #FAA" );
									if(resp.output)
										cout(resp.output.split("\n").join("<br/>"), "color: #FAA" );
									if(resp.output.indexOf("generated") != -1)
										CCompiler.showErrors(resp.output);
									return;
								}
								line.innerHTML = "Compilando... <span style='color: #AFA'>Hecho</span>   Ejecutando...";
								//console.log(resp);
								if(resp.output == "CACHED"){
									//cout("Usando cache", "color: #AEF");
								}
								else{
									cout(resp.output);
								}
							
								CCompiler.execute( resp.emcc_url );
							})
							.fail( function(err) {
								CCompiler.waiting = false;
								line.innerHTML = "Compilando... <span style='color: red'>Error del Servidor </span>";
							});

							//set as waiting to avoid do more than one request
							this.waiting = true;
						},

						//execute the code in the url inside a worker
						execute: function( url )
						{
							this.clearErrors();

							if(this.worker)
								this.worker.terminate();

							//cout(" + Ejecutando ...","color:green");
							cout("=============================================","color:white");
							//alert("Linea 1008:"+url);
							
							var worker = this.worker = new Worker(url);
							worker.onerror = function(err) { 
								cout("Error en codigo","color: red"); 
								cout(err,"color: gray"); 
								console.log(err);
							}

							worker.addEventListener("message", function(e){
								if(!e.data) return;
								var data = e.data;

								//allow to call exported instances
								if(data.action == "eval")
								{
									var instance = CCompiler.safe_instances[ data.instance ];
									if( instance && instance[ data.method ] )
										instance[ data.method ].apply( instance, data.params );
								}
								else if(data.action == "cout") //regular cout
								{
									cout.apply( window, data.params );
								}
								else if(data.action == "ready") //ready to call main
								{
									//cout(" + Llamando a la función main()" ).style.marginBottom = "10px";
									this.postMessage({ action:"callMain" });
								}
								else if(data.action == "end") //main exited
								{
									this.terminate();
									CCompiler.worker = null;
									setTimeout(function() {
										cout(" + Proceso finalizado" ).style.marginTop = "10px";
									},200);
								}
							});
						},

						//kill the worker
						killProcess: function()
						{
							if(!this.worker) return;
							this.worker.terminate();
							this.worker = null;
							cout(" + Proceso detenido" ).style.marginTop = "10px";
						},

						//parse errors and mark them in codemirror
						showErrors: function( errors )
						{
							var lines = errors.split("\n");

							var last_line = lines[ lines.length - 2];
							var num_errors = parseInt( last_line.split(" ")[0] );

							for(var i = 0; i < num_errors; i+=3)
							{
								var line = lines[i];
								var tokens = line.split(":");
								if(tokens.length == 0)
									continue;
								var lineNumber = parseInt( tokens[1] ) - 1;
								this.editor.addLineClass( lineNumber, 'background', 'line-error');
								console.log("ERROR COMPILADOR: "+lineNumber);

							}
						},

						//clear all error marks in codemirror
						clearErrors: function()
						{
							this.editor.eachLine( function(line) {
								CCompiler.editor.removeLineClass( line, 'background', 'line-error');
							});
						},

						//show help in console
						showHelp: function()
						{
							var info = document.getElementById("help-info");
							cout( info.innerHTML );
						}
					};

					//print in the console
					function cout(txt, style)
					{
						style = style || "";

						//create line
						var msg = document.createElement("p");
						msg.className = "msg";
						msg.innerHTML = "<span style='"+style+"'>"+txt+"</span>";

						//avoid overflow
						if(console_content.childElementCount > 1000)
							console_content.removeChild( console_content.childNodes[0] );

						//append
						console_content.appendChild(msg);

						//auto scroll
						console_content.scrollTop = console_content.scrollHeight;
						return msg;
					}

					//redirect standard console messages to my console
					/*console._log = console.log;
					console.log = function(msg) {
						if(typeof(msg) == "string")
							cout(msg,"color: #444");
						console._log(msg);
					};*/

					//allow to clear the console
					console.clear = function()
					{
						console_content.innerHTML = ""; 
					}

					//useful
					String.prototype.hashCode = function(){
					    var hash = 0;
					    if (this.length == 0) return this;
					    for (i = 0; i < this.length; i++) {
					        char = this.charCodeAt(i);
					        hash = ((hash<<5)-hash)+char;
					        hash = hash & hash; // Convert to 32bit integer
					    }
					    return Math.abs(hash);
					}
				//launch app
				CCompiler.init();

			break; 

			case 4: 
			if(!readonly){
				$(".preview").hide();
				$("#console").show();
			}
			
			console.log("Actividad C++");
						var console_div = document.querySelector("#console");
						var console_content = document.querySelector("#console .content");
						var CCompiler = {

						compiler_options: { optimize: false },
						show_warnings: false, //not used

						waiting: false, //waiting server response (to avoid flooding)
						editor: null,

						//instances allowed to be called from the worker
						safe_instances: { console: console },

						init: function()
						{
							if(editor!=null){
				  						editor.toTextArea();
				  			}
									
							if(stringCode == null || stringCode=='' || stringCode===undefined){
								document.getElementById("editor").value="";
							}else{
								document.getElementById("editor").value=stringCode;
							}
							var tema="icecoder";
							if(readonly){
								tema="default";
							}



							//create code mirror area
							 textarea = document.getElementById("editor");
							 editor = CodeMirror.fromTextArea(textarea, {
								mode: "text/x-c++src",
								theme: tema,
								lineNumbers: true,
								readOnly:readonly,
								extraKeys: {
										"Ctrl-Space": "autocomplete",
										"Cmd-Space": "autocomplete",
										"Ctrl-S": "save",
										"Cmd-S": "save",
										"Ctrl-L": "load",
										"Cmd-L": "load",
										"Ctrl-Enter": "compile",
										"Cmd-Enter": "compile",
										}
							});
							this.editor = editor;

							CodeMirror.commands.autocomplete = function(cm) {
								//CodeMirror.showHint(cm, CodeMirror.javascriptHint );
								//TODO
							}

							CodeMirror.commands.compile = function(cm) {
								var code = editor.getValue();
								CCompiler.compile( code );
							}

							CodeMirror.commands.save = function(cm) {
								var code = editor.getValue();
								localStorage.setItem("ccompiler-code", code);
								cout("Codigo Guardado","color: #AAF");
							}

							CodeMirror.commands.load = function(cm) {
								var code = localStorage.getItem("ccompiler-code");
								if(code)
								{
									editor.setValue( code );
									cout("Codigo Cargado","color: #AAF");
								}
								else
									cout("No se encontro codigo a cargar","color: #AAF");
							}

							//bind buttons
							$("#help-button").click( CCompiler.showHelp.bind( CCompiler ) );
							$("#compile-button").click( function() { CodeMirror.commands.compile(); } );
							$("#clear-button").click( console.clear );
							$("#kill-button").click( CCompiler.killProcess.bind( CCompiler ) );
							$("#optimize-button").click( function() { $(this).toggleClass("clicked"); CCompiler.compiler_options.optimize = !CCompiler.compiler_options.optimize; });
						},

						compile: function(code)
						{
							if( this.waiting )
							{
								//cout("Espera a que la compilación previa haya terminado...");
								return;
							}

							this.killProcess();
							console.clear();
							var line = cout("Compilando...");

							//Server request to get the code transpiled...
							$.post(tmp_url_compiler+"compiler.php",{code: code, options: this.compiler_options },null,"json")
							.done( function(resp) {
								CCompiler.waiting = false;
								if(resp.error)
								{
									line.innerHTML = "Compilando... <span style='color: red'>ERROR</span>";
									cout( resp.error, "color: #FAA" );
									if(resp.output)
										cout(resp.output.split("\n").join("<br/>"), "color: #FAA" );
									if(resp.output.indexOf("generated") != -1)
										CCompiler.showErrors(resp.output);
									return;
								}
								line.innerHTML = "Compilando... <span style='color: #AFA'>Hecho</span>   Ejecutando...";
								//console.log(resp);
								if(resp.output == "CACHED"){
									//cout("Usando cache", "color: #AEF");
								}
								else{
									cout(resp.output);
								}
								//alert("Linea 1273: "+resp.emcc_url);
								CCompiler.execute( resp.emcc_url );
							})
							.fail( function(err) {
								CCompiler.waiting = false;
								line.innerHTML = "Compilando... <span style='color: red'>Error del Servidor </span>";
							});

							//set as waiting to avoid do more than one request
							this.waiting = true;
						},

						//execute the code in the url inside a worker
						execute: function( url )
						{
							this.clearErrors();

							if(this.worker)
								this.worker.terminate();

							//cout(" + Ejecutando ...","color:green");
							cout("=============================================","color:white");
								
							var worker = this.worker = new Worker(url);
							worker.onerror = function(err) { 
								cout("Error en codigo","color: red"); 
								cout(err,"color: gray"); 
								console.log(err);
							}

							worker.addEventListener("message", function(e){
								if(!e.data) return;
								var data = e.data;

								//allow to call exported instances
								if(data.action == "eval")
								{
									var instance = CCompiler.safe_instances[ data.instance ];
									if( instance && instance[ data.method ] )
										instance[ data.method ].apply( instance, data.params );
								}
								else if(data.action == "cout") //regular cout
								{
									cout.apply( window, data.params );
								}
								else if(data.action == "ready") //ready to call main
								{
									//cout(" + Llamando a la función main()" ).style.marginBottom = "10px";
									this.postMessage({ action:"callMain" });
								}
								else if(data.action == "end") //main exited
								{
									this.terminate();
									CCompiler.worker = null;
									setTimeout(function() {
										cout(" + Proceso finalizado" ).style.marginTop = "10px";
									},200);
								}
							});
						},

						//kill the worker
						killProcess: function()
						{
							if(!this.worker) return;
							this.worker.terminate();
							this.worker = null;
							cout(" + Proceso detenido" ).style.marginTop = "10px";
						},

						//parse errors and mark them in codemirror
						showErrors: function( errors )
						{
							var lines = errors.split("\n");

							var last_line = lines[ lines.length - 2];
							var num_errors = parseInt( last_line.split(" ")[0] );

							for(var i = 0; i < num_errors; i+=3)
							{
								var line = lines[i];
								var tokens = line.split(":");
								if(tokens.length == 0)
									continue;
								var lineNumber = parseInt( tokens[1] ) - 1;
								this.editor.addLineClass( lineNumber, 'background', 'line-error');
								console.log("ERROR COMPILADOR: "+lineNumber);
							}
						},

						//clear all error marks in codemirror
						clearErrors: function()
						{
							this.editor.eachLine( function(line) {
								CCompiler.editor.removeLineClass( line, 'background', 'line-error');
							});
						},

						//show help in console
						showHelp: function()
						{
							var info = document.getElementById("help-info");
							cout( info.innerHTML );
						}
					};

					//print in the console
					function cout(txt, style)
					{
						style = style || "";

						//create line
						var msg = document.createElement("p");
						msg.className = "msg";
						msg.innerHTML = "<span style='"+style+"'>"+txt+"</span>";

						//avoid overflow
						if(console_content.childElementCount > 1000)
							console_content.removeChild( console_content.childNodes[0] );

						//append
						console_content.appendChild(msg);

						//auto scroll
						console_content.scrollTop = console_content.scrollHeight;
						return msg;
					}

					//redirect standard console messages to my console
					/*console._log = console.log;
					console.log = function(msg) {
						if(typeof(msg) == "string")
							cout(msg,"color: #444");
						console._log(msg);
					};*/

					//allow to clear the console
					console.clear = function()
					{
						console_content.innerHTML = ""; 
					}

					//useful
					String.prototype.hashCode = function(){
					    var hash = 0;
					    if (this.length == 0) return this;
					    for (i = 0; i < this.length; i++) {
					        char = this.charCodeAt(i);
					        hash = ((hash<<5)-hash)+char;
					        hash = hash & hash; // Convert to 32bit integer
					    }
					    return Math.abs(hash);
					}
				//launch app
				CCompiler.init();

			break; 

			case 5: // Java
				console.log("Actividad de java");

			break; 


			default: 
				console.log("Actividad indefinida");
			break;

		}

	

}

  // CodeMirror HTMLHint Integration
  (function(mod) {
    if (typeof exports == "object" && typeof module == "object") // CommonJS
      mod(require(url+"assets/codemirror/lib/codemirror"));
    else if (typeof define == "function" && define.amd) // AMD
      define([url+"assets/codemirror/lib/codemirror"], mod);
    else // Plain browser env
      mod(CodeMirror);
  })

  /*
  // ruleSets for HTMLLint
  var ruleSets = {
    "tagname-lowercase": true,
    "attr-lowercase": true,
    "attr-value-double-quotes": true,
    "doctype-first": false,
    "tag-pair": true,
    "spec-char-escape": true,
    "id-unique": true,
    "src-not-empty": true,
    "attr-no-duplication": true
  };

  (function(CodeMirror) {
    "use strict";

    CodeMirror.registerHelper("lint", "html", function(text) {
      var found = [], message;
      if (!window.HTMLHint) return found;
      var messages = HTMLHint.verify(text, ruleSets);
      for ( var i = 0; i < messages.length; i++) {
        message = messages[i];
        var startLine = message.line -1, endLine = message.line -1, startCol = message.col -1, endCol = message.col;
        found.push({
          from: CodeMirror.Pos(startLine, startCol),
          to: CodeMirror.Pos(endLine, endCol),
          message: message.message,
          severity : message.type
        });
      }
      return found;
    }); 
  });
  */





});
