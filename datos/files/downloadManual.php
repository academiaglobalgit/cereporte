<?php
	try
	{
		//$fullPathFile = "/mnt/volume-ams3-03/www/html/cereporte/admin/assets/files/Manual Asesor.pdf";
		$fullPathFile = "/var/www/html/cereporte/admin/assets/files/Manual Asesor.pdf";

		if(file_exists($fullPathFile))
		{
			$content = file_get_contents($fullPathFile);			
			header('Content-Type: application/pdf');
			header('Content-Length: '.strlen( $content ));
			header('Content-disposition: attachment; filename="' . basename($fullPathFile) . '"');
			header('Cache-Control: public, must-revalidate, max-age=0');
			header('Pragma: public');
			header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
			echo $content;

			/*$archiveFileZip = time() . ".zip";
			$archiveZip = new ZipArchive();

			if($archiveZip->open($archiveFileZip, ZipArchive::CREATE | ZipArchive::OVERWRITE))
			{			
				if(!$archiveZip->addFile($fullPathFile, basename($fullPathFile))){
					throw new Exception("El archivo no se pudo adjuntar");
				}

				if(!$archiveZip->close()){
					throw new Exception("El archivo no se pudo empaquetar");
				}

				if(file_exists($archiveFileZip))
				{	
					header('Content-Description: File Transfer');
	    			header('Content-Type: application/octet-stream');
				 	header('Content-Disposition: attachment; filename="'.basename($archiveFileZip).'"');
				 	header('Expires: 0');
				    header('Cache-Control: must-revalidate');
				    header('Pragma: public');
				    header('Content-Length: ' . filesize($archiveFileZip));
				    ob_clean();
				    readfile($archiveFileZip);
				    unlink($archiveFileZip);
				    header('Connection: close');
					exit;
				}
			}*/
		}
	}
	catch(exception $e)
	{
		$templateHtml = '<h2>Error al descargar el manual del asesor</h3>'
			. '<h4 class="list-group-item-heading">Ocurrio un error en el servidor</h4>'
			. '<p class="list-group-item-text">' . $e->getMessage() . '</p>';	
		echo $templateHtml;
	}
?>