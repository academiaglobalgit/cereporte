<?php 
session_start();
  $id_persona=0;
if(isset($_SESSION['id_persona'])){
  $id_persona=$_SESSION['id_persona'];
}
?>
<!DOCTYPE html >
<html ng-app='App'>
    <head>
      <meta charset="utf-8">
      <title>Alumnos</title>
      <meta name="description" content="Registro de Alumnos"/>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Loading Bootstrap -->
      <link  href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link  href="assets/bootstrap/css/bootstrap.min.custom.css" rel="stylesheet">
      <!--<link rel="shortcut icon" href="flatui/img/favicon.ico">-->
     
      <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
        <script src="flatui/dist/js/vendor/html5shiv.js"></script>
        <script src="flatui/dist/js/vendor/respond.min.js"></script>
      <![endif]-->
    </head>
  <body ng-controller="mainController-peticionesbajas">
  <div id="processing" class="loading col-md-12 text-center" style="display:none; opacity: 0.9; border-radius: 10px; z-index: 99; position:fixed; width:100%;height:100px; top:30%;" ><img src="assets/img/loading.gif" alt="Cargando..."  ></div>
  <div id="loading_dog" class="loading col-md-12 text-center" style="display:none; opacity: 0.9; border-radius: 10px; z-index: 99; position:fixed; width:100%;height:100px; top:0px;" ><img style="width: 100px; height: 400px;" src="assets/img/anydog2.gif" alt="Cargando..."  ></div>
    <div class="container-fluid">
        <div class="row" >
          <div class="col-md-12 col-xs-12" >
              
          </div>
        </div>
        <div class="row" >
          <div class="col-md-12 col-xs-12" >
          </div>
           <br>
        </div>

        <div id="view_usuarios" class="row" >

          <div class="col-md-10 col-md-offset-1 col-xs-12  panel panel-default" >
              <div class="panel-body">
                
                <div class="row" style="margin-top:10px;" >
                  <div class="col-md-12">
                      <div class="list-group" style=" height:350px; overflow-y: auto; ">
                      
                        <div  class="list-group-item active">
                         Resultados de Alumnos <span class="pull-right fui-list-large-thumbnails" ></span>
                        </div>
                          <table class="table" >
                          <thead>
                            <tr>
                                <th>Nombre(s)</th>
                                <th>Apellido(s)</th>
                                <th>Número de Colaborador</th>
                                <th>Estatus Actual</th>
                                <th>Petición</th>
                                <th>Fecha Petición</th>
                                <th>Cargas de Mes</th>
                                <th>Equivalencias</th>
                                <th>Estatus de Petición</th>

                                <th>Acción</th>

                            </tr>
                          </thead>
                          <tbody > <!--Content usuarios-->
                              <tr ng-repeat='usuario in usuarios'>
                            <td>{{usuario.nombre}}</td>
                            <td>{{usuario.apellido}}</td>
                            <td>{{usuario.numero_empleado}}</td>
                            <td>{{usuario.descripcion}}</td>
                            <td>{{usuario.estatus}}</td>
                            <td>{{usuario.fecha_peticion}}</td>
                            <td>{{usuario.mmes}}</td>
                            <td>{{usuario.emes}}</td>
                            <td>{{usuario.cambiopeticion}}</td>
                            <td>
                            <button type="button" class="btn btn-info" ng-click='peticionaceptada(usuario.idpeticion)'>Aceptar</button>
                            {{selResult[usuario.idalumno]}}
                            <td>
                            
                        </tr>
                          </tbody><!-- CONTENT usuarios -->
                          </table>
                      </div>
                  </div>
                </div>               

              </div>
          </div>

        </div>
          
        

    </div><!--CONTAINER-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
 	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    
 	<script src="assets/js/angular.min.js"></script>
  	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.3/angular-route.js"></script>-->
    <script src="controllers/main.js"></script>
  </body>
</html>