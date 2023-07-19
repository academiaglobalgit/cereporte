<?php 
	class PlanEstudios extends Connection {

		

		function PlanEstudios(){
		 	$this->Connect();
		}

		function GetCorporaciones(){


			$query="SELECT c.* from escolar.tb_corporaciones  c order by  c.nombre asc " ;

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

		function GetPlanEstudios(){


			$query="SELECT tp.* from escolar.tb_plan_estudio  tp where tp.basededatos <> 'nodefinido' order by  tp.basededatos asc " ;

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




		function GetPlanEstudio($id_plan_estudio=0){


			$query="SELECT tp.* from escolar.tb_plan_estudio  tp where tp.id ='".$id_plan_estudio."' order by  tp.basededatos asc limit 1" ;

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