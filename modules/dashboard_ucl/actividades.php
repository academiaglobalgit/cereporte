<?php 
include_once('includes/checklogin.php');
  $titulo_header="Actividades Integradoras";

?>
<!DOCTYPE html>
<html>
  <head>	
  <?php include_once('includes/assets.php'); ?>
    <script src="controllers/actividades.js"></script>
  </head>
  <body style="padding: 0px; margin: 0px;" >
      

  <?php include_once('includes/menu.php'); ?>



    <div class="container-fluid">
      <!-- VISTA CUANDO ESTÁ CARGANDO-->
       <div class="view_cargando" id="view_cargando" style="background-color: white;  vertical-align: center; width: 100%; height:100%; position: absolute; display:none;  opacity:0.85; z-index: 10;" ><br><br><br><br><br>
        <img style="position:relative;left: 45%; width: 5%;" src="assets/img/loading2.gif" alt="Espere un mmomento porfavor..."  ><br><strong style="position:relative;left: 40%;"  >Espere un momento porfavor.</strong>
      </div>

    <div class="row">
      <div id="list_materias" class="col-sm-3 panel-default"  >
          <div class="list-group">
            <a href="#" class="list-group-item active color_primario" >
              Cursos <span class="pull-right glyphicon glyphicon-triangle-right"></span>
            </a>
          </div>
      </div>

      <div class="col-sm-9 panel-default" style="border-left-style:solid; border-width: 1px;">
          <div class="row col-md-12">
              <div class="col-md-8" ><h3>Actividades por Alumnos </h3></div>
              <div class="col-md-4" >
                 <div class="input-group">
                  <input type="text" name="filtro" class="form-control" id="filtro" placeholder="Buscar por #Empleado o Nombre">
                   <span class="input-group-btn">
                    <button type="button" id="btn_filtro" class="btn btn-default "><span class=" glyphicon glyphicon glyphicon-search"></span></button>
                  </span>
                </div>
                
              </div>
          </div>
          <div class="row col-md-12">
            <table class="table table-responsive" >
              <thead">
                <tr class="active" >
                  <th>Id</th>
                  <th># Empleado</th>
                  <th>Alumno</th>
                  <th id="label_materia" >Curso</th>
                </tr>
              </thead>
              <tbody id="list_alumnos">
                <tr>
                  <td colspan="3 ">Seleccione un curso
                    
                  </td>
                 
                </tr>      
         
              </tbody>
            </table>
          </div>
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