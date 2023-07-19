<?php
class Mensaje 
{

	var $id;
	var $id_asunto;
	var $id_usuario;
	var $fecha;
	var $nombre;
	var $mensaje;
	var $visto;

	function Mensaje($id_=0,$id_asunto_=0,$id_usuario_=0,$fecha_='0000-00-00',$nombre_='Indefinido',$mensaje_='',$visto_=0){
		$this->id=$id_;
		$this->id_asunto=$id_asunto_;
		$this->id_usuario=$id_usuario_;
		$this->fecha=$fecha_;
		$this->nombre=$nombre_;
		$this->mensaje=$mensaje_;
		$this->visto=$visto_;

	}

}
?>