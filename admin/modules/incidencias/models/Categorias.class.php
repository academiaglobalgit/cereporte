<?php 
	class Categorias extends Connection {

		function Categorias(){
		 	$this->Connect();
		}

		function GetCategorias($categoria=''){
			$where="";


			if(empty($categoria) || $categoria=="" || $categoria=="null"){ 

			}else{
				$where.=" where tbc.nombre LIKE '%".$categoria."%'  ";
			}

			$query="SELECT tbc.* from escolar.tb_problematicas_categorias tbc ".$where." order by tbc.id ASC; " ;

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

		function GetCategoriaActivas($categoria=''){
			$where="";


			if(empty($categoria) || $categoria=="" || $categoria=="null"){ 

			}else{
				$where.=" AND  tbc.nombre LIKE '%".$categoria."%'  ";
			}

			$query="SELECT tbc.* from escolar.tb_problematicas_categorias tbc where (tbc.estatus='A') ".$where." order by tbc.orden ASC; " ;

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

		function InsertCategoria($nombre='',$tipo=1){


			$query="INSERT INTO escolar.tb_problematicas_categorias (nombre,tipo_incidencia)VALUES ('".$nombre."','".$tipo."') " ;

			$result_categoria=$this->Query($query);
			if($result_categoria['success']){
				$result=$result_categoria;
				$result['message']="Categoria creada correctamente.";

			}else{
				$result['message']="Error al crear el categoria.";

			}
			return $result;
		}


		function UpdateCategoria($id_categoria=0,$nombre='',$tipo=1,$estatus='A',$orden=0){

			$query="UPDATE escolar.tb_problematicas_categorias tbc SET tbc.nombre='".$nombre."', tbc.tipo_incidencia='".$tipo."'  WHERE tbc.id='".$id_categoria."' limit 1" ;

			$result_categoria=$this->Query($query);
			if($result_categoria['success']){
				$result=$result_categoria;
				$result['message']="categoria actualizada correctamente.";

			}else{
				$result['message']="Error al crear el categoria.";

			}
			return $result;
		}
	}
?>