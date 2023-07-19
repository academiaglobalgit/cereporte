<?php 
session_start();
  $id_persona=0;
if(isset($_SESSION['id_persona'])){
  $id_persona=$_SESSION['id_persona'];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Foros</title>
    <meta name="description" content="Foros de la asignatura"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Loading Bootstrap -->
    <link  href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="shortcut icon" href="flatui/img/favicon.ico">-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <script src="controllers/foros.js?n=4"></script>
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
                <!--<input type="hidden" name="id_plan_estudio" id="id_plan_estudio" class="input-form_course" value="8">-->
                <input type="hidden" name="id_corporacion" id="id_corporacion" class="input-form_course" value="5">

                <input type="hidden" name="id_alumno" id="id_alumno" class="input-form_course" value="0">
                <input type="hidden" name="id_moodle" id="id_moodle" class="input-form_course" value="0">
                <input type="hidden" name="id_persona" id="id_persona" class="input-form_course" value=<?php echo $id_persona; ?> >
                
                <div class="input-group">
                  <span  class="input-group-addon"  for="id_plan_estudio">Autoridad:</span >
                  <select type="text" class="form-control input-form_course" name="id_plan_estudio" id="id_plan_estudio">
                    <option value="8" selected>Plan Estudios DGB Original </option>
                    <option value="11">Plan Estudios SEPYC 1 </option>
                  </select>
                </div>

                <div class="input-group">
                  <span  class="input-group-addon"  for="id_course">Materia DGB:</span >
                  <select type="text" class="form-control input-form_course" name="id_course" id="id_course">
                    <option >Seleccione una materia </option>
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
                      <p><button class="btn btn-info btn-large btn-block"  data-toggle="modal" data-target="#modal_forum" type="button" >Nuevo bloque <span class="fui-plus"></span></button></p>
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
                  <p><button id="btn_modal_thread" style="display:none;" class="btn btn-info btn-large btn-block" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal_thread" type="button" >Nueva Pregunta <span class="fui-plus"></span></button></p>
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

       <!-- Modal CREAR FORUM-->
          <div id="modal_forum" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Crear Nuevo Bloque</h4>
                </div>
                <div class="modal-body">
                  
                  <form class="form"  id="form_forum" name="form_forum"  >
                  <p>Nombre del bloque</p>
                    <div class="form-group" >
                        <input type="text" name="nombre" id="f_nombre" error="Ingresa el nombre del bloque." class="input-form_forum form-control" placeholder="Foro Bloque 1"  required> 
                    </div>
                     <p>Selecciona un examen para ligarlo al bloque</p>
                    <div class="form-group" >
                        <select type="number" class="input-form_forum form-control"  error="Selecciona un examen para ligarlo al bloque."  name="id_quiz" id="f_id_quiz" required>
                            <option value="">No se encontraron examenes</option>
                        </select>
                    </div>
                    <div class="form-group" >
                        <input type="hidden" name="id_course" id="f_id_course" class="input-form_forum" value="0"> 
                        <input type="hidden" name="id_plan_estudio" id="f_id_plan_estudio" class="input-form_forum" value="8"> 
                        <input type="hidden" name="id_corporacion" id="f_id_corporacion" class="input-form_forum" value="5"> 

                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                  <button id="btn_form_forum" type="button" class="btn btn-info pull-right">Guardar</button>
                </div>
              </div>
            </div>
          </div>
         <!-- Modal EDITAR FORUM-->
            <div id="modal_forum_update" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Bloque</h4>
                  </div>
                  <div class="modal-body">
                    <p>Nombre del bloque</p>
                    <form class="form"  id="form_forum_update" name="form_forum_update"  >
                      <div class="form-group" >
                          <input type="text" name="nombre" id="f_u_nombre" error="Ingresa el nombre del bloque." class="form-control input-form_forum_update" placeholder="Foro Bloque 1"  value="" required> 
                      </div>
                     <p>Selecciona un examen para ligarlo al bloque </p>

                      <div class="form-group" >
                        <select type="number"  class="form-control input-form_forum_update"  error="Selecciona un examen para ligarlo al bloque."  name="id_quiz" id="f_u_id_quiz" required>
                          <option value="">No se encontraron examenes</option>
                        </select>
                      </div>
                      <div class="form-group" >
                        <input type="hidden" name="id_course" id="f_u_id_course" class="input-form_forum_update" value="0"> 
                        <input type="hidden" name="id_plan_estudio" id="f_u_id_plan_estudio" class="input-form_forum_update" value="8">
                        <input type="hidden" name="id_corporacion" id="f_u_id_corporacion" class="input-form_forum_update" value="5"> 

                      </div>
                      <div class="form-group" >
                          <input type="hidden" name="id_forum" id="f_u_id_forum" class="input-form_forum_update" value="0"> 
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button id="btn_form_forum_update" type="button" class="btn btn-info pull-right">Guardar</button>
                  </div>
                </div>
              </div>
            </div>

          <!--DELETE FORUM-->
          <div id="modal_forum_delete" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Eliminar bloque</h4>
                </div>
                <div class="modal-body">
                  <p>Nombre del bloque a eliminar</p>
                  <form class="form"  id="form_forum_delete" name="form_forum_delete"  >
                    <div class="form-group" >
                        <input type="text" name="nombre" class="input-form_forum_delete form-control" id="f_d_nombre" value="" disabled>
                        <input type="hidden" name="id_forum" id="f_d_id_forum" class="input-form_forum_delete form-control" value="0" > 
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                  <button id="btn_form_forum_delete" type="button" class="btn btn-danger pull-right">Eliminar</button>
                </div>
              </div>

            </div>
          </div>




              <!-- Modal CREAR THREAD-->
          <div id="modal_thread" class="modal fade " role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content ">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" >&times;</button>
                  <h4 class="modal-title">Crear Nueva Pregunta Detonante</h4>
                </div>
                <div class="modal-body">
                  <form class="form" id="form_thread" role="form" name="form_thread" >
                   <div class="form-group" >
                        <input type="hidden" name="id_persona" id="t_id_persona" class="input-form_course" value=<?php echo $id_persona; ?> >

                        <input type="hidden" id="t_id_forum" name="id_forum" class="input-form_thread form-control" error="Seleccione de nuevo un bloque." value="" required>
                    </div> 
                    <div class="form-group" >
                        Titulo:
                        <input type="text" id="t_nombre" name="nombre" class="input-form_thread form-control" error="Porfavor introduce un titulo valido." placeholder="Titulo de la pregunta" required>
                    </div>
                    <div class="form-group" >
                      Pregunta:
                      <textarea required="required" type="text" id="t_texto" name="texto" placeholder="Introduce el un texto para la pregunta." class="input-form_thread form-control" error="Porfavor introduce un texto valido." ></textarea>
                    </div>
                    <div class="form-group" >
                      Mensaje del Maestro hacia el alumno (Respuesta Correcta):
                      <textarea required="required" type="text" id="t_texto_correcta" name="texto_correcta" placeholder="Cuando el alumno da la respuesta correcta." class="input-form_thread form-control" error="Porfavor introduce un texto valido." ></textarea>
                    </div>
                   <div class="form-group" >
                      Mensaje del Maestro hacia el alumno (Respuesta Incorrecta):
                      <textarea required="required" type="text" id="t_texto_incorrecta" name="texto_incorrecta" placeholder="Cuando el alumno da la respuesta incorrecta." class="input-form_thread form-control" error="Porfavor introduce un texto valido." ></textarea>
                    </div>
                  <p>Tipo de Pregunta</p> 

                    <div class="form-group" >
                      <select type="text"  class="form-control input-form_thread" name="tipo" id="form_thread-t_tipo"  >
                        <option value="1" selected>Normal</option>
                        <option value="2" >Multirespuesta</option>
                      </select>
                    </div>

                    <input type="hidden" id="form_thread-t_idx_correct" name="idx_correct" class="input-form_thread form-control" value="0" >

                    <hr>
                    <div id="form_thread-showResponses" style="display:none;">
                        <div class="form-group">
                              <div class="col-md-3">
                                <input type="text" id="form_thread-t_texto_r" name="t_texto_r" class="input-form_thread form-control" error="Porfavor introduce una respuesta valida." placeholder="Nueva Respuesta" >
                              </div>
                              <div class="col-md-2" >
                                <button type="button" class="btn btn-success" id="form_thread-btn_responses_add" >Agregar</button>
                              </div>
                        </div>
                        <div class="form-group" >
                           <div class="table-responsive" id="form_thread-content_responses" >
                              <table class="table">
                                   <thead>
                                    <tr>
                                      <th>Respuestas</th>
                                    </tr>
                                   </thead>
                                   <tbody>
                                    <tr>
                                      <td>Actualmente no se han agregado respuestas para esta pregunta detonadora.<td>
                                    </tr>
                                   </tbody>
                              </table>
                          </div> 
                        </div>
                    </div>

                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                  <button id="btn_form_thread" type="button" class="btn btn-info pull-right">Guardar</button>
                </div>
              </div>

            </div>
          </div>




              <!-- Modal EDITAR THREAD-->
          <div id="modal_thread_update" class="modal fade " role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content ">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" >&times;</button>
                  <h4 class="modal-title">Crear Nueva Pregunta Detonante</h4>
                </div>
                <div class="modal-body">
                  <form class="form" id="form_thread_update" name="form_thread_update" >
                   <div class="form-group" >
                        <input type="hidden" id="t_u_id_thread" name="id_thread" class="input-form_thread_update form-control" error="Seleccione de nuevo una pregunta detonadora." value="" required>

                    </div>
                    <div class="form-group" >
                        <input type="text" id="t_u_nombre" name="nombre" class="input-form_thread_update form-control" error="Porfavor introduce un titulo valido." placeholder="Titulo de la pregunta" required>
                    </div>
                    <div class="form-group" >
                      <textarea required="required" type="text" id="t_u_texto" name="texto" placeholder="Introduce el un texto para la pregunta." class="input-form_thread_update form-control" error="Porfavor introduce un texto valido." ></textarea>
                    </div>
                    <div class="form-group" >
                      Mensaje del Maestro hacia el alumno (Respuesta Correcta):
                      <textarea required="required" type="text" id="t_u_texto_correcta" name="texto_correcta" placeholder="Cuando el alumno da la respuesta correcta." class="input-form_thread_update form-control" error="Porfavor introduce un texto valido." ></textarea>
                    </div>
                   <div class="form-group" >
                      Mensaje del Maestro hacia el alumno (Respuesta Incorrecta):
                      <textarea required="required" type="text" id="t_u_texto_incorrecta" name="texto_incorrecta" placeholder="Cuando el alumno da la respuesta incorrecta." class="input-form_thread_update form-control" error="Porfavor introduce un texto valido." ></textarea>
                    </div>
                  <p>Tipo de Pregunta</p> 
                    <input type="hidden" id="form_thread_update-t_idx_correct" name="idx_correct" class="input-form_thread_update form-control" value="0" >

                    <div class="form-group" >
                      <select type="text"  class="form-control input-form_thread_update" name="tipo" id="form_thread_update-t_tipo"  >
                        <option value="1" selected>Normal</option>
                        <option value="2" >Multirespuesta</option>
                      </select>
                    </div>
                    <hr>
                    <div id="form_thread_update-showResponses" style="display:none;" >
                        <div class="form-group">
                              <div class="col-md-3">
                                <input type="text" id="form_thread_update-t_texto_r" name="t_texto_r" class="input-form_thread_update form-control" error="Porfavor introduce una respuesta valida." placeholder="Nueva Respuesta" >
                              </div>
                              <div class="col-md-2" >
                                <button type="button" class="btn btn-success" id="form_thread_update-btn_responses_add" >Agregar</button>
                              </div>
                        </div>
                        <div class="form-group" >
                           <div class="table-responsive" id="form_thread_update-content_responses" >
                              <table class="table">
                                   <thead>
                                    <tr>
                                      <th>Respuestas</th>
                                    </tr>
                                   </thead>
                                   <tbody>
                                    <tr>
                                      <td>Actualmente no se han agregado respuestas para esta pregunta detonadora.<td>
                                    </tr>
                                   </tbody>
                              </table>
                          </div> 
                        </div>
                    </div>

                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                  <button id="btn_form_thread_update" type="button" class="btn btn-info pull-right">Guardar</button>
                </div>
              </div>

            </div>
          </div>
          <!--DELETE THREAD-->
          <div id="modal_thread_delete" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Eliminar bloque</h4>
                </div>
                <div class="modal-body">
                  <p>Nombre del bloque a eliminar</p>
                  <form class="form"  id="form_thread_delete" name="form_thread_delete"  >
                    <div class="form-group" >
                        <input type="text" name="nombre" class="input-form_thread_delete form-control" id="t_d_nombre" value="" disabled>
                        <input type="hidden" name="id_thread" id="t_d_id_thread" error="Porfavor vuelve a intentarlo mas tarde: 008" class="input-form_thread_delete form-control" value="" required> 
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                  <button id="btn_form_thread_delete" type="button" class="btn btn-danger pull-right">Eliminar</button>
                </div>
              </div>

            </div>
          </div>





           <!--DELETE THREAD-->
          <div id="modal_post_delete" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Eliminar Post</h4>
                </div>
                <div class="modal-body">
                  <p>Post a eliminar</p>
                  <form class="form"  id="form_post_delete" name="form_post_delete"  >
                    <div class="form-group" >
                        <input type="text" name="nombre" class="input-form_post_delete form-control" id="p_d_nombre" value="" disabled>
                        <input type="hidden" name="id_post" id="p_d_id_post" error="Porfavor vuelve a intentarlo mas tarde: 009" class="input-form_post_delete form-control" value="" required> 
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                  <button id="btn_form_post_delete" type="button" class="btn btn-danger pull-right">Eliminar</button>
                </div>
              </div>

            </div>
          </div>




    </div><!--CONTAINER-->

  </body>
</html>