<?php
session_start();
require_once "config.php";
require_once "funciones.php";

$opcion = $_REQUEST['a']; 
switch ($opcion)
{
	case 'listadoTicketsAdministrador':
		getListadoTicketsAdministrador();
		break;

	case 'getAsignarTicketAdministrador':
		getAsignarTicketAdministrador();
		break;

	case 'administradorTicketAsesor':
		administradorTicketAsesor();
		break;

	case 'asignarTicketDepartamento':
		asignarTicketDepartamento();
		break;

	case 'listadoTicketsEncargado':
		listadoTicketsEncargado();
		break;

	case 'getAsignarTicketEncargado':
		getAsignarTicketEncargado();
		break;

	case 'asignarTicketAsesor':
		asignarTicketAsesor();
		break;

	case 'listadoTicketsAsesor':
		listadoTicketsAsesor();
		break;

	case 'getDetalleTicketAsesor':
		getDetalleTicketAsesor();
		break;

	case 'guardarEditarTicketAsesor':
		guardarEditarTicketAsesor();
		break;

	case 'finalizarTicketAsesor':
		finalizarTicketAsesor();
		break;

	case 'cancelarTicketAsesor':
		cancelarTicketAsesor();
		break;

	case 'threadNotificacionesAyuda':
		threadNotificacionesAyuda();
		break;

	case 'eliminarTicketAsesor':
		eliminarTicketAsesor();
		break;

	case 'procesosTicketAsesor':
		procesosTicketAsesor();
		break;
}

