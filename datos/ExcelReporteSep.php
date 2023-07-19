
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


$filename="ReporteSEP.xls";

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");

        include 'config.php';

        if (true){

        	$bd="toksuniversity";
         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW",$bd);
         $mysql->Connectar();

            $query_avance="
         SELECT mdl_user.id , REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONCAT(mdl_user.lastname,' ',mdl_user.firstname)),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') AS 'NOMBRE COMPETO',
(select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.userid = mdl_user.id and mdl_user_info_data.fieldid = 10 limit 1)  as region  FROM mdl_user   WHERE mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno'   ORDER BY (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.userid = mdl_user.id and mdl_user_info_data.fieldid = 10 limit 1)  ASC ,CONCAT(mdl_user.lastname,' ',mdl_user.firstname) ASC;
            ";
        
			if($result_avance=$mysql->Query($query_avance)){

				$reporte=ResultToArray($result_avance,true);

					$table="<table>";


				   		$region=$reporte[0][2];
				   		$count25=1;

				        $table.="<tbody>";
				        for ($j=0; $j < count($reporte); $j++) {
			 				$pretable="<tr>";

			 				if($region != $reporte[$j][2]){ // no es la misma region

				 					$count25=1;
				 						$table.="<tr style='background-color:yellow;'><td colspan='4' ></td></tr>";
				 						
				 					
				 							for ($i=0; $i < count($reporte[$j]); $i++) { 
							 					$pretable.="<td>".utf8_decode($reporte[$j][$i])."</td>";
							 				}
				 					$region=$reporte[$j][2];

			 				}else{ // es la misma region

			 					if($count25>=25){
			 						$table.="<tr  style='background-color:#ccc;' ><td colspan='4' ></td></tr>";
			 						$count25=1;
			 									for ($i=0; $i < count($reporte[$j]); $i++) { 
							 					$pretable.="<td>".utf8_decode($reporte[$j][$i])."</td>";
							 				}
			 					}else{
			 							for ($i=0; $i < count($reporte[$j]); $i++) { 
						 					$pretable.="<td>".utf8_decode($reporte[$j][$i])."</td>";
						 				}
						 				$count25++;
			 					}
			 					

			 				}


			  				$pretable.="</tr>";
							 $table.=$pretable;
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



?>