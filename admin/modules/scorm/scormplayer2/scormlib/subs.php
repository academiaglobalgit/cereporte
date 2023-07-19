<?php 

/* 

VS SCORM 1.2 RTE - subs.php
Rev 2009-11-30-01
Copyright (C) 2009, Addison Robson LLC

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, 
Boston, MA 02110-1301, USA.

*/

// ------------------------------------------------------------------------------------
// Database-specific code
// ------------------------------------------------------------------------------------

function dbConnect() {

	// database login details
	global $dbname;
	global $dbhost;
	global $dbuser;
	global $dbpass;

	// link
	global $link;

	// connect to the database
	$link = mysql_connect($dbhost,$dbuser,$dbpass);
	mysql_select_db($dbname,$link);
	mysql_query("SET NAMES 'utf8'");
}


function GetScorm($id=0){
	global $link;
	
	$query="SELECT ts.*,tsf.id as scoid,tsf.url_player,tsf.url_scorm FROM escolar.tb_scorms_files tsf inner join escolar.tb_scorms ts on ts.id=tsf.id_scorm where tsf.status=1 AND ts.id='".$id."'  GROUP BY tsf.id_scorm order by tsf.id ASC  limit 1 " ;

	$result = mysql_query($query,$link);
	$scormResult=array();

	if($result){
		if(mysql_num_rows($result)>0){
			while ($row = mysql_fetch_assoc($result)) {
				$scormResult[]=$row;
			}
		}else{

		}
	}else{
	}

	return $scormResult;
}


function readElement($element) {

	global $link;
	global $SCOInstanceID;
	global $userid;
	global $scoid;

	$safeelement =  mysql_real_escape_string($element);
	$result = mysql_query("select value from tb_scorms_tracks where ((userid=".$userid.") and (scormid=$SCOInstanceID) and (element='$safeelement'))",$link);
	list($value) = mysql_fetch_row($result);

	return $value;

}

function writeElement($element,$value) { 

	global $link;
	global $SCOInstanceID;
	global $userid;
	global $scoid;


	$safeelement =  mysql_real_escape_string($element);
	$safevalue =  mysql_real_escape_string($value);
	mysql_query("update tb_scorms_tracks set value='".$safevalue."' where ((userid=".$userid.") and (scormid=".$SCOInstanceID.") and (element='".$safeelement."'))",$link);

	return;

}

function initializeElement($element,$value) {

	global $link;
	global $SCOInstanceID;
	global $userid;
	global $scoid;

	// make safe for the database
	$safeelement =  mysql_real_escape_string($element);
	$safevalue =  mysql_real_escape_string($value);

	// look for pre-existing values
	$result = mysql_query("select value from tb_scorms_tracks where ( (userid=".$userid.") and (scormid=".$SCOInstanceID.") and (element='".$safeelement."'))",$link);

	// if nothing found ...
	if (! mysql_num_rows($result)) {
		mysql_query("insert into tb_scorms_tracks (scormid,element,value,userid,scoid,fecha_registro) values ('".$SCOInstanceID."','".$safeelement."','".$safevalue."','".$userid."','".$scoid."',now())",$link);
	}

}

