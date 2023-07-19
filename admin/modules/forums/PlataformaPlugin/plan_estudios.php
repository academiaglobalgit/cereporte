<?PHP
	require_once('../config.php');
	require_once($CFG->libdir.'/gradelib.php'); 
	require_once($CFG->dirroot.'/grade/querylib.php');
	$activePage = basename($_SERVER['PHP_SELF'], ".php");
	include_once('functions/plan_estudio.php');
	include_once('functions/foros.php');

	include_once('functions/Scorms.php');
	$alumno = new Estudios();
	$scorms = new Scorms();
	$foros  = new Foros();
	$foro="";
?>


<!doctype html>
<html lang="en">
<head>
	<?php include('includes/partials/styles.php'); ?>
	<link rel="stylesheet" href="assets/css/plan_estudios.css"/>

</head>
<style>
	a{
		color:#000000;
	}
	a:hover{
		text-decoration: none;
		color: #265ba7;
	}
</style>
<body style="padding-bottom: 150px; padding-top: 110px;">

<section id="main-menu">
	<?php include('includes/partials/menu.php'); ?>
</section>



<section id="heading_plan_estudios">
	<div class="container">
		<div class="row text-center">
				<br/>
			<p class="hidden-xs " style="width:80%;margin-left:auto;margin-right:auto">
            El Plan de Estudios te presenta las materias que inscribiste. Existen dos opciones para estudiar tu material:<br/>
            •	En el botón Material para Estudiar necesitarás estar conectado a internet.<br/>

            •	En el ícono podrás descargarlo y guardarlo en tu dispositivo o imprimirlo <br/>(esta opción te permite, una vez guardado en tu equipo,
            	 estudiar tu material sin conexión a internet).<br/>

			</p>

            <p class="hidden-sm hidden-md hidden-lg text-center" style="font-size:12px;">
                 El Plan de Estudios te presenta las materias que inscribiste. Existen dos opciones para estudiar tu material:<br/><br>
            •	En el botón Material para Estudiar necesitarás estar conectado a internet.<br/><br>

            •	En el ícono podrás descargarlo y guardarlo en tu dispositivo o imprimirlo (esta opción te permite, una vez guardado en tu equipo,
            	 estudiar tu material sin conexión a internet).<br/>

            </p>

			<!--
				<strong class="text-center">
					<span class="visible-xs">xs</span>
					<span class="visible-sm">sm</span>
					<span class="visible-md">md</span>
					<span class="visible-lg">lg</span>
					<?php echo $USER->id; ?>
				</strong>
			-->



		</div>

	</div>
</section>


