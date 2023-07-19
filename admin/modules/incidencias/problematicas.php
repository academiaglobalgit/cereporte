<?php
include_once("includes/checklogin.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Incidencias | Problemáticas</title>
    <meta name="description" content="Catalogo de Problemáticas"/>
    <?php
       include_once("includes/assets.php"); // INCLUDE ASSETS
    ?>

  </head>
  <body>

    <div id="wrapper" class="">
      
      <!-- MODULO DE Problemáticas -->
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
              <p><h1>Catalogo de Problemáticas</h1></p>
              <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <li class="active">Problemáticas</li>
              </ol>
            </div>
          </div>  
          <div class="row"><!--BOTON CREAR-->
              <div class="col-md-12">
              <p><button class="btn btn-primary" data-toggle="modal" data-target="#modal_p_crear" type="button" ><span class=" glyphicon glyphicon-plus"></span> Crear Nueva Problemática</button>
              </p>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12">
                <div class="row" >
                  <div class="col-md-12">
                    <form id="form_p_search" class="form-inline" name="form_p_search" >
                                <div class="input-group" >
                                    <span class="input-group-addon" id="basic-addon1">Buscar problematica</span>
                                    <input type="text" id="form_p_search_problematica" value="" name="problematica" class="input-form_p_search form-control" error="Ingrese su busqueda." placeholder="buscar" >
                                </div>
                                <div class="input-group" >
                                  <button id="btn_form_p_search" class="btn btn-default" type="button">Filtrar</button>
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
                      <th>Categoría</th>
                      <th>Area</th>
                      <th>Plan de Estudios</th>
                      <th>Fecha Alta</th>

                      <th> </th>
                    </tr>
                  </thead>
                  <tbody id="tabla_problematicas" >
                    <tr>
                      <td>...</td>
                      <td>...</td>         
                      <td>
                        <button class="btn btn-default"" id="btn_modal_p_editar"  type="button" ><span class="glyphicon glyphicon-edit"></span></button>
                        <!--<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_p_eliminar" ><span class="glyphicon glyphicon-trash"></span></button>-->
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

      <div class="modal fade" id="modal_p_crear"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Nueva Problematica</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_p_crear" name="form_p_crear" >
                     <div class="form-group" >
                          Plan de estudios (Plataforma):
                          <select type="number" id="form_p_crear_id_plan_estudios" name="id_plan_estudios" class="input-form_p_crear form-control" error="Selecciona un plan_estudios." required>
                            <option value="" selected>Selecciona una plan de estudios</option>
                          </select>
                      </div>      
                      <div class="form-group" >
                          Problemática:
                          <input type="text" id="form_p_crear_nombre" value="" name="nombre" class="input-form_p_crear form-control" error="Ingesa un nombre de problematica." placeholder="problematica" required>
                      </div>
                      <div class="form-group" >
                          Categoria:
                          <select type="number" id="form_p_crear_id_categoria" name="id_categoria" class="input-form_p_crear form-control" error="Selecciona una categoria." placeholder="categoria" required>
                            <option value="" selected>Selecciona una categoria</option>
                          </select>
                      </div>   
                      <div class="form-group" >
                          Area:
                          <select type="number" id="form_p_crear_id_area" name="id_area" class="input-form_p_crear form-control" error="Selecciona un area." placeholder="area" required>
                            <option value="" selected>Selecciona una area</option>
                          </select>
                      </div>          
                                         
              </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btn_form_p_crear"  >Guardar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


      <!--EDITAR -->
      <div class="modal fade" id="modal_p_editar"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Modificar Problemàtica</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_p_editar" name="form_p_editar" >
                     <div class="form-group" >
                          <input type="hidden" id="form_p_editar_id_problematica" value="" name="id_problematica" class="input-form_p_editar form-control" error="Ingesa un id_problematica." required>
                          Plan de estudios (Plataforma):
                          <select type="number" id="form_p_editar_id_plan_estudios" name="id_plan_estudios" class="input-form_p_editar form-control" error="Selecciona un plan_estudios." required>
                            <option value="" selected>Selecciona una plan de estudios</option>
                          </select>
                      </div>      

                       <div class="form-group" >
                          Estatus:
                          <select type="number" id="form_p_editar_estatus" name="estatus" class="input-form_p_editar form-control" error="Selecciona un estatus." required>
                            <option value="1" >Activo</option>
                            <option value="0" >Baja</option>
                          </select>
                      </div>     


                      <div class="form-group" >
                          Problemática:
                          <input type="text" id="form_p_editar_nombre" value="" name="nombre" class="input-form_p_editar form-control" error="Ingesa un nombre de problematica." placeholder="problematica" required>
                      </div>
                      <div class="form-group" >
                          Categoria:
                          <select type="number" id="form_p_editar_id_categoria" name="id_categoria" class="input-form_p_editar form-control" error="Selecciona una categoria." placeholder="categoria" required>
                            <option value="" selected>Selecciona una categoria</option>
                          </select>
                      </div>   
                      <div class="form-group" >
                          Area:
                          <select type="number" id="form_p_editar_id_area" name="id_area" class="input-form_p_editar form-control" error="Selecciona un area." placeholder="area" required>
                            <option value="" selected>Selecciona una area</option>
                          </select>
                      </div>          
                          
              </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btn_form_p_editar"  >Guardar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!--ELIMINAR MODAL-->

      <div class="modal fade" id="modal_p_eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">AVISO</h4>
            </div>
            <div class="modal-body">
              <p>¿Está Seguro que desea eliminar la problematica?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" >Eliminar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

    <?php
       include_once("includes/scripts.php"); // INCLUDE SCRIPTS
    ?>
    <script src="controllers/problematicas.js"></script>


  </body>

</html>