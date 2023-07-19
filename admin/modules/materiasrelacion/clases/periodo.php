<?php 
class Periodo 
{
	var $id;
	var $nombre;
	var $numero;
	var $materias;
	var $show;


	function Periodo($id_=0,$nombre_="",$numero_=0,$materias_=[]){
		$this->id=$id_;
		$this->nombre=$nombre_;
		$this->numero=$numero_;
		$this->materias=$materias_;
		$this->show=false;

	}
}

?>