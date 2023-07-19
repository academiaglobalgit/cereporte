
<?php 
session_start();

	if(isset($_SESSION['nombre_completo']) && !empty($_SESSION['nombre_completo'])){
			$titulo="Chat Interno AG";
			$channels=array("Global");
			$admin=array("sistemas4" => "popo");
		    require_once('/var/www/html/cereporte/modules/phpfreechat/src/phpfreechat.class.php'); 
		    $params["serverid"] = md5($_SERVER["SERVER_NAME"]."_chat_interno"); // calculate a unique id for this chat
		    $params["language"]="es_ES";
		     $params["admins"]=$admin;

		    $params["nick"] = iconv("ISO-8859-1", "UTF-8", $_SESSION['nombre_completo']);
		    $params["frozen_nick"] = true;
		    $params["title"] = $titulo;
		    $params["channels"] = $channels;
		    $params["frozen_channels"] = $channels;
		    $params["shownotice"] = 2;  //connects y disconnects
		    $params["startwithsound"] = true;  //silenciado
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
			$params["container_cfg_mysql_table"]    = "tb_chat_interno";             // default value is "phpfreechat"
			$params["container_cfg_mysql_username"] = "sistemas";      // default value is "root"
			$params["container_cfg_mysql_password"] = "uCG1lysB9a4PGTkg7qeZ496u5063yHVW"; // default value is ""
				
			
		    $chat = new phpFreeChat($params);
		   // $chat->printJavascript();
		   // $chat->printStyle();

		    echo "	<style>
				    	#pfc_bbcode_container{
				    		display:none;
						}

						#pfc_cmd_container{
							display:none;
						}

						#pfc_minmax{
							display:none;
						}
		    		</style>";
		 	$chat->printChat(); 
	}else{
		echo "No se ha podido cargar el Chat Interno. :-( <br> Intente mas tarde";
	}

?>