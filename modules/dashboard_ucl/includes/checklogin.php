<?php
session_start();
if(isset($_SESSION['id_usuario'])){
  if($_SESSION['id_persona']!=0){
    $nombre_completo=$_SESSION['nombre_completo'];
    $id_persona=$_SESSION['id_persona'];
    $permisos=$_SESSION['permisos'];
    $id_permiso=$_SESSION['id_permiso'];
    $id_area=$_SESSION['id_area'];
  }else{
    $_SESSION['id_permiso']=null;
    $_SESSION['id_persona']=null;
    $_SESSION['permisos']=null;
    $_SESSION['id_corporacion']=null;
    $_SESSION['nombre_completo']=null;
    $_SESSION['id_area']=null;
    session_destroy();
    header("Location: login.php");
  }
}else{
    $_SESSION['id_permiso']=null;
    $_SESSION['id_persona']=null;
    $_SESSION['permisos']=null;
    $_SESSION['id_corporacion']=null;
    $_SESSION['nombre_completo']=null;
    $_SESSION['id_area']=null;
    session_destroy();
    //echo "<script>window.top.location.href='/cereporte'; </script>";
    header("Location: login.php");
}


?>