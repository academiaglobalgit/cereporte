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


//  essential functions
require "config.php";
require "subs.php";

dbConnect();

// optiene el id del scorm, userid y carpeta

$userid = $_GET['userid']; // el user id puede ser sacado de las variables de session para mas seguridad
$scormid = $_GET['scormid']; // id del scorm
$scoid =0; // id del sco

$SCO = "'".$_GET['SCO']."'"; //$_GET['SCO'];

 $scorm=GetScorm($scormid);

 if(count($scorm)>0){

 	$SCO="'".$scorm[0]['url']."/".$scorm[0]['url_player']."'";
 	$scoid=$scorm[0]['scoid'];
 }else{
	die("Lo sentimos por el momento no se puede reproducir este elemento <br>
		<a href='../' ><- Regresar</a>");
 }

//CloseConnect();
?>
<html>
<head>
	<title>VS SCORM</title>
	<script type="text/javascript" src="utils/jquery.min.js" ></script>
	
  <script language="javascript">
	 
	    var started = false;
	 
	    function loadSCO(SCO) {
	      if (! started) {
	        course.location.href = '../../players/'+SCO+'/res/html5.html';
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
		 	//alert("loaded");
		});

	  </script>
</head>
<frameset frameborder="0" framespacing="0" border="0" rows="50,*" cols="*" onbeforeunload="API.LMSFinish('');" onunload="API.LMSFinish('');">
	<frame src="api.php?scormid=<?php echo $scormid; ?>&userid=<?php echo $userid; ?>" heigth="1px" name="API" id="API" onload="loadSCO(<?php echo $SCO; ?>);" noresize>
	<frame src="espera.html" name="course" id="course">
</frameset>	



</html>