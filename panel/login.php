<?php
session_start();
require_once "../conexion.php";

session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    if ($email === '' || $password === '') {
        die("Faltan datos");
    }

    $sql = "SELECT id_usuario, password, rol FROM usuarios WHERE email = ? LIMIT 1";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("Error en prepare");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // ❌ Usuario no existe
    if ($stmt->num_rows !== 1) {
        die("Usuario o contraseña incorrectos");
    }

    // ✅ Ahora sí es seguro
    $stmt->bind_result($id_usuario, $hash, $rol);
    $stmt->fetch();

    if (!is_string($hash)) {
        die("Error interno de contraseña");
    }

    if (!password_verify($password, $hash)) {
        die("Usuario o contraseña incorrectos");
    }

    // ✅ Login OK
    $_SESSION["id_usuario"] = $id_usuario;
    $_SESSION["rol"] = $rol;

    header("Location: ../panel/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../panel/css/panel.css">
</head>
<body>

<main>
    <div class="login-box">
        <h2>Panel de Administración</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
</main>

</body>
</html>
