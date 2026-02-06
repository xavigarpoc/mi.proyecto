<?php
require_once "../seguridad.php";
require_once "../../conexion.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"]);
    $contenido = trim($_POST["contenido"]);

    if (!empty($titulo) && !empty($contenido)) {

        $stmt = $conexion->prepare(
            "INSERT INTO noticias (titulo, contenido, fecha) VALUES (?, ?, NOW())"
        );
        $stmt->bind_param("ss", $titulo, $contenido);

        if ($stmt->execute()) {
            header("Location: listar.php");
            exit;
        } else {
            $error = "Error al crear la noticia";
        }

    } else {
        $error = "Rellena todos los campos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva noticia</title>
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body>

<?php include "../menu.php"; ?>

<main>
    <h1>Nueva noticia</h1>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="post" class="form-panel">
        <input type="text" name="titulo" placeholder="Título de la noticia" required>

        <textarea name="contenido" placeholder="Contenido de la noticia" rows="6" required></textarea>

        <button type="submit">Guardar noticia</button>
        <a href="listar.php" class="btn-cancelar">Cancelar</a>
    </form>
</main>

</body>
</html>
