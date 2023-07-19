<?php 

/*

VS SCORM 1.2 RTE - rte.php
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
Boston, MA	02110-1301, USA.

*/

// optiene el id del scorm, userid y carpeta

$userid = $_GET['userid']; // el user id puede ser sacado de las variables de session para mas seguridad
$SCOInstanceID = $_GET['SCOInstanceID']; // id del scorm
$SCO = "'".$_GET['SCO']."'"; //$_GET['SCO'];

$scoid=0; // scoid= id del archivo del scorm activo tb_scorms_files


require "config.php";
require "subs.php";

dbConnect();

$scorm=GetScorm($SCOInstanceID);

 if(count($scorm)>0){

 	//$SCO="'".$scorm[0]['url']."/".$scorm[0]['url_player']."'";

 	if (file_exists("../../players/".$scorm[0]['url']."/".$scorm[0]['url_player']."/res/html5.html")) { // si es scorm normal
 		
 		$SCO="'../../players/".$scorm[0]['url']."/".$scorm[0]['url_player']."/res/html5.html'";

	}else if(file_exists("../../players/".$scorm[0]['url']."/".$scorm[0]['url_player']."/".str_replace(".zip","",$scorm[0]['url_scorm']).".htm")) { // si es captivate nuevo
 		
 		$SCO="'../../players/".$scorm[0]['url']."/".$scorm[0]['url_player']."/".str_replace(".zip","",$scorm[0]['url_scorm']).".htm'";

	}else{ // SI NO ENCUENTRA EL DIRECTORIO 
		die("Lo sentimos por el momento no se puede reproducir este elemento. 002 <br>
		<a href='../' ><- Regresar</a>");
	}

 	$scoid=$scorm[0]['scoid'];

 }else{
	die("Lo sentimos por el momento no se puede reproducir este elemento. 001 <br>
		<a href='../' ><- Regresar</a>");
 }

 
?>
<html>
<head>
	<title>VS SCORM</title>
	<script type="text/javascript" src="utils/jquery.min.js" ></script>
  <script language="javascript">
	 
	    var started = false;
	 
	    function loadSCO(SCO) {
	      if (! started) {
	        course.location.href = SCO;
	      }
	      started = true;
	    }
	 
	    function unloadSCO() {
	      setTimeout('API.LMSFinish("");',2000);
	    }

		$( document ).ready(function() {
		 		$( window ).unload(function() {
		 			alert("loaded");
					 return "Handler for .unload() called.";
				});
		 	
		});

	  </script>
</head>
<frameset frameborder="0" framespacing="0" border="0" rows="1,*" cols="*" onbeforeunload="API.LMSFinish('');" onunload="API.LMSFinish('');">
	<frame src="api.php?&SCOInstanceID=<?php echo $SCOInstanceID; ?>&userid=<?php echo $userid; ?>&scoid=<?php echo $scoid; ?>" heigth="1px" name="API" id="API" onload="loadSCO(<?php echo $SCO; ?>);" noresize>
	<frame src="espera.html" name="course" id="course">
</frameset>	

</html>