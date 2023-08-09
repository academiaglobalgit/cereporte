<?php 
	//INCLUDE OBLIGATORIO incluye columnas por default para cada plataforma de modle (nombre apellido, id,username,etc) aqui se encuenta el array de columnas inicializado llamado $columns_tmp
	require_once "columnas_default.php";
	$id_plan_estudio_columnas = 16;

	/*AGREGAR COLUMNAS PERSONALIZADAS */

	array_push($columns_tmp,new Column(3,1,"ingreso","ingreso","IFNULL((select ta.fecha_inscripcion 
		from escolar.tb_alumnos ta where ta.idmoodle=mdl_user.id AND ta.id_plan_estudio = 16 limit 1),' ')", "mdl_user","Fecha Inscripcion") );

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
				AND ta.id_plan_estudio = 16
				limit 1),' ')", "mdl_user","Nombre") );


		array_push($columns_tmp,new Column(3,1,"lastname","lastname","IFNULL((select CONCAT(tp.apellido1,' ',tp.apellido2)
				from escolar.tb_personas tp
				inner join escolar.tb_alumnos ta on tp.id = ta.id_persona
				where ta.idmoodle=mdl_user.id 
				AND ta.id_plan_estudio = 16
				limit 1),' ')", "mdl_user","Apellido") );

		array_push($columns_tmp,new Column(130,1,"responsable_inscripcion","responsable_inscripcion","IFNULL((select IF(escolar.tb_alumnos.id_usuario_responsable = 210, 'NO DEFINIDO', concat(usu.nombre,' ', ifnull(usu.apellidop,''),' ', ifnull(usu.apellidom,''))) from escolar.tb_alumnos LEFT JOIN escolar.tb_usuarios usu ON usu.id = escolar.tb_alumnos.id_usuario_responsable
				where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=16 limit 1),'')", "mdl_user","Responsable Inscripcion") );	

	//columna tipo 0  ()
	array_push($columns_tmp,new Column(3,0,"suspended","suspended","(select 0 )", "mdl_user","Status",false) );

	array_push($columns_tmp,new Column(4,1,"tipo_status","tipo_status","IFNULL((select escolar.tb_alumnos_estados.descripcion from escolar.tb_personas 
inner join escolar.tb_alumnos on escolar.tb_personas.id=escolar.tb_alumnos.id_persona 
inner join escolar.tb_alumnos_estados on escolar.tb_alumnos_estados.id=escolar.tb_alumnos.estado
where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=16 limit 1),' ')", "mdl_user","Descripcion status") );


		array_push($columns_tmp,new Column(5,1,"suspended","Status","IFNULL((select escolar.tb_alumnos_estados.nombre_categoria from escolar.tb_personas 
inner join escolar.tb_alumnos on escolar.tb_personas.id=escolar.tb_alumnos.id_persona 
inner join escolar.tb_alumnos_estados on escolar.tb_alumnos_estados.id=escolar.tb_alumnos.estado
where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=16 limit 1),1)
", "mdl_user","Categoria Status",false) );


	//columna tipo 1 
	/*
	array_push($columns_tmp,new Column(6,1,"data","n_empleado","(select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.userid = mdl_user.id and mdl_user_info_data.fieldid = 4 limit 1) ", "mdl_user","#Empleado",true) );
	*/

	array_push($columns_tmp,new Column(6,1,"n_empleado","n_empleado","IFNULL((select escolar.tb_alumnos.numero_empleado from escolar.tb_alumnos
	where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=16 limit 1),' ')", "mdl_user","#Empleado",true) );	

	array_push($columns_tmp,new Column(8,1,"region","region","(select tb_regiones.nombre from escolar.tb_alumnos inner join escolar.tb_personas on tb_personas.id = tb_alumnos.id_persona and tb_alumnos.id_plan_estudio = 16 inner join escolar.tb_regiones on tb_regiones.id = tb_personas.region where tb_alumnos.idmoodle = mdl_user.id limit 1) ", "mdl_user","Region") );


	array_push($columns_tmp,new Column(14,1,"fecha_status","fecha_status","IFNULL((select escolar.tb_alumnos_estados_log.fecha from escolar.tb_personas 
inner join escolar.tb_alumnos on escolar.tb_personas.id=escolar.tb_alumnos.id_persona and  escolar.tb_alumnos.id_plan_estudio = 16
inner join escolar.tb_alumnos_estados_log on escolar.tb_alumnos_estados_log.id_alumno=escolar.tb_alumnos.id
where escolar.tb_alumnos.idmoodle=mdl_user.id AND escolar.tb_alumnos.id_plan_estudio=16 order by escolar.tb_alumnos_estados_log.fecha DESC limit 1),' ')", "mdl_user","Fecha status",false) );

	#JAIME ALBERTO LOPEZ ZAZUETA
		#05 DE OCTUBRE DE 2018
		$querisillo = "
			SELECT
				tb_personas.curp
			FROM
				escolar.tb_alumnos
				INNER JOIN escolar.tb_personas ON tb_personas.id = tb_alumnos.id_persona AND tb_alumnos.id_plan_estudio = 16
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
				INNER JOIN escolar.tb_personas ON tb_personas.id = tb_alumnos.id_persona AND tb_alumnos.id_plan_estudio = 16
				INNER JOIN escolar.tb_regiones ON tb_regiones.id = tb_personas.region
			WHERE
				tb_alumnos.idmoodle = mdl_user.id
			LIMIT 1
		";
		array_push($columns_tmp,new Column(23, 1, "fecha_nacimiento", "fecha_nacimiento", "(".$querisillo.")", "mdl_user", "FECHA DE NACIMIENTO"));

		array_push($columns_tmp,new Column(24,1,"id","id", "IFNULL((SELECT sxx.id FROM escolar.tb_personas pxx 
			INNER JOIN escolar.tb_alumnos axx ON pxx.id = axx.id_persona 
			INNER JOIN escolar.tb_sucursales sxx ON  pxx.sucursal = sxx.id
			WHERE axx.idmoodle = mdl_user.id AND axx.id_plan_estudio = 16 LIMIT 1), 0)", "tb_sucursales", "Clave sucursal"));
		array_push($columns_tmp,new Column(25,1,"nombre","nombre", "IFNULL((SELECT sxx.nombre FROM escolar.tb_personas pxx 
			INNER JOIN escolar.tb_alumnos axx ON pxx.id = axx.id_persona 
			INNER JOIN escolar.tb_sucursales sxx ON  pxx.sucursal = sxx.id
			WHERE axx.idmoodle = mdl_user.id AND axx.id_plan_estudio = 16 LIMIT 1), '')", "tb_sucursales", "Nombre sucursal"));

			array_push($columns_tmp,new Column(998,1,"periodo_inscripcion","periodo_inscripcion","IFNULL((select periodo_inscripcion from escolar.tb_alumnos where id_plan_estudio = 16 and tb_alumnos.idmoodle =  mdl_user.id LIMIT 1) ,' ')", "mdl_user","Periodo Inscripcion"));
		
	array_push($columns_tmp, new Column(
		999, 
		1, 
		"promedio_general", 
		"promedio_general", 
		"IFNULL((SELECT COALESCE(FORMAT((SUM(IF(f.calificacion > 10, (f.calificacion * 0.1), f.calificacion))/COUNT(id)), 2), 0) FROM uclescuelas.ag_calificaciones f WHERE f.id_alumno = mdl_user.id) ,' ')", 
		"mdl_user",
		"Promedio General")
	);


	array_push($columns_tmp, new Column(
		1000, 
		1, 
		"periodo_actual", 
		"periodo_actual", 
		"COALESCE((SELECT MAX(j.periodo) FROM uclescuelas.mdl_user_enrolments g INNER JOIN uclescuelas.mdl_enrol h ON h.id = g.enrolid INNER JOIN escolar.tb_materias_ids i ON i.id_moodle = h.courseid AND i.id_plan_estudio = 16 INNER JOIN escolar.tb_materias j ON j.id = i.id_materia WHERE g.userid = mdl_user.id), 0)", 
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