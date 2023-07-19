<?php
$datos = json_decode(file_get_contents("php://input")); 

   if (isset($datos)){
		      include 'config.php';

			    $fecha_evaluacion= $datos->fecha_evaluacion;
          $ciclo_escolar = $datos->ciclo_escolar;
          $subciclo_escolar = $datos->subciclo_escolar;
          $tipo_evaluacion = $datos->tipo_evaluacion;
          $grado = $datos->grado;
          $tipo_movimiento = $datos->tipo_movimiento;
          $periodo=$datos->grado;
          $id_folio=$datos->id_folio;
          $corporacion = $datos->corporacion;

          	$where=" WHERE 1 ";
          if(!empty($id_folio)){
          	$where.=" AND adgb.id_folio='".$id_folio."' "; 
          }
          if(!empty($ciclo_escolar)){
          	$where.=" AND adgb.ciclo_escolar='".$ciclo_escolar."' "; 
          }
          if(!empty($subciclo_escolar)){
          	$where.=" AND adgb.subciclo_escolar='".$subciclo_escolar."' "; 
          }
          if(!empty($tipo_evaluacion)){
          	$where.=" AND adgb.tipo_evaluacion='".$tipo_evaluacion."' "; 
          }        

          if(!empty($grado)){
          	$where.=" AND adgb.grado='".$grado."' "; 
          }
          if(!empty($fecha_evaluacion)){
          	$where.=" AND date(adgb.fecha_evaluacion)=date('".$fecha_evaluacion."') "; 
          }   
          if(!empty($tipo_movimiento)){
          	$where.=" AND adgb.tipo_movimiento='".$tipo_movimiento."' "; 
          }   

        //cargamos el archivo al servidor con el mismo nombre
        //solo le agregue el sufijo bak_

         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");

         $query="";
       		$query2="";
         $mysql->Connectar();
   
            /** Clases necesarias */
            // Cargando la hoja de cálculo
            // Asignar hoja de excel activa
            //conectamos con la base de datos
            // Llenamos el arreglo con los datos  del archivo xlsx
            // $total_filas=$objPHPExcel->getSheetCount();
            $query_update="";
           $query_insert="";
            $WHERE_ALUMNOS="";


			$actas=array();
			$grupo=0;
			$folio=0;
			$idx=0;
				//optieneel ultimo folio
			$query_actas="SELECT adgb.ciclo_escolar,
              adgb.subciclo_escolar,
              adgb.tipo_evaluacion,
							adgb.grado,
							adgb.id_folio,
							ta2.curp as curp_docente,
              tm.matricula as id_asignaruta,
              tp.curp as curp_alumno,
							adgb.calificacion,
							adgb.fecha_evaluacion,
							adgb.tipo_movimiento

							 FROM escolar.tb_dgb_actas adgb 
              left JOIN escolar.tb_alumnos ta on ta.id=adgb.id_alumno
							left JOIN escolar.tb_personas tp on ta.id_persona=tp.id
              left JOIN escolar.tb_personas ta2 on ta2.id=adgb.id_profesor
              left join escolar.tb_materias tm on tm.id=adgb.id_materia_dgb
							".$where."

							order by adgb.id ASC
							";
			if($result_actas=$mysql->Query($query_actas)){

					$row_titles=mysql_fetch_assoc($result_actas);
					$actas_titulos=array();
					foreach (array_keys($row_titles) as $key) {
						array_push($actas_titulos,$key);
					}

					array_push($actas,$actas_titulos);
					mysql_data_seek($result_actas, 0);
					while ($row_acta=mysql_fetch_row($result_actas)) {
						array_push($actas,$row_acta);
					}

			}

				

             $table="<table style='border-style: solid;' >";
             $table.="<thead>
             			<th style='border-style: solid;' >#FILA</th>
             			<th style='border-style: solid;' >Ciclo Escolar</th>
             			<th style='border-style: solid;' >Subciclo Escolar</th>
             			<th style='border-style: solid;' >Tipo Evaluacion</th>
             			<th style='border-style: solid;' >Grado</th>
             			<th style='border-style: solid;' >Folio</th>
             			<th style='border-style: solid;' >curp docente</th>
             			<th style='border-style: solid;' >Id Asignatura</th>
             			<th style='border-style: solid;' >Curp Alumno</th>
             			<th style='border-style: solid;' >Calificacion</th>
             			<th style='border-style: solid;' >fecha evaluacion</th>
             			<th style='border-style: solid;' >Tipo de Movimiento</th>
             		</thead>";
 				$table.="<tbody>";


             for ($i=0; $i < count($actas) ; $i++) { 
             	$table.="<tr>";
             	$table.="<td style='border-style: solid;'>".($i+1)."</td>";
             	$table.="<td style='border-style: solid;'>".$actas[$i][0]."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i][1]."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i][2]."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i][3]."</td>";
             	$table.="<td style='border-style: solid;' >". $actas[$i][4]."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i][5]."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i][6]."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i][7]."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i][8]."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i][9]."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i][10]."</td>";
             	$table.="</tr>";
             }
 				$table.="</tbody></table>";
            $mysql->Cerrar();
            $result=array();
            $result[0]=$actas;
            $result[1]=$query_actas;

 			echo json_encode($result);




    $errores=0;
}



?>