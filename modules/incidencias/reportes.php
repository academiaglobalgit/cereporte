<?php
include_once("includes/checklogin.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Incidencias</title>
    <meta name="description" content="Sistema AG de Incidencias"/>
    <?php
       include_once("includes/assets.php"); // INCLUDE ASSETS
    ?>
        <script src="assets/js/moments.js"></script>
        <script src="assets/js/canvasjs.min.js"></script>

  </head>
  <body>

    <div id="wrapper" class="">
      
      <!-- MODULO DE INICIO -->
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
              <p><h1>Reportes</h1></p>
				<ul class="nav nav-tabs">
				  <li role="presentation" view="global" class="active menus"><a href="#">Global</a></li>
				  <!--<li role="presentation" view="categorias" class="menus" ><a href="#">Por Categorías</a></li>-->
				  <li role="presentation" view="alumno" class="menus"  ><a href="#">Por Alumno</a></li>
				</ul>
            </div>
          </div> 

          <div class="row views" id="view_global" >

              <!--<div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-heading text-center">
                    <h1 id="i_g_activas">...</h1>
                  </div>
                  <div class="panel-body small text-muted">
                  <span class="glyphicon glyphicon-upload" ></span> Pendientes
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-info">
                  <div class="panel-heading text-center">
                    <h1 id="i_g_proceso">...</h1>
                  </div>
                  <div class="panel-body small text-info">
                   <span class="glyphicon glyphicon-time" ></span> En Proceso
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-success">
                  <div class="panel-heading text-center">
                    <h1 id="i_g_realizadas">...</h1>
                  </div>
                  <div class="panel-body small text-success">
                    <span class="glyphicon glyphicon-ok" ></span> Realizadas
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-danger">
                  <div class="panel-heading text-center">
                    <h1 id="i_g_canceladas">...</h1>
                  </div>
                  <div class="panel-body small text-danger">
                    <span class="glyphicon glyphicon-remove" ></span> Canceladas
                  </div>
                </div>
              </div> -->

             	<div id="grafica_totales" class="col-md-6" style="height: 400px;"  ></div>
             	<div id="grafica_categorias" class="col-md-6" style="height: 400px;"  ></div>
              <div id="grafica_plataformas" class="col-md-6" style="height: 400px;"  ></div>
          </div>
 		<!--<div class="row views" id="view_categorias" style="display:none;" >
 		</div>-->

 		<div class="row views" id="view_alumno" style="display:none;" >
      <div class="row" >
          <div class="col-md-3" >
            <label>Plataforma:</label>
            <select  class="form-control" value="" name="id_plan_estudio" id="id_plan_estudio"   >
            <option value="" >Selecciona una opcion</option>
            </select>
            
            <label>#Empleado:</label><input   class="form-control" value="" name="numero_empleado" id="numero_empleado" placeholder="907526" ></span>
           
            <button class="btn btn-default form-control" id="btn_alumnobuscar" type="button"  > Buscar </button>
          </div>
   		</div>
       <div class="row" >
          <div class="col-md-6" >
                <div class="row table-responsive">
                  <table class="table">
                  <thead>
                    <tr>
                      <th> <center> # Id </center> </th>
                      <th> Reportó </th>
                      <th> #Empleado </th>
                      <th> Plan De Estudios </th>
                      <th> Categoría </th>
                      <th> <center> Estatus </center> </th>
                      <th> Registró </th>
                      <th> <center> Fecha </center> </th>
                      <th> </th>
                    </tr>
                  </thead>
                    <tbody id="tabla_incidencias">
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tbody>
                </table>
              </div>
          </div>
          <div class="col-md-6" >
              <div id="grafica_alumno_categorias"  style="height: 400px;"  ></div>
          </div>


      <div class="modal fade" id="modal_i_comentarios" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Movimientos de la inicidencia</h4> <small class="pull-right" > ID Moodle: <label id="modal_i_comentarios_id_moodle" ></label> <br> #Empleado: <label id="modal_i_comentarios_numero_empleado" ></label></small>
          </div>
          <div class="modal-body">
              <div id="div_comentarios" class="row" style="overflow-y: auto; ">
                  <p>Comentarios..</p>
              </div>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
          </div>
        </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->



       </div>
    </div>


        </div>
      </div>
      
    </div>
    <?php
       include_once("includes/scripts.php"); // INCLUDE SCRIPTS
    ?>

    <script src="controllers/reportes.js"></script>

  </body>

</html>