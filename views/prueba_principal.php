<?php
ini_set('display_errors',1);
require_once('../config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/querylib.php');
require_once('../util_cargar_materia.php');
include_once('models/Principal.php');
include_once('functions/peticiones.php');
include_once('includes/avisos/config.php');
include_once('includes/avisos/avisos.class.php');

include_once("jl_conexion.php");
$Materia= new Materia();
$Examen= new Examen();
$Peticion= new Peticiones();
$con = mysqli_connect($CFG->dbhost, $CFG->dbuser, $CFG->dbpass, $CFG->dbname);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <title>Prepa Coppel</title>
    <!-- Mensajes -->
    <?php include('includes/messages/NoPuedeCargarMessage.php');?>
    <!-- Estilos -->
    <?php include('includes/assets/head.php');?>
    <!-- Scripts -->
    <script src="js/ajax.js"></script>
    <script src="js/jquery1.11.3.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/main.js"></script>
    <script src="js/formValidation.js"></script>
    <script src="js/bootstrap.js"></script>



    <style>
        a{
            color:#000000;
            text-decoration: none;
        }

        a:hover{
            color:#000000;
            text-decoration: none;
        }

        a.login{
            color:#265da6;
        }
        a.back{
            width:256px;
            height:73px;
            position:fixed;
            bottom:15px;
            right:15px;
            background:#fff url(codrops_back.png) no-repeat top left;
            z-index:1;
            cursor:pointer;
        }

        /* Style for overlay and box */
        .overlay{
            background:transparent url(CSSOverlay/images/overlay.png) repeat top left;
            position:fixed;
            top:0px;
            bottom:0px;
            left:0px;
            right:0px;
            z-index:100;
        }
        .box{
            position:fixed;
            top:-200px;
            left:30%;
            right:30%;
            background-color:#fff;
            color:#7F7F7F;
            padding:20px;
            border:2px solid #ccc;
            -moz-border-radius: 20px;
            -webkit-border-radius:20px;
            -khtml-border-radius:20px;
            -moz-box-shadow: 0 1px 5px #333;
            -webkit-box-shadow: 0 1px 5px #333;
            z-index:101;
        }
        .box h1{
            border-bottom: 1px dashed #7F7F7F;
            margin:-20px -20px 0px -20px;
            padding:10px;
            background-color:#FFEFEF;
            color:#EF7777;
            -moz-border-radius:20px 20px 0px 0px;
            -webkit-border-top-left-radius: 20px;
            -webkit-border-top-right-radius: 20px;
            -khtml-border-top-left-radius: 20px;
            -khtml-border-top-right-radius: 20px;
        }
        a.boxclose{
            float:right;
            width:26px;
            height:26px;
            background:transparent url(CSSOverlay/images/cancel.png) repeat top left;
            margin-top:-30px;
            margin-right:-30px;
            cursor:pointer;
        }

        .table > tr:hover {
            background-color: #ffffff;
        }

    </style>
</head>

<body >

<!-- Modales -->
<span>
<div id="myModal-01" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
</div>
<div id="myModal-03" class="modal fade out" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class='modal-dialog'>
        <div class='modal-content '>

            <div class='modal-body' style='text-align: justify;'>
"Estimados Alumnos de Prepa Coppel, les informamos que los días 25 y 26 de Marzo, no contaremos con el servicio de 01800 8497056, por ser días inhábiles de Semana Santa; sin embargo, estaremos a tu disposición a través del teléfono celular que conoces de tu asesor".
            </div>
            <div class='modal-footer'>
                <center>
                   Muchas gracias por su atención y comprensión.<br/><br>

                    <button type='button' class='btn btn-primary' data-dismiss="modal">Cerrar</button>
                </center>
            </div>
        </div>
    </div>
</div>
<div id="myModal-04" class="modal fade out" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class='modal-dialog'>
        <div class='modal-content '>
            <div class='modal-header bg-color-blue'>
                <h4 class='modal-title text-white-title text-center' id='myModalLabel'>Avíso</h4>
            </div>
            <div class='modal-body' style='text-align: justify;'>
                Estimados alumnos de Prepa Coppel, para poder brindarles una mejor atención y servicio es necesario que llenen el siguiente formulario de actualización de datos.
                <br>
                A partir de septiembre de 2015	los exámenes de los cursos básicos que toma cada colaborador al entrar a la empresa se realizarán en esta plataforma dependiendo de su área de trabajo.
                <br>
                <br>
                <center class='text-center'>
                    Por su atención Gracias.
                </center>

            </div>
            <div class='modal-footer'>
                <center>
                    <button id='button_close_modal' type='button' class='btn btn-default' onclick='checar_actualizacion()'>Cerrar</button>
                </center>
            </div>
        </div>
    </div>
</div>
</span>

<div id="bar-update" class="progress">
    <div id='progress-bar-update' class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
    </div>
</div>


