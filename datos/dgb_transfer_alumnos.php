<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting( E_ALL );

/*DGB transferencia de alumnos

calificaciones:
GENERAION 1 HASTA EL PERIODO 5 
GENERACION 2 HASTA EL PERIODO 4

	header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");

*/



        /*
         $fecha_inscripcion= $datos->fecha_inscripcion;
          $generacion = $datos->generacion;
          $folio = $datos->folio;
          $periodo = $datos->periodo;
          */
          

        /*  $fecha_inscripcion= $_GET['fecha_inscripcion'];
          $generacion = $_GET['generacion'];
          $folio = $_GET['folio'];
          $periodo = $_GET['periodo'];
          */


        include 'config.php';

        $folio = 0;
 	 	$periodo = 1;
        $generacion =1;
        $numregistros = 0;
        $modo = 0;
        $fecha_evaluacion="2016-09-30";
        $ciclo_escolar =0;
        $subciclo_escolar =0;
        $tipo_evaluacion = 0;

        $grado =$periodo;

        $tipo_movimiento =0;
        $sumagrupo= $grado-1;
        if($sumagrupo > 0){
            $sumagrupo=100*$sumagrupo;
        }
       
        //cargamos el archivo al servidor con el mismo nombre
        //solo le agregue el sufijo bak_
        $archivo= "archivo";
        $tipo = 0;
        $destino = "bak_".$archivo;


        $folio=0;

        
         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");

         $query="";
       	$query2="";

         $mysql->Connectar();
   
	// optiene las materias de la dgb mediante la relacion y la linea de formacion 44  // COPPEL
            $query_materias="SELECT md.id as id_materia_dgb,tmi.id_moodle as idmoodle_coppel,tp.curp as curp_profesor,
             REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(concat(UPPER(tp.nombre),' ',UPPER(tp.apellido1),' ',UPPER(tp.apellido2)),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as nombre_profesor,
            tp.id as id_profesor,md.matricula as clave,m.nombre as nombre_moodle,
            md.nombre as nombre_dgb ,md.periodo ,
            (select tmi_ley.id_moodle from tb_materias_ids tmi_ley inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia where tmi_ley.id_plan_estudio=4 and mr_ley.id_materia_autoridad=md.id limit 1 ) as idmoodle_ley
            ,
            (select tmi_ley.id_moodle from tb_materias_ids tmi_ley inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia where tmi_ley.id_plan_estudio=3 and mr_ley.id_materia_autoridad=md.id limit 1 ) as idmoodle_soriana ,
            ( select tmi_ley.id_moodle from tb_materias_ids tmi_ley inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia where tmi_ley.id_plan_estudio=1 and mr_ley.id_materia_autoridad=md.id limit 1 ) as idmoodle_agcollege,
               (select tmi_ley.id_moodle from tb_materias_ids tmi_ley where  md.id=tmi_ley.id_materia and tmi_ley.id_plan_estudio=8 limit 1 ) as idmoodle_dgb

            from tb_materias md 
            left join tb_materias_relacion mdr on mdr.id_materia_autoridad=md.id 
            left join tb_materias_ids tmi on tmi.id_materia=mdr.id_materia 
            left join tb_materias m on m.id=mdr.id_materia
            left join tb_materias_profesores mp on mp.id_materia=md.id and mp.generacion=2
            left join tb_personas tp on tp.id=mp.id_profesor
            where md.id_linea_formacion=44 and tmi.id_plan_estudio=2
            and md.periodo<=4
            order by md.periodo ASC, md.id asc;
            ";
        


             $idx_materia=0;
             $materias=array();
			if($result_materias=$mysql->Query($query_materias)){
				while ($row_materia=mysql_fetch_array($result_materias)) {
					$materias[$idx_materia]['idmoodle']=$row_materia['idmoodle_coppel'];
					$materias[$idx_materia]['clave']=$row_materia['clave'];
					$materias[$idx_materia]['curp_profesor']=$row_materia['curp_profesor'];
					$materias[$idx_materia]['nombre_profesor']=$row_materia['nombre_profesor'];
					$materias[$idx_materia]['nombre_moodle']=$row_materia['nombre_moodle'];
					$materias[$idx_materia]['nombre_dgb']=$row_materia['nombre_dgb'];
					$materias[$idx_materia]['periodo']=$row_materia['periodo'];
					$materias[$idx_materia]['id_profesor']=$row_materia['id_profesor'];
					$materias[$idx_materia]['id_materia_dgb']=$row_materia['id_materia_dgb'];
					$materias[$idx_materia]['idmoodle_ley']=$row_materia['idmoodle_ley'];
					$materias[$idx_materia]['idmoodle_soriana']=$row_materia['idmoodle_soriana'];
					$materias[$idx_materia]['idmoodle_agcollege']=$row_materia['idmoodle_agcollege'];
					$materias[$idx_materia]['idmoodle_dgb']=$row_materia['idmoodle_dgb'];
					$idx_materia++;
				}
			}

	$total_cali=0;
	$query_cali="";
	$query_mdl_user="";
	$query_infodata="";
	$query_enrolments="";
            $query_alumnos="select tr.nomenclatura as region_nomenclatura, tba.generacion,tp.fecha_nacimiento,ta.numero_empleado,tp.tel1,tr.nombre as region_nombre,ta.id as id_tb_alumno,tp.contrasena,tp.usuario,ta.id_corporacion,ta.id_plan_estudio,ta.idmoodle,tp.curp, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(tp.apellido1),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as apellido1,
  REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(tp.apellido2),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as apellido2,
   REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(tp.nombre),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as nombre,tba.* from tb_personas tp 
             inner join tb_alumnos ta on ta.id_persona=tp.id 
             inner join tb_dgb_alumnos tba on tba.id_alumno=ta.id
             left join tb_regiones tr on tr.id=tp.region
              WHERE tba.generacion=2
                order by tba.grupo ASC, tba.matricula ASC

                ";
             $idx_alumno=0;
             $alumnos=array();
			if($result_alumnos=$mysql->Query($query_alumnos))
			{
				while ($row_alumno=mysql_fetch_array($result_alumnos)) 
				{
					$alumnos[$idx_alumno]['idmoodle']=$row_alumno['idmoodle'];
					$alumnos[$idx_alumno]['curp']=$row_alumno['curp'];
					$alumnos[$idx_alumno]['grupo']=$row_alumno['grupo'];
					$alumnos[$idx_alumno]['ciclo_escolar']=$row_alumno['ciclo_escolar'];
					$alumnos[$idx_alumno]['subciclo_escolar']=$row_alumno['subciclo_escolar'];
					$alumnos[$idx_alumno]['matricula']=$row_alumno['matricula'];
					$alumnos[$idx_alumno]['grado']=$row_alumno['grado'];
					$alumnos[$idx_alumno]['id_alumno']=$row_alumno['id_alumno'];
					$alumnos[$idx_alumno]['nombre']=$row_alumno['nombre'];
					$alumnos[$idx_alumno]['apellido1']=$row_alumno['apellido1'];
					$alumnos[$idx_alumno]['apellido2']=$row_alumno['apellido2'];
					$alumnos[$idx_alumno]['id_corporacion']=$row_alumno['id_corporacion'];
					$alumnos[$idx_alumno]['id_plan_estudio']=$row_alumno['id_plan_estudio'];

					$usuario=$row_alumno['usuario'];
					$contra=$row_alumno['contrasena'];
					$nombre=$row_alumno['nombre'];
					$apellido1=$row_alumno['apellido1'];
					$apellido2=$row_alumno['apellido2'];
					$email=$row_alumno['matricula']."@agcollege.mx";
					$ciudad="CIUDAD";
					$query_mdl_user.="\n\n  INSERT INTO agc.mdl_user ( auth, confirmed, policyagreed, deleted, suspended, mnethostid, username, password, idnumber, firstname, lastname, email, emailstop, icq, skype, yahoo, aim, msn, phone1, phone2, institution, department, address, city, country, lang, theme, timezone, firstaccess, lastaccess, lastlogin, currentlogin, lastip, secret, picture, url, description, descriptionformat, mailformat, maildigest, maildisplay, htmleditor, autosubscribe, trackforums, timecreated, timemodified, trustbitmask, imagealt, screenreader ,corp, id_plan_estudio,id_tb_alumno,oldid) VALUES ( 'manual', '1', '0', '0', '0', '1', '".$usuario."', '".$contra."', '', '".$nombre."','".$apellido1." ".$apellido2."', '".$email."', '0', '', '', '', '', '', '', '', '', '', '', '".$ciudad."', 'MX', 'es_mx', '', '99',UNIX_TIMESTAMP(now()),UNIX_TIMESTAMP(now()), UNIX_TIMESTAMP(now()), UNIX_TIMESTAMP(now()), '', '', '0', '', '', '1', '1', '0', '2', '1', '1', '0', UNIX_TIMESTAMP(now()), UNIX_TIMESTAMP(now()), '0', '', '0',".$row_alumno['id_corporacion'].",".$row_alumno['id_plan_estudio'].",".$row_alumno['id_tb_alumno'].",".$row_alumno['idmoodle']."); ";


						$subquery_alumno="(SELECT id FROM agc.mdl_user WHERE oldid=".$row_alumno['idmoodle']." and id_tb_alumno=".$row_alumno['id_tb_alumno']." limit 1)"; 
						$query_infodata.="\n \n 
						INSERT INTO agc.mdl_user_info_data ( userid, fieldid, data, dataformat) VALUES 
						( ".$subquery_alumno.", '1', 'Alumno', '0'),
						 ( ".$subquery_alumno.", '3', 'No Definido', '0'),
						  ( ".$subquery_alumno.", '4', '".$row_alumno['numero_empleado']."', '0'),
						   ( ".$subquery_alumno.", '5','".$row_alumno['region_nomenclatura']."', '0'),
						 	( ".$subquery_alumno.", '6', '".$row_alumno['matricula']."', '0'),
							( ".$subquery_alumno.", '7', '".$row_alumno['fecha_nacimiento']."', '0'),
							( ".$subquery_alumno.", '8', '".$row_alumno['tel1']."', '0'),
							( ".$subquery_alumno.", '9', '".$row_alumno['region_nombre']."', '0'),
							( ".$subquery_alumno.", '10', 'No Definido', '0'),
							( ".$subquery_alumno.", '11', '".$row_alumno['generacion']."', '0'),
							( ".$subquery_alumno.", '12', '".$row_alumno['grupo']."', '0');  ";
				

					foreach ($materias as $mat) 
					{
						 $cali=null;
	                    if((int)$row_alumno['id_plan_estudio']==2){ // coppel

	                        $query_calificaciones="SELECT agc.calificacion from prepacoppel.ag_calificaciones agc where agc.id_materia='".$mat['idmoodle']."' AND agc.id_alumno='".$row_alumno['idmoodle']."' limit 1";
	                       
	                        if($result_cali=$mysql->Query($query_calificaciones)){
	                            while($reg = mysql_fetch_array($result_cali)){
	                            	$cali=$reg['calificacion'];

		                            if($cali>=6.0){
		                                $cali=round($cali,0);
		                            }else{
		                                $cali=(int)$cali;
		                            }
	                            	
	                            }
	                        }

	                    }else if((int)$row_alumno['id_plan_estudio']==4){ //ley

	                        $query_calificaciones="SELECT agc.calificacion from prepaley.ag_calificaciones agc where agc.id_materia='".$mat['idmoodle_ley']."' AND agc.id_alumno='".$row_alumno['idmoodle']."' limit 1";
	                        
	                        if($result_cali=$mysql->Query($query_calificaciones)){
	                            while($reg = mysql_fetch_array($result_cali)){
	                            	$cali=$reg['calificacion'];

		                            if($cali>=6.0){
		                                $cali=round($cali,0);
		                            }else{
		                                $cali=(int)$cali;
		                            }

	                            }
	                            
	                        }

	                     }else if((int)$row_alumno['id_plan_estudio']==3){ //soriana

	                        $query_calificaciones="SELECT agc.calificacion from soriana.ag_calificaciones agc where agc.id_materia='".$mat['idmoodle_soriana']."' AND agc.id_alumno='".$row_alumno['idmoodle']."' limit 1";
	                        
	                        if($result_cali=$mysql->Query($query_calificaciones)){
	                            while($reg = mysql_fetch_array($result_cali)){
	                            	$cali=$reg['calificacion'];

		                            if($cali>=6.0){
		                                $cali=round($cali,0);
		                            }else{
		                                $cali=(int)$cali;
		                            }
	                            	
	                            }
	                        }

	                     }else if((int)$row_alumno['id_plan_estudio']==1){ //AGCOLLEGE

	                        $query_calificaciones="SELECT agc.calificacion from `agcollege-ag`.ag_calificaciones agc where agc.id_materia='".$mat['idmoodle_ley']."' AND agc.id_alumno='".$row_alumno['idmoodle']."' limit 1";
	                        
	                        if($result_cali=$mysql->Query($query_calificaciones)){
	                            while($reg = mysql_fetch_array($result_cali)){
	                            	$cali=$reg['calificacion'];

		                            if($cali>=6.0){
		                                $cali=round($cali,0);
		                            }else{
		                                $cali=(int)$cali;
		                            }
	                            	
	                            }
	                        }

	                    }else{
	                      $cali="NO RELACIONADA";
	                    }

	                    if($cali==null){

	                    }else{
	                    	$total_cali++;
	                    	$subquery_enrol="(SELECT enr.id FROM agc.mdl_enrol enr WHERE enr.enrol='manual' and enr.courseid=".$mat['idmoodle_dgb']." limit 1)";
	                    $query_enrolments.="\n\nINSERT INTO `agc`.`mdl_user_enrolments` ( `status`, `enrolid`, `userid`, `timestart`, `timeend`, `modifierid`, `timecreated`, `timemodified`) VALUES ( 1,".$subquery_enrol." , ".$subquery_alumno.", '0', '2147483647', '14331', '1454590872', '0');";


	                    $query_cali.="\n\n INSERT INTO `agc`.`ag_calificaciones` ( `id_alumno`, `id_materia`, `calificacion`, `id_tipo_examen`, `fecha_registro`, `fecha_ordinario`, `fecha_extraordinario1`, `fecha_extraordinario2`) VALUES ( ".$subquery_alumno.", ".$mat['idmoodle_dgb'].", '".$cali."', '1', now(), now(), NULL, NULL);";
	                    }
	                    
					
						/*if($grupo != $al['grupo']){
							$grupo=$al['grupo'];
							if($modo==0){ // modo preview : se generan los folios de modo ficticio apartir de el ultimo folio
							  $folio++;
	            			}else if($modo==1){ // modo generad
										// se genera un nuevo folio
								if($folio_ins=$mysql->Query("INSERT INTO escolar.tb_dgb_folios (id_folio,fecha_registro) VALUES ((".$folio."+1),now()) ")){

									if($res_folio=$mysql->Query("SELECT escolar.tb_dgb_folios.id_folio FROM escolar.tb_dgb_folios ORDER BY  escolar.tb_dgb_folios.id_folio DESC limit 1")){
										$row_folio=mysql_fetch_array($res_folio);
										$folio=$row_folio['id_folio'];
										$num_c=count($folio);
										$num_c=6-$num_c;
										$folio=str_pad($folio, $num_c, "0", STR_PAD_LEFT);
									}

								}
							}

						}*/

					} // materias




					$idx_alumno++;
				}
			}

		



			
	




        $mysql->Cerrar();

        echo "<br>QUERY INSERT ALUMNOS moodle";

		//echo "<br><textarea rows='8'  >".$query_mdl_user."</textarea><br>";
   
		echo "<br>QUERY INFODATA moodle";

	//	echo "<br><textarea rows='8'  >".$query_infodata."</textarea>";

		echo "<br>QUERY CARGAS moodle";

		//echo "<br><textarea rows='8'  >".$query_enrolments."</textarea>";

		echo "<br>QUERY CALIFICACIONES moodle";

		echo "<br><textarea rows='8'  >".$query_cali."</textarea>";
		echo "<br>TOTAL MATERIAS CALIFICACIONES: ".$total_cali;

		

?>