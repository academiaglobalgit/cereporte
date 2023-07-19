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
$filename="Reporte_ayuda_alumnos_totales_asesor.xls";

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");


    if (isset($_GET)){
          
		session_start();
		require_once "config.php";
		require_once "funciones.php";

        if (true){

        $bd="escolar";

         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW",$bd);
         $mysql->Connectar();

		 $query_a2 = "call escolar.sp_reporte_ayudaalumnos_totales_asesor();";
        	


			if($result_avance=$mysql->Query($query_a2)){

				$reporte=ResultToArray($result_avance,true);

					$table="<table border='1'>"; 
				        $table.="<tbody>
						<thead>
						<tr>
							<th colspan='7' bgcolor='#D2D7D3' style='color:#22313F;'> <h3> REPORTE AYUDA TOTALES POR ASESOR </h3> </th>
						</tr>
						<tr>
							<th width='20%' bgcolor='#D2D7D3' style='text-align:center'> <strong> ASESOR </strong> </th>
							<th width='20%' bgcolor='#D2D7D3' style='text-align:center'> <strong> VIGENTES </strong> </th>
                            <th width='20%' bgcolor='#D2D7D3' style='text-align:center'> <strong> CANCELADOS </strong> </th>
							<th width='20%' bgcolor='#D2D7D3' style='text-align:center'> <strong> VENCIDOS </strong> </th>
							<th width='20%' bgcolor='#D2D7D3' style='text-align:center'> <strong> CERRADOS </strong> </th>
							<th width='20%' bgcolor='#D2D7D3' style='text-align:center'> <strong> EN PROCESO </strong> </th>
							<th width='20%' bgcolor='#D2D7D3' style='text-align:center'> <strong> TOTAL </strong> </th>
						</tr>
					</thead>
					<tbody>";
				        for ($j=1; $j < count($reporte); $j++) {
			 				$table.="<tr>";
							for ($i=0; $i < 1; $i++) { 											 				
			 						$table.="
									 <td>".utf8_decode($reporte[$j][2])."</td>
									 <td>".$reporte[$j][3]."</td>
									 <td>".$reporte[$j][4]."</td>
									 <td>".$reporte[$j][5]."</td>
									 <td>".$reporte[$j][6]."</td>
									 <td>".$reporte[$j][7]."</td>
									 <td>".($reporte[$j][3]+$reporte[$j][4]+$reporte[$j][5]+$reporte[$j][6]+$reporte[$j][7])."</td>
 
									";
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