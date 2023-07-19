<?php 
session_start();
require_once "configAyuda.php";
require_once "../models/asunto.class.php";
require_once "../models/mensaje.class.php";

/*require_once('../../../preparatoriascorporativas/prepacoppel/config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/querylib.php');*/

//$id_usuario=$USER->id;
/*
if(isset($_GET['id_usuario'])){
	$id_usuario=strip_tags($_GET['id_usuario']);
}*/
$seguimientos= array();
$chats= array();
$regiones_filtro="";
$where=" WHERE escolar.view_asuntos.id_corporacion='".$_SESSION['id_corporacion']."' and ta.id_corporacion='".$_SESSION['id_corporacion']."'  AND (ae.categoria=0 OR ae.categoria=2 ) ";
$regiones="";
$mysql= new Connect();




/*if(isset($_GET['region']) && !empty($_GET['region'])){
	$region=$_GET['region'];
	$where.=" AND (
	(select mdl_user_info_data.data from mdl_user_info_data where mdl_user_info_data.userid = view_asuntos.id_usuario and mdl_user_info_data.fieldid = 10 limit 1)='".$region."' OR (select escolar.tb_alumnos.asesor FROM escolar.tb_alumnos WHERE escolar.tb_alumnos.idmoodle= view_asuntos.id_usuario and  escolar.tb_alumnos.id_corporacion='".$_SESSION['id_corporacion']."' limit 1 )='".$_SESSION['id_persona']."' ) ";
}else{
	$where.=" AND (select escolar.tb_alumnos.asesor FROM escolar.tb_alumnos WHERE escolar.tb_alumnos.idmoodle= view_asuntos.id_usuario and  escolar.tb_alumnos.id_corporacion='".$_SESSION['id_corporacion']."' limit 1 )='".$_SESSION['id_persona']."' ";
}*/

	if($mysql->Connectar()){

		if($result_reg=$mysql->Query("SELECT escolar.tb_asesores_regiones.id_region FROM escolar.tb_asesores_regiones WHERE escolar.tb_asesores_regiones.id_asesor='".$_SESSION['id_persona']."' ")){
			while ($row_reg=mysql_fetch_array($result_reg)) {
				$regiones.=" OR tp.region='".$row_reg['id_region']."' ";
			}
		}

		$regiones_filtro=$where." AND (1=2 ".$regiones." ) ";
		//echo $regiones_filtro;

		if($mysql->Query("UPDATE escolar.tb_asesores set escolar.tb_asesores.fecha_online=NOW() WHERE escolar.tb_asesores.id='".$_SESSION['id_persona']."' limit 1 ")){
			
		}
		$query_chat="
			SELECT view_asuntos.id,
			ta.idmoodle,
			tc.nombre as corporacion,
			tpe.nombre as plan_estudio,
			escolar.view_asuntos.fecha_registrado,
			escolar.view_asuntos.fecha_online,
			IF(DATE_SUB(NOW(),INTERVAL 30 SECOND) < escolar.view_asuntos.fecha_online,1,0) as online,
			concat(tp.nombre,' ',tp.apellido1,' ',tp.apellido2)  as nombre,
			(SELECT escolar.ag_ayuda_mensajes.fecha_registrado from escolar.ag_ayuda_mensajes WHERE (escolar.ag_ayuda_mensajes.id_asunto=view_asuntos.id and escolar.ag_ayuda_mensajes.id_usuario != 0) ORDER BY escolar.ag_ayuda_mensajes.id DESC limit 1) as ultima_fecha, 
			(SELECT COUNT(escolar.ag_ayuda_mensajes.id) from escolar.ag_ayuda_mensajes where escolar.ag_ayuda_mensajes.id_asunto=view_asuntos.id and escolar.ag_ayuda_mensajes.visto=0 ) as novistos 

			FROM escolar.view_asuntos 
			LEFT JOIN  escolar.tb_alumnos ta on ta.id=view_asuntos.id_usuario
			LEFT JOIN  escolar.tb_personas tp on tp.id=ta.id_persona
			LEFT JOIN  escolar.tb_plan_estudio tpe on tpe.id=ta.id_plan_estudio
			LEFT JOIN  escolar.tb_corporaciones tc on tc.id=ta.id_corporacion
			LEFT JOIN  tb_alumnos_estados ae on ta.estado=ae.id  
			 ".$regiones_filtro."  order by online DESC,novistos DESC,fecha_online DESC , ultima_fecha desc ";

		if($result=$mysql->Query($query_chat)){

			while ($segui=mysql_fetch_array($result)) {
				$j=0;
				$chats=[];
				//$mysql2= new Connect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
				$query="SELECT id_asunto,fecha_registrado,id_usuario,mensaje,visto,(SELECT concat(tb_personas.nombre,' ',tb_personas.apellido1) from tb_personas inner join tb_alumnos on tb_alumnos.id_persona=tb_personas.id WHERE tb_alumnos.id=view_mensajes.id_usuario AND tb_alumnos.id_corporacion='".$_SESSION['id_corporacion']."' limit 1) as nombre,(SELECT escolar.tb_personas.nombre from escolar.tb_personas WHERE escolar.tb_personas.id=view_mensajes.id_facilitador ) as nombre_asesor FROM view_mensajes where id_asunto='".$segui['id']."' ORDER BY fecha_registrado DESC limit 10 ";

				$notificaciones=0;
				if($result2=$mysql->Query($query)){
					while ($msg=mysql_fetch_array($result2)) {
						$visto=1;
						if($msg["id_usuario"]==0){
							$nombre=$msg['nombre_asesor'];
						}else{
							$visto=$msg['visto'];
							$nombre=$msg['nombre'];
							if($visto==0){
								$notificaciones++;
							}
						}
						array_push($chats,new Mensaje($j,$msg['id_asunto'],$msg['id_usuario'],$msg['fecha_registrado'],$nombre,$msg['mensaje'],$visto));
						$j++;
					}

				}

				
				array_push($seguimientos, new Asunto($segui['id'],$segui['idmoodle'],$segui['nombre'],$segui['corporacion'].": ".$segui['plan_estudio'],$segui['fecha_online'],'',0,'',$chats,$notificaciones,$segui['online'] ) );
			}

			$mysql->Cerrar();
		}
	}

				echo json_encode($seguimientos);


function checkOnline($fecha='0000-00-00 00:00:00'){


	$elapsed = '60'; // 600 segundos = 10 min
	// fecha de online
	$time_past = $fecha;
	$time_past = strtotime($time_past);

	//agrega los 10 min
	$time_past = $time_past + $elapsed;

	// Time NOW
	$time_now = time();

	// checa si han pasado mas de 10 minutos
	if($time_past > $time_now){
	    return 0;    
	}else{
	    return 1;
	}



$start_date = new Date();
$end_date = new Date($fecha);
$interval = $start_date->diff($end_date);
$hours   = $interval->format('%h'); 
$minutes = $interval->format('%i');
$mins=($hours * 60 + $minutes);

	if($mins>1){
		return 0;
	}else{
		return 1;
	}

}
?>