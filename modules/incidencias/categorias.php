<?php
include_once("includes/checklogin.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Incidencias | Categorías</title>
    <meta name="description" content="Catalogo de Categorías"/>
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
              <p><h1>Catalogo de Categorías</h1></p>
              <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <li class="active">Categorías</li>
              </ol>
            </div>
          </div>  
          <div class="row"><!--BOTON CREAR-->
              <div class="col-md-12">
              <p><button class="btn btn-primary" data-toggle="modal" data-target="#modal_c_crear" type="button" ><span class=" glyphicon glyphicon-plus"></span> Crear Nueva Categoría</button>
              </p>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12">
                <div class="row" >
                  <div class="col-md-12">
                    <form id="form_c_search" class="form-inline" name="form_c_search" >
	                        <div class="input-group" >
	                            <span class="input-group-addon" id="basic-addon1">Buscar categoría</span>
	                            <input type="text" id="form_c_search_categoria" value="" name="categoria" class="input-form_c_search form-control" error="Ingrese la categoria." placeholder="buscar" >
	                        </div>
	                        <div class="input-group" >
	                          <button id="btn_form_c_search" class="btn btn-default" type="button">Filtrar</button>
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
                      <th>Tipo</th>
                      <th> </th>
                    </tr>
                  </thead>
                  <tbody id="tabla_categorias" >
                    <tr>
                      <td>1</td>
                      <td>Item</td>         
                      <td>
                        <button class="btn btn-default" data-toggle="modal" data-target="#modal_c_crear"  type="button" ><span class="glyphicon glyphicon-edit"></span></button>
                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_p_eliminar" ><span class="glyphicon glyphicon-trash"></span></button>
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

      <div class="modal fade" id="modal_c_crear"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Nueva categoría</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_c_crear" name="form_c_crear" >

                      <div class="form-group" >
                          Nombre Categoría:
                          <input type="text" id="form_c_crear_nombre" value="" name="nombre" class="input-form_c_crear form-control" error="Ingresa el nombre de la categoría." placeholder="Categoría" required="">
                      </div>     
                      <div class="form-group" >
                          Tipo de Categoría:
                         <select type="number" id="form_c_crear_tipo" name="tipo" class="input-form_c_crear form-control" error="Ingresa el tipo de la categoría." required>
                          <option value="" selected>Selecciona el tipo</option>
                           <option value="1" >Externa</option>
                           <option value="2" selected>Interna</option>
                         </select>

                      </div>                          
              </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btn_form_c_crear"  >Guardar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

     <div class="modal fade" id="modal_c_editar"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Nueva categoría</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_c_editar" name="form_c_editar" >
                   <input type="hidden" id="form_c_editar_id_categoria" value="" name="id_categoria" class="input-form_c_editar form-control" error="Ingesa el id_categoria" required>
                      <div class="form-group" >
                          Nombre Categoría:
                          <input type="text" id="form_c_editar_nombre" value="" name="nombre" class="input-form_c_editar form-control" error="Ingresa el nombre de la categoría." placeholder="Categoría" required>
                      </div>         
                         <div class="form-group" >
                          Tipo de Categoría:
                         <select type="number" id="form_c_editar_tipo" name="tipo" class="input-form_c_editar form-control" error="Ingresa el tipo de la categoría." required>
                          <option value="" selected>Selecciona el tipo</option>
                           <option value="1" >Externa</option>
                           <option value="2" >Interna</option>
                         </select>

                      </div>                                  
              </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btn_form_c_editar" >Guardar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->



      <!--ELIMINAR MODAL-->

      <div class="modal fade" id="modal_c_eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">AVISO</h4>
            </div>
            <div class="modal-body">
              <p>¿Está Seguro que desea eliminar la categoría?</p>
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
    <script src="controllers/categorias.js"></script>


  </body>

</html>