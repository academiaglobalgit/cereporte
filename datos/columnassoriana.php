<?php
		require_once "columnas_default.php";

				array_push($columns_tmp,new Column(1,0,"suspended","suspended","(select 0 )", "mdl_user","Status",true) );

		array_push($columns_tmp,new Column(8,1,"data","puesto","(select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.userid = mdl_user.id and mdl_user_info_data.fieldid = 7 limit 1) ", "mdl_user","Puesto") );		
		


		$columna= new Column(13,2,"data","materias_soriana","SELECT mc.id,mc.fullname,cc.name FROM mdl_course mc INNER JOIN mdl_course_categories cc ON cc.id=mc.category order by cc.name ASC,mc.id ASC", "mdl_user","Materias Soriana");
		
		
		if($mysql->Connectar()){
			if($res=$mysql->Query($columna->subsql)){
				$k=0;
				while ($mat=mysql_fetch_array($res)) {
					
					//$columna->subcolumns[$k] = new Column(0,1,"data","mat_cop_".$mat['id']." ","IFNULL((select TRUNCATE(ag_calificaciones.calificacion,1) from ag_calificaciones where ag_calificaciones.id_alumno = mdl_user.id and ag_calificaciones.id_materia='".$mat['id']."' limit 1),'0.0')", "mdl_user",$mat['fullname']) ;
					//array_push($columns_tmp,new Column(0,1,"data","mat_cop_".$mat['id']." ","IFNULL((select TRUNCATE(ag_calificaciones.calificacion,1) from ag_calificaciones where ag_calificaciones.id_alumno = mdl_user.id and ag_calificaciones.id_materia='".$mat['id']."' limit 1),'0.0')", "mdl_user",$mat['fullname']) ) ;
					
					$columna->subcolumns[$k] = new Column(0,1,"IFNULL(
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
	) ","mat_".$mat['id'],
		" LEFT JOIN ag_calificaciones agc_".$mat['id']." ON agc_".$mat['id'].".id_alumno = mdl_user.id AND agc_".$mat['id'].".id_materia=".$mat['id']." ", "mdl_user",$mat['fullname']) ;
					
					$k++;
				}
			}

			$mysql->Cerrar();
		}

		array_push($columns_tmp,$columna);


?>