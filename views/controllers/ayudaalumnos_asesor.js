(function ()
{
	var arrayFiles = [];
	var nuFilesMax = 3;
	var toast = new notificacionesToast();
	var snFinalizar = false;
	var snCancelar = false;
	var paginador = new paginadoJquery();

	//SE INICIALIZA EL DOCUMENTO
	$(document).ready(function()
	{
		$("#btnCancelarEditarTicket").on('click', function()
		{
			visualizarListado();
		});

		$("#lblManual").on('click', function()
		{
			openNewWindowPost("https://agcollege.edu.mx/cereporte/datos/files/downloadManual.php");
			//openNewWindowPost("http://agcollege.com.mx/cereporte/datos/files/downloadManual.php");
		});

		/******************************************************/
		/************* EVENTO GUARDAR TICKET ******************/
		/******************************************************/

		$("#btnGuardarEditarTicket").on('click', function()
		{
			if(validarFormularioEditar())
			{
				var formData = new FormData();
				formData.append('a', 'guardarEditarTicketAsesor');
				formData.append('de_mensaje', $("#de_mensajeEditar").val());
				formData.append('id_titulo', $("#id_titulo").val());

				$.ajax({
					url: 'datos/ayuda_alumnos.php',
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,                         
					type: 'post',
					beforeSend: function(){
						$('.loading').show();
					},
					complete: function(){
						$('.loading').hide();
					},
					success: function(response)
					{
						if(response.success)
						{
							$("#de_mensaje").val('');
							toast.success("Mensaje enviado", "El mensaje se envio correctamente");
							visualizarListado();
						}
						else
						{
							toast.error(response.errorTitle, response.errorMensaje);
							console.log(response);
						}
					},
					error: function(response)
					{
						toast.error('Error al enviar el mensaje', 'Ocurrio un error en el servidor');
						console.log(response);
					}
				});
			}
		});	

		/******************************************************/
		/************* EVENTO FINALIZAR TICKET ****************/
		/******************************************************/

		$("#btnFinalizarEditarTicket").on('click', function()
		{
			var deMensaje = $("#de_mensajeEditar").val()
			
			if(!isNull('string', deMensaje))
			{
				toast.error('Mensaje sin guardar', 'Favor de guardar o borrar el mensaje escrito');
			}
			else
			{
				$("#modalConfirmarFinalizar").modal({
					backdrop: 'static',
					keyboard: false
				}).show()
			}
		});

		$("#btnAceptarFinalizar").on('click', function()
		{
			snFinalizar = true;
			$('#modalConfirmarFinalizar').modal('hide');
		});

		$("#btnCancelarFinalizar").on('click', function()
		{
			snFinalizar = false;
			$('#modalConfirmarFinalizar').modal('hide');
		});			

		$('#modalConfirmarFinalizar').on('hidden.bs.modal', function (e)
		{
			if(snFinalizar)
			{
				snFinalizar = false;

				var formData = new FormData();
				formData.append('a', 'finalizarTicketAsesor');
				formData.append('id_titulo', $("#id_titulo").val());

				$.ajax({
					url: 'datos/ayuda_alumnos.php',
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,                         
					type: 'post',
					beforeSend: function(){
						$('.loading').show();
					},
					complete: function(){
						$('.loading').hide();
					},
					success: function(response)
					{
						if(response.success)
						{
							$("#de_mensaje").val('');
							toast.success("Solicitud finalizada", "La solicitud se finalizo correctamente");
							visualizarListado();
						}
						else
						{
							toast.error(response.errorTitle, response.errorMensaje);
							console.log(response);
						}
					},
					error: function(response)
					{
						toast.error('Error al finalizar la solicitud', 'Ocurrio un error en el servidor');
						console.log(response);
					}
				});
			}
		});

		/******************************************************/
		/************* EVENTO EN PROCESO TICKET ****************/
		/******************************************************/


		$("#btnEnProcesoTicket").on('click', function()
		{
			var deMensaje = $("#de_mensajeEditar").val()
			
			if(!isNull('string', deMensaje))
			{
				toast.error('Mensaje sin guardar', 'Favor de guardar o borrar el mensaje escrito');
			}
			else
			{
				$("#modalConfirmarEnProceso").modal({
					backdrop: 'static',
					keyboard: false
				}).show()
			}
		});

		$("#btnAceptarProceso").on('click', function()
		{
			snProceso = true;
			$('#modalConfirmarEnProceso').modal('hide');
		});

		$("#btnCancelarProceso").on('click', function()
		{
			snProceso = false;
			$('#btnCancelarProceso').modal('hide');
		});			

		$('#modalConfirmarEnProceso').on('hidden.bs.modal', function (e)
		{
			if(snProceso)
			{
				snProceso = false;

				var formData = new FormData();
				formData.append('a', 'procesosTicketAsesor');
				formData.append('id_titulo', $("#id_titulo").val());

				$.ajax({
					url: 'datos/ayuda_alumnos.php',
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,                         
					type: 'post',
					beforeSend: function(){
						$('.loading').show();
					},
					complete: function(){
						$('.loading').hide();
					},
					success: function(response)
					{
						if(response.success)
						{
							$("#de_mensaje").val('');
							toast.success("Solicitud en proceso", "La solicitud se puso en proceso correctamente");
							visualizarListado();
						}
						else
						{
							toast.error(response.errorTitle, response.errorMensaje);
							console.log(response);
						}
					},
					error: function(response)
					{
						toast.error('Error al poner en proceso la solicitud', 'Ocurrio un error en el servidor');
						console.log(response);
					}
				});
			}
		});



		/******************************************************/
		/************* EVENTO CANCELAR TICKET ****************/
		/******************************************************/

		/*$("#btnCancelarTicketEditarTicket").on('click', function()
		{
			$("#modalConfirmarCancelar").modal({
				backdrop: 'static',
				keyboard: false
			}).show();
		});

		$("#btnAceptarCancelar").on('click', function()
		{
			snCancelar = true;
			$('#modalConfirmarCancelar').modal('hide');
		});

		$("#btnCancelarCancelar").on('click', function()
		{
			snCancelar = false;
			$('#modalConfirmarCancelar').modal('hide');
		});	

		$('#modalConfirmarCancelar').on('hidden.bs.modal', function (e)
		{
			if(snCancelar)
			{
				snFinalizar = false;

				var formData = new FormData();
				formData.append('a', 'cancelarTicketAsesor');
				formData.append('id_titulo', $("#id_titulo").val());

				$.ajax({
					url: 'datos/ayuda_alumnos.php',
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,                         
					type: 'post',
					beforeSend: function(){
						$('.loading').show();
					},
					complete: function(){
						$('.loading').hide();
					},
					success: function(response)
					{
						if(response.success)
						{
							$("#de_mensaje").val('');
							toast.success("Solicitud cancelada", "La solicitud se cancelo correctamente");
							visualizarListado();
						}
						else
						{
							toast.error(response.errorTitle, response.errorMensaje);
							console.log(response);
						}
					},
					error: function(response)
					{
						toast.error('Error al cancelar la solicitud', 'Ocurrio un error en el servidor');
						console.log(response);
					}
				});
			}
		});*/

		function refreshScroll()
		{
	 		$(window).attr('style', 'overflow-y: auto !important');
	 		$(window).scrollTop(0);
		}

		function visualizarListado()
		{
			$("#divEditarTickets").hide();
			$("#divListadoTickets").fadeIn(0, function(){
				initListadoTickets();
			});	
		}
		
		function initListadoTickets()
		{
			//$("#divContenedorAsesor").css('height', $(window).height());
			
			$("#divContenedorAsesor").addClass("embed-responsive-4by3");
			$("#divContenedorAsesor").addClass("embed-responsive");

			var formData = new FormData();
        	formData.append('a', 'listadoTicketsAsesor');

        	paginador.setFormData(formData);
			paginador.setUrlFileserver('datos/ayuda_alumnos.php');
			paginador.setFunctionUpdateTable(createBodyListado);

			paginador.setFunctionMsjeErrorServer(function(errorTitle, errorMsje){
				toast.error(errorTitle, errorMsje);
			});

			paginador.setFunctionBeforeServer(function()
			{
				$('.loading').show();
                $("#tickets_listado_body").empty();
			});

			paginador.setFunctionAfterServer(function(){
				$('.loading').hide(); 
			});

			paginador.initializeServer("listadoTicketsPaginado");

			refreshScroll();
		}

		function createBodyListado(dataArray)
		{
			if(dataArray.length > 15)
			{
				$("#divContenedorAdmin").removeClass("embed-responsive-4by3");
				$("#divContenedorAdmin").removeClass("embed-responsive");
			}
			else
			{
				$("#divContenedorAdmin").removeClass("embed-responsive-4by3");
				$("#divContenedorAdmin").removeClass("embed-responsive");

				$("#divContenedorAdmin").addClass("embed-responsive-4by3");
				$("#divContenedorAdmin").addClass("embed-responsive");	
			}

			var bodyTable = $("#tickets_listado_body");
			bodyTable.empty();

			$.each(dataArray, function(index, item)
			{
				var tr = $('<tr/>');
				tr.append('<td>' + item.id_titulo + '</td>');						

				var tdTitulo = $('<td/>');
				var spanTitulo = $('<span style="cursor:pointer;">' + item.de_titulo + '</span>');
				spanTitulo.attr('dataTicket', JSON.stringify(item));

				switch(item.cl_estatus)
				{
					case '1': spanTitulo.addClass('label label-primary'); break;//VIGENTE
					case '2': spanTitulo.addClass('label label-warning'); break;//VENCIDO
					case '3': spanTitulo.addClass('label label-danger'); break;//CANCELADO
					case '4': spanTitulo.addClass('label label-success'); break;//FINALIZO
					case '5': spanTitulo.addClass('label label-warning'); break;//FINALIZO
					default: spanTitulo.addClass('label label-default'); break;
				}

				if(item.nuMensajesNuevos > 0)
				{
					var badgeMensajes = $('<span class="badge pull-right" style="background-color: #d9534f !important;">' + item.nuMensajesNuevos + '</span>');
					tdTitulo.append(badgeMensajes);
				}
	
				spanTitulo.on('click', function()
				{
					var itemSelected = JSON.parse( $(this).attr('dataTicket') );
					visualizarEditarTickets(itemSelected);
				});

				tdTitulo.append(spanTitulo);
				tr.append(tdTitulo);
				tr.append('<td>' + item.fh_registro + '</td>');
				tr.append('<td>' + item.fh_ultima_modificacion + '</td>');
				tr.append('<td>' + item.nb_plan_estudio + '</td>');
				tr.append('<td>' + item.de_departamento + '</td>');
				tr.append('<td>' + item.nb_asesor + '</td>');
				tr.append('<td>' + item.de_estatus + '</td>');						
				bodyTable.append(tr);
			});
		}

		function visualizarEditarTickets(item)
		{
			$("#divListadoTickets").hide();
			$("#divEditarTickets").fadeIn(0, function()
			{	
				$("#id_titulo").val(item.id_titulo);						
				$("#id_titulo").text(item.id_titulo);
				$("#de_titulo").text(item.de_titulo);
				$("#nu_empleado").text(item.numero_empleado);
				$("#nu_telefono").text(item.nu_telefono);
				$("#nb_cliente").text(item.nb_cliente);
				$("#nb_planestudio").text(item.nb_plan_estudio);
				$("#lblPlanEstudio").empty();

				console.log(item);

				switch(item.id_plan_estudio)
				{
					case '2': $("#lblPlanEstudio").append('<span class="label col-12 col-lg-12" style="background-color: #265BA7; color:#FFFFFF;">'+ item.nb_plan_estudio +'</span>'); break;					
					case '22': $("#lblPlanEstudio").append('<span class="label col-12 col-lg-12" style="background-color: #265BA7; color:#FFFFFF;">'+ item.nb_plan_estudio +'</span>'); break;
				}
		
				if(item.cl_estatus == 2 || item.cl_estatus == 4)
				{
					$("#divMensajeEditar").hide();
					$("#btnGuardarEditarTicket").hide();
					$("#btnFinalizarEditarTicket").hide();
					$("#btnCancelarTicketEditarTicket").hide();
					$("#btnEnProcesoTicket").hide();
				}
				else if(item.cl_estatus == 5)
				{
					$("#btnEnProcesoTicket").hide();
				}
				else
				{
					$("#divMensajeEditar").show();
					$("#btnGuardarEditarTicket").show();
					$("#btnFinalizarEditarTicket").show();
					$("#btnCancelarTicketEditarTicket").show();	
					$("#btnEnProcesoTicket").show();				
				}

				initDataEditTickets();
			});
		}

		function initDataEditTickets()
		{
			var formData = new FormData();
			formData.append('a', 'getDetalleTicketAsesor');
			formData.append('id_titulo', $("#id_titulo").val());

			$.ajax({
				url: 'datos/ayuda_alumnos.php',
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: formData,
				type: 'post',
				beforeSend: function()
				{
					$('.loading').show();
					$("#divChats").empty();
					$('#de_mensajeEditar').val('');
				},
				complete: function(){
					$('.loading').hide();					
				},
				success: function(response)
				{
					if(response.success)
					{
						var divChats = $("#divChats");

						$.each(response.data, function(index, item)
						{
							var divParent = $('<div class="row message-body" style="margin-bottom:10px;"/>');
							var divChild;
							var divMessageContent;
							var title;
							var divMessage = $('<div class="message-text"/>');
							var span = $('<span class="message-time pull-right"/>');

							if(item.sn_automatico == 1)
							{
								divChild = $('<div class="col-sm-12 message-main-sender"/>');
								divMessageContent = $('<div class="sender"/>');
								title = $('<p class="name">ASESOR</p>');
							}
							else if(item.sn_notificacion == 1)
							{
								divChild = $('<div class="col-sm-12 notificationMsje-main"/>');
								divMessageContent = $('<div class="notificationMsje"/>');
								title = $('<div/>');								
							}
							//SI LA PERSONA ES NULO EL MENSAJE ES DEL ALUMNO, SI NO ES DEL ASESOR
							else if(isNull('string', item.id_persona) && item.sn_automatico == 0)
							{
								divChild = $('<div class="col-sm-12 message-main-receiver"/>');
								divMessageContent = $('<div class="receiver"/>');
								title = $('<p class="name">' + item.nb_alumno + '</p>');
							}
							else //MENSAJE DEL ASESOR
							{
								divChild = $('<div class="col-sm-12 message-main-sender"/>');
								divMessageContent = $('<div class="sender"/>');
								title = $('<p class="name">ASESOR</p>');
							}

							divMessage.text(item.de_mensaje);
							span.text(item.hr_mensaje);

							divMessageContent.append(title);
							divMessageContent.append(divMessage);
							divMessageContent.append(span);
							divChild.append(divMessageContent);
							divParent.append(divChild);

							divChats.append(divParent);							
						});
					}
					else
					{						
						toast.error(response.errorTitle, response.errorMensaje);
					}
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					toast.error('Error al obtener el detalle de la solicitud', 'Ocurrio un error en el servidor');
					console.log(errorThrown);
				}
			});				

			refreshScroll();
		}

		function validarFormularioEditar()
		{
			var bandera = true;

			if(isNull('string', $("#de_mensajeEditar").val()))
			{
				toast.error('Información faltante', 'Favor de escribir un mensaje');
				bandera = false;
			}

			return bandera;
		}

		initListadoTickets();
	});

}());