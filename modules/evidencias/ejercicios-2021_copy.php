<?php
$url = "https://agcollege.edu.mx";
$urlDev = "http://164.90.144.135";
$titulo_escuela = "";
$id_course_moodle = 0;
$unidad = 0;
$id_corporacion = 0;
$id_plan_estudio = 0;

if (
    isset($corporacion) && isset($plan_estudio) &&  isset($_GET['course']) && isset($_GET['unidad']) && is_numeric($_GET['course']) && is_numeric($_GET['unidad']) && is_numeric($plan_estudio)  && is_numeric($corporacion)
) {
    $id_course_moodle = $_GET['course'];
    $unidad = $_GET['unidad'];
    $id_corporacion = $corporacion;
    $id_plan_estudio = $plan_estudio;
}

//echo "USERID: ".$USER->id."";
$id_moodle = $USER->id;
$is_plataforma = "true";
$label_titulo = "Módulo";
if (isset($label_modulos)) {
    $label_titulo = $label_modulos;
}

$ejercicios_hechos = $ejercicios->get_ejercicios_hechos($id_moodle, $id_course_moodle, $unidad, $id_corporacion, $id_plan_estudio);
$nombre_materia = $ejercicios->get_materia_nombre($id_course_moodle);
?>

<?php
if ($id_plan_estudio != 50 && $id_plan_estudio != 22)
    echo '<link  href="', $url, '/cereporte/modules/evidencias/assets/bootstrap/css/bootstrap.min.custom.css" rel="stylesheet">';
?>

<link rel="stylesheet" href="<?php echo $url; ?>/cereporte/modules/evidencias/assets/toastr/toastr.min.css">
<link rel="stylesheet" href="assets/css/font-awesome.css" />
<style>
    .input-group-btn .btn {
        border-radius: 0;
        box-shadow: 0 0 0 0 black;
    }
</style>

<section id="content_ejercicios">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <button type="button" id="btnRubricas" class="btn btn-primary">Rúbricas</button>
                <button type="button" id="btnAPA" class="btn btn-primary">APA</button>

                <!-- <button type="button" id="btnEvaluacion" class="btn btn-success">Parámetros de Evaluación</button> -->
                <div class="container">
                    <div class="row col-12">
                        <table id="tableActividadesTerminadas" class="table table-bordered" style="margin-top: 1rem !important;">
                            <thead>
                                <tr>
                                    <th>ACTIVIDADES REALIZADAS</th>
                                    <th>Comentarios</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <ul id="tabsActividades" class="nav nav-tabs">
                </ul>


                <div id="tabsActividadesContent" class="tab-content">
                    <div id="tab_home" class="tab-pane fade in active">
                        <div class="container-fluid" style="background-position: center; background-repeat:no-repeat;">
                            <div class="row">

                                <div class="col-md-12 text-center">
                                    <h2 id="homeTitleActividades" class="textInicio"></h2>
                                </div>
                                <div class="col-md-12 text-center" style="margin-top: 1rem !important; ">
                                    <h4 id="homeTitleMateria" class="textInicio"></h4>
                                </div>
                                <div class="col-md-12 text-center" style="margin-top: 1rem !important;">
                                    <h4 id="homeTitleEjercicios" class="textInicio" style="margin-top: 1rem !important;"></h4>
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="col-md-offset-2 col-md-8 col-sm-12">
                                    <p>
                                        Realiza todas las Actividades Integradoras para poder presentar el examen del módulo actual.
                                        Cada Actividad Integradora se encuentra en las pestañas de la parte superior.
                                        No olvides <strong>Guardar tu progreso</strong> de cada actividad antes de salir.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODALES -->
<div id="modalDetalle" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detalle Actividad </h4>
            </div>

            <div class="modal-body">
                <div id="modalBody"></div>
                <div class="divider" style="margin-top:3rem !important;"></div>
                <h2 style="text-align: right !important;"><span id="nuCalificacion" class="label label-primary label-lg"></span></h2>

                <div class="panel panel-primary" style="margin-top:3rem !important;">
                    <div class="panel-heading">
                        <h2 class="panel-title"><b>Retroalimentación</b></h2>
                    </div>
                    <div class="panel-body">
                        <div id="listadoRetro" class="list-group"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="modalRubricas" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rúbricas</h4>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-lg-10 col-lg-offset-1">

                        <div class="col-md-12 text-left">
                            <h4><a href="./assets/files/rubricas/Rubricas MDN-Coppel_Rubrica_materia_cualitativas_PHS-min.jpg" target="_blank" download>
                                    <img src="./assets/icons/pdf-16.png" style="width: 16px;"> Rúbrica de materias cualitativas
                                </a></h4>
                            <h4><a href="./assets/files/rubricas/Rubricas MDN-Coppel_Rubrica_materia_cuantitativas_PHS-min.jpg" target="_blank" download>
                                    <img src="./assets/icons/pdf-16.png" style="width: 16px;"> Rúbrica de materias cuantitativas
                                </a></h4>
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

<div id="modalAPA" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">APA</h4>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-lg-10 col-lg-offset-1">

                        <div class="col-md-12 text-left">
                            <h4><a href="./assets/files/Formato_APA.pdf" target="_blank">
                                    <img src="./assets/icons/word-16.png" style="width: 16px;"> APA
                                </a></h4>
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


