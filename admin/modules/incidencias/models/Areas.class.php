<?php 
	class Areas extends Connection {

		function Areas(){
		 	$this->Connect();
		}

		function GetAreas($area=''){
			$where="";


			if(empty($area) || $area=="" || $area=="null"){ 

			}else{
				$where.=" where tua.descripcion LIKE '%".$area."%'  ";
			}

			$query="SELECT tua.* from escolar.tb_usuarios_areas tua ".$where." order by tua.id ASC; " ;

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

		function GetAreasActivas($area=''){
			$where="";


			if(empty($area) || $area=="" || $area=="null"){ 

			}else{
				$where.=" AND  tua.descripcion LIKE '%".$area."%'  ";
			}

			$query="SELECT tua.* from escolar.tb_usuarios_areas tua where (tua.estatus='A') ".$where." order by tua.orden ASC; " ;

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

		function InsertArea($descripcion='',$orden=0){


			$query="INSERT INTO escolar.tb_usuarios_areas (descripcion,estatus,orden)VALUES ('".$descripcion."','A','".$orden."') " ;

			$result_area=$this->Query($query);
			if($result_area['success']){
				$result=$result_area;
				$result['message']="Area creada correctamente.";

			}else{
				$result['message']="Error al crear el Area.";

			}
			return $result;
		}


		function UpdateArea($id_area=0,$descripcion='',$estatus='A',$orden=0){

			$query="UPDATE escolar.tb_usuarios_areas tua SET tua.orden='".$orden."',tua.descripcion='".$descripcion."',tua.estatus='".$estatus."' WHERE tua.id='".$id_area."' limit 1" ;

			$result_area=$this->Query($query);
			if($result_area['success']){
				$result=$result_area;
				$result['message']="Area actualizada correctamente.";

			}else{
				$result['message']="Error al crear el Area.";

			}
			return $result;
		}
	}
?>