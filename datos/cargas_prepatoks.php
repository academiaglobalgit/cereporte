<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
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


		$filename="CargasPrepaToks.xls";

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");


    if (isset($_GET)){

        include 'config.php';

        if (true){

        	$bd="prepatoks";

         	/*	if((int)$_GET['id_plan_estudio']==9){
         		$bd="prepatoks";
         	}else if((int)$_GET['id_plan_estudio']==10) {
         		$bd="toksuniversity";

         	}else if((int)$_GET['id_plan_estudio']==4) {
         		$bd="prepaley";
         	}*/

         	$anio="";
         	$mes="";

         	if(isset($_GET['anio']) && !empty($_GET['anio'])){
         		$anio=$_GET['anio'];
         	}
         	if(isset($_GET['mes']) && !empty($_GET['mes'])){
         		$mes=$_GET['mes'];
         	}   

         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW",$bd);
         $mysql->Connectar();


			$query=" SELECT

			ac.estafeta,
			ac.nombre,
			ac.nombre2,
			ac.apellido,
			ac.apellido2,
			ac.fecha_corte,
			(SELECT
			COUNT(mdl_user_enrolments.id)
			FROM
			mdl_user_enrolments
			WHERE
			userid=muid.userid) AS TotalCargas,
			mdl_course.fullname,
			DATE(FROM_UNIXTIME(mdl_user_enrolments.timecreated)) AS FechaMateriaCargo,
			ag_calificaciones.calificacion,
			ag_calificaciones.fecha_registro
			FROM
			ag_cortes AS ac
			LEFT OUTER JOIN
			mdl_user_info_data AS muid
			ON
			muid.fieldid=4
			AND
			muid.`data`=ac.estafeta
			LEFT OUTER JOIN
			mdl_user_enrolments
			ON
			mdl_user_enrolments.userid=muid.userid
			LEFT OUTER JOIN
			mdl_enrol
			ON
			mdl_enrol.id=mdl_user_enrolments.enrolid
			LEFT OUTER JOIN
			mdl_course
			ON
			mdl_course.id=mdl_enrol.courseid
			LEFT OUTER JOIN
			ag_calificaciones
			ON
			ag_calificaciones.id_alumno=muid.userid
			AND
			ag_calificaciones.id_materia=mdl_course.id
			LEFT OUTER JOIN
			mdl_user
			ON
			mdl_user.id=muid.userid
			WHERE
				DATE(ac.fecha_corte)='".$anio."'
			ORDER BY
			muid.userid, ac.estafeta";



			$query_sin_cortes="SELECT
muide.`data` AS Estafeta,
DATE(FROM_UNIXTIME(mu.timecreated)) AS FechaUsuarioCreado,
mu.firstname,
mu.lastname,
mu.username,
IF(mu.suspended,'Bloqueado','Acceso') AS Estatus,
(SELECT
COUNT(mdl_user_enrolments.id)
FROM
mdl_user_enrolments
WHERE
userid=muid.userid) AS TotalCargas,
mdl_course.fullname,
DATE(FROM_UNIXTIME(mdl_user_enrolments.timecreated)) AS FechaMateriaCargo,
ag_calificaciones.calificacion,
ag_calificaciones.fecha_registro

FROM
mdl_user AS mu
INNER JOIN
mdl_user_info_data AS muid
ON
muid.userid=mu.id
AND
muid.`data`='Alumno'
INNER JOIN
escolar.tb_alumnos
ON
escolar.tb_alumnos.idmoodle=mu.id
AND
escolar.tb_alumnos.id_corporacion=7
AND
escolar.tb_alumnos.id_plan_estudio=9
LEFT OUTER JOIN
mdl_user_enrolments
ON
mdl_user_enrolments.userid=muid.userid
LEFT OUTER JOIN
mdl_enrol
ON
mdl_enrol.id=mdl_user_enrolments.enrolid
LEFT OUTER JOIN
mdl_course
ON
mdl_course.id=mdl_enrol.courseid
LEFT OUTER JOIN
ag_calificaciones
ON
ag_calificaciones.id_alumno=muid.userid
AND
ag_calificaciones.id_materia=mdl_course.id
LEFT OUTER JOIN
mdl_user_info_data AS muide
ON
muide.userid=mu.id
AND
muide.fieldid=4
";

         	if(isset($_GET['tipo']) && !empty($_GET['tipo'])){
         		$result_avance=$mysql->Query($query_sin_cortes);
         	}else{
				$result_avance=$mysql->Query($query);
         	}
         	
			if($result_avance){

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

}else{
	echo "No Request";
}


?>