<div id="modalEvaluacion" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Parámetros de Evaluación</h4>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-lg-12">

                        <table class="table table-bordered" border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0 gridlines">

                            <tbody>
                                <tr class="row0">
                                    <td class="column0 style31 s style32 align-middle bg-g text-center" rowspan="2"><b>ELEMENTOS DEL FORMATO</b></td>
                                    <td class="column1 style33 s style35 bg-g text-center " colspan="6"><b>TIPOS DE FORMATO</b></td>
                                </tr>
                                <tr class="row1">
                                    <td class="column1 style23 s" class="text-center">
                                        <!-- <a href="files/rubricas/Ensayo.docx" target="_blank">Ensayo</a> -->
                                        <span>Ensayo</span>
                                    </td>
                                    <td class="column2 style23 s" class="text-center">
                                        <!-- <a href="files/rubricas/Resumen.docx" target="_blank">Resumen</a> -->
                                        <span>Resumen</span>
                                    </td>
                                    <td class="column3 style23 s" class="text-center">
                                        <!-- <a href="files/rubricas/Proyecto_final.docx"" target="_blank">Proyecto final</a> -->
                                        <span>Proyecto final</span>
                                    </td>
                                    <td class="column4 style23 s" class="text-center">
                                        <!-- <a href="files/rubricas/Mapa_mental.docx" target="_blank">Mapa mental</a> -->
                                        <span>Mapa mental</span>
                                    </td>
                                    <td class="column5 style23 s" class="text-center">
                                        <!-- <a href="files/rubricas/Cuadro_Sinoptico.docx" target="_blank">Cuadro sinóptico</a> -->
                                        <span>Cuadro sinóptico</span>
                                    </td>
                                    <td class="column6 style23 s" class="text-center">
                                        <!-- <a href="files/rubricas/Mapa_conceptual.docx" target="_blank">Mapa conceptual</a> -->
                                        <span>Mapa conceptual</span>
                                    </td>
                                </tr>
                                <tr class="row2">
                                    <td class="column0 style16 s"><span style="font-weight:bold;  font-size:11pt">Portada</span><span style=" font-size:11pt"> (Nombre del curso, nombre del alumno, módulo, actividad, unidad, fecha)</span></td>
                                    <td class="column1 style10 s">0.5 Pts.</td>
                                    <td class="column2 style10 s">0.5 Pts.</td>
                                    <td class="column3 style10 s">0.5 Pts.</td>
                                    <td class="column4 style10 s">0.5 Pts.</td>
                                    <td class="column5 style8 s">0.5 Pts.</td>
                                    <td class="column6 style8 s">0.5 Pts.</td>
                                </tr>
                                <tr class="row3">
                                    <td class="column0 style7 s">Encabezado <span style=" font-size:11pt">(Título del texto, contemplar al autor, editorial y libro del que se saca)</span></td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style10 s">1 Pts.</td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style11 bg-g"></td>
                                    <td class="column5 style9 bg-g"></td>
                                    <td class="column6 style9 bg-g"></td>
                                </tr>
                                <tr class="row4">
                                    <td class="column0 style4 s">Introducción <span style=" font-size:11pt">(antecedentes, problemática, justificación y objetivos)</span></td>
                                    <td class="column1 style10 s">1 Pts.</td>
                                    <td class="column2 style10 s">1.5 Pts.</td>
                                    <td class="column3 style10 s">2 Pts</td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>
                                </tr>
                                <tr class="row5">
                                    <td class="column0 style4 s">Índice</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style10 s">1 Pts.</td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>
                                </tr>
                                <tr class="row6">
                                    <td class="column0 style4 s">Cuerpo o desarrollo</td>
                                    <td class="column1 style10 s">6 Pts.</td>
                                    <td class="column2 style10 s">5 Pts.</td>
                                    <td class="column3 style10 s">3 Pts.</td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>
                                </tr>
                                <tr class="row7">
                                    <td class="column0 style4 s">Marco teórico</td>
                                    <td class="column1 style12 bg-g"></td>
                                    <td class="column2 style12 bg-g"></td>
                                    <td class="column3 style13 s">1 Pts.</td>
                                    <td class="column4 style19 bg-g"></td>
                                    <td class="column5 style20 bg-g"></td>
                                    <td class="column6 style20 bg-g"></td>

                                </tr>
                                <tr class="row8">
                                    <td class="column0 style6 s">Idea central</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style10 s">2 Pts.</td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>

                                </tr>
                                <tr class="row9">
                                    <td class="column0 style6 s">Ramas</td>
                                    <td class="column1 style17 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style10 s">1.5 Pts.</td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>

                                </tr>
                                <tr class="row10">
                                    <td class="column0 style6 s">Palabras clave</td>
                                    <td class="column1 style17 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style10 s">1.5 Pts.</td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>

                                </tr>
                                <tr class="row11">
                                    <td class="column0 style4 s">Imágenes, dibujos</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style10 s">1 Pts.</td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>

                                </tr>
                                <tr class="row12">
                                    <td class="column0 style4 s">Relaciones</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style10 s">1 Pts.</td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>

                                </tr>
                                <tr class="row13">
                                    <td class="column0 style4 s">Nubes</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style10 s">1 Pts.</td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>

                                </tr>
                                <tr class="row14">
                                    <td class="column0 style4 s">Adjuntos, notas y referencias</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style10 s">1.5 Pts.</td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>

                                </tr>
                                <tr class="row15">
                                    <td class="column0 style4 s">Idema General (tema)</td>
                                    <td class="column1 style12 bg-g"></td>
                                    <td class="column2 style12 bg-g"></td>
                                    <td class="column3 style12 bg-g"></td>
                                    <td class="column4 style12 bg-g"></td>
                                    <td class="column5 style22 s">2 Pts.</td>
                                    <td class="column6 style18 bg-g"></td>
                                </tr>
                                <tr class="row16">
                                    <td class="column0 style4 s">Idea Principal</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style11 bg-g"></td>
                                    <td class="column5 style8 s">2 Pts.</td>
                                    <td class="column6 style18 bg-g"></td>
                                </tr>
                                <tr class="row17">
                                    <td class="column0 style4 s">Ideas complementarias</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style11 bg-g"></td>
                                    <td class="column5 style8 s">2 Pts.</td>
                                    <td class="column6 style18 bg-g"></td>
                                </tr>
                                <tr class="row18">
                                    <td class="column0 style4 s">Detalles</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style11 bg-g"></td>
                                    <td class="column5 style8 s">2 Pts.</td>
                                    <td class="column6 style18 bg-g"></td>
                                </tr>
                                <tr class="row19">
                                    <td class="column0 style4 s">Conclusión</td>
                                    <td class="column1 style10 s">1.5 Pts.</td>
                                    <td class="column2 style10 s">1 Pts.</td>
                                    <td class="column3 style10 s">1 Pts.</td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style8 s">1.5 Pts.</td>
                                    <td class="column6 style18 bg-g"></td>
                                </tr>
                                <tr class="row20">
                                    <td class="column0 style4 s">Recomendaciones</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style10 s">1 Pts.</td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style18 bg-g"></td>
                                </tr>
                                <tr class="row21">
                                    <td class="column0 style4 s">Conceptos</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style8 s">1 Pts.</td>
                                </tr>
                                <tr class="row22">
                                    <td class="column0 style4 s">Palabras enlace</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style8 s">0.5 Pts.</td>
                                </tr>
                                <tr class="row23">
                                    <td class="column0 style4 s">Proposiciones</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style8 s">1 Pts.</td>
                                </tr>
                                <tr class="row24">
                                    <td class="column0 style4 s">Otros elementos</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style8 s">0.5 Pts.</td>
                                </tr>
                                <tr class="row25">
                                    <td class="column0 style4 s">Jerarquización</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style8 s">1.5 Pts.</td>
                                </tr>
                                <tr class="row26">
                                    <td class="column0 style4 s">Selección</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style8 s">1 Pts.</td>
                                </tr>
                                <tr class="row27">
                                    <td class="column0 style4 s">Impacto visual</td>
                                    <td class="column1 style11 bg-g"></td>
                                    <td class="column2 style11 bg-g"></td>
                                    <td class="column3 style11 bg-g"></td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style8 s">2 Pts.</td>
                                </tr>
                                <tr class="row28">
                                    <td class="column0 style4 s">Bibliografía (APA)</td>
                                    <td class="column1 style10 s">1 Pts.</td>
                                    <td class="column2 style10 s">1 Pts.</td>
                                    <td class="column3 style10 s">0.5 Pts.</td>
                                    <td class="column4 style17 bg-g"></td>
                                    <td class="column5 style18 bg-g"></td>
                                    <td class="column6 style8 s">2 Pts.</td>
                                </tr>
                                <tr class="row29">
                                    <td class="column0 style4 s">Ortografía y redacción (ausencia)</td>
                                    <td class="column1 style28 s">-1 Pts. Sobre calificación </td>
                                    <td class="column2 style28 s">-1 Pts. Sobre calificación </td>
                                    <td class="column3 style28 s">-1 Pts. Sobre calificación </td>
                                    <td class="column4 style28 s">-1 Pts. Sobre calificación </td>
                                    <td class="column5 style28 s">-1 Pts. Sobre calificación </td>
                                    <td class="column6 style28 s">-1 Pts. Sobre calificación </td>
                                </tr>

                            </tbody>

                        </table>


                        <p>Como parte de tu formación profesional, es importante que sepas que para todas las organizaciones es fundamental contar con recurso humano <span style="font-weight:bold;">capaz, honesto, comprometido, propositivo,</span><span> etcétera. Es por ello que consideramos necesario informarte de </span><span style="font-weight:bold;">la importancia de saber reportar</span><span> en cualquier esquema de trabajo o tarea que desarrolles, </span><span style="font-weight:bold;">las fuentes de las que obtuviste información </span><span>para realizar tus actividades, proyectos y demás. Para que comprendas mejor de lo que estamos hablando, te indicamos las siguientes reglas:</span>
                        </p>

                        <br><br>

                        <p>1.- Toda actividad, independientemente del formato en la que la presentes, <span style="font-weight:bold; ">debe incluir referencias bibliográficas en </span><a href="./assets/files/rubricas/APA_6ta_edicion.pdf" target="_blank"><b>formato APA </b></a>

                        <p>2.-Es muy importante cuidar la ortografía y redacción de tus tareas y respuestas en foros, pues en todos los casos tendrán valor en cualquiera de las actividades que presentes.</p>

                        <p>3.- La ausencia del reporte y referencia textual de la bibliografía que utilizaste para elaborar cualquier actividad, se considera como Deshonestidad Académica y se califica con Cero.</p>

                        <p>4.- La réplica de tareas en cualquier caso, será evalulada como Deshonestidad Académica.</p>
                        <p>5.- La réplica de respuestas en foros será considerada como Deshonestidad Académica.</p>
                        <p>6.-Las respuestas de los foros deben estar basadas en tu propio aprendizaje y de manera constructiva, desarrollar una respuesta que aporte valor a todos los participantes, si consideras que es importante citar algún párrafo o frase de alguna bibliografía, es importante tomar en cuenta que esto debe hacerse: <span style="font-weight:bold;">entrecomillando dicha frase o párrafo</span><span> </span><span style="text-decoration:underline;">e inmediatamente después, colocar la referencia del autor y fuente</span><span style=font-size:12pt"> de la que se obtuvo tal referencia; te pedimos evitar el uso excesivo de referencias, de lo contrario la aportación será inválida.</span></p>

                        <p>7.-La transcripción de documentos alojados en la web pueden servir como consulta y se debe hacer el reporte como referencia APA, sin embargo, no son válidos si son transcritos y tomados como propios, esto se califica como Deshonestidad Académica.</p>

                        <br><br>

                        <!-- <p>Para estar más informado, te recomendamos leer este artículo disponible en internet a cerca de la deshonestidad académica: 
                        <a href="https://tecreview.tec.mx/que-es-y-como-evitar-la-deshonestidad-academica/" target="_blank">https://tecreview.tec.mx/que-es-y-como-evitar-la-deshonestidad-academica/</a>
                    </p> -->
                    </div>

                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="modalConfirmarFinalizar" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-primary"><b>Finalizar actividad integradora</b></h3>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center">
                        <!--<p><h3><span id="lbl_leyenda_finalizar" class="label label-primary"></span></h3></p>-->
                        <p>
                        <h4 id="lbl_leyenda_finalizar"></h4>
                        </p>
                        <input type="hidden" id="nuActividadPosition" name="nuActividadPosition" />
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btn_modalfinalizaractividadCerrar">Cerrar</button>
                <button type="button" class="btn btn-success" id="btn_modalfinalizaractividad">Finalizar</button>
            </div>
        </div>
    </div>
