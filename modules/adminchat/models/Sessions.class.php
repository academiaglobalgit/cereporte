<?php

	class Sessions extends Connection{
		var $id_persona; //tb_personas id
		var $id_moodle; // moodle user id
		var $id_alumno; // tb_alumnos id

		function Sessions(){
			$this->Connect();
		}


		

	}
?>