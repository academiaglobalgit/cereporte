<?php 
session_start();
  $id_persona=0;
if(isset($_SESSION['id_persona'])){
  $id_persona=$_SESSION['id_persona'];
}
?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <title>Examenes de Alumno</title>
      <meta name="description" content="Administrador de chat"/>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Loading Bootstrap -->
      <link  href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!--<link rel="shortcut icon" href="flatui/img/favicon.ico">-->
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="controllers/examenes.js?n=6"></script>
      <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
        <script src="flatui/dist/js/vendor/html5shiv.js"></script>
        <script src="flatui/dist/js/vendor/respond.min.js"></script>
      <![endif]-->
    </head>
  <body>
  <div id="loading" class="col-md-12 text-center" style="display:none; opacity: 0.9; border-radius: 10px; z-index: 99; position:fixed; width:100%;height:100px; top:30%;" ><img src="assets/img/loading.gif" alt="Cargando..."  ></div>
    <div class="container-fluid">
        <div class="row" >
          <div class="col-md-12 col-xs-12" >
              <form class="form-inline alert alert-default" name="form_search"  id="form_search" role="form">
                  <div class="input-group">
                   <span  class="input-group-addon"  for="id_moodle">ID:</span >
                    <input type="text" name="id_moodle" id="id_moodle" size="6" class="form-control input-form_search" value="">
                  </div>
                  <div class="input-group">
                   <span  class="input-group-addon"  for="numero_empleado"># Empelado/Estafeta:</span >
                    <input type="text" name="numero_empleado" size="10" id="numero_empleado" class="form-control input-form_search" value="">
                  </div>
                      <input type="hidden" name="nombre" size="10" id="nombre_completo" class="form-control input-form_search" value="">

                  <div class="input-group">
                    <span  class="input-group-addon"  for="id_plan_estudio">Plataforma:</span >
                    <select type="number" style="width: 230px;" class="form-control input-form_search" name="id_plan_estudio" id="id_plan_estudio">
                    <option value="2">PrepaCoppel </option>
                    <option value="4">PrepaLey  </option>
                      <option value="9">Preparatoria Toks  </option>
                       <option value="10">Universidad Toks  </option>
                    </select>
                  </div>
                   <div class="input-group">
                    <button class="form-control btn btn-default" type="button" id="btn_form_search">
                       Buscar
                    </button>
                  </div>
              </form>
          </div>
        </div>
        <div class="row" >
          <div class="col-md-12 col-xs-12" >
          </div>
           <br>
        </div>


          <div id="view_usuarios" class="col-md-5 col-xs-12  panel panel-default" >
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                      <div class="list-group" style="height:350px; overflow-y: auto; ">
                      
                        <div  class="list-group-item active"  style="background-color:#34495e; border-color: #34495e;" >
                         Resultados de Alumnos <span class="pull-right fui-list-large-thumbnails" ></span>
                        </div>
                          <table class="table" >
                          <thead>
                            <tr>
                                <th>Id</th>
                                <th># Empleado </th>
                                <th>Nombre Completo</th>
                                <th></th>

                            </tr>
                          </thead>
                          <tbody id="content_usuarios"> <!--Content usuarios-->
   
                              <tr class="text-center" >
                                <td colspan="8"  >Por favor ingresa tu busqueda de usuario</td>
                            </tr>
                          </tbody><!-- CONTENT usuarios -->
                          </table>
                      </div>
                  </div>
                </div>               

              </div>
          </div>

          <div id="view_examenes"  class="col-md-7 col-xs-12 panel panel-default"  style="display:none;" >
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                      <div class="list-group" style="height:350px; overflow-y: auto; ">
                        <div id="modal_title_usuario" class="list-group-item active"  style="background-color:#34495e; border-color: #34495e;" >
                         Examenes del Alumno 
                        </div>
                          <form class="form"  id="form_usuario_examen" name="form_usuario_examen"  >
                                <select type="number" class="form-control input-form_usuario_examen" name="id_materia" id="f_e_id_materia">
                                <option value="">Cargando...</option>

                                </select>

                            <table class="table"  >
                              <thead>
                                <th>Scorm</th>
                                <th>Nombre</th>
                                <th>Status y Tiempo</th>
                                <th>Tipo</th>
                                <th>Calificacion</th>
                                <th></th>
                              </thead>
                              <tbody id="content_examenes" >
                                <tr>
                                  <td colspan="5">Seleccione una materia<td>
                                </tr>
                              </tbody>
                            </table>
                            <div class="form-group" >
                                <input type="hidden" name="id_persona" id="f_e_id_persona" class="input-form_usuario_examen" value="0"> 
                                <input type="hidden" name="id_moodle" id="f_e_id_moodle" class="input-form_usuario_examen" value="0"> 
                                <input type="hidden" name="id_plan_estudio" id="f_e_id_plan_estudio" class="input-form_usuario_examen" value="0"> 
                            </div>
                          </form>
                      </div>
                  </div>
                </div>               

              </div>
          </div>




                <div id="modal_reiniciar" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Reiniciar Examen</h4>
                      </div>
                      <div class="modal-body">
                        <p>¿Está seguro de que desea reiniciar este examen?.</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" id="reset_examen_modal_btn" class="btn btn-danger" data-dismiss="modal">Reiniciar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                      </div>
                    </div>

                  </div>
                </div>



    </div><!--CONTAINER-->

  </body>
</html>