<div>

    <div id="form_actualizacion" class="row" style="display: none;">
    </div>

    <?PHP

    $query = "
				SELECT a.id AS 'userid', d.id, d.tipo, d.descripcion
					FROM mdl_user a
					INNER JOIN escolar.tb_alumnos c ON c.idmoodle = a.id AND c.id_plan_estudio = 2 AND c.id_corporacion = 2
					INNER JOIN escolar.tb_alumnos_estados d ON d.id = c.estado
					WHERE a.id = ".$USER->id;
    $response = select_uno_db($query);
    $estados = $response["data"];
    if(isset($estados["userid"])){

        $avisos= new Avisos();

        echo $avisos->MostrarAvisos(2,$estados["id"]);

    }

    ?>

    <section id="ContenidoPrincipal" style='display: none;'>

        <!-- Mensaje de descuento de mensajes extraordinario-->
        <!--
        <span id="container_mensaje_control_escolar2">
            <center>
                <div id='mensaje_control_escolar2' class='row' style="width: 95%;">
                    <div class='alert alert-success' role='alert' style="background-color: #FEDC46; border-radius: 16px; border-color: #e7e7e7">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">cerrar ×</span></button>
                        <br/>
                        <blockquote style="border-left: none; margin-bottom: 0px; font-size:14.5;">
                            <center><i class="fa fa-exclamation-triangle fa-2x text-blue"></i></center>
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <center><p class="text-center text-blue">Atención Estudiantes, dando seguimiento al avance de su preparatoria y con la finalidad de que puedan regularizarse, AG College les  otorga un beneficio en el pago de sus exámenes extraordinarios del 50%, este beneficio estará vigente del 15 de Febrero al 15 de Marzo del presente año.</p></center>
                                </div>
                            </div>
                            <br/>
                            <p class="text-center text-blue" style="margin-bottom: 0px;">Atentamente<br>Departamento de Control Escolar</p>
                        </blockquote>
                    </div>
                </div>
            </center>
        </span>
        -->


        <input id="user" type="hidden" value="<?php echo $USER->id; ?>" style='display: none;'>
        <div class="container-fluid">

            <!-- Contenido principal: Tabla de materias-->
            <div class="row">
                <div class="col-md-12 spacetop">

                    <!-- Sistemas 2: Menú De los Botones-->
                    <span id="left-sidebar">
                        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 spacetop">
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <nav>
                                <ul>

                                <?php
                                $tienePeticiones = $Peticion->get_total_peticiones($USER->id);
                                if($tienePeticiones->total > 0){
                                    echo '<a href="#"><button type="button" class="btn btn-blue-0 peticiones locato" name="show_message_peticiones">Cargar Materias</button></a>';
                                }else{
                                    $alumno = $Materia->get_tipo_usuario($USER->id);
                                    if($alumno->tipo == 1){
                                        $materias_activas = $Materia->get_materias_activas($USER->id);
                                        if($materias_activas->total >=2){
                                            echo '<a href="#"><button name="show_denied_cargas" type="button" class="btn btn-blue-1 peticiones locato" >No Puedes Cargar</button></a>';
                                        }else{
                                            echo '<a type="button" class="btn btn-blue-0 locato" href="'.$CFG->wwwroot.'/V2/prueba_mapa.php" target="frame" >Cargar Materias</a>';
                                        }
                                    }else{
                                        if($Materia->MateriasDisponiblesCargar($USER->id) > 0 and @utilCargaMateria::total_cursos_activos() < 7){
                                            echo '<a type="button" class="btn btn-blue-0 locato" href="'.$CFG->wwwroot.'/V2/prueba_mapa.php" target="frame" >Cargar Materias</a>';
                                        }else{
                                            echo '<a href="#"><button name="show_denied_cargas" type="button" class="btn btn-blue-1 peticiones locato" >No Puedes Cargar</button></a>';
                                        }
                                    }
                                }
                                ?>
                                    <a type="button" href="<?php echo $CFG->wwwroot ?>/V2/Kardex.php"  class="btn btn-blue-2 spacetopmin locato">Revisar Calificaciones</a>
                                    <a type="button" href="<?php echo $CFG->wwwroot ?>/V2/otros_cursos.php"  class="btn btn-blue-3 spacetopmin locato">Cargar Cursos <br>Adicionales</a>
                                    <a type="button" id="btnBiblioteca"  href="#" class="btn btn-blue-4 spacetopmin locato show_modal_biblioteca "  >Biblioteca Virtual</a>
                                    <a id="btnVideotecateca"  href="#" class="btn btn-blue-5 spacetopmin locato show_modal_videoteca"  type="button" >Videoteca Virtual</a>

                                </ul>
                            </nav>
                        </div>
                    </span>

                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <?php
                        #CODIGO PARA OBTENER INFORMACION DEL USUARIO
                        $query = "SELECT a.userid, a.tipoid, b.descripcion AS 'tipo_colaborador', a.areaid, c.area FROM jl_data_personal a INNER JOIN jl_data_personal_tipo_colaborador b ON b.id = a.tipoid INNER JOIN jl_data_personal_areas c ON c.id = a.areaid WHERE a.userid = ".$USER->id;
                        $response = get_varios_from_table($query);
                        if($response["error"] == "NO"){
                            $usuarios = $response["data"];
                            if(count($usuarios) > 0){
                                $info_user = $usuarios[0];
                            }
                            else{
                                $info_user = 1;
                            }
                        }
                        else{
                            $info_user = 1;
                        }

                        ?>

                        <div class="text-center">
                            <?php $tienePeticiones->total ?>
                            <!-- Sistemas 2: Encabezado de la table de acuerdo a su situación-->
                            <?php
                            if(($Materia->MateriasSuma($USER->id)) > 0){

                                echo '
                                <h5 class="locato" style="color: #FEDC46;background-color: #265da6; padding-top:10px; padding-bottom: 10px; border-radius: 5px;">Materias Cargadas en este Momento</h5>
                                <table class="table">

                                    <thead>
                                        <tr>
                                            <th class="locato" style="color:#265da6;"><center>Materia</center></th>
                                            <th class="locato" style="color:#265da6;"><center>Material</center></th>
                                            <th class="locato" style="color:#265da6;"><center>Examen</center></th>
                                        </tr>
                                    </thead>';


                            }elseif(($Materia->ReprobadasSuma($USER->id)) > 0){
                                echo'
                                <h5 class="locato" style="color: #FEDC46;background-color: #265da6; padding-top:10px; padding-bottom: 10px; border-radius: 5px;">Solicitudes Pendientes</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="locato" style="color:#265da6;"><center>Materia</center></th>
                                            <th class="locato" style="color:#265da6;"><center></center></th>
                                            <th class="locato" style="color:#265da6;"><center>Solicitud</center></th>
                                        </tr>
                                    </thead>';

                            }elseif($tienePeticiones->total > 0){
                                echo'
                                <h5 class="locato" style="color: #FEDC46;background-color: #265da6; padding-top:10px; padding-bottom: 10px; border-radius: 5px;">Solicitudes de Cargas Pendientes</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="locato" style="color:#265da6;"><center>Materia Solicitada</center></th>
                                            <th class="locato" style="color:#265da6;"><center></center></th>
                                            <th class="locato" style="color:#265da6;"><center></center></th>
                                        </tr>
                                    </thead>';

                            }else{
                                echo '<center><h2 class="text-black locato" style="color: #FEDC46;background-color: #265da6; padding-top:10px; padding-bottom: 10px; border-radius: 5px;margin-top:18%;width:55%;">Por el momento<br>
no tienes materias cargadas.</h2></center>';
                            }
                            ?>
                                    <tbody>
                                        <!-- Renglones por si hay materias cargadas-->
                                        <span id="wrapper_materias" style="">
                                            <?php
                                            $datos = $Materia->MateriasCargadas($USER->id);

                                            if($datos!=null):

                                                foreach($datos as $materia):

                                                    if(($materia['courseid'] == 24 OR $materia['courseid'] == 29 OR $materia['courseid'] == 35 OR $materia['courseid'] == 40) AND $info_user == 1){
                                                        ?>
                                                        <tr>
                                                            <td width="40%" class="text-left"><?php echo utf8_encode($materia['fullname']); ?></td>
                                                            <td width="30%">
                                                                <div class="alert alert-warning" role="alert">
                                                                    Debe actualizar su información para acceder a esta materia.
                                                                </div>
                                                            </td>
                                                            <td width="30%">
                                                                <?php echo '<a href="javascript:void(0)" style="background-color: #ececec; border-radius:3px; padding:3px 12px;"><button id="boton_update" type="button" class="btn btn-default BotonEnviar" onclick="get_formulario_actualizacion_datos(1)"><strong>Actualizar información</strong></button></a>'; ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }else{#EMPIEZA ELSE 1
                                                        ?>
                                                        <tr>

                                                            <td width="40%" class="text-left"><?php echo utf8_encode($materia['fullname']); ?></td>
                                                            <td width="30%">
                                                                <center>
                                                                    <?php
                                                                    #CODIGO DE MATERIAL DE ESTUDIO DE LA MATERIA
                                                                    $datos = $Materia->MaterialDeEstudio($materia["courseid"]);
                                                                    $code_material = "";
                                                                    #echo "ES LA MATERIA: ".$materia['courseid']."<br>";
                                                                    if(($materia['courseid'] == 24 OR $materia['courseid'] == 29 OR $materia['courseid'] == 35 OR $materia['courseid'] == 40) AND $info_user != 1){
                                                                        if($info_user["tipoid"] == 1){
                                                                            #echo "ES EL TIPO DE COLABORADOR: ".$info_user["tipoid"]."<br>";
                                                                            #SI LA MATERIA ES DE COPPEL Y
                                                                            #EXISTEN DATOS DE USUARIO EN LA BASE DE DATOS Y
                                                                            #EL TIPO DE COLABORADOR ES IGUAL A 1
                                                                            #ENTONCES NO SE PONE
                                                                            if($materia['courseid'] == 35){
                                                                                if($info_user["areaid"] == 10){
                                                                                    foreach($datos as $material):
                                                                                        $cadenatexto = $material["name"];
                                                                                        $pdf = "pdf";$doc = "doc"; $ppt = "ppt";
                                                                                        $comparacionpdf = strpos($cadenatexto,$pdf); $comparaciondoc = strpos($cadenatexto,$doc); $comparacionppt = strpos($cadenatexto,$ppt);
                                                                                        if($comparacionpdf	== true){
                                                                                            $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_pdf.jpg' title='Bajar materiales de estudio en PDF' style='margin:1%'></a>";
                                                                                        }
                                                                                        elseif($comparaciondoc == true){
                                                                                            $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_doc.jpg' title='Bajar materiales de estudio en word' style='margin:1%'></a>";
                                                                                        }
                                                                                        elseif($comparacionppt == true){
                                                                                            $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_ppt.jpg' title='Bajar materiales de estudio en Powerpoint' style='margin:1%'></a>";
                                                                                        }
                                                                                        else{
                                                                                            $code_material .= $MaterialEstudio->nombre;
                                                                                        }
                                                                                    endforeach;
                                                                                    if($Materia->VideosDeEstudio2($materia['courseid'])){
                                                                                        //$code_material .= "<a href='".$CFG->wwwroot."/V2/Page.php?course=".$materia['courseid']."'><img src='../archivo_video.jpg' title='Ver vídeos'></a>";
                                                                                    }
                                                                                }
                                                                            }
                                                                            else if($materia['courseid'] == 40){
                                                                                if($info_user["areaid"] == 3 || $info_user["areaid"] == 6 || $info_user["areaid"] == 9){
                                                                                    foreach($datos as $material):
                                                                                        $cadenatexto = $material["name"];
                                                                                        $pdf = "pdf";$doc = "doc"; $ppt = "ppt";
                                                                                        $comparacionpdf = strpos($cadenatexto,$pdf); $comparaciondoc = strpos($cadenatexto,$doc); $comparacionppt = strpos($cadenatexto,$ppt);
                                                                                        if($comparacionpdf	== true){
                                                                                            $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_pdf.jpg' title='Bajar materiales de estudio en PDF' style='margin:1%'></a>";
                                                                                        }
                                                                                        elseif($comparaciondoc == true){
                                                                                            $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_doc.jpg' title='Bajar materiales de estudio en word' style='margin:1%'></a>";
                                                                                        }
                                                                                        elseif($comparacionppt == true){
                                                                                            $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_ppt.jpg' title='Bajar materiales de estudio en Powerpoint' style='margin:1%'></a>";
                                                                                        }
                                                                                        else{
                                                                                            $code_material .= $MaterialEstudio->nombre;
                                                                                        }
                                                                                    endforeach;
                                                                                    if($Materia->VideosDeEstudio2($materia['courseid'])){
                                                                                        //$code_material .= "<a href='".$CFG->wwwroot."/V2/Page.php?course=".$materia['courseid']."'><img src='../archivo_video.jpg' title='Ver vídeos'></a>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        else{
                                                                            foreach($datos as $material):
                                                                                $cadenatexto = $material["name"];
                                                                                $pdf = "pdf";$doc = "doc"; $ppt = "ppt";
                                                                                $comparacionpdf = strpos($cadenatexto,$pdf); $comparaciondoc = strpos($cadenatexto,$doc); $comparacionppt = strpos($cadenatexto,$ppt);
                                                                                if($comparacionpdf	== true){
                                                                                    $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_pdf.jpg' title='Bajar materiales de estudio en PDF' style='margin:1%'></a>";
                                                                                }
                                                                                elseif($comparaciondoc == true){
                                                                                    $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_doc.jpg' title='Bajar materiales de estudio en word' style='margin:1%'></a>";
                                                                                }
                                                                                elseif($comparacionppt == true){
                                                                                    $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_ppt.jpg' title='Bajar materiales de estudio en Powerpoint' style='margin:1%'></a>";
                                                                                }
                                                                                else{
                                                                                    $code_material .= $MaterialEstudio->nombre;
                                                                                }
                                                                            endforeach;
                                                                            if($Materia->VideosDeEstudio2($materia['courseid'])){
                                                                                //$code_material .= "<a href='".$CFG->wwwroot."/V2/Page.php?course=".$materia['courseid']."'><img src='../archivo_video.jpg' title='Ver vídeos'></a>";
                                                                            }
                                                                        }
                                                                    }
                                                                    else{
                                                                        if($materia['courseid'] <= 40){
                                                                            foreach(@$datos as $material):
                                                                                $cadenatexto = $material["name"];
                                                                                $pdf = "pdf";$doc = "doc"; $ppt = "ppt";
                                                                                $comparacionpdf = strpos($cadenatexto,$pdf); $comparaciondoc = strpos($cadenatexto,$doc); $comparacionppt = strpos($cadenatexto,$ppt);
                                                                                if($comparacionpdf	== true){
                                                                                    $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_pdf.jpg' title='Bajar materiales de estudio en PDF' style='margin:1%'></a>";
                                                                                }
                                                                                elseif($comparaciondoc == true){
                                                                                    $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_doc.jpg' title='Bajar materiales de estudio en word' style='margin:1%'></a>";
                                                                                }
                                                                                elseif($comparacionppt == true){
                                                                                    $code_material .= "<a href='".$CFG->wwwroot."/mod/resource/view.php?id=".$material['id']."' ><img src='../archivo_ppt.jpg' title='Bajar materiales de estudio en Powerpoint' style='margin:1%'></a>";
                                                                                }
                                                                                else{
                                                                                    $code_material .= $MaterialEstudio->nombre;
                                                                                }
                                                                            endforeach;
                                                                            if($Materia->VideosDeEstudio2($materia['courseid'])){
                                                                                //$code_material .= "<a href='".$CFG->wwwroot."/V2/Page.php?course=".$materia['courseid']."'><img src='../archivo_video.jpg' title='Ver vídeos'></a>";
                                                                            }
                                                                        }
                                                                    }
                                                                    echo $code_material;
                                                                    #------------------------------------------#
                                                                    ?>
                                                                </center>
                                                            </td>

                                                            <td width="30%">
                                                                <?php
                                                                $rs_secuenciaexamenes = $Examen->ExamenesPorMateria($USER->id,$materia['courseid']);
                                                                while($row = mysqli_fetch_assoc($rs_secuenciaexamenes)):
                                                                    ?>
                                                                    <center>
                                                                        <?php
                                                                        #CODIGO DE BOTONES DE CADA MATERIA
                                                                        if(($materia['courseid'] == 24 OR $materia['courseid'] == 29 OR $materia['courseid'] == 35 OR $materia['courseid'] == 40) AND $info_user != 1){
                                                                            if($info_user["tipoid"] == 1){
                                                                                if($materia['courseid'] == 24){
                                                                                    echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id=983" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                }
                                                                                else if($materia['courseid'] == 29){
                                                                                    echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id=984" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                }
                                                                                else if($materia['courseid'] == 35){
                                                                                    if($info_user["areaid"] == 6){
                                                                                        echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id=986" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                    }
                                                                                    else if($info_user["areaid"] == 7){
                                                                                        echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id=987" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                    }
                                                                                    else if($info_user["areaid"] == 9){
                                                                                        echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id=988" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                    }
                                                                                    else if($info_user["areaid"] == 10){
                                                                                        #CODIGO DE FAMILIAR
                                                                                        if($row['id_tipo'] == 1):
                                                                                            echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                        elseif($row['id_tipo']==2):
                                                                                            echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Examen Final</a>';
                                                                                        elseif($row['id_tipo']==3):
                                                                                            echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Examen Extraordinario</a>';
                                                                                        else:
                                                                                            echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                        endif;
                                                                                    }
                                                                                    else{
                                                                                        echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id=985" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                    }
                                                                                }
                                                                                else if($materia['courseid'] == 40){
                                                                                    if($info_user["areaid"] == 1 || $info_user["areaid"] == 2 || $info_user["areaid"] == 4 || $info_user["areaid"] == 5 || $info_user["areaid"] == 10){
                                                                                        echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id=989" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                    }
                                                                                    else if($info_user["areaid"] == 8){
                                                                                        echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id=990" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                    }
                                                                                    else if($info_user["areaid"] == 7){
                                                                                        echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id=991" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                    }
                                                                                    else{
                                                                                        #CODIGO DE FAMILIAR
                                                                                        if($row['id_tipo'] == 1):
                                                                                            echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen </a>';
                                                                                        elseif($row['id_tipo']==2):
                                                                                            echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Examen Final</a>';
                                                                                        elseif($row['id_tipo']==3):
                                                                                            echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Examen Extraordinario</a>';
                                                                                        else:
                                                                                            echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                        endif;
                                                                                    }
                                                                                }
                                                                                else{
                                                                                    echo '<a href="#" target="_top"><button id="" type="button" class="btn btn-default BotonEnviar"><strong> - - - </strong></button></a>';
                                                                                }
                                                                            }
                                                                            else{
                                                                                #CODIGO DE FAMILIAR
                                                                                if($row['id_tipo'] == 1):
                                                                                    echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                elseif($row['id_tipo']==2):
                                                                                    echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Examen Final</a>';
                                                                                elseif($row['id_tipo']==3):
                                                                                    echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Examen Extraordinario</a>';
                                                                                else:
                                                                                    echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                                endif;
                                                                            }
                                                                        }
                                                                        else{
                                                                            #CODIGO DE FAMILIAR
                                                                            if($row['id_tipo'] == 1):
                                                                                echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                            elseif($row['id_tipo']==2):
                                                                                echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Examen Final</a>';
                                                                            elseif($row['id_tipo']==3):
                                                                                echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Examen Extraordinario</a>';
                                                                            else:
                                                                                echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id='.$row["id"].'" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                            endif;
                                                                        }
                                                                        #------------------------------------------#
                                                                        ?>
                                                                    </center>
                                                                <?php
                                                                endwhile;

                                                                if($materia['courseid'] > 40){
                                                                    echo '<a href="'.$CFG->wwwroot.'/mod/quiz/view.php?id=978" target="_top" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Presentar Examen</a>';
                                                                }
                                                                ?>

                                                            </td>

                                                        </tr>
                                                    <?php
                                                    } #FIN DEL ELSE 1
                                                endforeach;
                                            endif;
                                            ?>
                                        </span>

                                        <!-- Renglones por si existen extraordinarios-->
                                        <span id="wrapper_extraordinarios">
                                        <?php
                                                $result_extraordinarios = $Peticion->SolicitarExtraordinario2($USER->id);

                                        if(empty($result_extraordinarios)){

                                        }else{
                                            foreach($result_extraordinarios as $infoextraordinarios){
                                                $existe_extraordinario = $Peticion->get_exist_peticion_extraordinario($USER->id,$infoextraordinarios->id_materia);
                                                if($existe_extraordinario->total > 0){

                                                        if($existe_extraordinario->estado == 1){
                                                            echo '<tr>
                                                                    <td width="40%" class="text-left">'.$infoextraordinarios->materia.'</td>
                                                                    <td width="30%">

                                                                    </td>
                                                                    <td width="30%">';
                                                                        echo '<center><a href="#"  name="show_message_extraordinario_solicitada" id="'.$infoextraordinarios->id_materia.'"  class="peticiones" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Extraordinario en Proceso</a></center>';
                                                            echo '</td>
                                                                 </tr>';
                                                        }else if($existe_extraordinario->estado == 3){
                                                            echo '<tr>
                                                                    <td width="40%" class="text-left">'.$infoextraordinarios->materia.'</td>
                                                                    <td width="30%">

                                                                    </td>
                                                                    <td width="30%">';
                                                            echo '<a href="#" ><button name="show_message_extraordinario_autorizada" id="'.$infoextraordinarios->id_materia.'" type="button" class="btn btn-default BotonEnviar peticiones" style="background-color: #ececec; border-radius:3px; padding:3px 12px;"><strong>Extraordinario Autorizado</strong></button></a>';
                                                            echo '</td>
                                                    </tr>';

                                                        }else if($existe_extraordinario->estado == 4){

                                                        }else{

                                                        }

                                                }else{
                                                    echo '<tr>
                                                        <td width="40%" class="text-left">'.$infoextraordinarios->materia.'</td>
                                                        <td width="30%">

                                                        </td>
                                                        <td width="30%">';
                                                    echo '<center><a href="#" class="show_autorizacion_extraordinario"  id="'.$USER->id.'" lang="'.$infoextraordinarios->id_materia.'" style="background-color: #ececec; border-radius:3px; padding:3px 12px;"">Solicitar Extraordinario</a></center>';
                                                    include('includes/modals/solicitud_extraordinario.php');

                                                    echo '</td>
                                                    </tr>';
                                                }

                                            }
                                        }

                                        ?>
                                        </span>

                                        <!-- Renglones por si existen peticiones-->
                                        <span id="wrapper_peticiones">
                                        <?php
                                        /*Se pregunta si existe una peticion de dicho usuario y materia de status activo*/
                                        //$check_peticion = $materia->get_exist_peticion($USER->id,$data->id);

                                        $result = $Peticion->get_materias_check_peticion($USER->id);

                                        if(empty($result)){

                                        }else{
                                            foreach($result as $infomateria){
                                                /*Se pregunta si existe una peticion de dicho usuario y materia de status activo*/
                                                $check_peticion = $Peticion->get_exist_peticion($USER->id,$infomateria->id);
                                                if($check_peticion->total >= 1){



                                                    /*Si existe peticion, se verifica el estado de la peticion*/
                                                    $check_estado_peticion = $Peticion->get_estado_peticion($USER->id,$infomateria->id);
                                                    if($check_estado_peticion->id_estado == 1){
                                                        echo '<tr>
                                                        <td width="40%" class="text-left">'.$infomateria->fullname.'</td>
                                                        <td width="30%">

                                                        </td>
                                                        <td width="30%">';

                                                        $posibles_materias = $Peticion->get_numero_materias_posibles_cargar($USER->id);

                                                        echo '<center><a href="#" class="show_autorizacion_carga"  id="'.$USER->id.'" lang="'.$infomateria->id.'" style="background-color: #ececec; border-radius:3px; padding:3px 12px;">Por Autorizar</a></center>';
                                                        include('includes/modals/autorizacion_carga.php');

                                                        echo '
                                                            </td>
                                                        </tr>';


                                                    }


                                                }
                                            }
                                        }


                                        ?>
                                        </span>

                                    </tbody>

                                </table>
                        </div>

                    </div>

                </div> <!-- Termina row -->
            </div> <!-- Container -->



            <!-- Boton de ayuda -->
            <span name="boton_ayuda">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-2 col-xs-push-9 col-sm-2 col-sm-push-10 col-md-2 col-md-push-10 col-lg-2 col-lg-push-10">
                            <?php if($USER->id == 2560): ?>
                                <td height="68" align="right"><a href="<?php echo $CFG->wwwroot.'/ayuda' ?>"><img src="img/ayuda.png" width="176" height="68" /></a></td>
                            <?php else: ?>
                                <td height="68" align="right"><a href="<?php echo $CFG->wwwroot."/ayuda.php?usuario=".$USER->id?>"><img src="img/ayuda.png" width="176" height="68" /></a></td>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </span>

    </section>

</div>


<!-- modales -->
    <span>
        <section id="modales_inicio">
            <?php
            $_SESSION["msj"]='1';
            include('includes/modals/show_biblioteca.php');
            include('includes/modals/show_videoteca.php');

            ?>
        </section>
    </span>

    <!-- Messages -->
    <span>
        <section id="messages_inicio">
            <?php
            $_SESSION["msj"]='1';
            include('includes/messages/success.php');
            include('includes/messages/error.php');
            include('includes/messages/warning.php');
            ?>
        </section>
    </span>

    <script src="controllers/inicio.js"></script>
</body>

</html>


<script>

    $(document).ready(function(){
        //<!-- This is needed for IE -->
        //checar_actualizacion();

        update_bar("Cargando espere un momento.. 100%", 100);
        $("#bar-update").fadeOut("slow", function(){
            if($("#mensaje_control_escolar").length){
                $("#mensaje_control_escolar").fadeIn("slow", function(){
                    $("#ContenidoPrincipal").fadeIn("slow");
                });
            }
            else{
                $("#ContenidoPrincipal").fadeIn("slow");
            }
        });

        //SISTEMAS3
        /*
        $('#boton_biblioteca').on('mouseover',function(){
            $('#btnBiblioteca').tooltip({
                html:true,
                title: 'Página web: https://www.biblionline.pearson.com/<br>Usuario: biblioteca@agcollege.edu.mx<br>Contraseña: agcollege',
                placement:'right',
                trigger:'hover',
                container:'body'
            });
        });
        */
        //SISTEMAS3

        //CODIGO PARA MENSAJE
        //SISTEMAS1
       
       /* $('#myModal-03').modal({
            show: true,
            keyboard: false,
            backdrop: false
        });*/
        

        //update_bar("Cargando espere un momento.. 13%", 13);
        //SISTEMAS1


    });

    function out_modal(){
        $("#myModal-04").modal("hide");
        update_bar("Cargando espere un momento.. 100%", 100);
        $("#bar-update").fadeOut("slow", function(){
            if($("#mensaje_control_escolar").length){
                $("#mensaje_control_escolar").fadeIn("slow", function(){
                    $("#ContenidoPrincipal").fadeIn("slow");
                });
            }
            else{
                $("#ContenidoPrincipal").fadeIn("slow");
            }
        });
    }

    function get_formulario_actualizacion_datos(num){

        if($("#mensaje_control_escolar").length){
            $("#mensaje_control_escolar").slideUp("slow", function(){
                $("#ContenidoPrincipal").slideUp("slow");
            });
        }
        else{
            $("#ContenidoPrincipal").slideUp("slow");
        }

        $("#myModal-04").modal("hide");
        $.ajax({
            beforeSend: function(){
            },
            cache: false,
            async: false,
            type: "POST",
            dataType: "JSON",
            url: "actualizar_data.php",
            data: "option=2&userid="+$("#user").val()+"&colaborador="+num,
            success: function(response){

                update_bar("Cargando espere un momento.. 14%", 14);
                padre = $(window.parent.document);
                update_bar("Cargando espere un momento.. 15%", 15);
                $("#ContenidoPrincipal").fadeOut("fast", function(){
                    update_bar("Cargando espere un momento.. 36%", 36);
                    $(padre).find("#page-footer").fadeOut("fast", function(){
                        //EVENTOS
                        if($("#id_tipo_colaborador").length){
                            $("#id_tipo_colaborador").change(function(){
                                get_code_area($(this).val());
                            });
                        }
                        update_bar("Cargando espere un momento.. 62%", 62);
                        if($("#id_ciudad").length){
                            $("#id_ciudad").change(function(){
                                get_code_region($(this).val());
                            });
                        }
                        update_bar("Cargando espere un momento.. 88%", 88);

                        $('#form_actualizacion').html(response);
                        $('#form_actualizacion').slideDown(response);
                        update_bar("Cargando espere un momento.. 100%", 100);
                        $("#bar-update").fadeOut("slow", function(){
                            if($("#mensaje_control_escolar").length){
                                $("#mensaje_control_escolar").slideUp("slow", function(){
                                    $("#ContenidoPrincipal").slideUp("slow");
                                });
                            }
                            else{
                                $("#ContenidoPrincipal").slideUp("slow");
                            }
                        });
                    });
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert("1001:"+ jqXHR + " :: " + textStatus + " : " + errorThrown);
                close_modal_02();
            }
        });
    }

    function cerrar_mensaje(){
        $("#modal_mensajes").modal("hide");
        update_bar("Cargando espere un momento.. 100%", 100);
        $("#bar-update").fadeOut("slow", function(){
            if($("#mensaje_control_escolar").length){
                $("#mensaje_control_escolar").fadeIn("slow", function(){
                    $("#ContenidoPrincipal").fadeIn("slow");
                });
            }
            else{
                $("#ContenidoPrincipal").fadeIn("slow");
            }
        });
    }

    function get_code_area(num){
        $.ajax({
            beforeSend: function(){
            },
            cache: false,
            async: false,
            type: "POST",

            dataType: "JSON",
            url: "actualizar_data.php",
            data: "option=3&colaborador="+num,
            success:
                function(response){
                    $("#div-area").fadeOut("fast", function(){
                        $("#div-area").html(response);
                        $("#div-area").fadeIn("fast");
                    });
                },
            error:
                function(jqXHR, textStatus, errorThrown){
                    alert("1002:"+ jqXHR + " :: " + textStatus + " : " + errorThrown);
                    close_modal_02();
                }
        });
    }

    function get_code_region(num){
        $.ajax({
            beforeSend: function(){
            },
            cache: false,
            async: false,
            type: "POST",
            dataType: "JSON",
            url: "actualizar_data.php",
            data: "option=7&id_ciudad="+num,
            success: function(response){
                $("#div-region").fadeOut("fast", function(){
                    $("#div-region").html(response);
                    $("#div-region").fadeIn("fast");
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert("1003:"+ jqXHR + " :: " + textStatus + " : " + errorThrown);
            }
        });
    }

    function centro(num){
        var parametros = {"num": num};
        $.ajax({
            data: parametros,
            url: 'buscar_centro.php',
            type: 'POST',
            success: function(response){
                $("#nombre_centro").val(response);
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert("1004:"+ jqXHR + " :: " + textStatus + " : " + errorThrown);
            }
        });
    }

    function send_info(){
        if(validar_form()){
            var parametros = $("#form_update_data").serialize();
            $.ajax({
                data: "option=5&userid="+$("#user").val()+"&"+parametros,
                url: 'actualizar_data.php',
                async: false,
                type: 'POST',
                dataType: "JSON",
                success: function(response){
                    $('#form_actualizacion').html("");
                    $('#form_actualizacion').slideUp("slow", function(){
                        $('#myModal-03').html(response);
                        $('#myModal-03').modal({
                            keyboard: false,
                            backdrop: false
                        });
                        $('#myModal-03').modal("show");
                        close_modal_02();
                    });
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert("1005:"+ jqXHR + " :: " + textStatus + " : " + errorThrown);
                }
            });
        }
    }

    function validar_form(){
        var bandera = false;
        if($("#nombre").val() == ""){
            alert("Debe proporcionar su nombre.");
        }
        else if($("#apellidop").val() == ""){
            alert("Debe proporcionar su apellido paterno.");
        }
        else if($("#id_ciudad").val() == 0){
            alert("Debe seleccionar la ciudad en que vive.");
        }
        else if($("#id_tipo_colaborador").val() == 1 && ($("#id_area").val() == 0 || $("#id_area").val() == "")){
            alert("Debe seleccionar el area en que labora.");
        }
        else if($("#numero_empleado").val() == ""){
            alert("Debe proporcionar su numero de empleado.");
        }
        else if($("#telefono_celular").val() == ""){
            alert("Debe proporcionar un numero de celular con el cual podamos contactarte.");
        }
        else{
            bandera = true;
        }
        return bandera;
    }

    function close_modal_02(){
        padre = $(window.parent.document);
        $(padre).find("#page-header").fadeIn("fast");
    }

    function close_modal_03(){
        $('#form_actualizacion').html("");
        $('#form_actualizacion').slideUp("slow");
        padre = $(window.parent.document);
        $(padre).find("#page-header").fadeIn("fast", function(){
            $(padre).find("#page-footer").fadeIn("fast");
            if($("#mensaje_control_escolar").length){
                $("#mensaje_control_escolar").fadeIn("slow", function(){
                    $("#ContenidoPrincipal").fadeIn("slow");
                });
            }
            else{
                $("#ContenidoPrincipal").fadeIn("slow");
            }
        });
    }

    function checar_actualizacion(){
        update_bar("Cargando espere un momento.. 0%", 0);
        $.ajax({
            type: "POST",
            dataType: "JSON",
            async: false,
            url: "actualizar_data.php",
            data: "option=6&userid="+$("#user").val(),
            success: function(response){
                //response = 2; //QUITAR DESPUES DE NAVIDAD
                update_bar("Cargando espere un momento.. 5%", 5);
                if(response == 1){
                    //NO HACER NADA
                    $("#myModal-04").modal("hide");
                    update_bar("Cargando espere un momento.. 100%", 100);
                    $("#bar-update").fadeOut("slow", function(){
                        if($("#mensaje_control_escolar").length){
                            $("#mensaje_control_escolar").fadeIn("slow", function(){
                                $("#ContenidoPrincipal").fadeIn("slow");
                            });
                        }
                        else{
                            $("#ContenidoPrincipal").fadeIn("slow");
                        }
                    });
                }
                else if(response == 2){
                    get_formulario_actualizacion_datos(response);
                }
                else if(response == 3){
                    update_bar("Cargando espere un momento.. 100%", 100);
                    $("#bar-update").fadeOut("slow", function(){
                        if($("#mensaje_control_escolar").length){
                            $("#mensaje_control_escolar").fadeIn("slow", function(){
                                $("#ContenidoPrincipal").fadeIn("slow");
                            });
                        }
                        else{
                            $("#ContenidoPrincipal").fadeIn("slow");
                        }
                    });
                    alert("Error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                alert("1006:"+ jqXHR + " :: " + textStatus + " : " + errorThrown);
            }
        });
    }

    function update_bar(message, number){
        var bar = $("#progress-bar-update");
        bar.html(message);
    }

    $('#page-header').click(function(){
        alert('hola');
    });
</script>