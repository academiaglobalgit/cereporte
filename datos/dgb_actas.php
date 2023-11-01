<?php
$datos = json_decode(file_get_contents("php://input")); 

/*DGB ACTAS CALIFICACION*/

$filename="dgb_ACTAS.xls";

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");


    if (isset($_GET)){
         /* $fecha_inscripcion= $datos->fecha_inscripcion;
          $generacion = $datos->generacion;
          $folio = $datos->folio;
          $periodo = $datos->periodo;*/
          

          $fecha_inscripcion= $_GET['fecha_inscripcion'];
          $generacion = $_GET['generacion'];
          $folio = $_GET['folio'];
          $periodo = $_GET['periodo'];
          $opciones = $_GET['opciones'];
          $generacion_maestro=$generacion;
        if($generacion>2){
            $generacion_maestro=2;
        }

         /* $fecha_evaluacion="2016-09-30";
          $generacion =1;
          $folio = 0;
          $periodo = 3;*/
          

        include 'config.php';
        $numregistros = 0;
        $modo =  $_GET['modo'];
        $fecha_evaluacion="2016-09-30";
        $ciclo_escolar =0;
        $subciclo_escolar =0;
        $tipo_evaluacion = 0;

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

          /*if (copy($_FILES['excel']['tmp_name'],$destino)) {
                echo "<center>Actas generadas ".@date("Y-m-d")."</center>";
            }else{
               	echo "Error Al Cargar el Archivo";
            }
           */

        $folio=0;

        if (true){
         $mysql= new Connect("localhost","sistemas","uCG1lysB9a4PGTkg7qeZ496u5063yHVW","escolar");

         $query="";
       		$query2="";
         $mysql->Connectar();
   
           /* 
            require_once('Classes/PHPExcel.php');
            require_once('Classes/PHPExcel/Reader/Excel2007.php');
            // Cargando la hoja de cálculo
            $objReader = new PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader->load("bak_".$archivo);
            $objFecha = new PHPExcel_Shared_Date();
            // Asignar hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);
            //conectamos con la base de datos
            // Llenamos el arreglo con los datos  del archivo xlsx
            // $total_filas=$objPHPExcel->getSheetCount();
                            $query_update="";
                            $query_insert="";
            $total_filas=$numregistros;
            $WHERE_ALUMNOS="";
            for ($i=1;$i<=$total_filas;$i++){
                $_DATOS_EXCEL[$i]['curp'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                //$_DATOS_EXCEL[$i]['tipobaja'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
               // $_DATOS_EXCEL[$i]['status'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
               	if(!empty($_DATOS_EXCEL[$i]['curp'])){
               		  $WHERE_ALUMNOS.=" OR tp.curp='".$_DATOS_EXCEL[$i]['curp']."' ";
               	}       
            }*/

$WHERE_ALUMNOS_G1="
tba.matricula='1511569450001' or
tba.matricula='1511569450002' or
tba.matricula='1511569450003' or
tba.matricula='1511569450004' or
tba.matricula='1511569450005' or
tba.matricula='1511569450006' or
tba.matricula='1511569450007' or
tba.matricula='1511569450008' or
tba.matricula='1511569450009' or
tba.matricula='1511569450010' or
tba.matricula='1511569450011' or
tba.matricula='1511569450012' or
tba.matricula='1511569450013' or
tba.matricula='1511569450014' or
tba.matricula='1511569450015' or
tba.matricula='1511569450016' or
tba.matricula='1511569450017' or
tba.matricula='1511569450018' or
tba.matricula='1511569450019' or
tba.matricula='1511569450020' or
tba.matricula='1511569450021' or
tba.matricula='1511569450022' or
tba.matricula='1511569450023' or
tba.matricula='1511569450024' or
tba.matricula='1511569450025' or
tba.matricula='1511569450026' or
tba.matricula='1511569450027' or
tba.matricula='1511569450028' or
tba.matricula='1511569450029' or
tba.matricula='1511569450030' or
tba.matricula='1511569450031' or
tba.matricula='1511569450032' or
tba.matricula='1511569450033' or
tba.matricula='1511569450034' or
tba.matricula='1511569450035' or
tba.matricula='1511569450036' or
tba.matricula='1511569450037' or
tba.matricula='1511569450038' or
tba.matricula='1511569450039' or
tba.matricula='1511569450040' or
tba.matricula='1511569450041' or
tba.matricula='1511569450042' or
tba.matricula='1511569450043' or
tba.matricula='1511569450044' or
tba.matricula='1511569450045' or
tba.matricula='1511569450046' or
tba.matricula='1511569450047' or
tba.matricula='1511569450048' or
tba.matricula='1511569450049' or
tba.matricula='1511569450050' or
tba.matricula='1511569450051' or
tba.matricula='1511569450052' or
tba.matricula='1511569450053' or
tba.matricula='1511569450054' or
tba.matricula='1511569450055' or
tba.matricula='1511569450056' or
tba.matricula='1511569450057' or
tba.matricula='1511569450058' or
tba.matricula='1511569450059' or
tba.matricula='1511569450060' or
tba.matricula='1511569450061' or
tba.matricula='1511569450062' or
tba.matricula='1511569450063' or
tba.matricula='1511569450064' or
tba.matricula='1511569450065' or
tba.matricula='1511569450066' or
tba.matricula='1511569450067' or
tba.matricula='1511569450068' or
tba.matricula='1511569450069' or
tba.matricula='1511569450070' or
tba.matricula='1511569450071' or
tba.matricula='1511569450072' or
tba.matricula='1511569450073' or
tba.matricula='1511569450074' or
tba.matricula='1511569450075' or
tba.matricula='1511569450076' or
tba.matricula='1511569450077' or
tba.matricula='1511569450078' or
tba.matricula='1511569450079' or
tba.matricula='1511569450080' or
tba.matricula='1511569450081' or
tba.matricula='1511569450082' or
tba.matricula='1511569450083' or
tba.matricula='1511569450084' or
tba.matricula='1511569450085' or
tba.matricula='1511569450086' or
tba.matricula='1511569450087' or
tba.matricula='1511569450088' or
tba.matricula='1511569450089' or
tba.matricula='1511569450090' or
tba.matricula='1511569450091' or
tba.matricula='1511569450092' or
tba.matricula='1511569450093' or
tba.matricula='1511569450094' or
tba.matricula='1511569450095' or
tba.matricula='1511569450096' or
tba.matricula='1511569450097' or
tba.matricula='1511569450098' or
tba.matricula='1511569450099' or
tba.matricula='1511569450100' or
tba.matricula='1511569450101' or
tba.matricula='1511569450102' or
tba.matricula='1511569450103' or
tba.matricula='1511569450104' or
tba.matricula='1511569450105' or
tba.matricula='1511569450106' or
tba.matricula='1511569450107' or
tba.matricula='1511569450108' or
tba.matricula='1511569450109' or
tba.matricula='1511569450110' or
tba.matricula='1511569450111' or
tba.matricula='1511569450112' or
tba.matricula='1511569450113' or
tba.matricula='1511569450114' or
tba.matricula='1511569450115' or
tba.matricula='1511569450116' or
tba.matricula='1511569450117' or
tba.matricula='1511569450118' or
tba.matricula='1511569450119' or
tba.matricula='1511569450120' or
tba.matricula='1511569450121' or
tba.matricula='1511569450122' or
tba.matricula='1511569450123' or
tba.matricula='1511569450124' or
tba.matricula='1511569450125' or
tba.matricula='1511569450126' or
tba.matricula='1511569450127' or
tba.matricula='1511569450128' or
tba.matricula='1511569450129' or
tba.matricula='1511569450130' or
tba.matricula='1511569450131' or
tba.matricula='1511569450132' or
tba.matricula='1511569450133' or
tba.matricula='1511569450134' or
tba.matricula='1511569450135' or
tba.matricula='1511569450136' or
tba.matricula='1511569450137' or
tba.matricula='1511569450138' or
tba.matricula='1511569450139' or
tba.matricula='1511569450140' or
tba.matricula='1511569450141' or
tba.matricula='1511569450142' or
tba.matricula='1511569450143' or
tba.matricula='1511569450144' or
tba.matricula='1511569450145' or
tba.matricula='1511569450146' or
tba.matricula='1511569450147' or
tba.matricula='1511569450148' or
tba.matricula='1511569450149' or
tba.matricula='1511569450150' or
tba.matricula='1511569450151' or
tba.matricula='1511569450152' or
tba.matricula='1511569450153' or
tba.matricula='1511569450154' or
tba.matricula='1511569450155' or
tba.matricula='1511569450156' or
tba.matricula='1511569450157' or
tba.matricula='1511569450158' or
tba.matricula='1511569450159' or
tba.matricula='1511569450160' or
tba.matricula='1511569450161' or
tba.matricula='1511569450162' or
tba.matricula='1511569450163' or
tba.matricula='1511569450164' or
tba.matricula='1511569450165' or
tba.matricula='1511569450166' or
tba.matricula='1511569450167' or
tba.matricula='1511569450168' or
tba.matricula='1511569450169' or
tba.matricula='1511569450170' or
tba.matricula='1511569450171' or
tba.matricula='1511569450172' or
tba.matricula='1511569450173' or
tba.matricula='1511569450174' or
tba.matricula='1511569450175' or
tba.matricula='1511569450176' or
tba.matricula='1511569450177' or
tba.matricula='1511569450178' or
tba.matricula='1511569450179' or
tba.matricula='1511569450180' or
tba.matricula='1511569450181' or
tba.matricula='1511569450182' or
tba.matricula='1511569450183' or
tba.matricula='1511569450184' or
tba.matricula='1511569450185' or
tba.matricula='1511569450186' or
tba.matricula='1511569450187' or
tba.matricula='1511569450188' or
tba.matricula='1511569450189' or
tba.matricula='1511569450190' or
tba.matricula='1511569450191' or
tba.matricula='1511569450192' or
tba.matricula='1511569450193' or
tba.matricula='1511569450194' or
tba.matricula='1511569450195' or
tba.matricula='1511569450196' or
tba.matricula='1511569450197' or
tba.matricula='1511569450198' or
tba.matricula='1511569450199' or
tba.matricula='1511569450200' or
tba.matricula='1511569450201' or
tba.matricula='1511569450202' or
tba.matricula='1511569450203' or
tba.matricula='1511569450204' or
tba.matricula='1511569450205' or
tba.matricula='1511569450206' or
tba.matricula='1511569450207' or
tba.matricula='1511569450208' or
tba.matricula='1511569450209' or
tba.matricula='1511569450210' or
tba.matricula='1511569450211' or
tba.matricula='1511569450212' or
tba.matricula='1511569450213' or
tba.matricula='1511569450214' or
tba.matricula='1511569450215' or
tba.matricula='1511569450216' or
tba.matricula='1511569450217' or
tba.matricula='1511569450218' or
tba.matricula='1511569450219' or
tba.matricula='1511569450220' or
tba.matricula='1511569450221' or
tba.matricula='1511569450222' or
tba.matricula='1511569450223' or
tba.matricula='1511569450224' or
tba.matricula='1511569450225' or
tba.matricula='1511569450226' or
tba.matricula='1511569450227' or
tba.matricula='1511569450228' or
tba.matricula='1511569450229' or
tba.matricula='1511569450230' or
tba.matricula='1511569450231' or
tba.matricula='1511569450232' or
tba.matricula='1511569450233' or
tba.matricula='1511569450234' or
tba.matricula='1511569450235' or
tba.matricula='1511569450236' or
tba.matricula='1511569450237' or
tba.matricula='1511569450238' or
tba.matricula='1511569450239' or
tba.matricula='1511569450240' or
tba.matricula='1511569450241' or
tba.matricula='1511569450242' or
tba.matricula='1511569450243' or
tba.matricula='1511569450244' or
tba.matricula='1511569450245' or
tba.matricula='1511569450246' or
tba.matricula='1511569450247' or
tba.matricula='1511569450248' or
tba.matricula='1511569450249' or
tba.matricula='1511569450250' or
tba.matricula='1511569450251' or
tba.matricula='1511569450252' or
tba.matricula='1511569450253' or
tba.matricula='1511569450254' or
tba.matricula='1511569450255' or
tba.matricula='1511569450256' or
tba.matricula='1511569450257' or
tba.matricula='1511569450258' or
tba.matricula='1511569450259' or
tba.matricula='1511569450260' or
tba.matricula='1511569450261' or
tba.matricula='1511569450262' or
tba.matricula='1511569450263' or
tba.matricula='1511569450264' or
tba.matricula='1511569450265' or
tba.matricula='1511569450266' or
tba.matricula='1511569450267' or
tba.matricula='1511569450268' or
tba.matricula='1511569450269' or
tba.matricula='1511569450270' or
tba.matricula='1511569450271' or
tba.matricula='1511569450272' or
tba.matricula='1511569450273' or
tba.matricula='1511569450274' or
tba.matricula='1511569450275' or
tba.matricula='1511569450276' or
tba.matricula='1511569450277' or
tba.matricula='1511569450278' or
tba.matricula='1511569450279' or
tba.matricula='1511569450280' or
tba.matricula='1511569450281' or
tba.matricula='1511569450282' or
tba.matricula='1511569450283' or
tba.matricula='1511569450284' or
tba.matricula='1511569450285' or
tba.matricula='1511569450286' or
tba.matricula='1511569450287' or
tba.matricula='1511569450288' or
tba.matricula='1511569450289' or
tba.matricula='1511569450290' or
tba.matricula='1511569450291' or
tba.matricula='1511569450292' or
tba.matricula='1511569450293' or
tba.matricula='1511569450294' or
tba.matricula='1511569450295' or
tba.matricula='1511569450296' or
tba.matricula='1511569450297' or
tba.matricula='1511569450298' or
tba.matricula='1511569450299' or
tba.matricula='1511569450300' or
tba.matricula='1511569450301' or
tba.matricula='1511569450302' or
tba.matricula='1511569450303' or
tba.matricula='1511569450304' or
tba.matricula='1511569450305' or
tba.matricula='1511569450306' or
tba.matricula='1511569450307' or
tba.matricula='1511569450308' or
tba.matricula='1511569450309' or
tba.matricula='1511569450310' or
tba.matricula='1511569450311' or
tba.matricula='1511569450312' or
tba.matricula='1511569450313' or
tba.matricula='1511569450314' or
tba.matricula='1511569450315' or
tba.matricula='1511569450316' or
tba.matricula='1511569450317' or
tba.matricula='1511569450318' or
tba.matricula='1511569450319' or
tba.matricula='1511569450320' 
 ";

$WHERE_ALUMNOS_G2="
tba.matricula='1511569450321' or
tba.matricula='1511569450322' or
tba.matricula='1511569450323' or
tba.matricula='1511569450324' or
tba.matricula='1511569450325' or
tba.matricula='1511569450326' or
tba.matricula='1511569450327' or
tba.matricula='1511569450328' or
tba.matricula='1511569450329' or
tba.matricula='1511569450330' or
tba.matricula='1511569450331' or
tba.matricula='1511569450332' or
tba.matricula='1511569450333' or
tba.matricula='1511569450334' or
tba.matricula='1511569450335' or
tba.matricula='1511569450336' or
tba.matricula='1511569450337' or
tba.matricula='1511569450338' or
tba.matricula='1511569450339' or
tba.matricula='1511569450340' or
tba.matricula='1511569450341' or
tba.matricula='1511569450342' or
tba.matricula='1511569450343' or
tba.matricula='1511569450344' or
tba.matricula='1511569450345' or
tba.matricula='1511569450346' or
tba.matricula='1511569450347' or
tba.matricula='1511569450348' or
tba.matricula='1511569450349' or
tba.matricula='1511569450350' or
tba.matricula='1511569450351' or
tba.matricula='1511569450352' or
tba.matricula='1511569450353' or
tba.matricula='1511569450354' or
tba.matricula='1511569450355' or
tba.matricula='1511569450356' or
tba.matricula='1511569450357' or
tba.matricula='1511569450358' or
tba.matricula='1511569450359' or
tba.matricula='1511569450360' or
tba.matricula='1511569450361' or
tba.matricula='1511569450362' or
tba.matricula='1511569450363' or
tba.matricula='1511569450364' or
tba.matricula='1511569450365' or
tba.matricula='1511569450366' or
tba.matricula='1511569450367' or
tba.matricula='1511569450368' or
tba.matricula='1511569450369' or
tba.matricula='1511569450370' or
tba.matricula='1511569450371' or
tba.matricula='1511569450372' or
tba.matricula='1511569450373' or
tba.matricula='1511569450374' or
tba.matricula='1511569450375' or
tba.matricula='1511569450376' or
tba.matricula='1511569450377' or
tba.matricula='1511569450378' or
tba.matricula='1511569450379' or
tba.matricula='1511569450380' or
tba.matricula='1511569450381' or
tba.matricula='1511569450382' or
tba.matricula='1511569450383' or
tba.matricula='1511569450384' or
tba.matricula='1511569450385' or
tba.matricula='1511569450386' or
tba.matricula='1511569450387' or
tba.matricula='1511569450388' or
tba.matricula='1511569450389' or
tba.matricula='1511569450390' or
tba.matricula='1511569450391' or
tba.matricula='1511569450392' or
tba.matricula='1511569450393' or
tba.matricula='1511569450394' or
tba.matricula='1511569450395' or
tba.matricula='1511569450396' or
tba.matricula='1511569450397' or
tba.matricula='1511569450398' or
tba.matricula='1511569450399' or
tba.matricula='1511569450400' or
tba.matricula='1511569450401' or
tba.matricula='1511569450402' or
tba.matricula='1511569450403' or
tba.matricula='1511569450404' or
tba.matricula='1511569450405' or
tba.matricula='1511569450406' or
tba.matricula='1511569450407' or
tba.matricula='1511569450408' or
tba.matricula='1511569450409' or
tba.matricula='1511569450410' or
tba.matricula='1511569450411' or
tba.matricula='1511569450412' or
tba.matricula='1511569450413' or
tba.matricula='1511569450414' or
tba.matricula='1511569450415' or
tba.matricula='1511569450416' or
tba.matricula='1511569450417' or
tba.matricula='1511569450418' or
tba.matricula='1511569450419' or
tba.matricula='1511569450420' or
tba.matricula='1511569450421' or
tba.matricula='1511569450422' or
tba.matricula='1511569450423' or
tba.matricula='1511569450424' or
tba.matricula='1511569450425' or
tba.matricula='1511569450426' or
tba.matricula='1511569450427' or
tba.matricula='1511569450428' or
tba.matricula='1511569450429' or
tba.matricula='1511569450430' or
tba.matricula='1511569450431' or
tba.matricula='1511569450432' or
tba.matricula='1511569450433' or
tba.matricula='1511569450434' or
tba.matricula='1511569450435' or
tba.matricula='1511569450436' or
tba.matricula='1511569450437' or
tba.matricula='1511569450438' or
tba.matricula='1511569450439' or
tba.matricula='1511569450440' or
tba.matricula='1511569450441' or
tba.matricula='1511569450442' or
tba.matricula='1511569450443' or
tba.matricula='1511569450444' or
tba.matricula='1511569450445' or
tba.matricula='1511569450446' or
tba.matricula='1511569450447' or
tba.matricula='1511569450448' or
tba.matricula='1511569450449' or
tba.matricula='1511569450450' or
tba.matricula='1511569450451' or
tba.matricula='1511569450452' or
tba.matricula='1511569450453' or
tba.matricula='1511569450454' or
tba.matricula='1511569450455' or
tba.matricula='1511569450456' or
tba.matricula='1511569450457' or
tba.matricula='1511569450458' or
tba.matricula='1511569450459' or
tba.matricula='1511569450460' or
tba.matricula='1511569450461' or
tba.matricula='1511569450462' or
tba.matricula='1511569450463' or
tba.matricula='1511569450464' or
tba.matricula='1511569450465' or
tba.matricula='1511569450466' or
tba.matricula='1511569450467' or
tba.matricula='1511569450468' or
tba.matricula='1511569450469' or
tba.matricula='1511569450470' 


";

            //SACA LOS IDS DE LOS ALUMNOS POR SU CUR EN TB_PERSONAS Y FILTRADO POR  CORPORACION
            //ORDENAR POR MATRICULA O APELLIDO
$WHERE_ALUMNOS_G="1=2";
if($generacion==1){
  $WHERE_ALUMNOS_G=$WHERE_ALUMNOS_G1;
}else if($generacion==2){
  $WHERE_ALUMNOS_G=$WHERE_ALUMNOS_G2;
}

            $query_alumnos="select ta.id_corporacion,ta.id_plan_estudio,ta.idmoodle,ta.numero_empleado,tp.curp, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(tp.apellido1),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as apellido1,
  REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(tp.apellido2),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as apellido2,
   REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(tp.nombre),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as nombre,
             tba.*, 
             est.descripcion as estatus,
             ta.last_access as ultimo_acceso
             from tb_personas tp 
             inner join tb_alumnos ta on ta.id_persona=tp.id 
             inner join tb_dgb_alumnos tba on tba.id_alumno=ta.id
             inner join escolar.tb_alumnos_estados est ON est.id = ta.estado
             WHERE   tba.generacion=".$generacion."
             order by tba.grupo ASC, tba.matricula ASC";

            //echo $query_alumnos; 

             $idx_alumno=0;
             $alumnos=array();
			if($result_alumnos=$mysql->Query($query_alumnos)){
				while ($row_alumno=mysql_fetch_array($result_alumnos)) {
					$alumnos[$idx_alumno]['idmoodle']=$row_alumno['idmoodle'];
          $alumnos[$idx_alumno]['numero_empleado']=$row_alumno['numero_empleado']; 
					$alumnos[$idx_alumno]['curp']=$row_alumno['curp'];
					$alumnos[$idx_alumno]['grupo']=$row_alumno['grupo'];
					$alumnos[$idx_alumno]['ciclo_escolar']=$row_alumno['ciclo_escolar'];
					$alumnos[$idx_alumno]['subciclo_escolar']=$row_alumno['subciclo_escolar'];
					$alumnos[$idx_alumno]['matricula']=$row_alumno['matricula'];
					$alumnos[$idx_alumno]['grado']=$row_alumno['grado'];
					$alumnos[$idx_alumno]['id_alumno']=$row_alumno['id_alumno'];
					$alumnos[$idx_alumno]['nombre']=$row_alumno['nombre'];
					$alumnos[$idx_alumno]['apellido1']=$row_alumno['apellido1'];
					$alumnos[$idx_alumno]['apellido2']=$row_alumno['apellido2'];
					$alumnos[$idx_alumno]['id_corporacion']=$row_alumno['id_corporacion'];
					$alumnos[$idx_alumno]['id_plan_estudio']=$row_alumno['id_plan_estudio'];
          $alumnos[$idx_alumno]['estatus']=$row_alumno['estatus'];
          $alumnos[$idx_alumno]['ultimo_acceso']=$row_alumno['ultimo_acceso'];

					$idx_alumno++;
				}
			}

			// optiene las materias de la dgb mediante la relacion y la linea de formacion 44  // COPPEL
            $query_materias="SELECT md.id as id_materia_dgb,tmi.id_moodle,tp.curp as curp_profesor,
            REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(concat(UPPER(tp.nombre),' ',UPPER(tp.apellido1),' ',UPPER(tp.apellido2)),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') as nombre_profesor,
            tp.id as id_profesor,md.matricula as clave,m.nombre as nombre_moodle,
            md.nombre as nombre_dgb ,md.periodo ,
            (select group_concat(tmi_ley.id_moodle) from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=4 
              and mr_ley.id_materia_autoridad=md.id limit 1 
            ) as idmoodle_ley,
            (select group_concat(tmi_ley.id_moodle) from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=3 
              and mr_ley.id_materia_autoridad=md.id limit 1 
            ) as idmoodle_soriana,            
            (select group_concat(tmi_ley.id_moodle) from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=1 
              and mr_ley.id_materia_autoridad=md.id limit 1 
            ) as idmoodle_agcollege,
            (select group_concat(tmi_ley.id_moodle) from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=13
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_sumate,
            (select group_concat(tmi_ley.id_moodle) from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=17
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_agsocial,
            (select group_concat(tmi_ley.id_moodle) from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=9 
              and mr_ley.id_materia_autoridad=md.id limit 1 
            ) as idmoodle_toks,
            (select group_concat(tmi_ley.id_moodle) from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=29
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_nueva_toks,
            (select group_concat(tmi_ley.id_moodle) from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=47
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_prepacoppel_2020,
            (select group_concat(tmi_ley.id_moodle)  from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=49
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_agcollege_2020,
            (select group_concat(tmi_ley.id_moodle)  from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=71
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_pizza_hut,
            (select group_concat(tmi_ley.id_moodle)  from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=72
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_wings_army,
            (select group_concat(tmi_ley.id_moodle)  from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=73
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_kia_sushi,
            (select group_concat(tmi_ley.id_moodle)  from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=74
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_valdez_baluarte,
            (select group_concat(tmi_ley.id_moodle) from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=60
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_oxxo,
            (select group_concat(tmi_ley.id_moodle) from tb_materias_ids tmi_ley 
              inner join tb_materias_relacion mr_ley on mr_ley.id_materia=tmi_ley.id_materia 
              where tmi_ley.id_plan_estudio=61
               and mr_ley.id_materia_autoridad=md.id limit 1
            ) as idmoodle_prepaley2022
            from tb_materias md 
            left join tb_materias_relacion mdr on mdr.id_materia_autoridad=md.id 
            left join tb_materias_ids tmi on tmi.id_materia=mdr.id_materia 
            left join tb_materias m on m.id=mdr.id_materia
            left join tb_materias_profesores mp on mp.id_materia=md.id AND mp.generacion='".$generacion_maestro."'
            left join tb_personas tp on tp.id=mp.id_profesor
            where md.id_linea_formacion=44 and tmi.id_plan_estudio=2
            AND md.periodo=".$grado."
            order by md.periodo ASC, md.id asc;
            ";


            //echo '<hr>'; 
            //echo $query_materias;  
            //echo '<hr>'; 
        


			/*// optiene las materias de la dgb mediante la relacion y la linea de formacion 44  // LEY
			$query_materias_ley="SELECT md.id as id_materia_dgb,tmi.id_moodle,tp.curp as curp_profesor,
			concat(tp.nombre,' ',tp.apellido1,' ',tp.apellido2) as nombre_profesor,
			tp.id as id_profesor,md.matricula as clave,m.nombre as nombre_moodle,
			md.nombre as nombre_dgb ,md.periodo 
			from tb_materias md 
			left join tb_materias_relacion mdr on mdr.id_materia_autoridad=md.id 
			left join tb_materias_ids tmi on tmi.id_materia=mdr.id_materia 
			left join tb_materias m on m.id=mdr.id_materia
			left join tb_materias_profesores mp on mp.id_materia=md.id
			left join tb_personas tp on tp.id=mp.id_profesor
			where tmi.id_plan_estudio=4
			AND (md.periodo=1 ) 
			order by md.id ASC
			";*/


             $idx_materia=0;
             $materias=array();
			if($result_materias=$mysql->Query($query_materias)){
				while ($row_materia=mysql_fetch_array($result_materias)) {
					$materias[$idx_materia]['idmoodle']=$row_materia['id_moodle'];
					$materias[$idx_materia]['clave']=$row_materia['clave'];
					$materias[$idx_materia]['curp_profesor']=$row_materia['curp_profesor'];
					$materias[$idx_materia]['nombre_profesor']=$row_materia['nombre_profesor'];
					$materias[$idx_materia]['nombre_moodle']=$row_materia['nombre_moodle'];
					$materias[$idx_materia]['nombre_dgb']=$row_materia['nombre_dgb'];
					$materias[$idx_materia]['periodo']=$row_materia['periodo'];
					$materias[$idx_materia]['id_profesor']=$row_materia['id_profesor'];
					$materias[$idx_materia]['id_materia_dgb']=$row_materia['id_materia_dgb'];
          $materias[$idx_materia]['idmoodle_ley']=$row_materia['idmoodle_ley'];
          $materias[$idx_materia]['idmoodle_soriana']=$row_materia['idmoodle_soriana'];
          $materias[$idx_materia]['idmoodle_agcollege']=$row_materia['idmoodle_agcollege'];
          $materias[$idx_materia]['idmoodle_sumate']=$row_materia['idmoodle_sumate'];
          $materias[$idx_materia]['idmoodle_agsocial']=$row_materia['idmoodle_agsocial'];
          $materias[$idx_materia]['idmoodle_toks']=$row_materia['idmoodle_toks'];
          $materias[$idx_materia]['idmoodle_nueva_toks']=$row_materia['idmoodle_nueva_toks'];
          $materias[$idx_materia]['idmoodle_prepacoppel_2020']=$row_materia['idmoodle_prepacoppel_2020'];
          $materias[$idx_materia]['idmoodle_agcollege_2020']=$row_materia['idmoodle_agcollege_2020'];
          $materias[$idx_materia]['idmoodle_oxxo']=$row_materia['idmoodle_oxxo'];
          $materias[$idx_materia]['idmoodle_prepaley2022']=$row_materia['idmoodle_prepaley2022'];

					$idx_materia++;
				}
			}



			$actas=array();
			$grupo=0;
			$idx=0;


				//optiene el ultimo folio
				if($res_folio=$mysql->Query("SELECT escolar.tb_dgb_folios.id_folio FROM escolar.tb_dgb_folios ORDER BY  escolar.tb_dgb_folios.id_folio DESC limit 1")){
									$row_folio=mysql_fetch_array($res_folio);
									if($row_folio['id_folio']==null || $row_folio['id_folio']==0){
										$folio=0;
									}else{
										$folio=$row_folio['id_folio'];
									}
					}


            $array_alumnos_cero = [];

			foreach ($alumnos as $al) {

				foreach ($materias as $mat) {

                    if((int)$al['id_corporacion']==2){ // coppel

                        if((int)$al['id_plan_estudio'] == 2)
                        {
                            $query_calificaciones="SELECT agc.calificacion from prepacoppel.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                            $cali=0;
                            if($result_cali=$mysql->Query($query_calificaciones)){
                                $reg = mysql_fetch_array($result_cali);
                                $cali=$reg['calificacion'];

                                if($cali>=6.0){
                                    $cali=round($cali,0);
                                }else{
                                    $cali=(int)$cali;

                                    if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                        $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                    }
                                }
                            }
                        }

                        if((int)$al['id_plan_estudio'] == 47) 
                        {
                            $query_calificaciones="SELECT agc.calificacion from nprepacoppel.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_prepacoppel_2020']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                            $cali=0;
                            if($result_cali=$mysql->Query($query_calificaciones)){
                                $reg = mysql_fetch_array($result_cali);
                                $cali=$reg['calificacion'];

                                if($cali>=6.0){
                                    $cali=round($cali,0);
                                }else{
                                    $cali=(int)$cali;
                                    if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                        $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                    }
                                }
                            }   
                        }

                    }else if((int)$al['id_corporacion']==4){ //ley

                        if((int)$al['id_plan_estudio'] == 4) {
                          $query_calificaciones="SELECT agc.calificacion from prepaley.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_ley']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                        }
                        elseif((int)$al['id_plan_estudio'] == 61) {
                          $query_calificaciones="SELECT agc.calificacion from nprepaley.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_prepaley2022']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                        }

                        $cali=0;
                        if($result_cali=$mysql->Query($query_calificaciones)){
                            $reg = mysql_fetch_array($result_cali);
                            $cali=$reg['calificacion'];

                            if($cali>=6.0){
                                $cali=round($cali,0);
                            }else{
                                $cali=(int)$cali;
                                if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                    $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                }
                            }
                        }

                    }else if((int)$al['id_corporacion']==3){ //soriana

                        $query_calificaciones="SELECT agc.calificacion from soriana.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_soriana']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                        $cali=0;
                        if($result_cali=$mysql->Query($query_calificaciones)){
                            $reg = mysql_fetch_array($result_cali);
                            $cali=$reg['calificacion'];

                            if($cali>=6.0){
                                $cali=round($cali,0);
                            }else{
                                $cali=(int)$cali;
                                if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                    $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                }
                            }
                        }

                    }else if((int)$al['id_corporacion']==1){ //AGCOLLEGE

                            // AG COLLEGE
                        if((int)$al['id_plan_estudio']==1)
                        {
                            $query_calificaciones="SELECT agc.calificacion from `agcollege-ag`.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_agcollege']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                            $cali=0;
                            if($result_cali=$mysql->Query($query_calificaciones)){
                                $reg = mysql_fetch_array($result_cali);
                                $cali=$reg['calificacion'];

                                if($cali>=6.0){
                                    $cali=round($cali,0);
                                }else{
                                    $cali=(int)$cali;
                                    if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                        $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                    }
                                }
                            }
                        }
                        else if((int)$al['id_plan_estudio']==49)
                        {
                            $query_calificaciones="SELECT agc.calificacion from prepaagcollege.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_agcollege_2020']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                            $cali=0;
                            if($result_cali=$mysql->Query($query_calificaciones)){
                                $reg = mysql_fetch_array($result_cali);
                                $cali=$reg['calificacion'];

                                if($cali>=6.0){
                                    $cali=round($cali,0);
                                }else{
                                    $cali=(int)$cali;
                                    if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                        $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                    }
                                }
                            }
                        }
                        else if((int)$al['id_plan_estudio']==71) //PIZZA HUT
                        {
                            $query_calificaciones="SELECT agc.calificacion from prepaagcollege.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_pizza_hut']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                            $cali=0;
                            if($result_cali=$mysql->Query($query_calificaciones)){
                                $reg = mysql_fetch_array($result_cali);
                                $cali=$reg['calificacion'];

                                if($cali>=6.0){
                                    $cali=round($cali,0);
                                }else{
                                    $cali=(int)$cali;
                                    if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                        $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                    }
                                }
                            }
                        }
                        else if((int)$al['id_plan_estudio']==72) //WINGS ARMY
                        {
                            $query_calificaciones="SELECT agc.calificacion from prepaagcollege.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_wings_army']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                            $cali=0;
                            if($result_cali=$mysql->Query($query_calificaciones)){
                                $reg = mysql_fetch_array($result_cali);
                                $cali=$reg['calificacion'];

                                if($cali>=6.0){
                                    $cali=round($cali,0);
                                }else{
                                    $cali=(int)$cali;
                                    if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                        $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                    }
                                }
                            }
                        }
                        else if((int)$al['id_plan_estudio']==73) //KIA SUCHI
                        {
                            $query_calificaciones="SELECT agc.calificacion from prepaagcollege.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_kia_sushi']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                            $cali=0;
                            if($result_cali=$mysql->Query($query_calificaciones)){
                                $reg = mysql_fetch_array($result_cali);
                                $cali=$reg['calificacion'];

                                if($cali>=6.0){
                                    $cali=round($cali,0);
                                }else{
                                    $cali=(int)$cali;
                                    if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                        $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                    }
                                }
                            }
                        }
                        else if((int)$al['id_plan_estudio']==74) //VALDEZ BALUARTE
                        {
                            $query_calificaciones="SELECT agc.calificacion from prepaagcollege.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_valdez_baluarte']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                            $cali=0;
                            if($result_cali=$mysql->Query($query_calificaciones)){
                                $reg = mysql_fetch_array($result_cali);
                                $cali=$reg['calificacion'];

                                if($cali>=6.0){
                                    $cali=round($cali,0);
                                }else{
                                    $cali=(int)$cali;
                                    if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                        $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                    }
                                }
                            }
                        }
                        else 
                        {
                        // AG COLLEGE SOCIAL 

                            $query_calificaciones="SELECT agc.calificacion from agsocial.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_agsocial']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                            $cali=0;
                            if($result_cali=$mysql->Query($query_calificaciones)){
                                $reg = mysql_fetch_array($result_cali);
                                $cali=$reg['calificacion'];

                                if($cali>=6.0){
                                    $cali=round($cali,0);
                                }else{
                                    $cali=(int)$cali;
                                    if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                        $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                    }
                                }
                            }
                        }

                    }else if((int)$al['id_corporacion']==7){ //PREPA TOKS  

                        if($al['id_plan_estudio'] == 9)
                        {
                                $query_calificaciones="SELECT agc.calificacion from prepatoks.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_toks']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                                $cali=0;
                                if($result_cali=$mysql->Query($query_calificaciones)){
                                    $reg = mysql_fetch_array($result_cali);
                                    $cali=$reg['calificacion'];

                                    if($cali>=6.0){
                                        $cali=round($cali,0);
                                    }else{
                                        $cali=(int)$cali;
                                        if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                            $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                        }
                                    }
                                }
                        } 
                        else
                        {
                            $query_calificaciones="SELECT agc.calificacion from nprepatoks.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_nueva_toks']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                            $cali=0;
                            if($result_cali=$mysql->Query($query_calificaciones)){
                                $reg = mysql_fetch_array($result_cali);
                                $cali=$reg['calificacion'];

                                if($cali>=6.0){
                                    $cali=round($cali,0);
                                }else{
                                    $cali=(int)$cali;
                                    if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                        $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                    }
                                }
                            }
                        }
                    }else if((int)$al['id_corporacion']==8){ //SUMATE 
                        $query_calificaciones="SELECT agc.calificacion from prepasumate.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_sumate']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                        $cali=0;
                        if($result_cali=$mysql->Query($query_calificaciones)){
                            $reg = mysql_fetch_array($result_cali);
                            $cali=$reg['calificacion'];

                            if($cali>=6.0){
                                $cali=round($cali,0);
                            }else{
                                $cali=(int)$cali;
                                if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                    $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                }
                            }
                        }
                    }
                    else if((int)$al['id_corporacion'] == 11){ //OXXO 
                        $query_calificaciones="SELECT agc.calificacion from prepaoxxo.ag_calificaciones agc where FIND_IN_SET(agc.id_materia,'".$mat['idmoodle_oxxo']."') AND agc.id_alumno='".$al['idmoodle']."' limit 1";
                        $cali=0;
                        if($result_cali=$mysql->Query($query_calificaciones)){
                            $reg = mysql_fetch_array($result_cali);
                            $cali=$reg['calificacion'];

                            if($cali>=6.0){
                                $cali=round($cali,0);
                            }else{
                                $cali=(int)$cali;
                                if(!isset($array_alumno_cero[$al['id_plan_estudio']][$al['idmoodle']]) && $opciones == 1){
                                    $array_alumno_cero[$al['id_plan_estudio']][$al['numero_empleado']] = $al['numero_empleado'];
                                }
                            }
                        }
                    }
                    else{
                      $cali="NO RELACIONADA";
                    }

					if($grupo != $al['grupo']){
						$grupo=$al['grupo'];

						if($modo==0){ // modo preview : se generan los folios de modo ficticio apartir de el ultimo folio
						  $folio++;
                        }else if($modo==1){ // modo generad
									// se genera un nuevo folio
							if($folio_ins=$mysql->Query("INSERT INTO escolar.tb_dgb_folios (id_folio,fecha_registro) VALUES ((".$folio."+1),now()) ")){

								if($res_folio=$mysql->Query("SELECT escolar.tb_dgb_folios.id_folio FROM escolar.tb_dgb_folios ORDER BY  escolar.tb_dgb_folios.id_folio DESC limit 1")){
									$row_folio=mysql_fetch_array($res_folio);
									$folio=$row_folio['id_folio'];
									$num_c=count($folio);
									$num_c=6-$num_c;
									$folio=str_pad($folio, $num_c, "0", STR_PAD_LEFT);
								}
							}
						}
					}

					if($modo==1){ // GUARDA EN LA TABLA tb_dgb_actas
						if($insert_acta=$mysql->Query("INSERT INTO escolar.tb_dgb_actas (ciclo_escolar,subciclo_escolar,tipo_evaluacion,grado,id_folio,id_profesor,id_materia_dgb,id_alumno,calificacion,fecha_evaluacion,tipo_movimiento,fecha_registro,grupo,generacion) 
							VALUES ('".$ciclo_escolar."',
									'".$subciclo_escolar."',
									'".$tipo_evaluacion."',
									'".$grado."',
									'".$folio."',
									'".$mat['id_profesor']."',
									'".$mat['id_materia_dgb']."',
									'".$al['id_alumno']."',
									'".$cali."',
									'".$fecha_evaluacion."',
									'".$tipo_movimiento."',
									now(),
                                    '".($sumagrupo+(int)$al['grupo'])."',
                                    '".$generacion."'
								) ")){
						}
					}

                    $corp="";
                    if((int)$al['id_corporacion']==2)
                    {  
                        if($al['id_plan_estudio']=='2')
                        {
                            $corp="COPPEL";
                        }
                        else {
                            $corp="COPPEL 2020";
                        }                     			
                        
                    }else if((int)$al['id_corporacion']==4){
                        if($al['id_plan_estudio']=='4')
                        {
                            $corp="LEY";
                        }
                        else {
                            $corp="LEY 2022";
                        }
                    }else if((int)$al['id_corporacion']==3){
                        $corp="SORIANA";       
                    }else if((int)$al['id_corporacion']==1){
                        if((int)$al['id_plan_estudio']==1)
                        {
                            $corp="AGCOLLEGE";       
                        }
                        else if((int)$al['id_plan_estudio']==49)
                        {
                            $corp="AGCOLLEGE 2020";
                        }
                        else if((int)$al['id_plan_estudio']==71)
                        {
                            $corp="PREPARATORIA PIZZA HUT";
                        }
                        else if((int)$al['id_plan_estudio']==72)
                        {
                            $corp="PREPARATORIA WINGS ARMY";
                        }
                        else if((int)$al['id_plan_estudio']==73)
                        {
                            $corp="PREPARATORIA KIA SUSHI";
                        }	
                        else if((int)$al['id_plan_estudio']==74)
                        {
                            $corp="PREPARATORIA VALDEZ BALUARTE";
                        }	
                        else
                        {
                            $corp="AGCOLLEGESOCIAL";
                        }
                    }else if((int)$al['id_corporacion']==8){
                        $corp = "MABE";
                    }else if((int)$al['id_corporacion']==7){
                        if((int)$al['id_plan_estudio']==9)
                        {
                            $corp = "TOKS";
                        }
                        else
                        {
                            $corp = "NUEVA PREPA TOKS";
                        }
                    }
                    else if((int)$al['id_corporacion'] == 11) {
                      $corp="OXXO";
                    }

                    $actas[$idx]['corporacion']=  $corp;
					$actas[$idx]['fila']=$idx+1;
					
					$actas[$idx]['primer_apellido']=$al['apellido1'];
					$actas[$idx]['segundo_apellido']=$al['apellido2'];
					$actas[$idx]['nombre']=$al['nombre'];
					$actas[$idx]['curp_alumno']=$al['curp'];
					$actas[$idx]['grado']=$grado;
					$actas[$idx]['grupo']= ($sumagrupo+(int)$al['grupo']);
					$actas[$idx]['clave_asignatura']=(string)$mat['clave'];
					$actas[$idx]['asignatura']=$mat['nombre_dgb'];
					$actas[$idx]['asignatura2']=$mat['nombre_moodle'];

					$actas[$idx]['calificacion']=$cali; //calificacion
					$actas[$idx]['fecha_evaluacion']=$fecha_evaluacion;
					$actas[$idx]['folio']=$folio; // numero de acta
					$actas[$idx]['curp_profesor']=$mat['curp_profesor']; // curp del docente
                    $actas[$idx]['estatus']=$al['estatus'];
                    $actas[$idx]['numero_empleado']=$al['numero_empleado'];
                    $actas[$idx]['ultimo_acceso']=$al['ultimo_acceso'];
                    $actas[$idx]['id_plan_estudio']=$al['id_plan_estudio'];

					$idx++;
				}

			}

            //server PRUEBA online    2801    root    localhost   prepasumate Query   1   User lock   SELECT GET_LOCK('prepasumate-mdl_-session-441', 120)

             $table="<table style='border-style: solid;' >";
             $table.="<thead>
                        <th style='border-style: solid;' >CORPORACION</th>
                  <th style='border-style: solid;' >Numero Empleado</th>  
             			<th style='border-style: solid;' >FILA</th>
             			<th style='border-style: solid;' >Primer Apellido</th>
             			<th style='border-style: solid;' >Segundo Apellido</th>
             			<th style='border-style: solid;' >Nombre</th>
             			<th style='border-style: solid;' >Curp del alumno</th>
             			<th style='border-style: solid;' >Grado</th>
             			<th style='border-style: solid;' >Grupo</th>
             			<th style='border-style: solid;' >Clave Asignatura</th>
             			<th style='border-style: solid;' >Asignatura</th>

             			<th style='border-style: solid;' >Calificacion</th>
             			<th style='border-style: solid;' >fecha evaluacion</th>
             			<th style='border-style: solid;' >Numero Acta</th>
             			<th style='border-style: solid;' >Curp Docente</th>
                  <th style='border-style: solid;' >Estatus</th>
                  <th style='border-style: solid;' >Ultimo Acceso</th>
             		</thead>";
 				$table.="<tbody>";


             for ($i=0; $i < count($actas) ; $i++) { 
                if(isset($array_alumno_cero[$actas[$i]['id_plan_estudio']][$actas[$i]['numero_empleado']]) && $opciones == 1){
                    $actas[$i]['calificacion'] = 0;
                }

             	$table.="<tr>";
                $table.="<td style='border-style: solid;'>".$actas[$i]['corporacion']."</td>";
                $table.="<td style='border-style: solid;'>".$actas[$i]['numero_empleado']."</td>";
             	$table.="<td style='border-style: solid;'>".$actas[$i]['fila']."</td>";
             	$table.="<td style='border-style: solid;'>".utf8_decode($actas[$i]['primer_apellido'])."</td>";
             	$table.="<td style='border-style: solid;' >".utf8_decode($actas[$i]['segundo_apellido'])."</td>";
             	$table.="<td style='border-style: solid;' >".utf8_decode($actas[$i]['nombre'])."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['curp_alumno']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['grado']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['grupo']."</td>";
             	$table.="<td style='border-style: solid;' >'".$actas[$i]['clave_asignatura']."'</td>";
             	$table.="<td style='border-style: solid;' >".utf8_decode($actas[$i]['asignatura'])."</td>";
             	//$table.="<td style='border-style: solid;' >".utf8_decode($actas[$i]['asignatura2'])."</td>";

             	$table.="<td style='border-style: solid;' >".$actas[$i]['calificacion']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['fecha_evaluacion']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['folio']."</td>";
             	$table.="<td style='border-style: solid;' >".$actas[$i]['curp_profesor']."</td>";
              $table.="<td style='border-style: solid;' >".$actas[$i]['estatus']."</td>";
              $table.="<td style='border-style: solid;' >".$actas[$i]['ultimo_acceso']."</td>";

             	$table.="</tr>";
             }
 				$table.="</tbody></table>";

 			echo $table;
            $mysql->Cerrar();
        }else{
            echo "Necesitas primero importar el archivo";
        }



    $errores=0;
}






?>