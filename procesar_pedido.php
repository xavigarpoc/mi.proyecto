<?php
session_start();

if (
    !isset($_POST['nombre'], $_POST['email'], $_POST['direccion']) ||
    !isset($_SESSION['carrito']) ||
    empty($_SESSION['carrito'])
) {
    die("Acceso no válido");
}

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$carrito = $_SESSION['carrito'];

$total = 0;
foreach ($carrito as $item) {
    $cantidad = isset($item['cantidad']) ? $item['cantidad'] : 1;
    $total += $item['precio'] * $cantidad;
}
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
                <img src="http://ciberteamfc.cat/img/header/logoteam.png" class="logo">
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
            <li><a href="http://ciberteamfc.cat/noticias.html">Noticias</a></li>
            <li><a href="http://ciberteamfc.cat/entradas.html">Entradas</a></li>
            <li><a href="http://ciberteamfc.cat/tienda.html">Tienda</a></li>
            <li><a href="http://ciberteamfc.cat/contacto.php">Contacto</a></li>
        </ul>
    </nav>
</header>

<header class="header2">
    <div class="top-bar">
        <a href="http://ciberteamfc.cat/index.html">
            <img src="http://ciberteamfc.cat/img/header/logoteam.png" class="logo">
        </a>

        <input type="text" placeholder="Buscar" class="search-box">

        <div><span class="span1">Síguenos</span></div>

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

<body>
<div class="divprocesar">

<h1>Pedido confirmado</h1>

<p>Gracias <strong><?php echo htmlspecialchars($nombre); ?></strong></p>
<p>Email: <?php echo htmlspecialchars($email); ?></p>
<p>Dirección: <?php echo htmlspecialchars($direccion); ?></p>

<h2>Resumen del pedido</h2>

<?php foreach ($carrito as $item) { ?>
    <p>
        <?php echo htmlspecialchars($item['nombre']); ?> -
        <?php echo number_format($item['precio'],2); ?> €
        (x<?php echo isset($item['cantidad']) ? $item['cantidad'] : 1; ?>)
    </p>
<?php } ?>

<p><strong>Total: <?php echo number_format($total, 2); ?> €</strong></p>

</div>

</body>

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

</html>

<?php
unset($_SESSION['carrito']);
?>

