<?php
session_start();
if(isset($_SESSION['id_corporacion'])){
	if($_SESSION['id_corporacion']!=0){
		require_once "views/home.html";
	}else{
		require_once "views/login.html";
	}
}else{
		require_once "views/login.html";
}
?>