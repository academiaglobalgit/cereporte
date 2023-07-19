<?php
	require_once "config.php";	
	session_start();

	$permisos=array();
	$permisos['permisos']=$_SESSION['permisos'];
	$permisos['id_permiso']=$_SESSION['id_permiso'];
	$id_persona = $_SESSION['id_persona'];

	if(!isset($_SESSION['id_tiporol']))
	{
		$mysql= new Connect();
		if($mysql->Connectar())
		{
			$query = "SELECT arl.id_tiporol FROM escolar.tb_ayuda_rolespersonas arl 
				INNER JOIN escolar.tb_ayuda_tiposroles atr ON atr.id_tiporol = arl.id_tiporol AND atr.sn_activo = 1 
				WHERE id_asesor = " . $id_persona;

			$result = $mysql->Query($query);

			if($result)
			{
				$arrayTiposRol = [];
				while($row=mysql_fetch_array($result))
				{
					$item = new stdClass;
					$item->id_tiporol = $row['id_tiporol'];
					array_push($arrayTiposRol, json_encode($item));
				}

				$_SESSION['tiposroles_ayuda'] = $arrayTiposRol;
			}		
		}
	}

	$permisos['tiposroles_ayuda'] = $_SESSION['tiposroles_ayuda'];

	//$permisos['id_tiporol']=$_SESSION['id_tiporol'];
	echo json_encode($permisos);
?>