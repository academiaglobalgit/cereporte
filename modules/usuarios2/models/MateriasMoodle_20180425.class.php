<?php 
	class MateriasMoodle extends Connection {

	
		function MateriasMoodle(){
		 	$this->Connect();
		}

		function GetMaterias($bd=""){
			$query="SELECT c.*,cc.name as periodo FROM ".$bd.".mdl_course c INNER JOIN ".$bd.".mdl_course_categories cc on cc.id=c.category WHERE c.visible=1 and cc.parent=4 AND cc.visible=1 order by cc.name ASC,c.id ASC";
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
		function GetEscuelas($bd=""){
			$query="SELECT cc.* FROM  ".$bd.".mdl_course_categories cc WHERE cc.parent=4 AND cc.visible=1 order by cc.id ASC";
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

