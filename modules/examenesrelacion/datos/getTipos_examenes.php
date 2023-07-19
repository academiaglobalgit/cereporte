<?php 
require_once "config.php";
require_once "../clases/tipo_examen.php";


$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	$tipos_examenes;
	mysql_select_db($database);
	$query = "select id,descripcion from view_tipos_examenes";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		for($indice = 0; $fila = mysql_fetch_array($resultado); $indice++)
		{
			$tipos_examenes[$indice] = new tipoexamen();
			$tipos_examenes[$indice]->id = $fila[0];
			$tipos_examenes[$indice]->descripcion = utf8_encode($fila[1]);
		}
		echo json_encode($tipos_examenes);
	}

}


?>