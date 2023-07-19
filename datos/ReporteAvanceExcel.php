<?php

function ResultToArray($result,$head=true){ // convert mysql result to obj
	// $head 
	// true=name columns from sql query 
	// false= name column from $column->desc

		$array_report=array();
		$array_titles=array();
		$array_rows=array();

		$k=0;
		$totaltitle=0;

		$title=mysql_fetch_assoc($result);
		mysql_data_seek($result,0); 

        if($head){
        	$j=0;
            foreach (array_keys($title) as $val) {
            	array_push($array_rows,$val);
            	array_push($array_titles,$val);
                $j++;
            }
        }else{
        	$j=0;
            foreach ($this->columns as $val) {

            	if($val->type==2){ // if have subcolumns

            		foreach ($val->subcolumns as $subval) {
            			array_push($array_titles,$subval->desc);
            			array_push($array_rows,$subval->alias);

            			$j++;
            		}

            	}else{
            		array_push($array_titles,$val->desc);
            		array_push($array_rows,$val->alias);

                	$j++;

            	}
            }
        }
		array_push($array_report,$array_titles);

		$k=1;
		


		while($row=mysql_fetch_assoc($result)){
			$i=0;
			
		
				$results_row=array();
				foreach ($array_rows as $row_str) {
					array_push($results_row,$row[$row_str]);
					$i++;
				}
				array_push($array_report,$results_row);

				//$array_report[$k]=$row;


			$k++;
		}

	
		return $array_report;
	}


$filename="ReporteAvance.xls";

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");


    if (isset($_GET)){
          


        include 'config.php';

        if (true){

        	$bd="";
         	if((int)$_GET['id_plan_estudio']==9){
         		$bd="prepatoks";
         	}else if((int)$_GET['id_plan_estudio']==10) {
         		$bd="toksuniversity";

         	}else if((int)$_GET['id_plan_estudio']==4) {
         		$bd="prepaley";

         	}
         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW",$bd);
         $mysql->Connectar();

            $query_avance="
            	SELECT
					mdl_user.id AS ID,
					mdl_user.firstname AS Nombres,
					mdl_user.lastname AS Apellidos,
					mdl_course.id AS IDMateria,
					mdl_course.fullname AS Materia,
					mdl_scorm.id AS IDScorm,
					mdl_scorm.`name` AS Scorm,
					msst.`value` AS Avance,
					mdl_course_sections.section AS Seccion,
					mdl_course_sections.`name` AS NombreSeccion
					FROM
					mdl_user

					INNER JOIN
					mdl_user_info_data
					ON
					mdl_user_info_data.userid=mdl_user.id
					AND
					mdl_user_info_data.`data`='Alumno'
					
					INNER JOIN
					mdl_scorm_scoes_track AS msst
					ON
					msst.userid=mdl_user.id
					AND
					msst.element='cmi.core.score.raw'

					INNER JOIN
					mdl_scorm
					ON
					mdl_scorm.id=msst.scormid
					
					INNER JOIN
					mdl_course
					ON
					mdl_course.id=mdl_scorm.course
					
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
					
					WHERE
					(SELECT
					mdl_scorm_scoes_track.`value`
					FROM
					mdl_scorm_scoes_track
					WHERE
					mdl_scorm_scoes_track.element='cmi.core.lesson_status'
					AND
					mdl_scorm_scoes_track.userid=msst.userid
					AND
					mdl_scorm_scoes_track.scormid=msst.scormid
					limit 1
					) != 'incomplete' 
					
					AND
					(mdl_course_sections.section=3 
					OR
					mdl_course_sections.section=4) 

					ORDER BY
					mdl_user.id, mdl_scorm.`name`
            ";
        
			if($result_avance=$mysql->Query($query_avance)){

				$reporte=ResultToArray($result_avance,true);

					$table="<table>";
				   				    
				        $table.="<tbody>";
				        for ($j=0; $j < count($reporte); $j++) {
			 				$table.="<tr>";
							for ($i=0; $i < count($reporte[$j]); $i++) { 											 				
			 						$table.="<td>".utf8_decode($reporte[$j][$i])."</td>";
			 				}
			  				$table.="</tr>";

				        }
				        $table.="</tbody>";
				        $table.="</table>";

				  $mysql->Cerrar();    
			      echo 	$table;


			}else{
								echo "No se pudo generar el reporte: 001 | ".mysql_error($mysql->con);

            	$mysql->Cerrar();
			}

        }else{
            echo "Necesitas enviar los datos primero";
        }

}

?>