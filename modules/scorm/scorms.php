<?php
include_once("includes/checklogin.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Scorms | Alta de Scorms</title>
    <meta name="description" content="Listado de Scorm"/>
    <?php
       include_once("includes/assets.php"); // INCLUDE ASSETS
    ?>
  </head>
  <body>

    <div id="wrapper" class="">
      
    <!-- MODULO DE Categorías -->
            <!-- INCLUDE MENU -->
    <?php
       include_once("includes/menu.php");
    ?>
          
      <!-- Page content -->
      <div id="page-content-wrapper">
        <!-- Keep all page content within the page-content inset div! -->
        <div class="page-content inset">
          <div class="row"><!--TITULO DE MODULO-->
              <div class="col-md-12">
              <p><h1>Catalogo de Scorms</h1></p>
              <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <li class="active">Scorms</li>
              </ol>
            </div>
          </div>  
          <div class="row"><!--BOTON CREAR-->
              <div class="col-md-12">
              <p><button class="btn btn-primary" data-toggle="modal" data-target="#modal_s_crear" type="button" ><span class=" glyphicon glyphicon-plus"></span> Crear Nuevo Scorm</button>

              <a class="pull-right btn btn-warning" href="scormdebugger.php" ><span class=" glyphicon glyphicon-fire"></span> Scorm Debugger</a>


              </p>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12">
                <div class="row" >
                  <div class="col-md-12">
                    <form id="form_s_search" class="form-inline" name="form_s_search" >
	                        <div class="input-group" >
	                            <span class="input-group-addon" id="basic-addon1">Buscar Scorm</span>
	                            <input type="text" id="form_s_search_categoria" value="" name="scorm" class="input-form_s_search form-control" error="Ingrese la scorm." placeholder="buscar" >
	                        </div>

                          <div class="input-group" >
                              <span class="input-group-addon" id="basic-addon1">Plan de Estudios</span>
                              <select type="number" id="form_s_id_plan_estudio" value="0" name="id_plan_estudio" class="input-form_s_search form-control" error="Ingrese el plan de estudio." placeholder="buscar" >
                              </select>
                          </div>
                          <div class="input-group" >
                              <span class="input-group-addon" id="basic-addon1">Materias</span>
                              <select type="number" id="form_s_id_materia" value="0" name="id_materia" class="input-form_s_search form-control" error="Ingrese la materia." placeholder="buscar" >
                              </select>
                          </div>


	                        <div class="input-group" >
	                          <button id="btn_form_s_search" class="btn btn-default" type="button">Filtrar</button>
	                        </div>                        
                      </form>         
                  </div>
                </div>
                <div class="row table-responsive">
                  <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>ID Materia</th>
                      <th>SCOID</th>
                      <th>URL pack</th>
                      <th>Player</th>

                      <th> </th>
                    </tr>
                  </thead>
                  <tbody id="tabla_scorms" >
                    <tr>
                      <td>...</td>
                      <td>...</td> 
                      <td>...</td>           
                      <td>...</td>         
                      <td>...</td>         
                      <td>...</td>         
                      <td>
                        <button class="btn btn-default" data-toggle="modal" data-target="#modal_s_crear"  type="button" ><span class="glyphicon glyphicon-edit"></span></button>
                        <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_s_eliminar" ><span class="glyphicon glyphicon-open-file"></span></button>
                      </td>       
                    </tr>              
                  </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>

<!--NODAL CREAR-->

      <div class="modal fade" id="modal_s_crear"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Nuevo Scorm</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_s_crear" name="form_s_crear" >
                    <div class="form-group" >
                        Nombre del Scorm:
                        <input type="text" id="form_s_crear_nombre" value="" name="nombre" class="input-form_s_crear form-control" error="Ingresa el nombre del scorm." placeholder="Categoría" required="">
                    </div>
                    <div class="form-group" >
                        ID materia :
                        <input type="number" id="form_s_crear_id_materia" value="" name="id_materia" class="input-form_s_crear form-control" error="Ingresa id_materia." placeholder="01" required>
                    </div>         

                    <div class="form-group" >
                          <div id="fileuploader">2 Paquete Scorm (.zip)</div>
                    </div>  

                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
              <button type="button" class="btn btn-primary" id="btn_form_s_crear" > Guardar </button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

     <div class="modal fade" id="modal_s_editar"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Modificación de  Scorm</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_s_editar" name="form_s_editar" >
                   <input type="hidden" id="form_s_editar_id_scorm" value="" name="id_scorm" class="input-form_s_editar form-control" error="Ingesa el id_categoria" required>
                      <div class="form-group" >
                          Nombre Scorm:
                          <input type="text" id="form_s_editar_nombre" value="" name="nombre" class="input-form_s_editar form-control" error="Ingresa el nombre de la categoría." placeholder="Categoría" required>
                      </div>   
                    <div class="form-group" >
                        Codigo de scorm (SCOID):
                        <input type="number" id="form_s_editar_scoid" value="" name="scoid" class="input-form_s_editar form-control" error="scoid error." placeholder="01" readonly="readonly">
                    </div>        
                     <div class="form-group" >
                       id_materia :
                        <input type="number" id="form_s_editar_id_materia" value="" name="id_materia" class="input-form_s_editar form-control" error="scoid error." placeholder="01" >
                    </div>                                 
              </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btn_form_s_editar" >Guardar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


  <div class="modal fade" id="modal_s_upload"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

              <h4 class="modal-title">Historial Paquetes de Scorm</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_s_upload" name="form_s_upload" >
                   <input type="hidden" id="form_s_upload_id_scorm" value="0" name="id_scorm" class="input-form_s_upload form-control" 
                   error="Ingesa el id_scorm" required>
                   <div class="form-group" >
                      Selecciona un paquete Scorm (.zip) para subir 
                        <div id="fileuploader2">Subir Paquete Scorm (.zip)</div>
                        <button type="button" class="btn btn-primary" id="btn_form_s_upload" >Subir</button>
                    </div>
                </form>

                <div class="row table-responsive">
                  <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Archivo Scorm</th>
                      <th>Player</th>
                      <th> </th>
                    </tr>
                  </thead>
                  <tbody id="tabla_scormsfiles" >
                    <tr>
                      <td>...</td>
                      <td>...</td>        
                      <td>...</td>         
                      <td>
                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_s_upload" ><span class="glyphicon glyphicon-trash"></span></button>
                      </td>       
                    </tr>              
                  </tbody>
                  </table>
                </div>
                                
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->




      <!--ELIMINAR MODAL-->

      <div class="modal fade" id="modal_s_eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">AVISO</h4>
            </div>
            <div class="modal-body">
              <p>¿Está Seguro que desea eliminar el scorm?</p>
            </div>
            <div class="modal-footer">
              <form id="form_s_eliminar" name="form_s_eliminar" >
                  <input type="hidden" value="0" name="id_scorm" id="form_s_eliminar_id_scorm" class="input-form_s_eliminar" >
              </form>

              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button id="btn_form_s_eliminar" type="button" class="btn btn-danger" >Eliminar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


    <?php
       include_once("includes/scripts.php"); // INCLUDE SCRIPTS
    ?>
    <script src="controllers/scorms.js"></script>


  </body>

</html>