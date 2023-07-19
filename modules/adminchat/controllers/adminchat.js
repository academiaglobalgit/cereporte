$( document ).ready(function() {
  
 var id_alumno=0; // id_alumno en cuestion (de escolar)
 var id_persona=0; // id_persona en cuestion (de escolar)
 var id_moodle=0; // id_alumno en cuestion (de moodle)

 var id_current_plan_estudio=2; // inicia con el id plan estudio de dgb
 var id_current_corporacion=2; // inicia con el id_corporacion  de dgb

  var asesores=[];
  var idx_current_asesor=0;

  var regiones;
  var idx_current_regiones=0;

  var corporaciones;
  var idx_current_corporaciones=0;

  var regiones_asesores;
  var idx_current_regiones_asesores=0;

   var table_asesores;
   var table_regiones;
  	function ShowLoading(){
  		$("#loading").fadeIn('fast');
  	}

  	function HideLoading(){
  		$("#loading").fadeOut('fast');
  	} 	



	$("#f_u_id_corporacion").change(function() { // cuando cambia el select del plan de estudio optiene las materias
		var id_corporacion=$(this).val();
		id_current_corporacion=id_corporacion;
		var data_ajax= {
				'id_corporacion':id_corporacion
			};
		GetAjax(data_ajax,"GetRegiones",function(response){
			RefreshRegiones(response);
		});

	});




	function RefreshCorporaciones(corporaciones_){
		var html_corporacion="";

		if(corporaciones_.length==0 || corporaciones_==null  || corporaciones_===undefined){
            html_corporacion+='	<option value="" > Sin corporaciones registradas. </option>'; 
            corporaciones=[];
		}else{
			corporaciones=corporaciones_;
			for (var i = 0; i < corporaciones_.length; i++) {
	            html_corporacion+='<option  value="'+corporaciones_[i]['id']+'"  >'+corporaciones_[i]['nombre']+'</option>'; 
			}			
		}

		$("#f_u_id_corporacion").empty().append(html_corporacion);

	}



	function RefreshRegiones(regiones_){
		var html_regiones="";

		if(regiones_.length==0 || regiones_==null  || regiones_===undefined){
            html_regiones+='	<option value="" > Sin regiones registradas. </option>'; 
            regiones=[];
		}else{
			regiones=regiones_;
			for (var i = 0; i < regiones_.length; i++) {
	            html_regiones+='<option  value="'+regiones_[i]['id']+'"  >'+regiones_[i]['nombre']+'</option>'; 
			}			
		}

		$("#f_u_id_region").empty().append(html_regiones);

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
						if(valor.trim().length>3)
						{
							validado= !validado; //tiene que tener almenos 4 caracteres
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
			  	
				  	
				 }).fail(function() {
					    console.log( "error al SEND AJAX 1" );
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

/*######## asesores CLICKS LISTENERS ########*/
	$("#f_u_btn_region").click(function(){
		SendAjax(
			"form_asesor_regiones",
			"AddRegionAsesor",
			function(){
				
					var data_ajax= {
						'id_asesor':asesores[idx_current_asesor]['id']
						};
						GetAjax(data_ajax,"GetAsesoresRegiones",function(response){		
							RefreshRegionesAsesores(response);
						});

			});
	});


	$("#btn_form_region_delete").click(function(){
		SendAjax(
			"form_region_delete",
			"RemoveRegionAsesor",
			function(){
								$("#modal_asesor_regiones_eliminar").modal('hide');

					var data_ajax= {
						'id_asesor':asesores[idx_current_asesor]['id']
						};
						GetAjax(data_ajax,"GetAsesoresRegiones",function(response){		
							RefreshRegionesAsesores(response);
						});

			});
	});


		$("#btn_refresh_asesores").click(function(){
						var data_ajax2= {
						'id_plan_estudio':id_current_plan_estudio,
						'id_corporacion':id_current_corporacion
					};
					GetAjax(data_ajax2,"GetAsesores",function(response){
						RefreshAsesores(response);

					});
		});


/*====== END asesores CLICK LISTENERS======*/


	function InitializeAsesores(){


		var data_ajax2= {
						'id_plan_estudio':id_current_plan_estudio,
						'id_corporacion':id_current_corporacion
					};
		GetAjax(data_ajax2,"GetAsesores",function(response){
			RefreshAsesores(response);
					$('#table_asesores').DataTable();

		});

		var data_ajax= {
				'id_corporacion':0
			};
		GetAjax(data_ajax,"GetCorporaciones",function(response){
			RefreshCorporaciones(response);


		});



	}

	function RefreshAsesores(asesores_){
		var html_asesores="";

		if(asesores_.length==0 || asesores_==null || asesores_===undefined){
			html_asesores+='<tr>';
            html_asesores+='	<td colspan="6" > No hay asesores registrados hasta este momento.</td>'; 
            html_asesores+='</tr>';
            asesores=[];
		}else{
			asesores=asesores_;
			for (var i = 0; i < asesores_.length; i++) {
				html_asesores+='<tr>';
	            html_asesores+='<td>'+asesores_[i]['id']+'</td>'; 
	            html_asesores+='<td>'+asesores_[i]['nombre']+'</td>'; 
	            html_asesores+='<td>'+asesores_[i]['apellido1']+'</td>'; 
	            html_asesores+='<td>'+asesores_[i]['apellido2']+'</td>'; 
	           	html_asesores+='<td>'+asesores_[i]['regiones']+'</td>'; 
	            html_asesores+='<td><a href="#" class="btn btn-info update_asesores" item-index="'+i+'"   >Regiones <span class="glyphicon glyphicon-cog" ></span></a></td>'; 
	            html_asesores+='</tr>';
			}			
		}

		$("#content_asesores").html(html_asesores);

		$(".update_asesores").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_asesor=index;
			$("#f_u_nombre").val(asesores[idx_current_asesor]['nombre']);
			$("#f_u_id_asesor").val(asesores[idx_current_asesor]['id']);

				var data_ajax= {
						'id_asesor':asesores[idx_current_asesor]['id']
				};
				GetAjax(data_ajax,"GetAsesoresRegiones",function(response){		
					RefreshRegionesAsesores(response);
				});

			$("#modal_asesor_regiones").modal('show');
			
		});
	}


	function RefreshRegionesAsesores(regiones_asesores_){
		var html_regiones_asesores="";

		if(regiones_asesores_.length==0 || regiones_asesores_==null || regiones_asesores_===undefined){
			html_regiones_asesores+='<tr>';
            html_regiones_asesores+='	<td colspan="3" > No hay regiones registradas hasta este momento.</td>'; 
            html_regiones_asesores+='</tr>';
            regiones_asesores=[];
		}else{
			regiones_asesores=regiones_asesores_;
			for (var i = 0; i < regiones_asesores_.length; i++) {
				html_regiones_asesores+='<tr>';
	            html_regiones_asesores+='<td> '+regiones_asesores_[i]['region']+'</td>'; 
	            html_regiones_asesores+='<td>'+regiones_asesores_[i]['corporacion']+'</td>'; 
	            html_regiones_asesores+='<td><a href="#" class="update_region"  item-index="'+i+'"   >Eliminar <span class="glyphicon glyphicon-times" ></span></a></td>'; 
	            html_regiones_asesores+='</tr>';
			}			
		}

		$("#content_regiones").empty().append(html_regiones_asesores);

	


		$(".update_region").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_regiones_asesores=index;

			$("#f_d_nombre").val(regiones_asesores[idx_current_regiones_asesores]['region']+' - '+regiones_asesores[idx_current_regiones_asesores]['corporacion']);
			$("#f_d_id_region_asesor").val(regiones_asesores[idx_current_regiones_asesores]['id']);
			$("#modal_asesor_regiones_eliminar").modal('show');
		});

	}



	function CKupdate(){
	    for ( instance in CKEDITOR.instances )
	        CKEDITOR.instances[instance].updateElement();
	}


	InitializeAsesores();

});
