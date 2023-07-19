<?php
    require_once "config.php";	
	session_start();

	
	
    $mysql= new Connect();
    if($mysql->Connectar())
    {
        $query = "select DISTINCT generacion from escolar.tb_dgb_alumnos where generacion >0";

        $result = $mysql->Query($query);

       if($result)
        {
            $arrayGeneraciones = [];
            while($row=mysql_fetch_array($result))
            {
                $item = new stdClass;
                $item->generacion = $row['generacion'];
                array_push($arrayGeneraciones,$item);
            }

        }	
    }

	//$permisos['tiposroles_ayuda'] = $_SESSION['tiposroles_ayuda'];

	//$permisos['id_tiporol']=$_SESSION['id_tiporol'];
	//echo json_encode($permisos);

echo json_encode($arrayGeneraciones);

?>