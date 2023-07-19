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

@$fecha=date("d_m_Y");
$filename="ReporteA2Toks.xls";

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");


    if (isset($_GET)){
          


        include 'config.php';

        if (true){

        	$bd="prepatoks";
         	/*if((int)$_GET['id_plan_estudio']==9){
         		$bd="prepatoks";
         	}else if((int)$_GET['id_plan_estudio']==10) {
         		$bd="toksuniversity";

         	}else if((int)$_GET['id_plan_estudio']==4) {
         		$bd="prepaley";

         	}*/
         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW",$bd);
         $mysql->Connectar();

            $query_a2="
            	


			select if(a1.id_plan_estudios=9,'PrepaToks','LicenciaturaToks') as programa ,a1.*,tr.nombre as estado from escolar.tb_a1 a1 
			left join escolar.tb_regiones tr on tr.id=a1.id_region 
			left join escolar.tb_estados te on te.id=a1.id_estado
			where a1.estatus=3 and a1.origen='PAGINA' and a1.id_corporacion=7;             
                          
            ";
        	


			if($result_avance=$mysql->Query($query_a2)){

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