</div>

<!-- INPUTS HIDDEN -->
<input type="hidden" id="id_alumno_moodle" name="id_alumno_moodle" value="<?php echo $idmoodle_alumno; ?>" />
<input type="hidden" id="id_plan_estudio" name="id_plan_estudio" value="<?php echo $id_plan_estudio; ?>" />
<input type="hidden" id="id_corporacion" name="id_corporacion" value="<?php echo $id_corporacion; ?>" />
<input type="hidden" id="id_course" name="id_course" value="<?php echo $id_course_moodle; ?>" />
<input type="hidden" id="id_unidad" name="id_unidad" value="<?php echo $unidad ?>" />

<!-- Scripts -->
<script type="text/javascript">
    <?php
    echo "
            let id_plan_estudio=", $id_plan_estudio, ";
            let id_corporacion=", $id_corporacion, "; 
            let is_plataforma=", $is_plataforma, ";
            let course=", $id_course_moodle, ";
            let unidad=", $unidad, ";
            let id_moodle=", $id_moodle, ";
        ";
    ?>
</script>

<script src="<?php echo $url; ?>/cereporte/modules/evidencias/assets/js/jquery.min.js"></script>
<script src="<?php echo $url; ?>/cereporte/modules/evidencias/ckeditor/ckeditor.js"></script>
<!-- <script src="<?php #echo $url; 
                    ?>/cereporte/modules/evidencias/controllers/evidencias-2021.js"></script> -->

