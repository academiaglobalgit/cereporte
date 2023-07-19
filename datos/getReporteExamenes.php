<?php
		$filename="ReporteGenerado.xls";

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");

		require_once "../models/report.class.php";

		require_once "config.php";

 $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");
$reporte= new Report("mdl_user","id");
/*
SELECT
	a.id AS 'id',
	a.username AS 'username',
	trim(a.firstname) AS 'nombre',
	trim(a.lastname) AS 'apellidos',
	c.data AS 'numero_trabajador',
	d.data AS 'numero_centro',
	e.data AS 'region',
	(
		SELECT
			count(
				prepacoppel.mdl_quiz.id
			)
		FROM
			(
				(
					prepacoppel.mdl_course
					JOIN prepacoppel.mdl_quiz ON (
						(
							prepacoppel.mdl_quiz.course = prepacoppel.mdl_course.id
						)
					)
				)
				JOIN prepacoppel.mdl_quiz_grades ON (
					(
						prepacoppel.mdl_quiz_grades.quiz = prepacoppel.mdl_quiz.id
					)
				)
			)
		WHERE
			(
				prepacoppel.mdl_quiz.course = prepacoppel.mdl_course.id
				and
				prepacoppel.mdl_quiz_grades.userid = a.id
				AND FROM_UNIXTIME(prepacoppel.mdl_quiz_grades.timemodified) < 2016-01-14
			)
	) AS 'numero_examenes_terminados',
	jl_get_materias_terminadas(a.id) AS 'total_materias_terminadas',
	(
		SELECT
			count(
				prepacoppel.ag_calificaciones.id
			)
		FROM
			prepacoppel.ag_calificaciones
		WHERE
			(
				(
					prepacoppel.ag_calificaciones.id_alumno = a.id
				)
				AND (
					prepacoppel.ag_calificaciones.calificacion >= 6
				)
				AND prepacoppel.ag_calificaciones.fecha_ordinario < 2016-01-14
			)
	) AS 'materias_aprobadas',
	(
		SELECT
			count(
				prepacoppel.ag_calificaciones.id
			)
		FROM
			prepacoppel.ag_calificaciones
		WHERE
			(
				(
					prepacoppel.ag_calificaciones.id_alumno = a.id
				)
				AND (
					prepacoppel.ag_calificaciones.calificacion < 6
				)
			)
	) AS 'materias_reprobadas',
	jl_get_materias_activas_by_userid (a.id) AS 'materias_activas',
	(
		SELECT
			FROM_UNIXTIME(
				prepacoppel.mdl_user_enrolments.timecreated
			)
		FROM
			(
				prepacoppel.mdl_user_enrolments
				JOIN prepacoppel.mdl_enrol ON (
					(
						(
							prepacoppel.mdl_enrol.id = prepacoppel.mdl_user_enrolments.enrolid
						)
						AND (
							prepacoppel.mdl_enrol.courseid <= 40
						)
					)
				)
			)
		WHERE
			(
				prepacoppel.mdl_user_enrolments.userid = a.id
			)
		ORDER BY
			FROM_UNIXTIME(
				prepacoppel.mdl_user_enrolments.timecreated
			) DESC
		LIMIT 1
	) AS 'ultima_carga',
	jl_get_materias_disponibles_by_userid (a.id) AS 'materias_disponibles',
	jl_get_disponibilidad_mapa_by_userid (a.id) AS 'mapa',
	jl_get_numero_materias_posible_cargar (a.id) AS 'materias_que_puede_cargar',
	DATE(FROM_UNIXTIME(a.firstaccess)) AS 'primer_acceso',
	DATE(FROM_UNIXTIME(a.lastaccess)) AS 'ultimo_acceso',
	y.estado AS 'estado',
	x.tipo AS 'tipo_estado',
	x.descripcion AS 'descripcion_estado'
FROM
	prepacoppel.mdl_user a INNER JOIN prepacoppel.mdl_user_info_data b ON (b.userid = a.id) AND (b.fieldid = 1) AND (b.data LIKE alumno) INNER JOIN prepacoppel.mdl_user_info_data c ON (c.userid = a.id) AND (c.fieldid = 4) INNER JOIN prepacoppel.mdl_user_info_data d ON (d.userid = a.id) AND (d.fieldid = 5)
	INNER JOIN prepacoppel.mdl_user_info_data e ON (e.userid = a.id) AND (e.fieldid = 10)
	INNER JOIN escolar.tb_personas z ON (z.idmoodle = a.id) AND (z.id_corporacion = 2) 
	INNER JOIN escolar.tb_alumnos y ON (y.id = z.id) AND (y.id_plan_estudio = 2)
	INNER JOIN escolar.tb_alumnos_estados x ON (x.id = y.estado)


 */
	$fecha="2016-01-02";
	if(isset($_GET['fecha']) || !empty($_GET['fecha']) ){
		$fecha= $_GET['fecha'];
	}else{
		$fecha= @date("Y-m-d");
	}

