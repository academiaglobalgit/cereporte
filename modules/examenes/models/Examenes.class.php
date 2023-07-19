<?php 
	class Examenes extends Connection {

	
		function Examenes(){
		 	$this->Connect();
		}

		function GetExamenesScorm($bd="",$id_moodle=0,$id_materia=0){
			$query='SELECT sst.id,sst.userid,sst.scormid,sst.value as calificacion,s.name,IF(cs.section=3,"Bloque",IF(cs.section=4,"Final",IF(cs.section=5,"Extra","Otro"))) as tipo,(SELECT sst4.value FROM '.$bd.'.mdl_scorm_scoes_track sst4 WHERE sst.scormid=sst4.scormid and sst.userid=sst4.userid and sst4.element="cmi.core.lesson_status" limit 1) as status,(SELECT sst4.id FROM '.$bd.'.mdl_scorm_scoes_track sst4 WHERE sst.scormid=sst4.scormid and sst.userid=sst4.userid and sst4.element="cmi.core.lesson_status" limit 1) as id_status,(SELECT sst4.value FROM '.$bd.'.mdl_scorm_scoes_track sst4 WHERE sst.scormid=sst4.scormid and sst.userid=sst4.userid and sst4.element="cmi.core.total_time" limit 1) as tiempo
FROM '.$bd.'.mdl_scorm_scoes_track sst inner join '.$bd.'.mdl_course_modules cm on cm.instance=sst.scormid inner join '.$bd.'.mdl_scorm s on sst.scormid=s.id inner join '.$bd.'.mdl_course_sections cs on cs.id=cm.section  
WHERE sst.element="cmi.core.score.raw" AND cm.course=s.course AND  s.course='.$id_materia.'  AND cm.module=18 AND sst.userid='.$id_moodle.' AND (cs.section=3 or cs.section=4 or cs.section=5) order by sst.id ASC; 
';


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



		function UpdateExamen($bd="",$userid=0,$scormid=0,$calificacion=0){ //actualiza calificacion

			$query_raw="UPDATE ".$bd.".mdl_scorm_scoes_track sst SET sst.value='".$calificacion."'  WHERE sst.element='cmi.core.score.raw' AND sst.userid='".$userid."' and sst.scormid='".$scormid."' limit 1; ";
			$query_status=" UPDATE ".$bd.".mdl_scorm_scoes_track sst SET sst.value=IF(".$calificacion.">=6,'passed','failed')  WHERE sst.element='cmi.core.lesson_status' AND sst.userid='".$userid."' and sst.scormid='".$scormid."' limit 1;  ";
			
			$this->begin_transaction();
			$result_raw=$this->Query($query_raw);
			$result_status=$this->Query($query_status);

			if($result_raw['success'] && $result_status['success']){
				$this->commit();
				$result['success']=true;
				$result['message']="Calificación Actualizada Correctamente.";
				$this->Bitacora($_SESSION['id_persona'],"EXAMENES SCORMS","MODIFICACION: CALIFICACION",$bd.": IDMOODLE: ".$userid." IDSCORM: ".$scormid." CALIFICACION: ".$calificacion);

			}else{
				$this->rollback();
				$result['success']=false;
				$result['message']="No se ha podido actualizar el examen. 001.";

			}

			return $result;
		}



		function ResetExamen($bd="",$userid=0,$scormid=0){ //actualiza calificacion

			$query_scoes="DELETE sst FROM ".$bd.".mdl_scorm_scoes_track sst WHERE sst.userid='".$userid."' and sst.scormid='".$scormid."' ";
			$query_intentos="DELETE si FROM ".$bd.".ag_scorm_intentos si WHERE si.userid='".$userid."' and si.scormid='".$scormid."' ";
			
			$this->begin_transaction();
			$result_scoes=$this->Query($query_scoes);
			$result_intentos=$this->Query($query_intentos);

			if($result_scoes['success'] && $result_intentos['success']){
				$this->commit();
				$result['success']=true;
				$result['message']="Examen REINICIADO Correctamente.";
				$this->Bitacora($_SESSION['id_persona'],"EXAMENES SCORMS","MODIFICACION: REINICIO",$bd.": IDMOODLE: ".$userid." IDSCORM: ".$scormid);
			}else{
				$this->rollback();
				$result['success']=false;
				$result['message']="No se ha podido reiniciar el examen. 001.";

			}

			return $result;
		}

		
	}
?>

