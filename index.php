<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kuday Argentina</title>

  <!-- ICONOS DE BOOTSTRAP -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- CSS DE BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- CSS PROPIO-->
  <link rel="stylesheet" href="CSS/styles.css">

</head>

<body>

  <header>

    <nav class="navbar navbar-expand-lg barranav fixed-top border rounded">
      <div class="container-fluid">
        <a class="navbar-brand marca align-self-center text-center ms-auto" href="index.php#inicio">Kuday Artesanias</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 600px; margin-right:50px;">
            <li class="nav-item">
              <a class="nav-link active boton-nav" href="index.php#inicio">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active boton-nav" aria-current="page" href="#promociones">Promociones</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active boton-nav" href="tienda.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Productos
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="cartucheras.php">Cartucheras / Neceser</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="setmatero.php">Sets Materos</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item " href="billeteras.php">Billeteras</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="bolsomatero.php">Bolso Matero</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="bandoleras.php">Bandoleras</a></li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="varios.php">Varios</a></li>
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
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, nesciunt.</p>
          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sed at vero aliquam fuga, ut ex.</p>
        </div>

        <div class="container col-6" id="presentacion">
          <img src="images/logo/logo.png" class="logo object-fit-cover " alt="logo">
        </div>

      </div>
      <article id="texto_presentacion" class="text-center mx-auto">
        <p id="eslogan">Visita nuestra tienda online para encontrar las mejores creaciones del mercado regional.</p>
      </article>
      <div class="w-50 text-center mx-auto" id="promo">
        <h2 class="fs-5 p-3"><span class="text-primary">KUDAY</span> es una tienda unica donde encontrarás las mejores <span class="text-primary text-center"> Promociones</span> todos los meses.</h2>
      </div>
    </div>
  </section>

  <section id="tienda-index">

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


  <section id="promociones">
    <h3 class="text-center titulo" style="margin-top: 150px;">Nuestras promociones</h3>
    <div class="container text-center" style="margin-top: 50px;">
      <div class="grid-images row p-2">

        <div class="col-md-3 fondo-card-promociones justify-content-evenly">
          <img src="./images/promociones/promo1.png" style="padding: 10px" class="img-promo-promociones img-fluid">
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title text-start">Promo 1</h5>
              <p>30% OFF</p>
              <a href="#" class="btn btn-danger w-100">Ver</a>
            </div>
          </div>
        </div>
        <div class="col-md-3 fondo-card-promociones justify-content-evenly">
          <img src="./images/promociones/promo2.png" style="padding: 10px;" class="img-promo-promociones img-fluid">
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title text-start">Promo 2</h5>
              <p>30% OFF</p>
              <a href="#" class="btn btn-danger w-100">Ver</a>
            </div>
          </div>
        </div>
        <div class="col-md-3 fondo-card-promociones justify-content-evenly">
          <img src="./images/promociones/promo3.png" style="padding: 10px;" class=" img-promo-promociones img-fluid">
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title text-start">Promo 3</h5>
              <p>70% OFF</p>
              <a href="#" class="btn btn-danger w-100">Ver</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="info">
    <div class="container-fluid row">

    </div>
  </section>

  <footer>

    <?php include("foot.php"); ?>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>