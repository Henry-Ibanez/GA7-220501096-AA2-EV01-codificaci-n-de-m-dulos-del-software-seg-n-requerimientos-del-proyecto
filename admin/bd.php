<?php

$servidor="localhost";
$baseDatos="restaurant";
$usuario="root";

$password="";

try {
    $conexion= new PDO( "mysql:host=$servidor; dbname=$baseDatos", $usuario, $password);
}catch (Exception $error){
    echo $error->getMessage();
}
?>