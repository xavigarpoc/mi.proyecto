?>

<?php
$envioCorrecto = false;

// CONEXIÓN A LA BASE DE DATOS
$conexion = new mysqli(
    "localhost",
    "cibert91492025",
    "OO!ig&0YLBue",
    "ciberteamfc_cat"
);

if ($conexion->connect_error) {
    die("Error de conexión");
}

if ($_POST) {

    $nombre   = trim($_POST["nombre"] ?? "");
    $correo   = trim($_POST["email"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $mensaje  = trim($_POST["mensaje"] ?? "");

    if ($nombre !== "" && $correo !== "" && $mensaje !== "") {

        // GUARDAR EN LA TABLA envios_web
        $stmt = $conexion->prepare(
            "INSERT INTO envios_web (nombre, email, telefono, mensaje)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param("ssss", $nombre, $correo, $telefono, $mensaje);
        $stmt->execute();
        $stmt->close();

        // (opcional) envío de email
        $para = "xavigarciaa.2008@gmail.com";
        $asunto = "Nuevo mensaje desde la web";

        $cuerpo  = "Nombre: $nombre\n";
        $cuerpo .= "Email: $correo\n";
        $cuerpo .= "Teléfono: $telefono\n\n";
        $cuerpo .= "Mensaje:\n$mensaje\n";

        $headers  = "From: Ciberteam FC <no-reply@ciberteamfc.cat>\r\n";
        $headers .= "Reply-To: $correo\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        mail($para, $asunto, $cuerpo, $headers);

        $envioCorrecto = true;
    }
}
?>