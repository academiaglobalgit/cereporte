<?php

 class ConnectionPG {

	var $bd="masterag";
	var $usuario="postgres";
	var $pass="uCG1lysB9a4PGTkg7qeZ496u5063yHVW";
	var $servidor="localhost";
	var $con; //conexion

	function ConnectionPG(){

	}

	function Connect($server='',$username='',$password='',$batabase='')
	{
		if($this->con){
			$this->Close();
		}

		if($this->con=pg_connect("host=".$server." dbname=".$batabase." user=".$username." password=".$password." port=5432")){
		}else{
			return false;
		}
	}

	function Close(){
		pg_close($this->con);
	}

	function Query($query=''){
		//pg_query($this->con,"set charset utf8 ");

		$result['message']="No message";
		$result['data']=null;
		$result['success']="";
		$result['data']=pg_query($this->con,$query);
		if($result['data']){
			$result['message']="Query executed successfully";
			$result['success']=true;
		}else{
			$result['data']=null;
			$result['message']=pg_last_error($this->con);
			$result['success']=false;
		}
		return $result;

	}

	function last_insert_table($table,$columnid)
	{
		$last_id=0;
		$result_lastid=$this->Query('SELECT "'.$columnid.'" FROM "masterag"."'.$table.'" ORDER BY  "'.$columnid.'" DESC LIMIT 1;');
		if($result_lastid['success']){
			while ($line = pg_fetch_array($result_lastid['data'], null, PGSQL_ASSOC)) {
			    foreach ($line as $col_value) {
			        $last_id=$col_value;
			    }
			}
		}

		return $last_id;

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


}
?>