function initializeSCO() {
	date_default_timezone_set('America/Mazatlan');
	global $link;
	global $SCOInstanceID;
	global $userid;
	global $scoid;

	// has the SCO previously been initialized?
	$result = mysql_query("select count(element) from tb_scorms_tracks where (scormid=".$SCOInstanceID." and userid=".$userid." )",$link);
	list($count) = mysql_fetch_row($result);

	// not yet initialized - initialize all elements
	if (! $count) {

		// configura los elementos que van a ser soportados por el SCO(scorm) API
		initializeElement('cmi.core._children','student_id,student_name,lesson_location,credit,lesson_status,entry,score,total_time,exit,session_time');

		initializeElement('cmi.interactions._children','id,objectives,interactions,time,type,correct_responses,weighting,student_response,result,latency, RO');

		initializeElement('cmi.core.score._children','raw');

		// Informacion del estudiante
		initializeElement('cmi.core.student_name',getFromLMS('cmi.core.student_name'));
		initializeElement('cmi.core.student_id',getFromLMS('cmi.core.student_id'));

		// Calificacion
		initializeElement('cmi.core.score.raw','');
		initializeElement('adlcp:masteryscore',getFromLMS('adlcp:masteryscore'));

		// SCO launch and suspend data
		initializeElement('cmi.launch_data',getFromLMS('cmi.launch_data'));
		initializeElement('cmi.suspend_data','');

		// progress and completion tracking
		initializeElement('cmi.core.lesson_location','');
		initializeElement('cmi.core.credit','credit');
		initializeElement('cmi.core.lesson_status','not attempted');
		initializeElement('cmi.core.entry','ab-initio');
		initializeElement('cmi.core.exit','');

		// seat time
		initializeElement('cmi.core.total_time','0000:00:00.00');
		initializeElement('cmi.core.session_time','0000:00:00.00');
		
		initializeElement('cmi.attemps','1'); // variable agregada para contar los intentos	

		initializeElement('cmi.interactions._count','0'); // variable agregada para contar las respuestas correctas
		initializeElement('cmi.objectives._count','0'); // variable agregada para contar las respuestas correctas

		$datetime = new DateTime(date("Y-m-d H:i:s"),new DateTimeZone('America/Mazatlan'));

		initializeElement('cmi.lastattemp',$datetime->format('Y-m-d H:i:s')); // variable agregada para ver la fecha del ultimo acceso al examen

	}else{

		$staus=readElement('cmi.core.lesson_status');
		if(($staus !='failed') && ($staus != 'passed') && ($staus != 'completed') ){ 
			// si no acreditò o fallò el examen entonces es que està incompleto y se siguen contandos los intentos.
			writeElement('cmi.attemps',(string)((int)readElement('cmi.attemps')+1));
			$datetime = new DateTime(date("Y-m-d H:i:s"),new DateTimeZone('America/Mazatlan'));
		/*	$la_time = new DateTimeZone('America/Mazatlan');
			$datetime->setTimezone($la_time);*/
			writeElement('cmi.lastattemp',$datetime->format('Y-m-d H:i:s'));
		}

	}

	// new session so clear pre-existing session time
	
	// create the javascript code that will be used to set up the javascript cache, 
	$initializeCache = "var cache = new Object();\n";

	$result = mysql_query("select element,value from tb_scorms_tracks where (scormid=".$SCOInstanceID.")",$link);
	while (list($element,$value) = mysql_fetch_row($result)) {
	
		// make the value safe by escaping quotes and special characters
		$jvalue = addslashes($value);
		// javascript to set the initial cache value
		$initializeCache .= "cache['".$element."'] = '".$jvalue."';\n";

		if($element=="cmi.interactions._count"){ //inicializa el count de iteraciones en la api JS
				$initializeCache .= " var count_i= ".$jvalue.";\n";
		}
		
	}
				$initializeCache .= " var userid= ".$userid.";\n";

				$initializeCache .= " var scoid= ".$scoid.";\n";

	// return javascript for cache initialization to the calling program
	return $initializeCache;

}


// ------------------------------------------------------------------------------------
// LMS-specific code
// ------------------------------------------------------------------------------------


function setInLMS($element,$value) {
	return "OK";
}

function getFromLMS($element) {
	global $SCOInstanceID;
	global $userid;
	global $scoid;

	switch ($element) {

		case 'cmi.core.student_name':
			$value = "nombre_alumno_".$userid;
			break;

		case 'cmi.core.student_id':
			$value = $userid;
			break;

		case 'adlcp:masteryscore':
			$value = 0;
			break;

		case 'cmi.launch_data':
			$value = "";
			break;

		default:
			$value = '';
		break;
	}

	return $value;

}

?>