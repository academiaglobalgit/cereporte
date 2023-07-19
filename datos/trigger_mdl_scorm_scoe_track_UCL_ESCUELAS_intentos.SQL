BEGIN 
	DECLARE flag_reinicio_modulos INT unsigned DEFAULT 1;  #0=ignorla la condicin de reinicio de modulos 1=si entra
	DECLARE estatus varchar(60);
    DECLARE esextra INTEGER;
	DECLARE calific float;
                   DECLARE calific_examen float;
	DECLARE ex_parciales float;
	
	DECLARE ex_extra float;
	DECLARE materia_id INTEGER;

	DECLARE examenes_materia INTEGER;
	DECLARE examenes_hechos INTEGER;

	DECLARE max_intentos_cali INT unsigned DEFAULT 3;  #numeros de intentos que tiene para realizar un examen 
	DECLARE intentos_cali INTEGER;
                     
    SELECT s.course INTO materia_id FROM mdl_scorm_scoes_track sst inner join mdl_scorm s on s.id=sst.scormid WHERE sst.element="cmi.core.lesson_status" AND  sst.id=old.id limit 1; 

SELECT count(ag_scorm_intentos_calificacion.id) INTO intentos_cali  FROM ag_scorm_intentos_calificacion WHERE  ag_scorm_intentos_calificacion.userid=old.userid and ag_scorm_intentos_calificacion.scormid=old.scormid ; 




   SELECT count(mdl_course_modules.id) INTO examenes_materia
	FROM mdl_course_modules
	INNER JOIN mdl_course_sections ON mdl_course_sections.id = mdl_course_modules.section
	WHERE mdl_course_modules.module = 18
	AND mdl_course_modules.course = materia_id
	AND mdl_course_sections.section =3;

	SELECT count(mdl_scorm_scoes_track.scormid) INTO examenes_hechos
	FROM mdl_scorm_scoes_track
	INNER JOIN mdl_scorm on mdl_scorm.id = mdl_scorm_scoes_track.scormid
	INNER JOIN mdl_course_modules on mdl_course_modules.instance = mdl_scorm.id
	INNER JOIN mdl_course_sections on mdl_course_sections.id = mdl_course_modules.section
	WHERE userid = old.userid
	AND mdl_scorm_scoes_track.element = 'cmi.core.lesson_status'
	AND mdl_scorm.course = materia_id
	AND mdl_course_modules.module = 18
	AND mdl_course_sections.section =3
	AND (mdl_scorm_scoes_track.value = 'failed' or mdl_scorm_scoes_track.value = 'passed' 
	or mdl_scorm_scoes_track.value = 'complete');


	
	SELECT count(cm.id)  INTO esextra
	FROM  mdl_scorm s
	INNER JOIN mdl_course_modules cm on s.id=cm.instance
	INNER JOIN mdl_course_sections cs on cs.id=cm.section WHERE cm.module=18 and cm.course=s.course and s.course=materia_id  and s.id=old.scormid and cs.section=5; 

	#ULTIMO EXAMEN PARCIAL DE LA MATERIA
	IF examenes_materia=examenes_hechos THEN


		
		SELECT sst.value INTO estatus FROM mdl_scorm_scoes_track sst WHERE sst.element="cmi.core.lesson_status" AND  sst.id=old.id ; 
                                      SELECT sst.value INTO calific_examen FROM mdl_scorm_scoes_track sst WHERE sst.element="cmi.core.score.raw" AND sst.userid = old.userid and  sst.scormid=old.scormid ; 
		IF estatus='passed' OR estatus='failed' OR estatus='complete' THEN

			

			IF estatus='failed' AND flag_reinicio_modulos=1 THEN
				#SI TIENE INTENTOS TODABIA
				IF intentos_cali<max_intentos_cali THEN

					INSERT INTO ag_scorm_intentos_calificacion(
						userid, 
						scormid, 
						intento, 
						 ultima_calificacion,
						fecha_registro
					)
					VALUES(
						old.userid, 
						old.scormid, 
						(intentos_cali+1), 
						calific_examen ,
						NOW()
					);
				END IF;

			ELSE
				#SI SILO PASÓ
				SELECT round((SUM(sst.value)/count(sst.id))*1,2) INTO ex_parciales FROM mdl_scorm_scoes_track sst inner join mdl_course_modules cm on cm.instance=sst.scormid inner join mdl_scorm s on sst.scormid=s.id inner join mdl_course_sections cs on cs.id=cm.section  
				WHERE sst.element="cmi.core.score.raw" AND cm.course=s.course and  s.course=materia_id  and cm.module=18 AND sst.userid=old.userid and cs.section=3;



	            set calific=ex_parciales;



				IF (SELECT count(ac.id) from ag_calificaciones ac where ac.id_alumno=old.userid and ac.id_materia=materia_id ) = 0 THEN
					INSERT INTO ag_calificaciones(id_alumno,id_materia,calificacion,id_tipo_examen) VALUES (old.userid,materia_id,calific,1) ;
					
				ELSE 
					UPDATE ag_calificaciones c SET c.calificacion=calific WHERE c.id_alumno=old.userid and materia_id=c.id_materia limit 1;
				END if;

			END IF;
			
		END IF;

	END IF;

	#EXAMENES PARCIALES
	IF examenes_hechos<examenes_materia THEN

		SELECT sst.value INTO estatus FROM mdl_scorm_scoes_track sst WHERE sst.element="cmi.core.lesson_status" AND  sst.id=old.id ; 
                                     SELECT sst.value INTO calific_examen FROM mdl_scorm_scoes_track sst WHERE sst.element="cmi.core.score.raw" AND sst.userid = old.userid and  sst.scormid=old.scormid ; 
		IF estatus='failed' AND flag_reinicio_modulos=1 THEN
			#SI TIENE INTENTOS TODABIA
			IF intentos_cali<max_intentos_cali THEN

					INSERT INTO ag_scorm_intentos_calificacion(
						userid, 
						scormid, 
						intento, 
						 ultima_calificacion,
						fecha_registro
					)
					VALUES(
						old.userid, 
						old.scormid, 
						(intentos_cali+1), 
						calific_examen ,
						NOW()
					);
			END IF;
		END IF;

	END IF;

	IF esextra=1 THEN

		
		SELECT sst.value INTO estatus FROM mdl_scorm_scoes_track sst WHERE sst.element="cmi.core.lesson_status" AND  sst.id=old.id ; 

		IF estatus='passed' OR estatus='failed' THEN

			
			SELECT round(SUM(sst.value)*1,2) INTO ex_extra FROM mdl_scorm_scoes_track sst inner join mdl_course_modules cm on cm.instance=sst.scormid inner join mdl_scorm s on sst.scormid=s.id inner join mdl_course_sections cs on cs.id=cm.section  
			WHERE sst.element="cmi.core.score.raw" AND cm.course=s.course and  s.course=materia_id and cm.module=18 AND sst.userid=old.userid and cs.section=5;

                                                                         set calific=ex_extra;

			IF (SELECT count(ac.id) from ag_calificaciones ac where ac.id_alumno=old.userid and ac.id_materia=materia_id ) = 0 THEN
				INSERT INTO ag_calificaciones(id_alumno,id_materia,calificacion,id_tipo_examen) VALUES (old.userid,materia_id,calific,1) ;
				
			ELSE 
				UPDATE ag_calificaciones c SET c.calificacion=calific,c.id_tipo_examen =2,c.fecha_ordinario = now() WHERE c.id_alumno=old.userid and materia_id=c.id_materia limit 1;
				

			END if;

		END IF;
	END IF;

END