<?php 

  $url="https://agcollege.edu.mx"; 
  $titulo_escuela="";
  $course=0;
  $unidad=0;
  $id_corporacion=0;
  $id_plan_estudio=0;

if( isset($corporacion) &&  isset($plan_estudio) &&  isset($_GET['course']) && isset($_GET['unidad']) && is_numeric($_GET['course']) && is_numeric($_GET['unidad']) && is_numeric($plan_estudio)  && is_numeric($corporacion)  ){
      $course=$_GET['course'];
      $unidad=$_GET['unidad'];
      $id_corporacion=$corporacion;
      $id_plan_estudio=$plan_estudio;
}

  //echo "USERID: ".$USER->id."";
  $id_moodle=$USER->id;
  $is_plataforma="true";
  $label_titulo="Módulo";
  if(isset($label_modulos)){
    $label_titulo=$label_modulos;
  }

   $ejercicios_hechos=$ejercicios->get_ejercicios_hechos($id_moodle,$course,$unidad,$id_corporacion,$id_plan_estudio);
   $nombre_materia=$ejercicios->get_materia_nombre($course);
?>
    <?php 
        if($id_plan_estudio != 50 && $id_plan_estudio != 22)
        echo '<link  href="', $url, '/cereporte/modules/evidencias/assets/bootstrap/css/bootstrap.min.custom.css" rel="stylesheet">';
    ?>
    
    <script type="text/javascript">
        <?php echo "
              var id_plan_estudio=".$id_plan_estudio.";
              var id_corporacion=".$id_corporacion."; 
              var is_plataforma=".$is_plataforma.";
              var course=".$course.";
              var unidad=".$unidad.";
              var id_moodle=".$id_moodle.";

        "; ?>
    </script>
    <script src="<?= $url ?>/cereporte/modules/evidencias/assets/js/jquery.min.js"></script>
    <script src="<?= $url ?>/cereporte/modules/evidencias/ckeditor/ckeditor.js"></script>
    <script src="<?= $url ?>/cereporte/modules/evidencias/controllers/evidencias.js?v=2"></script>
  
    <?php 
        if($id_plan_estudio != 50 && $id_plan_estudio != 22)
        echo '<body style="padding: 0px; margin: 0px;" >';
    ?>
        <!-- VISTA CUANDO ESTÁ CARGANDO-->
       <div class="view_cargando" id="view_cargando" style="background-color: white;  vertical-align: center; width: 100%; height:100%; position: absolute; display:none;  opacity:0.85; z-index: 10;" ><br><br><br><br><br>
        <img src="<?php echo $url; ?>/cereporte/modules/evidencias/assets/img/loading2.gif" style="width: 5%;" alt="Espere un mmomento porfavor..."  ><br><strong>Espere un momento porfavor.</strong>
      </div>

     <!-- MENU DE PESTAÑAS DEPENDIENDO DE CUANTOS EJERCICIOS POR MODULO-->
      <ul class="nav nav-tabs" id="content_ejercicios_tabs">
        <li role="presentation" item-index="0"  class="ejercicio_tab active"><a href="#">... </a></li>
       
      </ul>
    <div class="container-fluid">


       <!-- VISTA NORMAL PARA EDITAR -->
      <div class="container-fluid" id="view_editar" style="display:none;" >
        <div class="row">
            <div class="col-md-12 text-center"  ><h3 id="ejercicio_titulo" >...</h3></div>
        </div>
        <div class="row">
            <div class="col-md-12 text-left"  >
              <p id="ejercicio_desc">
                ....
              </p>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
           <div class="col-md-2 pull-left"  >
                <button class="btn btn-default pull-left" type="button" id="btn_save" ><!--<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>--> Guardar Progreso</button>
               
           </div>
           <div class="col-md-2 pull-right"  >
                <button class="btn btn-default pull-right" type="button" id="btn_save_finish" ><!--<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>-->Finalizar Actividad</button>
                <label style="display: none;" class="label label-success pull-left"  id="label_finish" ><!--<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>-->ACTIVIDAD REALIZADA</label>
           </div>
        </div>
        <div class="row">
        <br>
        </div>
        <div class="row edicion">
            <div class="col-md-12"  >
                <textarea class="ejercicio_contenido" id="ejercicio_contenido" name="ejercicio_contenido"  name="ejercicio_contenido" rows="15"  >

                </textarea>
            </div>
        </div>
        <div class="row vista_previa">
            <div class="col-md-12 ejercicio_contenido_vista_previa text-left panel panel-default"   >
               
            </div>
        </div>
      </div>

      <div class="container-fluid" id="view_inicio" style="   background-position: center;  background-repeat:no-repeat; background-image: url(<?php echo $url; ?>/cereporte/modules/evidencias/assets/img/background_edit.png); " >
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 >Actividades Integradoras <?php echo $label_titulo." ".($unidad+1); ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center"  >
                <h4 id="ejercicios_realizados" >
                    <?php 
                    if($ejercicios_hechos['totales']>0)
                        echo $nombre_materia."<br><br>Realizadas ".$ejercicios_hechos['hechos']." de ".$ejercicios_hechos['totales']; 
                    else echo $nombre_materia."<br><br><br>Sin Actividades Integradoras a realizar."; 
                    ?>
                </h4>
            </div>
        </div>
       
        <div class="row text-center">
            <div class="col-md-offset-2 col-md-8 col-sm-12"  >
              <p id="ejercicio_desc">
              <?php if($ejercicios_hechos['totales']>0){
                 echo " Realiza todas las Actividades Integradoras para poder presentar el examen del módulo ".($unidad+1).".<br>Cada Actividad Integradora se encuentra en las pestañas de la parte superior.<br> No olvides <strong>Guardar tu progreso</strong> de cada actividad antes de salir. ";
                  }
              ?>
               
              </p>
            </div>
        </div>
        <br>
        <br>
      </div>




    </div><!--CONTAINER-->
     <div id="modal_aviso" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="" ><img style="width: 5%;" src="<?php echo $url; ?>/cereporte/modules/evidencias/assets/img/ok.png" ></h4>
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