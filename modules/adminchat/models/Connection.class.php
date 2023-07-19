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
}
?> 