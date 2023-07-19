<?php 
	class Telefonos extends Connection {

		function Telefonos(){
		 	$this->Connect();
		}

		function GetTelefonosPreview($id_alumno=0){

		 	$query="SELECT tnt.* FROM escolar.tb_numeros_telefonicos tnt WHERE tnt.id_alumno='".$id_alumno."' and tnt.eliminado=0  limit 4";
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


		function GetTelefonos($id_alumno=0){

		 	$query="SELECT tnt.* FROM escolar.tb_numeros_telefonicos tnt WHERE tnt.id_alumno='".$id_alumno."' and tnt.eliminado=0  order by tnt.id DESC";
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
		function InsertTelefono($id_alumno=0,$id_usuario=0,$telefono='1337'){

			$query="INSERT INTO escolar.tb_numeros_telefonicos (id_alumno,id_asesor,numero_telefonico,eliminado,fecha_alta) VALUES ('".$id_alumno."','".$id_usuario."','".$telefono."',0,now() ) ";
		 	$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				$result['message']="Telefono registrado correctamente";

				$id_last=$this->last_insert_id();
				$pg = new ConnectionPG(); //conexion postgres
				if(!$pg->Connect("localhost","postgres","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","masterag")){
						//NO CONNECT
				} 
				$migrapersonas_produccion= new MigraPersonas($this, $pg); 
				$semigro=false;
				$semigro=$migrapersonas_produccion->MigrarTelefono($id_last); 
				$pg->Close();

				if($semigro){
					$result['message'].=".";
				}

			}else{
				$result['message']="No se ha podido guardar el telefono, intenta mas tarde.";
			}

			return $result;

		}

		function DeleteTelefono($id_telefono=0,$id_motivo_baja=1){
		 	$query="UPDATE escolar.tb_numeros_telefonicos tnt SET tnt.eliminado=1,tnt.id_motivo_baja=".$id_motivo_baja." WHERE tnt.id=".$id_telefono." limit 1 " ;
		 	$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				
				$result['message']="Telefono se ha eliminado correctamente";
				$pg = new ConnectionPG(); //conexion postgres
				if(!$pg->Connect("localhost","postgres","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","masterag")){
						//NO CONNECT
				} 
				$migrapersonas_produccion= new MigraPersonas($this, $pg); 
				$semigro=false;
				$semigro=$migrapersonas_produccion->MigrarTelefono($id_telefono); 
				$pg->Close();
				if($semigro){
					$result['message'].=".";
				}

			}else{
				$result['message']="No se ha podido eliminar el telefono, intenta mas tarde.";
			}

			return $result;
		}

		function GetMotivosBajasTelefonos(){

		 	$query="SELECT tnt.* FROM escolar.tb_numeros_telefonicos_motivos_baja tnt  order by tnt.id ASC";
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