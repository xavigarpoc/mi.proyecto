<?php
require_once "../seguridad.php";
require_once "../../conexion.php";

if (!isset($_GET["id"])) {
    header("Location: listar.php");
    exit;
}

$id = intval($_GET["id"]);

$stmt = $conexion->prepare("DELETE FROM noticias WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: listar.php");
exit;
