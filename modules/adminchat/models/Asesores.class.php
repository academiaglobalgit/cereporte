<?php 
	class Asesores extends Connection {

		

		function Asesores(){
		 	$this->Connect();
		}

		function GetAsesores(){

			$query="SELECT tp.*,a.fecha_online,(SELECT count(ar.id) FROM escolar.tb_asesores_regiones ar where ar.id_asesor=tp.id ) as regiones FROM escolar.tb_personas tp inner join escolar.tb_asesores a on tp.id=a.id  order by tp.nombre asc;  " ;

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


		function AddRegionAsesor($id_asesor=0,$id_region=0){

			$query="INSERT INTO escolar.tb_asesores_regiones (id_asesor,id_region) VALUES (".$id_asesor.",".$id_region.") ;" ;

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				$result['message']="Región asignada correctamente";
			}else{
				$result['message']="Los sentimos, No se puede asignar region en este momento \n Intente mas tarde. 001";

			}
			return $result;
		}

		function RemoveRegionAsesor($id_region_asesor=0){

			$query="DELETE  FROM  escolar.tb_asesores_regiones WHERE   escolar.tb_asesores_regiones.id=".$id_region_asesor." limit 1 ; " ;

			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				$result['message']="Región removida correctamente";
			}else{
				$result['message']="Los sentimos, No se puede remover esta region en este momento \n Intente mas tarde. 002";

			}
			return $result;
		}
		function GetAsesoresRegiones($id_asesor=0){

			$query="SELECT  ar.*,r.nombre as region,c.nombre as corporacion from escolar.tb_asesores_regiones ar  inner join escolar.tb_regiones r on r.id=ar.id_region inner join escolar.tb_corporaciones c on c.id=r.id_corporacion where ar.id_asesor=".$id_asesor." order by c.nombre asc;  " ;

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

