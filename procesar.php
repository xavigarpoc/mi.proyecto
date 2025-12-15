<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Acceso no permitido.";
    exit;
}

// Recoger y limpiar datos
$nombre   = trim($_POST["nombre"] ?? "");
$correo   = trim($_POST["email"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$mensaje  = trim($_POST["mensaje"] ?? "");

// Validación básica
if ($nombre === "" || $correo === "" || $mensaje === "") {
    echo "Faltan campos obligatorios.";
    exit;
}

// Email destino
$para = "xavigarciaa.2008@gmail.com";

// Asunto
$asunto = "Nuevo mensaje desde ciberteamfc.cat";

// Cuerpo del mensaje
$cuerpo = "Has recibido un nuevo mensaje desde el formulario web:\n\n";
$cuerpo .= "Nombre: $nombre\n";
$cuerpo .= "Correo: $correo\n";
$cuerpo .= "Teléfono: $telefono\n\n";
$cuerpo .= "Mensaje:\n$mensaje\n";

// Cabeceras (MUY IMPORTANTE)
$headers  = "From: Ciberteam FC <no-reply@ciberteamfc.cat>\r\n";
$headers .= "Reply-To: $correo\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Enviar correo
if (mail($para, $asunto, $cuerpo, $headers)) {
    echo "<h2>Mensaje enviado correctamente</h2>";
    echo "<a href='contacto.html'>Volver</a>";
} else {
    echo "<h2>Error al enviar el mensaje</h2>";
    echo "<a href='contacto.html'>Volver</a>";
}
?>