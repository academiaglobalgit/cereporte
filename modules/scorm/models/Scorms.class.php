<?php 
	class Scorms extends Connection {

		function Scorms(){
		 	$this->Connect();
		}

		function GetScorms($scorm=''){
			$where="";
			if(empty($scorm) || $scorm=="" || $scorm=="null"){ 

			}else{
				$where.=" and  ts.nombre LIKE '%".$scorm."%'  ";
			}

			$query="SELECT ts.*,tsf.id as scoid,tsf.url_player,tsf.url_scorm FROM escolar.tb_scorms_files tsf inner join escolar.tb_scorms ts on ts.id=tsf.id_scorm where tsf.status=1 and ts.eliminado=0 ".$where." GROUP BY tsf.id_scorm order by tsf.id ASC    " ;

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
		function GetScorm($id_scorm=0){

			$query="SELECT ts.*,tsf.id as scoid,tsf.url_player,tsf.url_scorm FROM escolar.tb_scorms_files tsf inner join escolar.tb_scorms ts on ts.id=tsf.id_scorm where tsf.status=1 AND ts.id='".$id_scorm."'   GROUP BY tsf.id_scorm order by tsf.id ASC  limit 1  " ;

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

		function GetScormActivas($scorm=''){
			$where="";
			if(empty($scorm) || $scorm=="" || $scorm=="null"){ 

			}else{
				$where.=" AND  ts.nombre LIKE '%".$scorm."%'  ";
			}

			$query=" SELECT ts.*,tsf.id as scoid,tsf.url_player,tsf.url_scorm FROM escolar.tb_scorms_files tsf inner join escolar.tb_scorms ts on ts.id=tsf.id_scorm  WHERE tsf.status=1 AND ts.eliminado=0  ".$where." GROUP BY tsf.id_scorm order by tsf.id ASC     " ;

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

		function GetScormFiles($id_scorm=0){

			$query="SELECT tsf.*,ts.url FROM escolar.tb_scorms_files tsf inner join escolar.tb_scorms ts on ts.id=tsf.id_scorm WHERE tsf.id_scorm='".$id_scorm."' order by tsf.id ASC" ;

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


		function InsertScorm($nombre='',$id_materia=0,$url='no_url'){

			$query="INSERT INTO escolar.tb_scorms (nombre,id_materia,url,fecha_registro) VALUES ('".$nombre."','".$id_materia."','".$url."',now() ) " ;
			$result_scorm=$this->Query($query);
			if($result_scorm['success']){
				$result=$result_scorm;
				$result['message']="Scorm guardado correctamente.";
			}else{
				$result['message']="Error al crear el scorm.";
			}
			return $result;

		}

		function InsertScormFile($id_scorm=0,$url_player='no_url',$url_scorm='no_url'){

			$query="INSERT INTO escolar.tb_scorms_files (id_scorm,url_player,url_scorm,fecha_registro) VALUES ('".$id_scorm."','".$url_player."','".$url_scorm."',now() ) " ;
			
			$query_update="UPDATE escolar.tb_scorms_files tsf SET tsf.status=0 where tsf.id_scorm='".$id_scorm."' "; // desactiva todos los paquetes
			$result_scorm_update=$this->Query($query_update);

			$result_scorm=$this->Query($query); // registra el nuevo paquete y le asigna status 1
			if($result_scorm['success']){
				$result=$result_scorm;
				$result['message']="Scorm guardado correctamente.";
			}else{
				$result['message']="Error al crear el scorm.";
			}
			return $result;

		}

		function ChangeScormFile($id_scorm=0,$id_scorm_file=0){
			
			$query_update="UPDATE escolar.tb_scorms_files tsf SET tsf.status=0 where tsf.id_scorm='".$id_scorm."' "; // desactiva todos los paquetes
			$result_scorm=$this->Query($query_update);

			$query_update2="UPDATE escolar.tb_scorms_files tsf SET tsf.status=1 where tsf.id='".$id_scorm_file."' limit 1 "; // activa el nuebvo scorm

			$result_scorm=$this->Query($query_update2);
			if($result_scorm['success']){
				$result=$result_scorm;
				$result['message']="Scorm activado correctamente.";
			}else{
				$result['message']="Error al crear el scorm.";
			}
			return $result;

		}

		function UpdateScorm($id_scorm=0,$nombre='',$id_materia=0){

			$query="UPDATE escolar.tb_scorms ts SET ts.nombre='".$nombre."',ts.id_materia='".$id_materia."' WHERE ts.id='".$id_scorm."' limit 1" ;
			$result_scorm=$this->Query($query);
			if($result_scorm['success']){
				$result=$result_scorm;
				$result['message']="Scorm actualizada correctamente.";
			}else{
				$result['message']="Error al crear el Scorm.";
			}
			return $result;

		}

		function DeleteScorm($id_scorm=0){

			$query="UPDATE escolar.tb_scorms ts SET ts.eliminado=1 where ts.id='".$id_scorm."' LIMIT 1 ";
			$result_scorm=$this->Query($query);
			if($result_scorm['success']){
				$result=$result_scorm;
				$result['message']="Scorm eliminado correctamente.";
			}else{
				$result['message']="Error al eliminar el Scorm.";
			}
			return $result;
			
		}
		function GetScormsTracks($scormid=0,$userid=0){

			$query="select st.* from escolar.tb_scorms_tracks st where ((st.userid=".$userid.") and (st.scormid=".$scormid.") ) " ;

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

		function DeleteScormsTracks($scormid=0,$userid=0){

			$query="DELETE FROM escolar.tb_scorms_tracks where ((userid=".$userid.") and (scormid=".$scormid.") ) ";
			$result_scorm=$this->Query($query);
			if($result_scorm['success']){
				$result=$result_scorm;
				$result['message']="Scorm Tracks eliminados correctamente.";
			}else{
				$result['message']="Error al eliminar el Scorm tracks .".$result_scorm['message'];
			}
			return $result;
			
		}
	}
?>