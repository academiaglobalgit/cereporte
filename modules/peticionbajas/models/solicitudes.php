<?PHP 	
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');


	include('conn.php');
	$con=conexion();
	$datos= array();
	$resultado= $con->query("SELECT * FROM ci_view_solicitudes");

	while($row=$resultado->fetch_assoc()){
		
	$datos[]=array_map('utf8_encode',$row);
	}
	
	echo json_encode($datos);
?>
