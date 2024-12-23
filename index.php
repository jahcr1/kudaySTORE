<?php
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kuday Argentina Sitio Oficial</title>

  <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Delius+Unicase:wght@400;700&family=Fuzzy+Bubbles:wght@400;700&family=Gwendolyn:wght@400;700&family=Homemade+Apple&family=Just+Me+Again+Down+Here&family=Kablammo&family=Klee+One&family=Ms+Madi&family=Mystery+Quest&family=Pacifico&family=Playwrite+IT+Moderna:wght@100..400&family=Poiret+One&family=Teko:wght@300..700&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap" rel="stylesheet">

  <!-- ICONOS DE BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- CSS DE BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- CSS PROPIO-->
  <link rel="stylesheet" href="./CSS/styles.css">

</head>

<body class="index-body">

  <header>
    <nav class="navbar navbar-expand-lg index-nav fixed-top">
      <div class="container-fluid" style="flex-wrap: wrap;">
        <a class="navbar-brand marca align-self-center text-center" href="index.php#inicio">Kuday Artesanias</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 600px; margin-right:50px;">
            <li class="nav-item">
              <a class="nav-link active boton-nav" href="index.php#inicio">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active boton-nav" aria-current="page" href="index.php#titulo_tienda">Tienda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active boton-nav" href="index.php#titulo_promociones">Promociones</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Productos
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="vistas/cartucheras.php">Cartucheras</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="vistas/neceser.php">Neceser</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="vistas/setmatero.php">Sets Materos</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item " href="vistas/billeteras.php">Billeteras</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="vistas/bolsomatero.php">Bolso Matero</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="vistas/bandoleras.php">Bandoleras</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="vistas/varios.php">Varios</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="vistas/promociones.php">Promociones</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link active boton-nav" href="index.php#seccion_footer">Contactános</a>
            </li>
            <li class="nav-item cart-item">
              <a href="./carrito.php" class="cart-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-cart">
                  <circle cx="9" cy="21" r="1"></circle>
                  <circle cx="20" cy="21" r="1"></circle>
                  <path d="M1 1h4l2.68 13.39a1 1 0 0 0 1 .86h9.72a1 1 0 0 0 1-.76l2.54-9.24a1 1 0 0 0-.96-1.24H5.21"></path>
                </svg>
                <span id="cart-count"><?php echo $cartCount; ?></span>
              </a>
            </li>

          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section id="inicio">
    <div class="container text-center">
      <div class="d-flex" id="box_inicio">
        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-4 align-self-center mx-auto">
          <h1 class="mx-auto text-center p-2"><span id="logo_texto">Kuday<br>Creaciones Artesanales</span></h1>
          <p>Buscá lo que necesitás en nuestra tienda Online.</p>
          <p>Envios a todo el país.</p>
        </div>

        <div class="col-xl-6 col-lg-5 col-md-5 col-sm-8" id="presentacion">
          <img src="images/logo/logo.png" class="logo object-fit-cover " alt="logo">
        </div>
      </div>
    </div>
    <div class="text-center mx-auto" id="minibanner">
        <h2 class="fs-5 p-3"><span class="text-primary">KUDAY</span> es una tienda unica donde vas a encontrar las mejores <span class="text-primary text-center"> Promociones</span> todos los meses.</h2>
    </div>
  </section>

  <section class="carrusel">
    <div class="container-fluid">
      <div id="carouselExampleSlidesOnly" class="carousel slide car pt-2 pb-3" data-bs-ride="carousel">
        <div class="carousel-inner carusel-index mx-auto">
          <div class="carousel-item active" data-bs-interval="4000">
            <img src="images/carousel/glaciar1.jpg" class="foto-carousel" alt="slide1">
            <div class="carousel-caption text-start">
              <h5>SE VIENE EL VERANO CON TODO</h5>
              <p>Y en Kuday sabemos lo que necesitás</p>
            </div>
            <div class="carousel-button">
              <a href="#" class="btn-invisible">Click Me</a>
            </div>
          </div>

          <div class="carousel-item" data-bs-interval="4000">
            <img src="images/carousel/glaciar2.jpg" class="foto-carousel" alt="slide2">
            <div class="carousel-caption text-start">
              <h5>SE VIENE EL VERANO CON TODO</h5>
              <p>Visita nuestras promociones todo el año</p>
            </div>
            <div class="carousel-button">
              <a href="#" class="btn-invisible">Ver Promos</a>
            </div>
          </div>
          <div class="carousel-item" data-bs-interval="4000">
            <img src="images/carousel/baner3.jpg" class="foto-carousel" alt="slide3">
            <div class="carousel-caption text-start">
              <h5>SE VIENE EL VERANO CON TODO</h5>
              <p>Te compro todo mameeeee.</p>
            </div>
            <div class="carousel-button">
              <a href="#" class="btn-invisible">VER PRODUCTOS</a>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

    </div>
  </section>

  <section id="tienda-index">
    <h3 class="text-center titulo" style="margin-top: 100px;" id="titulo_tienda">Tienda Kuday</h3>
    <div class="container" style="margin-top: 50px; padding-bottom:150px;">

      <div class="mainbox-store row justify-content-evenly">

        <div class="col-md-5 fondo-store1 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente1"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor1">
            <img src="./images/tienda/cartuchera3.png" alt="Cartuchera" class="imagen1">
          </div>
          <a href="./vistas/cartucheras.php" target="_blank" class="texto-store1">Cartucheras</a>
        </div>

        <div class="col-md-5 fondo-store2 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente2"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor2">
            <img src="./images/tienda/cartuchera3.png" alt="Neceser" class="imagen2">
          </div>
          <a href="./vistas/neceser.php" target="_blank" class="texto-store2">Neceser</a>
        </div>

        <div class="col-md-5 fondo-store3 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente3"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor3">
            <img src="./images/tienda/cartuchera3.png" alt="Billeteras" class="imagen3">
          </div>
          <a href="./vistas/billeteras.php" target="_blank" class="texto-store3">Billeteras</a>
        </div>

        <div class="col-md-5 fondo-store4 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente4"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor4">
            <img src="./images/tienda/cartuchera3.png" alt="Bandoleras" class="imagen4">
          </div>
          <a href="./vistas/bandoleras.php" target="_blank" class="texto-store4">Bandoleras</a>
        </div>

        <div class="col-md-5 fondo-store5 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente5"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor5">
            <img src="./images/tienda/cartuchera3.png" alt="Bolsomatero" class="imagen5">
          </div>
          <a href="./vistas/bolsomatero.php" target="_blank" class="texto-store5">Bolsos Materos</a>
        </div>

        <div class="col-md-5 fondo-store6 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente6"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor6">
            <img src="./images/tienda/setv31.png" alt="Set Matero" class="imagen6">
          </div>
          <a href="./vistas/setmatero.php" target="_blank" class="texto-store6">Set Matero</a>
        </div>

        <div class="col-md-5 fondo-store7 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente7"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor7">
            <img src="./images/tienda/portad1.png" alt="Varios" class="imagen7">
          </div>
          <a href="./vistas/varios.php" target="_blank" class="texto-store7">Varios</a>
        </div>

        <div class="col-md-5 fondo-store8 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente8"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor8">
            <img src="./images/tienda/cartuchera3.png" alt="Promociones" class="imagen8">
          </div>
          <a href="./vistas/promociones.php" target="_blank" class="texto-store8">Promociones</a>
        </div>

      </div>

    </div>
  </section>

  <section id="promociones" class="slider-container">
    <h3 class="titulo" id="titulo_promociones">Nuestras promociones</h3>

    <div class="slider-wrapper">
      <div class="slider">
        <div class="slider-track">
          <!-- Consultamos los productos con categoria_id = 8 -->
          <?php
          include('./componentes/conexion.php');
          // Consulta SQL con límite de 10 productos
          $consultar_productos = mysqli_query(
            $conexion,
            "SELECT p.*, c.nombre AS categoria_nombre 
                     FROM productos p 
                     JOIN categorias c ON p.categoria_id = c.id 
                     WHERE p.categoria_id = '8' 
                     LIMIT 10"
          );

          // Iteramos los productos
          while ($listar_productos = mysqli_fetch_assoc($consultar_productos)) {
          ?>
            <div class="slider-item">
              <!-- Verificamos si tiene imagen -->
              <?php if (!empty($listar_productos['ci_imagen_producto'])): ?>
                <?php
                $img_data = base64_encode($listar_productos['ci_imagen_producto']);
                $img_type = $listar_productos['formato_imagen'];
                echo "<img src='data:$img_type;base64,$img_data' alt='Imagen del producto'>";
                ?>
              <?php else: ?>
                <p>Sin imagen disponible</p>
              <?php endif; ?>
              <!-- Título del producto -->
              <h5 class="mt-2"><?php echo $listar_productos['nombre']; ?></h5>
              <!-- Botón que lleva a la página del producto -->
              <button class="btn btn-primary mt-2" onclick="window.location.href='./producto.php?id=<?php echo $listar_productos['id']; ?>'">
                Ver más
              </button>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>

  <section id="info">
    <div>
      <article id="texto_presentacion" class="text-center mx-auto">
        <p id="eslogan">Visita nuestra tienda online para encontrar las mejores creaciones del mercado regional.</p>

        <!-- Contenedor para pantallas grandes -->
        <div class="row desktop-container justify-content-evenly">
          <div class="col-md-3 icon-box">
            <i class="bi bi-truck"></i>
            <p>Envíos Gratis</p>
            <p>En tus compras superiores a $100.000</p>
          </div>
          <div class="col-md-3 icon-box">
            <i class="bi bi-credit-card"></i>
            <p>Cuotas sin interés</p>
            <p>3 y 6 cuotas sin interés con tarjeta de crédito bancarizadas y hasta 4 cuotas sin interés con tarjeta de débito</p>
          </div>
          <a href="https://wa.me/1234567890" target="_blank" class="col-md-3 icon-box text-decoration-none" style="color:black">
            <i class="bi bi-whatsapp"></i>
            <p>Soporte por WhatsApp</p>
            <p>Hacé click acá y comunicate con nosotros</p>
          </a>
        </div>

        <!-- Carrusel para pantallas pequeñas -->
        <div id="iconCarousel" class="carousel slide carousel-container" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="text-center icon-box">
                <i class="bi bi-truck"></i>
                <p>Envíos Gratis</p>
                <p>En tus compras superiores a $100.000</p>
              </div>
            </div>
            <div class="carousel-item">
              <div class="text-center icon-box">
                <i class="bi bi-credit-card"></i>
                <p>Cuotas sin interés</p>
                <p>3 y 6 cuotas sin interés con tarjeta de crédito bancarizadas y hasta 4 cuotas sin interés con tarjeta de débito</p>
              </div>
            </div>
            <div class="carousel-item">
              <a href="https://wa.me/1234567890" target="_blank" class="text-decoration-none text-center icon-box d-block" style="color:black">
                <i class="bi bi-whatsapp"></i>
                <p>Soporte por WhatsApp</p>
                <p>Hacé click acá y comunicate con nosotros</p>
              </a>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#iconCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#iconCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
          </button>
        </div>
      </article>
    </div>
  </section>

  <footer class="footer" id="seccion_footer">
    <main class="container-fluid">
      <div class="row contenedor_footer">
        
        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-10 p-2 pb-5">
          
          <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> CONTÁCTANOS</h6>
          <div class="box_1">
            <p class="p-footer"><i class="bi bi-telephone-fill tel"></i> +54 9 0297 432-1429</p>
            <p class="p-footer"><i class="bi bi-whatsapp wsp"></i> +54 9 0297 432-1429</p>
            <p class="p-footer"><i class="bi bi-geo-alt-fill ubic"></i> Gral. Araóz de Lamadrid 425</p>

            <!-- Mini mapa responsive -->
            <div class="map-container">
              <a
                href="https://www.google.com/maps?q=-31.409736861796983,-64.16100064468557&z=17"
                target="_blank"
                title="Abrir ubicación en Google Maps">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3664.3467339192976!2d-64.16100064468557!3d-31.409736861796983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2z-31.409736861796983_-64.16100064468557!5e0!3m2!1sen!2sar!4v1696990000000"
                  style="border:0;"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade"></iframe>
              </a>
            </div>
          </div>
        </div>

        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-8 p-2">
          
          <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> MEDIOS DE PAGO</h6>
          <div class="contenedor-cards p-2">
            <img src="./images/cards/visa.png" alt="mp">
            <img src="./images/cards/naranja.png" alt="visa">
            <img src="./images/cards/mercadopago2.png" alt="visa">
            <img src="./images/cards/pagofacil.png" alt="visa">
            <img src="./images/cards/efectivo.png" alt="visa">
            <img src="./images/cards/rapipago.png" alt="">
          </div>

          <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> FORMAS DE ENVIO</h6>
          <div class="contenedor-cards p-2">
            <img src="./images/cards/andreani.png" alt="">
            <img src="./images/cards/correoarg.png" alt="">
          </div>

          <h6 class="h6-footer" style="text-wrap: wrap!important;"><i class="bi bi-tencent-qq pinguin"></i> SEGUINOS EN NUESTRAS REDES!</h6>
          <div class="redes-icons-footer">
            <a href="https://www.facebook.com/dai.quiroga.7" target="_"><i class="bi bi-facebook fb"></i></a>
            <a href="https://www.facebook.com/dai.quiroga.7"><i class="bi bi-instagram ig"></i></a>
            <a href="https://www.facebook.com/dai.quiroga.7"><i class="bi bi-pinterest prest"></i></a>
          </div>
        </div>
        
      </div>
    </main>

    <p style="font-size:10px;background-color:white; color:black;width:100%;padding:0 5px;"><i class="bi bi-c-circle"></i> COPYRIGHT KUDAY ARTESANIAS & DEVCR1 2021. TODOS LOS DERECHOS RESERVADOS.</p>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>
    // Seleccionar los elementos del slider
    const sliderTrack = document.querySelector('#promociones .slider-track');
    const sliderItems = Array.from(document.querySelectorAll('#promociones .slider-item'));
    const slider = document.querySelector('#promociones .slider');

    let sliderWidth = slider.offsetWidth; // Ancho del slider visible
    let itemWidth = sliderItems[0].offsetWidth; // Ancho de un elemento
    let totalItems = sliderTrack.children.length; // Total de elementos (incluidos clones)
    let currentPosition = 0; // Posición inicial
    let animationFrameId; // ID del requestAnimationFrame para control

    // Ajustar el ancho total de la pista dinámicamente
    sliderTrack.style.width = `${totalItems * itemWidth}px`;

    // Función para reorganizar los elementos dinámicamente
    function rearrangeItems() {
      if (Math.abs(currentPosition) >= itemWidth) {
        currentPosition += itemWidth; // Ajustar la posición para evitar saltos
        const firstItem = sliderTrack.firstElementChild;
        sliderTrack.appendChild(firstItem); // Mover el primer elemento al final
        sliderTrack.style.transform = `translateX(${currentPosition}px)`; // Ajustar la posición
      }
    }

    // Función para animar el slider
    function animateSlider() {
      currentPosition -= 2; // Control de velocidad
      sliderTrack.style.transform = `translateX(${currentPosition}px)`; // Mover la pista
      rearrangeItems(); // Reorganizar los elementos si es necesario
      animationFrameId = requestAnimationFrame(animateSlider); // Continuar la animación
    }

    // Función para reiniciar el slider en caso de redimensionamiento
    function resetSlider() {
      // Cancelamos la animación temporalmente
      cancelAnimationFrame(animationFrameId);

      // Recalcular dimensiones críticas
      sliderWidth = slider.offsetWidth;
      itemWidth = sliderItems[0].offsetWidth;
      totalItems = sliderTrack.children.length;

      // Ajustar el ancho total de la pista
      sliderTrack.style.width = `${totalItems * itemWidth}px`;

      // Reiniciar la posición
      currentPosition = 0;
      sliderTrack.style.transform = `translateX(${currentPosition}px)`;

      // Reiniciar la animación
      requestAnimationFrame(animateSlider);
    }

    // Iniciar la animación
    requestAnimationFrame(animateSlider);

    // Detectar cambios en el tamaño de la ventana
    window.addEventListener('resize', resetSlider);
  </script>

</body>

</html>