<script src="<?php echo $url; ?>/cereporte/modules/evidencias/assets/toastr/toastr.min.js" type="text/javascript"></script>
<script src="<?php echo $url; ?>/cereporte/modules/evidencias/assets/toastr/notificacionesToast.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo $url; ?>/cereporte/modules/evidencias/assets/js/funcionesGlobales.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>/cereporte/modules/evidencias/assets/js/uploadFileActividadesIntegradoras.js?v=2"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var toast = new notificacionesToast();
        var arrayTabs = new Array();

        function get_browser() {
            var ua = navigator.userAgent,
                tem, M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
            if (/trident/i.test(M[1])) {
                tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
                return {
                    name: 'IE',
                    version: (tem[1] || '')
                };
            }
            if (M[1] === 'Chrome') {
                tem = ua.match(/\bOPR|Edge\/(\d+)/)
                if (tem != null) {
                    return {
                        name: 'Opera',
                        version: tem[1]
                    };
                }
            }
            M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
            if ((tem = ua.match(/version\/(\d+)/i)) != null) {
                M.splice(1, 1, tem[1]);
            }
            return {
                name: M[0],
                version: M[1]
            };
        }

        $("#btnRubricas").on('click', function() {
            $('#modalRubricas').modal({
                keyboard: false,
                backdrop: 'static'
            });
        });

        $("#btnAPA").on('click', function() {
            $('#modalAPA').modal({
                keyboard: false,
                backdrop: 'static'
            });
        });

        $("#btnEvaluacion").on('click', function() {
            $('#modalEvaluacion').modal({
                keyboard: false,
                backdrop: 'static'
            });
        });

        $("#btn_modalfinalizaractividadCerrar").on('click', function() {
            $("#modalConfirmarFinalizar").attr('isOk', 0);
            $("#modalConfirmarFinalizar").modal('hide');
        });

        $("#btn_modalfinalizaractividad").on('click', function() {
            $("#modalConfirmarFinalizar").attr('isOk', 1);
            $("#modalConfirmarFinalizar").modal('hide');
        });

        function initUI() {
            $("#modalConfirmarFinalizar").on('hidden.bs.modal', function(e) {
                var isOk = $("#modalConfirmarFinalizar").attr('isOk');

                if (isOk == 1) {
                    finishActividadIntegradora(parseInt($("#nuActividadPosition").val()));
                }
            });

            getActividadesIntegradoras();
        }

        function getActividadesIntegradoras() {
            var formData = new FormData();
            formData.append('a', 'getActividadesIntegradoras');
            formData.append('id_alumno_moodle', $("#id_alumno_moodle").val());
            formData.append('id_plan_estudio', $("#id_plan_estudio").val());
            formData.append('id_corporacion', $("#id_corporacion").val());
            formData.append('id_course', $("#id_course").val());
            formData.append('id_unidad', $("#id_unidad").val());

            $.ajax({
                url: 'functions/routes.php',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'post',
                crossDomain: true,
                headers: {
                    'Access-Control-Allow-Origin': '*'
                },
                beforeSend: function() {
                    $('.loading').show();
                },
                complete: function() {
                    $('.loading').hide();
                },
                success: function(response) {
                    if (response.success) {
                        loadActividadesTerminadas(response.data.actividadesTerminadas);
                        loadActividadesActuales(response.data.actividadesActuales);
                        loadActividadesRetrazadas(response.data.actividadesRechazadas);
                    } else {
                        toast.error(response.title, response.msje);
                    }
                },
                error: function(response) {
                    toast.error('Error al obtener las actividades integradoras', 'Favor de contactar al Centro de Atención y Servicios al Alumno1');
                    console.log(response, response.responseText);
                }
            });
        }

        function loadActividadesTerminadas(data) {
            for (var i = 0; i < data.length; i++) {
                let _item = data[i];
                var _button = $('<button type="button" class="btn btn-primary btn-xs">Ver detalle</button>');
                _button.on('click', function() {
                    verDetalleActividad(_item.actividades.intro,
                        _item.actividades.content,
                        _item.actividades.de_respuesta_alumno,
                        _item.actividades.nu_calificacion,
                        isNull('array', _item.comentarios) ? [] : _item.comentarios);
                });

                var _tdButton = $('<td/>');
                _tdButton.append(_button);

                var tr = $('<tr/>');
                tr.append('<td>' + _item.actividades.name + '</td>');
                tr.append(_tdButton);

                $("#tableActividadesTerminadas > tbody").append(tr);
            }
        }

        function loadActividadesRetrazadas(data) {
            for (var i = 0; i < data.length; i++) {
                let _item = data[i];
                var _button = $('<button type="button" class="btn btn-primary btn-xs">Ver detalle</button>');
                _button.on('click', function() {
                    verDetalleActividad(_item.actividades.intro,
                        _item.actividades.content,
                        _item.actividades.de_respuesta_alumno,
                        _item.actividades.nu_calificacion,
                        isNull('array', _item.comentarios) ? [] : _item.comentarios);
                });

                var _tdButton = $('<td/>');
                _tdButton.append(_button);

                var tr = $('<tr/>');
                tr.append('<td>' + _item.actividades.name + '</td>');
                tr.append(_tdButton);

                $("#tableActividadesRetrazadas > tbody").append(tr);
            }
        }

        async function loadActividadesActuales(dataParam) {
            console.log(dataParam);
            let formData = new FormData();
            
            formData.append('a','checkFailedStudent');
            formData.append('idmoodle_alumno',dataParam[0].idmoodle_alumno);
            formData.append('idmoodle_materia',dataParam[0].idmoodle_materia);
            
            let data;
            
            let result = await send_fetch(formData);
            
            console.log('result',result.data[0]);
            
            let registro_calificacion =  result.data[0];
            
            if (
                registro_calificacion === undefined || 
                registro_calificacion.calificacion >= 8 || 
                registro_calificacion.carga_materia == 1
            ) {
                data = dataParam.filter((item) =>item.tipo == 1);
            }else{
                data = dataParam;
            }
            
            console.log(data);
            debugger
            // if (registro_calificacion.calificacion === undefined || registro_calificacion.calificacion >= 8) {
            //     data = dataParam.Filter((item) => {
            //         item.section != 9
            //         console.log(item);
            //     });
                
            // }else{
            //     data = dataParam;
            // }
            
            console.log('data', data);
            
            var nu_actividades_terminadas = 0;
            nuModulo = parseInt($("#id_unidad").val()) + 1;

            $("#homeTitleActividades").text((data.length > 1 ? 'Actividades Integradoras Módulo ' : 'Actividad Integradora Módulo ') + nuModulo);
            $("#homeTitleMateria").text(data[0].nb_materia);
            var tabs = $("#tabsActividades");

            //TAB HOME
            var liHome = $('<li class="active"><a data-toggle="tab" class="tabSelected" href="#tab_home">Inicio</a></li>');
            liHome.on('click', function() {
                $("#tabsActividades li").find('a').removeClass('tabSelected');
                $("#tabsActividades li").find('a').addClass('tabNotSelected');

                $(this).find('a').removeClass('tabNotSelected');
                $(this).find('a').addClass('tabSelected');

                $("#tab_home").tab('show');
            });
            tabs.append(liHome);

            //TABS ACTIVIDADES
            //var _arrayPluginFiles = new Array(data.length);
            for (var i = 0; i < data.length; i++) {
                //TABS
                let _item = data[i];
                let _position = i;
                let _id_tab = 'tab_act_';

                var liTag = $('<li><a data-toggle="tab" href="#' + _id_tab + _position + '" class="tabNotSelected">Actividad ' + (_position + 1) + ' </a></li>');
                liTag.on('click', function() {
                    $("#tabsActividades li").find('a').removeClass('tabSelected');
                    $("#tabsActividades li").find('a').addClass('tabNotSelected');

                    $(this).find('a').removeClass('tabNotSelected');
                    $(this).find('a').addClass('tabSelected');

                    $("#" + _id_tab + _position).tab('show');
                });
                tabs.append(liTag);

                //TABS CONTENT
                createTabContent(_item, _position, _id_tab, nuModulo);

                //EXTRAS
                if (_item.estatus == 1) {
                    nu_actividades_terminadas = nu_actividades_terminadas + 1;
                }
            }

            if (nu_actividades_terminadas == data.length) {
                $("#homeTitleEjercicios").text('Sin Actividades Integradoras a realizar.');
            } else {
                $("#homeTitleEjercicios").text('Realizadas ' + nu_actividades_terminadas + ' de ' + data.length);
            }
        }

        function createTabContent(item, position, id_tab, nu_modulo) {
            var contentTag = $('<div class="container-fluid"/>');

            contentTag.append('<div class="row"><div class="col-md-12 text-center"><h3 class="homeTitleActividades">Actividad integradora ' +
                (position + 1) + ' unidad ' + nu_modulo + '</h3></div></div>');

            contentTag.append($('<div class="row"></div>').append($('<div class="col-md-12 text-left" style="margin-top:1rem !important;"><p>Descripción:</p></div>').append(item.content)));

            var _rowButtons = $('<div class="row" style="margin-top: 2rem !important;"></div>');
            var buttonSave = $('<button class="btn btn-primary pull-right" type="button" id="btn_save_' + position + '">Guardar Progreso</button>');
            var buttonFinish = $('<button class="btn btn-success pull-right" type="button" id="btn_save_finish_' + position + '">Finalizar Actividad</button>');
            let buttonChangeStatus = $('<button class="btn btn-primary pull-right" type="button" id="btn_change_status' + position + '">Modificar</button>');

            buttonChangeStatus.on('click', function() {
                changeActividadIntegradoraEstatus(position);
            });

            buttonSave.on('click', function() {
                saveActividadIntegradora(position);
            });

            buttonFinish.on('click', function() {
                var htmlActividad = 'No aplica';
                let fileInput = $.trim($('#inputFileUploadTemplate_actividadesintegradoas_' + position).val());

                if (fileInput == "Seleccionar archivo(s)")
                    toast.error('Actividad integradora incompleta', 'Es necesario subir un archivo antes de continuar.');
                else if (arrayTabs[position].uploadFiles.serverFiles.length == 0)
                    toast.error('Actividad integradora incompleta', 'Es necesario subir un archivo antes de continuar.');
                else {
                    $("#lbl_leyenda_finalizar").text('¿Deseas finalizar la actividad integradora ' + (position + 1) + '?');
                    $("#nuActividadPosition").val(position);

                    $('#modalConfirmarFinalizar').modal({
                        keyboard: false,
                        backdrop: 'static'
                    });
                }
            });

            _rowButtons.append('<div class="col-md-12"><p class="text-left">Adjunta tu evidencia de actividad integradora:</p></div><div class="col-md-8 pull-left"><div id="divFilesUploadAlumnos_' + position + '"></div></div>');
            if (item.estatus == 1) {
                if (item.nu_calificacion == "--")
                    _rowButtons.append($('<div class="col-md-4 pull-right" id="div_actividad_estatus"></div>').append(buttonChangeStatus));
                else
                    _rowButtons.append($('<div class="col-md-4 pull-right"></div>').append('<label id="label_finish_' + position + '" class="label label-success pull-right" style="display: none; font-size: 20px !important;">ACTIVIDAD REALIZADA</span></label>'));
            }
            _rowButtons.append($('<div class="col-md-2 pull-right"></div>').append(buttonFinish));
            _rowButtons.append($('<div class="col-md-2 pull-right"></div>').append(buttonSave));
            contentTag.append(_rowButtons);

            // contentTag.append('<div id="rowEditorTextoDisabled_' + position + '" class="row" style="margin-top:2rem !important; display: none;"><div class="col-md-12"><div class="panel panel-default"><div class="panel-body"><p id="ejercicio_contenido_disabled_' + position + '"></p></div></div></div></div>');

            contentParent = $('<div id="' + id_tab + position + '" class="tab-pane fade"></div>');
            contentParent.append($('<div class="container-fluid"></div>').prepend($('<div class="row"></div>').prepend(contentTag)));
            $("#tabsActividadesContent").append(contentParent);

            //CREAMOS PLUGINS UPLOAD FILE Y EDITOR DE TEXTO
            setTimeout(function() {
                //PLUGIN
                var plugin_uploadFiles = new uploadFileActividadesIntegradoras('divFilesUploadAlumnos_' + position,
                    'actividadesintegradoas_' + position,
                    $('#id_plan_estudio').val(),
                    $('#id_unidad').val(),
                    $('#id_course').val(),
                    $('#id_alumno_moodle').val(),
                    position,
                    (position + 1));

                //REVISAMOS SI HAY ARCHIVOS
                var _arrayFiles = [];
                if (!isNull('array', item.files)) {
                    for (var i = 0; i < item.files.length; i++) {
                        var obj = {
                            extension: item.files[i].ext_archivo,
                            name: item.files[i].nb_archivo,
                            path: item.files[i].url_archivo,
                            size: item.files[i].nu_size,
                            snDelete: false,
                            snSave: true
                        };

                        _arrayFiles.push(obj);
                    }
                }

                //plugin_uploadFiles.setExtensiones('png');
                //plugin_uploadFiles.setMethodChange(updateDataFileUpload);
                plugin_uploadFiles.setFiles(_arrayFiles);
                plugin_uploadFiles.createTemplate();

                arrayTabs.push({
                    id_ejercicio: item.id_ejercicio,
                    id_ejercicio_moodle: item.id_ejercicio_moodle,
                    id_materia_escolar: item.id_materia_escolar,
                    id_alumno_escolar: item.id_alumno_escolar,
                    uploadFiles: plugin_uploadFiles
                });

                //REVISAMOS SI LA ACTIVIDAD ESTA FINALIZADA O NO

                if (item.estatus == 0) {
                    var snDisabled = _arrayFiles.length > 0 ? false : true;

                    plugin_uploadFiles.setDisableButton(1, false);
                    plugin_uploadFiles.setDisableButton(2, snDisabled);
                    plugin_uploadFiles.setDisableButton(3, snDisabled);
                    plugin_uploadFiles.setDisableButton(4, snDisabled);

                    if (isNull('string', item.id_ejercicio)) buttonFinish.prop('disabled', true);
                } else {
                    plugin_uploadFiles.setDisableButton(1, true);
                    plugin_uploadFiles.setDisableButton(2, true);
                    plugin_uploadFiles.setDisableButton(3, true);
                    plugin_uploadFiles.setDisableButton(4, false);

                    disabledActividad(position, item.contenido);
                }
            }, 100);
        }

        function verDetalleActividad(intro, content, respuesta, nuCalificacion, comentarios) {
            var b = $('<b/>');
            b.append(content);

            $("#modalBody").empty();
            $("#listadoRetro").empty();
            $("#modalBody").append(b);
            $("#modalBody").append(respuesta);
            $("#nuCalificacion").text(nuCalificacion);

            for (var i = 0; i < comentarios.length; i++) {
                var divItem = $('<div class="list-group-item"/>');

                if (isNaN(comentarios[i].id_tutor)) {
                    divItem.append('<h4 class="list-group-item-heading text-danger" style="text-align: right !important;"><b>Alumno</b></h4>');
                    divItem.append('<p class="list-group-item-text" style="text-align: left !important;">' + comentarios[i].de_comentario + '</p>');
                } else {
                    divItem.append('<h4 class="list-group-item-heading text-primary"><b>Tutor</b></h4>');
                    divItem.append('<p class="list-group-item-text">' + comentarios[i].de_comentario + '</p>');
                }

                $("#listadoRetro").append(divItem);
            }

            $('#modalDetalle').modal({
                keyboard: false
            });
        }

        function saveActividadIntegradora(position) {
            if (validateForReapeatFiles(position)) {
                toast.error('Error de archivos', 'Hay uno o más archivos repetidos en la actividad, favor de volver a intentar.');
                return;
            }

            var htmlActividad = 'No aplica';

            var formData = new FormData();
            formData.append('a', 'saveActividadesIntegradoras');
            formData.append('id_alumno_moodle', $("#id_alumno_moodle").val());
            formData.append('id_unidad', $("#id_unidad").val());
            formData.append('id_corporacion', $("#id_corporacion").val());
            formData.append('id_materia_moodle', $("#id_course").val());
            formData.append('id_plan_estudio', $("#id_plan_estudio").val());
            formData.append('id_alumno_escolar', arrayTabs[position].id_alumno_escolar);
            formData.append('id_materia_escolar', arrayTabs[position].id_materia_escolar);
            formData.append('id_ejercicio_escolar', arrayTabs[position].id_ejercicio);
            formData.append('id_ejercicio_moodle', arrayTabs[position].id_ejercicio_moodle);
            formData.append('nu_actividad', (position + 1));
            formData.append('files', JSON.stringify(arrayTabs[position].uploadFiles.getFiles()));
            formData.append('contenido', htmlActividad);

            const browser = get_browser();
            formData.append('ultimo_navegador', `${browser.name} ${browser.version}`);

            $.ajax({
                url: 'functions/routes.php',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'post',
                beforeSend: function() {
                    $('.loading').show();
                },
                complete: function() {
                    $('.loading').hide();
                },
                success: function(response) {
                    if (response.success) {
                        updateFilesAfterSave(position, response.data[0]);
                        $("#btn_save_finish_" + position).prop('disabled', false);
                        toast.success('Guardado', 'El progreso se guardó exitosamente');
                    } else {
                        toast.error('ERROR', response.responseText);
                        console.log(response)
                    }
                },
                error: function(response) {
                    toast.error('error', response.responseText);
                    console.log(response)
                }
            });
        }

        function updateFilesAfterSave(position, data) {
            arrayTabs[position].id_ejercicio = data.id_ejercicio;
            arrayTabs[position].uploadFiles.setFiles(data.files);
        }

        function finishActividadIntegradora(position) {
            if (validateForReapeatFiles(position)) {
                toast.error('Error de archivos', 'Hay uno o más archivos repetidos en la actividad, favor de volver a intentar.');
                return;
            }

            var nuActividad = (position + 1);
            var htmlActividad = 'No aplica';

            if (arrayTabs[position].uploadFiles.serverFiles.length == 0) toast.error('Actividad integradora incompleta', 'Es necesario subir un archivo antes de continuar.');

            var formData = new FormData();
            formData.append('a', 'finishActividadesIntegradoras');
            formData.append('id_alumno_moodle', $("#id_alumno_moodle").val());
            formData.append('id_unidad', $("#id_unidad").val());
            formData.append('id_corporacion', $("#id_corporacion").val());
            formData.append('id_materia_moodle', $("#id_course").val());
            formData.append('id_plan_estudio', $("#id_plan_estudio").val());
            formData.append('id_alumno_escolar', arrayTabs[position].id_alumno_escolar);
            formData.append('id_materia_escolar', arrayTabs[position].id_materia_escolar);
            formData.append('id_ejercicio_escolar', arrayTabs[position].id_ejercicio);
            formData.append('id_ejercicio_moodle', arrayTabs[position].id_ejercicio_moodle);
            formData.append('nu_actividad', nuActividad);
            formData.append('files', JSON.stringify(arrayTabs[position].uploadFiles.getFiles()));
            formData.append('contenido', htmlActividad);

            const browser = get_browser();
            formData.append('ultimo_navegador', `${browser.name} ${browser.version}`);

            $.ajax({
                url: 'functions/routes.php',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'post',
                beforeSend: function() {
                    $('.loading').show();
                },
                complete: function() {
                    $('.loading').hide();
                },
                success: function(response) {
                    console.log(response)
                    if (response.success) {
                        toast.success('Actividad integradora finalizada', 'La actividad integradora ' + nuActividad + ' a finalizado correctamente');
                        disabledActividad(position, htmlActividad);
                        updateFilesAfterSave(position, response.data[0]);
                        location.reload();
                    } else {
                        toast.error(response.title, response.msje);
                    }
                },
                error: function(response) {
                    // toast.error('Error al obtener las actividades integradoras', 'Favor de contactar al Centro de Atención y Servicios al Alumno3');
                    toast.error(response.title, response.responseText);
                    // console.log(response.responseText);
                    console.log(response)
                }
            });
        }

        function validateForReapeatFiles(position) {
            // console.log(arrayTabs[position].uploadFiles.serverFiles)
            // const files = arrayTabs[position].uploadFiles.serverFiles;
            // const filesNames = [];
            // files.forEach(file => {
            //     if(filesNames.indexOf(file.name) === -1) filesNames.push(file.name)
            //     else return false;
            // });
            // console.log(filesNames);
        }

        function disabledActividad(position, htmlActividad) {
            //DISABLED BUTTONS PLUGIN
            arrayTabs[position].uploadFiles.setDisableButton(1, true);
            arrayTabs[position].uploadFiles.setDisableButton(2, true);
            arrayTabs[position].uploadFiles.setDisableButton(3, true);

            $("#btn_save_" + position).hide();
            $("#btn_save_finish_" + position).hide();
            $("#label_finish_" + position).css('display', 'block');


            //$("#ejercicio_contenido_disabled_" + position).html(htmlActividad);
            $("#rowEditorTexto_" + position).css('display', 'none');
            $("#rowEditorTextoDisabled_" + position).css('display', 'block');
            $("#rowEditorTexto_" + position).remove();
        }

        function changeActividadIntegradoraEstatus(position) {
            let formData = new FormData();
            formData.append('a', 'changeActividadIntegradoraStatus');
            formData.append('id_alumno_escolar', arrayTabs[position].id_alumno_escolar);
            formData.append('id_ejercicio_escolar', arrayTabs[position].id_ejercicio);
            formData.append('id_materia_escolar', arrayTabs[position].id_materia_escolar);

            const browser = get_browser();
            formData.append('ultimo_navegador', `${browser.name} ${browser.version}`);


            $.ajax({
                url: 'functions/routes.php',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'post',
                beforeSend: function() {
                    $('.loading').show();
                },
                complete: function() {
                    $('.loading').hide();
                },
                success: function(response) {
                    if (response.success) location.reload();
                    else toast.error(response.title, response.msje);
                },
                error: function(response) {
                    toast.error('Error al obtener las actividades integradoras', 'Favor de contactar al Centro de Atención y Servicios al Alumno3');
                    console.log(response);
                }
            });
        }
        
        async function send_fetch(formData = new FormData(), method = 'POST'){

            const response = await fetch("functions/routes.php", {
                method: method, // *GET, POST, PUT, DELETE, etc.
                cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                headers: {
                //   'Content-Type': 'application/json'
                },
                body: formData
            })
            .catch((error) => {
                alert(error);
                return error;
            });

            return response?.json() || { error: 'ocurrio un error al enviar la peticion' };
        }

        initUI();
    });
</script>