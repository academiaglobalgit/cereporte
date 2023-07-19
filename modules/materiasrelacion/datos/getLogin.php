<?php 
session_start();
if(isset($_SESSION['persona']))
	echo json_encode($_SESSION['persona']);
?>