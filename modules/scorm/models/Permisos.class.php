<?php 
	class Permisos extends Connection {

		function Permisos(){
		 	$this->Connect();
		}

		function GetPermisos(){
	

			$query="SELECT tup.* from escolar.tb_usuarios_permisos tup order by tup.orden ASC; " ;

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