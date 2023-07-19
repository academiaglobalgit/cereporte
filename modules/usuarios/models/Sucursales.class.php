<?php 
	class Sucursales extends Connection {

		

		function Sucursales(){
		 	$this->Connect();
		}

		function GetSucursales($id_corporacion=0,$id_estado=0){

			$query="SELECT s.id,s.nombre,s.numero,concat(s.numero,' ',s.nombre) as numero_nombre FROM tb_estados e inner join tb_ciudades c on e.id=c.id_estado inner join tb_sucursales s on s.id_ciudad=c.id and s.id_corporacion='".$id_corporacion."' and e.id='".$id_estado."' order by s.numero ASC " ;

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