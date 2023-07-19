<?php
    include 'config.php';
            	$bd="prepatoks";

    $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW",$bd);
    $mysql->Connectar();
 	$arrayresult=array();
 	$result_a= $mysql->Query("SELECT DISTINCT DATE(ac.fecha_corte) as fecha_corte FROM ag_cortes ac order by ac.fecha_corte DESC " );

 	while ($row=mysql_fetch_array($result_a)) {
 		$arrayresult[]=$row;
 	}

 	echo json_encode($arrayresult);
?>