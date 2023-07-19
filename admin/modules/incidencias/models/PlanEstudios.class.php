<?php 
	class PlanEstudios extends Connection {

		

		function PlanEstudios(){
		 	$this->Connect();
		}

		function GetPlanEstudios(){

			$query="SELECT tp.* from escolar.tb_plan_estudio  tp  order by  tp.basededatos asc " ;
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

			$query="SELECT tp.*,es.id_corporacion from escolar.tb_plan_estudio  tp inner join escolar.tb_escuelas es on es.id=tp.id_escuela where tp.id ='".$id_plan_estudio."' order by  tp.basededatos asc limit 1" ;
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


	}
?>