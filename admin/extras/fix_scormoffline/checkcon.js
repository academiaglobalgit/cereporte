$( document ).ready(function() {

var isOffline=false;
 

var template_error='<div class="wrap text-centered" style="text-align:center;"><div class="header"><div class="logo"><h1><a href="#">Se ha perdido la conexión a internet</a></h1></div></div><div class="content"><!--<img src="../internet.png" alt="Sin Red" title="error"/>--><p>Se Necesita <strong>conexión a internet</strong> para visualizar correctamente el <strong>Material o Examen</strong>.</p><strong>Favor de cerrar esta ventana y vuelva a intentar </strong><a href="#"></a><div class="copy-right"><p></p></div></div></div>';
               
        Offline.options = {checks: {xhr: {url: 'version.php'}}};

              Offline.on('confirmed-down', function () {

                //$("#page").html("<strong>Se necesita Acceso internet para realizar el examen. <br> Porfavor cierre esta ventana y vuelva a abrir el examen</strong>");
               
                if(!isOffline){
                  $("#page").html(template_error);
                  isOffline=true;
                }
 
              });

             /* Offline.on('confirmed-up', function () {
                   console.log("Connect ok!");

              });*/

      setInterval(function(){ 
          Offline.check();

        }, 4000);


});