<?php 
	class Geo extends Connection {

		

		function Geo(){
		 	$this->Connect();
		}

		function GetRegiones($id_corporacion=0){

			$query="SELECT tr.* FROM escolar.tb_regiones tr where tr.id_corporacion='".$id_corporacion."' order by  tr.nombre asc " ;
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

		function GetEstados(){

			$query="SELECT te.* from escolar.tb_estados te   order by  te.nombre asc" ;
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


		function GetCiudades($id_estado=0){

			$query="SELECT tc.* from escolar.tb_ciudades tc where tc.id_estado ='".$id_estado."'  order by  tc.nombre asc" ;
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

