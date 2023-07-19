$( document ).ready(function() {


	var materias=[];
	var idx_current_materia=0;
	var alumnos=[];
	var idx_current_alumno=0;



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


	function RefreshMaterias(materias_){
		var html_materias='';
		
		if(materias_.length==0 || materias_==null || materias_===undefined){
			
			html_materias+='<div class="list-group">';
			html_materias+='	<a href="#" class="list-group-item active color_primario"  >';
           	html_materias+='		No se han encontrado cursos. <span class="pull-right glyphicon glyphicon-triangle-right"></span>';
            html_materias+='	</a>';
			html_materias+='</div>';

            materias=[];
		}else{
			lastperiodo=0;
			materias=materias_;
			for (var i = 0; i < materias_.length; i++) {
				
				if(lastperiodo!=materias_[i]['id_periodo']){

					lastperiodo=materias_[i]['id_periodo'];

					if(html_materias!=''){
						html_materias+='</div>';
					}
					html_materias+='<div class="list-group">';
					html_materias+='	<a href="#" class="list-group-item active color_primario" style="cursor:auto;" >';
		           	html_materias+='		Escuela de '+materias_[i]['periodo']+' <span class="pull-right glyphicon glyphicon-triangle-right"></span>';
		            html_materias+='	</a>';
		            html_materias+='<a href="#" class="list-group-item materia" item-index="'+i+'" ><span class=" glyphicon glyphicon-stop">'+materias_[i]['fullname']+'</a>';
					
				}else{
					html_materias+='<a href="#" class="list-group-item materia" item-index="'+i+'" ><span class=" glyphicon glyphicon-stop">'+materias_[i]['fullname']+'</a>';
					if(i == materias_.length){
						html_materias+='</div>';
					}
				}


			}
				
		}

		$("#list_materias").empty().append(html_materias);

		$(".materia").click(function(){
				var idx=$(this).attr("item-index");
				idx_current_materia=idx;
				GetAlumnosByMateria();

		});
	}

	function RefreshAlumnos(alumnos_){
		var html_alumnos='';
		
		if(alumnos_.length==0 || alumnos_==null || alumnos_===undefined){
			
			html_alumnos+='<tr>';
			html_alumnos+='	<td colspan="3" >';
           	html_alumnos+='		No se han encontrado alumnos en este curso. ';
            html_alumnos+='	</td>';
			html_alumnos+='</tr>';

           	alumnos=[];

		}else{
				alumnos=alumnos_;
			for (var i = 0; i < alumnos_.length; i++) {

				html_alumnos+='<tr>';
				html_alumnos+=	'<td>'+alumnos_[i]['id']+'</td>';
	            html_alumnos+=	'<td>'+alumnos_[i]['numero_empleado']+'</td>';
	            html_alumnos+=	'<td>'+alumnos_[i]['firstname']+' '+alumnos_[i]['lastname']+'</td>';
	            html_alumnos+=	'<td>';
	            html_alumnos+=		'<table class="table" >';

	            var html_alumnos_unidades='<tr>';
	            var	html_alumnos_actividades='<tr style="font-size: 2em;">';
	            for (var j = 0; j < alumnos_[i]['unidades']; j++) {
	            	
	            	html_alumnos_unidades+='<th class="text-center" >Módulo '+(j+1)+' &nbsp;</th>';
	            	if(alumnos_[i]['actividades_alumno'][j]['hechos']>0 ){
	            		html_alumnos_actividades+='<td class="text-center" > <a target="_blank" href="php/actividades_pdf.php?userid='+alumnos_[i]['id']+'&modulo='+j+'&course='+materias[idx_current_materia]['id']+'"><span class="glyphicon glyphicon-align-center glyphicon-save-file"></span></a>';
	            	}else{
	            		html_alumnos_actividades+='<td class="text-center"><span style="color:black" class="glyphicon glyphicon-save-file"></span>';
	            	}
	            	html_alumnos_actividades+='<small style="font-size:12px;" >'+alumnos_[i]['actividades_alumno'][j]['hechos']+'/'+alumnos_[i]['actividades_alumno'][j]['totales']+'</small>';
	            	html_alumnos_actividades+='</td>';
	            }
	            html_alumnos_unidades+='</tr>';
	            html_alumnos_actividades+='</tr>';

	            html_alumnos+=html_alumnos_unidades+html_alumnos_actividades;

	            html_alumnos+=		'</table>';
	            html_alumnos+=	'</td>';
	            html_alumnos+='</tr>';   
			}



		}
			$("#label_materia").empty().append(materias[idx_current_materia]['fullname']);

			$("#list_alumnos").empty().append(html_alumnos);

	}
	function GetMaterias(){

		var data_ajax= {

			};

		GetAjax(
			data_ajax,
			"GetMaterias",
			function(response){
				RefreshMaterias(response);
			}
		);

	}

	function GetAlumnosByMateria(){

		var data_ajax= {
			"id_course":materias[idx_current_materia]['id'],
			"filtro":$("#filtro").val()
			};
		$("#filtro").val("");
		GetAjax(
			data_ajax,
			"GetAlumnosByMateria",
			function(response){
				RefreshAlumnos(response);
			}
		);

	}


	$("#btn_filtro").click(function(){
		GetAlumnosByMateria();
	});

	$('#filtro').keyup(function(e){
	    if(e.keyCode == 13)
	    {
	        GetAlumnosByMateria();
	    }
	});


	function initializeActividades(){
		GetMaterias();
	}


	initializeActividades();

});