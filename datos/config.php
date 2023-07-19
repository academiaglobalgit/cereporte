<?php 
class Connect {

	var $bd="prepacoppel";
	var $usuario="sistemas";
	var $pass="uCG1lysB9a4PGTkg7qeZ496u5063yHVW";
	var $servidor="localhost";
	var $con; //conexion

	function Connect($servidor_="localhost",$usuario_="sistemas",$pass_="uCG1lysB9a4PGTkg7qeZ496u5063yHVW",$bd_="prepacoppel"){
		$this->bd=$bd_;
		$this->servidor=$servidor_;
		$this->usuario=$usuario_;
		$this->pass=$pass_;
	}
	
	function Connectar()
	{

		if($this->con=mysql_connect($this->servidor,$this->usuario,$this->pass)){
			if(mysql_select_db($this->bd)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}

	}

	function Cerrar(){
		mysql_close($this->con);
	}

	function getConection()
	{
		return $this->con;
	}

	function Query($query=''){
		mysql_query("set charset utf8 ",$this->con);
		$result=mysql_query($query,$this->con);
		return $result;

	}
}
?>