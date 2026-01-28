<?php
$conexion = new mysqli("localhost", "cibert91492025", "OO!ig&0YLBue", "ciberteam");
if ($conexion->connect_error) {
    die("Error de conexión");
}

$conexion->set_charset("utf8");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conexion->prepare("
    SELECT titulo, subtitulo, contenido, imagen, fecha_publicacion
    FROM noticias
    WHERE id = ? AND estado = 'publicada'
");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$noticia = $resultado->fetch_assoc();

if (!$noticia) {
    die("Noticia no encontrada");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ciberteam FC</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="header1">
    <nav class="navbar">
        <div class="flex-header">
            <div class="menu-toggle" id="menu-toggle">&#9776;</div>
            <a href="http://ciberteamfc.cat/index.html" class="headermovil">
                <img src="http://ciberteamfc.cat/img/header/logoteam.png" alt="Logo Ciberteam FC" class="logo">
            </a>
        </div> 
        <ul>
            <li><a href="http://ciberteamfc.cat/index.html">Inicio</a></li>
            <li class="dropdown">
                <a href="">Club</a>
                <ul class="dropdown-content">
                    <li><a href="http://ciberteamfc.cat/club.historia.html">Historia</a></li>
                    <li><a href="http://ciberteamfc.cat/club.instalaciones.html">Instalaciones</a></li>
                    <li><a href="http://ciberteamfc.cat/club.patrocinadores.html">Patrocinadores</a></li>
                </ul>
            </li>
            <li><a href="http://ciberteamfc.cat/equipos.html">Equipos</a></li>
            <li><a href="http://ciberteamfc.cat/noticias.php">Noticias</a></li>
            <li><a href="http://ciberteamfc.cat/entradas.html">Entradas</a></li>
            <li><a href="http://ciberteamfc.cat/tienda.php">Tienda</a></li>
            <li><a href="http://ciberteamfc.cat/contacto.php">Contacto</a></li>
        </ul>
    </nav>
</header>

<header class="header2">
    <div class="top-bar">
        <a href="http://ciberteamfc.cat/index.html">
            <img src="http://ciberteamfc.cat/img/header/logoteam.png" alt="Logo Ciberteam FC" class="logo">
        </a>
        <input type="text" placeholder="Buscar" class="search-box">
        <span class="span1">Síguenos</span>
        <div class="logosheader">
            <img src="http://ciberteamfc.cat/img/header/logofacebook.png" class="logos">
            <img src="http://ciberteamfc.cat/img/header/logoyoutube.png" class="logos">
            <img src="http://ciberteamfc.cat/img/header/logolinkedin.png" class="logos">
            <img src="http://ciberteamfc.cat/img/header/logoinstagram.png" class="logos">
        </div>
        <div class="icons">
            <img src="http://ciberteamfc.cat/img/header/logocambioidioma.png" class="logosaparte1">
            <a href="carrito.php">
                <img src="http://ciberteamfc.cat/img/header/logocarritocompra.png" class="logosaparte2">
            </a>
        </div>
        <button class="login-btn">Iniciar Sesión</button>
    </div>
</header>

<main class="noticia-main">

    <div class="noticia-container">

        <?php if ($noticia['imagen']): ?>
            <div class="noticia-imagen">
                <img src="img/noticias/<?php echo htmlspecialchars($noticia['imagen']); ?>" alt="<?php echo htmlspecialchars($noticia['titulo']); ?>">
            </div>
        <?php endif; ?>

        <div class="noticia-texto">
            <h1 class="noticia-titulo"><?php echo htmlspecialchars($noticia['titulo']); ?></h1>

            <?php if ($noticia['subtitulo']): ?>
                <h3 class="noticia-subtitulo"><?php echo htmlspecialchars($noticia['subtitulo']); ?></h3>
            <?php endif; ?>

            <p class="noticia-contenido"><?php echo nl2br(htmlspecialchars($noticia['contenido'])); ?></p>

            <small class="noticia-fecha">
                Publicado el <?php echo date("d/m/Y H:i", strtotime($noticia['fecha_publicacion'])); ?>
            </small>

            <button onclick="window.history.back()" class="botonvolver">Volver a Noticias</button>
        </div>

    </div>

</main>

    <footer class="footer">
        <div class="footer1">
            <div class="footer1.1">
                <h1>Ciberteam FC</h1>
                <div class="footerredessociales">
                    <img src="http://ciberteamfc.cat/img/header/logofacebook.png" alt="Facebook" class="logosfooter">
                    <img src="http://ciberteamfc.cat/img/header/logoyoutube.png" alt="Youtube" class="logosfooter">
                    <img src="http://ciberteamfc.cat/img/header/logolinkedin.png" alt="Linkedin" class="logosfooter">
                    <img src="http://ciberteamfc.cat/img/header/logoinstagram.png" alt="Instagram" class="logosfooter">
                </div>
            </div>
        

            <div class="footer2">
              <h2>Patrocinadores</h2>
              <div class="patrocinadores">
                <ul>
                    <li onclick="window.open('https://www.coca-cola.com', '_blank')" class="patrocinadoresfooter">Coca Cola</li>
                    <li onclick="window.open('https://www.emirates.com', '_blank')" class="patrocinadoresfooter">Emirates</li>
                    <li onclick="window.open('https://es.louisvuitton.com', '_blank')" class="patrocinadoresfooter">Louis Vuitton</li>
                </ul>
                <ul>
                    <li onclick="window.open('https://www.caixabank.es', '_blank')" class="patrocinadoresfooter">Caixa Banc</li>
                    <li onclick="window.open('https://www.estrelladamm.com', '_blank')" class="patrocinadoresfooter">Estrella Damm</li>
                    <li onclick="window.open('https://eu.puma.com', '_blank')" class="patrocinadoresfooter">Puma</li>
                </ul>
                <ul>
                    <li onclick="window.open('https://www.nike.com', '_blank')" class="patrocinadoresfooter">Nike</li>
                    <li onclick="window.open('https://www.stoneisland.com', '_blank')" class="patrocinadoresfooter">Stone Island</li>
                    <li onclick="window.open('https://www.tecnocasa.es', '_blank')" class="patrocinadoresfooter">Tecnocasa</li>
                </ul>
              </div>
            </div>
            <h5 class="textofinal">Copyright CiberteamFC Página oficial del CiberteamFC</h5> 
            <h5 class="textofinal2">Terminos legales | Politica de Privavidad | Cookies | Accesibilidad | Centro de ayuda/FAQs | Gestión del consentimiento | Consent choices</h5>
        </div>

    </footer>

</body>
</html>
