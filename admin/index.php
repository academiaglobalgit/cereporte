<?php
include_once("includes/checklogin.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="description" content="Sistema AG Admin"/>
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
              <p><h1>Admin</h1></p>
              <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <li class="active"> Bienvenido(a) <strong><?php echo $nombre_completo; ?></strong> Administrador /li>
              </ol>
            </div>
          </div> 
          <div class="row">
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