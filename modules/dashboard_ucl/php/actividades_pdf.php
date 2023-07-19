<?php 

	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
	

	if(isset($_GET['userid']) && isset($_GET['modulo']) && isset($_GET['course']) && is_numeric($_GET['userid']) && is_numeric($_GET['modulo']) && is_numeric($_GET['course']) ){


		$userid=$_GET['userid'];
		$modulo=$_GET['modulo'];
		$course=$_GET['course'];


		$nombre_materia="Materia";
		$nombre_alumno="Alumno";

		
		require_once("../models/Connection.class.php");
		require_once("../models/Usuarios.class.php");
		require_once("../models/PlanEstudios.class.php");
		require_once("../models/MateriasMoodle.class.php");



		$id_plan_estudio=16;
		$id_corporacion=4;

		$usuarios = new Usuarios();
		$materiasmoodle=new MateriasMoodle();
		$planestudios = new PlanEstudios();

		$res_plan=$planestudios->GetPlanEstudio($id_plan_estudio);
		$bd_plan='`'.$res_plan['data'][0]['basededatos'].'`';
		$planestudios->Close();


		$result_usuario=$usuarios->GetAlumnoByMoodle($userid,$id_plan_estudio);
		$id_alumno=$result_usuario['data'][0]['id'];
		$result_usuario2=$usuarios->GetAlumnoMoodle($bd_plan,$userid);
		$nombre_alumno=$result_usuario2['data'][0]['firstname']." ".$result_usuario2['data'][0]['lastname'];
		$usuarios->Close();

		$result_tbmateria=$materiasmoodle->GetMateriaEscolarByMoodle($course,$id_plan_estudio);
		$id_materia=$result_tbmateria['data'][0]['id'];
		$nombre_materia=$result_tbmateria['data'][0]['nombre'];

		$materias_result=$materiasmoodle->GetEjerciciosByMateriaUnidad($bd_plan,$course,$modulo);
		$actividades=$materias_result['data'];

		if(count($actividades)<=0){
			die("No se ha podido cargar las actividades. Intente mas tarde.");
			$materiasmoodle->Close();
		}


		for ($i=0; $i < count($actividades); $i++) { 
			$result_ejercicio=$materiasmoodle->GetEjercicioAlumno($id_alumno,$id_materia,$actividades[$i]['id'],$modulo,$id_corporacion,$id_plan_estudio);

			if(count($result_ejercicio['data'])>0){
				$actividades[$i]['ejercicio_alumno']=$result_ejercicio['data'][0];
			}else{
				$actividades[$i]['ejercicio_alumno']=null;
			}
			
		}

		$materiasmoodle->Close();

require_once("../models/TCPDF-master/tcpdf.php");

class MYPDF extends TCPDF {
	var $modulo=0;
	var $nombre_alumno="Alumno";
	var $nombre_materia="Materia";
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'background_edit.png';
        $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 15);
        // Title
        $this->Cell(0, 15,'Actividades Integradoras Unidad '.($this->modulo+1), 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->writeHTML("<br>", true, false, true, false, '');
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 15,$this->nombre_materia, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->writeHTML("<br>", true, false, true, false, '');
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 15,$this->nombre_alumno, 0, false, 'C', 0, '', 0, false, 'M', 'M');


    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

	// create new PDF document
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf->nombre_alumno=$nombre_alumno;
	$pdf->nombre_materia=$nombre_materia;
	$pdf->modulo=$modulo;
	// set document information
	$pdf->SetCreator('AG College');
	$pdf->SetAuthor($nombre_alumno);
	$pdf->SetTitle($nombre_materia);
	$pdf->SetSubject('Actividades Unidad '.($modulo+1));
	//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	/*if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	    require_once(dirname(__FILE__).'/lang/eng.php');
	    $pdf->setLanguageArray($l);
	}*/

	// ---------------------------------------------------------

	// set font
	$pdf->SetFont('times', 'B', 12);


	for ($i=0; $i < count($actividades); $i++) { 
		$pdf->AddPage();
		//$html=$actividades[$i]['title'];
		if($actividades[$i]['ejercicio_alumno']['estatus']==1){
				$pdf->writeHTML("<h2>Actividad ".($i+1)." <small style='color:green;'>[Realizada]</small></h2>", true, false, true, false, '');

		}else{
				$pdf->writeHTML("<h2>Actividad ".($i+1)." <small>[Sin realizar]</small></h2>", true, false, true, false, '');

		}
		$pdf->writeHTML("<br><hr>", true, false, true, false, '');
		$pdf->writeHTML("<strong>".$actividades[$i]['name']."</strong>", true, false, true, false, '');
		$pdf->SetFont('helvetica', 'b', 10);
		$pdf->writeHTML("<section >".$actividades[$i]['content']."</section>", true, false, true, false, '');
		$pdf->writeHTML("<br><hr>", true, false, true, false, '');
		$pdf->writeHTML($actividades[$i]['ejercicio_alumno']['contenido'], true, false, true, false, '');
	}
	// set some text to print
	//$html ="TITULOBLA BLA BLA BLA BLA BLA 2<br>asdasds";

	// print a block of text using Write()
	//$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
	//$pdf->writeHTML($html, true, false, true, false, '');
	// ---------------------------------------------------------
	   ob_end_clean(); //add this line here 
	//Close and output PDF document
	$pdf->Output('actividades_integradoras_materia'.$course.'_modulo'.$modulo.'_id'+$userid+'.pdf', 'I');

	//============================================================+
	// END OF FILE
	//============================================================+






	}else{

		echo "No se ha podido cargar las actividades. Intente mas tarde.";
	}
?>