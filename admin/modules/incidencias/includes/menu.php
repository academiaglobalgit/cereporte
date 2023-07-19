<div id="sidebar-wrapper">
      <ul id="sidebar_menu" class="sidebar-nav">
           <li class="sidebar-brand"><a id="menu-toggle" href="#">Menu<span id="main_icon" class="glyphicon glyphicon-menu-hamburger"></span></a></li>
      </ul>
        <ul class="sidebar-nav" id="sidebar">     
          <li><a href="index.php" >Inicio<span class="sub_icon glyphicon glyphicon-home"></span></a></li>
          <li><a href="incidencias.php" >Incidencias<span class="sub_icon glyphicon glyphicon-warning-sign"></span></a></li>

          <?php 
              if($id_permiso==1){

                echo ' 
                        <li><a href="problematicas.php" >Problematicas<span class="sub_icon glyphicon glyphicon-flag"></span></a></li>
                        <li><a href="categorias.php" >Categorias<span class="sub_icon glyphicon glyphicon-list"></span></a></li>
                        <li><a href="areas.php" >Areas<span class="sub_icon glyphicon glyphicon-th-large"></span></a></li>
                        <li><a href="usuarios.php" >Usuarios<span class="sub_icon glyphicon glyphicon-user"></span></a></li>
                ';
              }
          ?>
         

        </ul>
</div>
<div id="loading" class="col-md-12 text-center" style="display:none; opacity: 0.9; border-radius: 10px; z-index: 999; position:fixed; width:100%;height:100px; top:30%;" ><img src="assets/img/loading.gif" alt="Cargando..."  ></div>