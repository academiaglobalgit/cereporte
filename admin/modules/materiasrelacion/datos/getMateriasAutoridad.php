<?php 
require_once "config.php";
require_once "../clases/materia.php";
$response = new stdClass();
$response->success = false;
$conexion = mysql_connect($server,$user,$password);
if($conexion)
{
	mysql_select_db($database);
	$query = "select tb_materias.id,tb_materias.matricula,tb_materias.nombre,tb_materias.periodo,tb_lineas_formacion.id_plan_estudio from tb_materias inner join tb_lineas_formacion on tb_materias.id_linea_formacion = tb_lineas_formacion.id inner join tb_plan_estudio on tb_plan_estudio.id = tb_lineas_formacion.id_plan_estudio inner join tb_escuelas on tb_escuelas.id = tb_plan_estudio.id_escuela and tb_escuelas.id_corporacion = 5 and matricula is not null";
	$resultado = mysql_query($query,$conexion);
	if($resultado)
	{
		$Materias;
		for($indice = 0; $fila = mysql_fetch_array($resultado);$indice++)
		{
			$Materias[$indice] = new materia();
			$Materias[$indice]->id = $fila[0];
			$Materias[$indice]->matricula = $fila[1];
			$Materias[$indice]->nombre = utf8_encode( $fila[2]);
			$Materias[$indice]->periodo = $fila[3];
			$Materias[$indice]->plan_estudio = $fila[4];
			
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