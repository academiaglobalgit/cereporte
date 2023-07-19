<?php 
	class Materias extends Connection {

		

		function Materias(){
		 	$this->Connect();
		}

		function GetTbMaterias($bd='nobd',$id_plan_estudio=0){

			$query="SELECT tm.*,c.id as id_moodle FROM escolar.tb_materias tm  inner join escolar.tb_materias_ids mids on mids.id_materia=tm.id 
			LEFT join `".$bd."`.mdl_course c on c.id=mids.id_moodle 
			LEFT join `".$bd."`.mdl_course_categories cc on cc.id=c.category
			 where tm.eliminado=0 and mids.id_plan_estudio='".$id_plan_estudio."' and c.visible=1 and cc.visible=1 and cc.parent=4 order by tm.periodo asc,tm.id asc ";

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


		function GetMateriasMoodle($bd=""){
			$query="SELECT c.*,cc.name as periodo FROM `".$bd."`.mdl_course c INNER JOIN `".$bd."`.mdl_course_categories cc on cc.id=c.category WHERE c.visible=1 and cc.parent=4 AND cc.visible=1 order by cc.name ASC,c.id ASC";
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