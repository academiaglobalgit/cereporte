<?php 
	class Quizes extends Connection {

		

		function Quizes(){
		 	$this->Connect();
		}

		function GetQuizes($id_plan_estudio=0,$id_course=0){

			$query="SELECT * FROM tb_examenes e where e.id_plan_estudio=".$id_plan_estudio." AND e.id_materia=".$id_course."   " ;

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

		function GetQuiz($id_plan_estudio=0,$id_course_moodle=0,$id_moodle=0,$id_modo=1){

			$query="SELECT * FROM tb_examenes e where e.id_plan_estudio=".$id_plan_estudio." AND e.id_materia=(SELECT tmi.id_materia from tb_materias_ids tmi where tmi.id_moodle=".$id_course_moodle." and tmi.id_plan_estudio=".$id_plan_estudio." limit 1) and  e.id_moodle=".$id_moodle." and  e.id_modo=".$id_modo." limit 1  " ;

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
		function GetQuizByMoodleQuiz($id_plan_estudio=0,$id_course_moodle=0,$id_moodle=0,$id_modo=1){

			$query="SELECT e.* FROM tb_examenes e where e.id_plan_estudio=".$id_plan_estudio." AND e.id_materia=(SELECT tmi.id_materia from tb_materias_ids tmi where tmi.id_moodle=".$id_course_moodle." and tmi.id_plan_estudio=".$id_plan_estudio." limit 1) and  e.id_moodle=".$id_moodle." and  e.id_modo=".$id_modo." limit 1  " ;

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

