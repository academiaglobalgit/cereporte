<?php
	function limpiarString($text){

	 $chars =   array("\\", "¨", "º", "~",
	              "|", "!", "\"",
	             "·", "$", "%", "&", "/",
	             "(", ")", "'", "¡",
	              "[", "^", "`", "]",
	             "+", "}", "{", "¨", "´",
	             ">", "<"
	             );
	        

	$clean = str_replace($chars, "", $text);
	return $clean;
	}

	function strip_all($text){

	  return limpiarString(strip_tags($text));

	}
?>