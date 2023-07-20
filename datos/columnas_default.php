<?php
		require_once "../models/column.class.php";

		$columns_tmp= array();
		array_push($columns_tmp,new Column(1,0,"id","id","(select 0 )", "mdl_user","Id",true) );
		array_push($columns_tmp,new Column(111,0,"username","username","(select 0 )", "mdl_user","Usuario") );



		//  array_push($columns_tmp,new Column(2,0,"firstname","firstname","(select 0 )", "mdl_user","Nombre") );
		//  array_push($columns_tmp,new Column(3,0,"lastname","lastname","(select 0 )", "mdl_user","Apellido") );

		// array_push($columns_tmp,new Column(122,0,"email","email","(select 0 )", "mdl_user","Correo Electrónico") );


		//array_push($columns_tmp,new Column(5,1,"ingreso","ingreso"," date(from_unixtime(mdl_user.timecreated)) ", "mdl_user","Fecha Inscripcion") );
		//array_push($columns_tmp,new Column(5,1,"registro","registro"," date(from_unixtime(mdl_user.timecreated)) ", "mdl_user","Fecha Registro") );
		//array_push($columns_tmp,new Column(12,0,"inscripcion","inscripcion"," DATE(fecha_inscripcion) ", "tb_alumnos","Fecha Inscripcion") );

		array_push($columns_tmp,new Column(7,0,"city","city","(select 0)", "mdl_user","Ciudad") );

		array_push($columns_tmp,new Column(9,1,"data","m_cargadas_activas","(select count(mdl_user_enrolments.id) from mdl_user_enrolments inner join mdl_enrol on mdl_user_enrolments.enrolid=mdl_enrol.id inner join mdl_course on mdl_course.id=mdl_enrol.courseid inner join mdl_course_categories on mdl_course.category=mdl_course_categories.id WHERE mdl_course_categories.visible=1 and mdl_course.visible=1 and mdl_course_categories.parent=4 and mdl_user_enrolments.status=0 and mdl_user_enrolments.userid = mdl_user.id)", "mdl_user","Cargas Activas") );
			// array_push($columns_tmp,new Column(99,1,"data","m_cargadas_concluidas","(select count(mdl_user_enrolments.id) from mdl_user_enrolments inner join mdl_enrol on mdl_user_enrolments.enrolid=mdl_enrol.id inner join mdl_course on mdl_course.id=mdl_enrol.courseid inner join mdl_course_categories on mdl_course.category=mdl_course_categories.id WHERE mdl_course_categories.visible=1 and mdl_course.visible=1 and mdl_course_categories.parent=4 and mdl_user_enrolments.status=1 and mdl_user_enrolments.userid = mdl_user.id)", "mdl_user","Cargas Concluidas") );

		// 12-09-2022: SE CAMBIO CARGAS CONCLUIDAS - ADRIANA HERNANDEZ
		array_push($columns_tmp,new Column(
			99, /*NUMERO DE COLUMNA*/
			1,
			"m_cargadas_concluidas",
			"m_cargadas_concluidas",
			"IFNULL((
				SELECT
					COUNT(*)
				FROM
					ag_calificaciones
				WHERE
					id_alumno = mdl_user.id
			), '0')", 
			"mdl_user",
			"Cargas Concluidas")
		);

		array_push($columns_tmp,new Column(9,1,"data","m_cargadastotal","(select count(mdl_user_enrolments.id) from mdl_user_enrolments inner join mdl_enrol on mdl_user_enrolments.enrolid=mdl_enrol.id inner join mdl_course on mdl_course.id=mdl_enrol.courseid inner join mdl_course_categories on mdl_course.category=mdl_course_categories.id WHERE mdl_course_categories.parent=4 and mdl_course_categories.visible=1 and mdl_course.visible=1 and mdl_user_enrolments.userid = mdl_user.id)", "mdl_user","Cargas Totales") );

		array_push($columns_tmp,new Column(10,1,"data","m_acreditadas","(select count(ag_calificaciones.id) from ag_calificaciones where ag_calificaciones.id_alumno = mdl_user.id and ag_calificaciones.calificacion>=6)", "mdl_user","Acreditadas") );

		array_push($columns_tmp,new Column(11,1,"data","m_equiv","(select count(ag_calificaciones.id) from ag_calificaciones where ag_calificaciones.id_alumno = mdl_user.id and ag_calificaciones.id_tipo_examen = 3)", "mdl_user","Equivalencias") );
		array_push($columns_tmp,new Column(11,1,"data","m_repro","(select count(ag_calificaciones.id) from ag_calificaciones where ag_calificaciones.id_alumno = mdl_user.id and ag_calificaciones.calificacion<6 )", "mdl_user","Reprobadas") );
		//array_push($columns_tmp,new Column(12,1,"data","m_total_acreditadas","(select count(ag_calificaciones.id) from ag_calificaciones where ag_calificaciones.id_alumno = mdl_user.id and ag_calificaciones.calificacion>=6)", "mdl_user","Total Acreditadas y Equiv") );

		array_push($columns_tmp,new Column(9,1,"data","m_ultima_carga","(select from_unixtime(mdl_user_enrolments.timecreated) from mdl_user_enrolments where mdl_user_enrolments.userid = mdl_user.id ORDER BY mdl_user_enrolments.timecreated DESC limit 1)", "mdl_user","Fecha Ultima Carga") );

		array_push($columns_tmp,new Column(99,1,"data","m_ultima_terminada","(SELECT fecha_registro FROM ag_calificaciones WHERE id_alumno = mdl_user.id ORDER BY fecha_registro DESC LIMIT 1)", "mdl_user","Fecha Ultima Terminada") );

		
		array_push($columns_tmp,new Column(999,1,"lastlogin","lastlogin"," IF(YEAR(from_unixtime(mdl_user.lastlogin)) = 1969, '', from_unixtime(mdl_user.lastlogin))", "mdl_user","Ultimo Login") );
		array_push($columns_tmp,new Column(9999,1,"lastaccess","lastaccess"," IF(YEAR(from_unixtime(mdl_user.lastaccess)) = 1969, '', from_unixtime(mdl_user.lastaccess))", "mdl_user","Ultimo Acceso") );

?>
