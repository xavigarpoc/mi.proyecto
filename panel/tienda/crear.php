<?php
session_start();
require_once __DIR__ . "/../seguridad.php";
require_once __DIR__ . "/../conexion.php";

if ($_POST) {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $imagen = $_POST["imagen"];
    $stock = $_POST["stock"];
    $categoria = $_POST["categoria"];
    $activo = $_POST["activo"];
    $descuento = $_POST["descuento"];

    $conexion->query("
        INSERT INTO productos (nombre, descripcion, precio, imagen, stock, categoria, activo, descuento)
        VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$stock', '$categoria', '$activo', '$descuento')
    ");

    header("Location: productos.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body>

<nav class="menu-panel">

    <div class="headers5-top">
        <img src="http://ciberteamfc.cat/img/header/logoteam.png" alt="Logo" class="headers5-logo">
        <h1 class="headers5-title">Panel Administración</h1>
    </div>

    <ul class="headers5-menu">
        <li><a href="/panel/menu.php">Inicio</a></li>
        <li><a href="/panel/noticias/listar.php">Noticias</a></li>
        <li><a href="/panel/tienda/productos.php">Tienda</a></li>
        <li><a href="/panel/logout.php">Cerrar sesión</a></li>
    </ul>

</nav>

<div class="contenido">
    <h2>Crear Nuevo Producto</h2>

    <a href="productos.php" class="btn-atras">← Volver al listado</a>
    <br><br>

<form method="POST" enctype="multipart/form-data">

    <h3>Nombre:</h3>
    <input type="text" name="nombre" required><br><br>

    <h3>Descripción:</h3>
    <textarea name="descripcion" required></textarea><br><br>

    <h3>Precio:</h3>
    <input type="number" step="0.01" name="precio" required><br><br>

    <h3>Imagen:</h3>
    <input type="file" name="imagen" accept="image/*" required><br><br>

    <h3>Stock:</h3>
    <input type="number" name="stock" required><br><br>

    <h3>Categoría:</h3>
    <input type="text" name="categoria" required><br><br>

    <h3>Estado:</h3>
    <select name="activo">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </select><br><br>

    <h3>Descuento:</h3>
    <input type="number" step="0.01" name="descuento"><br><br>

    <button type="submit">Guardar Producto</button>

</form>

</div>

</body>
</html>
