<?php 
session_start();
require_once "configAyuda.php";
require_once "../models/mensaje.class.php";
/*require_once('../../../preparatoriascorporativas/prepacoppel/config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/querylib.php');*/

//$id_usuario=$USER->id;
$asuntos=[];

$asuntos[0]="¿Donde puedo cargar una materia?";
$asuntos[1]="No puedo cargar";
$asuntos[2]="No tengo cargada una materia.¡ayuda!";
$asuntos[3]="Ayuda con el examen";
$asuntos[4]="Como usar la biblioteca virtual";
$asuntos[5]="¿Como veo mis calificaciones?";

$mensajes=[];
$mensajes[0]="Hola muy buenas tardes";
$mensajes[1]="¿Como estas?";
$mensajes[2]="Así es como lo puede solucionar. Pero tambien puedes hacerlo de este modo.";
$mensajes[3]="¿Pero como le hago? no entiendo nada de lo que dices";
$mensajes[4]="Muy bien, gracias.";
$mensajes[5]="Ha, está bien ya entendí como se hace. muchas gracias prepacoppel";

$nombres=[];
$nombres[0]="Facilitador";
$nombres[1]="Jhon Doe";


$status=[];
$status[0]=0;
$status[1]=1;

$id_asunto=0;

if(isset($_GET['id_asunto'])){
	$id_asunto=strip_tags($_GET['id_asunto']);
}

$seguimientos= array();
$chats= array();
//$mysql= new Connect();
$mysql= new Connect();

$j=0;
	if($mysql->Connectar()){

		if($mysql->Query("UPDATE escolar.ag_ayuda_mensajes set escolar.ag_ayuda_mensajes.visto=1 WHERE id_asunto='".$id_asunto."' and escolar.ag_ayuda_mensajes.id_usuario <> 0 and escolar.ag_ayuda_mensajes.visto=0 ")){
			
		}

		$notificaciones=0;
		if($result=$mysql->Query("SELECT id_asunto,id_usuario,fecha_registrado,mensaje,visto,(SELECT concat(tb_personas.nombre,' ',tb_personas.apellido1,' ',tb_personas.apellido2) from tb_personas inner join tb_alumnos on tb_alumnos.id_persona=tb_personas.id WHERE tb_alumnos.id=view_mensajes.id_usuario AND tb_alumnos.id_corporacion='".$_SESSION['id_corporacion']."' limit 1) as nombre,(SELECT escolar.tb_personas.nombre from escolar.tb_personas WHERE escolar.tb_personas.id=view_mensajes.id_facilitador ) as nombre_asesor FROM view_mensajes where id_asunto='".$id_asunto."'  order by fecha_registrado DESC LIMIT 10 ")){

			while ($msg=mysql_fetch_array($result)) {
				$visto=1;
				if($msg["id_usuario"]==0){
					$nombre=$msg['nombre_asesor'];
				}else{
					$nombre=$msg['nombre'];
					$visto=$msg['visto'];
					$notificaciones+=(int)$msg['visto'];
				}
				array_push($chats,new Mensaje($j,$msg['id_asunto'],$msg['id_usuario'],$msg['fecha_registrado'],$nombre,$msg['mensaje'],$visto));
				$j++;
			}
			
		}
			$mysql->Cerrar();
	}


			/*for ($j=0; $j < 10; $j++) { 
				$chats[$j]= new Mensaje($j,0,0,"01/22/2015 13:25:23",$nombres[rand(0,1)],$mensajes[rand(0,5)]);
			}*/
			
echo json_encode($chats);

?>