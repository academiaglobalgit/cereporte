$( document ).ready(function() {


	var is_loading=false;
	function ShowMensaje(msg){
		$('#aviso_msg').html(msg);
		//$('#modal_aviso').modal('show');
	}

  	function ShowLoading(){
  		is_loading=true;
  	  //	$("#view_editar").hide();
	  	$("#btn_login").removeClass("btn-success");
	  	$("#btn_login").toggleClass("btn-default");
	  	$("#btn_login").html("Ingresando...");
	  	$("#btn_login").attr("disabled");

  	}

  	function HideLoading(){
  		is_loading=false;
  		$("#btn_login").removeClass("btn-default");
  		$("#btn_login").toggleClass("btn-success");
  		$("#btn_login").removeAttr("disabled");
  		$("#btn_login").html('Ingresar <span class="glyphicon glyphicon-log-in"></span>');
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
						  		//ShowMensaje(datos['message']);
						  		console.log("Login OK: "+request);
						  		$("#"+form_element)[0].reset();
						  		function_after();
						  	}else{
						  		$("#contra").val("");
						  		ShowMensaje(datos['message']);
						    	
						  	}	
					  	}catch(e){
					    	console.log( "error "+e+ " al SEND AJAX 3: "+data);

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


	function GetLogin(){
		ShowMensaje("<br>");
		SendAjax("form_login","GetLogin",function(){
			window.location.href = "index.php"; 
		});
	}



	$('#usuario').keyup(function(e){
	    if(e.keyCode == 13)
	    {
	        GetLogin();
	    }
	});

	$('#contra').keyup(function(e){
	    if(e.keyCode == 13)
	    {
	        GetLogin();
	    }
	});


	$("#btn_login").click(function(){
		GetLogin();
	});

});