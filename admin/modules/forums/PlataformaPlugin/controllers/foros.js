$( document ).ready(function() {
 	var online=true; //TRUE= online false= local
	var URLAPI="http://agcollege.edu.mx/cereporte/modules/forums/php/ajaxHandler.php";
	if(online){
		URLAPI="http://agcollege.edu.mx/cereporte/modules/forums/php/ajaxHandler.php";
	}else{
		URLAPI="http://localhost/report/modules/forums/php/ajaxHandler.php";
	}	

 var id_alumno=0; // id_alumno en cuestion (de escolar)
 var id_persona=0; // id_persona en cuestion (de escolar)
 var id_moodle=0; // id_alumno en cuestion (de moodle)
 var id_examen_moodle=0; // id examen(bloque) en cuestion (de moodle)
 var id_materia=0; // id_course en cuestion (de moodle)
 var tipo_examen=1; // tipo de examen 1=quiz 2= scorm (de moodle)

 var id_current_plan_estudio=9; // inicia con el id plan estudio de dgb
 var id_current_corporacion=7; // inicia con el id_corporacion  de dgb

  var courses=[];
  var idx_current_course=0;
  var quizes=[];

  var forums;
  var idx_current_forum=0;
  var threads;
  var idx_current_thread=0;
  var r_text=[];
  var r_idx_correct=0;
  var posts;
  var id_current_post=0;


  	function ShowLoading(){
  		$("#loading").fadeIn('fast');
  	}

  	function HideLoading(){
  		$("#loading").fadeOut('fast');
  	} 	

	/*$("#id_plan_estudio").change(function() { // cuando cambia el select del plan de estudio optiene las materias
		id_current_plan_estudio=$(this).val();
		var data_ajax2= {
						'id_plan_estudio':id_current_plan_estudio,
						'id_corporacion':id_current_plan_estudio
					};
					GetAjax(data_ajax2,"GetCourses",function(response){
						RefreshCourses(response);
								$("#f_id_course").val(courses[0]['id']);
								$("#f_id_plan_estudio").val(id_current_plan_estudio);
								$("#f_u_id_course").val(courses[0]['id']);
								$("#f_u_id_plan_estudio").val(id_current_plan_estudio);

										var data_ajax3= {
											'id_course':courses[0]['id'],
											'id_plan_estudio':id_current_plan_estudio,
											'id_corporacion':id_current_plan_estudio
										};
										GetAjax(data_ajax3,"GetForums",function(response){
											RefreshForums(response);

										});

					});

	});*/



	$("#id_course").change(function() { // cuando cambia el select del plan de estudio optiene las materias
		idx_current_course=$(this).val();
		$("#f_id_course").val(courses[idx_current_course]['id']);
		$("#f_id_plan_estudio").val(id_current_plan_estudio);
		$("#f_id_corporacion").val(id_current_corporacion);

		$("#f_u_id_course").val(courses[idx_current_course]['id']);
		$("#f_u_id_plan_estudio").val(id_current_plan_estudio);
		$("#f_u_id_corporacion").val(id_current_corporacion);
		var data_ajax2= {
						'id_course':courses[idx_current_course]['id'],
						'id_plan_estudio':id_current_plan_estudio,
						'id_corporacion':id_current_corporacion
					};
					GetAjax(data_ajax2,"GetForums",function(response){
						RefreshForums(response);
						RefreshThreads([]);
						RefreshPosts([]);
					});
		var data_ajax4= {
				'id_course':courses[idx_current_course]['id'],
				'id_plan_estudio':id_current_plan_estudio
			};
		GetAjax(data_ajax4,"GetQuizes",function(response){
			RefreshQuizes(response);
		});

	});


	function RefreshCourses(courses_){
		var html_courses="";

		if(courses_.length==0 || courses_==null || courses_===undefined){
            html_courses+='	<option value="" > Sin materias registradas. </option>'; 
            courses=[];
		}else{
			courses=courses_;

			for (var i = 0; i < courses_.length; i++) {
	            html_courses+='	<option  value="'+i+'"  > Periodo '+courses_[i]['periodo']+' - '+courses_[i]['matricula']+' - '+courses_[i]['nombre']+'</option>'; 
			}			
		}

		$("#id_course").empty().append(html_courses);
	}


	function RefreshQuizes(quizes_){
		var html_quizes="";

		if(quizes_.length==0 || quizes_==null  || quizes_===undefined){
            html_quizes+='	<option value="" > Sin examenes registrados. </option>'; 
            quizes=[];
		}else{
			quizes=quizes_;
			var tipo_examen="Orinario";
			for (var i = 0; i < quizes_.length; i++) {
				if(quizes_[i]['id_tipo_examen']==1){
					tipo_examen="Parcial";

				}else if (quizes_[i]['id_tipo_examen']==2){
					tipo_examen="Orinadio";
				}
	            html_quizes+='	<option  value="'+quizes_[i]['id']+'"  >Bloque '+quizes_[i]['bloque']+' - Examen '+tipo_examen+' - '+quizes_[i]['nombre']+'</option>'; 
			}			
		}

		$("#f_id_quiz").empty().append(html_quizes);
		$("#f_u_id_quiz").empty().append(html_quizes);

	}





  	function AddResponse(text,form){
  		if(text==null || text.trim()=="" || text==undefined){
  			alert("Porfavor introduce una respuesta valida.");
  		}else{
  			var idx_tmp=0;
  		 	$("."+form+"-responses").each(function (){
  		 		r_text[idx_tmp]=$(this).val();
  		 		idx_tmp++;
  		 	});
  			r_text.push(text);

  			$("#"+form+"-t_texto_r").val("");

  			RefreshResponses(r_text,form);

  		}
  	}

  	function DeleteResponse(idx,form){
  		r_text.splice(idx, 1);
  		if(idx==r_idx_correct){
 			r_idx_correct=0;
 		}
  		RefreshResponses(r_text);
  	}




  	function RefreshResponses(responses_,form){
  		r_text=responses_;
  		var html_responses="";
  		
  		if(responses_==null || responses_===undefined || responses_.length==0){
  			  	html_responses="<table class='table'>";
		  		html_responses+="<thead>";
		    	html_responses+="	<tr>";
		    	html_responses+="		<th>Respuestas</th>";
		    	html_responses+="	</tr>";
		  		html_responses+="</thead>";
		  		html_responses+="<tbody>";
		  		html_responses+="<tr>";
		    	html_responses+="	<td>";
		    	html_responses+="		Actualmente no se han agregado respuestas para esta pregunta detonadora.";
		    	html_responses+="	</td>";
		  		html_responses+="</tr>";
  		}else{
  				html_responses="<table class='table'>";
		  		html_responses+="<thead>";
		    	html_responses+="	<tr>";
		    	html_responses+="		<th>Respuestas</th>";
		    	html_responses+="	</tr>";
		  		html_responses+="</thead>";
		  		html_responses+="<tbody>";

		  		for (var i = 0; i < responses_.length; i++){
		  			html_responses+="<tr>";
		  			html_responses+="	<td><button type='button' class='"+form+"-btn_responses_remove btn btn-warning' item-index='"+i+"'  ><span class='glyphicon glyphicon-minus'></span></button>";
		  			if(r_idx_correct==i){
		  				html_responses+="	<button type='button' class='"+form+"-btn_responses_correct btn btn-success' item-index='"+i+"'  ><span class='glyphicon glyphicon-check' ></span></button></td>";
		  			}else{
		  				html_responses+="	<button type='button' class='"+form+"-btn_responses_correct btn btn-default' item-index='"+i+"'  ><span class='glyphicon glyphicon-unchecked' ></span></button></td>";
		  			}
		  			html_responses+="	<td><input name='responses_"+i+"' class='input-"+form+" form-control "+form+"-responses' type='text' error='Porfavor introduce las respuestas correctamente.' value='"+responses_[i]+"' required></td>";
		  			//html_responses+="	<input name='responses_ids_"+i+"' class='input-"+form+" type='text'  value='"+responses_[i]+"' ></td>";

		  			html_responses+="</tr>";
		  		}
  		}
  	
  		html_responses+="</tbody>";
  		html_responses+="</table>";
  		$("#"+form+"-content_responses").empty().append(html_responses);
  		 
  		 $("."+form+"-btn_responses_remove").click(function(){
  		 	var index=parseInt($(this).attr("item-index"));
  		 	var idx_tmp=0;
  		 	$("."+form+"-responses").each(function (){
  		 		r_text[idx_tmp]=$(this).val();
  		 		idx_tmp++;
  		 	});

 			DeleteResponse(index,form);
		});

  		 $("."+form+"-btn_responses_correct").click(function(){
  		 	var index=parseInt($(this).attr("item-index"));
  		 	r_idx_correct=index;
  		 	$("#"+form+"-t_idx_correct").val(r_idx_correct);
  		 	$("."+form+"-btn_responses_correct").children().removeClass("glyphicon-check");
  		 	$("."+form+"-btn_responses_correct").children().removeClass("glyphicon-unchecked");
  		 	$("."+form+"-btn_responses_correct").removeClass("btn-success");
  		 	$("."+form+"-btn_responses_correct").removeClass("btn-default");
  		 	$("."+form+"-btn_responses_correct").children().toggleClass("glyphicon-unchecked");
  		 	$("."+form+"-btn_responses_correct").toggleClass("btn-default");
			
			$(this).removeClass("btn-default");
			$(this).toggleClass("btn-success");

  		 	$(this).children().removeClass("glyphicon-unchecked");
  		 	$(this).children().toggleClass("glyphicon-check");
				
		});
  	}

	/*THREAD  RESONSES BUTTONS*/

 	$("#form_thread-btn_responses_add").click(function(){
 			AddResponse($("#form_thread-t_texto_r").val(),"form_thread");
	});

	$("#form_thread-t_texto_r").keypress(function(event) {
   	 if (event.which == 13) {
			AddResponse($("#form_thread-t_texto_r").val(),"form_thread");
    	}
	});

	$("#form_thread-t_tipo").change(function() {
		if(parseInt($("#form_thread-t_tipo").val())==1){ // normal
			$("#form_thread-showResponses").fadeOut('fast');
		}else{ // multirespuesta
			$("#form_thread-showResponses").fadeIn('fast');
		}
	});
	/*END RESPONSES BUTTONS*/

	/*THREAD RESPONSES UPDATE BUTTONS*/
 	$("#form_thread_update-btn_responses_add").click(function(){
 			AddResponse($("#form_thread_update-t_texto_r").val(),"form_thread_update");
	});

	$("#form_thread_update-t_texto_r").keypress(function(event) {
   	 if (event.which == 13) {
			AddResponse($("#form_thread_update-t_texto_r").val(),"form_thread_update");
    	}
	});

	$("#form_thread_update-t_tipo").change(function() {
		if(parseInt($("#form_thread_update-t_tipo").val())==1){ // normal
			$("#form_thread_update-showResponses").fadeOut('fast');
		}else{ // multirespuesta
			$("#form_thread_update-showResponses").fadeIn('fast');
		}
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
					URLAPI, postData
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
					URLAPI, postData
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

/*######## FORUMS CLICKS LISTENERS ########*/
	$("#btn_form_forum").click(function(){
		SendAjax(
			"form_forum",
			"SetForum",
			function(){
				
				var data_ajax= {
						'id_course':courses[idx_current_course]['id'],
						'id_plan_estudio':id_current_plan_estudio,
						'id_corporacion':id_current_corporacion
				};
				GetAjax(data_ajax,"GetForums",function(response){		
				forums=response;	
				RefreshForums(forums);
				$("#modal_forum").modal('hide');
								var data_ajax2= {
									'id_forum':0
								};
						RefreshThreads([]);
					
						RefreshPosts([]);
				});
			}
		);
	});
	$("#btn_form_forum_delete").click(function(){
		SendAjax(
			"form_forum_delete",
			"DeleteForum",
			function(){
				$("#modal_forum_delete").modal('hide');
				var data_ajax= {
						'id_course':courses[idx_current_course]['id'],
						'id_plan_estudio':id_current_plan_estudio,
						'id_corporacion':id_current_corporacion
				};
				GetAjax(data_ajax,"GetForums",function(response){		
				forums=response;	
				RefreshForums(forums);
				
					var data_ajax2= {
						'id_forum':0
					};
						RefreshThreads([]);
					
						RefreshPosts([]);

				});
			}
		);
	});

	$("#btn_form_forum_update").click(function(){
		SendAjax(
			"form_forum_update",
			"UpdateForum",
			function(){
				$("#modal_forum_update").modal('hide');
				var data_ajax= {
						'id_course':courses[idx_current_course]['id'],
						'id_plan_estudio':id_current_plan_estudio,
						'id_corporacion':id_current_corporacion
				};
				GetAjax(data_ajax,"GetForums",function(response){		
				forums=response;	
				RefreshForums(forums);
					var data_ajax2= {
						'id_forum':forums[idx_current_forum]['id']
					};
						RefreshThreads([]);
						RefreshPosts([]);


				});
			}
		);
	});

/*====== END FORUMS CLICK LISTENERS======*/


/*######## THREADS CLICKS LISTENERS ########*/

	$("#btn_form_thread").click(function(){

		SendAjax(
			"form_thread",
			"SetThread",
			function(){
				$("#modal_thread").modal('hide');
				var data_ajax= {
					'id_forum':forums[idx_current_forum]['id']
				};
				GetAjax(data_ajax,"GetThreads",function(response){		
				threads=response;	
				RefreshThreads(threads);

				});
			}
		);
	});

	$("#btn_form_thread_update").click(function(){
		SendAjax(
			"form_thread_update",
			"UpdateThread",
			function(){
				$("#modal_thread_update").modal('hide');
				var data_ajax= {
					'id_forum':forums[idx_current_forum]['id']
				};
				GetAjax(data_ajax,"GetThreads",function(response){		
				RefreshThreads(response);
						var data_ajax2= {
							'id_thread':threads[idx_current_thread]['id']
						};
						GetAjax(data_ajax2,"GetPosts",function(response){
							RefreshPosts(response);
						});

				});
			}
		);
	});

	$("#btn_form_thread_delete").click(function(){
		SendAjax(
			"form_thread_delete",
			"DeleteThread",
			function(){
				$("#modal_thread_delete").modal('hide');
				var data_ajax= {
					'id_forum':forums[idx_current_forum]['id']
				};
				GetAjax(data_ajax,"GetThreads",function(response){		
				RefreshThreads(response);
				
						var data_ajax2= {
							'id_thread':0
						};
						GetAjax(data_ajax2,"GetPosts",function(response){
							RefreshPosts(response);
						});
				});
			}
		);
	});
/*===== END CLICKS THREADS ====*/


	function InitializeForums(){
		  id_materia=$("#id_materia").val();
		  id_persona=$("#id_persona").val();
		  id_moodle=$("#id_moodle").val();
		  id_examen=$("#id_examen").val();
		  tipo_examen=$("#tipo_examen").val();

		var data_ajax2= {
						'id_course':id_materia,
						'id_modo':tipo_examen,
						'id_quiz':id_examen,
						'id_plan_estudio':id_current_plan_estudio
					};
		
		GetAjax(data_ajax2,"GetForumsByExamenMoodle",function(response){
				RefreshForums(response);

				RefreshThreads([]);

				RefreshPosts([]);

		});




	}

	function RefreshForums(forums_){
		var html_forums="";

		if(forums_.length==0 || forums_==null || forums_===undefined){
			html_forums+='<div  class="list-group-item">';
            html_forums+='	<div class="alert alert-default" > No hay foros registrados hasta este momento.</div>'; 
            html_forums+='	<div class="pull-right">';
            html_forums+='	</div>';
            html_forums+='</div>';
            forums=[];
		}else{
			forums=forums_;
			for (var i = 0; i < forums_.length; i++) {
				html_forums+='<div  class="list-group-item">';
	            html_forums+='	<a href="#"  class="threads_forum" item-index="'+i+'"  ><li class="fa fa-comments-o " ></li> '+forums_[i]['nombre']+'</a>'; 
	            html_forums+='	<div class="pull-right">';
	            /*html_forums+='		<a href="#" class="delete_forum" item-index="'+i+'"  > <span  class="glyphicon glyphicon-minus" ></span></a>';
	            html_forums+='		<a href="#" class="update_forum" item-index="'+i+'"   > <span class="glyphicon glyphicon-cog" ></span></a>'; 
	            */
	            html_forums+='		<a href="#"  class="threads_forum" item-index="'+i+'"  > Ingresar <li class="fa fa-tasks  " ></li> </a>';
	            
	            html_forums+='	</div>';
	            html_forums+='</div>';
			}			
		}

		$("#content_forums").empty().append(html_forums);

		$(".delete_forum").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_forum=index;
			$("#f_d_nombre").val(forums[idx_current_forum]['nombre']);
			$("#f_d_id_forum").val(forums[idx_current_forum]['id']);
			$("#modal_forum_delete").modal('show');
			r_text=[];
		});

		$(".update_forum").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_forum=index;
			$("#f_u_nombre").val(forums[idx_current_forum]['nombre']);
			$("#f_u_id_forum").val(forums[idx_current_forum]['id']);
			$("#f_u_id_quiz").val(forums[idx_current_forum]['id_quiz']);

			$("#modal_forum_update").modal('show');
			r_text=[];
		});
		$(".threads_forum").click(function(){
			r_text=[];
			var index=parseInt($(this).attr("item-index"));
			idx_current_forum=index;

			var data_ajax= {
				'id_forum':forums[idx_current_forum]['id']
			};
			GetAjax(data_ajax,"GetThreads",function(response){
				RefreshThreads(response);

				var data_ajax2= {
					'id_thread':0
				};
				GetAjax(data_ajax2,"GetPosts",function(response){
					RefreshPosts(response);
				});
			});
		});
	}

	function RefreshThreads(threads_){
		var html_threads="";
		if(forums.length==0 || forums ==null || forums===undefined){
			$("#list_threads_title").empty().append("Preguntas Detonadoras");
			$("#t_id_forum").val(0);

		}else{
			$("#list_threads_title").empty().append(forums[idx_current_forum]['nombre']);
			$("#t_id_forum").val(forums[idx_current_forum]['id']);
			$("#btn_modal_thread").fadeIn();

		}

		if(threads_.length==0 || threads_ ==null || threads_===undefined){
			html_threads+='<div  class="list-group-item">';
            html_threads+='	<div class="alert alert-default" > No hay preguntas detonadoras registradas hasta este momento. Porfavor seleccione un foro.</div>'; 
            html_threads+='	<div class="pull-right">';
            html_threads+='	</div>';
            html_threads+='</div>';
            threads=[];

		}else{
			threads=threads_;

			for (var i = 0; i < threads_.length; i++) {
				html_threads+='<div  href="#"  class="list-group-item">';
	            html_threads+='  <h5 class="list-group-item-heading">'+(i+1)+' <li class="fa fa-question-circle " ></li> '+threads_[i]['nombre']+'</h5>'; 
	            html_threads+='	<div class="pull-right">';
	            /*
	            html_threads+='		<a href="#" class="delete_thread" item-index="'+i+'"  > <span  class="glyphicon glyphicon-minus" ></span></a>';
	            html_threads+='		<a href="#" class="update_thread" item-index="'+i+'"   > <span class="glyphicon glyphicon-cog" ></span></a>'; 
	           	*/
	            html_threads+='		<a href="#list_posts_title" class="posts_thread" item-index="'+i+'"   > Responder  <li class="fa fa-pencil-square-o" ></li></a>'; 

	            html_threads+='	</div>';
	           // html_threads+='		<p class="list-group-item-text"><a href="#btn_form_post" class="posts_thread" item-index="'+i+'"  > Ver Comentarios <small>('+threads_[i]['comentarios']+')</small></a></p>';
	            html_threads+='		<p class="list-group-item-text"><a href="#btn_form_post" class="posts_thread" item-index="'+i+'"  >&nbsp; </small></a></p>';

	            html_threads+='</div>';
			}			
		}

		$("#content_threads").empty().append(html_threads);

		$(".delete_thread").click(function(){
			r_text=[];
			var index=parseInt($(this).attr("item-index"));
			idx_current_thread=index;
			$("#t_d_nombre").val(threads[idx_current_thread]['nombre']);
			$("#t_d_id_thread").val(threads[idx_current_thread]['id']);
			$("#modal_thread_delete").modal('show');
		});

		$(".update_thread").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_thread=index;
			$("#t_u_nombre").val(threads[idx_current_thread]['nombre']);
			$("#t_u_texto").val(threads[idx_current_thread]['texto']);
			$("#t_u_texto_correcta").val(threads[idx_current_thread]['texto_correcta']);
			$("#t_u_texto_incorrecta").val(threads[idx_current_thread]['texto_incorrecta']);
			$("#t_u_id_thread").val(threads[idx_current_thread]['id']);
			$("#form_thread_update-t_tipo").val(threads[idx_current_thread]['tipo']);
			r_text=[];
			var tmp_respuestas=[];
			for (var i = 0; i < threads[idx_current_thread]['responses'].length; i++) {
				if(parseInt(threads[idx_current_thread]['responses'][i]['es_correcta'])==1){
					r_idx_correct=i;
					$("#form_thread_update-t_u_idx_correct").val(r_idx_correct);
				}
				tmp_respuestas.push(threads[idx_current_thread]['responses'][i]['texto']);
			}

			RefreshResponses(tmp_respuestas,"form_thread_update");
			$("#form_thread_update-t_tipo").trigger("change");


			$("#modal_thread_update").modal('show');
		});

		$(".posts_thread").click(function(){
			var index=parseInt($(this).attr("item-index"));
			idx_current_thread=index;
			//$("#t_id_thread").val(threads[idx_current_thread]['id']);
			//$("#btn_modal_thread").fadeIn();
			var data_ajax= {
				'id_thread':threads[idx_current_thread]['id']
			};
			GetAjax(data_ajax,"GetPosts",function(response){
				RefreshPosts(response);
				$("#modal_coments").modal('show');
			});
		});
	}

	function RefreshPosts(posts_){
		
		var html_posts="";


		if(posts_.length==0 || posts_==null || posts_===undefined){
				html_posts+='<div class="panel-heading" id="list_posts_title" >Comentarios </div>';
	            html_posts+='	<div class="panel-body">'; 
	            html_posts+='		<div class="alert alert-default" >Seleccione una Pregunta Detonadora.</div>';
	            html_posts+='	</div>';
	            		posts=[];

		}else{
				posts=posts_;
				var alreadyPosted=false; 
				var alreadyPostedIdx=0; 

				if(threads[idx_current_thread]['tipo']==2){ // is multiresponse
					for (var f = 0; f < posts_.length; f++) { // Check If the user already post on a multiple response thread
						if(parseInt(posts_[f]['id_alumno'])==id_persona){
							alreadyPosted=true;
							alreadyPostedIdx=f;
						}
					}
				}
				

				var respuestas;
				var respuestasArray=[];
				for (var i = 0; i < posts_.length; i++) {

					if(i==0 && !alreadyPosted){ // primer post y no a posteado todavia
						html_posts+='<div class="panel-heading" id="list_posts_title" >'+threads[idx_current_thread]['nombre']+'</div>';
			            html_posts+='	<div class="panel-body">';
			            html_posts+='		<div class="alert alert-default" >';
			           // html_posts+='			<p><strong>Maestro: '+threads[idx_current_thread]['admin']+'</strong></p>';
			            html_posts+='			<p><h4>'+posts_[i]['texto']+'</h4></p>';
			            html_posts+='		</div>';
			            html_posts+='		<form id="form_post" name="form_post" >';
			            html_posts+='			<div class="row">';
			            html_posts+='				<input type="hidden" value="'+id_persona+'" class="form-control input-form_post" name="id_user" id="p_id_user" >';
			            html_posts+='				<input type="hidden" value="'+threads[idx_current_thread]['id']+'" class="form-control input-form_post" name="id_thread" id="p_id_thread" >';
			            html_posts+='				<input type="hidden" value="'+threads[idx_current_thread]['id_primer_post']+'" class="form-control input-form_post" name="id_parent" id="p_id_parent" >';
			            html_posts+='				<input type="hidden" value="RE: '+threads[idx_current_thread]['nombre']+'" class="form-control input-form_post" name="titulo" id="p_titulo" >';

			            respuestas=threads[idx_current_thread]['responses'];
			             var escorrecta=0;
			            for (var j = 0; j < respuestas.length; j++) {
			            	respuestasArray.push(respuestas[j]['id']);
			            	if(parseInt(respuestas[j]['es_correcta'])==1){
				            	escorrecta=1;
							}else{
								escorrecta=0;
							}

				            html_posts+='			<div class="col-md-12 text-left" >'
				           	html_posts+=' 			 	'+(j+1)+') - <strong> <input type="radio"  value="'+respuestas[j]['id']+'" class=" input-form_post respuestas" name="id_respuesta" id="id_respuesta'+j+'" error="Elige una respuesta porfavor." required> '+respuestas[j]['texto']+'</strong> ';
				            html_posts+='			</div>';

			            }
			            if(respuestas.length==0){
				           	html_posts+='  <input type="hidden"  value="0" class=" input-form_post respuestas" name="id_respuesta" id="id_respuesta0" error="Elige una respuesta porfavor." required> ';
			            }

			            html_posts+='			</div>';
			            html_posts+='					<div class="row"><div class="col-md-12" ><br></div>';
			            html_posts+='						<div class="col-md-8" >';
			            html_posts+='						<textarea type="text" style="resize: none;" class="form-control input-form_post" error="Porfavor ingresa el porqué de tu respuesta" name="texto" id="texto" placeholder="Escribe la razón de tu respuesta" required></textarea>';
			            html_posts+='						</div>';
			            html_posts+='						<div class="col-md-4" >';
			            html_posts+='						<button id="btn_form_post" class="btn btn-block btn-large btn-primary"  type="button"  >Enviar</button>';
			            html_posts+='						</div>';		            
			            html_posts+='					</div>';
			            html_posts+='		</form>';
			            html_posts+='	</div>';

						html_posts+='<div   class="list-group">';
					}else if(i==0 && alreadyPosted){

						html_posts+='<div class="panel-heading" id="list_posts_title" >'+threads[idx_current_thread]['nombre']+'</div>';
			            html_posts+='	<div class="panel-body">';
			            html_posts+='		<div class="alert alert-default" >';
			            //html_posts+='			<p><strong>Profesor: '+threads[idx_current_thread]['admin']+'</strong></p>';
			            html_posts+='			<p><h4>'+posts_[i]['texto']+'</h4></p>';
			            html_posts+='		</div>';
			            html_posts+='		<form id="form_post_view" name="form_post" >';
			            html_posts+='			<div class="row">';
			            html_posts+='				<input type="hidden" value="'+id_persona+'" class="form-control input-form_post" name="id_user" id="p_id_user" >';
			            html_posts+='				<input type="hidden" value="'+threads[idx_current_thread]['id']+'" class="form-control input-form_post" name="id_thread" id="p_id_thread" >';
			            html_posts+='				<input type="hidden" value="'+threads[idx_current_thread]['id_primer_post']+'" class="form-control input-form_post" name="id_parent" id="p_id_parent" >';
			            html_posts+='				<input type="hidden" value="RE: '+threads[idx_current_thread]['nombre']+'" class="form-control input-form_post" name="titulo" id="p_titulo" >';

			            respuestas=threads[idx_current_thread]['responses'];
			            
			            for (var j = 0; j < respuestas.length; j++) {
			            	respuestasArray.push(respuestas[j]['id']);
			            	if(respuestas[j]['texto']==posts_[alreadyPostedIdx]['respuesta_text']){
			            		var html_resp_user="";
				            		if(respuestas[j]['es_correcta']==1){
				            			html_resp_user='<label class="label label-success" data-toggle="tooltip" title="CORRECTA" ><i class="fa fa-check" aria-hidden="true"></i></label></strong>';
				            		}else{
				            			html_resp_user='<label class="label label-danger" data-toggle="tooltip" title="INCORRECTA" ><i class="fa fa-times" aria-hidden="true"></i></label></strong>';
				            		}
 								html_posts+='			<div class="col-md-12 text-left" >'
				           		html_posts+=' 			 	'+(j+1)+') - <strong> <input disabled=disabled type="radio"  value="'+respuestas[j]['id']+'" class=" input-form_post respuestas" name="id_respuesta" id="id_respuesta'+j+'" checked="checked" > '+respuestas[j]['texto']+' '+html_resp_user+' <- Tu Respuesta </strong>';
				            	html_posts+='			</div>';
							}else{
 								html_posts+='			<div class="col-md-12 text-left" >'
				           		html_posts+=' 			 	'+(j+1)+') - <strong> <input disabled=disabled type="radio"  value="'+respuestas[j]['id']+'" class=" input-form_post respuestas" name="id_respuesta" id="id_respuesta'+j+'"  > '+respuestas[j]['texto']+' </strong> ';
				            	html_posts+='			</div>';
							}
			            }

			            html_posts+='			</div>';
			            html_posts+='					<div class="row"><br>';
			            if(parseInt(posts_[alreadyPostedIdx]['respuesta_correcta'])==1){ // el usuario dio una respuesta correcoa
			            	html_posts+='					<div class="col-md-12" ><strong>Mensaje del Profesor</strong> <div class="alert alert-success" >Respuesta Correcta: '+threads[idx_current_thread]['texto_correcta']+'</div> </div>';
			            }else{ // si no dio la respuesta correcta
			            	html_posts+='					<div class="col-md-12" ><strong>Mensaje del Profesor</strong> <div class="alert alert-danger" >Respuesta Incorrecta: '+threads[idx_current_thread]['texto_incorrecta']+'</div> </div>';
			            }

			            html_posts+='						<div class="col-md-8" >';
			            html_posts+='							'+posts_[i]['fecha_registro']+' - <strong>Tu Respuesta </strong> <div class="well well-lg"  id="texto" >'+posts_[alreadyPostedIdx]['texto']+'</div>';
			            html_posts+='						</div>';	            
			            html_posts+='					</div>';
			            html_posts+='		</form>';
			            html_posts+='	</div>';
						html_posts+='<div   class="list-group">';

					}else{
						if(parseInt(threads[idx_current_thread]['tipo']) == 1 || parseInt(threads[idx_current_thread]['tipo'])==0 ){ // solo si ya posteo puede ver las respuestas de los demas alumnos

								html_posts+='	<div class="list-group-item">';
								var user=posts_[i]['user'];

							if(posts_[i]['user']==null || posts_[i]['user']==""){
								user="Alumno "+i;
							}

								if(threads[idx_current_thread]['tipo'] == 2){ // si es de tipo multiRESPUESTA
									if(posts_[i]['respuesta_correcta']==1){ // el usuario dio una respuesta correcta
										html_posts+='		<p >'+posts_[i]['fecha_registro']+' - <strong> '+user+'</strong> : <label class="label label-success" data-toggle="tooltip" title="CORRECTA: '+posts_[i]['respuesta_text']+'" ><i class="fa fa-check" aria-hidden="true"></i></label></p>';
									}else{ // el usuario dio una respuesta incorrecta
										html_posts+='		<p >'+posts_[i]['fecha_registro']+' - <strong> '+user+'</strong> : <label class="label label-danger" data-toggle="tooltip" title="INCORRECTA: '+posts_[i]['respuesta_text']+'" ><i class="fa fa-times" aria-hidden="true"></i></label></p>';
									}
								}else{ // no es un hilo de multirespuesta, ES UN hilo normal
									html_posts+='		<p >'+posts_[i]['fecha_registro']+' -<strong> '+user+'</strong></p>';
								}
							
				            html_posts+='			<p>'+posts_[i]['texto']+'</p>';
				            html_posts+='	</div>';

						}

					}
				}
				html_posts+='		</div>';
				html_posts+='</div>';
		}

		$("#content_posts").empty().append(html_posts);
 		$('[data-toggle="tooltip"]').tooltip();  

		$("#btn_form_post").click(function(){
					SendAjax(
					"form_post",
					"SetPost",
						function(){
							var data_ajax= {
								'id_thread':threads[idx_current_thread]['id']
							};
							GetAjax(data_ajax,"GetPosts",function(response){		
							posts=response;	
							RefreshPosts(posts);
							$("#modal_coments").modal('hide');
							});
						});

		});


	}


	InitializeForums();
	//CKEDITOR.replace( 't_texto' );

	function CKupdate(){
	    for ( instance in CKEDITOR.instances )
	        CKEDITOR.instances[instance].updateElement();
	}

});
