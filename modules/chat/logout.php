<?php
	session_start();
/*
				$_SESSION['id_persona']=null;
				$_SESSION['permisos']=null;
				$_SESSION['id_corporacion']=null;
	session_destroy();*/
	$_SESSION['id_corporacion']=0;

	header('Location: index.php');

?>
