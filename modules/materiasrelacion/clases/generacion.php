<?php 
class Generacion
{
	var $id;
	var $nombre;
	var $periodos;
	var $show;
	function Generacion($id_=0,$nombre_="",$periodos_=[])
	{
		$this->id=$id_;
		$this->nombre=$nombre_;
		$this->periodos=$periodos_;
		$this->show=false;
	}
}
?>