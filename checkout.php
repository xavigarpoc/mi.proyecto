<?php session_start(); ?>

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

           <div class="menu-toggle" id="menu-toggle"> &#9776; </div>

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
                
                <div>
                    <span class="span1">Síguenos</span>
                </div>

            <div class="logosheader">
                <a href=""><img src="http://ciberteamfc.cat/img/header/logofacebook.png" alt="Facebook" class="logos"></a>
                <a href=""><img src="http://ciberteamfc.cat/img/header/logoyoutube.png" alt="Youtube" class="logos"></a>
                <a href=""><img src="http://ciberteamfc.cat/img/header/logolinkedin.png" alt="Linkedin" class="logos"></a>
                <a href=""><img src="http://ciberteamfc.cat/img/header/logoinstagram.png" alt="Instagram" class="logos"></a>
            </div>
        
        
            <div class="icons">
                <a href=""><img src="http://ciberteamfc.cat/img/header/logocambioidioma.png" alt="" class="logosaparte1"></a>
                <a href="carrito.php"><img src="http://ciberteamfc.cat/img/header/logocarritocompra.png" alt="" class="logosaparte2"></a>
            </div>

            <button class="login-btn">Iniciar Sesión</button>
        </div>
    </header>

<main>

<h1 class="titulo-form">Datos del pedido</h1>
<div class="form-pedido-container">

<form action="procesar_pedido.php" method="POST" class="form-pedido">

    <!-- DATOS PERSONALES -->
    <label>Nombre *</label>
    <input type="text" name="nombre" required>

    <label>Apellidos *</label>
    <input type="text" name="apellidos" required>

    <label>DNI *</label>
    <input type="text" name="dni" maxlength="9" required>

    <label>Teléfono de contacto *</label>
    <input type="tel" name="telefono" required>

    <label>Email *</label>
    <input type="email" name="email" required>

    <!-- DIRECCIÓN -->
    <label>Dirección *</label>
    <input type="text" name="direccion" id="direccion" required>

    <button type="button" onclick="obtenerDireccion()">Usar mi ubicación actual</button>

    <label>Código Postal *</label>
    <input type="text" name="cp" required>

    <label>Población *</label>
    <input type="text" name="poblacion" required>

    <label>Provincia *</label>
    <input type="text" name="provincia" required>

    <!-- MÉTODO DE PAGO -->
    <label>Forma de pago *</label>

    <div class="metodos-pago">
        <label>
            <input type="radio" name="metodo_pago" value="tarjeta" required>
            Tarjeta de crédito / débito
        </label>

        <label>
            <input type="radio" name="metodo_pago" value="bizum">
            Bizum
        </label>

        <label>
            <input type="radio" name="metodo_pago" value="paypal">
            PayPal
        </label>

        <label>
            <input type="radio" name="metodo_pago" value="reembolso">
            Contra reembolso
        </label>
    </div>

    <!-- DATOS TARJETA -->
    <div id="pago-tarjeta" style="display:none;">
        <label>Número de tarjeta</label>
        <input type="text" name="numero_tarjeta" placeholder="XXXX XXXX XXXX XXXX">

        <label>Fecha de caducidad</label>
        <input type="text" name="caducidad" placeholder="MM/AA">

        <label>CVV</label>
        <input type="text" name="cvv" placeholder="123">
    </div>

    <!-- DATOS BIZUM -->
    <div id="pago-bizum" style="display:none;">
        <label>Teléfono Bizum</label>
        <input type="text" name="telefono_bizum">
    </div>

    <button type="submit">Confirmar pedido</button>

</form>
</div>

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
        function obtenerDireccion() {
            if (!navigator.geolocation) {
                alert("Tu navegador no soporta geolocalización");
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    // OpenStreetMap (Nominatim)
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.display_name) {
                                document.getElementById("direccion").value = data.display_name;
                            } else {
                                alert("No se pudo obtener la dirección");
                            }
                        })
                        .catch(() => {
                            alert("Error al obtener la dirección");
                        });
                },
                function () {
                    alert("Permiso de ubicación denegado");
                }
            );
        }
    </script>

    <script>
function obtenerDireccion() {
    if (!navigator.geolocation) {
        alert("Tu navegador no soporta geolocalización");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("direccion").value = data.display_name;
                })
                .catch(() => alert("Error al obtener la dirección"));
        },
        () => alert("Permiso de ubicación denegado")
    );
}

const radios = document.querySelectorAll('input[name="metodo_pago"]');
const tarjeta = document.getElementById("pago-tarjeta");
const bizum = document.getElementById("pago-bizum");

radios.forEach(radio => {
    radio.addEventListener("change", () => {
        tarjeta.style.display = "none";
        bizum.style.display = "none";

        if (radio.value === "tarjeta") {
            tarjeta.style.display = "block";
        }
        if (radio.value === "bizum") {
            bizum.style.display = "block";
        }
    });
});
</script>


</body>
