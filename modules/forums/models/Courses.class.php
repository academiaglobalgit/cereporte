<?php 
	class Courses extends Connection {

		

		function Courses(){
		 	$this->Connect();
		}

		function GetCourses($id_plan_estudio=0){

			$query="";

			switch ($id_plan_estudio) { // DEPENDE DE id_plan_estudio OBTIENE LAS MATERIAS
				case 2: //coppel normal
					$query="SELECT c.*,cc.name as periodo FROM prepacoppel.mdl_course c inner join prepacoppel.mdl_course_categories cc on cc.id=c.category and c.visible=1 and cc.visible=1 and cc.parent=4 order by cc.name ASC";
				break;
				case 3: //soriana
					$query="SELECT c.*,cc.name as periodo FROM soriana.mdl_course c inner join soriana.mdl_course_categories cc on cc.id=c.category and c.visible=1 and cc.visible=1 and cc.parent=4 order by cc.name ASC";
				break;
				case 4: // LEY
					$query="SELECT c.*,cc.name as periodo FROM prepaley.mdl_course c inner join prepaley.mdl_course_categories cc on cc.id=c.category and c.visible=1 and cc.visible=1 and cc.parent=4 order by cc.name ASC";
				break;				
				case 8: //  MATERIAS DGB 
					$query="SELECT tm.* FROM escolar.tb_materias tm  inner join escolar.tb_materias_ids mids on mids.id_materia=tm.id where tm.eliminado=0 and mids.id_plan_estudio=8 order by tm.periodo asc,tm.id asc ";
				
				break;	
				case 6://
					# code...
				break;	
				case 11: // SEPIC

				$query="SELECT tm.* FROM escolar.tb_materias tm  inner join escolar.tb_materias_ids mids on mids.id_materia=tm.id where tm.eliminado=0 and mids.id_plan_estudio=11 order by tm.periodo asc,tm.id asc ";
				break;

				default: //
					# code...
				break;
			}

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