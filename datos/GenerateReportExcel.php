<?php
	$filename="ReporteGenerado.xls";
	//ini_set('display_errors', 1); error_reporting(E_ALL ^ E_DEPRECATED);
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=".$filename);
	header("Pragma: no-cache");
	header("Expires: 0");
	
	if(isset($_GET['columns']) && !empty($_GET['columns']) && isset($_GET['bd']) && is_numeric($_GET['bd']) ){

		require_once "config.php";
		require_once "../models/report.class.php";

		$columns_tmp;
		$reporte= new Report("mdl_user","id"); // intitialize with primary table and his primary key

		switch ($_GET['bd']) {
			case 1: // agcollege?
			$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","agcollege-ag");

			require_once "columnas_agcollege.php"; // columnas configuradas de coppel
				$reporte= new Report("mdl_user","id","`agcollege-ag`"," "," mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'alumno' "); // intitialize with primary table and his primary key
			break;

			case 49: // Flexi Academias 
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");
				require_once "columnas_agcollege2020.php"; // columnas configuradas de toksuni
				$reporte= new Report("mdl_user","id","prepaagcollege","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key
			break;
			
			case 2: // prepcoppel
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepacoppel");
				require_once "columnascoppel.php"; // columnas configuradas de coppel
				$reporte= new Report("mdl_user","id","prepacoppel","left join alumnos_cobaes ON alumnos_cobaes.IdMoodle=mdl_user.id","  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'alumno' "); // intitialize with primary table and his primary key
			break;

			case 60:
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaoxxo");

				require_once "columnas_prepaoxxo.php"; // columnas configuradas de escuelas
				$reporte= new Report("mdl_user","id","prepaoxxo","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno'"); // intitialize with primary table and his primary key
			break;

			case 47: // Flexi Academias 
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

				require_once "columnasprepatoks.php"; // columnas configuradas de prepatoks
				$reporte= new Report("mdl_user","id","prepatoks","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	
			case 10: // lic toks?
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","toksuniversity");

				require_once "columnastoksuniversity.php"; // columnas configuradas de toksuni
				$reporte= new Report("mdl_user","id","toksuniversity","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	
			case 12: // Maestria 
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","posgrados");

				require_once "columnas_maestria.php"; // columnas configuradas de toksuni
				$reporte= new Report("mdl_user","id","posgrado","","mdl_user.deleted = 0 and (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	

			case 13: // sumate
							$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepasumate");

				require_once "columnas_sumate.php"; // columnas configuradas de prepasumate
				$reporte= new Report("mdl_user","id","prepasumate","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;	
			case 17: // agsocial
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","agsocial");

				require_once "columnas_agsocial.php"; // columnas configuradas de agsocial
				$reporte= new Report("mdl_user","id","agsocial","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;
			
			case 16: // uclescuelas
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","uclescuelas");

				require_once "columnas_uclescuelas.php"; // columnas configuradas de escuelas
				$reporte= new Report("mdl_user","id","uclescuelas","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' "); // intitialize with primary table and his primary key

			break;

			case 18:
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","coppeling");

				require_once "columnas_coppeling.php"; // columnas configuradas de escuelas
				$reporte= new Report("mdl_user","id","coppeling","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = ".$_GET['bd']." AND idmoodle = mdl_user.id) = 1"); // intitialize with primary table and his primary key
			break;
			
			case 51:
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","admisionesids");

				require_once "columnas_coppelAdmisiones.php"; // columnas configuradas de escuelas
				$reporte= new Report("mdl_user","id","admisionesids","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno'"); // intitialize with primary table and his primary key
			break;
			
			case 50:
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","mdncoppel");

				require_once "columnas_coppelmdn.php"; // columnas configuradas de escuelas
				$reporte= new Report("mdl_user","id","mdncoppel","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno'"); // intitialize with primary table and his primary key
			break;	

			case 22:
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","coppelic");

				require_once "columnas_coppelic.php"; // columnas configuradas de escuelas
				$reporte= new Report("mdl_user","id","coppelic","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno'"); // intitialize with primary table and his primary key

			break;

			case 62:
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nlic");

				require_once "columnas_coppeleg.php"; // columnas configuradas de escuelas
				$reporte= new Report("mdl_user","id","coppeleg","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno'"); // intitialize with primary table and his primary key

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

			case 40: // AG LICK  
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

				require_once "columnas_umids.php"; // columnas configuradas de escuelas
				$reporte= new Report("mdl_user","id","umids","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno'"); // intitialize with primary table and his primary key
			break;
			
			case 64: // Adminisiones UMI
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","admisionesids2");

				require_once "columnas_umiAdmisiones.php"; // columnas configuradas de escuelas
				$reporte= new Report("mdl_user","id","admisionesids2","","mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno'"); // intitialize with primary table and his primary key
			break;

			case 71: // PREPA PIZZA HUT
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");

				require_once "columnas_prepapizzahut.php";
				$query = "mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = ".$_GET['bd']." AND idmoodle = mdl_user.id) = 1";
				$reporte= new Report("mdl_user","id","prepaagcollege","",$query); // intitialize with primary table and his primary key
			break;

			case 72: // PREPA WINGS ARMY
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");

				require_once "columnas_prepawingsarmy.php";
				$query = "mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = ".$_GET['bd']." AND idmoodle = mdl_user.id) = 1";
				$reporte= new Report("mdl_user","id","prepaagcollege","",$query); // intitialize with primary table and his primary key
			break;

			case 73: // PREPA KIA SUSHI
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");

				require_once "columnas_prepakiasushi.php";
				$query = "mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = ".$_GET['bd']." AND idmoodle = mdl_user.id) = 1";
				$reporte= new Report("mdl_user","id","prepaagcollege","",$query); // intitialize with primary table and his primary key
			break;

			case 74: // PREPA VALDEZ BALUARTE
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");

				require_once "columnas_prepavaldezbaluarte.php";
				$query = "mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = ".$_GET['bd']." AND idmoodle = mdl_user.id) = 1";
				$reporte= new Report("mdl_user","id","prepaagcollege","",$query); // intitialize with primary table and his primary key
			break;

			case 89: // MAESTRIA UMI 3
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","mdnumi2023");

				require_once "columnas_maestria_3.php";
				$query = "mdl_user.deleted = 0 and  (select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.fieldid = 1 and mdl_user_info_data.userid = mdl_user.id limit 1) = 'Alumno' AND (SELECT COUNT(*) FROM escolar.tb_alumnos WHERE id_plan_estudio = ".$_GET['bd']." AND idmoodle = mdl_user.id) = 1";
				$reporte= new Report("mdl_user","id","mdnumi2023","",$query); // intitialize with primary table and his primary key
			break;
				
			default:
				# code...
			break;
		}

		$array_columns=$_GET['columns']; // array columns from front
		$i=0;
		for  ($j=0;$j < count($_GET['columns']); $j++) {
				$reporte->columns[$i]=$columns_tmp[(int)$_GET['columns'][$j]];
				$reporte->columnswhere[$i]=$_GET['filters'][$i];

			$i++;
		}

		//echo $reporte->GenerateSQL(0); 
		if($mysql->Connectar()){
			
			if($result_sql=$mysql->Query($reporte->GenerateSQL(0))){

				   	$resultado= $reporte->ResultToArray($result_sql,false);

				    $table="<table>";
				   
				            //output header row (if at least one row exists)
				    
				        $table.="<tbody>";
				        for ($j=0; $j < count($resultado); $j++) {
			 				$table.="<tr>";
							for ($i=0; $i < count($resultado[$j]); $i++) { 											 				
			 						$table.="<td>".utf8_decode($resultado[$j][$i])."</td>";
			 				}
			  				$table.="</tr>";

				        }
				        $table.="</tbody>";
				        $table.="</table>";


			      echo 	$table;


			}else{

				echo "error0";
			}
			$mysql->Cerrar();

		}else{

			echo "error1";
		}

	}else{
		
		echo "Sin resultados";
	}

   	
?>