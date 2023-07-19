var app = angular.module('appReporte',['ngJsonExportExcel']);
app.controller('ctlReporte', function($scope,$http,$filter,$window,$timeout)
{
  $scope.btnExcel = {'visible':false};
  $scope.loading = false;
  $scope.reporte = [];
  $scope.consulta = { 'fecha1':null, 'fecha2':null,'empresas':[{'id':1,'nombre':'agcollege','ver':true},{'id':2,'nombre':'coppel','ver':true},{'id':3,'nombre':'soriana','ver':false},{'id':4,'nombre':'Ley','ver':true},{'id':7,'nombre':'Toks','ver':true},{'id':8,'nombre':'Mabe','ver':false}] };
  







/*
  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 3
  });
  */

  

  $scope.btnConsultar_click = function()
  {
    
    $scope.loading = true;
    $http.post("getCambiosAlumnos.php", $scope.consulta ).then(function(response) 
    {
      $scope.loading = false;
        if(response.data.success)
        {
            $scope.reporte = response.data.data;
            $scope.btnExcel.visible = true;



        }
        else
        {
          alert(response.data.mensaje);
          console.log(response.data.mensaje);
        }
        console.log(response.data);
    });
  }

  //2016-05-05
  //2016-05-06
  

});

