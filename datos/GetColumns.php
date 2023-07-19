<?php

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

if(isset($_GET['bd']) && is_numeric($_GET['bd'])){

		require_once "config.php"; 
		$columns_tmp;


		switch ($_GET['bd']) {
			case 1: // agcollege?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","agcollege-ag");
				require_once "columnas_agcollege.php"; // columnas configuradas de coppel			
			break;

			case 49: // prepacoppel 2020
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");
				require_once "columnas_agcollege2020.php"; // columnas configuradas de coppel
			break;

			case 2: // prepacoppel
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepacoppel");
				require_once "columnascoppel.php"; // columnas configuradas de coppel
			break;

			case 60: // prepaOxxo
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaoxxo");
				require_once "columnas_prepaoxxo.php"; // columnas configuradas de coppel
			break;

			case 47: // prepacoppel 2020
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nprepacoppel");
				require_once "columnas_prepacoppel2020.php"; // columnas configuradas de coppel
			break;

			case 3: // soriana?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","soriana");
				require_once "columnassoriana.php"; 
			break;		

			case 4: // ley?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaley");
				require_once "columnasley.php"; 
			break;
			
			case 61: // prepa ley 2022?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nprepaley");
				require_once "columnasley2022.php"; 
			break;
			
			case 14: // ley licenciatura?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","uclic");
				require_once "columnas_ley_lic.php"; 
			break;	

			case 9: // prepatoks?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepatoks");
				require_once "columnasprepatoks.php"; 
			break;	

			case 10: // universidadtoks?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","toksuniversity");
				require_once "columnastoksuniversity.php"; 
			break;	

			case 12: // Maestria
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","posgrados");
				require_once "columnas_maestria.php"; 
			break;	

			case 13: // prepasumate?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepasumate");
				require_once "columnas_sumate.php"; 
			break;	
			case 17: // agsocial?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","agsocial");
				require_once "columnas_agsocial.php"; 
			break;	
			case 16: // ucl escuelas?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","uclescuelas");
				require_once "columnas_uclescuelas.php"; 
			break;
			case 18: // coppel ingenieria 
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","coppeling");
				require_once "columnas_coppeling.php"; 
			break;
			case 51: // coppel admisiones IDS 
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","admisionesids");
				require_once "columnas_coppelAdmisiones.php"; 
			break;	
			case 50: // coppel MDN 
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","mdncoppel");
				require_once "columnas_coppelmdn.php"; 
			break;	
			case 22: // ucl escuelas?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","coppelic");
				require_once "columnas_coppelic.php"; 
			break;

			case 62: // LEG Coppel
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nlic");
				require_once "columnas_coppeleg.php"; 
			break;

			case 29: // prepatoks?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nprepatoks");
				require_once "columnas_nprepatoks.php"; 
			break;	

			case 30: // universidadtoks?
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","nlictoks");
				require_once "columnas_nlictoks.php"; 
			break;

			case 39: // Maestria
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","agmaestria");
				require_once "columnas_maestria_2.php"; 
			break;	

			case 40: // Ag lic
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","aglic");
				require_once "columnas_aglic.php"; 
			break;	

			case 19: // Flexi Academias
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","flexiescuelas");
				require_once "columnas_flexiacademias.php"; 
			break;

			case 59: // IDS UMI
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","umids");
				require_once "columnas_umids.php"; 
			break;

			case 64: // Admisiones UMI
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","admisionesids2");
				require_once "columnas_umiAdmisiones.php"; 
			break;

			case 71: // PREPA PIZZA HUT
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");
				require_once "columnas_prepapizzahut.php";
			break;

			case 72: // PREPA WINGS ARMY
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");
				require_once "columnas_prepawingsarmy.php";
			break;

			case 73: // PREPA KIA SUSHI
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");
				require_once "columnas_prepakiasushi.php";
			break;

			case 74: // PREPA VALDEZ BALUARTE
				$mysql = new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","prepaagcollege");
				require_once "columnas_prepavaldezbaluarte.php";
			break;

			default:
				# code...
			break;
		}
		echo json_encode($columns_tmp);

}




?>