<?php

 	header("Access-Control-Allow-Origin: * ");
	require_once("../models/Connection.class.php");
	require_once("../models/Asesores.class.php");
	require_once("../models/PlanEstudios.class.php");
	require_once("../models/Regiones.class.php");

	//require_once("../models/Validator.class.php");

	/*initialize result object*/
	$result['success']=false;
	$result['message']='Invalid Request';
	$result['data']=null;

	if(isset($_POST['request'])){
		$request=$_POST;
		switch ($request['request']) {

			case "GetAsesores":
				
					$asesores = new Asesores();
					$result=$asesores->GetAsesores();
				
				
			break;

			case "GetAsesoresRegiones":
					if(isset($request['data']['id_asesor']) && is_numeric($request['data']['id_asesor'])){
						$asesores = new Asesores();
						$result=$asesores->GetAsesoresRegiones($request['data']['id_asesor']);
					}else{
						$result['message']="Porfavor, Ingrese correctamente al asesor";

					}
				
			break;	

			case "AddRegionAsesor":
					if((isset($request['data']['id_asesor']) && is_numeric($request['data']['id_asesor'])) && (isset($request['data']['id_region']) && is_numeric($request['data']['id_region']))){
						$asesores = new Asesores();
						$result=$asesores->AddRegionAsesor($request['data']['id_asesor'],$request['data']['id_region']);
					}else{
						$result['message']="Porfavor, Ingrese correctamente al asesor y la región a asignar ";

					}
				
			break;	

			case "RemoveRegionAsesor":
					if(isset($request['data']['id_region_asesor']) && is_numeric($request['data']['id_region_asesor']) ){
						$asesores = new Asesores();
						$result=$asesores->RemoveRegionAsesor($request['data']['id_region_asesor']);
					}else{
						$result['message']="Porfavor, Ingrese correctamente la region que desea remover: 001";

					}
				
			break;	

			case "GetCorporaciones":
				
					$planestudios = new PlanEstudios();
					$result=$planestudios->GetCorporaciones();
				
				
			break;

			case "GetRegiones":
					if(isset($request['data']['id_corporacion']) && is_numeric($request['data']['id_corporacion'])){
						$reigones = new Regiones();
						$result=$reigones->GetRegiones($request['data']['id_corporacion']);

					}else{
						$result['message']="Porfavor, Ingrese correctamente la corporación";
					}
			break;

			default:
				# code...
			break;
		}

		

		echo json_encode($result);


	}else{
		echo json_encode($result);
	}

?>