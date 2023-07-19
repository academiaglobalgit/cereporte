<?php 

  $titulo_header="Bienvenido";

?>
<!DOCTYPE >
<html style="width:100%; height:100% background-color:#4D4D4D;" >
  <head>  
  <?php include_once('includes/assets.php'); ?>
    <script src="controllers/login.js"></script>
  </head>
  <body style="width:100%; height:100%;  background-size:100%, 100%; background-color:#4D4D4D; background-repeat:no-repeat; background-image: url('assets/img/bg_1.jpg');  "  >
      
        <!-- VISTA CUANDO ESTÁ CARGANDO-->
     <!-- <div class="view_cargando" id="view_cargando" style="background-color: white;  vertical-align: center; width: 100%; height:100%; position: absolute; display:none;  opacity:0.85; z-index: 10;" ><br><br><br><br><br>
        <img style="position:relative;left: 45%; width: 5%;" src="assets/img/loading2.gif" alt="Espere un mmomento porfavor..."  ><br><strong style="position:relative;left: 40%;"  >Espere un momento porfavor.</strong>
      </div>-->
      <div class="container" style="position:relative; top:25%;"  >
         <div class="row"  >

            <div class="col-sm-6 text-center"  > <h1 style="color:#ecf0f1;" ><strong>Universidad de Casa Ley</strong> <br><small>Panel Interno</small></h1> </div>
            


            <div class="col-sm-6" style="border-left-style: solid;  border-left-width: 2px; border-color: #bdc3c7;" >
              <div class="row col-sm-8 col-sm-offset-2 text-left" >
                  <h3 style="color:#ecf0f1;" >Iniciar Sesión</h3>
              </div>
               <br>
              <div class="row col-sm-8 col-sm-offset-2" >
                <form class="form form-login" id="form_login" >

                  <div class="form-group">
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario" class="form-control input-form_login">
                  </div>
                  <div class="form-group">
                    <input type="password" name="contra" id="contra" placeholder="*****" class="form-control input-form_login">
                  </div>
                  
                  <div class="row col-sm-12 text-center" >
                    <h5 style="color:#e74c3c;" id="aviso_msg" ><br></h5>
                  </div>
                  <div class="form-group">
                    <button type="button" id="btn_login" class="btn btn-block btn-success" >Ingresar  <span class="glyphicon glyphicon-log-in"></span>  </button>
                  </div>
                </form>
              </div>
            </div>


         </div>
      </div>

      
    </body>
</html>