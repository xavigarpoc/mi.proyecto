<?php
include '../seguridad.php';
include '../conexion.php';

if(!isset($_GET['id'])){
    header("Location: productos.php");
    exit;
}

$id = intval($_GET['id']);

// Eliminar imagen si existe
$sqlImg = "SELECT imagen FROM productos WHERE id = $id";
$resImg = $conexion->query($sqlImg);
if($resImg->num_rows > 0){
    $row = $resImg->fetch_assoc();
    if($row['imagen'] != '' && file_exists('../uploads/'.$row['imagen'])){
        unlink('../uploads/'.$row['imagen']);
    }
}

// Eliminar producto
$sql = "DELETE FROM productos WHERE id = $id";
$conexion->query($sql);

header("Location: productos.php");
exit;
