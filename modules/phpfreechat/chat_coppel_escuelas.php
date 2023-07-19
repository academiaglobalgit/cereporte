<?php 	

	include_once('Connection.class.php');

	$id_plan_estudio=21;
	$id_corporacion=2;
	$nick_alumno="Alumno";
	$escuela_nombre="chat_".$id_plan_estudio;


	function GetInfoAlumno($id_moodle_alumno){
		$bd="coppelescuelas";
		$mysql= new Connection();
		$nick=null;

		if($mysql->Connect()){

			$query="SELECT concat(m.firstname,' ',m.lastname) as nombre_completo FROM ".$bd.".mdl_user m WHERE m.id=".$id_moodle_alumno."  limit 1;";
			$result=$mysql->Query($query);
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$nick=$row['nombre_completo'];
				}
			}else{
			}
			$mysql->Close();
		}else{
		}

		return $nick;
	}




		if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
			$id_moodle=$_GET['userid'];
			$nick_temp=GetInfoAlumno($id_moodle);
			if($nick_temp==null){
				$nick_alumno=$nick_alumno.rand(1,200);
			}else{
				$nick_alumno=$nick_temp;
			}
		}else{
			$nick_alumno=$nick_alumno.rand(1,200);
		}


	
	$titulo="";
	$channels=array("Alumnos");
	$admin=array("sistemas4" => "123");
    require_once('/var/www/html/cereporte/modules/phpfreechat/src/phpfreechat.class.php'); 
    $params["serverid"] = "server_".$escuela_nombre; // calculate a unique id for this chat
    $params["language"]="es_ES";
    $params["admins"]=$admin;
    $params["nick"] = iconv("ISO-8859-1", "UTF-8", $nick_alumno);
    $params["frozen_nick"] = false;
    $params["title"] = $titulo;
    $params["channels"] = $channels;
    $params["frozen_channels"] = $channels;
    $params["shownotice"] = 2;  //connects y disconnects
    $params["startwithsound"] = false;  //silenciado
	$params["nickmarker"] = true;  //nocolorear nicks
	$params["notify_window"] = false;
	$params["display_pfc_logo"] = false;
	$params["display_ping"] = false;
	$params["displaytabimage"] = false;
	$params["displaytabclosebutton"] = false;
	$params["showsmileys"] = false;
	$params["btn_sh_smileys"] = false;
	$params["showwhosonline"] = true;

	$params["container_type"] = "mysql";
	$params["container_cfg_mysql_host"]     = "localhost";        // default value is "localhost"
	$params["container_cfg_mysql_port"]     = 3306;               // default value is 3306
	$params["container_cfg_mysql_database"] = "escolar";      // default value is "phpfreechat"
	$params["container_cfg_mysql_table"]    = "tb_chat";             // default value is "phpfreechat"
	$params["container_cfg_mysql_username"] = "sistemas";      // default value is "root"
	$params["container_cfg_mysql_password"] = "uCG1lysB9a4PGTkg7qeZ496u5063yHVW"; // default value is ""
		
	
    $chat = new phpFreeChat($params);
   //$chat->printJavascript();
   // $chat->printStyle();


 	

 	 echo "	


 	 <link  href='jquery-ui/jquery-ui.css' rel='stylesheet' >
 	<script src='jquery.js' ></script>
 	<script src='jquery-ui/jquery-ui.min.js' ></script>
 	<!--<script src='chat.js' ></script>-->
    	<style>
		    	#pfc_bbcode_container{
		    		display:none;
				}

				#pfc_cmd_container{
					display:none;
				}

				#pfc_minmax{
					display:none;
				}		
				#pfc_chat{
					font-size:9px !important;
				}
				.pfc_message
				{
					font-size:11px;
				}
				.pfc_nickmarker{
					font-size:9px;
				}
				#pfc_container{
					max-height:300px;
					background-image:none  !important;
					border:none  !important;
					padding:0px !important;
				}

				#pfc_channels_content{
					max-height:250px;
				}
				#pfc_title{
					display:none;
				}
				#pfc_send{
					/*
					background-image:url(send.png);
					background-size:20px,30px;
					background-repeat:no-repeat;
					*/
					border-radius:5px;
					border-color:grey !important;
					background-color:white;
					background-position:5px;
					width:40px;
					background-color: #979698 !important;
			        color:#ffffff;
			        font-family: 'Avenir', Helvetica, sans-serif;
			        font-style:bold;
				}

				.pfc_td1{
					display:none;
				}

				#pfc_errors{
					background-color: white;
				}




    		</style>";
    		$chat->printChat(); 
    		

?>