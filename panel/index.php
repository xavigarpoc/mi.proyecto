<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}
?>  

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de administración</title>
    <link rel="stylesheet" href="css/panel.css">
</head>
<body>

<?php include "menu.php"; ?>

<main>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION["nombre"]); ?></h1>
    <p>Panel de administración Ciberteam FC</p>
</main>

</body>
</html>
