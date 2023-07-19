<?php

class Connection {

	var $bd="escolar";
	var $usuario="sistemas";
	var $pass="uCG1lysB9a4PGTkg7qeZ496u5063yHVW";
	var $servidor="localhost";
	var $con; //conexion

	//CONFIG


	function Connection($servidor_="localhost",$usuario_="sistemas",$pass_="uCG1lysB9a4PGTkg7qeZ496u5063yHVW",$bd_="escolar"){
		$this->bd=$bd_;
		$this->servidor=$servidor_;
		$this->usuario=$usuario_;
		$this->pass=$pass_;
	}

	function Connect()
	{

		if($this->con){
			$this->Close();
		}

		if($this->con=mysqli_connect($this->servidor,$this->usuario,$this->pass)){
			if(mysqli_select_db($this->con,$this->bd)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}

	}

	function Close(){
		mysqli_close($this->con);
	}

	function Query($query=''){
		mysqli_query($this->con,"set charset utf8 ");

		$result['message']="No message";
		$result['data']=null;
		$result['success']="";
		$result['data']=mysqli_query($this->con,$query);
		if($result['data']){
			$result['message']="Query executed successfully";
			$result['success']=true;
		}else{
			$result['data']=null;
			$result['message']=mysqli_error($this->con);
			$result['success']=false;
		}
		return $result;

	}

	function last_insert_id(){
		return mysqli_insert_id($this->con);
	}

	function begin_transaction(){
		 $this->Query("START TRANSACTION");
	}

	function commit(){
		 $this->Query("COMMIT");
	}

	function rollback(){
		 $this->Query("ROLLBACK");
	}

	function Bitacora($id_persona=0,$modulo="",$accion="",$comentario=""){
		 $this->Query("INSERT INTO escolar.tb_bitacora_ce (id_persona,modulo,accion,comentarios,fecha_registro) VALUES (".$id_persona.",'".$modulo."','".$accion."','".$comentario."',now()) ;");
	}
}
?>
