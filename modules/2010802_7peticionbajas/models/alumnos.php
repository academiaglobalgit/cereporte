<?PHP 
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
  //header("Content-type: application/json; charset=iso-8859-1");
	
	if(isset($_POST['buscar'])){echo $_POST['buscar'];}
	include('conn.php');
	$con=conexion();
	$resultado= $con->query("SELECT * FROM ci_view_alumnos");
	$datos= array();
	while($row=$resultado->fetch_assoc()){
	//$datos[]=$row;
	//$datos['Materias'].=$row['mmes'];
	$datos[]=array_map('utf8_encode',$row);
	
	//echo $row['firstname']."<br>";
	}
	
	echo json_encode($datos);
?>