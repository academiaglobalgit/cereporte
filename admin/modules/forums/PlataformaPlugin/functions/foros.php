<?php
require_once('connection.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

class Foros extends Conexion{


    public function get_id_persona($id_moodle=0,$id_plan_estudio=0){
        $conexion= $this->conexion();
        mysqli_set_charset($conexion,'utf8');

        $query = "SELECT escolar.get_idpersona_escolar_generic(".$id_moodle.",".$id_plan_estudio.") as id";

        $registros = $conexion->query($query);
        $resultadoArray=array();

        if($registros) {
                while($row = $registros->fetch_assoc())
                {
                 $resultadoArray[]= $row;
              
                }
            $resultado=$resultadoArray[0]['id'];


        }else{
            $resultado=null;

        }

        $datos= $resultado;
        $conexion->close();
        return $datos;
    }

    public function GetQuizByMoodleQuiz($id_plan_estudio=0,$id_course_moodle=0,$id_moodle=0,$id_modo=1){
        $conexion= $this->conexion();
        mysqli_set_charset($conexion,'utf8');

       $query="SELECT e.* FROM escolar.tb_examenes e where e.id_plan_estudio=".$id_plan_estudio." AND e.id_materia=(SELECT tmi.id_materia from escolar.tb_materias_ids tmi where tmi.id_moodle=".$id_course_moodle." and tmi.id_plan_estudio=".$id_plan_estudio." limit 1) and  e.id_moodle=".$id_moodle." and  e.id_modo=".$id_modo." limit 1  " ;

        $registros = $conexion->query($query);
        $resultadoArray=array();

        if($registros) {
                while($row = $registros->fetch_assoc())
                {
                 $resultadoArray[]= $row;
                }
            $resultado=$resultadoArray;
        }else{
            $resultado=null;

        }
        $datos= $resultado;
        $conexion->close();
        return $datos;
    }

    public function GetForosTerminados($id_examen=0,$id_persona=0){
        $conexion= $this->conexion();
        mysqli_set_charset($conexion,'utf8');

        $query="SELECT f.*,h.id as id_hilo FROM escolar.tb_examenes te 
                    INNER JOIN escolar.tb_examenes_relacion ter on ter.id_examen_autoridad=te.id
                    inner join escolar.tb_examenes te2 on ter.id_examen=te2.id
                    inner join escolar.tb_foros f on f.id_quiz=te.id
                    inner join escolar.tb_foros_hilos h on f.id=h.id_foro
                    where f.eliminado=0 and h.eliminado=0 and h.id_primer_post<>0 and te2.id='".$id_examen."'    ORDER BY te.bloque asc";

        $foros_sin_terminar=0;
        $registros = $conexion->query($query);
        $resultadoArray=array();
        $resultado=null;
        if($registros) {

            $numero_rows=$registros->num_rows;

            if($numero_rows>0){

                while($row = $registros->fetch_assoc())
                {

                    $resultadoArray[]= $row;
                    $conteo=0;
                    $query_posts="SELECT count(p.id) as conteo FROM escolar.tb_foros_posts p where p.id_hilo='".$row['id_hilo']."' and eliminado=0 and p.id_alumno='".$id_persona."' limit 1 "; 
                     $registros_post = $conexion->query($query_posts);

                     if($registros_post){

                        while($row2 = $registros_post->fetch_assoc())
                        {
                            $conteo=(int)$row2['conteo'];
                        }
                     }else{
                        $conteo=1;
                     }

                     if($conteo<=0){
                       $foros_sin_terminar++;
                     }
                }

                $resultado=$resultadoArray;

            }else{

            }

        }else{
            $resultado=null;
        }

        $conexion->close();

        if($foros_sin_terminar<=0){ // si no hay foros sin terminar
            return true;
        }else{ // si si hay foros por terminar
            return false;
        }
    }



     public function GetForumsByExamen($id_examen=0){
        $conexion= $this->conexion();
        mysqli_set_charset($conexion,'utf8');

        $query="SELECT count(h.id) as conteo FROM escolar.tb_examenes te 
                    INNER JOIN escolar.tb_examenes_relacion ter on ter.id_examen_autoridad=te.id
                    inner join escolar.tb_examenes te2 on ter.id_examen=te2.id
                    inner join escolar.tb_foros f on f.id_quiz=te.id
                    inner join escolar.tb_foros_hilos h on f.id=h.id_foro
                    where f.eliminado=0 and h.eliminado=0 and te2.id='".$id_examen."'   ORDER BY te.bloque asc";

        $foros_existentes=0;
        $registros = $conexion->query($query);
        $resultadoArray=array();
        $resultado=null;
        if($registros) {

            $numero_rows=$registros->num_rows;

            if($numero_rows>0){

                while($row = $registros->fetch_assoc())
                {

                    $foros_existentes= (int)$row['conteo'];
                }


            }else{

            }

        }else{
            $foros_existentes=0;
        }

        $conexion->close();

        if($foros_existentes<=0){ // no hay foros 
            return false;
        }else{ // si si hay foros 
            return true;
        }
    }


    

}

?>