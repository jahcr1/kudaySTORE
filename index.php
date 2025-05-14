<?php
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kuday Argentina Sitio Oficial</title>

  <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Delius+Unicase:wght@400;700&family=Fuzzy+Bubbles:wght@400;700&family=Gwendolyn:wght@400;700&family=Homemade+Apple&family=Just+Me+Again+Down+Here&family=Kablammo&family=Klee+One&family=Ms+Madi&family=Mystery+Quest&family=Pacifico&family=Playwrite+IT+Moderna:wght@100..400&family=Poiret+One&family=Teko:wght@300..700&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap&family=Dancing+Script:wght@400..700&display=swap?" rel="stylesheet">

  <!-- ICONOS DE BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- ICONOS DE FONTAWESOME -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">

  <!-- Swiper.js desde CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- AOS CSS desde CDN-->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">


  <!-- CSS DE BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- CSS PROPIO-->
  <link rel="stylesheet" href="./CSS/styles.css">

</head>

<body class="index-body">

  <header>
    <nav class="navbar navbar-expand-xl index-nav fixed-top">
      <div class="container-fluid" style="flex-wrap: wrap;">
        <a class="navbar-brand d-flex align-items-center brand-logo" href="index.php#inicio">
          <!-- Logo como imagen SVG -->
          <img src="images/logo/logo.png" alt="Kuday Artesanías" class="logo-img" />
          <span class="logo-text">Kuday Artesanias</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 700px; margin-right:50px;">
            <li class="nav-item">
              <a class="nav-link active boton-nav" href="index.php#inicio">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active boton-nav" aria-current="page" href="index.php#titulo_tienda">Tienda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active boton-nav" href="index.php#productos-relevantes">Promociones</a>
            </li>
            <li class="nav-item dropdown" style="align-items: flex-start;">
              <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Productos
              </a>
              <ul class="dropdown-menu mx-2">
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
              <a class="nav-link active boton-nav" aria-current="page" href="#seccion_footer">Quiénes Somos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active boton-nav" href="./contacto.php" target="_blank">Contactános</a>
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
    <div class="container text-center py-5">
      <div class="row align-items-center" id="box_inicio"> 
        <div class="col-lg-12 col-md-12" data-aos="zoom-in">
          <img src="images/logo/logo.png" class="img-fluid" alt="logo" style="max-height: 750px;">
        </div>
      </div>
    </div>

    <div class="container-fluid text-center py-4" id="minibanner" data-aos="zoom-in">
      <h2 class="fs-4 fw-light fst-italic">
        <span class="text-kuday fw-semibold">KUDAY</span> es una tienda única donde vas a encontrar los mejores
        <span class="text-kuday fw-semibold">accesorios</span> para verte mejor!
      </h2>
    </div>
  </section>


  <section class="carrusel">
    <div class="container-fluid">
      <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade pt-2 pb-3" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner carusel-index">
          <div class="carousel-item active">
            <img src="images/carousel/glaciar1.jpg" class="foto-carousel" alt="slide1">
            <div class="carousel-caption">
              <h5 class="caption-title">Se viene el INVIERNO</h5>
              <p class="caption-parr">Y en Kuday sabemos lo que necesitás!</p>
            </div>
            <div class="carousel-button">
              <a href="vistas/promociones.php" class="btn-invisible btn-lg">Ver Promos</a>
            </div>
          </div>

          <div class="carousel-item">
            <img src="images/carousel/glaciar2.jpg" class="foto-carousel" alt="slide2">
            <div class="carousel-caption">
              <h5 class="caption-title">Los mejores accesorios para tu look</h5>
              <p class="caption-parr">Mirá nuestras promociones de invierno</p>
            </div>
            <div class="carousel-button">
              <a href="vistas/promociones.php" class="btn-invisible btn-lg">Ver Promos</a>
            </div>
          </div>
          <div class="carousel-item">
            <img src="images/carousel/baner3.jpg" class="foto-carousel" alt="slide3">
            <div class="carousel-caption">
              <h5 class="caption-title">Encontrá también buenisimas artesanías para tu hogar</h5>
              <p class="caption-parr">Art decó, productos para higiene personal y más</p>
            </div>
            <div class="carousel-button">
              <a href="vistas/varios.php" class="btn-invisible">Okay!</a>
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
    <div class="container-fluid" style="margin-top: 50px; padding-bottom:150px;">

      <div class="mainbox-store row justify-content-evenly">

        <div class="col-lg-5 fondo-store1 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente1"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor1">
            <img src="./images/tienda/cartucheras7.png" alt="Cartuchera" class="imagen1">
          </div>
          <a href="./vistas/cartucheras.php" target="_blank" class="texto-store1">Cartucheras</a>
        </div>

        <div class="col-lg-5 fondo-store2 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente2"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor2">
            <img src="./images/tienda/neceser8.png" alt="Neceser" class="imagen2">
          </div>
          <a href="./vistas/neceser.php" target="_blank" class="texto-store2">Neceser</a>
        </div>

        <div class="col-lg-5 fondo-store3 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente3"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor3">
            <img src="./images/tienda/billet12.png" alt="Billeteras" class="imagen3">
          </div>
          <a href="./vistas/billeteras.php" target="_blank" class="texto-store3">Billeteras</a>
        </div>

        <div class="col-lg-5 fondo-store4 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente4"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor4">
            <img src="./images/tienda/bandolera6.png" alt="Bandoleras" class="imagen4">
          </div>
          <a href="./vistas/bandoleras.php" target="_blank" class="texto-store4">Bandoleras</a>
        </div>

        <div class="col-lg-5 fondo-store5 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente5"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor5">
            <img src="./images/tienda/bolsomatero1.png" alt="Bolsomatero" class="imagen5">
          </div>
          <a href="./vistas/bolsomatero.php" target="_blank" class="texto-store5">Bolsos Materos</a>
        </div>

        <div class="col-lg-5 fondo-store6 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente6"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor6">
            <img src="./images/tienda/setmatero1.png" alt="Set Matero" class="imagen6">
          </div>
          <a href="./vistas/setmatero.php" target="_blank" class="texto-store6">Set Matero</a>
        </div>

        <div class="col-lg-5 fondo-store7 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente7"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor7">
            <img src="./images/tienda/varios6.png" alt="Varios" class="imagen7">
          </div>
          <a href="./vistas/varios.php" target="_blank" class="texto-store7">Varios</a>
        </div>

        <div class="col-lg-5 fondo-store8 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente8"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor8">
            <img src="./images/tienda/promo114v1.png" alt="Promociones" class="imagen8">
          </div>
          <a href="./vistas/promociones.php" target="_blank" class="texto-store8">Promociones</a>
        </div>

      </div>

    </div>
  </section>


  <section id="productos-relevantes" class="slider-container">
    <h3 class="titulo-slider" id="titulo_productos">Nuestras Promociones </h3>
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <?php
        include('./componentes/conexion.php');
        $query = "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '8' LIMIT 10";
        $result = mysqli_query($conexion, $query);
        while ($producto = mysqli_fetch_assoc($result)) {
        ?>
          <div class="swiper-slide slider-item">
            <?php if (!empty($producto['ci_imagen_producto'])): ?>
              <?php
              $img_data = base64_encode($producto['ci_imagen_producto']);
              $img_type = $producto['formato_imagen'];
              echo "<img src='data:$img_type;base64,$img_data' alt='Imagen de {$producto['nombre']}' class='producto-img'>";
              ?>
            <?php else: ?>
              <p class="no-imagen">Sin imagen disponible</p>
            <?php endif; ?>
            <h5 class="producto-nombre"><?php echo $producto['nombre']; ?></h5>
            <button class="btn btn-primary" onclick="window.location.href='./producto.php?id=<?php echo $producto['id']; ?>'">
              Ver más
            </button>
          </div>
        <?php } ?>
      </div>
      <!-- Agrega navegación y paginación -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>
  </section>


  <section id="info">
    <div>
      <article id="texto_presentacion" class="text-center mx-auto text-general">
        <p id="eslogan" data-aos="fade-up" data-aos-duration="1000">
          Visita los distintos productos y accesorios en nuestra tienda online para encontrar lo que está de moda en el mercado regional
        </p>

        <!-- Contenedor para pantallas grandes -->
        <div class="row desktop-container justify-content-evenly">
          <div class="col-md-3 icon-box" data-aos="zoom-in" data-aos-delay="100">
            <i class="bi bi-truck"></i>
            <p class="fw-semibold">Envíos Gratis</p>
            <p>En tus compras superiores a $100.000</p>
          </div>
          <div class="col-md-3 icon-box" data-aos="zoom-in" data-aos-delay="200">
            <i class="bi bi-credit-card"></i>
            <p class="fw-semibold">Cuotas sin interés</p>
            <p>3 y 6 cuotas sin interés con tarjeta de crédito bancarizadas y hasta 4 cuotas sin interés con tarjeta de débito</p>
          </div>
          <a href="https://wa.me/<?php echo $_ENV['WSP_CEL']; ?>" target="_blank" class="col-md-3 icon-box text-decoration-none" style="color:black" data-aos="zoom-in" data-aos-delay="300">
            <i class="bi bi-whatsapp"></i>
            <p class="fw-semibold">Soporte por WhatsApp</p>
            <p class="fw-semibold">Hacé click acá y comunicate con nosotros</p>
          </a>
        </div>

        <!-- Carrusel para pantallas pequeñas -->
        <div id="iconCarousel" class="carousel slide carousel-container d-md-none" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="carusel-information">
                <div class="text-center icon-box">
                  <i class="bi bi-truck"></i>
                  <p class="fw-semibold">Envíos Gratis</p>
                  <p>En tus compras superiores a $100.000</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="carusel-information">
                <div class="text-center icon-box">
                  <i class="bi bi-credit-card"></i>
                  <p class="fw-semibold">Cuotas sin interés</p>
                  <p>3 y 6 cuotas sin interés con tarjeta de crédito bancarizadas y hasta 4 cuotas sin interés con tarjeta de débito</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="carusel-information">
                <a href="https://wa.me/<?php echo $_ENV['WSP_CEL']; ?>" target="_blank" class="text-decoration-none text-center icon-box" style="color:black">
                  <i class="bi bi-whatsapp"></i>
                  <p class="fw-semibold">Soporte por WhatsApp</p>
                  <p class="fw-normal">Hacé click acá y comunicate con nosotros</p>
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
      <div class="row contenedor_footer align-items-center">

        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-10 p-2 pb-5">

          <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> CONTÁCTANOS</h6>
          <div class="box_1">
            <p class="p-footer"><i class="bi bi-envelope-at correo"></i>kudayartesanias@gmail.com</p>
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
            <a href="https://www.facebook.com/dai.quiroga.7" target="_blank"><i class="bi bi-facebook fb"></i></a>
            <a href="https://www.facebook.com/dai.quiroga.7" target="_blank"><i class="bi bi-instagram ig"></i></a>
            
          </div>
        </div>

      </div>
    </main>

    <p style="font-size:10px;background-color:white; color:black;width:100%;padding:0 5px;"><i class="bi bi-c-circle"></i> 2021 Kuday Artesanias & jahcr1. Todos los derechos reservados.</p>

  </footer>


  <!-- Incluyendo BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>

  <!-- Agrega Swiper.js desde CDN -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- AOS JS -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>


  <!-- CONFIG MySwiper JS -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      new Swiper(".mySwiper", {
        loop: true, // Hace que el slider sea infinito
        slidesPerView: 3,
        spaceBetween: 10,
        autoplay: {
          delay: 3000, // Cambia cada 3 segundos
          disableOnInteraction: false, // Sigue moviéndose aunque el usuario interactúe
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        breakpoints: {
          250: {
            slidesPerView: 1, // Muestra 1 slide (ya está igual en 480px)
            spaceBetween: 5, // Espacio muy pequeño entre los slides
          },
          480: {
            slidesPerView: 1, // Muestra solo un slide
            spaceBetween: 10, // Menor espacio entre los slides
          },
          640: {
            slidesPerView: 2,
            spaceBetween: 20,
          },
          1024: {
            slidesPerView: 2,
            spaceBetween: 30,
          },
        },
      });

      // 🚀 Carrusel de Bootstrap - animación de título y párrafo
      const carousel = document.querySelector('#carouselExampleSlidesOnly');

      // Reiniciar animación al cargar la página (F5)
      const resetAnimation = () => {
        const activeItem = carousel.querySelector('.carousel-item.active');
        const title = activeItem.querySelector('h5.caption-title');
        const paragraph = activeItem.querySelector('p.caption-parr');

        title.style.opacity = '0';
        paragraph.style.opacity = '0';
        
        // Forzamos reflujo para que la animación no se quede en estado "animada"
        void title.offsetWidth;
        void paragraph.offsetWidth;

        // Aplica la animación inicial
        title.style.animation = 'fadeInUp 1.2s ease forwards';
        title.style.animationDelay = '1s';
        paragraph.style.animation = 'fadeInUp 1.2s ease forwards';
        paragraph.style.animationDelay = '1.5s';
      };

      // Ejecutar la reinicialización de animación cuando cargue la página
      resetAnimation();

      // Aplicar animación en cada transición de slide
      carousel.addEventListener('slid.bs.carousel', function () {
        const activeItem = carousel.querySelector('.carousel-item.active');
        const title = activeItem.querySelector('h5.caption-title');
        const paragraph = activeItem.querySelector('p.caption-parr');

        title.style.opacity = '0';
        paragraph.style.opacity = '0';

        // Forzamos reflujo
        void title.offsetWidth;
        void paragraph.offsetWidth;

        title.classList.add('fadeInUp');
        paragraph.classList.add('fadeInUp');

        title.style.animation = 'fadeInUp 1.2s ease forwards';
        title.style.animationDelay = '1s';

        paragraph.style.animation = 'fadeInUp 1.2s ease forwards';
        paragraph.style.animationDelay = '1.5s';
      });

    });
  </script>

  <!-- CONFIG AOS JS -->
  <script>
    AOS.init({
      duration: 1000,
      once: false,
    });
  </script>



</body>

</html>