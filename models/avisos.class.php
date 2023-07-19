<?php
class Avisos Extends Connect
{
	
	function Avisos(){

	}


	function MostrarAvisos($id_corporacion=0,$id_estado_alumno=0){
 			$this->bd="escolar";
 			$this->password="";
 			$this->Connectar();
			$mensajes=array();
			$mensajes[0]=array();
			$mensajes[1]=array();
			$mensajes[2]=array();
			$mensajes[3]=array();
			$mensajes[4]=array();
			$mensajes[5]=array();
			$mensajes[6]=array();
			$mensajes[7]=array();
			$mensajes[8]=array();

			$idx=0;
			$query_mensajes="
            SELECT m.id,m.titulo,m.id_corporacion,m.tipo,m.status,m.fecha_registro,m.fecha_modificado,m.mensaje  from escolar.tb_mensajes_plataforma m where m.eliminado=0 AND m.status=1 AND m.id_corporacion='".$id_corporacion."' order by m.id DESC
							";

			if($result_mensajes=$this->Query($query_mensajes)){


				  

				while ($mensaje=mysql_fetch_object($result_mensajes)) {

					$template_mensaje="";
					switch($mensaje->tipo){

						case 0: // GLOBAL
							$template_mensaje = "
							<div id='modal_aviso_".$mensaje->id."' class='modal fade out' tabindex='-2' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' >
							    <div class='modal-dialog'>
							        <div class='modal-content '>
							            <div class='modal-header bg-color-blue'>
							                <h4 class='modal-title2 text-white-title text-center'>".$mensaje->titulo."</h4>
							            </div>
							            <div class='modal-body' style='text-align: justify;'>
							            <div class='col-md-12' >
							            </div>
							           ".$mensaje->mensaje."
							            </div>
							            <div class='modal-footer'>
							                <center>
							                    <button id='button_close_modal' type='button' class='btn btn-default' data-dismiss='modal' >Cerrar</button>
							                </center>
							            </div>
							        </div>
							    </div>
							</div>
							<script>
								$(document).ready(function(){
									$('#modal_aviso_'+".$mensaje->id.").modal('show');
								});
							</script>
							";
						break;

						case 1: // SOLO ACTIVOS
							$template_mensaje = "
								<center>
									<div id='mensaje_control_escolar' class='row' style='display: none; width: 95%;'>
										<div class='alert alert-warning' role='alert' style='background-color: #fafafa; border-radius: 16px; border-color: #e7e7e7'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
											<blockquote style='border-left: none; margin-bottom: 0px;'>
											    <center>
											    <i class='fa fa-exclamation-triangle fa-2x text-blue'></i>
											    <br>
											    <strong>".$mensaje->titulo."</strong>
											    </center>
											    <div class='row'>
		                                            <div class='col-lg-10 col-lg-offset-1'>
		                                            ".$mensaje->mensaje."
		                                            </div>
		                                        </div>
											</blockquote>
										</div>
									</div>
								</center>
							";
						break;

						case 4: // SUSPENDIDOS POR FALTA DE DOCUMENTOS

							$template_mensaje = "
								<center>
									<div id='mensaje_control_escolar' class='row' style='display: none; width: 95%;'>
										<div class='alert alert-warning' role='alert' style='background-color: #fafafa; border-radius: 16px; border-color: #e7e7e7'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
											<blockquote style='border-left: none; margin-bottom: 0px;'>
											    <center>
											    <i class='fa fa-exclamation-triangle fa-2x text-blue'></i>

											    <br>
											    <strong>".$mensaje->titulo."</strong>
											    </center>
											    <div class='row'>
		                                            <div class='col-lg-10 col-lg-offset-1'>
		                                            ".$mensaje->mensaje."
		                                            </div>
		                                        </div>
												
											</blockquote>
										</div>
									</div>
								</center>
							";

						break;

						case 5: // SUSPENDIDOS POR INACTIVIDAD
								$template_mensaje = "
								<center>
									<div id='mensaje_control_escolar' class='row' style='display: none; width: 95%;'>
										<div class='alert alert-warning' role='alert' style='background-color: #fafafa; border-radius: 16px; border-color: #e7e7e7'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
											<blockquote style='border-left: none; margin-bottom: 0px;'>
											    <center>
											    <i class='fa fa-exclamation-triangle fa-2x text-blue'></i>

											    <br>
											    <strong>".$mensaje->titulo."</strong>
											    </center>
											    <div class='row'>
		                                            <div class='col-lg-10 col-lg-offset-1'>
		                                            ".$mensaje->mensaje."
		                                            </div>
		                                        </div>
												
											</blockquote>
										</div>
									</div>
								</center>
							";
						break;

						case 6: // SUSPENDIDOS POR TIEMPO
								$template_mensaje = "
								<center>
									<div id='mensaje_control_escolar' class='row' style='display: none; width: 95%;'>
										<div class='alert alert-warning' role='alert' style='background-color: #fafafa; border-radius: 16px; border-color: #e7e7e7'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
											<blockquote style='border-left: none; margin-bottom: 0px;'>
											    <center>
											    <i class='fa fa-exclamation-triangle fa-2x text-blue'></i>

											    <br>
											    <strong>".$mensaje->titulo."</strong>
											    </center>
											    <div class='row'>
		                                            <div class='col-lg-10 col-lg-offset-1'>
		                                            ".$mensaje->mensaje."
		                                            </div>
		                                        </div>
												
											</blockquote>
										</div>
									</div>
								</center>
							";
						break;


						default:

						break;
					}

					array_push($mensajes[(int)$mensaje->tipo],$template_mensaje);

				}
			}

				$html_mensajes=" ";
			if($id_estado_alumno!=0){
				foreach ($mensajes[$id_estado_alumno] as $msg) {
					$html_mensajes.=$msg;
				}
			}

			foreach ($mensajes[0] as $msg) {
				$html_mensajes.=$msg;
			}

            $this->Cerrar();
 			return $html_mensajes;
	}

}

?>