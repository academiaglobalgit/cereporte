<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting( E_ALL );

/*DGB transferencia de alumnos

calificaciones:
GENERAION 1 HASTA EL PERIODO 5 
GENERACION 2 HASTA EL PERIODO 4


actividadesdeaprendisaje 20%
portafolio vale 40%
xamen final = 40%

*/
	   header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=dgb_crear_grupos.xls");
		header("Pragma: no-cache");
		header("Expires: 0");





        /*
         $fecha_inscripcion= $datos->fecha_inscripcion;
          $generacion = $datos->generacion;
          $folio = $datos->folio;
          $periodo = $datos->periodo;
          */
          

        /*  $fecha_inscripcion= $_GET['fecha_inscripcion'];
          $generacion = $_GET['generacion'];
          $folio = $_GET['folio'];
          $periodo = $_GET['periodo'];
          */


        include 'config.php';

        $matricula=1511569450470;

        $folio = 0;
 	 	$periodo = 1;
        $generacion =1;
        $numregistros = 0;


        $grado =$periodo;

        $tipo_movimiento =0;
        $sumagrupo= $grado-1;
        if($sumagrupo > 0){
            $sumagrupo=100*$sumagrupo;
        }
       
        //cargamos el archivo al servidor con el mismo nombre
        //solo le agregue el sufijo bak_
        $archivo= "archivo";
        $tipo = 0;
        $destino = "bak_".$archivo;


        $folio=0;

        
         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");

        $query="";
       	$grupo_idx=100;
         $mysql->Connectar();
         	$query="SELECT * FROM dgb_g3";
			$table="<table>";	
			$idx=0;
			if($result=$mysql->Query($query)){
				while ($row=mysql_fetch_array($result)) {
          $matricula++;
					if($idx%35==0){
						$grupo_idx++;
						/*$table.="<tr>";
						$table.="<td colspan='4' >GRUPO ".$grupo_idx."</td>";
						$table.="<tr>";*/
						
					}

					$table.="<tr>";
					$table.="<td>".$row['Id']."</td>";	
					$table.="<td>".$row['#Empleado']."</td>";	
					$table.="<td>".$row['Empresa']."</td>";	
					$table.="<td>".$grupo_idx."</td>";	
          $table.="<td>".$matricula."</td>";  
					$table.="</tr>";
					$idx++;
				}
			}

			$table.="</table>";
			echo $table;
?>