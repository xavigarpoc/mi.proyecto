<?php
session_start();
require_once __DIR__ . "/../seguridad.php";
require_once __DIR__ . "/../conexion.php";

$resultado = $conexion->query("SELECT * FROM productos ORDER BY id_producto DESC");
$conexion->set_charset("utf8mb4");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
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
    <h2>Lista de Productos</h2>

    <a href="crear.php">➕ Nuevo producto</a>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php while ($producto = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($producto["nombre"]) ?></td>
            <td><?= $producto["precio"] ?> €</td>
            <td><?= $producto["stock"] ?></td>
            <td><?= $producto["categoria"] ?></td>
            <td><?= $producto["activo"] == 1 ? 'Activo' : 'Inactivo' ?></td>
            <td>
                <a href="editar.php?id=<?= $producto["id_producto"] ?>">✏️ Editar</a> |
                <a href="eliminar.php?id=<?= $producto["id_producto"] ?>" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">🗑️ Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
