<?php 
class Persona
{
	var $id;
	var $nombre;
	var $apellidos;
	var $seguimientos;

	function Persona($id_=0,$nombre_='Indefinido',$apellidos_='Indefinido',$seguimientos_=[]){
		$this->id=$id_;
		$this->ingreso=$ingreso_;
		$this->nombre=$nombre_;
		$this->apellidos=$apellidos_;
		$this->seguimientos=$seguimientos_;
	}


}
?>