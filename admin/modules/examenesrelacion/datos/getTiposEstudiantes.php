<?php 
require_once "config.php";
require_once "../clases/estudiante_tipo.php";

$response->success = false; 
$conexion = mysql_connect($server,$user,$password);

if($conexion)
{
	mysql_select_db($database);
	mysql_set_charset("UTF8", $conexion);

	$query = "select id,nombre from tb_estudiantestipo";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$estudiantes_tipo = [];
		for($indice = 0; $fila =  mysql_fetch_array($resultado); $indice++)
		{
			$estudiantes_tipo[$indice] = new estudiantetipo();
			$estudiantes_tipo[$indice]->id = $fila[0];
			$estudiantes_tipo[$indice]->nombre = $fila[1];
		}
		$response->success = true;
		$response->data = $estudiantes_tipo;
	}
	else
	{
		$response->error = "No hay tipos de estudiantes disponibles ".mysql_error();
	}
	mysql_close($conexion);
	
}
else
{
	$response->error = "No se pudo conectar a la base de datos" . mysql_error();
}
echo json_encode($response);


?>