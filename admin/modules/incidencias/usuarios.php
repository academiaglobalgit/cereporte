<?php
include_once("includes/checklogin.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Incidencias | Usuarios</title>
    <meta name="description" content="Catalogo de Usuarios"/>
    <?php
       include_once("includes/assets.php"); // INCLUDE ASSETS
    ?>

  </head>
  <body>

    <div id="wrapper" class="">

      <!-- MODULO DE usuarios -->
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
              <p><h1>Catalogo de usuarios DE ALBERTO</h1></p>
              <ol class="breadcrumb">
                <li><a href="index.php">Inicio</a></li>
                <li class="active">usuarios</li>
              </ol>
            </div>
          </div>
          <div class="row"><!--BOTON CREAR-->
              <div class="col-md-12">
              <p><button class="btn btn-primary" data-toggle="modal" data-target="#modal_u_crear" type="button" ><span class=" glyphicon glyphicon-plus"></span> Crear Nuevo usuario</button>
              </p>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12">
                <div class="row" >
                  <div class="col-md-12">
                    <form id="form_u_search" class="form-inline" name="form_u_search" >
                                <div class="input-group" >
                                    <span class="input-group-addon" id="basic-addon1">Buscar usuario</span>
                                    <input type="text" id="form_u_search_usuario" value="" name="usuario" class="input-form_u_search form-control" error="Ingrese un USUARIO." placeholder="buscar" >
                                </div>
                                <div class="input-group" >
                                  <button id="btn_form_u_search" class="btn btn-default" type="button">Filtrar</button>
                                </div>
                      </form>
                  </div>
                </div>
                <div class="row table-responsive">
                  <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Usuario</th>
                      <th>Estatus</th>
                      <th>Permiso</th>
                      <th>Area</th>
                      <th>Fecha Alta</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="tabla_usuarios" >
                    <tr>
                      <td>...</td>
                      <td>...</td>
                      <td>...</td>
                      <td>...</td>
                      <td>...</td>
                      <td>...</td>
                      <td>...</td>
                      <td>
                        <button class="btn btn-default"
                          type="button" ><span class="glyphicon glyphicon-edit"></span></button>
                      </td>
                    </tr>
                  </tbody>
                  </table>
                </div>
            </div>
          </div>



        </div>
      </div>

    </div>

<!--NODAL CREAR-->

      <div class="modal fade" id="modal_u_crear"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Nuevo usuario</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_u_crear" name="form_u_crear" >

                      <div class="form-group" >
                          Nombre:
                          <input type="text" id="form_u_crear_nombre" value="" name="nombre" class="input-form_u_crear form-control" error="Ingresa el nombre del usuario." placeholder="Ejemplo: Cesar Alejandro" required>
                      </div>
                       <div class="form-group" >
                          Apellido Paterno:
                          <input type="text" id="form_u_crear_apellidop" value="" name="apellidop" class="input-form_u_crear form-control" error="Ingesa el apellido paterno." placeholder="ejemplo: Lopez" required>
                      </div>
                       <div class="form-group" >
                          Apellido Materno:
                          <input type="text" id="form_u_crear_apellidom" value="" name="apellidom" class="input-form_u_crear form-control" error="Ingesa un apellido Materno." placeholder="ejemplo: Rodriguez" required>
                      </div>
                      <div class="form-group" >
                          Fecha de Nacimiento:
                          <input type="text" id="form_u_crear_fecha_nacimiento" value="" name="fecha_nacimiento" class="input-form_u_crear form-control" error="Ingesa la fecha de nacimiento." placeholder="ejemplo: 01-19-1990" >
                      </div>

                       <div class="form-group" >
                          Contraseña:
                          <input type="text" id="form_u_crear_contrasena" value="" name="contrasena" class="input-form_u_crear form-control" error="Ingesa una contrasena." placeholder="*******" required>
                      </div>
                       <div class="form-group" >
                         Permiso:
                              <select type="number" id="form_u_crear_permiso" name="permiso" class="input-form_u_crear form-control" error="Selecciona un permiso." required>
                                <option value="" selected>selecciona un permiso</option>
                                <option value="1" >Permiso 1</option>
                                <option value="2" >Permiso 2</option>
                                <option value="3" >Permiso 3</option>
                                <option value="4" >Permiso 4</option>
                                <option value="5" >Permiso 5</option>
                                <option value="6" >Permiso 6</option>
                                <option value="7" >Permiso 7</option>

                              </select>
                      </div>
                      <div class="form-group" >
                         Area:
                              <select type="number" id="form_u_crear_area" name="area" class="input-form_u_crear form-control" error="Selecciona un area." required>
                                <option value="" selected>selecciona un area</option>
                                <option value="1" >Area 1</option>
                                <option value="2" >Area 2</option>
                                <option value="3" >Area 3</option>
                                <option value="4" >Area 4</option>
                                <option value="5" >Area 5</option>
                                <option value="6" >Area 6</option>
                              </select>
                      </div>


              </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btn_form_u_crear"   >Guardar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->




<!--NODAL CREAR-->

      <div class="modal fade" id="modal_u_editar"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Editar usuario</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form id="form_u_editar" name="form_u_editar" >

                      <div class="form-group" >
                        <input type="hidden" id="form_u_editar_id_usuario" value="" name="id_usuario" class="input-form_u_editar form-control" error="Selecciona correctamente el usuario." required>
                          Nombre:
                          <input type="text" id="form_u_editar_nombre" value="" name="nombre" class="input-form_u_editar form-control" error="Ingresa el nombre del usuario." placeholder="Ejemplo: Cesar Alejandro" required>
                      </div>
                       <div class="form-group" >
                          Apellido Paterno:
                          <input type="text" id="form_u_editar_apellidop" value="" name="apellidop" class="input-form_u_editar form-control" error="Ingesa el apellido paterno." placeholder="ejemplo: Lopez" required>
                      </div>
                       <div class="form-group" >
                          Apellido Materno:
                          <input type="text" id="form_u_editar_apellidom" value="" name="apellidom" class="input-form_u_editar form-control" error="Ingesa un apellido Materno." placeholder="ejemplo: Rodriguez" required>
                      </div>

                       <div class="form-group" >
                          Cuenta de Usuario:
                          <input type="text" id="form_u_editar_usuario" value="" name="usuario" class="input-form_u_editar form-control" error="Ingesa una cuenta de usuario." placeholder="ejemplo: cesaralejandro" disabled>
                      </div>

                       <div class="form-group" >
                         Estatus:
                              <select type="text" id="form_u_editar_estatus" name="estatus" class="input-form_u_editar form-control" error="Selecciona un permiso." >
                                <option value="A" >ACTIVO</option>
                                <option value="B" >BAJA</option>
                              </select>
                      </div>


                       <div class="form-group" >
                          Contraseña:
                          <input type="text" id="form_u_editar_contrasena" value="" name="contrasena" class="input-form_u_editar form-control" error="Ingesa una contrasena." placeholder="Ingresa una nueva contraseaña si deceas reemplazarla" >
                      </div>
                       <div class="form-group" >
                         Permiso:
                              <select type="number" id="form_u_editar_permiso" name="permiso" class="input-form_u_editar form-control" error="Selecciona un permiso." required>
                                <option value="" selected>selecciona un permiso</option>
                                <option value="1" >Permiso 1</option>
                                <option value="2" >Permiso 2</option>
                                <option value="3" >Permiso 3</option>
                                <option value="4" >Permiso 4</option>
                                <option value="5" >Permiso 5</option>
                                <option value="6" >Permiso 6</option>
                                <option value="7" >Permiso 7</option>

                              </select>
                      </div>
                      <div class="form-group" >
                         Area:
                              <select type="number" id="form_u_editar_area" name="area" class="input-form_u_editar form-control" error="Selecciona un area." required>
                                <option value="" selected>selecciona un area</option>
                                <option value="1" >Area 1</option>
                                <option value="2" >Area 2</option>
                                <option value="3" >Area 3</option>
                                <option value="4" >Area 4</option>
                                <option value="5" >Area 5</option>
                                <option value="6" >Area 6</option>
                                <option value="7" >Area 7</option>

                              </select>
                      </div>


              </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btn_form_u_editar">Guardar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->





      <!--ELIMINAR MODAL-->

      <div class="modal fade" id="modal_u_eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">AVISO</h4>
            </div>
            <div class="modal-body">
              <p>¿Está Seguro que desea eliminar este usuario?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" >Eliminar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

    <?php
       include_once("includes/scripts.php"); // INCLUDE SCRIPTS
    ?>
    <script src="controllers/usuarios.js"></script>



  </body>

</html>
