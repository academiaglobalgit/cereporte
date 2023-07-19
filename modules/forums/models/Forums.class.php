<?php 
	class Forums extends Connection {

		

		function Forums(){
		 	$this->Connect();
		}

		function GetForums($id_course=0,$id_corporacion=0,$id_plan_estudio=0){
			$query="SELECT * FROM tb_foros where tb_foros.id_materia=".$id_course."  and tb_foros.id_plan_estudio=".$id_plan_estudio." and tb_foros.eliminado=0 ORDER BY tb_foros.secuencia ASC";
			$result=$this->Query($query);
			if($result['success']){
				$arrayResult=array();
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function GetForum($id_forum=0){
			$query="SELECT * FROM tb_foros where tb_foros.id=".$id_forum." and tb_foros.eliminado=0 limit 1 ;";
			$result=$this->Query($query);
			if($result['success']){
				while($row=mysqli_fetch_array($result['data'])){
					$result['data'] = $row;
				}
			}
			return $result;
		}
		function GetForumsByExamen($id_examen=0){
			$query="SELECT f.* FROM tb_examenes te 
					INNER JOIN tb_examenes_relacion ter on ter.id_examen_autoridad=te.id
					inner join tb_examenes te2 on ter.id_examen=te2.id
					inner join tb_foros f on f.id_quiz=te.id
					where te2.id=".$id_examen."   ORDER BY te.bloque asc ";
			$result=$this->Query($query);
			if($result['success']){
				$arrayResult=array();
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}
		function SetForum($nombre='No Definido',$id_materia=0,$id_corporacion=0,$id_plan_estudio=0,$id_quiz=0){
			$query="CALL rv_set_forum('".$nombre."',".$id_materia.",".$id_corporacion.",".$id_plan_estudio.",".$id_quiz."); ";
			$result=$this->Query($query);
			if($result['success']==true){
				$result['message']="Foro guardado correctamente.";
			}
			return $result;
		}

		function UpdateForum($id_forum=0,$nombre='No definido',$id_quiz=0){
			$query="CALL rv_update_forum(".$id_forum.",'".$nombre."',".$id_quiz."); ";
			$result=$this->Query($query);
			if($result['success']==true){
				$result['message']="Foro Modificado correctamente.";
			}
			return $result;
		}	

		function DeleteForum($id_forum=0){
			$query="CALL rv_delete_forum(".$id_forum."); ";
			$result=$this->Query($query);
			if($result['success']==true){
				$result['message']="Foro Eliminado correctamente.";
			}
			return $result;
		}	

	}
?>