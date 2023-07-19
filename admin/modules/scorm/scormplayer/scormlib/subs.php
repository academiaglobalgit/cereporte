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
	//$link = mysql_connect($dbhost,$dbuser,$dbpass);

	if($link= mysqli_connect($dbhost,$dbuser,$dbpass, $dbname)){
		mysqli_select_db($link,$dbname);

	}else{
		//die("error connect");
	}

}


function CloseConnect() {
	// link
	global $link;
	mysqli_close($link);
}

function GetScorm($id=0){
	global $link;
	global $scormid;
	
	$query="SELECT ts.*,tsf.id as scoid,tsf.url_player,tsf.url_scorm FROM escolar.tb_scorms_files tsf inner join escolar.tb_scorms ts on ts.id=tsf.id_scorm where tsf.status=1 AND ts.id='".$id."'  GROUP BY tsf.id_scorm order by tsf.id ASC  limit 1 " ;

	$result = mysqli_query($link,$query);
	$scormResult=array();

	if($result){
		if(mysqli_num_rows($result)>0){
			while ($row = mysqli_fetch_assoc($result)) {
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
	global $scormid;
	global $userid;
	$safeelement = mysqli_real_escape_string($element);
	$result = mysqli_query($link,"select value from tb_scorm_scoes_track where ((scormid=".$scormid.") and (element='".$safeelement."'))");
	list($value) = mysqli_fetch_row($result);

	return $value;

}

function writeElement($element,$value) { 

	global $link;
	global $scormid;
	global $userid;
	$safeelement = mysqli_real_escape_string($element);
	$safevalue = mysqli_real_escape_string($value);
	mysqli_query($link,"update tb_scorm_scoes_track set value='".$safevalue."' where ((scormid=".$scormid.") and (element='".$safeelement."'))");

	return;

}

function initializeElement($element,$value) {

	global $link;
	global $scormid;
	global $userid;

	// make safe for the database
	$safeelement = mysqli_real_escape_string($element);
	$safevalue = mysqli_real_escape_string($value);

	// look for pre-existing values
	$result = mysqli_query($link,"select value from tb_scorm_scoes_track where ((scormid=".$scormid.") and (element='".$safeelement."'))");

	// if nothing found ...
	if (mysqli_num_rows($result)<=0) {
		mysqli_query($link,"insert into tb_scorm_scoes_track (scormid,element,value,userid) values (".$scormid.",'".$safeelement."','".$safevalue."','".$userid."')");
	}

}

function initializeSCO() {
		date_default_timezone_set('America/Mazatlan');

	global $link;
	global $scormid;
	global $userid;

	// has the SCO previously been initialized?
	$result = mysqli_query($link,"select count(element) from tb_scorm_scoes_track where (scormid='".$scormid."')");
	list($count) = mysqli_fetch_row($result);

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
		initializeElement('cmi.core.total_time','0000:00:00');
		initializeElement('cmi.core.session_time','0000:11:00');
		
		initializeElement('cmi.attemps','1'); // variable agregada para contar los intentos	

		initializeElement('cmi.interactions._count',''); // variable agregada para contar las respuestas correctas
		initializeElement('cmi.objectives._count',''); // variable agregada para contar las respuestas correctas

	/*	$datetime = new DateTime(date("Y-m-d H:i:s"));
		$la_time = new DateTimeZone('America/Mazatlan');
		$datetime->setTimezone($la_time);*/
				$datetime = new DateTime(date("Y-m-d H:i:s"),new DateTimeZone('America/Mazatlan'));

		initializeElement('cmi.lastattemp',$datetime->format('Y-m-d H:i:s')); // variable agregada para ver la fecha del ultimo acceso al examen

	//respuestas realizadas

	/*
	initializeElement('cmi.interactions.0',''); // variable agregada para contar las respuestas
	initializeElement('cmi.interactions.n.correct_responses.0',''); // variable agregada para contar las respuestas correctas
	initializeElement('cmi.interactions.n.id',''); // variable agregada para contar las respuestas correctas
	initializeElement('cmi.interactions.n.time',''); // variable agregada para contar las respuestas correctas
	initializeElement('cmi.interactions.n.result',''); // variable agregada para contar las respuestas correctas
	initializeElement('cmi.interactions.n.latency',''); // variable agregada para contar las respuestas correctas
	initializeElement('cmi.interactions.n.weighting',''); // variable agregada para contar las respuestas correctas
	initializeElement('cmi.interactions.n.objectives._count',''); // variable agregada para contar las respuestas correctas
	initializeElement('cmi.interactions._count',''); // variable agregada para contar las respuestas correctas
	*/

	}else{

		$staus=readElement('cmi.core.lesson_status');
		if(($staus !='failed') && ($staus != 'passed')){ 
			// si no acreditò o fallò el examen entonces es que està incompleto y se siguen contandos los intentos.
			writeElement('cmi.attemps',(string)((int)readElement('cmi.attemps')+1));
					$datetime = new DateTime(date("Y-m-d H:i:s"),new DateTimeZone('America/Mazatlan'));
/*
			$datetime = new DateTime(date("Y-m-d H:i:s"));
			$la_time = new DateTimeZone('America/Mazatlan');
			$datetime->setTimezone($la_time);*/
			writeElement('cmi.lastattemp',$datetime->format('Y-m-d H:i:s'));
		}

	}


	// new session so clear pre-existing session time
	writeElement('cmi.core.session_time','0000:11:00');

	// create the javascript code that will be used to set up the javascript cache, 
	$initializeCache = "var cache = new Object();\n";

	$result = mysqli_query($link,"select element,value from tb_scorm_scoes_track where (scormid='".$scormid."')");
	while (list($element,$value) = mysqli_fetch_row($result)) {
	
		// make the value safe by escaping quotes and special characters
		$jvalue = addslashes($value);
		// javascript to set the initial cache value
		$initializeCache .= "cache['".$element."'] = '".$jvalue."';\n";

	}

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

	switch ($element) {

		case 'cmi.core.student_name':
			$value = "nombreejemplo";
			break;

		case 'cmi.core.student_id':
			$value = "idalumno";
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