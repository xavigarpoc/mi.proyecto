<?php
session_start();
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../seguridad.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST["titulo"];
    $subtitulo = $_POST["subtitulo"];
    $contenido = $_POST["contenido"];
    $estado = $_POST["estado"];

    $sql = "INSERT INTO noticias 
        (titulo, subtitulo, contenido, estado, fecha_publicacion)
        VALUES (?, ?, ?, ?, NOW())";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $titulo, $subtitulo, $contenido, $estado);
    $stmt->execute();

    header("Location: listar.php");
    exit;
}
$conexion->set_charset("utf8mb4");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva noticia</title>
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
    <h2>Nueva noticia</h2>

    <a href="listar.php" class="btn-atras">← Volver al listado</a>
    <br><br>

<form method="POST" enctype="multipart/form-data">

    <h3>Título:</h3>
    <input type="text" name="titulo" required><br><br>

    <h3>Subtítulo:</h3>
    <input type="text" name="subtitulo"><br><br>

    <h3>Contenido:</h3>
    <textarea name="contenido" rows="6" required></textarea><br><br>

    <h3>Imagen:</h3>
    <input type="file" name="imagen" accept="image/*"><br><br>

    <h3>Fecha:</h3>
    <input type="datetime-local" name="fecha_publicacion" required><br><br>

    <h3>Estado:</h3>
    <select name="estado">
        <option value="borrador">Borrador</option>
        <option value="publicada">Publicada</option>
        <option value="archivada">Archivada</option>
    </select><br><br>

    <button type="submit">Guardar</button>

</form>

</div>

</body>
</html>
