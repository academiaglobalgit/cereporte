<?php
require_once "configAyuda.php";
require_once "../models/frecuente.class.php";
/*require_once('../../../preparatoriascorporativas/prepacoppel/config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/grade/querylib.php');*/

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

$frecuentes=[];




//$mysql= new Connect();
$mysql= new Connect();

	if($mysql->Connectar()){
		if($result=$mysql->Query("SELECT id,asunto,mensaje,jerarquia FROM view_preguntasfrecuentes order by jerarquia ASC limit 10 ")){

			while ($pf=mysql_fetch_array($result)) {
				array_push($frecuentes,new Frecuente($pf['id'],$pf['asunto'],$pf['mensaje'],$pf['jerarquia']));
			}
			
		}
			$mysql->Cerrar();
	}


/*
for ($i=0; $i < 5; $i++) { 
	array_push($frecuentes,new Frecuente($i,$asuntos[rand(0,5)],$mensajes[2],0));
}*/

echo json_encode($frecuentes);
?>