<?php 
	class Regiones extends Connection {

		

		function Regiones(){
		 	$this->Connect();
		}

		function GetRegiones($id_corporacion=0){


			$query="SELECT r.* from escolar.tb_regiones  r  where r.id_corporacion='".$id_corporacion."' order by  r.nombre asc " ;

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