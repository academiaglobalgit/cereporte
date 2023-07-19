<?php 

  require_once('../config.php');
  require_once($CFG->libdir.'/gradelib.php'); 
  require_once($CFG->dirroot.'/grade/querylib.php');
  require_once('functions/foros.php');

  $foros= new Foros();
  $activePage = basename($_SERVER['PHP_SELF'], ".php");
  
  
  /*CONFIG*/
  $is_debug=true; //para debuggear esta pagina = true, muestra los ids que recibe
  $id_plan_estudio=9; // plan estudio
  $tipo_examen=2; // 1=quiz 2=scorm


  /*INICIALIZAR VARIABLES antes de recibirlas */

  $id_alumno_moodle=0;
  $id_materia=0;
  $id_examen=0; //id_quiz o id_scorm
  $id_tb_examen=0;
  $id_persona=0;


if(isset($USER->id)){
  $id_alumno_moodle=$USER->id;
}
if(isset($_GET['id_materia']) && is_numeric($_GET['id_materia'])){
  $id_materia=$_GET['id_materia'];
}
if(isset($_GET['id_examen']) && is_numeric($_GET['id_examen'])){
  $id_examen=$_GET['id_examen'];
}

$id_persona=$foros->get_id_persona($id_alumno_moodle,$id_plan_estudio);

