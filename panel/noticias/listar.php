<?php
session_start();
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../seguridad.php";


$sql = "SELECT * FROM noticias ORDER BY id DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">    
<head>
    <meta charset="UTF-8">
    <title>Noticias</title>
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
    <h2>Noticias</h2>

    <a href="crear.php">➕ Nueva noticia</a><br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>Título</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>

        <?php while ($n = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($n["titulo"]) ?></td>
            <td><?= $n["estado"] ?></td>
            <td><?= $n["fecha_publicacion"] ?></td>
            <td>
                <a href="editar.php?id=<?= $n["id"] ?>">✏️ Editar</a> |
                <a href="eliminar.php?id=<?= $n["id"] ?>" onclick="return confirm('¿Seguro?')">🗑 Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
