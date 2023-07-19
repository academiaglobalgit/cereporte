<?php 
session_start();
  $id_persona=0;
if(isset($_SESSION['id_persona'])){
  $id_persona=$_SESSION['id_persona'];
}
?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <title>Alumnos</title>
      <meta name="description" content="Registro de Alumnos"/>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Loading Bootstrap -->
      <link  href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link  href="assets/bootstrap/css/bootstrap.min.custom.css" rel="stylesheet">
      <!--<link rel="shortcut icon" href="flatui/img/favicon.ico">-->
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="ckeditor/ckeditor.js"></script>
      <script src="controllers/usuarios.js?n=15"></script>
      <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
        <script src="flatui/dist/js/vendor/html5shiv.js"></script>
        <script src="flatui/dist/js/vendor/respond.min.js"></script>
      <![endif]-->
    </head>
  <body>
  <div id="loading" class="loading col-md-12 text-center" style="display:none; opacity: 0.9; border-radius: 10px; z-index: 99; position:fixed; width:100%;height:100px; top:30%;" ><img src="assets/img/loading.gif" alt="Cargando..."  ></div>
  <div id="loading_dog" class="loading col-md-12 text-center" style="display:none; opacity: 0.9; border-radius: 10px; z-index: 99; position:fixed; width:100%;height:100px; top:0px;" ><img style="width: 100px; height: 400px;" src="assets/img/anydog2.gif" alt="Cargando..."  ></div>
    <div class="container-fluid">
        <div class="row" >
          <div class="col-md-12 col-xs-12" >
              <form class="form-inline alert alert-default" name="form_search"  id="form_search" role="form">
                  <div class="input-group">
                   <span id="dog_count" class="input-group-addon"  for="id_moodle">ID:</span >
                    <input type="text" name="id_moodle" id="id_moodle" size="6" class="form-control input-form_search" value="">
                  </div>
                  <div class="input-group">
                   <span  class="input-group-addon"  for="numero_empleado"># Empelado/Estafeta:</span >
                    <input type="text" name="numero_empleado" size="10" id="numero_empleado" class="form-control input-form_search" value="">
                  </div>
                  <div class="input-group">
                   <span  class="input-group-addon"  for="nombre_completo">Nombre de Alumno:</span >
                    <input type="text" name="nombre_completo" id="nombre_completo" class="form-control input-form_search" value="">
                  </div>
                  <div class="input-group">
                    <span  class="input-group-addon"  for="id_plan_estudio">Plataforma:</span >
                    <select type="number" style="width: 230px;" class="form-control input-form_search" name="id_plan_estudio" id="id_plan_estudio">
                    <option value="2">PrepaCoppel </option>
                    <option value="4">PrepaLey </option>
                    <option value="9">Preparatoria Toks </option>
                    <option value="10">Universidad Toks </option>
                    </select>
                  </div>
                   <div class="input-group">
                    <button class="form-control btn btn-default" type="button" id="btn_form_search">
                       Buscar
                    </button>
                  </div>
              </form>
          </div>
        </div>
        <div class="row" >
          <div class="col-md-12 col-xs-12" >
          </div>
           <br>
        </div>

        <div id="view_usuarios" class="row" >

          <div class="col-md-10 col-md-offset-1 col-xs-12  panel panel-default" >
              <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                      <button class="btn btn-primary" type="button" id="btn_new_usuario" > + Alumno Nuevo</button>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;" >
                  <div class="col-md-12">
                      <div class="list-group" style=" height:350px; overflow-y: auto; ">
                      
                        <div  class="list-group-item active">
                         Resultados de Alumnos <span class="pull-right fui-list-large-thumbnails" ></span>
                        </div>
                          <table class="table" >
                          <thead>
                            <tr>
                                <th>ID MOODLE</th>
                                <th># Empleado/Estafeta </th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>A. Paterno</th>
                                <th>A. Materno</th>
                                <th>Nombre Completo</th>
                                <th>Numero Telefónico</th>
                                <th>Estado</th>

                                <th></th>

                            </tr>
                          </thead>
                          <tbody id="content_usuarios"> <!--Content usuarios-->
   
                              <tr class="text-center" >
                                <td colspan="8"  >Por favor ingresa tu busqueda de usuario</td>
                            </tr>
                          </tbody><!-- CONTENT usuarios -->
                          </table>
                      </div>
                  </div>
                </div>               

              </div>
          </div>

        </div>
          
         <!-- Modal EDITAR FORUM-->
            <!--<div id="modal_usuario_update" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal_title_usuario" >Editar Alumno</h4>
                  </div>
                  <div class="modal-body">
                    <p>Nombre del Alumno</p>
                    <form class="form" id="form_usuario_update" name="form_usuario_update"  >
                      <div class="form-group" >
                          <input type="text" name="nombre" id="f_u_nombre" error="Ingresa el nombre." class="form-control input-form_usuario_update" placeholder="Nombre del alumno"  value="" required> 
                      </div>
                      <p>Apellido paterno</p>

                      <div class="form-group" >
                          <input type="text" name="apellido1" id="f_u_apellido1" error="Ingresa el apellido paterno." class="form-control input-form_usuario_update" placeholder="Apellido paterno"  value="" required> 
                      </div>
                      <p>Apellido materno</p>
                      <div class="form-group" >
                          <input type="text" name="apellido2" id="f_u_apellido2" error="Ingresa el apellido materno." class="form-control input-form_usuario_update" placeholder="Apellido materno"  value="" > 
                      </div>

                        <p>Sexo<small style="color:red; font-size: 24px;">*</small></p>
                        <div class="form-group">
                          <select type="number" style="width: 330px;" class="form-control input-form_usuario_update" name="sexo" id="f_u_sexo"  required>
                            <option value="0">Femenino</option>
                            <option value="1">Masculino</option>
                          </select>
                        </div>

                      <p>Tipo de Alumno</p>
                      <div class="form-group" >
                          <select type="number" name="tipo_alumno" id="f_u_tipo_alumno" error="Selecciona el tipo de alumno." class="form-control input-form_usuario_update" placeholder="Tipo de Alumno"  required> 
                          <option value="1" >No Definido</option>
                           <option value="2" >Colaborador</option>
                            <option value="3" >Familiar</option>
                          </select>
                      </div>

                      <p>Email</p>
                      <div class="form-group" >
                          <input type="text" name="email" id="f_u_email" error="Ingrese el correo de la persona." class="form-control input-form_usuario_update" placeholder="email@agcollege.edu.mx"  value="" required> 
                      </div>

                     <p>Fecha de Nacimiento (AAAA-MM-DD)</p>
                      <div class="form-group" >
                          <input type="text" name="fecha_nacimiento" id="f_u_fecha_nacimiento" error="fecha de nacimiento" class="form-control input-form_usuario_update" placeholder="1990-01-22"  value="" > 
                      </div>

                      <p>USUARIO DE ACCESO ACTUAL</p>
                      <div class="form-group" >
                          <input type="text" name="username" id="f_u_username" error="usuario de acceso" class="form-control input-form_usuario_update" placeholder="sin usuario de acceso"  value="" disabled> 
                      </div>

                      <p>NUMERO DE EMPLEADO</p>
                      <div class="form-group" >
                          <input type="text" name="numero_empleado" id="f_u_numero_empleado" error="numero de empleado" class="form-control input-form_usuario_update" placeholder="000"  value="" required> 
                      </div>                     
                     
                      <p >Region</p>
                      <div class="form-group" >
                          <select type="number" name="id_region" id="f_u_id_region" error="Selecciona la region." class="form-control input-form_usuario_update" > 
                          <option value="" >Sin registros</option>
                          </select>
                          <input type="hidden" name="nombre_region" id="f_u_nombre_region" error="nombre de region" class="form-control input-form_usuario_update" placeholder=""  value="" > 

                      </div>

                      <p >Estado</p>
                      <div class="form-group" >
                          <select type="number" name="id_estado" id="f_u_id_estado" error="Selecciona el estado." class="form-control input-form_usuario_update"  required> 
                          <option value="" >Sin registros</option>
                          </select>
                      </div>

                      <p >Sucursal</p>
                      <div class="form-group" >
                          <select type="number" name="id_sucursal" id="f_u_id_sucursal" error="Selecciona la sucursal." class="form-control input-form_usuario_update"  > 
                            <option value="" >Sin registros</option>
                          </select>
                      </div>

                      <p class="input-a1toks" >Numero de Unidad/Sucursal</p>
                      <div class="form-group input-a1toks" >
                          <input type="number" name="numero_sucursal" id="f_u_numero_sucursal" error="ingresa correctamente numero de sucursal" class="form-control input-form_usuario_update input-a1toks" placeholder="000"  value="" > 
                      </div>
                      <p class="input-a1toks">Nombre de Unidad/Sucursal</p>
                      <div class="form-group input-a1toks" >
                          <input type="text" name="nombre_sucursal" id="f_u_nombre_sucursal" error="ingresa correctamente nombre de sucursal" class="form-control input-form_usuario_update input-a1toks" placeholder="sucursal/unidad"  value="" > 
                      </div>
                      <p class="input-a1toks" >Horario</p>
                      <div class="form-group input-a1toks" >
                          <input type="text" name="horario" id="f_u_horario" error="ingresa correctamente nombre de sucursal" class="form-control input-form_usuario_update input-a1toks" placeholder="horario"  value="" > 
                      </div>
                      
                       <div class="alert alert-warning" >NOTA: Ten en cuenta que al cambiarle el NOMBRE, el PRIMER APELLIDO o NUMERO DE EMPLEADO también se le MODIFICARÁ al alumno su USUARIO DE ACCESO o CONTRASEÑA.</div>

                      <div class="form-group" >
                          <input type="hidden" name="id_persona" id="f_u_id_persona" class="input-form_usuario_update" value="0"> 
                          <input type="hidden" name="id_moodle" id="f_u_id_moodle" class="input-form_usuario_update" value="0"> 
                          <input type="hidden" name="id_plan_estudio" id="f_u_id_plan_estudio" class="input-form_usuario_update" value="0"> 
                      </div>

                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button id="btn_form_usuario_update" type="button" class="btn btn-info pull-right">Guardar</button>
                  </div>
                </div>
              </div>
            </div>-->



            <!-- NEW USUARIO -->
        <div id="view_insert_usuario" class="row" style="display:none;" >
          <div   class="col-md-10 col-md-offset-1 col-xs-12  panel panel-info"  >
              <div class="panel-heading" ><h3 class="panel-title"  >Registro de Alumno Nuevo</h3></div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row" >
                        <button class="btn btn-default pull-left" id="btn_cancelar_new_usuario" type="button"  >Cancelar</button> <small class="pull-right" style="color:red;">(*) Campos Obligatorios </small>
                        <div class="col-md-2 col-lg-2 " align="center"> <img alt="Foto Alumno" src="assets/img/avatar.png" class="img-circle img-responsive"> 
                          <a href="#" disabled="disabled"  class="btn btn-default">Imagen del Alumno <i class="glyphicon glyphicon-edit"></i> </a>
                        </div>
                      <div class=" col-md-9 col-lg-9 ">
                       <form class="form"  id="form_usuario_insert" name="form_usuario_insert"  >
                          <table class="table table-user-information">
                            <tbody>
                              <tr>
                                <td>
                                  Plataforma<small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                    <select type="number" style="width: 330px;" class="form-input input-form_usuario_insert" name="id_plan_estudio" id="f_i_id_plan_estudio" tabindex="1" required>
                                      <option value="2">PrepaCoppel </option>
                                      <option value="4">PrepaLey  </option>
                                      <option value="9">Preparatoria Toks  </option>
                                      <option value="10">Universidad Toks  </option>
                                    </select>
                                  </td>
                              </tr>
                              <tr class="input-uclescuelas" style="display:none;" >
                                <td>
                                    Escuela<small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                  <select type="number" style="width: 330px;" class="form-input input-form_usuario_insert" name="id_escuela" id="f_i_id_escuela" tabindex="2" required>
                                  <option value="0" >No Definido</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                    Nombre del alumno<small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                   <input type="text" name="nombre" id="f_i_nombre" error="Ingresa correctamente el nombre." class="form-input input-form_usuario_insert" placeholder="Nombre del alumno" tabindex="3" value="" required> 

                                    <input type="hidden" name="tipo_usuario" id="f_tipo_usuario" error="tipo de usuario" tabindex="3" class="form-input input-form_usuario_insert" placeholder=""  value="Alumno"  >
                                </td>
                              </tr>
                              <tr>
                                <td>
                                    Apellido paterno<small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                  <input type="text" name="apellido1" id="f_i_apellido1" error="Ingresa correctamente el apellido paterno." class=" form-input input-form_usuario_insert" placeholder="Apellido paterno"  tabindex="4" value="" required> 
                                </td>
                              </tr>
                              <tr>
                                <td>
                                    Apellido materno<small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                    <input type="text" name="apellido2" id="f_i_apellido2" error="Ingresa correctamente el apellido materno." class=" form-input input-form_usuario_insert" placeholder="Apellido materno" tabindex="5" value="" > 
                                </td>
                              </tr>
                              <tr>
                                <td>
                                   Sexo <small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                    <select type="number" style="width: 330px;" class="form-input input-form_usuario_insert" tabindex="6" name="sexo" id="f_i_sexo" required>
                                      <option value="0">Femenino  </option>
                                      <option value="1">Masculino  </option>
                                    </select>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                    Tipo de alumno<small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                  <select type="select" style="width: 330px;" class=" form-input input-form_usuario_insert" tabindex="7" name="tipo_alumno" id="f_i_tipo_alumno" required>
                                    <option value="1">No Definido</option>
                                    <option value="2">Colaborador</option>
                                    <option value="3">Familiar</option>
                                  </select> <br>(NOTA: Seleccionar NO DEFINIDO para que el alumno pueda actualizar el mismo sus datos)
                                </td>
                              </tr>
                              <tr class="input-prepacoppel" >
                            <td>Area del Alumno(Solo PrepaCoppel):</td>
                            <td>  
                                
                              <select id="f_i_id_area" name="id_area" nombre="Area" type="select" error="Introduce tu Area correctamente" name="id_area" class=" form-input input-form_usuario_insert" >
                                          <option value="1" >ROPA</option>
                                          <option value="2">MUEBLES</option>
                                          <option value="3">CAJA</option>
                                          <option value="4">BANCO</option>
                                          <option value="5">ZAPATERIA CANADA</option>
                                          <option value="6">BODEGA</option>
                                          <option value="7">COBRANZA</option>
                                          <option value="8">CHOFER DISTRIBUCION</option>
                                          <option value="9">EQUIPO DE TRANSPORTE</option>
                                          <option value="10">STAFF</option>
                                          <option value="11">FAMILIAR</option>
                                          <option value="12" selected>NO DEFINIDO</option>                       
                                 </select>




                            </td>
                          </tr>               
                              <tr>
                                <td>
                                   Estado <small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                  <select type="number" style="width: 330px;" tabindex="8" class=" form-input input-form_usuario_insert" name="id_estado" id="f_i_id_estado" error="Selecciona el estado" required>
                                    <option value="">Seleccione un estado </option>
                                  </select>
                                </td>
                              </tr>   
                              <tr>
                                <td>
                                   Ciudad <small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                   <select type="number" style="width: 330px;" tabindex="9" class=" form-input input-form_usuario_insert" name="id_ciudad" id="f_i_id_ciudad"  error="Selecciona la ciudad" required>
                                    <option value="">Seleccione una ciudad </option>
                                  </select>
                                   <input type="hidden" name="nombre_ciudad" id="f_i_nombre_ciudad" error="selecciona correctamente la ciudad" class=" form-input input-form_usuario_insert" placeholder=""  value="" > 
                                    <input type="hidden" name="nomenclatura_ciudad" id="f_i_nomenclatura_ciudad" error="selecciona correctamente la nomenclatura ciudad" class=" form-input input-form_usuario_insert" placeholder=""  value="" > 
                                </td>
                              </tr>   
                              <tr>
                                <td>
                                    Region<small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                  <select type="number" style="width: 330px;" tabindex="10" class=" form-input input-form_usuario_insert" name="id_region" id="f_i_id_region"  error="Selecciona la region" required>
                                    <option value="">Seleccione una region </option>
                                  </select>
                                  <input type="hidden" name="nombre_region" id="f_i_nombre_region" error="selecciona correctamente la region" class=" form-input input-form_usuario_insert" placeholder=""  value="" > 
                                </td>
                              </tr> 

                                  <tr class="input-genercion" >
                            <td>Generación (Solo UCL ESCUELAS):</td>
                            <td>  
                                
                              <select id="f_i_generacion" name="generacion" nombre="Generacion" type="select" error="Introduce tu Area correctamente" name="generacion" class=" form-input input-form_usuario_insert" >
                                          <option value="0" selected>No definido</option>

                                          <option value="1" >Generacion 1</option>
                                          <option value="2">Generacion 2</option>
                                          <option value="3">Generacion 3</option>
                                          <option value="4">Generacion 4</option>
                                          <option value="5">Generacion 5 </option>
                                          <option value="6">Generacion 6 </option>
                                          <option value="7">Generacion 7 </option>
                                          <option value="8">Generacion 8</option>
                                          <option value="9">Generacion 9</option>
                                          <option value="10">Generacion 10</option>           
                                 </select>




                            </td>
                          </tr>     


                              <tr>
                                <td>
                                    NUMERO DE EMPLEADO <small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                  <input type="text" name="numero_empleado" tabindex="11" id="f_i_numero_empleado" error="ingresa correctamente numero de empleado" class=" form-input input-form_usuario_insert" placeholder="000"  value="" required> 
                                </td>
                              </tr>
                              <tr>
                                <td>
                                    Estado de Documentación<small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                  <select type="number" style="width: 330px;" class="form-input input-form_usuario_insert" tabindex="12" name="documentacion_estatus" id="f_i_documentacion_estatus" required>
                                    <option value="1">Completo</option>
                                    <option value="2">Incompleto</option>
                                    <option value="3">Sin Documentos</option>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                   Numero de Unidad/Sucursal 
                                </td>
                                <td>
                                  <input type="number" name="numero_sucursal" tabindex="13" id="f_i_numero_sucursal" error="ingresa correctamente numero de sucursal" class=" form-input input-form_usuario_insert" placeholder="000"  value="" > 
                                </td>
                              </tr>
                              <tr>
                                <td>
                                   Nombre de Unidad/Sucursal 
                                </td>
                                <td>
                                  <input type="text" name="nombre_sucursal" tabindex="14" id="f_i_nombre_sucursal" error="ingresa correctamente nombre de sucursal" class=" form-input input-form_usuario_insert" placeholder="sucursal/unidad"  value="" > 
                                </td>
                              </tr>  
                              <tr>
                                <td>
                                    Teléfono Celular <small style="color:red; font-size: 24px;">*</small>
                                </td>
                                <td>
                                    <input type="number" name="telefono_celular" id="f_i_telefono_celular" error="Ingresa correctamente el telefono de celular." class=" form-input input-form_usuario_insert" placeholder="Telefono celular 0000 00 00 00" tabindex="15" value="" required> 
                                </td>
                              </tr>
                              <tr>
                                <td>
                                    Teléfono de casa 
                                </td>
                                <td>
                                   <input type="number" name="telefono_casa" id="f_i_telefono_casa" error="Ingresa correctamente el telefono de casa." class=" form-input input-form_usuario_insert" placeholder="Telefono de casa 0000 00 00 00"  value="" tabindex="16" > 
                                </td>
                              </tr>
                              <tr>
                                <td>
                                   Teléfono Alternativo
                                </td>
                                <td>
                                    <input type="number" name="telefono_alternativo" id="f_i_telefono_alternativo" error="Ingresa correctamente el telefono alternativo." class=" form-input input-form_usuario_insert" tabindex="17" placeholder="Telefono de Alternativo 0000 00 00 00"  value="" >
                                </td>
                              </tr>
                               <tr>
                                <td>
                                   Correo Electrónico 
                                </td>
                                <td>
                                    <input type="text" name="email" id="f_i_email" error="Ingresa correctamente el Correo Electrónico." class=" form-input input-form_usuario_insert" placeholder="email@agcollege.edu.mx" tabindex="18" value="" >
                                </td>
                              </tr>
                              <tr>
                                 <td>
                                    Fecha de Nacimiento (DD-MM-AAAA)
                                </td>
                                <td>
                                   <input type="text" name="fecha_nacimiento" id="f_i_fecha_nacimiento" error="ingresa correctamente la fecha de nacimiento" class=" form-input input-form_usuario_insert" placeholder="22-01-1990" tabindex="19" value="" > 
                                </td>
                              </tr>
                              <tr>
                                 <td>
                                   CURP
                                </td>
                                <td>
                                   <input type="text" name="curp" id="f_i_curp" error="ingresa correctamente el curp" class="form-input input-form_usuario_insert" placeholder="" tabindex="19" value="" > 
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                   <div class="alert alert-info" >NOTA: Ten en cuenta que al cambiarle el Nombre, el primer apellido o Numero de Empleado también se le Modificarà al alumno su Usuario de acceso o Contraseña.</div>
                                </td>
                              </tr>
                          </tbody>
                          </table>
                        </form>
                        <button class="btn btn-success pull-right" tabindex="19" id="btn_usuario_insert" type="button" >Registrar Alumno</button>
                      </div>
                  </div>
                </div>     
              </div>
                    
              </div>
                  
              </div>
          </div>

        </div><!-- NEW USUARIO -->




        <!--FORM NEW  UPDATE  USUARIO -->

        <div class="row" id="view_usuario_update"  style="display:none;" >
            <div class="col-md-10 col-md-offset-1 col-xs-12  panel panel-info">
              <div class="panel-heading">
               <h3 class="panel-title" id="modal_title_usuario" ></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-2 col-lg-2 " align="center"> <img alt="Foto Alumno" src="assets/img/avatar.png" class="img-circle img-responsive"> 
                    <a href="#" disabled="disabled"  class="btn btn-default">Imagen del Alumno <i class="glyphicon glyphicon-edit"></i> </a>
                  </div>
                  
                  <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                    <dl>
                      <dt>DEPARTMENT:</dt>
                      <dd>Administrator</dd>
                      <dt>HIRE DATE</dt>
                      <dd>11/12/2013</dd>
                      <dt>DATE OF BIRTH</dt>
                         <dd>11/12/2013</dd>
                      <dt>GENDER</dt>
                      <dd>Male</dd>
                    </dl>
                  </div>-->

                  <div class=" col-md-9 col-lg-9 "> 
                 
                      <table class="table table-user-information">
                       <form class="form"  id="form_usuario_update" name="form_usuario_update"  >
                        <tbody>
                          <tr>
                            <td>Nombre:<small style="color:red; font-size: 24px;">*</small></td>
                            <td> <input type="text" name="nombre" id="f_u_nombre" error="Ingresa el nombre." class="form-input input-form_usuario_update" placeholder="Nombre del alumno"   tabindex="1" value="" required> </td>
                          </tr>
                          <tr>
                            <td>Apellido Paterno:<small style="color:red; font-size: 24px;">*</small></td>
                            <td><input type="text" name="apellido1" id="f_u_apellido1" error="Ingresa el apellido paterno." class="form-input input-form_usuario_update" placeholder="Apellido paterno"  tabindex="2"  value="" required> </td>
                          </tr>
                          <tr>
                            <td>Apellido Materno:</td>
                            <td><input type="text" name="apellido2" id="f_u_apellido2" error="Ingresa el apellido materno." class="form-input input-form_usuario_update" placeholder="Apellido materno"  tabindex="3" value="" > </td>
                          </tr>
                          <tr>
                            <td>Sexo:<small style="color:red; font-size: 24px;">*</small></td>
                            <td><select type="number" tabindex="4" class="form-input input-form_usuario_update" name="sexo" id="f_u_sexo"  required>
                            <option value="0">Femenino</option>
                            <option value="1">Masculino</option>
                          </select></td>
                          </tr>
                          <tr>
                            <td>Tipo de Alumno:<small style="color:red; font-size: 24px;">*</small></td>
                            <td>  
                                <select type="number"  tabindex="7" name="tipo_alumno" id="f_u_tipo_alumno" error="Selecciona el tipo de alumno." class="form-input input-form_usuario_update" placeholder="Tipo de Alumno"  required> 
                              <option value="1" >No Definido</option>
                               <option value="2" >Colaborador</option>
                                <option value="3" >Familiar</option>
                              </select> <br>(NOTA: Seleccionar NO DEFINIDO para que el alumno pueda actualizar el mismo sus datos)
                            </td>
                          </tr>
                             <tr class="input-prepacoppel" >
                            <td>Area del Alumno(Solo PrepaCoppel):</td>
                            <td>  
                              <select id="f_u_id_area" name="id_area" nombre="Area" type="select" error="Introduce tu Area correctamente" name="id_area" class="form-input input-form_usuario_update" >
                                          <option value="1" >ROPA</option>
                                          <option value="2">MUEBLES</option>
                                          <option value="3">CAJA</option>
                                          <option value="4">BANCO</option>
                                          <option value="5">ZAPATERIA CANADA</option>
                                          <option value="6">BODEGA</option>
                                          <option value="7">COBRANZA</option>
                                          <option value="8">CHOFER DISTRIBUCION</option>
                                          <option value="9">EQUIPO DE TRANSPORTE</option>
                                          <option value="10">STAFF</option>
                                          <option value="11">FAMILIAR</option>
                                          <option value="12" selected>NO DEFINIDO</option>                       
                                 </select>
                            </td>
                          </tr>                
                          <tr>
                          <td>Región:<small style="color:red; font-size: 24px;">*</small></td>
                            <td>
                                <select type="number"  tabindex="10" name="id_region" id="f_u_id_region" error="Selecciona la region." class="form-input input-form_usuario_update" required> 
                                <option value="" >Sin registros</option>
                                </select>
                                <input type="hidden" name="nombre_region" id="f_u_nombre_region" error="nombre de region" class="form-input input-form_usuario_update" placeholder=""  value="" > 
                            </td>
                          </tr>
                          <tr>
                            <td>Estado:<small style="color:red; font-size: 24px;">*</small></td>
                            <td>  <select type="number"  tabindex="11" name="id_estado" id="f_u_id_estado" error="Selecciona el estado." class="form-input input-form_usuario_update"  required> 
                                  <option value="" >Sin registros</option>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Sucursal:</td>
                            <td> 
                                <select type="number"  tabindex="12" name="id_sucursal" id="f_u_id_sucursal" error="Selecciona la sucursal." class="form-input input-form_usuario_update"  > 
                                <option value="" >Sin registros</option>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td>Usuario:</td>
                            <td> <input type="text"  tabindex="8" name="username" id="f_u_username" error="usuario de acceso" class="form-input input-form_usuario_update" placeholder="sin usuario de acceso"  value="" disabled> </td>
                          </tr>
                          <tr>
                            <td># Empleado/Estafeta:<small style="color:red; font-size: 24px;">*</small></td>
                            <td>
                            <input type="text"  tabindex="9" name="numero_empleado" id="f_u_numero_empleado" error="numero de empleado" class="form-input input-form_usuario_update" placeholder="000"  value="" required> 
                          </tr>
                          <tr>
                            <td>Email:</td>
                            <td> <input type="text"  tabindex="5" name="email" id="f_u_email" error="Ingrese el correo de la persona." class="form-input input-form_usuario_update" placeholder="email@agcollege.edu.mx"  value="" > </td>
                          </tr>
                          <tr>
                            <td>Fecha de Nacimiento (DD-MM-AAAA):</td>
                            <td>  <input type="text"  tabindex="6" name="fecha_nacimiento" id="f_u_fecha_nacimiento" error="fecha de nacimiento" class="form-input input-form_usuario_update" placeholder="1990-01-22"  value="" > 
                            </td>
                          </tr>
                          <tr>
                             <td>
                               CURP
                            </td>
                            <td>
                               <input type="text" name="curp" id="f_u_curp" error="ingresa correctamente el curp" class="form-input input-form_usuario_update" placeholder="" tabindex="19" value="" > 
                            </td>
                          </tr>
                          <!--DATOS PARA TOKS-->
                          <tr class="input-a1toks" >
                            <td>Numero de Unidad/Sucursal:</td>
                            <td><input type="number"  tabindex="13" name="numero_sucursal" id="f_u_numero_sucursal" error="ingresa correctamente numero de sucursal" class="form-input input-form_usuario_update input-a1toks" placeholder="000"  value="" > </td>
                          </tr>
                          <tr class="input-a1toks" >
                            <td>Nombre de Unidad/Sucursal:</td>
                            <td> <input type="text"  tabindex="14" name="nombre_sucursal" id="f_u_nombre_sucursal" error="ingresa correctamente nombre de sucursal" class="form-input input-form_usuario_update input-a1toks" placeholder="sucursal/unidad"  value="" ></td>
                          </tr>
                          <tr class="input-a1toks" >
                            <td>Horario:</td>
                            <td><input type="text"  tabindex="15" name="horario" id="f_u_horario" error="ingresa correctamente nombre de sucursal" class="form-input input-form_usuario_update input-a1toks" placeholder="horario"  value="" > </td>
                          </tr>

                          <!--TERMINA DATOS PARA TOKS-->
                        </tbody>
                        <input type="hidden" name="id_alumno" id="f_u_id_alumno" class="input-form_usuario_update" value="0"> 

                        <input type="hidden" name="id_persona" id="f_u_id_persona" class="input-form_usuario_update" value="0"> 
                        <input type="hidden" name="id_moodle" id="f_u_id_moodle" class="input-form_usuario_update" value="0"> 
                        <input type="hidden" name="id_plan_estudio" id="f_u_id_plan_estudio" class="input-form_usuario_update" value="0"> 
                      </form>
                      <tbody>
                        <tr>
                             <td colspan="1">
                               Telefonos del Alumno
                            </td>
                             <td colspan="2">
                               
                                    Registrar Telefono Nuevo
                                    
                                    <div class="input-group">
                                        <form class="form" id="form_telefono_insert" name="form_telefono_insert" >
                                          <input type="hidden" name="id_alumno" id="form_telefono_insert_id_alumno" class="form-input  input-form_telefono_insert" value="0" required>
                                          <input type="number" name="telefono" id="form_telefono_insert_telefono" class="form-input  input-form_telefono_insert form-control" placeholder="66770000000"  error="Por favor ingrese solo valores numericos." required>
                                        </form>
                                        <div class="input-group-btn">
                                          <button type="button" class="form-control btn btn-success" id="btn_insert_telefono" ><i class="glyphicon glyphicon-plus"></i></button>
                                        </div>
                                    </div>
                               
                            </td>
                          </tr>
                          <tr>
                            <table class="table">
                              <tbody id="tabla_telefonos_alumno" >
                                  
                              </tbody>
                            </table>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <div class="alert alert-info" >NOTA: Ten en cuenta que al cambiarle el <strong>Nombre</strong>, el <strong>primer apellido</strong> o <strong>Numero de Empleado</strong> también se le <strong>Modificarà</strong> al alumno su <strong>Usuario de acceso o Contraseña</strong>.</div> 
                            </td>
                          </tr>
                      </tbody>
                      </table>

                    <!--<button type="button" class="btn btn-success"><i class="glyphicon glyphicon-upload"></i> Subir Documento</button>-->
                          
                  </div>
                </div>
              </div>
                   <div class="panel-footer">
                          <button  id="btn_form_usuario_update_cancel" data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn_form_usuario_update_cancel btn btn-sm btn-default">Cancelar</button>
                          <span class="pull-right">
                              <button  tabindex="17" id="btn_form_usuario_update" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Guardar</button>
                          </span>
                    </div>
            </div>
        </div>    

    <div class="modal fade" id="modal_u_upload"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

              <h4 class="modal-title">Documentos del alumno</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_u_upload" name="form_u_upload" >
                   <input type="hidden" id="form_u_upload_id_scorm" value="0" name="id_" class="input-form_u_upload form-control" 
                   error="Ingesa el id_" required>
                   <input type="hidden" name="id_persona" id="f_upload_id_persona" class="input-form_u_upload" value="0"> 
                        <input type="hidden" name="id_moodle" id="f_upload_id_moodle" class="input-form_u_upload" value="0"> 
                        <input type="hidden" name="id_plan_estudio" id="f_upload_id_plan_estudio" class="input-form_u_upload" value="0"> 
                   <div class="form-group" >
                    <select>
                        <option value="1" >Acta de Nacimiento</option>
                        <option value="2" >Certificado</option>
                        <option value="3" >Carta de Autenticidad</option>
                        <option value="4" >Certificado Legalizado</option>
                        <option value="5" >Boleta de Calificación</option>
                        <option value="6" >Historial Académico</option>
                        <option value="7" >Diploma</option>
                        <option value="8" >Kardex</option>
                        <option value="9" >Carta de Trámite</option>
                        <option value="10" >Constancia de Estudios</option>
                        <option value="11" >Otro</option>
                    </select>
                   </div>
                   <div class="form-group" >
                      Selecciona un paquete Scorm (.zip) para subir 
                        <div id="fileuploader2">Subir Paquete Scorm (.zip)</div>
                        <button type="button" class="btn btn-primary" id="btn_form_u_upload" >Subir</button>
                    </div>
                </form>

                <div class="row table-responsive">
                  <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Documento</th>
                      <th>Player</th>
                      <th> </th>
                    </tr>
                  </thead>
                  <tbody id="tabla_scormsfiles" >
                    <tr>
                      <td>...</td>
                      <td>...</td>        
                      <td>
                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_u_upload" ><span class="glyphicon glyphicon-trash"></span></button>
                      </td>       
                    </tr>              
                  </tbody>
                  </table>
                </div>
                                
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


    <div class="modal fade" id="modal_telefonos"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

              <h4 class="modal-title">Eliminar telefono del Alumno</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form class="form" id="form_modal_telefonos" name="form_modal_telefonos" >
                   <input type="hidden" id="form_modal_telefonos_id_telefono" value="0" name="id_telefono" class="input-form_modal_telefonos form-control" 
                   error="Ingesa el id del telefono" required>
                    <select type="number"  id="form_modal_telefonos_id_motivo_baja" name="id_motivo_baja" class="input-form_modal_telefonos form-control"   error="selecciona el motivo de la baja" required>
                        <option value="" selected>Seleccione un motivo</option>
                        <option value="1" >Sin motivo</option>
                    </select>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-danger pull-right" id="btn_form_delete_telefono" >Eliminar Telefono</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->




    <div id="modal_aviso" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="" >Mensaje</h4>
          </div>
          <div class="modal-body" id="modal_aviso_msg" >
            <p></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-block btn-default" data-dismiss="modal">Aceptar</button>
          </div>
        </div>

      </div>
    </div>



    <div id="modal_pago" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="" >Registro de pagos por Alumno</h4>
          </div>
          <div class="modal-body"  >
                <form class="form form-inline" id="form_pago" name="form_pago" >
                  <!-- <div class="input-group">
                   <span id="dog_count" class="input-group-addon"  for="id_moodle">Alumno:</span >
                      <input type="text" id="form_pago_nombre" placeholder="Nombre del alumno" name="nombre" class="input-form_pago form-control" error="Ingesa el nombre del alumno" readonly="readonly"  style="width: 100px;" >
                  </div>
                  <div class="input-group">
                   <span id="dog_count" class="input-group-addon"  for="numero_empleado">#Empleado/Estafeta:</span >
                    <input type="text" id="form_pago_numero_empleado" placeholder="Numero de empleado" name="numero_empleado" class="input-form_pago form-control" error="Ingesa el nombre del alumno" readonly="readonly" style="width: 80px;" >
                  </div>-->
                   <div class="input-group">
                   <span id="dog_count" class="input-group-addon"  for="nomenclatura">Concepto</span >
                    <select type="text"  id="form_pago_nomenclatura" name="nomenclatura" class="input-form_pago form-control"   error="selecciona el concepto del pago" required style="width: 150px;"  >
                        <option value="" selected>Seleccione un concepto</option>
                        <option value="IN" >(IN) INSCRIPCIÓN</option>
                        <option value="RE" >(RE) REINSCRIPCIÓN</option>
                        <option value="PM" >(PM) PAGO MENSUAL</option>
                        <option value="EX" >(EX) EXAMEN EXTRAORDINARIO</option>
                    </select>
                  </div>
                  <div class="input-group">
                   <span id="dog_count" class="input-group-addon"  for="nomenclatura">Monto $:</span >
                     <input type="number" id="form_pago_monto" placeholder="10.00" name="monto" class="input-form_pago form-control" error="Ingesa el monto del pago" required style="width: 100px;" >
                  </div>
                 
                  <div class="input-group">
                   <span id="dog_count" class="input-group-addon"  for="fecha_pago">Fecha de pago:</span >
                     <input type="text" id="form_fecha_pago" placeholder="22-12-2017" name="fecha_pago" class="input-form_pago form-control" error="Ingesa la fecha correctamente" required style="width: 100px;" >
                  </div>
                    <div class="input-group">
                   <span id="dog_count" class="input-group-addon"  for="fecha_pago_periodo">Fecha de Periodo Pagado:</span >
                     <input type="text" id="form_fecha_pago_periodo" placeholder="22-12-2017" name="fecha_pago_periodo" class="input-form_pago form-control" error="Ingesa la fecha del periodo pagado por el alumno correctamente" required style="width: 100px;" >
                  </div>
                    <div class="input-group">
                      <span id="dog_count" class="input-group-addon"  for="reactivar">¿Reactivar Alumno?</span >
                     <input type="checkbox" id="form_pago_reactivar" class="input-form_pago form-control" name="reactivar" value="reactivar" style="width: 50px;"  >
                   </div>

                    <input type="hidden" name="id_alumno" id="form_pago_id_alumno" class="input-form_pago  form-control" value="0"> 
                    <input type="hidden" name="id_persona" id="form_pago_id_persona" class="input-form_pago  form-control" value="0"> 
                    <input type="hidden" name="id_moodle" id="form_pago_id_moodle" class="input-form_pago form-control" value="0"> 
                    <input type="hidden" name="id_plan_estudio" id="form_pago_id_plan_estudio" class="input-form_pago form-control" value="0"> 

                   

                </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancelar</button>
             <button type="button" class="pull-right btn btn-success" data-dismiss="modal">Registrar Pago</button>
          </div>
        </div>

      </div>
    </div>




    </div><!--CONTAINER-->

  </body>
</html>