?>
<!DOCTYPE html>
<html>
  <head>
    <?php include('includes/partials/styles.php'); ?>

    <style>
      .panel-heading{
        border-color: #f07e30 !important;
        color:white !important;
        background-color: #f07e30 !important;
      }
      .active{
        border-color: #f07e30 !important;
        background-color: #f07e30 !important;
      }

     .btn-primary{
        border-color: #f07e30 !important;
        background-color: #f07e30 !important;
      }
    a{
      color:#f07e30;
    }
    a:hover{
      text-decoration: none;
      color: #000;
    }
    </style>

  </head>
  <body  class="locato" style="padding-bottom: 150px; padding-top: 110px;" >
  <div id="loading" class="col-md-12 text-center" style="display:none; opacity: 0.9; border-radius: 10px; z-index: 99; position:fixed; width:100%;height:100px; top:30%;" ><img src="http://agcollege.edu.mx/cereporte/modules/forums/assets/img/loading.gif" alt="Cargando..."  ></div>

      <section id="main-menu">
        <?php include('includes/partials/menu.php'); ?>
    </section>

    <!-- Explicación de la página -->
    <section id="heading_inicio">
        <div class="container">
            <div class="row text-center">
                  
                <p class="">
                  <h2>Foros</h2>
                    <br/>
                  Es necesario contestar todas las preguntas detonadoras de los foros para poder realziar el exámen correspondiente.
                </p>
            </div>
        </div>
    </section>

   <section id="content_inicio">

    <div class="container-fluid">
  
              <form class="form-inline alert alert-default" name="form_course"  id="form_course" role="form">
               <div class="input-group">
                  <?php 
                    if($is_debug){
                      echo '<span class="input-group-addon"  for="id_plan_estudio"><strong>DEBUG MODE:  '.($is_debug==true ? 'ON' : 'OFF' ).'</strong></span > <br>';
                      echo '<span class="input-group-addon"  for="id_plan_estudio">ID_PERSONA:  '.$id_persona.'  </span >
                            <span class="input-group-addon"  for="id_plan_estudio">ID_MOODLE:   '.$id_alumno_moodle.'  </span >
                            <span class="input-group-addon"  for="id_plan_estudio">ID_COURSE:   '.$id_materia.' </span >
                            <span class="input-group-addon"  for="id_plan_estudio">ID_EXAMEN:   '.$id_examen.' </span >
                             <span class="input-group-addon"  for="id_plan_estudio">TIPO EXAMEN:   '.($tipo_examen==1 ? 'Quiz' : 'Scorm' ).' </span >';

                    }
                   ?>
                </div>
                <input type="hidden" name="id_plan_estudio" id="id_plan_estudio" class="input-form_course" value="9">
                <input type="hidden" name="id_materia" id="id_materia" class="input-form_course" value=<?php echo $id_materia; ?>>
                <input type="hidden" name="id_examen" id="id_examen" class="input-form_course" value=<?php echo $id_examen; ?>>
                <input type="hidden" name="id_quiz" id="id_quiz" class="input-form_course" value=<?php echo $id_examen; ?>>

                <input type="hidden" name="id_alumno" id="id_alumno" class="input-form_course" value="0">
                <input type="hidden" name="id_moodle" id="id_moodle" class="input-form_course" value=<?php echo $id_alumno_moodle; ?> >
                <input type="hidden" name="id_persona" id="id_persona" class="input-form_course" value=<?php echo $id_persona; ?> >
                <input type="hidden" name="tipo_examen" id="tipo_examen" class="input-form_course" value=<?php echo $tipo_examen; ?> >

              </form>
   


        <div class="row" >
          <div class="col-md-4 col-xs-12 panel panel-default" >
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12 text-center">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                      <div class="list-group" style="height:350px; overflow-y: auto; ">
                      
                        <div  class="list-group-item active">
                         Foros <span class="pull-right fui-list-large-thumbnails" ></span>
                        </div>
                          <div id="content_forums"> <!--Content FORUMS-->
                            <div  class="list-group-item">
                              <a href="#">Cargando ... </a>
                              <div class="pull-right">
                               
                              </div>
                            </div>

                          </div><!-- CONTENT FORUMS -->

                      </div>
                  </div>
                </div>               

              </div>
          </div>
          <div class="col-md-1 col-xs-12"> <!-- SEPARADOR--> </div>
          <div class="col-md-7 col-xs-12 panel panel-default" >
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                  
                  </div>
                </div>

                 <div class="row">
                  <div class="col-md-12">
                    <div class="list-group" style="height:350px;  overflow-y: auto; ">
                      
                      <div  class="list-group-item active">Preguntas Detonadoras 
                       <label id="list_threads_title" ></label> 
                      </div>
                      <div id="content_threads" >

                        <div href="#" class="list-group-item">
                          <h6 class="list-group-item-heading"><span class="fui-chat" ></span> Seleccione un bloque por favor. </h6>
                           <div class="pull-right">
                           
                            </div>
                          <p class="list-group-item-text"><a href="#"  > <small></small></a></p>
                        </div>

                      </div>

                    </div>
                  </div>
                </div>               

              </div>
            </div>

          </div>





        <!--MODAL COMENTARIOS-->

        <div id="modal_coments" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Pregunta Detonadora</h4>
              </div>
              <div class="modal-body">

                          <div class="row">
                            <div class="col-md-12">
                              <div class="panel panel-default" id="content_posts" >
                                <!-- Default panel contents -->
                                <div class="panel-heading" id="list_posts_title" >Comentarios </div>
                                 <div class="panel-body"> 
                                   <div class="alert alert-default" >Seleccione una Pregunta Detonadora.</div>
                                 </div>

                                <!-- List group -->

                                <ul class="list-group" >
                                  <li class="list-group-item"></li>
                                </ul>
                              </div>
                            </div>
                          </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              </div>
            </div>

          </div>
        </div>

    </div><!--CONTAINER-->
  </div> <!--SECTION INICIO-->

    <!-- Footer -->
    <section id="footer">
        <?php include('includes/partials/footer.php'); ?>
    </section>


    <!-- Messages -->
    <section id="messages_inicio">
        <?php
        include('includes/messages/success.php');
        include('includes/messages/error.php');
        include('includes/messages/warning.php');
        ?>
    </section>


    <!-- Scripts Generales -->
    <section class="scripts">
        <?php include('includes/partials/scripts.php'); ?>
        <script src="controllers/foros.js"></script>
    </section>
  </body>
</html>