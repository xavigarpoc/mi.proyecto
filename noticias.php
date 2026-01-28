<?php
$conexion = new mysqli("localhost", "cibert91492025", "OO!ig&0YLBue", "ciberteam");
if ($conexion->connect_error) {
    die("Error de conexión");
}

$conexion->set_charset("utf8");

$buscar = "";
$fecha_inicio = "";
$fecha_fin = "";

if (isset($_GET['fecha_inicio']) && !empty($_GET['fecha_inicio'])) {
    $fecha_inicio = $conexion->real_escape_string($_GET['fecha_inicio']);
}

if (isset($_GET['fecha_fin']) && !empty($_GET['fecha_fin'])) {
    $fecha_fin = $conexion->real_escape_string($_GET['fecha_fin']);
}

if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $buscar = $conexion->real_escape_string($_GET['buscar']);
}


$sql = "
    SELECT id, titulo, subtitulo, imagen, fecha_publicacion
    FROM noticias
    WHERE estado = 'publicada'
";

if ($buscar !== "") {
    $sql .= " AND (titulo LIKE '%$buscar%' OR subtitulo LIKE '%$buscar%')";
}

if ($fecha_inicio !== "" && $fecha_fin !== "") {
    $sql .= " AND DATE(fecha_publicacion) BETWEEN '$fecha_inicio' AND '$fecha_fin'";
} elseif ($fecha_inicio !== "") {
    $sql .= " AND DATE(fecha_publicacion) >= '$fecha_inicio'";
} elseif ($fecha_fin !== "") {
    $sql .= " AND DATE(fecha_publicacion) <= '$fecha_fin'";
}

$sql .= " ORDER BY fecha_publicacion DESC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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

<main>

    <div class="titulopag">
        <h1>NOTICIAS</h1>
    </div>

    <div class="barraseparacion"></div>

<form method="GET" class="buscadornoticias">
    <input 
        type="text" 
        name="buscar" 
        placeholder="Buscar por título o subtítulo"
        class="botonesnoticias"
        value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>">

    <div class="rango-fechas">
        <span class="texto-fecha">Desde:</span>
        <input 
            type="date" 
            name="fecha_inicio"
            class="botonesnoticias"
            value="<?php echo isset($_GET['fecha_inicio']) ? htmlspecialchars($_GET['fecha_inicio']) : '2025-01-01'; ?>">
    
        <span class="texto-fecha">Hasta:</span>
        <input 
            type="date" 
            name="fecha_fin"
            class="botonesnoticias"
            value="<?php echo isset($_GET['fecha_fin']) ? htmlspecialchars($_GET['fecha_fin']) : '2026-01-31'; ?>">
    </div>

    <button type="submit" class="botonesnoticias2">Buscar</button>

    <button type="button" id="resetFilters" class="botonesnoticias2">Restablecer filtros</button>

</form>


<div class="noticiasdivs">
    <?php while ($noticia = $resultado->fetch_assoc()): ?>
        <div class="noticias123">
            <div class="edicionnoticia">
                <div class="noticiasimg"
                     style="background-image: url('img/noticias/<?php echo htmlspecialchars($noticia['imagen']); ?>');">
                </div>
            </div>

            <div class="textonoticias">
                <h2><?php echo htmlspecialchars($noticia['titulo']); ?></h2>

                <?php if (!empty($noticia['subtitulo'])): ?>
                    <p><?php echo htmlspecialchars($noticia['subtitulo']); ?></p>
                <?php endif; ?>

                <small class="smallfecha">Publicado el: <?php echo htmlspecialchars($noticia['fecha_publicacion']); ?></small>

                <a href="noticia.php?id=<?php echo $noticia['id']; ?>" class="btnmejorasestadio">
                    Ir a la noticia
                </a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

</main>


    <footer class="footer">
        <div class="footer1">
            <div class="footer11">
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

<script>
const toggle = document.getElementById("menu-toggle");
const header1 = document.querySelector(".header1");
toggle.addEventListener("click", () => {
    header1.classList.toggle("active");
});
</script>

<button id="btnTop">⇧</button>

<script>
window.addEventListener("scroll", function () {
    const b = document.getElementById("btnTop");
    b.style.display = window.scrollY > 200 ? "block" : "none";
});
document.getElementById("btnTop").onclick = function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
};
</script>

<script>
document.getElementById("resetFilters").addEventListener("click", function() {

    document.querySelector('input[name="buscar"]').value = '';
    document.querySelector('input[name="fecha_inicio"]').value = '';
    document.querySelector('input[name="fecha_fin"]').value = '';

    window.location.href = window.location.pathname;
});
</script>

</body>
</html>
