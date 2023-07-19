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


$filename="ReporteLicToks.xls";

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");


    if (isset($_GET)){
          


        include 'config.php';

        if (true){

        	$bd="toksuniversity";
         	/*if((int)$_GET['id_plan_estudio']==9){
         		$bd="prepatoks";
         	}else if((int)$_GET['id_plan_estudio']==10) {
         		$bd="toksuniversity";

         	}else if((int)$_GET['id_plan_estudio']==4) {
         		$bd="prepaley";

         	}*/
         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW",$bd);
         $mysql->Connectar();

            $query_avance="
            	




SELECT mdl_user.id as ID, 
 IF((select count(mdl_user_enrolments.id) from mdl_user_enrolments where mdl_user_enrolments.userid = mdl_user.id AND 
 (YEAR(FROM_UNIXTIME(mdl_user_enrolments.timecreated))=YEAR(now()) AND MONTH(FROM_UNIXTIME(mdl_user_enrolments.timecreated))=MONTH(now()) ) )>0,'Activo','Inactivo') as 'ACTIVIDAD',
  IF(ta.estado<>1,tae.descripcion,tde.estatus_academico) as 'ESTATUS_DESCRIPCION',
(select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.userid = mdl_user.id and mdl_user_info_data.fieldid = 4 limit 1) as 'ESTAFETA',
 mdl_user.firstname as NOMBRE,
 mdl_user.lastname as APELLIDO,
ta.numero_referencia as 'Numero de Referencia',
from_unixtime(mdl_user.lastaccess) as ultimo_acceso,
(select FROM_UNIXTIME(mdl_user_enrolments.timecreated) from mdl_user_enrolments 
inner join mdl_enrol on mdl_user_enrolments.enrolid=mdl_enrol.id  
inner join mdl_course on mdl_enrol.courseid=mdl_course.id
where mdl_user_enrolments.userid = mdl_user.id ORDER BY mdl_user_enrolments.id DESC limit 1) as ultima_carga,
(select ag_calificaciones.fecha_registro FROM ag_calificaciones WHERE ag_calificaciones.id_alumno=mdl_user.id ORDER BY ag_calificaciones.id DESC LIMIT 1) as ultima_materia_terminada,
DATE(ta.fecha_inscripcion)
	FROM mdl_user 
	inner join escolar.tb_alumnos ta  on  ta.idmoodle=mdl_user.id
	inner join escolar.tb_personas tp on tp.id=ta.id_persona
	left join escolar.tb_regiones tr  on  tr.id=tp.region
	left join escolar.tb_ciudades tc  on  tc.id=tp.ciudad
	left join escolar.tb_puestos tpu  on  tpu.id=tp.puesto
	left join escolar.tb_sucursales ts  on  ts.id=tp.sucursal
	left join escolar.tb_alumnos_estados tae on tae.id=ta.estado
	left join escolar.tb_deserciones_razones tdr on tdr.id=ta.estado_razon
	left join escolar.tb_documentacion_estatus tde on tde.id=ta.documentacion_estatus

WHERE 

 
 IF((ta.estado=9  OR ta.estado=13  OR ta.estado=14  OR ta.estado=15),'activo','baja') = 'activo'
AND
(ta.id_corporacion='7'  and ta.id_plan_estudio='10' ) and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = '1' and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' ORDER BY mdl_user.id ASC                   
                          
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