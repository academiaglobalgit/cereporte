<?PHP 
	function conexion2()
	{

		
		$DB_HOST='localhost';
		$DB_USER='root';
		$DB_PASSWORD='uCG1lysB9a4PGTkg7qeZ496u5063yHVW';
		$DB_NAME='prepacoppel';
		
		$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		if(mysqli_connect_errno()){
			printf(error_db_connect());
			exit();
			}
			return $mysqli;
	}
?>