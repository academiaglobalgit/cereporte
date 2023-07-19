<?PHP 	include('conn.php');
	$con=conexion2();
	echo $con;
	/*$resultado= $con->query("SELECT * FROM ci_view_solicitudes");

	$datos= array();
	while($row=$resultado->fetch_assoc()){
	$datos[]=array_map('utf8_encode',$row);
	}
	
	echo json_encode($datos);*/
?>
