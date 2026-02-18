<?php
session_start();
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../seguridad.php";

$id = $_GET["id"];

$noticia = $conexion
    ->query("SELECT * FROM noticias WHERE id = $id")
    ->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titulo = $_POST["titulo"];
    $subtitulo = $_POST["subtitulo"];
    $contenido = $_POST["contenido"];
    $estado = $_POST["estado"];
    $fecha_publicacion = $_POST["fecha_publicacion"];

    // Si se ha subido una nueva imagen
    if (!empty($_FILES["imagen"]["name"])) {

        $nombreImagen = time() . "_" . $_FILES["imagen"]["name"];
        $rutaDestino = "../../img/noticias/" . $nombreImagen;

        move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino);

        $sql = "UPDATE noticias SET
            titulo = ?,
            subtitulo = ?,
            contenido = ?,
            imagen = ?,
            fecha_publicacion = ?,
            estado = ?
            WHERE id = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssssi", $titulo, $subtitulo, $contenido, $nombreImagen, $fecha_publicacion, $estado, $id);

    } else {

        $sql = "UPDATE noticias SET
            titulo = ?,
            subtitulo = ?,
            contenido = ?,
            fecha_publicacion = ?,
            estado = ?
            WHERE id = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssi", $titulo, $subtitulo, $contenido, $fecha_publicacion, $estado, $id);
    }

    $stmt->execute();

    header("Location: listar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar noticia</title>
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
    <h2>Editar noticia</h2>

    <a href="listar.php" class="btn-atras">← Volver al listado</a>
    <br><br>
    
    <form method="POST" enctype="multipart/form-data">

        <h3>Titulo:</h3>
        <input type="text" name="titulo"
               value="<?= htmlspecialchars($noticia["titulo"]) ?>" required><br><br>

        <h3>Subtitulo:</h3>
        <input type="text" name="subtitulo"
               value="<?= htmlspecialchars($noticia["subtitulo"]) ?>"><br><br>

        <h3>Contenido:</h3>
        <textarea name="contenido" rows="6" required><?= htmlspecialchars($noticia["contenido"]) ?></textarea><br><br>

        <h3>Imagen:</h3>
        <?php if (!empty($noticia["imagen"])): ?>
            <img src="/img/noticias/<?= $noticia["imagen"] ?>" width="150"><br><br>
        <?php endif; ?>

        <input type="file" name="imagen" accept="image/*"><br><br>
        
        <h3>Fecha:</h3>
        <input type="datetime-local" name="fecha_publicacion"
               value="<?= date("Y-m-d\TH:i", strtotime($noticia["fecha_publicacion"])) ?>" required><br><br>

        <h3>Estado:</h3>
        <select name="estado">
            <option value="borrador" <?= $noticia["estado"]=="borrador"?"selected":"" ?>>Borrador</option>
            <option value="publicada" <?= $noticia["estado"]=="publicada"?"selected":"" ?>>Publicada</option>
            <option value="archivada" <?= $noticia["estado"]=="archivada"?"selected":"" ?>>Archivada</option>
        </select><br><br>

        <button type="submit">Actualizar</button>
    </form>
</div>
</body>
</html>

