<?php
//echo "REF: ".basename($_SERVER['HTTP_REFERER'], ".php");


$array = array();

$array['a1']=null;
$array['a2']=1;
$array['a3']="hola";
if(!array_filter($array)){
	print_r(array_filter($array));
}
else{
	print_r(array_filter($array));
}
 
?>