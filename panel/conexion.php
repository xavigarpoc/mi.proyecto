<?php
$host = "localhost";
$user = "cibert91492025";   
$pass = "OO!ig&0YLBue";
$db   = "ciberteam";

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}  

$conexion->set_charset("utf8mb4");
?>