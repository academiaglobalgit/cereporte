<?PHP 
	function conexion()
	{
		$DB_HOST='localhost';
		$DB_USER='sistemas';
		$DB_PASSWORD='uCG1lysB9a4PGTkg7qeZ496u5063yHVW';
		//$DB_PASSWORD='uCG1lysB9a4PGTkg7qeZ496u5063yHVW';
		$DB_NAME='prepacoppel';
		
		$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		if(mysqli_connect_errno()){
			printf(error_db_connect());
			exit();
			}
			return $mysqli;
	}
?>
<?php 
/*define('server','localhost');
define('db','prepacoppel');
define('user','root');
define('password','uCG1lysB9a4PGTkg7qeZ496u5063yHVW');

$connection = mysqli_connect(server,user,password,db);*/

?>