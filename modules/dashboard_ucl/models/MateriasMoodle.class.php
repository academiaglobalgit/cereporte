<?php 
	class MateriasMoodle extends Connection {

	
		function MateriasMoodle(){
		 	$this->Connect();
		}

		function GetMaterias($bd=""){
			$query="SELECT c.*,cc.id as id_periodo,cc.name as periodo FROM ".$bd.".mdl_course c INNER JOIN ".$bd.".mdl_course_categories cc on cc.id=c.category WHERE c.visible=1 and cc.parent=4 AND cc.visible=1 order by cc.name ASC,c.id ASC";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function GetMateriaEscolarByMoodle($courseid=0,$id_plan_estudio=0){
			$query="SELECT tm.* FROM escolar.tb_materias tm  inner join escolar.tb_materias_ids mids on mids.id_materia=tm.id where tm.eliminado=0 and mids.id_plan_estudio=".$id_plan_estudio." AND  mids.id_moodle=".$courseid." order by tm.periodo asc,tm.id asc limit 1";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}

		function GetUCLEscuelas($bd=""){
			$query="SELECT cc.* FROM  ".$bd.".mdl_course_categories cc WHERE cc.parent=4 AND cc.visible=1 order by cc.id ASC";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}



		function GetExamenesParciales($bd="",$id_course=0){
			
		 $query = "SELECT cm.id, 
            cm.course, 
            cm.instance
           FROM ".$bd.".mdl_course_sections cs inner join ".$bd.".mdl_course_modules cm on cm.section=cs.id 
            where
            cs.section=3 AND 
            cm.course = '".$id_course."' 
            and
            cm.module=18
            order BY cm.instance";
            


			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
		}       

	    function GetExamenesHechos($bd,$id_moodle,$id_course){
	        $query = "select msst.id, ms.course,ms.name,mcm.section,mcs.name,
	                (
	                    SELECT value
	                    from ".$bd.".mdl_scorm_scoes_track
	                    where userid='$id_moodle'
	                    and (element = 'cmi.core.score.raw' or element = 'cmi.score.raw')
	                    and attempt = 1
	                    and ms.id = scormid
	                    limit 1) as calificacion
	                from ".$bd.".mdl_scorm_scoes_track msst
	                inner join ".$bd.".mdl_scorm ms on ms.id = msst.scormid
	                inner join ".$bd.".mdl_course_modules mcm on mcm.instance = msst.scormid
	                inner join ".$bd.".mdl_course_sections mcs on mcs.id = mcm.section
	                where msst.userid = '$id_moodle'
	                and mcm.course = '$materia'
	                and (mcs.section = 3 or mcs.section = 4)
	                and mcm.module = 18
	                and (msst.element ='cmi.core.lesson_status' or msst.element ='cmi.completion_status' )
					and (msst.value <> 'incomplete')
	                group by msst.scormid";
			$result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
	    }


	    function GetEjerciciosByMateriaUnidad($bd="",$materia=0,$unidad=0){
	    	/*
				unidad : 0= primera unidad 1= segunda unidad (dependiendo de cuantos examenes tenga hecho el alumno.
	    	*/
	        $query = "SELECT mp.id,mcm.course,mp.name,mp.content FROM ".$bd.".mdl_course_modules mcm inner join ".$bd.".mdl_page mp on mp.id=mcm.instance WHERE mcm.indent=".$unidad." and mcm.module=15 and mcm.course=".$materia." ORDER BY mp.id ASC;";

	       $result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
	    }


	    function GetEjerciciosHechos($bd="",$id_alumno=0,$materia=0,$unidad=0,$id_corporacion=0,$id_plan_estudio=0){
	    	/*
				unidad : 0= primera unidad 1= segunda unidad (dependiendo de cuantos examenes tenga hecho el alumno.
	    	*/
	        $query = "
	        SELECT 
	        (
		        SELECT count(mp.id) FROM ".$bd.".mdl_course_modules mcm 
		        inner join ".$bd.".mdl_page mp on mp.id=mcm.instance  
		        WHERE mcm.indent=".$unidad." and mcm.module=15 and mcm.course=".$materia."
	        ) as totales, 

	        (
		        SELECT count(te.id) FROM escolar.tb_ejercicios te  WHERE  
		        te.id_alumno=".$id_alumno." 
		        AND te.id_materia_escolar=IFNULL((SELECT tm.id FROM escolar.tb_materias tm  inner join escolar.tb_materias_ids mids on mids.id_materia=tm.id where tm.eliminado=0 and mids.id_plan_estudio=".$id_plan_estudio." AND  mids.id_moodle=".$materia."  limit 1),0) 
		        AND te.id_plan_estudio=".$id_plan_estudio." 
		        AND te.unidad=".$unidad."  
		        AND te.id_corporacion=".$id_corporacion." 
		        AND te.estatus=1
		    ) as hechos;

	        ";

	       $result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}
			return $result;
	    }

	    function GetEjercicioAlumno($id_alumno=0,$materia=0,$id_ejercicio=0,$unidad=0,$id_corporacion=0,$id_plan_estudio=0){

	        $query = "
	        SELECT te.* FROM escolar.tb_ejercicios te  WHERE  
	        te.id_alumno=".$id_alumno." 
	        AND te.id_materia_escolar=".$materia." 
	        AND te.id_ejercicio_moodle=".$id_ejercicio." 
	        AND te.id_plan_estudio=".$id_plan_estudio." 
	        AND te.unidad=".$unidad."  
	        AND te.id_corporacion=".$id_corporacion." LIMIT 1 ;" ;

	       $result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				while($row=mysqli_fetch_assoc($result['data'])){
					$arrayResult[]=$row;
				}
				$result['data']=$arrayResult;
			}else{
				$message['no se ha podido cargar el ejercicio del alumno, intente mas tarde'];
			}


			return $result;


	    }


	    function UpdateEjercicio($contenido='',$id_alumno=0,$materia=0,$id_ejercicio=0,$unidad=0,$id_corporacion=0,$id_plan_estudio=0,$estatus=0){

	        $query = "
	       CALL escolar.rv_ejercicio('".$contenido."',".$id_alumno."
	        ,".$id_ejercicio."
	        ,".$materia."
	       	 ,".$unidad."
	        ,".$id_corporacion."
	         ,".$id_plan_estudio."
	         ,".$estatus." );" ;

	       $result=$this->Query($query);
			$arrayResult=array();
			if($result['success']){
				$result['data']=null;

				if($estatus==1){
					$result['message']="Su Actividad Integradora se ha Finalizado correctamente.";

				}else{
					$result['message']="Su progreso se ha Guardado correctamente.";
	
				}

			}else{
				$result['message']="No se ha podido guardar, intentelo mas tarde. [001] ".$result['message'];
			}
			return $result;


	    }

	}
?>

