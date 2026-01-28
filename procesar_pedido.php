    <?php
    session_start();
    $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

    if (
        !isset($_POST['nombre'], $_POST['apellidos'], $_POST['dni'], $_POST['telefono'], $_POST['email'], $_POST['direccion'], $_POST['cp'], $_POST['poblacion'], $_POST['provincia'], $_POST['metodo_pago'])
    ) {
        die("Datos incompletos del formulario");
    }

    $conexion->set_charset("utf8");

    
    //POST datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $cp = $_POST['cp'];
    $poblacion = $_POST['poblacion'];
    $provincia = $_POST['provincia'];
    $metodo_pago = $_POST['metodo_pago'];
    $base = $_POST['preciobase'];


    //Datos tarjeta o bizum
    $numero_tarjeta = isset($_POST['numero_tarjeta']) ? $_POST['numero_tarjeta'] : null;
    $caducidad = isset($_POST['caducidad']) ? $_POST['caducidad'] : null;
    $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : null;
    $telefono_bizum = isset($_POST['telefono_bizum']) ? $_POST['telefono_bizum'] : null;

    // CÁLCULO DE PRECIOS
    $base = 0;

    foreach ($carrito as $item) {

        $cantidad = $item['cantidad'];
        $precio_unitario = (float)$item['precio'];
        $descuento = isset($item['descuento']) ? (float)$item['descuento'] : 0;

        $subtotal = ($precio_unitario - $descuento) * $cantidad;
        $base += $subtotal;
    }

        $iva = $base * 0.21;  
        $total = $base + $iva;

    // CONEXION A LA BBDD
    $conexion = new mysqli("localhost", "cibert91492025", "OO!ig&0YLBue", "ciberteam");
    if ($conexion->connect_error) die("Error de conexión: " . $conexion->connect_error);

    $estado = "pendiente";  

    // TABLA PEDIDOS
    $stmt = $conexion->prepare("
        INSERT INTO pedidos (
            nombre, apellidos, dni, telefono, email, direccion, cp, poblacion, provincia,
            metodo_pago, preciobase, iva, total, estado
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssssssssssddds", $nombre, $apellidos, $dni, $telefono, $email, $direccion, $cp, $poblacion, $provincia, $metodo_pago, $base, $iva, $total, $estado
    );
    $stmt->execute();
    $id_pedido = $conexion->insert_id; 
    $stmt->close();

    // TABLA articulos_pedidos
    $stmt = $conexion->prepare("
    INSERT INTO articulos_pedidos 
    (id_pedido, id_producto, nombre, cantidad, precio_unitario, descuento, subtotal)
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($carrito as $item) {
        $id_producto = $item['id'];
        $nombre = $item['nombre'];  
        $cantidad = $item['cantidad'];
        $precio = $item['precio'];
        $descuento = isset($item['descuento']) ? (float)$item['descuento'] : 0;

        $subtotal = ($precio - $descuento) * $cantidad;

        $stmt->bind_param("iisiddd",
            $id_pedido,
            $id_producto,
            $nombre,
            $cantidad,
            $precio,
            $descuento,
            $subtotal
        );
        $stmt->execute();
    }

    $stmt->close();

    // TABLA PAGOS
    $stmt = $conexion->prepare("
    INSERT INTO pagos (id_pedido, numero_tarjeta, caducidad, cvv, telefono_bizum, precio_total)
    VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("issssd", $id_pedido, $numero_tarjeta, $caducidad, $cvv, $telefono_bizum, $total);
    $stmt->execute();
    $stmt->close();

    $conexion->close();
    unset($_SESSION['carrito']);

    /* ENVIO EMAIL DE CONFIRMACIÓN */

    $para = $email;
    $asunto = "Confirmación de tu pedido - Ciberteam FC";

    /* Mensaje */
    $mensaje = "Hola,\n\n";
    $mensaje .= "Gracias por tu compra en Ciberteam FC.\n\n";
    $mensaje .= "Número de pedido: $id_pedido\n\n";
    $mensaje .= "RESUMEN DEL PEDIDO:\n";

    foreach ($carrito as $item) {
        $precio_con_descuento = $item['precio'] - (isset($item['descuento']) ? $item['descuento'] : 0);
        $mensaje .= "- " . $item['nombre'] . " | ";
        $mensaje .= "Cantidad: " . $item['cantidad'] . " | ";
        $mensaje .= "Precio: " . number_format($precio_con_descuento, 2) . " €\n";
    }

    $mensaje .= "\nBase imponible: " . number_format($base, 2) . " €";
    $mensaje .= "\nIVA (21%): " . number_format($iva, 2) . " €";
    $mensaje .= "\nTOTAL: " . number_format($total, 2) . " €\n\n";

    $mensaje .= "Dirección de envío:\n";
    $mensaje .= "$direccion\n$cp - $poblacion ($provincia)\n\n";
    $mensaje .= "Método de pago: $metodo_pago\n\n";
    $mensaje .= "Gracias por confiar en nosotros.\n";
    $mensaje .= "Ciberteam FC";

    // Cabeceras
    $cabeceras = "From: Ciberteam FC <no-reply@ciberteamfc.cat>\r\n";
    $cabeceras .= "Content-Type: text/plain; charset=UTF-8";

    // Envío
    mail($para, $asunto, $mensaje, $cabeceras);
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
                <li><a href="http://ciberteamfc.cat/noticias.php">Noticias</a></li>
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

    <div class="divprocesar">

    <h1>Pedido confirmado</h1>

    <p>Gracias <strong><?php echo htmlspecialchars($nombre); ?></strong></p>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>
    <p>Dirección: <?php echo htmlspecialchars($direccion); ?></p>

    <h2>Resumen del pedido</h2>

        <?php foreach($carrito as $item): ?>
    <p>
        <?php echo htmlspecialchars($item['nombre']); ?> -
        <?php 
            $precio_con_descuento = $item['precio'] - (isset($item['descuento']) ? $item['descuento'] : 0);
            echo number_format($precio_con_descuento, 2); 
        ?> € 
        (x<?php echo $item['cantidad']; ?>)
    </p>
        <?php endforeach; ?>

    <p><strong>Base imponible:</strong> <?php echo number_format($base, 2); ?> €</p>
    <p><strong>IVA (21%):</strong> <?php echo number_format($iva, 2); ?> €</p>
    <p><strong>Total:</strong> <?php echo number_format($total, 2); ?> €</p>

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