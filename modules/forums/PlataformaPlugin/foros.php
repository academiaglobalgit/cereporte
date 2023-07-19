<?php 
  $id_alumno_moodle=0;
  $id_materia=0;
  $id_examen=0;

if(isset($USER->id)){
  $id_alumno_moodle=$USER->id;
}
if(isset($_GET['id_materia']) && is_numeric($_GET['id_materia'])){
  $id_materia=$_GET['id_materia'];
}
if(isset($_GET['id_examen']) && is_numeric($_GET['id_examen'])){
  $id_examen=$_GET['id_examen'];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Foros de la asignatura</title>
    <meta name="description" content="Foros de la asignatura"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Loading Bootstrap -->
    <link  href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="shortcut icon" href="flatui/img/favicon.ico">-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="controllers/foros.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="flatui/dist/js/vendor/html5shiv.js"></script>
      <script src="flatui/dist/js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div id="loading" class="col-md-12 text-center" style="display:none; opacity: 0.9; border-radius: 10px; z-index: 99; position:fixed; width:100%;height:100px; top:30%;" ><img src="assets/img/loading.gif" alt="Cargando..."  ></div>
    <div class="container-fluid">
        <div class="row" >
          <div class="col-md-12 col-xs-12" >
              <form class="form-inline alert alert-default" name="form_course"  id="form_course" role="form">
               <div class="input-group">
                  <span class="input-group-addon"  for="id_plan_estudio">ID_PERSONA:  <?php echo $id_persona; ?> </span >
                 
                </div>
                <input type="hidden" name="id_plan_estudio" id="id_plan_estudio" class="input-form_course" value="8">
                <input type="hidden" name="id_corporacion" id="id_corporacion" class="input-form_course" value="5">

                <input type="hidden" name="id_alumno" id="id_alumno" class="input-form_course" value="0">
                <input type="hidden" name="id_moodle" id="id_moodle" class="input-form_course" value="0">
                <input type="hidden" name="id_persona" id="id_persona" class="input-form_course" value=<?php echo $id_persona; ?> >

                <div class="input-group">
                  <span  class="input-group-addon"  for="id_course">Materia DGB:</span >
                  <select type="text" class="form-control input-form_course" name="id_course" id="id_course">
                    <option >Seleccione una plataforma </option>
                  </select>
                </div>
              </form>
          </div>
        </div>
        <div class="row" >
          <div class="col-md-12 col-xs-12" >
            <br>
          </div>
        </div>

        <div class="row" >
          <div class="col-md-4 col-xs-12 panel panel-default" >
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                     
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                      <div class="list-group" style="height:350px; overflow-y: auto; ">
                      
                        <div  class="list-group-item active">
                         Bloques <span class="pull-right fui-list-large-thumbnails" ></span>
                        </div>
                          <div id="content_forums"> <!--Content FORUMS-->
                            <div  class="list-group-item">
                              <a href="#">Cargando ... </a>
                              <div class="pull-right">
                                  <a href="#" class="delete_forum" item-index="0"  > <span  class="glyphicon glyphicon-minus" ></span></a>
                                  <a href="#" > <span class="glyphicon glyphicon-cog" ></span></a>
                                  <a href="#" > <span class="glyphicon glyphicon-align-justify" ></span></a>
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
                              <a href="#" > <span class="fui-cross" ></span></a> 
                              <a href="#" > <span class="fui-gear" ></span></a> 
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
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-primary" id="content_posts" >
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

    </div><!--CONTAINER-->

  </body>
</html>