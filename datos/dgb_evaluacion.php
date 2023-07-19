<?php
include 'config.php';

$filename="dgb_ACTAS.xls";

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");


    extract($_POST);
    if (@$action == "upload" && is_numeric($_POST['registros'])){

          $numregistros = $_POST['registros']+1;
          $modo = $_POST['modo'];
		  $fecha_evaluacion=$_POST['fecha_evaluacion'];
          $ciclo_escolar = $_POST['ciclo_escolar'];
          $subciclo_escolar = $_POST['subciclo_escolar'];
          $tipo_evaluacion = $_POST['tipo_evaluacion'];
          $grado = $_POST['grado'];
          $tipo_movimiento = $_POST['tipo_movimiento'];
          $periodo=$grado;
          $corporacion = $_POST['corporacion'];
          $generacion = $_POST['generacion'];
          if($generacion>2){
          		$generacion=2;
          }
        //cargamos el archivo al servidor con el mismo nombre
        //solo le agregue el sufijo bak_
        $archivo = $_FILES['excel']['name'];
        $tipo = $_FILES['excel']['type'];
        $destino = "bak_".$archivo;

            if (copy($_FILES['excel']['tmp_name'],$destino)) {
                echo "<center>Actas generadas ".@date("Y-m-d")."</center>";
            }else{
               	echo "Error Al Cargar el Archivo";
            }


        if (file_exists ("bak_".$archivo)){
         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");
         $query="";
       	 $query2="";
         $mysql->Connectar();
   
            /** Clases necesarias */
            require_once('Classes/PHPExcel.php');
            require_once('Classes/PHPExcel/Reader/Excel2007.php');
            // Cargando la hoja de cálculo
            $objReader = new PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader->load("bak_".$archivo);
            $objFecha = new PHPExcel_Shared_Date();
            // Asignar hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);
            //conectamos con la base de datos
            // Llenamos el arreglo con los datos  del archivo xlsx
            // $total_filas=$objPHPExcel->getSheetCount();
                            $query_update="";
                            $query_insert="";
            $total_filas=$numregistros;
            $WHERE_ALUMNOS="";
            for ($i=1;$i<=$total_filas;$i++){
                $_DATOS_EXCEL[$i]['curp'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                //$_DATOS_EXCEL[$i]['tipobaja'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
               // $_DATOS_EXCEL[$i]['status'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
               	if(!empty($_DATOS_EXCEL[$i]['curp'])){
               		  $WHERE_ALUMNOS.=" OR tp.curp='".$_DATOS_EXCEL[$i]['curp']."' ";
               	}       
            }



            //SACA LOS IDS DE LOS ALUMNOS POR SU CUR EN TB_PERSONAS Y FILTRADO POR  CORPORACION
            //ORDENAR POR MATRICULA O APELLIDO
             $query_alumnos="select ta.idmoodle,tp.curp,tba.* from tb_personas tp 
             inner join tb_alumnos ta on ta.id_persona=tp.id 
             inner join tb_dgb_alumnos tba on tba.id_alumno=ta.id
             WHERE ta.id_corporacion=2 and ( 1=2 ".$WHERE_ALUMNOS." ) order by tba.grupo ASC, tba.matricula ASC";
             $idx_alumno=0;
             $alumnos=array();
			if($result_alumnos=$mysql->Query($query_alumnos)){
				while ($row_alumno=mysql_fetch_array($result_alumnos)) {
					$alumnos[$idx_alumno]['idmoodle']=$row_alumno['idmoodle'];
					$alumnos[$idx_alumno]['curp']=$row_alumno['curp'];
					$alumnos[$idx_alumno]['grupo']=$row_alumno['grupo'];
					$alumnos[$idx_alumno]['ciclo_escolar']=$row_alumno['ciclo_escolar'];
					$alumnos[$idx_alumno]['subciclo_escolar']=$row_alumno['subciclo_escolar'];
					$alumnos[$idx_alumno]['matricula']=$row_alumno['matricula'];
					$alumnos[$idx_alumno]['grado']=$row_alumno['grado'];
					$alumnos[$idx_alumno]['id_alumno']=$row_alumno['id_alumno'];

					$idx_alumno++;
				}
			}

			// optiene las materias de la dgb mediante la relacion y la linea de formacion 44 
			$query_materias="SELECT md.id as id_materia_dgb,tmi.id_moodle,tp.curp as curp_profesor,
			concat(tp.nombre,' ',tp.apellido1,' ',tp.apellido2) as nombre_profesor,
			tp.id as id_profesor,md.matricula as clave,m.nombre as nombre_moodle,
			md.nombre as nombre_dgb ,md.periodo 
			from tb_materias md 
			left join tb_materias_relacion mdr on mdr.id_materia_autoridad=md.id 
			left join tb_materias_ids tmi on tmi.id_materia=mdr.id_materia 
			left join tb_materias m on m.id=mdr.id_materia
			left join tb_materias_profesores mp on mp.id_materia=md.id and mp.generacion='".$generacion."'
			left join tb_personas tp on tp.id=mp.id_profesor
			where md.id_linea_formacion=44
			AND md.periodo='".$periodo."'
			order by md.id ASC
			";

             $idx_materia=0;
             $materias=array();
			if($result_materias=$mysql->Query($query_materias)){
				while ($row_materia=mysql_fetch_array($result_materias)) {
					$materias[$idx_materia]['idmoodle']=$row_materia['id_moodle'];
					$materias[$idx_materia]['clave']=$row_materia['clave'];
					$materias[$idx_materia]['curp_profesor']=$row_materia['curp_profesor'];
					$materias[$idx_materia]['nombre_profesor']=$row_materia['nombre_profesor'];
					$materias[$idx_materia]['nombre_moodle']=$row_materia['nombre_moodle'];
					$materias[$idx_materia]['nombre_dgb']=$row_materia['nombre_dgb'];
					$materias[$idx_materia]['periodo']=$row_materia['periodo'];
					$materias[$idx_materia]['id_profesor']=$row_materia['id_profesor'];
					$materias[$idx_materia]['id_materia_dgb']=$row_materia['id_materia_dgb'];
					$idx_materia++;
				}
			}



			$actas=array();
			$grupo=0;
			$folio=0;
			$idx=0;
				//optiene el ultimo folio
				if($res_folio=$mysql->Query("SELECT escolar.tbdgb_folios.id_folio FROM escolar.tbdgb_folios ORDER BY  escolar.tbdgb_folios.id_folio DESC limit 1")){
									$row_folio=mysql_fetch_array($res_folio);
									if($row_folio['id_folio']==null || $row_folio['id_folio']==0){
										$folio=0;
									}else{
										$folio=$row_folio['id_folio'];

									}
					}



			foreach ($materias as $mat) {
				

				foreach ($alumnos as $al) {

					$query_calificaciones="SELECT agc.calificacion from prepacoppel.ag_calificaciones agc where agc.id_materia='".$mat['idmoodle']."' AND agc.id_alumno='".$al['idmoodle']."' limit 1";
					$cali=0;
					if($result_cali=$mysql->Query($query_calificaciones)){
						$reg = mysql_fetch_array($result_cali);
						$cali=$reg['calificacion'];

						if($cali>=6.0){
							$cali=round($cali,0);
						}else{
							$cali=(int)$cali;
						}
					}

				
					if($grupo != $al['grupo']){
						$grupo=$al['grupo'];

						if($modo==0){ // modo preview : se generan los folios de modo ficticio apartir de el ultimo folio

								
								$folio++;
						}else if($modo==1){ // modo generad
							if($folio_ins=$mysql->Query("INSERT INTO escolar.tbdgb_folios (fecha_registro) VALUES (now()) ")){

								if($res_folio=$mysql->Query("SELECT escolar.tbdgb_folios.id_folio FROM escolar.tbdgb_folios ORDER BY  escolar.tbdgb_folios.id_folio DESC limit 1")){
									$row_folio=mysql_fetch_array($res_folio);
									$folio=$row_folio['id_folio'];
									/*$num_c=count($folio);
									$num_c=6-$num_c;
									$folio=str_pad($folio, $num_c, "0", STR_PAD_LEFT);*/
								}

							}
						}




					}





					if($modo==1){ // GUARDA EN LA TABLA tb_dgb_actas
						if($insert_acta=$mysql->Query("INSERT INTO escolar.tb_dgb_actas (ciclo_escolar,subciclo_escolar,tipo_evaluacion,grado,id_folio,id_profesor,id_materia_dgb,id_alumno,calificacion,fecha_evaluacion,tipo_movimiento,fecha_registro) 
							VALUES ('".$ciclo_escolar."',
									'".$subciclo_escolar."',
									'".$tipo_evaluacion."',
									'".$grado."',
									'".$folio."',
									'".$mat['id_profesor']."',
									'".$mat['id_materia_dgb']."',
									'".$al['id_alumno']."',
									'".$cali."',
									'".$fecha_evaluacion."',
									'".$tipo_movimiento."',
									now()
									) ")){

						}
					}


					$actas[$idx]['fila']=$idx+1;
					
					$actas[$idx]['ciclo_escolar']=$ciclo_escolar;
					$actas[$idx]['subciclo_escolar']=$subciclo_escolar;
					$actas[$idx]['tipo_evaluacion']=$tipo_evaluacion;
					$actas[$idx]['grado']=$grado;

					$actas[$idx]['folio']=$folio; // numero de acta
					$actas[$idx]['curp_profesor']=$mat['curp_profesor']; // curp del docente
					$actas[$idx]['clave_materia']=$mat['clave'];// ID asignatura
					$actas[$idx]['curp_alumno']=$al['curp']; //curp del alumno
					$actas[$idx]['calificacion']=$cali; //calificacion

					$actas[$idx]['fecha_evaluacion']=$fecha_evaluacion;
					$actas[$idx]['tipo_movimiento']=$tipo_movimiento;



					$idx++;
				}



			}





             $table="<table style='border-style: solid;' >";
             $table.="<thead>
             			<th style='border-style: solid;' >FILA</th>
             			<th style='border-style: solid;' >Ciclo Escolar</th>
             			<th style='border-style: solid;' >Subciclo Escolar</th>
             			<th style='border-style: solid;' >Tipo Evaluacion</th>
             			<th style='border-style: solid;' >Grado</th>
             			<th style='border-style: solid;' >Flolio</th>
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
             	$table.="<td style='border-style: solid;'>".$actas[$i]['fila']."</td>";
             	$table.="<td style='border-style: solid;'>".$actas[$i]['ciclo_escolar']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['subciclo_escolar']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['tipo_evaluacion']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['grado']."</td>";
             	$table.="<td style='border-style: solid;' >". $actas[$i]['folio']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['curp_profesor']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['clave_materia']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['curp_alumno']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['calificacion']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['fecha_evaluacion']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['tipo_movimiento']."</td>";
             	$table.="</tr>";
             }
 				$table.="</tbody></table>";

 			echo $table;
            $mysql->Cerrar();
        }else{
            echo "Necesitas primero importar el archivo";
        }



    $errores=0;
}






?>