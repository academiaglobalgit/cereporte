<?php 
	class Problematicas extends Connection {

		function Problematicas(){
		 	$this->Connect();
		}

		function GetProblematicas($problematica=''){
			$where="";

			if(empty($problematica) || $problematica=="" || $problematica=="null"){ 

			}else{
				$where.=" where tbp.nombre LIKE '%".$problematica."%'  ";
			}

			$query="SELECT tbp.*,c.nombre as categoria_nombre,a.descripcion as area_nombre,p.nombre as plan_nombre from escolar.tb_problematicas tbp
			left join escolar.tb_problematicas_categorias c on c.id=tbp.id_categoria 
			left join escolar.tb_usuarios_areas a on a.id=tbp.id_area 
			left join escolar.tb_plan_estudio p on p.id=tbp.id_plan_estudios ".$where." order by tbp.id ASC " ;

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

		function GetProblematicasActivas($problematica=''){
			$where="";

			if(empty($problematica) || $problematica=="" || $problematica=="null"){ 

			}else{
				$where.=" AND  tbp.nombre LIKE '%".$problematica."%'  ";
			}

			$query="SELECT tbp.* from escolar.tb_problematicas tbp where (tbp.estatus='A') ".$where." order by tbp.orden ASC; " ;
			
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

		function InsertProblematica($nombre='No definido',$id_categoria=0,$id_area=0,$id_plan_estudios=0){


			$query="INSERT INTO escolar.tb_problematicas  (nombre, estatus, id_categoria, id_area, id_plan_estudios, fecha_alta) VALUES ('".$nombre."',1,'".$id_categoria."','".$id_area."','".$id_plan_estudios."',now()) " ;


			$result_problematica=$this->Query($query);
			if($result_problematica['success']){
				$result=$result_problematica;
				$result['message']="Problematica creada correctamente.";

			}else{
				$result['message']="Error al crear el problematica.";

			}
			return $result;
		}


		function UpdateProblematica($id_problematica=0,$nombre='',$estatus='A',$id_categoria=0,$id_area=0,$id_plan_estudios=0){

			$query="UPDATE escolar.tb_problematicas tbp 
			SET  tbp.nombre='".$nombre."',
			 tbp.estatus='".$estatus."',
			  tbp.id_categoria='".$id_categoria."',
			   tbp.id_area='".$id_area."',
			    tbp.id_plan_estudios='".$id_plan_estudios."' WHERE tbp.id='".$id_problematica."' limit 1"; 

			$result_problematica=$this->Query($query);
			if($result_problematica['success']){
				$result=$result_problematica;
				$result['message']="Problematica actualizada correctamente.";
			}else{
				$result['message']="Error al crear el problematica.";
			}

			return $result;
		}

	}
?>