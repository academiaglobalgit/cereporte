<?PHP 
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');

	$idpeticion=$_GET['id'];
	
	/*include('../PHPMailer/class.phpmailer.php');
	include('../PHPMailer/class.smtp.php');*/
	//echo $idpeticion;
	include('conn.php');
	$con=conexion();
	
	function UpdateEstatus($userid, $idalumno, $idpeticion, $idestatu){
		$con=conexion();

		$resultado=("UPDATE escolar.tb_alumnos_estados_peticiones SET fecha_cambioestado=NOW() WHERE id=$idpeticion AND idalumno=$idalumno");
		if ($con->query($resultado) === TRUE){
			$resultado=("UPDATE escolar.tb_alumnos SET estado=$idestatu WHERE id=$idalumno AND id_corporacion=2 AND id_plan_estudio=2");
			if ($con->query($resultado) === TRUE){
				$resultado=("UPDATE prepacoppel.mdl_user SET suspended=1 WHERE id=$userid");
				if ($con->query($resultado) === TRUE){
							//echo "</br>Actualizaciones Realizadas";																
				}else{echo "Error: " . $resultado . "<br>" . $con->error;}
			}else{echo "Error: " . $resultado . "<br>" . $con->error;}
		}else{echo "Error: " . $resultado . "<br>" . $con->error;}
	}
	function DeleteMaterias($userid, $userenroments){
		$con=conexion();

		$sql = "DELETE FROM prepacoppel.mdl_user_enrolments WHERE userid=$userid AND id=$userenroments";

				if ($con->query($sql) === TRUE) {
					//echo "Materia Eliminada";
				} else {
					echo "Error al Eliminar la Petición: " . $con -> error;
				}
	}
	function DeleteCalificacion($userid, $idmateria){
		$con=conexion();

		$sql = "DELETE FROM prepacoppel.ag_calificaciones WHERE id_alumno=$userid AND id_materia=$idmateria";

				if ($con->query($sql) === TRUE) {
					//echo "Materia Eliminada";
				} else {
					echo "Error al Eliminar la Materia: " . $con -> error;
				}
	}
	
	function DeleteCalificacionEquiv($userid, $idmateria){
		$con=conexion();

		$sql = "DELETE FROM prepacoppel.ag_calificaciones WHERE id_alumno=$userid AND id_materia=$idmateria AND id_tipo_examen=3";

				if ($con->query($sql) === TRUE) {
					//echo "Materia Eliminada";
				} else {
					echo "Error al Eliminar la Materia: " . $con -> error;
				}
	}
	
$select=$con->query("SELECT *,DAY(fecha_peticion) AS D, MONTH(fecha_peticion) AS M, YEAR(fecha_peticion) AS Y  FROM ci_view_solicitudes WHERE idpeticion=$idpeticion AND cambiopeticion='Solicitado'");
if($row=$select->fetch_assoc())
{
	if($row['mmes']!=0 OR $row['emes']!=0)
		{
			
			if(($row['estatuspeticion']==3) AND $row["D"] > 25){
				//echo  "El Alumno tiene ".$row['mmes']." Cargas normales y ".$row['emes']." Equivalencias que no se eliminaron, la razón es que la petición de carga fue despues del 25 y el estatus solicitado es baja del programa.";
				UpdateEstatus($row['id'], $row['idalum'], $row['idpeticion'], $row['estatuspeticion']);			
				}else{
				
				$sel=$con->query("
				SELECT
					mue.id AS id,
					mue.`status` AS status,
					mue.userid AS userid,
					FROM_UNIXTIME(mue.timecreated) AS fechamat,
					me.courseid AS courseid
				FROM
					prepacoppel.mdl_user_enrolments AS mue
				INNER JOIN
					prepacoppel.mdl_enrol AS me
				ON
					me.id = mue.enrolid	
				WHERE
					mue.userid='".$row['id']."'	
				AND
					YEAR(FROM_UNIXTIME(mue.timecreated))='".$row['Y']."'
				AND
					MONTH(FROM_UNIXTIME(mue.timecreated))='".$row['M']."'
				");
				while($w=$sel->fetch_assoc()){	
				if($w['status']==1)
				{
					DeleteCalificacion($row['id'], $w['courseid']);
				}
				
				DeleteMaterias($row['id'], $w['id']);
				
				}
				
				$sel2=$con->query("
				SELECT
				*
				FROM
				prepacoppel.ag_calificaciones
				WHERE
				id_alumno='".$row['id']."'
				AND
				id_tipo_examen=3
				AND
				MONTH(fecha_ordinario)='".$row['M']."'
				AND
				YEAR(fecha_ordinario)='".$row['Y']."'
				");
				while($w2=$sel2->fetch_assoc()){
					DeleteCalificacionEquiv($row['id'], $w2['id_materia']);
				}
				
				
				UpdateEstatus($row['id'], $row['idalum'], $row['idpeticion'], $row['estatuspeticion']);		
			}
		}
		else
		{
			UpdateEstatus($row['id'], $row['idalum'], $row['idpeticion'], $row['estatuspeticion']);
		}
}

	$resultado= $con->query("SELECT * FROM ci_view_solicitudes");
	$datos= array();
	while($row=$resultado->fetch_assoc()){
	$datos[]=array_map('utf8_encode',$row);
	}
	echo json_encode($datos);

?>