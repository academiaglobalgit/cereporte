$( document ).ready(function() {

	function GetIncidenciasTotales(){
		GetAjax([],"GetIncidenciasTotales",function(response){
			$("#i_g_activas").empty().append(parseInt(response[0]['conteo'])+parseInt(response[4]['conteo']));
			$("#i_g_proceso").empty().append(response[1]['conteo']);
			$("#i_g_realizadas").empty().append(response[2]['conteo']);
			$("#i_g_canceladas").empty().append(response[3]['conteo']);
		});
	}

	function GetIncidenciasTotalesUsuario(){
		GetAjax([],"GetIncidenciasTotalesUsuario",function(response){
			$("#i_activas").empty().append(parseInt(response[0]['conteo'])+parseInt(response[4]['conteo']));
			$("#i_proceso").empty().append(response[1]['conteo']);
			$("#i_realizadas").empty().append(response[2]['conteo']);
			$("#i_canceladas").empty().append(response[3]['conteo']);
		});
	}


	function GetIncidenciasSolucionadasUsuario(){
		GetAjax([],"GetIncidenciasSolucionadasUsuario",function(response){
			$("#i_solucionadas").empty().append(parseInt(response[0]['solucionadas']));

		});
	}


	function InitializeInicio(){
		GetIncidenciasTotales();
		GetIncidenciasTotalesUsuario();
		GetIncidenciasSolucionadasUsuario();
	}

	InitializeInicio();
});