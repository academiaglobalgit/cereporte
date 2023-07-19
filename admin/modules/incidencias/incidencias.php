<?php
include_once("includes/checklogin.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<title> Reportes de Incidencias </title>
	<meta name="description" content="Sistema AG de Incidencias"/>
	<?php
	   include_once("includes/assets.php"); // INCLUDE ASSETS
	?>

  </head>
  <body>

	<div id="wrapper" class="">
	  
	<!-- MODULO DE INCIDENCIAS -->
	<!-- INCLUDE MENU -->

	<?php
	   include_once("includes/menu.php");
	?>
		  
	  <!-- Page content -->
	  <div id="page-content-wrapper">
		<!-- Keep all page content within the page-content inset div! -->
		<div class="page-content inset">
			<div class="row"><!--TITULO DE MODULO-->
				<div class="col-md-12">
					<p><h1>Reportes de Incidencias</h1></p>
					<ol class="breadcrumb">
					  <li><a href="index.php">Inicio</a></li>
					  <li class="active">Reportes de Incidencias</li>
					</ol>
				</div>
			</div>	
			<div class="row"><!--BOTON CREAR-->
				<div class="col-md-12">
 			   		<p><button class="btn btn-primary" data-toggle="modal" data-target="#modal_i_crear" type="button" ><span class=" glyphicon glyphicon-plus"></span> Registrar nuevo reporte de incidencia</button>
 			   		</p>
 			   	</div>
			</div>

		  	<div class="row"> <!--lISTADO -->
			  <div class="col-md-12">
		   		<div class="panel panel-default">
				  <div class="panel-heading">
					 <h3 class="panel-title"><span class=" glyphicon glyphicon-list"></span> Listado de Incidencias <!-- <button class="btn btn-default btn_menu_filtros"  type="button" >Filtros Avanzados<span class=" glyphicon glyphicon-filter"></span></button> --> </h3>
				   
				  </div>
				  <div class="panel-body">
					<div class="row"><!--BOTON FILTROS-->
						<div class="col-md-12">
							<form id="form_i_search" class="form-inline" name="form_i_search" >
								<div class="row">
									<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3' style='padding:5px;'>
										<div class="input-group" >
											<span class="input-group-addon" id="basic-addon1">Número de incidencia</span>
											<input type="text" id="form_i_search_id_ticket" value="" name="form_i_search_id_ticket" class="input-form_i_search form-control" error="Ingrese un número de incidencia" placeholder="12937" >
										</div>
									</div>
									<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3' style='padding:5px;'>
										<div class="input-group" >
											<span class="input-group-addon" id="basic-addon1">Categoria</span>
											<select type="number" id="form_i_search_categoria" name="form_i_search_categoria" class="input-form_i_search form-control" error="Selecciona una categoria" placeholder="Categoria" >
											</select>
										</div>
									</div>
									<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3' style='padding:5px;'>
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1">Área</span>
											<select type="number" id="form_i_search_area" name="form_i_search_area" class="input-form_i_search form-control" error="Selecciona un área" placeholder="Área" >
											</select>
										</div>
									</div>
									<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3' style='padding:5px;'>
										<div class="input-group" >
											<span class="input-group-addon" id="basic-addon1">Estatus</span>
											<select type="number" id="form_i_search_estatus" name="form_i_search_estatus" class="input-form_i_search form-control" error="Selecciona una esatatus" placeholder="estado" >
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3' style='padding:5px;'>
										<div class="input-group" >
											<span class="input-group-addon" id="basic-addon1">Año</span>
											<select type="number" id="form_i_search_year" name="form_i_search_year" class="input-form_i_search form-control" error="Selecciona un año" placeholder="Año">
												<option value="" selected> Seleccione un año </option>
												<option value="2016"> 2016 </option>
											</select>
										</div>
									</div>
									<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3' style='padding:5px;'>
										<div class="input-group" >
											<span class="input-group-addon" id="basic-addon1">Mes</span>
											<select type="number" id="form_i_search_month" name="form_i_search_month" class="input-form_i_search form-control" error="Selecciona un mes" placeholder="Mes">
												<option value="" selected> Seleccione una opción </option>
												<option value="1"> Enero </option>
												<option value="2"> Febrero </option>
												<option value="3"> Marzo </option>
												<option value="4"> Abril </option>
												<option value="5"> Mayo </option>
												<option value="6"> Junio </option>
												<option value="7"> Julio </option>
												<option value="8"> Agosto </option>
												<option value="9"> Septiembre </option>
												<option value="10"> Octubre </option>
												<option value="11"> Noviembre </option>
												<option value="12"> Diciembre </option>
											</select>
										</div>
									</div>
									<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4' style='padding:5px; vertical-align: middle;'>
										<div class="input-group" >
											<button id="btn_form_i_search" class="btn btn-default btn-sm" type="button"> Buscar </button>
										</div>	
									</div>
								</div>
						 	</form>		 		  
		 			   	</div>
					</div>

				  	<div class="row table-responsive">
				  		<table class="table">
							<thead>
								<tr>
									<th> <center> Número de Reporte </center> </th>
									<th> Persona que Reporto </th>
									<th> Problematica </th>
									<th> <center> Estatus </center> </th>
									<th> Persona que Registro </th>
									<th> <center> Fecha de Registro </center> </th>
									<th> </th>
								</tr>
							</thead>
							<tbody id="tabla_incidencias">
							</tbody>
							<tfooter>
								<tr>
									<th> <center> Número de Reporte </center> </th>
									<th> Persona que Reporto </th>
									<th> Problematica </th>
									<th> <center> Estatus </center> </th>
									<th> Persona que Registro </th>
									<th> <center> Fecha de Registro </center> </th>
									<th> </th>
								</tr>
							</tfooter>
						</table>

				  	</div>
				  </div>
				</div>
			</div>




		  </div><!--CONTENIDO -->
		</div>
	  </div>
	  
	</div>


			<!--NODAL CREAR-->
			<div class="modal fade" id="modal_i_crear"  tabindex="-1" role="dialog">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Registrar nuevo reporte de incidencia</h4>
				  </div>
				  <div class="modal-body">
					  <div class="row">
					  	<div class="form-group" >
							Tipo de incidencia:
							<select type="number" id="form_i_crear_tipo_incidencia" name="form_i_crear_tipo_incidencia" class="input-form_i_crear form-control" error="Selecciona una opción" placeholder="EXTERNA/INTERNA" required>
								<option value="" selected>Selecciona el tipo de incidencia</option>
								<option value="1" > Externa </option>
								<option value="2" > Interna </option>
							</select>
						</div>
						<div class="form-group">
							<form id="form_i_crear_externa" name="form_i_crear_externa" style="display: none;">
								<input id="form_i_crear_externa_tipo_incidencia" name="form_i_crear_tipo_incidencia" class="input-form_i_crear form-control" type="hidden" value="1">
								<div class="form-group">
									Plan de estudios del alumno:
									<select type="number" id="form_i_crear_id_plan_estudios_externa" name="form_i_crear_id_plan_estudios" class="input-form_i_crear form-control" error="Selecciona una opción" placeholder="Selecciona el plan de estudios del alumno" required>
									</select>
								</div>
								<div class="form-group">
									Número de empleado:
									<input type="text" id="form_i_crear_numero_empleado_externa" name="form_i_crear_numero_empleado" class="input-form_i_crear form-control" error="Número de empleado" placeholder="Número de empleado">
								</div>
								<div class="form-group">
									Nombre del alumno:
									<input type="hidden" id="form_i_crear_idpersona_externa" name="form_i_crear_idpersona" class="input-form_i_crear form-control">
									<input type="text" id="form_i_crear_nombre_alumno_externa" name="form_i_crear_nombre_alumno" class="input-form_i_crear form-control" error="Nombre del alumno" placeholder="Nombre del alumno" readonly>
								</div>
								<div class="form-group">
									Categoria:
									<select type="number" id="form_i_crear_id_categoria_externa" name="form_i_crear_id_categoria" class="input-form_i_crear form-control" error="Selecciona una opción" placeholder="Selecciona la categoria del problema" required>
									</select>
								</div>
								<div class="form-group" >
									Problematica:
									<select type="number" id="form_i_crear_problematica_externa" name="form_i_crear_problematica" class="input-form_i_crear form-control" error="Selecciona una problematica" placeholder="Problematica" required>
									</select>
								</div>
								<div class="form-group" >
									Comentarios:
									<textarea type="text" id="form_i_crear_comentarios_externa" name="form_i_crear_comentarios" class="input-form_i_crear form-control" error="Ingrese un comentario" placeholder="Ingrese un comentario" ></textarea>
								</div>
								<div class="form-group">
									Correo electrónico:
									<input type="text" id="form_i_crear_correo_externa" name="form_i_crear_correo" class="input-form_i_crear form-control" error="Correo Electrónico" placeholder="sistemas1@agcollege.edu.mx">
								</div>
								<div class="form-group">
									Número telefonico:
									<input type="text" id="form_i_crear_numero_telefonico_externa" name="form_i_crear_numero_telefonico" class="input-form_i_crear form-control" error="Número telefonico" placeholder="6671985149">
								</div>
						 	</form>
						</div>
						<div class="form-group">
							<form id="form_i_crear_interna" name="form_i_crear_interna" style="display: none;">
								<input id="form_i_crear_interna_tipo_incidencia" name="form_i_crear_tipo_incidencia" class="input-form_i_crear form-control" type="hidden" value="2">
								<div class="form-group">
									Categoria:
									<select type="number" id="form_i_crear_id_categoria_interna" name="form_i_crear_id_categoria" class="input-form_i_crear form-control" error="Selecciona una opción" placeholder="Selecciona la categoria del problema" required>
									</select>
								</div>
								<div class="form-group" >
									Problematica:
									<select type="number" id="form_i_crear_problematica_interna" name="form_i_crear_problematica" class="input-form_i_crear form-control" error="Selecciona una problematica" placeholder="Problematica" required>
									</select>
								</div>
								<div class="form-group" >
									Comentarios:
									<textarea type="text" id="form_i_crear_comentarios_interna" name="form_i_crear_comentarios" class="input-form_i_crear form-control" error="Ingrese un comentario" placeholder="Ingrese un comentario"></textarea> 
								</div>
								<div class="form-group">
									Correo electrónico:
									<input type="text" id="form_i_crear_correo_interna" name="form_i_crear_correo" class="input-form_i_crear form-control" error="Correo Electrónico" placeholder="sistemas1@agcollege.edu.mx">
								</div>
								<div class="form-group">
									Número telefonico:
									<input type="text" id="form_i_crear_numero_telefonico_interna" name="form_i_crear_numero_telefonico" class="input-form_i_crear form-control" error="Número telefonico" placeholder="6671985149">
								</div>
								<div class="form-group">
									Fecha limite para cumplir:
									<input type="text" id="form_i_crear_fecha_terminacion_interna" name="form_i_crear_fecha_terminacion" class="input-form_i_crear form-control" error="Selecciona una fecha" placeholder="Selecciona una fecha" readonly>
								</div>
						 	</form>
						</div>
					  </div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-success" id="btn_form_i_registrar"> <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar</button>
				  </div>
				</div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->



	<!--NODAL EDITAR-->
			<div class="modal fade" id="modal_i_editar"  tabindex="-1" role="dialog">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Registrar nuevo reporte de incidencia</h4>
				  </div>
				  <div class="modal-body">
					  <div class="row">
					  	<div class="form-group" >
							Tipo de incidencia:
							<select type="number" id="form_i_editar_tipo_incidencia" name="form_i_editar_tipo" class="form-control" error="Selecciona una opción"  disabled>
								<option value="1" > Externa </option>
								<option value="2" > Interna </option>
							</select>
						</div>
						<div class="form-group">
							<form id="form_i_editar_externa" name="form_i_editar_externa" style="display: none;">

							<input id="form_i_editar_id_incidencia_externa" name="form_i_editar_id_incidencia" class="input-form_i_editar_externa form-control" type="hidden" value="0">

								<input id="form_i_editar_externa_tipo_incidencia" name="form_i_editar_tipo_incidencia" class="input-form_i_editar_externa form-control" type="hidden" value="1">

								<!--<div class="form-group">
									Plan de estudios del alumno:
									<select type="number" id="form_i_editar_id_plan_estudios_externa" name="form_i_editar_id_plan_estudios" class="input-form_i_editar_externa form-control" error="Selecciona una opción" placeholder="Selecciona el plan de estudios del alumno" required>
									</select>
								</div> -->
								<!--<div class="form-group">
									Número de empleado:
									<input type="text" id="form_i_editar_numero_empleado_externa" name="form_i_editar_numero_empleado" class="input-form_i_editar_externa form-control" error="Número de empleado" placeholder="Número de empleado">
								</div> -->
								<!--<div class="form-group">
									Nombre del alumno:
									<input type="hidden" id="form_i_editar_idpersona_externa" name="form_i_editar_idpersona" class="input-form_i_editar_externa form-control">
									<input type="text" id="form_i_editar_nombre_alumno_externa" name="form_i_editar_nombre_alumno" class="input-form_i_editar_externa form-control" error="Nombre del alumno" placeholder="Nombre del alumno" readonly>
								</div> -->

								<div class="form-group">
									Usuario que Reporta:
									<input type="text" id="form_i_editar_nombre_reporta_externa" name="form_i_editar_nombre_reporta_externa" class="input-form_i_editar_externa form-control" error="Nombre del alumno" placeholder="Nombre del que reportó" readonly>
								</div>
								<div class="form-group">
									Usuario que Registra:
									<input type="text" id="form_i_editar_nombre_registra_externa" name="form_i_editar_nombre_registra_externa" class="input-form_i_editar_externa form-control" error="Nombre del alumno" placeholder="Nombre del registrante" readonly>
								</div>
								<div class="form-group">
									Usuario que Soluciona:
									<input type="text" id="form_i_editar_nombre_soluciona_externa" name="form_i_editar_nombre_soluciona_externa" class="input-form_i_editar_interna form-control" error="Nombre del alumno" placeholder="Nombre del solucionador" readonly>
								</div>


								<div class="form-group">
									Categoria:
									<select type="number" id="form_i_editar_id_categoria_externa" name="form_i_editar_id_categoria" class="input-form_i_editar_externa form-control" error="Selecciona una opción" required>
									</select>
								</div>
								<div class="form-group" >
									Problematica:
									<select type="number" id="form_i_editar_problematica_externa" name="form_i_editar_problematica" class="input-form_i_editar_externa form-control" error="Selecciona una problematica" placeholder="Problematica" required>
									</select>
								</div>
								<div class="form-group" >
									Comentarios:
									<textarea type="text" id="form_i_editar_comentarios_externa" name="form_i_editar_comentarios" class="input-form_i_editar_externa form-control" error="Ingrese un comentario" placeholder="Ingrese un comentario" ></textarea>
								</div>
								<div class="form-group">
									Correo electrónico:
									<input type="text" id="form_i_editar_correo_externa" name="form_i_editar_correo" class="input-form_i_editar_externa form-control" error="Correo Electrónico" placeholder="sistemas1@agcollege.edu.mx">
								</div>
								<div class="form-group">
									Número telefonico:
									<input type="text" id="form_i_editar_numero_telefonico_externa" name="form_i_editar_numero_telefonico" class="input-form_i_editar_externa form-control" error="Número telefonico" placeholder="6671985149">
								</div>

						 	</form>
						</div>
						<div class="form-group">
							<form id="form_i_editar_interna" name="form_i_editar_interna" style="display: none;">

								<input id="form_i_editar_id_incidencia_interna" name="form_i_editar_id_incidencia" class="input-form_i_editar_interna form-control" type="hidden" value="0">


								<input id="form_i_editar_interna_tipo_incidencia" name="form_i_editar_tipo_incidencia" class="input-form_i_editar_interna form-control" type="hidden" value="2">

								<div class="form-group">
									Usuario que Reporta:
									<input type="text" id="form_i_editar_nombre_reporta_interna" name="form_i_editar_nombre_reporta_interna" class="input-form_i_editar_interna form-control" error="Nombre del alumno" placeholder="Nombre del que reportó" readonly>
								</div>
								<div class="form-group">
									Usuario que Registra:
									<input type="text" id="form_i_editar_nombre_registra_interna" name="form_i_editar_nombre_registra_interna" class="input-form_i_editar_interna form-control" error="Nombre del alumno" placeholder="Nombre del registrante" readonly>
								</div>
								<div class="form-group">
									Usuario que Soluciona:
									<input type="text" id="form_i_editar_nombre_soluciona_interna" name="form_i_editar_nombre_soluciona_interna" class="input-form_i_editar_interna form-control" error="Nombre del alumno" placeholder="Nombre del solucionador" readonly>
								</div>

								<div class="form-group">
									Categoria:
									<select type="number" id="form_i_editar_id_categoria_interna" name="form_i_editar_id_categoria" class="input-form_i_editar_interna form-control" error="Selecciona una opción" placeholder="Selecciona la categoria del problema" required>
									</select>
								</div>
								<div class="form-group" >
									Problematica:
									<select type="number" id="form_i_editar_problematica_interna" name="form_i_editar_problematica" class="input-form_i_editar_interna form-control" error="Selecciona una problematica" placeholder="Problematica" required>
									</select>
								</div>
								<div class="form-group" >
									Comentarios:
									<textarea type="text" id="form_i_editar_comentarios_interna" name="form_i_editar_comentarios" class="input-form_i_editar_interna form-control" error="Ingrese un comentario" placeholder="Ingrese un comentario"></textarea> 
								</div>
								<div class="form-group">
									Correo electrónico:
									<input type="text" id="form_i_editar_correo_interna" name="form_i_editar_correo" class="input-form_i_editar_interna form-control" error="Correo Electrónico" placeholder="sistemas1@agcollege.edu.mx">
								</div>
								<div class="form-group">
									Número telefonico:
									<input type="text" id="form_i_editar_numero_telefonico_interna" name="form_i_editar_numero_telefonico" class="input-form_i_editar_interna form-control" error="Número telefonico" placeholder="6671985149">
								</div>
								<div class="form-group">
									Fecha limite para cumplir:
									<input type="text" id="form_i_editar_fecha_terminacion_interna" name="form_i_crear_fecha_terminacion" class="input-form_i_editar_interna form-control" error="Selecciona una fecha" placeholder="Selecciona una fecha" readonly>
								</div>
						 	</form>
						</div>
					  </div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-success" id="btn_form_i_editar"> <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Guardar Cambios</button>
				  </div>
				</div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<!--ELIMINAR MODAL-->
			<div class="modal fade" id="modal_i_cancelar" tabindex="-1" role="dialog">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">AVISO</h4>
				  </div>
				  <div class="modal-body">
					<p>¿Está Seguro que desea Cancelar la incidencia?</p>
					<form id="form_i_cancelar" name="form_i_cancelar" >
							<input type="hidden" id="form_i_cancelar_id_incidencia" name="id_incidencia" value="0" class="input-form_i_cancelar form-control" required>
	  						<input type="hidden" id="form_i_cancelar_estatus" name="estatus" value="4" class="input-form_i_cancelar form-control" required>
					</form>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-danger" id="btn_form_cancelar_incidencia" >Cancelar la incidencia</button>
				  </div>
				</div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->


			<!--transferir MODAL-->
			<div class="modal fade" id="modal_i_trans" tabindex="-1" role="dialog">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Seleccione el area a la que desea transferir la incidencia</h4>
				  </div>
				  <div class="modal-body">
						<form id="form_i_trans"  name="form_i_trans" >
							<div class="input-group" >
								<span class="input-group-addon" id="basic-addon1">Area a transferir</span>
								<select type="number" id="form_i_trans_area" name="estado" class="input-form_i_trans form-control" error="Selecciona un Area." placeholder="estado" required>
									<option value="" selected>Seleccione un area</option>
									<option value="1" >Area 1</option>
									<option value="2" >Area 2</option>
									<option value="3" >Area 3</option>
								</select>
							</div>
					  	</form>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-info" data-dismiss="modal" >Cambiar de Area</button>
				  </div>
				</div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="modal fade" id="modal_i_terminar" tabindex="-1" role="dialog">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ingrese un comentario antes de marcar como realizada la inicidencia</h4>
				  </div>
				  <div class="modal-body">
						<form id="form_i_terminar"  name="form_i_terminar" >
	  						<div class="form-group" >
	  						<input type="hidden" id="form_i_terminar_id_incidencia" name="id_incidencia" value="0" class="input-form_i_terminar form-control" required>
	  						<input type="hidden" id="form_i_terminar_estatus" name="estatus" value="3" class="input-form_i_terminar form-control" required>
							Comentario:
							<textarea type="text" id="form_i_terminar_comentario" name="comentario" class="input-form_i_terminar form-control" error="Ingrese un comentario." placeholder="Ingrese un comentario dirigido al usuario" ></textarea> 
						</div>
					  	</form>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_form_terminar_incidencia" class="btn btn-success"> Incidencia Realizada</button>
				  </div>
				</div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="modal fade" id="modal_i_proceso" tabindex="-1" role="dialog">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ingrese un comentario antes de poner en proceso la inicidencia</h4>
				  </div>
				  <div class="modal-body">
						<form id="form_i_proceso"  name="form_i_proceso" >
	  						<div class="form-group" >
	  						<input type="hidden" id="form_i_proceso_id_incidencia" name="id_incidencia"  value="0" class="input-form_i_proceso form-control" required>
	  						<input type="hidden" id="form_i_proceso_estatus" name="estatus" value="2" class="input-form_i_proceso form-control" required>

							Comentario:
							<textarea type="text" id="form_i_proceso_comentario" name="comentario" class="input-form_i_proceso form-control" error="Ingrese un comentario." placeholder="Ingrese un comentario dirigido al usuario" ></textarea> 
						</div>
					  	</form>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_form_proceso_incidencia" class="btn btn-info" >Incidencia En Proceso</button>
				  </div>
				</div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
    <?php
       	echo "<script>
			var id_area=".$id_area."; 
			
			var id_permiso=".$id_permiso.";
      	</script>";

       include_once("includes/scripts.php"); // INCLUDE SCRIPTS
   
    ?>

    	<script src="controllers/incidencias.js"></script>


  </body>

</html>