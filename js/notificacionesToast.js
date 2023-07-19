var notificacionesToast = function(){};

notificacionesToast.prototype = 
{
	configToast: null,

	//METODO QUE ASIGNA UNA CONFIGURACION POR DEFAULT
	getDefaultConfigToast: function()
	{
		this.configToast = {
			closeButton: true,
			debug: false,
			newestOnTop: false,
			progressBar: false,
			positionClass: "toast-bottom-right",
			preventDuplicates: true,
			onclick: null,
			showDuration: "300",
			hideDuration: "1000",
			timeOut: "5000",
			extendedTimeOut: "1000",
			showEasing: "swing",
			hideEasing: "linear",
			showMethod: "fadeIn",
			hideMethod: "fadeOut"
		};
	},

	//METODO QUE CREA EL OBJETO TOASTR.OPTIONS
	settingToast: function(msje, classToast)
	{
		if(this.configToast == null){
			this.getDefaultConfigToast();
		}

		this.configToast.timeOut = this.snConfigDefault ? msje.length * 150 : this.configToast.timeOut;
		toastr.options = this.configToast;
		toastr.options.onShown = function () { $(classToast).css('opacity', '1.0') }		
	},

	//MENSAJE SUCCESS
	success: function(title, msje)
	{
		this.settingToast(msje, '.toast-success');
		toastr.success(msje, title);
		this.resetConfig();
	},

	//MENSAJE ERROR
	error: function(title, msje, response = null)
	{
		this.settingToast(msje, '.toast-error');
		toastr.error(msje, title);
		this.resetConfig();

		if(response != null){
			console.log(response);
		}
	},

	//MENSAJE WARNING
	warning: function(title, msje)
	{
		this.settingToast(msje, '.toast-warning');
		toastr.warning(msje, title);
		this.resetConfig();
	},

	//MENSAJE INFO
	info: function(title, msje)
	{
		this.settingToast(msje, '.toast-info');
		toastr.info(msje, title);   
		this.resetConfig();
	},

	//CAMBIAR CONFIGURACION CONFIG
	changeConfig: function(_config)
	{
		this.configToast = _config;
	},

	//RESETEAR CONFIGURACION
	resetConfig:function()
	{
		this.configToast = null;
	}
};