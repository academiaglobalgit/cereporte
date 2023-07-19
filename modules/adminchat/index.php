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
      <title>Asesores Chat</title>
      <meta name="description" content="Administrador de chat"/>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Loading Bootstrap -->
      <link  href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
       <link  href="assets/datatable/datatable.min.css" rel="stylesheet">

      <!--<link rel="shortcut icon" href="flatui/img/favicon.ico">-->
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="assets/datatable/datatable.js"></script>
      <script src="ckeditor/ckeditor.js"></script>
      <script src="controllers/adminchat.js"></script>
      <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
        <script src="flatui/dist/js/vendor/html5shiv.js"></script>
        <script src="flatui/dist/js/vendor/respond.min.js"></script>
      <![endif]-->
    </head>
  <body>
  <div id="loading" class="col-md-12 text-center" style="display:none; opacity: 0.9; border-radius: 10px; z-index: 999; position:fixed; width:100%;height:100px; top:30%;" ><img src="assets/img/loading.gif" alt="Cargando..."  ></div>
    <div class="container-fluid">
        <div class="row" >
          <div class="col-md-12 col-xs-12" >
            <br>
          </div>
        </div>

        <div class="row" >
          <div class="col-md-12 col-xs-12 panel panel-default" >
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                      
                        <div  class="list-group-item active">
                        <button id="btn_refresh_asesores" type="button" class="btn btn-primary" >Actualizar</button> Listado de Asesores de Chat <span class="pull-right fui-list-large-thumbnails" ></span>
                        </div>
                        <br>
                          <div class="col-md-12"> <!--Content ASESORES-->

                           <table class="table" id="table_asesores">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>

                                <th>Apellido Materno</th>
                                <th>Regiones</th>

                                <th></th>
                              </tr>
                            </thead>
                              <tbody id="content_asesores" >
                                <tr>
                                  <td  >aaa</td>
                                  <td  >aaa</td>
                                  <td  >aaa</td>
                                  <td  >aaa</td>
                                  <td  >aaa</td>
                                  <td  >aaa</td>
                                </tr>
                                                                <tr>
                                  <td  >bbb</td>
                                  <td  >bbb</td>
                                  <td  >bbb</td>
                                  <td  >bbb</td>
                                  <td  >bbb</td>
                                  <td  >bbb</td>
                                </tr>
                                                                <tr>
                                  <td  >ccc</td>
                                  <td  >ccc</td>
                                  <td  >ccc</td>
                                  <td  >ccc</td>
                                  <td  >ccc</td>
                                  <td  >ccc</td>
                                </tr>
                              </tbody>
                            </table>

                          </div><!-- CONTENT ASESORES -->

                  </div>
                </div>               

              </div>
          </div>

        </div>
        
         <!-- Modal EDITAR asesor-->
            <div id="modal_asesor_regiones" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Asignar Region a Asesor</h4>
                  </div>
                  <div class="modal-body">
                    <form class="form"  id="form_asesor_regiones" name="form_asesor_regiones"  >
                     <p>Corporación:</p>
                      <div class="form-group" >
                        <select type="number"  class="form-control input-form_asesor_regiones"  error="Selecciona una corporacion."  name="id_corporacion" id="f_u_id_corporacion" required>
                          <option value="">No se encontraron corporaciones</option>
                        </select>
                      </div>
                     <p>Selecciona una Region para ligarlo al Asesor:</p>
                      <div class="form-group" >
                        <select type="number"  class="form-control input-form_asesor_regiones"  error="Selecciona una región para ligarlo al Asesor."  name="id_region" id="f_u_id_region" required>
                          <option value="">Seleccione una corporación primero</option>
                        </select>
                      </div>
                      <div class="form-group" >
                          <input type="hidden" name="id_asesor" id="f_u_id_asesor" class="input-form_asesor_regiones" value="0"> 
                      </div>

                        <div class="form-group" >
                          <button class="btn btn-success" type="button" id="f_u_btn_region" > + Asignar</button>
                      </div>
                    </form>
                    <form  class="form" >
                      <div class="form-group" style="height:200px; overflow-y: auto; " >
                          <table class="table" id="table_regiones">
                          <thead>
                            <tr>
                              <th>Región</th>
                              <th>Corporación</th>
                              <th></th>
                            </tr>
                          </thead>
                            <tbody id="content_regiones" >
                            <td  > ...</td>
                            <td  > ...</td>
                            <td  > ...</td>

                            </tbody>
                          </table>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button id="btn_form_asesor_regiones" type="button" class="btn btn-info pull-right"  data-dismiss="modal" >Aceptar</button>
                  </div>
                </div>
              </div>
            </div>

          <!--DELETE region asesor-->
          <div id="modal_asesor_regiones_eliminar" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Eliminar</h4>
                </div>
                <div class="modal-body">
                  <p>Region a eliminar del Asesor</p>
                  <form class="form"  id="form_region_delete" name="form_region_delete"  >
                    <div class="form-group" >
                        <input type="text" name="nombre" class="input-form_region_delete form-control" id="f_d_nombre" value="" disabled>
                        <input type="hidden" name="id_region_asesor" id="f_d_id_region_asesor" class="input-form_region_delete form-control" value="" > 
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                  <button id="btn_form_region_delete" type="button" class="btn btn-danger pull-right" >Eliminar</button>
                </div>
              </div>

            </div>
          </div>




             

    </div><!--CONTAINER-->

  </body>
</html>