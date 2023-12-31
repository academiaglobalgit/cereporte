<?php
		require_once "columnas_default.php";
		$id_plan_estudio_columnas = 17;

		array_push($columns_tmp,new Column(3,1,"ingreso","ingreso","IFNULL((select ta.fecha_inscripcion 
				from escolar.tb_alumnos ta WHERE ta.idmoodle=mdl_user.id AND ta.id_plan_estudio=17
				limit 1),' ')", "mdl_user","Fecha Inscripcion") );

	array_push($columns_tmp,new Column(
		140, /*NUMERO DE COLUMNA*/
		1,
		"fecha_migracion",
		"fecha_migracion",
		"IFNULL((
			SELECT
				a.fecha_migracion
			FROM
				escolar.tb_alumnos a
			WHERE
				a.idmoodle = mdl_user.id
				AND a.id_plan_estudio = $id_plan_estudio_columnas
			LIMIT 0, 1
		), 'NO DEFINIDO')",
		"mdl_user",
		"Fecha Migración")
	);

		array_push($columns_tmp,new Column(3,1,"firstname","firstname","IFNULL((select tp.nombre 
				from escolar.tb_personas tp
				inner join escolar.tb_alumnos ta on tp.id = ta.id_persona
				where ta.idmoodle=mdl_user.id 
				AND ta.id_plan_estudio=17
				limit 1),' ')", "mdl_user","Nombre") );


		array_push($columns_tmp,new Column(3,1,"lastname","lastname","IFNULL((select CONCAT(tp.apellido1,' ',tp.apellido2)
				from escolar.tb_personas tp
				inner join escolar.tb_alumnos ta on tp.id = ta.id_persona
				where ta.idmoodle=mdl_user.id 
				AND ta.id_plan_estudio=17
				limit 1),' ')", "mdl_user","Apellido") );



	array_push($columns_tmp,new Column(44,1,"name","Puesto","(select escolar.tb_a1.puesto from escolar.tb_a1 
where escolar.tb_a1.idmoodle=mdl_user.id AND escolar.tb_a1.id_plan_estudios=17 limit 1)
", "mdl_user","Puesto") );
array_push($columns_tmp,new Column(123,1,"data","sexo","(select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.userid = mdl_user.id and mdl_user_info_data.fieldid = 3 limit 1) ", "mdl_user","Sexo",false) );

array_push($columns_tmp,new Column(130,1,"responsable_admision","responsable_admision","IFNULL((select IF(escolar.tb_alumnos.id_usuario_responsable = 210, 'NO DEFINIDO', concat(usu.nombre,' ', ifnull(usu.apellidop,''),' ', ifnull(usu.apellidom,''))) from escolar.tb_alumnos LEFT JOIN escolar.tb_usuarios usu ON usu.id = escolar.tb_alumnos.id_usuario_responsable
				where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=17 limit 1),'')", "mdl_user","Responsable Admisión Inscripción") );	
				array_push($columns_tmp,new Column(131,1,"responsable_gestion","responsable_gestion","IFNULL((select IF (log.id = 210, 'NO DEFINIDO', concat(usu.nombre, ' ', ifnull( usu.apellidop, '' ), ' ', ifnull( usu.apellidom, '' ))) FROM escolar.tb_alumnos LEFT JOIN escolar.tb_alumnos_a1 log on log.id = escolar.tb_alumnos.id_alumno_a1 LEFT JOIN escolar.tb_usuarios usu ON usu.id = log.id_usuario_registra 
				WHERE escolar.tb_alumnos.idmoodle = mdl_user.id  AND escolar.tb_alumnos.id_plan_estudio = 17 LIMIT 1),'NO DEFINIDO')", "mdl_user","Responsable Gestión Escolar Inscripción") );

array_push($columns_tmp,new Column(44,1,"name","examenes_hechos","( SELECT
count(mdl_scorm_scoes_track.id)
FROM
mdl_scorm_scoes_track
INNER JOIN
mdl_scorm
ON
mdl_scorm.id=mdl_scorm_scoes_track.scormid
INNER JOIN
mdl_course_modules
ON
mdl_course_modules.course=mdl_scorm.course
AND
mdl_course_modules.instance=mdl_scorm.id
INNER JOIN
mdl_course_sections
ON
mdl_course_sections.id=mdl_course_modules.section
AND
mdl_course_sections.section=3

WHERE
mdl_scorm_scoes_track.userid=mdl_user.id

AND
mdl_scorm_scoes_track.element='cmi.core.lesson_status'
AND
(
mdl_scorm_scoes_track.`value`='passed'
OR
mdl_scorm_scoes_track.`value`='failed' )) 
", "mdl_user","Exams. Hechos") );

					array_push($columns_tmp,new Column(4,1,"suspended","Status","IFNULL((select escolar.tb_alumnos_estados.nombre_categoria from escolar.tb_personas 
inner join escolar.tb_alumnos on escolar.tb_personas.id=escolar.tb_alumnos.id_persona 
inner join escolar.tb_alumnos_estados on escolar.tb_alumnos_estados.id=escolar.tb_alumnos.estado
where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=17 limit 1),1)
", "mdl_user","Status",true) );

		array_push($columns_tmp,new Column(4,1,"tipo_status","tipo_status","IFNULL((select escolar.tb_alumnos_estados.descripcion from escolar.tb_personas 
inner join escolar.tb_alumnos on escolar.tb_personas.id=escolar.tb_alumnos.id_persona 
inner join escolar.tb_alumnos_estados on escolar.tb_alumnos_estados.id=escolar.tb_alumnos.estado
where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=17 limit 1),' ')", "mdl_user","Descripcion status") );


		array_push($columns_tmp,new Column(5,1,"suspended","Status","IFNULL((select escolar.tb_alumnos_estados.nombre_categoria from escolar.tb_personas 
inner join escolar.tb_alumnos on escolar.tb_personas.id=escolar.tb_alumnos.id_persona 
inner join escolar.tb_alumnos_estados on escolar.tb_alumnos_estados.id=escolar.tb_alumnos.estado
where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=17 limit 1),1)
", "mdl_user","Categoria Status",false) );

	array_push($columns_tmp,new Column(14,1,"fecha_status","fecha_status","IFNULL((select escolar.tb_alumnos_estados_log.fecha from escolar.tb_personas 
inner join escolar.tb_alumnos on escolar.tb_personas.id=escolar.tb_alumnos.id_persona and  escolar.tb_alumnos.id_plan_estudio = 17
inner join escolar.tb_alumnos_estados_log on escolar.tb_alumnos_estados_log.id_alumno=escolar.tb_alumnos.id
where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=17 order by escolar.tb_alumnos_estados_log.fecha DESC limit 1),' ')", "mdl_user","Fecha status") );
	/*
	array_push($columns_tmp,new Column(6,1,"data","n_empleado","(select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.userid = mdl_user.id and mdl_user_info_data.fieldid = 4 limit 1) ", "mdl_user","Estafeta",true) );
	*/
		//columna tipo 1
	array_push($columns_tmp,new Column(6,1,"n_empleado","n_empleado","IFNULL((select escolar.tb_alumnos.numero_empleado from escolar.tb_alumnos
	where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=17 limit 1),' ')", "mdl_user","#Empleado",true) );	


		array_push($columns_tmp,new Column(7,1,"region","region","(select tb_regiones.nombre from escolar.tb_alumnos inner join escolar.tb_personas on tb_personas.id = tb_alumnos.id_persona and tb_alumnos.id_plan_estudio = 17 inner join escolar.tb_regiones on tb_regiones.id = tb_personas.region where tb_alumnos.idmoodle = mdl_user.id limit 1) ", "mdl_user","Region") );
	/*
		array_push($columns_tmp,new Column(7,1,"data","region","(select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.userid = mdl_user.id and mdl_user_info_data.fieldid = 10 limit 1) ", "mdl_user","Region",true) );
	*/
				
		$columna= new Column(13,2,"data","materias_agsocial","SELECT mdl_course.id,mdl_course.fullname,mdl_course_categories.name FROM mdl_course inner join mdl_course_categories on mdl_course.category=mdl_course_categories.id WHERE mdl_course_categories.parent=4 order by mdl_course_categories.name ASC,mdl_course.id ASC", "mdl_user","Materias");
		
		
		if($mysql->Connectar()){
			if($res=$mysql->Query($columna->subsql)){
				$k=0;
				while ($mat=mysql_fetch_array($res)) {
					
					//$columna->subcolumns[$k] = new Column(0,1,"data","mat_cop_".$mat['id']." ","IFNULL((select TRUNCATE(ag_calificaciones.calificacion,1) from ag_calificaciones where ag_calificaciones.id_alumno = mdl_user.id and ag_calificaciones.id_materia='".$mat['id']."' limit 1),'0.0')", "mdl_user",$mat['fullname']) ;
					//array_push($columns_tmp,new Column(0,1,"data","mat_cop_".$mat['id']." ","IFNULL((select TRUNCATE(ag_calificaciones.calificacion,1) from ag_calificaciones where ag_calificaciones.id_alumno = mdl_user.id and ag_calificaciones.id_materia='".$mat['id']."' limit 1),'0.0')", "mdl_user",$mat['fullname']) ) ;
					

					//SACA LA CALIFICACION
					$query_calif="IFNULL(
									round(agc_".$mat['id'].".calificacion,1),
									IF(
										(select count(ue.id) from mdl_user_enrolments ue INNER JOIN mdl_enrol me ON me.id=ue.enrolid WHERE ue.userid=mdl_user.id AND me.courseid=".$mat['id'].") =0,
										'Por Cursar',
										IF(	
											(select ue.status from mdl_user_enrolments ue INNER JOIN mdl_enrol me ON me.id=ue.enrolid WHERE ue.userid=mdl_user.id AND me.courseid=".$mat['id']." )=0,
											'En Proceso',
											'Sin Calificacion'
										)
									)
								) ";

					//SACA NUMERO DE EXAMENES HECHOS (SCORM)

					$query_scorm_ex="(select count(ag_scorm.id_modulo)
                    from ag_scorm
                    inner join mdl_scorm on mdl_scorm.id = ag_scorm.id
                    where mdl_scorm.course = '".$mat['id']."'
                    and id_tipo=2
                    and ag_scorm.id IN(
                            select mdl_scorm_scoes_track.scormid
                            from mdl_scorm_scoes_track
                            inner join mdl_scorm on mdl_scorm_scoes_track.scormid = mdl_scorm.id
                            inner join ag_scorm on ag_scorm.id = mdl_scorm_scoes_track.scormid
                            where userid = mdl_user.id
                            AND course = '".$mat['id']."'
                            and (id_tipo=2 or id_tipo=3)
                            and element = 'cmi.core.lesson_status'
                            AND (mdl_scorm_scoes_track.value='failed' or mdl_scorm_scoes_track.value='passed' or mdl_scorm_scoes_track.value='completed')
                          group by mdl_scorm_scoes_track.scormid
                    )
                    order by ag_scorm.secuencia,ag_scorm.id
                  limit 1)";


						
					$columna->subcolumns[$k] = new Column(0,1,$query_calif,"mat_".$mat['id'],
					" LEFT JOIN ag_calificaciones agc_".$mat['id']." ON agc_".$mat['id'].".id_alumno = mdl_user.id AND agc_".$mat['id'].".id_materia=".$mat['id']." ", "mdl_user",$mat['fullname']) ;
					
					$k++;
				}
			}

			$mysql->Cerrar();
		}




	$columna2= new Column(133,2,"data","ex_materias_agsocial","SELECT mdl_course.id,mdl_course.fullname,mdl_course_categories.name FROM mdl_course inner join mdl_course_categories on mdl_course.category=mdl_course_categories.id WHERE mdl_course_categories.parent=4 order by mdl_course_categories.name ASC,mdl_course.id ASC", "mdl_user","Exame. Materias");


	if($mysql->Connectar()){
			if($res2=$mysql->Query($columna2->subsql)){
				$k=0;
				while ($mat2=mysql_fetch_array($res2)) {
					
		

                  $query_scorm_ex_generic="( SELECT
count(mdl_scorm_scoes_track.id)
FROM
mdl_scorm_scoes_track
INNER JOIN
mdl_scorm
ON
mdl_scorm.id=mdl_scorm_scoes_track.scormid
INNER JOIN
mdl_course_modules
ON
mdl_course_modules.course=mdl_scorm.course
AND
mdl_course_modules.instance=mdl_scorm.id
INNER JOIN
mdl_course_sections
ON
mdl_course_sections.id=mdl_course_modules.section
AND
mdl_course_sections.section=3
and 
mdl_scorm.course='".$mat2['id']."'
WHERE
mdl_scorm_scoes_track.userid=mdl_user.id

AND
mdl_scorm_scoes_track.element='cmi.core.lesson_status'
AND
(
mdl_scorm_scoes_track.`value`='passed'
OR
mdl_scorm_scoes_track.`value`='failed' )) ";


					$columna2->subcolumns[$k]= new Column(0,1,$query_scorm_ex_generic ,"ex_mat_".$mat2['id'],"", "mdl_user",$mat2['fullname'] );


					$k++;
				}
			}

			$mysql->Cerrar();
		}




		array_push($columns_tmp,$columna);
				array_push($columns_tmp,$columna2);

		array_push($columns_tmp,new Column(14,1,"periodos_terminados","periodos_terminados","(select rv_get_periodo_actual(mdl_user.id) )", "mdl_user","Periodos Terminados") );
		array_push($columns_tmp,new Column(15,1,"numero_telefonico","numero_telefonico","IFNULL((SELECT tnt.numero_telefonico FROM escolar.tb_numeros_telefonicos tnt inner join escolar.tb_alumnos ta on tnt.id_alumno=ta.id WHERE  tnt.eliminado=0 and ta.idmoodle=mdl_user.id and ta.id_plan_estudio=17  order by tnt.id DESC limit 1),'SIN NUMERO')", "mdl_user","Numero Telefonico") );

		#JAIME ALBERTO LOPEZ ZAZUETA
		#05 DE OCTUBRE DE 2018
		$querisillo = "
			SELECT
				tb_personas.curp
			FROM
				escolar.tb_alumnos
				INNER JOIN escolar.tb_personas ON tb_personas.id = tb_alumnos.id_persona AND tb_alumnos.id_plan_estudio = 17
				INNER JOIN escolar.tb_regiones ON tb_regiones.id = tb_personas.region
			WHERE
				tb_alumnos.idmoodle = mdl_user.id
			LIMIT 1
		";
		array_push($columns_tmp,new Column(23, 1, "curp", "curp", "(".$querisillo.")", "mdl_user", "CURP"));

		$querisillo = "
			SELECT
				DATE(tb_personas.fecha_nacimiento)
			FROM
				escolar.tb_alumnos
				INNER JOIN escolar.tb_personas ON tb_personas.id = tb_alumnos.id_persona AND tb_alumnos.id_plan_estudio = 17
				INNER JOIN escolar.tb_regiones ON tb_regiones.id = tb_personas.region
			WHERE
				tb_alumnos.idmoodle = mdl_user.id
			LIMIT 1
		";

	array_push($columns_tmp,new Column(23, 1, "fecha_nacimiento", "fecha_nacimiento", "(".$querisillo.")", "mdl_user", "FECHA DE NACIMIENTO"));

	array_push($columns_tmp,new Column(998,1,"periodo_inscripcion","periodo_inscripcion","IFNULL((select periodo_inscripcion from escolar.tb_alumnos where id_plan_estudio = 17 and tb_alumnos.idmoodle =  mdl_user.id LIMIT 1) ,' ')", "mdl_user","Periodo Inscripcion"));

	array_push($columns_tmp, new Column(
		999, 
		1, 
		"promedio_general", 
		"promedio_general", 
		"IFNULL((SELECT COALESCE(FORMAT((SUM(IF(f.calificacion > 10, (f.calificacion * 0.1), f.calificacion))/COUNT(id)), 2), 0) FROM agsocial.ag_calificaciones f WHERE f.id_alumno = mdl_user.id) ,' ')", 
		"mdl_user",
		"Promedio General")
	);

	
	array_push($columns_tmp, new Column(
		1000, 
		1, 
		"periodo_actual", 
		"periodo_actual", 
		"COALESCE((SELECT MAX(j.periodo) FROM agsocial.mdl_user_enrolments g INNER JOIN agsocial.mdl_enrol h ON h.id = g.enrolid INNER JOIN escolar.tb_materias_ids i ON i.id_moodle = h.courseid AND i.id_plan_estudio = 17 INNER JOIN escolar.tb_materias j ON j.id = i.id_materia WHERE g.userid = mdl_user.id), 0)", 
		"mdl_user", 
		"Periodo Actual")
	);

	#==============================================================================================
	#A PARTIR DE AQUI FAVOR DE LLEVAR UNA NUMERACION SECUENCIAL DEL NUMERO DE COLUMNA
	array_push($columns_tmp,new Column(
		100, /*NUMERO DE COLUMNA*/
		1,
		"fecha_primera_carga",
		"fecha_primera_carga",
		"IFNULL((SELECT
				tapc.fecha_primera_carga
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'SIN CARGA')", 
		"mdl_user",
		"Fecha de Primera Carga")
	);

	array_push($columns_tmp,new Column(
		101, /*NUMERO DE COLUMNA*/
		1,
		"nombre_materia_primera_carga",
		"nombre_materia_primera_carga",
		"IFNULL((SELECT
				tm.nombre
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
				INNER JOIN escolar.tb_materias tm ON tm.id = tapc.id_materia_primera_carga
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'SIN CARGA')", 
		"mdl_user",
		"Nombre de Primera Carga")
	);

	array_push($columns_tmp,new Column(
		102, /*NUMERO DE COLUMNA*/
		1,
		"materias_posibles_cargar",
		"materias_posibles_cargar",
		"IFNULL((SELECT
				tapc.posibles_cargar
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Materias Posibles Cargar")
	);

	array_push($columns_tmp,new Column(
		103, /*NUMERO DE COLUMNA*/
		1,
		"peticiones_solicitadas",
		"peticiones_solicitadas",
		"IFNULL((SELECT
				tapc.peticiones_solicitadas
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Peticiones Solicitadas")
	);

	array_push($columns_tmp,new Column(
		104, /*NUMERO DE COLUMNA*/
		1,
		"cargas_mensuales",
		"cargas_mensuales",
		"IFNULL((SELECT
				tapc.cargas_mensuales
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Cargas del mes")
	);

	array_push($columns_tmp,new Column(
		105, /*NUMERO DE COLUMNA*/
		1,
		"cargas_totales",
		"cargas_totales",
		"IFNULL((SELECT
				tapc.cargas_totales
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Cargas totales")
	);

	array_push($columns_tmp,new Column(
		106, /*NUMERO DE COLUMNA*/
		1,
		"equivalencias_mensuales",
		"equivalencias_mensuales",
		"IFNULL((SELECT
				tapc.equivalencias_mensuales
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Equivalencias del mes")
	);

	array_push($columns_tmp,new Column(
		106, /*NUMERO DE COLUMNA*/
		1,
		"cargas_habilitadas",
		"cargas_habilitadas",
		"IFNULL((SELECT
				tapc.cargas_habilitadas
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Cargas habilitadas")
	);

	array_push($columns_tmp,new Column(
		107, /*NUMERO DE COLUMNA*/
		1,
		"cursos_terminados",
		"cursos_terminados",
		"IFNULL((SELECT
				tapc.cursos_terminados
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Cursos terminados")
	);

	array_push($columns_tmp,new Column(
		108, /*NUMERO DE COLUMNA*/
		1,
		"cursos_aprobados",
		"cursos_aprobados",
		"IFNULL((SELECT
				tapc.cursos_aprobados
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Cursos aprobados")
	);

	array_push($columns_tmp,new Column(
		109, /*NUMERO DE COLUMNA*/
		1,
		"cursos_reprobados",
		"cursos_reprobados",
		"IFNULL((SELECT
				tapc.cursos_reprobados
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Cursos reprobados")
	);

	array_push($columns_tmp,new Column(
		110, /*NUMERO DE COLUMNA*/
		1,
		"periodo_cursando",
		"periodo_cursando",
		"IFNULL((SELECT
				tapc.periodo_cursando
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Periodo cursando")
	);

	array_push($columns_tmp,new Column(
		111, /*NUMERO DE COLUMNA*/
		1,
		"ultimo_periodo_terminado",
		"ultimo_periodo_terminado",
		"IFNULL((SELECT
				tapc.ultimo_periodo_terminado
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_alumnos_posibles_cargar tapc ON tapc.id_alumno = ta.id AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Último periodo terminado")
	);

	array_push($columns_tmp,new Column(
		112, /*NUMERO DE COLUMNA*/
		1,
		"email",
		"email",
		"IFNULL((SELECT
				tp.email
			FROM
				escolar.tb_alumnos ta 
				INNER JOIN escolar.tb_personas tp ON tp.id = ta.id_persona AND ta.id_plan_estudio = $id_plan_estudio_columnas
			WHERE
				ta.idmoodle = mdl_user.id
			LIMIT 1), 'NO DEFINIDO')", 
		"mdl_user",
		"Correo electrónico")
	);

	array_push($columns_tmp,new Column(
		113, /*NUMERO DE COLUMNA*/
		1,
		"telefono_1",
		"telefono_1",
		"IFNULL((SELECT
				b.numero_telefonico AS 'telefono_1'
			FROM
				escolar.tb_alumnos a
				INNER JOIN escolar.tb_numeros_telefonicos b ON b.id_alumno = a.id
				INNER JOIN escolar.tb_numeros_telefonicos_tipos c ON c.id = b.id_tipo
			WHERE
				a.idmoodle = mdl_user.id
				AND a.id_plan_estudio = $id_plan_estudio_columnas
			ORDER BY
				b.fecha_alta DESC
			LIMIT 0, 1), 'NO DEFINIDO')",
		"mdl_user",
		"Teléfono 1")
	);

	array_push($columns_tmp,new Column(
		114, /*NUMERO DE COLUMNA*/
		1,
		"telefono_2",
		"telefono_2",
		"IFNULL((SELECT
				b.numero_telefonico AS 'telefono_2'
			FROM
				escolar.tb_alumnos a
				INNER JOIN escolar.tb_numeros_telefonicos b ON b.id_alumno = a.id
				INNER JOIN escolar.tb_numeros_telefonicos_tipos c ON c.id = b.id_tipo
			WHERE
				a.idmoodle = mdl_user.id
				AND a.id_plan_estudio = $id_plan_estudio_columnas
			ORDER BY
				b.fecha_alta DESC
			LIMIT 1, 1), 'NO DEFINIDO')",
		"mdl_user",
		"Teléfono 2")
	);

	array_push($columns_tmp,new Column(
		115, /*NUMERO DE COLUMNA*/
		1,
		"telefono_3",
		"telefono_3",
		"IFNULL((SELECT
				b.numero_telefonico AS 'telefono_3'
			FROM
				escolar.tb_alumnos a
				INNER JOIN escolar.tb_numeros_telefonicos b ON b.id_alumno = a.id
				INNER JOIN escolar.tb_numeros_telefonicos_tipos c ON c.id = b.id_tipo
			WHERE
				a.idmoodle = mdl_user.id
				AND a.id_plan_estudio = $id_plan_estudio_columnas
			ORDER BY
				b.fecha_alta DESC
			LIMIT 2, 1), 'NO DEFINIDO')",
		"mdl_user",
		"Teléfono 3")
	);

	array_push($columns_tmp,new Column(
		116, /*NUMERO DE COLUMNA*/
		1,
		"empresa",
		"empresa",
		"IFNULL((SELECT
				b.nombre as 'empresa'
			FROM
				escolar.tb_alumnos a
				INNER JOIN escolar.tb_empresas b ON b.id = a.id_empresa
			WHERE
				a.idmoodle = mdl_user.id
				AND a.id_plan_estudio = $id_plan_estudio_columnas
			LIMIT 0,1), 'NO DEFINIDO')",
		"mdl_user",
		"Empresa")
	);

	array_push($columns_tmp,new Column(
		117, /*NUMERO DE COLUMNA*/
		1,
		"precio_inscripcion",
		"precio_inscripcion",
		"IFNULL((SELECT b.precio_inscripcion as 'precio_inscripcion'
		FROM
			escolar.tb_alumnos b 
		WHERE
			b.idmoodle = mdl_user.id
			AND b.id_plan_estudio = $id_plan_estudio_columnas
		LIMIT 0,1), 'NO DEFINIDO')",
		"mdl_user",
		"Precio inscripcion")
	);

	array_push($columns_tmp,new Column(
		118, /*NUMERO DE COLUMNA*/
		1,
		"precio_materia",
		"precio_materia",
		"IFNULL((SELECT a.precio_materia as 'precio_materia'
		FROM
			escolar.tb_alumnos a 
		WHERE
			a.idmoodle = mdl_user.id
			AND a.id_plan_estudio = $id_plan_estudio_columnas
		LIMIT 0,1), 'NO DEFINIDO')",
		"mdl_user",
		"Precio materia")
	);

	array_push($columns_tmp,new Column(
		119, /*NUMERO DE COLUMNA*/
		1,
		"institucion_actual",
		"institucion_actual",
		"IFNULL((SELECT	
				c.nombre as 'institucion_actual'
		FROM
			escolar.tb_alumnos a 
			INNER JOIN escolar.tb_corporaciones c ON c.id = a.id_corporacion
		WHERE
			a.idmoodle = mdl_user.id
			AND a.id_plan_estudio = $id_plan_estudio_columnas
		LIMIT 0,1), 'NO DEFINIDO')",
		"mdl_user",
		"Institucion actual")
	);

	array_push($columns_tmp,new Column(
		120, /*NUMERO DE COLUMNA*/
		1,
		"institucion_vieja",
		"institucion_vieja",
		"IFNULL((SELECT	d.nombre as 'institucion_vieja'
		FROM
			escolar.tb_alumnos a 
			
			INNER JOIN escolar.tb_alumnos_migraciones_log b ON b.id_alumno = a.id
			INNER JOIN escolar.tb_alumnos c ON c.id = b.id_alumno_plan_anterior
			INNER JOIN escolar.tb_corporaciones d ON d.id = c.id_corporacion
		WHERE
			a.idmoodle = mdl_user.id
			AND a.id_plan_estudio = $id_plan_estudio_columnas
		LIMIT 0,1), 'EXTERNA')",
		"mdl_user",
		"Institucion vieja")
	);


	array_push($columns_tmp,new Column(
		121, /*NUMERO DE COLUMNA*/
		1,
		"familiar",
		"familiar",
		"IFNULL((SELECT b.nombre as 'familiar'
		FROM
			escolar.tb_alumnos a 
			INNER JOIN escolar.tb_colaborador_familiares b ON b.id = a.id_colaborador_familiar
		WHERE
			a.idmoodle = mdl_user.id
			AND a.id_plan_estudio = $id_plan_estudio_columnas
		LIMIT 0,1), 'NO DEFINIDO')",
		"mdl_user",
		"Familiar")
	);

	array_push($columns_tmp,new Column(
		129, /*NUMERO DE COLUMNA*/
		1,
		"expediente",
		"expediente",
		"IFNULL((SELECT
				b.descripcion as 'expediente'
			FROM
				escolar.tb_alumnos a
				INNER JOIN escolar.tb_alumnos_expedientes b ON b.id = a.id_expediente
			WHERE
				a.idmoodle = mdl_user.id
				AND a.id_plan_estudio = $id_plan_estudio_columnas
			LIMIT 0,1), 'NO DEFINIDO')",
		"mdl_user",
		"Expediente")
	);
	
?>