<?php
class Avisos Extends Conexion
{
	
	var $id_corporacion=0;
	var $id_plan_estudio=0;

	function Avisos()
	{

	}

	function GetStatusTbAlumno($id_moodle=0){

		$query="SELECT ta.estado,ta.numero_empleado,CONCAT(tp.nombre,' ',tp.apellido1,' ',tp.apellido2) AS nombre_alumno FROM escolar.tb_alumnos ta inner join escolar.tb_personas tp on tp.id=ta.id_persona WHERE ta.id_corporacion='".$this->id_corporacion."' and ta.id_plan_estudio='".$this->id_plan_estudio."' and ta.idmoodle='".$id_moodle."' limit 1";
		
		$conexion= $this->conexion();
		$result_array=array();
			if($result=$conexion->query($query))
			{

				while ($row=$result->fetch_assoc())
				{
					$result_array=$row;
				}
			}

		$conexion->close();
		return $result_array;
	}

	function MostrarAvisos($alunno = array())
	{		$id_estado_alumno=0;
			$nombre_alumno="";
			$numero_empleado="<numero de estafeta>";
			if(isset($alunno['estado'])){
				$id_estado_alumno=$alunno['estado'];
				$numero_empleado=$alunno['numero_empleado'];
				$nombre_alumno=$alunno['nombre_alumno'];
			}
 			
 			$conexion= $this->conexion();
			$html_mensajes="";
			$idx=0;
			$query_mensajes="SELECT m.id,m.titulo,m.id_corporacion,m.id_plan_estudio,m.tipo,m.status,m.fecha_registro,m.fecha_modificado,m.mensaje  from escolar.tb_mensajes_plataforma m where m.eliminado=0 AND m.status=1 AND m.id_plan_estudio='".$this->id_plan_estudio."' order by m.id DESC";
			
			$template_mensaje="";

			if($result_mensajes=$conexion->query($query_mensajes))
			{

				while ($mensaje=$result_mensajes->fetch_object() )
				{

					$mensaje->mensaje=str_replace("%nombre_alumno%", $nombre_alumno, $mensaje->mensaje);
					$mensaje->mensaje=str_replace("%numero_empleado%", $numero_empleado,$mensaje->mensaje);
					
					switch($mensaje->tipo)
					{

						case 0: // GLOBAL
							$template_mensaje = "
							<div id='modal_avisos' class='modal fade out' tabindex='-2' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' >
							    <div class='modal-dialog'>
							        <div class='modal-content '>
							            <div class='modal-header bg-color-blue'>
							                <h4 class='modal-title2 text-white-title text-center'>".$mensaje->titulo."</h4>
							            </div>
							            <div class='modal-body' style='text-align: justify;'>
								            <div class='row' >
									            <div class='col-md-12' >
									           		".$mensaje->mensaje."
									            </div>
									        </div>
							            </div>
							            <div class='modal-footer'>
							                <center>
							                    <button id='button_close_modal' type='button' class='btn btn-default' data-dismiss='modal' >Cerrar</button>
							                </center>
							            </div>
							        </div>
							    </div>
							</div>
							"; 

							$html_mensajes.=$template_mensaje;
						break;

						case 1: // SOLO ACTIVOS

							$template_mensaje = "
								<center>
									<div id='mensaje_control_escolar' class='row' style='width: 95%;'>
										<div class='alert alert-warning' role='alert' style='background-color: #fafafa; border-radius: 16px; border-color: #e7e7e7'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
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
									<div id='mensaje_control_escolar' class='row' style='width: 95%;'>
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
										<div id='mensaje_control_escolar' class='row' style='width: 95%;'>
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
									<div id='mensaje_control_escolar' class='row' style=' width: 95%;'>
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

						default: // NONE
						break;
					}

					if($mensaje->tipo==$id_estado_alumno){
						$html_mensajes.=$template_mensaje;
					}


				}
				 $conexion->close();
			}

			return $html_mensajes;

	}


}

?>