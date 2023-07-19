<?php 
include_once('includes/checklogin.php');
  $titulo_header="Universidad de Casa Ley";

?>
<!DOCTYPE html>
<html>
  <head>	
  <?php include_once('includes/assets.php'); ?>
  
  </head>
  <body style="padding: 0px; margin: 0px;" >
      

  <?php include_once('includes/menu.php'); ?>



    <div class="container">
      <!-- VISTA CUANDO ESTÁ CARGANDO-->
       <div class="view_cargando" id="view_cargando" style="background-color: white;  vertical-align: center; width: 100%; height:100%; position: absolute; display:none;  opacity:0.85; z-index: 10;" ><br><br><br><br><br>
        <img style="position:relative;left: 45%; width: 5%;" src="assets/img/loading2.gif" alt="Espere un mmomento porfavor..."  ><br><strong style="position:relative;left: 40%;"  >Espere un momento porfavor.</strong>
      </div>

    <div class="row">
      <div class="col-sm-3">
          <a href="actividades.php" class="thumbnail text-center" style="border-bottom-width: 5px;">            
            <span class="glyphicon glyphicon-file " aria-hidden="true" style="font-size:50px; color:black"></span>
            <div class="caption" >
              <h3>Actividades Integradoras</h3>
              <p><small>Reporte de actividades integradoras realizadas por alumnos. (Escuelas)</small></p>
            </div>
          </a>
      </div>

      <div class="col-sm-3">
          <a target="_blank" href="http://agcollege.edu.mx/UCL/prepaley/reportes/" class="thumbnail text-center" style="border-bottom-width: 5px;">            
            <span class="glyphicon glyphicon-stats " aria-hidden="true" style="font-size:50px; color:black"></span>
            <div class="caption" >
              <h3>Reportes Preparatoria</h3>
              <p><small>Reportes de alumnos, materias y calificaciones.</small></p>
            </div>
          </a>
      </div>

      <div class="col-sm-3">
          <a target="_blank" href="http://agcollege.edu.mx/UCL/licenciatura/reportes/" class="thumbnail text-center" style="border-bottom-width: 5px;">            
            <span class="glyphicon glyphicon-stats " aria-hidden="true" style="font-size:50px; color:black"></span>
            <div class="caption" >
              <h3>Reportes Licenciatura</h3>
              <p><small>Reportes de alumnos, materias y calificaciones.</small></p>
            </div>
          </a>
      </div>
      <div class="col-sm-3">
          <a href="#" class="thumbnail text-center" style="border-bottom-width: 5px;">            
            <!--<span class="glyphicon glyphicon-option-horizontal" aria-hidden="true" style="font-size:50px; color:black"></span>-->
            <div class="caption" >
              <h3  ><span class="glyphicon glyphicon-option-horizontal" aria-hidden="true" style="font-size:50px; color:#dddddd;"></span></h3>
              <small><br><br><br><br><br></small>
            </div>
          </a>
      </div>
      
    </div>



    </div><!--CONTAINER-->
     <div id="modal_aviso" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="" ><img style="width: 5%;" src="assets/img/ok.png" ></h4>
          </div>
          <div class="modal-body" id="modal_aviso_msg" >
            <p></p>
          </div>
          <div class="modal-footer text-center" >
            <button type="button" class="btn btn-default pull-center" data-dismiss="modal">Aceptar</button>
          </div>
        </div>

      </div>
    </div>
  </body>
</html>