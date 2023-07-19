<?php
include_once("includes/checklogin.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Scorms | Debugger </title>
    <meta name="description" content="Debugger de Scorm"/>
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
              <p><h1>Scorm Debugger</h1></p>
              <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="scorms.php">Scorms</a></li>
                <li class="active">Scorm Debugger</li>

              </ol>
            </div>
          </div>  
          <div class="row"><!--BOTON CREAR-->
              <div class="col-md-12">
              <p>

              </p>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12">
                <div class="row" >
                  <div class="col-md-12">
                    <form id="form_s_search" class="form-inline" name="form_s_search" >
	                        <div class="input-group" >
	                            <span class="input-group-addon" id="basic-addon1">SCORM ID</span>
	                            <input type="number" id="form_s_search_scormid" value="0" name="scormid" class="input-form_s_search form-control" error="Ingrese el scormid." placeholder="4" >
	                        </div>

	                        <div class="input-group" >
	                            <span class="input-group-addon" id="basic-addon1">USERID</span>
	                               <input type="number" id="form_s_search_userid" value="0" name="userid" class="input-form_s_search form-control" error="Ingrese el userid." placeholder="1" >
	                        </div>

	                        <div class="input-group" >
	                          <button id="btn_form_s_search" class="btn btn-default" type="button">Actualizar</button>
	                        </div>  
	                        <div class="input-group pull-right" >
	                          <button id="btn_form_s_search_delete"  data-toggle="modal" data-target="#modal_s_eliminar" class="btn btn-danger" type="button">Eliminar Tracks</button>
	                        </div>                        
                      </form>         
                  </div>
                </div>
                <div class="row table-responsive"  style="height:350px; overflow-y: auto; ">
                  <table class="table" >
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>SCORM ID</th>
                      <th>USERID</th>
                      <th>ELEMENT</th>
                      <th>VALUE</th>
                      <th>Registro</th>
                      <th>Modificación</th>

                    </tr>
                  </thead>
                  <tbody id="tabla_scormstracks" >
                    <tr>
                      <td>...</td>
                      <td>...</td> 
                      <td>...</td>           
                      <td>...</td>         
                      <td>...</td>         
                      <td>...</td>         
                      <td>
							...
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

      



      <!--ELIMINAR MODAL-->

      <div class="modal fade" id="modal_s_eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">AVISO</h4>
            </div>
            <div class="modal-body">
              <p>¿Está Seguro que desea eliminar los tracks del listado?</p>
            </div>
            <div class="modal-footer">

              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button id="btn_form_s_eliminar" type="button" class="btn btn-danger" >Eliminar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


    <?php
       include_once("includes/scripts.php"); // INCLUDE SCRIPTS
    ?>
    <script src="controllers/scormdebugger.js"></script>


  </body>

</html>