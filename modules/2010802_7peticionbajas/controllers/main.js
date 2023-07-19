// Creación del módulo
var app = angular.module('App', []);
app.filter('startFromGrid', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});

function ShowMensaje(msg){
	$('#modal_aviso_msg').html(msg);
	$('#modal_aviso').modal('show');
	}

  	function ShowLoading(){

  		if(ShowDoge){
  			 $("#loading_dog").fadeIn('fast');

  		}else{
  			 $("#loading").fadeIn('fast');
  		}
  	}

  	function HideLoading(){

  		$(".loading").fadeOut('fast');

  	} 
	
app.controller('mainController-peticionesbajas',['$scope', '$http',function($scope, $http) 
{
	  $scope.selAccion=[];
      $scope.currentPage = 0;
      $scope.pageSize = 10;
      $scope.pages = [];
	 
	$("#processing").show();
	$http({method: 'GET', url: 'models/solicitudes.php'}).success(function(datos){
	$("#processing").hide();
    $scope.usuarios = datos;
	
      $scope.configPages = function($scope) {
        $scope.pages.length = 0;
        var ini = $scope.currentPage - 4;
        var fin = $scope.currentPage + 5;
		 //console.log($scope.usuarios);
        if (ini < 1) {
          ini = 1;
          if (Math.ceil($scope.usuarios.length / $scope.pageSize) > 10)
            fin = 10;
          else
            fin = Math.ceil($scope.usuarios.length / $scope.pageSize);
        } else {
          if (ini >= Math.ceil($scope.usuarios.length / $scope.pageSize) - 10) {
            ini = Math.ceil($scope.usuarios.length / $scope.pageSize) - 100;
            fin = Math.ceil($scope.usuarios.length / $scope.pageSize);
          }
        }
        if (ini < 1) ini = 1;
        for (var i = ini; i <= fin; i++) {
          $scope.pages.push({
            no: i
          });
        }

        if ($scope.currentPage >= $scope.pages.length)
          $scope.currentPage = $scope.pages.length - 1;
      };

      $scope.setPage = function(index) {
        $scope.currentPage = index - 1;
      };
	 });
	   $scope.solicitudes= function(){
		   $scope.selAccion=[];
      $scope.currentPage = 0;
      $scope.pageSize = 10;
      $scope.pages = [];
	 
	$("#processing").show();
	$http({method: 'GET', url: 'models/solicitudes.php'}).success(function(datos){
	$("#processing").hide();
    $scope.usuarios = datos;
	
      $scope.configPages = function($scope) {
        $scope.pages.length = 0;
        var ini = $scope.currentPage - 4;
        var fin = $scope.currentPage + 5;
		 //console.log($scope.usuarios);
        if (ini < 1) {
          ini = 1;
          if (Math.ceil($scope.usuarios.length / $scope.pageSize) > 10)
            fin = 10;
          else
            fin = Math.ceil($scope.usuarios.length / $scope.pageSize);
        } else {
          if (ini >= Math.ceil($scope.usuarios.length / $scope.pageSize) - 10) {
            ini = Math.ceil($scope.usuarios.length / $scope.pageSize) - 100;
            fin = Math.ceil($scope.usuarios.length / $scope.pageSize);
          }
        }
        if (ini < 1) ini = 1;
        for (var i = ini; i <= fin; i++) {
          $scope.pages.push({
            no: i
          });
        }

        if ($scope.currentPage >= $scope.pages.length)
          $scope.currentPage = $scope.pages.length - 1;
      };

      $scope.setPage = function(index) {
        $scope.currentPage = index - 1;
      };
	 });
		  }	
	  $scope.peticionaceptada= function(id){
		$scope.selResult=[];
			//console.log($scope.selAccion[id]);
			if(confirm("¿¿Seguro??")){
			$("#processing").show();
			var datos="?estatus="+$scope.selAccion[id]+"&id="+id;
			$http({method: 'GET', url: 'models/bajas.php'+datos}).success(function(datos){
			$("#processing").hide();
				//console.log(datos)
				//$scope.usuarios = datos; // Show result from server in our <pre></pre> element
				alert("Petición Aceptada");
							
						}).error(function(datos) {
							//$scope.usuarios = datos || "Request failed";
								
						});
						
						}else{$scope.selAccion[id]='';}
	
		};
		
	
		
	  }]);


	
