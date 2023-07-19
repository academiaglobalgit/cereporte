<?php
	session_start();

				$_SESSION['id_persona']=null;
				$_SESSION['permisos']=null;
				$_SESSION['id_corporacion']=null;
				$_SESSION['nombre_completo']=null;
				$_SESSION['id_usuario']=null;
				$_SESSION['permiso']=null;

	session_destroy();
	header('Location: index.php');

?>
