<?php
ini_set('max_execution_time', 10000); //300 seconds = 5 minutes
set_time_limit ( 0 );
ini_set('memory_limit', '-1'); 
ini_set('post_max_size', '500M');
ini_set('upload_max_filesize', '500M');
//ini_set('display_errors', 1);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once("ConnectionPG.class.php");
?>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>:: Importar de Excel (.XLSX) INSERTA EXCEL ::</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>

<body style="background-color: #e8e8e8;">
<!-- FORMULARIO PARA SOICITAR LA CARGA DEL EXCEL -->

<section id ="excel">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <br/>
                <br/>
                <div class="panel panel-primary">

                    <div class="panel-heading">
                        <h3 align="center" class="panel-title">Importar INSERTA EXCEL</h3>
                    </div>

                    <div class="panel-body">
                        <form name='importa' method='post' action='upload.php' enctype='multipart/form-data' id='excelform'>
                            <div class="form-group">
                                <label for="exampleInputFile">Selecciones el archivo a Importar</label>
                                <input type="file" id="InputFile" name="excel">

                            </div>

                            <div class="form-group">
                                <label for=''>Números de registros</label>
                                <input type='number' value='' name='registros'/>
                            </div>


                            <center><input id="excelenviar" type='submit' name='enviar'  value="Visualizar Información"  /></center>
                            <input type="hidden" value="upload" name="action" />
                        </form>
                    </div>

                </div>


            </div>
        </div>
    </div>

</section>
<p><!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->

    <?php


    extract($_POST);
    if (@$action == "upload" && is_numeric($_POST['registros'])){

        $numregistros = $_POST['registros'];
        //cargamos el archivo al servidor con el mismo nombre
        //solo le agregue el sufijo bak_
      
        $archivo = $_FILES['excel']['name'];
        $tipo = $_FILES['excel']['type'];
        $destino = "bak_".$archivo;
      

            if (copy($_FILES['excel']['tmp_name'],$destino)) {
                echo "<center>Archivo Cargado Con Éxito</center>";
            }else{
               echo "Error Al Cargar el Archivo";
            }

//file_exists ("bak_".$archivo)
    if (file_exists ("bak_".$archivo)){
         $query="";
         $query2="";

   
            
        
            /** Clases necesarias */
            require_once('PHPExcel.php');
            require_once('PHPExcel/Reader/Excel2007.php');

            // Cargando la hoja de cálculo

            $objReader = new PHPExcel_Reader_Excel2007();
            //$objPHPExcel = $objReader->load("localidades.xls");
             //$objPHPExcel = $objReader->load("bak_cat_localidad_FEB2017.xlsx");
             $objPHPExcel = $objReader->load("bak_".$archivo);


            // Asignar hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);

            $pg = new ConnectionPG();
            $pg->Connect();
            


            // Imprimiendo los resultados en HTML
            //conectamos con la base de datos

            // Llenamos el arreglo con los datos  del archivo xlsx
            // $total_filas=$objPHPExcel->getSheetCount();
                            $query_update="";
                            $query_insert="";
            $total_filas=$numregistros;
            for ($i=1;$i<=$total_filas;$i++){
                $_DATOS_EXCEL[$i]['CVE_ENT'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                // $_DATOS_EXCEL[$i]['NOM_ENT'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                // $_DATOS_EXCEL[$i]['NOM_ABR'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                // $_DATOS_EXCEL[$i]['CVE_MUN'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['NOM_MUN'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                // $_DATOS_EXCEL[$i]['CVE_LOC'] = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['NOM_LOC'] = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['LATITUD'] = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['LONGITUD'] = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['ALTITUD'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
                    if(is_numeric($_DATOS_EXCEL[$i]['CVE_ENT'])){
                            $pg->Query('INSERT INTO "masterag"."cat_localidad_FEB2017" ("CVE_MUN", "NOM_MUN", "CVE_LOC", "NOM_LOC", "LATITUD", "LONGITUD", "ALTITUD") VALUES (NULL, \''.$_DATOS_EXCEL[$i]['NOM_MUN'].'\', NULL, \''.$_DATOS_EXCEL[$i]['NOM_LOC'].'\', \''.$_DATOS_EXCEL[$i]['LATITUD'].'\', \''.$_DATOS_EXCEL[$i]['LONGITUD'].'\', \''.$_DATOS_EXCEL[$i]['ALTITUD'].'\'); ');
                    }
               
                

            }
            $pg->Close();
             echo "<textarea>".$query_insert."</textarea>";
        }else{
            echo "Necesitas primero importar el archivo";
        }
    $errores=0;

    ?>
</p>

<h2 align="center">Visualización de información</h2>


<?php


echo "<strong><center>ARCHIVO IMPORTADO CON EXITO, EN TOTAL REGISTROS Y $errores ERRORES</center></strong>";
//echo $registros;
$num_registros = $registros+1;
if(@$repetidos > 0){

}else{

    echo "<div class='alert alert-success alert-dismissible fade in' role='alert'>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
      <center><h4><strong>Todo ha salido correctamente!</strong></h4>
      <p>".@$lolo." usuarios van hacer registrados satisfactoriamente. Favor de poner el siguiente número <strong>".$num_registros."</strong> en el campo de numero de registros para continuar con el proceso.</p>
    </div></center>
    ";

  
}





unlink($destino);
}else{
    echo "<center>Favor de seleccionar el archivo y definir el número de registros</center>";
}

?>
<p>&nbsp;</p>
<section class="scripts">
    <script src="../../public/js/jquery.js"></script>
    <script src="../../public/js/bootstrap.js"></script>
    <script src="../../public/js/jasny-bootstrap.js"></script>
    <script>

        function cerrarsession(){
            console.log('entro');
            window.location.href='../logout.php';
        }
    </script>
</section>
</body>
</html>