<section id="content_plan_estudios">
	<div class="container">
		<div class="row text-center">
			<div class="col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">

				<?php
					#echo "id_alumno: ".$USER->id."<br>";
					$html_reload="";
					$check_informacion = $alumno->check_informaction_actualizada($USER->id);
					/*Pregunta si el alumno tiene la informacion actualizada*/


							$tipo_alumno = $alumno->get_tipo_alumno($USER->id);


							$materias_activas = $alumno->get_materias_activas($USER->id);

							if($tipo_alumno->tipo2 == 1){
								$alumno_escolar = 'No definido';
							}
							elseif($tipo_alumno->tipo2 == 2){
								$alumno_escolar = 'Colaborador';
							}
							elseif($tipo_alumno->tipo2 == 3){
								$alumno_escolar = 'Familiar';
							}
							else{
								$alumno_escolar = 'No definido';
							}

							//echo $tipo_alumno->tipo1.'='.$alumno_escolar.'<br>';

							if($tipo_alumno->tipo1 == 'Colaborador'){

								/*Pregunta si el alumno tiene alguna materia activa*/
								if(count($materias_activas) > 0){
									echo '
										<table class="table responsive" cellspacing="0" width="100%" id="table_plan_estudio">

											<section class="hidden-sm">
											    <div class="row heading_periodo" style="font-size:1em;padding-bottom: 5px;padding-top: 5px;">
                                                    <div style="float:left;width:49%;padding-top: 10px;" class=" ">Materia </div>
                                                    <div style="float:left;width:16%;text-align: center;margin-bottom: 0px;padding-top: 10px;" class="table responsive hidden-xs ">Material en Línea</div>
                                                    <div style="float:left;width:12%;text-align: center;margin-bottom: 0px;padding-top: 10px;" class="table responsive hidden-xs ">Exámenes</div>
                                                    <div style="float:left;width:16%;text-align:center;margin-bottom: 0px;" class="table responsive hidden-xs  ">Exámenes <br>Presentados</div>
                                                    <div style="float:left;width:7%;text-align:center;margin-bottom: 0px;padding-bottom: 0px;margin-top: 0px;padding-top: 0px;" class="table responsive hidden-xs">Material <br>Descargable</div>
                                                </div>
                                            </section>

                                            <section class="hidden-xs hidden-md hidden-lg">
											    <div class="row heading_periodo" style="font-size:1em;padding-bottom: 5px;padding-top: 5px;">
                                                    <div style="float:left;width:41%;padding-top: 10px;" class=" ">Materia </div>
                                                    <div style="float:left;width:18%;text-align: center;margin-bottom: 0px;padding-top: 0px; font-size: 12px;" class="table responsive hidden-xs ">Material <br>en Línea</div>
                                                    <div style="float:left;width:19%;text-align: center;margin-bottom: 0px;padding-top: 10px; font-size: 12px;" class="table responsive hidden-xs ">Exámenes</div>
                                                    <div style="float:left;width:14%;text-align:center;margin-bottom: 0px; font-size: 12px;" class="table responsive hidden-xs  ">Exámenes <br>Presentados</div>
                                                    <div style="float:left;width:8%;text-align:center;margin-bottom: 0px;padding-bottom: 0px;margin-top: 0px;padding-top: 0px; font-size: 12px;" class="table responsive hidden-xs">Material <br>Descargable</div>
                                                </div>
                                            </section>
												

												<tbody>
									';

									foreach($materias_activas as $data){ // recorrido de materias activas
										$mensaje_boton = "Presentar Examen";
										if($data->id =="prueba para materias de corporaciones" ){ //====  IF MATERIAS CORPORACION
											$area_alumno = $alumno->get_area_persona($USER->id);

											/*if($tipo_alumno->tipo1 == $alumno_escolar and ($area_alumno > 0 and $area_alumno < 11)){

												if($data->id == 18){
													if($area_alumno >= 1 and $area_alumno <= 10){
														$section = 6;
													}else{
														$section = 3;
													}

													$get_examenes_parciales =$alumno->examenesParcialesCoppel1andCoppel2($data->id,$section);
													$material = '';
												}else if($data->id == 23){

													if($area_alumno >= 1 and $area_alumno <= 10){
														$section = 6;
													}else{
														$section = 3;
													}

													$get_examenes_parciales =$alumno->examenesParcialesCoppel1andCoppel2($data->id,$section);
													$material='';

												}else if($data->id == 26){

													if(($area_alumno >= 1 and $area_alumno <=5) or($area_alumno == 8)){
														$section = 6;
														$material='';
													}else if($area_alumno == 6){
														$section = 7;
														$material='';
													}else if($area_alumno == 7){
														$section = 8;
														$material='';
													}else if($area_alumno == 9){
														$section = 9;
														$material='';
													}else if($area_alumno == 10){
														$section = 3;
														$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para Estudiar</span>';
													}else{
														$section = 3;
													}

													$get_examenes_parciales =$alumno->examenesParcialesCoppel3andCoppel4($data->id,$section);

												}else if($data->id == 27){

													if($area_alumno == 1 or $area_alumno == 2 or $area_alumno == 4 or $area_alumno == 5 or $area_alumno==10){
														$section = 6;
														$material='';
													}else if($area_alumno == 8){
														$section = 7;
														$material='';
													}else if($area_alumno == 7){
														$section = 8;
														$material='';
													}else if($area_alumno == 3 or $area_alumno == 6 or $area_alumno == 9){
														$section = 3;
														$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para Estudiar</span>';
													}else{
														$section = 3;
													}

													$get_examenes_parciales =$alumno->examenesParcialesCoppel3andCoppel4($data->id,$section);

												}else{
													echo 'Algo paso';
												}

												if(empty($get_examenes_parciales)){ 
													$examen_actual = null;
												}else{
													$examenes_parciales = explode(",", $get_examenes_parciales);
													for($i=0; $i<count($examenes_parciales); $i++){
														$get_idquiz = $alumno->get_idquiz_by_module($data->id,$examenes_parciales[$i]);
														$check_examen=$alumno->examenesHechosPorMateria($USER->id,$get_idquiz);
														if($check_examen == 0){
															$examen_actual=$examenes_parciales[$i];
															break;
														}else{
															$examen_actual = null;
														}
													}
												}

												if($examen_actual <> null){
													$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_actual.'" target="_blank"><span class="examen_style">Presentar Examen</span></a>';
												}else{
													if($data->id == 26 and $area_alumno==10){

														$examenes_hechos= $alumno->check_examenes_parciales_materia($data->id,$USER->id);

														if($examenes_hechos > 0 and ( $examenes_hechos == count(@$examenes_parciales) )){
															$examen_final_hecho = $alumno->check_examen_final($USER->id,$data->id);
															if($examen_final_hecho == 1){
																$check_extra = $alumno->check_examen_extraordinario($USER->id,$data->id);
																if($check_extra == 1){
																	$examen_extraordinario = $alumno->get_extraordinario($data->id);
																	$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_extraordinario.'" target="_blank"><span class="extraordinario_style ">Presentar Extraordinario</span></a>';
																}else{
																	$modulo='Terminada';
																	$material = '';
																}
															}else{

																$examen_final = $alumno->examenFinal($data->id);
																$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_final.'" target="_blank"><span class="examen_style ">Presentar Examen</span></a>';
															}

														}else{

															$modulo = '<a href="#" target="_blank"><span class="examen_style">Presentar Examen</span></a>';
														}

													}else if($data->id == 27 and($area_alumno == 3 or $area_alumno == 6 or $area_alumno ==9)){
														$examenes_hechos= $alumno->check_examenes_parciales_materia($data->id,$USER->id);

														echo '<br>terminaron los parciales';
														if($examenes_hechos > 0 and ( $examenes_hechos == count(@$examenes_parciales) )){
															$examen_final_hecho = $alumno->check_examen_final($USER->id,$data->id);
															if($examen_final_hecho == 1){
																$check_extra = $alumno->check_examen_extraordinario($USER->id,$data->id);
																if($check_extra == 1){
																	$examen_extraordinario = $alumno->get_extraordinario($data->id);
																	$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_extraordinario.'" target="_blank"><span class="extraordinario_style ">Presentar Extraordinario</span></a>';
																}else{
																	$modulo='Terminada';
																	$material = '';
																}
															}else{

																$examen_final = $alumno->examenFinal($data->id);
																$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_final.'" target="_blank"><span class="examen_style ">Presentar Examen</span></a>';
															}

														}else{

															$modulo = '<a href="#" target="_blank"><span class="examen_style">Presentar Examen</span></a>';
														}
													}else{
														$modulo = '<a href="#" target="_blank"><span class="examen_style">Presentar Examen</span></a>';
													}

												}

											}else{
												$modulo = '<a href="'.$CFG->wwwroot.'/plataforma/perfil.php" target="_blank"><span class="actualizar_style locato" >Actualizar Información</span></a>';
												$material = '';
											}*/



										}else{ //======= NO SON MATERIAS DE CORPORACION 
											$material_actual = null;
											//$examen_actual = $alumno->ExamenesPorMateria($USER->id,$data->id);
											$examenes_hechos_alumno = array();
											$get_examenes_parciales = $alumno->examenesParcialesPorMateria($data->id);
											$get_materiales = $alumno->scorm_material_by_materia($data->id);

											if(empty($get_examenes_parciales) || empty($get_materiales)){
												$examen_actual = null;
												$material_actual = null;
                                                $examenes_parciales=null;
											}else{
												
												$examenes_parciales = explode(",", $get_examenes_parciales);
												$materiales = explode(",", $get_materiales);
												for($i = 0; $i < count($examenes_parciales); $i++){
													$get_idscorm = $alumno->get_idscorm_by_module($data->id, $examenes_parciales[$i]);
													$id_scorm = $get_idscorm;
													$check_examen = $alumno->get_data_scorm($data->id, $USER->id, $get_idscorm, 1);
													#echo $check_examen."<br>";

													if(is_null($check_examen) || $check_examen == "incomplete"){ // SI NO LO HA TERMINADO O NO LO HA HECHO
														#--------------------
														$response = $scorms->get_intetos_scorm($id_scorm, $USER->id);
														#echo $response["query"]."<br>";
														$scorm_intentos = $response["data"];
														if(count($scorm_intentos) < 2){
															$examen_actual = $examenes_parciales[$i];
															$material_actual = $materiales[$i];
														}
														else{
															$examen_actual = null; // YA HIZO EL EXAMEN PAARSIAL (ACREDITADO, REPROBADO O COMPLETADO)
															$material_actual = null;
															$response = $scorms->get_scorm_track_info($id_scorm, $USER->id);
															$scorm_info = $response["data"];
															$response = $scorms->get_scorm_track_answers_correct($id_scorm, $USER->id);
															$scorm_respuestas = $response["data"];
															$puntuacion_obtenida = count($scorm_respuestas);
															if($puntuacion_obtenida != 0){
																$calificacion = ($puntuacion_obtenida * $scorm_info["peso_pregunta"]);
																//$calificacion = ($puntuacion_obtenida / $scorm_info["puntuacion_maxima"]) * 10;
															}
															else{
																$calificacion = 0;
															}
															$estatus = "";
															if($calificacion >= 6){
																$estatus = "passed";
															}
															else{
																$estatus = "failed";
															}
															$response = $scorms->update_scorm_track($id_scorm, $USER->id, $estatus, $calificacion);
															$html_reload = "<script> location.reload(); </script>";
														}
														#--------------------
														break;
													}else if ($check_examen == "passed" || $check_examen == "failed"  || $check_examen == "complete" ) { 
														$mensaje_boton = "Presentar Examen";
														$examen_actual = null; // YA HIZO EL EXAMEN PAARSIAL (ACREDITADO, REPROBADO O COMPLETADO)
														$material_actual = null;
														array_push($examenes_hechos_alumno, $examenes_parciales[$i]); //se agrega el id del examen scorm al array si ya lo hizo
														#echo "2<br>";
													}else{
														//ALGO SALÍO MAL
														$mensaje_boton = "Presentar Examen";
														$examen_actual = 0;
														$material_actual = 0;
														#echo "3<br>";
													}

												}
											}
											//echo "EXAMEN ACTUAL".$examen_actual; // debug examen actual

											if($examen_actual != null){ // si no es igual a null muestra el examen parsial normal
												#echo "4<br>";
												$response = $scorms->get_intetos_scorm($id_scorm, $USER->id);
												$scorm_intentos = $response["data"];
												$material = "";
												$modulo = "";
												/*
												if(count($scorm_intentos) == 0){
													$mensaje_boton = "Presentar Examen";
													$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para Estudiar</span>';
													$modulo = '<a name="boton_examen" data-scorm="'.$id_scorm.'" data-user="'.$USER->id.'" href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_actual.'" target="_blank"><span class="examen_style"> '.$mensaje_boton.' </span></a>';
												}
												if(count($scorm_intentos) == 1){
													$mensaje_boton = "Continuar Examen";
													$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para Estudiar</span>';
													$modulo = '<a onclick="preguntar_continuar_examen('.$id_scorm.', '.$USER->id.')" href="javascript: void(0);"> <span class="examen_style "> '.$mensaje_boton.' </span> </a> <input id="value_boton_modal_'.$id_scorm.'" type="hidden" value="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_actual.'">';
												}
												else if(count($scorm_intentos) == 2){
													$mensaje_boton = "No hay mas intentos";
													$modulo = '<a name="boton_examen" data-scorm="'.$id_scorm.'" data-user="'.$USER->id.'" href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_actual.'" target="_blank"><span class="examen_style"> '.$mensaje_boton.' </span></a>';
													
												}
												*/


												/*================== FIXED INTENTOS =========*/
												$html_reload="";
												if($scorms->validar_iniciacion_examen($USER->id,$id_scorm) > 8){
													//Intento 1 (se comprueba que el alumno tiene 1 preguntas contestada minima)
													$scorms->post_intento_examen($USER->id,$id_scorm,1);
													$numero_intentos= (int)$scorms->get_examen_intento($USER->id,$id_scorm);
													if( $numero_intentos == 1 ){
															//Intento 2 al dar que si en el modal de validación
															$mensaje_boton = "Continuar<br>Examen";
															$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para <br>Estudiar</span>';





												 	
															$modulo = '<a onclick="preguntar_continuar_examen('.$id_scorm.', '.$USER->id.')" href="javascript: void(0);"> <span class="examen_style "> '.$mensaje_boton.' </span> </a> <input id="value_boton_modal_'.$id_scorm.'" type="hidden" value="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_actual.'">';


													}else if($numero_intentos == 2 ){
														/*  $correctas =0;
														for($i=0; $i<10; $i++){
															$pregunta =$scorms->post_calificacion_intento2($USER->id,$id_scorm,$i);
															if($pregunta == 1){
																$correctas++;
															}else{

															}
														}

														 //echo $correctas;
														 $calif_correcta = $correctas * 0.4;
														 $scorms->update_examen_status($USER->id,$id_scorm,$calif_correcta);
														 $html_reload="<script>alert('ALEEERT'); location.reload();</script>";

														*/
													}
													else{
														/*Muestra los botones PARA PRESENTAR EL EXAMEN por primera vez*/
										 			$mensaje_boton = "Presentar <br>Examen";
										 			/*CODIGO PARA ABRIR UN MODAL DE MATERIALES (EN CASO DE QUE SEAN MAS DE 1 )*/
													//$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para <br>Estudiar</span>';
													$material = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$material_actual.'" target="_blank"><span class="material_style ">Material para <br>Estudiar</span></a>';


													$modulo = '<a name="boton_examen" data-scorm="'.$id_scorm.'" data-user="'.$USER->id.'" href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_actual.'" target="_blank"><span class="examen_style"> '.$mensaje_boton.' </span></a>';
													//$modulo = '<a name="boton_examen" data-scorm="'.$id_scorm.'" data-user="'.$USER->id.'" href="#" style="cursor: not-allowed; pointer-events: none;opacity: 0.65;filter: alpha(opacity=65);box-shadow: none;"><span class="examen_style"> '.$mensaje_boton.' </span></a>';
													}
												}
												else{
													/*Muestra los botones PARA PRESENTAR EL EXAMEN por primera vez*/
										 			$mensaje_boton = "Presentar <br>Examen";
										 			/*CODIGO PARA ABRIR UN MODAL DE MATERIALES (EN CASO DE QUE SEAN MAS DE 1 )*/
													//$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para <br>Estudiar</span>';
													$material = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$material_actual.'" target="_blank"><span class="material_style ">Material para <br>Estudiar</span>';



													$modulo = '<a name="boton_examen" data-scorm="'.$id_scorm.'" data-user="'.$USER->id.'" href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_actual.'" target="_blank"><span class="examen_style"> '.$mensaje_boton.' </span></a>';


													/*==================FOROS======================*/
													$id_examen_escolar=$foros->GetQuizByMoodleQuiz(9,$data->id,$id_scorm,2);
													$id_persona_alumno=$foros->get_id_persona($USER->id,9);
													$foros_terminados=$foros->GetForosTerminados($id_examen_escolar[0]['id'],$id_persona_alumno);

													if($foros_terminados){
														$str_terminados="Foros terminados ";
													}else{
														$str_terminados="faltan foros por terminar";

													}
												 	$n_foros=$foros->GetForumsByExamen($id_examen_escolar[0]['id']);
												 	if($n_foros>0){

												 		if($foros_terminados){ // muestra boton examen normal
												 				$foro='<a name="boton_examen" data-scorm="'.$id_scorm.'" data-user="'.$USER->id.'" href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_actual.'" target="_blank"><span class="examen_style"> '.$mensaje_boton.' </span></a>';

												 				$modulo=$foro;
												 		}else{ //muestra modal de foros
												 			$foro='<a  data-toggle="modal" data-target="#foros_'.$data->id.'_'.$USER->id.'"  href="#" ><span class="material_style ">'.$mensaje_boton.' </span></a>';
												 			$modulo=$foro;
												 		}
												 		
												 	}

												 	/*====termina foros ===*/

												 	//agregar si no quieres foros
													

													//$modulo = '<a name="boton_examen" data-scorm="'.$id_scorm.'" data-user="'.$USER->id.'" href="#" style="cursor: not-allowed; pointer-events: none;opacity: 0.65;filter: alpha(opacity=65);box-shadow: none;"><span class="examen_style"> '.$mensaje_boton.' </span></a>';
												}


											}else{ // SI TODOS LOS EXAMENES PARCIALES SON NULL ENTONCES SE TRATA DE EL EXAMEN FINAL
												#echo "5<br>";
												//$examenes_hechos= $alumno->check_examenes_parciales_materia($data->id,$USER->id);
											   $examenes_hechos= count(@$examenes_hechos_alumno);

												if($examenes_hechos > 0 and ( $examenes_hechos == count(@$examenes_parciales) )){

													//$examen_final_hecho = $alumno->check_examen_final($USER->id,$data->id);
													$examen_final_hecho=$alumno->scorms_ex_final_materia_alumno($USER->id, $data->id);

													if(!is_null($examen_final_hecho) && ($examen_final_hecho['value']=='complete' || $examen_final_hecho['value']=='failed' || $examen_final_hecho['value']=='passed')){ // si hizo el examen final

														//=======================EXAMEN EXTRAORDINARIO===================
                                                        $calificacion_final = $alumno->get_calificacion_final($USER->id, $data->id);
                                                        if($calificacion_final==1){ // El alumno reprobo la materia
                                                            $check_extra = $alumno->scorms_ex_extra_materia_alumno($USER->id,$data->id);
                                                            if(is_null($check_extra) ||  $check_extra['value'] == 'incomplete'){ // si no ha hecho el extraordinario o terminado el extraordinario

                                                                // $examen_extraordinario = $alumno->scorms_ex_extra_materia($data->id);
                                                                $examen_extraordinario  = $alumno->scorms_ex_extra_materia($data->id);

                                                                if(is_null($examen_extraordinario)){
                                                                    $id_scorm_ex_extra=0;
                                                                    $modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$id_scorm_ex_extra.'" target="_blank"><span class="extraordinario_style ">Presentar <br>Extraordinario</span></a>';
                                                                }else if($check_extra['value'] == 'complete' || $check_extra['value'] == 'failed' || $check_extra['value'] == 'passed'){
                                                                    $modulo='Terminada';
                                                                    $material = '';
                                                                    //=======================EXAMEN EXTRAORDINARIO 2DO INTENTO AQUI===================
                                                                }else{
                                                                    $id_scorm_ex_extra=$examen_extraordinario['id'];
                                                                    $modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$id_scorm_ex_extra.'" target="_blank"><span class="extraordinario_style ">Presentar Extraordinario</span></a>';
                                                                }

                                                                //$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$id_scorm_ex_extra.'" target="_blank"><span class="extraordinario_style ">Presentar Extraordinario</span></a>';

                                                            }else if ($examen_final_hecho['value']=='complete' || $examen_final_hecho['value']=='failed' ) {
                                                                $modulo='Reprobada';
                                                                $material = '';
                                                            }elseif ($examen_final_hecho['value']=='passed') {
                                                                $modulo='Terminada';
                                                                $material = '';
                                                            }
                                                            //$modulo = '<a href="#"><span class="examen_style ">Terminada</span></a>';
                                                            $material = '';
                                                        }else{
                                                            $modulo='Terminada';
                                                            $material = '';
                                                        }

													}else if (is_null($examen_final_hecho) || $examen_final_hecho['value']=='incomplete'){ // NO HA HECHO EL EXAMEN FINAL

														$examen_final = $alumno->scorms_ex_final_materia($data->id);
														if(is_null($examen_final)){
															$id_scorm_ex_final = 0;
														}else{
														   $id_scorm_ex_final = $examen_final['id'];
														}

														#--------------------
														
														$response = $scorms->get_scorm_by_module($id_scorm_ex_final);
														$id_scorm = $response["data"]["id_scorm"];
														$id_module = $response["data"]["id_module"];

														#echo "ID SCORM: ".$id_scorm."<br>";
														#echo "ID MODULE: ".$id_module."<br>";
														$modulo = "";
														$examen_actual = "";
														$material = '';
														$html_reload = "";
														#echo "Registros: ".$scorms->validar_iniciacion_examen($USER->id, $id_scorm)."<br>";
														if($scorms->validar_iniciacion_examen($USER->id, $id_scorm) > 8){
															#Intento 1 (se comprueba que el alumno tiene 1 preguntas contestada minima)
															$scorms->post_intento_examen($USER->id, $id_scorm, 1);
															$numero_intentos = (int)$scorms->get_examen_intento($USER->id, $id_scorm);
															#echo "Numero de intentos: ".$numero_intentos."<br>";
															if($numero_intentos == 1){
																$modulo = '<a onclick="preguntar_continuar_examen('.$id_scorm.', '.$USER->id.')" href="javascript: void(0);"> <span class="examen_style "> Continuar <br>Examen </span> </a> <input id="value_boton_modal_'.$id_scorm.'" type="hidden" value="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$id_module.'">';
																$examen_actual="Final ".$id_scorm_ex_final;
																$material = '';
															}
															else if($numero_intentos == 2){
																#Muestra los botones PARA PRESENTAR EL EXAMEN por primera vez
																#CALIFICA EL EXAMEN
																$response = $scorms->get_scorm_track_info($id_scorm, $USER->id);
																$scorm_info = $response["data"];
																$response = $scorms->get_scorm_track_answers_correct($id_scorm, $USER->id);
																$scorm_respuestas = $response["data"];
																$puntuacion_obtenida = count($scorm_respuestas);
																if($puntuacion_obtenida != 0){
																	$calificacion = ($puntuacion_obtenida * $scorm_info["peso_pregunta"]);
																	//$calificacion = ($puntuacion_obtenida / $scorm_info["puntuacion_maxima"]) * 10;
																}
																else{
																	$calificacion = 0;
																}
																$estatus = "";
																if($calificacion >= 6){
																	$estatus = "passed";
																}
																else{
																	$estatus = "failed";
																}
																#CAMBIA EL ESTATUS DEL EXAMEN
																$response = $scorms->update_scorm_track($id_scorm, $USER->id, $estatus, $calificacion);
																#SE RECARGA LA PAGINA
																$html_reload = "<script> location.reload(); </script>";
															}
															else{
																#Muestra los botones PARA PRESENTAR EL EXAMEN por primera vez
																$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$id_scorm_ex_final.'" target="_blank"><span class="examen_style ">Examen Final</span></a>';
																$examen_actual = "Final ".$id_scorm_ex_final;
																$material = '';
															}
														}
														else{
															 #Muestra los botones PARA PRESENTAR EL EXAMEN por primera vez
                                                            if(is_null(@$alumno->scorms_count_ex_final_materia($data->id)))
                                                            {
                                                                $modulo = '<a href="#" ><span class="proceso_final_style">En Proceso</span></a>';
                                                            }
                                                            else
                                                            {
                                                                $modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$id_scorm_ex_final.'" target="_blank"><span class="examen_final_style">Presentar <br>Examen Final</span></a>';
                                                            }
                                                            $examen_actual = "Final ".$id_scorm_ex_final;
                                                            $material = '';

															/*
															#Muestra los botones PARA PRESENTAR EL EXAMEN por primera vez
										count($alumno->get_examenes_hechos($USER->id,$data->id))+1;
										//(count(@$examenes_parciales)+count(@$alumno->scorms_count_ex_final_materia($data->id))	
															$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$id_scorm_ex_final.'" target="_blank"><span class="examen_final_style">Presentar <br>Examen Final</span></a>';
															$examen_actual = "Final ".$id_scorm_ex_final;
															$material = '';
															*/
														}
														#--------------------*/
													}

												}else{ // algo salio mal

													$modulo = '<a href="#" ><span class="proceso_final_style">En Proceso</span></a>';
                                                    $material = '';
                                                    //$modulo = '<a href="#" data-toggle="modal" data-target="#examen_'.$data->id.'_'.$USER->id.'" target="_top"><span class="examen_style">Presentar <br>Examen</span></a>';
                                                    //$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para <br>Estudiar</span>';
												}

											}

										   
											
										}

										$materiales=$alumno->materialDeEstudio($data->id);
										$material_download = $alumno->descargable_by_materia($data->id);

                                        echo '
											<tr style="border-bottom:1px solid #ddd;" class="hidden-xs">
												<td width="40%" class="text-left" style="vertical-align: middle; "><span class="name_style">'.$data->fullname.' </td>
												<td class="pull-right" style="vertical-align: middle; padding-top:15px;" >'.$modulo.'</td>
												<td class="pull-right" style="vertical-align: middle; padding-top:15px;" >'.$material.'</a></td>

												<td class="hidden-xs"  width="2%;" style="background-color:white; border-bottom:white;"></td>';
                                                if((count($alumno->get_examenes_hechos($USER->id,$data->id))) >= (count($examenes_parciales))){
                                                    echo '<td style="vertical-align: middle; " >Ext</a></td>';
                                                }else{
                                                	if(count(@$alumno->scorms_count_ex_final_materia($data->id))==0){
		                                                echo '<td style="vertical-align: middle; " >'.(count($alumno->get_examenes_hechos($USER->id,$data->id))).' de 6</a></td>';
		                                            }else{
		                                                echo '<td style="vertical-align: middle; " >'.(count($alumno->get_examenes_hechos($USER->id,$data->id))).' de '.(count(@$examenes_parciales)+count(@$alumno->scorms_count_ex_final_materia($data->id))).'</a></td>';
		                                            }
                                                    //echo '<td style="vertical-align: middle; " >'.(count($alumno->get_examenes_hechos($USER->id,$data->id))).' de '.(count(@$examenes_parciales)+count(@$alumno->scorms_count_ex_final_materia($data->id))).'</a></td>';
                                                }

                                                echo '<td class="hidden-xs" width="2%;" style="background-color:white; border-bottom:white;"></td>';

                                                if($material_download == null){
                                                    //echo '<td width="10%" class="text-center" style="vertical-align: middle"><a id="donwload_material" href="#" data-toggle="modal" data-target=".material_descarga">Descarga Material</a></td>';
													echo '<td width="10%" class="text-center" style="vertical-align: middle"><a id="donwload_material" href="#" data-toggle="modal" data-target=".material_descarga"><img src="assets/img/archivo_pdf.jpg"  alt=""/></a></td>';
                                                }else{
                                                    echo '<td width="10%" class="text-center" style="vertical-align: middle"><a id="donwload_material" href='.$CFG->wwwroot."/mod/resource/view.php?id=".$material_download.' target="_blank" download><img src="assets/img/archivo_pdf.jpg"  alt=""/></a></td>';
                                                }


											echo '</tr>
										';

										 //PANTALLA MOVIL
                                        echo '
											<tr style="border-bottom:1px solid #ddd;" class="hidden-sm hidden-md hidden-lg" >
												<td width="37%" class="text-left" style="vertical-align: middle; "><span class="name_style">'.$data->fullname.' </td>
												<td class="pull-right" style="vertical-align: middle; padding-top:15px;" >'.$material.'</a></td>
												<td class="pull-right" style="vertical-align: middle; padding-top:15px;" >'.$modulo.'</td>

												<td class="hidden-xs"  width="2%;" style="background-color:white; border-bottom:white;"></td>';
                                        if((count($alumno->get_examenes_hechos($USER->id,$data->id))) > (count($examenes_parciales)+1)){
                                            echo '<td style="vertical-align: middle; " >Ext</a></td>';
                                        }else{
                                            if(count(@$alumno->scorms_count_ex_final_materia($data->id))==0){
                                                echo '<td style="vertical-align: middle; " >'.(count($alumno->get_examenes_hechos($USER->id,$data->id))).' de 6</a></td>';
                                            }else{
                                                echo '<td style="vertical-align: middle; " >'.(count($alumno->get_examenes_hechos($USER->id,$data->id))).' de '.(count(@$examenes_parciales)+count(@$alumno->scorms_count_ex_final_materia($data->id))).'</a></td>';
                                            }
                                            // echo '<td style="vertical-align: middle; " >'.(count($alumno->get_examenes_hechos($USER->id,$data->id))+1).' de '.(count(@$examenes_parciales)+count(@$alumno->scorms_count_ex_final_materia($data->id))).'</a></td>';
                                        }

                                        echo '<td class="hidden-xs" width="2%;" style="background-color:white; border-bottom:white;"></td>';

                                        if($material_download == null){
                                            echo '<td width="10%" class="text-center" style="vertical-align: middle"><a id="donwload_material" href="#" data-toggle="modal" data-target=".material_descarga"><img src="assets/img/archivo_pdf.jpg" alt=""/></a></td>';
                                        }else{
                                            echo '<td width="10%" class="text-center" style="vertical-align: middle"><a id="donwload_material" href='.$CFG->wwwroot."/mod/resource/view.php?id=".$material_download.' target="_blank" download><img src="assets/img/archivo_pdf.jpg" alt=""/></a></td>';
                                            //  echo '<td width="10%" class="text-center" style="vertical-align: middle"><a id="donwload_material" href='.$CFG->wwwroot."/mod/resource/view.php?id=".$material_download.' target="_blank" download>Descarga Material</a></td>';
                                        }


                                        echo '</tr>
										';

										if(count($materiales) > 0  && $material_actual!=null){
											include('includes/modals/materiales.php');
										}else{
											include('includes/modals/materiales404.php');
										}
										include('includes/modals/examenes404.php');

									} ////// WHILE RECORRIDO DE MATERIAS ACTIVAS

									echo '</tbody>'.$html_reload; // si reload tiene la funcion pues refresca la pagina
                                    include('includes/modals/material_descarga404.php');
								}else{
									echo '<h3 class="locato">No tienes ninguna materia cargada por el momento</h3>';
								}
							}
							else if($tipo_alumno->tipo1 == 'Familiar'){

							/*Pregunta si el alumno tiene alguna materia activa*/
								if(count($materias_activas) > 0){
									echo '<table class="table responsive" cellspacing="0" width="100%" id="table_plan_estudio">

										<div class="row heading_periodo">MATERIA</div>
										<br/>


										<tbody>';

											foreach($materias_activas as $data){ // recorrido de materias activas

												if($data->id =="prueba para materias de corporaciones" ){ //====  IF MATERIAS CORPORACION
													$area_alumno = $alumno->get_area_persona($USER->id);

												  /*  if($tipo_alumno->tipo1 == $alumno_escolar and ($area_alumno > 0 and $area_alumno < 11)){

														if($data->id == 18){
															if($area_alumno >= 1 and $area_alumno <= 10){
																$section = 6;
															}else{
																$section = 3;
															}

															$get_examenes_parciales =$alumno->examenesParcialesCoppel1andCoppel2($data->id,$section);
															$material = '';
														}else if($data->id == 23){

															if($area_alumno >= 1 and $area_alumno <= 10){
																$section = 6;
															}else{
																$section = 3;
															}

															$get_examenes_parciales =$alumno->examenesParcialesCoppel1andCoppel2($data->id,$section);
															$material='';

														}else if($data->id == 26){

															if(($area_alumno >= 1 and $area_alumno <=5) or($area_alumno == 8)){
																$section = 6;
																$material='';
															}else if($area_alumno == 6){
																$section = 7;
																$material='';
															}else if($area_alumno == 7){
																$section = 8;
																$material='';
															}else if($area_alumno == 9){
																$section = 9;
																$material='';
															}else if($area_alumno == 10){
																$section = 3;
																$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para Estudiar</span>';
															}else{
																$section = 3;
															}

															$get_examenes_parciales =$alumno->examenesParcialesCoppel3andCoppel4($data->id,$section);

														}else if($data->id == 27){

															if($area_alumno == 1 or $area_alumno == 2 or $area_alumno == 4 or $area_alumno == 5 or $area_alumno==10){
																$section = 6;
																$material='';
															}else if($area_alumno == 8){
																$section = 7;
																$material='';
															}else if($area_alumno == 7){
																$section = 8;
																$material='';
															}else if($area_alumno == 3 or $area_alumno == 6 or $area_alumno == 9){
																$section = 3;
																$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para Estudiar</span>';
															}else{
																$section = 3;
															}

															$get_examenes_parciales =$alumno->examenesParcialesCoppel3andCoppel4($data->id,$section);

														}else{
															echo 'Algo paso';
														}

														if(empty($get_examenes_parciales)){ 
															$examen_actual = null;
														}else{
															$examenes_parciales = explode(",", $get_examenes_parciales);
															for($i=0; $i<count($examenes_parciales); $i++){
																$get_idquiz = $alumno->get_idquiz_by_module($data->id,$examenes_parciales[$i]);
																$check_examen=$alumno->examenesHechosPorMateria($USER->id,$get_idquiz);
																if($check_examen == 0){
																	$examen_actual=$examenes_parciales[$i];
																	break;
																}else{
																	$examen_actual = null;
																}
															}
														}

														if($examen_actual <> null){
															$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_actual.'" target="_blank"><span class="examen_style">Presentar Examen</span></a>';
														}else{
															if($data->id == 26 and $area_alumno==10){

																$examenes_hechos= $alumno->check_examenes_parciales_materia($data->id,$USER->id);

																if($examenes_hechos > 0 and ( $examenes_hechos == count(@$examenes_parciales) )){
																	$examen_final_hecho = $alumno->check_examen_final($USER->id,$data->id);
																	if($examen_final_hecho == 1){
																		$check_extra = $alumno->check_examen_extraordinario($USER->id,$data->id);
																		if($check_extra == 1){
																			$examen_extraordinario = $alumno->get_extraordinario($data->id);
																			$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_extraordinario.'" target="_blank"><span class="extraordinario_style ">Presentar Extraordinario</span></a>';
																		}else{
																			$modulo='Terminada';
																			$material = '';
																		}
																	}else{

																		$examen_final = $alumno->examenFinal($data->id);
																		$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_final.'" target="_blank"><span class="examen_style ">Presentar Examen</span></a>';
																	}

																}else{

																	$modulo = '<a href="#" target="_blank"><span class="examen_style">Presentar Examen</span></a>';
																}

															}else if($data->id == 27 and($area_alumno == 3 or $area_alumno == 6 or $area_alumno ==9)){
																$examenes_hechos= $alumno->check_examenes_parciales_materia($data->id,$USER->id);

																echo '<br>terminaron los parciales';
																if($examenes_hechos > 0 and ( $examenes_hechos == count(@$examenes_parciales) )){
																	$examen_final_hecho = $alumno->check_examen_final($USER->id,$data->id);
																	if($examen_final_hecho == 1){
																		$check_extra = $alumno->check_examen_extraordinario($USER->id,$data->id);
																		if($check_extra == 1){
																			$examen_extraordinario = $alumno->get_extraordinario($data->id);
																			$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_extraordinario.'" target="_blank"><span class="extraordinario_style ">Presentar Extraordinario</span></a>';
																		}else{
																			$modulo='Terminada';
																			$material = '';
																		}
																	}else{

																		$examen_final = $alumno->examenFinal($data->id);
																		$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_final.'" target="_blank"><span class="examen_style ">Presentar Examen</span></a>';
																	}

																}else{

																	$modulo = '<a href="#" target="_blank"><span class="examen_style">Presentar Examen</span></a>';
																}
															}else{
																$modulo = '<a href="#" target="_blank"><span class="examen_style">Presentar Examen</span></a>';
															}

														}

													}else{
														$modulo = '<a href="'.$CFG->wwwroot.'/plataforma/perfil.php" target="_blank"><span class="actualizar_style locato" >Actualizar Información</span></a>';
														$material = '';
													}*/



												}else{ //======= NO SON MATERIAS DE CORPORACION 


												
													 $material_actual=null;
													//$examen_actual = $alumno->ExamenesPorMateria($USER->id,$data->id);
															$examenes_hechos_alumno=array();
															$get_examenes_parciales =$alumno->examenesParcialesPorMateria($data->id);
															$get_materiales=$alumno->scorm_material_by_materia($data->id);

															if(empty($get_examenes_parciales) || empty($get_materiales)){
																$examen_actual = null;
																$material_actual=null;
															}else{
																
																$examenes_parciales = explode(",", $get_examenes_parciales);
																$materiales = explode(",", $get_materiales);
																for($i=0; $i<count($examenes_parciales); $i++){

																	$get_idscorm = $alumno->get_idscorm_by_module($data->id,$examenes_parciales[$i]);
																	$check_examen=$alumno->get_data_scorm($data->id,$USER->id,$get_idscorm,1);
																	if(is_null($check_examen) || $check_examen=="incomplete"   ){ // SI NO LO HA TERMINADO O NO LO HA HECHO
																		$examen_actual=$examenes_parciales[$i];
																		$material_actual=$materiales[$i];
																		break;
																	}else if ($check_examen=="passed" || $check_examen=="failed"  || $check_examen=="complete" ) { 
																	   $examen_actual=null; // YA HIZO EL EXAMEN PAARSIAL (ACREDITADO, REPROBADO O COMPLETADO)
																	   array_push($examenes_hechos_alumno,$examenes_parciales[$i]); //se agrega el id del examen scorm al array si ya lo hizo
																	}else{//ALGO SALÍO MAL
																		$examen_actual=0;
																		$material_actual=0;
																	}

																}
															}

													if($examen_actual != null){ // si no es igual a null muestra el examen parsial normal
														$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$examen_actual.'" target="_blank"><span class="examen_style ">Presentar Examen </span></a>';
													}else{ // SI TODOS LOS EXAMENES PARCIALES SON NULL ENTONCES SE TRATA DE EL EXAMEN FINAL

														//$examenes_hechos= $alumno->check_examenes_parciales_materia($data->id,$USER->id);
													   $examenes_hechos= count(@$examenes_hechos_alumno);

														if($examenes_hechos > 0 and ( $examenes_hechos == count(@$examenes_parciales) )){

															//$examen_final_hecho = $alumno->check_examen_final($USER->id,$data->id);
															$examen_final_hecho=$alumno->scorms_ex_final_materia_alumno($USER->id,$data->id);
															if(!is_null($examen_final_hecho) && ($examen_final_hecho['value']=='complete' || $examen_final_hecho['value']=='failed' )){ // si hizo el examen final y lo reprobó
																//=======================EXAMEN EXTRAORDINARIO===================
															   /* $check_extra = $alumno->scorms_ex_extra_materia_alumno($USER->id,$data->id);

																if(is_null($check_extra)){ // si no ha hecho el extraordinario
																   
																   // $examen_extraordinario = $alumno->scorms_ex_extra_materia($data->id);
																	$examen_extraordinario  = $alumno->scorms_ex_extra_materia($data->id);
																	if(is_null($examen_extraordinario)){
																		$id_scorm_ex_extra=0;
																	}else{
																	   $id_scorm_ex_extra=$examen_extraordinario['id'];
																	}
																	$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$id_scorm_ex_extra.'" target="_blank"><span class="extraordinario_style ">Presentar Extraordinario</span></a>';

																}else if ($examen_final_hecho['value']=='complete' || $examen_final_hecho['value']=='failed' ) {
																	$modulo='Reprobada';
																	$material = '';
																}elseif ($examen_final_hecho['value']=='passed') {
																	 $modulo='Terminada';
																	$material = '';
																}*/
																$modulo = '<a href="#"><span class="examen_style ">Terminada</span></a>';

															}else if( $examen_final_hecho['value']=='passed') { // SI  HIZO EL EXAMEN FINAL y APROBÓ
																$modulo = '<a href="#"><span class="examen_style ">Terminada</span></a>';
																$material = '';
													  
															}else if (is_null($examen_final_hecho) || $check_examen=="incomplete" ){ // NO HA HECHO EL EXAMEN FINAL
																
																$examen_final = $alumno->scorms_ex_final_materia($data->id);
																if(is_null($examen_final)){
																	$id_scorm_ex_final=0;
																}else{
																   $id_scorm_ex_final=$examen_final['id'];
																}

																$modulo = '<a href="'.$CFG->wwwroot.'/mod/scorm/view.php?id='.$id_scorm_ex_final.'" target="_blank"><span class="examen_style ">Examen Final</span></a>';
																$examen_actual="Final ".$id_scorm_ex_final;
															}

														}else{ // algo salio mal

															//$modulo = '<a href="#mal2" target="_blank"><span class="examen_style">Examen Final</span></a>';
                                                            $modulo = '<a href="#" data-toggle="modal" data-target="#examen_'.$data->id.'_'.$USER->id.'" target="_top"><span class="examen_style">Presentar Examen</span></a>';
                                                            $material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para Estudiar</span>';
														}

													}

													$material = '<a href="#" data-toggle="modal" data-target="#material_'.$data->id.'_'.$USER->id.'" ><span class="material_style ">Material para Estudiar</span>';
												}

												$materiales=$alumno->materialDeEstudio($data->id);
											



												echo '<tr style="border-bottom:1px solid #ddd;">
													<td class="text-left" style="vertical-align: middle; "><span class="name_style">'.$data->fullname.' </td>
													<td class="pull-right" style="vertical-align: middle; " >'.$modulo.'</td>

													<td class="pull-right" style="vertical-align: middle; " >'.$material.'</a></td>
												</tr>';

												if(count($materiales) > 0 && $material_actual!=null){
													include('includes/modals/materiales.php');
												}else{
													include('includes/modals/materiales404.php');
												}

											} ////// WHILE RECORRIDO DE MATERIAS ACTIVAS

										echo '</tbody>';
								}else{
									echo '<h3 class="locato">No tienes ninguna materia cargada por el momento</h3>';
								}




							}else{
								echo '<h3 class="locato">No tienes definido tu tipo de alumno</h3>';
							}


					 echo '</table>';

				?>



			</div>
		</div>
	</div>


	  <!--<div class="modal fade" id="modal_aviso" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <img src="http://agcollege.edu.mx/img/cancermama.jpg" width="100%" alt="Cancer de Mama" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div> -->
</section>



<section id="footer" class="bg-white">
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

<section class="scripts">
	<?php include('includes/partials/scripts.php'); ?>
</section>
</body>

</html>