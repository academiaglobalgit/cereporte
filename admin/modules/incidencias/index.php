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
              <p><h1>Inicio</h1></p>
              <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <li class="active"> Bienvenido(a) <strong><?php echo $nombre_completo; ?></strong> al sistema de incidencias</li>
              </ol>
            </div>
          </div> 

          <div class="row">

              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-heading text-center">
                    <h1 id="i_activas">...</h1>
                  </div>
                  <div class="panel-body small text-muted">
                  <span class="glyphicon glyphicon-upload" ></span> Incidencias Activas
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-info">
                  <div class="panel-heading text-center">
                    <h1 id="i_proceso">...</h1>
                  </div>
                  <div class="panel-body small text-info">
                   <span class="glyphicon glyphicon-time" ></span> Incidencias En Proceso
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-success">
                  <div class="panel-heading text-center">
                    <h1 id="i_realizadas">...</h1>
                  </div>
                  <div class="panel-body small text-success">
                    <span class="glyphicon glyphicon-ok" ></span> Incidencias Realizadas
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="panel panel-danger">
                  <div class="panel-heading text-center">
                    <h1 id="i_canceladas">...</h1>
                  </div>
                  <div class="panel-body small text-danger">
                    <span class="glyphicon glyphicon-remove" ></span> Incidencias Canceladas
                  </div>
                </div>
              </div>
          </div>


        </div>
      </div>
      
    </div>
    <?php
       include_once("includes/scripts.php"); // INCLUDE SCRIPTS
    ?>

    <script src="controllers/index.js"></script>

  </body>

</html>