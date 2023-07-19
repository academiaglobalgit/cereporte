<?php 
require_once 'config.php';


error_reporting(E_ERROR | E_PARSE);
$response_server = new stdClass();
$response_client = new stdClass();
$response_server->success = false;
$response_client = json_decode(file_get_contents("php://input"),true);


	if(isset($response_client['fecha1']) && isset($response_client['fecha2']) && isset($response_client['empresas']))
	{
		$sql_empresas='';
		
		$empresas = $response_client['empresas'];
		$indice = 0;
		$num_empresas = 0;
		while($indice < count($empresas))
		{
			$item_empresa = $empresas[$indice];
	
			if($item_empresa['ver'] )
			{
				
				if($num_empresas == 0)
				{
					$sql_empresas = ' and (id_corporacion = ' . $item_empresa['id'];	
				}
				else
				{
					$sql_empresas = $sql_empresas.' or id_corporacion = ' . $item_empresa['id'];	
				}
				$num_empresas++;
			}
			$indice++;
	
		}
		if($num_empresas > 0)
			$sql_empresas = $sql_empresas.')';
	
	
	
		if($num_empresas > 0)
		{
			$connection = mysqli_connect(server,user,password,db);
			if(!mysqli_connect_errno())
			{
				$fecha1 = $response_client['fecha1'];
				$fecha2 = $response_client['fecha2'];
				
				$query = mysqli_query($connection,"select * from view_reporte_fechas where (fecha between '$fecha1' and '$fecha2') $sql_empresas"  );
	
	
				if($query)
				{
					while($row = mysqli_fetch_assoc($query))
					{
						$response_server->data[] = $row;
	
						
					}
					$response_server->success = true;
	
				}
				else
				{
					$response_server->error = mysqli_error($connection);
					$response_server->mensaje = "Error al intentar consultar los datos, intente más tarde: detalles técnicos #004";
				}
				mysqli_close($connection);
			}
			else
			{
				$response_server->error = mysqli_connect_error();
				$response_server->mensaje = "No se pudo conectar a los datos, intente más tarde: detalles técnicos #003";
			}
		}
		else
		{
			$response_server->mensaje = "No se enviaron los datos nesesarios para consultar: detalles técnicos #002";
		}
	
			
	
	}
	else
	{
		$response_server->mensaje = "No se enviaron los datos nesesarios para consultar: detalles técnicos #001";
	}	



echo json_encode($response_server);


?>
