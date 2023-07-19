<?php 
	class Incidencias extends Connection {

		function Incidencias(){
		 	$this->Connect();
		}

		function get_areas_grupoag(){

			$query = "SELECT * FROM view_areas_grupoag";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function get_categorias(){

			$query = "SELECT * FROM view_categorias_problematicas";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function GetIncidenciasTotales(){

			$query = "SELECT tie.id,count(ti.id) as conteo  FROM escolar.tb_incidencias_estatus tie left join escolar.tb_incidencias ti on ti.estatus=tie.id GROUP BY tie.id order by tie.id asc";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function GetIncidenciasTotalesCategorias(){

			$query = "SELECT tie.id,tie.nombre,count(ti.id) as conteo  FROM escolar.tb_problematicas_categorias tie left join escolar.tb_incidencias ti on ti.id_categoria=tie.id GROUP BY tie.id order by tie.id asc";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function GetIncidenciasTotalesPlataformas(){

			$query = "SELECT tie.id,tie.nombre_corto as nombre,count(ti.id) as conteo  FROM escolar.tb_plan_estudio tie left join escolar.tb_incidencias ti on ti.id_plan_estudio=tie.id GROUP BY tie.id order by tie.id asc";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}
		function GetIncidenciasAlumnoCategorias($id_plan_estudio=0,$numero_empleado=''){

			$query = "SELECT tie.id,tie.nombre,count(ti.id) as conteo  FROM escolar.tb_problematicas_categorias tie left join escolar.tb_incidencias ti on ti.id_categoria=tie.id and ti.numero_empleado=".$numero_empleado." and ti.id_plan_estudio=".$id_plan_estudio." GROUP BY tie.id order by tie.id asc";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}


		function GetIncidenciasTotalesUsuario($id_persona=0){

			$query = "SELECT tie.id,count(ti.id) as conteo  FROM escolar.tb_incidencias_estatus tie left join escolar.tb_incidencias ti on ti.estatus=tie.id and ti.id_usuario_registra='".$id_persona."' GROUP BY tie.id order by tie.id asc";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}


		function GetIncidenciasSolucionadasUsuario($id_persona=0){

			$query = "SELECT count(ti.id) as solucionadas FROM escolar.tb_incidencias_estatus tie left join escolar.tb_incidencias ti on ti.estatus=tie.id and ti.id_usuario_soluciono='".$id_persona."' 
					WHERE ti.estatus=3 GROUP BY tie.id order by tie.id asc";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}



		function get_incidencias_estatus(){

			$query = "SELECT * FROM view_incidencias_estatus";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function get_incidencias_years(){
			$query = "SELECT DISTINCT YEAR(fecha_registro) AS 'year' FROM tb_incidencias ORDER BY YEAR(fecha_registro) DESC";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function get_incidencias($filtro){
			$query = "
				SELECT
					a.id, 
					CONCAT(IFNULL(b.apellido1, ''), ' ', IFNULL(b.apellido2, ''), ' ', IFNULL(b.nombre, '')) AS 'nombre_usuario_reporta',
					a.comentarios, 
					a.estatus AS 'id_estatus',
					a.id_area,
					c.descripcion AS 'area',
					IF(a.tipo = 1, 'EXTERNA', 'INTERNA') AS 'tipo', 
					a.tipo AS 'id_tipo', 
					a.id_problematicas, 
					g.id_categoria,
					d.nombre AS 'estatus',
					e.nombre AS 'origen',
					CONCAT(IFNULL(f.apellido1, ''), ' ', IFNULL(f.apellido2, ''), ' ', IFNULL(f.nombre, '')) AS 'nombre_usuario_registra',
					g.nombre AS 'problematica', 
					a.fecha_registro, 
					(SELECT CONCAT(IFNULL(apellido1, ''), ' ', IFNULL(apellido2, ''), ' ', IFNULL(nombre, '')) FROM tb_personas WHERE id =  a.id_usuario_soluciono) AS 'nombre_usuario_soluciona',
					a.fecha_solucion, 
					a.fecha_modificacion,
					a.correo,
					a.telefono,
					a.fecha_terminacion,
					h.nombre as nombre_categoria,
					p.nombre_corto as nombre_plan_estudios,
					a.numero_empleado,
					ta.idmoodle,
					a.id_usuario_registra,
					a.id_plan_estudio
				FROM
					tb_incidencias a
					left JOIN tb_personas b ON b.id = a.id_usuario_reporta
					INNER JOIN tb_usuarios_areas c ON c.id = a.id_area
					INNER JOIN tb_incidencias_estatus d ON d.id = a.estatus
					INNER JOIN tb_incidencias_origen e ON e.id = a.origen
					left JOIN tb_personas f ON f.id = a.id_usuario_registra
					INNER JOIN tb_problematicas g ON g.id = a.id_problematicas
					INNER JOIN tb_problematicas_categorias h ON h.id = a.id_categoria
					left JOIN tb_plan_estudio p ON p.id = a.id_plan_estudio
					left JOIN tb_alumnos ta ON ta.id_persona =  a.id_usuario_reporta and ta.id_plan_estudio=a.id_plan_estudio

				".$filtro."
				ORDER BY
					a.id DESC
					Limit 30;
			";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
				#$result['query']=$query;
			}
			return $result;
		}

		function get_categorias_externas(){

			$query = "SELECT * FROM view_categorias_problematicas_externas";

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function get_categorias_internas(){
			$query = "SELECT * FROM view_categorias_problematicas_internas";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}


		function get_informacion_alumno_by_numero_empleado($numero_empleado, $id_plan_estudios){
			$query = "
				SELECT 
					a.id AS 'id_persona', 
					b.numero_empleado, 
					CONCAT(IFNULL(a.nombre, ''), ' ', IFNULL(a.apellido1, ''), ' ', IFNULL(a.apellido2, '')) AS 'nombre_completo' 
				FROM 
					tb_personas a 
					INNER JOIN tb_alumnos b ON b.id_persona = a.id 
				WHERE 
					b.id_plan_estudio = ".$id_plan_estudios." 
					AND b.numero_empleado = '".$numero_empleado."' 
					AND b.numero_empleado <> 0
				LIMIT 1";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function get_problematicas_by_categoria($id_categoria){
			$query = "SELECT
					id,
					nombre
				FROM
					escolar.view_problematicas
				WHERE
					id_categoria = ".$id_categoria."";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function insert_tb_incidencias_externa($id_usuario_reporta, $comentarios, $id_area, $tipo, $origen, $id_usuario_registra, $id_problematicas, $correo, $telefono,$id_plan_estudio=0,$id_corporacion=0,$id_categoria=0){
			$query = "
				INSERT INTO escolar.tb_incidencias (
					id_usuario_reporta,
					comentarios,
					id_area,
					tipo,
					estatus,
					origen,
					id_usuario_registra,
					id_problematicas,
					fecha_registro,
					correo,
					telefono,
					id_plan_estudio,
					id_corporacion,
					id_categoria
				)
				VALUES (
					".$id_usuario_reporta.",
					'".$comentarios."',
					".$id_area.",
					".$tipo.",
					5,
					".$origen.",
					".$id_usuario_registra.",
					".$id_problematicas.",
					NOW(),
					'".$correo."',
					'".$telefono."',
					'".$id_plan_estudio."',
					'".$id_corporacion."',
					'".$id_categoria."'
				)
			";
			$result_problematica=$this->Query($query);
			if($result_problematica['success']){
				$result=$result_problematica;
				$result['message']="El reporte de incidencia fue enviado exitosamente.";

			}else{
				$result['message']="Error al registrar el reporte de incidencia.";
			}
			//$result['query']=$query;
			return $result;
		}

		function insert_tb_incidencias_interna($id_usuario_reporta, $comentarios, $id_area, $tipo, $origen, $id_usuario_registra, $id_problematicas, $fecha_terminacion,$id_categoria=0,$id_corporacion=0,$id_plan_estudio=0,$numero_empleado=''){
			$query = "
				INSERT INTO escolar.tb_incidencias (
					id_usuario_reporta,
					comentarios,
					id_area,
					tipo,
					estatus,
					origen,
					id_usuario_registra,
					id_problematicas,
					fecha_registro,
					id_corporacion,
					id_plan_estudio,
					id_categoria,
					numero_empleado
				)
				VALUES (
					'".$id_usuario_reporta."',
					'".htmlspecialchars($comentarios)."',
					'".$id_area."',
					'".$tipo."',
					5,
					'".$origen."',
					'".$id_usuario_registra."',
					'".$id_problematicas."',
					NOW(),
					'".$id_corporacion."',
					'".$id_plan_estudio."',
					'".$id_categoria."',
					'".strip_tags($numero_empleado)."'

				)
			";


			




			$result_problematica=$this->Query($query);
			$result['query']=$query;
			if($result_problematica['success']){

				$id_incidencia=$this->last_insert_id();

				$query_movimiento="INSERT INTO escolar.tb_incidencias_movimientos (
				id_incidencia, 
				comentarios,
				estatus, 
				fecha_registro,
				id_usuario_movimiento
				) 
				VALUES (
				".$id_incidencia.",
				'".$comentarios."',
				5,
				now(),
				".$_SESSION['id_persona']."
				)";

				$result_inci_movi=$this->Query($query_movimiento);



				$result=$result_problematica;
				$result['message']="El reporte de incidencia fue enviado exitosamente.";

			}else{
				$result['message']="Error al registrar el reporte de incidencia. ";
			}
			
			return $result;
		}





		function uptate_tb_incidencias_interna($id_incidencia=0,$tipo=0, $comentarios='', $id_categoria=0,$id_problematicas=0, $fecha_terminacion='0000-00-00 00:00:00',$id_plan_estudio=0,$numero_empleado=''){

			$query = "
				UPDATE escolar.tb_incidencias ti SET
				ti.comentarios='".strip_tags($comentarios)."',
				ti.estatus=5,
				ti.tipo='".$tipo."',
				ti.id_problematicas='".$id_problematicas."',
				ti.id_categoria='".$id_categoria."',
				ti.fecha_terminacion='".$fecha_terminacion."',
				ti.id_plan_estudio='".$id_plan_estudio."',
				ti.numero_empleado='".$numero_empleado."'

				WHERE ti.id='".$id_incidencia."' LIMIT 1
			";
			
			$result_problematica=$this->Query($query);
			if($result_problematica['success']){


				$query_movimiento="INSERT INTO escolar.tb_incidencias_movimientos (
				id_incidencia, 
				comentarios,
				estatus, 
				fecha_registro,
				id_usuario_movimiento
				) 
				VALUES (
				".$id_incidencia.",
				'".strip_tags($comentarios)."',
				5,
				now(),
				'".$_SESSION['id_persona']."'
				)";

				$result_inci_movi=$this->Query($query_movimiento);



				$result=$result_problematica;
				$result['message']="El reporte de incidencia fue ACTUALIZADO exitosamente.";
			}else{
				$result['message']="Error al ACTUALIZAR el reporte de incidencia.";
			}

			$result['query']=$query;
			return $result;
		}


		function uptate_tb_incidencias_externa($id_incidencia=0,$tipo=0, $comentarios='', $id_categoria=0,$id_problematicas=0, $correo=0, $telefono=0){

			$query = "
				UPDATE escolar.tb_incidencias ti SET
				ti.comentarios='".$comentarios."',
				ti.tipo='".$tipo."',
				ti.id_problematicas='".$id_problematicas."',
				ti.correo='".$correo."',
				ti.telefono='".$telefono."'

				WHERE ti.id='".$id_incidencia."' LIMIT 1
			";
			
			$result_problematica=$this->Query($query);
			if($result_problematica['success']){
				$result=$result_problematica;
				$result['message']="El reporte de incidencia fue ACTUALIZADO exitosamente.";
			}else{
				$result['message']="Error al ACTUALIZAR el reporte de incidencia.";
			}

			$result['query']=$query;
			return $result;
		}


		public function get_problematica_by_id($id_problematica){
			$query = "
				SELECT
					a.id,
					a.nombre,
					a.estatus,
					a.id_categoria,
					b.nombre AS 'categoria',
					a.id_area,
					c.descripcion AS 'area',
					a.id_plan_estudios,
					a.fecha_alta
				FROM
					escolar.tb_problematicas a
					INNER JOIN escolar.tb_problematicas_categorias b ON b.id = a.id_categoria
					INNER JOIN escolar.tb_usuarios_areas c ON c.id = a.id_area
				WHERE
					a.id = ".$id_problematica."
				LIMIT 1
			";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			$result['query']=$query;
			return $result;
		}
		
		/*
		function GetIncidenciasActivas($problematica=''){
			$where="";

			if(empty($problematica) || $problematica=="" || $problematica=="null"){ 

			}else{
				$where.=" AND  tbp.nombre LIKE '%".$problematica."%'  ";
			}

			$query="SELECT tbp.* from tb_problematicas tbp where (tbp.estatus='A') ".$where." order by tbp.orden ASC; " ;
			
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function InsertProblematica($nombre='No definido',$id_categoria=0,$id_area=0,$id_plan_estudios=0){


			$query="INSERT INTO tb_problematicas  (nombre, estatus, id_categoria, id_area, id_plan_estudios, fecha_alta) VALUES ('".$nombre."',1,'".$id_categoria."','".$id_area."','".$id_plan_estudios."',now()) " ;


			$result_problematica=$this->Query($query);
			if($result_problematica['success']){
				$result=$result_problematica;
				$result['message']="Problematica creada correctamente.";

			}else{
				$result['message']="Error al crear el problematica.";

			}
			return $result;
		}


		function UpdateProblematica($id_problematica=0,$nombre='',$estatus='A',$id_categoria=0,$id_area=0,$id_plan_estudios=0){

			$query="UPDATE tb_problematicas tbp 
			SET  tbp.nombre='".$nombre."',
			 tbp.estatus='".$estatus."',
			  tbp.id_categoria='".$id_categoria."',
			   tbp.id_area='".$id_area."',
			    tbp.id_plan_estudios='".$id_plan_estudios."' WHERE tbp.id='".$id_problematica."' limit 1"; 

			$result_problematica=$this->Query($query);
			if($result_problematica['success']){
				$result=$result_problematica;
				$result['message']="Problematica actualizada correctamente.";
			}else{
				$result['message']="Error al crear el problematica.";
			}

			return $result;
		}
		*/

		function ChangeStatusIncidencia($id_incidencia=0,$estatus=1,$comentarios=''){ // cambia de estatus la incidencia

			$str_set="";
			if($estatus==3){
				$str_set.=" , ti.fecha_solucion=now() , 
				ti.id_usuario_soluciono='".$_SESSION['id_persona']."' ";
			}


			$query="
			UPDATE escolar.tb_incidencias ti 
			SET 
			 ti.estatus='".$estatus."' ,
			 ti.fecha_modificacion=now()
			 ".$str_set."
			  WHERE ti.id='".$id_incidencia."' limit 1 "; 

			$result_incidencia=$this->Query($query);
			if($result_incidencia['success']){

				$query_movimiento="INSERT INTO escolar.tb_incidencias_movimientos (
				id_incidencia, 
				comentarios,
				estatus, 
				fecha_registro,
				id_usuario_movimiento
				) 
				VALUES (
				".$id_incidencia.",
				'".strip_tags($comentarios)."',
				'".$estatus."',
				now(),
				".$_SESSION['id_persona']."
				)";

				$result_inci_movi=$this->Query($query_movimiento);



				$result=$result_incidencia;
				$result['message']="Incidencia actualizada correctamente. ";
			}else{
				$result['message']="Error al crear el Incidencia.";
			}

			return $result;
		}


		public function GetComentarios($id_incidencia=0){
			$query = "
				SELECT
					a.*,
					CONCAT(IFNULL(b.apellido1, ''), ' ', IFNULL(b.apellido2, ''), ' ', IFNULL(b.nombre, '')) AS 'nombre_usuario_reporta',
					CONCAT(IFNULL(c.apellido1, ''), ' ', IFNULL(c.apellido2, ''), ' ', IFNULL(c.nombre, '')) AS 'nombre_usuario_registra',
					ti.comentarios as primer_comentario
				FROM
					escolar.tb_incidencias_movimientos a
					inner join 
					escolar.tb_incidencias ti on ti.id=a.id_incidencia
					left JOIN tb_personas b ON b.id = ti.id_usuario_reporta
					left JOIN tb_personas c ON c.id = ti.id_usuario_registra

				WHERE
					a.id_incidencia = '".$id_incidencia."'

				ORDER BY 
					a.id DESC 
			";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}
		


		

	}
?>