$query_mats="";

$where="													
";
		if($mysql->Connectar()){
			if($res=$mysql->Query("SELECT prepacoppel.mdl_course.id,prepacoppel.mdl_course.fullname,prepacoppel.mdl_course_categories.name FROM prepacoppel.mdl_course inner join prepacoppel.mdl_course_categories on prepacoppel.mdl_course.category=prepacoppel.mdl_course_categories.id WHERE prepacoppel.mdl_course_categories.parent=4 order by prepacoppel.mdl_course_categories.name ASC,prepacoppel.mdl_course.id ASC")){
				$k=0;
							while ($mat=mysql_fetch_array($res)) {
					
									
									$query_mats.=",(
										
											SELECT
												count(
													prepacoppel.mdl_quiz.id
												)
											FROM
												
											 prepacoppel.mdl_quiz
											inner JOIN prepacoppel.mdl_quiz_grades ON prepacoppel.mdl_quiz_grades.quiz = prepacoppel.mdl_quiz.id
											WHERE
												(
													prepacoppel.mdl_quiz.course = '".$mat['id']."'
													and
													prepacoppel.mdl_quiz_grades.userid = prepacoppel.mdl_user.id
													AND FROM_UNIXTIME(prepacoppel.mdl_quiz_grades.timemodified) <= '".$fecha."'
												)
									) as '".$mat['fullname']."' ";

									
									$k++;
								}
				}

			$mysql->Cerrar();
		}



		$query="SELECT prepacoppel.mdl_user.id ,
		prepacoppel.mdl_user.firstname as 'NOMBRES',
		prepacoppel.mdl_user.lastname 'APELLIDOS',
		(select prepacoppel.mdl_user_info_data.data from prepacoppel.mdl_user_info_data where prepacoppel.mdl_user_info_data.userid = prepacoppel.mdl_user.id and prepacoppel.mdl_user_info_data.fieldid = 4 limit 1)  as n_empleado ,
		(select prepacoppel.mdl_user_info_data.data from prepacoppel.mdl_user_info_data where prepacoppel.mdl_user_info_data.userid = prepacoppel.mdl_user.id and prepacoppel.mdl_user_info_data.fieldid = 10 limit 1)  as region ,
		(select count(prepacoppel.ag_calificaciones.id) from prepacoppel.ag_calificaciones where prepacoppel.ag_calificaciones.id_alumno = prepacoppel.mdl_user.id and prepacoppel.ag_calificaciones.id_tipo_examen != 3 and prepacoppel.ag_calificaciones.calificacion>=6) as m_acreditadas ,
		(select count(prepacoppel.ag_calificaciones.id) from prepacoppel.ag_calificaciones where prepacoppel.ag_calificaciones.id_alumno = prepacoppel.mdl_user.id and prepacoppel.ag_calificaciones.calificacion<6 ) as m_reprobadas ,
		(select count(prepacoppel.mdl_user_enrolments.id) from prepacoppel.mdl_user_enrolments inner join prepacoppel.mdl_enrol on prepacoppel.mdl_user_enrolments.enrolid=prepacoppel.mdl_enrol.id inner join prepacoppel.mdl_course on prepacoppel.mdl_course.id=prepacoppel.mdl_enrol.courseid inner join prepacoppel.mdl_course_categories on prepacoppel.mdl_course.category=prepacoppel.mdl_course_categories.id WHERE prepacoppel.mdl_course_categories.parent=4 and prepacoppel.mdl_user_enrolments.status=0 and prepacoppel.mdl_user_enrolments.userid = prepacoppel.mdl_user.id) as m_cargadas_activas ,
		(select from_unixtime(prepacoppel.mdl_user_enrolments.timecreated) from prepacoppel.mdl_user_enrolments where prepacoppel.mdl_user_enrolments.userid = prepacoppel.mdl_user.id ORDER BY prepacoppel.mdl_user_enrolments.timecreated DESC limit 1) as m_ultima_carga ,
		IFNULL((select escolar.tb_alumnos_estados.categoria from escolar.tb_personas 
inner join escolar.tb_alumnos on escolar.tb_personas.id=escolar.tb_alumnos.id_persona 
inner join escolar.tb_alumnos_estados on escolar.tb_alumnos_estados.id=escolar.tb_alumnos.estado
where escolar.tb_alumnos.idmoodle=prepacoppel.mdl_user.id AND escolar.tb_alumnos.id_corporacion=2 limit 1),1)
 as Status ,
 IFNULL((select escolar.tb_alumnos_estados.descripcion from escolar.tb_personas 
inner join escolar.tb_alumnos on escolar.tb_personas.id=escolar.tb_alumnos.id_persona 
inner join escolar.tb_alumnos_estados on escolar.tb_alumnos_estados.id=escolar.tb_alumnos.estado
where escolar.tb_alumnos.idmoodle=prepacoppel.mdl_user.id AND escolar.tb_alumnos.id_corporacion=2 limit 1),' ') as tipo_status
".$query_mats."
  FROM prepacoppel.mdl_user left join prepacoppel.alumnos_cobaes ON prepacoppel.alumnos_cobaes.IdMoodle=prepacoppel.mdl_user.id    WHERE  (select prepacoppel.mdl_user_info_data.data from prepacoppel.mdl_user_info_data where prepacoppel.mdl_user_info_data.fieldid = 1 and prepacoppel.mdl_user_info_data.userid = prepacoppel.mdl_user.id limit 1) = 'alumno'   ORDER BY prepacoppel.mdl_user.id ASC";


		if($mysql->Connectar()){
			if($result_sql=$mysql->Query($query)){

				   	$resultado=array();
				   	$array_report=array();
					$array_titles=array();
					$array_rows=array();

							foreach (array_keys(mysql_fetch_assoc($result_sql)) as $key) {
								array_push($array_rows,$key);
							}
								mysql_data_seek($result_sql, 0); // para que vuelva a recorrer desde la primera fila de resultados

						array_push($resultado,$array_rows);
				   			while($row=mysql_fetch_assoc($result_sql)){
								$i=0;
									$results_row=array();
									foreach ($array_rows as $row_str) {
										array_push($results_row,$row[$row_str]);
										$i++;
									}
									array_push($resultado,$results_row);
								$k++;
							}

				    $table="<table>";
				   
				        //output header row (if at least one row exists)
				    
				        $table.="<tbody>";
				        for ($j=0; $j < count($resultado); $j++) {
			 				$table.="<tr>";
							for ($i=0; $i < count($resultado[$j]); $i++) { 											 				
			 					$table.="<td>".utf8_decode($resultado[$j][$i])."</td>";
			 				}
			  				$table.="</tr>";

				        }
				        $table.="</tbody>";
				        $table.="</table>";


			      echo 	$table;


			}else{

				echo "error0";
			}
			$mysql->Cerrar();

		}else{

			echo "error1";
		}

   	
?>