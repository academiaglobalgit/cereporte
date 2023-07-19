<?php

public function get_peticiones($filtro){
			$controller = new Controller();
			$query = "


			SELECT a.id, a.id_materia, d.fullname AS 'materia', a.id_alumno, b.firstname AS 'nombre', b.lastname AS 'apellido', a.status, DATE(a.timecreated) AS 'fecha_peticion', c.data AS 'numero_empleado' FROM peticion_materias a INNER JOIN mdl_user b ON b.id = a.id_alumno INNER JOIN mdl_user_info_data c ON c.userid = b.id INNER JOIN mdl_course d ON d.id = a.id_materia WHERE c.fieldid = 4 





			".$filtro;
			return $controller->select_varios_db($query);
		}
		public function get_peticion_by_id($id){
			$controller = new Controller();
			$query = "




			SELECT a.id, a.id_materia, d.fullname AS 'materia', a.id_alumno, b.firstname AS 'nombre', b.lastname AS 'apellido', a.status, DATE(a.timecreated) AS 'fecha_peticion', c.data AS 'numero_empleado' FROM peticion_materias a INNER JOIN mdl_user b ON b.id = a.id_alumno INNER JOIN mdl_user_info_data c ON c.userid = b.id INNER JOIN mdl_course d ON d.id = a.id_materia WHERE c.fieldid = 4 AND a.id =".$id;
			return $controller->select_uno_db($query);
		}
		public function update_estatus_peticion($id, $estatus, $motivo){
			$controller = new Controller();
			$query = "




UPDATE peticion_materias SET status = '".$estatus."', motivo_rechazo = '".$motivo."', timemodified = now() WHERE id =".$id;
call actualizar_peticion(estado,motivo,id)




			return $controller->update_bd($query);
		}
		public function peticiones_totales(){
			$controller = new Controller();
			$query = "





			SELECT (SELECT COUNT(id) FROM peticiones_movimientos WHERE status = 0) AS 'total_solicitudes_realizadas', (SELECT COUNT(id) FROM peticiones_movimientos WHERE status = 2) AS 'total_solicitudes_rechazadas', (SELECT COUNT(id) FROM peticiones_movimientos WHERE status = 1) AS 'total_solicitudes_autorizadas'






			";
			return $controller->select_uno_db($query);
		}
		public function get_date_today(){
			$controller = new Controller();
			$query = "


			SELECT DAY(NOW()) AS 'day', MONTH(NOW()) AS 'month', YEAR(NOW()) AS 'year', DATE(NOW()) AS 'today_date'


			";
			return $controller->select_uno_db($query);
		}
		public function peticiones_totales_by_monthyear($month, $year){
			$controller = new Controller();
			$query = "


			SELECT (SELECT COUNT(id) FROM peticiones_movimientos WHERE status = 0 AND MONTH(fecha_movimiento) = ".$month." AND YEAR(fecha_movimiento) = ".$year.") AS 'total_solicitudes_realizadas', (SELECT COUNT(id) FROM peticiones_movimientos WHERE status = 2 AND MONTH(fecha_movimiento) = ".$month." AND YEAR(fecha_movimiento) = ".$year.") AS 'total_solicitudes_rechazadas', (SELECT COUNT(id) FROM peticiones_movimientos WHERE status = 1 AND MONTH(fecha_movimiento) = ".$month." AND YEAR(fecha_movimiento) = ".$year.") AS 'total_solicitudes_autorizadas'




			";
			return $controller->select_uno_db($query);
		}





?>