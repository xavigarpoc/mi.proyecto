<?php
session_start();
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../seguridad.php";

$id = $_GET["id"];

$conexion->query("DELETE FROM noticias WHERE id = $id");

header("Location: listar.php");
exit;
$conexion->set_charset("utf8mb4");

