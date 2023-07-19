<?php 
	class Posts extends Connection {

		

		function Posts(){
		 	$this->Connect();
		}

		function GetPosts($id_thread=0){
			$query="SELECT p.*,CONCAT(tb_personas.nombre,'',tb_personas.apellido1,'',tb_personas.apellido2) as user FROM tb_foros_posts p LEFT join tb_personas on tb_personas.id=p.id_alumno  where p.id_hilo='".$id_thread."'  and p.eliminado=0 order by p.id ASC";
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

		function GetPost($id_post=0){
			$query="SELECT p.*,CONCAT(tb_personas.nombre,'',tb_personas.apellido1,'',tb_personas.apellido2) as user FROM tb_foros_posts p LEFT join tb_personas on tb_personas.id=p.id_alumno where p.id='".$id_post."' and p.eliminado=0 order by p.id ASC";
			$result=$this->Query($query);
			if($result['success']){
				while($row=mysqli_fetch_array($result['data'])){
					$result['data'] = $row;
				}
			}
			return $result;
		}

		function SetPost($id_thread=0,$id_parent=0,$titulo='No Definido',$text='',$id_respuesta=0,$id_user=0){
			$query="CALL rv_set_post(".$id_thread.",".$id_parent.",'".$titulo."','".$text."','".$id_respuesta."',".$id_user."); ";
			$result=$this->Query($query);
			if($result['success']==true){
				$result['message']="Publicación guardada correctamente.";
			}
			return $result;
		}

		function UpdatePost($id_post=0,$titulo='No definido',$text=''){
			$query="CALL rv_update_post(".$id_post.",'".$titulo."','".$text."'); ";
			$result=$this->Query($query);
			if($result['success']==true){
				$result['message']="Publicación Modificada correctamente.";
			}
			return $result;
		}	

		function DeletePost($id_post=0){
			$query="CALL rv_delete_post(".$id_post."); ";
			$result=$this->Query($query);
			if($result['success']==true){
				$result['message']="Publicación Eliminada correctamente.";
			}
			return $result;
		}	

	}
?>