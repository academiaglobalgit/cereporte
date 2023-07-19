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

		this.configToast.timeOut = this.snConfigDefault ? msje.length * 200 : this.configToast.timeOut;
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
	error: function(title, msje, response)
	{
		this.settingToast(msje, '.toast-error');
		toastr.error(msje, title);
		this.adjustToastWidth(title, '.toast-error');
		this.resetConfig();

		if(response){
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

	//METODO QUE AJUSTA EL EL WIDTH DE UNA NOTIFICACION
	adjustToastWidth: function(_title, _class)
	{
		setTimeout(function()
		{			
			var sizeWidth = _title.length * 10;
			var toastWidth = $('#toast-container').width();
			$(_class).css('width', sizeWidth > toastWidth ? sizeWidth : toastWidth);
		},0);
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