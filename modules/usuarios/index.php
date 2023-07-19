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
      <title>Usuarios</title>
      <meta name="description" content="Administrador de chat"/>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Loading Bootstrap -->
      <link  href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!--<link rel="shortcut icon" href="flatui/img/favicon.ico">-->
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="ckeditor/ckeditor.js"></script>
      <script src="controllers/usuarios.js?n=6"></script>
      <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
        <script src="flatui/dist/js/vendor/html5shiv.js"></script>
        <script src="flatui/dist/js/vendor/respond.min.js"></script>
      <![endif]-->
    </head>
  <body>
  <div id="loading" class="col-md-12 text-center" style="display:none; opacity: 0.9; border-radius: 10px; z-index: 99; position:fixed; width:100%;height:100px; top:30%;" ><img src="assets/img/loading.gif" alt="Cargando..."  ></div>
    <div class="container-fluid">
        <div class="row" >
          <div class="col-md-12 col-xs-12" >
              <form class="form-inline alert alert-default" name="form_search"  id="form_search" role="form">

                  <div class="input-group">
                   <span  class="input-group-addon"  for="id_moodle">ID:</span >
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
                      <button class="btn btn-primary" type="button" id="btn_new_usuario" > + Alumno Nuevo</button>

          <div class="col-md-10 col-md-offset-1 col-xs-12  panel panel-default" >
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                      <div class="list-group" style="height:350px; overflow-y: auto; ">
                      
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
                                <th>Telefono </th>
                                <th>Tel2 O Celular</th>
                                <th>Alternativo</th>
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
            <div id="modal_usuario_update" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal_title_usuario" >Editar Alumno</h4>
                  </div>
                  <div class="modal-body">
                    <p>Nombre del Alumno</p>
                    <form class="form"  id="form_usuario_update" name="form_usuario_update"  >
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
                          <select type="number" style="width: 330px;" class="form-control input-form_usuario_update" name="sexo" id="f_u_sexo"  requied>
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
            </div>








            <!-- NEW USUARIO -->
        <div id="view_insert_usuario" class="row" style="display:none;" >
          <div   class="col-md-8 col-md-offset-2 col-xs-12 panel panel-primary"  >
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row" ><button class="btn btn-default pull-left" id="btn_cancelar_new_usuario" type="button"  >Cancelar</button> <small class="pull-right" style="color:red;">(*) Campos Obligatorios </small><br><h2 class="pull-right">Registro de Usuario Nuevo</h2></div>
                       <form class="form"  id="form_usuario_insert" name="form_usuario_insert"  >
                          
                          <p>Plataforma<small style="color:red; font-size: 24px;">*</small></p>
                          <div class="form-group">
                            <select type="number" style="width: 330px;" class="form-control input-form_usuario_insert" name="id_plan_estudio" id="f_i_id_plan_estudio" requied>
                              <option value="2">PrepaCoppel </option>
                              <option value="4">PrepaLey  </option>
                              <option value="9">Preparatoria Toks  </option>
                              <option value="10">Universidad Toks  </option>
                            </select>
                          </div>

                           <p class="input-uclescuelas" style="display:none;" >Escuela Ucl<small style="color:red; font-size: 24px;">*</small></p>
                          <div class="form-group input-uclescuelas" style="display:none;" >
                            <select type="number" style="width: 330px;" class="form-control input-form_usuario_insert" name="id_ucl_escuela" id="f_i_id_ucl_escuela" requied>
                            </select>
                          </div>
                         

                          <p>Tipo de alumno<small style="color:red; font-size: 24px;">*</small></p>
                          <div class="form-group">
                            <select type="text" style="width: 330px;" class="form-control input-form_usuario_insert" name="tipo_alumno" id="f_i_tipo_alumno" requied>
                            <option value="">No Definido </option>
                            <option value="2">Colaborador  </option>
                              <option value="3">Familiar  </option>
                            </select>
                          </div>

                          <p>Nombre del alumno<small style="color:red; font-size: 24px;">*</small></p>
                          <div class="form-group" >
                              <input type="text" name="nombre" id="f_i_nombre" error="Ingresa correctamente el nombre." class="form-control input-form_usuario_insert" placeholder="Nombre del alumno"  value="" required> 
                          </div>
                          
                          <p>Apellido paterno<small style="color:red; font-size: 24px;">*</small></p>

                          <div class="form-group" >
                              <input type="text" name="apellido1" id="f_i_apellido1" error="Ingresa correctamente el apellido paterno." class="form-control input-form_usuario_insert" placeholder="Apellido paterno"  value="" required> 
                          </div>
                          <p>Apellido materno</p>
                          <div class="form-group" >
                              <input type="text" name="apellido2" id="f_i_apellido2" error="Ingresa correctamente el apellido materno." class="form-control input-form_usuario_insert" placeholder="Apellido materno"  value="" > 
                          </div>

                          <p>Sexo<small style="color:red; font-size: 24px;">*</small></p>
                          <div class="form-group">
                            <select type="text" style="width: 330px;" class="form-control input-form_usuario_insert" name="sexo" id="f_i_sexo" requied>
                            <option value="0">Femenino  </option>
                            <option value="1">Masculino  </option>
                            </select>
                          </div>

                         <p>Fecha de Nacimiento (DD-MM-AAAA)</p>
                          <div class="form-group" >
                              <input type="text" name="fecha_nacimiento" id="f_i_fecha_nacimiento" error="ingresa correctamente la fecha de nacimiento" class="form-control input-form_usuario_insert" placeholder="22-01-1990"  value="" > 
                          </div>

                          <p>Teléfono de casa</p>
                          <div class="form-group" >
                              <input type="number" name="telefono_casa" id="f_i_telefono_casa" error="Ingresa correctamente el telefono de casa." class="form-control input-form_usuario_insert" placeholder="Telefono de casa 0000 00 00 00"  value="" > 
                          </div>

                          <p>Teléfono Celular<small style="color:red; font-size: 24px;">*</small></p>
                          <div class="form-group" >
                              <input type="number" name="telefono_celular" id="f_i_telefono_celular" error="Ingresa correctamente el telefono de celular." class="form-control input-form_usuario_insert" placeholder="Telefono celular 0000 00 00 00"  value="" required> 
                          </div>

                          <p>Teléfono Alternativo</p>
                          <div class="form-group" >
                              <input type="number" name="telefono_alternativo" id="f_i_telefono_alternativo" error="Ingresa correctamente el telefono alternativo." class="form-control input-form_usuario_insert" placeholder="Telefono de Alternativo 0000 00 00 00"  value="" >
                          </div>

                          <p>Correo Electrónico</p>
                          <div class="form-group" >
                              <input type="text" name="email" id="f_i_email" error="Ingresa correctamente el Correo Electrónico." class="form-control input-form_usuario_insert" placeholder="email@agcollege.edu.mx"  value="" >
                          </div>

                          <p>Estado<small style="color:red; font-size: 24px;">*</small></p>
                          <div class="form-group" >
                               <select type="number" style="width: 330px;" class="form-control input-form_usuario_insert" name="id_estado" id="f_i_id_estado" error="Selecciona el estado" requied>
                              <option value="">Seleccione un estado </option>
                            </select>
                          </div>

                          <p>Ciudad<small style="color:red; font-size: 24px;">*</small></p>
                          <div class="form-group" >
                               <select type="number" style="width: 330px;" class="form-control input-form_usuario_insert" name="id_ciudad" id="f_i_id_ciudad"  error="Selecciona la ciudad" requied>
                              <option value="">Seleccione una ciudad </option>
                            </select>
                                  <input type="hidden" name="nombre_ciudad" id="f_i_nombre_ciudad" error="selecciona correctamente la ciudad" class="form-control input-form_usuario_insert" placeholder=""  value="" > 
                                  <input type="hidden" name="nomenclatura_ciudad" id="f_i_nomenclatura_ciudad" error="selecciona correctamente la nomenclatura ciudad" class="form-control input-form_usuario_insert" placeholder=""  value="" > 
                          </div>

                          <p>Region<small style="color:red; font-size: 24px;">*</small></p>
                          <div class="form-group" >
                               <select type="number" style="width: 330px;" class="form-control input-form_usuario_insert" name="id_region" id="f_i_id_region"  error="Selecciona la region" requied>
                              <option value="">Seleccione una region </option>
                            </select>
                               <input type="hidden" name="nombre_region" id="f_i_nombre_region" error="selecciona correctamente la region" class="form-control input-form_usuario_insert" placeholder=""  value="" > 
                          </div>

                          <p>NUMERO DE EMPLEADO<small style="color:red; font-size: 24px;">*</small></p>
                          <div class="form-group" >
                              <input type="text" name="numero_empleado" id="f_i_numero_empleado" error="ingresa correctamente numero de empleado" class="form-control input-form_usuario_insert" placeholder="000"  value="" required> 
                          </div>

                          <p>Numero de Unidad/Sucursal</p>
                          <div class="form-group" >
                              <input type="number" name="numero_sucursal" id="f_i_numero_sucursal" error="ingresa correctamente numero de sucursal" class="form-control input-form_usuario_insert" placeholder="000"  value="" > 
                          </div>

                          <p>Nombre de Unidad/Sucursal</p>
                          <div class="form-group" >
                              <input type="text" name="nombre_sucursal" id="f_i_nombre_sucursal" error="ingresa correctamente nombre de sucursal" class="form-control input-form_usuario_insert" placeholder="sucursal/unidad"  value="" > 
                          </div>

                          <div class="alert alert-warning" >NOTA: Ten en cuenta que al INGRESAR el NOMBRE, el PRIMER APELLIDO o NUMERO DE EMPLEADO también se le GENERARÁ al alumno su USUARIO DE ACCESO Y/o CONTRASEÑA.</div>
                         
                        </form>
                            <button class="btn btn-success pull-right" id="btn_usuario_insert" type="button" >Crear Usuario</button>

                  </div>
                </div>               
              </div>
           
          </div>
        </div><!-- NEW USUARIO -->

    </div><!--CONTAINER-->

  </body>
</html>