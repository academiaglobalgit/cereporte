<?php
class Frecuente 
{
	var $id;
	var $asunto;
	var $mensaje;
	var $jerarquia;

	function Frecuente($id_=0,$asunto_='',$mensaje_='',$jerarquia_=0){
		$this->id=$id_;
		$this->asunto=$asunto_;
		$this->mensaje=$mensaje_;
		$this->jerarquia=$jerarquia_;


	}

}
?>