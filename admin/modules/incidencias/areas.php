<?php
include_once("includes/checklogin.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Incidencias | Areas</title>
    <meta name="description" content="Catalogo de Areas"/>
    <?php
       include_once("includes/assets.php"); // INCLUDE ASSETS
    ?>


  </head>
  <body>

    <div id="wrapper" class="">
      
      <!-- MODULO DE Areas -->
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
              <p><h1>Catalogo de Areas</h1></p>
              <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <li class="active">Areas</li>
              </ol>
            </div>
          </div>  
          <div class="row"><!--BOTON CREAR-->
              <div class="col-md-12">
              <p><button class="btn btn-primary" data-toggle="modal" data-target="#modal_a_crear" type="button" ><span class=" glyphicon glyphicon-plus"></span> Crear Nueva Area</button>
              </p>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12">
                <div class="row" >
                  <div class="col-md-12">
                    <form id="form_a_search" class="form-inline" name="form_a_search" >
                                <div class="input-group" >
                                    <span class="input-group-addon" id="basic-addon1">Buscar Area</span>
                                    <input type="text" id="form_a_search_area" value="" name="area" class="input-form_a_search form-control" error="Ingrese el nombre del area." placeholder="buscar" >
                                </div>
                                <div class="input-group" >
                                  <button id="btn_form_search" class="btn btn-default" type="button">Filtrar</button>
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
                      <th>Estatus</th>
                      <th>Orden</th>
                      <th> </th>
                    </tr>
                  </thead>
                  <tbody id="tabla_areas" >
                    <tr>
                      <td>...</td>
                      <td>...</td>         
                      <td>
                        <button class="btn btn-default"    type="button" ><span class="glyphicon glyphicon-edit"></span></button>
                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_a_eliminar" ><span class="glyphicon glyphicon-trash"></span></button>
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

      <div class="modal fade" id="modal_a_crear"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Nueva Areas</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_a_crear" name="form_a_crear" >

                      <div class="form-group" >
                          Nombre Area:
                          <input type="text" id="form_a_crear_descripcion" value="" name="descripcion" class="input-form_a_crear form-control" error="Ingesa una areas." placeholder="areas" required>
                      </div>     
                      <div class="form-group" >
                          Orden:
                          <input type="number" id="form_a_crear_orden" value="" name="orden" class="input-form_a_crear form-control" error="Ingesa el numero de ordenamiento del area." placeholder="1" required>
                      </div>                               
              </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btn_form_a_crear" >Guardar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->



      <div class="modal fade" id="modal_a_editar"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Modificar Area</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_a_editar" name="form_a_editar" >
                        <input type="hidden" class="input-form_a_editar" id="form_a_editar_id_area" name="id_area" value="" required>

                      <div class="form-group" >
                          Nombre Area:
                          <input type="text" id="form_a_editar_descripcion" value="" name="descripcion" class="input-form_a_editar form-control" error="Ingesa un nombre de area." placeholder="Area de mantenimiento" >
                      </div>            
                       <div class="form-group" >
                          Estatus:
                          <select type="text" id="form_a_editar_estatus"  name="estatus" class="input-form_a_editar form-control" error="Selecciona el estadus del area." >
                          <option value="A" >Activo</option>
                          <option value="B" >Baja</option>
                          </select>
                      </div>           
                      <div class="form-group" >
                          Orden:
                          <input type="number" id="form_a_editar_orden" value="" name="orden" class="input-form_a_editar form-control" error="Ingesa el numero de ordenamiento del area." placeholder="1" required>
                      </div>              
              </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btn_form_a_editar"  >Guardar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->




      <!--ELIMINAR MODAL-->

      <div class="modal fade" id="modal_a_eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">AVISO</h4>
            </div>
            <div class="modal-body">
              <p>¿Está Seguro que desea eliminar esta Area?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" >Eliminar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


    <?php
       include_once("includes/scripts.php"); // INCLUDE scripts
    ?>
   <script src="controllers/areas.js"></script>
  </body>

</html>