<?php
$datos = json_decode(file_get_contents("php://input")); 

   if (isset($datos)){
		      include 'config.php';

			    $fecha_inscripcion= $datos->fecha_inscripcion;
          $ciclo_escolar = $datos->ciclo_escolar;
          $subciclo_escolar = $datos->subciclo_escolar;
          $id_moodle = $datos->id_moodle;
          $grado = $datos->grado;
          $nombre = $datos->nombre;
          $periodo=$datos->grado;
          $matricula=$datos->matricula;
          $corporacion = $datos->corporacion;

          	$where=" WHERE 1 ";
          if(!empty($matricula)){
          	$where.=" AND adgb.matricula='".$matricula."' "; 
          }
          if(!empty($ciclo_escolar)){
          	$where.=" AND adgb.ciclo_escolar='".$ciclo_escolar."' "; 
          }
          if(!empty($subciclo_escolar)){
          	$where.=" AND adgb.subciclo_escolar='".$subciclo_escolar."' "; 
          }
          if(!empty($id_moodle)){
          	$where.=" AND  ta.idmoodle='".$id_moodle."' "; 
          }        

          if(!empty($grado)){
          	$where.=" AND adgb.grado='".$grado."' "; 
          }
          if(!empty($fecha_inscripcion)){
          	$where.=" AND date(adgb.fecha_inscripcion)=date('".$fecha_inscripcion."') "; 
          }   
          if(!empty($nombre)){
          	$where.=" AND (tp.nombre like '%".$nombre."%' AND Apellido like '%".$nombre."%') "; 
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

			$query_actas="SELECT 
              adgb.matricula as 'Matricula',
              tp.curp as 'Curp',
              ta.idmoodle as 'Id Moodle',
              tp.nombre as 'Nombre',
              concat(tp.apellido1,' ',tp.apellido2) as 'Apellido',
              adgb.ciclo_escolar as 'Ciclo Escolar',
              adgb.subciclo_escolar as 'SubCiclo Escolar' ,
              adgb.grado as 'Grado',
              adgb.fecha_inscripcion as 'Fecha de Inscripcion'
							 FROM escolar.tb_dgb_alumnos adgb 
              left JOIN escolar.tb_alumnos ta on ta.id=adgb.id_alumno
							left JOIN escolar.tb_personas tp on ta.id_persona=tp.id
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
                  <th style='border-style: solid;' >Matricula</th>
                  <th style='border-style: solid;' >Curp</th>
                  <th style='border-style: solid;' >Id Moodle</th>
                  <th style='border-style: solid;' >Nombre</th>
                  <th style='border-style: solid;' >Apellido</th>
             			<th style='border-style: solid;' >Ciclo Escolar</th>
             			<th style='border-style: solid;' >Subciclo Escolar</th>
             			<th style='border-style: solid;' >Grado</th>
             			<th style='border-style: solid;' >Fecha Incripcion</th>
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