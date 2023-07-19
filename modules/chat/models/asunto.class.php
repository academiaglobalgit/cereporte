<?php
class Asunto 
{
	var $id;
	var $id_usuario;
	var $nombre;
	var $asunto;
	var $fecha;
	var $telefono;
	var $status;
	var $archivo; // array de mensajes de chat
	var $notif; // array de mensajes de chat
	var $online; // array de mensajes de chat

	var $chat; // array de mensajes de chat
	
	/*
	STATUS
	0 
	1 
	*/
	function Asunto($id_=0,$id_usuario_=0,$nombre_="indefinido",$asunto_='Indefinida',$fecha_="0000-00-00",$telefono_='',$status_=0,$archivo_="",$chat_=[],$notif_=0,$online_=0){
		$this->id=$id_;
		$this->id_usuario=$id_usuario_;
		$this->nombre=$nombre_;		
		$this->asunto=$asunto_;
		$this->fecha=$fecha_;
		$this->status=$status_;
		$this->chat=$chat_;
		$this->telefono=$telefono_;
		$this->archivo=$archivo_;
		$this->notif=$notif_;
		$this->online=$online_;

	}

}
?>