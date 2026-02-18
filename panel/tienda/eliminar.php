<?php
session_start();
require_once __DIR__ . "/../seguridad.php";
require_once __DIR__ . "/../conexion.php";

$id = $_GET["id"];
$conexion->query("DELETE FROM productos WHERE id_producto = $id");

header("Location: productos.php");
exit;
