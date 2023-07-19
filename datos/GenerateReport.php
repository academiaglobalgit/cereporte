<?php
$datos = json_decode(file_get_contents("php://input")); 
	if(isset($datos->columns) && !empty($datos->columns)){

		require_once "config.php";
		require_once "../models/report.class.php";


		$columns_tmp;
		$reporte= new Report("mdl_user","id"); // intitialize with primary table and his primary key
		

		switch ($datos->bd) {
			case 1: // agcollege?
						$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","agcollege-ag");

				require_once "columnas_agcollege.php"; // columnas configuradas de coppel
				$reporte= new Report("mdl_user","id","`agcollege-ag`",""," mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'alumno' "); // intitialize with primary table and his primary key
			break;

			case 2: // prepcoppel
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepacoppel");
				require_once "columnascoppel.php"; // columnas configuradas de coppel
				$reporte= new Report("mdl_user","id","prepacoppel","left join alumnos_cobaes ON alumnos_cobaes.IdMoodle=mdl_user.id"," (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'alumno' "); // intitialize with primary table and his primary key
			break;

			case 60: // prepaOxxo
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaoxxo");
				require_once "columnas_prepaoxxo.php"; // columnas configuradas de prepaOxxo
				$reporte= new Report("mdl_user","id","prepaoxxo","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key
			break;

			case 47: // prepa coppel 2020
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nprepacoppel");
				require_once "columnas_prepacoppel2020.php"; // columnas configuradas de toksuni
				$reporte= new Report("mdl_user","id","nprepacoppel","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key
			break;

			case 3: // soriana?
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","soriana");

				require_once "columnassoriana.php"; // columnas configuradas de soriana
				$reporte= new Report("mdl_user","id","soriana","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 10 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'alumno' "); // intitialize with primary table and his primary key

			break;			

			case 4: // ley?
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaley");

				require_once "columnasley.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","prepaley","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 10 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'alumno' "); // intitialize with primary table and his primary key

			break;
			
			case 61: // ley 2022?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nprepaley");

				require_once "columnasley2022.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","nprepaley","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'alumno' "); // intitialize with primary table and his primary key

			break;

			case 14: // ley licenciatura?
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","uclic");

				require_once "columnas_ley_lic.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","uclic","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'alumno' "); // intitialize with primary table and his primary key

			break;	

			case 9: // lic toks?
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepatoks");

				require_once "columnasprepatoks.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","prepatoks","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	
			case 10: // lic toks?
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","toksuniversity");

				require_once "columnastoksuniversity.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","toksuniversity","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	
			case 12: // Maestria 
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","posgrados");

				require_once "columnas_maestria.php"; // columnas configuradas de toksuni
				$reporte= new Report("mdl_user","id","posgrado","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;
			case 13: // sumate
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepasumate");

				require_once "columnas_sumate.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","prepasumate","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	
			case 17: // sumate
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","agsocial");

				require_once "columnas_agsocial.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","agsocial","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	

			case 18: // IDS
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","coppeling");

				require_once "columnas_coppeling.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","coppeling","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = $datos->bd AND idmoodle = mdl_user.id) = 1"); // intitialize with primary table and his primary key

			break;
			
			case 51: // Admisiones IDS
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","admisionesids");

				require_once "columnas_coppelAdmisiones.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","admisionesids","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;

			case 50: // MDN
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","mdncoppel");

				require_once "columnas_coppelmdn.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","mdncoppel","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	

			case 16: // uclescuelas
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","uclescuelas");

				require_once "columnas_uclescuelas.php"; // columnas configuradas de escuelas
				$reporte= new Report("mdl_user","id","uclescuelas","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;

			case 22: // Licenciatura coppel
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","coppelic");
				require_once "columnas_coppelic.php"; // columnas configuradas de coppel
				//$reporte= new Report("mdl_user","id","prepacoppel","left join alumnos_cobaes ON alumnos_cobaes.IdMoodle=mdl_user.id"," (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'alumno' "); // intitialize with primary table and his primary key
				$reporte= new Report("mdl_user","id","coppelic","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno'"); // intitialize with primary table and his primary key
			break;

			case 62: // LEG coppel
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nlic");
				require_once "columnas_coppeleg.php"; // columnas configuradas de coppel
				//$reporte= new Report("mdl_user","id","prepacoppel","left join alumnos_cobaes ON alumnos_cobaes.IdMoodle=mdl_user.id"," (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'alumno' "); // intitialize with primary table and his primary key
				$reporte= new Report("mdl_user","id","nlic","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno'"); // intitialize with primary table and his primary key
			break;

			case 29: // nueva prepa toks?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nprepatoks");

				require_once "columnas_nprepatoks.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","nprepatoks","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	
			case 30: // nueva lic toks?
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nlictoks");

				require_once "columnas_nlictoks.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","nlictoks","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	

			case 39: // Maestria 
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","agmaestria");

				require_once "columnas_maestria_2.php"; // columnas configuradas de toksuni
				$reporte= new Report("mdl_user","id","agmaestria","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	

			case 40: // Lic Ag College 
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","aglic");

				require_once "columnas_aglic.php"; // columnas configuradas de toksuni
				$reporte= new Report("mdl_user","id","aglic","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	

			case 19: // Flexi Academias 
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","flexiescuelas");
				require_once "columnas_flexiacademias.php"; // columnas configuradas de toksuni
				$reporte= new Report("mdl_user","id","flexiescuelas","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	

			case 59: // IDS UMI
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","umids");

				require_once "columnas_umids.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","umids","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;

			case 64: // IDS UMI
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","admisionesids2");

				require_once "columnas_umiAdmisiones.php"; // columnas configuradas de ley
				$reporte= new Report("mdl_user","id","admisionesids2","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;

			case 49: // AGcollage2020
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");

				require_once "columnas_agcollege2020.php"; // columnas configuradas de Agcollage2020
				$reporte= new Report("mdl_user","id","prepaagcollege","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;

			case 71: // Prepa PIZZA HUT
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");

				require_once "columnas_prepapizzahut.php"; // columnas configuradas de Prepa PIZZA HUT
				$reporte= new Report("mdl_user","id","prepaagcollege","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = $datos->bd AND idmoodle = mdl_user.id) = 1"); // intitialize with primary table and his primary key

			case 72: // Prepa WINGS ARMY
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");

				require_once "columnas_prepawingsarmy.php"; // columnas configuradas de Prepa WINGS ARMY
				$reporte= new Report("mdl_user","id","prepaagcollege","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = $datos->bd AND idmoodle = mdl_user.id) = 1"); // intitialize with primary table and his primary key

			case 73: // Prepa KIA SUSHI
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");

				require_once "columnas_prepakiasushi.php"; // columnas configuradas de Prepa KIA SUSHI
				$reporte= new Report("mdl_user","id","prepaagcollege","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = $datos->bd AND idmoodle = mdl_user.id) = 1"); // intitialize with primary table and his primary key

			case 74: // Prepa VALDEZ BALUARTE
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");

				require_once "columnas_prepavaldezbaluarte.php"; // columnas configuradas de Prepa VALDEZ BALUARTE
				$reporte= new Report("mdl_user","id","prepaagcollege","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = $datos->bd AND idmoodle = mdl_user.id) = 1"); // intitialize with primary table and his primary key

			break;

			default:
				# code...
			break;
		}


		$array_columns=$datos->columns; // array columns from front
		$i=0;
		foreach ($datos->columns as $val) {
				$reporte->columns[$i]=$columns_tmp[$val];
				$reporte->columnswhere[$i]=$datos->filters[$i];
			$i++;
		}

		//$reporte->AddColumn($columns_tmp[$array_columns[$i]]);

		$query=$reporte->GenerateSQL(50);

		//echo $query; 

		if($mysql->Connectar()){
			if($result=$mysql->Query($query)){
				$resultado[0]= $reporte->ResultToArray($result,false);
				$resultado[1]= $query;

				echo json_encode($resultado);
			}else{
				$resultado[0]= 0;
				$resultado[1]= $query;
				echo json_encode($resultado);

				//echo 0;
			}
			$mysql->Cerrar();

		}else{
				$resultado[0]= 1;
				$resultado[1]= "Cannot Connect to BD";
				echo json_encode($resultado);
		}

	}else{
		$resultado[0]= 2;
		$resultado[1]= "No columns selected";
		echo json_encode($resultado);

	}


?>