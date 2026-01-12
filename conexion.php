<?php
$host = "localhost";
$usuario = "cibert91492025";
$password = "OO!ig&0YLBue";
$bd = "ciberteam"; // nombre de tu base de datos

$conexion = new mysqli($host, $usuario, $password, $bd);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>