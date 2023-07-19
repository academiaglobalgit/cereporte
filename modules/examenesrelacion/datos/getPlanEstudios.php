<?php 
require_once "config.php";
require_once "../clases/plan_estudio.php";
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select tb_plan_estudio.id,tb_plan_estudio.nombre,tb_plan_estudio.id_escuela,tb_plan_estudio.activo,tb_escuelas.id_corporacion from tb_plan_estudio inner join tb_escuelas on tb_escuelas.id = tb_plan_estudio.id_escuela";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$PlanEstudios;
		for($indice = 0; $fila = mysql_fetch_array($resultado);$indice++)
		{
			
			$PlanEstudios[$indice]['id']= $fila[0];
			$PlanEstudios[$indice]['nombre'] = utf8_encode($fila[1]);
			$PlanEstudios[$indice]['escuela'] = $fila[2];
			$PlanEstudios[$indice]['activo'] = $fila[3];
			$PlanEstudios[$indice]['id_corporacion'] = $fila[4];

		}
		$response->success = true;
		$response->data = $PlanEstudios;
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