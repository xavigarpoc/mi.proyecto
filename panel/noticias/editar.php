<?php
require_once "../seguridad.php";
require_once "../../conexion.php";

if (!isset($_GET["id"])) {
    header("Location: listar.php");
    exit;
}

$id = intval($_GET["id"]);
$error = "";

/* Obtener noticia */
$stmt = $conexion->prepare("SELECT * FROM noticias WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    header("Location: listar.php");
    exit;
}

$noticia = $resultado->fetch_assoc();

/* Actualizar */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"]);
    $contenido = trim($_POST["contenido"]);

    if (!empty($titulo) && !empty($contenido)) {
        $stmt = $conexion->prepare(
            "UPDATE noticias SET titulo = ?, contenido = ? WHERE id = ?"
        );
        $stmt->bind_param("ssi", $titulo, $contenido, $id);

        if ($stmt->execute()) {
            header("Location: listar.php");
            exit;
        } else {
            $error = "Error al actualizar";
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
    <title>Editar noticia</title>
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body>

<?php include "../menu.php"; ?>

<main>
    <h1>Editar noticia</h1>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="post" class="form-panel">
        <input type="text" name="titulo" value="<?= htmlspecialchars($noticia["titulo"]) ?>" required>

        <textarea name="contenido" rows="6" required><?= htmlspecialchars($noticia["contenido"]) ?></textarea>

        <button type="submit">Guardar cambios</button>
        <a href="listar.php" class="btn-cancelar">Cancelar</a>
    </form>
</main>

</body>
</html>
