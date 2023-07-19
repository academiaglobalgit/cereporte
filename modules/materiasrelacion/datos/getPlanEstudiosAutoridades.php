<?php 
require_once "config.php";
require_once "../clases/plan_estudio.php";
$response = new stdClass();
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select tb_plan_estudio.id,tb_plan_estudio.nombre from tb_plan_estudio inner join tb_escuelas on tb_plan_estudio.id_escuela = tb_escuelas.id where tb_escuelas.id_corporacion = 5";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$Materias;
		for($indice = 0; $fila = mysql_fetch_array($resultado);$indice++)
		{
			$Materias[$indice] = new planestudio();
			$Materias[$indice]->id = $fila[0];
			$Materias[$indice]->nombre = utf8_encode($fila[1]) ;
			

		}
		$response->success = true;
		$response->data = $Materias;
	}
	else
	{
		$response->error = mysql_error();
	}
	mysql_close($conexion);
}
else
{
	$response->error = mysql_error();
}
echo json_encode($response);
?>