var app = angular.module('appAyudaAdmin',  ["ngSanitize", "ngCsv","angularUtils.directives.dirPagination",'ngAnimate','ngFileUpload','luegg.directives']);
app.directive('ngEnter', function() {
        return function(scope, element, attrs) {
            element.bind("keydown keypress", function(event) {
                if(event.which === 13) {
                    scope.$apply(function(){
                        scope.$eval(attrs.ngEnter, {'event': event});
                    });

                    event.preventDefault();
                }
            });
        };
    });

app.directive('animateOnChange', function($animate,$timeout) {
  return function(scope, elem, attr) {
      scope.$watch(attr.animateOnChange, function(nv,ov) {
        if (nv!=ov) {
          var c = nv > ov?'change-up':'change';
          $animate.addClass(elem,c).then(function() {
            $timeout(function() {$animate.removeClass(elem,c);});
          });
        }
      });
   };
}).directive('customAutofocus', function() {
  return{
         restrict: 'A',

         link: function(scope, element, attrs){
           scope.$watch(function(){
             return scope.$eval(attrs.customAutofocus);
             },function (newValue){
               if (newValue == true){
                   element[0].focus();
                   element[0].val(element[0].val());

               }
           });
         }
     };
})
;


app.factory('Excel',function($window){
        var uri='data:application/vnd.ms-excel;base64,',
            template='<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64=function(s){return $window.btoa(unescape(encodeURIComponent(s)));},
            format=function(s,c){return s.replace(/{(\w+)}/g,function(m,p){return c[p];})};
        return {
            tableToExcel:function(tableId,worksheetName){
                var table=angular.element(tableId);
                    ctx={worksheet:worksheetName,table:table.html()},
                    href=uri+base64(format(template,ctx));
                return href;
            }
        };
    }).controller('ctrlAyudaAdmin', ['Excel','$timeout','$scope','$http','$location','Upload','$interval', function(Excel,$timeout,$scope,$http,$location,Upload,$interval) {
		$scope.currenturl=window.location.href;
	    $scope.resultUrl = $scope.currenturl.substring(0, $scope.currenturl.lastIndexOf("/") + 1);
		$scope.imagen;
		$scope.cargando=false;
		$scope.cargandoFrecuentes=false;
		$scope.region="";
		$scope.id_usuario=1;
		$scope.status='';
		$scope.loading_gif='img/pinki.gif';
		$scope.loading_gif='img/loader.gif';

		$scope.easteregg1=false;
		$scope.easteregg2=false;

		// INICIO 
		$scope.maxChats=3;
		$scope.title="Chat de Ayuda";
		$scope.notificaciones=0;

		$scope.totalesSegui=[];
		//seguimientos variables
		$scope.regiones=[];
		$scope.currentChat=[];
		$scope.ID=0;
		$scope.IDX=0;
		$scope.currentAsunto="Seguimiento";
		$scope.seguimientos=[];
		$scope.showSeguimientos=[];
		$scope.funcSeguimientos=[];
		$scope.funcSetMensajes=[];
		$scope.funcFocus=[];
		$scope.chatMensaje=[];
		$scope.AutoUpdates=[];
		$scope.StatusSeguimientos=[];
		$scope.Estatus=[];
		$scope.Estatus[0]="Desconectado";
		$scope.Estatus[1]="En-Linea";
		//PREGUNTAS FRECUENTES
		$scope.frecuentes=[];
		$scope.showFrecuentes=[];
		$scope.cargandoForm=false;

		$scope.showSeguimientos=[];
		$scope.minSeguimientos=[];

		$scope.MsgSeguimientos=[];

		$scope.classSeguimiento=[];
		$scope.corporaciones=[];
		if($location.search().iduser){ // valida si exíste el parametro
			$scope.id_usuario = $location.search().iduser; 
		}
		$scope.titleMostrar=false;
		$scope.NotifInterval=undefined;

			if(!angular.isDefined($scope.NotifInterval)){

				$scope.NotifInterval=$interval(function (){

					if($scope.titleMostrar){
		    			if($scope.notificaciones>0){
							$scope.title="("+$scope.notificaciones+") Mensajes ";
						}else{
							$scope.title="Chat de Ayuda";
						}
						$scope.titleMostrar=false;
					}else{
						$scope.title="Chat de Ayuda";
						$scope.titleMostrar=true;
					}
						

				}, 1000);
	    	}



			$scope.intervalUpdate=undefined;
			if(!angular.isDefined($scope.intervalUpdate)){
				$scope.intervalUpdate=$interval(function (){
					$scope.GetSeguimientos(' ');
				}, 10000);
	    	}

		$scope.selectImg= function (file,invalidfiles){
				alert(file);
				if(form.file.$valid){
					$scope.file=file;
				}

		};

		$scope.vistaMas = function (){
			var alto= $("#divContenido").height();
			$("#frame",window.parent.document).height((alto+400));
		}

		$scope.vistaMenos= function (){
			var alto= $("#divContenido").height();
			//$("#frame",window.parent.document).height((alto-200));
		}

	$scope.GetTotalesSeguimientos=function (){

	    		var url=$scope.resultUrl+"datos/GetTotalesSeguimientos.php";
				$http.get
				(
					url
				).success(function(data,status,headers,config)
				{	

					if(angular.isObject(data)){

						$scope.totalesSegui=data;
					}



				})
				.error(function(err,status,headers,config)
				{
					//alert("Error al optener el las preguntas frecuentes");
					console.log("Error al optener los totales"+err);
	    			

				});
			    

	    	
	}

	$scope.easterEgg=function (){
		$scope.easteregg2=true;

		 if($scope.easteregg1 && $scope.easteregg2){ 
		 	loading_gif='img/pinki.gif'; 
		 }
	}
	$scope.GetRegiones=function (){

	    		var url=$scope.resultUrl+"datos/getRegiones.php";
				$http.get
				(
					url
				).success(function(data,status,headers,config)
				{	

					if(angular.isObject(data)){
						$scope.regiones=data;
					}else{
						$scope.regiones=[];
					}
				})
				.error(function(err,status,headers,config)
				{
					//alert("Error al optener el las preguntas frecuentes");
					console.log("Error al optener regiones"+err);
				});
			    
	    	
	}
	$scope.GetCorporaciones=function (){

	    		var url=$scope.resultUrl+"datos/getCorporaciones.php";
				$http.get
				(
					url
				).success(function(data,status,headers,config)
				{	

					if(angular.isObject(data)){
						$scope.corporaciones=data;
					}else{
						$scope.corporaciones=[];
					}
				})
				.error(function(err,status,headers,config)
				{
					//alert("Error al optener el las preguntas frecuentes");
					console.log("Error al optener corporaciones"+err);
				});
			    
	    	
	}
	$scope.GetFrecuentes = function ()
	    {
	    	if(!$scope.cargandoFrecuentes){


	    		$scope.cargandoFrecuentes=true;
	    		var url=$scope.resultUrl+"datos/GetFrecuentes.php";
				$http.get
				(
					url
				).success(function(data,status,headers,config)
				{	
					console.log("optener frecuentes");
	    			$scope.cargandoFrecuentes=false;

					if(angular.isObject(data)){

						$scope.frecuentes.length=0;
						$scope.frecuentes=data;
						for (var i = 0; i < $scope.frecuentes.length; i++) {
							if(i==0){
								$scope.showFrecuentes[$scope.frecuentes[i].id]=true;
							}else{
								$scope.showFrecuentes[$scope.frecuentes[i].id]=false;
							}

							if(i>4){
								$scope.vistaMas();
							}
						}
					}



				})
				.error(function(err,status,headers,config)
				{
					//alert("Error al optener el las preguntas frecuentes");
					console.log("Error al optener el las preguntas frecuentes:"+err);
	    			$scope.cargandoFrecuentes=false;

				});
			    

	    	}

		};

	$scope.RefreshNotif = function (){
		$scope.notificaciones=0;
		for (var i = 0; i < $scope.seguimientos.length; i++) {
			$scope.notificaciones+=$scope.seguimientos[i].notif;
		}

	};
	$scope.GetSeguimientos = function (region)
	    {

	    		$scope.cargando=true;
	    		var url=$scope.resultUrl+"datos/GetSeguimientos.php";
				$http.get
				(
					url
				).success(function(data,status,headers,config)
				{	
					$scope.cargando=false;

					if(angular.isObject(data)){
						$scope.notificaciones=0;
						$scope.seguimientos.length=0;
						//$scope.showSeguimientos.length=0;
						$scope.funcSeguimientos.length=0;
						$scope.funcSetMensajes.length=0;
						//$scope.AutoUpdates.length=0;
						$scope.StatusSeguimientos.length=0;
						$scope.seguimientos=data;
						for (var i = 0; i < $scope.seguimientos.length; i++) {
							$scope.seguimientos[i].chat=$scope.seguimientos[i].chat.reverse();
							$scope.funcSeguimientos[$scope.seguimientos[i].id]=$scope.GetMensajes;
							$scope.funcSetMensajes[$scope.seguimientos[i].id]=$scope.SetMensaje;
							$scope.StatusSeguimientos[$scope.seguimientos[i].id]=$scope.seguimientos[i].status;



							if(!angular.isDefined($scope.AutoUpdates[$scope.seguimientos[i].id])){
								$scope.AutoUpdates[$scope.seguimientos[i].id]=undefined;
							};

							if($scope.showSeguimientos[$scope.seguimientos[i].id]==true){
								$scope.showSeguimientos[$scope.seguimientos[i].id]=true;
							}else{
								$scope.showSeguimientos[$scope.seguimientos[i].id]=false;
							}

							if($scope.MsgSeguimientos[$scope.seguimientos[i].id]==""){
								$scope.MsgSeguimientos[$scope.seguimientos[i].id]=="";
							}
							$scope.minSeguimientos[$scope.seguimientos[i].id]=true;
							if($scope.classSeguimiento[$scope.seguimientos[i].id] != 'active'){
								$scope.classSeguimiento[$scope.seguimientos[i].id]='';
							}
							$scope.notificaciones+=$scope.seguimientos[i].notif;
							if(i>3){
								$scope.vistaMas();
							}


						}

						

					}

				})
				.error(function(err,status,headers,config)
				{
	    			$scope.cargando=false;

					console.log("Error al optener los seguimiento "+err);

				});
			    

	    

		};
		$scope.SetCurrentFocus = function (id){
			for (var i = 0; i < $scope.seguimientos.length; i++) {
				$scope.funcFocus[$scope.seguimientos[i].id]=false;
			}
			$scope.funcFocus[id]=true;

		};
		$scope.SetCurrentFrecuente = function (){
			angular.element("#pregunta_update").val($scope.frecuentes[$scope.IDX].asunto);
            angular.element("#respuesta_update").val($scope.frecuentes[$scope.IDX].mensaje);
            angular.element("#jerarquia_update").val($scope.frecuentes[$scope.IDX].jerarquia);
		};

		$scope.SetFrecuente = function (picFile)
	    {
	    	if(!$scope.cargandoForm){
				$scope.cargandoForm=true;
	    		var URL=$scope.resultUrl+"datos/SetFrecuente.php";

    		   Upload.upload({
		            url: URL,
		            method:"POST",
		            data: {
		            	file: picFile,
		                pregunta:angular.element("#pregunta").val(),
		                respuesta:angular.element("#respuesta").val(),
		                jerarquia:angular.element("#jerarquia").val()
		             }
		        }).then(function (resp) {

		           if( resp.data==1){
						alert("Pregunta Frecuente guardada");
						angular.element("#pregunta").val("");
		                angular.element("#respuesta").val("");
		                angular.element("#jerarquia").val("");
		                $scope.picFile=null;
		                $scope.cargandoForm=false;
		                $scope.GetFrecuentes();
					}else{
						$scope.cargandoForm=false;
						alert("No se pudo agregar la pregunta frecuente. \n porfavor ingrese los datos y video correctamente");
					}
		        }, function (resp) {
		            console.log("Error al agregar la pregunta frecuente");
	    			$scope.cargandoForm=false;
		        }, function (evt) {
		           /* var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
		            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);*/
		        });
			    

	    	}

		};

		$scope.SetFrecuenteUpdate = function (picFile2)
	    {
	    	if(!$scope.cargandoForm){
				$scope.cargandoForm=true;
	    		var URL=$scope.resultUrl+"datos/UpdateFrecuente.php";

    		   Upload.upload({
		            url: URL,
		            method:"POST",
		            data: {
		            	file: picFile2,
		            	id_frecuente:$scope.ID,
		                pregunta:angular.element("#pregunta_update").val(),
		                respuesta:angular.element("#respuesta_update").val(),
		                jerarquia:angular.element("#jerarquia_update").val()
		             }
		        }).then(function (resp) {

		           if( resp.data==1){
						alert("Pregunta Frecuente guardada");
						angular.element("#pregunta_update").val("");
		                angular.element("#respuesta_update").val("");
		                angular.element("#jerarquia_update").val("");
		                $scope.picFile=null;
		                $scope.cargandoForm=false;
						$('#modal_update').modal('hide');
		                $scope.GetFrecuentes();
					}else{
						$scope.cargandoForm=false;
						alert("No se pudo guardar la pregunta frecuente. \n porfavor ingrese los datos y video correctamente");
					}
		        }, function (resp) {
		            console.log("Error al guardar la pregunta frecuente");
	    			$scope.cargandoForm=false;
		        }, function (evt) {
		           /* var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
		            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);*/
		        });
			    

	    	}

		};

		$scope.SetMensaje = function (id_asunto,idx_asunto)
	    {
	    	if(!$scope.cargando){

				var msg=$scope.MsgSeguimientos[id_asunto];
	    		$scope.cargando=true;

	    		var datos= {
	    			mensaje: msg,
	    			id_asunto:id_asunto
	    		};
	    		var url=$scope.resultUrl+"datos/SetMensaje.php";

				$http.post
				(
					url,
					datos
				).success(function(data,status,headers,config)
				{	
					if(data==1){
						$scope.MsgSeguimientos[id_asunto]="";
						$scope.GetMensajes(id_asunto,idx_asunto);
					}else{
						console.log("Error al enviar el mensaje chat");
					}
					$scope.cargando=false;

				})
				.error(function(err,status,headers,config)
				{
					console.log("Error al enviar el mensaje"+err);
	    			$scope.cargando=false;

				});
			    

	    	}

		};

		$scope.SetStatus = function (id_asunto,idx_asunto,status_)
	    {


	    	if(!$scope.cargando && 	$scope.StatusSeguimientos[id_asunto]==0){

	    		$scope.cargando=true;

	    		var datos= {
	    			status: status_,
	    			id_asunto:id_asunto
	    		};
	    		var url=$scope.resultUrl+"datos/SetStatus.php";

				$http.post
				(
					url,
					datos
				).success(function(data,status,headers,config)
				{	
					if(data==1){
						console.log("Status cambiado");
						$scope.StatusSeguimientos[id_asunto]=status_;
					}else{
						console.log("Error al cambiar status 1");

					}
					$scope.cargando=false;

				})
				.error(function(err,status,headers,config)
				{
					console.log("Error al cambiar el status 0");
	    			$scope.cargando=false;

				});
			    

	    	}

		};
		$scope.SetCurrent= function (id_asunto,idx_asunto) {
			$scope.ID=id_asunto;
			$scope.IDX=idx_asunto;
			$scope.imagen=$scope.seguimientos[$scope.IDX].archivo;
		}
		$scope.DelSeguimiento = function ()
	    {

	    	if(!$scope.cargando){

	    		$scope.cargando=true;
	    		var datos= {
	    			id_asunto:$scope.ID
	    		};
	    		var url=$scope.resultUrl+"datos/DelSeguimiento.php";

				$http.post
				(
					url,
					datos
				).success(function(data,status,headers,config)
				{	

					$scope.cargando=false;
					if(data==1){
						console.log("Seguimiento eliminado");
						$('#modal_delete').modal('hide');
						$scope.GetSeguimientos();
					}else{
						console.log("Error al eliminar el seguimiento 1");

					}
					$('#modal_delete').modal('hide');
				})
				.error(function(err,status,headers,config)
				{
					console.log("Error al eliminar el seguimiento 404");
	    			$scope.cargando=false;
				});
			    

	    	}

		};


		$scope.DelFrecuente = function ()
	    {

	    	if(!$scope.cargando){

	    		$scope.cargando=true;
	    		var datos= {
	    			id_frecuente:$scope.ID
	    		};
	    		var url=$scope.resultUrl+"datos/DelFrecuente.php";

				$http.post
				(
					url,
					datos
				).success(function(data,status,headers,config)
				{	

					$scope.cargando=false;
					if(data==1){
						console.log("Frecuente eliminado");
						$('#modal_delete').modal('hide');
						$scope.GetFrecuentes();
					}else{
						console.log("Error al eliminar el frecuete 1");

					}
					$('#modal_delete').modal('hide');
				})
				.error(function(err,status,headers,config)
				{
					console.log("Error al eliminar el frecuente 404");
	    			$scope.cargando=false;
				});
	    	}

		};				
		$scope.GetMensajes = function (id_asunto,idx_asunto)
	    {
	    		var url=$scope.resultUrl+"datos/GetMensajes.php?id_asunto="+id_asunto;
				
				$http.get
				(
					url
				).success(function(data,status,headers,config)
				{	
					console.log("Mensajes cargados asunto: "+id_asunto);
					$scope.currentChat.length=0;
					if(angular.isObject(data)){

						$scope.seguimientos[idx_asunto].chat=angular.copy(data).reverse();
					}else{
					}
					//$scope.currentChat=data;
				})
				.error(function(err,status,headers,config)
				{

					console.log("Error al optener los mensajes "+err);

				});
		};


		 $scope.resetForm = function ()
	    {
	    	$scope.s = angular.copy($scope.initialSearch);
	    };

	    $scope.toggleSearchAv = function ()
	    {
	    	$scope.s = angular.copy($scope.initialSearch);
	    	$scope.busquedaAv = !$scope.busquedaAv;
	    };

	    $scope.isFormChanged = function ()
	    {
	      return !angular.equals($scope.s, $scope.initialSearch);
	    };

		$scope.enter = function ()
	    {
			
	    };
	    $scope.SetAutoUpdate = function (id_asunto,idx_asunto,asunto_txt){

	    	$scope.maxChats
	    	$scope.classSeguimiento[id_asunto]='active';
	    	$scope.showSeguimientos[id_asunto]=true;
	    	$scope.currentAsunto=asunto_txt;

	    	$scope.seguimientos[idx_asunto].notif=0;
	    	$scope.RefreshNotif();

	    	/*$scope.ID=id_asunto;
	    	$scope.IDX=idx_asunto;*/
	    	//$scope.currentChat.length=0;
	    	//$scope.currentChat=angular.copy($scope.seguimientos[idx_asunto].chat);
	    	if(!angular.isDefined($scope.AutoUpdates[id_asunto])){

				$scope.AutoUpdates[id_asunto]=$interval(function (){
				    		$scope.GetMensajes(id_asunto,idx_asunto);
				    	}, 5000);
	    	}
	    
		} 
	    $scope.StopAutoUpdate = function (id_asunto,idx_asunto){
	    	$scope.showSeguimientos[id_asunto]=false;
	    	$scope.classSeguimiento[id_asunto]='';

	        if(angular.isDefined($scope.AutoUpdates[id_asunto]))
          	{
            	$interval.cancel($scope.AutoUpdates[id_asunto]);
            	$scope.AutoUpdates[id_asunto]=undefined;
          	}
		}
	    $scope.isOnline = function (fecha){
			var nowDate= new Date();
			var Time1 = new Date(fecha);
			var LastTenMin= new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), nowDate.getHours(), nowDate.getMinutes() - 10);
			var Online;
			return Online = !(Time1 < LastTenMin);
		}

}]);