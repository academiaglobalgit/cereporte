<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <script src="js/angular.js"></script>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/bootstrap-collapse.js"></script>
  <script src="controller.js"></script>
   <script src="js/dirpagination.js"></script>
 <style>
tr
{
-webkit-transition: opacity 0.5s;
 -moz-transition: opacity 0.5s;
 -ms-transition: opacity 0.5s;
 -o-transition: opacity 0.5s;
 transition: opacity 0.5s;	
}
a { cursor :pointer; }

.alumno_activo
{
	opacity:1.0;
}
.alumno_baja
{
	opacity:0.5;
}
.tabletext_center{
	text-align:center;
}

.text_resplandor
{
	opacity: 1;
    -webkit-animation-name: resplandor; /* Chrome, Safari, Opera */
    -webkit-animation-duration: 2s; /* Chrome, Safari, Opera */
    -webkit-animation-iteration-count: 1000; /* Chrome, Safari, Opera */
    animation-name: resplandor;
    animation-duration: 2s;
    animation-iteration-count: 1000;
}

/* Chrome, Safari, Opera */
@-webkit-keyframes resplandor {
    0%   {color:red; left:0px; top:0px; opacity:1;}
    50%  {color:blue; left:0px; top:0px; opacity:0.5;}
    100% {color:red; left:0px; top:0px; opacity:1;}
}

/* Standard syntax */
@keyframes resplandor{
	0%   {color:red; left:0px; top:0px; opacity:1;}
    50%  {color:blue; left:0px; top:0px; opacity:0.5;}
    100% {color:red; left:0px; top:0px; opacity:1;}
}

 </style>

</head>



<body>
<!-- 
<div style="background-color:#182E4C; width:100%; height:195px;" ><center> <img id="imgLogo" src="http://agcollege.edu.mx/img/Logo-01.png" heigt="175px"></center></div>
<br>
-->
<div ng-app="appAdministrador" ng-controller="ctlAdministrador">

<div ng-include="'plan_estudio.html'"></div>

</div>
<!--  Administrador  -->



</div>
<!-- ADMINISTRADOR APP-->


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</body>
</html>

