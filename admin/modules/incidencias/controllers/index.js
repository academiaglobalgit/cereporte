$( document ).ready(function() {

	function GetIncidenciasTotales(){
		GetAjax([],"GetIncidenciasTotales",function(response){
			$("#i_activas").empty().append(response[0]['conteo']);
			$("#i_proceso").empty().append(response[1]['conteo']);
			$("#i_realizadas").empty().append(response[2]['conteo']);
			$("#i_canceladas").empty().append(response[3]['conteo']);

		});
	}

	function InitializeInicio(){
		GetIncidenciasTotales();
	}

	InitializeInicio();
});