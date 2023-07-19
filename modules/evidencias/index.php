<?php 
  $titulo_escuela="UCL";
  $course=20;
  $unidad=0;
  $id_moodle=0;
  $is_plataforma="false";
?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <title><?php echo $titulo_escuela; ?> | Ejercicios de Evidencias</title>
      <meta name="description" content="Ejercicios de Evidencias"/>

      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Loading Bootstrap -->
      <link  href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link  href="assets/bootstrap/css/bootstrap.min.custom.css" rel="stylesheet">
      <!--<link rel="shortcut icon" href="flatui/img/favicon.ico">-->
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="ckeditor/ckeditor.js"></script>
      <script type="text/javascript">
        <?php echo "
                var course=".$course.";
                var unidad=".$unidad.";
                var id_moodle=".$id_moodle.";
                var is_plataforma=".$is_plataforma.";
                      "; ?>
      </script>
      <script src="controllers/evidencias.js?n=2"></script>
      <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
        <script src="flatui/dist/js/vendor/html5shiv.js"></script>
        <script src="flatui/dist/js/vendor/respond.min.js"></script>
      <![endif]-->
    </head>
  <body style="padding: 0px; margin: 0px;" >
        <!-- VISTA CUANDO ESTÁ CARGANDO-->

      <div class="view_cargando" id="view_cargando" style="background-color: white; text-align:center; vertical-align: center; width: 100%; height:100%; position: fixed; display:none;  opacity:0.85; z-index: 10;" ><br><br><br><br><br>
          <div class="row text-center"><img src="assets/img/loading2.gif" alt="Espere un mmomento porfavor..."  ><strong>Espere un mmomento porfavor.</strong></div>
      </div>

     <!-- MENU DE PESTAÑAS DEPENDIENDO DE CUANTOS EJERCICIOS POR MODULO-->
      <ul class="nav nav-tabs" id="content_ejercicios_tabs" >
        <li role="presentation" item-index="0"  class="ejercicio_tab active"><a href="#">... </a></li>
        <!--<button class="btn btn-success pull-right" type="button" id="btn_save_exit" ><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Guardar y Salir</button>-->
      </ul>
    <div class="container-fluid">

      

       <!-- VISTA NORMAL PARA EDITAR -->
      <div class="container-fluid" id="view_editar" style="display:none;" >
        <div class="row">
            <div class="col-md-12"  ><h2 id="ejercicio_titulo" >Titulo del Ejercicio</h2></div>
        </div>
        <div class="row">
            <div class="col-md-12"  >
              <p id="ejercicio_desc">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ac nunc a felis ornare elementum vitae quis diam. Aenean tempus eros egestas sem auctor sollicitudin. Duis porttitor a metus id egestas. Nam sit amet venenatis metus, eget accumsan erat. Nunc rhoncus tortor nec fringilla semper. Aenean at felis et nisl rutrum rutrum. Morbi tincidunt orci orci, sit amet fringilla mi sodales vitae. Donec bibendum imperdiet massa vel imperdiet. Integer sagittis sodales odio, a maximus arcu tempor sed. Vestibulum eleifend metus non tincidunt dignissim. Nam aliquet turpis sit amet nunc rutrum, id faucibus urna condimentum. Nam nec turpis a velit blandit vehicula a sit amet orci. Aenean vulputate placerat mauris ut condimentum. Nullam ac convallis ante, eget laoreet quam. 
              </p>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
           <div class="col-md-2"  >
                <button class="btn btn-primary" type="button" id="btn_save" ><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Guardar Progreso</button>
           </div>
        </div>
        <div class="row">
            <div class="col-md-12"  >
                <textarea class="ejercicio_contenido" id="ejercicio_contenido" name="ejercicio_contenido"  name="ejercicio_contenido" rows="15"  >

                </textarea>
            </div>
        </div>
      </div>

      <div class="container-fluid" id="view_inicio">
        <div class="row">
            <div class="col-md-12 text-center"  ><h2 id="ejercicio_titulo" >Ejercicios del Modulo <?php echo ($unidad+1); ?></h2></div>
        </div>
        <div class="row text-center">
            <div class="col-md-offset-3 col-md-6 col-sm-12"  >
              <p id="ejercicio_desc">
               Nam sit amet venenatis metus, eget accumsan erat. Nunc rhoncus tortor nec fringilla semper. Aenean at felis et nisl rutrum rutrum. Morbi tincidunt orci orci, sit amet fringilla mi sodales vitae. Donec bibendum imperdiet massa vel imperdiet. Integer sagittis sodales odio, a maximus arcu tempor sed. Vestibulum eleifend metus non tincidunt dignissim. Nam aliquet turpis sit amet nunc rutrum, id faucibus urna condimentum. Nam nec turpis a velit blandit vehicula a sit amet orci. Aenean vulputate placerat mauris ut condimentum. Nullam ac convallis ante, eget laoreet quam. 
              </p>
            </div>
        </div>
        <br>
        <br>

        <div class="row">
            <div class="col-md-12 text-center"  >
               <img src="assets/img/background_edit.png" alt="" style="opacity: 0.1;"  >
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
            <h4 class="modal-title" id="" >Mensaje</h4>
          </div>
          <div class="modal-body" id="modal_aviso_msg" >
            <p></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Aceptar</button>
          </div>
        </div>

      </div>
    </div>
  </body>
</html>