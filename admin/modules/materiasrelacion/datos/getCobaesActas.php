<?php 
require_once "config.php";
require_once "../clases/cobaesacta.php";
session_start();
$response = new stdClass();
$response->success = false;
if(isset($_SESSION['persona']))
{
	$actas;
	$actas_alumnos;
	$conexion = mysql_connect($server,$user,$password);
	if($conexion)
	{
		mysql_select_db($database);
		$query = "select id,folio,id_alumno,matricula,generacion,calificacion,nombre from viewcb_actas_alumnos";
		$resultado = mysql_query($query,$conexion);
		if($resultado)
		{
			$response->success = true;
			for($indice=0; $fila = mysql_fetch_array($resultado); $indice++)
			{
				$actas_alumnos[$indice] = new cobaesactaalumno();
				$actas_alumnos[$indice]->id = $fila[0];
				$actas_alumnos[$indice]->folio = $fila[1];
				$actas_alumnos[$indice]->id_alumno = $fila[2];
				$actas_alumnos[$indice]->matricula = $fila[3];
				$actas_alumnos[$indice]->generacion = $fila[4];
				$actas_alumnos[$indice]->calificacion = $fila[5];
				$actas_alumnos[$indice]->nombre = utf8_encode($fila[6]);
			}
			$query = "select folio,id_materia,nombre,generacion,grupo,tipo,date(fecha),periodo from viewcb_actas";
			$resultado = mysql_query($query,$conexion);
			if($resultado)
			{
				for($indice=0; $fila = mysql_fetch_array($resultado); $indice++)
				{
					$actas[$indice] = new cobaesacta();
					$actas[$indice]->folio = $fila[0];
					$actas[$indice]->id_materia = $fila[1];
					$actas[$indice]->nombre_materia = utf8_encode($fila[2]);
					$actas[$indice]->generacion = $fila[3];
					$actas[$indice]->grupo = $fila[4];
					$actas[$indice]->tipo = $fila[5];
					$actas[$indice]->fecha = $fila[6];
					$actas[$indice]->periodo = $fila[7];
				}

				foreach($actas as $acta)
				{
					$indice = 0;
					foreach($actas_alumnos as $acta_alumno)
					{
						if( $acta->folio == $acta_alumno->folio )
						{
							$acta->alumnos[$indice++] = $acta_alumno; 
						}
					}
				}	
			}
			$response->data = $actas;

		}
		else
		{
			$response->error = mysql_error();
		}

		mysql_close($conexion);
	}
	else
	{
		$response->error = "Sin conexión ".mysql_error();		
	}
}
else
{
	$response->error = "No hay usuario";
}
echo json_encode($response);
?>