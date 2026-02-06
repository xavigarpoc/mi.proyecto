<?php
require_once "../seguridad.php";
require_once "../../conexion.php";

$resultado = $conexion->query("SELECT * FROM noticias ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Noticias</title>
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body>

<?php include "../menu.php"; ?>

<main>
    <h1>Gestión de noticias</h1>
    <a href="crear.php">➕ Nueva noticia</a>

    <table>
        <tr>
            <th>Título</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>

        <?php while ($noticia = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $noticia["titulo"] ?></td>
            <td><?= $noticia["fecha"] ?></td>
            <td>
                <a href="editar.php?id=<?= $noticia["id"] ?>">Editar</a>
                <a href="eliminar.php?id=<?= $noticia["id"] ?>" onclick="return confirm('¿Eliminar noticia?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>

</body>
</html>
