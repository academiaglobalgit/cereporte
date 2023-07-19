<?php 
	class Threads extends Connection {

		

		function Threads(){
		 	$this->Connect();
		}

		function GetThreads($id_forum=0){
			$query="SELECT tb_foros_hilos.*,tb_foros_posts.texto,(SELECT COUNT(tb_foros_posts.id)-1 from tb_foros_posts where tb_foros_posts.id_hilo=tb_foros_hilos.id ) as comentarios,CONCAT(tb_personas.nombre,'',tb_personas.apellido1,'',tb_personas.apellido2) as admin FROM tb_foros_hilos inner join tb_foros_posts on tb_foros_hilos.id_primer_post=tb_foros_posts.id LEFT join tb_personas on tb_personas.id=tb_foros_hilos.id_admin where tb_foros_hilos.id_foro=".$id_forum." and tb_foros_hilos.eliminado=0 ORDER BY tb_foros_hilos.id ASC";
			$result=$this->Query($query);
			if($result['success']){
				$arrayResult=array();
				while($row=mysqli_fetch_assoc($result['data'])){
					$result2=$this->Query("SELECT r.* FROM tb_foros_respuestas r where r.id_hilo=".$row['id']." and r.eliminado=0 order by r.id asc");
					$respuestas=array();
					if($result2['success']){
						while ($row2=mysqli_fetch_array($result2['data'])) {
							$respuestas[]=$row2;
						}
					}
					$row['responses']=$respuestas;

					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function GetThread($id_thread=0){
			$query="SELECT tb_foros_hilos.*,tb_foros_posts.texto,(SELECT COUNT(tb_foros_posts.id)-1 from tb_foros_posts  where tb_foros_posts.id_hilo=tb_foros_hilos.id ) as comentarios,CONCAT(tb_personas.nombre,'',tb_personas.apellido1,'',tb_personas.apellido2) as admin FROM tb_foros_hilos inner join tb_foros_posts on tb_foros_hilos.id_primer_post=tb_foros_posts.id LEFT join tb_personas on tb_personas.id=tb_foros_hilos.id_admin where tb_foros_hilos.id=".$id_thread." and tb_foros_hilos.eliminado=0 limit 1 ;";
			$result=$this->Query($query);
			if($result['success']){
				while($row=mysqli_fetch_array($result['data'])){

					$result2=$this->Query("SELECT r.* FROM tb_foros_respuestas r where r.id_hilo=".$row['id']." and r.eliminado=0 order by r.id asc");
					$respuestas=array();
					if($result2['success']){
						while ($row2=mysqli_fetch_array($result2['data'])) {
							$respuestas[]=$row2;
						}
					}
					$row['responses']=$respuestas;
				
					$result['data'] = $row;
					
				}
			}
			return $result;
		}

		function SetThread($nombre='No Definido',$id_forum=0,$text='',$text_correct='',$text_incorrect='',$id_admin=0,$tipo=0,$responses=array(),$idx_correct=0){
			$query="select rv_set_thread('".$nombre."',".$id_forum.",'".$text."','".$text_correct."','".$text_incorrect."',".$id_admin.",".$tipo.") as id_thread; ";
			$result=$this->Query($query);
			if($result['success']==true){
							/*INSERT RESPONSES*/
							$row= mysqli_fetch_array($result['data']);
							$id_thread_=$row[0];
							for ($i=0; $i < count($responses); $i++) { 
								$is_correct=0;
								if($idx_correct==$i){ //IF IS THE CORRET RESPONSE
									$is_correct=1;
								}
								$insert_responses=" CALL rv_set_response(".$id_thread_.",'".$responses[$i]."',".$is_correct."); ";
								$result2=$this->Query($insert_responses);
								if($result2['success']==true && $is_correct==1){ // IF IS THE CORRECT RESPONSE
									$id_correct= mysqli_insert_id($this->con); 
									$this->Query("UPDATE tb_foros_hilos SET tb_foros_hilos.id_respuesta='".$id_correct."' where tb_foros_hilos.id='".$id_thread_."' ");
								}
							}


				$result['message']="Pregunta Detonadora guardada correctamente.";
			}
			return $result;
		}

		function UpdateThread($id_thread=0,$nombre='No definido',$text='',$text_correct='',$text_incorrect='',$tipo=0,$responses=array(),$idx_correct=0){
			$query="CALL rv_update_thread(".$id_thread.",'".$nombre."','".$text."','".$text_correct."','".$text_incorrect."',".$tipo."); ";
			$result=$this->Query($query);
			if($result['success']==true){
				/*INSERT RESPONSES*/
							$id_thread_=$id_thread;
							$this->Query("CALL rv_delete_responses(".$id_thread.");");
							for ($i=0; $i < count($responses); $i++) { 
								$is_correct=0;
								if($idx_correct==$i){ //IF IS THE CORRET RESPONSE
									$is_correct=1;
								}
								$insert_responses=" CALL rv_set_response(".$id_thread_.",'".$responses[$i]."',".$is_correct."); ";
								$result2=$this->Query($insert_responses);
								if($result2['success']==true && $is_correct==1){ // IF IS THE CORRECT RESPONSE
									$id_correct= mysqli_insert_id($this->con); 
									$this->Query("UPDATE tb_foros_hilos SET tb_foros_hilos.id_respuesta='".$id_correct."' where tb_foros_hilos.id='".$id_thread_."'; ");
								}
							}
				$result['message']="Pregunta Detonadora Modificada correctamente.";
			}


			return $result;
		}	

		function DeleteThread($id_thread=0){
			$query="CALL rv_delete_thread(".$id_thread."); ";
			$result=$this->Query($query);
			if($result['success']==true){
				$result['message']="Pregunta Detonadora Eliminada correctamente.";
			}
			return $result;
		}	

	}
?>