//LISTADO ADMINISTRADOR
function getListadoTicketsAdministrador()
{
	$resultado = new stdClass();
	$resultado->data = new stdClass();
	$resultado->data->registros = [];
	$resultado->success = true;
	$resultado->errorTitle = 'Error al obtener las solicitudes';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "call escolar.sp_listado_ayuda_ticket(NULL, NULL, NULL, " . $_SESSION['id_area']  . 
				", " .  $_REQUEST['nuPage'] . ", " .  $_REQUEST['nuRowsPage'] . ", 3);";

			$registros = $mysql->Query($query);			

			if ($registros) 
			{
				$resultado->data->nuTotalRows = mysql_fetch_array($registros)["nuTotalRows"];
				mysql_data_seek($registros, 0);

				while($row = mysql_fetch_array($registros))
				{
					$item = new stdClass();
					$item->id_titulo = $row['id_titulo'];
					$item->de_titulo = $row['de_titulo'];
					$item->id_alumno = $row['id_alumno'];
					$item->id_plan_estudio = $row['id_plan_estudio'];
					$item->nb_plan_estudio = $row['nb_plan_estudio'];
					$item->nu_prioridad = $row['nu_prioridad'];
					$item->cl_estatus = $row['cl_estatus'];
					$item->de_estatus = $row['de_estatus'];
					$item->fh_registro = $row['fh_registro'];
					$item->fh_ultima_modificacion = $row['fh_ultima_modificacion'];
					$item->id_departamento = $row['id_departamento'];
					$item->de_departamento = $row['de_departamento'];					
					$item->id_asesor = $row['id_asesor'];
					$item->nb_asesor = $row['nb_asesor'];
					$item->sn_asignadodepartamento = $row['sn_asignadodepartamento'];
					$item->nb_cliente = $row['nb_cliente'];
					$item->numero_empleado = $row['numero_empleado'];
					$item->nu_telefono = $row['nu_telefono'];
					$item->nuMensajesNuevos = $row['nuMensajesNuevos'];
					/*$item->id_titulo = $row['id_titulo'];
					$item->de_titulo = $row['de_titulo'];
					$item->id_alumno = $row['id_alumno'];
					$item->id_plan_estudio = $row['id_plan_estudio'];
					$item->nb_plan_estudio = $row['nb_plan_estudio'];
					$item->nu_prioridad = $row['nu_prioridad'];
					$item->cl_estatus = $row['cl_estatus'];
					$item->de_estatus = $row['de_estatus'];
					$item->fh_registro = $row['fh_registro'];
					$item->fh_ultima_modificacion = $row['fh_ultima_modificacion'];
					$item->id_departamento = $row['id_departamento'];
					$item->de_departamento = $row['de_departamento'];					
					$item->id_asesor = $row['id_asesor'];
					$item->nb_asesor = $row['nb_asesor'];
					$item->sn_asignadodepartamento = $row['sn_asignadodepartamento'];
					$item->nuMensajesNuevos = $row['nuMensajesNuevos'];*/
					array_push($resultado->data->registros, $item);
				}
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//EL ADMINISTRADOR OBTIENE LA INFORMACION NECESARIA PARA ASIGNAR TICKET A DEPARTAMENTO O ASESOR 
function getAsignarTicketAdministrador()
{
	$resultado = new stdClass();	
	$resultado->success = true;
	$resultado->errorTitle = 'Error al obtener la información';
	$resultado->data = new stdClass();
	$resultado->data->departamentos = [];
	$resultado->data->asesores = [];
	$resultado->data->mensajes = [];

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "SELECT id, descripcion AS area FROM escolar.tb_usuarios_areas WHERE sn_ayuda = 1 AND UPPER(estatus) = 'A' ORDER BY descripcion ASC";

			$registros = $mysql->Query($query);			
			if ($registros) 
			{
				while($row = mysql_fetch_array($registros))
				{
					$item = new stdClass();
					$item->id_departamento = $row['id'];
					$item->nb_departamento = $row['area'];
					array_push($resultado->data->departamentos, $item);
				}

				$query = "
					SELECT 
						usx.id_area, 
						arp.id_asesor, 
						CONCAT(pxx.nombre, ' ', pxx.apellido1, ' ', COALESCE(pxx.apellido2, '')) AS nb_asesor 
					FROM 
						escolar.tb_ayuda_rolespersonas arp
						INNER JOIN escolar.tb_personas pxx ON pxx.id = arp.id_asesor 
						INNER JOIN escolar.tb_usuarios usx ON usx.id_persona = pxx.id 
					WHERE 
						arp.id_tiporol = 3 
						AND UPPER(usx.estatus) = 'A' 
					ORDER BY 
						nb_asesor
				";

				$registrosAsesores = $mysql->Query($query);			
				if ($registros) 
				{
					while($rowAsesores = mysql_fetch_array($registrosAsesores))
					{
						$item = new stdClass();
						$item->id_area = $rowAsesores['id_area'];
						$item->id_asesor = $rowAsesores['id_asesor'];
						$item->nb_asesor = $rowAsesores['nb_asesor'];
						array_push($resultado->data->asesores, $item);
					}
				}

				$query = "call escolar.sp_listado_ayuda_ticket(NULL, NULL, " . $_REQUEST['id_titulo']. ", NULL, NULL, NULL, 6);";

				$registros = $mysql->Query($query);			
				if ($registros) 
				{
					while($row = mysql_fetch_array($registros))
					{
						$item = new stdClass();
						$item->de_mensaje = $row['de_mensaje'];
						$item->hr_mensaje = $row['hr_mensaje'];
						$item->id_persona = $row['id_persona'];
						$item->nb_alumno = $row['nb_alumno'];
						$item->sn_automatico = $row['sn_automatico'];
						$item->sn_notificacion = $row['sn_notificacion'];					
						array_push($resultado->data->mensajes, $item);
					}
				}
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//EL ADMINISTRADOR ASIGNA EL TICKET AL DEPARTAMENTO O ASESOR
function asignarTicketDepartamento()
{
	$idAsesor = isset($_REQUEST['id_asesor']) ? $_REQUEST['id_asesor'] : 'NULL';
	$idDepartamento = isset($_REQUEST['id_departamento']) ? $_REQUEST['id_departamento'] : 'NULL';

	$resultado = new stdClass();
	$resultado->success = true;
	$resultado->errorTitle = 'Error al asignar la solicitud';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			//mysqli_set_charset($conexion,'utf8');

			$query = "CALL escolar.sp_add_ayuda_ticket(" . $idAsesor . " , " . $idDepartamento . " , ". 
				$_REQUEST['id_titulo'] . ", NULL, NULL, NULL, NULL, NULL, NULL, 'M', 2);";

			$registros = $mysql->Query($query);		

			if ($registros === false) 	
			{
				$resultado->success = false;
				$resultado->errorMensaje = "Favor de contactar al area de sistemas";
				$resultado->errorSQL = $mysql->getError();
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//LISTADO ENCARGADO
function listadoTicketsEncargado()
{
	$resultado = new stdClass();
	$resultado->data = new stdClass();
	$resultado->data->registros = [];
	$resultado->success = true;
	$resultado->errorTitle = 'Error al obtener las solicitudes';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "call escolar.sp_listado_ayuda_ticket(NULL, NULL, NULL, " . $_SESSION['id_area']  . 
				", " .  $_REQUEST['nuPage'] . ", " .  $_REQUEST['nuRowsPage'] . ", 4);";

			$registros = $mysql->Query($query);			

			if ($registros) 
			{
				$resultado->data->nuTotalRows = mysql_fetch_array($registros)["nuTotalRows"];

				mysql_data_seek($registros, 0);

				while($row = mysql_fetch_array($registros))
				{
					$item = new stdClass();
					$item->id_titulo = $row['id_titulo'];
					$item->de_titulo = $row['de_titulo'];
					$item->id_alumno = $row['id_alumno'];
					$item->id_plan_estudio = $row['id_plan_estudio'];
					$item->nb_plan_estudio = $row['nb_plan_estudio'];
					$item->nu_prioridad = $row['nu_prioridad'];
					$item->cl_estatus = $row['cl_estatus'];
					$item->de_estatus = $row['de_estatus'];
					$item->fh_registro = $row['fh_registro'];
					$item->fh_ultima_modificacion = $row['fh_ultima_modificacion'];
					$item->id_departamento = $row['id_departamento'];
					$item->de_departamento = $row['de_departamento'];					
					$item->id_asesor = $row['id_asesor'];
					$item->nb_asesor = $row['nb_asesor'];
					$item->sn_asignadodepartamento = $row['sn_asignadodepartamento'];
					$item->nb_cliente = $row['nb_cliente'];
					$item->numero_empleado = $row['numero_empleado'];
					$item->nu_telefono = $row['nu_telefono'];
					$item->nuMensajesNuevos = $row['nuMensajesNuevos'];
					/*$item->id_titulo = $row['id_titulo'];
					$item->de_titulo = $row['de_titulo'];
					$item->id_alumno = $row['id_alumno'];
					$item->id_plan_estudio = $row['id_plan_estudio'];
					$item->nb_plan_estudio = $row['nb_plan_estudio'];
					$item->nu_prioridad = $row['nu_prioridad'];
					$item->cl_estatus = $row['cl_estatus'];
					$item->de_estatus = $row['de_estatus'];
					$item->fh_registro = $row['fh_registro'];
					$item->fh_ultima_modificacion = $row['fh_ultima_modificacion'];
					$item->id_departamento = $row['id_departamento'];
					$item->de_departamento = $row['de_departamento'];					
					$item->id_asesor = $row['id_asesor'];
					$item->nb_asesor = $row['nb_asesor'];
					$item->sn_asignadodepartamento = $row['sn_asignadodepartamento'];
					$item->nuMensajesNuevos = $row['nuMensajesNuevos'];*/
					array_push($resultado->data->registros, $item);
				}
				
				/*while($row = mysql_fetch_array($registros))
				{
					$item = new stdClass();
					$item->id_titulo = $row['id_titulo'];
					$item->de_titulo = $row['de_titulo'];
					$item->id_alumno = $row['id_alumno'];
					$item->id_plan_estudio = $row['id_plan_estudio'];
					$item->nu_prioridad = $row['nu_prioridad'];
					$item->cl_estatus = $row['cl_estatus'];
					$item->de_estatus = $row['de_estatus'];
					$item->fh_registro = $row['fh_registro'];
					$item->fh_ultima_modificacion = $row['fh_ultima_modificacion'];
					$item->id_departamento = $row['id_departamento'];
					$item->de_departamento = $row['de_departamento'];					
					$item->id_asesor = $row['id_asesor'];
					$item->nb_asesor = $row['nb_asesor'];
					$item->sn_asignadodepartamento = $row['sn_asignadodepartamento'];
					$item->nuMensajesNuevos = $row['nuMensajesNuevos'];
					array_push($resultado->data, $item);
				}*/
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//EL ENCARGADO OBTIENE LA INFORMACION NECESARIA PARA ASIGNAR TICKET A UN ASESOR 
function getAsignarTicketEncargado()
{
	$resultado = new stdClass();	
	$resultado->success = true;
	$resultado->errorTitle = 'Error al obtener la información';
	$resultado->data = new stdClass();
	//$resultado->data->departamentos = [];
	$resultado->data->asesores = [];
	$resultado->data->mensajes = [];

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{	
			$query = "SELECT arp.id_asesor, CONCAT(pxx.nombre, ' ', pxx.apellido1, ' ', COALESCE(pxx.apellido2, '')) AS nb_asesor 
				FROM escolar.tb_ayuda_rolespersonas arp
				INNER JOIN escolar.tb_personas pxx ON pxx.id = arp.id_asesor 
				INNER JOIN escolar.tb_usuarios usx ON usx.id_persona = arp.id_asesor 
				WHERE arp.id_tiporol = 3 AND UPPER(usx.estatus) = 'A' AND usx.id_area = " . $_REQUEST["id_departamento"];

			$registrosAsesores = $mysql->Query($query);			
			if ($registrosAsesores) 
			{
				while($rowAsesores = mysql_fetch_array($registrosAsesores))
				{
					$item = new stdClass();
					$item->id_asesor = $rowAsesores['id_asesor'];
					$item->nb_asesor = $rowAsesores['nb_asesor'];
					array_push($resultado->data->asesores, $item);
				}

				$query = "call escolar.sp_listado_ayuda_ticket(NULL, NULL, " . $_REQUEST['id_titulo']. ", NULL, NULL, NULL, 6);";

				$registros = $mysql->Query($query);			
				if ($registros) 
				{
					while($row = mysql_fetch_array($registros))
					{
						$item = new stdClass();
						$item->de_mensaje = $row['de_mensaje'];
						$item->hr_mensaje = $row['hr_mensaje'];
						$item->id_persona = $row['id_persona'];
						$item->nb_alumno = $row['nb_alumno'];
						$item->sn_automatico = $row['sn_automatico'];
						$item->sn_notificacion = $row['sn_notificacion'];					
						array_push($resultado->data->mensajes, $item);
					}
				}
			}

			/*$query = "SELECT id, descripcion AS area FROM escolar.tb_usuarios_areas WHERE sn_ayuda = 1 AND UPPER(estatus) = 'A' ORDER BY descripcion ASC";

			$registros = $mysql->Query($query);			
			if ($registros) 
			{
				while($row = mysql_fetch_array($registros))
				{
					$item = new stdClass();
					$item->id_departamento = $row['id'];
					$item->nb_departamento = $row['area'];
					array_push($resultado->data->departamentos, $item);
				}

				$query = "SELECT arp.id_asesor, CONCAT(pxx.nombre, ' ', pxx.apellido1, ' ', COALESCE(pxx.apellido2, '')) AS nb_asesor 
					FROM escolar.tb_ayuda_rolespersonas arp
					INNER JOIN escolar.tb_personas pxx ON pxx.id = arp.id_asesor
					WHERE arp.id_tiporol = 3";

				$registrosAsesores = $mysql->Query($query);			
				if ($registrosAsesores) 
				{
					while($rowAsesores = mysql_fetch_array($registrosAsesores))
					{
						$item = new stdClass();
						$item->id_asesor = $rowAsesores['id_asesor'];
						$item->nb_asesor = $rowAsesores['nb_asesor'];
						array_push($resultado->data->asesores, $item);
					}
				}
			}*/
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//EL ENCARGADO ASIGNA EL TICKET AL ADMINISTRADOR
function administradorTicketAsesor()
{
	$resultado = new stdClass();
	$resultado->success = true;
	$resultado->errorTitle = 'Error al asignar la solicitud';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			//mysqli_set_charset($conexion,'utf8');

			$query = "CALL escolar.sp_add_ayuda_ticket(NULL, NULL, ". $_REQUEST['id_titulo'] . ", NULL, NULL, 
				NULL, NULL, NULL, NULL, 'M', 7);";
						
			$registros = $mysql->Query($query);		

			if ($registros === false) 	
			{
				$resultado->success = false;
				$resultado->errorMensaje = "Favor de contactar al area de sistemas";
				$resultado->errorSQL = $mysql->getError();
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//EL ENCARGADO ASIGNA EL TICKET A UN ASESOR
function asignarTicketAsesor()
{
	$resultado = new stdClass();
	$resultado->success = true;
	$resultado->errorTitle = 'Error al asignar la solicitud';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			//mysqli_set_charset($conexion,'utf8');

			$query = "CALL escolar.sp_add_ayuda_ticket(" . $_REQUEST['id_asesor'] . " , " . $_REQUEST['id_departamento'] . 
				" , ". $_REQUEST['id_titulo'] . ", NULL, NULL, NULL, NULL, NULL, NULL, 'M', 3);";
						
			$registros = $mysql->Query($query);		

			if ($registros === false) 	
			{
				$resultado->success = false;
				$resultado->errorMensaje = "Favor de contactar al area de sistemas";
				$resultado->errorSQL = $mysql->getError();
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//LISTADO ASESOR
function listadoTicketsAsesor()
{
	$resultado = new stdClass();
	$resultado->data->registros = [];
	$resultado->success = true;
	$resultado->errorTitle = 'Error al obtener las solicitudes';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "call escolar.sp_listado_ayuda_ticket(NULL, " . $_SESSION['id_persona'] . ", NULL, " . 
				$_SESSION['id_area']  . ", " .  $_REQUEST['nuPage'] . ", " .  $_REQUEST['nuRowsPage'] . ", 5);";

			$registros = $mysql->Query($query);			

			if ($registros) 
			{
				$resultado->data->nuTotalRows = mysql_fetch_array($registros)["nuTotalRows"];
				mysql_data_seek($registros, 0);

				while($row = mysql_fetch_array($registros))
				{
					$item = new stdClass();
					$item->id_titulo = $row['id_titulo'];
					$item->de_titulo = $row['de_titulo'];
					$item->id_alumno = $row['id_alumno'];
					$item->id_plan_estudio = $row['id_plan_estudio'];
					$item->nb_plan_estudio = $row['nb_plan_estudio'];
					$item->nu_prioridad = $row['nu_prioridad'];
					$item->cl_estatus = $row['cl_estatus'];
					$item->de_estatus = $row['de_estatus'];
					$item->fh_registro = $row['fh_registro'];
					$item->fh_ultima_modificacion = $row['fh_ultima_modificacion'];
					$item->id_departamento = $row['id_departamento'];
					$item->de_departamento = $row['de_departamento'];					
					$item->id_asesor = $row['id_asesor'];
					$item->nb_asesor = $row['nb_asesor'];
					$item->sn_asignadodepartamento = $row['sn_asignadodepartamento'];
					$item->nb_cliente = $row['nb_cliente'];
					$item->numero_empleado = $row['numero_empleado'];
					$item->nu_telefono = $row['nu_telefono'];
					$item->nuMensajesNuevos = $row['nuMensajesNuevos'];
					array_push($resultado->data->registros, $item);
				}
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//DETALLE TICKET ASESOR
function getDetalleTicketAsesor()
{
	$resultado = new stdClass();
	$resultado->data = [];
	$resultado->success = true;
	$resultado->errorTitle = 'Error al obtener el detalle';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "call escolar.sp_listado_ayuda_ticket(NULL, NULL, " . $_REQUEST['id_titulo']. ", NULL, NULL, NULL, 6);";

			$registros = $mysql->Query($query);			
			if ($registros) 
			{
				while($row = mysql_fetch_array($registros))
				{
					$item = new stdClass();
					$item->de_mensaje = $row['de_mensaje'];
					$item->hr_mensaje = $row['hr_mensaje'];
					$item->id_persona = $row['id_persona'];
					$item->nb_alumno = $row['nb_alumno'];
					$item->sn_automatico = $row['sn_automatico'];
					$item->sn_notificacion = $row['sn_notificacion'];					
					array_push($resultado->data, $item);
				}
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//ASESOR MANDA MENSAJE
function guardarEditarTicketAsesor()
{
	$resultado = new stdClass();
	$resultado->data = [];
	$resultado->success = true;
	$resultado->errorTitle = 'Error al enviar el mensaje';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "CALL escolar.sp_add_ayuda_ticket(" . $_SESSION['id_persona'] . ", NULL, ". 
				$_REQUEST['id_titulo'] . ", NULL, NULL, NULL, NULL, NULL, '" . $_REQUEST['de_mensaje'] . "', 'M', 4);";

			$registros = $mysql->Query($query);			
			if ($registros === false) 	
			{
				$resultado->success = false;
				$resultado->errorMensaje = "Favor de contactar al area de sistemas";
				$resultado->errorSQL = $mysql->getError();
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//ASESOR FINALIZA TICKET
function finalizarTicketAsesor()
{
	$resultado = new stdClass();
	$resultado->success = true;
	$resultado->errorTitle = 'Error al finalizar la solicitud';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "CALL escolar.sp_add_ayuda_ticket(" . $_SESSION['id_persona'] . ", NULL, ". 
				$_REQUEST['id_titulo'] . ", NULL, NULL, NULL, NULL, NULL, NULL, 'M', 5);";

			$registros = $mysql->Query($query);			
			if ($registros === false) 	
			{
				$resultado->success = false;
				$resultado->errorMensaje = "Favor de contactar al area de sistemas";
				$resultado->errorSQL = $mysql->getError();
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

function procesosTicketAsesor()
{
	$resultado = new stdClass();
	$resultado->success = true;
	$resultado->errorTitle = 'Error al finalizar la solicitud';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "CALL escolar.sp_add_ayuda_ticket(" . $_SESSION['id_persona'] . ", NULL, ". 
				$_REQUEST['id_titulo'] . ", NULL, NULL, NULL, NULL, NULL, NULL, 'M', 8);";

			$registros = $mysql->Query($query);			
			if ($registros === false) 	
			{
				$resultado->success = false;
				$resultado->errorMensaje = "Favor de contactar al area de sistemas";
				$resultado->errorSQL = $mysql->getError();
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

//ASESOR CANCELA TICKET
function cancelarTicketAsesor()
{
	$query = "CALL escolar.sp_add_ayuda_ticket(" . $_SESSION['id_persona'] . ", NULL, ". 
				$_REQUEST['id_titulo'] . ", NULL, NULL, NULL, NULL, NULL, NULL, 'M', 6);";

	$resultado = new stdClass();
	$resultado->success = true;
	$resultado->errorTitle = 'Error al cancelar la solicitud';

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "CALL escolar.sp_add_ayuda_ticket(" . $_SESSION['id_persona'] . ", NULL, ". 
				$_REQUEST['id_titulo'] . ", NULL, NULL, NULL, NULL, NULL, NULL, 'M', 6);";

			$registros = $mysql->Query($query);			
			if ($registros === false) 	
			{
				$resultado->success = false;
				$resultado->errorMensaje = "Favor de contactar al area de sistemas";
				$resultado->errorSQL = $mysql->getError();
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = $mysql->getError();
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

function threadNotificacionesAyuda()
{
	$resultado = new stdClass();
	$resultado->data = new stdClass();
	$resultado->data->Mensajes = [];
	$resultado->data->Pendientes = [];
	$resultado->success = true;

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "call escolar.sp_listado_ayuda_ticket(NULL, " . $_SESSION['id_persona']. ", NULL, " . $_SESSION['id_area']  . ", NULL, NULL, 7);";
			$registros = $mysql->Query($query);
			if ($registros) 
			{
				$row = mysql_fetch_array($registros);		
				$item = new stdClass();
				$item->nuMensajesNuevos = $row['nuMensajesNuevos'];
				array_push($resultado->data->Mensajes, $item);
			}
			$mysql->Cerrar();

			if($mysql->Connectar())
			{
				$query = "call escolar.sp_listado_ayuda_ticket(NULL, " . $_SESSION['id_persona']. ", NULL, " . $_SESSION['id_area']  . ", NULL, NULL, 9);";
				$registros2 = $mysql->Query($query);
				if ($registros2) 
				{
					$row = mysql_fetch_array($registros2);
					$item = new stdClass();
					$item->nuTotalVigentes = $row['nuTotalVigentes'];
					$item->nuTotalVencidos = $row['nuTotalVencidos'];				
					array_push($resultado->data->Pendientes, $item);
				}
			}
			else
			{
				$resultado->success = false;
				$resultado->errorMsje = 'Favor de contactar al area de soporte';
				$resultado->errorSQL = 'No se pudo conectar a la base de datos';
			}			
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = 'No se pudo conectar a la base de datos';
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

function eliminarTicketAsesor()
{
	$resultado = new stdClass();
	$resultado->data = [];
	$resultado->success = true;

	$mysql= new Connect();

	try
	{
		if($mysql->Connectar())
		{
			$query = "CALL escolar.sp_add_ayuda_ticket(NULL, NULL, ". $_REQUEST['id_titulo'] . ", NULL, NULL, 
				NULL, NULL, NULL, NULL, 'E', 1);";

			$registros = $mysql->Query($query);		

			if ($registros === false) 	
			{
				$resultado->success = false;
				$resultado->errorMensaje = "Favor de contactar al area de sistemas";
				$resultado->errorSQL = $mysql->getError();
			}
		}
		else
		{
			$resultado->success = false;
			$resultado->errorMsje = 'Favor de contactar al area de soporte';
			$resultado->errorSQL = 'No se pudo conectar a la base de datos';
		}		
	}
	catch(Exception $e)
	{
		$resultado->success = false;
		$resultado->errorMsje = 'Favor de contactar al area de soporte';
		$resultado->errorSQL = $e->getMessage();
	}

	$mysql->Cerrar();
	echo json_encode($resultado);
}

?>