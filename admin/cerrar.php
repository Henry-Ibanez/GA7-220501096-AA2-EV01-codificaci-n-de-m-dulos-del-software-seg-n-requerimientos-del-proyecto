<?php 
session_start();
session_destroy();
header("location:../index.php");
echo"salir...cerrar sesión"
?>