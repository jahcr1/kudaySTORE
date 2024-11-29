<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kuday Argentina Sitio Oficial</title>

  <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Aclonica&family=Bangers&family=Barrio&family=Chango&family=Chewy&family=Chicle&family=Delius+Unicase:wght@400;700&family=Flavors&family=Gwendolyn:wght@400;700&family=Ingrid+Darling&family=Just+Me+Again+Down+Here&family=Kablammo&family=Lumanosimo&family=Martian+Mono:wght@100..800&family=Mystery+Quest&family=Pacifico&family=Rubik+Puddles&family=Shrikhand&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap" rel="stylesheet">

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
      <div class="container-fluid">
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
              <a class="nav-link active boton-nav" aria-current="page" href="vistas/promociones.php">Promociones</a>
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
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link active boton-nav" href="#">Contactános</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

  </header>

  <section id="inicio">
    <div class="container text-center mx-auto">
      <div class="d-flex">
        <div class="col-5">
          <h1 class="mx-auto text-center p-5"><span id="logo_texto">Kuday<br>Creaciones Artesanales</span></h1>
          <p>Buscá lo que necesitás en nuestra tienda Online.</p>
          <p>Envios a todo el país.</p>
        </div>

        <div class="container col-6" id="presentacion">
          <img src="images/logo/logo.png" class="logo object-fit-cover " alt="logo">
        </div>

      </div>
      <article id="texto_presentacion" class="text-center mx-auto">
        <p id="eslogan">Visita nuestra tienda online para encontrar las mejores creaciones del mercado regional.</p>
      </article>
      <div class="w-100 text-center mx-auto" id="promo">
        <h2 class="fs-5 p-3"><span class="text-primary">KUDAY</span> es una tienda unica donde vas a encontrar las mejores <span class="text-primary text-center"> Promociones</span> todos los meses.</h2>
      </div>
    </div>
  </section>

  
  <section class="carrusel" style="margin-top: 100px;">
    <div class="container">
      <div id="carouselExampleSlidesOnly" class="carousel slide car pt-2 pb-3" data-bs-ride="carousel">
        <div class="carousel-inner carusel-index">
          <div class="carousel-item active" data-bs-interval="4000">
            <img src="images/carousel/carusel1.jpg" class="foto-carousel d-block w-100 img-fluid object-fit-cover" alt="slide1">
          </div>
          <div class="carousel-item" data-bs-interval="4000">
            <img src="https://picsum.photos/1200/600" class="foto-carousel d-block w-100 img-fluid object-fit-cover" alt="slide2">
          </div>
          <div class="carousel-item" data-bs-interval="4000">
            <img src="https://picsum.photos/1200/700" class="foto-carousel d-block w-100 img-fluid object-fit-cover" alt="slide3">
          </div>
        </div>
      </div>
      
    </div>
  </section>
  
  
  <section id="tienda-index">
    <h3 class="text-center titulo" style="margin-top: 150px;">Tienda Kuday</h3>
    <div class="container" style="margin-top: 50px; padding-bottom:150px;">

      <div class="mainbox-store row justify-content-evenly">
        
        <div class="col-md-5 fondo-store1 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente1"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor1">
            <img src="./images/tienda/cartuchera3.png" alt="Cartuchera" class="imagen1">
          </div>
          <a href="./vistas/cartucheras.php" target="_blank" class="text-center texto-store1">Cartucheras</a>
        </div>

        <div class="col-md-5 fondo-store2 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente2"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor2">
            <img src="./images/tienda/cartuchera3.png" alt="Neceser" class="imagen2">
          </div>
          <a href="./vistas/neceser.php" target="_blank" class="text-center texto-store2">Neceser</a>
        </div>

        <div class="col-md-5 fondo-store3 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente3"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor3">
            <img src="./images/tienda/cartuchera3.png" alt="Billeteras" class="imagen3">
          </div>
          <a href="./vistas/billeteras.php" target="_blank" class="text-center texto-store3">Billeteras</a>
        </div>

        <div class="col-md-5 fondo-store4 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente4"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor4">
            <img src="./images/tienda/cartuchera3.png" alt="Bandoleras" class="imagen4">
          </div>
          <a href="./vistas/bandoleras.php" target="_blank" class="text-center texto-store4">Bandoleras</a>
        </div>

        <div class="col-md-5 fondo-store5 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente5"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor5">
            <img src="./images/tienda/cartuchera3.png" alt="Bolsomatero" class="imagen5">
          </div>
          <a href="./vistas/bolsomatero.php" target="_blank" class="text-center texto-store5">Bolsos Materos</a>
        </div>

        <div class="col-md-5 fondo-store6 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente6"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor6">
            <img src="./images/tienda/setv31.png" alt="Set Matero" class="imagen6">
          </div>
          <a href="./vistas/setmatero.php" target="_blank" class="text-center texto-store6">Set Matero</a>
        </div>

        <div class="col-md-5 fondo-store7 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente7"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor7">
            <img src="./images/tienda/portad1.png" alt="Varios" class="imagen7">
          </div>
          <a href="./vistas/varios.php" target="_blank" class="text-center texto-store7">Varios</a>
        </div>
        
        <div class="col-md-5 fondo-store8 d-flex align-items-center justify-content-center g-2 gy-4">
          <div class="gradiente8"></div> <!-- Capa para el gradiente -->
          <div class="imagen-contenedor8">
            <img src="./images/tienda/cartuchera3.png" alt="Promociones" class="imagen8">
          </div>
          <a href="./vistas/promociones.php" target="_blank" class="text-center texto-store8">Promociones</a>
        </div>
      
      </div>

    </div>
  </section>

  
  <section id="promociones" class="slider-container">
    <h3 class="slider-title">Nuestras promociones</h3>
    
    <div class="slider-wrapper">
      <div class="slider">
        <div class="slider-track">
          <div class="slider-item"><img src="./images/promociones/promo2.png" alt="Imagen 2"></div>
          <div class="slider-item"><img src="./images/promociones/promo1.png" alt="Imagen 1"></div>
          <div class="slider-item"><img src="./images/promociones/promo2.png" alt="Imagen 2"></div>
          <div class="slider-item"><img src="./images/promociones/promo3.png" alt="Imagen 3"></div>
        </div>
      </div>
    </div>
  </section>


  <section>
    
  </section>

  <section id="info">
    <div class="container-fluid row">

    </div>
  </section>

  
  <footer class="cartuchera-footer">
      <main class="container-fluid">
            <div class="row contenedor_footer-cartuchera">  
                <div class="col-xl-3 col-md-3 col-sm-10 p-2">
                    <h6 class="h6-footer-cartuchera"><i class="bi bi-tencent-qq"></i>  CONTÁCTANOS</h6>
                    <p class="p-footer-cartuchera"><i class="bi bi-telephone-fill"></i>   +54 9 0297 432-1429</p>
                    <p class="p-footer-cartuchera"><i class="bi bi-whatsapp"></i>   +54 9 0297 432-1429</p>
                    <p class="p-footer-cartuchera"><i class="bi bi-geo-alt-fill"></i>   Gral. Araóz de Lamadrid 425</p>
                </div>
                <div class="col-xl-3 col-md-3 col-sm-6 p-2">
                    <h6 class="h6-footer-cartuchera"><i class="bi bi-tencent-qq"></i>  MEDIOS DE PAGO</h6>
                    <div class="contenedor-cards p-2">
                        <img src="./images/cards/visa.png"  alt="mp">
                        <img src="./images/cards/naranja.png" alt="visa">
                        <img src="./images/cards/mercadopago2.png" alt="visa">
                        <img src="./images/cards/pagofacil.png" alt="visa">
                        <img src="./images/cards/efectivo.png" alt="visa">
                        <img src="./images/cards/rapipago.png" alt="">
                    </div>
                </div>
                <div class="col-xl-3 col-md-3 col-sm-6 p-2">
                    <h6 class="h6-footer-cartuchera"><i class="bi bi-tencent-qq"></i>  FORMAS DE ENVIO</h6>
                    <div class="contenedor-cards p-2">
                        <img src="./images/cards/andreani.png" alt="">
                        <img src="./images/cards/correoarg.png" alt="">
                    </div>
                </div>
                <div class="row d-flex">
                    <h4>Seguinos en nuestras redes!</h4>
                    <div class="redes-icons-footer-cartuchera ">
                        <a href="https://www.facebook.com/dai.quiroga.7" target="_"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.facebook.com/dai.quiroga.7"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.facebook.com/dai.quiroga.7"><i class="bi bi-pinterest"></i></a>
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
        const sliderWidth = slider.offsetWidth;

        // Clonación de los elementos para que el movimiento sea infinito
        sliderItems.forEach(item => {
          const cloneStart = item.cloneNode(true);  // Clonamos para el inicio
          const cloneEnd = item.cloneNode(true);    // Clonamos para el final
          sliderTrack.appendChild(cloneEnd);        // Clonamos al final
          sliderTrack.insertBefore(cloneStart, sliderTrack.firstChild); // Clonamos al inicio
        });

        // Variables de control
        let currentPosition = -sliderWidth; // Comenzamos con el primer clon visible
        const totalItems = sliderTrack.children.length;

        // Ajustamos el ancho de la pista del slider dinámicamente
        sliderTrack.style.width = `${totalItems * sliderWidth}px`;

        // Posicionamos el slider en la posición inicial (detrás del primer clon)
        sliderTrack.style.transform = `translateX(${currentPosition}px)`;

        // Función para animar el slider utilizando requestAnimationFrame
        function animateSlider() {
          currentPosition -= 2; // Control de velocidad del deslizamiento (más grande = más rápido)

          // Cuando llegue al final de la pista, reiniciamos la posición sin interrupciones
          if (Math.abs(currentPosition) >= sliderWidth * (totalItems - sliderItems.length)) {
            currentPosition = -sliderWidth; // Reinicia el desplazamiento para dar continuidad
          }

          // Usamos requestAnimationFrame para asegurar que la animación sea suave
          sliderTrack.style.transform = `translateX(${currentPosition}px)`;

          // Llamar a la función para la siguiente animación
          requestAnimationFrame(animateSlider);
        }

        // Iniciar la animación con requestAnimationFrame
        requestAnimationFrame(animateSlider);

        // Reajustar el ancho del slider al cambiar el tamaño de la ventana
        window.addEventListener('resize', () => {
          const sliderWidth = slider.offsetWidth;  // Vuelve a calcular el ancho
          sliderTrack.style.width = `${totalItems * sliderWidth}px`; // Ajustamos el ancho de la pista
          currentPosition = -sliderWidth;  // Reseteamos la posición al nuevo ancho
        });

  </script>

</body>

</html>