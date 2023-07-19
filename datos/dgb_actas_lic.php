<?php
    
    //error_reporting(E_ALL);ini_set('display_errors', 1); 
    
    include 'config.php';

    $datos = json_decode(file_get_contents("php://input")); 

    
    $filename="dgb_ACTAS_SEPYC_GEN_".$_GET['generacion']."_PERIODO_".$_GET['periodo'].".xls";    
	
    header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=".$filename);
	header("Pragma: no-cache");
	header("Expires: 0");

    if (isset($_GET))
    {
        //$fecha_inscripcion  = $_GET['fecha_inscripcion'];
        $generacion         = $_GET['generacion'];
        $folio              = $_GET['folio'];
        $periodo            = $_GET['periodo'];        
        $numregistros       = 0;        
        $fecha_evaluacion   = "2016-09-30";
        $ciclo_escolar      = 0;
        $subciclo_escolar   = 0;
        $tipo_evaluacion    = 0;
        $grado              = $periodo;
        $tipo_movimiento    = 0;
        $sumagrupo          = $grado - 1;
        $folio              = 0;

        if($sumagrupo > 0)
        {
            $sumagrupo = 100 * $sumagrupo;
        }
        
        $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");

        $mysql->Connectar();

        $q="SELECT
                ta.id_corporacion,
                ta.id_plan_estudio,
                ta.idmoodle,
                ta.numero_empleado,
                tp.curp,
                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(tp.apellido1),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as apellido1,
                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(tp.apellido2),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as apellido2,
                REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(tp.nombre),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as nombre,
                tba.*, 
                est.descripcion as estatus,
                ta.last_access as ultimo_acceso,
                corp.nombre as corporacion
            from tb_personas tp 
            inner join tb_alumnos ta on ta.id_persona=tp.id 
            inner join tb_dgb_sepyc_alumnos tba on tba.id_alumno=ta.id
            inner join escolar.tb_alumnos_estados est ON est.id = ta.estado
            inner join escolar.tb_corporaciones corp ON ta.id_corporacion = corp.id
            WHERE tba.generacion = ".$generacion." 
            order by tba.id ";

            $idx_alumno=0;
            $alumnos=array();

			if($result_alumnos=$mysql->Query($q))
            {
				while ($row_alumno=mysql_fetch_array($result_alumnos)) 
                {
					$alumnos[$idx_alumno]['idmoodle']              = $row_alumno['idmoodle'];
                    $alumnos[$idx_alumno]['numero_empleado']       = $row_alumno['numero_empleado']; 
					$alumnos[$idx_alumno]['curp']                  = $row_alumno['curp'];
					$alumnos[$idx_alumno]['grupo']                 = $row_alumno['grupo'];
					$alumnos[$idx_alumno]['ciclo_escolar']         = $row_alumno['ciclo_escolar'];
					$alumnos[$idx_alumno]['subciclo_escolar']      = $row_alumno['subciclo_escolar'];
					$alumnos[$idx_alumno]['matricula']             = $row_alumno['matricula'];
					$alumnos[$idx_alumno]['grado']                 = $row_alumno['grado'];
					$alumnos[$idx_alumno]['id_alumno']             = $row_alumno['id_alumno'];
					$alumnos[$idx_alumno]['nombre']                = $row_alumno['nombre'];
					$alumnos[$idx_alumno]['apellido1']             = $row_alumno['apellido1'];
					$alumnos[$idx_alumno]['apellido2']             = $row_alumno['apellido2'];
					$alumnos[$idx_alumno]['id_corporacion']        = $row_alumno['id_corporacion'];
					$alumnos[$idx_alumno]['id_plan_estudio']       = $row_alumno['id_plan_estudio'];
                    $alumnos[$idx_alumno]['estatus']               = $row_alumno['estatus'];
                    $alumnos[$idx_alumno]['ultimo_acceso']         = $row_alumno['ultimo_acceso'];
                    $alumnos[$idx_alumno]['corporacion']           = $row_alumno['corporacion'];
					$idx_alumno++;
				}
			}

            $idx = 0;

			// optiene las materias de la dgb mediante la relacion y la linea de formacion 44  
			foreach ($alumnos as $al) 
            {
                $q="SELECT 
                        md.id as id_materia_dgb,
                        tmi.id_moodle,
                        tp.curp as curp_profesor,
                        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(concat(UPPER(tp.nombre),' ',UPPER(tp.apellido1),' ',UPPER(tp.apellido2)),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as nombre_profesor,
                        tp.id as id_profesor,
                        md.matricula as clave,
                        m.nombre as nombre_moodle,
                        md.nombre as nombre_dgb,    
                        md.periodo,
                        (select tmi_ley.id_moodle 
                            from tb_materias_ids tmi_ley 
                            inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
                            where tmi_ley.id_plan_estudio = ".$al['id_plan_estudio']." 
                            and mr_ley.id_materia_autoridad = md.id limit 1 
                        ) as idmoodle_db
                    from tb_materias md 
                    left join tb_materias_relacion mdr on mdr.id_materia_autoridad=md.id 
                    left join tb_materias_ids tmi on tmi.id_materia=mdr.id_materia 
                    left join tb_materias m on m.id=mdr.id_materia
                    left join tb_materias_profesores mp on mp.id_materia=md.id AND mp.generacion = '1'
                    left join tb_personas tp on tp.id=mp.id_profesor
                    where tmi.id_plan_estudio = ".$al['id_plan_estudio']."
                    AND md.periodo=".$grado."
                    order by md.periodo ASC, md.id asc;";

                $idx_materia=0;

                $materias=array();

                if($result_materias=$mysql->Query($q))
                {
                    while ($row_materia=mysql_fetch_array($result_materias)) 
                    {
                        $materias[$idx_materia]['idmoodle']            = $row_materia['id_moodle'];
                        $materias[$idx_materia]['clave']               = $row_materia['clave'];
                        $materias[$idx_materia]['curp_profesor']       = $row_materia['curp_profesor'];
                        $materias[$idx_materia]['nombre_profesor']     = $row_materia['nombre_profesor'];
                        $materias[$idx_materia]['nombre_moodle']       = $row_materia['nombre_moodle'];
                        $materias[$idx_materia]['nombre_dgb']          = $row_materia['nombre_dgb'];
                        $materias[$idx_materia]['periodo']             = $row_materia['periodo'];
                        $materias[$idx_materia]['id_profesor']         = $row_materia['id_profesor'];
                        $materias[$idx_materia]['id_materia_dgb']      = $row_materia['id_materia_dgb'];
                        $materias[$idx_materia]['idmoodle_db']         = $row_materia['idmoodle_db'];
                        $idx_materia++;
                    }
                }



				foreach ($materias as $mat) 
                {
                    $q_cal  = "SELECT calificacion  FROM [DB].ag_calificaciones WHERE id_materia = '".$mat['idmoodle_db']."' AND id_alumno = '".$al['idmoodle']."' limit 1";
                    $db     = '';
                    $cali   = 0;
                    $corp   = '';


                    if((int)$al['id_plan_estudio'] == 22)
                    {
                        $db = "coppelic";
                    }
                    else if((int)$al['id_plan_estudio'] == 10)
                    {
                        $db = "toksuniversity";   
                    }
                    else if((int)$al['id_plan_estudio'] == 14)
                    {
                        $db = "uclic";
                    }
                    else if((int)$al['id_plan_estudio'] == 30) 
                    {
                        $db = "nlictoks";
                    }
                    else
                    {
                        $cali="NO RELACIONADA";
                    }

                    $q_cal = str_replace('[DB]', $db, $q_cal);

                    if($result_cali=$mysql->Query($q_cal))
                    {
                        $reg = mysql_fetch_array($result_cali);

                        $cali = $reg['calificacion'];

                        if($cali >= 6.0)
                        {
                            $cali = round($cali,0);
                        }
                        else
                        {
                            $cali = (int)$cali;
                        }
                    }
                        
                    $actas[$idx]['corporacion']        = $al['corporacion'];
					$actas[$idx]['fila']               = $idx+1;
					$actas[$idx]['primer_apellido']    = $al['apellido1'];
					$actas[$idx]['segundo_apellido']   = $al['apellido2'];
					$actas[$idx]['nombre']             = $al['nombre'];
					$actas[$idx]['curp_alumno']        = $al['curp'];
					$actas[$idx]['grado']              = $grado;
					$actas[$idx]['grupo']              = ($sumagrupo+(int)$al['grupo']);
					$actas[$idx]['clave_asignatura']   = (string)$mat['clave'];
                    $actas[$idx]['id_materia_dgb']     = $mat['id_materia_dgb']; 
					$actas[$idx]['asignatura']         = $mat['nombre_dgb'];
					$actas[$idx]['asignatura2']        = $mat['nombre_moodle'];
					$actas[$idx]['calificacion']       = $cali; //calificacion
					$actas[$idx]['fecha_evaluacion']   = $fecha_evaluacion;
					$actas[$idx]['folio']              = $folio; // numero de acta
					$actas[$idx]['curp_profesor']      = $mat['curp_profesor']; // curp del docente
                    $actas[$idx]['estatus']            = $al['estatus'];
                    $actas[$idx]['numero_empleado']    = $al['numero_empleado'];
                    $actas[$idx]['ultimo_acceso']      = $al['ultimo_acceso'];
                    $actas[$idx]['materias']           = $materias;

					$idx++;
				}
			}

            $table="<table style='border-style: solid;' >";
            $table.="<thead>
                        <th style='border-style: solid;' >CORPORACION</th>
                        <th style='border-style: solid;' >Numero Empleado</th>  
                        <th style='border-style: solid;' >FILA</th>
                        <th style='border-style: solid;' >Primer Apellido</th>
                        <th style='border-style: solid;' >Segundo Apellido</th>
                        <th style='border-style: solid;' >Nombre</th>
                        <th style='border-style: solid;' >Curp del alumno</th>
                        <th style='border-style: solid;' >Grado</th>
                        <th style='border-style: solid;' >Grupo</th>
                        <th style='border-style: solid;' >Clave Asignatura</th>";                        

            # SE PINTAN LAS MATERIAS COMO TITULOS
            foreach ($materias as $mat) 
            {
                $table.="<th>".$mat['nombre_dgb']."</th>"; 
            }

            $table.="   <th style='border-style: solid;' >fecha evaluacion</th>
                        <th style='border-style: solid;' >Numero Acta</th>
                        <th style='border-style: solid;' >Curp Docente</th>
                        <th style='border-style: solid;' >Estatus</th>
                        <th style='border-style: solid;' >Ultimo Acceso</th>
                    </thead>";
                $table.="<tbody>";
            
            // Se hace el recorrido por los alumnos 
            for ($i=0 ; $i<count($actas) ; $i++)
            {    
                $table.="<tr>";
                $table.="<td style='border-style: solid;'>".$actas[$i]['corporacion']."</td>";
                $table.="<td style='border-style: solid;'>".$actas[$i]['numero_empleado']."</td>";
                $table.="<td style='border-style: solid;'>".$actas[$i]['fila']."</td>";
                $table.="<td style='border-style: solid;'>".utf8_decode($actas[$i]['primer_apellido'])."</td>";
                $table.="<td style='border-style: solid;' >".utf8_decode($actas[$i]['segundo_apellido'])."</td>";
                $table.="<td style='border-style: solid;' >".utf8_decode($actas[$i]['nombre'])."</td>";
                $table.="<td style='border-style: solid;' >".$actas[$i]['curp_alumno']."</td>";
                $table.="<td style='border-style: solid;' >".$actas[$i]['grado']."</td>";
                $table.="<td style='border-style: solid;' >".$actas[$i]['grupo']."</td>";
                $table.="<td style='border-style: solid;' >'".$actas[$i]['clave_asignatura']."'</td>";

                // Se hace el recorrido por las materias del periodo 
                $materias = $actas[$i]['materias'];
                foreach ($materias as $mat) 
                {
                    // Se hace el recorrido por el alumno y la materia activa en el foreach 
                    for ($j=0 ; $j<count($actas) ; $j++)
                    {
                        if($actas[$j]['numero_empleado']==$actas[$i]['numero_empleado'] & $actas[$j]['id_materia_dgb']==$mat['id_materia_dgb'])
                        {
                            $table.="<td style='border-style: solid;' >".$actas[$j]['calificacion']."</td>";                            
                        }
                    }
                }
                
                $table.="<td style='border-style: solid;' >".$actas[$i]['fecha_evaluacion']."</td>";
                $table.="<td style='border-style: solid;' >".$actas[$i]['folio']."</td>";
                $table.="<td style='border-style: solid;' >".$actas[$i]['curp_profesor']."</td>";
                $table.="<td style='border-style: solid;' >".$actas[$i]['estatus']."</td>";
                $table.="<td style='border-style: solid;' >".$actas[$i]['ultimo_acceso']."</td>";
                $table.="</tr>";

                $i = $i + (count($materias) - 1); 
            }

 			echo $table;
            $mysql->Cerrar();
        }
        else
        {
            echo "Necesitas primero importar el archivo";
        }
?>