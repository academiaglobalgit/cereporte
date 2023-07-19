(function ()
{
	var arrayFiles = [];
	var nuFilesMax = 3;
	var toast = new notificacionesToast();
	var paginador = new paginadoJquery();
	var arrayAsesores = [];
	var snEliminar = false;

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
		
		//EVENTO EDITAR TICKET PARA AGREGAR NUEVO MENSAJE
		$("#btnGuardarEditarTicket").on('click', function()
		{
			if(validarFormularioEditar())
			{
				var formData = new FormData();
				formData.append('a', 'asignarTicketDepartamento');
				formData.append('id_titulo', $("#id_titulo").val());

				if(!isNull('string', $("#nb_departamento").val()))
				{
					formData.append('id_departamento', $("#nb_departamento").val());					
				}				

				if(!isNull('string', $("#nb_asesor").val()))
				{
					formData.append('id_asesor', $("#nb_asesor").val());					
				}

				//AJAX QUE SUBE EL ARCHIVO
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
							toast.success("Solicitud asignada", "La solicitud se asigno correctamente");
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
						toast.error('Error al asignar la solicitud', 'Ocurrio un error en el servidor');
						console.log(response);
					}
				});
			}
		});	

		$("#btnFinalizarEditarTicket").on('click', function()
		{
			$('#modalConfirmarFinalizar').modal({ keyboard: false }).show();
		});

		$("#btnCancelarTicketEditarTicket").on('click', function()
		{
			$('#modalConfirmarCancelar').modal({ 
				backdrop: 'static',
				keyboard: false
			}).show();
		});

		$("#nb_departamento").on('change', function()
		{
			var idDepartamento = $(this).val();
			var asesoresFilter = $.grep(arrayAsesores, function(item) {
			    return item.id_area === idDepartamento;
			});

			var selectAsesores = $('#nb_asesor');
			selectAsesores.find('option').remove().end().append('<option value="">Seleccione..</option>');
			$.each(asesoresFilter, function(index, item){
				selectAsesores.append('<option value="' + item.id_asesor+ '">' + item.nb_asesor + '</option>');
			});
		});
		
		function visualizarListado()
		{
			$("#divEditarTickets").hide();
			$("#divListadoTickets").fadeIn(0, function(){
				initListadoTickets();
			});	
		}

		function resfreshScroll()
		{
	 		$(window).scrollTop(0);
			$(window).attr('style', 'overflow-y: auto !important');
		}
		
		function initListadoTickets()
		{
			//$("#divContenedorAdmin").css('height', $(window).height());

			$("#divContenedorAdmin").addClass("embed-responsive-4by3");
			$("#divContenedorAdmin").addClass("embed-responsive");

			var formData = new FormData();
        	formData.append('a', 'listadoTicketsAdministrador');

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

			/*$("#divContenedorAdmin").removeClass("embed-responsive-4by3");
			$("#divContenedorAdmin").removeClass("embed-responsive");*/

			var bodyTable = $("#tickets_listado_body");
			bodyTable.empty();

			$.each(dataArray, function(index, item)
			{
				var tr = $('<tr id="_index' + item.id_titulo + '"/>');
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
					default: spanTitulo.addClass('label label-default'); break;
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

				var buttonDelete = $('<button type="button" data="'+ item.id_titulo + '" idRow="_index' + item.id_titulo + '" class="btn btn-sm btn-default"><i class="fa fa-times" aria-hidden="true"></i></button>');
				buttonDelete.on('click', function()
				{
					$("#id_titulo").val($(this).attr('data'));

					$("#modalEliminarRegistro").attr('idrow', $(this).attr('idRow'));
					$("#modalEliminarRegistro").modal({backdrop: 'static', keyboard: false}).show();
				});

				var divButtons = $('<div/>');
				var tdAcciones = $('<td/>');
				divButtons.append(buttonDelete);
				tdAcciones.append(divButtons);
				tr.append(tdAcciones);

				bodyTable.append(tr);
			});

			resfreshScroll();
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

				switch(item.cl_estatus)
				{
					case '1': editarModoLectura(false); break; 
					case '2': editarModoLectura(false); break; 
					case '3': editarModoLectura(true); break; 
					case '4': editarModoLectura(true); break; 
				}

				initDataEditTickets(item);
			});
		}

		function editarModoLectura(bandera)
		{
			if(bandera)
			{
				$("#btnGuardarEditarTicket").hide();
				$("#nb_departamento").attr('disabled', 'disabled');
				$("#nb_asesor").attr('disabled', true);
			}
			else
			{
				$("#btnGuardarEditarTicket").show();
				$("#nb_departamento").removeAttr('disabled');
				$("#nb_asesor").attr('disabled', false);
			}			
		}

		function initDataEditTickets(item)
		{
			var formData = new FormData();
			formData.append('a', 'getAsignarTicketAdministrador');
			formData.append('id_titulo', item.id_titulo);

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
					$('#nb_departamento').find('option').remove().end().append('<option value="">Seleccione..</option>');
					$('#nb_asesor').find('option').remove().end().append('<option value="">Seleccione..</option>');
				},
				complete: function(){
					$('.loading').hide();					
				},
				success: function(response)
				{
					if(response.success)
					{
						var selectDepartamentos = $('#nb_departamento');
						var selectAsesores = $('#nb_asesor');
						var snSelected = false;
						arrayAsesores = response.data.asesores;

						$.each(response.data.departamentos, function(index, item)
						{
							selectDepartamentos.append('<option dataAsesores="'+ JSON.stringify(item) +'" value="' + item.id_departamento+ '">' + item.nb_departamento + '</option>');
						});

						$.each(response.data.asesores, function(index, item)
						{							
							selectAsesores.append('<option value="' + item.id_asesor+ '">' + item.nb_asesor + '</option>');
						});

						if(!isNaN(parseInt(item.id_departamento)) && item.id_departamento != '1'){
							selectDepartamentos.val(item.id_departamento);
						} 

						if(!isNaN(parseInt(item.id_asesor))){
							selectAsesores.val(item.id_asesor);
						} 

						//ASIGNAMOS MENSAJES
						var divChats = $("#divChats");
						divChats.empty();

						$.each(response.data.mensajes, function(index, item)
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
					toast.error('Error al obtener el listado de tickets', 'Ocurrio un error en el servidor');
					console.log(errorThrown);
				}
			});				
		}

		function validarFormularioEditar()
		{
			if(isNull('string', $("#nb_departamento").val()) && isNull('string', $("#nb_asesor").val()))
			{
				toast.error('Información incompleta', 'Favor de seleccionar un departamento, o un asesor, o ambos');
				return false;
			}

			return true;
		}

		$("#btnCancelarEliminarRegistro").on('click', function()
		{
			snEliminar = false;
			$('#modalEliminarRegistro').modal('hide');
		});

		$("#btnAceptarEliminarRegistro").on('click', function()
		{
			snEliminar = true;
			$('#modalEliminarRegistro').modal('hide');
		});

		$('#modalEliminarRegistro').on('hidden.bs.modal', function (e)
		{
			if(snEliminar)
			{
				snEliminar = false;
				var rowDeleteID = $(this).attr('idRow')

				var formData = new FormData();
				formData.append('a', 'eliminarTicketAsesor');
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
							$("#"+rowDeleteID).remove();
							$("#id_titulo").val("");
							toast.success("Solicitud eliminada", "La solicitud se elimino correctamente");							
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
		});
		
		initListadoTickets();
	});
}());