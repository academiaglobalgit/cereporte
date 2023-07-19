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


}

?>