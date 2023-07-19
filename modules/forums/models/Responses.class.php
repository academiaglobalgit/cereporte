<?php 
	class Responses extends Connection {

		function Responses(){
		 	$this->Connect();
		}
	




		function GetResponses($id_thread=0){
			$query="SELECT r.* FROM tb_foros_respuestas r where r.id_hilo='".$id_thread."'  and r.eliminado=0 order by r.id ASC";
			$result=$this->Query($query);
			if($result['success']){
				$arrayResult=array();
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function GetResponse($id_response=0){
			$query="SELECT r.* FROM tb_foros_respuestas r where r.id='".$id_response."'  and r.eliminado=0 order by r.id ASC";
			$result=$this->Query($query);
			if($result['success']){
				while($row=mysqli_fetch_array($result['data'])){
					$result['data'] = $row;
				}
			}
			return $result;
		}

		function SetResponse($id_thread=0,$text='',$is_correct=0){
			$query="CALL rv_set_response(".$id_thread.",'".$text."',".$is_correct."); ";
			$result=$this->Query($query);
			if($result['success']==true){
				$result['message']="Respuesta guardada correctamente.";
			}
			return $result;
		}

		function DeleteResponses($id_thread=0){
			$query="CALL rv_delete_responses(".$id_thread."); ";
			$result=$this->Query($query);
			if($result['success']==true){
				$result['message']="Respuesta guardada Eliminada.";
			}
			return $result;
		}

	}
?>