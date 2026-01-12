<?php
session_start();

/* AÑADIR PRODUCTO AL CARRITO */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_producto'])) {

    $id = $_POST['id_producto'];

    if (!isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id] = [
            'id' => $id,
            'nombre' => $_POST['nombre'],
            'precio' => $_POST['precio'],
            'cantidad' => 1
        ];
    } else {
        $_SESSION['carrito'][$id]['cantidad']++;
    }
}

/* MODIFICAR CANTIDAD / ELIMINAR */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['accion'], $_POST['id'])) {

    $id = $_POST['id'];
    $accion = $_POST['accion'];

    if (isset($_SESSION['carrito'][$id])) {
        switch ($accion) {
            case 'sumar':
                $_SESSION['carrito'][$id]['cantidad']++;
                break;

            case 'restar':
                $_SESSION['carrito'][$id]['cantidad']--;
                if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
                    unset($_SESSION['carrito'][$id]);
                }
                break;

            case 'eliminar':
                unset($_SESSION['carrito'][$id]);
                break;
        }
    }
}
?>

<?php
$total_carrito = 0;

if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total_carrito += $item['precio'] * $item['cantidad'];
    }
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
            <li><a href="http://ciberteamfc.cat/tienda.php">Tienda</a></li>
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
        <span class="span1">Síguenos</span>
        <div class="logosheader">
            <img src="http://ciberteamfc.cat/img/header/logofacebook.png" class="logos">
            <img src="http://ciberteamfc.cat/img/header/logoyoutube.png" class="logos">
            <img src="http://ciberteamfc.cat/img/header/logolinkedin.png" class="logos">
            <img src="http://ciberteamfc.cat/img/header/logoinstagram.png" class="logos">
        </div>
        <div class="icons">
            <a href="carrito.php"><img src="http://ciberteamfc.cat/img/header/logocarritocompra.png" class="logosaparte2"></a>
        </div>
        <button class="login-btn">Iniciar Sesión</button>
    </div>
</header>

<main>
<h1 class="titulopagina123">Carrito de compra</h1>

<div class="carrito-layout3">
    <div class="tiendadiv3 carrito-productos3">

<?php
if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        ?>
        <div class="productostienda3">
            <h1 class="textotienda3"><?php echo $item['nombre']; ?></h1>
            <p class="textotienda4">Precio: <?php echo number_format($item['precio'], 2); ?> €</p>
            <p class="textotienda4">Cantidad: <?php echo $item['cantidad']; ?></p>
            <p class="textotienda4">Total: <?php echo number_format($item['precio'] * $item['cantidad'], 2); ?> €</p>

            <div class="botones-carrito3">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    <input type="hidden" name="accion" value="sumar">
                    <button type="submit">+</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    <input type="hidden" name="accion" value="restar">
                    <button type="submit">−</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    <input type="hidden" name="accion" value="eliminar">
                    <button type="submit">Eliminar</button>
                </form>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p>El carrito está vacío</p>";
}
?>

</div>

    <div class="resumen-carrito3">
        <h2>Resumen del pedido</h2>

        <div class="resumen-linea3">
            <span class="textotienda4">Total productos</span>
            <span><?php echo number_format($total_carrito, 2); ?> €</span>
        </div>

        <div class="resumen-linea3 total3">
            <span>Total</span>
            <span><?php echo number_format($total_carrito, 2); ?> €</span>
        </div>

        <div class="botones33">
        <a href="checkout.php" class="btn-resumen3">Finalizar compra</a>
        <a href="tienda.php" class="btn-resumen3">Continuar comprando</a>
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
