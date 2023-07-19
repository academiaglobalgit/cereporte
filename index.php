<?php
session_start();
if(isset($_SESSION['id_persona'])){
	if($_SESSION['id_persona']!=0){
		require_once "views/home.html";
	}else{
		require_once "views/login.html";
	}
}else{
		require_once "views/login.html";
}
?>